<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'userID';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'userName',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //eloquent/relationship between user & users privileges
    public function userPrivileges()
    {
        return $this->hasMany(UserPrivilege::class,'userID');
    }

    //eloquent/relationship between user types & users
    public function userType()
    {
        return $this->belongsTo(UserType::class,'userTypeID');
    }

    public function productions()
    {
        return $this->hasMany(Production::class, 'moduleID');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'userID');
    }
}
