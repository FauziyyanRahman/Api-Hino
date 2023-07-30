<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
 * @property int|null $active
 * @property int|null $create_id
 * @property string|null $create_date
 * @property int|null $update_id
 * @property string|null $update_date
 * @property string|null $msuser_permission
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $update_at
 * @property int|null $update_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $deleteable
 * @property-read \App\Models\Karoseri|null $karoseri
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\At> $logins
 * @property-read int|null $logins_count
 * @method static \Illuminate\Database\Eloquent\Builder|Users newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Users query()
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereCreateId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereMsuserPermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUpdateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUpdateBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUpdateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Users withoutTrashed()
 * @mixin \Eloquent
 */

class Users extends Authenticatable implements JWTSubject
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
        'active',
        'create_id',
        'create_date',
        'update_id',
        'update_date',
        'msuser_permission',
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

    // Enum mapping for "msuser_permission" field
    protected $enumCasts = [
        'msuser_permission' => 'string'
    ];

    public function karoseri()
    {
        return $this->belongsTo(Karoseri::class, 'ms_body_maker_id', 'ms_karoseri_id');
    }

    public function logins()
    {
        return $this->hasMany(AT::class, 'user_id');
    }

    // Method required by JWTSubject interface
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Method required by JWTSubject interface
    public function getJWTCustomClaims()
    {
        return [];
    }
}
