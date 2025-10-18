<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
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
            'otp' =>  ['required', 'string' , 'size:6'],
        ];
    }
    public function messages(): array {
        return [
            'otp.required' => 'وارد کردن کد تایید اجیاری است',
            'otp.size' => 'کد تایید باید ۶ رقم باشد' ,
        ];
    }
}
