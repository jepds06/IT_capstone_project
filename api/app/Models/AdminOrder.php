<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOrder extends Model
{
    use HasFactory;

    protected $table = 'adminOrders';
    protected $primaryKey = 'adminOrdID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'userID',
        'quoteID',
    ];

    public $timestamps = false;

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    // Relationship with the quotation detail model
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quoteID');
    }

    public function adminDeliveries()
    {
        return $this->hasMany(AdminDelivery::class, 'adminOrdID');
    }

    // Relationship with the AdminPayment model
    public function adminPayments()
    {
        return $this->hasMany(AdminPayment::class, 'adminOrdID');
    }

    public function adminOrderDetail()
    {
        return $this->hasMany(AdminOrderDetail::class, 'adminOrdID');
    }
}
