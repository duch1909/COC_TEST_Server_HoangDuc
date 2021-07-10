<?php

namespace App\Services\CourseRegistration;

use App\Notifications\SussessRegistrationEmail;
use App\Repositories\CourseRegistrationRepositoryRepository;
use App\Services\Traits\CourseRegistrationTrait;
use App\Services\Traits\ImageTrait;
use Illuminate\Support\Facades\Notification;
use Mi\Core\Services\BaseService;

class CreateCourseRegistrationService extends BaseService
{
    use CourseRegistrationTrait,
        ImageTrait;

    /**
     * @var \App\Repositories\CourseRegistrationRepositoryRepository
     */
    protected $repository;

    public function __construct(CourseRegistrationRepositoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Logic to handle the data
     */
    public function handle()
    {
        $this->caculateEndDateTime();

        $path = $this->uploadImage([$this->data->get('image')]);
        $this->data->put('image', $path[0]);

        $course = $this->repository->create($this->data->toArray());

        Notification::route('mail', $this->data->get('email'))->notify(new SussessRegistrationEmail($course->id));

        return $course;
    }
}
