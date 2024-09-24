<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory;

    protected $table = 'accountTypes';
    protected $primaryKey = 'accTypeID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'accountTypeName'
    ];

    //eloquent/relationship between accounts & account types
    public function accounts()
    {
        return $this->hasMany(Account::class, 'accTypeID');
    }
}
