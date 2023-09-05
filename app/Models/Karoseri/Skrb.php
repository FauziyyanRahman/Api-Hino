<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Skrb extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'msbodymaker_skrb';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ms_skrb text',
        'ms_hino_five',
        'ms_hino_three',
        'created_by',
        'update_by',
        'deleted_by',
        'ms_company_id',
        'ms_hino_bus'
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
