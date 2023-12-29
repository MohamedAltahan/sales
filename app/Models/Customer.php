<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'name',  'account_number', 'start_balance', 'current_balance',
        'notes', 'added_by', 'updated_by', 'created_at', 'updated_at', 'active', 'com_code',
        'date', 'start_balance_status', 'address', 'city_id', 'customer_code'
    ];
}
