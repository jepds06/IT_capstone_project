<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierMaterial extends Model
{
    use HasFactory;

    protected $table = 'supplierMaterials';
    protected $primaryKey = 'suppMatrlID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable =[
        'supplierID',
        'materialID',
        'unitPrice'
    ];

    protected $casts = [
        'unitPrice' => 'decimal:2'
    ];

    //eloquent/relationship between suppliers & supplierMaterials
    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplierID');
    }

    //eloquent/relationship between materials & supplierMaterials
    public function material()
    {
        return $this->belongsTo(Material::class,'materialID');
    }
}
