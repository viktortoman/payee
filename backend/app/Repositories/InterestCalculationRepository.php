<?php

namespace App\Repositories;

use App\Interfaces\Repository\InterestCalculationRepositoryInterface;
use App\Models\InterestCalculation;

class InterestCalculationRepository extends BaseRepository implements InterestCalculationRepositoryInterface
{
    public function __construct(InterestCalculation $model)
    {
        parent::__construct($model);
    }
}
