<?php 
require_once('Connections/directorio.php'); 
require_once('../../Connections/sala2.php'); 
@session_start();

$query_usuario = "SELECT codigocortocarrera FROM sala.carrera WHERE codigocarrera = '".$_SESSION['codigofacultad']."'";
$usuario = mysql_query($query_usuario, $sala) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
$codigoarea = $row_usuario['codigocortocarrera'];

if (!$codigoarea )
 {
  $codigoarea = "AD103";
 }

mysql_select_db($database_directorio, $directorio);
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formarea")) {
 	 $insertSQL = sprintf("INSERT INTO directorio (numeroidentificaciondirectorio, nombresdirectorio, apellidosdirectorio, codigocargo, codigooficina, codigoestadodirectorio) VALUES (%s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['cedula'], "text"),
						   GetSQLValueString($_POST['nombres'], "text"),
						   GetSQLValueString($_POST['apellidos'], "text"),
						   GetSQLValueString($_POST['cargoselect'], "text"),
						   GetSQLValueString($_POST['oficinaselect'], "text"),
						   GetSQLValueString($_POST['estado'], "text"));
	
	  mysql_select_db($database_directorio, $directorio);
	  $Result1 = mysql_query($insertSQL, $directorio) or die(mysql_error());
	}


	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formarea")) {
	  $updateSQL = sprintf("UPDATE directorio SET numeroidentificaciondirectorio=%s, nombresdirectorio=%s, apellidosdirectorio=%s, codigocargo=%s, codigooficina=%s, codigoestadodirectorio=%s WHERE iddirectorio=%s",
						   GetSQLValueString($_POST['cedula'], "text"),
						   GetSQLValueString($_POST['nombres'], "text"),
						   GetSQLValueString($_POST['apellidos'], "text"),
						   GetSQLValueString($_POST['cargoselect'], "text"),
						   GetSQLValueString($_POST['oficinaselect'], "text"),
						   GetSQLValueString($_POST['estado'], "text"),
						   GetSQLValueString($_POST['id'], "int"));
	
 	   mysql_select_db($database_directorio, $directorio);
	  $Result1 = mysql_query($updateSQL, $directorio) or die(mysql_error());
	}

$query_avanzado = "SELECT DISTINCT  numeroidentificaciondirectorio cedula,oficina.codigoarea,directorio.codigocargo,directorio.codigooficina,codigoestadodirectorio,numeroidentificaciondirectorio,directorio.iddirectorio,nombresdirectorio,apellidosdirectorio,nombreoficina,nombresede,nombrearea,nombrepiso,nombrecargo 
FROM directorio.directorio,directorio.area,directorio.sede,directorio.oficina,directorio.piso,directorio.cargo,directorio.comunicacion,directorio.sedearea 
WHERE directorio.codigooficina=oficina.codigooficina and oficina.codigoarea=sedearea.codigoarea  
and oficina.codigosede=sedearea.codigosede and oficina.codigopiso=piso.codigopiso 
and directorio.codigocargo=cargo.codigocargo and sedearea.codigosede=sede.codigosede  
and sedearea.codigoarea=area.codigoarea "; 
if(isset($_POST['nombres'])&&trim($_POST['nombres'])!='')
$query_avanzado .= "and nombresdirectorio like '%".$_POST['nombres']."%' and apellidosdirectorio like '%".$_POST['apellidos']."%'";
else
$query_avanzado .= "and numeroidentificaciondirectorio='".$_POST['cedula']."'";
//echo $query_avanzado;
$avanzado = mysql_query($query_avanzado, $directorio) or die(mysql_error());
$row_avanzado = mysql_fetch_assoc($avanzado);
$totalRows_avanzado = mysql_num_rows($avanzado);
if($row_avanzado['nombresdirectorio']!=''||$row_avanzado['apellidosdirectorio']!=''){
$nombresfinal=$row_avanzado['nombresdirectorio'];
$apellidosfinal=$row_avanzado['apellidosdirectorio'];
}
else{
$nombresfinal=$_POST['nombres'];
$apellidosfinal=$_POST['apellidos'];
}

//mysql_select_db($database_directorio, $directorio); AD103 - > Personal
if($codigoarea==AD103){
$query_oficina = "SELECT * FROM directorio.oficina ORDER BY nombreoficina ASC";
}else
$query_oficina = "SELECT * FROM directorio.oficina where codigoarea = '$codigoarea' ORDER BY nombreoficina ASC";


$oficina = mysql_query($query_oficina, $directorio) or die(mysql_error());
$row_oficina = mysql_fetch_assoc($oficina);
$totalRows_oficina = mysql_num_rows($oficina);

//mysql_select_db($database_directorio, $directorio);
$query_cargo = "SELECT * FROM directorio.cargo ORDER BY nombrecargo ASC";
$cargo = mysql_query($query_cargo, $directorio) or die(mysql_error());
$row_cargo = mysql_fetch_assoc($cargo);
$totalRows_cargo = mysql_num_rows($cargo);

//mysql_select_db($database_directorio, $directorio);
$query_estado = "SELECT * FROM directorio.estadodirectorio";
$estado = mysql_query($query_estado, $directorio) or die(mysql_error());
$row_estado = mysql_fetch_assoc($estado);
$totalRows_estado = mysql_num_rows($estado);

if($_POST[areaselect]=='')
$areatemp=1;
if($_POST[sedeselect]=='')
$sedetemp=1;
if($_POST[oficinaselect]=='')
$oficinatemp=1;
if($_POST[cargoselect]=='')
$cargotemp=1;
?>
<script language="javascript">
function enviar()
{
 document.formarea.submit();
}
function continuar()
{
 location.href='comunicacion.php';
 document.formarea.submit();
}
function enviartodo()
{	
  if(document.formarea.nombres.value=='' || document.formarea.apellidos.value=='' || document.formarea.oficinaselect.value=='' || document.formarea.cargoselect.value==''){
	 alert('Debe llenar todos los campos');
	}else{
	//document.formarea.dep.value=0;
	document.formarea.submit();
	}
}

function existe(){
document.formcedula.submit();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Directorio UnBosque</title>
<style type="text/css">
<!--
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8.5pt; }
.Estilo8 {color: #003768; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo11 {font-family: "Square721 Ex BT"}
.Estilo14 {
	font-family: "Square721 Ex BT";
	font-size: x-small;
	font-weight: bold;
	color: #003768;
}
.Estilo15 {color: #FF0000}
.Estilo16 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 8.5pt;
	color: #000000;
	font-weight: normal;
}
.Estilo18 {color: #FF0000; font-family: Verdana, Arial, Helvetica, sans-serif; }

-->
</style>
</head>

<body>
<table width="65%"  border="" align="center" cellspacing="0" bordercolor="#F7BC6C" id="tabla">
  <tr>
    <th height="128" valign="top" class="Estilo11 Estilo8" scope="col"><img src="BanDirector.jpg" width="648" height="107"></th>
  </tr>
  <tr>
	<td>
	<form  method="post" name="formcedula" id="formcedula" action="insertar.php">
	  <p align="center" class="Estilo8"><span class="Estilo11"><br>Informacion personal </span>
	  <p align="center" class="Estilo8"><span class="Estilo11">Nombres</span>
          <input name="nombres" type="text" id="nombres" value="<?php echo $_POST['nombres']; ?>" size="30">
          <input name="id" type="hidden" id="id" value="<?php echo $row_avanzado['iddirectorio']; ?>">
      <p align="center" class="Estilo8"><span class="Estilo11">Apellidos</span>
          <input name="apellidos" type="text" id="apellidos" value="<?php echo $_POST['apellidos']; ?>" size="30">
          <br><input type="submit" name="Submit" value="Ver">

	  </p>
	  <p>
	    <input name="id" type="hidden" id="id" value="<?php echo $row_avanzado['iddirectorio']; ?>">
	 </p>
	</form> 
	</td>
	</tr>	
    <tr>
	<th  scope="col">
	
    <span class="Estilo16">    </span>
    <table width="80%"  border="0" cellspacing="0" bgcolor="#EFEBDE">
      <tr>
        <th scope="col"><span class="Estilo16">
<?	
		echo $codigoarea;
		  if($codigoarea!=$row_avanzado['codigoarea'] && $codigoarea!=AD103 && $_POST[cedula]!='' && $row_avanzado['numeroidentificaciondirectorio']!='')
		  echo "La persona identificada con ".$row_avanzado['numeroidentificaciondirectorio']." ya se encuentra registrada en el sistema pero no pertenece a su área";
if($row_avanzado==NULL && $row_avanzado['cedula']!='')
echo "Esta persona aun no esta registrada en el sistema";

if($codigoarea==AD103 || $codigoarea==$row_avanzado['codigoarea'] || $row_avanzado['numeroidentificaciondirectorio']=='')
	if($_POST['nombres']!='' || $_POST['apellidos']!=''){

?>
        </span></th>
      </tr>
    </table>
    <span class="Estilo18">    </span>
    <form  method="POST" name="formarea" id="formarea" action="<?php echo $editFormAction; ?>">
<table width="100%"  border="0" cellspacing="0">
        <tr>
          <th scope="col"><p align="center" class="Estilo8"><span class="Estilo11">Nombres</span>
                <input name="nombres" type="" id="nombres" value="<?php echo $nombresfinal; ?>" size="30">
                <input name="cedula" type="hidden" id="cedula" value="<?php echo $row_avanzado['cedula']  ?>">
                <input name="id" type="hidden" id="id" value="<?php echo $row_avanzado['iddirectorio']; ?>">
            <p align="center" class="Estilo8"><span class="Estilo11">Apellidos</span>
                <input name="apellidos" type="text" id="apellidos" value="<?php echo $apellidosfinal; ?>" size="30">
            </p>
            <p align="center" class="Estilo14">Informaci&oacute;n General</p>
            
              <div align="center">
                <table height="166" align="center" cellspacing="2" >
                  <tr class="Estilo14">
                    <th width="60" height="25" align="left" valign="middle"  scope="col">&nbsp;</th>
                    <th height="25" align="left" valign="middle" bgcolor="#EFEBDE" scope="col"><div align="center">Informacion
                    </div>                      </th>
                  </tr>
                  <tr class="Estilo14">
                    <th height="25" align="left" valign="top"  scope="col">Area </th>
                    <th height="25" align="left" valign="middle" bgcolor="#EFEBDE" class="Estilo16"  scope="col"><div align="center"><?php echo $row_avanzado['nombrearea']; ?>                      </div></th>
                  </tr>
                  <tr class="Estilo14">
                    <th height="25" align="left" valign="middle" scope="col">Sede </th>
                    <th height="25" align="left" valign="middle" bgcolor="#EFEBDE" class="Estilo16"scope="col"><div align="center"><?php echo $row_avanzado['nombresede']; ?>                      </div></th>
                  </tr>
                  <?php $cargoselect=$row_avanzado['nombrecargo']; ?>
                  <tr class="Estilo14">
                    <th height="25" align="left" valign="middle"  scope="col">Oficina</th>
                    <th height="25" align="left" valign="middle" bgcolor="#EFEBDE" class="Estilo16" scope="col">
                      <div align="center">
                        <select name="oficinaselect" class="Estilo5" id="oficinaselect" dir="ltr" onChange="">
                          <option value="" <?php if (!(strcmp("", $row_avanzado['codigooficina']))) {echo "SELECTED";} ?>>Seleccione</option>
                          <?php
do {  
?>
                          <option value="<?php echo $row_oficina['codigooficina']?>"<?php if (!(strcmp($row_oficina['codigooficina'], $row_avanzado['codigooficina']))) {echo "SELECTED";} ?>><?php echo $row_oficina['nombreoficina']?></option>
                          <?php
} while ($row_oficina = mysql_fetch_assoc($oficina));
  $rows = mysql_num_rows($oficina);
  if($rows > 0) {
      mysql_data_seek($oficina, 0);
	  $row_oficina = mysql_fetch_assoc($oficina);
  }
?>
                        </select>
                      </div></th>
                  </tr>
                  <tr class="Estilo14">
                    <th height="25" align="left" valign="middle"  scope="col">Cargo</th>
                    <th height="25" align="left" valign="middle" bgcolor="#EFEBDE" class="Estilo16" scope="col">
                      <div align="center">
                        <select name="cargoselect" class="Estilo5" id="cargoselect" dir="ltr" onChange="">
                          <option value="" <?php if (!(strcmp("", $row_avanzado['codigocargo']))) {echo "SELECTED";} ?>>Seleccione</option>
                          <?php
do {  
?>
                          <option value="<?php echo $row_cargo['codigocargo']?>"<?php if (!(strcmp($row_cargo['codigocargo'], $row_avanzado['codigocargo']))) {echo "SELECTED";} ?>><?php echo $row_cargo['nombrecargo']?></option>
                          <?php
} while ($row_cargo = mysql_fetch_assoc($cargo));
  $rows = mysql_num_rows($cargo);
  if($rows > 0) {
      mysql_data_seek($cargo, 0);
	  $row_cargo = mysql_fetch_assoc($cargo);
  }
?>
                        </select>
                      </div></th>
                  </tr>
                  <tr class="Estilo14">
                    <th height="25" align="left" valign="middle"  scope="col">Estado</th>
                    <th height="25" align="left" valign="middle" bgcolor="#EFEBDE" class="Estilo16" scope="col"><div align="center">
                      <select name="estado" id="estado">
                        <?php
do {  
?>
                        <option value="<?php echo $row_estado['codigoestadodirectorio']?>"<?php if (!(strcmp($row_estado['codigoestadodirectorio'], $row_avanzado['codigoestadodirectorio']))) {echo "SELECTED";} ?>><?php echo $row_estado['nombreestadodirectorio']?></option>
                        <?php
} while ($row_estado = mysql_fetch_assoc($estado));
  $rows = mysql_num_rows($estado);
  if($rows > 0) {
      mysql_data_seek($estado, 0);
	  $row_estado = mysql_fetch_assoc($estado);
  }
?>
                      </select>
                    </div></th>
                  </tr>
                </table>
            </div>              
            <p align="center" class="Estilo14">
              <input type="button" name="enviar" value="Enviar Datos" onClick="enviartodo()"> 
              <span class="Estilo8">
             <?php if( $row_avanzado['numeroidentificaciondirectorio']==''){?>
			  <input type="hidden" name="MM_insert" value="formarea">
			  <?php } else if( $row_avanzado['numeroidentificaciondirectorio']!=''){ ?>
			
              <input type="hidden" name="MM_update" value="formarea">
			  <?php } ?>
</span>              <span class="Estilo8">              </span>              </p>
            </th>
          </tr>
      </table>
	  <p class="Estilo8">&nbsp;</p>
      </form>  
	  <form name="form1" method="post" action="comunicacioncapas.php">
	   <?php if($row_avanzado['numeroidentificaciondirectorio']!=''){ ?>
	    <input type="submit" name="Submit" value="Continuar">
		<?php  } ?>
        <span class="Estilo8">
        <input name="cedula" type="hidden" id="cedula" value="<?php echo $row_avanzado['cedula']  ?>">
      </span>      </form>	  <P>&nbsp;	  </P>
</table>
<?php } ?>
<span class="Estilo8"></span>
</body>
</html>
<?php
mysql_free_result($estado);
mysql_free_result($avanzado);
mysql_free_result($oficina);
mysql_free_result($cargo);
?>
