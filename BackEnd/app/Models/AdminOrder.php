<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_ID',
        'supp_matrl_ID',
        'qty_ordered',
        'amount'
    ];
}
