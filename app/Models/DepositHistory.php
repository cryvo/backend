<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DepositHistory extends Model
{
    protected $fillable = ['user_id','asset','address'];
    protected $casts = ['created_at'=>'datetime'];
}
