<?php  
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
require("../../../../sala/entidad/LogGrupo.php");
require("../../../../sala/entidadDAO/LogGrupoDAO.php");


mysql_select_db($database_sala, $sala);


session_start();


require_once('seguridadmateriasgrupos.php');


$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

$Usario_id = mysql_query($SQL_User, $sala) or die("$SQL_User");
$Usario_idD = mysql_fetch_assoc($Usario_id);

$userid=$Usario_idD['id'];

$Padre = $_REQUEST['Padre'];

if($Padre){
    $texto = '¿Desea eliminar el grupo...? \n Tenga encuenta que el Eliminar el Grupo Eliminara \n Solicitudes de Espacios Fisicos y \n La Asignacion de Salones...';
}else{
    $texto = '¿Desea eliminar el grupo...? ';
    
}

?>


<html>


<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<title>Eliminar grupo</title>

<?PHP 

$alert='<script  type="text/javascript">



 var entrar = confirm("'.$texto.'")

if ( !entrar )


{ 


	window.close();


}

</script>';

echo $alert;

?>
<!--
<script  type="text/javascript">


var entrar = confirm("¿Desea eliminar el grupo...? \n Tenga encuenta que el Eliminar el Grupo Eliminara \n Solicitudes de Espacios Fisicos y \n La Asignacion de Salones...")


if ( !entrar )


{ 


	window.close();


}


</script>-->


</head>


<?php


$codigocarrera = $_SESSION['codigofacultad'];


$codigomateria = $_GET['codigomateria1'];


$carrera = $_GET['carrera1'];

$Padre = $_REQUEST['Padre'];


$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera&Padre$Padre";


if(isset($_GET['grupo1']))


{


	$grupo=$_GET['grupo1'];


	$idgrupo=$_GET['idgrupo1'];


}


if(isset($_POST['grupo1']))


{


	$grupo=$_POST['grupo1'];


	$idgrupo=$_POST['idgrupo1'];


}


//$_SESSION['numerodegrupo']--;


include_once('../../../EspacioFisico/Interfas/FuncionesSolicitudEspacios_Class.php');   $C_FuncionesSolicitudEspacios = new FuncionesSolicitudEspacios();


$query_updeliminargrupo = "UPDATE grupo 


SET codigoestadogrupo = '20'


WHERE idgrupo = '$idgrupo'";


//echo "<br>UPDATE GRUPO:".$query_updeliminargrupo;


//exit();


$updeliminargrupo = mysql_query($query_updeliminargrupo, $sala) or die(mysql_error());

#Instancia de objecto de LOgGrupo para insercion del log
$logGroupObject = new LogGrupo($idgrupo);
$logGroupDAO = new \Sala\entidadDAO\LogGrupoDAO($logGroupObject);
$logGroupDAO->save();

//Eliminar Grupo


if($Padre){
    $C_FuncionesSolicitudEspacios->Eliminar($userid,$Padre,'../../../EspacioFisico/');
}

echo "<script language='javascript'>


			window.opener.recargar('".$dirini."');


			window.opener.focus();


			window.close();


	  </script>";


?>


</body>


</html>