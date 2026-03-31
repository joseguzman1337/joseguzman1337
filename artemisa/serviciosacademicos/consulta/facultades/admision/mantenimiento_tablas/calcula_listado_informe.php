<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
$_SESSION['externo']=1;
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
require_once('../../../../funciones/clases/formulario/clase_formulario.php');
require_once('../../../../funciones/clases/motor/motor.php');
require_once('funciones/ObtenerDatos.php');
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

//error_reporting(2047);
$objetobase=new BaseDeDatosGeneral($sala);

?>
<?php
if($_POST['codigocarrera']=='')
unset($_SESSION['codigocarrera']);

if(isset($_POST['codigocarrera'])&&trim($_POST['codigocarrera'])!=''){

	$_SESSION['codigocarrera']=$_POST['codigocarrera'];
	$datosperiodo=$objetobase->recuperar_datos_tabla("periodo","codigoestadoperiodo",4,"","",0);
	if(!is_array($datosperiodo)){
	$datosperiodo=$objetobase->recuperar_datos_tabla("periodo","codigoestadoperiodo",1,"","",0);
	}
	$_SESSION['codigoperiodo_seleccionado']=$datosperiodo['codigoperiodo'];
	$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_POST['codigocarrera'],"","",0);
	$_SESSION['codigomodalidadacademica']=$datoscarrera['codigomodalidadacademica'];
	$codigocarrera=$_SESSION['codigocarrera'];
	$codigoperiodo=$_SESSION['codigoperiodo_seleccionado'];
	$codigomodalidadacademica=$_SESSION['codigomodalidadacademica'];
	
	
	$link_origen=$_GET['link_origen'];
	$debug=false;
	if($_GET['depurar']==si)
	{
		$debug=true;
		$sala->debug=true;
	}
	/*if($_SESSION['codigocarrera']=='todos' or $_SESSION['codigocarrera']=="" or $_SESSION['codigoperiodo_seleccionado']=="")
	{
		echo '<script language="javascript">alert("Debe seleccionar solo una carrera y periodo")</script>';
		echo '<script language="javascript">window.location.reload("menu.php")</script>';
	}*/
	
	$admisiones_consulta=new TablasAdmisiones($sala,$debug);
	
	$array_subperiodo=$admisiones_consulta->LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera,$codigoperiodo);
	$idsubperiodo=$array_subperiodo['idsubperiodo'];
	$idadmision=$admisiones_consulta->LeerIdadmision($codigocarrera,$idsubperiodo);
	$array_parametrizacion_admisiones=$admisiones_consulta->LeerParametrizacionPruebasAdmision($idadmision);
	
	$array_listado_asignacion_pruebas=$admisiones_consulta->GenerarListadoPruebasAdmision($codigocarrera,$idsubperiodo);
	$i=1;
	if(!empty($array_listado_asignacion_pruebas)){
	
	foreach ($array_listado_asignacion_pruebas as $llave => $valor)
	{
		if($codigomodalidadacademica<>300)
		{
			$array_colegios[]['colegio_egreso']=$admisiones_consulta->ObtenerColegio($valor['codigoestudiante']);
		}
		else
		{
			$array_colegios[]['universidad_egreso']=$admisiones_consulta->ObtenerUniversidadEgreso($valor['codigoestudiante']);
		}
		$array_opcion[]=$admisiones_consulta->ObtenerSegundaOpcion($valor['codigoestudiante'],$codigocarrera,$idsubperiodo);
	}
	$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_colegios);
	$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_opcion);
	//$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_numero);
	
	$FlagRequiereIcfes=false;
	foreach ($array_parametrizacion_admisiones as $llave => $valor)
	{
		$cadena_llave="PUNTAJE_".ereg_replace(" ","_",$valor['nombretipodetalleadmision']);
		$cadena_llave_2="PORC_".ereg_replace(" ","_",$valor['nombretipodetalleadmision']);
		$cadena_llave_3="TOT_PREGUNTAS_".ereg_replace(" ","_",$valor['nombretipodetalleadmision']);
		$cadena_llave_4="RESULTADO_PRUEBAS_ESTADO";
	
		foreach ($array_listado_asignacion_pruebas as $llave => $valor_l)
		{
			if($valor['codigotipodetalleadmision']<>4)//no calcular icfes
			{
				$array_resultado_examen=$admisiones_consulta->ObtenerResultadoExamen($valor_l['codigoestudiante'],$idadmision,$valor['codigotipodetalleadmision']);
				//$array_resultado_admision[]=array($cadena_llave=>$array_resultado_examen['resultado'],$cadena_llave_2=>$array_resultado_examen['porcentaje'],$cadena_llave_3=>$array_resultado_examen['total_preguntas']);
				if(trim($array_resultado_examen['resultado'])=="0") $array_resultado_examen['resultado']="...";
				//echo "Resultado=".$array_resultado_examen['resultado']."<br>";
	
				$array_resultado_admision[]=array($cadena_llave=>$array_resultado_examen['resultado']);
			}
			else
			{
				$array_parametrizacion_icfes=array('nombretipodetalleadmision',$valor['nombretipodetalleadmision'],'iddetalleadmision'=>$valor['iddetalleadmision'],'porcentajedetalleadmision'=>$valor['porcentajedetalleadmision'],'totalpreguntasdetalleadmision'=>$valor['totalpreguntasdetalleadmision']);
				$FlagRequiereIcfes=true;
			}
		}
		$array_puntajes[]=array('codigotipodetalleadmision'=>$valor['codigotipodetalleadmision'],'array_puntaje'=>$array_resultado_admision);
		if($debug==true)
		{
			echo "<h1>Tabla de puntajes x codigotipodetalleadmision)</h1>";
			$admisiones_consulta->DibujarTabla($array_resultado_admision,$valor['codigotipodetalleadmision']);
		}
		unset($array_resultado_admision);
	}
	foreach ($array_parametrizacion_admisiones as $llave => $valor)
	{
		if($valor['codigotipodetalleadmision']<>4)
		{
			$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_puntajes[$llave]['array_puntaje']);
		}
	}
	if($FlagRequiereIcfes==true)
	{
		foreach ($array_listado_asignacion_pruebas as $llave => $valor)
		{
			$array_icfes[]['RESULTADO_PRUEBAS_ESTADO']=$admisiones_consulta->ObtenerResultadoIcfes($valor['codigoestudiante']);
		}
		$array_listado_asignacion_pruebas = $admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_icfes);
	}
	/**
	 * Finalmente, se calcula la columna del promedio
	 */
	unset($FlagRequiereIcfes);
	foreach ($array_parametrizacion_admisiones as $llave => $valor)
	{
	
		foreach ($array_listado_asignacion_pruebas as $llave => $valor_l)
		{
			$cadena_promedio="ACUMULADO ".ereg_replace(" ","_",$valor['nombretipodetalleadmision']);
			$cadena_llave="PUNTAJE_".ereg_replace(" ","_",$valor['nombretipodetalleadmision']);
	
			if($valor['codigotipodetalleadmision']<>4)
			{
				//no calcular icfes
				$array_promedio_acumulado[][$cadena_promedio]=$admisiones_consulta->CalculaPromedioColumnaResultados($valor_l[$cadena_llave],$valor['porcentajedetalleadmision'],$valor['totalpreguntasdetalleadmision']);
			}
			else
			{
				$FlagRequiereIcfes=true;
			}
		}
		if($debug==true)
		{
			echo "<h1>Tabla de acumulados x codigotipodetalleadmision)</h1>";
			$admisiones_consulta->DibujarTabla($array_promedio_acumulado,$valor['codigotipodetalleadmision']);
		}
		$array_acumulados[]=array('codigotipodetalleadmision'=>$valor['codigotipodetalleadmision'],'array_acumulado'=>$array_promedio_acumulado);
		unset($array_promedio_acumulado);
	}
	
	foreach ($array_parametrizacion_admisiones as $llave => $valor)
	{
		if($valor['codigotipodetalleadmision']<>4)
		{
			$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_acumulados[$llave]['array_acumulado']);
		}
	}
	
	/**
	 * Si se requiere el icfes, calcula el promedio acumulado
	 */
	if($FlagRequiereIcfes==true)
	{
		foreach ($array_listado_asignacion_pruebas as $llave => $valor)
		{
			$array_promedio_acumulado_icfes[]['ACUMULADO_PRUEBAS_ESTADO']=$admisiones_consulta->CalculaPromedioColumnaResultados($valor['RESULTADO_PRUEBAS_ESTADO'],$array_parametrizacion_icfes['porcentajedetalleadmision'],$array_parametrizacion_icfes['totalpreguntasdetalleadmision']);
		}
		$array_listado_asignacion_pruebas = $admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_promedio_acumulado_icfes);
	}
	$array_sumatoria_acumulados=$admisiones_consulta->CalculaColumnaAcumuladoTotalSumatoria($array_listado_asignacion_pruebas,$array_parametrizacion_admisiones,$FlagRequiereIcfes);
	
	$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_sumatoria_acumulados);
	
	$_SESSION['array_listado_asignacion_pruebas']=$array_listado_asignacion_pruebas;
	//si se le da por el get, admitir, apunta al listado de admisión con chulitos de los mechudos
	}

}
/* echo "<pre>";
print_r($_SESSION['array_listado_asignacion_pruebas']);
echo "</pre>"; */
	echo'<meta http-equiv="REFRESH" content="0;URL=listado_informe.php?asignahorario&codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'"/>';



?>