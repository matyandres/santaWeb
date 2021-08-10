<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoTicket extends Model
{
    protected $table = 'productoticket';
    protected $primaryKey = 'idProductoTicket';
    public $timestamps = false;
}
