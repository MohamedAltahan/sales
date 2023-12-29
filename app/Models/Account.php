<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';
    protected $fillable = [
        'name', 'account_type_id', 'primary_account_number', 'account_number', 'start_balance', 'current_balance',
        'other_table_fk', 'notes', 'added_by', 'updated_by', 'created_at', 'updated_at', 'active', 'com_code',
        'date', 'is_primary', 'start_balance_status'
    ];
}
