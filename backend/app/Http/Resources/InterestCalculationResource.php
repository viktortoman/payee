<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterestCalculationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'calculated_interest' => $this->calculated_interest,
            'principal_amount' => $this->principal_amount,
            'days_count' => $this->days_count,
            'interest_rate' => $this->interest_rate,
        ];
    }
}
