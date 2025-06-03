<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'user_id','symbol','side','type','price','amount','filled','status'
    ];
    public function user(){ return $this->belongsTo(User::class); }
}
