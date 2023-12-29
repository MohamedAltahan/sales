<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'primary_retail_price' => 'required',
            'primary_unit_id' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الصنف مطلوب',
            'primary_retail_price.required' =>  ' السعر قطاعي للوحده الاساسية مطلوب ',
            'primary_unit_id.required'  =>  '   الوحدة الاساسية مطلوبة',

        ];
    }
}
