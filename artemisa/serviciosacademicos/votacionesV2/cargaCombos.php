<?php
require_once('../Connections/sala2.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');
include_once("includes/objetosHTML.php");
$obj = New objetosHTML;
if($_REQUEST['opc']=='dep')
	echo $obj->optionsSelect("","select iddepartamento,nombredepartamento from departamento where idpais=".$_REQUEST['id']." order by nombredepartamento");
if($_REQUEST['opc']=='ciu')
	echo $obj->optionsSelect("","select idciudad,nombreciudad from ciudad where iddepartamento=".$_REQUEST['id']." order by nombreciudad");
if($_REQUEST['opc']=='ac')
	echo $obj->optionsSelect("","select iddetallenucleobasicoareaconocimiento, nombredetallenucleobasicoareaconocimiento from detallenucleobasicoareaconocimiento l where l.idnucleobasicoareaconocimiento='".$_REQUEST['id']."' order by nombredetallenucleobasicoareaconocimiento");
if($_REQUEST['opc']=='gi')
	echo $obj->optionsSelect("","select idgrupoinvestigacion,nombregrupoinvestigacion from grupoinvestigacion where codigofacultad=".$_REQUEST['id']." order by nombregrupoinvestigacion");
if($_REQUEST['opc']=='li')
	echo $obj->optionsSelect("","select idlineainvestigacion,nombrelineainvestigacion from lineainvestigacion where codigoestado like '1%' and idgrupoinvestigacion=".$_REQUEST['id']." order by nombrelineainvestigacion");
if($_REQUEST['opc']=='empty')
	echo $obj->optionsSelect("","");
?>
