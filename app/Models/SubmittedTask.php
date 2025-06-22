<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmittedTask extends Model
{
    protected $table = 'submitted_tasks';

    protected $fillable = [
        'Content',
        'TaskId',
        'StudentId',
        'TenantId',
        'IsActive',
        'Created',
        'Updated',
        'Deleted'
    ];

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $casts = [
        'Created' => 'datetime',
        'Updated' => 'datetime',
        'Deleted' => 'datetime'
    ];
}
