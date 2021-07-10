<?php

namespace App\Services\CourseRegistration;

use Mi\Core\Services\BaseService;

class FindCourseRegistrationService extends BaseService
{
    /**
     * Logic to handle the data
     */
    public function handle()
    {
        return $this->model->with([
            'startTime',
            'learningHour',
            'duration',
            'course'
        ])->findOrFail($this->model->id);
    }
}
