<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CourseRegistration;
use App\Http\Requests\User\CourseRegistration\ListCourseRegistrationRequest;
use App\Http\Requests\User\CourseRegistration\SendCodeRegistrationRequest;
use App\Http\Requests\User\CourseRegistration\UpdateCourseRegistrationRequest;
use App\Http\Requests\User\CourseRegistration\CreateCourseRegistrationRequest;
use App\Http\Resources\CourseRegistration\CourseRegistrationCollection;
use App\Http\Resources\CourseRegistration\CourseRegistrationResource;
use App\Services\CourseRegistration\CreateCourseRegistrationService;
use App\Services\CourseRegistration\DeleteCourseRegistrationService;
use App\Services\CourseRegistration\FindCourseRegistrationService;
use App\Services\CourseRegistration\ListCourseRegistrationService;
use App\Services\CourseRegistration\SendTokenCourseRegistrationService;
use App\Services\CourseRegistration\UpdateCourseRegistrationService;

class CourseRegistrationController extends Controller
{
    protected $createService;
    protected $listService;
    protected $updateService;
    protected $deleteService;
    protected $findService;
    protected $sendTokenService;

    public function __construct(
        CreateCourseRegistrationService $createService,
        ListCourseRegistrationService $listService,
        UpdateCourseRegistrationService $updateService,
        DeleteCourseRegistrationService $deleteService,
        FindCourseRegistrationService $findService,
        SendTokenCourseRegistrationService $sendTokenService
    ) {
        $this->createService = $createService;
        $this->listService = $listService;
        $this->updateService = $updateService;
        $this->deleteService = $deleteService;
        $this->findService = $findService;
        $this->sendTokenService = $sendTokenService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\CourseRegistration\CreateCourseRegistrationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCourseRegistrationRequest $request)
    {
        $course = $this->createService->setRequest($request)->handle();

        return response()->created(new CourseRegistrationResource($course));
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\User\CourseRegistration\ListCourseRegistrationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ListCourseRegistrationRequest $request)
    {
        $list = $this->listService->setRequest($request)->handle();

        return response()->success(new CourseRegistrationCollection($list));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\CourseRegistration\UpdateCourseRegistrationRequest  $request
     * @param \App\Models\CourseRegistration $courseRegistration
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRegistrationRequest $request, CourseRegistration $courseRegistration)
    {
        $course = $this->updateService->setRequest($request)->setModel($courseRegistration)->handle();

        return response()->success(new CourseRegistrationResource($course));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CourseRegistration $courseRegistration
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseRegistration $courseRegistration)
    {
        $this->deleteService->setModel($courseRegistration)->handle();

        return response()->successWithoutData();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CourseRegistration $courseRegistration
     * @return \Illuminate\Http\Response
     */
    public function show(CourseRegistration $courseRegistration)
    {
        $course = $this->findService->setModel($courseRegistration)->handle();

        return response()->success(new CourseRegistrationResource($course));
    }

    /**
     * Send token to email's user
     *
     * @param \App\Http\Requests\User\CourseRegistration\SendCodeRegistrationRequest $courseRegistration
     * @return \Illuminate\Http\Response
     */
    public function sendToken(SendCodeRegistrationRequest $request)
    {
        $this->sendTokenService->setRequest($request)->handle();

        return response()->successWithoutData();
    }
}
