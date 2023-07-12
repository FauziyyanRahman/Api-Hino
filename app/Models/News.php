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
}
