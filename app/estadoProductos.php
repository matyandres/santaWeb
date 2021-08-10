<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estadoProductos extends Model
{
    protected $table = 'estadoproductos';
    protected $primaryKey = 'idEstado';
    public $timestamps = false;
}
