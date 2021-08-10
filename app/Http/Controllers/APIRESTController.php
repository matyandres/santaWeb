<?php

namespace App\Http\Controllers;

use App\Comunas;
use App\Cupon;
use App\Productos;
use App\ProductoTicket;
use App\Regiones;
use App\Ticket;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class APIRESTController extends Controller
{
    public function login(Request $request)
    {
        try {
            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;

            $validar = User::where('username', $request->username)
                        ->join('comunas','comunas.id','users.idComuna')
                        ->join('regiones','regiones.id','comunas.idRegion')
                        ->select('users.*','regiones.nombre as region','comunas.nombre as comuna')
                        ->first();

            if (!isset($request->username)) {
                return json_encode(['cod' => 500, 'mensaje' => 'El username no puede ser vacio', 'response' => null]);
            }
            if (!isset($request->password)) {
                return json_encode(['cod' => 500, 'mensaje' => 'La contraseña no puede ser vacia', 'response' => null]);
            }

            if (Hash::check($request->password, $validar->password)) {
                return json_encode(['cod' => 200, 'mensaje' => 'Ingreso con exito', 'response' => $validar]);
            } else {
                return json_encode(['cod' => 500, 'mensaje' => 'Contraseña incorrecta', 'response' => null]);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }

    public function verificarCodigoVendedor(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;

            if (!isset($request->referencia)) {
                return json_encode(['cod' => 500, 'mensaje' => 'Codigo vendedor vacio', 'response' => null]);
            }

            $validar = User::where('codigoReferencia', $request->referencia)
                ->where('id_perfilUsuario', 4)
                ->first();

            if ($validar == '') {
                return json_encode(['cod' => 500, 'mensaje' => 'Codigo de referencia invalido', 'response' => null]);
            } else {
                return json_encode(['cod' => 200, 'mensaje' => 'Correcto', 'response' => $validar->id]);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }

    public function verificarCodigoCliente(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;

            if (!isset($request->referencia)) {
                return json_encode(['cod' => 500, 'mensaje' => 'Codigo cliente vacio', 'response' => null]);
            }

            $validar = User::where('codigoReferencia', $request->referencia)
                ->where('id_perfilUsuario', 2)
                ->first();

            if ($validar == '') {
                return json_encode(['cod' => 500, 'mensaje' => 'Codigo de referencia invalido', 'response' => null]);
            } else {
                return json_encode(['cod' => 200, 'mensaje' => 'Correcto', 'response' => $validar->id]);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function registrar(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;


            if (!isset($request->telefono)) {
                return json_encode(['cod' => 500, 'mensaje' => 'El telefono esta vacio', 'response' => null]);
            }
            if (!isset($request->rut)) {
                return json_encode(['cod' => 500, 'mensaje' => 'El rut esta vacio', 'response' => null]);
            }
            if (!isset($request->dv)) {
                return json_encode(['cod' => 500, 'mensaje' => 'El dv esta vacio', 'response' => null]);
            }
            if (!isset($request->nombre)) {
                return json_encode(['cod' => 500, 'mensaje' => 'El nombre esta vacio', 'response' => null]);
            }
            if (!isset($request->password)) {
                return json_encode(['cod' => 500, 'mensaje' => 'La contraseña esta vacia', 'response' => null]);
            }
            if (!isset($request->idComuna)) {
                return json_encode(['cod' => 500, 'mensaje' => 'Seleccione una comuna', 'response' => null]);
            }





            $telefono = User::where('telefono', $request->telefono)
                ->first();




            if ($telefono != '') {
                return json_encode(['cod' => 500, 'mensaje' => 'El numero telefonico ya esta registrado', 'response' => null]);
            }

            $rut = User::where('rut', $request->rut)
                ->first();
            if ($rut != '') {
                return json_encode(['cod' => 500, 'mensaje' => 'El rut ya se encuentra en la base de datos', 'response' => null]);
            }

            if (!$this->valida_rut($request->rut . '-' . $request->dv)) {
                return json_encode(['cod' => 500, 'mensaje' => 'El rut es invalido', 'response' => null]);
            }

            $usuario = new User();
            $usuario->rut = $request->rut;
            $usuario->dv = $request->dv;
            $usuario->name = $request->nombre;
            $usuario->telefono = $request->telefono;
            $usuario->password = Hash::make($request->password);
            $usuario->id_perfilUsuario = 2;
            $usuario->idComuna = $request->idComuna;


            $usuario->codigoReferencia = $this->generateRandomString(6);


            if (!isset($request->cCliente) && $request->cCliente != '') {
                $usuario->codigoReferido = $request->cCliente;

                $cuponU1 = new Cupon();
                $cuponU2 = new Cupon();

                $cuponU1->idUsuario = $usuario->id;
                $cuponU2->idUsuario = $request->cCliente;

                $cuponU1->idEstadoCupon = 1;
                $cuponU2->idEstadoCupon = 1;

                $cuponU1->descripcion = 'Nuevo registro 20%';
                $cuponU2->descripcion = 'Nuevo registro 20%';

                $cuponU1->valorCupon = 20;
                $cuponU2->valorCupon = 20;
            }
            if (!isset($request->cVendedor) && $request->cVendedor != '') {
                $usuario->codigoVendedor = $request->cVendedor;
            }


            $usuario->username = $request->nombre[0] . $request->telefono;

            $usuario->save();

            if (!isset($request->cCliente) && $request->cCliente != '') {

                $cuponU1->save();
                $cuponU2->save();
            }

            return json_encode(['cod' => 200, 'mensaje' => 'registro con exito', 'response' => $usuario]);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function getRegiones(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;

            $regiones = Regiones::all();
            return json_encode(['cod' => 200, 'mensaje' => '', 'response' => $regiones]);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function getComunas(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;
            if (!isset($request->idRegion)) {
                return json_encode(['cod' => 500, 'mensaje' => 'Seleccione una region', 'response' => null]);
            }

            $regiones = Comunas::where('idRegion', $request->idRegion)->get();
            return json_encode(['cod' => 200, 'mensaje' => '', 'response' => $regiones]);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function verificarCompra(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;


            $usuario = User::where('id', $request->id)->first();

            if ($usuario != '' && $usuario->direccion != '') {
                return json_encode(['cod' => 200, 'mensaje' => '', 'response' => '']);
            } else {
                return json_encode(['cod' => 500, 'mensaje' => '', 'response' => '']);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function registrarUltimosDatos(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;

            if (!isset($request->direccion) && $request->direccion == '') {
                return json_encode(['cod' => 500, 'mensaje' => 'Ingrese una direccion', 'response' => null]);
            }
            if (!isset($request->correo) && $request->correo == '') {
                return json_encode(['cod' => 500, 'mensaje' => 'Ingrese un correo electronico', 'response' => null]);
            }



            $usuario = User::where('id', $request->id)->first();
            if ($usuario == '') {
                return json_encode(['cod' => 500, 'mensaje' => 'usuario no encontrado', 'response' => '']);
            }

            $usuario->email = $request->correo;
            $usuario->direccion = $request->direccion;

            $usuario->save();



            return json_encode(['cod' => 200, 'mensaje' => 'Datos registrado', 'response' => '']);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }

    public function productos(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;


            $productos = Productos::where('idEstado', 1)
                ->join('valorproducto', 'valorproducto.idProducto', 'productos.idProducto')
                ->where('valorproducto.estado', 1)
                ->get();


            return json_encode(['cod' => 200, 'mensaje' => 'Productos', 'response' => $productos]);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }

    public function getCuponesId(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;


            $productos = Cupon::where('idUsuario', $request->id)
                ->where('cupones.idEstadoCupon', '!=', 3)
                ->join('estadocupon', 'estadocupon.idEstadoCupon', 'cupones.idEstadoCupon')
                ->select('cupones.*', \DB::raw("date_format(created_at, '%d-%m-%Y' ) as fecha_tra"), 'estadocupon.descripcion as estado')
                ->orderby('idCupon', 'DESC')
                ->get();

            $fechaHoy = date('d-m-Y');

            foreach ($productos as $producto) {
                $fecha = date("d-m-Y", strtotime($producto->fecha_tra . "+ 14 days"));
                $fecha1 = date("d-m-Y", strtotime($producto->fecha_tra . "+ 19 days"));

                if ($fecha >= $fechaHoy) {
                    $producto->idEstadoCupon = 2;
                    $producto->save();
                }
                if ($fecha1 > $fechaHoy && $producto->idEstadoCupon == 2) {

                    $producto->delete();
                }
            }


            return json_encode(['cod' => 200, 'mensaje' => 'Cupones', 'response' => $productos]);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function generarCupon(Request $request)
    {
        try {
            
            
            
            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;

            if($request->total == 0){
                return json_encode(['cod' => 500, 'mensaje' => 'Error, ticket sin articulos', 'response' => '']);
            }

            $ticket = new Ticket();
            $ticket->idUsuario = $request->id;
            $ticket->idEstadoTicket = 3;
            $ticket->total = $request->total;

            $productoAux = $request->productos;
            if (isset($request->cupon) && $request->cupon != '') {
                $cupones = Cupon::find($request->cupon);
                if ($cupones->idEstadoCupon != 1) {
                    return json_encode(['cod' => 500, 'mensaje' => 'Cupon utilizado', 'response' => '']);
                }
                $ticket->idCupon = $request->cupon;
                $cupones->idEstadoCupon = 3;
                $cupones->save();
            }
            $ticket->save();
          
            foreach ($productoAux as $producto) {

                $productoT = ProductoTicket::where('idTicket', $ticket->idTicket)->where('idProducto', $producto)->first();
               
                if ($productoT != null) {
                    $productoT->cantidad = $productoT->cantidad + 1;
                    $productoT->save();
                   
                } else {
                    $productoN = new ProductoTicket();
                    $productoN->idTicket = $ticket->idTicket;
                    $productoN->idProducto = $producto;
                    $productoN->cantidad = 1;
                    $productoN->save();
                }

                unset($productoT);
                unset($productoN);
                

            }
          
            return json_encode(['cod' => 200, 'mensaje' => 'Ticket Generado', 'response' => $ticket->idTicket]);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function detalleTicket(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;

            $detalle =  Ticket::leftjoin('cupones', 'cupones.idCupon', 'ticket.idCupon')
                ->join('estadoticket', 'estadoticket.idEstadoTicket', 'ticket.idEstadoTicket')
                ->where('ticket.idTicket', $request->idTicket)
                ->select(
                    \DB::raw("date_format(ticket.created_at, '%d-%m-%Y' ) as fechaCreada"),
                    \DB::raw("date_format(ticket.created_at, '%H:%m' ) as horaCreada"),
                    'ticket.idEstadoTicket',
                    'estadoticket.descripcion',
                    'cupones.descripcion as descripcionCupon',
                    'cupones.valorCupon',
                    \DB::raw('CONCAT(cupones.valorCupon, "%") AS porcentaje'),
                    'ticket.total'
                )
                ->first();

            $producto = Productos::join('productoticket', 'productoticket.idProducto', 'productos.idProducto')
                ->where('productoticket.idTicket', $request->idTicket)
                ->select('productos.nombre', 'productoticket.cantidad')
                ->get();
            if ($detalle->valorCupon != '') {
                $cuponIngresado = true;
                $descuentoProcentaje = $detalle->valorCupon / 100;

                $totalFinal = ($detalle->total * 100) / (100 - $detalle->valorCupon);

                $descuento = intval($totalFinal * $descuentoProcentaje) * -1;
            } else {
                $cuponIngresado = false;
                $totalFinal = null;

                $descuento = null;
            }





            $array = [
                'fechaCreado' => $detalle->fechaCreada,
                'horaCreado' => $detalle->horaCreada,
                'idEstadoTicket' => $detalle->idEstadoTicket,
                'cuponIngresado' => $cuponIngresado,
                'descripcion' => $detalle->descripcion,
                'cuponValor' => $detalle->porcentaje,
                'descripcionCupon' => $detalle->descripcionCupon,
                'total' => $totalFinal,
                'descuento' => $descuento,
                'totalFinal' => $detalle->total,
                'productos' => $producto
            ];

           





            return json_encode(['cod' => 200, 'mensaje' => 'Detalle ticket', 'response' => $array]);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function ticketAll(Request $request)
    {
        try {

            if ($request->APIkey != "santaAgua=APIKEY1321DADQD11DAS") return;

            $detalle =  Ticket::leftjoin('cupones', 'cupones.idCupon', 'ticket.idCupon')
                ->join('estadoticket', 'estadoticket.idEstadoTicket', 'ticket.idEstadoTicket')
                ->where('ticket.idTicket', $request->id)
                ->select(
                    \DB::raw("date_format(ticket.created_at, '%d-%m-%Y' ) as fechaCreada"),
                    \DB::raw("date_format(ticket.created_at, '%H:%m' ) as horaCreada"),
                    'ticket.idEstadoTicket',
                    'estadoticket.descripcion',
                    'cupones.descripcion as descripcionCupon',
                    'cupones.valorCupon',
                    \DB::raw('CONCAT(cupones.valorCupon, "%") AS porcentaje'),
                    'ticket.total'
                )
                ->first();

            $producto = Productos::join('productoticket', 'productoticket.idProducto', 'productos.idProducto')
                ->where('productoticket.idTicket', $request->idTicket)
                ->select('productos.nombre', 'productoticket.cantidad')
                ->get();
            if ($detalle->valorCupon != '') {
                $cuponIngresado = true;
                $descuentoProcentaje = $detalle->valorCupon / 100;

                $totalFinal = ($detalle->total * 100) / (100 - $detalle->valorCupon);

                $descuento = intval($totalFinal * $descuentoProcentaje) * -1;
            } else {
                $cuponIngresado = false;
                $totalFinal = null;

                $descuento = null;
            }





            $array = [
                'fechaCreado' => $detalle->fechaCreada,
                'horaCreado' => $detalle->horaCreada,
                'idEstadoTicket' => $detalle->idEstadoTicket,
                'cuponIngresado' => $cuponIngresado,
                'descripcion' => $detalle->descripcion,
                'cuponValor' => $detalle->porcentaje,
                'descripcionCupon' => $detalle->descripcionCupon,
                'total' => $totalFinal,
                'descuento' => $descuento,
                'totalFinal' => $detalle->total,
                'productos' => $producto
            ];

           





            return json_encode(['cod' => 200, 'mensaje' => 'Detalle ticket', 'response' => $array]);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }


































































































    function generateRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.';
        $charactersLength = strlen($characters);
        $randomString = '';
        do {
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
        } while (!$this->verificaExisteCodigo($randomString));

        return $randomString;
    }

    public function verificaExisteCodigo($codigo)
    {
        $userMarca = User::where('codigoReferencia', '=', $codigo)->count();
        if ($userMarca == 0) {
            return true;
        } else {
            return false;
        }
    }

    function valida_rut($rut)
    {
        $rut = preg_replace('/[^k0-9]/i', '', $rut);
        $dv  = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut) - 1);
        $i = 2;
        $suma = 0;
        foreach (array_reverse(str_split($numero)) as $v) {
            if ($i == 8)
                $i = 2;

            $suma += $v * $i;
            ++$i;
        }

        $dvr = 11 - ($suma % 11);

        if ($dvr == 11)
            $dvr = 0;
        if ($dvr == 10)
            $dvr = 'K';

        if ($dvr == strtoupper($dv))
            return true;
        else
            return false;
    }
}
