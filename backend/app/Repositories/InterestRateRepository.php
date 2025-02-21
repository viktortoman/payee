<?php

namespace App\Repositories;


use App\Interfaces\Repository\InterestRateRepositoryInterface;
use App\Models\InterestRate;

class InterestRateRepository extends BaseRepository implements InterestRateRepositoryInterface
{
    public function __construct(InterestRate $model)
    {
        parent::__construct($model);
    }

    public function getMinInterestEffectiveDate()
    {
        return $this->model::min('effective_date');
    }

    public function getMaxInterestEffectiveDate()
    {
        return $this->model::max('effective_date');
    }

    public function getInterestRateByDate($start)
    {
        return $this->model::query()
            ->where('effective_date', '<=', $start)
            ->orderBy('effective_date', 'desc')
            ->first();
    }
}
