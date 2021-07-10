<?php

namespace App\Services\CourseRegistration;

use App\Repositories\CourseRegistrationRepositoryRepository;
use Mi\Core\Services\BaseService;

class ListCourseRegistrationService extends BaseService
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
        return $this->repository
            ->with([
                'startTime',
                'learningHour',
                'duration',
                'course'
            ])
            ->orderBy($this->data->get('orderBy', 'id'), $this->data->get('sortedBy', 'desc'))
            ->paginate($this->getPerPage());
    }
}
