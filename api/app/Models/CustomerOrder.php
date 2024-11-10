<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $table = 'customerOrders';
    protected $primaryKey = 'cstrOrderID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'userID',
        'orderDate',
        'orderStatus',
        'orderRemarks'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class, 'cstrOrderID');
    }
}
