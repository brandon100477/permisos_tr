@extends('herencia.welcome')
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>Bienvenido</title>
        @vite(['resources/css/empleado/empleado.css'])
    </head>
    <body>
        @section('content')
        <div class="contenedor">
            <form method="POST">
                <div class="col-md-12">
                    <h4 id="h4">Ver los registros solicitados</h4><br>
                    <a href="{{ route('ruta_registros') }}" id="butons">Ver</a><br><br><br><br><!--Boton para ver los registros hasta el momento.-->
                    <h4 id="h4">Solicitar un nuevo permiso</h4><br>
                    <a href="{{ route('ruta_permisos') }}" id="butons">Diligenciar</a><!--Boton para registrar un nuevo formulario.-->
                </div>
            </form>
        </div>
        @endsection 
    </body>
</html>