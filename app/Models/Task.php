<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Title',
        'Description',
        'DueDate',
        'SubjectId',
        'TenantId',
        'IsActive',
        'Created',
        'Updated',
        'Deleted'
    ];

    protected $casts = [
        'DueDate' => 'datetime',
        'Created' => 'datetime',
        'Updated' => 'datetime',
        'Deleted' => 'datetime',
    ];
}
