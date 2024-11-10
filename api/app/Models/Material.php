<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';
    protected $primaryKey = 'materialID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'description',
        'specification',
        'brand',
        'unitOfMeasure'
    ];

    //eloquent/relationship between materials & productMaterials
    public function productMaterials()
    {
        return $this->hasMany(ProductMaterial::class, 'materialID');
    }

    //eloquent/relationship between materials & supplierMaterials
    public function supplierMaterials()
    {
        return $this->hasMany(SupplierMaterial::class, 'materialID');
    }

    // Optionally, if you need to get the products associated with this material directly:
    public function products()
    {
        return $this->belongsToMany(Product::class, 'productMaterials', 'materialID', 'productID');
    }

    public function quotationDetails()
    {
        return $this->hasMany(QuotationDetail::class, 'materialID');
    }
}
