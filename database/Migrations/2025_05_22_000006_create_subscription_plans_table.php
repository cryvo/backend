<?php
// File: backend/app/Models/SubscriptionPlan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = ['name','config'];
    protected $casts = ['config'=>'array'];
}
