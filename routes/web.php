<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix("/api")->group(function () {

    Route::post('/login', 'APIRESTController@login');
    Route::post('/registrar', 'APIRESTController@registrar');
    Route::post('/vCodigoVendedor', 'APIRESTController@verificarCodigoVendedor');
    Route::post('/vCodigoCliente', 'APIRESTController@verificarCodigoCliente');
    Route::post('/getRegiones', 'APIRESTController@getRegiones');
    Route::post('/getComunas', 'APIRESTController@getComunas');
    Route::post('/verificarCompra', 'APIRESTController@verificarCompra');
    Route::post('/registrarUltimosDatos', 'APIRESTController@registrarUltimosDatos');
    Route::post('/productos', 'APIRESTController@productos');
    Route::post('/getCuponesId', 'APIRESTController@getCuponesId');
    Route::post('/generarCupon', 'APIRESTController@generarCupon');
    Route::post('/detalleTicket', 'APIRESTController@detalleTicket');

});


Route::prefix("/in")->middleware(['auth'])->group(function () {

    
    Route::prefix("/util")->middleware(['auth'])->group(function () {
    
        //RUTAS UTILIDADES
        Route::post('/regiones', 'UtilController@getRegiones')->name('regiones');
        Route::post('/estadoProducto', 'UtilController@getEstadoProducto')->name('estadoProducto');
        Route::post('/comunas', 'UtilController@getComunas')->name('comunas');
        Route::post('/getIdRegion', 'UtilController@getIdRegion')->name('idRegion');
        Route::post('/getIdProducto', 'UtilController@getIdProducto')->name('idProducto');
        
        
    });



    Route::prefix("/usuario")->middleware(['auth'])->group(function () {
    
        //RUTAS USUARIOS
        Route::post('/datosUsuarios', 'UsuariosController@datosUsuarios')->name('usuariosDatos');
        Route::get('/index', 'UsuariosController@index')->name('usuarios');
        Route::post('/store', 'UsuariosController@store')->name('u_store');
        
        Route::get('/getClientesChard', 'UsuariosController@getClientesChard')->name('getClientesChard');
        Route::post('/delete', 'UsuariosController@delete')->name('u_delete');
        Route::post('/update', 'UsuariosController@update')->name('u_update');
        Route::post('/generarCodigo', 'UsuariosController@generarCodigo')->name('u_generarCodigo');
        Route::post('/datosCliente', 'UsuariosController@datosCliente')->name('datosCliente');
        
        
    });


    Route::prefix("/productos")->middleware(['auth'])->group(function () {
    
        //RUTAS PRODUCTOS
        Route::post('/datosProductos', 'ProductosController@datosProductos')->name('productosDatos');
        Route::get('/index', 'ProductosController@index')->name('productos');
        Route::post('/store', 'ProductosController@store')->name('u_store');
        Route::post('/delete', 'ProductosController@delete')->name('u_delete');
        Route::post('/update', 'ProductosController@update')->name('u_update');
        Route::post('/cambiaEstado', 'ProductosController@cambiaEstado')->name('cambiaEstado');
        Route::post('/historialPrecio', 'ProductosController@historialPrecio')->name('historialPrecio');
        Route::post('/setPrecio', 'ProductosController@setPrecio')->name('setPrecio');
        Route::post('/setOferta', 'ProductosController@setOferta')->name('setOferta');
        Route::post('/quitarOferta', 'ProductosController@quitarOferta')->name('quitarOferta');
        Route::post('/searchOffer', 'ProductosController@searchOffer')->name('searchOffer');
        Route::post ('/historialPrecioProducto', 'ProductosController@historialPrecioProducto')->name('historialPrecioProducto');
        Route::get('/getProductosPrecios', 'ProductosController@getProductosPrecios')->name('getProductosPrecios');
        
        
    });
    Route::prefix("/reportes")->middleware(['auth'])->group(function () {
    
        //RUTAS PRODUCTOS
        Route::get('/reportes', 'ReporteController@index')->name('reportes');
        Route::get('/getProveedores', 'ReporteController@getProveedores')->name('getProveedores');
        /* Route::get('/index', 'ProductosController@index')->name('productos');
        Route::post('/store', 'ProductosController@store')->name('u_store');
        Route::post('/delete', 'ProductosController@delete')->name('u_delete');
        Route::post('/update', 'ProductosController@update')->name('u_update');
        Route::post('/cambiaEstado', 'ProductosController@cambiaEstado')->name('cambiaEstado');
        Route::post('/historialPrecio', 'ProductosController@historialPrecio')->name('historialPrecio');
        Route::post('/setPrecio', 'ProductosController@setPrecio')->name('setPrecio'); */
        
    });
    
    Route::prefix("/ventas")->middleware(['auth'])->group(function () {
    
        //RUTAS VENTAS
        Route::post('/getVentas', 'VentasController@getVentas')->name('getVentas');
        Route::post('/getVentasProveedor', 'VentasController@getVentasProveedor')->name('getVentasProveedor');
        Route::get('/getVentasMes', 'VentasController@getVentasMes')->name('getVentasMes');
        Route::get('/getVentasProducto', 'VentasController@getVentasProducto')->name('getVentasProducto');
       
        
    });
    
});
