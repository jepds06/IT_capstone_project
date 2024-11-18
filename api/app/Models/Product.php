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
    public $timestamps = false;

    protected $fillable = [
        'productName',
        'specifications',
        'unitPrice',
        'imagePath',
        'prodCatID'
    ];
    
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
        return $this->belongsToMany(Material::class, 'productMaterials', 'productID', 'materialID');
    }

    public function productionDetails()
    {
        return $this->hasMany(ProductionDetail::class, 'productID');
    }

    public function salesOrder()
    {
        return $this->hasMany(SalesProductOrder::class, 'productID');
    }
}
