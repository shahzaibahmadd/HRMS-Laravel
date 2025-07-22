<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['assigned_by', 'assigned_to', 'title', 'description', 'status', 'due_date'];

    protected $casts = [
        'due_date' => 'datetime',
    ];
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function performanceReviews()
    {
        return $this->hasMany(PerformanceReview::class);
    }
}
