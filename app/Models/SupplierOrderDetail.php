<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'supplier_order_details';
    protected $fillable = [
        'id', 'supplier_orders_serial', 'order_type', 'com_code', 'received_quantity',
        'unit_id', 'unit_price', 'is_parent_unit', 'unit_total_price', 'order_date',
        'added_by', 'created_at', 'updated_by', 'updated_at', 'item_code', 'batch_id', 'expire_date',
        'production_date', 'item_type',

    ];
}
