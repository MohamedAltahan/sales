<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasuries extends Model
{
    use HasFactory;
    protected $table = 'treasuries';
    protected $fillable = [
        'name', 'is_master', 'last_bill_exchange', 'last_bill_collect', 'date',
        'added_by', 'created_at', 'updated_at', 'updated_by', 'com_code', 'active'
    ];
}
