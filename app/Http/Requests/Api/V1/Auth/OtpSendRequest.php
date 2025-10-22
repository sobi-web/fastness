<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Rules\Api\V1\Mobile;
use Illuminate\Foundation\Http\FormRequest;

class OtpSendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
//            'otp' =>  ['required', 'string' , 'size:6'],
            'phone' => ['required', 'string', new Mobile() ],
        ];
    }
    public function messages(): array {
        return [
            'phone.required' => __('otp.phone_number_required'),
            'phone.' . Mobile::class => __('otp.invalid_phone_number'),
//            'phone.required' => ('otp.phone_number_required'),
//            'phone.' . Mobile::class => ('otp.invalid_phone_number'),
        ];
    }
}
