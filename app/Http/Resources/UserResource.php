<?php

namespace App\Http\Resources;

use App\Http\Resources\RoleResource;
use App\Support\Enums\IntentEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    public function toArray($request): array {
        $intent = $request->get('intent');
        switch ($intent) {
            case IntentEnum::API_USER_CREATE_INSTRUCTOR->value:
                return[
                    'id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email,
                    'email_verified_at' => $this->email_verified_at,
                    'password' => $this->password,
                    'image_path' => $this->image_path,
                    'roles' => RoleResource::collection($this->roles),
                    'created_at' => $this->created_at->toDateTimeString(),
                    'updated_at' => $this->updated_at->toDateTimeString(),
                ];
            default:
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email,
                    'email_verified_at' => $this->email_verified_at,
                    'password' => $this->password,
                    'contract_id' => $this->contract_id,
                    'contract' => ContractResource::make($this->whenLoaded('contract')),
                    'image_path' => $this->image_path,
                    'unique_id' => $this->unique_id,
                    'roles' => RoleResource::collection($this->roles),
                    'created_at' => $this->created_at->toDateTimeString(),
                    'updated_at' => $this->updated_at->toDateTimeString(),
                ];
        }
    }
}
