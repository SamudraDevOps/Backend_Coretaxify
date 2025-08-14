<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SptPphResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'cl_bp1_1' => $this->cl_bp1_1 ?? 0,
            'cl_bp1_2' => $this->cl_bp1_2 ?? 0,
            'cl_bp1_3' => $this->cl_bp1_3 ?? 0,
            'cl_bp1_4' => $this->cl_bp1_4 ?? 0,
            'cl_bp1_5' => $this->cl_bp1_5 ?? 0,
            'cl_bp1_6' => $this->cl_bp1_6 ?? 0,
            'cl_bp1_7' => $this->cl_bp1_7 ?? 0,
            'cl_bp1_8' => $this->cl_bp1_8 ?? 0,
            'cl_bp2_1' => $this->cl_bp2_1 ?? 0,
            'cl_bp2_2' => $this->cl_bp2_2 ?? 0,
            'cl_bp2_3' => $this->cl_bp2_3 ?? 0,
            'cl_bp2_4' => $this->cl_bp2_4 ?? 0,
            'cl_bp2_5' => $this->cl_bp2_5 ?? 0,
            'cl_bp2_6' => $this->cl_bp2_6 ?? 0,
            'cl_bp2_7' => $this->cl_bp2_7 ?? 0,
            'cl_bp2_8' => $this->cl_bp2_8 ?? 0,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
