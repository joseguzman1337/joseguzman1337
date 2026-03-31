<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
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
if(isset($_GET["numerodocumento"])&&($_GET["numerodocumento"]!='')){

$query="select idestudiantenovedadarpextemporaneo, nombrenovedadarp, fechaestudiantenovedadarpextemporaneo
fechainicioestudiantenovedadarpextemporaneo, fechafinalestudiantenovedadarpextemporaneo, e.nombreestado
from estudiantenovedadarpextemporaneo ene,novedadarp n,estudiantenovedadarp en,
estudiantegeneral eg,estado e
where 
en.idestudiantenovedadarp=ene.idestudiantenovedadarp
and n.idnovedadarp=en.idnovedadarp
and eg.idestudiantegeneral=en.idestudiantegeneral
and eg.numerodocumento='".$_GET["numerodocumento"]."'
and e.codigoestado=ene.codigoestado
order by fechaestudiantenovedadarpextemporaneo desc
";

$objetobase=new BaseDeDatosGeneral($sala);

$operacion=$sala->query($query);
while($row_operacion=$operacion->fetchRow())
{
	$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$datosestudiante=$objetobase->recuperar_datos_tabla("estudiantegeneral","numerodocumento",$_GET["numerodocumento"],'','',0);
$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($array_interno,"Listado de Novedades Extemporaneas $estudiante");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('idestudiantenovedadarpextemporaneo','novedadarpextemporaneo.php','novedadarpextemporaneo.php','idestudiantenovedadarpextemporaneo','idestudiantenovedadarpextemporaneo',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->mostrar();
}
?>
