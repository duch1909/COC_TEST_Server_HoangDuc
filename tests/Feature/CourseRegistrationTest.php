<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Duration;
use App\Models\LearningHour;
use App\Models\StartTime;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CourseRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private $image;
    private $admin;
    private $startTime;
    private $learningHour;
    private $duration;
    private $course;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            'StartTimeSeeder',
            'LearningHourSeeder',
            'CourseSeeder',
            'DurationSeeder'
        ]);

        $this->startTime = StartTime::first();
        $this->learningHour = LearningHour::first();
        $this->duration = Duration::first();
        $this->course = Course::first();
        $this->admin = factory(User::class)->create();
        $this->image = UploadedFile::fake()->image('image.jpg');
    }

    public function testUserCanCreateCourseRegistration()
    {
        $response = $this
            ->postJson("api/user/course-registrations", [
                "name" => "test",
                "dob" => "1996/09/19",
                "address" => "da nang",
                "phone" => "0935888888",
                "email" => "test@gmail.com",
                "start_date" => "2021/07/07",
                "start_time_id" => "22",
                "learning_hour_id" => "6",
                "duration_id" => "1",
                "course_id" => "1",
                "image" => $this->image
            ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'id',
            'name',
            'dob',
            'address',
            'phone',
            'email',
            'start_date',
            'image',
            'end_date',
            'end_time',
            'created_at',
            'updated_at'
        ]);

        $this->assertDatabaseHas('registrations', [
            'end_date' => '2021/08/08',
            'end_time' => '01:30'
        ]);
    }

    public function testUserCanNotListCourseRegistrations()
    {
        $response = $this->getJson("api/user/course-registrations");

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAdminCanListCourseRegistrations()
    {
        $response = $this->actingAs($this->admin, 'users')
            ->getJson("api/user/course-registrations");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testOrderListCourseRegistrationDefaultByIdDesc()
    {
        $count = rand(5, 20);

        factory(CourseRegistration::class, $count)->create([
            "start_time_id" => $this->startTime,
            "learning_hour_id" => $this->learningHour,
            "duration_id" => $this->duration,
            "course_id" => $this->course
        ]);

        $response = $this->actingAs($this->admin, 'users')
            ->getJson("api/user/course-registrations");

        $response->assertOk()->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'dob',
                    'address',
                    'phone',
                    'email',
                    'start_date',
                    'image',
                    'end_date',
                    'end_time',
                    'created_at',
                    'updated_at',
                    'start_time' => ['id', 'start_time'],
                    'learning_hour' => ['id', 'learning_hour'],
                    'duration' => ['id', 'month'],
                    'course' => ['id', 'title'],
                ]
            ],
            'last_page',
            'per_page',
            'total'
        ]);

        $body = json_decode($response->getContent(), true);

        $highestValue = 999999;
        foreach ($body['data'] as $data) {
            $this->assertTrue($data['id'] < $highestValue);
            $highestValue = $data['id'];
        }
    }

    public function testOrderListCourseRegistrationByIdAsc()
    {
        $count = rand(5, 20);

        factory(CourseRegistration::class, $count)->create([
            "start_time_id" => $this->startTime,
            "learning_hour_id" => $this->learningHour,
            "duration_id" => $this->duration,
            "course_id" => $this->course
        ]);

        $response = $this->actingAs($this->admin, 'users')
            ->json('GET', "api/user/course-registrations", [
                'orderBy' => 'id',
                'sortedBy' => 'asc'
            ]);

        $response->assertOk()->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'dob',
                    'address',
                    'phone',
                    'email',
                    'start_date',
                    'image',
                    'end_date',
                    'end_time',
                    'created_at',
                    'updated_at',
                    'start_time' => ['id', 'start_time'],
                    'learning_hour' => ['id', 'learning_hour'],
                    'duration' => ['id', 'month'],
                    'course' => ['id', 'title'],
                ]
            ],
            'last_page',
            'per_page',
            'total'
        ]);

        $body = json_decode($response->getContent(), true);

        $lowestValue = 0;
        foreach ($body['data'] as $data) {
            $this->assertTrue($data['id'] > $lowestValue);
            $lowestValue = $data['id'];
        }
    }

    public function testUserCanNotUpdateCourseRegistration()
    {
        $courseRegistration = factory(CourseRegistration::class)->create([
            "start_time_id" => $this->startTime,
            "learning_hour_id" => $this->learningHour,
            "duration_id" => $this->duration,
            "course_id" => $this->course
        ]);

        $response = $this->putJson("api/user/course-registrations/" . $courseRegistration->id, [
            "name" => "test",
            "dob" => "1996/09/19",
            "address" => "da nang",
            "phone" => "0935888888",
            "email" => "test@gmail.com",
            "start_date" => "2021/07/07",
            "start_time_id" => "22",
            "learning_hour_id" => "6",
            "duration_id" => "1",
            "course_id" => "1",
            "image" => $this->image
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAdminCanUpdateCourseRegistration()
    {
        $courseRegistration = factory(CourseRegistration::class)->create([
            "start_time_id" => $this->startTime,
            "learning_hour_id" => $this->learningHour,
            "duration_id" => $this->duration,
            "course_id" => $this->course
        ]);

        $response = $this
            ->actingAs($this->admin, 'users')
            ->putJson("api/user/course-registrations/" . $courseRegistration->id, [
                "name" => "test",
                "dob" => "1996/09/19",
                "address" => "da nang",
                "phone" => "0935888888",
                "email" => "test@gmail.com",
                "start_date" => "2021/07/07",
                "start_time_id" => $this->startTime->id,
                "learning_hour_id" => $this->learningHour->id,
                "duration_id" => $this->duration->id,
                "course_id" => $this->course->id,
                "image" => $this->image
            ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUserCanNotDeleteCourseRegistrations()
    {
        $courseRegistration = factory(CourseRegistration::class)->create([
            "start_time_id" => $this->startTime,
            "learning_hour_id" => $this->learningHour,
            "duration_id" => $this->duration,
            "course_id" => $this->course
        ]);

        $response = $this->deleteJson("api/user/course-registrations/" . $courseRegistration->id);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAdminCanDeleteCourseRegistrations()
    {
        $courseRegistration = factory(CourseRegistration::class)->create([
            "start_time_id" => $this->startTime,
            "learning_hour_id" => $this->learningHour,
            "duration_id" => $this->duration,
            "course_id" => $this->course
        ]);

        $response = $this->actingAs($this->admin, 'users')
            ->deleteJson("api/user/course-registrations/" . $courseRegistration->id);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAdminCanShowCourseRegistrations()
    {
        $courseRegistration = factory(CourseRegistration::class)->create([
            "start_time_id" => $this->startTime,
            "learning_hour_id" => $this->learningHour,
            "duration_id" => $this->duration,
            "course_id" => $this->course
        ]);

        $response = $this->actingAs($this->admin, 'users')
            ->getJson(
                "api/user/course-registrations/" . $courseRegistration->id,
                [
                    'Authorization' => true
                ]
            );

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUserCanNotShowCourseRegistrations()
    {
        $courseRegistration = factory(CourseRegistration::class)->create([
            "start_time_id" => $this->startTime,
            "learning_hour_id" => $this->learningHour,
            "duration_id" => $this->duration,
            "course_id" => $this->course
        ]);

        $response = $this->getJson("api/user/course-registrations/" . $courseRegistration->id);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUserCanShowCourseRegistrationsWithToken()
    {
        $courseRegistration = factory(CourseRegistration::class)->create([
            "start_time_id" => $this->startTime,
            "learning_hour_id" => $this->learningHour,
            "duration_id" => $this->duration,
            "course_id" => $this->course,
            'token' => 'token'
        ]);

        $response = $this->json("GET", "api/user/course-registrations/" . $courseRegistration->id, [
            'token' => 'token'
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
