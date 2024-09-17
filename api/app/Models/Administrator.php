<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

    protected $table = 'administrators';
    protected $primaryKey = 'adminID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'accountID',
        'adminFirstName',
        'adminLastName',
        'contactNum',
        'adminAddress'
    ];

    //eloquent/relationship between accounts & administrators
    public function account()
    {
        return $this->belongsTo(Account::class, 'accountID');
    }
}
