<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escrow extends Model
{
    protected $fillable = [
        'trade_id','buyer_id','seller_id',
        'asset','amount',
        'buyer_confirmed','seller_confirmed','status','released_at'
    ];
    protected $casts = [
        'amount'=>'decimal:8',
        'buyer_confirmed'=>'boolean',
        'seller_confirmed'=>'boolean',
        'released_at'=>'datetime',
    ];

    public function trade()  { return $this->belongsTo(P2PTrade::class, 'trade_id'); }
    public function buyer()  { return $this->belongsTo(User::class,      'buyer_id'); }
    public function seller() { return $this->belongsTo(User::class,      'seller_id'); }

    public function canRelease(): bool
    {
        return $this->buyer_confirmed && $this->seller_confirmed && $this->status === 'in_escrow';
    }

    public function release()
    {
        if (! $this->canRelease()) {
            throw new \Exception("Escrow {$this->id} cannot be released");
        }
        // 1) Transfer funds: add to seller wallet
        $sellerWallet = $this->seller->wallets()->firstOrCreate(['asset'=>$this->asset]);
        $sellerWallet->balance = $sellerWallet->balance + $this->amount;
        $sellerWallet->save();
        // 2) Mark released
        $this->update([
            'status'      => 'released',
            'released_at' => now(),
        ]);
    }
}
