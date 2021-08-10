<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regiones;
use App\Comunas;
use App\estadoProductos;
use App\Ventas;
use Yajra\Datatables\Facades\Datatables;
use DB;

class VentasController extends Controller
{
    public function getVentas(Request $request)
    {

        $año  =  $request->fecha;

        $ventas = Ventas::leftJoin('estadoticket', 'estadoticket.idEstadoTicket', '=', 'ticket.idEstadoTicket')
            ->join('users', 'users.id', '=', 'ticket.idUsuario')
            ->join('cupones', 'cupones.idCupon', '=', 'ticket.idCupon')
            ->where(DB::raw("DATE_FORMAT(ticket.created_at,'%Y')"), $año)
            ->select(
                'ticket.idEstadoTicket',
                'ticket.idTicket',
                'cupones.descripcion as idCupon',
                'ticket.created_at',
                'ticket.updated_at',
                'ticket.total',
                \DB::raw("CONCAT(users.name) as idUsuario")
            )
            ->get();
        return Datatables::of($ventas)->make(true);
    }
    public function getVentasProveedor(Request $request)
    {
        $id_proveedor = $request->id_proveedor;
        $mes = $request->mesProveedor;
        $anho = $request->anho;


        if ($id_proveedor == 0 && $mes == 0) {
            $ventas = Ventas::leftJoin('estadoticket', 'estadoticket.idEstadoTicket', '=', 'ticket.idEstadoTicket')
                ->join('users', 'users.id', '=', 'ticket.idUsuario')
                ->leftJoin('cupones', 'cupones.idCupon', '=', 'ticket.idCupon')
                ->where(DB::raw("DATE_FORMAT(ticket.created_at,'%Y')"), $anho)
                ->where('ticket.idEstadoTicket', 1)
                ->select(
                    'ticket.idEstadoTicket',
                    'ticket.idTicket',
                    'cupones.descripcion as idCupon',
                    'ticket.created_at',
                    'ticket.updated_at',
                    'ticket.total',
                    \DB::raw("CONCAT(users.name) as idUsuario")
                )
                ->get();
            return Datatables::of($ventas)->make(true);
        }
        if ($id_proveedor != 0 && $mes == 0) {
            $ventas = Ventas::leftJoin('estadoticket', 'estadoticket.idEstadoTicket', '=', 'ticket.idEstadoTicket')
                ->join('users', 'users.id', '=', 'ticket.idUsuario')
                ->leftJoin('cupones', 'cupones.idCupon', '=', 'ticket.idCupon')
                ->where(DB::raw("DATE_FORMAT(ticket.created_at,'%Y')"), $anho)
                ->where('users.codigoVendedor', $id_proveedor)
                ->where('ticket.idEstadoTicket', 1)
                ->select(
                    'ticket.idEstadoTicket',
                    'ticket.idTicket',
                    'cupones.descripcion as idCupon',
                    'ticket.created_at',
                    'ticket.updated_at',
                    'ticket.total',
                    \DB::raw("CONCAT(users.name) as idUsuario")
                )
                ->get();
            return Datatables::of($ventas)->make(true);
        }
        if ($id_proveedor == 0 && $mes != 0) {
            $ventas = Ventas::leftJoin('estadoticket', 'estadoticket.idEstadoTicket', '=', 'ticket.idEstadoTicket')
                ->join('users', 'users.id', '=', 'ticket.idUsuario')
                ->leftJoin('cupones', 'cupones.idCupon', '=', 'ticket.idCupon')
                ->where(DB::raw("DATE_FORMAT(ticket.created_at,'%Y')"), $anho)
                ->where(DB::raw("DATE_FORMAT(ticket.created_at,'%m')"), $mes)
                ->where('ticket.idEstadoTicket', 1)
                ->select(
                    'ticket.idEstadoTicket',
                    'ticket.idTicket',
                    'cupones.descripcion as idCupon',
                    'ticket.created_at',
                    'ticket.updated_at',
                    'ticket.total',
                    \DB::raw("CONCAT(users.name) as idUsuario")
                )
                ->get();
            return Datatables::of($ventas)->make(true);
        }
        if ($id_proveedor != 0 && $mes != 0) {
            $ventas = Ventas::leftJoin('estadoticket', 'estadoticket.idEstadoTicket', '=', 'ticket.idEstadoTicket')
                ->join('users', 'users.id', '=', 'ticket.idUsuario')
                ->leftJoin('cupones', 'cupones.idCupon', '=', 'ticket.idCupon')
                ->where(DB::raw("DATE_FORMAT(ticket.created_at,'%Y')"), $anho)
                ->where(DB::raw("DATE_FORMAT(ticket.created_at,'%m')"), $mes)
                ->where('users.codigoVendedor', $id_proveedor)
                ->where('ticket.idEstadoTicket', 1)
                ->select(
                    'ticket.idEstadoTicket',
                    'ticket.idTicket',
                    'cupones.descripcion as idCupon',
                    'ticket.created_at',
                    'ticket.updated_at',
                    'ticket.total',
                    \DB::raw("CONCAT(users.name) as idUsuario")
                )
                ->get();
            return Datatables::of($ventas)->make(true);
        }
    }
    public function getVentasMes(Request $request)
    {
        $año = date('Y');
        
        $response = DB::table('ticket')
            ->where('idEstadoTicket', 1)
            ->where(DB::raw("DATE_FORMAT(updated_at,'%Y')"),$año)
            ->select(DB::raw('COUNT(*) as cantidad'), DB::raw("DATE_FORMAT(updated_at,'%m') as months"))
            ->groupBy('months')
            ->orderBy('months','ASC')
            ->get();

        return response()->json(array('response' => true, 'data' => $response));
    }
    public function getVentasProducto(Request $request)
    {
        $fecha = $request->mes;
        $año = $request->ano;
        if($fecha == 0 && ($año == null || $año == 0)){
            $response = DB::table('ticket')
            ->join('productoticket', 'productoticket.idTicket', '=', 'ticket.idTicket')
            ->join('productos', 'productos.idProducto', '=', 'productoticket.idProducto')
            ->where('ticket.idEstadoTicket', 1)
           // ->where(DB::raw("DATE_FORMAT(ticket.updated_at,'%m')"), $fecha)
            ->select('productos.nombre', DB::raw('SUM(productoticket.cantidad) as cantidad'))
            ->groupBy('productos.idProducto')
            ->get();
        }else if($fecha != 0 && ($año == null || $año == 0)){
            $response = DB::table('ticket')
            ->join('productoticket', 'productoticket.idTicket', '=', 'ticket.idTicket')
            ->join('productos', 'productos.idProducto', '=', 'productoticket.idProducto')
            ->where('ticket.idEstadoTicket', 1)
            ->where(DB::raw("DATE_FORMAT(ticket.updated_at,'%m')"), $fecha)
            ->select('productos.nombre', DB::raw('SUM(productoticket.cantidad) as cantidad'))
            ->groupBy('productos.idProducto')
            ->get();
        }else if($fecha == 0 && $año != null && $año != 0){
            $response = DB::table('ticket')
            ->join('productoticket', 'productoticket.idTicket', '=', 'ticket.idTicket')
            ->join('productos', 'productos.idProducto', '=', 'productoticket.idProducto')
            ->where('ticket.idEstadoTicket', 1)
            ->where(DB::raw("DATE_FORMAT(ticket.updated_at,'%Y')"), $año)
            ->select('productos.nombre', DB::raw('SUM(productoticket.cantidad) as cantidad'))
            ->groupBy('productos.idProducto')
            ->get();
        }else{
            $response = DB::table('ticket')
            ->join('productoticket', 'productoticket.idTicket', '=', 'ticket.idTicket')
            ->join('productos', 'productos.idProducto', '=', 'productoticket.idProducto')
            ->where('ticket.idEstadoTicket', 1)
            ->where(DB::raw("DATE_FORMAT(ticket.updated_at,'%Y')"), $año)
            ->where(DB::raw("DATE_FORMAT(ticket.updated_at,'%m')"), $fecha)
            ->select('productos.nombre', DB::raw('SUM(productoticket.cantidad) as cantidad'))
            ->groupBy('productos.idProducto')
            ->get();
        }
        

        

        if(COUNT($response)>0){
            return response()->json(array('response' => true, 'data' => $response));
        }else{
            return response()->json(array('response' => false));
        }
    }
}
