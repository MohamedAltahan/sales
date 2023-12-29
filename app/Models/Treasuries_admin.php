<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasuries_admin extends Model
{
    use HasFactory;
    protected $table = 'treasuries_admins';
    protected $fillable = [
        'treasuries_admins_id', 'admin_id', 'treasury_id',
        'active', 'added_by', 'updated_by',
        'created_at', 'updated_at', 'com_code', 'date',
    ];
}
