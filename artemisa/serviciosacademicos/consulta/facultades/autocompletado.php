<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
header('Content-Type: text/html; charset=UTF-8');
$rutaado='../../funciones/adodb/';
require_once('../../Connections/salaado-pear.php');
$usuario=$_SESSION['MM_Username'];

if(isset($_GET['leeMenus']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$query="
	
	select
	mu.idmenuopcion as menuopcion_ID, mu.nombremenuopcion, mu.linkmenuopcion,mu.framedestinomenuopcion as linkTarget
	from 
	usuario u
	inner join permisousuariomenuopcion pumu on u.idusuario=pumu.idusuario
	inner join permisomenuopcion pmu on pumu.idpermisomenuopcion=pmu.idpermisomenuopcion
	inner join detallepermisomenuopcion dpmu on pmu.idpermisomenuopcion=dpmu.idpermisomenuopcion
	inner join tipousuario tu on u.codigotipousuario=tu.codigotipousuario
	inner join menuopcion mu on dpmu.idmenuopcion=mu.idmenuopcion
	and now() between u.fechainiciousuario and u.fechavencimientousuario
	and pmu.codigoestado=100
	and dpmu.codigoestado=100
	and mu.codigoestadomenuopcion='01'
	and u.usuario='$usuario'
	and nombremenuopcion like '".$letters."%'";
	$res=$sala->query($query);
	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	while($inf = $res->fetchRow()){
		echo $inf["menuopcion_ID"]."###".$inf["nombremenuopcion"]."|";
	}	
}
?>