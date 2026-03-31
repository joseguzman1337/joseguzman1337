<?php 
	/*
	 * @modified David Perez <perezdavid@unbosque.edu.co>
	 * @since  Noviembre 07, 2017
	 * Cambio en el banner de evaluación docente 20172
	*/
	session_start();
	$rutaado="../../funciones/adodb/";
	require_once('../../Connections/salaado-pear.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<title>Servicios Académicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-Equiv="Cache-Control" Content="no-cache" />
<meta http-Equiv="Pragma" Content="no-cache" />
<meta http-Equiv="Expires" Content="0" />



<?php

if($_SESSION['rol']=='1'||$_SESSION['rol']=='2')
{	
	if($_SESSION['rol']==1 && $_SESSION['MM_Username']!='padre'){
		
		$query_sitestudiante="select * from estudiante where codigoestudiante=".$_SESSION['codigo']." and codigosituacioncarreraestudiante=400";
		$sitestudiante=$sala->query($query_sitestudiante);
		$totalRows_sitestudiante = $sitestudiante->RecordCount();
	        $row_sitestudiante=$sitestudiante->fetchRow();
		
		if($totalRows_sitestudiante==0){
			
			$query_modalidad="select * from estudiante e, carrera c where e.codigoestudiante=".$_SESSION['codigo']." and e.codigocarrera=c.codigocarrera";
	                $modalidad=$sala->query($query_modalidad);
	                $totalRows_modalidad = $modalidad->RecordCount();
	                $row_modalidad=$modalidad->fetchRow();

			if($row_modalidad['codigomodalidadacademica']=='200'){
				$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
				votacion v, plantillavotacion pv,estudiante e
				WHERE
				v.codigoestado=100
				and e.codigoestudiante=".$_SESSION['codigo']."
				and pv.idvotacion=v.idvotacion
				and pv.codigocarrera=e.codigocarrera
				and v.idtipocandidatodetalleplantillavotacion=2
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				group by v.idvotacion
				";
			}
			elseif($row_modalidad['codigomodalidadacademica']=='300'){
			$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion 
	                FROM
	                votacion v
	                WHERE
        	        v.codigoestado=100
                	and v.idtipocandidatodetalleplantillavotacion=2
	                AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
        	         ";
			}
		}
		else{
		$query_modalidad="select * from estudiante e, carrera c where e.codigoestudiante=".$_SESSION['codigo']." and e.codigocarrera=c.codigocarrera";
                        $modalidad=$sala->query($query_modalidad);
                        $totalRows_modalidad = $modalidad->RecordCount();
                        $row_modalidad=$modalidad->fetchRow();

		$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion 
		FROM
                votacion v
                WHERE
        	v.codigoestado=100
                and v.idtipocandidatodetalleplantillavotacion=3
                AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
                 ";
		}	
		$rutabasevot="../../";
	}
	elseif ($_SESSION['rol']==2){
		
		$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
		votacion v
		WHERE
		v.codigoestado=100
		and v.idtipocandidatodetalleplantillavotacion=1
		AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
		";
		$rutabasevot="../";
	}

	if ($_SESSION['rol']==1 && $_SESSION['MM_Username']!='padre'){
	$operacion_votacion=$sala->query($query_votacion);
	$row_operacion_votacion=$operacion_votacion->fetchRow();
	$idvotacion=$row_operacion_votacion['idvotacion'];
	}
	elseif ($_SESSION['rol']==2){
		$operacion_votacion=$sala->query($query_votacion);
                $row_operacion_votacion=$operacion_votacion->fetchRow();
                $totalRows_votacion=$operacion_votacion->RecordCount();
                //$idvotacion=$row_operacion_votacion['idvotacion'];
		
		if($totalRows_votacion > 0){
		  $query_sitdocente="select * from docentesvoto where numerodocumento=".$_SESSION['codigodocente']."";
		  $sitdocente=$sala->query($query_sitdocente);
		  $totalRows_sitdocente = $sitdocente->RecordCount();
		  $row_operacion=$sitdocente->fetchRow();

		  if($totalRows_sitdocente ==0){
		  echo '<script language="JavaScript">alert("No tiene una Facultad asociada para la jornada de Votación, por favor acérquese a la Dirección de Tecnología")</script>';
		  }
		  else{  
		  $idvotacion=$row_operacion_votacion['idvotacion'];
		  //echo $codigocarrera=$row_sitdocente['codigocarrera'];

		  }
                }
	}

	if(!empty($idvotacion)){ ?>
<link rel="stylesheet" href="<?php echo $rutabasevot ?>/../../js/jquery.countdown/jquery.countdown.css">
<style>
    .is-countdown{
        background-color: #fff;
        border:0; 
        display:inline;
    }
    .countdown-row{
        display: inline;
    } 
    .countdown-amount{
        font-size:1em;
        font-weight:normal;
    }
   
}
</style>
<script src="<?php echo $rutabasevot ?>/../../js/jquery.js"></script>
<script src="<?php echo $rutabasevot ?>/../../js/jquery.countdown/jquery.plugin.js"></script>
<script src="<?php echo $rutabasevot ?>/../../js/jquery.countdown/jquery.countdown.js"></script>
<script src="<?php echo $rutabasevot ?>/../../js/jquery.countdown/jquery.countdown-es.js"></script>
<script language="javascript">
    $(function () {
            var austDay = new Date("<?php echo date('M j, Y H:i:s O', strtotime($row_operacion_votacion['fechafinalvotacion'])); ?>");
            //austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
            $('#timer').countdown($.extend({until: austDay, serverSync: serverTime, description: 'para que finalice la votación.',
            padZeroes: false, compact: true, layout:'{d<}{dn} días, {d>}'+ '{hn} horas, {mn} minutos y {sn} segundos {desc}',
            onExpiry: acaboVotacion
        },$.countdown.regionalOptions['es']));
    });
    
    function serverTime() { 
        var time = null; 
        $.ajax({url: '<?php echo $rutabasevot ?>serverTime.php', 
            async: false, dataType: 'text', 
            success: function(text) { 
                time = new Date(text); 
            }, error: function(http, message, exc) { 
                time = new Date(); 
        }}); 
        return time; 
    }
    
    function acaboVotacion() { 
        $("table#votacion").html("<td style='font-size:16px;font-weight:bold;'>Ha finalizado la jornada de votación.</td>"); 
    }

	</script>
<?php
	$_SESSION['fecha_final']=$row_operacion_votacion['fechafinalvotacion'];
	if($_SESSION['rol']==1 && $_SESSION['MM_Username']!='padre'){
		if($totalRows_sitestudiante==0){
		$tipovotante='estudiante';
		}
		else{
		$tipovotante='egresado';
		}
		$query_numerodocumento="SELECT eg.numerodocumento, e.codigocarrera
		FROM estudiante e, estudiantegeneral eg
		WHERE
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND e.codigoestudiante='".$_SESSION['codigo']."'
		";
		$operacion=$sala->query($query_numerodocumento);
		$row_operacion=$operacion->fetchRow();
		$numerodocumento=$row_operacion['numerodocumento'];

	}
	elseif ($_SESSION['rol']==2){
		$tipovotante='docente';
		$numerodocumento=$_SESSION['codigodocente'];
	}

	$codigocarrera=$row_operacion['codigocarrera'];
	$modalidadacademica=$row_modalidad['codigomodalidadacademica'];
	if(!empty($numerodocumento)){
		 $query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) as votos FROM
		votacion v, votantesvotacion vv
		WHERE
		v.codigoestado='100'
		AND vv.codigoestado='100'
		AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
		AND v.idvotacion=vv.idvotacion
		and v.idvotacion='".$idvotacion."'
		AND vv.numerodocumentovotantesvotacion='$numerodocumento'
		";
		$operacion_votacion_vigente=$sala->query($query_votacion_vigente);
		$row_operacion_votacion_vigente=$operacion_votacion_vigente->fetchRow();
		$cantVotos=$row_operacion_votacion_vigente['votos'];
		if($cantVotos==0){
				$_SESSION['datosvotante']=array('codigoestudiante'=>$_SESSION['codigo'],'numerodocumento'=>$numerodocumento,'codigocarrera'=>$codigocarrera,'tipovotante'=>$tipovotante,'cantVotos'=>$cantVotos,'idvotacion'=>$idvotacion,'modalidadacademica'=>$modalidadacademica);
		}
	}
	}

}

if($_SESSION['rol']=='1' && $_SESSION['MM_Username']!='padre'){

  $query_nuevos="SELECT ee.codigoestudiante, ee.codigoperiodo
  FROM estudianteestadistica ee, carrera c, estudiante e
  where e.codigoestudiante = ".$_SESSION['codigo']." and e.codigocarrera=c.codigocarrera
  and ee.codigoestudiante=e.codigoestudiante
  and ee.codigoperiodo = ".$_SESSION['codigoperiodosesion']."
  and ee.codigoprocesovidaestudiante= 400
  and ee.codigoestado like '1%'";
  $nuevos=$sala->query($query_nuevos);
  $totalRows_nuevos = $nuevos->RecordCount();
  $row_nuevos=$nuevos->fetchRow();

  if($totalRows_nuevos !=0){  
  $estudiantenuevo=true;
  }
}

if($_SESSION['rol']=='2'){

  $esdocente=true;
}


?><script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<body oncontextmenu="return false">
<?php
if(empty($idvotacion) && empty($estudiantenuevo) && empty($esdocente)){ ?>
<div id="bienvenidaIMG" style="position:absolute; width:200px; height:115px; z-index:1; top: 26px; left: 29px;"><img src="imagesAlt2/serviciosenlinea_foto.jpg" width="311" height="361"></div>
<div id="Layer1" style="position:absolute; left:566px; top:391px; width:43px; height:42px; z-index:3"><span class="Estilo19"></span></div>
<p><br>
  <br>
</p>
<div id="bienvenidaTEXTO" style="position:relative;width:630px; z-index:2; left: 370px; top: -20px; text-align:justify; background-color:#EDF0D5">
        <font color="#9DA242" size="5"><b>Servicio al Usuario</b></font>
        <br></div>
<div style="position:relative;width:630px; z-index:2; left: 370px; top: -10px; text-align:justify;">
        <font color="#6D6D6F" size="3">
        
        Con el propósito de brindar un servicio integral en lo funcional y técnico de los sistemas de información de la Universidad (SALA, aulas virtuales, wi-fi, correo electrónico, entre otros), comuníquese a la mesa de servicio PBX 6489000 Ext 1555, donde será atendido en el siguiente horario:<br><br>
        Lunes a viernes: 7:00 a.m.- 6:00 p.m.
        <br>
        Sábados: 7:00 a.m. - 5:00 p.m.
        <br><br>
        Adicionalmente, a través del correo electrónico <font color="#9DA242" size="3">mesadeservicio@unbosque.edu.co</font>, usted podrá solicitar servicios las 24 horas del día y como respuesta recibirá un número de caso automático para ser atendido el siguiente día hábil.
        </font>
</div>

<?php 
$hoy = strtotime(date("Y-m-d"));
$finMensaje =  strtotime("2014-03-10");

if ($hoy<$finMensaje) { ?>
<div id="bienvenidaTEXTO" style="position:relative;width:630px; z-index:2; left: 370px; top: 10px; text-align:justify; background-color:#EDF0D5">
        <font color="#9DA242" size="5"><b>Elecciones de Congreso y Parlamento Andino</b></font>
        <br></div>
<div style="position:relative;width:630px; z-index:2; left: 370px; top: 20px; text-align:justify;">
        <font color="#6D6D6F" size="3">
        
        ¿Ya sabe si fue elegido como jurado de votación para las elecciones de Congreso y Parlamento Andino que se realizarán el domingo 09 de marzo? 
		LAS SESIONES DE CAPACITACIÓN INICIARON EL PASADO 10 DE FEBRERO. Recuerde que no asistir a la capacitación o a la jornada de votación implica sanciones legales. 
		Toda la información <a href="http://www.uelbosque.edu.co/sites/default/files/boletines/comunicado_interno/temporal/jurados.pdf"><font color="#9DA242" size="3">aquí</font></a>. 
        </font>
</div>
<?php } ?>

<div id="bienvenidaTEXTO2" style="position:absolute; width:300px; height:115px; z-index:3; top: 400px; left: 29px;">
        <p><font color="#9DA242" size="+1">Para realizar su prematricula utilice  Firefox</font> <img  src="../../../imagenes/mozilla.jpeg" height="40"/>  <font color="#9DA242" size="+1"> o Internet Explorer</font> <img  src="../../../imagenes/iexplorer.jpeg" width="30"/><span class="Estilo19"><br><br> Universidad El Bosque en mejoramiento continuo<br>Tu eres clave Participa</span></p>
</div>
<!--
<div id="bienvenidaTEXTO" style="position:absolute; width:200px; height:115px; z-index:2; left: 370px; top: 144px;"><img src="imagesAlt2/serviciosenlinea_texto.gif" width="339" height="188">
        <p><font color="#9DA242" size="+1">Para realizar su prematricula utilice  Firefox</font> <img  src="../../../imagenes/mozilla.jpeg" height="40"/>  <font color="#9DA242" size="+1"> o Internet Explorer</font> <img  src="../../../imagenes/iexplorer.jpeg" width="30"/><span class="Estilo19"><br><br> Universidad El Bosque en mejoramiento continuo<br>Tu eres clave Participa</span></p>
</div>-->
<?php
}

if(!empty($estudiantenuevo) && empty($idvotacion)){ ?>
<p><br>
  <br>
</p>
<div id="bienvenidaTEXTO" style="position:absolute; width:630px; z-index:2; left: 29px; top: 30px; text-align:justify; background-color:#EDF0D5">
        <font color="#9DA242" size="5"><b>Mensaje de Interes</b></font>
        <br></div>
<div id="bienvenidaTEXTO" style="position:absolute; width:630px; z-index:2; left: 29px; top: 70px; text-align:justify;">
        <font color="#6D6D6F" size="3">
        
        "Nos interesa que te vaya bien en la Universidad. 
	<br>
	Para conocer mejor a nuestros estudiantes y poder ayudarte a estudiar mejor, encontrarás unas preguntas sencillas (no te preocupes que no son de conocimientos) en el siguiente enlace":
        <br>        
        <br>
        <font color="#9DA242" size="3"><a href="http://ubosquemoodle.unbosque.edu.co/moodle/mod/feedback/view.php?id=482" target="_blank">Haz Clic Aquí</a></font> 
        </font>
</div>

<!--
<div id="bienvenidaTEXTO" style="position:absolute; width:200px; height:115px; z-index:2; left: 370px; top: 144px;"><img src="imagesAlt2/serviciosenlinea_texto.gif" width="339" height="188">
        <p><font color="#9DA242" size="+1">Para realizar su prematricula utilice  Firefox</font> <img  src="../../../imagenes/mozilla.jpeg" height="40"/>  <font color="#9DA242" size="+1"> o Internet Explorer</font> <img  src="../../../imagenes/iexplorer.jpeg" width="30"/><span class="Estilo19"><br><br> Universidad El Bosque en mejoramiento continuo<br>Tu eres clave Participa</span></p>
</div>-->
<?php
}
if(!empty($esdocente)){ ?>
<p><br>
  <br>
</p>

<div id="bienvenidaTEXTO" style="width:630px; z-index:2; left: 29px; top: 30px; text-align:justify;" >
 <a href="https://docs.google.com/forms/d/e/1FAIpQLSfxr6xQLsLoyJWCX5C7xoyq5y458FEejd0agvrBSxGPclWWEw/viewform" target="_blank"><img src="../evaluacionasignaturas20172.jpg" ></a></td>
<br></div>
<?php
}


if(!empty($idvotacion)){?>
<p><br>
<span class="Estilo1"><?php echo $row_operacion_votacion['descripcionvotacion']?><br>
Periodo (<?php list($ano,$mes,$fecha)=explode("-",$row_operacion_votacion['fechainiciovigenciacargoaspiracionvotacion']);echo $ano?> a <?php echo ($ano+1);?>) </span><br>
<ul>
  <li>El plazo para votar va comprendido entre <?php list($fecha_ini,$hora_ini)=explode(" ",$row_operacion_votacion['fechainiciovotacion']);echo $fecha_ini?> a las <?php echo $hora_ini?> y <?php list($fecha_fin,$hora_fin)=explode(" ",$row_operacion_votacion['fechafinalvotacion']); echo $fecha_fin;?> a las <?php echo $hora_fin?></li>
  <li>Quedan <div id="timer"></div></li>
</ul>
</p>
<table width="500" border="0" id="votacion">
  <tr><?php if($cantVotos==0){?>
    <td width="154"><div align="right"><br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <a href="<?php echo $rutabasevot ?>../votaciones/datosVotacion.php"><img src="<?php echo $rutabasevot ?>vote.jpg" width="110" height="78"></a></td>
    <td width="330"><div align="center" id="bienvenida"><a href="<?php echo $rutabasevot ?>../votaciones/datosVotacion.php"><img src="<?php echo $rutabasevot ?>urna.gif" width="200" height="211"></a></div></td>
  <?php }else{echo "<td style='font-size:16px;font-weight:bold;'>Usted ya votó. Gracias por su voto.</td>";}?>
    </tr>
</table>
<p>&nbsp; </p>
<?php } ?>   
</body>
</html>