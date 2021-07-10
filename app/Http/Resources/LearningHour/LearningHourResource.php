<?php

namespace App\Http\Resources\LearningHour;

use Illuminate\Http\Resources\Json\JsonResource;

class LearningHourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->only([
            'id',
            'learning_hour'
        ]);
    }
}
