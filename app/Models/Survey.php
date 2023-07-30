<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Survey
 *
 * @property int $survey_id
 * @property string|null $survey_username
 * @property string|null $survey_question_1
 * @property string|null $survey_answer_1
 * @property string|null $survey_comment_1
 * @property string|null $survey_question_2
 * @property string|null $survey_answer_2
 * @property string|null $survey_comment_2
 * @property string|null $survey_question_3
 * @property string|null $survey_answer_3
 * @property string|null $survey_comment_3
 * @property string|null $survey_question_4
 * @property string|null $survey_answer_4
 * @property string|null $survey_comment_4
 * @property string|null $survey_note
 * @property string|null $survey_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $deleteable
 * @method static \Illuminate\Database\Eloquent\Builder|Survey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey query()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDeleteable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyAnswer1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyAnswer2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyAnswer3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyAnswer4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyComment1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyComment2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyComment3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyComment4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyQuestion1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyQuestion2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyQuestion3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyQuestion4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey withoutTrashed()
 * @mixin \Eloquent
 */
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
