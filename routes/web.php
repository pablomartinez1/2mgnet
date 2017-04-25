<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', function () {
	if(Auth::guest())
	{
		$users = DB::table('users')->orderBy('id', 'asc')->get();
  	return view('welcome')->with('users', $users);
	}
	else {
		return redirect('home');
	}
});

Auth::routes();

Route::get('/test', 'HomeController@test');

Route::get('/home', 'HomeController@index');

Route::get('/abm/clientes', 'ClientesController@clientes');
Route::get('/abm_acciones/nuevocliente', 'ClientesController@nuevocliente');
Route::post('/crearcliente', 'ClientesController@crearcliente');
Route::get('/abm_acciones/editarcliente/{id}', 'ClientesController@editarcliente');
Route::get('/abm_acciones/mostrarcliente/{id}', 'ClientesController@mostrarcliente');
Route::post('/abm_acciones/actualizarcliente/{id}', 'ClientesController@actualizarcliente');
Route::get('/eliminarcliente/{id}', 'ClientesController@eliminarcliente');
Route::post('/abm/clientes', 'ClientesController@filtrarclientes');

Route::get('/abm/contactos', 'ContactosController@contactos');
Route::get('/abm_acciones/nuevocontacto', 'ContactosController@nuevocontacto');
Route::post('/crearcontacto', 'ContactosController@crearcontacto');
Route::get('/abm_acciones/mostrarcontacto/{id}', 'ContactosController@mostrarcontacto');
Route::get('/abm_acciones/editarcontacto/{id}', 'ContactosController@editarcontacto');
Route::post('/abm_acciones/actualizarcontacto/{id}', 'ContactosController@actualizarcontacto');
Route::get('/eliminarcontacto/{id}', 'ContactosController@eliminarcontacto');
Route::post('/abm/contactos', 'ContactosController@filtrarcontactos');

Route::get('/abm/eventos', 'EventosController@eventos');
Route::get('/abm_acciones/nuevoevento', 'EventosController@nuevoevento');
Route::post('/crearevento', 'EventosController@crearevento');
Route::get('/abm_acciones/editarevento/{id}', 'EventosController@editarevento');
Route::get('/abm_acciones/mostrarevento/{id}', 'EventosController@mostrarevento');
Route::post('/abm_acciones/actualizarevento/{id}', 'EventosController@actualizarevento');
Route::get('/eliminarevento/{id}', 'EventosController@eliminarevento');
Route::post('/abm/eventos', 'EventosController@filtrareventos');

Route::get('/abm/venues', 'VenuesController@venues');
Route::get('/abm_acciones/nuevovenue', 'VenuesController@nuevovenue');
Route::post('/crearvenue', 'VenuesController@crearvenue');
Route::get('/abm_acciones/editarvenue/{id}', 'VenuesController@editarvenue');
Route::get('/abm_acciones/mostrarvenue/{id}', 'VenuesController@mostrarvenue');
Route::post('/abm_acciones/actualizarvenue/{id}', 'VenuesController@actualizarvenue');
Route::get('/eliminarvenue/{id}', 'VenuesController@eliminarvenue');
Route::post('/abm/venues', 'VenuesController@filtrarvenues');

Route::get('/abm/proveedores', 'ProveedoresController@proveedores');
Route::get('/abm_acciones/nuevoproveedor', 'ProveedoresController@nuevoproveedor');
Route::post('/crearproveedor', 'ProveedoresController@crearproveedor');
Route::get('/abm_acciones/editarproveedor/{id}', 'ProveedoresController@editarproveedor');
Route::get('/abm_acciones/mostrarproveedor/{id}', 'ProveedoresController@mostrarproveedor');
Route::post('/abm_acciones/actualizarproveedor/{id}', 'ProveedoresController@actualizarproveedor');
Route::get('/eliminarproveedor/{id}', 'ProveedoresController@eliminarproveedor');
Route::post('/abm/proveedores', 'ProveedoresController@filtrarproveedores');

Route::get('/abm/contrataciones', 'ContratacionesController@contrataciones');
Route::post('/crearcontratacion', 'ContratacionesController@crearcontratacion');
Route::post('/abm/contrataciones', 'ContratacionesController@filtrarcontrataciones');

Route::get('/abm/servicios', 'ServiciosController@servicios');
Route::post('/crearservicio', 'ServiciosController@crearservicio');
Route::post('/abm/servicios', 'ServiciosController@filtrarservicios');

Route::get('/abm/venuesalas', 'VenueSalasController@venuesalas');
Route::get('/abm_acciones/nuevasala/{id}', 'VenueSalasController@nuevasala');
Route::post('/crearsalas', 'VenueSalasController@crearsalas');
Route::get('/abm_acciones/editarsala/{id}', 'VenueSalasController@editarsala');
Route::get('/abm_acciones/mostrarsala/{id}', 'VenueSalasController@mostrarsala');
Route::post('/abm_acciones/actualizarsala/{id}', 'VenueSalasController@actualizarsala');
Route::get('/eliminarsalas/{id}', 'VenueSalasController@eliminarsalas');
Route::post('/abm/venuesalas', 'VenueSalasController@filtrarvenuesalas');

/*
Route::get('/abm/clientesfinales', 'ClientesFinalesController@clientesfinales');
Route::get('/abm_acciones/nuevoclientefinal', 'ClientesFinalesController@nuevoclientefinal');
Route::post('/crearclientefinal', 'ClientesFinalesController@crearclientefinal');
Route::get('/abm_acciones/editarclientefinal/{id}', 'ClientesFinalesController@editarclientefinal');
Route::get('/abm_acciones/mostrarclientefinal/{id}', 'ClientesFinalesController@mostrarclientefinal');
Route::post('/abm_acciones/actualizarclientefinal/{id}', 'ClientesFinalesController@actualizarclientefinal');
Route::get('/eliminarclientefinal/{id}', 'ClientesFinalesController@eliminarclientefinal');
Route::post('/abm/clientesfinales', 'ClientesFinalesController@filtrarclientesfinales');
*/

Route::get('/cambiarpassword', 'HomeController@cambiarpassword');
Route::post('/cambiarpassword/reset', 'HomeController@actualizarpassword');

Route::get("/excel/clientes", "ExcelController@clientes");
Route::get("/excel/contactos", "ExcelController@contactos");
Route::get("/excel/eventos", "ExcelController@eventos");
Route::get("/excel/venues", "ExcelController@venues");
Route::get("/excel/proveedores", "ExcelController@proveedores");
