<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'users' => UserResource::collection($this->users),
            'name' => $this->name,
            'qty_student' => $this->qty_student,
            'start_period' => $this->start_period,
            'end_period' => $this->end_period,
            'spt' => $this->spt,
            'bupot' => $this->bupot,
            'faktur' => $this->faktur,
            'purchase_code' => $this->purchase_code,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}