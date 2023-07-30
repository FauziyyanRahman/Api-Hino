<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Karoseri
 *
 * @property int $ms_karoseri_id
 * @property string|null $ms_karoseri_region
 * @property string|null $ms_karoseri_wilayah
 * @property string|null $ms_karoseri_tipe
 * @property string|null $ms_karoseri_name
 * @property string|null $ms_karoseri_merk
 * @property string|null $ms_karoseri_domisili
 * @property string|null $ms_karoseri_alamat
 * @property string|null $ms_karoseri_telepon
 * @property string|null $ms_karoseri_fax
 * @property string|null $ms_karoseri_website
 * @property string|null $ms_karoseri_unitproductioncap
 * @property string|null $ms_karoseri_grade
 * @property string|null $ms_karoseri_productlineup
 * @property string|null $ms_karoseri_photoproduct
 * @property string|null $ms_karoseri_owner_name
 * @property string|null $ms_karoseri_owner_telepon
 * @property string|null $ms_karoseri_owner_email
 * @property string|null $ms_karoseri_marketing_name
 * @property string|null $ms_karoseri_marketing_telepon
 * @property string|null $ms_karoseri_marketing_email
 * @property string|null $ms_karoseri_engineering_name
 * @property string|null $ms_karoseri_engineering_telepon
 * @property string|null $ms_karoseri_engineering_email
 * @property string|null $ms_karoseri_production_name
 * @property string|null $ms_karoseri_production_telepon
 * @property string|null $ms_karoseri_production_email
 * @property int|null $active
 * @property int|null $create_id
 * @property string|null $create_date
 * @property int|null $update_id
 * @property string|null $update_date
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri query()
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereCreateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriDomisili($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriEngineeringEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriEngineeringName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriEngineeringTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriMarketingEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriMarketingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriMarketingTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriOwnerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriOwnerTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriPhotoproduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriProductionEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriProductionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriProductionTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriProductlineup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriUnitproductioncap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereMsKaroseriWilayah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Karoseri whereUpdateId($value)
 * @mixin \Eloquent
 */
class Karoseri extends Model
{
    protected $table = 'mskaroseri';
    protected $primaryKey = 'ms_karoseri_id';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'ms_karoseri_id' => 'integer',
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
