<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_ID',
        'material_ID',
        'quantity'
    ];
}
