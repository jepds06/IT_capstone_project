<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';
    protected $primaryKey = 'moduleID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable =[
        'moduleName'
    ];

    public function userprivileges()
    {
        return $this->hasMany(UserPrivilege::class, 'moduleID');
    }
}
