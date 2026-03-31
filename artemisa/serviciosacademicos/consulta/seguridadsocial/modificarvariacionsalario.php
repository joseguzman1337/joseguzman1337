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
	//if($_GET['codigoestado']==200){
	$tabla="estudiantenovedadarp";
	$idtabla=$_GET['idestudiantegeneral'];
	$condicion="and codigoestado like '1%' 
			and '".formato_fecha_mysql("01/".$_GET['mescierre'])."' between fechainicionovedadarp and fechafinalnovedadarp";

	$novedad=$objetobase->recuperar_datos_tabla("novedadarp","nombrecortonovedadarp","VSP",$condicion,"",0);
	//$condicion="and idnovedadarp=".$novedad['idnovedadarp'].
				//" and '".formato_fecha_mysql("01/".$_GET['mescierre'])."' between fechainicioestudiantenovedadarp and fechafinalestudiantenovedadarp ";
	//$filaactualizar['codigoestado']=200;
	//$objetobase->actualizar_fila_bd($tabla,$filaactualizar,'idestudiantegeneral',$idtabla,$condicion);
	//}
	//if($_GET['estado']==100){
	$fila["idestudiantegeneral"]=$_GET['idestudiantegeneral'];
	$fila["idnovedadarp"]=$novedad['idnovedadarp'];
	$fila["fechaestudiantenovedadarp"]=formato_fecha_mysql($_GET['fechaingreso']);
	$fila["fechainicioestudiantenovedadarp"]=formato_fecha_mysql("01/".$_GET['mescierre']);
	$fila["fechafinalestudiantenovedadarp"]=formato_fecha_mysql("01/".$_GET['mescierre']);
	$fila["observacionnovedadarp"]="";
	$fila["codigoestado"]=$_GET['estado'];
	$fila["idempresasalud"]=1;
	$fila["idestudiantenovedadarporigen"]=0;
	$fila["numerodocumentonovedadarp"]=' ';
	
	echo $condicionactualiza="idestudiantegeneral=".$_GET['idestudiantegeneral'].
						" and fechainicioestudiantenovedadarp='".$fila["fechainicioestudiantenovedadarp"].
						"' and fechafinalestudiantenovedadarp='".$fila["fechafinalestudiantenovedadarp"].
						"' and idnovedadarp='".$fila["idnovedadarp"]."'";
	$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
	//}	
	//alerta_javascript("ingreso idempresasalud=".$_GET['idempresasalud']."\n codigoempresasalud".$_GET['codigoempresasalud']); 

	//$datos1["idempresasalud"]=$_GET['idempresasalud'];
	//$datos1["codigoempresasalud"]=$_GET['codigoempresasalud'];




	?>

	
