<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
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
