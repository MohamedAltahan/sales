<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'sales_invoice_details';
    protected $fillable = [
        'item_serial', 'what_paid', 'what_remain', 'customer_id', 'sales_invoice_id', 'sales_invoices_auto_serial', 'item_type',
        'item_code', 'unit_id', 'quantity', 'total_unit_price', 'invoice_total_price', 'com_code', 'invoice_date', 'added_by',
        'items_serial', 'created_at', 'updated_by', 'updated_at', 'date', 'old_remain', 'chassisWidthValue', 'unit_price', 'invoice_total_price_with_old'
    ];
}
