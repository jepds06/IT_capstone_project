<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'customerID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'accountID',
        'cstrFirstName',
        'cstrLastName',
        'contactNum',
        'cstrAddress',
        'customerType',
        'prefContactMethod',
        'cstrStatus'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'accountID');
    }
}
