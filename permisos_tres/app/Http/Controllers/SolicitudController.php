<?php

namespace App\Http\Controllers;

use App\Models\{permisos, personas, empresa};
use Dompdf\Dompdf;
use Illuminate\Support\Facades\{Auth, DB, hash};
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class SolicitudController extends Controller
{
    public function login(Request $request)
    {//login validación y autenticación usuarios
        return view('login');
    }
    public function login_inicio(Request $request)
    {
        $usuario = personas::where('correo', $request->email)->where('habilitar', 1)->first();
        if (!$usuario) {
            return back()->withErrors(['email' => 'El correo no existe']);// El correo no existe, muestra un mensaje de error
        }
        if($usuario->habilitar == 0){
            return back()->withErrors(['email' => 'El usuario ya no existe']);
        }
        if (Hash::check($request->password, $usuario->password)) {
            $token = auth()->login($usuario);// Obtener el token de acceso del usuario
            $request->session()->put('accessToken', $token);// Almacenar el token de acceso en la sesión del usuario
            $request->session()->regenerate();
            $empresa = empresa::where('id_usuario', $usuario->id)->first();
            //Inicio de filtros para seleccionar vistas
            $empresaTipo = $empresa->empresa;
            $area = $empresa->area;
            $cargo = $empresa->cargo;
            if(in_array($empresaTipo,['0'])){
                return view('admin.view');
            }
            if (in_array($empresaTipo, ['1', '2', '3'])) {
                if (in_array($area, ['1', '2', '3', '4', '5', '6', '7', '8', '9'])) {
                    if ($cargo === '1') {
                        return view('empleado.empleado');
                    }else if (in_array($cargo, ['2', '3', '4', '5'])) {
                        return view('jefe');
                    }elseif (in_array($cargo, ['6'])){
                        return redirect('/Principal-th');
                    }
                }
            }
        }else{
            $errores = [];// Validar errores
            if (!$usuario) {
                $errores['usuario'] = 'El correo no existe';
            }else if (!Hash::check($request->password, $usuario->password)) {
                $errores['password'] = 'La contraseña es incorrecta';
            }
            return back()->withErrors($errores); // Mostrar el mensaje de error si es por contraseña o por correo incorrecto
        }
    }
    public function register()
    {
        return view('registro');
    }
    public function registrar(Request $request)
    {
        $registro = new personas();
        $registro -> nombre= $request -> nombreApellido;
        $registro -> correo = $request -> correo;
        $registro -> password = bcrypt($request->contrasena);//Metodo para encriptar la contraseña por el metodo "Hash"
        $registro -> cedula = $request -> cedula;
        $registro -> habilitar = 1;
        if($registro->nombre === null){
            return redirect('/Register');
        }else{
        $registro ->save(); //Guarda todo el registro.
        return $this->foranea_sesion();
        }
    }
    public function foranea_sesion()
    {
        $personas =personas::all();
        return view('registro2', compact('personas'));//Redirecciona a la pagina del segundo registro para su respectivo logueo
    }
    public function principal(Request $request)
    {
        $registro = new empresa();
        $registro-> id_usuario = $request -> personas;
        $registro -> empresa= $request -> empresa;
        $registro -> area = $request->area; 
        $registro -> cargo = $request -> cargo;
        $registro -> especificacion = $request -> especifi;
        $registro ->save(); //Guarda todo el registro.
        if ($request->cargo === '1') {//Guardado de cargo
            $registro->assignRole('empresario');
        }
        if ($request->cargo === '2') {
            $registro->assignRole('lider');
        }
        if ($request->cargo === '3') {
            $registro->assignRole('director');
        }
        if ($request->cargo === '4') {
            $registro->assignRole('gerente');
        }
        if ($request->cargo === '5') {
            $registro->assignRole('vicepresidente');
        }
        if ($request->cargo === '6') {
            $registro->assignRole('lider_th');
        }
        return redirect('/Principal-th')->with('success', 'Registro exitoso');
    }
    public function logout(Request $request)//Función de cerrar sesión
    {
        Auth::logout(); // Cerrar sesión utilizando el servicio de autenticación
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function permisos(Request $request)
    {
        $id=auth()->user()->id;
        $usuario =personas::where('id', $id)->where('habilitar', 1)->first();
        $id_usuario= $usuario->id;
        $cargo= empresa::where('id_usuario', $id)->first();
        $id_cargo= $cargo->id;//Asignación del cargo
        return view('empleado.nuevo_permiso', compact('id_usuario', 'id_cargo'));//Redirecciona a la pagina de solicitud de permisos
    }
    public function registros()
    {
       /*  $prueba = "Holaaa";
        dd($prueba); */ /* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
        $id=auth()->user()->id;
        $datos = permisos::where('id_usuario', $id)->get();
        
        return view('registros', compact('datos'));//Redirecciona a la pagina donde se ve el registro de permisos por persona
    }
    public function descargar(Request $request, $id)
    {

        if($id === null){ //Condicion para mostrar mensaje de error controlado
            return redirect('/Error');
        }
        $id_usuario=auth()->user()->id;
        $datos_permiso = permisos::where('id', $id)->first();
        $pcl = $datos_permiso->p_c_l;
        $estado = $datos_permiso ->estado_solicitud;
        $fecha_solicitud = $datos_permiso ->fecha_solicitud;
        $hora_inicio = $datos_permiso ->hora_inicio;
        $hora_fin = $datos_permiso ->hora_fin;
        $fecha_inicio = $datos_permiso ->dia_inicio;
        $fecha_fin = $datos_permiso ->dia_fin;
        $justificacion = $datos_permiso ->info_permiso;
        $firma_e = $datos_permiso->firma_empleado;
        $firma_j = $datos_permiso ->firma_jefe;
        $firma_th = $datos_permiso ->firma_th;
        $remunerado = $datos_permiso->remunerado;
        $obs = $datos_permiso->observaciones;
        $id_user = $datos_permiso->id_usuario;
        if($firma_j == null){
            $firma_j = 'descarga.png';
        }
        if($firma_th == null){
            $firma_th = 'descarga.png';
        }
        $datos_persona= personas::where('id', $id_user)->where('habilitar', 1)->first();
        $nombre = $datos_persona->nombre;
        $cedula = $datos_persona->cedula;
        $datos_cargo = empresa::where('id_usuario', $id_user)->first();
        $empresas = [ //asiganción de empresa
            '1' => 'Cedicaf',
            '2' => 'Radiologos Asociados',
            '3' => 'Diaxme Salud',
        ];
        $empresa = $empresas[$datos_cargo->empresa] ?? 'Empresa Desconocida';
        $areas = [//Asignación de areas
            '1' => 'Administrativo',
            '2' => 'Asistencial',
            '3' => 'Comercial',
            '4' => 'Financiera',
            '5' => 'Ingenieria y Biomedica',
            '6' => 'Operaciones y Servicio',
            '7' => 'Talento Humano',
            '8' => 'Tegnologia de la Inf',
        ];
        $cargos = [
            '1' => 'Empresario',
            '2' => 'Líder',
            '3' => 'Director',
            '4' => 'Gerente',
            '5' => 'Vicepresidente',
            '6' => 'Lider T.H',
        ];
        $car = $cargos[$datos_cargo->cargo] ?? 'Área Desconocida';
        $area = $areas[$datos_cargo->area] ?? 'Área Desconocida';
        $especifi= $datos_cargo->especificacion;
        $image_e = public_path('./image_e/'. $firma_e);
        if(!empty($image_j = public_path('./image_j/'. $firma_j))){
            $image_j = public_path('./image_j/'. $firma_j);
        }else{
            $image_j = public_path('./image/rechazado.jpg');
        }
        if(!empty($image_th = public_path('./image_th/'. $firma_th))){
            $image_th = public_path('./image_th/'. $firma_th);
            
        }else{
            $image_th = public_path('./image/rechazado.jpg');
        }
        $image_logo = public_path('./img/logo.jpg');
        $pdf = PDF::loadView('descargar', compact('obs','remunerado','image_th','image_j','image_e','firma_th','firma_j','firma_e','justificacion','cedula','fecha_inicio','fecha_fin','hora_inicio','hora_fin','pcl','fecha_solicitud','nombre','empresa','car','especifi','estado', 'image_logo'));
        return $pdf->download('Permiso.pdf');
    }
    public function prevista(Request $request)
    {   //Datos pasados del controlador
        $pcl = $request->session()->get('pcl');
        $estado = $request->session()->get('estado');
        $hora_inicio = $request->session()->get('hora_inicio');
        $hora_fin = $request->session()->get('hora_fin');
        $fecha_inicio = $request->session()->get('fecha_inicio');
        $fecha_fin = $request->session()->get('fecha_fin');
        $justificacion = $request->session()->get('justificacion');
        $id =auth()->user()->id;
        $usuario = personas::where('id', $id)->where('habilitar', 1)->first();//Datos sacados de la DB usuarios
        $nombre = $usuario->nombre;
        $cedula = $usuario->cedula;
        $cargo = Empresa::where('id_usuario', $id)->first();//Datos sacados de la DB empresa
        $empresas = [ //asiganción de empresa
            '1' => 'Cedicaf',
            '2' => 'Radiologos Asociados',
            '3' => 'Diaxme Salud',
        ];
        $empresa = $empresas[$cargo->empresa] ?? 'Empresa Desconocida';
        $areas = [//Asignación de areas
            '1' => 'Administrativo',
            '2' => 'Asistencial',
            '3' => 'Comercial',
            '4' => 'Financiera',
            '5' => 'Ingenieria y Biomedica',
            '6' => 'Operaciones y Servicio',
            '7' => 'Talento Humano',
            '8' => 'Tegnologia de la Inf',
        ];
        $cargos = [
            '1' => 'Empresario',
            '2' => 'Líder',
            '3' => 'Director',
            '4' => 'Gerente',
            '5' => 'Vicepresidente',
            '6' => 'Lider T.H',
        ];
        $car = $cargos[$cargo->cargo] ?? 'Área Desconocida';
        $area = $areas[$cargo->area] ?? 'Área Desconocida';
        $especifi= $cargo->especificacion;
        $fecha_actual = date('d/m/Y');
        $image_logo = public_path('./img/logo.jpg');
        $pdf = PDF::loadView('prevista', compact('fecha_actual','fecha_inicio','fecha_fin', 'hora_fin', 'hora_inicio', 'estado', 'pcl', 'justificacion', 'nombre','cedula', 'empresa', 'area', 'especifi', 'car', 'image_logo'));
        return $pdf->stream();
    }
    public function solicitud()
    {
        $areas = [1, 3, 4, 5, 7, 8];
        /* Condicional para los gerentes y vicepresidente */
        $id = auth()->user()->id;
        $cargos = Empresa::where('id_usuario', $id)->first();
        if($cargos->cargo ==='1'){ //Condicion para mostrar mensaje de error controlado
            return redirect('/Error');
        };
        $empresa = $cargos->empresa;
        $area = $cargos->area;
        $car = $cargos->cargo;
        if($id === '287'){
            $empleado = Empresa::where('area', $areas)
            ->where('cargo', $car - 1)->pluck('id_usuario')->toArray();
            $especificaciones = Empresa::whereIn('id_usuario', $empleado)->get();
            $usuarios = personas::whereIn('id', $empleado)->get()->where('habilitar', 1);
            $permisos = permisos::whereIn('id_usuario', $empleado)->orderby('fecha_solicitud','asc')->get();
            return view('lider.solicitud', compact('permisos', 'usuarios', 'especificaciones'));
        }


        $empleado = Empresa::/* where('empresa', $empresa)-> */where('area', $area)->where('cargo', $car - 1)->pluck('id_usuario')->toArray();
        $especificaciones = Empresa::whereIn('id_usuario', $empleado)->get();
        $usuarios = personas::whereIn('id', $empleado)->get()->where('habilitar', 1);
        $permisos = permisos::whereIn('id_usuario', $empleado)->orderby('fecha_solicitud','asc')->get();
        return view('lider.solicitud', compact('permisos', 'usuarios', 'especificaciones'));
    }
    public function solicitudes()
    {
        $areas = [1, 3, 4, 5, 7, 8];
        /* Condicional para los gerentes y vicepresidente */
        $id = auth()->user()->id;
        $cargos = Empresa::where('id_usuario', $id)->first();
        if($cargos->cargo ==='1'){ //Condicion para mostrar mensaje de error controlado
            return redirect('/Error');
        };
        $empresa = $cargos->empresa;
        $area = $cargos->area;
        $car = $cargos->cargo;
        if($id === '287'){
            $empleado = Empresa::where('area', $areas)
            ->where('cargo', $car - 1)->pluck('id_usuario')->toArray();
            $especificaciones = Empresa::whereIn('id_usuario', $empleado)->get();
            $usuarios = personas::whereIn('id', $empleado)->get()->where('habilitar', 1);
            $permisos = permisos::whereIn('id_usuario', $empleado)->orderby('fecha_solicitud','asc')->get();
            return view('lider.solicitud', compact('permisos', 'usuarios', 'especificaciones'));
        }
        $empleado = Empresa::where('area', $area)->where('cargo', $car - 1)->pluck('id_usuario')->toArray();
        $especificaciones = Empresa::whereIn('id_usuario', $empleado)->get();
        $usuarios = personas::whereIn('id', $empleado)->where('habilitar', 1)->get();
        $permisos = permisos::whereIn('id_usuario', $empleado)->where('estado_solicitud', 'Pendiente')->orderby('fecha_solicitud','asc')->get();
        return view('lider.solicitudes', compact('permisos', 'usuarios', 'especificaciones'));
    }
    public function firmado(Request $request)
    {    
        $accion = $request->input('submit_action');
        $datos = $request->all();
        if(empty($datos)){ //Condicion para mostrar mensaje de error controlado
           return redirect('/Error');
        }
        
        if ($datos['permiso'] === 'Otro') {// Verifica si se seleccionó "Otro" como motivo del permiso
            $justificacion = $datos['justificado'];// Guarda el valor justificado.
        }else{
            $justificacion = $datos['permiso'];
        }
        if ($request->firma_th === null) {
            $estado = 'Pendiente';// Guarda el valor justificado.
        }else{
            $estado = $request->estado;
        }
        if ($accion === 'prevista') {
            $pcl = $datos['pcl'];
            return redirect()->route('ruta_prevista')->with([
                'estado'=> $estado,
                'pcl' => $pcl,
                'hora_inicio' => $datos['hora_inicio'],
                'hora_fin' => $datos['hora_fin'], 
                'fecha_inicio' =>$datos['fecha_inicio'],
                'fecha_fin' =>$datos['fecha_fin'],
                'justificacion'=>$justificacion,
            ]);
        } elseif ($accion === 'firmar') {
            if (!empty($request->firma_e)) {
                $file_e = time() . "." . $request->firma_e->extension();
                $request->firma_e->move(public_path("image_e"), $file_e);
            } else {
                $file_e = null;
            }
            if (!empty($request->firma_jefe)) {
                $file_j = time() . "." . $request->firma_jefe->extension();
                $request->firma_jefe->move(public_path("image_j"), $file_j);
            } else {
                $file_j = null;
            }
            if (!empty($request->file_th)) {
                $file_th = time() . "." . $request->file_th->extension();
                $request->file_th->move(public_path("image_th"), $file_th);
            } else {
                $file_th = null;
            }
            $fecha_actual = date('d/m/Y');
            $registro = new permisos();
            $registro -> id_usuario = $request -> usuario_id;
            $registro -> id_cargo = $request -> cargo_id;
            $registro -> info_permiso = $justificacion;
            $registro -> fecha_solicitud = $fecha_actual;
            $registro -> hora_inicio = $request-> hora_inicio;
            $registro -> hora_fin = $request-> hora_fin;
            $registro -> dia_inicio = $request-> fecha_inicio;
            $registro -> dia_fin = $request-> fecha_fin;
            $registro -> remunerado = $request -> adicional;
            $registro -> firma_empleado = $file_e;
            $registro -> firma_jefe = $file_j;
            $registro -> firma_th = $file_th;
            $registro -> observaciones = $request-> observaciones;
            $registro -> estado_solicitud = $estado;
            $registro -> p_c_l = $request->pcl;
            $registro->save();
            $cargos = Empresa::where('id', $request->cargo_id)->first();
            $cargo= $cargos->cargo;
            $redirectRoutes = [
                '1' => '/Principal',
                '2' => '/Principal-lider',
                '3' => '/Principal-director',
                '4' => '/Principal-gerente',
                '5' => '/Principal-vicepresidencia',
                '6' => '/Principal-th',
            ];
            if (array_key_exists($cargo, $redirectRoutes)) {// Verifica si $cargo existe en el array de rutas de redirección
                return redirect($redirectRoutes[$cargo]);
            }
        }
    }
    public function volver_principal()
    {//Desde la solicitud de permisos, volver a la vista según corresponda
        $id =auth()->user()->id;
        $cargos = Empresa::where('id_usuario', $id)->first();
        $cargo= $cargos->cargo;
            $redirectRoutes = [
                '1' => '/Principal',
                '2' => '/Principal-lider',
                '3' => '/Principal-director',
                '4' => '/Principal-gerente',
                '5' => '/Principal-vicepresidencia',
                '6' => '/Principal-th',
            ];
            if (array_key_exists($cargo, $redirectRoutes)) {// Verifica si $cargo existe en el array de rutas de redirección
                return redirect($redirectRoutes[$cargo]);
            }
    }
    public function revisar(Request $request)
    {
        $ide = $request->ide;
        if($ide === null){ //Condicion para mostrar mensaje de error controlado
            return redirect('/Error');
        }
        $actualizar = permisos::where('id', $ide)->first();
        $permiso_id = $actualizar->id;
        $id=auth()->user()->id;
        $usuario =personas::where('id', $id)->where('habilitar', 1)->first();
        $id_usuario= $usuario->id;
        $cargo= empresa::where('id_usuario', $id)->first();
        $id_cargo= $cargo->id;//Asignación del cargo
        return view('actualizar', compact('permiso_id','actualizar','id_usuario', 'id_cargo'));//Redirecciona a la pagina de solicitud de permisos
    }
    public function revisar2(Request $request)
    {
        $ide = $request->ide;
        if($ide === null){ //Condicion para mostrar mensaje de error controlado
            return redirect('/Error');
        }
        $actualizar = permisos::where('id', $ide)->first();
        $permiso_id = $actualizar->id;
        $id=auth()->user()->id;
        $usuario =personas::where('id', $id)->where('habilitar', 1)->first();
        $id_usuario= $usuario->id;
        $cargo= empresa::where('id_usuario', $id)->first();
        $id_cargo= $cargo->id;//Asignación del cargo
        return view('actualizar2', compact('permiso_id','actualizar','id_usuario', 'id_cargo'));//Redirecciona a la pagina de solicitud de permisos
    }
    public function actualizar(Request $request)
    {
        $accion = $request->input('submit_action');
        $ide = $request->ide; //id del permiso correspondiente
        $permiso_update = permisos::where('id', $ide)->first();
        $usuario_id = $permiso_update->id_usuario; //id del usuario
        $estado = $permiso_update->estado_solicitud;
        $fecha_solicitud = $permiso_update->fecha_solicitud;
        $pcl = $permiso_update->p_c_l;
        $justificacion = $permiso_update->info_permiso;
        $hora_inicio = $permiso_update->hora_inicio;
        $hora_fin = $permiso_update->hora_fin;
        $fecha_inicio = $permiso_update->dia_inicio;
        $fecha_fin = $permiso_update->dia_fin;
        $firma_e = $permiso_update->firma_empleado;
        $firma_j = $permiso_update->firma_jefe;
        $firma_th = $permiso_update->firma_th;
        $remunerado = $permiso_update->remunerado;
        $obs = $permiso_update->observaciones;
        $image_logo = public_path('./img/logo.jpg');
        if($firma_th == null){
            $firma_th = 'rechazado.jpg';
        }
        if($firma_j == null){
            $firma_j = 'rechazado.jpg';
        }
        $image_e = public_path('./image_e/'. $firma_e);
        $image_j = public_path('./image_j/'. $firma_j);
        $image_th = public_path('./image_th/'. $firma_th);
        $usuario =personas::where('id', $usuario_id)->where('habilitar', 1)->first();
        $nombre = $usuario->nombre;
        $cedula = $usuario->cedula;
        $cargo = Empresa::where('id_usuario', $usuario_id)->first();
        $empresas = [ //asiganción de empresa
            '1' => 'Cedicaf',
            '2' => 'Radiologos Asociados',
            '3' => 'Diaxme Salud',
        ];
        $areas = [//Asignación de areas
            '1' => 'Administrativo',
            '2' => 'Asistencial',
            '3' => 'Comercial',
            '4' => 'Financiera',
            '5' => 'Ingenieria y Biomedica',
            '6' => 'Operaciones y Servicio',
            '7' => 'Talento Humano',
            '8' => 'Tegnologia de la Inf',
        ];
        $cargos = [
            '1' => 'Empresario',
            '2' => 'Líder',
            '3' => 'Director',
            '4' => 'Gerente',
            '5' => 'Vicepresidente',
            '6' => 'Lider T.H',
        ];
        $empresa = $empresas[$cargo->empresa] ?? 'Empresa Desconocida';
        $area = $areas[$cargo->area] ?? 'Área Desconocida';
        $car = $cargos[$cargo->cargo] ?? 'Área Desconocida';
        $especifi = $cargo->especificacion;
        $id = auth()->user()->id;
        $consultas = Empresa::where('id_usuario', $id)->first();
        $consulta = $consultas->cargo;
        if($accion === 'prevista'){
            $pdf = PDF::loadView('descargar', compact('obs','remunerado','image_th','image_j','image_e','firma_th','firma_j','firma_e','justificacion','cedula','hora_inicio','hora_fin','fecha_inicio','fecha_fin','pcl','fecha_solicitud','nombre','empresa','car','especifi','estado', 'image_logo'));            
            return $pdf->stream();
        }else if($accion ==='aprobar'){
            if (!empty($request->firma_jefe)) {
                $file_j = time() . "." . $request->firma_jefe->extension();
                $request->firma_jefe->move(public_path("image_j"), $file_j);
            }else{
                $file_j = null;
            }
            if (!empty($request->firma_th)) {
                $file_th = time() . "." . $request->firma_th->extension();
                $request->firma_th->move(public_path("image_th"), $file_th);
            }else{
                $file_th = null;
            }
            if(!empty($request->firma_th)){
                $datos_actualizar = permisos::findOrfail($ide);
                $datos_actualizar->estado_solicitud = 'Aprobado';
                $datos_actualizar->observaciones = $request->observaciones;
                $datos_actualizar -> remunerado = $request -> adicional;
                $datos_actualizar -> firma_th = $file_th;
                $datos_actualizar -> save();
                
                if(in_array($consulta,['2','3','4','5'])){
                   
                    return redirect('/Solicitud-jefe');
                }else if(in_array($consulta,['6'])){
                    return redirect('/Autorizar');
                }
            }else{
                $datos_actualizar = permisos::findOrfail($ide);
                $datos_actualizar->estado_solicitud = 'Aprobado';
                $datos_actualizar->observaciones = $request->observaciones;
                $datos_actualizar -> remunerado = $request -> adicional;
                $datos_actualizar -> firma_jefe = $file_j;
                $datos_actualizar -> save();
                if(in_array($consulta,['2','3','4','5'])){
                    return redirect('/Solicitud-jefe');
                }else if(in_array($consulta,['6'])){
                    return redirect('/Autorizar');
                }
            }
        }else{
            if (!empty($request->firma_jefe)) {
                $file_j = time() . "." . $request->firma_jefe->extension();
                $request->firma_jefe->move(public_path("image_j"), $file_j);
            }else{
                $file_j = null;
            }
            if (!empty($request->firma_th)) {
                $file_th = time() . "." . $request->firma_th->extension();
                $request->firma_th->move(public_path("image_th"), $file_th);
            }else{
                $file_th = null;
            }
            if(!empty($request->firma_th)){
                $datos_actualizar = permisos::findOrfail($ide);
                $datos_actualizar->estado_solicitud = 'Rechazado';
                $datos_actualizar->observaciones = $request->observaciones;
                $datos_actualizar -> remunerado = $request -> adicional;
                $datos_actualizar -> firma_th = $file_th;
                $datos_actualizar -> save();
                if(in_array($consulta,['2','3','4','5'])){
                    return redirect('/Solicitud-jefe');
                }else if(in_array($consulta,['6'])){
                    return redirect('/Autorizar');
                }
            }else{
                $datos_actualizar = permisos::findOrfail($ide);
                $datos_actualizar->estado_solicitud = 'Rechazado';
                $datos_actualizar->observaciones = $request->observaciones;
                $datos_actualizar -> remunerado = $request -> adicional;
                $datos_actualizar -> firma_jefe = $file_j;
                $datos_actualizar -> save();
                if(in_array($consulta,['2','3','4','5'])){
                    return redirect('/Solicitud-jefe');
                }else if(in_array($consulta,['6'])){
                    return redirect('/Autorizar');
                }
            }
        }
    }
    public function autorizar(Request $request)
    {//Visualizar que permisos se han tomado para darles la ultima autorización
        $id=auth()->user()->id;
        $cargos = Empresa::where('id_usuario', $id)->first();
        $empresa = $cargos->empresa;
        $area = $cargos->area;
        $car= $cargos->cargo;
        $especificacion = $cargos ->especificacion;
        if($car === '6'){
            $empleado = Empresa::all()->pluck('id_usuario')->toArray();
            $especificaciones = Empresa::whereIn('id_usuario', $empleado)->get();
            $usuarios = personas::WhereIn('id',$empleado)->where('habilitar', 1)->get();
            $permisos = permisos::whereNotNull('firma_jefe')->where('firma_th', null)->get();
            return view('th.revisar', compact('permisos', 'usuarios', 'especificaciones'));
        }else if($car === '1' || $car === '2'|| $car === '3'|| $car === '4' || $car === '5'){
                return redirect('/Error');
        }
    return view('th.princial');
    }
    public function archivo(Request $request)
    //Desde la solicitud de permisos, volver a la vista según corresponda
    {
        $filtro_inicio = $request->input('fecha_inicio');
        $filtro_fin = $request->input('fecha_fin');
        $filtro_inicio_db = !empty($filtro_inicio) ? Carbon::createFromFormat('Y-m-d', $filtro_inicio)->format('d/m/Y') : null;//Declaración para los filtros 
        $filtro_fin_db = !empty($filtro_fin) ? Carbon::createFromFormat('Y-m-d', $filtro_fin)->format('d/m/Y') : null;

        $id=auth()->user()->id;
        $cargos = Empresa::where('id_usuario', $id)->first();
        $empresa = $cargos->empresa;
        $area = $cargos->area;
        $car= $cargos->cargo;
        $especificacion = $cargos ->especificacion;
        if($car === '6'){
            $empleado = Empresa::all()->pluck('id_usuario')->toArray();
            $especificaciones = Empresa::whereIn('id_usuario', $empleado)->get();
            $usuarios = personas::WhereIn('id',$empleado)->get(); //Poner el 'Where' Para filtrar entre los habilitados y no habilitados.
            $permisos = permisos::whereNotNull('firma_th')
            ->where(function ($query) use ($filtro_inicio_db, $filtro_fin_db){
                if (!empty($filtro_inicio_db) && !empty($filtro_fin_db)){
                    $query->whereBetween(DB::raw("STR_TO_DATE(fecha_solicitud, '%d/%m/%Y')"), [
                        Carbon::createFromFormat('d/m/Y', $filtro_inicio_db)->startOfDay(),
                        Carbon::createFromFormat('d/m/Y', $filtro_fin_db)->endOfDay(),
                    ]);
                }
            })->get();
            /* $delete = permisos::where('id_usuario', null)->get(); */
            return view('th.archivo', compact('permisos', 'usuarios', 'especificaciones', 'filtro_inicio', 'filtro_fin'));
        }else if($car === '1' || $car === '2'|| $car === '3'|| $car === '4' || $car === '5'){ //Condicion para mostrar mensaje de error controlado
            return redirect('/Error');
        }
        return view('th.princial');
    }
    public function firmar(Request $request)
    {
        $ide = $request->ide;
        if($ide === null){ //Condicion para mostrar mensaje de error controlado
            return redirect('/Error');
        }
        $actualizar = permisos::where('id', $ide)->first();
        $permiso_id = $actualizar->id;
        $id=auth()->user()->id;
        $usuario =personas::where('id', $id)->where('habilitar', 1)->first();
        $id_usuario= $usuario->id;
        $cargo= empresa::where('id_usuario', $id)->first();
        $id_cargo = $cargo->id;//Asignación del cargo
        return view('th.firmar', compact('permiso_id','actualizar','id_usuario', 'id_cargo'));//Redirecciona a la pagina de solicitud de permisos
    }

    public function exportar(Request $request){

        $accion = $request->input('submit_action');
        $boxes = $request->seleccionados;
        if( empty($boxes)){
            dd("Error. Check vacio");
        }
        $areas = [//Asignación de areas
            '1' => 'Administrativo',
            '2' => 'Asistencial',
            '3' => 'Comercial',
            '4' => 'Financiera',
            '5' => 'Ingenieria y Biomedica',
            '6' => 'Operaciones y Servicio',
            '7' => 'Talento Humano',
            '8' => 'Tegnologia de la Inf',
        ];
        $permisos = permisos::whereIn('id', $boxes)->get();
        foreach($permisos as $permiso){
            if($permiso->id_usuario == null){/* CAMBIO PARA SABER SI USUARIO EXISTE */
                $client [] = "PEDRO"; /* Aquí tendría que venir el campo nuevo y seguarda el nombre en client */
            }
            $id_usuario[] = $permiso ->id_usuario;
            $id_cargo []= $permiso ->id_cargo;
            $pcl []= $permiso->p_c_l;
            $fecha[]= $permiso->fecha_solicitud;
            $estado[] = $permiso->estado_solicitud;
            $remunerado[] = $permiso->remunerado;
            $info[] = $permiso->info_permiso;
            $diaini[] = $permiso->dia_inicio;
            $diafin[] = $permiso->dia_fin;
        }
        $user =[];
        foreach($id_usuario as $id){
            $user = personas::where('id', $id)->where('habilitar', 1)->get();
            $users[] = $user;
        }
        foreach($users as $personas){
            foreach($personas as $person){
                $client[] =$person->nombre;
            }
        }
        /* dd($client); */
        $cargos =[];
        foreach($id_cargo as $ids){
            $cargos = empresa::where('id', $ids)->get();
            $especificaciones[] = $cargos;
        }
        foreach($especificaciones as $especifi){
            foreach($especifi as $especi){
                $cargo []= $especi->especificacion; 
                $area [] = $areas[$especi->area] ?? 'Área Desconocida';
            }
        }
        $cont = count($boxes) + 1;
        if($accion == 'botton1'){
        {
            // Crea una nueva hoja de cálculo
            $spreadsheet = new Spreadsheet();
            // Agrega los encabezados de las columnas y estilos
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Tipo de permiso');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Nombre');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Fecha de solicitud');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Aprobado / Rechazado');
            $spreadsheet->getActiveSheet()->setCellValue('E1', 'Remunerado');
            $spreadsheet->getActiveSheet()->setCellValue('F1', 'Solicitado por');
            $spreadsheet->getActiveSheet()->setCellValue('G1', 'Dia de inicio');
            $spreadsheet->getActiveSheet()->setCellValue('H1', 'Dìa fin');
            $spreadsheet->getActiveSheet()->setCellValue('I1', 'Area');
            $spreadsheet->getActiveSheet()->setCellValue('J1', 'Especificación de cargo');
            
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(35);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(28);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(40);

            $spreadsheet->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Centrar los encabezados
            $spreadsheet->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true); // Negrita
            $spreadsheet->getActiveSheet()->getStyle('A1:J1')->getFont()->setSize(15); $i=2; $j=0;// Tamaño personalizado
            // Recorre los datos y los escribe en la hoja de cálculo
            
                for( $i = 2; $i<=$cont; $i++){
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $pcl[$j]);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $client[$j]);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $fecha[$j]);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $estado[$j]);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $i, $remunerado[$j]);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $i, $info[$j]);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $i, $diaini[$j]);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $i, $diafin[$j]);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $i, $area[$j]);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $i, $cargo[$j]);
                    $j++;
                };
            // Guarda el archivo Excel en un directorio temporal
            $writer = new Xlsx($spreadsheet);
            $tempPath = tempnam(sys_get_temp_dir(), 'registro_');
            $writer->save($tempPath);
            // Envía el archivo Excel al navegador
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Registro.Xlsx"');
            header('Cache-Control: max-age=0');
            readfile($tempPath);
            // Elimina el archivo Excel temporal
            unlink($tempPath);
        };
    }else{
        return $this->pdfs($boxes);
    }
    }
    public function pdfs($boxes){
        $datos = permisos::whereIn('id', $boxes)->get();
        $pdf = new Dompdf();
        foreach($datos as $datos_permiso){
            $pcl [] = $datos_permiso->p_c_l;
            $estado[] = $datos_permiso ->estado_solicitud;
            $fecha_solicitud[] = $datos_permiso ->fecha_solicitud;
            $hora_inicio[] = $datos_permiso ->hora_inicio;
            $hora_fin []= $datos_permiso ->hora_fin;
            $fecha_inicio[] = $datos_permiso ->dia_inicio;
            $fecha_fin []= $datos_permiso ->dia_fin;
            $justificacion[] = $datos_permiso ->info_permiso;
            $firma_empleo[] = $datos_permiso->firma_empleado;
            $firma_j[] = $datos_permiso ->firma_jefe;
            $firma_th []= $datos_permiso ->firma_th;
            $remunerado[] = $datos_permiso->remunerado;
            $obs[] = $datos_permiso->observaciones;
            $id_user[] = $datos_permiso->id_usuario;
            $id_cargo[] = $datos_permiso ->id_cargo;
            if($firma_j == null){
                $firma_j = 'descarga.png';
            }
            if($firma_th == null){
                $firma_th = 'descarga.png';
            }
        };
        $cont = count($boxes);
        $user =[];
        foreach($id_user as $id){
            $user = personas::where('id', $id)->where('habilitar', 1)->get();
            $users[] = $user;
        }
        foreach($users as $personas){
            foreach($personas as $person){
                $nombre[] =$person->nombre;
                $cedula[] = $person->cedula;
            }
        }
        $empresas = [ //asiganción de empresa
            '1' => 'Cedicaf',
            '2' => 'Radiologos Asociados',
            '3' => 'Diaxme Salud',
        ];
        $areas = [//Asignación de areas
            '1' => 'Administrativo',
            '2' => 'Asistencial',
            '3' => 'Comercial',
            '4' => 'Financiera',
            '5' => 'Ingenieria y Biomedica',
            '6' => 'Operaciones y Servicio',
            '7' => 'Talento Humano',
            '8' => 'Tegnologia de la Inf',
        ];
        $cargos = [
            '1' => 'Empresario',
            '2' => 'Líder',
            '3' => 'Director',
            '4' => 'Gerente',
            '5' => 'Vicepresidente',
            '6' => 'Lider T.H',
        ];
        $data =[];
        foreach($id_cargo as $ids){
            $data = empresa::where('id', $ids)->get();
            $especificaciones[] = $data;
        }
        foreach($especificaciones as $especifis){
            foreach($especifis as $especi){
                $cargos[] =$especi->cargo;
                $especifi [] = $especi->especificacion;
                $empresa[] = $empresas[$especi->empresa] ?? 'Empresa Desconocida';
                $car [] = $cargos[$especi->cargo] ?? 'Área Desconocida';
            }
        }
        foreach($firma_empleo as $firma_e){
            $image_e[] =  public_path('./image_e/'. $firma_e);
        }
        foreach($firma_j as $firma_jefe){
            $image_j []= public_path('./image_j/'. $firma_jefe);
        }
        foreach($firma_th as $firma_talento){
            $image_th []= public_path('./image_th/'. $firma_talento);
        }
        $image_logo = public_path('./img/logo.jpg');
        $data =[];/* Mapeo de los datos optenidos para tener un array de arrays */
        for($i = 0; $i<$cont;$i++){
            $data[] = [
                'obs' => $obs[$i] ?? '',
                'remunerado' => $remunerado[$i] ?? '',
                'image_th' => $image_th[$i] ?? '',
                'image_j' => $image_j[$i] ?? '',
                'image_e' => $image_e[$i] ?? '',
                'justificacion' => $justificacion[$i] ?? '',
                'cedula' => $cedula[$i] ?? '',
                'fecha_inicio' => $fecha_inicio[$i] ?? '',
                'fecha_fin' => $fecha_fin[$i] ?? '',
                'hora_inicio' => $hora_inicio[$i] ?? '',
                'hora_fin' => $hora_fin[$i] ?? '',
                'pcl' => $pcl[$i] ?? '',
                'fecha_solicitud' => $fecha_solicitud[$i] ?? '',
                'nombre' => $nombre[$i] ?? '',
                'empresa' => $empresa[$i] ?? '',
                'car' => $car[$i] ?? '',
                'especifi' => $especifi[$i] ?? '',
                'estado' => $estado[$i] ?? '',
                'image_logo' => $image_logo ?? ''
            ];
        }
        $pdf = PDF:: loadView('descargarpack',['alls' =>$data]);
        return $pdf->download('pack_permisos.pdf');
    }
}