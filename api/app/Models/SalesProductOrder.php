<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesProductOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_ID',
        'prd_ord_ID',
    ];
}
