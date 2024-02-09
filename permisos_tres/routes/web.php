<?php

use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\AdController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
        return view('welcome');
        })->middleware('auth');

Route::controller(SolicitudController::class)->group(function(){

        // inicio de sesión
        Route::post('/Login', 'login_inicio')->name('ruta_login');
        Route::get('/Login', 'login')->name('ruta_login');
        // 1° parte del Registro (Datos personales)
        Route::get('/Register', 'register')->name('ruta_registrar')->middleware('auth'); //GET:Se envían los datos por URL
        Route::post('/Register', 'register')->name('ruta_registrar')->middleware('auth'); //POST:Se envían los datos de forma oculta
        // 2° parte del Registro (Datos de la empresa)
        Route::get('/Register/Cargo', 'registrar')->name('ruta_cargo')->middleware('auth');
        Route::post('/Register/Cargo', 'registrar')->name('ruta_cargo')->middleware('auth'); 
        //Ruta de la vista principal
        Route::post('/Registrado', 'principal')->name('ruta_principal');
        Route::get('/Registrado', 'principal')->name('ruta_principal')->middleware('auth');
        // cierre de sesión
        Route::post('/logout', 'logout')->name('auth.logout')->middleware('auth');
        // Ruta para un nuevo permiso empleados
        Route::post('/Permisos', 'permisos')->name('ruta_permisos')->middleware('auth');
        Route::get('/Permisos', 'permisos')->name('ruta_permisos')->middleware('auth');
        // Ruta para ver los permisos de empleados
        Route::post('/Registros', 'registros')->name('ruta_registros')->middleware('auth');
        Route::get('/Registros', 'registros')->name('ruta_registros')->middleware('auth');
        // Ruta para lideres y jefes inmediatos puedan ver todos los permisos de empleados
        Route::post('/Solicitud-jefe/Revisar', 'solicitudes')->name('ruta_solicitudes')->middleware('auth');
        Route::get('/Solicitud-jefe', 'solicitudes')->name('ruta_solicitudes')->middleware('auth');
        // Ruta para lideres y jefes inmediatos puedan ver todos los permisos pendientes de empleados
        Route::post('/Firmar-jefe/Revisar', 'solicitud')->name('ruta_solicitud')->middleware('auth');
        Route::get('/Firmar-jefe', 'solicitud')->name('ruta_solicitud')->middleware('auth');
        // Ruta para un nuevo permiso  de lideres y superior
        Route::post('/Permisos-jefe', 'permisos')->name('ruta_permisos2')->middleware('auth');
        Route::get('/Permisos-jefe', 'permisos')->name('ruta_permisos2')->middleware('auth');
        //Ruta para firmar cualquier permiso
        Route::any('/Permisos/Firmado', 'firmado')->name('ruta_firmar')->middleware('auth');
        //Ruta para previsualizar cualquier permiso
        Route::post('/Permisos/Prevista', 'prevista')->name('ruta_prevista')->middleware('auth');
        Route::get('/Permisos/Prevista', 'prevista')->name('ruta_prevista')->middleware('auth');
        //Ruta para descargar PDF de cualquier permiso
        Route::post('/Registros/Descargar/{id}', 'descargar')->name('ruta_descargar')->middleware('auth');
        Route::get('/Registros/Descargar/{id}', 'descargar')->name('ruta_descargar')->middleware('auth');
        //Ruta para regresar a la respectiva vista principal
        Route::post('/Volver', 'volver_principal')->name('ruta_volver')->middleware('auth');
        Route::get('/Volver', 'volver_principal')->name('ruta_volver')->middleware('auth');
        //Ruta para ver la vista de aprobar o rechazar el permiso
        Route::post('/Solicitud-jefe/Revisar', 'revisar')->name('ruta_revisar')->middleware('auth');
        Route::get('/Solicitud-jefe/Revisar', 'revisar')->name('ruta_revisar')->middleware('auth');
        //Ruta para ver la vista de aprobar o rechazar el permiso
        Route::post('/Firmar-jefe/Revisar', 'revisar2')->name('ruta_revisar2')->middleware('auth');
        Route::get('/Firmar-jefe/Revisar', 'revisar2')->name('ruta_revisar2')->middleware('auth');
        //Ruta donde se ejecuta el aprobar o rechazar el permiso
        Route::post('/Solicitud-jefe/Revisar/Actualizar', 'actualizar')->name('ruta_actualizar')->middleware('auth');
        Route::get('/Solicitud-jefe/Revisar/Actualizar', 'actualizar')->name('ruta_actualizar')->middleware('auth');
        //Ruta para ver y firmar los permisos por parte de TH
        Route::post('/Autorizar', 'autorizar')->name('ruta_autorizar')->middleware('auth');
        Route::get('/Autorizar', 'autorizar')->name('ruta_autorizar')->middleware('auth');
        //Ruta de proceso de firma de TH
        Route::post('/Autorizar/Firmar', 'firmar')->name('ruta_firmar2')->middleware('auth');
        Route::get('/Autorizar/Firmar', 'firmar')->name('ruta_firmar2')->middleware('auth');
        //Ruta ver los permisos ya firmados
        Route::post('/Revisar', 'archivo')->name('ruta_archivo')->middleware('auth');
        Route::get('/Revisar', 'archivo')->name('ruta_archivo')->middleware('auth');
        //Ruta para las exportaciones en excel y pdf
        Route::get('/Exportar', 'exportar')->name('ruta_exportar')->middleware('auth');
        Route::post('/Exportar', 'exportar')->name('ruta_exportar')->middleware('auth');
});

Route::controller(AdController::class)->group(function(){
        //Rutas para deshabilitar los usuarios, sea individual o por varios usuarios
        Route::post('/Administrador/Delete', 'delete')->name('ruta_borrar')->middleware('auth');
        Route::get('/Administrador/Delete', 'delete')->name('ruta_borrar')->middleware('auth');

        Route::post('/Administrador/Delete/Eliminar/{id}', 'eliminar')->name('ruta_eliminar')->middleware('auth');
        Route::get('/Administrador/Delete/Eliminar/{id}', 'eliminar')->name('ruta_eliminar')->middleware('auth');

        Route::post('/Administrador/Delete/EliminarPack/', 'eliminarpack')->name('ruta_eliminarlos')->middleware('auth');
        Route::get('/Administrador/Delete/EliminarPack/', 'eliminarpack')->name('ruta_eliminarlos')->middleware('auth');
        //Rutas para habilitar los usuarios, sea individual o por varios usuarios
        Route::post('/Administrador/Habilitar', 'habilitar')->name('ruta_habilitar')->middleware('auth');
        Route::get('/Administrador/Habilitar', 'habilitar')->name('ruta_habilitar')->middleware('auth');

        Route::post('/Administrador/Habilitar/Enable/{id}', 'enable')->name('ruta_enable')->middleware('auth');
        Route::get('/Administrador/Habilitar/Enable/{id}', 'enable')->name('ruta_enable')->middleware('auth');

        Route::post('/Administrador/Habilitar/Enablepack', 'enablepack')->name('ruta_enablepack')->middleware('auth');
        Route::get('/Administrador/Habilitar/Enablepack', 'enablepack')->name('ruta_enablepack')->middleware('auth');
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