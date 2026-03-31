<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<div align="center"></div>
<table width="511" border="0" align="center">
  <tr>
    <td><p align="center"><img src="../../../../imagenes/logoweb2.jpg" width="200" height="62" onClick="print()"></p>
      <p align="center"><span class="Estilo2">INFORME DE REGISTRO DE ESTUDIANTES GRADUADOS</span></p>
      <p align="center">Fecha:
        <?php $fecha=$_GET['fecha'];echo $fecha;?>
      </p>
    <?php 
require_once("funciones/tabla_fn.php"); 
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$query_log_registrograduado="SELECT idregistrograduado AS 'No. registro', concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS Nombre,
eg.numerodocumento AS Documento, c.nombrecarrera AS Programa, rg.numeroactaregistrograduado AS 'No. Acta', rg.numerodiplomaregistrograduado AS 'No. Diploma'
FROM registrograduado rg, estudiantegeneral eg, estudiante e, carrera c
WHERE 
rg.codigoestado = '100' AND
rg.codigoautorizacionregistrograduado='100' AND
rg.fechaautorizacionregistrograduado LIKE '$fecha%' AND
rg.codigoestudiante=e.codigoestudiante AND
e.idestudiantegeneral=eg.idestudiantegeneral AND
e.codigocarrera=c.codigocarrera
";

$log_registrograduado=mysql_query($query_log_registrograduado,$sala) or die(mysql_error());
tabla($log_registrograduado);
?>
    <p>Firma: </p>
    <p>______________________<br>
      Luis Arturo Rodriguez<br>
      Secretario General
    </p>
    <p>&nbsp;</p></td>
  </tr>
</table>
<br>
