@extends('herencia.welcome')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('../../css/registro.css')}}">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>Bienvenido</title>
        @vite(['resources/css/th/principal.css'])
    </head>
    <body>
        @section('content')
        <div class="contenedor">
            <form method="POST">
                <div class="col-md-12">
                    <h4 id="h4">Registrar usuarios.</h4>
                        <a href="{{ route('ruta_registrar') }}" id="butons">Registrar</a><br><br>
                    <h4 id="h4">Ver los registros solicitados.</h4>
                        <a href="{{ route('ruta_autorizar') }}" id="butons">Ver</a><br><br>
                    <h4 id="h4">Ver todos los registro ya firmados</h4>
                        <a href="{{ route('ruta_archivo') }}" id="butons">Ver</a><br><br>
                </div>
            </form>
        </div>
        @endsection
    </body>
</html>