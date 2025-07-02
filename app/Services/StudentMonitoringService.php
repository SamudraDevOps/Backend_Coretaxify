<?php

namespace App\Services;

use App\Models\User;
use App\Models\AssignmentUser;
use App\Models\Sistem;
use Illuminate\Database\Eloquent\Collection;

class StudentMonitoringService
{
    public function getStudentsForMonitoring(User $supervisor): Collection
    {
        if ($supervisor->hasRole('dosen')) {
            return $this->getMahasiswaForDosen($supervisor);
        } elseif ($supervisor->hasRole('psc')) {
            return $this->getMahasiswaPscForPsc($supervisor);
        }

        return collect();
    }

    private function getMahasiswaForDosen(User $dosen): Collection
    {
        // Get all mahasiswa from groups created by this dosen
        return AssignmentUser::whereHas('assignment.group', function ($query) use ($dosen) {
            $query->where('user_id', $dosen->id);
        })
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'mahasiswa');
            })
            ->with([
                'user',
                'assignment.group',
                'assignment.task',
                'sistems',
                'activities' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(5);
                }
            ])
            ->get();
    }

    private function getMahasiswaPscForPsc(User $psc): Collection
    {
        // Get all mahasiswa-psc from groups created by this PSC
        return AssignmentUser::whereHas('assignment.group', function ($query) use ($psc) {
            $query->where('user_id', $psc->id);
        })
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'mahasiswa-psc');
            })
            ->with([
                'user',
                'assignment.group',
                'assignment.task',
                'sistems',
                'activities' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(5);
                }
            ])
            ->get();
    }

    public function getStudentSimulationDetail(AssignmentUser $assignmentUser, User $supervisor): array
    {
        // Verify supervisor can monitor this student
        if (!$this->canMonitorStudent($assignmentUser, $supervisor)) {
            throw new \Exception('Unauthorized to monitor this student');
        }

        // Load all simulation data for read-only viewing
        $assignmentUser->load([
            'user',
            'assignment.task',
            'assignment.group',
            'sistems' => function ($query) {
                $query->with([
                    'profil_saya.informasi_umum',
                    'profil_saya.data_ekonomi',
                    'profil_saya.nomor_identifikasi_eksternal',
                    'detail_kontaks',
                    'tempat_kegiatan_usahas',
                    'detail_banks',
                    'unit_pajak_keluargas',
                    'pihak_terkaits',
                    'sistem_tambahans',
                    'spts.spt_ppn',
                    'spts.spt_pph',
                    'fakturs.detail_transaksis',
                    'bupots.bupot_dokumens',
                    'pembayarans'
                ]);
            },
            'activities' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(20);
            }
        ]);

        return [
            'assignment_user' => $assignmentUser,
            'simulation_summary' => $this->getSimulationSummary($assignmentUser),
            'is_monitoring_mode' => true,
            'supervisor' => $supervisor->only(['id', 'name', 'email'])
        ];
    }

    public function getSistemForMonitoring(Sistem $sistem, User $supervisor): array
    {
        // Verify supervisor can monitor this sistem
        $assignmentUser = $sistem->assignment_user;
        if (!$this->canMonitorStudent($assignmentUser, $supervisor)) {
            throw new \Exception('Unauthorized to monitor this sistem');
        }

        // Load all sistem data for read-only viewing
        $sistem->load([
            'profil_saya.informasi_umum',
            'profil_saya.data_ekonomi',
            'profil_saya.nomor_identifikasi_eksternal',
            'detail_kontaks',
            'tempat_kegiatan_usahas',
            'detail_banks',
            'unit_pajak_keluargas',
            'pihak_terkaits',
            'sistem_tambahans',
            'spts.spt_ppn',
            'spts.spt_pph',
            'fakturs.detail_transaksis',
            'bupots.bupot_dokumens',
            'pembayarans',
            'assignment_user.user'
        ]);

        return [
            'sistem' => $sistem,
            'is_monitoring_mode' => true,
            'supervisor' => $supervisor->only(['id', 'name', 'email']),
            'student' => $sistem->assignment_user->user->only(['id', 'name', 'email'])
        ];
    }

    private function canMonitorStudent(AssignmentUser $assignmentUser, User $supervisor): bool
    {
        if ($supervisor->hasRole('dosen')) {
            // Dosen can monitor mahasiswa in their groups
            return $assignmentUser->assignment->group &&
                $assignmentUser->assignment->group->user_id === $supervisor->id &&
                $assignmentUser->user->hasRole('mahasiswa');
        }

        if ($supervisor->hasRole('psc')) {
            // PSC can monitor mahasiswa-psc in their groups
            return $assignmentUser->assignment->group &&
                $assignmentUser->assignment->group->user_id === $supervisor->id &&
                $assignmentUser->user->hasRole('mahasiswa-psc');
        }

        return false;
    }

    private function getSimulationSummary(AssignmentUser $assignmentUser): array
    {
        $summary = [
            'total_sistems' => $assignmentUser->sistems->count(),
            'sistems_with_data' => 0,
            'total_fakturs' => 0,
            'total_bupots' => 0,
            'total_spts' => 0,
            'total_pembayarans' => 0,
            'last_activity' => $assignmentUser->activities->first()?->created_at,
            'is_started' => $assignmentUser->is_start
        ];

        foreach ($assignmentUser->sistems as $sistem) {
            if (
                $sistem->detail_kontaks->count() > 0 ||
                $sistem->detail_banks->count() > 0 ||
                $sistem->pihak_terkaits->count() > 0
            ) {
                $summary['sistems_with_data']++;
            }

            $summary['total_fakturs'] += $sistem->fakturs->count();
            $summary['total_bupots'] += $sistem->bupots->count();
            $summary['total_spts'] += $sistem->spts->count();
            $summary['total_pembayarans'] += $sistem->pembayarans->count();
        }

        return $summary;
    }

    public function getGroupOverview(User $supervisor): array
    {
        $overview = [];

        $groups = $supervisor->group()->with([
            'assignments.assignmentUsers' => function ($query) use ($supervisor) {
                if ($supervisor->hasRole('dosen')) {
                    $query->whereHas('user.roles', function ($q) {
                        $q->where('name', 'mahasiswa');
                    });
                } elseif ($supervisor->hasRole('psc')) {
                    $query->whereHas('user.roles', function ($q) {
                        $q->where('name', 'mahasiswa-psc');
                    });
                }
            },
            'assignments.assignmentUsers.user',
            'assignments.assignmentUsers.sistems',
            'assignments.assignmentUsers.activities'
        ])->get();

        foreach ($groups as $group) {
            $groupStats = [
                'total_students' => 0,
                'active_students' => 0,
                'total_sistems' => 0,
                'students_with_progress' => 0
            ];

            $students = [];

            foreach ($group->assignments as $assignment) {
                foreach ($assignment->assignmentUsers as $assignmentUser) {
                    $groupStats['total_students']++;

                    if ($assignmentUser->is_start) {
                        $groupStats['active_students']++;
                    }

                    $sistemsCount = $assignmentUser->sistems->count();
                    $groupStats['total_sistems'] += $sistemsCount;

                    if ($sistemsCount > 0) {
                        $groupStats['students_with_progress']++;
                    }

                    $students[] = [
                        'user' => $assignmentUser->user,
                        'assignment' => $assignment,
                        'sistems_count' => $sistemsCount,
                        'is_started' => $assignmentUser->is_start,
                        'last_activity' => $assignmentUser->activities->first()?->created_at
                    ];
                }
            }

            $overview[] = [
                'group' => $group,
                'stats' => $groupStats,
                'students' => $students
            ];
        }

        return $overview;
    }
}
