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
        $plain_password = $this->generatePassword();
        $data['default_password'] = $plain_password;
        $data['password'] = $plain_password;

        $user = parent::create($data);
        $this->assignRoleByIntent($user, $data['intent'] ?? null);
        $this->sendEmail($user);
        return $user;
    }

    public function assignRoleByIntent(Model $user, ?string $intent): void {
        if (!$user instanceof User) {
            return;
        }

        switch($intent) {
            case IntentEnum::API_USER_CREATE_ADMIN->value:
                $user->roles()->attach(Role::where('name', 'admin')->first());
                break;
            case IntentEnum::API_USER_CREATE_INSTRUCTOR->value:
                $user->roles()->attach(Role::where('name', 'instruktur')->first());
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
            $dosen = User::create([
                'contract_id' => $data['contract_id'],
                'name' => $record[0],
                'email' => $record[1],
                'password' => $plain_password,
                'default_password' => $plain_password
            ]);
            $dosen->roles()->attach(Role::where('name', 'dosen')->first());
            $this->sendEmail($dosen);
        }
    }
    private function sendEmail(Model $user){
        Mail::to($user->email)->send(new NewUserMail($user));
    }

    private function generatePassword(): string {
        return Str::random(8);
    }
}
