<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'rol',
    ];
}
