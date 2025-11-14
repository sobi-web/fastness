<?php

namespace App\Http\Resources\Api\V1\Courses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug ,
            'name' => $this->name,

            // ✅ نمایش والد در صورت لود شدن
            'parent' => $this->whenLoaded('parent', function () {
                return [
                    'slug' => $this->slug,
                    'name' => $this->parent->name,

                ];
            }),

            // ✅ نمایش فرزندان در صورت لود شدن
            'children' => $this->whenLoaded('children', function () {
                return self::collection($this->children);
            }),
        ];
    }
}
