<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CrybotService;

class RunCrybot extends Command
{
    // the name and signature of the console command
    protected $signature = 'crybot:scan';

    // the console command description
    protected $description = 'Scan markets & send Crybot signals';

    public function handle(CrybotService $bot)
    {
        $bot->runScan();
    }
}
