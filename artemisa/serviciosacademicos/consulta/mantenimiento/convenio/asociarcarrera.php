<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
/*echo $_REQUEST['codigocarrera'];
echo "  ".$_REQUEST['idconvenio'];
echo " ".$_REQUEST['check'];*/

$query_convenios = "select idconveniocarrera, idconvenio, codigocarrera FROM conveniocarrera 
where idconvenio =  '".$_REQUEST['idconvenio']."'
and codigocarrera = '".$_REQUEST['codigocarrera']."'";
$convenios = $db->Execute($query_convenios);
$totalRows_convenios = $convenios->RecordCount();
$row_convenios = $convenios->FetchRow();


    if ($_REQUEST['check'] == 'true' && $row_convenios['codigocarrera']==''){
        echo "es para insertar";
        $query_guardar = "INSERT INTO conveniocarrera (idconveniocarrera, codigocarrera, codigoestado, idconvenio) values (0, '{$_REQUEST['codigocarrera']}', 100, '{$_REQUEST['idconvenio']}')";
        $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
    }
    elseif ($_REQUEST['check'] == 'true' && $row_convenios['codigocarrera']!=''){
        echo "es para actualizar";
        $query_actualizar = "UPDATE conveniocarrera SET codigoestado = 100
        where idconveniocarrera = '".$row_convenios['idconveniocarrera']."'";
        $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
    }
    elseif ($_REQUEST['check'] == 'false' ){
        echo "es falso y se cambia el estado";
        $query_actualizar = "UPDATE conveniocarrera SET codigoestado = 200
        where idconveniocarrera = '".$row_convenios['idconveniocarrera']."'";
        $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
    }

?>