<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasPermissions extends Model
{
    protected $connection = 'mysql';
    protected $table = 'model_has_permissions';
    public $timestamps = false;
    protected $fillable = [
        'permission_id',
        'model_type',
        'model_id'
    ];
}
