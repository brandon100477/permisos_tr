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
        @vite(['resources/css/jefe/actualizar.css', 'resources/js/actualizar.js'])
        <title>Permisos</title>
    </head>
    <body>
        <nav class="navbar" style="background-color: rgba(115,188,220,255);">
            <div class="container-fluid">
                <h3>Revisar y aprobar</h3>
                <a href="{{ route('ruta_volver1')}}" class="btn btn-light" id="cerrar">Volver</a>
            </div>
        </nav>
        <div class="container">
            <form id="formulario" method="POST" action="{{ route('ruta_actualizar') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="usuario_id" id="nombre" value="{{ $id_usuario }}" class="">
                <input type="hidden" name="ide" id="ide" value="{{ $permiso_id }}" class="">
                <input type="hidden" name="cargo_id" id="nombre" value="{{ $id_cargo }}" class=""><br>
                <div class="content">
                    <label name="titulo" id="titulo" class="textos"><h5> Estado de permiso:</h5></label>
                    <input type="text" id="" name="" value="{{ $actualizar->estado_solicitud }}" readonly>
                    <label name="titulo" id="titulo" class="textos"><h5> Tipo de permiso:</h5></label>
                    <input type="text" id="p_c_l" name="p_c_l" value="{{ $actualizar->p_c_l }}" readonly>
                    <h5 name="titulo" id="titulo"class="textos" > Hora del permiso:</h5>
                        <p>De <input name="hora_inicio" type="time"  value="{{ $actualizar->hora_inicio}}" readonly> a <input name="hora_fin" type="time" value="{{ $actualizar->hora_fin}}" readonly></p>
                        <h5 name="titulo" id="titulo"class="textos" > Fecha del permiso:</h5>
                        <p>Desde la fecha: <input  type="date"  name="fecha_inicio" placeholder="dd/mm/aaaa" value="{{ $actualizar->dia_inicio}}" readonly> Hasta: <input  type="date"  name="fecha_fin" placeholder="dd/mm/aaaa" value="{{ $actualizar->dia_fin}}" readonly></p>
                    <h5 name="titulo" id="titulo"class="textos">Motivo del permiso</h5>
                    <input type="text" id="permiso" name="permiso" value="{{ $actualizar->info_permiso}}" readonly>
                    <h5 name="nombreApellido" id="nombreApellido"class="textos" >Firmado por el empleado:</h5>
                    <img src="{{ asset('image_e/' . $actualizar->firma_empleado) }}" class="img" />
                    <h5 name="nombreApellido" id="nombreApellido"class="textos">Remunerado: </h5>
                    <div class="radio">
                        <input type="radio" id="op1" name="adicional" value="Si" required>
                        <label for="op1">Si</label>
                        <input type="radio" id="op2" name="adicional" value="No">
                        <label for="op2">No</label>
                    </div>
                    <h5 name="titulo" id="titulo"class="textos" > Observaciones</h5>
                    <input type="text" class="" id="observaciones" name="observaciones" placeholder="Justificar: Opcional">
                    <h5 name="nombreApellido" id="nombreApellido"class="textos" >Firma de jefe inmediato.</h5>
                    <input type="file" class="" id="firma_jefe" name="firma_jefe" placeholder="Firma" required>
                    <h5 name="nombreApellido" id="nombreApellido"class="textos" >Pendiente de firmar por Talento Humano.</h5><br>
                </div>
                <div class="boton">
                    <button class="btn-lg boton primary" type="submit" name="submit_action" value="prevista" id="button1">Pre-vista</button>
                    <button class="btn-lg boton primary" type="submit" name="submit_action" value="aprobar" id="button2">Aprobar</button>
                    <button class="btn-lg boton primary" type="submit" name="submit_action" value="rechazar" id="button3">Rechazar</button><br><br><br><br>
                </div>
            </form>
        </div>
    </body>
</html>