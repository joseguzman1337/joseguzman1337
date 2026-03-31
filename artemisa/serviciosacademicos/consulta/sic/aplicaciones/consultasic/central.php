<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

	//$formato = 'doc';
	$nombrearchivo="AutoevaluacionInstitucional";
	
	switch ($_GET["exportar"])
	{
		case 'xls' :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
		case 'doc' :
			$strType = 'application/msword';
			$strName = $nombrearchivo.".doc";
			break;
		case 'txt' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".txt";
			break;
		case 'csv' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".csv";
			break;
		case 'xml' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".xml";
			break;
		default :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
	}
if(isset($_GET["exportar"])&&trim($_GET["exportar"])!=""){
	header("Content-Type: $strType");
	header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	//header("Cache-Control: no-store, no-cache");
	header("Pragma: public");
}

//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
//$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('../../../../funciones/sala_genericas/FuncionesSeguridad.php');

require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/clasemenusic.php");
require_once(realpath(dirname(__FILE__))."/claseconsultasic.php");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true','Los campos marcados con *, no han sido correctamente diligenciados:\n\n','','false',"../../../../",0);

$objetobase=new BaseDeDatosGeneral($sala);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
	<script type="text/javascript">
	function selaprueba(obj,iditem){
		if(obj.checked==true)
			window.parent.frames[1].cambiaEstadoImagen(true,iditem);
		else		
			window.parent.frames[1].cambiaEstadoImagen(false,iditem);
	}	
	</script>
  </head>
  <body>
<?php
$objetomenusic= new MenuSic($objetobase,$formulario);
/*echo "_POST<pre>";
print_r($_POST);
echo "</pre>";*/
echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

//echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
//		<input type=\"hidden\" name=\"AnularOK\" value=\"\">";
if(is_array($_POST)&&count($_POST)>0){
foreach($_POST as $llave=>$valor){
//$arrayiditem[]=str_replace("check","",$llave);
$objetomenusic->consultapapas(str_replace("check","",$llave));
}
$funcion="mostrarconsultacarreraitem";
$objetomenusic->$funcion($_SESSION["sissic_codigocarrera"],$_GET['tipovisualiza']);
}
//echo "</form>";
echo "</table>";
?>
  </body>
</html>