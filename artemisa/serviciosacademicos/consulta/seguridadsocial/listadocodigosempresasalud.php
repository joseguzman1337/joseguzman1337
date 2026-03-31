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

</script>
<script type="text/javascript" src="funciones/FuncionesAportesJscript.js"></script>
<script src="../../funciones/sala_genericas/ajax/javascripts/prototype.js" type="text/javascript"></script>

<?php
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/motor/motorformulario.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/FuncionesMatriz.php");

function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}
if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']!=''))
$_SESSION['sesion_codigoestudiante']=$_GET['codigoestudiante'];

$query="select e.idempresasalud,e.nombreempresasalud,
t.nombretipoempresasalud,e.codigoempresasalud from 
empresasalud e, tipoempresasalud t where
e.codigotipoempresasalud=t.codigotipoempresasalud
order by nombretipoempresasalud,nombreempresasalud 
";

$objetobase=new BaseDeDatosGeneral($sala);
$condicion="and es.idestudiantegeneral=eg.idestudiantegeneral
			and eg.tipodocumento=do.tipodocumento";
$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante es, estudiantegeneral eg, documento do","es.codigoestudiante",$_SESSION['sesion_codigoestudiante'],$condicion);

$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
$i=0;
do
{
	if($row_operacion['codigoempresasalud']=='')
	$espacio="0";
	else
	$espacio="";
	
	$row_operacion['codigoempresasalud']="<div id='celda_".$i."_3' >".$row_operacion['codigoempresasalud']."$espacio</div>";
	$row_operacion['Empresasalud']="<div id='celda_".$i."_4' align='center'>".$row_operacion['idempresasalud']."</div>";
	
	$row_operacion=QuitarColumnaFila($row_operacion,0);
	//$row_operacion=QuitarColumnaFila($row_operacion,1);

	$array_interno[]=$row_operacion;
	$i++;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
while ($row_operacion=$operacion->fetchRow());
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//echo "<table width='200' border='1'  onKeyDown='return cambietexto(event);'>";
unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_GET['Recargar']);

$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($array_interno,"Listado de codigos empresasalud ","","no","","",$_SERVER['REQUEST_URI'],"","");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
if(!isset($_REQUEST['Filtrar']))
$motor->asignarJavascripttabla("onclick='getCellInfo(this,3,".($i-1).",3,0)' onKeyDown='return cambietexto(event,3,".($i-1).",3,0)'");


$motor->agregarllave_drilldown('idcarreracentrotrabajo','asignacioncentrotrabajo.php','asignacioncentrotrabajo.php','','idcarreracentrotrabajo',"codigoestudiante=".$_GET['codigoestudiante']."&modificar=1",'','','','','onclick= "return ventanaprincipal(this)"');

$motor->mostrar();

?>
</table>