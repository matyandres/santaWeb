<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValorProductos extends Model
{
    protected $table = 'valorproducto';
    protected $primaryKey = 'idValorProducto';
    public $timestamps = true;
}
