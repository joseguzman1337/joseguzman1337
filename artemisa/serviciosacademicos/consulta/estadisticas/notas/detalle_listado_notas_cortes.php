<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();

require_once("funciones/obtener_datos.php");
ini_set('memory_limit', '256M');
ini_set('max_execution_time','6400000');
error_reporting(0);
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Detalle listado promedio cortes de notas</title>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
</head>
<body>
<?php
if(isset($_GET['semestre']))
{
	$semestre=$_GET['semestre'];
}
if(isset($_GET['link_origen']))
{
	$link_origen=$_GET['link_origen'];
}

$contador=0;
$numerocorte_max=0;
$conteo=0;
$codigoestudiante_impreso=null;
//leer cantidad max de cortes para crear el array
if($_GET['descriptor']=="detalle")
{
	foreach ($_SESSION['estadisticas']->array_notas_estudiantes as $llave => $valor)
	{
		if($valor['codigomateria']==$_GET['codigomateria'])
		{
			if($valor['numerocorte']>$numerocorte_max)

			{
				$numerocorte_max=$valor['numerocorte'];
			}
		}
	}

	//para armar el array base
	foreach ($_SESSION['estadisticas']->array_notas_estudiantes as $llave => $valor)
	{
		if($_GET['codigoestudiante']==$valor['codigoestudiante'] and $_GET['codigomateria']==$valor['codigomateria'])
		{
			$array_interno[0]['codigoestudiante']=$valor['codigoestudiante'];
			$array_interno[0]['numerodocumento']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['numerodocumento'];
			$array_interno[0]['nombre']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['nombre'];
			$array_interno[0]['materia']=$_SESSION['estadisticas']->array_codigomaterias_leidas[$valor['codigomateria']]['nombremateria'];
			$array_interno[0]['codigomateria']=$valor['codigomateria'];
			for ($i=1;$i<=$numerocorte_max;$i++)
			{
				if($valor['numerocorte']==$i)
				{
					$nota=$valor['nota'];
					$array_interno[0]["corte_".$i]=$nota;
				}
			}
		}
	}
	$contador=0;
	reset($array_interno);
	//para poner la definitiva
	foreach ($array_interno as $llave => $valor)
	{
		foreach ($_SESSION['estadisticas']->array_definitivas_estudiantes as $llave_def => $valor_def)
		{
			if($valor_def['codigomateria']==$valor['codigomateria'] and $valor_def['codigoestudiante']==$valor['codigoestudiante'])
			{
				$definitiva=$valor_def['notadefinitiva'];
			}
		}
		$array_interno[0]['notadefinitiva']=$definitiva;
		//definir si si perdió y sipuede habilitar
		if($definitiva >= $_SESSION['estadisticas']->array_codigomaterias_leidas[$valor['codigomateria']]['notaminimaaprobatoria'])
		{
			$aprobada="si";
		}
		else
		{
			$aprobada="no";
		}

		if($definitiva >= $_SESSION['estadisticas']->array_codigomaterias_leidas[$valor['codigomateria']]['notaminimahabilitacion'])
		{
			$puedehabilitar="si";
		}
		else
		{
			$puedehabilitar="no";
		}

		$array_interno[0]['aprobada']=$aprobada;
		$array_interno[0]['habilitable']=$puedehabilitar;
	}
}
elseif ($_GET['descriptor']=="detallexmateria")
{
	foreach ($_SESSION['estadisticas']->array_notas_estudiantes as $llave => $valor)
	{
		if($valor['codigomateria']==$_GET['codigomateria'])
		{
			if($valor['numerocorte']>$numerocorte_max)

			{
				$numerocorte_max=$valor['numerocorte'];
			}
		}
	}

	//para armar el array base
	foreach ($_SESSION['estadisticas']->array_notas_estudiantes as $llave => $valor)
	{
		if($_GET['codigomateria']==$valor['codigomateria'])
		{
			$array_materia[]=$valor;
			if($codigoestudiante_impreso<>$valor['codigoestudiante'])
			{
				if($valor["existenota"]==true)
				{
					$array_interno[$contador]['codigoestudiante']=$valor['codigoestudiante'];
					$array_interno[$contador]['numerodocumento']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['numerodocumento'];
					$array_interno[$contador]['nombre']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['nombre'];
					$array_interno[$contador]['materia']=$_SESSION['estadisticas']->array_codigomaterias_leidas[$valor['codigomateria']]['nombremateria'];
					$array_interno[$contador]['codigomateria']=$valor['codigomateria'];
					for ($i=1;$i<=$numerocorte_max;$i++)
					{
						$array_interno[$contador]["corte_".$i]=null;
					}
					$codigoestudiante_impreso=$valor['codigoestudiante'];
					$contador++;
				}
			}

		}
	}
	$contador=0;
	//para ponerle las notas al array base
	foreach ($array_interno as $llave => $valor)
	{
		foreach ($array_materia as $llave_mat => $valor_mat)
		{
			if($valor['codigoestudiante']==$valor_mat['codigoestudiante'])
			{
				for ($i=1;$i<=$numerocorte_max;$i++)
				{
					if($valor_mat['numerocorte']==$i)
					{
						$array_interno[$llave]['corte_'.$i]=$valor_mat['nota'];
					}
				}
			}
		}
	}
	unset($array_materia);
	reset($array_interno);
	//para ponerle las definitivas al array base
	foreach ($array_interno as $llave => $valor)
	{
		foreach ($_SESSION['estadisticas']->array_definitivas_estudiantes as $llave_def => $valor_def)
		{
			if($valor_def['codigomateria']==$valor['codigomateria'] and $valor_def['codigoestudiante']==$valor['codigoestudiante'])
			{
				$definitiva=$valor_def['notadefinitiva'];
			}
		}
		$array_interno[$llave]['notadefinitiva']=$definitiva;
		//definir si si perdió y sipuede habilitar
		//definir si si perdió y sipuede habilitar
		if($definitiva >= $_SESSION['estadisticas']->array_codigomaterias_leidas[$valor['codigomateria']]['notaminimaaprobatoria'])
		{
			$aprobada="si";
		}
		else
		{
			$aprobada="no";
		}

		if($definitiva >= $_SESSION['estadisticas']->array_codigomaterias_leidas[$valor['codigomateria']]['notaminimahabilitacion'])
		{
			$puedehabilitar="si";
		}
		else
		{
			$puedehabilitar="no";
		}

		$array_interno[$llave]['aprobada']=$aprobada;
		$array_interno[$llave]['habilitable']=$puedehabilitar;
	}
}
elseif ($_GET['descriptor']=="pruebaacademica")
{
	$contador=0;
	//$array_interno=$_SESSION['estadisticas']->array_historico_situacion_estudiante[$_GET['codigoestudiante']];
	//para armar el array base
	foreach ($_SESSION['estadisticas']->array_estudiantes as $llave => $valor)
	{
		if($_GET['codigoestudiante']==$valor['codigoestudiante'])
		{
			foreach ($_SESSION['estadisticas']->array_historico_situacion_estudiante[$_GET['codigoestudiante']] as $llave_hist => $valor_hist)
			{
				$array_interno[$contador]['codigoestudiante']=$valor['codigoestudiante'];
				$array_interno[$contador]['numerodocumento']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['numerodocumento'];
				$array_interno[$contador]['nombre']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['nombre'];
				$array_interno[$contador]['situacion']=$valor_hist['situacion'];
				$array_interno[$contador]['periodo']=$valor_hist['periodo'];
				$array_interno[$contador]['fecha']=$valor_hist['fecha'];
				$array_interno[$contador]['fechainicio']=$valor_hist['fechainicio'];
				$array_interno[$contador]['fechafinal']=$valor_hist['fechafinal'];
				$contador++;
			}
		}
	}
}
elseif ($_GET['descriptor']=="totalpruebaacademica")
{
	$contador=0;
	//$array_interno=$_SESSION['estadisticas']->array_historico_situacion_estudiante[$_GET['codigoestudiante']];
	//para armar el array base
	foreach ($_SESSION['estadisticas']->array_estudiantes as $llave => $valor)
	{
		foreach ($_SESSION['estadisticas']->array_historico_situacion_estudiante[$valor['codigoestudiante']] as $llave_hist => $valor_hist)
		{
			$array_interno[$contador]['codigoestudiante']=$valor['codigoestudiante'];
			$array_interno[$contador]['numerodocumento']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['numerodocumento'];
			$array_interno[$contador]['nombre']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['nombre'];
			$array_interno[$contador]['situacion']=$valor_hist['situacion'];
			$array_interno[$contador]['periodo']=$valor_hist['periodo'];
			$array_interno[$contador]['fecha']=$valor_hist['fecha'];
			$array_interno[$contador]['fechainicio']=$valor_hist['fechainicio'];
			$array_interno[$contador]['fechafinal']=$valor_hist['fechafinal'];
			$contador++;
		}
	}
}
elseif($_GET['descriptor']=="detallexestudiante")
{
	//$_SESSION['estadisticas']->DibujarTabla($_SESSION['estadisticas']->array_notas_estudiantes);
	//para armar el array base
	foreach ($_SESSION['estadisticas']->array_notas_estudiantes as $llave => $valor)
	{
		if($_GET['codigoestudiante']==$valor['codigoestudiante'])
		{
			//solo mostrar las materias que tienen alguna nota
			if($valor["existenota"]==true)
			{
				$array_materia[]=$valor;
				$array_interno[$contador]['codigoestudiante']=$valor['codigoestudiante'];
				$array_interno[$contador]['numerodocumento']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['numerodocumento'];
				$array_interno[$contador]['nombre']=$_SESSION['estadisticas']->array_estudiantes[$valor['codigoestudiante']]['nombre'];
				$array_interno[$contador]['materia']=$_SESSION['estadisticas']->array_codigomaterias_leidas[$valor['codigomateria']]['nombremateria'];
				$array_interno[$contador]['codigomateria']=$valor['codigomateria'];
				$array_interno[$contador]["numerocorte"]=$valor['numerocorte'];
				$array_interno[$contador]["nota"]=$valor['nota'];
				$array_interno[$contador]['acumulado_corte']=($valor['nota']*$valor['porcentajecorte'])/100;
				$contador++;
			}
		}
	}
	$contador=0;
	//para ponerle las definitivas al array base
	foreach ($array_interno as $llave => $valor)
	{
		foreach ($_SESSION['estadisticas']->array_definitivas_estudiantes as $llave_def => $valor_def)
		{
			if($valor_def['codigomateria']==$valor['codigomateria'] and $valor_def['codigoestudiante']==$valor['codigoestudiante'])
			{
				$definitiva=$valor_def['notadefinitiva'];
			}
		}
		$array_interno[$llave]['notadefinitiva']=$definitiva;
		//definir si si perdió y sipuede habilitar
		//definir si si perdió y sipuede habilitar
		if($definitiva >= $_SESSION['estadisticas']->array_codigomaterias_leidas[$valor['codigomateria']]['notaminimaaprobatoria'])
		{
			$aprobada="si";
		}
		else
		{
			$aprobada="no";
		}

		if($definitiva >= $_SESSION['estadisticas']->array_codigomaterias_leidas[$valor['codigomateria']]['notaminimahabilitacion'])
		{
			$puedehabilitar="si";
		}
		else
		{
			$puedehabilitar="no";
		}

		$array_interno[$llave]['aprobada']=$aprobada;
		$array_interno[$llave]['habilitable']=$puedehabilitar;
	}

}
$motor=new matriz($array_interno,"Detalle","detalle_listado_notas_cortes.php?descriptor=".$_GET['descriptor']."&codigomateria=".$_GET['codigomateria']."&codigoestudiante=".$_GET['codigoestudiante']."&semestre=$semestre","si","si","listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php?descriptor=".$_GET['descriptor']."&codigomateria=".$_GET['codigomateria']."&codigoestudiante=".$_GET['codigoestudiante']."&semestre=$semestre",true,"si","../../../");
if(isset($_GET['redimensionable']))
{
	$motor->asignarCeldasRedimensionables("90px");
}
$motor->jsVarios();
$motor->archivo_origen_con_get=true;
$motor->mostrar();
?>
</body>

</html>