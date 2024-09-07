<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestProdMaterial extends Model
{
    use HasFactory;

    protected $table = 'request_prod_materials';
    protected $primaryKey = 'req_prodmats_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'prodtn_mtrl_ID',
        'req_ID',
        'qty_requested'
    ];
}
