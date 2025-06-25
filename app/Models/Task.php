<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'dueDate',
        'subjectId',
        'tenantId',
        'isActive',
        'created',
        'updated',
        'deleted'
    ];

    protected $casts = [
        'dueDate' => 'datetime',
        'created' => 'datetime',
        'updated' => 'datetime',
        'deleted' => 'datetime',
    ];
}
