<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use League\Csv\Reader;
use App\Models\Account;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Support\Interfaces\Services\TaskServiceInterface;
use App\Support\Interfaces\Repositories\TaskRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class TaskService extends BaseCrudService implements TaskServiceInterface
{

    protected function getRepositoryClass(): string
    {
        return TaskRepositoryInterface::class;
    }

    public function create(array $data): ?Model
    {
        // Validate file content before creating the task
        $records = $this->validateFileContent($data['import_file']);

        // Use database transaction to ensure all operations succeed or fail together
        return DB::transaction(function () use ($data, $records) {
            $task = Task::create([
                'user_id' => auth()->user()->id,
                'name' => $data['name'],
            ]);

            $this->saveFileAndCreateAccounts($data['import_file'], $task, $records);

            return $task;
        });
    }

    /**
     * Validate file content before processing
     *
     * @param UploadedFile $file
     * @return array
     * @throws \Exception
     */
    protected function validateFileContent(UploadedFile $file): array
    {
        $extension = $file->getClientOriginalExtension();
        $records = [];

        try {
            if ($extension === 'csv') {
                $reader = Reader::createFromPath($file->getRealPath(), 'r');
                $reader->setHeaderOffset(0);
                $records = iterator_to_array($reader->getRecords());

                // Validate CSV has required columns
                if (empty($records) || !$this->hasRequiredColumns($records[0])) {
                    throw new \Exception('File CSV tidak memiliki kolom yang diperlukan.');
                }
            } else if ($extension === 'xlsx') {
                $reader = new Xlsx();
                $spreadsheet = $reader->load($file->getRealPath());
                $records = $spreadsheet->getActiveSheet()->toArray();
                $headers = $records[0] ?? [];
                $records = array_slice($records, 1);

                // Validate Excel has required columns and data
                if (empty($records) || !$this->hasRequiredColumnsExcel($headers)) {
                    throw new \Exception('File Excel tidak memiliki kolom yang diperlukan.');
                }
            } else if ($extension === 'xls') {
                $reader = new Xls();
                $spreadsheet = $reader->load($file->getRealPath());
                $records = $spreadsheet->getActiveSheet()->toArray();
                $headers = $records[0] ?? [];
                $records = array_slice($records, 1);

                // Validate Excel has required columns and data
                if (empty($records) || !$this->hasRequiredColumnsExcel($headers)) {
                    throw new \Exception('File Excel tidak memiliki kolom yang diperlukan.');
                }
            } else {
                throw new \Exception('Tipe file tidak didukung.');
            }

            // Filter out empty rows
            $records = array_filter($records, function ($row) {
                return !empty(array_filter($row, function ($cell) {
                    return !empty($cell);
                }));
            });

            // Ensure we have data after filtering
            if (empty($records)) {
                throw new \Exception('File tidak memiliki data yang valid.');
            }

            return $records;
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            throw new \Exception('Format file tidak valid: ' . $e->getMessage());
        } catch (\League\Csv\Exception $e) {
            throw new \Exception('Format CSV tidak valid: ' . $e->getMessage());
        }
    }

    /**
     * Check if CSV record has all required columns
     *
     * @param array $record
     * @return bool
     */
    protected function hasRequiredColumns(array $record): bool
    {
        $requiredKeys = [
            'account_type_id',
            'nama',
            'npwp',
            'kegiatan_utama',
            'jenis_wajib_pajak',
            'status_npwp'
        ];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $record)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if Excel headers contain required columns
     *
     * @param array $headers
     * @return bool
     */
    protected function hasRequiredColumnsExcel(array $headers): bool
    {
        // For Excel files, we check the first row contains expected headers
        // Adjust this based on your actual Excel structure
        if (count($headers) < 6) {
            return false;
        }

        // Check that first few columns exist and aren't empty
        return !empty($headers[0]) && !empty($headers[1]) && !empty($headers[2]);
    }

    /**
     * Save file and create accounts
     *
     * @param UploadedFile $file
     * @param Task $task
     * @param array $records
     * @return void
     */
    protected function saveFileAndCreateAccounts(UploadedFile $file, Task $task, array $records): void
    {
        $filename = time() . '.' . $file->getClientOriginalName();
        $file->storeAs('soal', $filename, 'public');

        $task->update([
            'file_path' => $filename,
        ]);

        foreach ($records as $record) {
            // For CSV files, the keys are already column names
            if ($file->getClientOriginalExtension() === 'csv') {
                Account::create([
                    'task_id' => $task->id,
                    'account_type_id' => $record['account_type_id'],
                    'nama' => $record['nama'],
                    'npwp' => $record['npwp'],
                    'kegiatan_utama' => $record['kegiatan_utama'],
                    'jenis_wajib_pajak' => $record['jenis_wajib_pajak'],
                    'kategori_wajib_pajak' => $record['kategori_wajib_pajak'],
                    'status_npwp' => $record['status_npwp'],
                    'tanggal_terdaftar' => $record['tanggal_terdaftar'] ?? null,
                    'tanggal_aktivasi' => $record['tanggal_aktivasi'] ?? null,
                    'status_pengusaha_kena_pejak' => $record['status_pengusaha_kena_pejak'] ?? null,
                    'tanggal_pengukuhan_pkp' => $record['tanggal_pengukuhan_pkp'] ?? null,
                    'kantor_wilayah_direktorat_jenderal_pajak' => $record['kantor_wilayah_direktorat_jenderal_pajak'] ?? null,
                    'kantor_pelayanan_pajak' => $record['kantor_pelayanan_pajak'] ?? null,
                    'seksi_pengawasan' => $record['seksi_pengawasan'] ?? null,
                    'tanggal_pembaruan_profil_terakhir' => $record['tanggal_pembaruan_profil_terakhir'] ?? null,
                    'alamat_utama' => $record['alamat_utama'] ?? null,
                    'nomor_handphone' => $record['nomor_handphone'] ?? null,
                    'email' => $record['email'] ?? null,
                    'kode_klasifikasi_lapangan_usaha' => $record['kode_klasifikasi_lapangan_usaha'] ?? null,
                    'deskripsi_klasifikasi_lapangan_usaha' => $record['deskripsi_klasifikasi_lapangan_usaha'] ?? null,
                ]);
            } else {
                // For Excel files, we use numeric indices
                Account::create([
                    'task_id' => $task->id,
                    'account_type_id' => $record[0],
                    'nama' => $record[1],
                    'npwp' => $record[2],
                    'kegiatan_utama' => $record[3],
                    'jenis_wajib_pajak' => $record[4],
                    'kategori_wajib_pajak' => $record[5],
                    'status_npwp' => $record[6],
                    'tanggal_terdaftar' => $record[7] ?? null,
                    'tanggal_aktivasi' => $record[8] ?? null,
                    'status_pengusaha_kena_pejak' => $record[9] ?? null,
                    'tanggal_pengukuhan_pkp' => $record[10] ?? null,
                    'kantor_wilayah_direktorat_jenderal_pajak' => $record[11] ?? null,
                    'kantor_pelayanan_pajak' => $record[12] ?? null,
                    'seksi_pengawasan' => $record[13] ?? null,
                    'tanggal_pembaruan_profil_terakhir' => $record[14] ?? null,
                    'alamat_utama' => $record[15] ?? null,
                    'nomor_handphone' => $record[16] ?? null,
                    'email' => $record[17] ?? null,
                    'kode_klasifikasi_lapangan_usaha' => $record[18] ?? null,
                    'deskripsi_klasifikasi_lapangan_usaha' => $record[19] ?? null,
                ]);
            }
        }
    }

    public function importData(UploadedFile $file, $keyOrModel): void
    {
        $task = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);

        // Validate file content
        $records = $this->validateFileContent($file);

        // Use transaction to ensure all operations succeed or fail together
        DB::transaction(function () use ($file, $task, $records) {
            $task->accounts()->delete();

            if ($task->file_path) {
                Storage::disk('public')->delete('soal/' . $task->file_path);
            }

            $this->saveFileAndCreateAccounts($file, $task, $records);
        });
    }

    public function update($keyOrModel, array $data): ?Model
    {
        $task = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);

        if (isset($data['import_file'])) {
            // Validate file content before updating
            $records = $this->validateFileContent($data['import_file']);

            DB::transaction(function () use ($task, $data, $records) {
                $task->accounts()->delete();

                if ($task->file_path) {
                    Storage::disk('public')->delete('soal/' . $task->file_path);
                }

                $this->saveFileAndCreateAccounts($data['import_file'], $task, $records);
            });
        }

        return parent::update($task, $data);
    }

    public function getTasksByUserId($userId)
    {
        $repository = app($this->getRepositoryClass());
        return $repository->query()->whereHas('user', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->paginate();
    }

    public function getTasksByUserRole($user, $perPage = 20)
    {
        $repository = app($this->getRepositoryClass());

        // Get an array of role IDs for the currently logged-in user
        $userRoleIds = $user->roles->pluck('id')->toArray();

        if ($user->hasRole('instruktur')) {
            $userRoleIds = [4];
        }

        return $repository->query()
            ->whereHas('user.roles', function ($query) use ($userRoleIds) {
                $query->whereIn('roles.id', $userRoleIds);
            })
            ->where(function ($query) {
                $query->where('status', 'active')
                      ->orWhereNull('status');
            })
            ->paginate($perPage);
    }
    public function downloadFile(Task $task)
    {
        $filename = $task->file_path;
        $path = storage_path('app/public/soal/' . $filename);
        return response()->download($path);
    }

    public function delete($keyOrModel): bool
    {
        $task = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);

        $task->contracts()->detach();
        $task->accounts()->delete();

        parent::delete($task);

        return true;
    }
}
