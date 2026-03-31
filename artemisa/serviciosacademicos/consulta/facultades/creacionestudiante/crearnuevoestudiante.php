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
if ($_POST['nombres'] == "")
 {
  session_unregister('codigoestudiantecolegionuevo');
 }
if(isset($_GET['apellidos']) || isset($_GET['nombres']) || isset($_GET['documento']))
{
	$_POST['apellidos'] = $_GET['apellidos'];
	$_POST['nombres'] = $_GET['nombres'];
	$_POST['documento'] = $_GET['documento'];
}
if($_POST['regresar'])
{
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=validarcrearnuevoestudiante.php?nombres=".$_POST['nombres']."&apellidos=".$_POST['apellidos']."&documento=".$_POST['documento']."&buscar=Buscar'>";	        	     
  exit();
} 
$formulariovalido = 1;  
//mysql_select_db($database_sala, $sala);
$query_jornadas = "SELECT * FROM jornada";
$jornadas = mysql_query($query_jornadas, $sala) or die(mysql_error());
$row_jornadas = mysql_fetch_assoc($jornadas);
$totalRows_jornadas = mysql_num_rows($jornadas);

//mysql_select_db($database_sala, $sala);
$query_tipoestudiante = "SELECT * FROM tipoestudiante where codigotipoestudiante like '1%'";
//$query_tipoestudiante = "SELECT * FROM tipoestudiante where (codigotipoestudiante like '1%' or codigotipoestudiante like '4%')";
$tipoestudiante = mysql_query($query_tipoestudiante, $sala) or die(mysql_error());
$row_tipoestudiante = mysql_fetch_assoc($tipoestudiante);
$totalRows_tipoestudiante = mysql_num_rows($tipoestudiante);

$query_situacionestudiante = "SELECT * FROM situacioncarreraestudiante where codigosituacioncarreraestudiante = 70";
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

//mysql_select_db($database_sala, $sala);
$query_seldecision = "select codigodecisionuniversidad, nombredecisionuniversidad
from decisionuniversidad";
$seldecision = mysql_query($query_seldecision, $sala) or die("$query_seldecision");
$totalRows_seldecision = mysql_num_rows($seldecision);

$query_selgenero = "select codigogenero, nombregenero
from genero";
$selgenero = mysql_query($query_selgenero, $sala) or die("$query_selgenero");
$totalRows_selgenero = mysql_num_rows($selgenero);
$row_selgenero = mysql_fetch_assoc($selgenero);
//echo "aca".$row_planestudios['idplanestudio'];
?>
<html>
<head>
<title>Crear Estudiante</title>
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
<script language="javascript">
function validar()
 {
	document.form1.submit();

 }
</script>
<form name="form1" method="post" action="crearnuevoestudiante.php" onChange="validar()">
    <p align="center"><strong>CREAR NUEVO ESTUDIANTE</strong></p>
    <table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" colspan="3"><div align="center"><font size="1" face="tahoma"><strong>Facultad*</strong></font></div></td>
        <td colspan="3" ><div align="center"><font size="1" face="tahoma">
          <strong><?php echo $row_carreras['nombrecarrera'] ?></strong>
		  </font></div></td>
	  </tr>
      <tr>
        <td width="91" bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Apellidos*</strong></font></div></td>
        <td colspan="1">
          <div align="center"><font size="1" face="tahoma">
          <input name="apellidos" type="text" id="apellidos" value="<?php echo $_POST['apellidos']; ?>" size="30">
</font><font size="2" face="Tahoma">
<?php
echo "<span class='Estilo3'>";
if(isset($_POST['apellidos']))
{
	$apellidos = $_POST['apellidos'];
	$imprimir = true;
	$arequerido = validar($apellidos,"requerido",$error1,&$imprimir);
	//$anombre = validar($apellidos,"nombre",$error6,&$imprimir);
	$formulariovalido = $formulariovalido*$arequerido;
}
					echo "</span>";
				?>
</font><font size="1" face="tahoma">          </font></div></td>
        <td bgcolor="#C5D5D6" width="131"><div align="center"><font size="1" face="tahoma"><strong>Nombres*</strong></font></div></td>
        <td colspan="1"><div align="center"><font size="1" face="tahoma">
            <input name="nombres" type="text" id="nombres2" value="<?php echo $_POST['nombres']; ?>" size="30">
</font><font size="2" face="Tahoma">
<?php
echo "<span class='Estilo3'>";
if(isset($_POST['nombres']))
{
	$nombres = $_POST['nombres'];
	$imprimir = true;
	$nrequerido = validar($nombres,"requerido",$error1,&$imprimir);
	//$nnombre = validar($nombres,"nombre",$error6,&$imprimir);
	$formulariovalido = $formulariovalido*$nrequerido;
}
					echo "</span>";
				?>
</font><font size="1" face="tahoma">        </font></div></td>
	<td width="90" bgcolor="#C5D5D6" colspan="1">
			  <div align="center"><font size="1" face="tahoma"><strong>Fecha de Nacimiento* </strong></font></div></td>
			<td colspan="1"><div align="center"><font size="1" face="tahoma">
			  <input name="fnacimiento" type="text" size="10" value="<?php if(isset($_POST['fnacimiento'])) echo $_POST['fnacimiento']; else echo "aaaa-mm-dd"; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
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
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>T. Documento*</strong></font></div></td>
        <td colspan="1"><div align="center"><font size="2" face="Tahoma">
		<select name="tipodocumento">
<?php
do 
{  
?>
  			<option value="<?php echo $row_documentos['tipodocumento']?>"<?php if (!(strcmp($row_documentos['tipodocumento'], $_POST['tipodocumento']))) {echo "SELECTED";} ?>><?php echo $row_documentos['nombredocumento']?></option>
<?php
				  
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
          <input name="documento" type="text" id="documento2" value="<?php echo $_POST['documento']; ?>" size="20" readonly="true" onClick="alert('Si desea modificar el número de documento de clic en Regresar, \n y en el campo donde pide colocar el documento digítelo.')">
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
		<td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Genero*</strong></font></div></td>
        <td><div align="center"><font size="1" face="tahoma">
          <select name="genero">
              <option value="0" <?php if (!(strcmp(0, $_POST['genero']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
do 
{  
?>
              <option value="<?php echo $row_selgenero['codigogenero']?>"<?php if (!(strcmp($row_selgenero['codigogenero'], $_POST['genero']))) {echo "SELECTED";} ?>><?php echo $row_selgenero['nombregenero']?></option>
              <?php
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
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Expedido en*</strong> </font></div></td>
        <td colspan="1"><div align="center"><font size="1" face="tahoma">
            <input name="expedido" type="text" id="expedido3" value="<?php echo $_POST['expedido']; ?>" size="25">
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
        <td><div align="center"><font size="1" face="tahoma">
            <select name="jornada" id="select10">
              <option value="0" <?php if (!(strcmp(0, $_POST['jornada']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
do 
{  
?>
              <option value="<?php echo $row_jornadas['codigojornada']?>"<?php if (!(strcmp($row_jornadas['codigojornada'], $_POST['jornada']))) {echo "SELECTED";} ?>><?php echo $row_jornadas['nombrejornada']?></option>
              <?php
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
            <option value="0" <?php if (!(strcmp(0, $_POST['semestre']))) {echo "SELECTED";} ?>>Sel</option>
            <?php for ($i=1;$i<13;$i++)
			{?>
            <option value="<?php echo $i;?>"<?php if (!(strcmp($i, $_POST['semestre']))) {echo "SELECTED";} ?>><?php echo $i;?></option>
            <?php }  ?>
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
      </tr>
      <tr>
        <td width="107" bgcolor="#C5D5D6"><div align="center"><strong><font size="1" face="tahoma">Tipo Estudiante* </font></strong></div></td>
        <td colspan="2"><div align="center">
          <font size="1" face="tahoma">
          <select name="tipoestudiante" id="select13">
            <option value="0" <?php if (!(strcmp(0, $_POST['tipoestudiante']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
do 
{  
?>
            <option value="<?php echo $row_tipoestudiante['codigotipoestudiante']?>"<?php if (!(strcmp($row_tipoestudiante['codigotipoestudiante'], $_POST['tipoestudiante']))) {echo "SELECTED";} ?>><?php echo $row_tipoestudiante['nombretipoestudiante']?></option>
<?php
} while ($row_tipoestudiante = mysql_fetch_assoc($tipoestudiante));
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
          <strong><?php echo $row_situacionestudiante['nombresituacioncarreraestudiante']?></strong>
 </font></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Celula</strong>r</font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
            <input name="celular" type="text" id="celular2" value="<?php echo $_POST['celular']; ?>" size="30">
        </font></div></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="1" face="tahoma"><strong>E-mail </strong></font></div></td>
        <td colspan="2"><div align="center"><font size="1" face="tahoma">
            <input name="email" type="text" id="email3" value="<?php echo $_POST['email']; ?>" size="30">
        </font></div></td>
		</tr>
      <tr>
        
      <td height="27" bgcolor="#C5D5D6">
<div align="center"><font size="1" face="tahoma"><strong>Dir. Estudiante*</strong></font></div></td>
        <td colspan="1"><div align="center"><font size="1" face="tahoma">
            <input name="direccion1" type="text" id="direccion12" value="<?php echo $_POST['direccion1']; ?>" size="30">
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
        <td colspan="1"><div align="center"><font size="1" face="tahoma">
            <input name="telefono1" type="text" id="telefono13" value="<?php echo $_POST['telefono1']; ?>" size="22">
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
          <input name="ciudad1" type="text" id="ciudad15" value="<?php echo $_POST['ciudad1']; ?>" size="19">
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
        <td colspan="1"><div align="center"><font size="1" face="tahoma">
            <input name="direccion2" type="text" id="direccion22" value="<?php echo $_POST['direccion2']; ?>" size="30">
        </font></div></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="1" face="tahoma"><strong>Tel&eacute;fono:</strong></font></div></td>
        <td colspan="1"><div align="center"><font size="1" face="tahoma">
            <input name="telefono2" type="text" id="telefono23" value="<?php echo $_POST['telefono2']; ?>" size="22">
        </font></div></td>
        <td bgcolor="#C5D5D6"><div align="center"><font size="1" face="tahoma"><strong>Ciudad:</strong> </font></div></td>
        <td><div align="center"><font size="1" face="tahoma">
            <input name="ciudad2" type="text" id="ciudad24" value="<?php echo $_POST['ciudad2']; ?>" size="19">
        </font></div></td>
      </tr>
    </table>
    <p align="center">
      <input name="guardar" type="submit" id="guardar" value="Crear" style="width: 80px">
      &nbsp;
      <input name="regresar" type="submit" id="regresar" value="Regresar" style="width: 80px">
  </p>
</form>
</body>
</html>
<?php
if($_POST['guardar'])
{
	if($formulariovalido)
	{
		$query_selgenero = "select codigoperiodo from periodo where codigoestadoperiodo = '1'";
		$selgenero = mysql_query($query_selgenero, $sala) or die("$query_selgenero");
		$totalRows_selgenero = mysql_num_rows($selgenero);
		$row_selgenero = mysql_fetch_assoc($selgenero);

		$query_insestudiante = "INSERT INTO estudiantegeneral(tipodocumento, numerodocumento, expedidodocumento, nombrecortoestudiantegeneral, nombresestudiantegeneral, apellidosestudiantegeneral, fechanacimientoestudiantegeneral, codigogenero, direccionresidenciaestudiantegeneral, ciudadresidenciaestudiantegeneral, telefonoresidenciaestudiantegeneral, telefono2estudiantegeneral, celularestudiantegeneral, direccioncorrespondenciaestudiantegeneral, ciudadcorrespondenciaestudiantegeneral, telefonocorrespondenciaestudiantegeneral, emailestudiantegeneral, fechacreacionestudiantegeneral, fechaactualizaciondatosestudiantegeneral) 
    	VALUES('".$_POST['tipodocumento']."', '".$_POST['documento']."', '".$_POST['expedido']."', '".$_POST['documento']."', '".$_POST['nombres']."', '".$_POST['apellidos']."', '".$_POST['fnacimiento']."', '".$_POST['genero']."', '".$_POST['direccion1']."', '".$_POST['ciudad1']."', '".$_POST['telefono1']."', '".$_POST['telefono2']."', '".$_POST['celular']."', '".$_POST['direccion2']."', '".$_POST['ciudad2']."', '".$_POST['telefono2']."', '".$_POST['email']."', '".date("Y-m-d G:i:s",time())."', '".date("Y-m-d G:i:s",time())."')";
		//echo "$query_insestudiante <br>";
		$insestudiante = mysql_db_query($database_sala,$query_insestudiante) or die("$query_insestudiante".mysql_error());
		$idestudiantegeneral = mysql_insert_id();
			
		$query_insestudiantedocumento = "INSERT INTO estudiantedocumento(idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento) 
		VALUES('$idestudiantegeneral', '".$_POST['tipodocumento']."', '".$_POST['documento']."', '".$_POST['expedido']."', '".date("Y-m-d G:i:s",time())."', '2999-12-31')";
		//echo "$query_insestudiantedocumento <br>";
		$insestudiantedocumento = mysql_db_query($database_sala,$query_insestudiantedocumento) or die("$query_insestudiantedocumento".mysql_error());

		$query_insestudiantecarrera = "INSERT INTO estudiante( idestudiantegeneral, codigocarrera, semestre, numerocohorte, codigotipoestudiante, codigosituacioncarreraestudiante, codigoperiodo, codigojornada) 
		VALUES('$idestudiantegeneral', '".$row_carreras['codigocarrera']."', '".$_POST['semestre']."', '1', '".$_POST['tipoestudiante']."', '70', '".$row_selgenero['codigoperiodo']."', '".$_POST['jornada']."')";

		$insestudiantecarrera = mysql_db_query($database_sala,$query_insestudiantecarrera) or die("query_insestudiantecarrera".mysql_error());
		$codigoestudiantenuevo = mysql_insert_id();
			
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudiante.php?codigocreado=".$codigoestudiantenuevo."'&usuarioeditar=".$usuarioeditar.">";	        	     
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
	window.location.reload("crearnuevoestudiante.php"+dir);
	history.go();
}
function buscarcolegio()
 {
  document.form1.submit();
  window.open('editarestudiantecolegio.php?nuevo','mensajes','width=800,height=400,left=100,top=100,scrollbars=yes')
 }

</script>