<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    protected $table = 'product_orders';
    protected $primaryKey = 'prod_ord_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'cstr_order_ID',
        'product_ID',
        'quantity',
        'unit_price',
    ];
}
