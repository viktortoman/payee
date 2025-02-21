<?php

namespace App\Interfaces\Service\API;

use App\Models\InterestCalculation;

interface InterestServiceInterface
{
    public function calculate(array $data): InterestCalculation;
}
