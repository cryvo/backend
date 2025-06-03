<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReferralUse extends Model
{
    protected $fillable = ['referral_id','referred_user_id'];
}
