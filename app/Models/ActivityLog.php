<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'email',
        'ip_address',
        'device',
        'login_at',
        'logout_at',
    ];

    protected $dates = [
        'login_at',
        'logout_at',
    ];
} 