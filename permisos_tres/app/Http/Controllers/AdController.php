<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{personas};

class AdController extends Controller
{
    public function delete(Request $request)
    {//login validación y autenticación usuarios
        $cedula = $request->input('cedula');
        $id=auth()->user()->id;
        $num= 1;
        $personas = personas::where('id', '!=', $id)->where('cedula', 'like', '%' . $cedula. '%' )->where('habilitar', 1)->get();
        return view('admin.delete', compact('personas', 'cedula', 'num'));
    }
    public function eliminar($id){
        $personas=personas::findOrfail($id);// Realiza la lógica de eliminación.
        $personas->habilitar = 0;
        $personas->save();
        return redirect()->back()->with('success', 'Registro eliminado exitosamente');// Redirecciona de vuelta a la página anterior
    }
    public function eliminarpack(Request $request){
        $boxes = $request->seleccionados;
        $personas=personas::whereIn('id', $boxes)->get();
        foreach($personas as $persona){
            $persona->habilitar = 0;
            $persona->save();
        }
        return redirect()->back()->with('success', 'Registros eliminados exitosamente');
    }
    public function habilitar(Request $request)
    {//login validación y autenticación usuarios
        $cedula = $request->input('cedula');
        $id=auth()->user()->id;
        $num= 1;
        $personas = personas::where('id', '!=', $id)->where('cedula', 'like', '%' . $cedula. '%' )->where('habilitar', 0)->get();
        return view('admin.vdele', compact('personas', 'cedula', 'num'));
    }
    public function enable($id)
    {                
        $personas=personas::findOrfail($id);
        $personas->habilitar = 1;
        $personas->save();
        return redirect()->back()->with('success', 'Registro habilitado exitosamente'); // Redirecciona de vuelta a la página anterior
    }
    public function enablepack(Request $request)
    {        
        $boxes = $request->seleccionados;
        $personas=personas::whereIn('id', $boxes)->get();
        foreach($personas as $persona){
            $persona->habilitar = 1;
            $persona->save();
        }
        return redirect()->back()->with('success', 'Registros eliminados exitosamente');
    }
    }