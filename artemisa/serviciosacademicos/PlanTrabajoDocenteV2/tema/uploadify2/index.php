<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- P&aacute;gina web dise�ada por LOVELESS ISMA -->
<!-- Puedes usar este archivo  HTML de manera pacialmente libre, en tu web, tu trabajo, tu casa, tu blog, para estudiar, para sorprender a tu novia, etc. -->
<!-- �Porqu� digo parcialmente? Por que est� bajo licencia GPL (General Public License, s�, esa la del b�falo o gnu o sabr� la mierda que animal sea), y puedes usarla libremente. -->
<!-- Pero eso s�, poniendo el nombre de su autor (en este caso '***LOVELESS ISMA***'). -->
<!-- As� que cualquier intento de copiar �sto sin siquiera agradecer a LOVELESS ISMA y/o poner su nombre te juro que te estar� vigilando. -->
<!-- Y el d�a que te encuentre te perseguir� con unas tijeras para jard�n y te podar� los test�culos. -->
<title>Galer&iacute;a de im&aacute;genes con PHP y JQuery, desarrollada por LOVELESSISMA.</title>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="css/uploadify.css">
<script language="javascript" type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
<script language="javascript" type="text/javascript" src="js/swfobject.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
$(function() {
	$('#inputArchivo').uploadify({
		'uploader': 'swf/uploadify.swf',
		'script': 'uploadify.php',
		'queueID': 'listaArchivos',
		'buttonText': 'Examinar',
		'wmode': 'transparent',
		'auto': true,
		'multi': true,
		'cancelImg': 'cancel.png',
		'folder': 'archivos',
		onAllComplete : function(event, data){
			alert(data.filesUploaded + ' archivos subidos correctamente'); 
		}
	});
});
</script>
<style type="text/css">

body {
background:#FFFFFF;
font: bold 13px/1.5 'Helvetica Neue', Arial, 'Liberation Sans', FreeSans, sans-serif;
margin:0px;
padding:0px;
}

h1 {
font-size:16px;
}

h4 {
font-size:12px;
}


#listaArchivos {
width: 400px;
height: 300px;
overflow: auto;
border: 1px solid #E5E5E5;
margin-bottom: 10px;
}

a.linkCancelar {
color:#EEEEEE;
background:#454545 url(imagenes/Delete.gif) no-repeat 2px;
padding:5px 14px 5px 24px;
margin-right:10px;
float:left;
text-decoration:none;
font:12px/20px Tahoma, Verdana, Arial, Helvetica, sans-serif !important;
-moz-border-radius: 2px; /* S�lo Firefox */
}

a.linkCancelar:hover {
background:#5E5D5E url(imagenes/Delete.gif) no-repeat 2px;
}
</style>
</head>

<body>
	<h1>Upload m&uacute;ltiple de archivos, desarrollado por LOVELESS ISMA.</h1>
	<h4>
	&Eacute;sto ha sido hecho por medio del programa Macromedia Dreamweaver 8.<br />
	Plugin de Javascript utilizado (s): JQuery &minus;&gt; Uploadify .<br />
	Lenguage de servidor utilizado: PHP.<br />
	</h4> 
	<div id="listaArchivos" class="listaArchivos"></div>
	<input name="inputArchivo" type="file" id="inputArchivo" />
	<a href="javascript:jQuery('#inputArchivo').uploadifyClearQueue()" class="linkCancelar">Cancelar todo</a>
</body>
</html>
