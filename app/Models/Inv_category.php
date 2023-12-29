<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_category extends Model
{
    use HasFactory;
    protected $table = 'inv_categories';
    protected $fillable = [
        'name', 'date',
        'added_by', 'created_at', 'updated_at', 'updated_by', 'com_code', 'active'
    ];
}
