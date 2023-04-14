<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $fillable = [
        'name', 'phone', 'address',  'date',
        'added_by', 'created_at', 'updated_at', 'updated_by', 'com_code', 'active'
    ];
}
