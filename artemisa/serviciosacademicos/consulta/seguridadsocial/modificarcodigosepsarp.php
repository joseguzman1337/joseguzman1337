<?php 
 session_start();
 $rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
 
 ?>

<?php
 require_once('../../funciones/sala_genericas/ajax/json.php');
$json = new Services_JSON();

//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");

//$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
 
//echo "LINK_ORIGEN=".$_GET['link_origen'];

?>
	<?php 
	$datos = array();
	if(isset($_GET['Enviar'])){
	//$valido=validaciongenerica($_GET['codigoempresasalud'], "numero","");
		//if($valido['valido']){
		$tabla="empresasalud";
		$idtabla=$_GET['idempresasalud'];
		$filaactualizar['codigoempresasalud']=$_GET['codigoempresasalud'];
		$objetobase->actualizar_fila_bd($tabla,$filaactualizar,'idempresasalud',$idtabla);
		//}
 	//echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
	}
	//alerta_javascript("ingreso idempresasalud=".$_GET['idempresasalud']."\n codigoempresasalud".$_GET['codigoempresasalud']); 

	//$datos1["idempresasalud"]=$_GET['idempresasalud'];
	//$datos1["codigoempresasalud"]=$_GET['codigoempresasalud'];




	?>

	
