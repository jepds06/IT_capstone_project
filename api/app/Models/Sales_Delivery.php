<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_Delivery extends Model
{
    use HasFactory;

    protected $table = 'salesDeliveries';
    protected $primaryKey = 'deliveryID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'salesID',
        'deliveryDate',
        'deliveryAddress',
        'deliveryStatus'
    ];
}
