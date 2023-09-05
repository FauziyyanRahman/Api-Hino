<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class WebUsers extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'msbodymaker_pic_web';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ms_name',
        'ms_email',
        'ms_phone',
        'ms_position',
        'created_by',
        'update_by',
        'deleted_by',
        'ms_company_id',
        'ms_approved',
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
