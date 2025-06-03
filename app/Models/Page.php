<?php
// File: backend/app/Models/Page.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug','title','config'];
    protected $casts = ['config'=>'array'];
}
