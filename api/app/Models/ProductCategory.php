<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    
    protected $table = 'productCategories';
    protected $primaryKey = 'prodCatID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'description'
    ];

    public function products()
    {
        return $this->hasMany(Product::class,'prodCatId');
    }
}
