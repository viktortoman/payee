<?php

namespace App\Console\Commands;

use App\Imports\InterestRatesImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ParseInterestRatesXlsxCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-interest-rates-xlsx-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse interest rates XLSX file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = 'alapkamat.xlsx';
        $file = Storage::disk('local')->path($fileName);

        if (!Storage::disk('local')->exists($fileName)) {
            $this->error("File {$fileName} does not exist");
            return;
        }

        try {
            Excel::import(new InterestRatesImport, $file);

            $this->info('Interest rates XML file has been parsed successfully');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
