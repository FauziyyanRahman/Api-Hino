<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'msbodymaker_variant_product';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ms_dump',
        'ms_box',
        'ms_wing_box',
        'ms_tanki_pertamina',
        'ms_tank_air',
        'ms_cpo',
        'ms_cargo',
        'ms_pemadam_kebaran',
        'ms_mixer',
        'ms_box_pendingin',
        'ms_car_carrier',
        'ms_compactor',
        'ms_arm_roll',
        'ms_skylift',
        'ms_road_sweeper',
        'ms_field_16', 
        'ms_field_17', 
        'ms_field_18', 
        'ms_field_19', 
        'ms_field_20', 
        'ms_field_21', 
        'ms_field_22', 
        'ms_field_23', 
        'ms_field_24', 
        'ms_field_25', 
        'ms_field_26', 
        'ms_field_27', 
        'ms_field_28', 
        'ms_field_29', 
        'ms_field_30',  
        'created_by',
        'update_by',
        'deleted_by',
        'ms_company_id'
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
