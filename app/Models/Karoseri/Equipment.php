<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'msbodymaker_equipment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ms_equipment',
        'ms_welding_machine',
        'ms_cutting_machine',
        'ms_bending_machine',
        'ms_plasma_cutting',
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
