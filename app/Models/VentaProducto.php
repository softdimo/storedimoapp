<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VentaProducto extends Model
{
    use SoftDeletes;

    protected $table = 'venta_productos';
    protected $primaryKey = 'id_venta_producto';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad',
        'precio_unitario_venta',
        'precio_detal_venta',
        'precio_x_mayor_venta',
        'subtotal',
        'ganancia_venta'
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
