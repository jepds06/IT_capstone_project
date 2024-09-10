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
        'unitPrice',
    ];
}
