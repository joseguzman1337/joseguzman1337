<?php
@session_start();
require('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');


// Cargar los campos necesarios
$artesydiseno = array( "Arte Dramático", "Artes Plásticas","Cursos certificados en artesanias",
        "Diseño Industrial", "Formación Musical");
$cienciasysalud = array( "Biología", "Enfermería",
        "Instrumentación Quirúrgica", "Medicina", "Odontología",
        "Optometría", "Psicología");
$cienciassociales = array( "Derecho", "Filosofía",
        "Lic. en Educación Bilingue con Énfasis en la Enseñanza del Inglés",
        "Licenciatura en Pedagogía Infantil",
        "Psicología");
$ingenierias = array( "Administración de Empresas", "Bioningeniería", "Ingeniería Ambiental",
        "Ingeniería Electrónica", "Ingeniería Industrial",
        "Ingeniería de Sistemas");


$carreras['Pregrado']['Artes y Diseño'] = $artesydiseno;
$carreras['Pregrado']['Ciencias Naturales y de la Salud'] = $cienciasysalud;
$carreras['Pregrado']['Ciencias Sociales y Humanidades'] = $cienciassociales;
$carreras['Pregrado']['Administración e Ingenierías'] = $ingenierias;
$carreras['Pregrado']['Curso Básico'] = array("Curso Básico Pre-Universitario");

$carreras['Postgrado']['Doctorado en'] = array ("Bioética");
$carreras['Postgrado']['Maestrías'] = array ("Maestría en Bioética","Maestría en Ciencias Biomédicas", "Maestría en  Docencia de la Eduación Superior", "Maestría en Psicología",
        "Maestría en Psiquiatría Forense", "Maestría en Salud Pública", "Maestría en Salud Sexual y Reproductiva");

$carreras['Postgrado']['Especializaciones en Psicología'] = array ("Psicología Médica y de la Salud","Psicología del Deporte y del Ejercio", "Psicología Ocupacional y Organizacional", "Psicología Social Cooperación y Gestión Comunitaria",
        "Psicología Clínica y Autoeficacia Personal", "Psicología Clínica y Desarrollo Infantil");

$carreras['Postgrado']['Especializaciones en Educación'] = array("Especialización en Docencia Universitaria");

$carreras['Postgrado']['Especializaciones Interdisciplinarias'] = array("Bioética", "Filosofía de la Ciencia", "Epidemiología General", "Epidemiología Clínica", "Ergonomía", "Gerencia de la Calidad en Salud",
        "Higiene Industrial","Salud Familiar y Comunitaria","Salud Ocupacional");

$carreras['Postgrado']['Especializaciones en Odontología'] = array("Cirugía Oral y Maxilofacial", "Endodoncia", "Ortodoncia", "Odontología Pediátrica", "Operatoria Dental Estética y Materiales Dentales", "Patología Oral y Medios Diagnósticos",
        "Periodoncia y Medicina Oral","Prostodoncia Énfasis en Odontología y Estética");

$carreras['Postgrado']['Especializaciones en Medicina'] = array("Anestesia Cardiovascular y Torácica", "Anestesia y Reanimación FSFB", "Anestesia y Reanimación HSB", "Cardiología Adultos", "Cardiología Pediátrica", "Cirugía de Columna",
        "Cirugía de Mano","Cirugía de Torax", "Cirugía General", "Cirugía Plástica","Cirugía Vascular y Angiología","Dermatología","Gastroenterología Pediátrica","Ginecología y Obstetricia","Medicina Critíca y Cuidado Intensivo Pediátrico",
        "Medicina del Deporte","Medicina del Dolor y Cuidados Paliativos","Medicina Familiar","Medicina Física y Rehabilitación","Medicina Interna HSC","Nefrología Pediátrica","Neonatología","Neumología","Neumología Pediátrica","Neurocirugía",
        "Neurología","Oftalmología","Oncología Clínica","Ortopedia","Pediatría","Psiquiatría","Psiquiatría de Enlace e Interconsultas","Psiquiatría Infantil y del Adolecente","Radiología e Imágenes Diagnosticas","Reumatología Pediátrica","Urología");

$carreras['Postgrado']['Especializaciones en Ingeniería'] = array("Diseño de Redes Telemáticas", "Gerencia de Proyectos", "Gerencia de Producción y Productividad", "Salud y Ambiente", "Seguridad en Redes Telemáticas");

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
#central					{ width: 100%; height: 100%; position: absolute; top: 0; left: 0; overflow:inherit; }
#formulario					{ width: 100%; height: 100%; margin: 0; padding: 0; list-style-type: none; text-align: left; overflow: hidden; }
#lightbox					{ width: 100%; height: 100%; position: relative; background:url(imagenes/vm_lightbox.png) }
#cerrado					{ width: 100%; height: 100%; position: relative; background-color: transparent; z-index: -1; }
.cerrar						{ display:block; position:absolute; width:121px; height:21px; text-decoration:none; background:url(imagenes/vm_saltar.png) no-repeat right; top:5px; right:5px; }
.cerrar:hover				{ background:url(imagenes/vm_saltar_hover.png); }
.vm_campo					{ position:relative; width:323px; height:25px; margin:2px 0; vertical-align:middle; padding:5px 0 0 10px; left:0; border:none; color:#596221; background:url(imagenes/vm_campo.gif) repeat-x #eaebdb; }
select, input#idposgrado	{ margin:2px 0; position:relative; width:333px; left:0; border:none; color:#596221; background:url(imagenes/vm_campo.gif) repeat-x #eaebdb; }
select						{ }
.vm_boton					{ width:160px; height:21px; margin:10px; padding-right:24px; font-weight:bold; text-align:right; border:none; background:url(imagenes/vm_enviar.png); }
.vm_boton:hover				{ color:#FFF; background:url(imagenes/vm_enviar.png); background-position:0 21px; }
/*input:focus				{ color:#B5B5A6; }*/
#vm_superior_izquierda		{ display:block; float:left; width:16px; height:11px; background:url(imagenes/vm_borde_esquinas.png); background-position:0 0; }
#vm_superior				{ display:block; width:auto; height:11px; margin:0 16px; background:url(imagenes/vm_superior.png) repeat-x; }
#vm_superior_derecha		{ display:block; width:16px; height:11px; position:absolute; top:0; right:0; background:url(imagenes/vm_borde_esquinas.png); background-position:16px 0px; }
#vm_izquierda				{ display:block; width:16px; height:100%; position:absolute; left:0; background:url(imagenes/vm_izquierda.png) repeat-y; }
#vm_central					{ display:block; width:auto; height:100%; position:relative; margin:0 16px; background:#FFF; }
#vm_contenido				{ width:333px; margin:0 15px; background:#F1F2E7 }
#vm_derecha					{ display:block; width:16px; height:100%; position:absolute; top:11px; right:0; background:url(imagenes/vm_derecha.png) repeat-y; }
#vm_inferior_izquierda		{ display:block; float:left; width:16px; height:19px; background:url(imagenes/vm_borde_esquinas.png); background-position:0 19px; }
#vm_inferior				{ display:block; width:auto; height:19px; position:relative; margin:0px 16px; background:url(imagenes/vm_inferior.png) repeat-x; }
#vm_inferior_derecha		{ display:block; width:16px; height:19px; position:absolute; right:0; bottom:-30px; background:url(imagenes/vm_borde_esquinas.png); background-position:16px 19px; }
#vm_encabezado				{ width:auto; padding-bottom:35px; min-height:50px; background:url(imagenes/vm_degradado_inferior.png) repeat-x bottom #97BE0D; }
#vm_degradado				{ width:auto; height:15px; background:url(imagenes/vm_degradado_superior.png) repeat-x top; }
#cordenadas a				{ padding:5px; text-decoration:none; font-size:1.5em; color:#FFF; }
#cordenadas a:hover			{ background-color:#849331; }
.radiobuttons				{ text-align:center; padding:10px;}
.radiobuttons span			{ margin-right:20px;}
</style>
<!--[if IE]>
    <style type="text/css">
    html {
    overflow-y: auto;}

    #formulario {
    position: relative;}
    
    </style>
    <![endif]-->
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
	<div id="campana" style="position:absolute; width:395px; height:375px; left:50%; top:50px; margin-left:-190px;">    
			<span id="vm_superior_izquierda"></span>
			<span id="vm_superior"></span>
			<span id="vm_superior_derecha"></span>
			<span id="vm_izquierda"></span>
			<div id="vm_central">
	        	<div id="vm_encabezado"><a href="#cerrado" class="cerrar" title="cerrar ventana"></a>
	            <div id="vm_degradado"></div>
                <div style="margin:20px 15px 0 15px;">Para conocer sus intereses y  ofrecerle un mejor servicio, complete los campos a continuaci&oacute;n:</div> 
	            </div>
                <div id="vm_contenido">
                <form action="" method="get" style="width:331px; margin:0; padding:0; margin-top:5px; text-align:right;" id="f1" name="f1">
                    <?php
                    $campanapublicitaria = "google";
                    if(isset($_REQUEST['campanapublicitaria']))
                        $campanapublicitaria = $_REQUEST['campanapublicitaria'];
                    ?>
                <input type="hidden" name="campanapublicitaria" value="<?php echo $campanapublicitaria; ?>" />
                <input type="text" class="vm_campo" name="nombresestudiante" value="<?php if (isset($_REQUEST['nombresestudiante'])) echo $_REQUEST['nombresestudiante']; else echo "Nombres y Apellidos"; ?>" onfocus="if(this.value == 'Nombres y Apellidos') {this.value=''}" onblur="if(this.value == ''){this.value='Nombres y Apellidos';}" />
                <!--<input type="text" class="vm_campo" name="nombresestudiante" value="Nombres y apellidos" onfocus="this.value=''" onblur="if(this.value == ''){this.value='Nombres y apellidos';}" />-->
                <input type="text" class="vm_campo" name="emailestudiante" value="<?php if (isset($_REQUEST['emailestudiante'])) echo $_REQUEST['emailestudiante']; else echo "Correo electrónico"; ?>" onfocus="if(this.value == 'Correo electrónico') {this.value=''}" onblur="if(this.value == ''){this.value='Correo electrónico';}" />
                <!--<input type="text" class="vm_campo" name="Correo" value="Correo electr&oacute;nico" onfocus="this.value=''" onblur="if(this.value == ''){this.value='Correo electr&oacute;nico';}" />-->
                <input type="text" class="vm_campo" name="telefonoestudiante" value="<?php if (isset($_REQUEST['telefonoestudiante'])) echo $_REQUEST['telefonoestudiante']; else echo "Móvil"; ?>" onfocus="if(this.value == 'Móvil') {this.value=''}" onblur="if(this.value == ''){this.value='Móvil';}" />
                <!--<input type="text" class="vm_campo" name="Movil" value="M&oacute;vil" onfocus="this.value=''" onblur="if(this.value == ''){this.value='Mobil';}" />-->
		<div class="radiobuttons"><div style="margin-bottom:10px;">Quisiera mayor informaci&oacute;n sobre</div>
                <?php
                $modalidad = $_REQUEST['modalidadacademica'];
                ?>
                <!--<span><input type="radio" name="oferta" value="pregrado" checked="checked" onClick="optCheck(this.value)" />Pregrado</span>
                <span><input type="radio" name="oferta" value="posgrado" onClick="optCheck(this.value)" />Posgrado</span>-->
                <input type="radio" name="modalidadacademica" value="Pregrado" onclick="f1.submit()" <?php if($modalidad == "Pregrado") echo "checked"?>>
                    <span style="margin:1px 0px; font-size:0.8em; color:#596221; text-align: left;" onclick="f1.modalidadacademica[0].checked=true; f1.submit()">Pregrado&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </input>
                <input type="radio" name="modalidadacademica" value="Postgrado" onclick="f1.submit()" <?php if($modalidad == "Postgrado") echo "checked"?>>
                    <span style="margin:1px 0px; font-size:0.8em; color:#596221; text-align: left;" onclick="f1.modalidadacademica[1].checked=true; f1.submit()">Postgrado&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </input>
                </div>
                <select name="listacarrera" class="codigocarrera">
                                    <option selected="selected" value="">Me interesa el programa de:</option>
                                    <?php
                                    if(is_array($carreras[$modalidad])) {
                                        $nombreareadisciplinar = "";
                                        $entrogrupo = false;
                                        foreach($carreras[$modalidad] as $area => $carrerasFinal) {
                                            //$selected = "";
                                            if($area != $nombreareadisciplinar) {
                                                $nombreareadisciplinar = $area;
                                                $entrogrupo = true;
                                                ?>
                                    <optgroup label="<?php echo "$nombreareadisciplinar"; ?>">
                                                    <?php
                                                }
                                                foreach($carrerasFinal as $carrera) {
                                                    $selected = "";
                                                    if(isset($_REQUEST['listacarrera'])) {
                                                        if($_REQUEST['listacarrera'] == $carrera)
                                                            $selected = "selected";
                                                    }
                                                    ?>
                                        <option value="<?php echo $carrera;?>" <?php echo $selected; ?>> <?php echo $carrera; // strtolower( ?></option>

                                                    <?php
                                                }
                                            }
                                            if($entrogrupo) {
                                                ?>
                                    </optgroup>
                                            <?php
                                            $entrogrupo = false;
                                        }
                                    }
                                    ?>
                                </select>
                <!--<select id="lista_desplegable_pregrado" name="lista_pregrados" style="display:block">
                	<option selected="selected">Seleccione el pregrado de su inter&eacute;s
                    </option>
                	<optgroup label="Artes y Dise&ntilde;o">
                		<option value="Arte Dramatico">Arte Dram&aacute;tico</option>
                		<option value="Artes Plasticas">Artes Pl&aacute;sticas</option>
                        <option value="Cursos certificados en artesanias">Cursos certificados en artesan&iacute;as</option>
                		<option value="Diseno Industrial">Dise&ntilde;o Industrial</option>
                		<option value="Formacion Musical">Formaci&oacute;n Musical</option>
                    </optgroup>
                	<optgroup label="Ciencias Naturales y de la Salud">
                		<option value="Biologia">Biolog&iacute;a</option>
                		<option value="Enfermeria">Enfermer&iacute;a</option>
                		<option value="Instrumentacion Quirurgica">Instrumentaci&oacute;n Quir&uacute;rgica</option>
                		<option value="Medicina">Medicina</option>
                		<option value="Odontologia">Odontolog&iacute;a</option>
                		<option value="Optometria">Optometr&iacute;a</option>
                		<option value="Psicologia">Psicolog&iacute;a</option>
                    </optgroup>
                	<optgroup label="Ciencias Sociales y Humanidades">
                    	<option value="Derecho">Derecho</option>
                		<option value="Filosofia">Filosof&iacute;a</option>
                		<option value="Lic. en Educacion Bilingue">Lic. en Educaci&oacute;n Bilingue con &Eacute;nfasis en la Ense&ntilde;anza del Ingl&eacute;s</option>
                		<option value="Lic. en Pedagogia Infantil">Licenciatura en Pedagog&iacute;a Infantil</option>
                		<option value="Psicologia">Psicolog&iacute;a</option>
                    </optgroup>
                	<optgroup label="Administraci&oacute;n e Ingenier&iacute;as">
                		<option value="Administracion de Empresas">Administraci&oacute;n de Empresas</option>
                        <option value="Bioingenieria">Bioingenier&iacute;a</option>
                		<option value="Ingenieria Ambiental">Ingenier&iacute;a Ambiental</option>
                		<option value="Ingenieria Electronica">Ingenier&iacute;a Electr&oacute;nica</option>
                		<option value="Ingenieria Industral">Ingenier&iacute;a Industrial</option>
                		<option value="Ingenieria de Sistemas">Ingenier&iacute;a de Sistemas</option>
                    </optgroup>
                </select>				
                <select id="lista_desplegable_posgrado" name="lista_posgrados" style="display:none">
                	<option selected="selected">Seleccione el posgrado de su inter&eacute;s
                    </option>
                	<optgroup label="Doctorado">
                		<option value="Doctorado en bioetica">Doctorado en Bio&eacute;tica</option>
                    </optgroup>
                	<optgroup label="Maestr&iacute;as">
                		<option value="Maestria en Bioetica">Masestr&iacute;a en Bio&eacute;tica</option>
                		<option value="Maestria en Ciencias Biomedicas">Maestr&iacute;a en Ciencias Biom&eacute;dicas</option>
                		<option value="Maestria en Docencia de la Educacion Superior">Maestr&iacute;a en Docencia de la Educaci&oacute;n Superior</option>
                		<option value="Maestria en Psicologia">Maestr&iacute;a en Psicolog&iacute;a</option>
						<option value="Maestria en Psiquiatria Forense">Maestr&iacute;a en Psiquiatr&iacute;a Forense</option>
						<option value="Maestria en Salud Publica">Maestr&iacute;a en Salud P&uacute;blica</option>
						<option value="Maestria en Salud Sexual y Reproductiva">Maestr&iacute;a en Salud Sexual y Reproductiva</option>						
                    </optgroup>
                	<optgroup label="Especializaciones en Psicolog&iacute;a">
						<option value="Psicologia Medica y de la Salud">Psicolog&iacute;a M&eacute;dica y de la Salud</option>
						<option value="Psicologia del Deporte y del Ejercicio">Psicolog&iacute;a del Deporte y del Ejercicio</option>
						<option value="Psicologia Ocupacional y Organizacional">Psicolog&iacute;a Ocupacional y Organizacional</option>
						<option value="Psicologia Social Cooperacion y Gestion Comunitaria">Psicolog&iacute;a Social Cooperaci&oacute;n y Gesti&oacute;n Comunitaria</option>
						<option value="Psicologia Clinica y Autoeficacia Personal">Psicolog&iacute;a Cl&iacute;nica y Autoeficacia Personal</option>
						<option value="Psicologia Clinica y Desarrollo Infantil">Psicolog&iacute;a Cl&iacute;nica y Desarrollo Infantil</option>
                    </optgroup>
                	<optgroup label="Especializaciones en Educaci&oacute;n">
						<option value="Especializacion en Docencia Universitaria">Especializaci&oacute;n en Docencia Universitaria</option>
                    </optgroup>
                	<optgroup label="Especializaciones Interdisciplinarias">
						<option value="Bioetica">Bio&eacute;tica</option>
						<option value="Filosofia de la Ciencia">Filosof&iacute;a de la Ciencia</option>
						<option value="Epidemiologia General">Epidemiolog&iacute;a General</option>
						<option value="Epidemiologia Clinica">Epidemiolog&iacute;a Cl&iacute;nica</option>
						<option value="Ergonomia">Ergonom&iacute;a</option>
						<option value="Gerencia de la Calidad en Salud">Gerencia de la Calidad en Salud</option>
						<option value="Higiene Industrial">Higiene Industrial</option>
						<option value="Salud Familiar y Comunitaria">Salud Familiar y Comunitaria</option>
						<option value="Salud Ocupacional">Salud Ocupacional</option>
                    </optgroup>
                	<optgroup label="Especializaciones en Odontolog&iacute;a">
						<option value="Cirugia Oral y Maxilofacial">Cirug&iacute;a Oral y Maxilofacial</option>
						<option value="Endodoncia">Endodoncia</option>
						<option value="Ortodoncia">Ortodoncia</option>
						<option value="Odontologia Pediatrica">Odontolog&iacute;a Pedi&aacute;trica</option>
						<option value="Operatoria Dental Estetica y Materiales Dentales">Operatoria Dental Est&eacute;tica y Materiales Dentales</option>
						<option value="Patologia Oral y Medios Diagnosticos">Patolog&iacute;a Oral y Medios Diagn&oacute;sticos</option>
						<option value="Periodoncia y Medicina Oral">Periodoncia y Medicina Oral</option>
						<option value="Prostodoncia enfasis en Odontologia Estetica">Prostodoncia &eacute;nfasis en Odontolog&iacute;a Est&eacute;tica</option>
                    </optgroup>
                	<optgroup label="Especializaciones en Medicina">
						<option value="Anestesia Cardiovascular y Toracica">Anestesia Cardiovascular y Tor&aacute;cica</option>
						<option value="Anestesia y Reanimacion FSFB">Anestesia y Reanimaci&oacute;n FSFB</option>
						<option value="Anestesia y Reanimacion HSB">Anestesia y Reanimaci&oacute;n HSB</option>
						<option value="Cardiologia Adultos">Cardiolog&iacute;a Adultos</option>
						<option value="Cardiologia Pediatrica">Cardiolog&iacute;a Pedi&aacute;trica</option>
						<option value="Cirugia de Columna">Cirug&iacute;a de Columna</option>
						<option value="Cirugia de Mano">Cirug&iacute;a de Mano</option>
						<option value="Cirugia de Torax">Cirug&iacute;a de T&oacute;rax</option>
						<option value="Cirugia General">Cirug&iacute;a General</option>
						<option value="Cirugia Plastica">Cirug&iacute;a Pl&aacute;stica</option>
						<option value="Cirugia Vascular y Angiologia">Cirug&iacute;a Vascular y Angiolog&iacute;a</option>
						<option value="Dermatologia">Dermatolog&iacute;a</option>
						<option value="Gastroenterologia Pediatrica">Gastroenterolog&iacute;a Pedi&aacute;trica</option>
						<option value="Ginecologia y Obstetricia">Ginecolog&iacute;a y Obstetricia</option>
						<option value="Medicina Critica y Cuidado Intensivo Pediatrico">Medicina Cr&iacute;tica y Cuidado Intensivo Pedi&aacute;trico</option>
						<option value="Medicina Del Deporte">Medicina Del Deporte</option>
						<option value="Medicina del Dolor y Cuidados Paliativos">Medicina del Dolor y Cuidados Paliativos</option>
						<option value="Medicina Familiar">Medicina Familiar</option>
						<option value="Medicina Fisica y Rehabilitacion">Medicina F&iacute;sica y Rehabilitaci&oacute;n</option>
						<option value="Medicina Interna HSC">Medicina Interna HSC</option>
						<option value="Nefrologia pediatrica">Nefrolog&iacute;a pedi&aacute;trica</option>
						<option value="Neonatologia">Neonatolog&iacute;a</option>
						<option value="Neumologia">Neumolog&iacute;a</option>
						<option value="Neumologia Pediatrica">Neumolog&iacute;a Pedi&aacute;trica</option>
						<option value="Neurocirugia">Neurocirug&iacute;a</option>
						<option value="Neurologia">Neurolog&iacute;a</option>
						<option value="Oftalmologia">Oftalmolog&iacute;a</option>
						<option value="Oncologia Clinica">Oncolog&iacute;a Cl&iacute;nica</option>
						<option value="Ortopedia">Ortopedia</option>
						<option value="Pediatria">Pediatr&iacute;a</option>
						<option value="Psiquiatria">Psiquiatr&iacute;a</option>
						<option value="Psiquiatria de Enlace e Interconsultas">Psiquiatr&iacute;a de Enlace e Interconsultas</option>
						<option value="Psiquiatria Infantil y del Adolescente">Psiquiatr&iacute;a Infantil y del Adolescente</option>
						<option value="Radiologia e Imagenes Diagnosticas">Radiolog&iacute;a e Im&aacute;genes Diagnosticas</option>
						<option value="Reumatologia pediatrica">Reumatolog&iacute;a pedi&aacute;trica</option>
						<option value="Urologia">Urolog&iacute;a</option>
                    </optgroup>					
                	<optgroup label="Especializaciones en Ingenier&iacute;a">
						<option value="Diseno de Redes Telematicas">Dise&ntilde;o de Redes Telem&aacute;ticas</option>
						<option value="Gerencia de Proyectos">Gerencia de Proyectos</option>
						<option value="Gerencia de Produccion y Productividad">Gerencia de Producci&oacute;n y Productividad</option>
						<option value="Salud y Ambiente">Salud y Ambiente</option>
						<option value="Seguridad en Redes Telematicas">Seguridad en Redes Telem&aacute;ticas</option>
                    </optgroup>					
                </select>-->
                <input type="submit" class="vm_boton" value="Enviar y continuar" name="Enviar" />
                </form>
                </div><span style="display:block; margin:5px 15px; font-size:0.7em; font-style:italic; color:#A4AF92">Sus datos son confidenciales y de uso exclusivo de la Universidad.</span>
	        </div>
			<span id="vm_derecha"></span>
			<span id="vm_inferior_izquierda"></span>
			<span id="vm_inferior"></span>
			<span id="vm_inferior_derecha"></span>
	</div>
  </div>
  <div id="cerrado"></div>
</div>
</body>
</html>
<?php
if(isset($_REQUEST['Enviar'])) {
    $mensaje = "";
    $nombresestudiante = $_REQUEST['nombresestudiante'];
    $emailestudiante = $_REQUEST['emailestudiante'];
    $telefonoestudiante = $_REQUEST['telefonoestudiante'];
    $listacarrera = $_REQUEST['listacarrera'];
    $campanapublicitaria = $_REQUEST['campanapublicitaria'];
    $modalidadacademica = $_REQUEST['modalidadacademica'];
    if($_REQUEST['nombresestudiante'] == 'Nombres y Apellidos' || $_REQUEST['nombresestudiante'] == '') {
        $mensaje .= '\nDebe diligenciar los Nombres';
    } else if($_REQUEST['emailestudiante'] == 'Correo electrónico' || $_REQUEST['emailestudiante'] == '') {
        $mensaje .= '\nDebe diligenciar el Correo electrónico';
    } else if($_REQUEST['telefonoestudiante'] == 'Móvil' || $_REQUEST['telefonoestudiante'] == '') {
        $mensaje .= '\nDebe diligenciar el Móvil';
    } else if($_REQUEST['listacarrera'] == '') {
        $mensaje .= '\nDebe seleccionar una Carrera';
    }
    if($mensaje != "") {
        ?>
<script type="text/javascript">
    alert('Todos los campos del formulario son obligatorios: <?php echo $mensaje; ?>')
</script>
        <?php
        //exit();
    }
    else {
        ?>
<script type="text/javascript">
    window.location.href='index_agradecimientos.php?<?php echo "nombresestudiante=$nombresestudiante&emailestudiante=$emailestudiante&telefonoestudiante=$telefonoestudiante&listacarrera=$listacarrera&campanapublicitaria=$campanapublicitaria&modalidadacademica=$modalidadacademica"; ?>';
</script>
        <?php
    }
}
?>
