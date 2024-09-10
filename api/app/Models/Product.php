<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'productID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'productName',
        'specifications',
        'unitPrice',
        'prodCatID'
    ];
}
