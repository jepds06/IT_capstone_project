<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPrivilege extends Model
{
    use HasFactory;

    protected $table = 'userPrivileges';
    protected $primaryKey = 'privilegeID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable =[
        'userID',
        'moduleID',
        'create',
        'update',
        'view',
        'cancel',
    ];

    //eloquent/relationship for users & user privileges
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    //eloquent/relationship for modules & user privileges
    public function module()
    {
        return $this->belongsTo(Module::class, 'moduleID');
    }
}