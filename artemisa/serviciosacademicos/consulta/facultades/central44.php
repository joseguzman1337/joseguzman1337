<?php
session_start();
//phpinfo();
$rutaado="../../funciones/adodb/";
require_once('../../Connections/salaado-pear.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script LANGUAGE="JavaScript1.1">
function derecha(e) {
	/*if (navigator.appName == 'Netscape' && (e.which == 3 || e.which == 2)){
		alert('Botón derecho inhabilitado');
		return false;
	}

	else if (navigator.appName == 'Microsoft Internet Explorer' && (event.button == 2)){
		alert('Botón derecho inhabilitado');
	}*/
}
document.onmousedown=derecha;
</script>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<title>Servicios Académicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.Estilo13 {
	font-family: Tahoma;
	font-size: x-small;
	font-weight: bold;
}
-->
</style>
<style type="text/css">
<!--
.Estilo16 {color: #000000}
body {
	margin-top: 0px;
	margin-left: 0px;
}
.Estilo17 {color: #003366}
-->
</style>
<?php
if($_SESSION['rol']=='1'||$_SESSION['rol']=='2')
{


	if($_SESSION['rol']==1){
		$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
		votacion v
		WHERE
		v.codigoestado=100
		and v.idtipocandidatodetalleplantillavotacion=2
		AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
		";
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
	
	$operacion_votacion=$sala->query($query_votacion);
	$row_operacion_votacion=$operacion_votacion->fetchRow();
	$idvotacion=$row_operacion_votacion['idvotacion'];

	if(!empty($idvotacion)){?>
	<script language="javascript">
	function createRequestObject() {
		var ro;
		var browser = navigator.appName;
		if(browser == 'Microsoft Internet Explorer') {
			ro = new ActiveXObject("Microsoft.XMLHTTP");
		} else {
			ro = new XMLHttpRequest();
		}
		return ro;
	}

	var http = createRequestObject();
	function sndReq(action) {
		http.open('get', '<?php echo $rutabasevot ?>centralTimer.php');
		http.onreadystatechange = handleResponse;
		http.send(null);
	}

	function handleResponse() {
		if(http.readyState == 4) {
			var response = http.responseText;
			document.getElementById('timer').innerHTML = response;
		}
	}
	setInterval('sndReq()', 1000);

	</script>

	
	<?php 
	$_SESSION['fecha_final']=$row_operacion_votacion['fechafinalvotacion'];
	if($_SESSION['rol']==1){
		$tipovotante='estudiante';
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
			$_SESSION['datosvotante']=array('codigoestudiante'=>$_SESSION['codigo'],'numerodocumento'=>$numerodocumento,'codigocarrera'=>$codigocarrera,'tipovotante'=>$tipovotante,'cantVotos'=>$cantVotos,'idvotacion'=>$idvotacion);
		}
	}
	}

}

?>

</head>
<body oncontextmenu="return false">
<?php
if(empty($idvotacion)){ ?>
<div id="bienvenidaIMG" style="position:absolute; width:200px; height:115px; z-index:1; top: 26px; left: 29px;"><img src="imagesAlt2/serviciosenlinea_foto.jpg" width="311" height="361"></div>
<br>
<br>
<div id="bienvenidaTEXTO" style="position:absolute; width:200px; height:115px; z-index:2; left: 370px; top: 199px;"><img src="imagesAlt2/serviciosenlinea_texto.gif" width="339" height="188"></div>
<?php 
}
if(!empty($idvotacion)){?>
<p><br>
<span class="Estilo1"><?php echo $row_operacion_votacion['descripcionvotacion']?><br>
Periodo (<?php list($ano,$mes,$fecha)=explode("-",$row_operacion_votacion['fechainiciovigenciacargoaspiracionvotacion']);echo $ano?> a <?php echo $ano;?>) </span><br>
<ul>
  <li>El plazo para votar va comprendido entre <?php list($fecha_ini,$hora_ini)=explode(" ",$row_operacion_votacion['fechainiciovotacion']);echo $fecha_ini?> a las <?php echo $hora_ini?> y <?php list($fecha_fin,$hora_fin)=explode(" ",$row_operacion_votacion['fechafinalvotacion']); echo $fecha_fin;?> a las <?php echo $hora_fin?></li>
  <li><div id="timer"></div></li>
</ul>
</p>
<table width="500" border="0">
  <tr><?php if($cantVotos==0){?>
    <td width="154"><div align="right"><br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <a href="<?php echo $rutabasevot ?>../votaciones/datosVotacion.php"><img src="<?php echo $rutabasevot ?>vote.jpg" width="110" height="78"></a></td><?php }else{echo "Usted ya votó";}?>
    <td width="330"><div align="center" id="bienvenida"><img src="<?php echo $rutabasevot ?>urna.jpg" width="200" height="211"></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<?php }?>
</body>
</html>
