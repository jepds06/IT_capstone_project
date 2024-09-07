<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Category extends Model
{
    use HasFactory;
    
    protected $table = 'product_categories';
    protected $primaryKey = 'prodCat_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'description'
    ];
}
