<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MtTradeEvent extends Model
{
    protected $fillable = ['user_id','symbol','volume','price','type'];
}
