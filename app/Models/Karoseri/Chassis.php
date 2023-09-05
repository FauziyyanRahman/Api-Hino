<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Chassis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'msbodymaker_hino_chassis_use';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ms_type',
        'ms_unit',
        'created_by',
        'update_by',
        'deleted_by',
        'ms_field_1',
        'ms_field_2',
        'ms_field_3',
        'ms_company_id',
        'ms_field_4',
        'ms_field_5',
        'ms_field_6',
        'ms_field_7',
        'ms_field_8',
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
