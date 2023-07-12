<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogActivity extends Model
{
    use SoftDeletes;

    protected $table = 'log_activity';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_module',
        'doc_no',
        'desc_activity',
        'doc_date',
        'subject',
        'url',
        'method',
        'ip',
        'agent',
        'user_id',
        'created_by',
        'update_at',
        'update_by',
        'deleted_at',
        'deleted_by',
        'deleteable',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'deleteable' => 'boolean',
    ];
}
