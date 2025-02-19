<?php

namespace App\Console\Commands;

use App\Imports\InterestRatesImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ParseInterestRatesXmlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-interest-rates-xml-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse interest rates XML file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = storage_path('alapkamat.xlsx');

        if (!file_exists($file)) {
            $this->error('alapkamat.xml file does not exist');
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
