<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_date',
        'sls_POdr_ID',
        'pay_mthd_ID',
        'payment_status',
        'due_date',
        'amount_to_pay',
        'amount_paid'
    ];
}
