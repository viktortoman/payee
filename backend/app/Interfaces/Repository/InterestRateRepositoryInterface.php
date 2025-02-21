<?php

namespace App\Interfaces\Repository;

interface InterestRateRepositoryInterface extends BaseRepositoryInterface
{
    public function getMinInterestEffectiveDate();
    public function getMaxInterestEffectiveDate();
    public function getInterestRateByDate($start);
}
