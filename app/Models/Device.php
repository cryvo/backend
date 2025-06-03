<?php
// app/Models/Device.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['ip','agent'];
}
