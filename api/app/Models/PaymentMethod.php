<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'paymentMethods';
    protected $primaryKey = 'payMethodID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'payMethodName'
    ];

    public function adminPayments()
    {
        return $this->hasMany(AdminPayment::class, 'payMethodID');
    }
}
