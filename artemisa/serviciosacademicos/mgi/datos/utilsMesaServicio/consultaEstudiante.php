<?php
	session_start();
	if(empty($_SESSION['MM_Username'])){
		echo "No ha iniciado sesión en el sistema";
		exit();
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Modificar Estudiante</title>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="js/functionsUtils.js"></script>
		<link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
		<div id="contenido" style="margin-top: 10px;">
		<h4>Actualizar Estudiante</h4>
			<div id="form"> 
					<label for="file">Digite n&uacute;mero documento estudiante:</label>
					<input type="text" name="documento" id="documento" autocomplete="off"/>
					<input type="submit" name="buscar" value="Buscar" id="buscar" class="paging" />
			</div>
			<div id="idData"></div>
			<input type='submit' name='guardar' id='guardar' size='35' value='Guardar' class="paging"/><br>
		 </div>
		 <div id="correo" style="margin-top: 10px;">
					<table border = '1.5'width='80%'>  
						<th>Digite correo para enviar link de inscripción</th>	
						<tr><td><input type='text' name='correoEnviar' id='correoEnviar' /></td></tr>
						<tr><td colspan="2"><input type='submit' name='enviarCorreo' id='enviarCorreo' size='35' value='EnviarCorreo' class="paging"/></td>
					</table>
		 </div>
  </body>
</html>
