<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'empresas';
    protected $primaryKey = 'id_empresa';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'id_tipo_documento',
        'nit_empresa',
        'ident_empresa_natural',
        'nombre_empresa',
        'telefono_empresa',
        'celular_empresa',
        'email_empresa',
        'direccion_empresa',
        'app_key', // app key
        'app_url', // app url
        'id_tipo_bd', // db connection
        'db_host', // db host
        'db_database', // db database
        'db_username', // db username
        'db_password', // db password
        'logo_empresa', // logo empresa
        'id_estado' // estado
    ];
}
