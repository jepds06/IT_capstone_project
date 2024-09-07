<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesProductOrder extends Model
{
    use HasFactory;

    protected $table = 'sales_product_orders';
    protected $primaryKey = 'sls_prd_ord_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'sales_ID',
        'prd_ord_ID',
    ];
}
