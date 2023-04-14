<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasuries_delivery extends Model
{
    use HasFactory;
    protected $table = 'treasuries_delivery';
    protected $fillable = [
        'id ', 'treasuries_id', 'treasuries_tobe_delivered_id',
        'added_by', 'created_at', 'updated_at', 'updated_by', 'com_code'
    ];
}
