<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_ord_ID',
        'pay_mthd_ID',
        'amount_to_pay',
        'amount_paid',
        'due_date',
        'payment_status',
        'remarks'
    ];
}
