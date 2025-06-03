<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id',
        'asset',
        'amount',
        'tx_hash',
        'status',
    ];

    protected $casts = [
        'amount'     => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The user who made this deposit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
