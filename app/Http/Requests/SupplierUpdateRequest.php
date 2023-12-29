<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'supplier_type_id' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم العميل مطلوب',
            'supplier_type_id.required' => 'نوع المورد مطلوب'


        ];
    }
}
