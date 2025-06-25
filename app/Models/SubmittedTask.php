<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmittedTask extends Model
{
    protected $table = 'submitted_tasks';

    protected $fillable = [
        'content',
        'taskId',
        'studentId',
        'tenantId',
        'isActive',
        'created',
        'updated',
        'deleted'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $casts = [
        'created' => 'datetime',
        'updated' => 'datetime',
        'deleted' => 'datetime'
    ];
}
