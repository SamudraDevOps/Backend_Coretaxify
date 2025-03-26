<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Mail\NewUserMail;
use Illuminate\Support\Str;
use App\Support\Enums\IntentEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Support\Interfaces\Services\UserServiceInterface;
use App\Support\Interfaces\Repositories\UserRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class UserService extends BaseCrudService implements UserServiceInterface {
    protected function getRepositoryClass(): string {
        return UserRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        if (User::where('email', $data['email'])->exists()) {
            throw new \Exception('Email telah didaftarkan: ' . $data['email']);
        }

        $plain_password = $this->generatePassword();
        $data['default_password'] = $plain_password;
        $data['password'] = $plain_password;

        try {
            $user = parent::create($data);
            $user->email_verified_at = now();
            $user->save();
            $this->assignRoleByIntent($user, $data['intent'] ?? null);
            $this->sendEmail($user);
            return $user;
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                throw new \Exception('Email telah didaftarkan:' . $data['email']);
            }
            throw $e;
        }
    }

    public function assignRoleByIntent(Model $user, ?string $intent): void {
        if (!$user instanceof User) {
            return;
        }

        switch($intent) {
            case IntentEnum::API_USER_CREATE_ADMIN->value:
                $user->roles()->attach(Role::where('name', 'admin')->first());
                break;
            case IntentEnum::API_USER_CREATE_PSC->value:
                $user->roles()->attach(Role::where('name', 'psc')->first());
                break;
            case IntentEnum::API_USER_CREATE_INSTRUKTUR->value:
                $user->roles()->attach(Role::where('name', 'instruktur')->first());
                break;
            case IntentEnum::API_USER_CREATE_MAHASISWA_PSC->value:
                $user->roles()->attach(Role::where('name', 'mahasiswa-psc')->first());
                break;
            default:
                $user->roles()->attach(Role::where('name', 'dosen')->first());
                break;
        }
    }

    public function importData(array $data): void {

        $file = $data['import_file'];

        if ($file->getClientOriginalExtension() === 'xlsx') {
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
            $plain_password = $this->generatePassword();
            // dd($record);
            switch($data['intent']) {
                case IntentEnum::API_USER_IMPORT_DOSEN->value:
                    $user = User::create([
                        'contract_id' => $data['contract_id'],
                        'name' => $record[0],
                        'email' => $record[1],
                        'password' => $plain_password,
                        'default_password' => $plain_password
                    ]);
                    $user->roles()->attach(Role::where('name', 'dosen')->first());
                    break;
                case IntentEnum::API_USER_IMPORT_MAHASISWA_PSC->value:
                    $user = User::create([
                        'name' => $record[0],
                        'email' => $record[1],
                        'password' => $plain_password,
                        'default_password' => $plain_password
                    ]);
                    $user->roles()->attach(Role::where('name', 'mahasiswa-psc')->first());
                    if(isset($data['group_id'])) { $user->groups()->attach($data['group_id']); }
                    break;
                case IntentEnum::API_USER_IMPORT_INSTRUKTUR->value:
                    $user = User::create([
                        'name' => $record[0],
                        'email' => $record[1],
                        'password' => $plain_password,
                        'default_password' => $plain_password
                    ]);
                    $user->roles()->attach(Role::where('name', 'instruktur')->first());
                    break;
            }
            $this->sendEmail($user);
        }
    }
    private function sendEmail(Model $user){
        Mail::to($user->email)->send(new NewUserMail($user));
    }

    private function generatePassword(): string {
        return Str::random(8);
    }
}
