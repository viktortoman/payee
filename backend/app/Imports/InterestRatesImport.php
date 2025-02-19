<?php

namespace App\Imports;

use App\Models\InterestRate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class InterestRatesImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $date = Date::excelToDateTimeObject($row[0])->format('Y-m-d');
            $rate = (float) str_replace(',', '.', str_replace('%', '', $row[1]));

            InterestRate::updateOrCreate([
                'effective_date' => $date,
            ], [
                'rate' => $rate
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
