<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    
    protected $table = 'accounts';
    protected $primaryKey = 'accountID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'username',
        'email',
        'password',
        'accTypeID'
    ];

    //eloquent/relationship between account types & accounts
    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'accTypeID');
    }

    //eloquent/relationship between accounts & administrators
    public function administrators()
    {
        return $this->hasMany(Administrator::class, 'accountID');
    }

    //eloquent/relationship between accounts & customers
    public function customers()
    {
        return $this->hasMany(Customer::class, 'accountID');
    }

    //eloquent/relationship between accounts & suppliers
    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'accountID');
    }
}
