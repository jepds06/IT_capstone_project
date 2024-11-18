<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'salesID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'userID',
        'salesDate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function salesOrders()
    {
        return $this->hasMany(SalesProductOrder::class, 'salesID');
    }

    public function customerPayment()
    {
        return $this->hasMany(CustomerPayment::class, 'salesID');
    }

    public function salesDeliveries()
    {
        return $this->hasOne(Sales_Delivery::class, 'salesID');
    }
}
