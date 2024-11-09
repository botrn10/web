<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
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
            'name' => 'required|unique:menus,name,'.$this->id,
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Tên đã tồn tại!',
            'name.required' => 'Tên không được để trống!',
        ];
    }
}
