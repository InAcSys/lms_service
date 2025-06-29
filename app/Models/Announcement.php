<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'tenantId',
        'authorId',
        'subjectId',
        'isActive',
        'created',
        'updated',
        'deleted'
    ];

    public $timestamps = false;

    protected $casts = [
        'created' => 'datetime',
        'updated' => 'datetime',
        'deleted' => 'datetime'
    ];
}
