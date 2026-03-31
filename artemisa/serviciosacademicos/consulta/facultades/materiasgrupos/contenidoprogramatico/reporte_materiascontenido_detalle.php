<?php
require('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');
require_once('../../../../funciones/clases/motorv2/motor.php');
session_start();
$db->SetFetchMode(ADODB_FETCH_ASSOC);

$codigoperiodo = $_SESSION['codigoperiodosesion'];
/*$codigoperiodo = 20131;*/

if($_REQUEST['nacodigocarrera'] != 0){
$concarrera="and m.codigocarrera=".$_REQUEST['nacodigocarrera'];

$query_carrera="select nombrecarrera from carrera where codigocarrera='".$_REQUEST['nacodigocarrera']."'";
$carrera = $db->Execute($query_carrera);
         $totalRows_carrera = $carrera->RecordCount();
         $row_carrera = $carrera->FetchRow();


}
elseif($_REQUEST['nacodigocarrera'] == 0){
$concarrera="and ca.codigomodalidadacademica='".$_REQUEST['nacodigomodalidadacademica']."'";
}
	$query_materia = "SELECT ca.nombrecarrera,m.codigomateria, m.nombremateria,
	case
	WHEN c.idcontenidoprogramatico IS NOT NULL THEN
	'SI'
	ELSE
	'NO'
	end 'Syllabus/Contenido'
	,dc.fechadetallecontenidoprogramatico as FechaUltimaModif
	,m.numerocreditos, tm.nombretipomateria,
	 SUM(maximogrupo - (matriculadosgrupoelectiva + matriculadosgrupo) ) AS cupo, 
	concat(d.nombredocente,' ', d.apellidodocente) as Nombre, d.numerodocumento as Documento_Docente
         FROM materia m
		left join contenidoprogramatico c on c.codigomateria=m.codigomateria  and c.codigoperiodo='$codigoperiodo' and c.codigoestado like '1%'
		left join detallecontenidoprogramatico dc on c.idcontenidoprogramatico=dc.idcontenidoprogramatico
		,grupo g, docente d, tipomateria tm, carrera ca
         WHERE g.codigoperiodo = '$codigoperiodo'
         AND m.codigomateria = g.codigomateria	
         $concarrera
	 and ca.codigocarrera=m.codigocarrera
         AND g.codigoestadogrupo = '10'
         AND m.codigoestadomateria = '01'
         and g.numerodocumento = d.numerodocumento
         and m.codigotipomateria = tm.codigotipomateria
	GROUP by 2,3
        ORDER BY ca.nombrecarrera,m.nombremateria";
	 //echo $query_materia;
	 $materia = $db->Execute($query_materia);
	 $totalRows_materia = $materia->RecordCount();
	 $row_materia = $materia->FetchRow();
	

   do{
    $Array_interno[] = $row_materia;
   }while($row_materia = $materia->FetchRow());
 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Reporte</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
</head>
<body>
	<p><label id='labelresaltadogrande'>LISTADO DE MATERIAS SYLLABUS/CONTENIDOS PROGRAMATICOS  </label></p>
<?php
         //matriz($matriz,$titulo="",$archivo_origen="",$filtrasino="si",$numerarsino="no",$atras="",$link_recarga="",$origen_x_sesion=false,$ordenasino="si",$rutaraiz="../../",$modoDHML=false)
$motor = new matriz($Array_interno,"LISTAMATERIA","reporte_materiascontenido_detalle.php","si","si","si","reporte_materiascontenido.php","","","../../../../");
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
	window.location.href='reporte_materiascontenido.php';
}
</script>
