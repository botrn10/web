<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressUser extends FormRequest
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
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'province_id.required' => 'Không được để trống!',
            'district_id.required' => 'Không được để trống!',
            'ward_id.required' => 'Không được để trống!',

        ];
    }
}
