<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PorcentajeComision extends Model
{
    use SoftDeletes;

    protected $table = 'porcentajes_comision';
    protected $primaryKey = 'id_porcentaje_comision';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'porcentaje_comision'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // Si estamos en una conexión tenant, usar esa conexión
        if (config('database.default') === 'tenant') {
            $this->connection = 'tenant';
        }
    }
}
