<?

chdir(dirname(__FILE__)."/common/");

//tODO descomentar en produccion
if (file_exists("../instalador") && is_dir("../instalador")){
	if (file_exists("parametros.properties.php")){
		require_once "Configuracion.php";
		//var_export(file_exists("../instalador/sincronizado.flg"));

	//	if (file_exists("../instalador/sincronizado.flg") || !(Configuracion::isNTHabilitado())){
			echo "<h1>Si ha completado el proceso de instalacion debe borrar la carpeta 'instalador' del arbol web.</h1>";
	//	}else{?>
	<!--		<h1>Debe ejecutar la sincronizacion con el direcotrio.</h1>
			<br/>
		<a href="instalador/paso_6.php">Actualizar ahora</a>
		-->
		<?//}
	}else{
		header("Location: ./instalador/instalador_controller.php");
	}
	exit;
}
require_once "Configuracion.php";

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" 
"http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<title><? echo Configuracion::getTituloSitio(); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="icon" type="image/x-icon" href="/favicon.ico" />
</head>

<frameset rows="100,*" framespacing="0" border="0" frameborder="0">
	<frame name="top" src="main/head.php" marginwidth="0" marginheight="0" scrolling="no" noresize />
	<frame name="bottom" src="main/cuerpo.php"  marginwidth="0" marginheight="0" scrolling="auto" noresize/>
	<noframes>
		<body>
			<p>This page uses frames, but your browser doesn't support them.</p>
			<p>Esta pï¿½gina utiliza marcos, pero su navegador no las soporta.</p>
			<p>Esta pï¿½gina usa quadros, mas seu navegador nï¿½o as suporta.</p>
		</body>
	</noframes>
</frameset>

</html>