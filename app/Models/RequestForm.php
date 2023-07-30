<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\RequestForm
 *
 * @property int $request_id
 * @property string|null $request_user_id
 * @property string|null $request_date
 * @property string|null $request_status
 * @property string|null $request_update_by
 * @property string|null $request_update_date
 * @property int|null $request_kategori_id
 * @property string|null $request_karoseri_name
 * @property string|null $request_pic
 * @property string|null $request_muatan
 * @property string|null $request_body
 * @property string|null $request_tdp
 * @property string $request_status_reason
<<<<<<< HEAD
=======
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $update_at
 * @property int|null $update_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $deleteable
>>>>>>> 02b16a2d8ca2269701d814d1164d45662d6d55a9
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm query()
<<<<<<< HEAD
=======
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereDeleteable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereDeletedBy($value)
>>>>>>> 02b16a2d8ca2269701d814d1164d45662d6d55a9
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestKaroseriName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestMuatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestPic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestStatusReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestTdp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestUpdateBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereRequestUserId($value)
<<<<<<< HEAD
=======
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereUpdateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm whereUpdateBy($value)
>>>>>>> 02b16a2d8ca2269701d814d1164d45662d6d55a9
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RequestForm withoutTrashed()
 * @mixin \Eloquent
 */
class RequestForm extends Model
{
    use SoftDeletes;

    protected $table = 'request_form';
    protected $primaryKey = 'request_id';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $fillable = [
        'request_user_id',
        'request_date',
        'request_status',
        'request_update_by',
        'request_update_date',
        'request_kategori_id',
        'request_karoseri_name',
        'request_pic',
        'request_muatan',
        'request_body',
        'request_tdp',
        'request_status_reason',
        'created_at',
        'created_by',
        'update_at',
        'update_by',
        'deleted_at',
        'deleted_by',
        'deleteable',
    ];

    protected $casts = [
        'request_id' => 'integer',
        'request_kategori_id' => 'integer',
        'created_by' => 'integer',
        'update_by' => 'integer',
        'deleted_by' => 'integer',
        'deleteable' => 'integer',
    ];
}
