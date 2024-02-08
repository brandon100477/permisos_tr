<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @vite(['resources/css/empleado/registros.css'])
        <title>Registro</title>
    </head>
    <body>
        <nav class="navbar" style="background-color: rgba(115,188,220,255);">
            <div class="container-fluid">
                <h3>Ver permisos</h3>
                <a href="{{ route('ruta_volver')}}" class="btn btn-light" id="cerrar">Volver</a>
            </div>
        </nav>
        <div class="container">
            <br><h2>Permisos solicitados hasta la fecha</h2><br>
            <div class="collapse show" id="collapseTable">
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Tipo de permiso</th>
                            <th>Fecha de solicitud</th>
                            <th>Pendiente - Aprobado - Rechazado</th>
                            <th>Descargar permiso</th>
                        </tr>
                            @foreach ($datos as $dato)
                                <tr>
                                    <td>{{ $dato -> p_c_l }}</td>
                                    <td>{{ $dato -> fecha_solicitud }}</td>
                                    <td>{{ $dato -> estado_solicitud }}</td>
                                    <td>
                                        <form action="{{ route('ruta_descargar', ['id' => $dato->id])}}" method="post">
                                            @csrf
                                            <input type="hidden" name="ide" id="ide" value="{{ $dato -> id}}">
                                            <button type="submit"><i class="fa fa-download" aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>