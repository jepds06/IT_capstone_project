<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOrder extends Model
{
    use HasFactory;

    protected $table = 'admin_orders';
    protected $primaryKey = 'admin_ord_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'admin_ID',
        'supp_matrl_ID',
        'qty_ordered',
        'amount'
    ];
}
