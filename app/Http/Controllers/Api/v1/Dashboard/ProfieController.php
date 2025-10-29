<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\ProfileCreateRequest;
use App\Http\Requests\Api\V1\Dashboard\ProfileUpdateRequest;
use App\Http\Resources\Api\V1\UserProfileResource;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Request;

class ProfieController extends BaseApiController
{
    public function store(ProfileCreateRequest $request)
    {
       $user = auth()->user();
       $data = $request->validated();

       $profile_create =  $user->profile()->create($data);
        $profile = UserProfileResource::make($user->profile()->first());

       return $this->apiResponse(200 , 'success', [
           'profile' => $profile,
           'user' => UserResource::make($user),
       ]);


    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        $profile_create =  $user->profile()->update($data);
        $profile = UserProfileResource::make($user->profile()->first());

        return $this->apiResponse(200 , 'success', [
            'profile' => $profile,
            'user' => UserResource::make($user),
        ]);


    }

    public function show()
    {
   $user = auth()->user();
   $profile = UserProfileResource::make($user->profile()->first());
   return $this->apiResponse(200 , 'success', ['profile' => $profile]);

    }




}
