<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Decargando</title>
  </head>
  <style>
    table, th, td{
      width: 100%;
      border: 1px solid black;
      border-collapse: collapse;
      text-align: center;
    }
    th, td{
      padding: 5px;
    }

    .text{
      text-align: left;
    }

    .ancho{
      padding: 10px;
    }
    .ancho2{
      padding: 30px;
    }
    .tam{
      font-size: 15px;
    }
    .fondo{
      background-color: #D3D3D3;
    }
    .img{
      width: 300px;
      height: 60px;
    }
    
  </style>
  @foreach ($alls as $all)
    
  
  <body>
    <h2>Permiso, compensatorio o licencia:</h2>
    <table>
      <tr>
        <th rowspan="3"><img src="{{ $all['image_logo'] }}"  class="img" /></th>
        <td><strong>Administración del personal</strong></td>
        <td class="text"><strong>Código: GTH-ADP-FO-011</strong></td>
      </tr>
      <tr>
        <td>Gestión de Talento Humano</td>
        <td class="text">Versión: 8</td>
      </tr>
      <tr>
        <td>Solicitud de permiso, Licencia o Compensatorio</td>
        <td class="text">Actualización: 21-07-2023</td>
      </tr>
    </table>
    <table>
      <tr>
        <th class="text tam"><strong>Nombre del colaborador:</strong></th>
        <td  class="text ancho">{{ $all['nombre'] }}</td>
        <th><strong>Empresa/Agencia</strong></th>
        <td  class="text ancho">{{ $all['empresa']  }}</td>
      </tr>
    </table>
    <table>
      <tr>
        <td rowspan="2"><strong>Cargo:</strong> {{ $all['car']  }}, {{ $all['especifi'] }}</td>
        <td  class="text"><strong>Estado del proceso:</strong> {{ $all['estado']  }}</td>
      </tr>
      <tr>
        <td  class="text"><strong>Fecha de la solicitud:</strong> {{ $all['fecha_solicitud'] }}</td>
      </tr>
    </table>
    <table>
      <tr>
        <th><strong>Tipo de permiso:</strong></th>
        <td class="text ancho"> {{ $all['pcl']  }}</td>
      </tr>
    </table>
    <table>
      <tr>
        <td rowspan="2"><strong>Motivo del permiso, compensatorio o licencia:</strong>  {{ $all['justificacion']  }}</td>
        <td class="text"><strong>Desde:</strong> {{ $all['hora_inicio']  }} <br><br><strong>Hasta:</strong> {{ $all['hora_fin'] }}</td>
      </tr>
      <tr>
        <td class="text"><strong>Fecha inicial:</strong> {{ $all['fecha_inicio'] }} <br> <br><strong>Fecha final:</strong> {{ $all['fecha_fin']}}</td>
      </tr>
    </table>
    <table>
      <th><strong>Remunerado: </strong></th>
      <td class="text">{{ $all['remunerado']  }}</td>
    </table>
    <table>
      <tr>
        <th rowspan="2"><strong>Firma y cedula del colaborador: </strong></th>
        <td><img src="{{ $all['image_e']  }}" class="img"/></td>
      </tr>
      <tr>
        <td class="text"><strong>C.C.</strong> {{ $all['cedula'] }} </td>
      </tr>
    </table>
    <table>
      <tr>
        <th class="ancho fondo"><strong>Autorización Talento Humano</strong></th>
      </tr>
    </table>
    <table>
      <tr>
        <th class="text"><strong>Observaciones:</strong></th>
      </tr>
      <tr>
        <td class="ancho2 text">{{ $all['obs']  }}</td>
      </tr>
    </table>
    <table>
      <tr>
        <th ><img src="{{ $all['image_j']  }}" class="img"/></th>
        <th ><img src="{{ $all['image_th'] }}" class="img"/></th>
      </tr>
      <tr>
        <th >Firma del líder inmediato</th>
        <th>Firma de Líder Talento Humano</th>
      </tr>
    </table>

  </body>
  @endforeach
</html>