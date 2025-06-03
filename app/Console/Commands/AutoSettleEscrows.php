<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Escrow;

class AutoSettleEscrows extends Command
{
    protected $signature = 'escrow:auto-settle';
    protected $description = 'Auto-release escrows older than 60m even if one side did not confirm';

    public function handle()
    {
        $cutoff = now()->subMinutes(60);
        Escrow::where('status','in_escrow')
            ->where('created_at','<',$cutoff)
            ->get()
            ->each(function(Escrow $escrow){
                try {
                    $escrow->release();
                    $this->info("Released escrow #{$escrow->id}");
                } catch (\Exception $e) {
                    $this->error("Failed to release #{$escrow->id}: {$e->getMessage()}");
                }
            });
    }
}
