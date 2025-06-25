<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';

    protected $fillable = [
        'tenantId',
        'studentId',
        'subjectId',
        'yaskId',
        'grade',
        'comment',
        'isActive',
        'created',
        'updated',
        'deleted'
    ];

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $casts = [
        'created' => 'datetime',
        'updated' => 'datetime',
        'deleted' => 'datetime'
    ];
}
