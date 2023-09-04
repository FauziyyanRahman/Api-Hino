<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'created_at',
        'created_by',
        'update_at',
        'update_by',
        'deleted_at',
        'deleted_by',
    ];

    // Timestamps
    public $timestamps = false; // Disable Laravel's automatic timestamps

    // Soft deletes
    protected $dates = ['deleted_at']; // Enable soft deletes
}
