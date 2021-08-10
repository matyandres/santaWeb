<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Productos;
use App\Valores;
use App\ValorProductos;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;
use Intervention\Image\ImageManagerStatic as Image;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('productos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function datosProductos(Request $request)
    {
        if (Auth::user()->id_perfilUsuario == 1) {
            $año  =  $request->fecha;

            if ($año) {
                $productos = Productos::join('valorproducto', 'valorproducto.idProducto', '=', 'productos.idProducto')
                    ->where('valorproducto.estado', 1)
                    ->where(DB::raw("DATE_FORMAT(productos.created_at,'%Y')"), $año)
                    ->get();
                return Datatables::of($productos)->make(true);
            } else {
                $productos = Productos::join('valorproducto', 'valorproducto.idProducto', '=', 'productos.idProducto')
                    ->where('valorproducto.estado', 1)
                    ->get();
                return Datatables::of($productos)->make(true);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $v = Validator::make($request->all(), [
                'nombre' => 'required|max:255|string',
                'descripcion' => 'required|max:2255|string',
                'Valor' => 'int|required',
                'estadoProducto' => 'int|required'
            ]);
            if ($v->fails()) return json_encode(['cod' => 100, 'mensaje' => $v->errors()->all()]);
            if ($request->avatar != '') {
                $img = (string) Image::make($request->file('avatar'))->resize(500, 300)->encode('data-url');
            } else {
                $img = '';
            }

            $product = new Productos();
            $product->nombre = $request->nombre;
            $product->descripcion = $request->descripcion;
            $product->avatar = $img;
            $product->idestado = $request->estadoProducto;
            $product->save();


            $valorProducto =  new ValorProductos();
            $valorProducto->estado = 1;
            $valorProducto->idProducto = $product->idProducto;
            $valorProducto->precio = $request->Valor;

            $valorProducto->save();

            return json_encode(['cod' => 200, 'mensaje' => 'Datos guardados correctamente']);
        } catch (\Throwable $th) {
            return json_encode(['cod' => 500, 'mensaje' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            $v = Validator::make($request->all(), [
                'nombre' => 'required|max:255|string',
                'descripcion' => 'required|max:2255|string',
                'id' => 'required|int'
            ]);
            if ($v->fails()) return json_encode(['cod' => 100, 'mensaje' => $v->errors()->all()]);


            $product = Productos::find($request->id);
            $product->nombre = $request->nombre;
            $product->descripcion = $request->descripcion;
            if ($request->avatar != '') {
                $img = (string) Image::make($request->file('avatar'))->resize(500, 300)->encode('data-url');
                $product->avatar = $img;
            }

            $product->save();



            return json_encode(['cod' => 200, 'mensaje' => 'Datos guardados correctamente']);
        } catch (\Throwable $th) {
            return json_encode(['cod' => 500, 'mensaje' => $th->getMessage()]);
        }
    }


    public function delete(Request $request)
    {


        try {


            if (Auth::user()->id_perfilUsuario == 1) {
                $pro = Productos::find($request->id);

                $pro->delete();
                return json_encode(['cod' => 200]);
            } else {
                return json_encode(['cod' => 500, 'mensaje' => 'El usuario no cuenta con el perfil requerido para realizar la accion']);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }

    public function cambiaEstado(Request $request)
    {
        try {


            if (Auth::user()->id_perfilUsuario == 1) {
                $pro = Productos::find($request->idProducto);
                $pro->idEstado = $request->estado;
                $pro->save();
                return json_encode(['cod' => 200, 'mensaje' => 'Estado modificado correctamente']);
            } else {
                return json_encode(['cod' => 500, 'mensaje' => 'El usuario no cuenta con el perfil requerido para realizar la accion']);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }


    public function historialPrecio(Request $request)
    {

        try {

            $valores = ValorProductos::where('idProducto', $request->id)
                ->select('precio', 'valorproducto.estado')
                ->orderBy('created_at', 'DESC')
                ->take(10)
                ->get();

            return json_encode(['cod' => 200, 'mensaje' => '', 'resp' => $valores]);
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }

    public function setPrecio(Request $request)
    {


        try {

            $v = Validator::make($request->all(), [
                'id' => 'required|int',
                'valor' => 'int|required',
            ]);
            if ($v->fails()) return json_encode(['cod' => 100, 'mensaje' => $v->errors()->all()]);

            $precioPro = ValorProductos::where('idProducto', $request->id)
                ->where('estado', 1)
                ->get();
            foreach ($precioPro as $value) {
                $value->estado = 0;
                $value->save();
            }

            $producto = Productos::find($request->id);
            $producto->oferta= 0;
            $producto->save();


            $precioPro = new ValorProductos();
            $precioPro->estado = 1;
            $precioPro->idProducto = $request->id;
            $precioPro->precio = $request->valor;
            $precioPro->save();

            return json_encode(['cod' => 200, 'mensaje' => 'El precio fue guardado exitosamente', 'resp' => '']);
        } catch (\Throwable $th) {

            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getProductosPrecios(Request $request)
    {
        $productos = DB::table('productos')
            ->get();

        if (COUNT($productos) > 0) {
            return response()->json(
                array(
                    'response' => true,
                    'data' => $productos
                )
            );
        } else {
            return response()->json(
                array(
                    'response' => false,
                )
            );
        }
    }
    public function historialPrecioProducto(Request $request)
    {
        $idProducto = $request->id_producto;
        $anho = $request->anho;
        $mes = $request->mes;
        if ($idProducto == 0) {
            return response()->json(
                array(
                    'response' => false
                )
            );
        }
        if ($idProducto != 0 && $anho == 0 && $mes == 0) {
            $producto = DB::table('valorproducto')
                ->where('idProducto', $idProducto)
                ->get();
        }
        if ($idProducto != 0 && $anho != 0 && $mes == 0) {
            $producto = DB::table('valorproducto')
                ->where('idProducto', $idProducto)
                ->where(DB::raw("DATE_FORMAT(valorproducto.created_at,'%Y')"), $anho)
                ->get();
        }
        if ($idProducto != 0 && $anho != 0 && $mes != 0) {
            $producto = DB::table('valorproducto')
                ->where('idProducto', $idProducto)
                ->where(DB::raw("DATE_FORMAT(valorproducto.created_at,'%Y')"), $anho)
                ->where(DB::raw("DATE_FORMAT(valorproducto.created_at,'%m')"), $mes)
                ->get();
        }
        if ($idProducto != 0 && $anho == 0 && $mes != 0) {
            $producto = DB::table('valorproducto')
                ->where('idProducto', $idProducto)
                ->where(DB::raw("DATE_FORMAT(valorproducto.created_at,'%m')"), $mes)
                ->get();
        }
        if (COUNT($producto) > 0) {
            return response()->json(
                array(
                    'response' => true,
                    'data' => $producto
                )
            );
        } else {
            return response()->json(
                array(
                    'response' => false
                )
            );
        }
    }
    public function searchOffer(Request $request)
    {
        $producto = DB::table('productos')
            ->where('idProducto', $request->id)
            ->first();

        return response()->json(['response' => true, 'data' => $producto]);
    }
    public function setOferta(Request $request)
    {
        try {
            if($request->valor >75){
               return json_encode(['cod' => 100, 'mensaje' => 'El campo oferta no puede superar al 75%']);
            }
            $response =  DB::table('productos')
                ->where('idProducto', $request->id)
                ->update([
                    'oferta' => (int)$request->valor
                ]);

            if ($response) {
                $productoPrecio = DB::table('valorproducto')
                    ->where('idProducto', $request->id)
                    ->where('estado', 1)
                    ->first();


                $valorAntiguo = $productoPrecio->precio - ((int)($productoPrecio->precio * $request->valor) / 100);


                DB::table('valorproducto')
                    ->where('idProducto', $request->id)
                    ->where('estado', 1)
                    ->update([
                        'precio' => (int) $valorAntiguo
                    ]);
                return json_encode(['cod' => 200, 'mensaje' => 'La oferta fue ingresada con éxito', 'resp' => '']);
            } else {
                return json_encode(['cod' => 500, 'mensaje' => 'No se logro modificar su oferta', 'resp' => '']);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function quitarOferta(Request $request)
    {
        try {
            $productoDescuento =  DB::table('productos')
                ->where('idProducto', $request->id)
                ->first();
            $response =  DB::table('productos')
                ->where('idProducto', $request->id)
                ->update([
                    'oferta' => 0
                ]);

            if ($response) {
                $productoPrecio = DB::table('valorproducto')
                    ->where('idProducto', $request->id)
                    ->where('estado', 1)
                    ->first();

                $nuevoValor = ($productoPrecio->precio * 100) / (100 - $productoDescuento->oferta);


                DB::table('valorproducto')
                    ->where('idProducto', $request->id)
                    ->where('estado', 1)
                    ->update([
                        'precio' => (int) $nuevoValor
                    ]);

                return json_encode(['cod' => 200, 'mensaje' => 'La oferta fue modificada con éxito', 'resp' => '']);
            } else {
                return json_encode(['cod' => 500, 'mensaje' => 'No se logro modificar su oferta', 'resp' => '']);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
}
