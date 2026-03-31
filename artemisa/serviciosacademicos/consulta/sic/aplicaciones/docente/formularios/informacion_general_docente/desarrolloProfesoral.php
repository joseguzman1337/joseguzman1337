<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">DESARROLLO PROFESORAL<br><br>Por favor indique qu&eacute; actividades realizar&aacute; durante el siguiente periodo laboral y d&eacute; una breve descripci&oacute;n<br></legend>
<?php
	if($_REQUEST["acc"]=="list") {
		$res=$db->exec("select * from desarrolloprofesoral where iddocente='".$_SESSION['sissic_iddocente']."'");
		$fila=array();
		while ($row=mysql_fetch_array($res)) {
			$fila[]=$row["items"];
			$fila[$row["items"]]=$row["descripcionitem"];
		}
?>
		<p> <?php echo $obj->textArea("Bilinguismo","bilinguismo",$fila["Bilinguismo"],0,6,60)?> </p>
		<p> <?php echo $obj->textArea("Aprendizaje significativo : Diseñado integrado curso","aprendizaje",$fila["Aprendizaje significativo : Disenado integrado curso"],0,6,60)?> </p>
		<p> <?php echo $obj->textArea("Capacitaci&oacute;n en TICS","capacitaciontics",$fila["Capacitacion en TICS"],0,6,60)?> </p>
		<p> <?php echo $obj->textArea("Capacitaci&oacute;n en sistemas de referenciaci&oacute;n","capacitacionsistemasref",$fila["Capacitacion en sistemas de referenciacion"],0,6,60)?> </p>
		<p> <?php echo $obj->textArea("Estudios de postgrados","estudiospostgrados",$fila["Estudios de postgrados"],0,6,60)?> </p>
		<p> <?php echo $obj->textArea("Otros cursos","otroscursos",$fila["Otros cursos"],0,6,60)?> </p>
		<p>
			<?php echo $obj->hiddenBox("opc",$_REQUEST["opc"])?>
			<div id="submit">
				<button type="submit">Guardar</button>
			</div>
		</p>
<?php
	}
?>
</fieldset>
<div id="resultado"></div>
