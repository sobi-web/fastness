<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'full_name' => $this->full_name,
            "job_title" => $this->job_title,
            "birth_date" => $this->birth_date,
            "gender" => $this->gender ,
            "avatar_url" =>$this->avatar_url ,
            "bio" => $this->bio ,
            "created_at" => $this->created_at,


        ];
    }


}
