<?php

namespace App\Services\CourseRegistration;

use App\Services\Traits\CourseRegistrationTrait;
use App\Services\Traits\ImageTrait;
use Mi\Core\Services\BaseService;

class UpdateCourseRegistrationService extends BaseService
{
    use CourseRegistrationTrait,
        ImageTrait;

    /**
     * Logic to handle the data
     */
    public function handle()
    {
        $this->caculateEndDateTime();

        if ($this->data->has('image')) {
            $path = $this->uploadImage([$this->data->get('image')]);
            $this->data->put('image', $path[0]);
        }

        $this->model->fill($this->data->toArray());
        $this->model->save();

        return $this->model;
    }
}
