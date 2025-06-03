<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CrybotPlan extends Model
{
    protected $fillable = ['name','price_usd','frequency','features'];
    protected $casts = ['features'=>'array'];
}
