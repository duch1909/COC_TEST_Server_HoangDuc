<?php

namespace App\Http\Resources\CourseRegistration;

use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Duration\DurationResource;
use App\Http\Resources\LearningHour\LearningHourResource;
use App\Http\Resources\StartTime\StratTimeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseRegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = $this->resource->only([
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

        $result['start_time'] = new StratTimeResource($this->whenLoaded('startTime'));
        $result['learning_hour'] = new LearningHourResource($this->whenLoaded('learningHour'));
        $result['duration'] = new DurationResource($this->whenLoaded('duration'));
        $result['course'] = new CourseResource($this->whenLoaded('course'));

        return $result;
    }
}
