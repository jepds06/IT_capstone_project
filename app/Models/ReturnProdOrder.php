<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnProdOrder extends Model
{
    use HasFactory;

    protected $table = 'return_prod_orders';
    protected $primaryKey = 'return_prd_ord_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'sls_prd_ord_ID',
        'return_date',
        'qty_returned',
        'reason',
        'refund_amount'
    ];
}
