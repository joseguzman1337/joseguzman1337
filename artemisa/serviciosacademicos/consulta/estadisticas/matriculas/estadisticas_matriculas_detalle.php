<?php
session_start();
//require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
//print_r($_GET);
//error_reporting(0);
?>
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once("funciones/obtener_datos.php");
?>
<?php
$_SESSION['codigocarrera_reporte']=$_GET['codigocarrera'];
$_SESSION['descriptor_reporte']=$_GET['descriptor'];
$_SESSION['codigoperiodo_reporte']=$_GET['codigoperiodo'];
$_SESSION['sesioncodigoprocesovidaestudiante'] = $_REQUEST['codigoprocesovidaestudiante'];

$contador=0;
$carrera="SELECT c.nombrecarrera from carrera c WHERE c.codigocarrera='".$_SESSION['codigocarrera_reporte']."'";
$operacion_carrera=$sala->query($carrera);
$row_carrera=$operacion_carrera->fetchRow();
$nombrecarrera=strtoupper($row_carrera['nombrecarrera']);

$datos_matriculas=new obtener_datos_matriculas($sala,$_SESSION['codigoperiodo_reporte']);
//para los recursivos



if(isset($_SESSION['codigomodalidadacademica']) and isset($_SESSION['codigocarrera']))
{
	if($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$carreras=$datos_matriculas->obtener_carreras("","");
	}
	elseif($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']!="todos")
	{
		$carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
	}
	elseif($_SESSION['codigomodalidadacademica']!="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$carreras=$datos_matriculas->obtener_carreras($_SESSION['codigomodalidadacademica'],"");
	}
	else
	{
		$carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
	}
}

switch ($_SESSION['descriptor_reporte'])
{
	case 'Aspirantes':
		$array_codigosestudiante=$datos_matriculas->ObtenerAspirantesSinmatriculaSinPago($_SESSION['codigocarrera_reporte'],$_SESSION['codigoperiodo_reporte'],'arreglo');
		if(is_array($array_codigosestudiante))
		{
			foreach ($array_codigosestudiante as $llave => $valor)
			{
				$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
				$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
				$contador++;
			}
		}
		else
		{
			echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
			echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
		}
		$_SESSION['titulo']='ASPIRANTES '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_Aspirantes'://acumular todos los mechudos del drill-down

	$contador=0;
	foreach ($carreras as $llave => $valor)
	{
		//$array_codigosestudiante=$datos_matriculas->obtener_datos_codigosituacioncarreraestudiante($valor['codigocarrera'],106,'arreglo');
		$array_codigosestudiante=$datos_matriculas->ObtenerAspirantes($valor['codigocarrera'],$_SESSION['codigoperiodo_reporte'],'arreglo');
		foreach ($array_codigosestudiante as $llave => $valor)
		{
			$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
			$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
			$contador++;
		}
	}
	$_SESSION['titulo']='ASPIRANTES '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
	break;

	case 'Formularios':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_cuentaoperacionprincipal($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],152,'arreglo');
		$_SESSION['titulo']='FORMULARIOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'formulariosvsinscripcion':
		$array_codigosestudiante=$datos_matriculas->seguimiento_formulariovsinscripcion($_SESSION['codigocarrera_reporte'],'arreglo');
		$_SESSION['titulo']='FORMULARIOS VS INSCRIPCIONES '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'Inscritos':
		$contador=0;
		$array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],153,'arreglo');
		if(is_array($array_codigosestudiante))
		{
			foreach ($array_codigosestudiante as $llave => $valor)
			{
				$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
				$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
				$contador++;
			}

		}
		else
		{
			echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
			echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
		}
		$_SESSION['titulo']='INSCRITOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'Inscritos_Evaluados':
			$contador=0;
		$array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalInscritosEvaluado($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],153,'arreglo');
		if(is_array($array_codigosestudiante))
		{
			foreach ($array_codigosestudiante as $llave => $valor)
			{
				$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
				$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
				unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
				$contador++;
			}
		}
		else
		{
			echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
			echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
		}
		$_SESSION['titulo']='INSCRITOS EVALUADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'subtotal_Inscritos_Evaluados':
			$contador=0;
		foreach ($carreras as $llave => $valor)
		{
			//echo "ENTRO Inscritos_Evaluados? ".$valor['codigocarrera'];
			$array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalInscritosEvaluado($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],153,'arreglo');
			//echo "<pre>".print_r($array_codigosestudiante)."</pre>";
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$contador++;
				}
			}

		}
			if(!is_array($datos_estudiantes))
			{
				echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
				echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
			}

		$_SESSION['titulo']='INSCRITOS EVALUADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
break;


	case 'subtotal_Inscripciones':
		$contador=0;
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],153,'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
					//echo "<h1>MODALIDADACADEMICA=".$datos_estudiantes[$contador]["codigomodalidadacademica"]."</h1>";
					$contador++;
				}
				//exit();
			}
		}
		$_SESSION['titulo']='INSCRITOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'a_seguir_aspirantes_vs_inscritos':
		$contador=0;
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_aspirantes_vs_inscritos($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],'arreglo');
		}
		if(is_array($array_codigosestudiante))
		{
			foreach ($array_codigosestudiante as $llave => $valor)
			{
				$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
				$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
				$contador++;
			}
		}
		$_SESSION['titulo']='ASPIRANTES VS INSCRITOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'subtotal_a_seguir_aspirantes_vs_inscritos':
		$contador=0;
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_aspirantes_vs_inscritos($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='INSCRITOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'inscripcionvsmatriculadosnuevos':
		$array_codigosestudiante=$datos_matriculas->seguimiento_inscripcionvsmatriculadosnuevos($_SESSION['codigocarrera_reporte'],'arreglo');
		if(is_array($array_codigosestudiante))
		{
			foreach ($array_codigosestudiante as $llave => $valor)
			{
				$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
				$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
				$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
				$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
				$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
				$contador++;
			}
		}
		else
		{
			echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
			echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
		}
		$_SESSION['titulo']='INSCRITOS VS MATRICULADOS NUEVOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_a_seguir_inscripcion_vs_matriculados_nuevos':
		$contador=0;
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->seguimiento_inscripcionvsmatriculadosnuevos($valor['codigocarrera'],'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					if($valor['codigoestudiante']<>"")
					{
						$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
						$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
						$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
						$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
						$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
						$contador++;
					}
				}
			}
		}
		$_SESSION['titulo']='INSCRITOS VS MATRICULADOS NUEVOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'MatriculadosNuevos':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_nuevos($_SESSION['codigocarrera_reporte'],'arreglo');
		$_SESSION['titulo']='MATRICULADOS NUEVOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_MatriculadosNuevos':
		$contador=0;
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_nuevos($valor['codigocarrera'],'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='MATRICULADOS NUEVOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'MatriculadosAntiguos':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($_SESSION['codigocarrera_reporte'],20,'arreglo');
		$_SESSION['titulo']='MATRICULADOS ANTIGUOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_MatriculadosAntiguos':
		$contador=0;
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($valor['codigocarrera'],20,'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='MATRICULADOS ANTIGUOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'Matriculados_Repitentes_1_semestre':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_repitentes($_SESSION['codigocarrera_reporte'],20,'arreglo');
		$_SESSION['titulo']='MATRICULADOS REPITENTES 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_Matriculados_Repitentes_1_semestre':
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_repitentes($valor['codigocarrera'],20,'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='MATRICULADOS REPITENTES 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'MatriculadosTransferencia':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia($_SESSION['codigocarrera_reporte'],'arreglo');
		$_SESSION['titulo']='MATRICULADOS TRANSFERENCIA '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_Matriculados_Transferencia':
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia($valor['codigocarrera'],'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='MATRICULADOS TRANSFERENCIA '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'Matriculados_Transferencia_1_semestre':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia_1_semestre($_SESSION['codigocarrera_reporte'],'arreglo');
		$_SESSION['titulo']='MATRICULADOS TRANSFERENCIA 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_Matriculados_Transferencia_1_semestre':
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia_1_semestre($valor['codigocarrera'],'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='MATRICULADOS TRANSFERENCIA 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'MatriculadosReintegro':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_reintegro($_SESSION['codigocarrera_reporte'],'arreglo');
		$_SESSION['titulo']='MATRICULADOS REINTEGRO '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'subtotal_Matriculados_Reintegro':
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($valor['codigocarrera'],21,'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='MATRICULADOS REINTEGRO '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'Matriculados_Reintegro_1_semestre':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_reintegro_1_semestre($_SESSION['codigocarrera_reporte'],21,'arreglo');
		$_SESSION['titulo']='MATRICULADOS REINTEGRO 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_Matriculados_Reintegro_1_semestre':
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante_1_semestre($valor['codigocarrera'],21,'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='MATRICULADOS REINTEGRO 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'TotalMatriculados':
		$array_codigosestudiante=$datos_matriculas->obtener_total_matriculados($_SESSION['codigocarrera_reporte'],'arreglo');
		$_SESSION['titulo']='TOTAL MATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_Total_Matriculados':
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_total_matriculados($valor['codigocarrera'],'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['semestre']=$datos_matriculas->obtener_semestre_estudiante($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$datosordenes=$datos_matriculas->obtenerDatosOrdenMatricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['fechapagomatricula']=$datosordenes["fechapago"];

					$contador++;
				}
			}
		}
		$_SESSION['titulo']='TOTAL MATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'Total_Matriculados_1_semestre':
		$array_codigosestudiante=$datos_matriculas->obtener_total_matriculados_1_semestre($_SESSION['codigocarrera_reporte'],'arreglo');
		$_SESSION['titulo']='MATRICULADOS 1 SEMESTRE '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_Total_Matriculados_1_semestre':
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_total_matriculados_1_semestre($valor['codigocarrera'],'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='MATRICULADOS 1 SEMESTRE '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'Prematriculados':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_cuentaoperacionprincipal_ordenesnopagas($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],151,'arreglo');
		$_SESSION['titulo']='PREMATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;
	case 'subtotal_a_seguir_Prematriculados':
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_cuentaoperacionprincipal_ordenesnopagas($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],151,'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='PREMATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'Noprematriculados':
		$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_noprematriculados($_SESSION['codigocarrera_reporte'],'arreglo');
		if(is_array($array_codigosestudiante))
		{
			foreach ($array_codigosestudiante as $llave => $valor)
			{
				$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
				$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
				$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
				$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
				$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
				$contador++;
			}
		}
		else
		{
			echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
			echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
		}
		$_SESSION['titulo']='NO PREMATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_a_seguir_No_prematriculados':
		foreach ($carreras as $llave => $valor)
		{
			$array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_noprematriculados($valor['codigocarrera'],'arreglo');
			if(is_array($array_codigosestudiante))
			{
				foreach ($array_codigosestudiante as $llave => $valor)
				{
					$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
					$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
					$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
					$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
					$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
					$contador++;
				}
			}
		}
		$_SESSION['titulo']='NO PREMATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'Interesados':
		$array_idpreinscripciones=$datos_matriculas->obtener_preinscripcion_estadopreinscripcionestudiante_general($_SESSION['codigocarrera_reporte'],'arreglo');
		if(is_array($array_idpreinscripciones))
		{
			foreach ($array_idpreinscripciones as $llave => $valor)
			{
				$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_preinscripcion($valor['idpreinscripcion'],$_SESSION['codigocarrera_reporte']);
				$contador++;
			}
		}
		else
		{
			echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
			echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
		}
		$_SESSION['titulo']='INTERESADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
		break;

	case 'subtotal_Interesados'://sumar todos los arrays para el drill_down
	foreach ($carreras as $llave => $valor)
	{
		$array_idpreinscripciones=$datos_matriculas->obtener_preinscripcion_estadopreinscripcionestudiante_general($valor['codigocarrera'],'arreglo');
		if(is_array($array_idpreinscripciones))
		{
			foreach ($array_idpreinscripciones as $llave => $valor)
			{
				$datos_estudiantes[]=$datos_matriculas->obtener_datos_estudiante_preinscripcion($valor['idpreinscripcion'],$valor['codigocarrera']);
			}
		}
	}
	$_SESSION['titulo']='INTERESADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
	break;
}

if($_SESSION['descriptor_reporte']!='subtotal_Interesados'
and $_SESSION['descriptor_reporte']!='Interesados'
and $_SESSION['descriptor_reporte']!="Aspirantes"
and $_SESSION['descriptor_reporte']!="subtotal_Aspirantes"
and $_SESSION['descriptor_reporte']!='Inscritos'
and $_SESSION['descriptor_reporte']!='Inscritos_Evaluados'
and $_SESSION['descriptor_reporte']!='subtotal_Inscritos_Evaluados'
and $_SESSION['descriptor_reporte']!='subtotal_Inscripciones'
and $_SESSION['descriptor_reporte']!='inscripcionvsmatriculadosnuevos'
and $_SESSION['descriptor_reporte']!='subtotal_a_seguir_inscripcion_vs_matriculados_nuevos'
and $_SESSION['descriptor_reporte']!='Noprematriculados'
and $_SESSION['descriptor_reporte']!='subtotal_MatriculadosNuevos'
and $_SESSION['descriptor_reporte']!='subtotal_MatriculadosAntiguos'
and $_SESSION['descriptor_reporte']!='subtotal_Matriculados_Transferencia'
and $_SESSION['descriptor_reporte']!='subtotal_Matriculados_Reintegro'
and $_SESSION['descriptor_reporte']!='subtotal_Total_Matriculados'
and $_SESSION['descriptor_reporte']!='subtotal_Matriculados_Repitentes_1_semestre'
and $_SESSION['descriptor_reporte']!='subtotal_Matriculados_Transferencia_1_semestre'
and $_SESSION['descriptor_reporte']!='subtotal_Matriculados_Reintegro_1_semestre'
and $_SESSION['descriptor_reporte']!='subtotal_Total_Matriculados_1_semestre'
and $_SESSION['descriptor_reporte']!='subtotal_a_seguir_Prematriculados'
and $_SESSION['descriptor_reporte']!='subtotal_a_seguir_No_prematriculados'
and $_SESSION['descriptor_reporte']!='a_seguir_aspirantes_vs_inscritos'
and $_SESSION['descriptor_reporte']!='subtotal_a_seguir_aspirantes_vs_inscritos'
)//los que de una vez botan los datos del estudiante')
{
	if(is_array($array_codigosestudiante))
	{
		foreach ($array_codigosestudiante as $llave => $valor)
		{
			$datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante($valor['codigoestudiante']);
 			$datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
			$datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
			$datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
			$datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
			$datosordenes=$datos_matriculas->obtenerDatosOrdenMatricula($valor['codigoestudiante']);
			$datos_estudiantes[$contador]['fechapagomatricula']=$datosordenes["fechapago"];
		$contador++;
		}
	}
	else
	{
		echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
		echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
	}
}
unset($_SESSION['array_sesion']);
$_SESSION['array_sesion']=$datos_estudiantes;
//echo $_SESSION['descriptor_reporte'];
//echo "<pre>"; print_r($_SESSION['array_sesion']); echo "</pre>";
//exit();
if(is_array($_SESSION['array_sesion']))
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=tabla_estadisticas_matriculas_detalle.php'>";
}
?>