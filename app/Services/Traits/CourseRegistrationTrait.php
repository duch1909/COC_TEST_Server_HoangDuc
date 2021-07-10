<?php

namespace App\Services\Traits;

use App\Models\Duration;
use App\Models\LearningHour;
use App\Models\StartTime;
use Carbon\Carbon;

trait CourseRegistrationTrait
{
    public function caculateEndDateTime()
    {
        $duration = Duration::find($this->data->get('duration_id'))->month;
        $learningHour = Carbon::parse(LearningHour::find($this->data->get('learning_hour_id'))->learning_hour);
        $startTime = Carbon::parse(StartTime::find($this->data->get('start_time_id'))->start_time)->format('H:i');
        $endDateTime = Carbon::parse($this->data->get('start_date') . $startTime)
            ->addMonth($duration)
            ->addHours($learningHour->hour)
            ->addMinutes($learningHour->minute);

        $this->data->put('end_date', $endDateTime);
        $this->data->put('end_time', $endDateTime);
    }
}
