<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
//error_reporting(0);
if(isset($_GET['orden']) and $_GET['orden']!="")
{
	$_SESSION['orden']=$_GET['orden'];
}
if(isset($_GET['ordenamiento']) and $_GET['ordenamiento']!="")
{
	$_SESSION['ordenamiento']=$_GET['ordenamiento'];
}
if(isset($_GET['codigomodalidadacademica']) and isset($_GET['codigocarrera']) and isset($_GET['codigoperiodo']))
{
	$_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
	$_SESSION['codigocarrera']=$_GET['codigocarrera'];
	$_SESSION['codigoperiodo']=$_GET['codigoperiodo'];
}
$_SESSION['get']=$_GET;
//print_r($_SESSION);
?>

<?php
require_once("../../../../funciones/conexion/conexionpear.php");
require_once("clases/obtener_datos.php");
require_once("funciones/filtro.php");
require_once("funciones/imprimir_arrays_bidimensionales.php");
require_once("funciones/ordenar_matrices.php");
require_once("funciones/totales_matrices.php");
?>
<script type="text/javascript" src="funciones_javascript.js"></script>
<style type="text/css">@import url(estilos/sala.css);</style>
<?php
$contador=0;
$sumatoria=0;
$nombrellave_inc=0;
$datos_matriculas=new obtener_datos_matriculas($sala,$_SESSION['codigoperiodo']);
if(isset($_SESSION['codigomodalidadacademica']) and isset($_SESSION['codigocarrera']))
{
	if($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$row_obtener_carreras=$datos_matriculas->obtener_carreras("","");
	}
	elseif($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']!="todos")
	{
		$row_obtener_carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
	}
	elseif($_SESSION['codigomodalidadacademica']!="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$row_obtener_carreras=$datos_matriculas->obtener_carreras($_SESSION['codigomodalidadacademica'],"");
	}
	else
	{
		$row_obtener_carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
	}
}

$row_datos_151=$datos_matriculas->obtener_datos_base("151");
$row_datos_152=$datos_matriculas->obtener_datos_base("152");
$row_datos_153=$datos_matriculas->obtener_datos_base("153");

$row_cantidades_151=$datos_matriculas->contar_cantidades("151");
$row_cantidades_152=$datos_matriculas->contar_cantidades("152");
$row_cantidades_153=$datos_matriculas->contar_cantidades("153");

$row_cantidades_matriculas_tipoestudiante_10=$datos_matriculas->contar_valores_por_tipestudiante("10");
$row_cantidades_matriculas_tipoestudiante_11=$datos_matriculas->contar_valores_por_tipestudiante("11");
$row_cantidades_matriculas_tipoestudiante_20=$datos_matriculas->contar_valores_por_tipestudiante("20");
$row_cantidades_matriculas_tipoestudiante_21=$datos_matriculas->contar_valores_por_tipestudiante("21");


$row_pagoxinternet_151=$datos_matriculas->obtener_cantidad_pagosxinternet("151");
$row_pagoxinternet_152=$datos_matriculas->obtener_cantidad_pagosxinternet("152");
$row_pagoxinternet_153=$datos_matriculas->obtener_cantidad_pagosxinternet("153");

$row_cantidad_alumnos_matriculados_nuevos=$datos_matriculas->obtener_cantidad_alumnos_matriculados("10");
$row_cantidad_alumnos_matriculados_transferencia=$datos_matriculas->obtener_cantidad_alumnos_matriculados("11");
$row_cantidad_alumnos_matriculados_antiguos=$datos_matriculas->obtener_cantidad_alumnos_matriculados("20");
$row_cantidad_alumnos_matriculados_reintegro=$datos_matriculas->obtener_cantidad_alumnos_matriculados("21");

$row_cantidad_alumnos_preinscritos=$datos_matriculas->contar_cantidad_alumnos_codigosituacioncarreraestudiante("106");
$row_cantidad_alumnos_inscritos=$datos_matriculas->contar_cantidad_alumnos_codigosituacioncarreraestudiante("107");


foreach($row_obtener_carreras as $clave => $valor)
{
	$array_datos[$contador]['cod']=$valor['codigocarrera'];
	$array_datos[$contador]['nombrecarrera']=$valor['nombrecarrera'];
	if($row_cantidades_151[$contador]==""){$array_datos[$contador]['cantidad_matricula']=0;}else{$array_datos[$contador]['cantidad_matricula']=$row_cantidades_151[$contador];};
	if($row_pagoxinternet_151[$contador]['cantidad']==""){$array_datos[$contador]['cantidad_matricula_internet']=0;}else{$array_datos[$contador]['cantidad_matricula_internet']=$row_pagoxinternet_151[$contador]['cantidad'];};
	$array_datos[$contador]['cantidad_matricula_presencial']=$row_cantidades_151[$contador]-$row_pagoxinternet_151[$contador]['cantidad'];
	if($row_pagoxinternet_151[$contador]['valor']==""){$array_datos[$contador]['valor_matricula_internet']=0;}else{$array_datos[$contador]['valor_matricula_internet']=$row_pagoxinternet_151[$contador]['valor'];}
	$array_datos[$contador]['valor_matricula_presencial']=$row_datos_151[$contador]['total']-$row_pagoxinternet_151[$contador]['valor'];
	if($row_datos_151[$contador]['total']==""){$array_datos[$contador]['total_matricula']=0;}else{$array_datos[$contador]['total_matricula']=$row_datos_151[$contador]['total'];};

	if($row_cantidades_152[$contador]==""){$array_datos[$contador]['cantidad_formulario']=0;}else{$array_datos[$contador]['cantidad_formulario']=$row_cantidades_152[$contador];};
	if($row_pagoxinternet_152[$contador]['cantidad']==""){$array_datos[$contador]['cantidad_formulario_internet']=0;}else{$array_datos[$contador]['cantidad_formulario_internet']=$row_pagoxinternet_152[$contador]['cantidad'];};
	$array_datos[$contador]['cantidad_formulario_presencial']=$row_cantidades_152[$contador]-$row_pagoxinternet_152[$contador]['cantidad'];
	if($row_pagoxinternet_152[$contador]['valor']==""){$array_datos[$contador]['valor_formulario_internet']=0;}else{$array_datos[$contador]['valor_formulario_internet']=$row_pagoxinternet_152[$contador]['valor'];};
	$array_datos[$contador]['valor_formulario_presencial']=$row_datos_152[$contador]['total']-$row_pagoxinternet_152[$contador]['valor'];
	if($row_datos_152[$contador]['total']==""){$array_datos[$contador]['total_formulario']=0;}else{$array_datos[$contador]['total_formulario']=$row_datos_152[$contador]['total'];};


	if($row_cantidades_153[$contador]==""){$array_datos[$contador]['cantidad_inscripcion']=0;}else{$array_datos[$contador]['cantidad_inscripcion']=$row_cantidades_153[$contador];};
	if($row_pagoxinternet_153[$contador]['cantidad']==""){$array_datos[$contador]['cantidad_inscripcion_internet']=0;}else{$array_datos[$contador]['cantidad_inscripcion_internet']=$row_pagoxinternet_153[$contador]['cantidad'];};
	$array_datos[$contador]['cantidad_inscripcion_presencial']=$row_cantidades_153[$contador]-$row_pagoxinternet_153[$contador]['cantidad'];
	if($row_pagoxinternet_153[$contador]['valor']==""){$array_datos[$contador]['valor_inscripcion_internet']=0;}else{$array_datos[$contador]['valor_inscripcion_internet']=$row_pagoxinternet_153[$contador]['valor'];};
	$array_datos[$contador]['valor_inscripcion_presencial']=$row_datos_153[$contador]['total']-$row_pagoxinternet_153[$contador]['valor'];
	if($row_datos_153[$contador]['total']==""){$array_datos[$contador]['total_inscripcion']=0;}else{$array_datos[$contador]['total_inscripcion']=$row_datos_153[$contador]['total'];};

	if($row_cantidad_alumnos_matriculados_nuevos[$contador]['total']==""){$array_datos[$contador]['valor_matriculados_nuevos']=0;}else{$array_datos[$contador]['valor_matriculados_nuevos']=$row_cantidad_alumnos_matriculados_nuevos[$contador]['total'];};
	if($row_cantidades_matriculas_tipoestudiante_10[$contador]==""){$array_datos[$contador]['cantidad_matriculados_nuevos']=0;}else{$array_datos[$contador]['cantidad_matriculados_nuevos']=$row_cantidades_matriculas_tipoestudiante_10[$contador];};

	if($row_cantidad_alumnos_matriculados_transferencia[$contador]['total']==""){$array_datos[$contador]['valor_matriculados_transferencia']=0;}else{$array_datos[$contador]['valor_matriculados_transferencia']=$row_cantidad_alumnos_matriculados_transferencia[$contador]['total'];};
	if($row_cantidades_matriculas_tipoestudiante_11[$contador]==""){$array_datos[$contador]['cantidad_matriculados_transferencia']=0;}else{$array_datos[$contador]['cantidad_matriculados_transferencia']=$row_cantidades_matriculas_tipoestudiante_11[$contador];};

	if($row_cantidad_alumnos_matriculados_antiguos[$contador]['total']==""){$array_datos[$contador]['valor_matriculados_antiguos']=0;}else{$array_datos[$contador]['valor_matriculados_antiguos']=$row_cantidad_alumnos_matriculados_antiguos[$contador]['total'];};
	if($row_cantidades_matriculas_tipoestudiante_20[$contador]==""){$array_datos[$contador]['cantidad_matriculados_antiguos']=0;}else{$array_datos[$contador]['cantidad_matriculados_antiguos']=$row_cantidades_matriculas_tipoestudiante_20[$contador];};

	if($row_cantidad_alumnos_matriculados_reintegro[$contador]['total']==""){$array_datos[$contador]['valor_matriculados_reintegro']=0;}else{$array_datos[$contador]['valor_matriculados_reintegro']=$row_cantidad_alumnos_matriculados_reintegro[$contador]['total'];};
	if($row_cantidades_matriculas_tipoestudiante_21[$contador]==""){$array_datos[$contador]['cantidad_matriculados_reintegro']=0;}else{$array_datos[$contador]['cantidad_matriculados_reintegro']=$row_cantidades_matriculas_tipoestudiante_21[$contador];};

	$array_datos[$contador]['preinscritos']=$row_cantidad_alumnos_preinscritos[$contador]['total'];
	$array_datos[$contador]['inscritos']=$row_cantidad_alumnos_inscritos[$contador]['total'];

	$contador++;
}

$ordenamiento=new matriz($array_datos);
$ordenamiento->leer_llaves();
$array_ordenado=$ordenamiento->ordenamiento($_GET['ordenamiento'],$_GET['orden']);


?>
<form name="form1" method="GET" action="">

<?php 
if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
{

	$ordenamiento->agregarcolumna_filtro_automatica($_SESSION['get']);
	$array_filtrado=$ordenamiento->filtrar($array_ordenado);
	$totales=new totales($array_filtrado);
	$totales->leer_columnas();
	$array_totales=$totales->totales_matriz();
	listar($array_filtrado,"Admisiones Periodo ".$_SESSION['codigoperiodo']."","admisiones.php");
	listar($array_totales,"Subtotales","","no");
}
else
{
	$totales=new totales($array_ordenado);
	$totales->leer_columnas();
	$array_totales=$totales->totales_matriz();
	listar($array_ordenado,"Admisiones Periodo ".$_SESSION['codigoperiodo']."","admisiones.php");
	listar($array_totales,"Subtotales","","no");
}


?>
<input name="Filtrar" type="submit" id="Filtrar" value="Filtrar">
<input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
<input name="Regresar" type="submit" id="Regresar" value="Regresar">
<input type="hidden" name="ordenamiento" value="<?php echo $_GET['ordenamiento']?>">
<input type="hidden" name="orden" value="<?php echo $_GET['orden']?>">
<input type="hidden" name="filtrar" value="<?php echo $_GET['filtrar']?>">
</form>
<?php
if(isset($_GET['Restablecer']))
{
	unset($_SESSION['get']);
	echo '<script language="javascript">window.location.reload("estadisticas.php")</script>';
}
if(isset($_GET['Regresar']))
{
	unset($_SESSION['get']);
	echo '<script language="javascript">window.location.reload("menu.php?codigomodalidadacademica='.$_SESSION['codigomodalidadacademica'].'&codigocarrera='.$_SESSION['codigocarrera'].'&codigoperiodo='.$_SESSION['codigoperiodo'].'")</script>';
}
?>
<?php
$llaves=leer_llaves($array_datos);
tabla_arreglo_chulitos($llaves);
if(isset($_POST['Recortar']))
{
	foreach($_POST as $vpost => $valor)
	{
		if (ereg("^sel".$valor."$",$vpost))
		{
			$array_llaves_seleccionadas[]=$valor;

		}
	}
	if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
	{
		$recorte=$ordenamiento->recortar($array_filtrado,$array_llaves_seleccionadas);
	}
	else
	{
		$recorte=$ordenamiento->recortar($array_ordenado,$array_llaves_seleccionadas);
	}

	listar($recorte,"Admisiones Periodo ".$_SESSION['codigoperiodo']."","admisiones.php","no");
}
?>