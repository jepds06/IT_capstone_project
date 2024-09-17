<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    protected $table = 'productOrders';
    protected $primaryKey = 'prodOrdID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'cstrOrderID',
        'productID',
        'quantity',
        'unitPrice',
    ];
}
