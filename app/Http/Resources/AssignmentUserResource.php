<?php

namespace App\Http\Resources;

use App\Support\Enums\IntentEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentUserResource extends JsonResource
{
    public function toArray($request): array
    {
        $intent = $request->get('intent');

        switch ($intent) {
            case IntentEnum::API_GET_ASSIGNMENT_MEMBERS_WITH_SISTEM_SCORES->value:
                $sistemScores = [];
                $totalScoresAcrossAllSistems = 0;

                foreach ($this->sistems as $sistem) {
                    $bupotScores = $sistem->bupot_scores;
                    $fakturScores = $sistem->faktur_scores;
                    $sptScores = $sistem->spt_scores;

                    $totalBupotScores = $bupotScores->sum('score');
                    $totalFakturScores = $fakturScores->sum('score');
                    $totalSptScores = $sptScores->sum('score');
                    $totalAllScores = $totalBupotScores + $totalFakturScores + $totalSptScores;

                    $totalBupotCount = $bupotScores->count();
                    $totalFakturCount = $fakturScores->count();
                    $totalSptCount = $sptScores->count();
                    $totalAllCount = $totalBupotCount + $totalFakturCount + $totalSptCount;

                    $totalScoresAcrossAllSistems += $totalAllScores;

                    $sistemScores[] = [
                        'sistem_id' => $sistem->id,
                        'sistem_info' => [
                            'id' => $sistem->id,

                            'created_at' => $sistem->created_at->toISOString(),
                            'updated_at' => $sistem->updated_at->toISOString(),
                        ],
                        'scores' => [
                            'bupot_scores' => $bupotScores->toArray(),
                            'faktur_scores' => $fakturScores->toArray(),
                            'spt_scores' => $sptScores->toArray(),
                        ],
                        'score_summary' => [
                            'total_bupot_scores' => $totalBupotScores,
                            'total_faktur_scores' => $totalFakturScores,
                            'total_spt_scores' => $totalSptScores,
                            'total_all_scores' => $totalAllScores,
                            'total_bupot_count' => $totalBupotCount,
                            'total_faktur_count' => $totalFakturCount,
                            'total_spt_count' => $totalSptCount,
                            'total_all_count' => $totalAllCount,
                        ]
                    ];
                }

                return [
                    'id' => $this->id,
                    'user' => new UserResource($this->user),
                    'assignment' => new AssignmentResource($this->assignment),
                    'sistem_scores' => $sistemScores,
                    'summary' => [
                        'total_sistems' => $this->sistems->count(),
                        'total_scores_across_all_sistems' => $totalScoresAcrossAllSistems
                    ]
                ];
            default:
                return [
                    'id' => $this->id,
                    // 'user_id' => $this->user_id,
                    'user' => new UserResource($this->user),
                    // 'assignment_id' => $this->assignment_id,
                    'assignment' => new AssignmentResource($this->assignment),
                    'is_start' => $this->is_start,
                    'score' => $this->score,
                    // 'created_at' => $this->created_at->toDateTimeString(),
                    // 'updated_at' => $this->updated_at->toDateTimeString(),
                ];
        }
    }
}
