<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCapacity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'msbodymaker_production_capacity';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ms_unit',
        'created_by',
        'update_by',
        'deleted_by',
        'ms_company_id',
        'ms_all_type'
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
