<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php' );
require_once('../../../funciones/errores_creacionestudiante.php' );
require_once('../../../funciones/funcionip.php' );
@session_start();
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];
mysql_select_db($database_sala, $sala);
@session_start();
$usuarioeditar = $_GET['usuarioeditar'];
$ip = "SIN DEFINIR";
$ip = tomarip();
if (isset($_GET['codigocreado']))
  {
    $codigoestudiante = $_GET['codigocreado'];
  }
else
  if (isset($_SESSION['codigo']))
  {
    $codigoestudiante = $_SESSION['codigo'];
  }

if($_POST['regresar'])
{
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=menucrearnuevoestudiante.php'>";

 exit();
} 

$query_dataestudiante = "SELECT eg.idestudiantegeneral, c.nombrecarrera, eg.apellidosestudiantegeneral, 
eg.nombresestudiantegeneral, d.nombredocumento, eg.tipodocumento, eg.numerodocumento, eg.fechanacimientoestudiantegeneral, 
eg.expedidodocumento, e.codigojornada, j.nombrejornada, e.semestre, e.numerocohorte, e.codigotipoestudiante, 
t.nombretipoestudiante, e.codigosituacioncarreraestudiante, s.nombresituacioncarreraestudiante, eg.celularestudiantegeneral, 
eg.emailestudiantegeneral, eg.codigogenero, g.nombregenero, eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, 
eg.ciudadresidenciaestudiantegeneral, eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral, 
eg.ciudadcorrespondenciaestudiantegeneral, e.codigoestudiante,c.codigocarrera
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

if($totalRows_dataestudiante != "")
{
	$formulariovalido = 1;  

	$query_jornadas = "SELECT * FROM jornada";

	$jornadas = mysql_query($query_jornadas, $sala) or die(mysql_error());

	$row_jornadas = mysql_fetch_assoc($jornadas);

	$totalRows_jornadas = mysql_num_rows($jornadas);

	$query_tipoestudiante = "SELECT * FROM tipoestudiante";

	$tipoestudiante = mysql_query($query_tipoestudiante, $sala) or die(mysql_error());

	$row_tipoestudiante = mysql_fetch_assoc($tipoestudiante);

	$totalRows_tipoestudiante = mysql_num_rows($tipoestudiante);
    $query_situacionestudiante = "SELECT * 
	FROM situacioncarreraestudiante
	where codigosituacioncarreraestudiante not like '4%'	";
	$situacionestudiante = mysql_query($query_situacionestudiante, $sala) or die(mysql_error());
	$row_situacionestudiante = mysql_fetch_assoc($situacionestudiante);
	$totalRows_situacionestudiante = mysql_num_rows($situacionestudiante);

	$query_carreras = "SELECT codigocarrera, nombrecarrera FROM carrera where codigocarrera = '".$_SESSION['codigofacultad']."' order by 2 asc";
	$carreras = mysql_query($query_carreras, $sala) or die(mysql_error());
	$row_carreras = mysql_fetch_assoc($carreras);
	$totalRows_carreras = mysql_num_rows($carreras);
    $query_documentos = "SELECT * FROM documento";
	$documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
	$row_documentos = mysql_fetch_assoc($documentos);
	$totalRows_documentos = mysql_num_rows($documentos);

	$query_planestudios = "SELECT * FROM planestudio where codigocarrera = '".$_SESSION['codigofacultad']."' 
	                       and codigoestadoplanestudio like '1%'";
	$planestudios = mysql_query($query_planestudios, $sala) or die("$query_planestudios");
	$row_planestudios = mysql_fetch_assoc($planestudios);
	$totalRows_planestudios = mysql_num_rows($planestudios);

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

	$seldecisionestudiante = mysql_query($query_seldecisionestudiante, $sala) or die("$query_seldecisionestudiante");
	$row_seldecisionestudiante = mysql_fetch_assoc($seldecisionestudiante);
	$totalRows_seldecisionestudiante = mysql_num_rows($seldecisionestudiante);

	$query_dataestudianteplan = "select * 
    from planestudioestudiante pee, planestudio p 
	where pee.codigoestudiante = '$codigoestudiante'
	and p.idplanestudio = pee.idplanestudio";
	$dataestudianteplan = mysql_query($query_dataestudianteplan, $sala) or die("$query_dataestudiante".mysql_error());
	$row_dataestudianteplan = mysql_fetch_assoc($dataestudianteplan);
	$totalRows_dataestudianteplan = mysql_num_rows($dataestudianteplan);

?>
<html>
<head>
<title>Crear Estudiante</title>
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



<form name="form1" method="post" action="editarestudiante.php?codigocreado=<?php echo $codigoestudiante;?>&usuarioeditar=<?php echo $usuarioeditar;?>">



    <p align="center" class="Estilo3">EDITAR ESTUDIANTEEE</p>



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

			$prematriculaviva = mysql_query($query_prematriculaviva, $sala) or die("$query_prematriculaviva");
			$row_prematriculaviva = mysql_fetch_assoc($prematriculaviva);
			$totalRows_prematriculaviva = mysql_num_rows($prematriculaviva);
		}
		if($totalRows_prematriculaviva == "")
		{
?>
		  <select name="planestudio">
            <?php
			if($totalRows_dataestudianteplan == "")
			{

?>
            <option value="1" <?php if (!(strcmp(0,$row_dataestudianteplan['idplanestudio']))) {echo "SELECTED";} ?>>Seleccionar ...</option>
            <?php
			}

			do
			{


?>
            <option value="<?php echo $row_planestudios['idplanestudio'];?>"<?php if(!(strcmp($row_planestudios['idplanestudio'],$row_dataestudianteplan['idplanestudio']))) {echo "SELECTED";} ?>><?php echo $row_planestudios['nombreplanestudio']?></option>
            <?php
			}
			while ($row_planestudios = mysql_fetch_assoc($planestudios));
			$totalRows_planestudios = mysql_num_rows($planestudios);
			if($totalRows_planestudios > 0)
			{
				mysql_data_seek($planestudios, 0);
				$row_planestudios = mysql_fetch_assoc($planestudios);
			}
?></select>
          <?php
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


?>
        </span></font><span class="Estilo1"><font size="2" face="Tahoma">
        <?php
	echo "<span class='Estilo3'>";

 	if($_SESSION['MM_Username'] <> 'dirsecgeneral')
   	{
		if(isset($_POST['planestudio']))
		{
			$planestudio = $_POST['planestudio'];
			$imprimir = true;
			$prequerido = validar($planestudio,"combo",$error1,&$imprimir);
			$formulariovalido = $formulariovalido*$prequerido;
			if($_POST['planestudio'] == '1')
			{
				echo "Seleccionar plan de estudio";
				$formulariovalido = 0;
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
          <input name="apellidos" type="text" id="apellidos" value="<?php if(isset($_POST['apellidos'])) echo $_POST['apellidos']; else echo $row_dataestudiante['apellidosestudiantegeneral'];?>" size="30">
<?php
	echo "<span class='Estilo3'>";
	if(isset($_POST['apellidos']))
	{
		$apellidos = $_POST['apellidos'];
		$imprimir = true;
		$arequerido = validar($apellidos,"requerido",$error1,&$imprimir);

		$formulariovalido = $formulariovalido*$arequerido;
	}
	echo "</span>";
?></td>
        <td align="center" bgcolor="#C5D5D6" class="Estilo2">Nombres<span class="Estilo4">*</span></td>
        <td colspan="1"><div align="left"><font size="1" face="tahoma">
            <input name="nombres" type="text" id="nombres2" value="<?php if(isset($_POST['nombres'])) echo $_POST['nombres']; else echo $row_dataestudiante['nombresestudiantegeneral'];?>" size="30">
          </font><font size="2" face="Tahoma">

          <?php
	echo "<span class='Estilo3'>";
	if(isset($_POST['nombres']))
	{
		$nombres = $_POST['nombres'];
		$imprimir = true;
		$nrequerido = validar($nombres,"requerido",$error1,&$imprimir);


		$formulariovalido = $formulariovalido*$nrequerido;
	}
	echo "</span>";
?>
        </font><font size="1" face="tahoma">        </font></div></td>
	  <td bgcolor="#C5D5D6" colspan="1" class="Estilo2" align="center">Fecha de Nacimiento<span class="Estilo4">*</span></td>
        <td colspan="1"><div align="left"><font size="1" face="tahoma">
          <input name="fnacimiento" type="text" size="10" value="<?php if(isset($_POST['fnacimiento'])) echo $_POST['fnacimiento']; else echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_dataestudiante['fechanacimientoestudiantegeneral']); ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
          </font><font size="1" face="Tahoma"><font color="#FF0000">
          <?php
	if(isset($_POST['fnacimiento']))
	{
		$fnacimiento = $_POST['fnacimiento'];
		$imprimir = true;
		$ffecha = validar($fnacimiento,"fechaant",$error3,&$imprimir);
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
  			    <option value="<?php echo $row_documentos['tipodocumento']?>"<?php if (!(strcmp($row_documentos['tipodocumento'], $_POST['tipodocumento']))) {echo "SELECTED";} ?>><?php echo $row_documentos['nombredocumento']?></option>
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
		      </select>
		    <font size="2" face="Tahoma">
            <?php
	echo "<span class='Estilo3'>";
	if(isset($_POST['tipodocumento']))
	{
		$tipodocumento = $_POST['tipodocumento'];
		$imprimir = true;
		$tdrequerido = validar($tipodocumento,"combo",$error1,&$imprimir);
		$formulariovalido = $formulariovalido*$tdrequerido;
	}
	echo "</span>";
?>
		    </font> </div></td>
        <td align="center" bgcolor="#C5D5D6" class="Estilo2">N&uacute;mero<span class="Estilo4">*</span></td>
        <td colspan="1" align="center">
          <div align="left">
  <input name="documento" type="text" id="documento2" value="<?php if(isset($_POST['documento'])) echo $_POST['documento']; else echo $row_dataestudiante['numerodocumento'];?>" size="20">
<?php
	echo "<span class='Estilo3'>";
	if(isset($_POST['documento']))
	{
		$documento = $_POST['documento'];
		$imprimir = true;
		$ndrequerido = validar($documento,"requerido",$error1,&$imprimir);
		$ndnumero = validar($documento,"numero",$error2,&$imprimir);
		$formulariovalido = $formulariovalido*$ndrequerido*$ndnumero;
	}
	echo "</span>";
?>
          </div></td>
		<td bgcolor="#C5D5D6" align="center" class="Estilo2">Expedido en<span class="Estilo4">*</span></td>
        <td colspan="1" align="left" class="Estilo1">
              <input name="expedido" type="text" id="expedido3" value="<?php if(isset($_POST['expedido'])) echo $_POST['expedido']; else echo $row_dataestudiante['expedidodocumento'];?>" size="19">
            <?php

	echo "<span class='Estilo3'>";
	if(isset($_POST['expedido']))
	{
		$expedido = $_POST['expedido'];
		$imprimir = true;
		$erequerido = validar($expedido,"requerido",$error1,&$imprimir);
		$enombre = validar($expedido,"nombre",$error6,&$imprimir);
		$formulariovalido = $formulariovalido*$erequerido*$enombre;

	}
	echo "</span>";
?>
</td>
 	</tr>
	 <tr>

       <td bgcolor="#C5D5D6" class="Estilo2" align="center">Jornada<span class="Estilo4">*</span></td>

        <td class="Estilo1" align="center">
            <div align="left">
  <select name="jornada" id="select10">

		    <option value="<?php echo $row_dataestudiante['codigojornada'] ?>" selected><?php echo $row_dataestudiante['nombrejornada']?></option>
      <?php

	do
	{
		if($row_dataestudiante['codigojornada'] != $row_jornadas['codigojornada'])

        {

?>
            <option value="<?php echo $row_jornadas['codigojornada']?>"<?php if (!(strcmp($row_jornadas['codigojornada'], $_POST['jornada']))) {echo "SELECTED";} ?>><?php echo $row_jornadas['nombrejornada']?></option>

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
	echo "<span class='Estilo3'>";
	if(isset($_POST['jornada']))
	{
		$jornada = $_POST['jornada'];
		$imprimir = true;
		$jrequerido = validar($jornada,"combo",$error1,&$imprimir);
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
            <option value="<?php echo $i;?>"<?php if (!(strcmp($i, $_POST['semestre']))) {echo "SELECTED";} ?>><?php echo $i;?></option>
<?php
		}
	}
?>
          </select>

<?php
	echo "<span class='Estilo3'>";

	if(isset($_POST['semestre']))
	{
		$semestre = $_POST['semestre'];
		$imprimir = true;
		$srequerido = validar($semestre,"combo",$error1,&$imprimir);
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
?>
              <option value="<?php echo $row_selgenero['codigogenero']?>"<?php if (!(strcmp($row_selgenero['codigogenero'], $_POST['genero']))) {echo "SELECTED";} ?>><?php echo $row_selgenero['nombregenero']?></option>
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
	echo "<span class='Estilo3'>";
	if(isset($_POST['genero']))
	{
		$genero = $_POST['genero'];
		$imprimir = true;
		$grequerido = validar($genero,"combo",$error1,&$imprimir);
		$formulariovalido = $formulariovalido*$grequerido;
	}
	echo "</span>";
?>

          </div></td>
      </tr>

      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2" align="center">Tipo Estudiante<span class="Estilo4">*</span></td>
        <td colspan="2" class="Estilo1">
          <font size="1" face="tahoma">
          <select name="tipoestudiante" id="select13">
            <option value="<?php echo $row_dataestudiante['codigotipoestudiante'] ?>" selected><?php echo $row_dataestudiante['nombretipoestudiante']?></option>
            <?php
	do
	{
		 if($row_dataestudiante['codigotipoestudiante'] != $row_tipoestudiante['codigotipoestudiante'])
		{
?>
            <option value="<?php echo $row_tipoestudiante['codigotipoestudiante']?>"<?php if (!(strcmp($row_tipoestudiante['codigotipoestudiante'], $_POST['tipoestudiante']))) {echo "SELECTED";} ?>><?php echo $row_tipoestudiante['nombretipoestudiante']?></option>
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
	echo "<span class='Estilo3'>";

	if(isset($_POST['tipoestudiante']))
	{
		$tipoestudiante = $_POST['tipoestudiante'];
		$imprimir = true;
		$trequerido = validar($tipoestudiante,"combo",$error1,&$imprimir);
		$formulariovalido = $formulariovalido*$trequerido;
	}
	echo "</span>";
?>
</td>
        <td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Situaci&oacute;n Estudiante</td>
        <td colspan="2" align="left" class="Estilo1">

<?php
       if (substr($row_dataestudiante['codigosituacioncarreraestudiante'],0,1) <>  4)
	    {
?>
           <select name="situacion">
           <option value="<?php echo $row_dataestudiante['codigosituacioncarreraestudiante'] ?>" selected><?php echo $row_dataestudiante['nombresituacioncarreraestudiante']?></option>
              <?php
	do
	{
		if($row_dataestudiante['codigosituacioncarreraestudiante'] != $row_situacionestudiante['codigosituacioncarreraestudiante'])
		{
			if($row_dataestudiante['codigosituacioncarreraestudiante'] != 107)
			{

?>
              <option value="<?php echo $row_situacionestudiante['codigosituacioncarreraestudiante']?>"<?php if (!(strcmp($row_situacionestudiante['codigosituacioncarreraestudiante'], $_POST['situacion']))) {echo "SELECTED";} ?>><?php echo $row_situacionestudiante['nombresituacioncarreraestudiante']?></option>
              <?php
			}
			else
			{
				if($row_situacionestudiante['codigosituacioncarreraestudiante'] == 300 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 107)
				{
?>
           	      <option value="<?php echo $row_situacionestudiante['codigosituacioncarreraestudiante']?>"<?php if (!(strcmp($row_situacionestudiante['codigosituacioncarreraestudiante'], $_POST['situacion']))) {echo "SELECTED";} ?>><?php echo $row_situacionestudiante['nombresituacioncarreraestudiante']?></option>

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



<?php  



      



       }// if ($row_dataestudiante['codigosituacioncarreraestudiante'] <> 400 or $row_dataestudiante['codigosituacioncarreraestudiante'] <> 104)



	  else
	   {
	     echo $row_dataestudiante['nombresituacioncarreraestudiante'];
	     echo '<input name="situacion" type="hidden" value='.$row_dataestudiante['codigosituacioncarreraestudiante'].'>';
	   }

	echo "<span class='Estilo3'>";

	if(isset($_POST['situacion']))
	{
		$situacion = $_POST['situacion'];

		$imprimir = true;

		$srequerido = validar($situacion,"combo",$error1,&$imprimir);

		$formulariovalido = $formulariovalido*$srequerido;

	}

	echo "</span>";



?>



</td>



      </tr>



      <tr>



        <td bgcolor="#C5D5D6" class="Estilo2" align="center">Celular</td>



        <td colspan="2" class="Estilo1" align="left">



            <input name="celular" type="text" value="<?php if(isset($_POST['celular'])) echo $_POST['celular']; else echo $row_dataestudiante['celularestudiantegeneral'];?>" size="30">



        </td>



        <td bgcolor="#C5D5D6" align="center" class="Estilo2">E-mail</td>



        <td colspan="2">



            <input name="email" type="text" id="email3" value="<?php if(isset($_POST['email'])) echo $_POST['email']; else echo $row_dataestudiante['emailestudiantegeneral'];?>" size="30">



        </td>



	  </tr>



      <tr>



        



      <td height="27" bgcolor="#C5D5D6" class="Estilo2" align="center">Dir. Estudiante<span class="Estilo4">*</span></td>



        <td colspan="1" class="Estilo1" align="left">



  <input name="direccion1" type="text" value="<?php if(isset($_POST['direccion1'])) echo $_POST['direccion1']; else echo $row_dataestudiante['direccionresidenciaestudiantegeneral'];?>" size="30">



  <?php
	echo "<span class='Estilo3'>";

	if(isset($_POST['direccion1']))
	{
		$direccion1 = $_POST['direccion1'];

		$imprimir = true;
		$dr1requerido = validar($direccion1,"requerido",$error1,&$imprimir);
		$formulariovalido = $formulariovalido*$dr1requerido;
	}

	echo "</span>";

?>            </td>
        <td align="center" bgcolor="#C5D5D6" class="Estilo2">Tel&eacute;fono<span class="Estilo4">*</span></td>
        <td colspan="1" align="left">
  <input name="telefono1" type="text" id="telefono13" value="<?php if(isset($_POST['telefono1'])) echo $_POST['telefono1']; else echo $row_dataestudiante['telefonoresidenciaestudiantegeneral'];?>" size="22">
  <?php
	echo "<span class='Estilo3'>";

	if(isset($_POST['telefono1']))
	{
		$telefono1 = $_POST['telefono1'];
		$imprimir = true;
		$t1requerido = validar($telefono1,"requerido",$error1,&$imprimir);
		$formulariovalido = $formulariovalido*$t1requerido;
	}
	echo "</span>";
?>            </td>



        <td bgcolor="#C5D5D6" align="center" class="Estilo2">Ciudad<span class="Estilo4">*</span></td>



        <td align="left" class="Estilo1">



          <input name="ciudad1" type="text" id="ciudad15" value="<?php if(isset($_POST['ciudad1'])) echo $_POST['ciudad1']; else echo $row_dataestudiante['ciudadresidenciaestudiantegeneral'];?>" size="19">



          <?php
	echo "<span class='Estilo3'>";
	if(isset($_POST['ciudad1']))
	{
		$ciudad1 = $_POST['ciudad1'];
		$imprimir = true;
		$c1requerido = validar($ciudad1,"requerido",$error1,&$imprimir);
		$formulariovalido = $formulariovalido*$c1requerido;

	}
	echo "</span>";
?>



        </td>



      </tr>



      <tr>



        <td height="26" bgcolor="#C5D5D6" class="Estilo2" align="center">Dir. Correspondencia</td>



        <td colspan="1" class="Estilo1" align="left">



            <input name="direccion2" type="text" id="direccion22" value="<?php if(isset($_POST['direccion2'])) echo $_POST['direccion2']; else echo $row_dataestudiante['direccioncorrespondenciaestudiantegeneral'];?>" size="30">



        </td>



        <td align="center" bgcolor="#C5D5D6" class="Estilo2">Tel&eacute;fono</td>



        <td colspan="1" align="left" class="Estilo1">



            <input name="telefono2" type="text" id="telefono23" value="<?php if(isset($_POST['telefono2'])) echo $_POST['telefono2']; else echo $row_dataestudiante['telefonocorrespondenciaestudiantegeneral'];?>" size="22">



        </td>



        <td bgcolor="#C5D5D6" align="center" class="Estilo2">Ciudad</td>



        <td align="left" class="Estilo1">



              <input name="ciudad2" type="text" id="ciudad24" value="<?php if(isset($_POST['ciudad2'])) echo $_POST['ciudad2']; else echo $row_dataestudiante['ciudadcorrespondenciaestudiantegeneral'];?>" size="19">



         </td>



      </tr>



 </table> 



<?php

if($_POST['guardar'])
  {

if(trim($numerodocumentoinicial)=='0'||trim($numerodocumentoinicial)==''||!isset($numerodocumentoinicial))
	$formulariovalido=0;

if(trim($_POST['documento'])=='0'||trim($_POST['documento'])==''||!isset($_POST['documento']))
	$formulariovalido=0;

	if($formulariovalido)
	{
		// Lo primero que se mira es si el nuevo documento que se quiere insertar no este ya en estudiantedocumento en los activos
		// Esto para los estudiantes que son diferentes al actual
		$query_estudianteexiste = "select * from estudiantedocumento
		where numerodocumento = '".$_POST['documento']."'
		and fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
		and fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
		and idestudiantegeneral <> '$idestudiantegeneral'";
		$estudianteexiste = mysql_query($query_estudianteexiste, $sala) or die(mysql_error());
		$row_estudianteexiste = mysql_fetch_assoc($estudianteexiste);
		$totalRows_estudianteexiste = mysql_num_rows($estudianteexiste);

		if($totalRows_estudianteexiste != "")
		{
			echo '<script language="JavaScript">alert("El documento '.$_POST['documento'].' ya existe en el sistema"); hisroty.go(-1)</script>';  
			exit();

		}

		if($_POST['situacion'] == 103)
		{
			$query_ordenespagas = "SELECT *
			FROM ordenpago o
			WHERE codigoestadoordenpago LIKE '4%'									
			AND o.codigoestudiante = '".$codigoestudiante."'						  
			AND o.codigoperiodo = '$periodoactual'";	

			$ordenespagas = mysql_query($query_ordenespagas, $sala) or die(mysql_error());

			$row_ordenespagas = mysql_fetch_assoc($ordenespagas);

			$totalRows_ordenespagas = mysql_num_rows($ordenespagas);

            if($row_ordenespagas <> "")
			{
				echo '<script language="javascript"> 
				alert ("Este estudiante se encuentra en estado matriculado, se retiraran las materias inscritas") 
                </script>';
				$base="update prematricula set  codigoestadoprematricula = 50 
				where codigoestudiante = '".$codigoestudiante."'
				and codigoestadoprematricula like '4%'
				and codigoperiodo = '$periodoactual'"; 

	            $sol=mysql_db_query($database_sala,$base);	   

				$base1="update detalleprematricula set  codigoestadodetalleprematricula = 24 
				where idprematricula='". $row_ordenespagas['idprematricula']."'"; 

	            $sol1=mysql_db_query($database_sala,$base1);	

				$base2="update ordenpago set  codigoestadoordenpago = 52 
				where codigoestudiante = '".$codigoestudiante."'
				and codigoestadoordenpago like '4%'
				and codigoperiodo = '$periodoactual'";  

	            $sol2=mysql_db_query($database_sala,$base2);
			}
			else
			{
				$query_ordenespagas = "SELECT *
				FROM ordenpago o
				WHERE codigoestadoordenpago LIKE '1%'									
				AND o.codigoestudiante = '".$codigoestudiante."'						  
				AND o.codigoperiodo = '$periodoactual'";

				$ordenespagas = mysql_query($query_ordenespagas, $sala) or die(mysql_error());
				$row_ordenespagas = mysql_fetch_assoc($ordenespagas);
				$totalRows_ordenespagas = mysql_num_rows($ordenespagas);

				if ($row_ordenespagas <> "")
			    {
					echo '<script language="javascript">alert("Estudiante con prematricula activa por favor anulársela antes de retirarlo")</script>';
				  	echo '<script language="javascript">history.go(-1)</script>';

				}
			 }
		}

		$query_situacionestudiante1 = "SELECT *
		FROM historicosituacionestudiante										
		WHERE  codigoestudiante = '".$codigoestudiante."'
		ORDER BY idhistoricosituacionestudiante DESC";										 

		$situacionestudiante1 = mysql_query($query_situacionestudiante1, $sala) OR die(mysql_error());

	    $row_situacionestudiante1 = mysql_fetch_assoc($situacionestudiante1);

	    $totalRows_situacionestudiante1 = mysql_num_rows($situacionestudiante1);

		$fechahoy = date("Y-m-d G:i:s",time());


		if($_POST['situacion'] <> $row_situacionestudiante1['codigosituacioncarreraestudiante'])
		{
			$sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";

		    $sql.= "VALUES('0','".$codigoestudiante."','".$_POST['situacion']."','".$periodoactual."','".$fechahoy."','".$fechahoy."','2999-12-31','".$usuario."')"; 

			$result = mysql_query($sql,$sala);

			$query_updest1 = "UPDATE historicosituacionestudiante
            SET fechafinalhistoricosituacionestudiante = '".$fechahoy."'
    	    WHERE idhistoricosituacionestudiante = '".$row_situacionestudiante1['idhistoricosituacionestudiante']."'"; 

			$updest1 = mysql_query($query_updest1,$sala); 	  

		}	

		$query_tipo = "SELECT *
		FROM historicotipoestudiante										
		WHERE  codigoestudiante = '".$codigoestudiante."'
		ORDER BY idhistoricotipoestudiante DESC";

		$tipo = mysql_query($query_tipo, $sala) OR die(mysql_error());

	    $row_tipo = mysql_fetch_assoc($tipo);

	    $totalRows_tipo = mysql_num_rows($tipo);		

		if($_POST['tipoestudiante'] <> $row_tipo['codigotipoestudiante'])
		{
		  $sql1 = "insert into historicotipoestudiante(idhistoricotipoestudiante,codigoestudiante,codigotipoestudiante,codigoperiodo,fechahistoricotipoestudiante,fechainiciohistoricotipoestudiante,fechafinalhistoricotipoestudiante,usuario,iphistoricotipoestudiante)";
		  $sql1.= "VALUES('0','".$codigoestudiante."','".$_POST['tipoestudiante']."','".$periodoactual."','".$fechahoy."','".$fechahoy."','2999-12-31','".$usuario."','$ip')";
		  $result1 = mysql_query($sql1,$sala);	
			$query_updest1 = "UPDATE historicotipoestudiante
            SET fechafinalhistoricotipoestudiante = '".$fechahoy."'
    	    WHERE idhistoricotipoestudiante = '".$row_tipo['idhistoricotipoestudiante']."'";



			$updest1 = mysql_query($query_updest1,$sala); 	  

		}	


		if($_POST['documento'] <> $numerodocumentoinicial)

		{

			$query_insdocumento = "INSERT INTO estudiantedocumento(idestudiantedocumento, idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento) 
		    VALUES(0, '$idestudiantegeneral', '".$_POST['tipodocumento']."', '".$_POST['documento']."', '".$_POST['expedido']."', '$fechahoy', '2999-12-31')"; 

			if(!($insdocumento = mysql_query($query_insdocumento,$sala)))

			 {

				$query_upddocumento = "UPDATE estudiantedocumento
				SET fechavencimientoestudiantedocumento='2999-12-31'
				WHERE idestudiantegeneral = '$idestudiantegeneral'
				and numerodocumento = '".$_POST['documento']."'";

				$upddocumento = mysql_query($query_upddocumento,$sala);	

			 }

			$fechahabil = date("Y-m-d");

			$unDiaMenos = strtotime("-1 day", strtotime($fechahabil));	

			$fechahabil = date("Y-m-d", $unDiaMenos);		

				

			$query_upddocumento = "UPDATE estudiantedocumento
    		SET fechavencimientoestudiantedocumento='$fechahabil'
    		WHERE idestudiantegeneral = '$idestudiantegeneral'
			and numerodocumento = '$numerodocumentoinicial'";


			$upddocumento = mysql_query($query_upddocumento,$sala) or die("$query_upddocumento".mysql_error());			

			$query_updusuario = "UPDATE usuario
			SET numerodocumento = '".$_POST['documento']."'
			WHERE numerodocumento = '$numerodocumentoinicial'";			

			$updusuario = mysql_query($query_updusuario,$sala) or die("$query_updusuario".mysql_error());

		}	



		$query_updestudiantegeneral = "UPDATE estudiantegeneral
    	SET tipodocumento='".$_POST['tipodocumento']."',
		numerodocumento='".$_POST['documento']."', 
		expedidodocumento='".$_POST['expedido']."',
		nombrecortoestudiantegeneral='".$_POST['documento']."',
		nombresestudiantegeneral='".$_POST['nombres']."',
		apellidosestudiantegeneral='".$_POST['apellidos']."',
		fechanacimientoestudiantegeneral='".$_POST['fnacimiento']."',
		codigogenero='".$_POST['genero']."',
		direccionresidenciaestudiantegeneral='".$_POST['direccion1']."',
		ciudadresidenciaestudiantegeneral='".$_POST['ciudad1']."',
		telefonoresidenciaestudiantegeneral='".$_POST['telefono1']."',
		telefono2estudiantegeneral='".$_POST['telefono2']."',
		celularestudiantegeneral='".$_POST['celular']."',
		direccioncorrespondenciaestudiantegeneral='".$_POST['direccion2']."',
		ciudadcorrespondenciaestudiantegeneral='".$_POST['ciudad2']."',
		telefonocorrespondenciaestudiantegeneral='".$_POST['telefono2']."',
		emailestudiantegeneral='".$_POST['email']."',
		fechaactualizaciondatosestudiantegeneral='".date("Y-m-d G:i:s",time())."'
		WHERE idestudiantegeneral = '$idestudiantegeneral'";

		$updestudiantegeneral = mysql_query($query_updestudiantegeneral,$sala) or die("$query_updestudiantegeneral".mysql_error());    

		$query_updestudiante = "UPDATE estudiante

		SET semestre='".$_POST['semestre']."',
		codigotipoestudiante='".$_POST['tipoestudiante']."',
		codigosituacioncarreraestudiante='".$_POST['situacion']."',
		codigojornada='".$_POST['jornada']."'
		WHERE codigoestudiante = '$codigoestudiante'";

		$updestudiante = mysql_query($query_updestudiante,$sala) or die("$query_updestudiantegeneral".mysql_error());



		



		//exit();   



		if ($_SESSION['MM_Username'] =='dirsecgeneral')



        {



		 	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudiante.php?codigocreado=".$codigoestudiante."'>";



			echo '<script language="JavaScript">history.go(-2);</script>';				        	     



           	exit();  



		} 



		if($totalRows_dataestudianteplan == "")



		{



			$query_insplanestudioestudiante = "INSERT INTO planestudioestudiante(idplanestudio, codigoestudiante, fechaasignacionplanestudioestudiante, fechainicioplanestudioestudiante, fechavencimientoplanestudioestudiante, codigoestadoplanestudioestudiante) 



    		VALUES('".$_POST['planestudio']."', '$codigoestudiante', '".date("Y-m-d")."', '".date("Y-m-d")."', '2999-12-31', '101')"; 



			//echo "<br>".$query_insplanestudioestudiante."<br>";



			//exit();



			$insplanestudioestudiante = mysql_query($query_insplanestudioestudiante,$sala); 



		}



		else



		{



			$query_planestudioestudiante = "UPDATE planestudioestudiante 



			SET idplanestudio='".$_POST['planestudio']."', fechaasignacionplanestudioestudiante='".date("Y-m-d")."'



			WHERE codigoestudiante = '$codigoestudiante'"; 



			//echo "<br>".$query_planestudioestudiante."<br>";



			//exit();



			$planestudioestudiante = mysql_query($query_planestudioestudiante,$sala); 



		}		



    }



    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../prematricula/loginpru.php?codigocarrera=".$row_dataestudiante['codigocarrera']."&estudiante=".$row_dataestudiante['codigoestudiante']."'>";



  }



}// grande



?>



<script language="javascript">



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



</script>



<script language="javascript">



function recargar(dir)



{



	window.location.reload("editarestudiante.php"+dir);



	history.go();



}



</script>







<br>



<div align="center">



<input type="submit" name="guardar" value="Guardar">



</div>



</form>