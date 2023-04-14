<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Add_treasuries_deliveryRequest extends FormRequest
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
            'treasuries_tobe_delivered_id' => 'required',

        ];
    }

    public function messages()
    {
        return [

            'treasuries_tobe_delivered_id.required' => 'اسم الخزنة الفرعية مطلوب',


        ];
    }
}//class end
