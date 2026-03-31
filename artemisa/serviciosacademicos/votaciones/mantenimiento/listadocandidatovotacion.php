<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../sala.css">
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
}
</script>
<?php
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/motor/motor.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}
if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']!=''))
$_SESSION['sesion_codigoestudiante']=$_GET['codigoestudiante'];

$query="select distinct  cv.*, tc.nombretipocandidatodetalleplantillavotacion,v.nombrevotacion from
candidatovotacion cv, tipocandidatodetalleplantillavotacion tc,
 detalleplantillavotacion dpv, plantillavotacion pv, votacion v
where 
v.idvotacion = pv.idvotacion and
dpv.idplantillavotacion=pv.idplantillavotacion and
dpv.idcandidatovotacion=cv.idcandidatovotacion and
cv.idtipocandidatodetalleplantillavotacion=tc.idtipocandidatodetalleplantillavotacion
and cv.codigoestado like '1%' 
and (NOW() between v.fechainiciovigenciacargoaspiracionvotacion and fechafinalvigenciacargoaspiracionvotacion)
order by idcandidatovotacion desc
";

$objetobase=new BaseDeDatosGeneral($sala);

$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
$ruta1="../".$row_operacion["rutaarchivofotocandidatovotacion"].$row_operacion["numerodocumentocandidatovotacion"].".jpg";
$ruta2="../".$row_operacion["rutaarchivofotocandidatovotacion"].$row_operacion["numerodocumentocandidatovotacion"].".JPG";
if(file_exists($ruta1)||file_exists($ruta2))
	$row_operacion["fotoencontrada"]="Si";
else
	$row_operacion["fotoencontrada"]="No";
	
	$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
while ($row_operacion=$operacion->fetchRow());
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($array_interno,"Listado Candidato Votacion");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('nombrescandidatovotacion','listadocandidatovotacion.php','candidatovotacion.php','','idcandidatovotacion',"",'','','','','onclick= "return ventanaprincipal(this)"');

$motor->mostrar();
?>
