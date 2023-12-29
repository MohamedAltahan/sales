<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasuries_transaction extends Model
{
    use HasFactory;
    protected $table = 'treasuries_transactions';
    protected $fillable = [
        'treasuries_transactionsID', 'treasury_id', 'transaction_type', 'fk', 'account_number', 'account_or_treasury',
        'is_approved', 'shift_code', 'transaction_money_value', 'current_account_balance', 'note', 'created_at',
        'added_by', 'bill_number', 'updated_at', 'auto_serial', 'transaction_date', 'updated_by', 'com_code'
    ];
}
