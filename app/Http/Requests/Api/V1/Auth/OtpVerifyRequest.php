<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Rules\Api\V1\Mobile;
use App\Rules\Api\V1\OtpNotExpired;
use App\Rules\Api\V1\ValidOtpFlow;
use Illuminate\Foundation\Http\FormRequest;

class OtpVerifyRequest extends FormRequest
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
            'code' =>  ['required', 'string' , 'digits:6'],
            'flow_token' => ['required' , 'uuid'] ,
        ];
    }
    public function messages(): array
    {
        return [
            'otp.string' => __('otp.code_format_invalid'),
            'otp.required' => __('otp.code_required'),
            'otp.digits' => __('otp.code_format_invalid') , 
        ];
    }
}
