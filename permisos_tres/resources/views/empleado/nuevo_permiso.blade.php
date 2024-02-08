<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>Permisos</title>
        @vite(['resources/css/empleado/nuevo_permiso.css', 'resources/js/nuevo_permiso.js'])
    </head>
    <body>
        <nav class="navbar" style="background-color: rgba(115,188,220,255);">
            <div class="container-fluid">
                <h3>Diligenciar permiso</h3>
                <a href="{{ route('ruta_volver')}}" class="btn btn-light" id="cerrar">Volver</a>
            </div>
        </nav>
        <div class="container">
            <form id="formulario" method="POST" action="{{ route('ruta_firmar') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="usuario_id" id="nombre" value="{{ $id_usuario }}" class="">
                <input type="hidden" name="cargo_id" id="nombre" value="{{ $id_cargo }}" class=""><br>
                <div class="content">
                    <h5> Seleccione el tipo de permiso:</h5>
                    <div class="selectdiv">
                        <select type="submit" id="pcl" name="pcl" class="select" value="" required>	
                            <option selected readonly value="">Seleccionar una categoria</option>
                            <option value="Permiso">Permiso</option>
                            <option value="Compensatorio">Compensatorio</option>
                            <option value="Licencia">Licencia</option>
                        </select><br><br>
                    </div>
                    <h5 name="titulo" id="titulo"class="textos" > Hora:</h5>
                    <p>De <input name="hora_inicio" type="time"  required><br> A <input name="hora_fin" type="time" required></p>
                    <h5 name="titulo" id="titulo"class="textos" >Fecha:</h5>
                    <p>Desde: <input  type="date"  name="fecha_inicio" placeholder="dd/mm/aaaa" required><br> Hasta: <input  type="date"  name="fecha_fin" placeholder="dd/mm/aaaa" required></p>
                    <h5 name="titulo" id="titulo" class="textos" > Información del permiso</h5>
                    <div class="radio">
                        <input type="radio" id="opcion1" name="permiso" value="Dia de la familia" required>
                        <label for="opcion1">Día de la Familia</label><br>
                        <input type="radio" id="opcion2" name="permiso" value="Otro">
                        <label for="opcion2">Otro:<input type="text" class="" id="justificado" name="justificado" placeholder="Justificar: Día de cumpleaños"></label>
                    </div><br>
                    <label for="nombreApellido"></label>
                    <h5 name="nombreApellido" id="nombreApellido"class="textos" >Firma del empleado.</h5>
                    <input type="file" class="" id="firma_e" name="firma_e" required><br>
                    <div class="boton">
                        <button class="btn-lg boton primary" type="submit" name="submit_action" value="firmar" id="button1">Firmar</button>
                        <button class="btn-lg boton primary" type="submit" name="submit_action" value="prevista" id="button2">Pre-vista</button><br>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>