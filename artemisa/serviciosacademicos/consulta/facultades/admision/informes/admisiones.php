<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
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
require_once("../../../../../funciones/conexion/conexionpear.php");
require_once("clases/obtener_datos.php");
require_once("funciones/filtro.php");
require_once("funciones/imprimir_arrays_bidimensionales.php");
require_once("funciones/ordenar_matrices.php");
?>
<script type="text/javascript" src="funciones_javascript.js"></script>
<style type="text/css">@import url(estilos/sala.css);</style>
<?php
$contador=0;
$sumatoria=0;
$nombrellave_inc=0;

$admisiones=new obtener_datos_admisiones($sala,$_SESSION['codigoperiodo']);
if(isset($_SESSION['codigomodalidadacademica']) and isset($_SESSION['codigocarrera']))
{
	if($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$carreras=$admisiones->obtener_carreras("","");
	}
	elseif($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']!="todos")
	{
		$carreras=$admisiones->obtener_carreras("",$_SESSION['codigocarrera']);
	}
	elseif($_SESSION['codigomodalidadacademica']!="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$carreras=$admisiones->obtener_carreras($_SESSION['codigomodalidadacademica'],"");
	}
	else
	{
		$carreras=$admisiones->obtener_carreras("",$_SESSION['codigocarrera']);
	}
}
//$carreras=$admisiones->obtener_carreras($_SESSION['codigomodalidadacademica'],$_SESSION['codigocarrera']);
$estudiantes=$admisiones->obtener_estudiantes("","");
$datos_estudiantes=$admisiones->obtener_datos_estudiantes();
$icfes_estudiantes=$admisiones->calcular_icfes_estudiantes();
$salon_pruebas_estudiantes=$admisiones->obtener_salon_pruebas_estudiantes();
$pruebas=$admisiones->obtener_tipos_detalle_admision();
$estados_admision=$admisiones->obtener_estudiantes_estadoadmision();
//armado de arreglo principal
foreach ($estudiantes as $llaveestudiantes => $valorestudiantes)
{

	//print_r($valorestudiantes);
	$array_datos[$contador]['Estado_Proceso_Admision']=$estados_admision[$llaveestudiantes]['nombresituacioncarreraestudiante'];
	$array_datos[$contador]['Numero']=$contador+1;
	$array_datos[$contador]['Programa']=$valorestudiantes['nombrecarrera'];
	$array_datos[$contador]['codigoestudiante']=$valorestudiantes['codigoestudiante'];
	$array_datos[$contador]['idestudiantegeneral']=$valorestudiantes['idestudiantegeneral'];
	$array_datos[$contador]['nombre']=$datos_estudiantes[$llaveestudiantes]['nombre'];
	$array_datos[$contador]['numerodocumento']=$datos_estudiantes[$llaveestudiantes]['numerodocumento'];
	$array_datos[$contador]['genero']=$datos_estudiantes[$llaveestudiantes]['nombregenero'];
	if($datos_estudiantes[$llaveestudiantes]['fechanacimiento']==NULL or ereg("1900",$datos_estudiantes[$llaveestudiantes]['fechanacimiento']) or ereg("0000",$datos_estudiantes[$llaveestudiantes]['fechanacimiento']))
	{
		$array_datos[$contador]['edad']=NULL;
	}
	else
	{
		$array_datos[$contador]['edad']=$admisiones->edad($datos_estudiantes[$llaveestudiantes]['fechanacimiento']);
	}

	if($icfes_estudiantes[$llaveestudiantes]['puntaje_total']==NULL)
	{
		$array_datos[$contador]['puntaje_icfes']=NULL;
	}
	else
	{
		$array_datos[$contador]['puntaje_icfes']=$icfes_estudiantes[$llaveestudiantes]['puntaje_total'];
	}
	$array_datos[$contador]['salon']=$salon_pruebas_estudiantes[$llaveestudiantes]['observacionestudianteestudio'];

	foreach ($pruebas as $clave => $valor)
	{
		$nombrellave=str_replace(" ","_",strtolower($valor['nombretipodetalleadmision']));
		$variable=$admisiones->obtener_datos_pruebas_estudiantes($valor['codigotipodetalleadmision'],$valorestudiantes['codigoestudiante']);
		$array_datos[$contador][$nombrellave]=$variable['resultadodetalleestudianteadmision'];
		$nombrellave_estado="estado_prueba_".str_replace(" ","_",strtolower($valor['nombretipodetalleadmision']));
		$array_datos[$contador][$nombrellave_estado]=$variable['nombreestadoestudianteadmision'];

	}
	$sumatoria=0;
	$array_datos[$contador]['Acumulado']=round($admisiones->obtener_acumulado_pruebas_estudiantes($valorestudiantes['codigoestudiante']));
	$contador++;
}
$ordenamiento=new matriz($array_datos);
$ordenamiento->leer_llaves();
$array_ordenado=$ordenamiento->ordenamiento($_GET['ordenamiento'],$_GET['orden']);
//$array_ordenado=$ordenamiento->ordenamiento("nombre","desc");
//listar($carreras);
//listar($estudiantes);
//listar($datos_estudiantes);
//listar($icfes_estudiantes);
//listar($pruebas);
?>
<form name="form1" method="GET" action="">

<?php 
if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
{

	$ordenamiento->agregarcolumna_filtro_automatica($_SESSION['get']);
	$array_filtrado=$ordenamiento->filtrar($array_ordenado);
	listar($array_filtrado,"Admisiones Periodo ".$_SESSION['codigoperiodo']."","admisiones.php");
}
else
{
	listar($array_ordenado,"Admisiones Periodo ".$_SESSION['codigoperiodo']."","admisiones.php");
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
	echo '<script language="javascript">window.location.reload("admisiones.php")</script>';
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