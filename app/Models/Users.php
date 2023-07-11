<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Users
 *
 * @property int $ms_user_id
 * @property string $ms_user_name
 * @property string|null $ms_user_password
 * @property string|null $ms_user_description
 * @property string|null $ms_user_email
 * @property string|null $ms_role_name
 * @property int|null $ms_body_maker_id
 * @property string|null $permission
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $update_at
 * @property int|null $update_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $deleteable
 * @method static \Illuminate\Database\Eloquent\Builder|Users newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Users query()
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereDeleteable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereMsBodyMakerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereMsRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereMsUserDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereMsUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereMsUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereMsUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereMsUserPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUpdateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUpdateBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Users withoutTrashed()
 * @mixin \Eloquent
 */
class Users extends Model
{
    use SoftDeletes;

    protected $table = 'msuser';
    protected $primaryKey = 'ms_user_id';
    public $timestamps = false;

    protected $fillable = [
        'ms_user_name',
        'ms_user_password',
        'ms_user_description',
        'ms_user_email',
        'ms_role_name',
        'ms_body_maker_id',
        'permission',
        'created_at',
        'created_by',
        'update_at',
        'update_by',
        'deleted_at',
        'deleted_by',
        'deleteable',
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];
}
