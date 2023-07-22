<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\News
 *
 * @property mixed $password
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @property int $ms_berita_id
 * @property string|null $ms_berita_judul
 * @property string|null $ms_berita_judul_en
 * @property string|null $ms_berita_content
 * @property string|null $ms_berita_content_en
 * @property string|null $ms_berita_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $update_at
 * @property int|null $update_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $deleteable
 * @property-read \App\Models\User|null $createUser
 * @property-read \App\Models\User|null $updateUser
 * @method static \Illuminate\Database\Eloquent\Builder|News onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDeleteable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereMsBeritaContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereMsBeritaContentEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereMsBeritaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereMsBeritaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereMsBeritaJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereMsBeritaJudulEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdateBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|News withoutTrashed()
 * @mixin \Eloquent
 */
class News extends Model
{
    use SoftDeletes;

    protected $table = 'msberita';
    protected $primaryKey = 'ms_berita_id';
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    protected $casts = [
        'ms_berita_id' => 'integer',
        'ms_berita_judul' => 'string',
        'ms_berita_judul_en' => 'string',
        'ms_berita_content' => 'string',
        'ms_berita_content_en' => 'string',
        'ms_berita_image' => 'string',
        'created_at' => 'datetime',
        'created_by' => 'integer',
        'update_at' => 'datetime',
        'update_by' => 'integer',
        'deleted_at' => 'datetime',
        'deleted_by' => 'integer',
        'deleteable' => 'integer',
    ];

    // Define the relationship with the User model for create user
    public function createUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Define the relationship with the User model for update user
    public function updateUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
