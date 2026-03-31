<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' );
ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once("funciones/ObtenerDatos.php");
?>
<?php
$nombresitioadmision="Universidad El Bosque";
$direccionsitioadmision="Transversal 9A Bis No. 132-55";
$telefonositioadmision="6331368";
$nombreresponsablesitioadmision="UNIVERSIDAD";
$codigoestado=100;
$capacidadsitioadmision=100;

$sitioadmision = new TablasAdmisiones($sala);
$array_carreras=$sitioadmision->LeerCarreras("todos","todos");

	

foreach ($array_carreras as $llave => $valor)
{
	$array_subperiodo=$sitioadmision->LeerSubperiodos($valor['codigocarrera']);
	if($array_subperiodo['idsubperiodo']=="")
	{
		$array_nosubperiodo[]=array('codigocarrera'=>$valor['codigocarrera'],'nombrecarrera'=>$valor['nombrecarrera']);
	}
	else 
	{
		$query_inserta_masivo="
		INSERT INTO sitioadmision 
		(nombresitioadmision, 
		direccionsitioadmision, telefonositioadmision, 
		nombreresponsablesitioadmision, codigoestado, 
		capacidadsitioadmision, codigocarrera, 
		idsubperiodo) 
		VALUES ('$nombresitioadmision','$direccionsitioadmision','$telefonositioadmision','$nombreresponsablesitioadmision','$codigoestado','$capacidadsitioadmision','".$valor['codigocarrera']."','".$array_subperiodo['idsubperiodo']."')
		";
		$sala->debug=true;
		$operacion=$sala->query($query_inserta_masivo);
		$sala->debug=false;
	}
}
if(isset($_GET['depurar']))
{
	$sitioadmision->DibujarTabla($array_carreras,"carreras");
	$sitioadmision->DibujarTabla($array_nosubperiodo,"carreras sin carreraperiodo/subperiodo");
}
$sitioadmision->DibujarTabla($array_nosubperiodo,'Carreras sin carreraperiodo o subperiodo');
?>