<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'adminOrderDetails';
    protected $primaryKey = 'adminOrdDetailID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'adminOrdID',
        'prodtnMtrlID',
        'qtyOrdered',
        'amount',
        'isDropped'
    ];
    
    public function adminPayments()
    {
        return $this->hasMany(AdminPayment::class, 'adminOrdDetailID');
    }

    public function adminOrder()
    {
        return $this->belongsTo(AdminOrder::class, 'adminOrdID');
    }

    public function productionMaterial()
    {
        return $this->belongsTo(ProductionMaterial::class, 'prodtnMtrlID');
    }
}
