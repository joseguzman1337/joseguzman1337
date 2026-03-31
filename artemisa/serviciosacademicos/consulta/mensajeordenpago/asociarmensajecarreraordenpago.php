<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../Connections/salaado.php');
/*echo $_REQUEST['codigocarrera'];
echo "  ".$_REQUEST['mensajecarreraordenpago'];
echo " ".$_REQUEST['check'];
*/
$query_permisos = "select idmensajecarreraordenpago, codigocarrera, observacionmensajecarreraordenpago FROM mensajecarreraordenpago
where codigocarrera = '".$_REQUEST['codigocarrera']."'";
$permisos = $db->Execute($query_permisos);
$totalRows_permisos = $permisos->RecordCount();
$row_permisos = $permisos->FetchRow();


    if ($_REQUEST['check'] == 'true' && $row_permisos['codigocarrera']==''){
        echo "es para insertar";
        $query_guardar = "INSERT INTO mensajecarreraordenpago (idmensajecarreraordenpago, codigocarrera, observacionmensajecarreraordenpago, codigoestado) values (0, '{$_REQUEST['codigocarrera']}', '{$_REQUEST['mensajecarreraordenpago']}', 100)";
        $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
    }
    elseif ($_REQUEST['check'] == 'true' && $row_permisos['codigocarrera']!=''){
        echo "es para actualizar";
        $query_actualizar = "UPDATE mensajecarreraordenpago SET codigoestado = 100, observacionmensajecarreraordenpago = '".$_REQUEST['mensajecarreraordenpago']."'
        where idmensajecarreraordenpago = '".$row_permisos['idmensajecarreraordenpago']."'";
        $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
    }
    elseif ($_REQUEST['check'] == 'false' ){
        echo "es falso y se cambia el estado";
        $query_actualizar = "UPDATE mensajecarreraordenpago SET codigoestado = 200
        where idmensajecarreraordenpago = '".$row_permisos['idmensajecarreraordenpago']."'";
        $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
    }

?>