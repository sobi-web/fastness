<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Api\V1\Dashboard\ProfileCreateRequest;
use App\Http\Requests\Api\V1\Dashboard\ProfileUpdateRequest;
use App\Http\Resources\Api\V1\Dashboards\UserProfileResource;
use App\Http\Resources\Api\V1\Dashboards\UserResource;
use Illuminate\Support\Facades\Storage;

class ProfieController extends BaseApiController
{
    public function store(ProfileCreateRequest $request)
    {
       $user = auth()->user();
       $data = $request->validated();


        if ($request->hasFile('avatar_url')) {

            $originalName = preg_replace('/\s+/', '_', $request->file('avatar_url')->getClientOriginalName());
            $fileName = now()->format('Y-m-d_His') . '_' . $originalName;

            $data['avatar_url'] = $request->file('avatar_url')->storeAs(
                "users/{$user->id}/avatars",
                $fileName,
                'public'
            );
        }


        $profile = $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

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
       $profile = $user->profile()->first();

        if ($request->hasFile('avatar_url')) {
            if (
                isset($profile) &&
                $profile->avatar_url &&
                Storage::disk('public')->exists($profile->avatar_url)
            ) {
                Storage::disk('public')->delete($profile->avatar_url);
            }

            $originalName = preg_replace('/\s+/', '_', $request->file('avatar_url')->getClientOriginalName());
            $fileName = now()->format('Y-m-d_His') . '_' . $originalName;

            $data['avatar_url'] = $request->file('avatar_url')->storeAs(
                "users/{$user->id}/avatars",
                $fileName,
                'public'
            );
        }



        $profile_create =  $user->profile()->update($data);
        $profile_updated = UserProfileResource::make($user->profile()->first());

        return $this->apiResponse(200 , 'success', [
            'profile' => $profile_updated,
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
