<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesProductOrder extends Model
{
    use HasFactory;

    protected $table = 'salesProductOrders';
    protected $primaryKey = 'slsPrdOrdID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'salesID',
        'productID',
        'qtyOrdered',
        'amount'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'salesID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }
}
