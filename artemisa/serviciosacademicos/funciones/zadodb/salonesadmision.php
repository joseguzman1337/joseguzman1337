<?php
session_start();
$codigocarrera = $_SESSION['codigofacultad'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];
$codigocarrera = 10;
$codigoperiodo = 20062;

require_once('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
include($rutazado.'zadodb-pager.inc.php');
//include_once($rutaado.'adodb-pager.inc.php');
require_once('../../../Connections/salaado.php'); 
require_once("funcionesadmision.php");

?>
<html>
<head>
<title>Salones Admisión</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<form action="" name="f1" method="post">
<p>SITIOS DE ADMISION</p>
<?php
print_r($_POST);
//$db->debug = true;
//$rows_per_page=10;
if($_REQUEST['row_page'] != "")
{
	$rows_per_page = $_REQUEST['row_page'];
}
$sqlini = "SELECT s.idsitioadmision, s.nombresitioadmision, s.direccionsitioadmision, s.telefonositioadmision, s.nombreresponsablesitioadmision, s.codigoestado, s.capacidadsitioadmision, s.codigocarrera, s.idsubperiodo
from sitioadmision s, estado e, carreraperiodo cp, subperiodo su
where e.codigoestado = s.codigoestado
and s.codigocarrera = cp.codigocarrera
and s.idsubperiodo = su.idsubperiodo
and cp.idcarreraperiodo = su.idcarreraperiodo
and s.codigoestado like '1%'
and cp.codigoperiodo = '$codigoperiodo'
and cp.codigocarrera = '$codigocarrera'";

$pager = new ADODB_Pager($db,$sqlini.$sqlfin,false,false,true);

// El sqlini y sqlfin sirve para la realizacion del filtro, si no lleva filtro no hay necesidad del sqlfin
//$pager->Filter($sqlini,$sqlfin,$array_campos,$linkadd);
// Codigo necesario para editar
if(isset($_REQUEST['nasaveedit']))
{
	$id = $_REQUEST['naid'];
	foreach($_REQUEST as $key => $value)
	{
		if(ereg("naupdate",$key))
		{
			$fields_update[ereg_replace("naupdate","",$key)] = $value;
		}
	}
	//ini_set("display_errors", "0");
	$ins_upd = $db->AutoExecute("sitioadmision", $fields_update, 'UPDATE', "idsitioadmision = $id"); 
		
	//if ($ins_upd) rs2html($ins_upd);
	echo "<h1>".$db->ErrorNo()."<br> sdas</h1>";
	//if($ins_upd)
	unset($_REQUEST['naedit']);
}
if(isset($_REQUEST['nanew']))
{
	unset($_REQUEST['naedit']);
}

if(isset($_REQUEST['nasavenew']))
{
	foreach($_REQUEST as $key => $value)
	{
		if(ereg("naupdate",$key))
		{
			$fields_update[ereg_replace("naupdate","",$key)] = $value;
		}
	}
	$ins_upd = $db->AutoExecute("sitioadmision", $fields_update, 'INSERT'); 
	unset($_REQUEST['naedit']);
}

// Hace que no acepte registros menores a cero
if($rows_per_page < 1)
{
	$rs_sqlini = $db->Execute($sqlini);
	$rows_per_page = $rs_sqlini->RecordCount();
}
// Deja listo para editar
$pager->edit = true;
// Deja listo para modificar
$pager->delete = true;

// Deja lsto para modificar el número de registros por consulta
$pager->numberRegisters = false;

// Si se quiere hacer menus, toca pasarle el query para que lo haga
$queryheaderarray[5] = "select nombreestado, codigoestado 
from estado where codigoestado = beg end";
$queryheaderarray[7] = "select nombrecarrera, codigocarrera 
from carrera where fechavencimientocarrera > now() and codigocarrera = '$codigocarrera' begand codigocarrera = end";
$queryheaderarray[8] = "select s.nombresubperiodo, s.idsubperiodo 
from subperiodo s, carreraperiodo cp where cp.idcarreraperiodo = s.idcarreraperiodo and cp.codigoperiodo = '$codigoperiodo' and cp.codigocarrera = '$codigocarrera' begand s.idsubperiodo = end";
$pager->queryheaderarray = $queryheaderarray;

// Si se quieren hacer links de detalle, que apunten a otra página
$linkrowarray[1] = "horariositioadmision.php?idsitioadmision=";
$pager->linkrowarray = $linkrowarray;

// Si se desea quitar un capo de la columna solamente con dejar en blanco el nombre de la columna funciona
// ej: array('','','Dirección','Teléfono','Responsable','Estado','','Carrera','Subperiodo')
$pager->Render($rows_per_page,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"', array('','Nombre','Dirección','Teléfono','Responsable','Estado','Capacidad','Carrera','Subperiodo')); 
//print_r($pager->queryheaderarray);
?>
<br>
<input type="submit" name="nanew" value="Nuevo"><input type="button" value="Restablecer" onClick="window.location.href='salonesadmision.php'">
</form>
</body>
</html>
