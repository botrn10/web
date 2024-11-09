<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|unique:users,name,' .$this->id,
            'email' => 'required|unique:users,email,' .$this->id,
            'phone' => 'required',
            'password' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống!',
            'name.unique' => 'Tên đã tồn tại!',
            'email.unique' => 'Email đã tồn tại!',
            'email.required' => 'Email không được để trống!',
            'phone.required' => 'Số điện thoại không được để trống!',
            'password.required' => 'Mật khẩu thoại không được để trống!',
            'province_id.required' => 'Không được để trống!',
            'district_id.required' => 'Không được để trống!',
            'ward_id.required' => 'Không được để trống!',

        ];
    }
}
