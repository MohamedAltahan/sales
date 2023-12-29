<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    use HasFactory;
    protected $table = 'salesinvoices';
    protected $fillable = [
        'what_old_paid', 'id', 'is_approved', 'sales_matrial_types', 'sales_invoice_id', 'invoice_date', 'is_has_customer', 'customer_id',
        'com_code',
        'notes',  'total_cost_items',
        'total_befor_discount', 'final_total_cost', 'account_number', 'what_paid', 'what_remain',
        'treasuries_transactions_id', 'added_by', 'created_at', 'updated_at',
        'updated_by', 'approved_by', 'date', 'sales_item_type', 'invoice_total_price_with_old', 'old_remain'
    ];
}
