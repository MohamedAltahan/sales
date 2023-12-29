<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;
    protected $table = 'transactions_details';
    protected $fillable = [
        'id', 'transaction_type', 'user_id', 'transaction_value', 'created_at', 'udated_at'
    ];
}
