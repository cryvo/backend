<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FeeTier extends Model
{
    protected $fillable = ['name','min_volume_usd','maker_fee','taker_fee'];
}
