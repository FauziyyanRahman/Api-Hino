<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'msmessages';
    protected $primaryKey = 'id';
    public $timestamps = false; // Since you have created_at and update_at columns
    protected $fillable = [
        'id',
        'ms_pic_web',
        'ms_content',
        'ms_attachment',
        'created_at',
        'created_by',
        'update_at',
        'update_by',
        'deleted_at',
        'deleted_by',
        'ms_company_id',
    ];
}
