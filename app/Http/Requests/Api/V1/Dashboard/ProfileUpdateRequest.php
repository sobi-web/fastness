<?php

namespace App\Http\Requests\Api\V1\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */



    public function rules(): array
    {
        return [
            'full_name' => [ 'string' , 'max:255' , 'min:5'],
            'birth_date' =>     [ 'date'],
            'gender' =>     [ 'string' ],
            'job_title' =>  ['string' , 'nullable'] ,
            'avatar_url' => ['nullable', 'string' , 'url'],
            'bio' => ['nullable', 'string' , 'min:15'],


        ];
    }
    public function messages(): array {
        return [
            'full_name.required' => __('ProfileRequest.full_name.required'),
            'full_name.min' => __('ProfileRequest.full_name.min'),
            'full_name.max' => __('ProfileRequest.full_name.max'),
            'birth_date.required' => __('ProfileRequest.birth_date.required'),
            'birth_date.date' => __('ProfileRequest.birth_date.date'),
            'birth_date.date_format' => __('ProfileRequest.birth_date.date_format'),
            'gender.required' => __('ProfileRequest.gender.required'),
            'gender.min' => __('ProfileRequest.gender.min'),
            'gender.max' => __('ProfileRequest.gender.max'),
            'job_title.required' => __('ProfileRequest.job_title.required'),
            'job_title.min' => __('ProfileRequest.job_title.min'),
            'job_title.max' => __('ProfileRequest.job_title.max'),
            'avatar_url.nullable' => __('ProfileRequest.avatar_url.nullable'),
            'avatar_url.url' => __('ProfileRequest.avatar_url.url'),
            'bio.required' => __('ProfileRequest.bio.required'),
            'bio.min' => __('ProfileRequest.bio.min'),

        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
