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

    public $timestamps = false;
    
    public function prdCategory()
    {
        return $this->belongsTo(ProductCategory::class,'prodCatID');
    }

    public function productMaterials()
    {
        return $this->hasMany(ProductMaterial::class, 'productID');
    }

     /**
     * Get the materials associated with the product directly.
     */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'productmaterials', 'productID', 'materialID');
    }
}
