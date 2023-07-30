<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditTrailCategory extends Model
{
    use SoftDeletes;

    protected $table = 'audit_trail_kategori';
    protected $primaryKey = 'audit_id';
    public $timestamps = false;

    protected $fillable = [
        'audit_user_id',
        'audit_date',
        'audit_kategori_id',
    ];

    protected $dates = [
        'audit_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}