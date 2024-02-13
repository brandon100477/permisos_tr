@extends('herencia.welcome')
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="{{asset('css/view.css')}}">
        <title>Bienvenido</title>
    </head>
    <body>
        @section('content')
            <div class="contenedor">
                <form method="POST">
                    <div class="col-md-12">
                        <div class="container"> 
                            <h4 id="h4">Habilitar usuarios</h4>
                            <h4 id="h4">Deshabilitar usuarios</h4>
                            <div class="button-borders">
                                <a href="{{ route('ruta_habilitar') }}"  class="primary-button">Habilitar</a>
                            </div>
                            <div class="button-borders">
                                <a href="{{ route('ruta_borrar') }}" class="primary-button">Revisar</a>
                            </div><br><br>
                        </div>
                    </div>
                </form>
            </div>
        @endsection 
    </body>
</html>