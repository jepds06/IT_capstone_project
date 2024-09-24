<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $table = 'userTypes';
    protected $primaryKey = 'userTypeID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'userTypeName'
    ];

    //eloquent/relationship between user types & users
    public function users()
    {
        return $this->hasMany(User::class, 'userTypeID');
    }
}
