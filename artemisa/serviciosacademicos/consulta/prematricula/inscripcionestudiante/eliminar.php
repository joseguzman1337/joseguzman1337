<?php  
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require('../../../Connections/sala2.php'); 

$rutaado = "../../../funciones/adodb/";

require_once('../../../Connections/salaado.php'); 



$id = $_REQUEST['id'];

if(isset($_REQUEST['estudiosrealizados']))

{

	$direccion = "estudiosrealizados.php";

	$query = "update estudianteestudio 

   	set codigoestado = '200'

	WHERE idestudianteestudio = '$id'";

}

if(isset($_REQUEST['datosfamiliares']))

{

	$direccion = "datosfamiliares.php";

	$query = "update estudiantefamilia 

   	set codigoestado = '200'

	WHERE idestudiantefamilia = '$id'";

}

if(isset($_REQUEST['aspectospersonales']))

{

	$direccion = "aspectospersonales.php";

	$query = "update estudianteaspectospersonales 

   	set codigoestado = '200'

	WHERE idestudianteaspectospersonales = '$id'";

}

if(isset($_REQUEST['idiomas']))

{

	$direccion = "idiomas.php";

	$query = "update estudianteidioma

   	set codigoestado = '200'

	WHERE idestudianteidioma = '$id'";

}

if(isset($_REQUEST['carreraspreferencia']))

{

	$direccion = "carreraspreferencia.php";

	$query = "update estudiantecarrerapreferencia

   	set codigoestado = '200'

	WHERE idestudiantecarrerapreferencia = '$id'";

}

if(isset($_REQUEST['carrerasinscritas']))

{

	$direccion = "carrerasinscritas.php";

	$query = "update estudiantecarrerainscripcion

   	set codigoestado = '200'

	WHERE idestudiantecarrerainscripcion = '$id'";

}

if(isset($_REQUEST['recursofinanciero']))

{

	$direccion = "recursofinanciero.php";

	$query = "update estudianterecursofinanciero

   	set codigoestado = '200'

	WHERE idestudianterecursofinanciero = '$id'";

}

$rs = $db->Execute($query);	



echo "<script language='javascript'>

window.opener.recargar('".$direccion."');

window.opener.focus();

window.close();

</script>"; 

?>