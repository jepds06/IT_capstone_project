<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';
    protected $primaryKey = 'material_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'description',
        'specification',
        'brand',
        'unit_of_measure'
    ];
}
