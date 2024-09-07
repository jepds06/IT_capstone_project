<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMaterial extends Model
{
    use HasFactory;

    protected $table = 'production_materials';
    protected $primaryKey = 'prodtn_mtrl_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'product_mats_ID',
        'production_ID'
    ];
}
