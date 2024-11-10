<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPayment extends Model
{
    use HasFactory;

    protected $table = 'adminPayments';
    protected $primaryKey = 'adminPayID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'adminOrdID',
        'payMethodID',
        'paymentDate',
        'amountToPay',
        'amountPaid',
        'paymentStatus',
        'remarks'
    ];

    public function adminOrder()
    {
        return $this->belongsTo(AdminOrder::class, 'adminOrdID');
    }

    // Relationship with the PaymentMethod model
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payMethodID');
    }
}
