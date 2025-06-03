<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CrybotSubscription extends Model
{
    protected $fillable = ['user_id','plan_id','starts_at','ends_at','status'];

    public function plan() { return $this->belongsTo(CrybotPlan::class,'plan_id'); }
    public function user() { return $this->belongsTo(User::class,'user_id'); }
    public function signals() { return $this->hasMany(CrybotSignal::class,'subscription_id'); }
}
