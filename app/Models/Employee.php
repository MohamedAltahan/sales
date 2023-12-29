<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $primaryKey = 'employeeId';
    protected $table = 'employees';
    protected $fillable = [
        'address',  'start_balance_status', 'transaction_type', 'employeeId', 'name', 'current_balance', 'notes', 'created_at', 'updated_at', 'date', 'com_code'
    ];
}
