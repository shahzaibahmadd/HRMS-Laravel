<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    protected $fillable = [
        'method', 'url', 'payload', 'ip_address', 'user_agent', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
