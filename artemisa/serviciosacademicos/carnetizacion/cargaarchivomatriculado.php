<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Subir archivos</title>
	<link rel="STYLESHEET" type="text/css" href="estilos_admin.css">
</head>
<body>
<h1 align="center">Cargar archivo Matriculados </h1>
<br>
	<form action="subearchivomatriculado.php" method="post" enctype="multipart/form-data">
	  <div align="center"> <input type="hidden" name="cadenatexto" size="20" maxlength="100">

		    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
		    <br>

		    <br>

		    <b>Subir archivo modificamatriculado.txt: </b>

		    <br>

            <input name="userfile" type="file">		

            <br>

		    <br><br><br>

		    <input type="submit" value="Cargar Nuevo Archivo">&nbsp;

          <input type="button" name="Submit" value="Matricular registros Existentes" onClick="recargar()">

		</div>

	</form>

</body>

</html>

<script language="javascript">

function recargar()

{

	window.location.reload("modificarmatriculado.php");

}

</script>



