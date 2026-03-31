<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
//require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
	//print_r($_SESSION['array_listado_asignacion_pruebas']);
	if(!$_SESSION['matrizfiltradavacia']){
	$_GET['Filtrar']='Filtrar';
	$_GET['codigoestadoestudianteadmision']=300;
	$_GET['f_codigoestadoestudianteadmision']='like';
	//unset($_SESSION['matrizfiltradavacia']);
	$entroborrar=0;
}
else{
	unset($_SESSION['array_listado_asignacion_pruebas']);
	unset($_SESSION['matrizfiltradavacia']);
	$entroborrar=1;
}


?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="javascript">
function reCarga(pagina){
	document.location.href=pagina;
}
function recargar(){
document.location.href= "<?php echo 'calcula_listado_resultados.php?codigomodalidadacademica='. $_GET['codigomodalidadacademica'].'&codigocarrera='. $_GET['codigocarrera'].'&codigoperiodo='. $_GET['codigoperiodo'].'&link_origen=menu.php' ?>"
}

</script>
<form name="admitir" method="post" action="">
<p align="left" class="Estilo3">MENU PARAMETRIZACION ADMISIONES</p>
  <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
  	<tr>
  		<td>Cantidad de aspirantes a admitir</td>
  		<td><input type="submit" name="Enviar" value="Enviar"></td>
  	</tr>
  </table>
</form>
<?php
ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/motorv2/motor.php');
require_once('../../../../funciones/clases/debug/SADebug.php');
require_once('funciones/ObtenerDatos.php');

$fechahoy=date("Y-m-d H:i:s");
$_SESSION['get']=$_GET;

$debug=false;
if($_GET['depurar']=='si')
{
	$debug=true;
	$sala->debug=true;
}

$codigocarrera=$_SESSION['codigocarrera'];
$codigoperiodo=$_SESSION['codigoperiodo_seleccionado'];
echo "<pre>";
//print_r($_SESSION['array_listado_asignacion_pruebas']);
echo "</pre>";

if($codigocarrera=="" or $codigoperiodo=="")
{
	echo "<h1>Error, se perdió la variable de sesion carrera o periodo</h1>";
}
$link_origen=$_GET['link_origen'];
$admisiones_consulta=new TablasAdmisiones($sala,$debug);
$array_subperiodo=$admisiones_consulta->LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera,$codigoperiodo);
$idsubperiodo=$array_subperiodo['idsubperiodo'];
$idadmision=$admisiones_consulta->LeerIdadmision($codigocarrera,$idsubperiodo);
$array_parametrizacion_admisiones=$admisiones_consulta->LeerParametrizacionPruebasAdmision($idadmision);
$array_listado_asignacion_pruebas=$_SESSION['array_listado_asignacion_pruebas'];

$tabla = new matriz($array_listado_asignacion_pruebas,"Listado resultados de las pruebas $codigocarrera",'listado_cambio_admitir.php','si','si','menuadministracionresultados.php',"menu.php",false,"si","../../../../");
$tabla->definir_llave_globo_general('nombre');

if(!is_array($tabla->matriz_filtrada)&&$entroborrar)
$_SESSION['matrizfiltradavacia']=0;
else
$_SESSION['matrizfiltradavacia']=1;



foreach ($array_parametrizacion_admisiones as $llave => $valor)
{
	if($valor['codigotipodetalleadmision']<>4)//no calcular icfes
	{
		$cadena_llave="PUNTAJE_".ereg_replace(" ","_",$valor['nombretipodetalleadmision']);
		//	$tabla->agregarllave_drilldown($cadena_llave,'listado_resultados.php','detalleestudianteadmision.php','test','codigoestudiante',"codigotipodetalleadmision=".$valor['codigotipodetalleadmision']."",'idestudianteadmision','idestudianteadmision');
		//$tabla->agregarllave_emergente($cadena_llave,'listado_resultados.php','detalleestudianteadmision.php','test','codigoestudiante',"codigotipodetalleadmision=".$valor['codigotipodetalleadmision']."",300,300,200,150,"yes","yes","no","no","no",'idadmision','idadmision','','');
	}
}
//$tabla->agregarllave_emergente('nombreestadoestudianteadmision','listado_resultados.php','estudianteadmision.php','test','codigoestudiante',"",120,200,200,150,"yes","yes","no","no","no",'idadmision','idadmision','','');

$tabla->botonRecargar=false;
/*$i=1;
foreach ($tabla->matriz as $llave => $valor){
	$array_numero[]['Numero']=$i++;
}*/
//$tabla->matriz=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($tabla->matriz,$array_numero);
			if(!is_array($tabla->filtrotmp))
				$tabla->filtrotmp=1;
$tabla->mostrar();
if($_REQUEST['Enviar']){
	
	foreach ($array_parametrizacion_admisiones as $llave => $valor){

			$QueryActualizaEstado="UPDATE estudianteadmision SET
			codigoestadoestudianteadmision='300'
			WHERE
			idestudianteadmision = '".$matriz[$i]['idestudianteadmision']."'
			";

			$queryActualizaSituacionCarreraEstudiante="
			UPDATE estudiante SET codigosituacioncarreraestudiante='300'
			WHERE
			codigoestudiante = '".$matriz[$i]['codigoestudiante']."'
			";

			$queryIdEstudianteGeneral="SELECT eg.idestudiantegeneral FROM estudiantegeneral eg, estudiante e
			WHERE
			e.codigoestudiante = '".$matriz[$i]['codigoestudiante']."'
			AND e.idestudiantegeneral=eg.idestudiantegeneral
			";
			$op=$sala->execute($queryIdEstudianteGeneral);
			$idestudiantegeneral=$op->fields['idestudiantegeneral'];

			$queryIdInscripcion="SELECT i.idinscripcion FROM inscripcion i
			inner join estudiantecarrerainscripcion eci on i.idinscripcion=eci.idinscripcion
			AND eci.codigocarrera='$codigocarrera'
			AND eci.idestudiantegeneral='$idestudiantegeneral'
			AND i.codigoperiodo='$codigoperiodo'";				
			$opI=$sala->execute($queryIdInscripcion);
			$idinscripcion=$opI->fields['idinscripcion'];

			$queryActualizaInscripcion="UPDATE inscripcion i SET codigosituacioncarreraestudiante='300' WHERE i.idinscripcion = '$idinscripcion'";
			$admitir=$sala->query($QueryActualizaEstado);
			$opAI=$sala->execute($queryActualizaInscripcion);
			$admitirSCE=$sala->query($queryActualizaSituacionCarreraEstudiante);

			//idplanestudios=20
			$queryInsertaPlanEstudios="
			insert into planestudioestudiante
			(`idplanestudio`, `codigoestudiante`, `fechaasignacionplanestudioestudiante`, 
			`fechainicioplanestudioestudiante`, 
			`fechavencimientoplanestudioestudiante`, 
			`codigoestadoplanestudioestudiante`
			)
			values
			('20', '".$matriz[$i]['codigoestudiante']."', '$fechahoy', 
			'$fechahoy', 
			'2999-12-31', 
			'100'
			)
			";
			$pe=$sala->execute($queryInsertaPlanEstudios);
		}

}

?>

