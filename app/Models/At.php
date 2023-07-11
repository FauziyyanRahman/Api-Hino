<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\At
 *
 * @property int|null $user_id
 * @property string|null $date_login
 * @property string|null $mac_add
 * @property string|null $ip_add
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $update_at
 * @property int|null $update_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $deleteable
 * @method static \Illuminate\Database\Eloquent\Builder|At newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|At newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|At onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|At query()
 * @method static \Illuminate\Database\Eloquent\Builder|At whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereDateLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereDeleteable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereIpAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereMacAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereUpdateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereUpdateBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|At withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|At withoutTrashed()
 * @mixin \Eloquent
 */
class At extends Model
{
    use SoftDeletes;

    protected $table = 'at';
    protected $primaryKey = null; // No primary key defined
    public $incrementing = false; // No auto-incrementing primary key
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'date_login',
        'mac_add',
        'ip_add',
        'created_by',
        'update_by',
        'deleted_by',
        'deleteable',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
