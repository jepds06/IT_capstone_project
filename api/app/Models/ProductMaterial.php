<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaterial extends Model
{
    use HasFactory;

    protected $table = 'productMaterials';
    protected $primaryKey = 'productMatsID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'productID',
        'materialID',
        'quantity'
    ];

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'materialID');
    }

    public function productionMaterials()
    {
        return $this->hasMany(ProductionMaterial::class, 'productMatsID');
    }

    // Optionally, if you need to get the products associated with this material directly:
    public function productDetails()
    {
        return $this->belongsToMany(ProductionDetail::class, 'productionMaterials', 'productMatsID', 'prodtnDetailID');
    }
}
