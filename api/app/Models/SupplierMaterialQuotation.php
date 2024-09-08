<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierMaterialQuotation extends Model
{
    use HasFactory;

    protected $fillable =[
        'quotation_ID',
        'supp_matrl_ID',
        'quantity',
        'quotation_price'
    ];
}
