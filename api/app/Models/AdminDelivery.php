<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDelivery extends Model
{
    use HasFactory;

    protected $table = 'adminDeliveries';
    protected $primaryKey = 'adminDlvrID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'adminOrdID',
        'deliveryDate',
        'deliveryAddress',
//        'deliveryStatus',
        'qtyReceived'
    ];

    public $timestamps = false;

    public function adminOrder()
    {
        return $this->belongsTo(AdminOrder::class, 'adminOrdID');
    }
}
