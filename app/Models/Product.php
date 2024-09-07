<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'product_name',
        'specifications',
        'unit_price',
        'prodCat_ID'
    ];
}
