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
	// return view('login');
	return redirect()->route('login');
});
Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
Route::resource('oficinas', 'OficinaController');


Route::get('perfil/imagen', 'PerfilController@getImagen');
Route::post('perfil/imagen', 'PerfilController@postImagen');
Route::get('perfil/password', 'PerfilController@getPassword');
Route::post('perfil/password', 'PerfilController@postPassword');
Route::get('perfil/edit', 'PerfilController@edit');
Route::resource('perfil', 'PerfilController');

Route::resource('notificaciones', 'NotificacionController');

Route::get('metas/{meta_id}/requisitos/create', 'RequisitoController@create')->name('requisito.create');
Route::get('metas/{meta_id}/requisitos/{requisito_id}/edit', 'RequisitoController@edit')->name('requisito.edit');
Route::resource('requisitos', 'RequisitoController');

Route::post('users/post_js', 'UserController@post_js');
Route::resource('users', 'UserController',['except'=> [
	'pass'
]]);

Route::get('users/pass/{user_id}','UserController@pass');

Route::post('actividades/post_js', 'ActividadController@post_js');
Route::get('actividades/asignaciones', 'ActividadController@asignaciones');
Route::get('actividades/creaciones', 'ActividadController@creaciones');
Route::get('actividades/monitoreos', 'ActividadController@monitoreos');
Route::get('actividades/todas', 'ActividadController@todas');
Route::get('actividades/oficina', 'ActividadController@oficina')->name('actividades.oficina');
Route::resource('actividades', 	'ActividadController');
Route::resource('responsables', 'ResponsableController');

Route::get('javascript', 'JavascriptController@index');
Route::post('javascript', 'JavascriptController@funciones');



Route::resource('metas', 		'MetaController', ['except' => [
	'create',
	'edit',
	'show'
]]);
Route::get('actividades/{actividad}/metas/create', 		'MetaController@create')	->name('metas.create');
Route::get('actividades/{actividad}/metas/edit/{meta}', 'MetaController@edit')		->name('metas.edit');
Route::get('actividades/{actividad}/metas/{meta}', 		'MetaController@show')		->name('metas.show');
Route::put('metas/{meta}/responsables',					'MetaController@regResp')	->name('metas.regResp');

Route::get('actividades/{actividad}/informacion/create', 		'ActividadController@informacion')	->name('actividad.informacion');
Route::put('actividades/{actividad}/informacion/informarcioneditar', 		'ActividadController@informacioneditar')	->name('actividad.informacioneditar');

Route::put('indicadores/{indicador}/actividad/valor', 		'ActividadController@valor')	->name('actividad.valor');

Route::get('actividades/{actividad}/metas/{meta}/informacion/create', 		'MetaController@informacion')	->name('meta.informacion');
Route::put('actividades/0/metas/{meta}/informacion/informarcioneditar', 		'MetaController@informacioneditar')	->name('meta.informacioneditar');

Route::resource('gastos', 								'GastoController', ['except' => [
	'create',
	'edit',
	'show'
]]);
Route::get('metas/{meta}/gastos/create', 		'GastoController@create')	->name('gastos.create');
Route::get('metas/{meta}/gastos/{gasto}/edit', 	'GastoController@edit')		->name('gastos.edit');

Route::resource('monitoreo', 						'MonitoreoController', ['except' => [
	'create',
	'edit',
	'show'
]]);
Route::get('metas/{meta}/monitoreo/create', 			'MonitoreoController@create')	->name('monitoreo.create');
Route::get('metas/{meta}/monitoreo/{monitoreo}/edit', 	'MonitoreoController@edit')		->name('monitoreo.edit');


Route::resource('indicadores', 'IndicadorController');

Route::get('reportes', 'ReportesController@index');
Route::post('reporte', 'ReportesController@reporte')->name('reportes.generar');
Route::post('reporte2', 'ReportesController@reporte2')->name('reportes.generar2');

Route::get('manual', 'HomeController@manual')->name('manual');
