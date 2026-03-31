<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
include($rutazado.'zadodb-pager.inc.php');

session_start();
if(isset($_SESSION['debug_sesion']))
{
    $db->debug = true;
}
$db->debug = true;
$codigoestudiante = $_REQUEST['codigoestudiante'];
$cambiosituacion = 100;

$query_historicosituacionhoy = "select *
from historicosituacionestudiante
where codigoestudiante = '".$codigoestudiante."'
and fechainiciohistoricosituacionestudiante LIKE '".date("Y-m-d")."%'
order by 1 desc";
$historicosituacionhoy = $db->Execute($query_historicosituacionhoy);
$totalRows_historicosituacionhoy = $historicosituacionhoy->RecordCount();
$row_historicosituacionhoy = $historicosituacionhoy->FetchRow();
$periodoactual = 20091;
$usuario = 'adminodontologia';
if ($row_historicosituacionhoy == "")
{
    if($row_historicosituacion['codigosituacioncarreraestudiante'] <> $cambiosituacion)
    {
        $sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";
        $sql.= "VALUES('0','".$codigoestudiante."','$cambiosituacion','".$periodoactual."',now(),now(),'2999-12-31','".$usuario."')";
        //echo $sql,"<br>";
        $result = $db->Execute($sql);

        $query_updest1 = "UPDATE historicosituacionestudiante
        SET fechafinalhistoricosituacionestudiante = '".$fechahoy."'
        WHERE idhistoricosituacionestudiante = '".$row_historicosituacion['idhistoricosituacionestudiante']."'";
        $updest1 = $db->Execute($query_updest1);

    }

    $base1= "update estudiante set
    codigosituacioncarreraestudiante ='$cambiosituacion'
    where  codigoestudiante = '".$codigoestudiante."'";
    $sol1 = $db->Execute($base1);
}
?>