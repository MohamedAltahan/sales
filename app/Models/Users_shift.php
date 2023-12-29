<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_shift extends Model
{
    use HasFactory;

    protected $table = 'users_shifts';
    protected $fillable = [
        'users_shiftsID', 'user_id', 'treasury_id', 'shift_start_balance',
        'start_date', 'end_date', 'is_shift_finished', 'is_reviewed', 'receiver_id', 'receiving_shift_id',
        'receiving_treasury_id', 'money_should_received', 'money_real_received', 'money_state',
        'money_state_value', 'receiving_treasury_type', 'receiving_time', 'treasury_transactions_id',
        'added_by', 'updated_by', 'noted', 'com_code', 'updated_at', 'date', 'shift_code'
    ];
}
