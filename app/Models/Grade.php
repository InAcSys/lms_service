<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';
    protected $fillable = [
        'taskId',
        'studentId',
        'grade',
        'comment',
        'tenantId',
        'isActive',
    ];

    protected $casts = [
        'grade' => 'decimal:2',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'taskId');
    }
}
