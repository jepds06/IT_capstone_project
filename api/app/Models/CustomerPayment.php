<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $table = 'customerPayments';
    protected $primaryKey = 'cstrPayID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'paymentDate',
        'slsPrdOrdID',
        'payMethodID',
        'paymentStatus',
        'dueDate',
        'amountToPay',
        'amountPaid'
    ];

    public function slsPrdOrder()
    {
        return $this->belongsTo(SalesProductOrder::class, 'slsPrdOrdID');
    }

    public function payMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payMethodID');
    }
}
