<?php
@session_start();
require('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once('../../funciones/sala/auditoria/auditoria.php');

//$db->debug = true;
$query = "SELECT p.codigoperiodo
FROM periodo p
WHERE p.codigoestadoperiodo = '4'";
$operacion = $db->Execute($query);
$totalRows_operacion = $operacion->RecordCount();
if($totalRows_operacion == 0) {
    $query = "SELECT p.codigoperiodo
    FROM periodo p
    WHERE p.codigoestadoperiodo = '1'";
    $operacion = $db->Execute($query);
}
$row_operacion = $operacion->FetchRow();
$codigoperiodo = $row_operacion['codigoperiodo'];
//print_r($_REQUEST);

if(isset($_REQUEST['nombresestudiante']) && isset($_REQUEST['emailestudiante']) && isset($_REQUEST['telefonoestudiante'])
        && isset($_REQUEST['listacarrera']) && isset($_REQUEST['campanapublicitaria'])
        && $codigoperiodo != '') {

    // Debe insertar los datos en la base de datos
    $auditoria = new auditoria();
    if($auditoria->usuario == '')
        $auditoria->idusuario = 1;
    //$idtrato = 1;
    //$tipodocumento = 0;
    //$numerodocumento = "";
    $nombresestudiante = $_REQUEST['nombresestudiante'];
    $emailestudiante = $_REQUEST['emailestudiante'];
    $telefonoestudiante = $_REQUEST['telefonoestudiante'];
    $carreracampanapublicitaria = $_REQUEST['listacarrera'];
    $nombrecampanapublicitaria = $_REQUEST['campanapublicitaria'];
    //$ciudadestudiante = '';
    //$codigoestadopreinscripcionestudiante = "300";
    $nombrecampanapublicitaria = $_REQUEST['campanapublicitaria'];
    $modalidadacademica = $_REQUEST['modalidadacademica'];
    /*if($_REQUEST['campanapublicitaria'] == 'google' || $_REQUEST['campanapublicitaria'] == 3) {
        $idtipoorigenpreinscripcion = 3;
        $campanapublicitaria=$_REQUEST['campanapublicitaria'];
    }*/
    $ins_query = "insert into campanapublicitaria(idcampanapublicitaria, fechacampanapublicitaria, codigoperiodo, apellidosestudiante, nombresestudiante, telefonoestudiante, emailestudiante, carreracampanapublicitaria, nombrecampanapublicitaria, ip, codigoestado, modalidadacademica)
    values(0, now(), '$codigoperiodo', '', '$nombresestudiante', '$telefonoestudiante', '$emailestudiante', '$carreracampanapublicitaria', '$nombrecampanapublicitaria', '$auditoria->ip', '100', '$modalidadacademica')";
    $ins = $db->Execute($ins_query);
    //$idpreinscripcion = $db->Insert_ID();
    ?>
<script type="text/javascript">
    window.location.href='index_agradecimientos.php?campanapublicitaria=<?php echo $_REQUEST['campanapublicitaria']; ?>';
</script>
    <?php
    exit();
} else {
    ?>
<!--<html>
    <head><title>Universidad El Bosque</title></head>
    <body>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-16402110-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </body>
</html>
-->
    <?php

    //exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Universidad El Bosque</title>
<link rel="icon" type="image/ico" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="scripts/oferta.css" />
<script type="text/javascript" src="scripts/jquery-1.2.2.pack.js"></script>
<script type="text/javascript" src="scripts/animatedcollapse.js"></script>
<script type="text/javascript">
	animatedcollapse.addDiv('encabezado')
	animatedcollapse.addDiv('primero', 'persist=0,hide=1,speed=400,group=gruponivel1')			<!-- Pregrado -->			
	animatedcollapse.addDiv('segundo', 'persist=0,hide=1,speed=400,group=gruponivel1')			<!-- Postgrado -->		
	animatedcollapse.addDiv('tercero', 'persist=0,hide=1,speed=400,group=gruponivel1')			<!-- Educaci&oacute;n Continuada -->	
	animatedcollapse.init()
	function optCheck(valor) {
		var selPregrado = document.getElementById('lista_desplegable_pregrado');
		var selPosgrado = document.getElementById('lista_desplegable_posgrado');
		if (valor=='pregrado') {selPregrado.style.display = 'block';selPosgrado.style.display = 'none';}
		if (valor=='posgrado') {selPregrado.style.display = 'none';selPosgrado.style.display = 'block';}
	}
</script>
<style type="text/css">
html, body					{ height: 100%; width: 100%; margin: 0; padding: 0; }
#central					{ width: 100%; height: 100%; position: absolute; top: 0; left: 0; }
#formulario					{ width: 100%; height: 100%; margin: 0; padding: 0; list-style-type: none; text-align: left; overflow: hidden; }
#lightbox					{ width: 100%; height: 100%; position: relative; background:url(imagenes/vm_lightbox.png) }
#cerrado					{ width: 100%; height: 100%; position: relative; background-color: transparent; z-index: -1; }
.cerrar						{ background:url(imagenes/vm_cerrar.png); background-position:0 0; top:5px; right:5px; position:absolute; display:block; width:21px; height:21px; text-decoration:none; }
.cerrar:hover				{ background:url(imagenes/vm_cerrar.png); background-position:21px 0; }
#vm_superior_izquierda		{ display:block; float:left; width:16px; height:11px; background:url(imagenes/vm_borde_esquinas.png); background-position:0 0; }
#vm_superior				{ display:block; width:auto; height:11px; margin:0 16px; background:url(imagenes/vm_superior.png) repeat-x; }
#vm_superior_derecha		{ display:block; width:16px; height:11px; position:absolute; top:0; right:0; background:url(imagenes/vm_borde_esquinas.png); background-position:16px 0px; }
#vm_izquierda				{ display:block; width:16px; height:100%; position:absolute; left:0; background:url(imagenes/vm_izquierda.png) repeat-y; }
#vm_central					{ display:block; width:auto; height:100%; position:relative; margin:0 16px; background:#FFF; }
#vm_contenido				{ width:313px; margin:5px 15px 0 15px; padding:10px; }
#vm_derecha					{ display:block; width:16px; height:100%; position:absolute; top:11px; right:0; background:url(imagenes/vm_derecha.png) repeat-y; }
#vm_inferior_izquierda		{ display:block; float:left; width:16px; height:19px; background:url(imagenes/vm_borde_esquinas.png); background-position:0 19px; }
#vm_inferior				{ display:block; width:auto; height:19px; position:relative; margin:0px 16px; background:url(imagenes/vm_inferior.png) repeat-x; }
#vm_inferior_derecha		{ display:block; width:16px; height:19px; position:absolute; right:0; bottom:-30px; background:url(imagenes/vm_borde_esquinas.png); background-position:16px 19px; }
#vm_encabezado				{ width:auto; min-height:50px; background:url(imagenes/vm_degradado_inferior.png) repeat-x bottom #97BE0D; }
#vm_degradado				{ width:auto; height:15px; background:url(imagenes/vm_degradado_superior.png) repeat-x top; }
.vm_boton					{ display:block; width:136px; height:21px; margin:10px 0 0 0; padding-right:24px; text-decoration:none; color:#000; font-weight:bold; text-align:right; border:none; background:url(imagenes/vm_enviar.png); }
.vm_boton:hover				{ color:#FFF; background:url(imagenes/vm_enviar.png); background-position:0 21px; }
#cordenadas a				{ padding:5px; text-decoration:none; font-size:1.5em; color:#FFF; }
#cordenadas a:hover			{ background-color:#849331; }
</style>
</head>
<body>

<div id="central">
<div id="contenedor">
  <div id="encabezado">&nbsp;</div>
  <a href="javascript:animatedcollapse.toggle('primero')" class="nivel1a"><span>Pregrado</span></a>
  <div id="primero" class="contenedor">
	<iframe src="contenedores/1-pregrado.html" class="frame" scrolling="no" frameborder="0"></iframe>
  </div>
  <a href="javascript:animatedcollapse.toggle('segundo')" class="nivel1a"><span>Posgrados</span></a>
  <div id="segundo" class="contenedor">
    <iframe src="contenedores/2-postgrados.html" class="frame" scrolling="no" frameborder="0"></iframe>
  </div>
  <a href="javascript:animatedcollapse.toggle('tercero')" class="nivel1a"><span>Educaci&oacute;n Continuada</span></a>
  <div id="tercero" class="contenedor">
    <iframe src="contenedores/3-educacion_continuada.html" class="frame" scrolling="no" frameborder="0"></iframe>
  </div>
  <a href="http://www.uelbosque.edu.co/programas_academicos/curso_basico_preuniversitario" class="nivel1b"><span>&#187; Curso B&aacute;sico Preuniversitario</span></a>

  <a href="http://www.uelbosque.edu.co/programas_academicos/curso_basico_formacion_musical" class="nivel1b"><span>&#187; Curso B&aacute;sico de Formaci&oacute;n Musical</span></a>

  <a href="http://www.uelbosque.edu.co/programas_academicos/curso_basico_ingenierias_ciencias_ambientales" class="nivel1b"><span>&#187; Curso B&aacute;sico en Ingenier&iacute;as y Ciencias Ambientales</span></a>

  <a href="http://www.uelbosque.edu.co/programas_academicos/curso_pre_icfes" class="nivel1b"><span>&#187; Curso Pre-Icfes</span></a>

  <a href="http://www.uelbosque.edu.co/programas_academicos/colegio" class="nivel1b"><span>&#187; Colegio Bilingue</span></a>

  <a href="http://www.uelbosque.edu.co/programas_academicos/idiomas/ingles" class="nivel1b"><span>&#187; Idiomas</span></a>
    
  <div id="piedepagina">
         <img src="http://www.uelbosque.edu.co/sites/default/files/imagenes/institucionales/colores.jpg" style="padding:0; margin:0; display:block;" />
  		<span id="cordenadas">
			<div style="padding:10px;"><span>Para mayor informaci&oacute;n |</span> L&iacute;nea Gratuita 018000 113033 <span>|</span> PBX [57-1] 6489000 <span>|</span> Carrera 7 B Bis No. 132 - 11</div>
            <a href="http://www.uelbosque.edu.co/admisiones">&#187; Inscripciones abiertas 2012-II</a>
		</span>
  
  </div>
</div>
</div>
<div id="formulario">
  <div id="lightbox">
    <!--[if IE]>
        <div class="ie-bg"></div>
        <![endif]-->
	<div id="campana" style="position:absolute; width:395px; height:120px; left:50%; top:100px; margin-left:-190px;">    
			<span id="vm_superior_izquierda"></span>
			<span id="vm_superior"></span>
			<span id="vm_superior_derecha"></span>
			<span id="vm_izquierda"></span>
			<div id="vm_central">
	        	<div id="vm_encabezado"><a href="#cerrado" class="cerrar" title="cerrar ventana"></a>
	            <div id="vm_degradado"></div>
                <div style="margin:-5px 15px 0 15px; font-size:0.9em;">Sus datos han sido registrados exitosamente.</div> 
              </div>
                <div id="vm_contenido">   
                <span style="display:block; text-align:center; font-size:1.2em;">Agradecemos su colaboraci&oacute;n.</span>
                </div>
	        </div>
			<span id="vm_derecha"></span>
			<span id="vm_inferior_izquierda"></span>
			<span id="vm_inferior"></span>
			<span id="vm_inferior_derecha"></span>
	</div>
  </div>
  <div id="cerrado"></div>
</div>
    <?php
        if($_REQUEST['campanapubliciataria'] == "google") {
        ?>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-16402110-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
        <?php
        }
        ?>
</body>
</html>
