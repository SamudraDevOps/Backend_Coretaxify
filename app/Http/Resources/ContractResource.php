<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'university' => new UniversityResource($this->university),
            'contract_type' => $this->contract_type,
            'qty_student' => $this->qty_student,
            'start_period' => $this->start_period,
            'end_period' => $this->end_period,
            'spt' => $this->spt,
            'bupot' => $this->bupot,
            'faktur' => $this->faktur,
            'contract_code' => $this->contract_code,
            'status' => $this->status,
            'is_buy_task' => $this->is_buy_task,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
