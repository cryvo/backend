<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = ['user_id','code','reward_points'];

    public function uses() { return $this->hasMany(ReferralUse::class); }
}
public function parent() { return $this->belongsTo(Referral::class,'parent_id'); }
public function children() { return $this->hasMany(Referral::class,'parent_id'); }
