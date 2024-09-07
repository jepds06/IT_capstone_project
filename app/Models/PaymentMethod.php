<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';
    protected $primaryKey = 'pay_mthd_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'pay_mthd_name'
    ];
}
