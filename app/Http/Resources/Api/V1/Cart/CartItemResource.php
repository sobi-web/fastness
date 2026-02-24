<?php

namespace App\Http\Resources\Api\V1\Cart;

use App\Http\Resources\Api\V1\Courses\ShowCourseResourse;
use App\Models\Shop\Course\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $item = Course::find($this->course_id);
        $media = $item->media()->where('type', 'image')->first();
        return [
            'id' => $this->id,
            'type' => 'course',


            'course' => [
                'title' => $item->name,
                'slug' => $item->slug,
                'category' => $item->category ? [
                    'name' => $item->category->name,
                    'slug' => $item->category->slug,
                ] : null,
                'media' => $media ? [
                    'name' => $media->name,
                    'slug' => $media->path,
                    'type' => $media->type,

                ] : null
            ],
            'price' => [
                'unit_price' => number_format((int)$this->unit_price),
                'discount_amount' => number_format((int)$this->discount_amount),
                'final_price' => number_format((int)$this->final_price),
            ],

        ];
    }
}
