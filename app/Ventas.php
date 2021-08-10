<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = 'ticket';
    protected $primaryKey = 'idTicket';
    public $timestamps = true;

}
