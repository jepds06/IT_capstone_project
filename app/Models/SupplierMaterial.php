<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierMaterial extends Model
{
    use HasFactory;

    protected $table = 'supplier_materials';
    protected $primaryKey = 'supp_matrl_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable =[
        'supplier_ID',
        'material_ID',
        'unit_price',
    ];
}
