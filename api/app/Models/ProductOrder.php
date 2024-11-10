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
    public $timestamps = false;

    protected $fillable = [
        'cstrOrderID',
        'productID',
        'quantity',
        'unitPrice',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }

    public function customerOrder()
    {
        return $this->belongsTo(CustomerOrder::class, 'cstrOrderID');
    }

    public function slsProdOrders()
    {
        return $this->hasMany(SalesProductOrder::class, 'prodOrdID');
    }
}
