<?php

namespace App\Http\Resources\Api\V1\Courses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseMediaResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type ,
            'url' => $this->path ,
            'name' => $this->name
        ] ;
    }
}
