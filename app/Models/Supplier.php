<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = [
        'supplier_parent_account_number', 'name', 'account_number', 'start_balance', 'current_balance',
        'notes', 'added_by', 'updated_by', 'created_at', 'updated_at', 'active', 'com_code',
        'date', 'start_balance_status', 'address', 'city_id', 'supplier_code', 'supplier_type_id'
    ];
}
