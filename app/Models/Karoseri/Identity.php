<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Identity extends Model
{
    use HasFactory, SoftDeletes;

    // Define the table name explicitly
    protected $table = 'msbodymaker_identitas';
    protected $primaryKey = 'id';
    // Define the fillable columns to allow mass assignment
    protected $fillable = [
        'ms_company_name',
        'ms_company_status',
        'ms_address',
        'ms_phone_number',
        'ms_email',
        'ms_website',
        'ms_established',
        'ms_owner',
        'ms_warranty_to_customer',
        'ms_business_activity',
        'ms_number_employee',
        'ms_building_area_land',
        'ms_quality_system',
        'ms_technical_assistance',
        'ms_number_of_branch',
        'ms_company_license',
        'created_by',
        'update_by',
        'deleted_by',
        'ms_fax',
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
