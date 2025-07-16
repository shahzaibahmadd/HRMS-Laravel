<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeProfile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'designation',
        'department',
        'skills',
        'resume',
        'contract',
        'joining_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
