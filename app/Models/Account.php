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

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'accTypeID');
    }
}
