<?php
/**
 * Se descargan las librerias http://code.jquery.com/ui/1.13.1/jquery-ui.js 
 * y http://code.jquery.com/ui/jquery-ui-git.css para evitar problemas de
 * referenciacion por https
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de septiembre de 2018.
 */
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>:: ADMINISTRACION DE VOTACIONES ::</title>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
		<link rel="stylesheet" type="text/css" media="screen" href="css/jquery-ui-git.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/css_menu.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/css_form.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/css_table.css" />
		<script>
			$().ready(function() {
				$("#forma").validate({
					submitHandler: function(form) {
							$('#resultado').html('<img src="images/cargando.gif">&nbsp;&nbsp;<span class="search">Guardando...</span>');
							$.ajax({
								type: 'POST',
								url: 'save.php',
								async: false,
								data: $('#forma').serialize(),                
								success:function(data){
									$('#resultado').html(data);
								},
								error: function(data,error,errorThrown){alert(error + errorThrown);}
							});
					}
				});
			});
		</script>
	</head>
	<body>
<?php
		include_once("includes/connection.php");
		//$db =&connection::getInstance();
		require_once('../Connections/sala2.php');
		$rutaado = "../funciones/adodb/";
		require_once('../Connections/salaado.php');
		
		include_once("includes/objetosHTML.php");
		$obj = New objetosHTML;
		include_once("includes/menu.php");
?>
		<form class="cmxform" id="forma" name="forma" method="post" action="">
<?php

			if(!isset($_REQUEST["opc"]))
				include_once("configuracion/bienvenida.php");
			if($_REQUEST["opc"]=="v")
				include_once("configuracion/votaciones.php");
			if($_REQUEST["opc"]=="p")
				include_once("configuracion/plantillas.php");
			if($_REQUEST["opc"]=="c")
				include_once("configuracion/candidatos.php");
?>
		</form>
	</body>
</html>
