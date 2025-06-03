<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'asset',
        'amount',
        'address',
        'status',
    ];

    protected $casts = [
        'amount'     => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The user who requested this withdrawal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
