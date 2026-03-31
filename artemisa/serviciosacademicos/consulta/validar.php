<?php 

session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../Connections/sala2.php');

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	switch ($theType) {
		case "text":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "long":
		case "int":
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			break;
		case "double":
			$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
			break;
		case "date":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
			
		case "defined":
			$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			break;
	}
	return $theValue;
}
$colname2_Recordset1 = "1";

if (isset($_POST['numerodocumento'])) {
	$colname2_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['numerodocumento'] : addslashes($_POST['numerodocumento']);
}

mysql_select_db($database_sala, $sala);
$query_Recordset1 = sprintf("SELECT * FROM estudiantegeneral WHERE numerodocumento = '%s'", $colname2_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname2_docente = "0";
if (isset($_POST['numerodocumento'])) {
	$colname2_docente = (get_magic_quotes_gpc()) ? $_POST['numerodocumento'] : addslashes($_POST['numerodocumento']);
}
$colname_docente = "1";
if (isset($_POST['codigousuario'])) {
	$colname_docente = (get_magic_quotes_gpc()) ? $_POST['codigousuario'] : addslashes($_POST['codigousuario']);
}
mysql_select_db($database_sala, $sala);
 $query_docente = "SELECT * FROM docente WHERE codigodocente = '".$colname_docente."' or numerodocumento = '".$colname2_docente."'";

$docente = mysql_query($query_docente, $sala) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);
//exit();
//LINEA TEMPORAL VOTACIONES//
if($_POST['estado']=="deshabilitado"){
$totalRows_docente=1;
}

//echo $query_docente;
?>
<?php  
if ($_POST['Submit2']){
	$correct=0;
	$fechahoy=date("Y-m-d H:i:s");
	if(!$_POST['rol'])
	{
		$tiporol=1;
	}
	else{
		$correct++;
	}

	if (!$_POST['tipodocumento']){
	$tipodoc=1;
	}
	else {
		$correct=$correct+1;
	}
	if (!$_POST['numerodocumento']){
		$numdoc=1;
	}
	else {
		$correct=$correct+1;
	}
	if (!$_POST['apellidos']){
		$apelli=1;
	}
	else {
		$correct=$correct+1;
	}
	if (!$_POST['nombres']){
		$nomb=1;
	}
	else {
		$correct=$correct+1;
	}
	if (!$_POST['codigousuario'] and $_POST['rol'] == 2){
		$cod=1;
	}
	else {
		$correct=$correct+1;
	}
	if (!$_POST['semestre'] and $_POST['rol'] == 1){
		$sem=1;
	}
	else {
		$correct=$correct+1;
	}
   if ($_POST['rol']==1){
		if ($correct==7){
			if (!$totalRows_Recordset1){
				$no=1;
			}
			else{
				$GLOBALS['codigo'] = $_POST['numerodocumento'];
				session_register("codigo");
				
		
				$insertSQL = sprintf("INSERT INTO usuario (usuario, numerodocumento, tipodocumento, apellidos, nombres, codigousuario,semestre, codigorol, fechainiciousuario, fechavencimientousuario, fecharegistrousuario, codigotipousuario, idusuariopadre, codigoestadousuario,ipaccesousuario) VALUES (%s, %s, %s, %s, %s, %s, %s,%s,%s,%s,%s,%s,%s,%s)",
				GetSQLValueString(trim($_SESSION['MM_Username']), "text"),
				GetSQLValueString($_POST['numerodocumento'], "text"),
				GetSQLValueString($_POST['tipodocumento'], "int"),
				GetSQLValueString($_POST['apellidos'], "text"),
				GetSQLValueString($_POST['nombres'], "text"),
				GetSQLValueString($_POST['numerodocumento'], "text"),
				GetSQLValueString($_POST['semestre'], "text"),
				GetSQLValueString("1","int"),
				GetSQLValueString($fechahoy,"date"),
				GetSQLValueString("2999-12-31","date"),
				GetSQLValueString($fechahoy,"date"),
				GetSQLValueString("600","int"),
				GetSQLValueString("0","int"),
				"100",
				"0");
				mysql_select_db($database_sala, $sala);
				$Result1 = mysql_query($insertSQL, $sala) or die("$insertSQL");
				$ok=1;
			} //fin else si existe el estudiante
		}//fin si todos estan correctos
	}//fin rol 1
	if ($_POST['rol']==2){
		if ($correct==7){
			//echo $correct;
			//echo $row_Recordset1;
			//echo $totalRows_Recordset1;
			if (!$totalRows_docente){
				//echo "usted no esta registrado como estudiante activo en la universidad";
				$no=2;
			}
			else{
				//echo $row_Recordset1['nombresestudiante'] ." ". $row_Recordset1['apellidosestudiante'];
				$GLOBALS['codigodocente'] = $_POST['numerodocumento'];

				if($_POST['estado']=="deshabilitado"){
								
				echo $insertSQL="update usuario set
						 numerodocumento='".$_POST['numerodocumento']."', 
						 tipodocumento=".$_POST['tipodocumento'].",
						 apellidos='".$_POST['apellidos']."',
						 nombres='".$_POST['nombres']."', 
						 codigousuario='".$_POST['codigousuario']."',
						 semestre='1',
						 codigorol='2',
						 fechainiciousuario='".$fechahoy."',
						 fechavencimientousuario='2999-12-31',
						 fecharegistrousuario='".$fechahoy."',
						 codigotipousuario='500',
						 idusuariopadre=0,
						 ipaccesousuario='0',
						 codigoestadousuario='100'
						where usuario='".$_SESSION['MM_Username']."'";
										mysql_select_db($database_sala, $sala);			    
				$Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
				$ok=2;
				
//				mysql_select_db($database_sala, $sala);			    

				$query_usuario = "SELECT idusuario FROM usuario WHERE usuario='".$_SESSION['MM_Username']."'";
				$resultusuario = mysql_query($query_usuario, $sala) or die($query_usuario.mysql_error());
				$row_usuario = mysql_fetch_assoc($resultusuario);
				
				$insertusuario = "insert into permisousuariomenuopcion (idpermisomenuopcion,idusuario,codigoestado) values (251,".$row_usuario['idusuario'].",'100')";
				$resultdetalle = mysql_query($insertusuario, $sala) or die(mysql_error());


				}
				else{
					session_register("codigodocente");
					$insertSQL = sprintf("INSERT INTO usuario (usuario, numerodocumento, tipodocumento, apellidos, nombres, codigousuario,semestre, codigorol, fechainiciousuario, fechavencimientousuario, fecharegistrousuario, codigotipousuario, idusuariopadre, codigoestadousuario,ipaccesousuario) VALUES (%s, %s, %s, %s, %s, %s, %s,%s,%s,%s,%s,%s,%s,%s,%s)",
					GetSQLValueString(trim($_SESSION['MM_Username']), "text"),
					GetSQLValueString($_POST['numerodocumento'], "text"),
					GetSQLValueString($_POST['tipodocumento'], "int"),
					GetSQLValueString($_POST['apellidos'], "text"),
					GetSQLValueString($_POST['nombres'], "text"),
					GetSQLValueString($_POST['codigousuario'], "text"),
					GetSQLValueString("1","int"),
					GetSQLValueString("2","int"),
					GetSQLValueString($fechahoy,"date"),
					GetSQLValueString("2999-12-31","date"),
					GetSQLValueString($fechahoy,"date"),
					GetSQLValueString("500","int"),
					GetSQLValueString("0","int"),
					"100",
					"0"
					);
				mysql_select_db($database_sala, $sala);			    
				$Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
				$ok=2;
				
//				mysql_select_db($database_sala, $sala);			    

				$query_usuario = "SELECT max(idusuario) idusuario FROM usuario WHERE numerodocumento = ".$_POST['numerodocumento'];
				$resultusuario = mysql_query($query_usuario, $sala) or die($query_usuario.mysql_error());
				$row_usuario = mysql_fetch_assoc($resultusuario);
				
				$insertusuario = "insert into permisousuariomenuopcion (idpermisomenuopcion,idusuario,codigoestado) values (251,".$row_usuario['idusuario'].",'100')";
				$resultdetalle = mysql_query($insertusuario, $sala) or die(mysql_error());

				}
						
			} //fin else si existe el docente
		}//fin si todos estan correctos
	}//fin rol 2
}// fin if submit
?>
<?php
mysql_free_result($Recordset1);
mysql_free_result($docente);
?>

