<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regiones;
use App\Comunas;
use App\estadoProductos;
use App\Productos;

class UtilController extends Controller
{
    public function getRegiones()
    {
        $reg =  Regiones::select('id','nombre as text')->get();
        return json_encode($reg);
    }

    public function getComunas(Request $request)
    {

        $com =  Comunas::where('idRegion','=',$request->idRegion)->select('id','nombre as text')->get();
        return json_encode($com);
    }
    public function getIdRegion(Request $request)
    {   
        $_comuna = Comunas::find($request->idComuna);
        return json_encode($_comuna->idRegion);
    }

    public function getEstadoProducto()
    {
        $estados =  estadoProductos::select('idEstado as id','descripcion as text')->get();
        return json_encode($estados);
    }

    public function getIdProducto(Request $request)
    {
        $productos = Productos::find($request->id);
        return json_encode($productos->idEstado);
    }
}
