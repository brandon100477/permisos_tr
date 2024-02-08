<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Archivo</title>
        @vite(['resources/css/th/archivo.css','resources/js/archivo.js'])
    </head>
    <body>
        <nav class="navbar" style="background-color: rgba(115,188,220,255);">
            <div class="container-fluid">
                <h3>Permisos Autorizados</h3>
                <a href="{{ route('ruta_volver')}}" class="btn btn-light" id="cerrar">Volver</a>
            </div>
        </nav>
        <div class="container">
            <h2>Permisos firmados y registrados hasta la fecha</h2><br>
            <div class="buttons">
                <form>
                    <div class="conjunto">
                        <h7 name="titulo" id="titulo"class="titulo"> Fecha inicio:</h7>
                        <h7 name="titulo2" id="titulo2"class="titulo2"> Fecha fin:</h7>
                    </div>
                    <input type="date" class="fecha_inicio" name="fecha_inicio" id="fecha_inicio" value="{{ $filtro_inicio }}">
                    <input type="date" class="fecha_fin" name="fecha_fin" id="fecha_fin" value="{{ $filtro_fin }}">
                    <button class="btn btn-warning btn-sm" id="boton_buscar" type="submit" >Buscar</button><br><br>
                </form>
                <form action="{{ route('ruta_exportar')}}" method="post">
                    @csrf
                    <input type="button"  value="Seleccionar todo" class="btn btn-warning btn-sm botton" id="seleccionarTodo">
                    @foreach ($usuarios as $usuario)
                        @foreach ($permisos as $permiso)
                            @if ($usuario->id == $permiso->id_usuario)
                                <input type="hidden" name="identi[]" id="identi" value="{{ $permiso->id }}">
                                <input type="hidden" name="pcl[]" id="pcl" value="{{ $permiso->p_c_l }}">
                                <input type="hidden" name="nombre[]" id="nombre" value="{{ $usuario->nombre }}">
                                <input type="hidden" name="fecha[]" id="fecha" value="{{ $permiso->fecha_solicitud }}">
                                <input type="hidden" name="estado[]" id="estado" value="{{ $permiso->estado_solicitud }}">
                                <input type="hidden" name="remunerado[]" id="remunerado" value="{{ $permiso->remunerado }}">
                                <input type="hidden" name="info[]" id="info" value="{{ $permiso->info_permiso }}">
                                <input type="hidden" name="diaini[]" id="diaini" value="{{ $permiso->dia_inicio }}">
                                <input type="hidden" name="diafin[]" id="diafin" value="{{ $permiso->dia_fin }}">
                                @foreach ($especificaciones as $especificacion)
                                    @if ($especificacion->id_usuario == $usuario->id)
                                        <input type="hidden" name="especi[]" id="especi" value="{{ $especificacion->especificacion }}">
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                    <button type="submit" class="btn btn-warning btn-sm botton" id="boton_excel" value="botton1" name="submit_action">Descargar Excel</button><!-- Botón para exportar el excel -->
                    <button type="submit" class="btn btn-warning btn-sm botton" id="boton_pdf" value="botton2" name="submit_action">Descargar PDF'S</button><!-- Botón para exportar el excel -->
                    <div class="collapse show" id="collapseTable">
                        <div class="table-container">
                            <table>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Tipo de permiso</th>
                                    <th>Nombre</th>
                                    <th>Fecha de solicitud</th>
                                    <th>Especificación de cargo</th>
                                    <th>Aprobado / Rechazado</th>
                                    <th>Revisar</th>
                                </tr>
                                @foreach ($usuarios as $usuario)
                                    @foreach ($permisos as $permiso)
                                        @if ($usuario->id == $permiso->id_usuario)
                                            <tr>
                                            <td>
                                                <input type="checkbox" class="checkbox" name="seleccionados[]" value="{{ $permiso->id }}">
                                            </td>
                                                <td>{{ $permiso->p_c_l }}</td>
                                                <td>{{ $usuario->nombre }}</td>
                                                <td>{{ $permiso->fecha_solicitud }}</td>
                                                <td>
                                                    @foreach ($especificaciones as $especificacion)
                                                        @if ($especificacion->id_usuario == $usuario->id)
                                                            {{ $especificacion->especificacion }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $permiso->estado_solicitud }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('ruta_descargar', ['id' => $permiso->id]) }}" name="ide" id="ide{{ $permiso->id }}" ><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                    </div>
                </form>
            </div><br>
        </div>
    </body>
</html>