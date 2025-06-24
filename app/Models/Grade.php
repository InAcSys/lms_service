<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';

    protected $fillable = [
        'Id',
        'TenantId',
        'StudentId',
        'SubjectId',
        'TaskId',
        'Grade',
        'Comment',
        'IsActive',
        'Created',
        'Updated',
        'Deleted'
    ];

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $casts = [
        'Created' => 'datetime',
        'Updated' => 'datetime',
        'Deleted' => 'datetime'
    ];
}
