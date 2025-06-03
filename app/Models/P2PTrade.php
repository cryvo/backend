<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class P2PTrade extends Model
{
    protected $fillable = [
      'ad_id','buyer_id','seller_id','amount','rate',
      'escrow_amount','escrow_status','escrow_release_at'
    ];
    protected $casts = [
      'escrow_amount'=>'decimal:8',
      'escrow_release_at'=>'datetime',
    ];

    // Release escrow to seller
    public function releaseEscrow()
    {
        if($this->escrow_status!=='pending') return false;
        DB::transaction(function(){
            // credit seller wallet
            $seller = $this->seller;
            $seller->wallets()
              ->where('asset','USDT')
              ->increment('balance',$this->escrow_amount);
            // mark released
            $this->update([
              'escrow_status'=>'released',
              'escrow_release_at'=>now()
            ]);
        });
        return true;
    }
}
