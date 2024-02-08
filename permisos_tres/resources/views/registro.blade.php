
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Solo se debe registrar personal con autorización, desde la pagina de inicio no se debería registrar.-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        @vite(['resources/css/registrarse.css'])
        <title>Registrar</title>
    </head>
    <body>
        <div class="wrapper">
            <!--CSS: container register-->
            <form class="login" action="{{ route('ruta_cargo') }}" method="POST">
                @csrf <!--Este metodo ayuda a que los datos del formulario se puedan enviar -->
                <h2 name="regis" id="regis" class="title">Registrar usuarios</h2><!--registro de datos a la db-->
                <h5 name="nombreApellido" id="nombreApellido"class="text" >1. Nombre y apellido</h5>
                <input type="text" class=" form-control @error('nombreApellido') is-invalid @enderror" value="{{ old('nombreApellido') }}" id="nombreApellido" name="nombreApellido" placeholder="Respuesta:" required>
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                <label for="nombreApellido"></label>
                @error('nombreApellido')<!--Metodo para el manejo de errores -->
                {{ $message }}
                @enderror
                <h5 name="correo" id="correo"class="textos" >2. Correo electronico</h5>
                <input type="email" class=" form-control @error('correo') is-invalid @enderror" value="{{ old('correo') }}" id="correo" name="correo" placeholder="example@example.com" required>
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <label for="correo"></label>
                @error('correo')
                {{ $message }}
                @enderror
                <br>
                <h5 name="contrasena" id="contrasena"class="textos" >3. Contraseña</h5>
                <input type="password" class=" form-control @error('contrasena') is-invalid @enderror" name="contrasena" id="contrasena" placeholder="*******" required>
                <i class="fa fa-key"></i>
                <label for="contrasena"></label>
                @error('contrasena')
                {{ $message }}
                @enderror
                <br>
                <h5 name="cedula" id="cedula"class="textos" >4. Cedula</h5>
                <input type="number" class=" form-control @error('cedula') is-invalid @enderror" name="cedula" id="cedula" placeholder="C.C 104527587" required>
                <i class="fa fa-id-card-o" aria-hidden="true"></i>
                <label for="cedula"></label>
                @error('cedula')
                {{ $message }}
                @enderror
                <br>
                <div class="boton">
                    <button class="btn-lg boton primary spinner" type="submit" name="button1" id="button1"><span  class="state">Continuar </span><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </form><br>
        </div>
    </body>
</html>