<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function getProveedores(Request $request)
    {
        $proveedores = DB::table('users')
            ->where('id_perfilUsuario', 4)
            ->select('name', 'id')
            ->get();


        return response()->json(
            array(
                'response' => true,
                'data' => $proveedores
            )
        );
    }
}
