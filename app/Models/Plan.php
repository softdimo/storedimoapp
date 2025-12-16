<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'planes';
    protected $primaryKey = 'id_plan';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'nombre_plan',
        'valor_mensual',
        'valor_trimestral',
        'valor_semestral',
        'valor_anual',
        'descripcion_plan',
        'id_estado_plan'
    ];
}
