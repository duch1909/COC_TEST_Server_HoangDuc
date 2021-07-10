<?php

namespace App\Services\CourseRegistration;

use Mi\Core\Services\BaseService;

class DeleteCourseRegistrationService extends BaseService
{
    /**
     * Logic to handle the data
     */
    public function handle()
    {
        $this->model->delete();
    }
}
