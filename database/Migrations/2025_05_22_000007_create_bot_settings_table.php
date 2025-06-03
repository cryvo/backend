<?php
// File: backend/app/Models/BotSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotSetting extends Model
{
    protected $fillable = ['name','config'];
    protected $casts = ['config'=>'array'];
}
