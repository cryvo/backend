<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = [
        'trade_id', 'user_id', 'reason', 'message', 'status'
    ];

    /**
     * The user who raised the dispute.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The P2P trade this dispute refers to.
     */
    public function trade()
    {
        return $this->belongsTo(P2PTrade::class);
    }
}
