<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierMaterial extends Model
{
    use HasFactory;

    protected $fillable =[
        'supplier_ID',
        'material_ID',
        'unit_price',
    ];
}
