<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id','method','path','request','response','ip'
    ];
    protected $casts = [
        'request'  => 'array',
        'response' => 'array',
    ];
}
