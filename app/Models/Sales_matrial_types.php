<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_matrial_types extends Model
{
    use HasFactory;
    protected $table = 'sales_material_types';
    protected $fillable = [
        'name',  'date',
        'added_by', 'created_at', 'updated_at', 'updated_by', 'com_code', 'active'
    ];
}
