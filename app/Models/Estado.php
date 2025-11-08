<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'estados';
    protected $primaryKey = 'id_estado';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'estado',
    ];
}
