<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\LogActivity
 *
<<<<<<< HEAD
=======
 * @property int $id
 * @property int|null $id_module
 * @property string|null $doc_no
 * @property string|null $desc_activity
 * @property string|null $doc_date
 * @property string|null $subject
 * @property string|null $url
 * @property string|null $method
 * @property string|null $ip
 * @property string|null $agent
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property string|null $update_at
 * @property int|null $update_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $deleted_by
 * @property bool|null $deleteable
>>>>>>> 02b16a2d8ca2269701d814d1164d45662d6d55a9
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity query()
<<<<<<< HEAD
=======
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereDeleteable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereDescActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereDocDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereDocNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereIdModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereUpdateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereUpdateBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity whereUserId($value)
>>>>>>> 02b16a2d8ca2269701d814d1164d45662d6d55a9
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LogActivity withoutTrashed()
 * @mixin \Eloquent
 */
class LogActivity extends Model
{
    use SoftDeletes;

    protected $table = 'log_activity';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_module',
        'doc_no',
        'desc_activity',
        'doc_date',
        'subject',
        'url',
        'method',
        'ip',
        'agent',
        'user_id',
        'created_by',
        'update_at',
        'update_by',
        'deleted_at',
        'deleted_by',
        'deleteable',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'deleteable' => 'boolean',
    ];
}
