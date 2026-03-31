<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
      
require_once('../../../Connections/sala2.php');
//session_start();
  
   if ($_GET['colegio'] <> "")
     {	   
	   $_SESSION['codigoestudiantecolegionuevo'] = $_GET['colegio'];
		$direccion = "crearnuevoestudiante.php";
		echo "<script language='javascript'>
			  window.opener.recargar('".$direccion."');
			  window.opener.focus();
			  window.close();
			  </script>";
			  exit();
      }

?>