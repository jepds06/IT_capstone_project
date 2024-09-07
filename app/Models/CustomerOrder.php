<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $table = 'customer_orders';
    protected $primaryKey = 'cstr_order_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'customer_ID',
        'order_date',
        'order_status',
        'order_remarks'
    ];
}
