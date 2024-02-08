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
        @vite(['resources/css/jefe/jefe.css'])
    </head>
    <body>
        @section('content')
            <div class="contenedor">
                <form method="POST">
                    <div class="col-md-12">
                        <div class="container"> 
                            <h4 id="h4">Ver los registros pendientes</h4>
                            <h4 id="h4">Previsualizar los permisos</h4>
                            <div>
                                <a href="{{ route('ruta_solicitudes') }}" id="butons">Ver</a>
                            </div>
                            <div>
                                <a href="{{ route('ruta_solicitud') }}" id="butons">Ver</a>
                            </div><br><br>
                        </div>
                        <h4 id="h4">Ver los registros solicitados</h4>
                        <div>
                            <a href="{{ route('ruta_registros') }}" id="butons">Ver</a>
                        </div><br><br><br>
                        <h4 id="h4">Solicitar un nuevo permiso</h4>
                        <div>
                            <a href="{{ route('ruta_permisos2') }}" id="butons">Diligenciar</a>
                        </div>
                    </div>
                </form>
            </div>
        @endsection 
    </body>
</html>