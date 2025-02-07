<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'qty_student' => $this->qty_student,
            'start_period' => $this->start_period,
            'end_period' => $this->end_period,
            'spt' => $this->spt,
            'bupot' => $this->bupot,
            'faktur' => $this->faktur,
            'class_code' => $this->class_code,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}