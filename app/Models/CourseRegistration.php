<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StartTime;
use App\Models\LearningHour;
use App\Models\Duration;
use App\Models\Course;

class CourseRegistration extends Model
{
    use SoftDeletes;

    protected $table = 'registrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'dob',
        'address',
        'phone',
        'email',
        'start_date',
        'image',
        'start_time_id',
        'learning_hour_id',
        'duration_id',
        'course_id',
        'end_date',
        'end_time',
        'token'
    ];

    public function startTime()
    {
        return $this->belongsTo(StartTime::class);
    }

    public function learningHour()
    {
        return $this->belongsTo(LearningHour::class);
    }

    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d');
    }

    public function getEndTimeAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }
}
