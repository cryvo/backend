<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['slug','title','excerpt','content','published_at'];
    protected $dates = ['published_at'];
}
