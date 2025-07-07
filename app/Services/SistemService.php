<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Assignment;
use App\Models\ProfilSaya;
use App\Models\DataEkonomi;
use Illuminate\Http\Request;
use App\Models\InformasiUmum;
use App\Models\AssignmentUser;
use App\Support\Enums\IntentEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\NomorIdentifikasiEksternal;
use Symfony\Component\HttpFoundation\Response;
use App\Support\Interfaces\Services\SistemServiceInterface;
use App\Support\Interfaces\Repositories\SistemRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class SistemService extends BaseCrudService implements SistemServiceInterface
{
    protected function getRepositoryClass(): string
    {
        return SistemRepositoryInterface::class;
    }

    public function create(array $data): ?Model
    {
        $userId = auth()->id();
        return DB::transaction(function () use ($data, $userId) {
            $assignmentExists = AssignmentUser::where('user_id', $userId)
                ->where('assignment_id', $data['assignment'])
                ->exists();


            if (!$assignmentExists) {
                abort(Response::HTTP_FORBIDDEN, 'No assignment exists for the current user.');
            }

            AssignmentUser::where('user_id', $userId)
                ->update(['is_start' => true]);

            $dataAssign = $data['assignment'];
            $user = auth()->user();

            $assignUser_id = AssignmentUser::where('user_id', $user->id)
                ->where('assignment_id', $dataAssign)
                ->first()->assignment_id;

            $idAssignUser = AssignmentUser::where('user_id', $user->id)
                ->where('assignment_id', $dataAssign)
                ->first()->id;

            $task_id = Assignment::where('id', $assignUser_id)->first()->task_id;

            $dataAccount = Account::where('task_id', $task_id)
                ->select('nama', 'npwp', 'account_type_id', 'alamat_utama', 'email')
                ->get();

            foreach ($dataAccount as $account) {
                $sistem = parent::create([
                    'assignment_user_id' => $idAssignUser,
                    'profil_saya_id' => ProfilSaya::create([
                        'informasi_umum_id' => InformasiUmum::create([
                            'nama' => $account->nama,
                            'npwp' => $account->npwp,
                            'jenis_wajib_pajak' => $account->account_type->name,
                            'kategori_wajib_pajak' => $account->account_type->name,
                            'bahasa' => 'Bahasa Indonesia',
                        ])->id,
                        'data_ekonomi_id' => DataEkonomi::create()->id,
                        'nomor_identifikasi_eksternal_id' => NomorIdentifikasiEksternal::create([
                            'nomor_identifikasi' => $account->npwp,
                        ])->id,
                    ])->id,
                    'nama_akun' => $account->nama,
                    'npwp_akun' => $account->npwp,
                    'tipe_akun' => $account->account_type->name,
                    'alamat_utama_akun' => $account->alamat_utama,
                    'email_akun' => $account->email,
                ]);

                $kategoriWajibPajak = $sistem->tipe_akun;

                if ($kategoriWajibPajak === 'Badan' || $kategoriWajibPajak === 'Badan Lawan Transaksi') {
                    $kategoriWajibPajak = 'Perseroan Terbatas (PT)';
                } elseif ($kategoriWajibPajak === 'Orang Pribadi') {
                    $kategoriWajibPajak = 'Orang Pribadi';
                }
            }
            return $sistem;
        });
    }

    public function getSystemsByAssignment(Assignment $assignment, Request $request)
    {
        $intent = $request->get('intent');
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($intent === IntentEnum::API_GET_SISTEM_FIRST_ACCOUNT->value) {
            return $this->getFirstSystemByAssignment($assignment);
        }

        /** @var SistemRepositoryInterface $repository */
        $repository = $this->repository;
        return $repository->getByAssignmentUser($assignmentUser->id);
    }

    public function getFirstSystemByAssignment(Assignment $assignment)
    {
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        /** @var SistemRepositoryInterface $repository */
        $repository = $this->repository;
        return $repository->getFirstByAssignmentUser($assignmentUser->id);
    }

    public function getSystemDetail(Assignment $assignment, Model $sistem, Request $request, string $intent = null)
    {
        $intent = $intent ?? $request->get('intent');
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignmentUser->id) {
            abort(403);
        }

        /** @var SistemRepositoryInterface $repository */
        $repository = $this->repository;

        switch ($intent) {
            case IntentEnum::API_GET_SISTEM_INFORMASI_UMUM->value:
            case IntentEnum::API_GET_SISTEM_ALAMAT->value:
            case IntentEnum::API_GET_SISTEM_IKHTISAR_PROFIL->value:
                return $repository->getByAssignmentUserAndId($assignmentUser->id, $sistem->id);

            case IntentEnum::API_SISTEM_GET_AKUN_ORANG_PIBADI->value:
                return $repository->getOrangPribadiByAssignmentUser($assignmentUser->id);

            case IntentEnum::API_SISTEM_GET_PROFIL_SAYA->value:
                $sistem = $repository->getByAssignmentUserAndId($assignmentUser->id, $sistem->id);
                return $sistem->profil_saya;

            default:
                return $repository->getByAssignmentUserAndId($assignmentUser->id, $sistem->id);
        }
    }
}
