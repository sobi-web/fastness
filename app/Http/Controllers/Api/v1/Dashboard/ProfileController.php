<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\ProfileCreateRequest;
use App\Http\Requests\Api\V1\Dashboard\ProfileUpdateRequest;
use App\Http\Resources\Api\V1\Dashboards\UserProfileResource;
use App\Http\Resources\Api\V1\Dashboards\UserResource;
use App\Http\Traits\Api\V1\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProfileController extends Controller
{
    use ApiResponse;

    public function store(ProfileCreateRequest $request)
    {
        try {


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


            return $this->successResponse(
                [
                    'profile' => $profile,
                    'user' => UserResource::make($user)]
            );


        } catch (ModelNotFoundException $e) {
            // رکورد پیدا نشد → 404
            return $this->errorResponse($e->getMessage(), 'رکورد مورد نظر یافت نشد', 404);

        } catch (QueryException $e) {
            // خطاهای دیتابیس
            \Log::error('DB Error in ProfileController@store: ' . $e->getMessage());

            return $this->errorResponse($e->getMessage(), 'Error', 500);

        } catch (Throwable $e) {
            // هر خطای غیرمنتظره
            \Log::error('Error in ProfileController@store: ' . $e->getMessage());
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }

    }

    public function update(ProfileUpdateRequest $request)
    {
        try {


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


            $profile_create = $user->profile()->update($data);
            $profile_updated = UserProfileResource::make($user->profile()->first());


            return $this->successResponse(
                [
                    'profile' => $profile_updated,
                    'user' => UserResource::make($user),
                ]
            );

        } catch (ModelNotFoundException $e) {
            // رکورد پیدا نشد → 404
            return $this->errorResponse($e->getMessage(), 'رکورد مورد نظر یافت نشد', 404);

        } catch (QueryException $e) {
            // خطاهای دیتابیس
            \Log::error('DB Error in ProfileController@update: ' . $e->getMessage());
            return $this->errorResponse($e->getMessage(), 'Error', 500);

        } catch (Throwable $e) {
            // هر خطای غیرمنتظره
            \Log::error('Error in ProfileController@update: ' . $e->getMessage());
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }

    }

    public function show()
    {
        try {


            $user = auth()->user();
            $profile = UserProfileResource::make($user->profile()->first());
            return $this->successResponse($profile);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), $e->getMessage(), 404);
        } catch (QueryException $e) {
            \Log::error('DB Error in ProfileController@show: ' . $e->getMessage());
            return $this->errorResponse($e->getMessage(), 'Error', 500);

        } catch (Throwable $e) {
            \Log::error('Error in ProfileController@show: ' . $e->getMessage());
            return $this->errorResponse($e->getMessage(), 'Error', 500);

        }

    }


}
