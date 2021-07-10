<?php

namespace App\Services\CourseRegistration;

use App\Notifications\SendTokenRegistrationMail;
use App\Repositories\CourseRegistrationRepositoryRepository;
use Illuminate\Support\Facades\Notification;
use Mi\Core\Services\BaseService;
use Illuminate\Support\Str;

class SendTokenCourseRegistrationService extends BaseService
{
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
        $course = $this->repository
            ->where($this->data->toArray())
            ->firstOrFail();

        $token = Str::random(64);

        $course->update(['token' => $token]);

        Notification::route('mail', $this->data->get('email'))->notify(new SendTokenRegistrationMail($token, $course->id));
    }
}
