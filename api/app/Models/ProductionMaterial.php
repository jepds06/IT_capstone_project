<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMaterial extends Model
{
    use HasFactory;

    protected $table = 'productionMaterials';
    protected $primaryKey = 'prodtnMtrlID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'prodtnDetailID',
        'productMatsID',
        'qtyNeeded',
        'status'
    ];

    public function productMaterial()
    {
        return $this->belongsTo(ProductMaterial::class, 'productMatsID');
    }

    public function productionDetail()
    {
        return $this->belongsTo(ProductionDetail::class, 'prodtnDetailID');
    }

    public function adminOrderDetail()
    {
        return $this->hasMany(AdminOrderDetail::class, 'prodtnMtrlID');
    }
}
