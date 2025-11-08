<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Baja extends Model
{
    use SoftDeletes;

    protected $table = 'bajas';
    protected $primaryKey = 'id_baja';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'id_responsable_baja',
        'fecha_baja',
        'id_estado_baja'
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
