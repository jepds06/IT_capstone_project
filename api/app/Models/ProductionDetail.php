<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionDetail extends Model
{
    use HasFactory;

    protected $table = 'productionDetails';
    protected $primaryKey = 'prodtnDetailID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'productionID',
        'productID',
        'quantity',
        'status',
        'remarks'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }

    public function production()
    {
        return $this->belongsTo(Production::class, 'productionID');
    }

    public function productionMaterials()
    {
        return $this->hasMany(ProductionMaterial::class, 'prodtnDetailID');
    }

    public function productMaterials()
    {
        return $this->belongsToMany(ProductMaterial::class, 'productionMaterials', 'productMatsID', 'prodtnDetailID');
    }

    public function finishedProducts()
    {
        return $this->hasMany(FinishedProduct::class, 'prodtnDetailID');
    }
}
