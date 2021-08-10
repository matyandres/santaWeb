<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use DB;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuario.index');
    }

    public function datosUsuarios()
    {
        if (Auth::user()->id_perfilUsuario == 1) {
            $user = user::join('comunas', 'comunas.id', '=', 'users.idComuna')
                ->join('regiones', 'regiones.id', '=', 'comunas.idRegion')
                ->select('users.*', 'comunas.nombre as comuna', 'regiones.nombre as region');
            return Datatables::of($user)->make(true);
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            if ($request->email == '') {
                $v = Validator::make($request->all(), [
                    'rut' => 'required|int|unique:users',
                    'dv' => 'required|string|max:1',
                    'telefono' => 'required|string|unique:users|min:9',
                    'nombre' => 'required|string|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'seleccionTipoUsuario' => 'required|int',
                    'username' => 'required|string|unique:users|max:255',
                    'direccion' => 'required|string|max:255',
                    'comunas' => 'required|int'
                ]);
            } else {
                $v = Validator::make($request->all(), [
                    'rut' => 'required|int|unique:users',
                    'dv' => 'required|string|max:1',
                    'telefono' => 'required|string|unique:users|min:9',
                    'nombre' => 'required|string|max:255',
                    'email' => 'unique:users|email|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'seleccionTipoUsuario' => 'required|int',
                    'username' => 'required|string|unique:users|max:255',
                    'direccion' => 'required|string|max:255',
                    'comunas' => 'required|int'
                ]);
            }

            if ($v->fails()) return json_encode(['cod' => 100, 'mensaje' => $v->errors()->all()]);


            $user = new User();
            $user->name = $request->nombre;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->direccion = $request->direccion;
            $user->idComuna = $request->comunas;
            $user->email = $request->email;
            $user->telefono = $request->telefono;
            $user->rut = $request->rut;
            $user->dv = $request->dv;
            $user->password = Hash::make($request->password);
            $user->id_perfilUsuario = $request->seleccionTipoUsuario;
            $user->codigoReferencia = $this->generateRandomString(6);


            if (Auth::user()->id_perfilUsuario == 1) {

                $user->save();
                return json_encode(['cod' => 200]);
            } else {

                return json_encode(['cod' => 500, 'mensaje' => 'El usuario no cuenta con el perfil requerido para realizar la accion']);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage()]);
        }
    }
    public function generarCodigo(Request $request)
    {
        try {
            $codigo = $this->generateRandomString(6);
            $user = User::find($request->idUsuario);
            $user->codigoReferencia = $codigo;

            $user->save();
            if ($request->marca == 1) {

                return json_encode(['cod' => 200, 'mensaje' => 'El codigo se ha generado correctamente!!']);
            } else {
                return json_encode(['cod' => 200, 'mensaje' => 'El codigo se ha actualizado correctamente!!']);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage()]);
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



            $pro = User::find($request->id);
            if ($pro->email == $request->email) {
                $v = Validator::make($request->all(), [


                    'nombre' => 'required|string|max:255',
                    'seleccionTipoUsuario' => 'required|int',
                    'direccion' => 'required|string|max:255',
                    'comunas' => 'required|int'
                ]);
            } else {
                $v = Validator::make($request->all(), [


                    'nombre' => 'required|string|max:255',
                    'email' => 'unique:users|email|max:255',
                    'seleccionTipoUsuario' => 'required|int',
                    'direccion' => 'required|string|max:255',
                    'comunas' => 'required|int'
                ]);
            }
            if ($v->fails()) return json_encode(['cod' => 100, 'mensaje' => $v->errors()->all()]);

            if ($pro->telefono == $request->telefono) {
                $v = Validator::make($request->all(), [

                    'telefono' => 'required|string|min:9',

                ]);
            } else {
                $v = Validator::make($request->all(), [

                    'telefono' => 'required|string|unique:users|min:9',

                ]);
            }
            if ($v->fails()) return json_encode(['cod' => 100, 'mensaje' => $v->errors()->all()]);
            $pro->name = $request->nombre;
            $pro->email = $request->email;
            $pro->telefono = $request->telefono;
            $pro->id_perfilUsuario = $request->seleccionTipoUsuario;
            $pro->direccion = $request->direccion;


            if (Auth::user()->id_perfilUsuario == 1) {
                $pro->save();
                return json_encode(['cod' => 200]);
            } else {
                return json_encode(['cod' => 500, 'mensaje' => 'El usuario no cuenta con el perfil requerido para realizar la accion']);
            }
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
    public function delete(Request $request)
    {


        try {
            $pro = User::find($request->id);

            if (Auth::user()->id_perfilUsuario == 1) {

                $pro->delete();
                return json_encode(['cod' => 200]);
            } else {
                return json_encode(['cod' => 500, 'mensaje' => 'El usuario no cuenta con el perfil requerido para realizar la accion']);
            }
        } catch (\Throwable $th) {
            return json_encode(['cod' => $th->getCode(), 'mensaje' => $th->getMessage(), 'response' => null]);
        }
    }
    public function getClientesChard(Request $request)
    {
        /*         $clientes = \DB::table()
            ->select(
                \DB::raw('COUNT(*)'),
                \DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
            )
            ->groupBy('months')
            ->get(); */ 
        $año = date('Y');
        $clientes = user::select(
            \DB::raw('COUNT(*) as cantidad'),
            \DB::raw("DATE_FORMAT(created_at,'%m') as months")
            
        )
            ->where('id_perfilUsuario', 2)
            ->where(DB::raw("DATE_FORMAT(created_at,'%Y')"),$año)
            ->groupBy('months')
            ->orderBy('months','ASC')
            ->get();
        return response()->json(
            $clientes
        );
    }
    public function datosCliente(Request $request)
    {
        $año  =  $request->fecha;

        $clientes = User::select('*', 'comunas.nombre as nombreComuna', DB::raw("CONCAT(users.rut, '-', users.dv) as rutCompleto"))
            ->join('perfilusuario', 'perfilusuario.id', '=', 'users.id_perfilUsuario')
            ->join('comunas', 'comunas.id', '=', 'users.idComuna')
            ->where('users.id_perfilUsuario', 2)
            ->where(DB::raw("DATE_FORMAT(users.created_at,'%Y')"), $año)
            ->get();
          
        return Datatables::of($clientes)->make(true);
    }
}
