<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Karoseri
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri query()
 * @mixin \Eloquent
 */
class Karoseri extends Model
{
    protected $table = 'mskaroseri';
    protected $primaryKey = 'ms_karoseri_id';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'ms_karoseri_id' => 'bigint',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'deleteable' => 'integer',
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ms_karoseri_region',
        'ms_karoseri_wilayah',
        'ms_karoseri_tipe',
        'ms_karoseri_name',
        'ms_karoseri_merk',
        'ms_karoseri_domisili',
        'ms_karoseri_alamat',
        'ms_karoseri_telepon',
        'ms_karoseri_fax',
        'ms_karoseri_website',
        'ms_karoseri_unitproductioncap',
        'ms_karoseri_grade',
        'ms_karoseri_productlineup',
        'ms_karoseri_photoproduct',
        'ms_karoseri_owner_name',
        'ms_karoseri_owner_telepon',
        'ms_karoseri_owner_email',
        'ms_karoseri_marketing_name',
        'ms_karoseri_marketing_telepon',
        'ms_karoseri_marketing_email',
        'ms_karoseri_engineering_name',
        'ms_karoseri_engineering_telepon',
        'ms_karoseri_engineering_email',
        'ms_karoseri_production_name',
        'ms_karoseri_production_telepon',
        'ms_karoseri_production_email',
    ];
}
