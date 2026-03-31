<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>
<script>
	function VentanaOpen(){
			getemail=dhtmlmodal.open('newsletterbox', 'ajax', 'VentanaPrueba.php?actionID=Ventana&id_area=1', 'Indicadores Del Area ', 'width=900px, height=600px, left=300,right=0, resize=0,top=100%'); return false;
		}
</script>
<?PHP
switch($_REQUEST['actionID']){
		case 'Ventana':{
				echo 'acaa';
			}break;
	}
?>
<a onClick="VentanaOpen()">Open Ventana</a>