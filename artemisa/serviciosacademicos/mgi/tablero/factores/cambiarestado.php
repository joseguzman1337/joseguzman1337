<?php 
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION); 

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
include_once('../../../ReportesAuditoria/templates/mainjson.php');
if(isset($_POST['activa']) && $_POST['activa']==1){

$query_activa="update plandocente set verificado=1 where id_docente='".$_POST['iddocente']."' and codigoperiodo='".$_POST['codigoperiodo']."'";
$activa=$db->Execute($query_activa);

}

elseif(isset($_POST['activa']) && $_POST['activa']==0){

$query_activa="update plandocente set verificado=0 where id_docente='".$_POST['iddocente']."' and codigoperiodo='".$_POST['codigoperiodo']."'";
$activa=$db->Execute($query_activa);

}

?>
