<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoBd extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'tipos_bd';
    protected $primaryKey = 'id_tipo_bd';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'tipo_bd',
    ];
}
