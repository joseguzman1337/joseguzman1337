<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php' ); 
require_once('../../../funciones/errores_creacionestudiante.php' );
session_start();
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];
mysql_select_db($database_sala, $sala);
session_start();
//require_once('seguridadcrearestudiante.php');
$usuarioeditar = $_GET['usuarioeditar']; 

$query_existeestudiante = "SELECT * FROM estudiante 
where idestudiantegeneral = '$idestudiantegeneral'
and codigocarrera = '".$_SESSION['codigofacultad']."'";
$existeestudiante = mysql_query($query_existeestudiante, $sala) or die(mysql_error());
$row_existeestudiante = mysql_fetch_assoc($existeestudiante);
$totalRows_existeestudiante = mysql_num_rows($existeestudiante);
if($totalRows_existeestudiante != "")
{
?>
<script language="javascript">
	alert("Este estudiante ya pertenece a la Facultad");
	history.go(-1);
</script>
<?php
}
if(isset($_GET['estudiantegeneral']))
{
	$idestudiantegeneral = $_GET['estudiantegeneral'];
   	// $_SESSION['codigo']= $codigoestudiante;
	//echo $codigoestudiante;
}
else if(isset($_SESSION['codigo']))
{
	$codigoestudiante = $_SESSION['codigo'];
}
if($_POST['regresar'])
{
  	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=menucrearnuevoestudiante.php'>";	        	     
 	exit();
} 

$query_dataestudiante = "SELECT eg.idestudiantegeneral, eg.apellidosestudiantegeneral, 
eg.nombresestudiantegeneral, d.nombredocumento, eg.tipodocumento, eg.numerodocumento, eg.fechanacimientoestudiantegeneral, 
eg.expedidodocumento, eg.celularestudiantegeneral, eg.emailestudiantegeneral, eg.codigogenero, g.nombregenero, eg.direccionresidenciaestudiantegeneral, 
eg.telefonoresidenciaestudiantegeneral, eg.ciudadresidenciaestudiantegeneral, eg.direccioncorrespondenciaestudiantegeneral, 
eg.telefonocorrespondenciaestudiantegeneral, eg.ciudadcorrespondenciaestudiantegeneral
FROM documento d, genero g, estudiantegeneral eg
WHERE eg.tipodocumento = d.tipodocumento
AND eg.codigogenero = g.codigogenero
and eg.idestudiantegeneral = '$idestudiantegeneral'";
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);
$idestudiantegeneral = $row_dataestudiante['idestudiantegeneral'];
$numerodocumentoinicial = $row_dataestudiante['numerodocumento'];
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
	
	$query_situacionestudiante = "SELECT * FROM situacioncarreraestudiante";
	$situacionestudiante = mysql_query($query_situacionestudiante, $sala) or die(mysql_error());
	$row_situacionestudiante = mysql_fetch_assoc($situacionestudiante);
	$totalRows_situacionestudiante = mysql_num_rows($situacionestudiante);
	
	//mysql_select_db($database_sala, $sala);
	$query_carreras = "SELECT codigocarrera, nombrecarrera FROM carrera where codigocarrera = '".$_SESSION['codigofacultad']."' order by 2 asc";
	$carreras = mysql_query($query_carreras, $sala) or die(mysql_error());
	$row_carreras = mysql_fetch_assoc($carreras);
	$totalRows_carreras = mysql_num_rows($carreras);
	
	//mysql_select_db($database_sala, $sala);
	$query_documentos = "SELECT * FROM documento";
	$documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
	$row_documentos = mysql_fetch_assoc($documentos);
	$totalRows_documentos = mysql_num_rows($documentos);
	
	//mysql_select_db($database_sala, $sala);
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
	
	$query_seldecisionestudiante = "select d.nombredecisionuniversidad, e.codigodecisionuniversidad
	FROM decisionuniversidad d, estudiantedecisionuniversidad e 
	WHERE d.codigodecisionuniversidad = e.codigodecisionuniversidad
	and e.codigoestudiante = '$codigoestudiante'";
	//echo $query_seldecisionestudiante;
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
<title>Crear Estudiante Carrera</title>
</head>
<style type="text/css">
<!--
.Estilo3 {
	color: #FF0000;
	font-size: 8pt;
}
-->
</style>
<body>
<form name="form1" method="post" action="editarestudiantecarrera.php?estudiantegeneral=<?php echo $idestudiantegeneral;?>&usuarioeditar=<?php echo $usuarioeditar;?>">
    <p align="center"><strong>CREAR ESTUDIANTE EN LA FACULTAD</strong></p>
    <table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" colspan="3" align="center"><font size="1" face="tahoma"><strong>Facultad*</strong></font></td>
        <td colspan="3" align="center"><font size="1" face="tahoma"><strong><?php echo $row_carreras['nombrecarrera']; ?></strong></font></td>
	  </tr>
      <tr>
        <td width="91" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Apellidos*</strong></font></div></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['apellidosestudiantegeneral'];?></strong></font></td>
        <td bgcolor="#C5D5D6" width="131"><div align="center"><font size="1" face="tahoma"><strong>Nombres*</strong></font></div></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['nombresestudiantegeneral'];?></strong></font></td>
	    <td width="90" bgcolor="#C5D5D6" colspan="1"><div align="center"><font size="1" face="tahoma"><strong>Fecha de Nacimiento* </strong></font></div></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_dataestudiante['fechanacimientoestudiantegeneral']); ?></strong></font></td>
    </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>T. Documento*</strong></font></div></td>
        <td colspan="1" align="center"><font size="1" face="Tahoma"><strong><?php echo $row_dataestudiante['nombredocumento']?></strong></font></td>
        <td width="90" bgcolor="#C5D5D6"><font size="1" face="tahoma"><strong>N&uacute;mero* </strong></font></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['numerodocumento'];?></strong></font></td>
		<td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Expedido en*</strong> </font></div></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['expedidodocumento'];?></strong></font></td>
 	</tr>
	 <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Jornada*</strong></font></div></td>
        <td><div align="center"><font size="1" face="tahoma">
            <select name="jornada" id="select10">
			<option value="0" selected>Seleccionar...</option>
			
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
</font><font size="2" face="Tahoma">
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
</font><font size="1" face="tahoma">        </font></div></td>
        <td colspan="1" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Semestre*</strong></font></div>          <div align="center">
        </div></td>
        <td><font size="1" face="tahoma">
          <select name="semestre">
            <option value="0" selected>Seleccionar...</option>
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
</font><font size="2" face="Tahoma">
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
</font><font size="1" face="tahoma">&nbsp;        </font></td>
	<td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Genero*</strong></font></div></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['nombregenero']?></strong></font></td>
      </tr>
      <tr>
        <td width="107" bgcolor="#C5D5D6"><div align="center"><strong><font size="1" face="tahoma">Tipo Estudiante* </font></strong></div></td>
        <td colspan="2"><div align="center">
          <font size="1" face="tahoma">
          <select name="tipoestudiante" id="select13">
            <option value="0" selected>Seleccionar...</option>
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
          </font><font size="1" face="tahoma">          </font><font size="2" face="Tahoma">

          </font><font size="1" face="tahoma">          </font></div></td>
        <td colspan="1" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Situaci&oacute;n Estudiante</strong></font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
          <select name="situacion">
            <option value="0" selected>Seleccionar...</option>
            <?php
	do 
	{  
		if($row_dataestudiante['codigosituacioncarreraestudiante'] != $row_situacionestudiante['codigosituacioncarreraestudiante'])
		{
			if($row_dataestudiante['codigosituacioncarreraestudiante'] != 70) 
			{	
?>
            <option value="<?php echo $row_situacionestudiante['codigosituacioncarreraestudiante']?>"<?php if (!(strcmp($row_situacionestudiante['codigosituacioncarreraestudiante'], $_POST['situacion']))) {echo "SELECTED";} ?>><?php echo $row_situacionestudiante['nombresituacioncarreraestudiante']?></option>
            <?php
			}
			else
			{
				if($row_situacionestudiante['codigosituacioncarreraestudiante'] == 60 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 70) 
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
</font><font size="2" face="Tahoma">
<?php
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
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Celula</strong>r</font></div></td>
        <td colspan="2" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['celularestudiantegeneral'];?>&nbsp;</strong></font></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="1" face="tahoma"><strong>E-mail </strong></font></div></td>
        <td colspan="2" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['emailestudiantegeneral'];?>&nbsp;</strong></font></td>
	  </tr>
      <tr>
        
      <td height="27" bgcolor="#C5D5D6">
<div align="center"><font size="1" face="tahoma"><strong>Dir. Estudiante*</strong></font></div></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['direccionresidenciaestudiantegeneral'];?>&nbsp;</strong></font></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="1" face="tahoma"><strong>Tel&eacute;fono* </strong></font></div></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['telefonoresidenciaestudiantegeneral'];?>&nbsp;</strong> </font></td>
        <td width="50" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Ciudad*</strong> </font></div></td>
        <td width="121" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['ciudadresidenciaestudiantegeneral'];?>&nbsp;</strong></font></td>
      </tr>
      <tr>
        <td height="26" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Dir.Correspondencia</strong></font></div></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['direccioncorrespondenciaestudiantegeneral'];?>&nbsp;</strong></font></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="1" face="tahoma"><strong>Tel&eacute;fono:</strong></font></div></td>
        <td colspan="1" align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['telefonocorrespondenciaestudiantegeneral'];?>&nbsp;</strong></font></td>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Ciudad:</strong> </font></div></td>
        <td align="center"><font size="1" face="tahoma"><strong><?php echo $row_dataestudiante['ciudadcorrespondenciaestudiantegeneral'];?>&nbsp;</strong></font></td>
      </tr>
	</table>
    <p align="center">
      <input name="crear" type="submit" id="crear" value="Crear" style="width: 80px">

      &nbsp;
      <input name="regresar" type="button" id="regresar" value="Regresar" onClick="history.go(-1)" style="width: 80px">
  </p>
</form>
</body>
</html>
<?php
}
/* //////////////////////////
else
{
?>
<script language="javascript">
	alert("Este estudiante no tiene asignado un plan de estudio");
	history.go(-1);
</script>
<?php
	exit();
}  *///////////////////////////////

if($_POST['crear'])
{
	//exit();
	if($formulariovalido)
	{
		$query_selgenero = "select codigoperiodo from periodo where codigoestadoperiodo = '1'";
		$selgenero = mysql_query($query_selgenero, $sala) or die("$query_selgenero");
		$totalRows_selgenero = mysql_num_rows($selgenero);
		$row_selgenero = mysql_fetch_assoc($selgenero);

		// Inserta los datos del estudiante asignando la nueva carrera
		$query_selmaxestudiante = "select max(codigoestudiante*1) as mayorcodigo
		from estudiante";	
		//echo "$query_selmaxestudiante";
		$selmaxestudiante = mysql_db_query($database_sala,$query_selmaxestudiante) or die("$query_selmaxestudiante".mysql_error());     
		$row_selmaxestudiante=mysql_fetch_array($selmaxestudiante);	
		$codigoestudiantenuevo = $row_selmaxestudiante['mayorcodigo'] + 1;
		
		$query_insestudiantecarrera = "INSERT INTO estudiante(codigoestudiante, idestudiantegeneral, codigocarrera, semestre, numerocohorte, codigotipoestudiante, codigosituacioncarreraestudiante, codigoperiodo, codigojornada) 
		VALUES('$codigoestudiantenuevo', '$idestudiantegeneral', '".$row_carreras['codigocarrera']."', '".$_POST['semestre']."', '1', '".$_POST['tipoestudiante']."', '".$_POST['situacion']."', '".$row_selgenero['codigoperiodo']."', '".$_POST['jornada']."')"; 
		//echo "$query_insestudiantecarrera <br>";
		$insestudiantecarrera = mysql_db_query($database_sala,$query_insestudiantecarrera) or die("query_insestudiantecarrera".mysql_error());
		
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudiante.php?codigocreado=".$codigoestudiantenuevo."'&usuarioeditar=".$usuarioeditar.">";	        	     
	}
	else
	{
		//echo "correpto";
	}
}
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
