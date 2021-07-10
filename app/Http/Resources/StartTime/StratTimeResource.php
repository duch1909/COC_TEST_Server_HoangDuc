<?php

namespace App\Http\Resources\StartTime;

use Illuminate\Http\Resources\Json\JsonResource;

class StratTimeResource extends JsonResource
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
            'start_time'
        ]);
    }
}
