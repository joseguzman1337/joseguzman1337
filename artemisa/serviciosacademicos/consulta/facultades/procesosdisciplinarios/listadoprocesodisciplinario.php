<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
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
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}
if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']!=''))
$_SESSION['sesion_codigoestudiante']=$_GET['codigoestudiante'];

$query="select p.codigoestudiante, p.idprocesodisciplinario, p.fecharegistroprocesodisciplinario Fecha_Registro,
p.descripcionprocesoadmnistrativoprocesodisciplinario Descripcion,
 ep.nombreestadoprocesodisciplinario Estado,
d.cargodirectivo Directivo, 
t.nombretipofaltaprocesodisciplinario Falta, ts.nombretiposancionprocesodisciplinario Sancion,
p.numeroactoadministrativoprocesodisciplinario Numero_Acta, p.fechaactoadministrativoprocesodisciplinario
Fecha_Acto_Administrativo,
p.fechaaperturaprocesodisciplinario Fecha_de_Apertura,p.fechanotificacionsancionprocesodisciplinario Fecha_de_Notificacion,
p.fechanotificacionsancionprocesodisciplinario Fecha_de_Sancion, p.fechacierreprocesodisciplinario Fecha_de_Cierre,
p.direccionipregistroprocesodisciplinario Equipo_de_Ingreso
from procesodisciplinario p, estadoprocesodisciplinario ep,
directivo d, tipofaltaprocesodisciplinario t, tiposancionprocesodisciplinario ts, 
estudiantegeneral eg, estudiante e
where
p.codigoestado like '1%' and
p.idestudiantegeneral = ".$_GET['idestudiantegeneral']." and
p.codigoestadoprocesodisciplinario=ep.codigoestadoprocesodisciplinario and 
p.iddirectivoresponsablesancionprocesodisciplinario=d.iddirectivo and
p.idtipofaltaprocesodisciplinario=t.idtipofaltaprocesodisciplinario and
p.idtiposancionprocesodisciplinario=ts.idtiposancionprocesodisciplinario and
p.idestudiantegeneral=eg.idestudiantegeneral and
p.codigoestudiante=e.codigoestudiante
order by fecharegistroprocesodisciplinario desc
";

$objetobase=new BaseDeDatosGeneral($sala);

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
unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$datosestudiante=$objetobase->recuperar_datos_tabla("estudiantegeneral eg, documento d","idestudiantegeneral",$_GET['idestudiantegeneral'],' and eg.tipodocumento=d.tipodocumento ','',0);
$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($array_interno,"Listado de Procesos Disciplinarios de ".$estudiante);
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('idprocesodisciplinario','procesodisciplinario.php&codigoestudiante='.$_GET['codigoestudiante'],'procesodisciplinario.php','','idprocesodisciplinario',"",'','','','','onclick= "return ventanaprincipal(this)"');

$motor->mostrar();
?>
