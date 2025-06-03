<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\P2PTrade;

class ReleaseEscrow extends Command
{
    protected $signature = 'escrow:release';
    protected $description = 'Auto‐release escrow after timeout';

    public function handle()
    {
        // Release pending escrow older than 1h
        $deadline = now()->subHour();
        $trades = P2PTrade::where('escrow_status','pending')
            ->where('created_at','<',$deadline)->get();

        foreach($trades as $t){
            $t->releaseEscrow();
            $this->info("Released escrow for trade {$t->id}");
        }
    }
}
