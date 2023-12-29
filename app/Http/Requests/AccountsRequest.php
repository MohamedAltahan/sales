<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountsRequest extends FormRequest
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
            'account_type_id' => 'required',
            'primary_accounts' => 'required_if:is_primary,0',
            'start_balance' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الحساب مطلوب',
            'account_type_id.required'  =>  '  نوع الحساب مطلوب',
            'primary_accounts.required_if'  =>  '  الحساب الاساسي مطلوب   ',
            'start_balance.required' =>  '   الرصيد الابتدائي مطلوب '


        ];
    }
}
