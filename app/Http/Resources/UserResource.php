<?php

namespace App\Http\Resources;

use App\Http\Resources\RoleResource;
use App\Support\Enums\IntentEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    public function toArray($request): array {
        $intent = $request->get('intent');
        switch ($intent) {
            case IntentEnum::API_USER_CREATE_INSTRUKTUR->value:
                return[
                    'id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email,
                    'email_verified_at' => $this->email_verified_at,
                    'password' => $this->password,
                    'image_path' => $this->image_path,
                    'status' => $this->status,
                    'roles' => RoleResource::collection($this->roles),
                    'created_at' => $this->created_at->toDateTimeString(),
                    'updated_at' => $this->updated_at->toDateTimeString(),
                ];
            case IntentEnum::API_USER_GET_MAHASISWA_PSC->value:
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email,
                    'email_verified_at' => $this->email_verified_at,
                    'password' => $this->password,
                    'image_path' => $this->image_path,
                    'status' => $this->status,
                    'groups' => GroupResource::collection($this->groups),
                    'roles' => RoleResource::collection($this->roles),
                    'created_at' => $this->created_at->toDateTimeString(),
                    'updated_at' => $this->updated_at->toDateTimeString(),
                ];
            default:
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email,
                    'contract' => ContractResource::make($this->whenLoaded('contract')),
                    'instansi' => $this->contract ? $this->contract->university->name : null,
                    'email_verified_at' => $this->email_verified_at,
                    'password' => $this->password,
                    'contract_id' => $this->contract_id,
                    'image_path' => $this->image_path,
                    'status' => $this->status,
                    'unique_id' => $this->unique_id,
                    'roles' => RoleResource::collection($this->roles),
                    'created_at' => $this->created_at->toDateTimeString(),
                    'updated_at' => $this->updated_at->toDateTimeString(),
                ];
        }
    }
}
