<?php
require('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once('../../funciones/clases/motorv2/motor.php');
session_start();
$db->SetFetchMode(ADODB_FETCH_ASSOC);

if($_REQUEST['codigocarrera'] != 'todos'){
$concarrera="and c.codigocarrera=".$_REQUEST['codigocarrera'];
}
$query_datos="select c.nombrecarrera as Carrera, UPPER(ce.nombres) AS Nombres, ce.telefono as Telefono
	,ce.celular as Celular,ce.email as Correo_Electronico,ce.profesion as Profesion,ce.especialidad as Especialidad
	,ce.empresa as Empresa,ce.cargo as Cargo,ce.comentarios as Comentarios, ce.fecharegistro as Fecha_Registro
from capturaeducontinuada ce, carrera c
where	
	c.codigocarrera=ce.codigocarrera
	and ce.fecharegistro between '".$_REQUEST['fechainicio']." 00:00:00' and '".$_REQUEST['fechafin']." 23:59:59'
	$concarrera
	order by c.nombrecarrera,ce.fecharegistro";
$datos = $db->Execute($query_datos);
$totalRows_datos = $datos->RecordCount();
$row_datos = $datos->FetchRow();

   do{
    $Array_interno[] = $row_datos;
   }while($row_datos = $datos->FetchRow());
 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Reporte</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
</head>
<body>
<p><img src="../../aspirantes/Unbosque/imagenes/banner.gif"></p>
	<p><label id='labelresaltadogrande'>REPORTE CAPTURA DE DATOS EDUCACION CONTINUADA</label></p>
<?php
         //matriz($matriz,$titulo="",$archivo_origen="",$filtrasino="si",$numerarsino="no",$atras="",$link_recarga="",$origen_x_sesion=false,$ordenasino="si",$rutaraiz="../../",$modoDHML=false)
$motor = new matriz($Array_interno,"LISTACAPTURA","informecapturainfo.php","si","si","si","menureporte.php","","","../../");
$motor->botonRecargar = false;
$motor->botonRegresar = false;
$motor->mostrar();
?>
<input type="button" value="Regresar" onClick="regreso()">
</body>
</html>
<script language="javascript">
function regreso()
{
	window.location.href='menureporte.php';
}
</script>
