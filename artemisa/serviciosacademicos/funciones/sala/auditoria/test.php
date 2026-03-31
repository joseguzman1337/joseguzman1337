<?php
require_once('../../../Connections/sala2.php');
$rutaado = "../../adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');

require_once('auditoria.php');

session_start();

if(isset($_GET['debug']))
{
    $db->debug = true;
}

$auditoria = new auditoria();
print_r($auditoria);
//print_r($auditoria);
?>