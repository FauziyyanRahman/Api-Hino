<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'msbanner';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ms_title',
        'ms_description',
        'ms_url',
        'ms_type',
        'ms_status',
        'ms_company_id',
        'created_by',
        'update_by',
        'deleted_by',
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
