<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|unique:categories,name,'.$this->id.'|max:50|min:5',
            'description' => 'required|max:50|min:5',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Tên danh mục đã tồn tại!',
            'name.min' => 'Tên tối thiểu 5 ký tự!',
            'name.max' => 'Tên tối đa 50 ký tự!',
            'name.required' => 'Tên danh mục không được để trống!',
            'description.required' => 'Mô tả không được để trống!',
            'description.max' => 'Mô tả tối đa 50 ký tự!',
            'description.min' => 'Mô tả tối thiểu 5 ký tự!',
        ];
    }
}
