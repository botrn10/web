<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewPassword extends FormRequest
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
    public function rules(): array
    {
        return [
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Mật khẩu không được để trống!',
            'password_confirmation.required' => 'Mật khẩu xác nhận không được để trống!',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp!',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự!',

        ];
    }
}
