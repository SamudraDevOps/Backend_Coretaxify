<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Account;
use App\Models\ExamUser;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Support\Interfaces\Services\ExamServiceInterface;
use App\Support\Interfaces\Repositories\ExamRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class ExamService extends BaseCrudService implements ExamServiceInterface {
    protected function getRepositoryClass(): string {
        return ExamRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        $filename = null;
        if(isset($data['supporting_file'])) {
            $filename = $this->supportFile($data['supporting_file']);
        }

        $data['user_id'] = auth()->id();
        $exam = Exam::create([
            'user_id' => $data['user_id'],
            'task_id' => $data['task_id'],
            'name' => $data['name'],
            'exam_code' => $data['exam_code'],
            'start_period' => $data['start_period'],
            'end_period' => $data['end_period'],
            'duration' => $data['duration'],
            'supporting_file' => $filename,
        ]);

        // if (!empty($data['import_file'])) {
        //     $this->importData($data['import_file']);
        // }

        // Attach logged in user to the newly created group
        // $exam->users()->attach(auth()->id());

        return $exam;
    }

    private function supportFile(UploadedFile $file) {
        $filename = time() . '.' . $file->getClientOriginalName();
        $file->storeAs('support-file', $filename, 'public');

        return $filename;
    }

    public function joinExam(array $data): ?Model {
        $exam = Exam::where('exam_code', $data['exam_code'])->first();
        $examId = $exam->id;

        $examUser = ExamUser::create([
            'user_id' => auth()->id(),
            'exam_id' => $examId,
        ]);

        return $examUser;
    }

    public function getExamsByUserId($userId, $perPage = 15) {
        $repository = app($this->getRepositoryClass());
        $user = auth()->user();

        if($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
            return $repository->query()->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->paginate($perPage);
        } else if ($user->hasRole('dosen') || $user->hasRole('psc') || $user->hasRole('instruktur') || $user->hasRole('admin')) {
            return $repository->query()->whereHas('user', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->paginate($perPage);
        }


        // return $repository->query()->whereHas('users', function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // })->paginate(5);
    }

    public function getExamsByUserRole($user, $perPage = 15) {
        $repository = app($this->getRepositoryClass());

        // Get an array of role IDs for the currently logged-in user
        $userRoleIds = $user->roles->pluck('id')->toArray();

        return $repository->query()
            ->whereHas('user.roles', function ($query) use ($userRoleIds) {
                $query->whereIn('roles.id', $userRoleIds);
            })
            ->paginate($perPage);
    }

    private function importData(UploadedFile $file): void {
        $filename = time() . '.' . $file->getClientOriginalName();
        $file->storeAs('soal-psc', $filename, 'public');

        $exam = Exam::latest()->first();
        $exam->update([
            'file_path' => $filename,
        ]);

        if ($file->getClientOriginalExtension() === 'xlsx') {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($file->getRealPath());
            $records = $spreadsheet->getActiveSheet()->toArray();
            $records = array_slice($records, 1);
            $records = array_filter($records);
        } else if($file->getClientOriginalExtension() === 'xls') {
            $reader = new Xls();
            $spreadsheet = $reader->load($file->getRealPath());
            $records = $spreadsheet->getActiveSheet()->toArray();
            $records = array_slice($records, 1);
            $records = array_filter($records);
        } else {
            throw new \Exception('Invalid file type');
        }

        foreach ($records as $record) {
            $account = Account::create([
                'exam_id' => $exam->id,
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

    public function downloadFile(Exam $exam) {
        $filename = $exam->filename;
        $path = storage_path('app/public/soal-psc/' . $filename);
        return response()->download($path);
    }

    public function downloadSupport(Exam $exam) {
        $filename = $exam->supporting_file;
        $path = storage_path('app/public/support-file/' . $filename);
        return response()->download($path);
    }
}
