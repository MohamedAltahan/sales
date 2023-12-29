<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_type extends Model
{
    use HasFactory;
    protected $table = 'transaction_types';
    protected $fillable = [
        'transaction_typesID', 'transaction_name', 'active', 'in_screen', 'is_private_internal'
    ];
}
