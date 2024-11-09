<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|unique:products,name,' . $this->id . "|max:50|min:15",
            'description' => 'required|max:255|min:20',
            'category_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
            'price' => 'required|numeric|min:10000|max:10000000',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Tên sản phẩm đã tồn tại!',
            'name.min' => 'Tên sản phẩm tối thiểu 15 ký tự!',
            'name.max' => 'Tên sản phẩm tối đa 50 ký tự!',
            'name.required' => 'Tên sản phẩm không được để trống!',
            'category_id.required' => 'Danh mục không được để trống!',
            'description.required' => 'Mô tả không được để trống!',
            'description.max' => 'Mô tả tối đa 255 ký tự!',
            'description.min' => 'Mô tả tối thiểu 20 ký tự!',
            'province_id.required' => 'Không được để trống!',
            'district_id.required' => 'Không được để trống!',
            'ward_id.required' => 'Không được để trống!',
            'price.required' => 'Giá sản phẩm được để trống!',
            'price.min' => 'Giá sản phẩm phải lớn hơn 10.000 VNĐ!',
            'price.max' => 'Giá sản phẩm phải nhỏ hơn 10.000.000 VNĐ!',
        ];
    }
}
