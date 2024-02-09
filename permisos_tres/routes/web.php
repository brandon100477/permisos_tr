<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\AdController;
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
    return view('welcome');
    })->middleware('auth');

    Route::controller(SolicitudController::class)->group(function(){
        Route::post('/Login', 'login_inicio')->name('ruta_login');
        Route::get('/Login', 'login')->name('ruta_login');
    });

    Route::get('/Principal', function () { //Ruta para volver a la vista principal de empleados
        return view('empleado.empleado');})->middleware('auth');

Route::get('/Solicitud-jefe/volver', function () { //Ruta para volver a la vista donde se solicitan los permisos - es una vista de lideres y superiores
        return redirect('/Solicitud-jefe');})->middleware('auth')->name('ruta_volver1');

Route::get('/Autorizar/volver', function () { //Ruta para volver a la vista donde se ven todos los permisos que faltan por firmar por parte de TH
        return redirect('/Autorizar');})->middleware('auth')->name('ruta_volver2');

Route::get('/Firmar-jefe/volver', function () { //Ruta para volver a la vista donde se ven todos los permisos que faltan por firmar por parte de TH
        return redirect('/Firmar-jefe');})->middleware('auth')->name('ruta_volver3');

Route::get('/Administrador/volver', function () { //Ruta para volver a la vista de Admin
        return redirect('/Administrador');})->middleware('auth')->name('ruta_volver4');

Route::get('/Principal-lider', function () { //Ruta para volver a principal lider
        return view('jefe');})->middleware('auth');

Route::get('/Principal-director', function () { //Ruta para volver a principal director
        return view('jefe');})->middleware('auth');

Route::get('/Principal-gerente', function () { //Ruta para volver a principal gerente
        return view('jefe');})->middleware('auth');

Route::get('/Principal-vicepresidencia', function () { //Ruta para volver a principal vicepresidencia
        return view('jefe');})->middleware('auth');

Route::get('/Principal-th', function () { //Ruta para volver a principal TH
        return view('th.principal');})->middleware('auth');

Route::get('/Administrador', function () { //Ruta para 
        return view('admin.view');})->middleware('auth');

Route::get('/Error', function () { //Ruta para hacer pruebas
        return view('prueba');})->middleware('auth');