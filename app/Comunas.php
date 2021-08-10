<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunas extends Model
{
    protected $table = 'comunas';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
