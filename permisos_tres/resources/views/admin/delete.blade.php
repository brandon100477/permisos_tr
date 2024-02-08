<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('img/favicon.png')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @vite(['resources/css/delete.css', 'resources/js/delete.js'])
    <title>Delete</title>
</head>
<body>
    <nav class="navbar" style="background-color: rgba(115,188,220,255);">
        <div class="container-fluid">
            <h3>Borrar usuarios</h3>
            <a href="{{ route('ruta_volver4')}}" class="btn btn-light" id="cerrar">Volver</a>
        </div>
    </nav>
        <div class="container">
            <h2>Lista de usuarios</h2><br>
            <div class="buttons">
                <form>
                    <div class="conjunto">
                        <h5 name="titulo" id="titulo"class="titulo">Cedula:</h5>
                    </div>
                    <input type="search" name="cedula" id="cedula" value="{{ $cedula }}">
                    <button class="btn btn-warning btn-sm" id="boton_buscar" type="submit" >Buscar</button><br><br>
                </form>
                <form action="{{ route('ruta_eliminarlos')}}" method="post" id="bin">
                    @csrf
                    <input type="button"  value="Seleccionar todo" class="btn btn-warning btn-sm botton" id="seleccionarTodo">
                    <button type="submit" class="btn btn-warning btn-sm botton eliminar" id="boton_eliminar" value="botton2" name="submit_action">Eliminar</button><!-- Botón para exportar el excel -->
                    <div class="collapse show" id="collapseTable">
                        <div class="table-container">
                            <table>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Cedula</th>
                                    <th>Eliminar</th>
                                </tr>
                                @foreach ($personas as $persona)
                                    <tr>
                                        <td><input type="checkbox" class="checkbox" name="seleccionados[]" value="{{ $persona->id }}"></td>
                                        <td>{{ $num++ }}</td>
                                        <td>{{ $persona->nombre }}</td>
                                        <td>{{ $persona->correo }}</td>
                                        <td>{{ $persona->cedula }}</td>
                                        <td>
                                        <a href="{{ route('ruta_eliminar', ['id' => $persona->id])}}" name="ide" id="one-delete" class="eliminar-link" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </form>
            </div><br>
        </div>
    </body>
</html>