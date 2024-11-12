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
        'prodOrdID',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'salesID');
    }

    public function productOrder()
    {
        return $this->belongsTo(ProductOrder::class, 'prodOrdID');
    }

    public function returnProdOrders()
    {
        return $this->hasMany(ReturnProdOrder::class, 'slsPrdOrdID');
    }
}
