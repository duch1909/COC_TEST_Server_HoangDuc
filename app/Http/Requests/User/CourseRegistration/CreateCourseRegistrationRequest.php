<?php

namespace App\Http\Requests\User\CourseRegistration;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => [
                'required',
                'image',
                'mimes:png,jpg',
                'max:4096'
            ],
            'name' => [
                'required',
                'string',
                'max:50'
            ],
            'dob' => [
                'required',
                'date',
                'date_format:Y/m/d'
            ],
            'address' => [
                'required',
                'string'
            ],
            'phone' => [
                'required',
                new Phone
            ],
            'email' => [
                'required',
                'email'
            ],
            'start_date' => [
                'required',
                'date',
                'date_format:Y/m/d'
            ],
            'start_time_id' => [
                'required',
                'exists:start_times,id'
            ],
            'learning_hour_id' => [
                'required',
                'exists:learning_hours,id'
            ],
            'duration_id' => [
                'required',
                'exists:durations,id'
            ],
            'course_id' => [
                'required',
                'exists:courses,id'
            ]
        ];
    }
}
