<?php
// File: backend/app/Models/Fee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = ['name','config'];
    protected $casts = ['config'=>'array'];
}
