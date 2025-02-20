<?php

namespace App\Services\API;

use App\Models\InterestCalculation;
use App\Models\InterestRate;
use Illuminate\Support\Carbon;

class InterestService
{
    /**
     * Calculate interest based on the given data.
     * @throws \Exception
     */
    public function calculate(array $data)
    {
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $amount = $data['amount'];

        $start = Carbon::createFromFormat('Y-m-d', $startDate);
        $end = Carbon::createFromFormat('Y-m-d', $endDate);
        $days = (int) $start->diffInDays($end->addDay());

        $initialRate = InterestRate::query()
            ->where('effective_date', '<=', $start)
            ->orderBy('effective_date', 'desc')
            ->first();

        if (!$initialRate) {
            throw new \Exception('No interest rate found for the given dates: ' . $startDate . ' - ' . $endDate);
        }

        $interest = ($amount * ($initialRate->rate / 100) * ($days / 365));

        return InterestCalculation::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'principal_amount' => $amount,
            'days_count' => $days,
            'calculated_interest' => round($interest, 2),
            'interest_rate' => $initialRate->rate . '%',
        ]);
    }
}
