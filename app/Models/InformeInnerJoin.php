<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformeInnerJoin extends Model
{
    protected $connection = 'mysql';
    protected $table = 'informe_inner_join';
    protected $fillable = [
        'informe_codigo',
        'infxcampos',
        'inner_join',
    ];

    public $timestamps = true;
}
