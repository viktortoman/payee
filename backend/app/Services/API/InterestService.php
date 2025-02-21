<?php

namespace App\Services\API;

use App\Interfaces\Repository\InterestCalculationRepositoryInterface;
use App\Interfaces\Repository\InterestRateRepositoryInterface;
use App\Interfaces\Service\API\InterestServiceInterface;
use App\Models\InterestCalculation;
use Exception;
use Illuminate\Support\Carbon;

readonly class InterestService implements InterestServiceInterface
{
    public function __construct(
        private InterestRateRepositoryInterface        $interestRateRepository,
        private InterestCalculationRepositoryInterface $interestCalculationRepository
    ) {}

    /**
     * Calculate interest based on the given data.
     * @throws Exception
     */
    public function calculate(array $data): InterestCalculation
    {
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $amount = $data['amount'];

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = (int) $start->diffInDays($end->addDay());

        $initialRate = $this->interestRateRepository->getInterestRateByDate($start);

        if (!$initialRate) {
            throw new Exception('No interest rate found for the given dates: ' . $startDate . ' - ' . $endDate);
        }

        $interest = ($amount * ($initialRate->rate / 100) * ($days / 365));

        return $this->interestCalculationRepository->create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'principal_amount' => $amount,
            'days_count' => $days,
            'calculated_interest' => round($interest, 2),
            'interest_rate' => $initialRate->rate . '%',
        ]);
    }
}
