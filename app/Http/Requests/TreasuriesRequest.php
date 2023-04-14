<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TreasuriesRequest extends FormRequest
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
            'is_master' => 'required',
            'last_bill_exchange' => 'required|integer|min:0',
            'last_bill_exchange' => 'required',
            'last_bill_collect' => 'required',
            'active' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الخزنة مطلوووب',
            'last_bill_exchange.required'  => 'الرقم مطلوب',
            'last_bill_collect.required'  => '   الرقم مطلوب',
            'last_bill_collect.required'  => '   الرقم مطلوب',
            'last_bill_collect.integer'  => '   الرقم مطلوب صحيح',
            'is_master.required'  =>  ' نوع الخزنه مطلوب',
            'active.required'  =>  ' حالة التفعيل مطلوبة'

        ];
    }
}//class end
