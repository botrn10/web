<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'code'  => 'required|min:8|max:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống',
            'code.required'  => 'OTP không được để trống',
            'code.min'       => 'OTP có 8 ký tự',
            'code.max'       => 'OTP có 8 ký tự',
        ];
    }
}
