<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'msbodymaker_pic';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ms_job_area',
        'ms_name',
        'ms_email',
        'ms_phone_number',
        'created_by',
        'update_by',
        'deleted_by',
        'ms_company_id',
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
