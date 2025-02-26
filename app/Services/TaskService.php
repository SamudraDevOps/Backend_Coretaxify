<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use League\Csv\Reader;
use App\Models\Account;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Support\Interfaces\Services\TaskServiceInterface;
use App\Support\Interfaces\Repositories\TaskRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class TaskService extends BaseCrudService implements TaskServiceInterface {

    protected function getRepositoryClass(): string {
        return TaskRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        $task = Task::create([
            'user_id' => auth()->user()->id,
            'name' => $data['name'],
        ]);
        $this->importData($data['import_file'], $task);
        return $task;
    }

    public function importData(UploadedFile $file, $keyOrModel): void {
        $task = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);

        $filename = time() . '.' . $file->getClientOriginalName();
        $file->storeAs('soal', $filename, 'public');

        $task->update([
            'file_path' => $filename,
        ]);

        if($file->getClientOriginalExtension() === 'csv') {
            $reader = Reader::createFromPath($file->getRealPath(), 'r');
            $reader->setHeaderOffset(0);
            $records = $reader->getRecords();
            // dd($records);
        } else if ($file->getClientOriginalExtension() === 'xlsx') {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($file->getRealPath());
            $records = $spreadsheet->getActiveSheet()->toArray();
            $records = array_slice($records, 1);
            $records = array_filter($records);
            // dd($records);
        } else if($file->getClientOriginalExtension() === 'xls') {
            $reader = new Xls();
            $spreadsheet = $reader->load($file->getRealPath());
            $records = $spreadsheet->getActiveSheet()->toArray();
            $records = array_slice($records, 1);
            $records = array_filter($records);
            // dd($records);
        } else {
            throw new \Exception('Invalid file type');
        }

        foreach ($records as $record) {
            $account = Account::create([
                'task_id' => $task->id,
                'account_type_id' => $record[0],
                'nama' => $record[1],
                'npwp' => $record[2],
                'kegiatan_utama' => $record[3],
                'jenis_wajib_pajak' => $record[4],
                'status_npwp' => $record[5],
                'tanggal_terdaftar' => $record[6],
                'tanggal_aktivasi' => $record[7],
                'status_pengusaha_kena_pejak' => $record[8],
                'tanggal_pengukuhan_pkp' => $record[9],
                'kantor_wilayah_direktorat_jenderal_pajak' => $record[10],
                'kantor_pelayanan_pajak' => $record[11],
                'seksi_pengawasan' => $record[12],
                'tanggal_pembaruan_profil_terakhir' => $record[13],
                'alamat_utama' => $record[14],
                'nomor_handphone' => $record[15],
                'email' => $record[16],
                'kode_klasifikasi_lapangan_usaha' => $record[17],
                'deskripsi_klasifikasi_lapangan_usaha' => $record[18],
            ]);
        }
    }

    public function update($keyOrModel, array $data): ?Model {
        $task = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);

        if (isset($data['import_file'])) {
            $task->accounts()->delete();

            Storage::disk('public')->delete('soal.' . $task->file_path);

            $this->importData($data['import_file'], $task);
        }

        return parent::update($task, $data);
    }

    public function getTasksByUserId($userId) {
        $repository = app($this->getRepositoryClass());
        return $repository->query()->whereHas('user', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->paginate();
    }

    public function getTasksByUserRole($user) {
        $repository = app($this->getRepositoryClass());
    
        // Get an array of role IDs for the currently logged-in user
        $userRoleIds = $user->roles->pluck('id')->toArray();
    
        return $repository->query()
            ->whereHas('user.roles', function ($query) use ($userRoleIds) {
                $query->whereIn('roles.id', $userRoleIds);
            })
            ->paginate();
    }
    public function downloadFile(Task $task) {
        $filename = $task->file_path;
        $path = storage_path('app/public/soal/' . $filename);
        return response()->download($path);
    }
}
