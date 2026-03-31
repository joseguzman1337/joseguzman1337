<?php
session_start();
//error_reporting(0);
//print_r($_SESSION);
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
require_once('../../../Connections/sap.php');
require_once('funciones/validaciones.php');
require_once('funciones/funcion-barra.php');
require_once('funciones/motor.php');
$contador=0;
if(isset($_GET['facultad']))
{
	$query_egresados="SELECT e.codigoestudiante,e.idestudiantegeneral,e.codigocarrera,e.codigosituacioncarreraestudiante,concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.codigogenero, c.nombrecarrera, eg.numerodocumento,sce.nombresituacioncarreraestudiante
	FROM estudiante e, estudiantegeneral eg, carrera c,situacioncarreraestudiante sce 
	WHERE
	e.codigocarrera=c.codigocarrera 
	AND e.codigosituacioncarreraestudiante=104 
	AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante 
	AND e.idestudiantegeneral = eg.idestudiantegeneral 
	AND e.codigocarrera='".$_GET['facultad']."' order by nombre
	";
}
else
{
	$query_egresados="SELECT e.codigoestudiante,e.idestudiantegeneral,e.codigocarrera,e.codigosituacioncarreraestudiante,concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.codigogenero, c.nombrecarrera, eg.numerodocumento,sce.nombresituacioncarreraestudiante
	FROM estudiante e, estudiantegeneral eg, carrera c,situacioncarreraestudiante sce 
	WHERE
	e.codigocarrera=c.codigocarrera 
	AND e.codigosituacioncarreraestudiante=104 
	AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante 
	AND e.idestudiantegeneral = eg.idestudiantegeneral 
	AND e.codigocarrera='".$_SESSION['codigofacultad']."' order by nombre
	";
}
$egresados=mysql_query($query_egresados,$sala) or die(mysql_error());
$row_egresados=mysql_fetch_assoc($egresados);
$row_egresados_tabla=mysql_fetch_assoc($egresados);
$num_rows_egresados=mysql_num_rows($egresados);
$cant_regs_egresados=$num_rows_egresados;
?>
<?php 
echo "<h2>Este proceso puede demorar un tiempo, porfavor espere...</h2>";
echo "<div id='progress' style='position:relative;padding:0px;width:2048px;height:60px;left:25px;'>";
do
{
	echo '<img src="barra.JPG">';
	$array_estado_validaciones[$contador]['codigoestudiante']=$row_egresados['codigoestudiante'];
	$array_estado_validaciones[$contador]['documento']=$row_egresados['numerodocumento'];
	//$array_estado_validaciones[$contador]['codigoestudiante']=$row_egresados['codigoestudiante'];
	$array_estado_validaciones[$contador]['nombre']=$row_egresados['nombre'];
	//$array_estado_validaciones[$contador]['situacionestudiante']=$row_egresados['nombresituacioncarreraestudiante'];
	$array_estado_validaciones[$contador]['pendiente_documentos']=validacion_documentos($row_egresados['codigocarrera'],$row_egresados['codigogenero'],$row_egresados['codigoestudiante'],$sala,$documentacionpendiente);
	$array_estado_validaciones[$contador]['pendiente_pazysalvo']=validacion_pazysalvo($row_egresados['codigoestudiante'],$sala);
	$array_estado_validaciones[$contador]['pendiente_materias']=generarcargaestudiante($row_egresados['codigoestudiante'],$sala,$materiaspendientes);
	$array_estado_validaciones[$contador]['pendiente_saldo_sap']=validacion_saldo_sap($row_egresados['codigoestudiante'],$database_sala,$sala,$rfc,$login,$rfchandle,$deudassap);
	$array_estado_validaciones[$contador]['pendiente_derechos_grado']=validacion_pago_derechos_grado($row_egresados['codigoestudiante'],$sala);
	if(
	$array_estado_validaciones[$contador]['pendiente_documentos']=='no'
	and
	$array_estado_validaciones[$contador]['pendiente_pazysalvo']=='no'
	and
	$array_estado_validaciones[$contador]['pendiente_materias']=='no'
	and
	$array_estado_validaciones[$contador]['pendiente_saldo_sap']=='no'
	and
	$array_estado_validaciones[$contador]['pendiente_derechos_grado']=='no'
	)
	{
		$array_estado_validaciones[$contador]['elegible_grado']='si';
	}
	else
	{
		$array_estado_validaciones[$contador]['elegible_grado']='no';
	}

	//unset($deudassap);
	barra();
	$contador++;
	//echo "documentos ",$pendiente_documentos," ",$row_egresados['numerodocumento']," ","sap ",$pendiente_sap,"<br>";
}
while ($row_egresados=mysql_fetch_assoc($egresados));
echo "</div>";
?>
<?php
$_SESSION['validaciones']=$array_estado_validaciones;
$_SESSION['deudassap']=$deudassap;
$_SESSION['documentacionpendiente']=$documentacionpendiente;
$_SESSION['materiaspendientes']=$materiaspendientes;
if(isset($_GET['facultad']))
{
	echo '<script language="javascript">window.location.reload("tabla_elegibles.php?facultad");</script>';
}
else
{
	echo '<script language="javascript">window.location.reload("tabla_elegibles.php?secgnral");</script>';
}
?>
