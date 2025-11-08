<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoEmpleado extends Model
{
    use SoftDeletes;

    protected $table = 'pago_empleados';
    protected $primaryKey = 'id_pago_empleado';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'id_empresa',
        'id_tipo_pago',
        'fecha_pago',
        'id_usuario',
        'valor_ventas',
        'valor_comision',
        'id_periodo_pago',
        'cantidad_dias',
        'valor_dia',
        'valor_prima',
        'valor_vacaciones',
        'valor_cesantias',
        'salario_neto',
        'valor_total',
        'id_estado'
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
