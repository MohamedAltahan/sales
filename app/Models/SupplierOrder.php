<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrder extends Model
{
    protected $table = 'supplier_orders';
    protected $fillable = [
        'order_type', 'auto_serial', 'doc_no', 'order_date', 'supplier_code', 'is_approved',
        'com_code', 'bill_total_cost_before_discount', 'discount_type', 'discount_percent', 'discount_value', 'tax_percent',
        'tax_value', 'notes', 'bill_final_total_cost', 'item_total_price', 'account_number', 'account_balance', 'payment_type',
        'paid', 'remain', 'treasuries_transaction_id', 'balance_before', 'balance_after', 'added_by', 'created_at',
        'updated_at', 'updated_by', 'store_id',
    ];
}
