<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestForm extends Model
{
    use SoftDeletes;

    protected $table = 'request_form';
    protected $primaryKey = 'request_id';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $fillable = [
        'request_user_id',
        'request_date',
        'request_status',
        'request_update_by',
        'request_update_date',
        'request_kategori_id',
        'request_karoseri_name',
        'request_pic',
        'request_muatan',
        'request_body',
        'request_tdp',
        'request_status_reason',
        'created_at',
        'created_by',
        'update_at',
        'update_by',
        'deleted_at',
        'deleted_by',
        'deleteable',
    ];

    protected $casts = [
        'request_id' => 'integer',
        'request_kategori_id' => 'integer',
        'created_by' => 'integer',
        'update_by' => 'integer',
        'deleted_by' => 'integer',
        'deleteable' => 'integer',
    ];
}
