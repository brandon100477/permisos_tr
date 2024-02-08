<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Prevista</title>
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
  <body>
    <h2>Prevista del permiso, compensatorio o licencia:</h2>
    <table>
      <tr>
        <th rowspan="3"><img src="{{ $image_logo }}"  class="img" /></th>
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
        <td  class="text ancho">{{ $nombre }}</td>
        <th><strong>Empresa/Agencia</strong></th>
        <td  class="text ancho">{{ $empresa }}</td>
      </tr>
    </table>
    <table>
      <tr>
        <td rowspan="2"><strong>Cargo:</strong> {{ $car }}, {{ $especifi }}</td>
        <td  class="text"><strong>Estado del proceso:</strong> {{ $estado }}</td>
      </tr>
      <tr>
        <td class="text"><strong>Fecha de la solicitud:</strong> {{ $fecha_actual }}</td>
      </tr>
    </table>
    <table>
      <tr>
        <th><strong>Tipo de permiso:</strong></th>
        <td class="text ancho"> {{ $pcl }}</td>
      </tr>
    </table>
    <table>
      <tr>
        <td rowspan="2"><strong>Motivo del permiso, compensatorio o licencia:</strong>  {{ $justificacion }}</td>
        <td class="text"><strong>Desde:</strong> {{ $hora_inicio }} <br><br><strong>Hasta:</strong> {{ $hora_fin}}</td>
      </tr>
      <tr>
        <td class="text"><strong>Fecha inicial:</strong> {{ $fecha_inicio}} <br> <br><strong>Fecha final:</strong> {{ $fecha_fin}}</td>
      </tr>
    </table>
    <table>
      <tr>
        <th rowspan="2"><strong>Firma y cedula del colaborador: </strong></th>
        <td><img src="../../public/image_e/1698348888.png" /></td>
      </tr>
      <tr>
        <td class="text"><strong>C.C.</strong> {{ $cedula}} </td>
      </tr>
    </table>
    <table>
      <tr>
        <th class="ancho fondo"><strong>Autorización Talento Humano</strong></th>
      </tr>
    </table>
    <table>
      <tr>
        <th ><img src="../../public/image_e/1698237281.webp" /></th>
        <th ><img src="../../public/image_e/1698237281.webp" /></th>
      </tr>
      <tr>
        <th >Firma del líder inmediato</th>
        <th>Firma de Líder Talento Humano</th>
      </tr>
    </table>
  </body>
</html>
