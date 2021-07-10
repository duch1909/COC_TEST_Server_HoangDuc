<?php

namespace App\Http\Resources\Duration;

use Illuminate\Http\Resources\Json\JsonResource;

class DurationResource extends JsonResource
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
            'month'
        ]);
    }
}
