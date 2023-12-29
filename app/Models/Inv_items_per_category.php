<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_items_per_category extends Model
{
    use HasFactory;
    protected $table = 'inv_items_per_category';
    protected $fillable = [
        'item_stock_type', 'id', 'name', 'item_type', 'inv_category_id', 'item_code', 'primary_item_id', 'has_retailunit', 'retail_unit_id',
        'primary_unit_id', 'units_per_parent', 'added_by', 'updated_by', 'created_at', 'updated_at', 'active', 'date', 'com_code', 'barcode', 'primary_retail_price', 'primary_half_wholesale_price', 'primary_wholesale_price', 'secondary_retail_price',
        'secondary_half_wholesale_price', 'secondary_wholesale_price', 'primary_cost', 'secondary_cost', 'has_fixed_price',
        'stock_quantity', 'chassisName', 'retail_quantity', 'primary_and_retial_quantity', 'photo', 'length', 'width', 'chassisPrice'
    ];
}
