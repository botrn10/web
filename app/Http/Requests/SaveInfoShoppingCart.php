<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveInfoShoppingCart extends FormRequest
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
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'note' => 'max:50',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống!',
            'phone.required' => 'Số điện thoại không được để trống!',
            'address.required' => 'Địa chỉ được để trống!',
            'note.max' => 'Ghi chú tối đa 50 ký tự!',
        ];
    }
}
