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
//    public function toArray(Request $request): array
//    {
//        return [
//            'slug' => $this->slug ,
//            'name' => $this->name,
//
//            // ✅ نمایش والد در صورت لود شدن
//            'parent' => $this->whenLoaded('parent', function () {
//                return [
//                    'slug' => $this->slug,
//                    'name' => $this->parent->name,
//
//                ];
//            }),
//
//            // ✅ نمایش فرزندان در صورت لود شدن
//            'children' => $this->whenLoaded('children', function () {
//                return self::collection($this->children);
//            }),
//        ];
//    }


    public function toArray($request)
    {
        return [
            'name'  => $this->name,
            'slug'  => $this->slug,
            'icon'  => $this->icon,

            // تعداد محصول
            'products_count' => $this->when(isset($this->courses), function () {
                return  count($this->courses) ;
            }),

            // Parent
            'parent' => $this->whenLoaded('parent', function () {
                return [
                    'name'            => $this->parent->name,
                    'slug'            => $this->parent->slug,
                    'icon'  => $this->parent->icon,
                    'products_count'  =>  count($this->parent->courses)  ?? null,
                ];
            }),

            // children
            'children' => $this->whenLoaded('children', function () {
                return CategoryResource::collection($this->children);
            }),

            // childrenRecursive
            'children_recursive' => $this->whenLoaded('childrenRecursive', function () {
                return CategoryResource::collection($this->childrenRecursive);
            }),
        ];
    }




}
