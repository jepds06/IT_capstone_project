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
    public $timestamps = false;

    protected $fillable =[
        'userID',
        'materialID',
        'unitPrice'
    ];

    protected $casts = [
        'unitPrice' => 'decimal:2'
    ];

    //eloquent/relationship between suppliers & supplierMaterials
    public function user()
    {
        return $this->belongsTo(User::class,'supplierID');
    }

    //eloquent/relationship between materials & supplierMaterials
    public function material()
    {
        return $this->belongsTo(Material::class,'materialID');
    }
    public function adminOrders()
    {
        return $this->hasMany(AdminOrder::class, 'suppMatrlID');
    }
}
