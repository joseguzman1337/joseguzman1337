<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<html>
<head>
	<title>Encuesta</title>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<style type="text/css">
<!--
.Estilo1 {
	color: #EA7500;
	font-size: 12px;
}
.Estilo4 {font-size: 12px}
.Estilo5 {
	font-size: 11px;
	color: #000000;
}
-->
</style>
</head>
<body>
<form action="" name="f1" method="post">
<?php
echo $this->informacionencuesta;
?>
<hr>
<ol>
<?php
foreach($this->preguntas as $pregunta) :
?> 
<br><br>
<li><b>
<?php echo $pregunta->nombrepregunta."<br>"; ?>
</b></li>
<input type="hidden" name="fechainiciodetalleencuesta" value="<?php if($fechainiciodetalleencuesta != "") echo $fechainiciodetalleencuesta; else echo date('Y-m-d H:i:s'); ?>">
<table width="50%" cellpadding="2" cellspacing="0">
<tr id="trtitulogris">
<td width="88%" bgcolor="#FFFFFF"></td>
<td width="6%" bgcolor="#F8F8F8" align="center">SI</td>
<td width="6%" bgcolor="#F8F8F8" align="center">NO</td>
</tr>
<?php
	foreach($pregunta->respuestas as $respuestas) :
?>
  <tr>
	<td>
<input type="hidden" name="esta<?php echo $respuestas->idrespuesta ?>">	
	<li>
<?php		
		echo $respuestas->nombrerespuesta."<br>";
?>
  	</li></td>
	<td bgcolor="#F8F8F8">
	<input type="radio" name="rta<?php echo $respuestas->idrespuesta ?>" value="true" <?php if($_POST['rta'.$respuestas->idrespuesta] == 'true'  && isset($_POST['Enviar'])) echo "checked";?>>
	</td>
	<td bgcolor="#F8F8F8">
		<input type="radio" name="rta<?php echo $respuestas->idrespuesta ?>" value="false" <?php if($_POST['rta'.$respuestas->idrespuesta] == 'false' && isset($_POST['Enviar'])) echo "checked";?>>
	</td>
  </tr>
<?php
	endforeach;
	//print_r($pregunta->respuestas);
?>
</table>
<?php
endforeach;
?>
<br>
<br>
<input type="submit" name="Enviar" value="Guardar">&nbsp;&nbsp;<input type="submit" value="Reestablecer">
</ol>
</form>
</body>
</html>