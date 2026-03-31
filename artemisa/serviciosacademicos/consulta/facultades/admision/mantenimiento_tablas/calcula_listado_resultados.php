<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    ini_set('memory_limit', '64M');
    ini_set('max_execution_time','90');
    require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
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
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once('funciones/ObtenerDatos.php');
//error_reporting(2047);
?>
<?php

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
if($_SESSION['codigocarrera']=='todos' or $_SESSION['codigocarrera']=="" or $_SESSION['codigoperiodo_seleccionado']=="")
{
	echo '<script language="javascript">alert("Debe seleccionar solo una carrera y periodo")</script>';
	echo '<script language="javascript">window.location.reload("menu.php")</script>';
}

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
	$fechanacimiento=formato_fecha_defecto(sacarpalabras($valor["fechanacimiento"],0,0));
	$edadmeses=(int) (diferencia_fechas($fechanacimiento,date("d/m/Y"),"meses",0)/12);
	$array_edades[]['Edad']=$edadmeses;
	if($codigomodalidadacademica<>300)
	{
		$array_colegios[]['colegio_egreso']=$admisiones_consulta->ObtenerColegio($valor['codigoestudiante']);
        $periodos = 2;
        $array_icfesGeneral[]['PUNTAJE_GENERAL_ICFES'] = $admisiones_consulta->ObtenerPuntajeGeneralIcfes($valor['codigoestudiante']);
        $array_recursofinanciero[]['TIPO_RECURSO'] = $admisiones_consulta->ObtenerTipoRecurso($valor['codigoestudiante']);
	}
	else
	{
        $periodos = '1';
		$array_colegios[]['universidad_egreso']=$admisiones_consulta->ObtenerUniversidadEgreso($valor['codigoestudiante']);
        $periodo=$admisiones_consulta->validarperiodo($valor['codigoestudiante']);        
        if(!$periodo['FechaPrueba']){$periodo['FechaPrueba']=0;}
        $array_periodo[]['Periodo']=$periodo['FechaPrueba'];
	}
	$array_opcion[]=$admisiones_consulta->ObtenerSegundaOpcion($valor['codigoestudiante'],$codigocarrera,$idsubperiodo);
}
   
$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_edades);
$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_colegios);
$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_opcion);
if($periodos== 1)
{
    $array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_periodo);
}
if($periodos== 2)
{
    $array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_icfesGeneral);
    $array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_recursofinanciero);
}
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
		if($valor['codigotipodetalleadmision']<>4)//no calcular icfes o ecaes
		{            
			$array_resultado_examen=$admisiones_consulta->ObtenerResultadoExamen($valor_l['codigoestudiante'],$idadmision,$valor['codigotipodetalleadmision']);			
			if(trim($array_resultado_examen['resultado'])=="0") $array_resultado_examen['resultado']="...";			
			$array_resultado_admision[]=array($cadena_llave=>$array_resultado_examen['resultado']);
		}
		else
		{                             
            $array_parametrizacion_icfes=array('nombretipodetalleadmision',$valor['nombretipodetalleadmision'],'iddetalleadmision'=>$valor['iddetalleadmision'],'porcentajedetalleadmision'=>$valor['porcentajedetalleadmision'],'totalpreguntasdetalleadmision'=>$valor['totalpreguntasdetalleadmision']);
            
            $modalidadcarrera = $admisiones_consulta->modalidadcarrera($codigocarrera);
            //si la modalidad de la carrera es 300 se ingresa al ecaes
            if($modalidadcarrera == '300')
            {
                $FlagRequiereEcaes=true;    
            }
            //si la modalidad de la carrera es 200 se ingresa al icfes
            if($modalidadcarrera == '200')
            {
                $FlagRequiereIcfes=true;        
            }
		}
	}//foreach $array_listado_asignacion_pruebas
	$array_puntajes[]=array('codigotipodetalleadmision'=>$valor['codigotipodetalleadmision'],'array_puntaje'=>$array_resultado_admision);    
	if($debug==true)
	{
		echo "<h1>Tabla de puntajes x codigotipodetalleadmision)</h1>";
		$admisiones_consulta->DibujarTabla($array_resultado_admision,$valor['codigotipodetalleadmision']);
	}
	unset($array_resultado_admision);
}//foreach $array_parametrizacion_admisiones
foreach ($array_parametrizacion_admisiones as $llave => $valor)
{
	if($valor['codigotipodetalleadmision']<>4)
	{
		$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_puntajes[$llave]['array_puntaje']);
	}
}//foreach $array_parametrizacion_admisiones
        
if($FlagRequiereIcfes==true)
{
	foreach ($array_listado_asignacion_pruebas as $llave => $valor)
	{
		$array_icfes[]['RESULTADO_PRUEBAS_ESTADO']=$admisiones_consulta->ObtenerResultadoIcfes($valor['codigoestudiante']);
	}    
	$array_listado_asignacion_pruebas = $admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_icfes);
    $pruebaestado = true;
}
/**
 * Finalmente, se calcula la columna del promedio
 */
unset($FlagRequiereIcfes);
    
//Si es necesio el ecaes de valida
if($FlagRequiereEcaes==true)
{    
	foreach ($array_listado_asignacion_pruebas as $llave => $valor)
	{    
		$array_ecaes[]['RESULTADO_PRUEBAS_ESTADO']=$admisiones_consulta->ObtenerResultadoEcaes($valor['codigoestudiante']);
	}    
	$array_listado_asignacion_pruebas = $admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_ecaes);    
    $pruebaestado = true;
}    
unset($FlagRequiereEcaes);  
    
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
            $modalidadcarrera = $admisiones_consulta->modalidadcarrera($codigocarrera);
            //si la modalidad de la carrera es 300 se ingresa al ecaes
            if($modalidadcarrera == '300')
            {
                $FlagRequiereEcaes=true;    
            }
            //si la modalidad de la carrera es 200 se ingresa al icfes
            if($modalidadcarrera == '200')
            {
                $FlagRequiereIcfes=true;        
            }
		}
	}//foreach $array_listado_asignacion_pruebas
	if($debug==true)
	{
		echo "<h1>Tabla de acumulados x codigotipodetalleadmision)</h1>";
		$admisiones_consulta->DibujarTabla($array_promedio_acumulado,$valor['codigotipodetalleadmision']);
	}
	$array_acumulados[]=array('codigotipodetalleadmision'=>$valor['codigotipodetalleadmision'],'array_acumulado'=>$array_promedio_acumulado);
	unset($array_promedio_acumulado);
}//foreach $array_parametrizacion_admisiones

    
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
    $pruebaestado = true;
}//if icfes
    
if($FlagRequiereEcaes==true)
{
    $y=0;
	foreach ($array_listado_asignacion_pruebas as $llave => $valordatos)
	{
        if($valordatos['RESULTADO_PRUEBAS_ESTADO'] === 'no aplica')
        {
            $valordatos['RESULTADO_PRUEBAS_ESTADO'] = 0;   
            $puntaje = $valordatos['PUNTAJE_EXAMEN_ESCRITO_DE_CONOCIMIENTOS_GENERALES'];
            if($puntaje!='...')
            {  
                //si no aplica el ecaes se saca nuevamente el resultado de la prueba de escrita sumando el porcentaje del ecaes. IQ
                $suma = $admisiones_consulta->AjustarresultadoExamen($valordatos['codigoestudiante'], $valordatos['idadmision'], $puntaje); 
                $array_listado_asignacion_pruebas[$y]['ACUMULADO EXAMEN_ESCRITO_DE_CONOCIMIENTOS_GENERALES'] = $suma;                 
            }
        }
		$array_promedio_acumulado_ecaes[]['ACUMULADO_PRUEBAS_ESTADO']=$admisiones_consulta->CalculaPromedioColumnaResultados($valordatos['RESULTADO_PRUEBAS_ESTADO'],$array_parametrizacion_icfes['porcentajedetalleadmision'],$array_parametrizacion_icfes['totalpreguntasdetalleadmision']);
        $y++;
	}
	$array_listado_asignacion_pruebas = $admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_promedio_acumulado_ecaes);
    $pruebaestado = true;
}//if ecaes
        
$array_sumatoria_acumulados=$admisiones_consulta->CalculaColumnaAcumuladoTotalSumatoria($array_listado_asignacion_pruebas,$array_parametrizacion_admisiones,$pruebaestado);
    
$array_listado_asignacion_pruebas=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_pruebas,$array_sumatoria_acumulados);
    
$_SESSION['array_listado_asignacion_pruebas']=$array_listado_asignacion_pruebas;
//si se le da por el get, admitir, apunta al listado de admisión con chulitos de los mechudos
}
if(isset($_GET['admitir']))
{
	echo'<meta http-equiv="REFRESH" content="0;URL=listado_admitir.php?reload=recargar=calcula_listado_resultados.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'&link_origen=menu.php"/>';
}

else
{
	if(isset($_GET['cambioestado']))
	{
		echo'<meta http-equiv="REFRESH" content="0;URL=listado_asigna_proceso.php?reload=recargar=calcula_listado_resultados.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'&link_origen=menu.php"/>';
	}
	else 
	{
		if(isset($_GET['asignaestado']))
			echo'<meta http-equiv="REFRESH" content="0;URL=listado_asigna_horario.php?asignahorario&reload=recargar=calcula_listado_resultados.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'&link_origen=menu.php"/>';
		else
			if(isset($_GET['listadoadmitir']))
				echo'<meta http-equiv="REFRESH" content="0;URL=listado_cambio_admitir.php?reload=recargar=calcula_listado_resultados.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'&link_origen=menu.php"/>';
			else		
				echo'<meta http-equiv="REFRESH" content="0;URL=listado_resultados.php?reload=recargar=calcula_listado_resultados.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'&link_origen=menu.php"/>';
	}
		
	
}


?>