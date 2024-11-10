<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnProdOrder extends Model
{
    use HasFactory;

    protected $table = 'returnProdOrders';
    protected $primaryKey = 'returnPrdOrdID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'slsPrdOrdID',
        'returnDate',
        'qtyReturned',
        'reason',
        'refundAmount'
    ];
}
