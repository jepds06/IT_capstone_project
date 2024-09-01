<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestProdMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'prodtn_mtrl_ID',
        'req_ID',
        'qty_requested'
    ];
}
