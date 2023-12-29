<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Exchange_transactionRequest extends FormRequest
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
            'transaction_date' => 'required',
            'account_number' => 'required',
            'transaction_money_value' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'transaction_date.required' => 'تاريخ المعاملة مطلوب',
            'account_number.required'  =>  ' رقم الحساب مطلوب  ',
            'transaction_money_value.required'  =>  ' المبلغ المصروف مطلوب ',

        ];
    }
}
