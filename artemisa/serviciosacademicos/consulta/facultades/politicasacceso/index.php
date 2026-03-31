<?php
	session_start();
	$rutaado=("../../../funciones/adodb/");
	require_once("../../../Connections/salaado-pear.php");
	require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
	require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
	require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
	require_once("../../../funciones/clases/formulario/clase_formulario.php");
	require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
	
	$variables=explode("|",$_REQUEST['parametros']);
	//echo '<pre>'; print_r($variables); die;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
	<head>
		<title>Servicios Academicos</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script type="text/javascript">
			var lateral = window.parent.frames[1].name;
			window.parent.document.getElementById("frameMovible").cols="0%,100%"
			window.parent.frames[1].cols="0";
			function continuar(url_redirect)
			{
				var lateral = window.parent.frames[1].name;
				window.parent.document.getElementById("frameMovible").cols="240,*";
				window.parent.frames[1].cols="0";
				var urlcompleta = window.location.href;
				urlcompleta=urlcompleta.replace('index.php','');
				var index = urlcompleta.indexOf("?");
				var url =urlcompleta.substring(0,index) ;
				//alert(window.location.href);
				//alert(url+'../'+url_redirect);
				window.location.href=url+'../'+url_redirect;
			}
		</script>
	</head>
	<?php 
	if(isset($_REQUEST['accion'])) {
		if($_REQUEST['accion']=='Acepto') {
			//echo "insert into politicasaccesodetalle (idpoliticasacceso,idusuario,usuariopoliticasaccesodetalle,aceptanoaceptapoliticasaccesodetalle) values(".$_REQUEST['idpoliticas'].",".$_REQUEST['idusuariopoliticas'].",concat('".$_REQUEST['apellidosusuariopoliticas']."',' ','".$_REQUEST['nombresusuariopoliticas']."'),".$respuesta.")";
			$sala->query("insert into politicasaccesodetalle (idpoliticasacceso,idusuario,usuariopoliticasaccesodetalle,aceptanoaceptapoliticasaccesodetalle) values(".$_REQUEST['idpoliticas'].",".$_REQUEST['idusuariopoliticas'].",concat('".$_REQUEST['apellidosusuariopoliticas']."',' ','".$_REQUEST['nombresusuariopoliticas']."'),true)");
			echo "<script>continuar('".$_REQUEST['urldespuesaceptarpoliticas']."')</script>";
		} else {
			$sala->query("insert into politicasaccesodetalle (idpoliticasacceso,idusuario,usuariopoliticasaccesodetalle,aceptanoaceptapoliticasaccesodetalle) values(".$_REQUEST['idpoliticas'].",".$_REQUEST['idusuariopoliticas'].",concat('".$_REQUEST['apellidosusuariopoliticas']."',' ','".$_REQUEST['nombresusuariopoliticas']."'),false)");
			echo "<script>parent.location.href='../consultafacultadesv2.htm'</script>";
		}
	}
	?>
	<form name='forma' action='' method='post'>
		<br>
		<frameset onunload="" name="principal" id="principal" rows="100" cols="*" frameborder="no" border="0" framespacing="1">
			<div align="center">
				<iframe width="50%" frameborder=0 height="450" scrolling="auto" src="<?php echo $variables[0]; ?>"></iframe>
			</div>
		</frameset>
		<br>
		<input type='hidden' name='idpoliticas' value='<?php echo $variables[1];?>'>
		<input type='hidden' name='idusuariopoliticas' value='<?php echo $variables[2];?>'>
		<input type='hidden' name='apellidosusuariopoliticas' value='<?php echo $variables[3];?>'>
		<input type='hidden' name='nombresusuariopoliticas' value='<?php echo $variables[4];?>'>
		<input type='hidden' name='urldespuesaceptarpoliticas' value='<?php echo $variables[5];?>'>
		<center>
			<input type='submit' name='accion' value='Acepto'>
			<input type='submit' name='accion' value='No Acepto'>
		</center>
	</form>
	<noframes>
		<body>
		</body>	
	</noframes>
</html>