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
        'suppMatrlID',
        'qtyOrdered',
        'amount'
    ];

     // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

     // Relationship with the SupplierMaterial model
    public function supplierMaterial()
    {
        return $this->belongsTo(SupplierMaterial::class, 'suppMatrlID');
    }
    // Relationship with the AdminPayment model
    public function adminPayments()
    {
        return $this->hasMany(AdminPayment::class, 'adminOrdID');
    }
}
