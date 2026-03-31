<?php
require_once(realpath(dirname(__FILE__)."/../../../../sala/includes/adaptador.php"));

/**
 * Si la aplicacion se corre en un entorno local o de pruebas se activa la visualizacion 
 * de todos los errores de php
 */
$pos = strpos($Configuration->getEntorno(), "local");
if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"||$pos!==false){
    //@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    //@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    /**
     * Se incluye la libreria Kint para hacer debug controlado de variables y objetos
     */
    require_once (PATH_ROOT.'/kint/Kint.class.php');
}
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php' );
require_once('../../../funciones/errores_creacionestudiante.php' );
require_once('../../../funciones/funcionip.php' );
$ruta="../../../";
require_once($ruta."Connections/conexionldap.php");
require_once($ruta."funciones/clases/autenticacion/claseldap.php");

session_start();
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];
mysql_select_db($database_sala, $sala);
session_start();

$usuarioeditar = $_GET['usuarioeditar'];
$txtActualizaDatos = $_GET['txtActualizaDatos'];
$ip = "SIN DEFINIR";
$ip = tomarip();
if (isset($_GET['codigocreado'])) {
    $_SESSION['codigo'] = $codigoestudiante = $_GET['codigocreado'];
} elseif (isset($_SESSION['codigo'])) {
    $codigoestudiante = $_SESSION['codigo'];
}
if ($_REQUEST['regresar']) {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=menucrearnuevoestudiante.php'>";
    exit();
}


$query_dataestudiante = "SELECT eg.*, c.nombrecarrera,d.nombredocumento, e.codigojornada, j.nombrejornada, e.semestre, e.numerocohorte, e.codigotipoestudiante,
t.nombretipoestudiante, e.codigosituacioncarreraestudiante, s.nombresituacioncarreraestudiante,g.nombregenero,e.codigoestudiante,c.codigocarrera
FROM estudiante e, carrera c,documento d, jornada j, tipoestudiante t, situacioncarreraestudiante s, genero g, estudiantegeneral eg
WHERE e.codigocarrera = c.codigocarrera
AND eg.tipodocumento = d.tipodocumento
AND e.codigojornada = j.codigojornada
AND e.codigotipoestudiante = t.codigotipoestudiante
AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
AND eg.codigogenero = g.codigogenero
AND e.codigoestudiante = '$codigoestudiante'
and eg.idestudiantegeneral = e.idestudiantegeneral";
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);
$idestudiantegeneral = $row_dataestudiante['idestudiantegeneral'];
$numerodocumentoinicial = $row_dataestudiante['numerodocumento'];
/*$txtActualizaDato = $row_dataestudiante['EstadoActualizaDato'];
if( $txtActualizaDato != 2 ){
	$datoActualizado = "readonly='readonly'";
}else{
	$datoActualizado = "";
}*/
//echo  "<h1>asdasd".$row_planestudios['idplanestudio']."</h1>";

if($totalRows_dataestudiante != "")
{
	$formulariovalido = 1;
//mysql_select_db($database_sala, $sala);
	$query_jornadas = "SELECT * FROM jornada";
	$jornadas = mysql_query($query_jornadas, $sala) or die(mysql_error());
	$row_jornadas = mysql_fetch_assoc($jornadas);
	$totalRows_jornadas = mysql_num_rows($jornadas);
	//mysql_select_db($database_sala, $sala);
	$query_tipoestudiante = "SELECT * FROM tipoestudiante";
	$tipoestudiante = mysql_query($query_tipoestudiante, $sala) or die(mysql_error());
	$row_tipoestudiante = mysql_fetch_assoc($tipoestudiante);
	$totalRows_tipoestudiante = mysql_num_rows($tipoestudiante);

	$query_situacionestudiante = "SELECT *
	FROM situacioncarreraestudiante
	where codigosituacioncarreraestudiante not like '4%'
	";
	$situacionestudiante = mysql_query($query_situacionestudiante, $sala) or die(mysql_error());
	$row_situacionestudiante = mysql_fetch_assoc($situacionestudiante);
	$totalRows_situacionestudiante = mysql_num_rows($situacionestudiante);
	//mysql_select_db($database_sala, $sala);
    $query_carreras = "SELECT codigocarrera, nombrecarrera FROM carrera where codigocarrera = '".$_SESSION['codigofacultad']."' order by 2 asc";
	$carreras = mysql_query($query_carreras, $sala) or die(mysql_error());
	$row_carreras = mysql_fetch_assoc($carreras);
	$totalRows_carreras = mysql_num_rows($carreras);
	//mysql_select_db($database_sala, $sala);

	$query_documentos = "SELECT * FROM documento where codigoestado like '1%'";
    $documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
	$row_documentos = mysql_fetch_assoc($documentos);
	$totalRows_documentos = mysql_num_rows($documentos);
	//mysql_select_db($database_sala, $sala);

	// SELECT * FROM planestudio where codigocarrera = '".$_SESSION['codigofacultad']."'
	$query_planestudios = "SELECT * FROM planestudio where codigocarrera = '".$row_dataestudiante['codigocarrera']."'
    and codigoestadoplanestudio like '1%'";
	$planestudios = mysql_query($query_planestudios, $sala) or die("$query_planestudios");
	$row_planestudios = mysql_fetch_assoc($planestudios);
	$totalRows_planestudios = mysql_num_rows($planestudios);
	//echo "$query_planestudios<br>";

	$query_selgenero = "select codigogenero, nombregenero
	from genero";
	$selgenero = mysql_query($query_selgenero, $sala) or die("$query_selgenero");
	$totalRows_selgenero = mysql_num_rows($selgenero);
	$row_selgenero = mysql_fetch_assoc($selgenero);
	$query_seldecision = "select codigodecisionuniversidad, nombredecisionuniversidad
	from decisionuniversidad";
	$seldecision = mysql_query($query_seldecision, $sala) or die("$query_seldecision");
	$totalRows_seldecision = mysql_num_rows($seldecision);

	$query_seldecisionestudiante = "SELECT *
	FROM estudiantedecisionuniversidad e,decisionuniversidad d
    WHERE e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."'
    and e.codigodecisionuniversidad = d.codigodecisionuniversidad
    and e.codigoestadoestudiantedecisionuniversidad like '1%'
    order by nombredecisionuniversidad";
    //echo $query_seldecisionestudiante;
	$seldecisionestudiante = mysql_query($query_seldecisionestudiante, $sala) or die("$query_seldecisionestudiante");
	$row_seldecisionestudiante = mysql_fetch_assoc($seldecisionestudiante);
	$totalRows_seldecisionestudiante = mysql_num_rows($seldecisionestudiante);

	$query_dataestudianteplan = "select *
	from planestudioestudiante pee, planestudio p
	where pee.codigoestudiante = '$codigoestudiante'
	and p.idplanestudio = pee.idplanestudio
	and p.codigoestadoplanestudio like '1%'
	and pee.codigoestadoplanestudioestudiante like '1%'";
	//echo $query_dataestudianteplan,"<br>";
	$dataestudianteplan = mysql_query($query_dataestudianteplan, $sala) or die("$query_dataestudiante".mysql_error());
	$row_dataestudianteplan = mysql_fetch_assoc($dataestudianteplan);
	$totalRows_dataestudianteplan = mysql_num_rows($dataestudianteplan);
	//echo  "<h1>asdasd".$row_planestudios['idplanestudio']."</h1>";
?>


<html>
<head>
<title>Crear Estudiante</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- <script src="//code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script> -->
</head>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<body>
<form name="form1" id="editarestudianteForm" >
    <p align="center" class="Estilo3">EDITAR ESTUDIANTE</p>
    <p><input type="hidden" id="txtCodigoCreado" name="txtCodigoCreado" value="<?php echo $codigoestudiante; ?>" /></p>
    <table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2" align="center">Facultad<span class="Estilo4">*</span></td>
        <td colspan="2" class="Estilo1" align="center"><?php echo $row_dataestudiante['nombrecarrera'] ?></td>
		<td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Plan de Estudio<span class="Estilo4">*</span></td>
		<td colspan="2" align="center"><span class="Estilo1">
      <?php
	if($_SESSION['MM_Username'] == 'dirsecgeneral')
	{ // if session usuario
		if($row_dataestudianteplan['idplanestudio'] <> "")
		{
			$planestudiante =  $row_dataestudianteplan['idplanestudio'];
		}
	else
		{
			$planestudiante = 1;
		}
?>
          <input type="hidden" name="planestudio" value="<?php echo  $planestudiante;?>">
       <?php
		echo  $planestudiante;
	}
	else
	{
		// Mira que el estudiante no tenga prematricula para el periodo activo, si la tiene ya no le permite cambiar el plan de estudio
		$query_prematriculaviva = "select distinct e.codigoestudiante
		from prematricula p, estudiante e, detalleprematricula d, periodo pe
		where p.codigoestudiante = e.codigoestudiante
		and p.idprematricula = d.idprematricula
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%')
		and pe.codigoperiodo = p.codigoperiodo
		and pe.codigoestadoperiodo = '3'
		and e.codigoestudiante = '$codigoestudiante'";
		//echo $query_prematriculaviva;
		$prematriculaviva = mysql_query($query_prematriculaviva, $sala) or die("$query_prematriculaviva");
		$row_prematriculaviva = mysql_fetch_assoc($prematriculaviva);
		$totalRows_prematriculaviva = mysql_num_rows($prematriculaviva);
		if($totalRows_prematriculaviva == "")
		{
			$query_prematriculaviva = "select distinct e.codigoestudiante
			from prematricula p, estudiante e, detalleprematricula d, periodo pe
			where p.codigoestudiante = e.codigoestudiante
			and p.idprematricula = d.idprematricula
			and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
			and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%')
			and pe.codigoperiodo = p.codigoperiodo
			and pe.codigoestadoperiodo = '1'
			and e.codigoestudiante = '$codigoestudiante'";
			///echo $query_prematriculaviva;
			$prematriculaviva = mysql_query($query_prematriculaviva, $sala) or die("$query_prematriculaviva");
			$row_prematriculaviva = mysql_fetch_assoc($prematriculaviva);
			$totalRows_prematriculaviva = mysql_num_rows($prematriculaviva);
		}
    //echo $query_prematriculaviva;
	//print_r($row_planestudios);
	if($totalRows_prematriculaviva == "")
		{
?>
<select name="planestudio">
 <?php
			if($totalRows_dataestudianteplan == "")
			{
?>

           <option value="0" <?php if (!(strcmp(0,$row_dataestudianteplan['idplanestudio']))) {echo "SELECTED";} ?>>Seleccionar ..........</option>
            <?php
			}

		do
		{
			//if($row_planestudios['idplanestudio'] != $row_dataestudianteplan['idplanestudio'])
				//{
?>
            <option value="<?php echo $row_planestudios['idplanestudio'];?>"<?php if(!(strcmp($row_planestudios['idplanestudio'],$row_dataestudianteplan['idplanestudio']))) {echo "SELECTED";} ?>><?php echo $row_planestudios['nombreplanestudio']?></option>
 <?php
				//}
    	}
			while ($row_planestudios = mysql_fetch_assoc($planestudios));
			$totalRows_planestudios = mysql_num_rows($planestudios);
			if($totalRows_planestudios > 0)
			{
    			mysql_data_seek($planestudios, 0);
				$row_planestudios = mysql_fetch_assoc($planestudios);

			}
?>
          </select>
          <?php
		//echo  "<h1>asdasd".$row_planestudios['idplanestudio']."</h1>";
		}
		else
		{
?>
          <input type="hidden" name="planestudio" value="<?php echo  $row_dataestudianteplan['idplanestudio'];?>">
          <?php
			if(isset($row_dataestudianteplan['nombreplanestudio']))
		  	{
				echo $row_dataestudianteplan['nombreplanestudio'];
			}
			else
			{
				echo "No tiene";
			}
		}
	}
	//exit();
	// if session usuario
?>

        </span></font><span class="Estilo1"><font size="2" face="Tahoma">
<?php
	echo "<span class='Estilo4'>";
 	if($_SESSION['MM_Username'] <> 'dirsecgeneral')
  	{
		if(isset($_REQUEST['planestudio']))
		{
			$planestudio = $_REQUEST['planestudio'];
			$imprimir = true;
			$prequerido = validar($planestudio,"combo",$error1,$imprimir);
			//$formulariovalido = $formulariovalido*$prequerido;
			if($_REQUEST['planestudio'] == '1')
			{
				echo "Seleccionar plan de estudio";
				//$formulariovalido = 0;
			}
		}
   	}
	echo "</span>";
?>
        </font><font size="2" face="Tahoma"></font></span> </div></td>
	  </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2" align="center">Apellidos<span class="Estilo4">*</span></td>
        <td colspan="1" class="Estilo1">
          <input name="apellidos" type="text" id="apellidos" value="<?php if(isset($_REQUEST['apellidos'])) echo $_REQUEST['apellidos']; else echo $row_dataestudiante['apellidosestudiantegeneral'];?>" size="30" >
<?php
	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['apellidos']))
	{
		$apellidos = $_REQUEST['apellidos'];
		$imprimir = true;
		$arequerido = validar($apellidos,"requerido",$error1,$imprimir);
		//$anombre = validar($apellidos,"nombre",$error6,$imprimir);
		$formulariovalido = $formulariovalido*$arequerido;
	}
	echo "</span>";
?></td>
        <td align="center" bgcolor="#C5D5D6" class="Estilo2">Nombres<span class="Estilo4">*</span></td>
        <td colspan="1"><div align="left"><font size="1" face="tahoma">
            <input name="nombres" type="text" id="nombres2" value="<?php if(isset($_REQUEST['nombres'])) echo $_REQUEST['nombres']; else echo $row_dataestudiante['nombresestudiantegeneral'];?>" size="30"  >
          </font><font size="2" face="Tahoma">
   <?php
	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['nombres']))
	{
       	$nombres = $_REQUEST['nombres'];
		$imprimir = true;
		$nrequerido = validar($nombres,"requerido",$error1,$imprimir);
		//$nnombre = validar($nombres,"nombre",$error6,$imprimir);
		$formulariovalido = $formulariovalido*$nrequerido;
	}
	echo "</span>";
?>
        </font><font size="1" face="tahoma">        </font></div></td>
	  <td bgcolor="#C5D5D6" colspan="1" class="Estilo2" align="center">Fecha de Nacimiento (aaaa-mm-dd)<span class="Estilo4">*</span></td>
      <td colspan="1"><div align="left"><font size="1" face="tahoma">
          <input name="fnacimiento" type="text" size="10" value="<?php if(isset($_REQUEST['fnacimiento'])) echo $_REQUEST['fnacimiento']; else echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_dataestudiante['fechanacimientoestudiantegeneral']); ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
          </font><font size="1" face="Tahoma"><font color="#FF0000">
 <?php
	if(isset($_REQUEST['fnacimiento']))
	{
		$fnacimiento = $_REQUEST['fnacimiento'];
		$imprimir = true;
		$ffecha = validar($fnacimiento,"fechaant",$error3,$imprimir,$fnacimiento[0]);
		$formulariovalido = $formulariovalido*$ffecha;
	}
?>
        </font></font><font size="1" face="tahoma">		 </font></div></td>
    </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2" align="center">T. Documento<span class="Estilo4">*</span></td>
       <td colspan="1" class="Estilo1"><div align="center"><font size="2" face="Tahoma">
		  <div align="left">
		    <select name="tipodocumento">
		    <option value="<?php echo $row_dataestudiante['tipodocumento'] ?>" selected><?php echo $row_dataestudiante['nombredocumento']?></option>
 <?php
	do
     {
	  if($row_dataestudiante['tipodocumento'] != $row_documentos['tipodocumento'] && $row_documentos['nombredocumento'] != "Seleccionar")
		{
?>
  			    <option value="<?php echo $row_documentos['tipodocumento']?>"<?php if (!(strcmp($row_documentos['tipodocumento'], $_REQUEST['tipodocumento']))) {echo "SELECTED";} ?>><?php echo $row_documentos['nombredocumento']?></option>
<?php
		}
	}
	while($row_documentos = mysql_fetch_assoc($documentos));
	$rows = mysql_num_rows($documentos);
if($rows > 0)
	{
		mysql_data_seek($documentos, 0);
		$row_documentos = mysql_fetch_assoc($documentos);
	}
?>
		      </select><input type='hidden' name='tipodocumentoold' value='<?php echo $row_dataestudiante['tipodocumento'] ?>'>
		    <font size="2" face="Tahoma">
<?php
	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['tipodocumento']))
	{
		$tipodocumento = $_REQUEST['tipodocumento'];
		$imprimir = true;
		$tdrequerido = validar($tipodocumento,"combo",$error1,$imprimir);
		$formulariovalido = $formulariovalido*$tdrequerido;
	}
	echo "</span>";
?>
  </font> </div></td>
  <td align="center" bgcolor="#C5D5D6" class="Estilo2">N&uacute;mero<span class="Estilo4">*</span></td>
  <td colspan="1" align="center"><div align="left">
 <input name="documento" type="text" id="documento2" value="<?php if(isset($_REQUEST['documento'])) echo $_REQUEST['documento']; else echo $row_dataestudiante['numerodocumento'];?>" size="20" >
 <input name="documentoold" type="hidden" value="<?php if(isset($_REQUEST['documento'])) echo $_REQUEST['documento']; else echo $row_dataestudiante['numerodocumento'];?>">
<?php
	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['documento']))
	{
		$documento = $_REQUEST['documento'];
		$imprimir = true;
		$ndrequerido = validar($documento,"requerido",$error1,$imprimir);
		$ndnumero = validar($documento,"numero",$error2,$imprimir);
		$formulariovalido = $formulariovalido*$ndrequerido*$ndnumero;
	}
	echo "</span>";
?>
          </div></td>
		<td bgcolor="#C5D5D6" align="center" class="Estilo2">Expedido en (lugar)<span class="Estilo4">*</span></td>
        <td colspan="1" align="left" class="Estilo1">
           <input name="expedido" type="text" id="expedido3" value="<?php if(isset($_REQUEST['expedido'])) echo $_REQUEST['expedido']; else echo $row_dataestudiante['expedidodocumento'];?>" size="19" >
  <?php
	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['expedido']))
	{
		$expedido = $_REQUEST['expedido'];
		$imprimir = true;
		$erequerido = validar($expedido,"requerido",$error1,$imprimir);
		//$enombre = validar($expedido,"ciudad",$error6,$imprimir);
		$formulariovalido = $formulariovalido*$erequerido;
	}
	echo "</span>";
?>
</td>
 	</tr>
	 <tr>
       <td bgcolor="#C5D5D6" class="Estilo2" align="center">Jornada<span class="Estilo4">*</span></td>
        <td class="Estilo1" align="center"><div align="left">
  <select name="jornada" id="select10">
		    <option value="<?php echo $row_dataestudiante['codigojornada'] ?>" selected><?php echo $row_dataestudiante['nombrejornada']?></option>
<?php
	do
	{
		if($row_dataestudiante['codigojornada'] != $row_jornadas['codigojornada'])
		{
?>
            <option value="<?php echo $row_jornadas['codigojornada']?>"<?php if (!(strcmp($row_jornadas['codigojornada'], $_REQUEST['jornada']))) {echo "SELECTED";} ?>><?php echo $row_jornadas['nombrejornada']?></option>
<?php
		}
	} while ($row_jornadas = mysql_fetch_assoc($jornadas));
	$rows = mysql_num_rows($jornadas);
	if($rows > 0)
	{
		mysql_data_seek($jornadas, 0);
		$row_jornadas = mysql_fetch_assoc($jornadas);
	}
?>
           </select>
<?php
	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['jornada']))
	{
		$jornada = $_REQUEST['jornada'];
		$imprimir = true;
		$jrequerido = validar($jornada,"combo",$error1,$imprimir);
		$formulariovalido = $formulariovalido*$jrequerido;
	}
	echo "</span>";
?>
            </div></td>
        <td colspan="1" align="center" bgcolor="#C5D5D6" class="Estilo2">Semestre<span class="Estilo4">*</span></td>
       <td>
         <select name="semestre">
            <option value="<?php echo $row_dataestudiante['semestre'] ?>" selected><?php echo $row_dataestudiante['semestre']?></option>
<?php

	for ($i=1;$i<13;$i++)
	{
		if($row_dataestudiante['semestre'] != $i)
		{
?>
            <option value="<?php echo $i;?>"<?php if (!(strcmp($i, $_REQUEST['semestre']))) {echo "SELECTED";} ?>><?php echo $i;?></option>
<?php
		}

	}
?>
<select>
<?php
	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['semestre']))
	{
		$semestre = $_REQUEST['semestre'];
		$imprimir = true;
	    $srequerido = validar($semestre,"combo",$error1,$imprimir);
		$formulariovalido = $formulariovalido*$srequerido;
	}
	echo "</span>";
?>
&nbsp;</td>
	<td bgcolor="#C5D5D6" align="center" class="Estilo2">Genero<span class="Estilo4">*</span></td>
        <td colspan="1"><div align="center"><font size="1" face="tahoma">
          <div align="left">
  <select name="genero">
		    <option value="<?php echo $row_dataestudiante['codigogenero'] ?>" selected><?php echo $row_dataestudiante['nombregenero']?></option>
<?php
	do
	{
		if($row_dataestudiante['codigogenero'] != $row_selgenero['codigogenero'])
		{
?>         <option value="<?php echo $row_selgenero['codigogenero']?>"<?php if (!(strcmp($row_selgenero['codigogenero'], $_REQUEST['genero']))) {echo "SELECTED";} ?>><?php echo $row_selgenero['nombregenero']?></option>
 <?php
 		}
	} while ($row_selgenero = mysql_fetch_assoc($selgenero));
	$rows = mysql_num_rows($selgenero);
	if($rows > 0)
	{
	  mysql_data_seek($selgenero, 0);
	  $row_selgenero = mysql_fetch_assoc($selgenero);
    }
?>
      </select>
<?php
	echo "<span class='Estilo4'>";
   if(isset($_REQUEST['genero']))
    {
		$genero = $_REQUEST['genero'];
	    $imprimir = true;
		$grequerido = validar($genero,"combo",$error1,$imprimir);
		$formulariovalido = $formulariovalido*$grequerido;
	}
	echo "</span>";
	
	$query_rot = "SELECT
                            lc.codigocarrera,
                            lc.LugarRotacionCarreraID,
                            ic.NombreInstitucion as lugarRotacionBase,
                            l.LugarRotacionCarreraID AS lugarestudiante 
                    FROM
                            estudiante e
                            INNER JOIN LugarRotacionCarrera lc ON (lc.codigocarrera = e.codigocarrera 
                            AND codigoestado = 100)
                            INNER JOIN InstitucionConvenios ic ON ( lc.lugarRotacionBase = ic.InstitucionConvenioId )
                            LEFT JOIN LugarRotacionCarreraEstudiante l ON l.codigoestudiante = e.codigoestudiante 
                    WHERE
                            e.codigoestudiante = '" . $codigoestudiante . "' 
                    ORDER BY
                            lc.lugarRotacionBase ASC ";
						//echo $query_rot;
    $rot = mysql_query($query_rot, $sala) or die("$query_rot");
    $totalRows_rot = mysql_num_rows($rot);
    $row_rot = mysql_fetch_assoc($rot);
	$hayrotacion=false;
    if (count($row_rot)>0 && $row_rot!==false) {
		$hayrotacion=true;													 
	}
?>
      </div></td>
     </tr>
      <tr>
	  
        <td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Situaci&oacute;n Estudiante</td>
        <td colspan="<?php if($hayrotacion){ echo 1; } else { echo 2; }?>" align="left" class="Estilo1">
<?php
        if (substr($row_dataestudiante['codigosituacioncarreraestudiante'],0,1) <>  4)
	    {
?>
           <select name="situacion" id="situacion" onChange="if(this.value == '400'){ sitgraduado.style.display='';} else {sitgraduado.style.display='none'; }">
           <option value="<?php echo $row_dataestudiante['codigosituacioncarreraestudiante'] ?>" selected><?php echo $row_dataestudiante['nombresituacioncarreraestudiante']?></option>
             <?php
            if($_SESSION['MM_Username'] == "dirsecgeneral")
            {
?>
                <option value="400" onClick="alert('Recuerde que el paso a graduado es delicado, asï¿½ que debe estar seguro de hacerlo')">Graduado</option>
<?php
            }
	do
	{
	  if($row_dataestudiante['codigosituacioncarreraestudiante'] != $row_situacionestudiante['codigosituacioncarreraestudiante'])
		{ 
			$disabled='';	
			$txt_add='';
			if($row_situacionestudiante['codigosituacioncarreraestudiante'] == 108) {
				if($_SESSION['codigofacultad']!=156 && $_SESSION['usuario']!='admintecnologia') {
					$disabled='disabled';	
					$txt_add='(disponible solo para el área de crédito y cartera)';
				}
			}
			if($row_dataestudiante['codigosituacioncarreraestudiante'] != 107)
			{
?>
              <option value="<?php echo $row_situacionestudiante['codigosituacioncarreraestudiante']?>"<?php if (!(strcmp($row_situacionestudiante['codigosituacioncarreraestudiante'], $_REQUEST['situacion']))) {echo "SELECTED";} ?> <?=$disabled?>><?php echo $row_situacionestudiante['nombresituacioncarreraestudiante']." ".$txt_add?></option>
<?php
			}
			else
		    {
				if($row_situacionestudiante['codigosituacioncarreraestudiante'] == 300 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 107 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 113 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 111 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 115)
				{
?>
           	      <option value="<?php echo $row_situacionestudiante['codigosituacioncarreraestudiante']?>"<?php if (!(strcmp($row_situacionestudiante['codigosituacioncarreraestudiante'], $_REQUEST['situacion']))) {echo "SELECTED";} ?> <?=$disabled?>><?php echo $row_situacionestudiante['nombresituacioncarreraestudiante']." ".$txt_add?></option>
           	      <?php
				}
			}
		}
	} while ($row_situacionestudiante = mysql_fetch_assoc($situacionestudiante));
	$rows = mysql_num_rows($situacionestudiante);
	if($rows > 0)
	{
		mysql_data_seek($situacionestudiante, 0);
		$row_situacionestudiante = mysql_fetch_assoc($situacionestudiante);
	}
?>
  </select>
        <div id="sitgraduado" style="display:none">Debe digitar una observación para pasarlo a graduado *
            <input type="text" value="<?php if(isset($_REQUEST['observacionsituacion'])) echo $_REQUEST['observacionsituacion'];  ?>" name="observacionsituacion">
          </div>
<?php
       }// if ($row_dataestudiante['codigosituacioncarreraestudiante'] <> 400 or $row_dataestudiante['codigosituacioncarreraestudiante'] <> 104)
	  else
       {
	     echo $row_dataestudiante['nombresituacioncarreraestudiante'];
	     echo '<input name="situacion" type="hidden" value='.$row_dataestudiante['codigosituacioncarreraestudiante'].'>';
	   }
	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['situacion']))
     {
		$situacion = $_REQUEST['situacion'];
		$imprimir = true;
		$srequerido = validar($situacion,"combo",$error1,$imprimir);
		$formulariovalido = $formulariovalido*$srequerido;
        if($_REQUEST['situacion'] == 400)
        {
            if($_REQUEST['observacionsituacion'] == '' &&  $row_dataestudiante['codigosituacioncarreraestudiante'] != 400)
            {
?>
<script type="text/javascript">
    alert("Debido a que está pasando a graduado debe colocar una observación");
</script>
<?php
                $formulariovalido = 0;
            }
        }
     }
	echo "</span>";
?>
</td>
        <td bgcolor="#C5D5D6" class="Estilo2" align="center">Tipo Estudiante<span class="Estilo4">*</span></td>
        <td colspan="<?php if($hayrotacion){ echo 1; } else { echo 2; }?>" class="Estilo1">
          <font size="1" face="tahoma">
          <select name="tipoestudiante" id="select13">
            <option value="<?php echo $row_dataestudiante['codigotipoestudiante'] ?>" selected><?php echo $row_dataestudiante['nombretipoestudiante']?></option>
<?php
	do
     {
		 if($row_dataestudiante['codigotipoestudiante'] != $row_tipoestudiante['codigotipoestudiante'])
		{
?>
           <option value="<?php echo $row_tipoestudiante['codigotipoestudiante']?>"<?php if (!(strcmp($row_tipoestudiante['codigotipoestudiante'], $_REQUEST['tipoestudiante']))) {echo "SELECTED";} ?>><?php echo $row_tipoestudiante['nombretipoestudiante']?></option>
   <?php
   	   }
	}
	while ($row_tipoestudiante = mysql_fetch_assoc($tipoestudiante));
	$rows = mysql_num_rows($tipoestudiante);
	if($rows > 0)
	{
		mysql_data_seek($tipoestudiante, 0);
		$row_tipoestudiante = mysql_fetch_assoc($tipoestudiante);
    }
?>
          </select>
          </font><font size="2" face="Tahoma">
          <?php

	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['tipoestudiante']))
	{
    	$tipoestudiante = $_REQUEST['tipoestudiante'];
		$imprimir = true;
		$trequerido = validar($tipoestudiante,"combo",$error1,$imprimir);
		$formulariovalido = $formulariovalido*$trequerido;
   }
	echo "</span>";
?>
</td>
<?php if($hayrotacion){ ?>
       <td bgcolor="#C5D5D6" class="Estilo2" align="center">Lugar de Rotación<span class="Estilo4">*</span></td>
        <td class="Estilo1" align="center"><div align="left">
	<select name="lugarRotacion" id="select10">
<?php 
	do
     { 
		$idR =  $row_rot["lugarestudiante"];
		if(isset($_REQUEST["lugarRotacion"])) { $idR = $_REQUEST["lugarRotacion"];}
	 ?>
		<option value="<?php echo $row_rot['LugarRotacionCarreraID']; ?>" <?php if($row_rot['LugarRotacionCarreraID']==$idR){ echo "selected"; } ?>>
		<?php echo $row_rot['lugarRotacionBase']; ?></option>
<?php 
	}
	while ($row_rot = mysql_fetch_assoc($rot)); ?>
    </select>
<?php
	/*echo "<span class='Estilo4'>";
	if(isset($_REQUEST['jornada']))
	{
		$jornada = $_REQUEST['jornada'];
		$imprimir = true;
		$jrequerido = validar($jornada,"combo",$error1,$imprimir);
		$formulariovalido = $formulariovalido*$jrequerido;
	}
	echo "</span>";*/
?>
            </div></td> 
<?php } ?>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2" align="center">Celular</td>
        <td colspan="2" class="Estilo1" align="left">
            <input name="celular" type="text" value="<?php if(isset($_REQUEST['celular'])) echo $_REQUEST['celular']; else echo $row_dataestudiante['celularestudiantegeneral'];?>" size="30">
        </td>
        <td bgcolor="#C5D5D6" align="center" class="Estilo2">E-mail <span class="Estilo4">*</span></td>
        <td colspan="2">
            <input name="email" type="text" id="email3" value="<?php if(isset($_REQUEST['email'])) echo $_REQUEST['email']; else {echo $row_dataestudiante['emailestudiantegeneral'];}?>" size="30">
        </td>
	  </tr>
      <tr>
	  <td height="27" bgcolor="#C5D5D6" class="Estilo2" align="center">Dir. Estudiante<span class="Estilo4">*</span></td>
      <td colspan="5" class="Estilo1" align="left">&nbsp;
	  <INPUT name="direccion1" size="90" readonly onClick="window.open('direccion.php?inscripcion=1','direccion','width=1000,height=300,left=150,top=150,scrollbars=yes')"  value="<?php if(isset($_REQUEST['direccion1'])) echo $_REQUEST['direccion1']; else echo $row_dataestudiante['direccionresidenciaestudiantegeneral'] ; ?>">
      <input name="direccion1oculta" type="hidden" value="<?php if(isset($_REQUEST['direccion1oculta'])) echo $_REQUEST['direccion1oculta']; else echo $row_dataestudiante['direccioncortaresidenciaestudiantegeneral']; ?>">
	  <?php
	  // Set up regular expression strings to evaluate the value of email variable against
$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/'; 
	echo "<span class='Estilo4'>";
	if($_REQUEST['direccion1'] == "" && $_REQUEST['guardar'])
	 {
         echo utf8_decode('<script language="JavaScript">alert("Debe Digitar una Dirección de Residencia"); history.go(-1);</script>');
	 }
	if(($_REQUEST['email'] == "" || !preg_match($regex, $_REQUEST['email'])) && $_REQUEST['guardar'])
	 {
         echo utf8_decode('<script language="JavaScript">alert("Debe digitar una dirección de E-mail válida"); history.go(-1);</script>');
	 }
	echo "</span>";
?>

	  </td>

 </tr>
      <tr><td height="27" bgcolor="#C5D5D6" class="Estilo2" align="center">Tel&eacute;fono<span class="Estilo4">*</span></td>
        <td colspan="2" class="Estilo1" align="left">
		<input name="telefono1" type="text" id="telefono13" value="<?php if(isset($_REQUEST['telefono1'])) echo $_REQUEST['telefono1']; else echo $row_dataestudiante['telefonoresidenciaestudiantegeneral'];?>" size="22">
  <?php
	echo "<span class='Estilo4'>";
	if(isset($_REQUEST['telefono1']))
	{
	  $telefono1 = $_REQUEST['telefono1'];
	  $imprimir = true;
	  $t1requerido = validar($telefono1,"requerido",$error1,$imprimir);
	  $formulariovalido = $formulariovalido*$t1requerido;
	}
	echo "</span>";
?>
		</td>
        <td colspan="1" align="left" bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">Ciudad Residencia<span class="Estilo4">*</span></span>
       </div></td>
       <td colspan="2" align="center" class="Estilo2">
<?php
			$query_ciudad = "select *
			from ciudad c,departamento d
		    where c.iddepartamento = d.iddepartamento
			order by 3";
	        $ciudad = mysql_query($query_ciudad, $sala) or die("$query_ciudad");
	        $totalRows_ciudad= mysql_num_rows($ciudad);
	        $row_ciudad = mysql_fetch_assoc($ciudad);
?>
         <!--  <input name="ciudad1" type="text" id="ciudad15" value="<?php if(isset($_REQUEST['ciudad1'])) echo $_REQUEST['ciudad1']; else echo $row_dataestudiante['ciudadresidenciaestudiantegeneral'];?>" size="19"> -->
          <select name="ciudad1">

          <option value="0" <?php if (!(strcmp("0", $row_dataestudiante['ciudadresidenciaestudiantegeneral']))) {echo "SELECTED";} ?>>Seleccionar</option>
 <?php
		do
		 {
?>
            <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $row_dataestudiante['ciudadresidenciaestudiantegeneral']))) {echo "SELECTED";} ?>><?php echo $row_ciudad['nombreciudad'],"-",$row_ciudad['nombredepartamento'];?></option>

            <?php

                }

				while($row_ciudad = mysql_fetch_assoc($ciudad));
			$rows = mysql_num_rows($ciudad);
			if($rows > 0)

			{
				mysql_data_seek($ciudad, 0);
				$row_ciudad = mysql_fetch_assoc($ciudad);
			}
?>
          </select>
<?php
	echo "<span class='Estilo4'>";
	if($_REQUEST['ciudad1'] == 0 and $_REQUEST['guardar'])
    {
	   echo '<script language="JavaScript">alert("Debe Seleccionar una ciudad de residencia"); history.go(-1);</script>';
	}
	echo "</span>";
?>
</td>
      </tr>
	   <tr>
	  <td height="27" bgcolor="#C5D5D6" class="Estilo2" align="center">Dir. Correspondencia </td>

      <td colspan="5" class="Estilo1" align="left">&nbsp;

	    <INPUT name="direccion2" size="90" readonly onClick="window.open('direccion.php?correo=1','direccion','width=1000,height=300,left=150,top=150,scrollbars=yes')"  value="<?php if(isset($_REQUEST['direccion2'])) echo $_REQUEST['direccion2']; else echo $row_dataestudiante['direccioncorrespondenciaestudiantegeneral']; ?>">

		  <input name="direccion2oculta" type="hidden" size="25" value="<?php if(isset($_REQUEST['direccion2oculta'])) echo $_REQUEST['direccion2oculta']; else echo $row_data['direccioncortacorrespondenciaestudiantegeneral']; ?>"></span></td>

  </td>

 </tr>

      <tr>

        <td height="26" bgcolor="#C5D5D6" class="Estilo2" align="center">Tel&eacute;fono</td>
        <td colspan="2" class="Estilo1" align="left"><input name="telefono2" type="text" id="telefono23" value="<?php if(isset($_REQUEST['telefono2'])) echo $_REQUEST['telefono2']; else echo $row_dataestudiante['telefonocorrespondenciaestudiantegeneral'];?>" size="22">
        </td>
      <td colspan="1" align="left" class="Estilo1" bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">Ciudad Corespondencia</span>
     </div></td>
       <td colspan="2" align="center" class="Estilo2">

              <!-- <input name="ciudad2" type="text" id="ciudad24" value="<?php if(isset($_REQUEST['ciudad2'])) echo $_REQUEST['ciudad2']; else echo $row_dataestudiante['ciudadcorrespondenciaestudiantegeneral'];?>" size="19">        </td> -->

         <?php

			$query_ciudad = "select *

			from ciudad c,departamento d

		    where c.iddepartamento = d.iddepartamento

			order by 3";

	        $ciudad = mysql_query($query_ciudad, $sala) or die("$query_ciudad");

	        $totalRows_ciudad= mysql_num_rows($ciudad);

	        $row_ciudad = mysql_fetch_assoc($ciudad);

			?>

          <select name="ciudad2">

          <option value="0" <?php if (!(strcmp("0", $row_dataestudiante['ciudadcorrespondenciaestudiantegeneral']))) {echo "SELECTED";} ?>>Seleccionar</option>

 <?php

		do

		 {

?>



            <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $row_dataestudiante['ciudadcorrespondenciaestudiantegeneral']))) {echo "SELECTED";} ?>><?php echo $row_ciudad['nombreciudad'],"-",$row_ciudad['nombredepartamento'];?></option>



            <?php



                }



				while($row_ciudad = mysql_fetch_assoc($ciudad));



				$rows = mysql_num_rows($ciudad);



					if($rows > 0)



					{



						mysql_data_seek($ciudad, 0);



						$row_ciudad = mysql_fetch_assoc($ciudad);



					}



				?>



          </select>



      </tr>
	  <tr>
		<td height="26" bgcolor="#C5D5D6" class="Estilo2" align="center">Lugar de Nacimiento</td>
        <td colspan="2" class="Estilo1" align="left">
			<?php

	        $ciudad = mysql_query($query_ciudad, $sala) or die("$query_ciudad");

	        $totalRows_ciudad= mysql_num_rows($ciudad);

	        $row_ciudad = mysql_fetch_assoc($ciudad);

			?>
		<div style="margin:5px 2px;">(Si usted es extranjero seleccione en el menú .EXTRANJERO) </div>
          <select name="ciudadnacimiento">

          <option value="0" <?php if (!(strcmp("0", $row_dataestudiante['idciudadnacimiento']))) {echo "SELECTED";} ?>>Seleccionar</option>

 <?php

		do

		 {

?>



            <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $row_dataestudiante['idciudadnacimiento']))) {echo "SELECTED";} ?>><?php echo $row_ciudad['nombreciudad'],"-",$row_ciudad['nombredepartamento'];?></option>



            <?php



                }



				while($row_ciudad = mysql_fetch_assoc($ciudad));



				$rows = mysql_num_rows($ciudad);



					if($rows > 0)



					{



						mysql_data_seek($ciudad, 0);



						$row_ciudad = mysql_fetch_assoc($ciudad);



					}



				?>



          </select>
		
        </td>
		<td colspan="1" align="left" class="Estilo1" bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">País de Nacimiento</span>
		</div></td>
		<td colspan="2" align="center" class="Estilo2">
		 <?php

			$query_pais = "select *

			from pais p

			Where codigoestado=100 
			
			order by 3";

	        $pais = mysql_query($query_pais, $sala) or die("$query_pais");

	        $totalRows_ciudad= mysql_num_rows($pais);

	        $row_ciudad = mysql_fetch_assoc($pais);

			?>

          <select id="idpaisnacimiento" name="idpaisnacimiento">

 <?php

		do

		 {

?>



            <option value="<?php echo $row_ciudad['idpais']?>"<?php if (!(strcmp($row_ciudad['idpais'], $row_dataestudiante['idpaisnacimiento']))) {echo "SELECTED";} ?>><?php echo $row_ciudad['nombrepais'];?></option>



            <?php



                }



				while($row_ciudad = mysql_fetch_assoc($pais));



				$rows = mysql_num_rows($pais);



					if($rows > 0)



					{



						mysql_data_seek($pais, 0);



						$row_ciudad = mysql_fetch_assoc($pais);



					}



				?>



          </select>


		
		</td>
	  </tr>
</table>
<?php
$SQL_DATA = 'SELECT * FROM EstudianteVisa WHERE idestudiantegeneral = "'.$idestudiantegeneral.'" AND estado = 100 ; ';
$dataVisa = mysql_query($SQL_DATA, $sala) or die("$SQL_DATA");
while($row_dataVisa = mysql_fetch_assoc($dataVisa)){
	$TipoPermiso=$row_dataVisa['TipoPermiso'];
	$CategoriaVisaId=$row_dataVisa['CategoriaVisaId'];
	$NumeroVisa=$row_dataVisa['NumeroVisa'];
	$NumeroVisaT=$row_dataVisa['NumeroVisaT'];
	$FechaExpedicion=$row_dataVisa['FechaExpedicion'];
	$FechaVencimiento=$row_dataVisa['FechaVencimiento'];
	$idpaisnacimiento= $row_dataVisa['PaisId'];
}
if($TipoPermiso)
{
	$style="";
}else{
	
	$style="display:none";
}
?>
<div id="table_extranjero" style="<?php echo $style; ?>">
 <p align="center" class="Estilo3">EXTRANJERO</p>
	<table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
	<tr>
		<td class="Estilo2" bgcolor="#C5D5D6" align="center">Tipo Permiso:<span class="Estilo4">*</span></td>
		<td><select id="tipoPermiso" name="tipoPermiso">
			<option value="">Seleccione</option>
			<option value="1">VISA</option>
			<option value="2">Permiso de estudio</option>
		</select></td>
	</tr>
	</table>
</div>

<div id="table_extranjero1" style="<?php echo $style; ?>">
	<table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
		<tr>
			<td bgcolor="#C5D5D6" class="Estilo2" align="center">Categoria Visa<span class="Estilo4">*</span></td>
			<td colspan="2" class="Estilo1">
			  <select id="categoriavisa" name="categoriavisa">
				  <?php
					$SQL_CATEGORIA = 'SELECT * FROM CategoriaVisa WHERE estado="100"; ';
					$categoria = mysql_query($SQL_CATEGORIA, $sala) or die("$SQL_CATEGORIA");
				  ?>
					<option value="0">Seleccione</option>
					<?php while($row_categoria = mysql_fetch_assoc($categoria)){ ?>
						<option value="<?php echo $row_categoria['CategoriaVisaId']; ?>"><?php echo $row_categoria['Nombre']; ?></option>
					<?php } ?>
				</select>
			</td>
			<td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Número Visa<span class="Estilo4">*</span></td>
			<td colspan="2" align="left" class="Estilo1"><input type="text" id="numerovisa1" name="numerovisa1" value="<?php echo $NumeroVisa; ?>"/></td>
			</tr>
			<tr>
					<td bgcolor="#C5D5D6" class="Estilo2" align="center">Fecha expedición visa (aaaa-mm-dd)<span class="Estilo4">*</span></td>
					<td colspan="2" class="Estilo1">
					  <input type="text" id="fechaexpediciovisa1" name="fechaexpediciovisa1" value="<?php echo $FechaExpedicion;?>" />
			</td>
			<td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Fecha vencimiento visa (aaaa-mm-dd)<span class="Estilo4">*</span></td>
			<td colspan="2" align="left" class="Estilo1"><input type="text" id="fechavencimientovisa1" name="fechavencimientovisa1" value="<?php echo $FechaVencimiento; ?>"/></td>
		</tr>
		<input type="hidden" name="exCategoria" value="1" id="exCategoria">
	</table>
</div>

<div id="table_extranjero2" style="<?php echo $style; ?>">
	<table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
		<tr>
			<td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Número <span class="Estilo4">*</span></td>
			<td colspan="2" align="left" class="Estilo1"><input type="text" id="numerovisa" name="numerovisa" value="<?php echo $NumeroVisaT; ?>"/></td>
		</tr>
		<tr>
				<td bgcolor="#C5D5D6" class="Estilo2" align="center">Fecha expedición (aaaa-mm-dd)<span class="Estilo4">*</span></td>
				<td colspan="2" class="Estilo1">
				  <input type="text" id="fechaexpediciovisa" name="fechaexpediciovisa" value="<?php echo $FechaExpedicion;?>" />
		</td>
		<td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Fecha vencimiento (aaaa-mm-dd)<span class="Estilo4">*</span></td>
		<td colspan="2" align="left" class="Estilo1"><input type="text" id="fechavencimientovisa" name="fechavencimientovisa" value="<?php echo $FechaVencimiento; ?>"/></td>
		</tr>
	<input type="hidden" name="exCategoriaTipo" value="2" id="exCategoriaTipo">
	</table>
</div>
<?php

if(!empty($_REQUEST['guardar'])) {

        if ($_REQUEST['situacion'] == 300) {
            $SQL = 'SELECT codigosituacioncarreraestudiante FROM estudiante WHERE idestudiantegeneral = ' . $idestudiantegeneral;
            $resultado = mysql_query($SQL, $sala) or die(mysql_error());
            $row_resultado = mysql_fetch_assoc($resultado);
            if ($row_resultado['codigosituacioncarreraestudiante'] != 300) {
                $SQL = 'SELECT car.codigomodalidadacademica, car.codigocarrera FROM estudiante est
					JOIN carrera car ON est.codigocarrera = car.codigocarrera
					WHERE est.idestudiantegeneral = ' . $idestudiantegeneral . ' AND car.codigocarrera = ' . $row_dataestudiante['codigocarrera'];
                $resultado = mysql_query($SQL, $sala) or die(mysql_error());
                $row_resultado = mysql_fetch_assoc($resultado);
                if ($row_resultado['codigomodalidadacademica'] == 200 && $row_resultado['codigomodalidadacademica'] != 92) {
                    /* echo "<script>var r = confirm('¿Enviar carta de felicitación?');
                      if (r == true) {
                      $.ajax({
                      type: 'POST',
                      url: 'editarestudiante.php',
                      async: false,
                      dataType: 'json',
                      data:({action:'enviar_carta', nombres: '".$_REQUEST['nombres']."', apellidos: '".$_REQUEST['apellidos']."', nombrecarrera: '".$row_dataestudiante['nombrecarrera']."', documento: '".$_REQUEST['documento']."', email: '".$_REQUEST['email']."'}),
                      success: function(data){
                      alert(data);
                      }
                      });
                      }</script>"; */
                }
            }
        }

        $_REQUEST['nombres'] = strtoupper($_REQUEST['nombres']);
        $_REQUEST['apellidos'] = strtoupper($_REQUEST['apellidos']);
        if ($_REQUEST['situacion'] == 111) {
            $query_updest1 = "UPDATE inscripcion i, estudiantecarrerainscripcion  e
        SET i.codigosituacioncarreraestudiante = '111'
        WHERE i.idestudiantegeneral = '$idestudiantegeneral'
        and i.codigoperiodo = '" . $_SESSION['codigoperiodosesion'] . "'
        and e.idestudiantegeneral = i.idestudiantegeneral
        and e.idinscripcion = i.idinscripcion
        and e.codigocarrera = '" . $row_dataestudiante['codigocarrera'] . "'";
            //echo $query_updest1;
            //exit();
            $updest1 = mysql_query($query_updest1, $sala) or die(mysql_error());
        }



        //exit();

        if (trim($numerodocumentoinicial) == '0' || trim($numerodocumentoinicial) == '' || !isset($numerodocumentoinicial))
            $formulariovalido = 0;


        if (trim($_REQUEST['documento']) == '0' || trim($_REQUEST['documento']) == '' || !isset($_REQUEST['documento'])) {
            $formulariovalido = 0;
            echo "<script language='javascript'>alert('El numero del documento no puede ser cero')</script>";
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
        }



        if ($formulariovalido) {



            // Lo primero que se mira es si el nuevo documento que se quiere insertar no este ya en estudiantedocumento en los activos
            // Esto para los estudiantes que son diferentes al actual



            $query_estudianteexiste = "select * from estudiantedocumento
		where numerodocumento = '" . $_REQUEST['documento'] . "'
		and fechainicioestudiantedocumento <= '" . date("Y-m-d H:m:s", time()) . "'
	    and fechavencimientoestudiantedocumento >= '" . date("Y-m-d H:m:s", time()) . "'
 	    and idestudiantegeneral <> '$idestudiantegeneral'";
            echo $query_ordenes;
            $estudianteexiste = mysql_query($query_estudianteexiste, $sala) or die(mysql_error());
            $row_estudianteexiste = mysql_fetch_assoc($estudianteexiste);
            $totalRows_estudianteexiste = mysql_num_rows($estudianteexiste);

            if ($totalRows_estudianteexiste != "") {
                echo '<script language="JavaScript">alert("El documento ' . $_REQUEST['documento'] . ' ya existe en el sistema"); hisroty.go(-1)</script>';
                exit();
            }
            //if($_REQUEST['situacion'] == 51 or $_REQUEST['situacion'] == 52)
            if ($_REQUEST['situacion'] == 103) {
                $query_ordenespagas = "SELECT *
			FROM ordenpago o
			WHERE codigoestadoordenpago LIKE '4%'
			AND o.codigoestudiante = '" . $codigoestudiante . "'
			AND o.codigoperiodo = '$periodoactual'";
                //echo $query_ordenes;
                $ordenespagas = mysql_query($query_ordenespagas, $sala) or die(mysql_error());
                $row_ordenespagas = mysql_fetch_assoc($ordenespagas);
                $totalRows_ordenespagas = mysql_num_rows($ordenespagas);
                if ($row_ordenespagas <> "") {
                    echo '<script language="javascript">
				alert ("Este estudiante se encuentra en estado matriculado, se retiraran las materias inscritas")
                </script>';

                    $base = "update prematricula set  codigoestadoprematricula = 50
				where codigoestudiante = '" . $codigoestudiante . "'
				and codigoestadoprematricula like '4%'
				and codigoperiodo = '$periodoactual'";
                    $sol = mysql_db_query($database_sala, $base);

                    $base1 = "update detalleprematricula set  codigoestadodetalleprematricula = 24
				where idprematricula='" . $row_ordenespagas['idprematricula'] . "'";
                    $sol1 = mysql_db_query($database_sala, $base1);
                    $base2 = "update ordenpago set  codigoestadoordenpago = 52
				where codigoestudiante = '" . $codigoestudiante . "'
				and codigoestadoordenpago like '4%'
				and codigoperiodo = '$periodoactual'";
                    $sol2 = mysql_db_query($database_sala, $base2);
                } else {
                    $query_ordenespagas = "SELECT *
			FROM ordenpago o
			WHERE codigoestadoordenpago LIKE '1%'
			AND o.codigoestudiante = '" . $codigoestudiante . "'
			AND o.codigoperiodo = '$periodoactual'";
                    //echo $query_ordenes;
                    $ordenespagas = mysql_query($query_ordenespagas, $sala) or die(mysql_error());
                    $row_ordenespagas = mysql_fetch_assoc($ordenespagas);
                    $totalRows_ordenespagas = mysql_num_rows($ordenespagas);

                    if ($row_ordenespagas <> "") {
                        echo '<script language="javascript">alert("Estudiante con prematricula activa por favor anulï¿½rsela antes de retirarlo")</script>';
                        echo '<script language="javascript">history.go(-1)</script>';
                    }
                }
            }

            $query_situacionestudiante1 = "SELECT *
		FROM historicosituacionestudiante
		WHERE  codigoestudiante = '" . $codigoestudiante . "'
		ORDER BY idhistoricosituacionestudiante DESC";
            //echo $query_situacionestudiante1;
            $situacionestudiante1 = mysql_query($query_situacionestudiante1, $sala) OR die(mysql_error());
            $row_situacionestudiante1 = mysql_fetch_assoc($situacionestudiante1);
            $totalRows_situacionestudiante1 = mysql_num_rows($situacionestudiante1);

            $fechahoy = date("Y-m-d G:i:s", time());


            if ($_REQUEST['situacion'] <> $row_situacionestudiante1['codigosituacioncarreraestudiante']) {

                if ($_REQUEST['situacion'] == 104) {
                    require('../cierresemestre/funcionmateriaaprobada.php');
                    require('../cierresemestre/generarcargaestudiante.php');
                    if ($materiaspropuestas <> "") {
                        foreach ($materiaspropuestas as $k => $v) {
                            //echo $v['codigomateria'],"&nbsp;",$codigoestudiante,"propuestas<br>";
                            $totalmaterias[] = $v['codigomateria'];
                        }
                    }

                    if ($materiasobligatorias <> "") {
                        foreach ($materiasobligatorias as $k1 => $v1) {
                            //echo $v1['codigomateria'],"&nbsp;",$codigoestudiante,"aca<br>";
                            $totalmaterias[] = $v1['codigomateria'];
                        }
                    }

                    if ($totalmaterias == "") {
                        $sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";
                        $sql .= "VALUES('0','" . $codigoestudiante . "','" . $_REQUEST['situacion'] . "','" . $periodoactual . "','" . $fechahoy . "','" . $fechahoy . "','2999-12-31','" . $usuario . "')";
                        $result = mysql_query($sql, $sala);

                        $query_updest1 = "UPDATE historicosituacionestudiante
				  SET fechafinalhistoricosituacionestudiante = '" . $fechahoy . "'
				  WHERE idhistoricosituacionestudiante = '" . $row_situacionestudiante1['idhistoricosituacionestudiante'] . "'";
                        $updest1 = mysql_query($query_updest1, $sala);
                    } else {
                        echo '<script language="JavaScript">alert("El estudiante tiene materias pendientes por Cursar de su plan de estudios, no puede pasar a egresado."); history.go(-1);</script>';
                        exit();
                    }
                } else {
                    $sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";
                    $sql .= "VALUES('0','" . $codigoestudiante . "','" . $_REQUEST['situacion'] . "','" . $periodoactual . "','" . $fechahoy . "','" . $fechahoy . "','2999-12-31','" . $usuario . "')";
                    $result = mysql_query($sql, $sala);

                    $query_updest1 = "UPDATE historicosituacionestudiante
				SET fechafinalhistoricosituacionestudiante = '" . $fechahoy . "'
				WHERE idhistoricosituacionestudiante = '" . $row_situacionestudiante1['idhistoricosituacionestudiante'] . "'";
                    $updest1 = mysql_query($query_updest1, $sala);
                }
            }

            //$insertoGraduado = true;


            if ($_REQUEST['situacion'] == 400 && $_REQUEST['situacion'] != $row_dataestudiante['codigosituacioncarreraestudiante']) {
                require_once('../../../Connections/sala2.php');
                $rutaado = "../../../funciones/adodb/";
                //$rutazado = "../../../funciones/zadodb/";
                require_once('../../../Connections/salaado.php');
                require_once('../../../funciones/sala/auditoria/auditoria.php');
                //$db->debug=true;
                $auditoria = new auditoria();
                // Guardar en el logsituaciongraduados
                $sql = "INSERT INTO logsituaciongraduado(idlogsituaciongraduado, fechalogsituaciongraduado,  observacionlogsituaciongraduado, codigosituacioncarreraestudiante, idusuario, ip)
            VALUES(0, now(), '" . $_REQUEST['observacionsituacion'] . "', '" . $row_dataestudiante['codigosituacioncarreraestudiante'] . "', '$auditoria->idusuario', '$auditoria->ip')";
                //echo $_REQUEST['situacion'];
                //exit();

                $result = mysql_query($sql, $sala) or die(mysql_error());
            }
            $query_tipo = "SELECT *
		FROM historicotipoestudiante
		WHERE  codigoestudiante = '" . $codigoestudiante . "'
		ORDER BY idhistoricotipoestudiante DESC";
            //echo $query_situacionestudiante1;
            $tipo = mysql_query($query_tipo, $sala) OR die(mysql_error());
            $row_tipo = mysql_fetch_assoc($tipo);
            $totalRows_tipo = mysql_num_rows($tipo);



            if ($_REQUEST['tipoestudiante'] <> $row_tipo['codigotipoestudiante']) {
                $sql1 = "insert into historicotipoestudiante(idhistoricotipoestudiante,codigoestudiante,codigotipoestudiante,codigoperiodo,fechahistoricotipoestudiante,fechainiciohistoricotipoestudiante,fechafinalhistoricotipoestudiante,usuario,iphistoricotipoestudiante)";
                $sql1 .= "VALUES('0','" . $codigoestudiante . "','" . $_REQUEST['tipoestudiante'] . "','" . $periodoactual . "','" . $fechahoy . "','" . $fechahoy . "','2999-12-31','" . $usuario . "','$ip')";
                $result1 = mysql_query($sql1, $sala);

                $query_updest1 = "UPDATE historicotipoestudiante
            SET fechafinalhistoricotipoestudiante = '" . $fechahoy . "'
    	    WHERE idhistoricotipoestudiante = '" . $row_tipo['idhistoricotipoestudiante'] . "'";
                $updest1 = mysql_query($query_updest1, $sala);
            }

            //*******************************************************************************************************************
            // INVOCA EL WEB SERVICE DE PS PARA REALIZAR LA ACTUALIZACION DE LOS DATOS, SI LA RESPUESTA ES ERRONEA NO SE HACE LA ACTUALIZACION EN SALA DE LOS DATOS
            //var_dump(realpath(dirname(__FILE__)).'/../../interfacespeople/ordenesdepago/reportarmodificacionestudiantesala.php'); 
            require_once(realpath(dirname(__FILE__)) . '/../../interfacespeople/ordenesdepago/reportarmodificacionestudiantesala.php');
            //var_dump($result);
            if (($result['ERRNUM'] != 0 || $result['ERRNUM'] === '' || empty($result)) && $_REQUEST['situacion'] == 400) {/*
              Cambio realizado Por Marcos 11/06/2013
             */
                echo "<script>alert('No se pudo realizar la actualizacion de la informacion. Por favor contáctese con la universidad para recibir ayuda en este proceso. Gracias.')</script>";
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudianteGrados.php?usuarioeditar=" . $_REQUEST['usuarioeditar'] . "&codigocreado=" . $_REQUEST['codigocreado'] . "&facultad=" . $_SESSION['codigofacultad'] . "'>";
                exit;
            }
            //*******************************************************************************************************************
            // Miro si el documento es diferente al que se encuentra en estudiantegeneral.
            // Si es diferente inserta uno nuevo en estudiantedocumento y hace el update en estudiantegeneral

            /* if($_REQUEST['documento'] <> $numerodocumentoinicial)
              { */

            $query_upddocumento = "select * from estudiantedocumento
    		WHERE idestudiantegeneral = '$idestudiantegeneral' and numerodocumento = '" . $_REQUEST['documento'] . "'";
            //echo $query_upddocumento."<br><br>";
            //exit();
            $resultestdocumentos = mysql_query($query_upddocumento, $sala) or die("$query_upddocumento" . mysql_error());
            $totalRows_documentos = mysql_num_rows($resultestdocumentos);

            if ($totalRows_documentos != "" && $totalRows_documentos > 0) {
                $query_upddocumento = "UPDATE estudiantedocumento
				SET fechavencimientoestudiantedocumento='2999-12-31'
				WHERE idestudiantegeneral = '$idestudiantegeneral'
				and numerodocumento = '" . $_REQUEST['documento'] . "'";
                $upddocumento = mysql_query($query_upddocumento, $sala) or die("$query_upddocumento" . mysql_error());
            } else {

                $query_insdocumento = "INSERT INTO estudiantedocumento(idestudiantedocumento, idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento)
				VALUES(0, '$idestudiantegeneral', '" . $_REQUEST['tipodocumento'] . "', '" . $_REQUEST['documento'] . "', '" . $_REQUEST['expedido'] . "', '$fechahoy', '2999-12-31')";

                mysql_query($query_insdocumento, $sala) or die("$query_upddocumento" . mysql_error());
            }

            $fechahabil = date("Y-m-d");

            //echo "FH : $fechahabil<br>";
            //echo "$diamax<br>";



            $unDiaMenos = strtotime("-1 day", strtotime($fechahabil));
            $fechahabil = date("Y-m-d", $unDiaMenos);



            $query_upddocumento = "UPDATE estudiantedocumento
    		SET fechavencimientoestudiantedocumento='$fechahabil'
    		WHERE idestudiantegeneral = '$idestudiantegeneral'
			and numerodocumento<>'" . $_REQUEST['documento'] . "'
			AND fechavencimientoestudiantedocumento>NOW()";
            //echo $query_upddocumento."<br><br>";
            //exit();
            $upddocumento = mysql_query($query_upddocumento, $sala) or die("$query_upddocumento" . mysql_error());



            $query_updusuario = "UPDATE usuario
			SET numerodocumento = '" . $_REQUEST['documento'] . "'
			WHERE numerodocumento = '$numerodocumentoinicial'";
            $updusuario = mysql_query($query_updusuario, $sala) or die("$query_updusuario" . mysql_error());

            //} 

            $query_upddocumento = "select * from estudiantedocumento
    		WHERE idestudiantegeneral = '$idestudiantegeneral'";
            //echo $query_upddocumento."<br><br>";
            //exit();
            $resultestdocumentos = mysql_query($query_upddocumento, $sala) or die("$query_upddocumento" . mysql_error());

            while ($row_estdocumentos = mysql_fetch_assoc($resultestdocumentos)) {
                $query_updusuario = "UPDATE usuario
				SET numerodocumento = '" . $_REQUEST['documento'] . "'
				WHERE numerodocumento = '" . $row_estdocumentos["numerodocumento"] . "'";
                $updusuario = mysql_query($query_updusuario, $sala) or die("$query_updusuario" . mysql_error());
            }


            $query_updestudiantegeneral = "UPDATE estudiantegeneral
    	SET tipodocumento='" . $_REQUEST['tipodocumento'] . "',
		numerodocumento='" . $_REQUEST['documento'] . "',
		expedidodocumento='" . $_REQUEST['expedido'] . "',
		nombrecortoestudiantegeneral='" . $_REQUEST['documento'] . "',
		nombresestudiantegeneral='" . $_REQUEST['nombres'] . "',
		apellidosestudiantegeneral='" . $_REQUEST['apellidos'] . "',
		fechanacimientoestudiantegeneral='" . $_REQUEST['fnacimiento'] . "',
		codigogenero='" . $_REQUEST['genero'] . "',
		direccionresidenciaestudiantegeneral='" . $_REQUEST['direccion1'] . "',
		direccioncortaresidenciaestudiantegeneral = '" . $_REQUEST['direccion1oculta'] . "',
		ciudadresidenciaestudiantegeneral='" . $_REQUEST['ciudad1'] . "',
		telefonoresidenciaestudiantegeneral='" . $_REQUEST['telefono1'] . "',
		telefono2estudiantegeneral='" . $_REQUEST['telefono2'] . "',
		celularestudiantegeneral='" . $_REQUEST['celular'] . "',
		direccioncorrespondenciaestudiantegeneral='" . $_REQUEST['direccion2'] . "',
		direccioncortacorrespondenciaestudiantegeneral = '" . $_REQUEST['direccion2oculta'] . "',
		ciudadcorrespondenciaestudiantegeneral='" . $_REQUEST['ciudad2'] . "',
		telefonocorrespondenciaestudiantegeneral='" . $_REQUEST['telefono2'] . "',
		emailestudiantegeneral='" . $_REQUEST['email'] . "',
		idciudadnacimiento='" . $_REQUEST['ciudadnacimiento'] . "',
		idpaisnacimiento='" . $_REQUEST['idpaisnacimiento'] . "',
		fechaactualizaciondatosestudiantegeneral='" . date("Y-m-d G:i:s", time()) . "',
		EstadoActualizaDato = 1
		WHERE idestudiantegeneral = '$idestudiantegeneral'";

            $updestudiantegeneral = mysql_query($query_updestudiantegeneral, $sala) or die("$query_updestudiantegeneral" . mysql_error());

            $query_datausuario = "select * from usuario where numerodocumento=" . $_REQUEST['documento'];
            $datausuario = mysql_query($query_datausuario, $sala) or die("$query_datausuario" . mysql_error());
            $row_datausuario = mysql_fetch_assoc($datausuario);

            $objetoldap = new claseldap(SERVIDORLDAP, CLAVELDAP, PUERTOLDAP, CADENAADMINLDAP, "", RAIZDIRECTORIO);
            $objetoldap->ConexionAdmin();
            $infomodificado["gacctMail"] = $_REQUEST['email'];
            //$infomodificado= array("gacctMail" => array($_REQUEST['email']));

            if (!$objetoldap->ModificacionUsuario($infomodificado, $row_datausuario["usuario"])) {
                //$infomodificado["objectClass"][0]="googleUser";
                $objetoldap->AdicionUsuario($infomodificado, $row_datausuario["usuario"]);
            }

            $query_updestudiante = "UPDATE estudiante
	    SET semestre='" . $_REQUEST['semestre'] . "',
		codigotipoestudiante='" . $_REQUEST['tipoestudiante'] . "',
		codigosituacioncarreraestudiante='" . $_REQUEST['situacion'] . "',
		codigojornada='" . $_REQUEST['jornada'] . "'
		WHERE codigoestudiante = '$codigoestudiante'";
            $updestudiante = mysql_query($query_updestudiante, $sala) or die("$query_updestudiantegeneral" . mysql_error);


            /**
             * @modified Andres Ariza <arizaandres@unbosque.edu.do>
             * Se agrega llamado al proceso de sincronizacion de estudiante e inscripcion
             * @since Nobiembre 15, 2018
             */
            $querySelect = "SELECT i.idinscripcion
            FROM inscripcion i,
            estudiantecarrerainscripcion e 
            WHERE i.idestudiantegeneral = '$idestudiantegeneral'
            and i.codigoperiodo = '" . $_SESSION['codigoperiodosesion'] . "'
            and e.idestudiantegeneral = i.idestudiantegeneral
            and e.idinscripcion = i.idinscripcion
            and e.codigocarrera = '" . $row_dataestudiante['codigocarrera'] . "' ";
            $resultado1 = mysql_query($querySelect, $sala) or die(mysql_error());
            $row_resultado1 = mysql_fetch_assoc($resultado1);
            //home/arizaandres/Documentos/proyectoSala/serviciosacademicos/consulta/facultades/creacionestudiante/editarestudianteGrados.php
            require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
            require_once(PATH_SITE . "/utiles/SincronizarInscripcionEstudiante/Fachada.php");

            class localFachadaEG extends Sala\utiles\SincronizarInscripcionEstudiante\Fachada {

                function __construct() {
                    
                }

            }
            $idinscripcion =$row_resultado1['idinscripcion'];
            $localFachada = new localFachadaEG();
            $constructor = $localFachada->construir($idinscripcion, $codigoestudiante);
            $localFachada->sincronizar($constructor->getInscripcion()->getCodigoperiodo(), $_REQUEST['situacion'], $constructor->getEstudiante()->getCodigoestudiante(), $constructor->getInscripcion()->getIdinscripcion());


            exit();
            //echo "<br>".$query_updestudiante."<br>";
            //exit();
            $query_tipousuario = "SELECT idusuario 
			FROM usuario 
			where usuario = '" . $usuario . "'";
            $tipousuario = $db->Execute($query_tipousuario);
            $totalRows_tipousuario = $tipousuario->RecordCount();
            $row_usuario = $tipousuario->FetchRow();
            $idusuario = $row_usuario["idusuario"];
            if (isset($_REQUEST["lugarRotacion"]) && is_numeric($_REQUEST["lugarRotacion"])) {
                $query_rotacion = "select codigoestudiante from LugarRotacionCarreraEstudiante
										where codigoestudiante = '" . $codigoestudiante . "'";
                $estudianterotacion = $db->Execute($query_rotacion);
                $totalRows_estudianterotacion = $estudianterotacion->RecordCount();
                $row_estudianterotacion = $estudianterotacion->FetchRow();
                if (!$row_estudianterotacion) {
                    $query_rotacion = "INSERT INTO `LugarRotacionCarreraEstudiante` (`codigoestudiante`, `LugarRotacionCarreraID`, 
												`FechaCreacion`, `UsuarioCreacion`, `FechaModificacion`, `UsuarioModificacion`) 
												VALUES ('" . $codigoestudiante . "', '" . $_REQUEST["lugarRotacion"] . "', '" . date("Y-m-d") . "', '" . $idusuario . "', 
												'" . date("Y-m-d") . "', '" . $idusuario . "')";
                    $actualizarotacion = $db->Execute($query_rotacion);
                } else {
                    $query_rotacion = "UPDATE `LugarRotacionCarreraEstudiante` SET `LugarRotacionCarreraID`='" . $_REQUEST["lugarRotacion"] . "', 
												`codigoestado`='100',`FechaModificacion`='" . date("Y-m-d") . "', `UsuarioModificacion`='" . $idusuario . "'
												WHERE (`codigoestudiante`='" . $codigoestudiante . "')";
                    $actualizarotacion = $db->Execute($query_rotacion);
                }
            }

            if ($_SESSION['MM_Username'] == 'dirsecgeneral') {
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudianteGrados.php?codigocreado=" . $codigoestudiante . "'>";
                echo '<script language="JavaScript">history.go(-2);</script>';
                exit();
            }

            if ($totalRows_dataestudianteplan == "") {
                $query_planestudioestudiante = "UPDATE planestudioestudiante
			SET codigoestadoplanestudioestudiante = 200
			WHERE codigoestudiante = '$codigoestudiante'";
                //echo "<br>".$query_planestudioestudiante."<br>";
                //exit();
                $planestudioestudiante = mysql_query($query_planestudioestudiante, $sala);

                $query_insplanestudioestudiante = "INSERT INTO planestudioestudiante(idplanestudio, codigoestudiante, fechaasignacionplanestudioestudiante, fechainicioplanestudioestudiante, fechavencimientoplanestudioestudiante, codigoestadoplanestudioestudiante)
    		VALUES('" . $_REQUEST['planestudio'] . "', '$codigoestudiante', '" . date("Y-m-d") . "', '" . date("Y-m-d") . "', '2999-12-31', '101')";
                $insplanestudioestudiante = mysql_query($query_insplanestudioestudiante, $sala);
            } else {
                $query_planestudioestudiante = "UPDATE planestudioestudiante
			SET idplanestudio='" . $_REQUEST['planestudio'] . "', fechaasignacionplanestudioestudiante='" . date("Y-m-d") . "'
			WHERE codigoestudiante = '$codigoestudiante'";
                //echo "<br>".$query_planestudioestudiante."<br>";
                //exit();
                $planestudioestudiante = mysql_query($query_planestudioestudiante, $sala);
            }

            $centralData = array(
                'SEARCHTERM1' => $_REQUEST['documento'],
                'SEARCHTERM2' => '',
                'PARTNERTYPE' => '',
                'AUTHORIZATIONGROUP' => '',
                'PARTNERLANGUAGE' => '',
                'PARTNERLANGUAGEISO' => '',
                'DATAORIGINTYPE' => '',
                'CENTRALARCHIVINGFLAG' => '',
                'CENTRALBLOCK' => '',
                'TITLE_KEY' => '',
                'CONTACTALLOWANCE' => '',
                'PARTNEREXTERNAL' => '',
                'TITLELETTER' => '',
                'NOTRELEASED' => '',
                'COMM_TYPE' => ''
            );

            $centralDataX = array(
                'SEARCHTERM1' => 'X',
                'SEARCHTERM2' => '',
                'PARTNERTYPE' => '',
                'AUTHORIZATIONGROUP' => '',
                'PARTNERLANGUAGE' => '',
                'PARTNERLANGUAGEISO' => '',
                'DATAORIGINTYPE' => '',
                'CENTRALARCHIVINGFLAG' => '',
                'CENTRALBLOCK' => '',
                'TITLE_KEY' => '',
                'CONTACTALLOWANCE' => '',
                'PARTNEREXTERNAL' => '',
                'TITLELETTER' => '',
                'NOTRELEASED' => '',
                'COMM_TYPE' => ''
            );

            $dataPersona = array(
                'FIRSTNAME' => $_REQUEST['nombres'],
                'LASTNAME' => $_REQUEST['apellidos'],
                'BIRTHNAME' => '',
                'MIDDLENAME' => '',
                'SECONDNAME' => '',
                'TITLE_ACA1' => '',
                'TITLE_ACA2' => '',
                'TITLE_SPPL' => '',
                'PREFIX1' => '',
                'PREFIX2' => '',
                'NICKNAME' => '',
                'INITIALS' => '',
                'NAMEFORMAT' => '',
                'NAMCOUNTRY' => '',
                'NAMCOUNTRYISO' => '',
                'SEX' => '',
                'BIRTHPLACE' => '',
                'BIRTHDATE' => '',
                'DEATHDATE' => '',
                'MARITALSTATUS' => '',
                'CORRESPONDLANGUAGE' => '',
                'CORRESPONDLANGUAGEISO' => '',
                'FULLNAME' => $_REQUEST['apellidos'] . ' ' . $_REQUEST['nombres'],
                'EMPLOYER' => '',
                'OCCUPATION' => '',
                'NATIONALITY' => '',
                'NATIONALITYISO' => '',
                'COUNTRYORIGIN' => ''
            );

            $dataPersonaX = array(
                'FIRSTNAME' => 'X',
                'LASTNAME' => 'X',
                'BIRTHNAME' => '',
                'MIDDLENAME' => '',
                'SECONDNAME' => '',
                'TITLE_ACA1' => '',
                'TITLE_ACA2' => '',
                'TITLE_SPPL' => '',
                'PREFIX1' => '',
                'PREFIX2' => '',
                'NICKNAME' => '',
                'INITIALS' => '',
                'NAMEFORMAT' => '',
                'NAMCOUNTRY' => '',
                'NAMCOUNTRYISO' => '',
                'SEX' => '',
                'BIRTHPLACE' => '',
                'BIRTHDATE' => '',
                'DEATHDATE' => '',
                'MARITALSTATUS' => '',
                'CORRESPONDLANGUAGE' => '',
                'CORRESPONDLANGUAGEISO' => '',
                'FULLNAME' => 'X',
                'EMPLOYER' => '',
                'OCCUPATION' => '',
                'NATIONALITY' => '',
                'NATIONALITYISO' => '',
                'COUNTRYORIGIN' => ''
            );

            //print_r($_REQUEST);
            //exit();
            if (isset($_REQUEST['telefono1'])) {
                $telefonoData = array(
                    'COUNTRY' => '',
                    'COUNTRYISO' => '',
                    'STD_NO' => '',
                    'TELEPHONE' => $_REQUEST['telefono1'],
                    'EXTENSION' => '',
                    'TEL_NO' => '',
                    'CALLER_NO' => '',
                    'STD_RECIP' => '',
                    'R_3_USER' => '',
                    'HOME_FLAG' => '',
                    'CONSNUMBER' => '000',
                    'ERRORFLAG' => '',
                    'FLG_NOUSE' => ''
                );

                $telefonoDataX = array(
                    'COUNTRY' => '',
                    'COUNTRYISO' => '',
                    'STD_NO' => '',
                    'TELEPHONE' => 'X',
                    'EXTENSION' => '',
                    'TEL_NO' => '',
                    'CALLER_NO' => '',
                    'STD_RECIP' => '',
                    'R_3_USER' => '',
                    'HOME_FLAG' => '',
                    'CONSNUMBER' => 'X',
                    'UPDATEFLAG' => 'U',
                    'FLG_NOUSE' => ''
                );
            }
            $interlocutor = $idestudiantegeneral;
            /* se debe actualiza la informacion del estudiant en people */
            // require_once('../../../interfacessap/modificarinterlocutorDirectamente.php');
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../prematricula/loginpru.php?codigocarrera=" . $row_dataestudiante['codigocarrera'] . "&estudiante=" . $row_dataestudiante['codigoestudiante'] . "'>";
        }
    }
}// grande
?>
<br>
<?php if ($txtActualizaDatos != 1) { ?>
                                <div align="center">
                                <input type="submit" name="guardar" value="guardar" id="guardar">
                                </div>
<?php } ?>
  </form>
  <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.13.1.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->  
<script language="javascript" type="text/javascript">
function recargar(direccioncompleta, direccioncompletalarga)
{
 document.form1.direccion1.value=direccioncompletalarga;
 document.form1.direccion1oculta.value=direccioncompleta;
}

function recargar1(direccioncompleta, direccioncompletalarga)
{
 document.form1.direccion2.value=direccioncompletalarga;
 document.form1.direccion2oculta.value=direccioncompleta;
}


function limpiarinicio(texto)
{
	if(texto.value == "aaaa-mm-dd")
		texto.value = "";
}
function iniciarinicio(texto)
{
	if(texto.value == "")
		texto.value = "aaaa-mm-dd";
}
   

$('input#guardar').click( function( ) {
           // event.preventDefault();
			var resultado = verifica_admitido();
			var guardar = $("#guardar").val( );
			var txtCodigoCreado = $('#txtCodigoCreado').val( );
			if(resultado){
				$.ajax({
			  		type: 'POST',
					url: '../../consulta/facultades/creacionestudiante/editarestudianteGrados.php?codigocreado='+txtCodigoCreado+'&usuarioeditar=facultad',
					data: $('#editarestudianteForm').serialize( )+ "&guardar="+guardar
				});
				
			}
			alert("Se modificaron los datos");
			$( "#mensageActualizarEstudiante" ).dialog( "close" );
			$( "#btnBuscarTMando" ).trigger( "click" );
			return false;
			
			
});


function verifica_admitido(){
	var situacion = $('#situacion').val();
	var guardar = $('#guardar').val();
	var tipoForm=$('#exCategoria').val();
	var tipoForm2=$('#exCategoriaTipo').val();
	var categoriavisa = $('#categoriavisa').val();
	var numerovisaT = $('#numerovisa').val();
	var numerovisa = $('#numerovisa1').val();
	var idpaisnacimiento = $('#idpaisnacimiento').val();
	var tipoPermiso = $('#tipoPermiso').val();
	var idpaisnacimiento= $('#idpaisnacimiento').val();
	
	var fechaexpediciovisa =  $('#fechaexpediciovisa1').val();
	if(fechaexpediciovisa == ''){
		var fechaexpediciovisa =  $('#fechaexpediciovisa').val();	
	}
	var fechavencimientovisa =  $('#fechavencimientovisa1').val();
	if(fechavencimientovisa == ''){
		var fechavencimientovisa =  $('#fechavencimientovisa').val();
	}
	var ciudadnacimiento = document.getElementsByName("ciudadnacimiento")[0].value;
	if(tipoPermiso == 1){
		if (categoriavisa == 0){
			alert('Debe Seleccionar Categoria Visa');
			return false;
		}
	}
	if(ciudadnacimiento != 2000){
		if(idpaisnacimiento != 1){
			alert('Verifique que la ciudad de nacimiento concuerde con el pais de nacimiento');
			return false;	
		}
	}else{
		if(idpaisnacimiento == 1){
			alert('Verifique que la ciudad de nacimiento concuerde con el pais de nacimiento');
			return false;	
		}
	}
	
	if(idpaisnacimiento != 1){
		if(numerovisaT ==''){
			if(numerovisa == ''){
					alert('Debe Digitar El número de tarjeta');
					return false;
				}
			}
		if(fechaexpediciovisa == ''){
			alert('Debe Seleccionar Fecha de Expedición de la tarjeta');
		return false;
		}
		if(fechavencimientovisa == ''){
			alert('Debe Seleccionar Fecha de Vencimiento de la tarjeta');
			return false;
		}
	}
	

	var respuesta = 1;
	$.ajax({
		type: 'POST',
		url: 'editarestudianteGrados.php',
		async: false,
		dataType: 'json',
		data:({action:'verificar_admitido', situacion: situacion, idestudiantegeneral: '<?php echo $idestudiantegeneral; ?>', 
		codigocarrera: '<?php echo $row_dataestudiante['codigocarrera']; ?>',guardar:guardar,fechaexpediciovisa:fechaexpediciovisa,
		fechavencimientovisa:fechavencimientovisa,categoriavisa:categoriavisa,numerovisa:numerovisa,numerovisaT:numerovisaT,idpaisnacimiento:idpaisnacimiento,tipoPermiso:tipoPermiso}),
		success: function(data){
			respuesta = data.respuesta;
			
			if(data.respuesta == 0){
				respuesta = 1;
			}else{
				var r = confirm('¿Está seguro que desea cambiar el estado a admitido?');
				if (r == true) {
					var nombres = $('#nombres2').val();
					var apellidos = $('#apellidos').val();
					var documento = $('#documento2').val();
					var email = $('#email3').val();
					$.ajax({
								type: 'POST',
								url: 'editarestudianteGrados.php',
								async: false,
								dataType: 'json',
								data:({action:'enviar_carta', nombres: nombres, apellidos: apellidos, nombrecarrera: '<?php echo $row_dataestudiante['nombrecarrera']; ?>', documento: documento, email: email}),
								success: function(data){
									respuesta = 1;
								}
					});
				}else{
					respuesta = 0;
					
					//location.reload();
				}
			}			
		}
	});
	if (respuesta == 0){
		
		return false;
	}else{
		
		return true;
	}
}
  $(document).ready(function () {
                $("#fechaexpediciovisa").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
                $('#ui-datepicker-div').css('display', 'none');
				$("#fechaexpediciovisa1").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
                $('#ui-datepicker-div').css('display', 'none');
				$("#fechavencimientovisa").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
				$("#fechavencimientovisa1").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
			var selectPrograma="<?php echo $TipoPermiso; ?>";
			$('#tipoPermiso > option[value="'+selectPrograma+'"]').attr('selected', 'selected');
			var CategoriaVisaId="<?php echo $CategoriaVisaId; ?>";
			var idpaisnacimiento ="<?php echo $idpaisnacimiento; ?>";
			if(idpaisnacimiento == ''){
				idpaisnacimiento=$('#idpaisnacimiento').val();
			}
			$('#idpaisnacimiento > option[value="'+idpaisnacimiento+'"]').attr('selected', 'selected');
			if(CategoriaVisaId != '0'){
				$('#categoriavisa > option[value="'+CategoriaVisaId+'"]').attr('selected', 'selected');
			}
			if(idpaisnacimiento !== '1'){
				if (idpaisnacimiento !== ''){
					$('#table_extranjero').css('display', 'block');	
				}
			}
			
			if(selectPrograma == '1'){
				$('#table_extranjero2').css('display', 'none');	
				$('#table_extranjero1').css('display', 'block');
				$(":text",$("#table_extranjero2")).val('');
				
			}else{
				if(selectPrograma !== ''){
					$('#table_extranjero1').css('display', 'none');
					$('#table_extranjero2').css('display', 'block');
					$(":text",$("#table_extranjero1")).val('');					
				
					
				}
			}if(selectPrograma == '2'){
					$('#table_extranjero2').css('display', 'block');	
					$('#table_extranjero1').css('display', 'none');
					$(":text",$("#table_extranjero1")).val('');					
			}
			if(selectPrograma == ''){
					$('#table_extranjero1').css('display', 'none');
					$('#table_extranjero2').css('display', 'none');
				}
                //$('#demo').before( oTableTools.dom.container );
            });
$(document).ready(function(){
				var CategoriaVisaId="<?php echo $CategoriaVisaId; ?>";
				if(CategoriaVisaId == '0'){
					$("#categoriavisa").css("display", "none"); 
				}if(CategoriaVisaId == ''){
					$("#categoriavisa").css("display", "none"); 
				}
				
				var visa; 
				$("#tipoPermiso").change(function(){
					visa=document.getElementById("tipoPermiso").value;
					
					if (visa == 1)
					{
						$("#categoriavisa").css("display", "block"); 	
						$('#table_extranjero1').css('display', 'block');
						$('#table_extranjero2').css('display', 'none');
						$(":text",$("#table_extranjero2")).val('');
					
					}
					else
					{
						$('#table_extranjero2').css('display', 'block');
						$('#table_extranjero1').css('display', 'none');						
						$(":text",$("#table_extranjero1")).val('');

					}
					if(visa=="")
					{
						$("#categoriavisa").css("display", "none");
						
					}
				});
			});
$(document).ready(function(){
	
	$('#idpaisnacimiento').change(function(){
	
		if($('#idpaisnacimiento option:selected').val() == 1){
			$('#table_extranjero1').css('display', 'none');
			$('#table_extranjero').css('display', 'none');
			$('#table_extranjero2').css('display', 'none');
		}else{
			$('#table_extranjero').css('display', 'block');
		}
	});
});
</script>
