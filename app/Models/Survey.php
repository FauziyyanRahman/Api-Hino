<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;

    protected $table = 'survey';
    protected $primaryKey = 'survey_id';
    protected $fillable = [
        'survey_username',
        'survey_question_1',
        'survey_answer_1',
        'survey_comment_1',
        'survey_question_2',
        'survey_answer_2',
        'survey_comment_2',
        'survey_question_3',
        'survey_answer_3',
        'survey_comment_3',
        'survey_question_4',
        'survey_answer_4',
        'survey_comment_4',
        'survey_note',
        'survey_date',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'deleteable',
    ];

    protected $dates = ['survey_date', 'created_at', 'updated_at', 'deleted_at'];
}
