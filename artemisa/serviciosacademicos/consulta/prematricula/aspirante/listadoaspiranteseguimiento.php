<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
</script>

<?php
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/motor/motor.php");
require_once(realpath(dirname(__FILE__))."/../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php' ); 
function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}
$query="SELECT 
		es.codigoestudiante,
		es.idestudianteseguimiento, 
		es.observacionestudianteseguimiento observacion,
		es.fechaestudianteseguimiento as fecha,
		es.fechahastaestudianteseguimiento,
		fechadesdeestudianteseguimiento,
		p.nombrecortoproceso as proceso,
		u.usuario as usuario,
		t.nombretipoestudianteseguimiento ObservacionTipo,
			if(es.idtipodetalleestudianteseguimiento=1,t.nombretipoestudianteseguimiento,CONCAT(t.nombretipoestudianteseguimiento,' / ',tpd.nombretipodetalleestudianteseguimiento)) TipoObservacion,
		if(es.codigotipoestudianteseguimiento like '4%','Modificar','') Actualizar
		FROM  usuario u, proceso p, tipoestudianteseguimiento t,estudianteseguimiento es
			left join tipodetalleestudianteseguimiento tpd 
			on es.idtipodetalleestudianteseguimiento=tpd.idtipodetalleestudianteseguimiento
		WHERE es.codigoestudiante='".$_GET['codigoestudiante']."'
		AND es.idusuario = u.idusuario
		AND es.codigoestado=100
		AND es.idproceso=p.idproceso
		AND t.codigotipoestudianteseguimiento=es.codigotipoestudianteseguimiento
		order by idestudianteseguimiento desc
";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
while ($row_operacion=$operacion->fetchRow());
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
$motor = new matriz($array_interno,'Listado seguimientos del aspirante');
$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('observacion','listadoaspiranteseguimiento.php','detalleobservacionaspiranteseguimiento.php','observacion de la observacion','idestudianteseguimiento',"codigoestudiante=".$_GET['codigoestudiante']);
$motor->agregarllave_drilldown('Actualizar','listadoaspiranteseguimiento.php','aspiranteseguimiento.php','observacion de la observacion','idestudianteseguimiento',"Desbloquear=1&codigoestudiante=".$_GET['codigoestudiante'],'','','','','onclick= "return ventanaprincipal(this)"');

$motor->mostrar();
?>
