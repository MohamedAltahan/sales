<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_type extends Model
{
    protected $table = 'supplier_types';
    protected $fillable = [
        'name',  'date',
        'added_by', 'created_at', 'updated_at', 'updated_by', 'com_code', 'active'
    ];
}
