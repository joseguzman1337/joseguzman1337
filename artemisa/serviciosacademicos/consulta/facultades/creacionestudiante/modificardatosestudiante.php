<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);  
     
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php' ); 
require_once('../../../funciones/errores_creacionestudiante.php' ); 

mysql_select_db($database_sala, $sala);
session_start();
require_once('seguridadcrearestudiante.php');
$codigoestudiante = $_SESSION['codigo'];

if($_POST['regresar'])
{
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=menucrearnuevoestudiante.php'>";	        	     
  exit();
} 

$query_dataestudiante = "select c.nombrecarrera, pe.idplanestudio, pe.nombreplanestudio, e.apellidosestudiante, 
e.nombresestudiante, d.nombredocumento, d.tipodocumento, e.numerodocumento, e.fechanacimientoestudiante, 
e.expedidodocumento, e.codigojornada, j.nombrejornada, e.semestre, e.numerocohorte, e.codigotipoestudiante, 
t.nombretipoestudiante, e.codigosituacioncarreraestudiante, s.nombresituacioncarreraestudiante, e.celularestudiante, 
e.emailestudiante, e.codigogenero, g.nombregenero, e.direccionresidenciaestudiante, e.telefonoresidenciaestudiante, 
e.ciudadresidenciaestudiante, e.direccioncorrespondenciaestudiante, e.telefonocorrespondenciaestudiante, 
e.ciudadcorrespondenciaestudiante
from estudiante e, carrera c, planestudio pe, planestudioestudiante pee, documento d, jornada j, tipoestudiante t, situacioncarreraestudiante s, genero g
where e.codigocarrera = c.codigocarrera
and e.codigoestudiante = pee.codigoestudiante
and pee.idplanestudio = pe.idplanestudio
and pe.codigoestadoplanestudio = '101'
and e.tipodocumento = d.tipodocumento
and e.codigojornada = j.codigojornada
and e.codigotipoestudiante = t.codigotipoestudiante
and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
and e.codigogenero = g.codigogenero
and e.codigoestudiante = '$codigoestudiante'";
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);

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
	$query_planestudios = "SELECT * FROM planestudio where codigocarrera = '".$_SESSION['codigofacultad']."' and codigoestadoplanestudio like '1%'";
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
	
	$query_seldecisionestudiante = "select d.nombredecisionuniversidad
	from decisionuniversidad d, estudiantedecisionuniversidad e
	where d.codigodecisionuniversidad =  e.codigodecisicionuniversidad
	and e.codigoestudiante = '$codigoestudiante'";
	$seldecisionestudiante = mysql_query($query_seldecisionestudiante, $sala) or die("$query_seldecisionestudiante");
	$row_seldecisionestudiante = mysql_fetch_assoc($seldecisionestudiante);
	$totalRows_seldecisionestudiante = mysql_num_rows($seldecisionestudiante);
?>
<form name="form1" method="post" action="modificardatosestudiante.php">
    <p align="center"><strong><font size="2" face="Tahoma">DATOS ACTUALES ESTUDIANTE</font></strong></p>
    <p align="center">&nbsp;
	  <font color="#660000" size="4" face="tahoma">Por favor Actualice sus datos</font><?php }  	
	?></p>
    <table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
      <tr>
        <td width="91" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Facultad*</strong></font></div></td>
        <td colspan="3" ><div align="center"><font size="1" face="tahoma">
          <strong><?php echo $row_dataestudiante['nombrecarrera'] ?></strong>
		  </font></div></td>
		<td colspan="2" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Plan de Estudio * </strong></font></div></td>
		<td colspan="3" ><?php echo $row_dataestudiante['nombreplanestudio'] ?></td>
	  </tr>
      <tr>
        <td width="91" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Apellidos*</strong></font></div></td>
        <td colspan="3">
          <div align="center"><font size="1" face="tahoma">
          <input name="apellidos" type="text" id="apellidos" value="<?php if(isset($_POST['apellidos'])) echo $_POST['apellidos']; else echo $row_dataestudiante['apellidosestudiante'];?>" size="30">
</font><font size="2" face="Tahoma">
<?php
	echo "<span class='Estilo3'>";
	if(isset($_POST['apellidos']))
	{
		$apellidos = $_POST['apellidos'];
		$imprimir = true;
		$arequerido = validar($apellidos,"requerido",$error1,&$imprimir);
		$anombre = validar($apellidos,"nombre",$error6,&$imprimir);
		$formulariovalido = $formulariovalido*$arequerido*$anombre;
	}
	echo "</span>";
?>
</font><font size="1" face="tahoma">          </font></div></td>
        <td bgcolor="#C5D5D6" width="131"><div align="center"><font size="1" face="tahoma"><strong>Nombres*</strong></font></div></td>
        <td colspan="3"><div align="center"><font size="1" face="tahoma">
            <input name="nombres" type="text" id="nombres2" value="<?php if(isset($_POST['nombres'])) echo $_POST['nombres']; else echo $row_dataestudiante['nombresestudiante'];?>" size="30">
</font><font size="2" face="Tahoma">
<?php
	echo "<span class='Estilo3'>";
	if(isset($_POST['nombres']))
	{
		$nombres = $_POST['nombres'];
		$imprimir = true;
		$nrequerido = validar($nombres,"requerido",$error1,&$imprimir);
		$nnombre = validar($nombres,"nombre",$error6,&$imprimir);
		$formulariovalido = $formulariovalido*$nrequerido*$nnombre;
	}
	echo "</span>";
?>
</font><font size="1" face="tahoma">        </font></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>T. Documento*</strong></font></div></td>
        <td colspan="2"><div align="center"><font size="2" face="Tahoma">
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
		</font>		</td>
        <td width="90" bgcolor="#C5D5D6">
          <div align="center"><font size="1" face="tahoma"><strong>N&uacute;mero* </strong></font></div></td>
        <td colspan="1"><div align="center"><font size="1" face="tahoma">
          <input name="documento" type="text" id="documento2" value="<?php if(isset($_POST['documento'])) echo $_POST['documento']; else echo $row_dataestudiante['numerodocumento'];?>" size="20">
        </font><font size="2" face="Tahoma">
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
        </font></div></td>
		<td width="90" bgcolor="#C5D5D6" colspan="2">
          <div align="center"><font size="1" face="tahoma"><strong>Fecha de Nacimiento* </strong></font></div></td>
        <td colspan="1"><div align="center"><font size="1" face="tahoma">
          <input name="fnacimiento" type="text" size="10" value="<?php if(isset($_POST['fnacimiento'])) echo $_POST['fnacimiento']; else echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_dataestudiante['fechanacimientoestudiante']); ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
</font><font size="1" face="Tahoma"><font color="#FF0000">
<?php
	if(isset($_POST['fnacimiento']))
	{
		$fnacimiento = $_POST['fnacimiento'];
		$imprimir = true;
		$ffecha = validar($fnacimiento,"fechaant",$error3,&$imprimir);
		//echo "asda".$pefechainiciofecha;
		$formulariovalido = $formulariovalido*$ffecha;
	}
?>
</font></font><font size="1" face="tahoma">		 </font></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Expedido en*</strong> </font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
            <input name="expedido" type="text" id="expedido3" value="<?php if(isset($_POST['expedido'])) echo $_POST['expedido']; else echo $row_dataestudiante['expedidodocumento'];?>" size="25">
        </font><font size="2" face="Tahoma">
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
        </font></div></td>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Jornada*</strong></font></div></td>
        <td><?php echo $row_dataestudiante['nombrejornada'] ?></td>
        <td colspan="2" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Semestre*</strong></font></div>          <div align="center">
        </div></td>
        <td><?php echo $row_dataestudiante['semestre'] ?></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Nro Cohorte*</strong></font> </div></td>
        <td width="59"><?php echo $row_dataestudiante['numerocohorte'] ?></td>
        <td width="107" bgcolor="#C5D5D6"><div align="center"><strong><font size="1" face="tahoma">Tipo Estudiante* </font></strong></div></td>
        <td><?php echo $row_dataestudiante['nombretipoestudiante'] ?></td>
        <td colspan="2" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Situaci&oacute;n Estudiante</strong></font></div></td>
        <td colspan="2"><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'] ?>
	</td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Celula</strong>r</font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
            <input name="celular" type="text" value="<?php if(isset($_POST['celular'])) echo $_POST['celular']; else echo $row_dataestudiante['celularestudiante'];?>" size="30">
        </font></div></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="1" face="tahoma"><strong>E-mail </strong></font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
            <input name="email" type="text" id="email3" value="<?php if(isset($_POST['email'])) echo $_POST['email']; else echo $row_dataestudiante['emailestudiante'];?>" size="30">
        </font></div></td>
		<td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Genero*</strong></font></div></td>
        <td><div align="center"><font size="1" face="tahoma">
          <select name="genero">
              <option value="<?php echo $row_dataestudiante['codigogenero'] ?>" selected><?php echo $row_dataestudiante['nombregenero']?></option>
<?php
	do 
	{ 
		if($row_selgenero['codigogenero'] != $row_dataestudiante['codigogenero'])
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
</font><font size="2" face="Tahoma">
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
</font><font size="1" face="tahoma">        </font></div></td>
      </tr>
      <tr>
        
      <td height="27" bgcolor="#C5D5D6">
<div align="center"><font size="1" face="tahoma"><strong>Dir. Estudiante*</strong></font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
            <input name="direccion1" type="text" value="<?php if(isset($_POST['direccion1'])) echo $_POST['direccion1']; else echo $row_dataestudiante['direccionresidenciaestudiante'];?>" size="30">
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
?>
         </font></div></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="1" face="tahoma"><strong>Tel&eacute;fono* </strong></font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
            <input name="telefono1" type="text" id="telefono13" value="<?php if(isset($_POST['telefono1'])) echo $_POST['telefono1']; else echo $row_dataestudiante['telefonoresidenciaestudiante'];?>" size="22">
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
?>
        </font></div></td>
        <td width="50" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Ciudad*</strong> </font></div></td>
        <td width="121"><div align="center"><font size="1" face="tahoma">
          <input name="ciudad1" type="text" id="ciudad15" value="<?php if(isset($_POST['ciudad1'])) echo $_POST['ciudad1']; else echo $row_dataestudiante['ciudadresidenciaestudiante'];?>" size="19">
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
        </font></div></td>
      </tr>
      <tr>
        <td height="26" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Dir.Correspondencia</strong></font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
            <input name="direccion2" type="text" id="direccion22" value="<?php if(isset($_POST['direccion2'])) echo $_POST['direccion2']; else echo $row_dataestudiante['direccioncorrespondenciaestudiante'];?>" size="30">
        </font></div></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="1" face="tahoma"><strong>Tel&eacute;fono:</strong></font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
            <input name="telefono2" type="text" id="telefono23" value="<?php if(isset($_POST['telefono2'])) echo $_POST['telefono2']; else echo $row_dataestudiante['telefonocorrespondenciaestudiante'];?>" size="22">
        </font></div></td>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Ciudad:</strong> </font></div></td>
        <td><div align="center"><font size="1" face="tahoma">
            <input name="ciudad2" type="text" id="ciudad24" value="<?php if(isset($_POST['ciudad2'])) echo $_POST['ciudad2']; else echo $row_dataestudiante['ciudadcorrespondenciaestudiante'];?>" size="19">
        </font></div></td>
      </tr>
    </table>
    <p align="center">&nbsp;</p>
    <p align="center">
      <input name="guardar" type="submit" id="guardar" value="Guardar Cambios">
      &nbsp;&nbsp;
<?php
 
	if ($rol == '3')
	  {
	   echo "<input type='button' onClick='history.go(-1)' value='Regresar'>";
      }  
?>
</p>
</form>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
<?php
}
else
{
?>
<script language="javascript">
	alert("Este estudiante no tiene asignado un plan de estudio");
	history.go(-1);
</script>
<?php
	exit();
}
if($_POST['guardar'])
{
	if($formulariovalido)
	{
		//echo  $estudiante;
		$query_updest = "UPDATE estudiante 
    	SET tipodocumento='".$_POST['tipodocumento']."', numerodocumento='".$_POST['documento']."', expedidodocumento='".$_POST['expedido']."', nombresestudiante='".$_POST['nombres']."', apellidosestudiante='".$_POST['apellidos']."', fechanacimientoestudiante='".$_POST['fnacimiento']."', codigogenero='".$_POST['genero']."', direccionresidenciaestudiante='".$_POST['direccion1']."', ciudadresidenciaestudiante='".$_POST['ciudad1']."', telefonoresidenciaestudiante='".$_POST['telefono1']."', telefono2estudiante='".$_POST['telefono2']."', celularestudiante='".$_POST['celular']."', direccioncorrespondenciaestudiante='".$_POST['direccion2']."', ciudadcorrespondenciaestudiante='".$_POST['ciudad2']."', telefonocorrespondenciaestudiante='".$_POST['telefono2']."', emailestudiante='".$_POST['email']."', fechaactualizaciondatosestudiante='".date("Y-m-d G:i:s",time())."'
		where codigoestudiante = '$codigoestudiante'"; 
		$updest = mysql_query($query_updest,$sala);    
		echo "<br>".$query_updest."<br>";
		   
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../../consultanotas.htm'>";	        	     
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