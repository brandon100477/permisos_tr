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
    }

