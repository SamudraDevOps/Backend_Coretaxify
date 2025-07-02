<?php

namespace App\Services;

use App\Models\AssignmentUser;
use App\Models\SharedAssignmentUser;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Sistem;
use App\Models\ProfilSaya;
use App\Models\InformasiUmum;
use App\Models\DataEkonomi;
use App\Models\NomorIdentifikasiEksternal;
use Illuminate\Support\Facades\DB;

class AssignmentSharingService
{
    public function shareAssignmentUser(AssignmentUser $originalAssignmentUser, array $userIds, string $shareType): array
    {
        $sharedResults = [];

        DB::transaction(function () use ($originalAssignmentUser, $userIds, $shareType, &$sharedResults) {
            foreach ($userIds as $userId) {
                $result = $this->duplicateAssignmentUser($originalAssignmentUser, $userId, $shareType);
                $sharedResults[] = $result;
            }
        });

        return $sharedResults;
    }

    private function duplicateAssignmentUser(AssignmentUser $original, int $targetUserId, string $shareType): array
    {
        // Load the assignment relationship and get the actual Assignment model
        $originalAssignment = $original->assignment;

        // Create new assignment for the target user
        $newAssignment = $this->duplicateAssignment($originalAssignment, $targetUserId);

        // Create new assignment user
        $newAssignmentUser = new AssignmentUser([
            'user_id' => $targetUserId,
            'assignment_id' => $newAssignment->id,
            'score' => null,
            'is_start' => $original->is_start,
            'is_shared_copy' => true,
            'original_assignment_user_id' => $original->id,
            'shared_metadata' => [
                'shared_from_user' => auth()->id(),
                'shared_at' => now(),
                'share_type' => $shareType,
                'original_assignment_name' => $originalAssignment->name
            ]
        ]);
        $newAssignmentUser->save();

        // Duplicate all sistems and their related data
        $this->duplicateAllSistems($original, $newAssignmentUser);

        // Create sharing record
        $sharedRecord = SharedAssignmentUser::create([
            'original_assignment_user_id' => $original->id,
            'shared_assignment_user_id' => $newAssignmentUser->id,
            'shared_by_user_id' => auth()->id(),
            'shared_to_user_id' => $targetUserId,
            'share_type' => $shareType,
            'shared_at' => now(),
            'metadata' => [
                'original_assignment_name' => $originalAssignment->name,
                'sistems_count' => $original->sistems->count()
            ]
        ]);

        // Log activity
        $original->logActivity('assignment_shared', "Assignment shared to user ID: {$targetUserId}", [
            'share_type' => $shareType,
            'target_user_id' => $targetUserId
        ]);

        return [
            'assignment' => $newAssignment,
            'assignment_user' => $newAssignmentUser,
            'share_record' => $sharedRecord
        ];
    }

    private function duplicateAssignment(Assignment $original, int $targetUserId): Assignment
    {
        $newAssignment = new Assignment([
            'group_id' => null, // Shared assignments don't belong to groups
            'user_id' => $targetUserId,
            'task_id' => $original->task_id,
            'name' => $original->name . ' (Shared)',
            'assignment_code' => Assignment::generateTaskCode(),
            'start_period' => $original->start_period,
            'end_period' => $original->end_period,
            'supporting_file' => $original->supporting_file
        ]);
        $newAssignment->save();

        return $newAssignment;
    }

    private function duplicateAllSistems(AssignmentUser $original, AssignmentUser $new): void
    {
        foreach ($original->sistems as $sistem) {
            $this->duplicateSistem($sistem, $new);
        }
    }

    private function duplicateSistem(Sistem $originalSistem, AssignmentUser $newAssignmentUser): Sistem
    {
        // Duplicate profil_saya first if exists
        $newProfilSayaId = null;
        if ($originalSistem->profil_saya) {
            $newProfilSayaId = $this->duplicateProfilSaya($originalSistem->profil_saya);
        }

        // Create new sistem
        $newSistem = new Sistem([
            'assignment_user_id' => $newAssignmentUser->id,
            'profil_saya_id' => $newProfilSayaId,
            'nama_akun' => $originalSistem->nama_akun,
            'npwp_akun' => $originalSistem->npwp_akun,
            'tipe_akun' => $originalSistem->tipe_akun,
            'alamat_utama_akun' => $originalSistem->alamat_utama_akun,
            'email_akun' => $originalSistem->email_akun,
            'saldo' => $originalSistem->saldo
        ]);
        $newSistem->save();

        // Duplicate all related data
        $this->duplicateAllSistemRelatedData($originalSistem, $newSistem);

        return $newSistem;
    }

    private function duplicateProfilSaya($originalProfilSaya): int
    {
        // Duplicate informasi_umum
        $newInformasiUmumId = null;
        if ($originalProfilSaya->informasi_umum) {
            $newInformasiUmum = $originalProfilSaya->informasi_umum->replicate();
            $newInformasiUmum->save();
            $newInformasiUmumId = $newInformasiUmum->id;
        }

        // Duplicate data_ekonomi
        $newDataEkonomiId = null;
        if ($originalProfilSaya->data_ekonomi) {
            $newDataEkonomi = $originalProfilSaya->data_ekonomi->replicate();
            $newDataEkonomi->save();
            $newDataEkonomiId = $newDataEkonomi->id;
        }

        // Duplicate nomor_identifikasi_eksternal
        $newNomorIdentifikasiEksternalId = null;
        if ($originalProfilSaya->nomor_identifikasi_eksternal) {
            $newNomorIdentifikasiEksternal = $originalProfilSaya->nomor_identifikasi_eksternal->replicate();
            $newNomorIdentifikasiEksternal->save();
            $newNomorIdentifikasiEksternalId = $newNomorIdentifikasiEksternal->id;
        }

        // Create new profil_saya
        $newProfilSaya = new ProfilSaya([
            'informasi_umum_id' => $newInformasiUmumId,
            'data_ekonomi_id' => $newDataEkonomiId,
            'detail_bank_id' => $originalProfilSaya->detail_bank_id, // Will be handled separately
            'nomor_identifikasi_eksternal_id' => $newNomorIdentifikasiEksternalId,
            'pihak_terkait_id' => $originalProfilSaya->pihak_terkait_id, // Will be handled separately
            'tempat_kegiatan_usaha_id' => $originalProfilSaya->tempat_kegiatan_usaha_id, // Will be handled separately
            'detail_kontak_id' => $originalProfilSaya->detail_kontak_id, // Will be handled separately
        ]);
        $newProfilSaya->save();

        return $newProfilSaya->id;
    }

    private function duplicateAllSistemRelatedData(Sistem $original, Sistem $new): void
    {
        // Duplicate detail_kontaks
        foreach ($original->detail_kontaks as $item) {
            $newItem = $item->replicate();
            $newItem->sistem_id = $new->id;
            $newItem->save();
        }

        // Duplicate tempat_kegiatan_usahas
        foreach ($original->tempat_kegiatan_usahas as $item) {
            $newItem = $item->replicate();
            $newItem->sistem_id = $new->id;
            $newItem->save();
        }

        // Duplicate detail_banks
        foreach ($original->detail_banks as $item) {
            $newItem = $item->replicate();
            $newItem->sistem_id = $new->id;
            $newItem->save();
        }

        // Duplicate unit_pajak_keluargas
        foreach ($original->unit_pajak_keluargas as $item) {
            $newItem = $item->replicate();
            $newItem->sistem_id = $new->id;
            $newItem->save();
        }

        // Duplicate pihak_terkaits
        foreach ($original->pihak_terkaits as $item) {
            $newItem = $item->replicate();
            $newItem->sistem_id = $new->id;
            // Handle foreign key references
            if ($item->akun_op == $original->id) {
                $newItem->akun_op = $new->id;
            }
            $newItem->save();
        }

        // Duplicate sistem_tambahans
        foreach ($original->sistem_tambahans as $item) {
            $newItem = $item->replicate();
            $newItem->sistem_id = $new->id;
            $newItem->save();
        }

        // Duplicate SPTs and related data
        foreach ($original->spts as $spt) {
            $newSpt = $spt->replicate();
            $newSpt->badan_id = $new->id;
            if ($spt->pic_id == $original->id) {
                $newSpt->pic_id = $new->id;
            }
            $newSpt->save();

            // Duplicate spt_ppns if exists
            if ($spt->spt_ppn) {
                $newSptPpn = $spt->spt_ppn->replicate();
                $newSptPpn->spt_id = $newSpt->id;
                $newSptPpn->save();
            }

            // Duplicate spt_pphs if exists
            if ($spt->spt_pph) {
                $newSptPph = $spt->spt_pph->replicate();
                $newSptPph->spt_id = $newSpt->id;
                $newSptPph->save();
            }
        }

        // Duplicate fakturs and their detail_transaksis
        foreach ($original->fakturs as $faktur) {
            $newFaktur = $faktur->replicate();
            $newFaktur->badan_id = $new->id;
            if ($faktur->pic_id == $original->id)
                $newFaktur->pic_id = $new->id;
            if ($faktur->akun_pengirim_id == $original->id)
                $newFaktur->akun_pengirim_id = $new->id;
            if ($faktur->akun_penerima_id == $original->id)
                $newFaktur->akun_penerima_id = $new->id;
            $newFaktur->save();

            // Duplicate detail_transaksis for this faktur
            foreach ($faktur->detail_transaksis as $detail) {
                $newDetail = $detail->replicate();
                $newDetail->faktur_id = $newFaktur->id;
                $newDetail->save();
            }
        }

        // Duplicate bupots and related data
        foreach ($original->bupots as $bupot) {
            $newBupot = $bupot->replicate();
            $newBupot->pembuat_id = $new->id;
            if ($bupot->representatif_id == $original->id) {
                $newBupot->representatif_id = $new->id;
            }
            $newBupot->save();

            // Duplicate bupot_dokumens if exists
            if (method_exists($bupot, 'bupot_dokumens')) {
                foreach ($bupot->bupot_dokumens as $dokumen) {
                    $newDokumen = $dokumen->replicate();
                    $newDokumen->bupot_id = $newBupot->id;
                    $newDokumen->save();
                }
            }
        }

        // Duplicate pembayarans
        foreach ($original->pembayarans as $pembayaran) {
            $newPembayaran = $pembayaran->replicate();
            $newPembayaran->badan_id = $new->id;
            if ($pembayaran->pic_id == $original->id) {
                $newPembayaran->pic_id = $new->id;
            }
            $newPembayaran->save();
        }

        // Duplicate pics
        foreach ($original->akun_badans as $pic) {
            $newPic = $pic->replicate();
            $newPic->akun_badan_id = $new->id;
            if ($pic->akun_op_id == $original->id) {
                $newPic->akun_op_id = $new->id;
            }
            $newPic->save();
        }
    }

    public function getSharedAssignments(User $user, string $shareType = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = SharedAssignmentUser::where('shared_to_user_id', $user->id)
            ->with([
                'originalAssignmentUser.user',
                'originalAssignmentUser.assignment',
                'sharedAssignmentUser.assignment',
                'sharedBy'
            ]);

        if ($shareType) {
            $query->where('share_type', $shareType);
        }

        return $query->orderBy('shared_at', 'desc')->get();
    }
}
