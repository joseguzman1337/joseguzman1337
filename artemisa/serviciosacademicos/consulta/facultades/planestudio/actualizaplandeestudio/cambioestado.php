<?php
session_start();
	if(!isset ($_SESSION['MM_Username'])){
		echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
		exit();
    }
require_once('../../../../Connections/sala2.php'); 


$idplanestudio2= $_REQUEST['planestudio2']; 
$idplanestudio= $_REQUEST['planestudio']; 
if(isset($idplanestudio2)){
	$update="UPDATE planestudio SET codigoestadoplanestudio='101' WHERE  idplanestudio='".$idplanestudio2."'";
	$update31=mysql_db_query($database_sala,$update);
	echo "<script language='javascript'>
		alert('Estado Cambiado Correctamente');
		window.location.href='../plandeestudioinicial.php';
		</script>";
}else{
	$update="UPDATE planestudio SET codigoestadoplanestudio='100' WHERE  idplanestudio='".$idplanestudio."'";
	$update31=mysql_db_query($database_sala,$update);
	echo "<script language='javascript'>
		alert('Estado Cambiado Correctamente');
		window.location.href='../plandeestudioinicial.php';
		</script>";
}


?>