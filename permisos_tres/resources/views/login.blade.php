<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <title>Inicio de sesión</title>
        @vite(['resources/css/login.css','resources/js/login.js'])
    </head>
    <body>
        <div class="wrapper">
            <form  class="login" action="{{ route('ruta_login') }}" method="POST">
                <p class="title">Inicio de sesión</p>
                @csrf
                <h4 name="email" id="email">Email</h4>
                <input type="email" class=" form-control @error('email') is-invalid @enderror text" value="{{ old('email') }}" id="email" name="email" placeholder="example@example.com">
                <i class="fa fa-user"></i>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <br><br>
                <h4 name="password" id="password">Password</h4>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="********">
                <i class="fa fa-key"></i>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <br><br>
                <button type="submit">
                    <i class="spinner"></i>
                    <span class="state">Sing In</span>
                </button>
            </form>
            
        </div>
    </body>     
</html>