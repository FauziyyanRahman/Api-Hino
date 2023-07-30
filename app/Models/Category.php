<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $ms_kategori_id
 * @property int|null $ms_kategori_level
 * @property string $ms_kategori_name
 * @property string|null $ms_kategori_name_en
 * @property int|null $ms_kategori_parent
 * @property string|null $ms_kategori_file
 * @property string|null $ms_kategori_image
 * @property int|null $ms_kategori_flag_turunan
 * @property int|null $ms_kategori_flag_form
 * @property int|null $active
 * @property int|null $create_id
 * @property string|null $create_date
 * @property int|null $update_id
 * @property string|null $update_date
 * @property-read Category|null $level1Parent
 * @property-read Category|null $level2Parent
 * @property-read Category|null $level3Parent
 * @property-read Category|null $level4Parent
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMsKategoriFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMsKategoriFlagForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMsKategoriFlagTurunan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMsKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMsKategoriImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMsKategoriLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMsKategoriName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMsKategoriNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMsKategoriParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdateId($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected $table = 'mskategori';
    protected $primaryKey = 'ms_kategori_id';
    public $timestamps = false;
    protected $fillable = [
        'ms_kategori_level',
        'ms_kategori_name',
        'ms_kategori_name_en',
        'ms_kategori_parent',
        'ms_kategori_file',
        'ms_kategori_image',
        'ms_kategori_flag_turunan',
        'ms_kategori_flag_form',
        'active',
        'created_at',
        'created_by',
        'update_at',
        'update_by',
        'deleted_at',
        'deleted_by',
        'deleteable',
    ];

    // Relationship to get the parent category for level 1
    public function level1Parent()
    {
        return $this->belongsTo(Category::class, 'ms_kategori_parent', 'ms_kategori_id');
    }

    // Relationship to get the parent category for level 2
    public function level2Parent()
    {
        return $this->belongsTo(Category::class, 'ms_kategori_parent', 'ms_kategori_id')->with('level1Parent');
    }

    // Relationship to get the parent category for level 3
    public function level3Parent()
    {
        return $this->belongsTo(Category::class, 'ms_kategori_parent', 'ms_kategori_id')->with('level2Parent');
    }

    // Relationship to get the parent category for level 4
    public function level4Parent()
    {
        return $this->belongsTo(Category::class, 'ms_kategori_parent', 'ms_kategori_id')->with('level3Parent');
    }
}
