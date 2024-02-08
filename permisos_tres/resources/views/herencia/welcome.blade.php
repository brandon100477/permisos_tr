<!-- master template of principal page-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/favicon.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/welcome.css')}}">
    <title>Bienvenido</title>
  </head>
  <body class="body">
    <!--Barra de navegación-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        @if (Route::has('ruta_login'))
          @auth
          <a class="navbar-brand text-sm text-gray-700 dark:text-gray-500 underline">Bienvenid@ <b>{{auth()->user()->nombre}}</b></a>
        @else
          <a href="{{ route('login') }}" class="navbar-brand text-sm text-gray-700 dark:text-gray-500 underline">Iniciar sesión</a>
          @endauth
        @endif
        <form class="d-flex" role="search" action="{{ url('logout') }}" method="POST">
          <button class="form-control me-2 d-grid gap-2 col-6 mx-auto btn btn-sm btn-outline-success" type="submit">Cerrar sesión</button>
          @csrf
        </form>
      </div>
    </nav>
    @yield('content')
  </body>
</html>