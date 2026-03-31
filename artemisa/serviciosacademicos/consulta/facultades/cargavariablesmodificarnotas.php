<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../Connections/sala2.php');
session_start();
$materiagrupo=explode("-",$_POST['materiagrupo']); 
$_SESSION['cortes']= $_POST['corte'];
if ($_POST['corte'] == "")
				{
				   echo '<script language="JavaScript">alert("Debe Digitar el número de corte")</script>';			
				   echo '<script language="JavaScript">history.go(-1)</script>';		
				   exit();
				}
$_SESSION['grupos'] = $materiagrupo[1];
$_SESSION['materias'] =  $materiagrupo[0];
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=notassala.php'>";
?>