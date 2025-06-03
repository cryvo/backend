<?php
// File: backend/app/Models/Market.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $fillable = ['name','symbol','config'];
    protected $casts = ['config'=>'array'];
}
