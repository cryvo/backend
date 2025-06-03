<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = ['user_id','name','key','revoked_at'];
}
