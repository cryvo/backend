<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CrybotSignal extends Model
{
    protected $fillable = ['subscription_id','market','type','side','price','sent_at'];

    public function subscription() { return $this->belongsTo(CrybotSubscription::class,'subscription_id'); }
}
