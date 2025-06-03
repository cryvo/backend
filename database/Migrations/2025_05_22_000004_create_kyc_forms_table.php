<?php
// File: backend/app/Models/KycForm.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycForm extends Model
{
    protected $fillable = ['name','config'];
    protected $casts = ['config'=>'array'];
}
