<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BajaDetalle extends Model
{
    use SoftDeletes;

    protected $table = 'bajas_detalle';
    protected $primaryKey = 'id_baja_detalle';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'id_baja',
        'id_tipo_baja',
        'id_producto',
        'cantidad',
        'observaciones'
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
