<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $connection = 'mysql';
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'nombre',
        'ruta',
        'icono',
        'padre',
        'hijo',
        'abuelo',
        'menu_id',
        'permission_id',
        'estado_id'
    ];
}
