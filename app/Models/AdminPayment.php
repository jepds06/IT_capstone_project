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

    protected $fillable = [
        'adminOrdID',
        'payMethodID',
        'amountToPay',
        'amountPaid',
        'dueDate',
        'paymentStatus',
        'remarks'
    ];
}
