<?php

namespace App\Models\Karoseri;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DesignTools extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'msbodymaker_design_tool';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ms_quantity_of_computer_design',
        'ms_twod_program_design',
        'ms_threed_program_design',
        'created_by',
        'update_by',
        'ms_company_id',
    ];

    protected $dates = [
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public $timestamps = false;
    
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'update_by');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'ms_company_id');
    }
}
