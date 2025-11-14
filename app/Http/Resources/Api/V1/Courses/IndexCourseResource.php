<?php

namespace App\Http\Resources\Api\V1\Courses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
           'name' => $this->name ,
           'slug' => $this->slug ,
           'description' => $this->description ,
           'price' => number_format($this->price ) . ' '. 'تومان',
           'created_at' =>$this->created_at->diffForHumans() ,
           'media'  => CourseMediaResourse::collection($this->whenLoaded('media')),
           'categories' => CategoryResource::collection($this->whenLoaded('categories')),
           ];
    }
}
