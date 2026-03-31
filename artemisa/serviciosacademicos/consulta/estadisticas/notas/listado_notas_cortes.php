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
//require_once("funciones/obtener_datos.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Listado promedio cortes de notas</title>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
</head>
<body>
<?php
$codigoperiodo=$_SESSION['codigoperiodosesion'];
$codigocarrera=$_SESSION['codigofacultad'];
if(isset($_REQUEST['semestre']))
{
	$semestre=$_REQUEST['semestre'];
}

echo "codigoperiodo $codigoperiodo codigocarrera $codigocarrera semestre ".$semestre."<br>";

if(empty($codigoperiodo) or empty($codigocarrera))
{
	echo "<h1>No se puede continuar, no existen variables de sesion carrera, o periodo</h1>";
}
else
{
	if(!isset($_SESSION['estadisticas']))
	{
		$_SESSION['estadisticas'] = new estadisticasNotas($sala,$codigoperiodo,false);
		if(!empty($semestre))
		{
			$_SESSION['estadisticas']->leeEstudiantesSemestre($codigoperiodo,$codigocarrera,$semestre);
		}
		else
		{
			//no usado, porque consume demasiados recursos
			//$_SESSION['estadisticas']->leerEstudiantesCarrera($codigocarrera,$codigoperiodo);
		}
		$_SESSION['estadisticas']->LeerMateriasArrayEstudiantes();
		$_SESSION['estadisticas']->leeCortesyDatosMaterias();
		$_SESSION['estadisticas']->leerHistoricoArrayEstudiantes();
		$_SESSION['array_general']=$_SESSION['estadisticas']->creaArrayGeneral();
		$motor=new matriz($_SESSION['array_general'],"Notas","listado_notas_cortes.php?semestre=$semestre","si","si","menu.php","listado_notas_cortes.php?semestre=$semestre&link_origen=menu.php",true,"si","../../../");
		$motor->archivo_origen_con_get=true;
		if(isset($_GET['redimensionable']))
		{
			$motor->asignarCeldasRedimensionables("100px");
		}
		$motor->definir_llave_globo_general("nombre");
		$motor->jsVarios();
		$motor->agregarllave_emergente("nombre","listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php","detallexestudiante","codigoestudiante","",800,600,50,50,"yes","yes","no","no","no","","","Clic aquí para ver informe x estudiante","");
		$motor->agregarllave_emergente("cant_perdida_calidad_est","listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php","pruebaacademica","codigoestudiante","codigomateria=".$valor['codigomateria']."&semestre=$semestre",800,300,200,150,"yes","yes","no","no","no","","","","");
		$motor->agregar_llaves_totales("cant_perdida_calidad_est","listado_notas_cortes.php","detalle_listado_notas_cortes.php","totalpruebaacademica","codigomateria=".$valor['codigomateria']."&semestre=$semestre","","","Clic aquí para ver el informe de situacion estudiante",false);
		foreach ($_SESSION['estadisticas']->array_codigomaterias_leidas as $llave => $valor)
		{
			$nombremateria=ereg_replace('\.',"",$valor['nombremateria']);
			$nombremateria=ereg_replace(',',"",$nombremateria);
			$encabezado_array=$valor['codigomateria']."-".ereg_replace(" ","_",$nombremateria);
			$motor->agregarllave_emergente($encabezado_array,"listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php","detalle","codigoestudiante","codigomateria=".$valor['codigomateria']."&semestre=$semestre",$width=800,$height=300,$top=200,$left=150,$scrollbars="yes",$resizable="yes",$toolbar="no",$status="no",$menu="no",$variable="",$aliasvariable="",$textoglobo="",$javascript="");
			$motor->agregar_llaves_totales($encabezado_array,"listado_notas_cortes.php","detalle_listado_notas_cortes.php","detallexmateria","codigomateria=".$valor['codigomateria']."&semestre=$semestre","","","Clic aquí para ver el informe x materia",false);
		}
		$motor->mostrar();

	}
	elseif ($_SESSION['estadisticas']->semestre<>$semestre)
	{
		unset($_SESSION['estadisticas']);
		$_SESSION['estadisticas'] = new estadisticasNotas($sala,$codigoperiodo,false);
		if(!empty($semestre))
		{
			
			$_SESSION['estadisticas']->leeEstudiantesSemestre($codigoperiodo,$codigocarrera,$semestre);
		}
		else
		{	
			//no usado, porque consume demasiados recursos
			//$_SESSION['estadisticas']->leerEstudiantesCarrera($codigocarrera,$codigoperiodo);
		}
		$_SESSION['estadisticas']->LeerMateriasArrayEstudiantes();
		$_SESSION['estadisticas']->leeCortesyDatosMaterias();
		$_SESSION['estadisticas']->leerHistoricoArrayEstudiantes();
		$_SESSION['array_general']=$_SESSION['estadisticas']->creaArrayGeneral();
		$motor=new matriz($_SESSION['array_general'],"Notas","listado_notas_cortes.php?semestre=$semestre","si","si","menu.php","listado_notas_cortes.php?semestre=$semestre&link_origen=menu.php",true,"si","../../../");
		$motor->archivo_origen_con_get=true;
		if(isset($_GET['redimensionable']))
		{
			$motor->asignarCeldasRedimensionables("100px");
		}
		$motor->definir_llave_globo_general("nombre");
		$motor->jsVarios();
		$motor->agregarllave_emergente("nombre","listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php","detallexestudiante","codigoestudiante","",800,600,50,50,"yes","yes","no","no","no","","","Clic aquí para ver informe x estudiante","");
		$motor->agregarllave_emergente("cant_perdida_calidad_est","listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php","pruebaacademica","codigoestudiante","codigomateria=".$valor['codigomateria']."&semestre=$semestre",800,300,200,150,"yes","yes","no","no","no","","","","");
		$motor->agregar_llaves_totales("cant_perdida_calidad_est","listado_notas_cortes.php","detalle_listado_notas_cortes.php","totalpruebaacademica","codigomateria=".$valor['codigomateria']."&semestre=$semestre","","","Clic aquí para ver el informe de situacion estudiante",false);
		foreach ($_SESSION['estadisticas']->array_codigomaterias_leidas as $llave => $valor)
		{
			$nombremateria=ereg_replace('\.',"",$valor['nombremateria']);
			$nombremateria=ereg_replace(',',"",$nombremateria);
			$encabezado_array=$valor['codigomateria']."-".ereg_replace(" ","_",$nombremateria);
			$motor->agregarllave_emergente($encabezado_array,"listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php","detalle","codigoestudiante","codigomateria=".$valor['codigomateria']."&semestre=$semestre",$width=800,$height=300,$top=200,$left=150,$scrollbars="yes",$resizable="yes",$toolbar="no",$status="no",$menu="no",$variable="",$aliasvariable="",$textoglobo="",$javascript="");
			$motor->agregar_llaves_totales($encabezado_array,"listado_notas_cortes.php","detalle_listado_notas_cortes.php","detallexmateria","codigomateria=".$valor['codigomateria']."&semestre=$semestre","","","Clic aquí para ver el informe x materia",false);
		}
		$motor->mostrar();
	}
	else
	{
		$motor=new matriz($_SESSION['array_general'],"Notas","listado_notas_cortes.php?semestre=$semestre","si","si","menu.php","listado_notas_cortes.php?semestre=$semestre&link_origen=menu.php",true,"si","../../../");
		$motor->archivo_origen_con_get=true;
		if(isset($_GET['redimensionable']))
		{
			$motor->asignarCeldasRedimensionables("100px");
		}
		$motor->definir_llave_globo_general("nombre");
		$motor->jsVarios();
		$motor->agregarllave_emergente("nombre","listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php","detallexestudiante","codigoestudiante","",800,600,50,50,"yes","yes","no","no","no","","","Clic aquí para ver informe x estudiante","");
		$motor->agregarllave_emergente("cant_perdida_calidad_est","listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php","pruebaacademica","codigoestudiante","codigomateria=".$valor['codigomateria']."&semestre=$semestre",800,300,200,150,"yes","yes","no","no","no","","","","");
		$motor->agregar_llaves_totales("cant_perdida_calidad_est","listado_notas_cortes.php","detalle_listado_notas_cortes.php","totalpruebaacademica","codigomateria=".$valor['codigomateria']."&semestre=$semestre","","","Clic aquí para ver el informe de situacion estudiante",false);
		foreach ($_SESSION['estadisticas']->array_codigomaterias_leidas as $llave => $valor)
		{
			$nombremateria=ereg_replace('\.',"",$valor['nombremateria']);
			$nombremateria=ereg_replace(',',"",$nombremateria);
			$encabezado_array=$valor['codigomateria']."-".ereg_replace(" ","_",$nombremateria);
			$motor->agregarllave_emergente($encabezado_array,"listado_notas_cortes.php?semestre=$semestre","detalle_listado_notas_cortes.php","detalle","codigoestudiante","codigomateria=".$valor['codigomateria']."&semestre=$semestre",$width=800,$height=300,$top=200,$left=150,$scrollbars="yes",$resizable="yes",$toolbar="no",$status="no",$menu="no",$variable="",$aliasvariable="",$textoglobo="",$javascript="");
			$motor->agregar_llaves_totales($encabezado_array,"listado_notas_cortes.php","detalle_listado_notas_cortes.php","detallexmateria","codigomateria=".$valor['codigomateria']."&semestre=$semestre","","","Clic aquí para ver el informe x materia",false);
		}
		$motor->mostrar();
	}
}
?>

</body>
</html>
<?php
//$_SESSION['estadisticas']->DibujarTabla($_SESSION['estadisticas']->array_cortes_materias);
//echo "<h2>".count($_SESSION['estadisticas']->array_codigomaterias_leidas)."</h2>";
//$_SESSION['estadisticas']->DibujarTabla($_SESSION['estadisticas']->array_codigomaterias_leidas);
//$_SESSION['estadisticas']->DibujarTabla($_SESSION['estadisticas']->array_notas_estudiantes);
//$_SESSION['estadisticas']->DibujarTabla($_SESSION['estadisticas']->array_definitivas_estudiantes);
$_SESSION['estadisticas']->cuentaMateriasPerdidas();
?>
