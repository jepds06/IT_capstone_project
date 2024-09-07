<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_Delivery extends Model
{
    use HasFactory;

    protected $table = 'sales_deliveries';
    protected $primaryKey = 'delivery_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'sales_ID',
        'delivery_date',
        'delivery_address',
        'delivery_status'
    ];
}
