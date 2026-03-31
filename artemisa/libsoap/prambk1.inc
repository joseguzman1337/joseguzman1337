<?php
session_start();
require_once('../serviciosacademicos/Connections/sala2.php');
mysql_select_db($database_sala, $sala);

$EntityCode = '10017';
//$SrvCode = '1000201';
$SrvCode = '10001';
//$SrvCode = '1000201';

//$UserType = $_SESSION['usertype'];
//$UserType = $row_dataestudiante['codigotipocliente'];
if(isset($_REQUEST['PaymentSystem']))
{
	if(!isset($_SESSION['tipodepagosesion']))
	{
		$GLOBALS['tipodepagosesion'];
		session_register("tipodepagosesion");
		$_SESSION['tipodepagosesion'] = $_REQUEST['PaymentSystem'];
	}
}
else
{
	if(!isset($_SESSION['tipodepagosesion']))
	{
		$GLOBALS['tipodepagosesion'];
		session_register("tipodepagosesion");
		$_SESSION['tipodepagosesion'] = 0;
	}
}
//$PaymentSystem = '0'; //PSE
$_SESSION['tipodepagosesion'] = $_REQUEST['PaymentSystem'];
$PaymentSystem = $_SESSION['tipodepagosesion'];
//$URLResponse = 'http://172.16.7.109/desarrollo1/libsoap/class.getRequest.php';
//$URLResponse = 'http://172.16.7.109/libsoap/class.getRequest.php';
//$URLResponse = 'https://artemisa.unbosque.edu.co/libsoap/class.getRequest.php';
$URLResponse = 'http://artemisa.unbosque.edu.co/libsoap/class.getRequest.php';
//echo "<pre>Lo que viene por el REQUEST<br>"; print_r($_REQUEST); echo "</pre>";
//exit();
?>

