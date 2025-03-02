<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Account;
use App\Models\GroupUser;
use App\Support\Enums\IntentEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Support\Interfaces\Services\GroupServiceInterface;
use App\Support\Interfaces\Repositories\GroupRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class GroupService extends BaseCrudService implements GroupServiceInterface {
    protected function getRepositoryClass(): string {
        return GroupRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        $data['user_id'] = auth()->id();
        // $data['class_code'] = Group::generateClassCode();
        $group = Group::create([
            'name' => $data['name'],
            'user_id' => $data['user_id'],
            'start_period' => $data['start_period'],
            'end_period' => $data['end_period'],
            'class_code' => $data['class_code'],
            'status' => $data['status'],
        ]);

        // if (!empty($data['import_file'])) {
        //     $this->importData($data['import_file']);
        // }

        // Attach logged in user to the newly created group
        // $group->users()->attach(auth()->id());

        return $group;
    }

    public function joinGroup(array $data): ?Model {
        $group = Group::where('class_code', $data['class_code'])->first();
        $groupId = $group->id;

        $groupUser = GroupUser::create([
            'user_id' => auth()->id(),
            'group_id' => $groupId,
        ]);

        return $groupUser;
    }

    public function getGroupsByUserId($userId) {
        $repository = app($this->getRepositoryClass());
        $user = auth()->user();

        if($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
            return $repository->query()->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->paginate();
        } else if ($user->hasRole('dosen') || $user->hasRole('psc')) {
            return $repository->query()->whereHas('user', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->paginate();
        }

        // return $repository->query()->whereHas('users', function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // })->paginate(1);
    }

    public function getGroupsByUserRole($user) {
        $repository = app($this->getRepositoryClass());

        // Get an array of role IDs for the currently logged-in user
        $userRoleIds = $user->roles->pluck('id')->toArray();

        return $repository->query()
            ->whereHas('user.roles', function ($query) use ($userRoleIds) {
                $query->whereIn('roles.id', $userRoleIds);
            })
            ->paginate();
    }

    // private function importData(UploadedFile $file): void {
    //     $filename = time() . '.' . $file->getClientOriginalName();
    //     $file->storeAs('soal-psc', $filename, 'public');

    //     $group = Group::latest()->first();
    //     $group->update([
    //         'file_path' => $filename,
    //     ]);

    //     if ($file->getClientOriginalExtension() === 'xlsx') {
    //         $reader = new Xlsx();
    //         $spreadsheet = $reader->load($file->getRealPath());
    //         $records = $spreadsheet->getActiveSheet()->toArray();
    //         $records = array_slice($records, 1);
    //         $records = array_filter($records);
    //     } else if($file->getClientOriginalExtension() === 'xls') {
    //         $reader = new Xls();
    //         $spreadsheet = $reader->load($file->getRealPath());
    //         $records = $spreadsheet->getActiveSheet()->toArray();
    //         $records = array_slice($records, 1);
    //         $records = array_filter($records);
    //     } else {
    //         throw new \Exception('Invalid file type');
    //     }

    //     foreach ($records as $record) {
    //         $account = Account::create([
    //             'group_id' => $group->id,
    //             'account_type_id' => $record[0],
    //             'nama' => $record[1],
    //             'npwp' => $record[2],
    //             'kegiatan_utama' => $record[3],
    //             'jenis_wajib_pajak' => $record[4],
    //             'status_npwp' => $record[5],
    //             'tanggal_terdaftar' => $record[6],
    //             'tanggal_aktivasi' => $record[7],
    //             'status_pengusaha_kena_pejak' => $record[8],
    //             'tanggal_pengukuhan_pkp' => $record[9],
    //             'kantor_wilayah_direktorat_jenderal_pajak' => $record[10],
    //             'kantor_pelayanan_pajak' => $record[11],
    //             'seksi_pengawasan' => $record[12],
    //             'tanggal_pembaruan_profil_terakhir' => $record[13],
    //             'alamat_utama' => $record[14],
    //             'nomor_handphone' => $record[15],
    //             'email' => $record[16],
    //             'kode_klasifikasi_lapangan_usaha' => $record[17],
    //             'deskripsi_klasifikasi_lapangan_usaha' => $record[18],
    //         ]);
    //     }
    // }

    // public function downloadFile(Group $group) {
    //     $filename = $group->file_path;
    //     $path = storage_path('app/public/soal-psc/' . $filename);
    //     return response()->download($path);
    // }
}
