<?php require_once('../../Connections/directorio.php'); 
@session_start();
?>

<?php 
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
if($_POST['confidencial']==''){
$_POST['confidencial']=200;
}
if($_POST['publica']==''){
$_POST['publica']=200;
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formcomn")) {
  $insertSQL = sprintf("INSERT INTO comunicacion (iddirectorio, codigomediocomunicacion, identificacioncomunicacion, codigoconfidencialcomunicacion, codigopublicainternetcomunicacion) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['medio'], "int"),
                       GetSQLValueString($_POST['info'], "text"),
                       GetSQLValueString($_POST['confidencial'], "text"),
                       GetSQLValueString($_POST['publica'], "text"));

  mysql_select_db($database_directorio, $directorio);
  $Result1 = mysql_query($insertSQL, $directorio) or die(mysql_error());
}

if (isset($_POST['ide'])) {
  $deleteSQL = sprintf("DELETE FROM comunicacion WHERE iddirectorio=%s AND identificacioncomunicacion=%s",
                       GetSQLValueString($_POST['ide'], "int"),
					   GetSQLValueString($_POST['medioe'], "text"));

  mysql_select_db($database_directorio, $directorio);
  $Result1 = mysql_query($deleteSQL, $directorio) or die(mysql_error());

  $deleteGoTo = "comunicacion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $deleteGoTo));
}
if($_POST['confidenciala']==''){
$_POST['confidenciala']=200;
}
if($_POST['publicaa']==''){
$_POST['publicaa']=200;
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formmodificar")) {
  $updateSQL = sprintf("UPDATE comunicacion SET codigoconfidencialcomunicacion=%s, codigopublicainternetcomunicacion=%s,identificacioncomunicacion=%s  WHERE iddirectorio=%s AND identificacioncomunicacion=%s ",
                       GetSQLValueString($_POST['confidenciala'], "text"),
                       GetSQLValueString($_POST['publicaa'], "text"),
					   GetSQLValueString($_POST['infoa'], "text"),
					   GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['medioa'], "text"));
					   
                       

  mysql_select_db($database_directorio, $directorio);
  $Result1 = mysql_query($updateSQL, $directorio) or die(mysql_error());
}


mysql_select_db($database_directorio, $directorio);
$query_avanzado = "SELECT DISTINCT  numeroidentificaciondirectorio,directorio.iddirectorio,nombresdirectorio,apellidosdirectorio,nombreoficina,nombresede,nombrearea,nombrepiso,nombrecargo FROM `directorio`,`area`,`sede`,`oficina`,`piso`,`cargo`,`comunicacion`,`sedearea` WHERE directorio.codigooficina=oficina.codigooficina and oficina.codigoarea=sedearea.codigoarea  and oficina.codigosede=sedearea.codigosede and oficina.codigopiso=piso.codigopiso and directorio.codigocargo=cargo.codigocargo and sedearea.codigosede=sede.codigosede  and sedearea.codigoarea=area.codigoarea  and numeroidentificaciondirectorio='$_POST[cedula]'";
$avanzado = mysql_query($query_avanzado, $directorio) or die(mysql_error());
$row_avanzado = mysql_fetch_assoc($avanzado);
$totalRows_avanzado = mysql_num_rows($avanzado);

mysql_select_db($database_directorio, $directorio);
$query_medios = "SELECT * FROM mediocomunicacion";
$medios = mysql_query($query_medios, $directorio) or die(mysql_error());
$row_medios = mysql_fetch_assoc($medios);
$totalRows_medios = mysql_num_rows($medios);

mysql_select_db($database_directorio, $directorio);
$query_publica = "SELECT * FROM publicainternetcomunicacion";
$publica = mysql_query($query_publica, $directorio) or die(mysql_error());
$row_publica = mysql_fetch_assoc($publica);
$totalRows_publica = mysql_num_rows($publica);

$colname_actualesmedios = "1";
if (isset($_POST['iddirectorio'])) {
  $colname_actualesmedios = (get_magic_quotes_gpc()) ? $_POST['iddirectorio'] : addslashes($_POST['iddirectorio']);
}
mysql_select_db($database_directorio, $directorio);
$query_actualesmedios = "SELECT nombremediocomunicacion,identificacioncomunicacion,comunicacion.codigomediocomunicacion FROM comunicacion,mediocomunicacion  WHERE iddirectorio = '".$row_avanzado['iddirectorio']."' and mediocomunicacion.codigomediocomunicacion=comunicacion.codigomediocomunicacion order by comunicacion.codigomediocomunicacion " ;
$actualesmedios = mysql_query($query_actualesmedios, $directorio) or die(mysql_error());
$row_actualesmedios = mysql_fetch_assoc($actualesmedios);
$totalRows_actualesmedios = mysql_num_rows($actualesmedios);

// El query_sede depende de 2 Condicionales dependiendo si el campo area esta vacio o no vacio
mysql_select_db($database_directorio, $directorio);

if($_POST[areaselect]!=''){
$query_sede = "SELECT * FROM sede,sedearea WHERE sedearea.codigoarea='$_POST[areaselect]'  and sede.codigosede=sedearea.codigosede ORDER BY nombresede ASC";
}
else
{$query_sede = "SELECT * FROM sede ORDER BY nombresede ASC";
}
$sede = mysql_query($query_sede, $directorio) or die(mysql_error());
$row_sede = mysql_fetch_assoc($sede);
$totalRows_sede = mysql_num_rows($sede);
// El query_oficina esta sometido a 4 condicionales los cuales depende si los campos area o sede con estan vacios o no , o sino uno de los 2 no lo esta
mysql_select_db($database_directorio, $directorio);
if($_POST[sedeselect]!='' && $_POST[areaselect]!=''){
$query_oficina = "SELECT * FROM oficina WHERE codigosede='$_POST[sedeselect]'  and codigoarea='$_POST[areaselect]' ORDER BY nombreoficina ASC";
}else
if($_POST[sedeselect]!='' && $_POST[areaselect]=='')
{
$query_oficina = "SELECT * FROM oficina WHERE codigosede='$_POST[sedeselect]'  ORDER BY nombreoficina ASC";
}else
if($_POST[sedeselect]=='' && $_POST[areaselect]!='')
{
$query_oficina = "SELECT * FROM oficina WHERE  codigoarea='$_POST[areaselect]' ORDER BY nombreoficina ASC";
}
else {
$query_oficina = "SELECT * FROM oficina  ORDER BY nombreoficina ASC";
}
$oficina = mysql_query($query_oficina, $directorio) or die(mysql_error());
$row_oficina = mysql_fetch_assoc($oficina);
$totalRows_oficina = mysql_num_rows($oficina);

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

function mostrar(capa,capa2,capa3)
{
	posicion();
	if(document.layers)document.layers[capa].visibility='show'     // Si utilizamos NS
	if(document.all)document.all(capa).style.visibility='visible'  // Si utilizamos IE
	
	if(document.layers)document.layers[capa2].visibility='hide'     // Si utilizamos NS
	if(document.all)document.all(capa2).style.visibility='hidden'   // Si utilizamos IE
	
	if(document.layers)document.layers[capa3].visibility='hide'     // Si utilizamos NS
	if(document.all)document.all(capa3).style.visibility='hidden'   // Si utilizamos IE
}
function enviar()
{
				document.formarea.submit();

}
function enviaragregar()
{	
		if(document.formcomn.id.value=='' || document.formcomn.cedula.value=='' || document.formcomn.medio.value=='' || document.formcomn.info.value=='' || document.formcomn.confidencial.value=='' || document.formcomn.publica.value==''){
		alert('Debe llenar todos los campos');
		}else{
			
			document.formcomn.submit();
			}
}
function enviarmodificar()
{	
		if(document.formmodificar.id.value=='' || document.formmodificar.cedula.value=='' || document.formmodificar.medioa.value=='' || document.formmodificar.infoa.value=='' || document.formmodificar.confidenciala.value=='' || document.formmodificar.publicaa.value=='' ){
		alert('Debe llenar todos los campos');
		}else{
			
			document.formmodificar.submit();
			}
}			
function valor()
{

document.formmodificar.infoa.value=document.formmodificar.medioa.value;


}
function posicion()
{

		if(navigator.appName=="Netscape"){
		   var scrollabajo=window.pageYOffset;
		   }
		else{
	
		   
		   var scrollabajo=document.body.scrollTop+200;
		   var scrollcentro=105+(document.body.clientWidth)/2;
		   }
		var posabajo=scrollabajo;
		var poscentro=scrollcentro;
		document.getElementById('agregar').style.top=posabajo;
		document.getElementById('agregar').style.left=poscentro;
		
		document.getElementById('modificar').style.top=posabajo;
		document.getElementById('modificar').style.left=poscentro;
		
		document.getElementById('eliminar').style.top=posabajo;
		document.getElementById('eliminar').style.left=poscentro;
		pepe=window.setTimeout('posicion()',100)
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Directorio UnBosque</title>
<style type="text/css">
<!--
.Estilo8 {color: #003768; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo11 {font-family: "Square721 Ex BT"}
.Estilo14 {
	font-family: "Square721 Ex BT";
	font-size: x-small;
	font-weight: bold;
	color: #003768;
}
.Estilo15 {color: #FF0000}
.Estilo22 {font-family: "Square721 Ex BT"; font-size: xx-small; }
.Estilo10 {
	color: #003768;
	font-size: x-small;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8.5pt; }
.Estilo24 {font-size: x-small}
.Estilo27 {color: #003768; font-size: x-small; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }

-->
</style>
<script language="JavaScript" type="text/JavaScript">
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

<body onLoad="mostrar('agregar','modificar','eliminar')">
<?php if($_POST[cedula]!=''){ ?>
<div id="agregar" style="position:absolute; left:166px; top:390px; width:150; height:180; z-index:1; visibility: hidden; background-color: #ECE9D8; layer-background-color: #ECE9D8; border: 1px none #000000;">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="formcomn" id="formcomn">
    <p align="left"><span class="Estilo27">Agregar</span><span class="Estilo14">
      <input name="id" type="hidden" id="id" value="<?php echo $row_avanzado['iddirectorio']; ?>">      
      <input name="cedula" type="hidden" id="cedula" value="<?php echo $row_avanzado['numeroidentificaciondirectorio']; ?>">
</span>
    </p>
    <div align="center">
      <table width="30%" cellspacing="2" bordercolor="#ECE9D8">
        <tr>
          <th width="50%" class="Estilo5" scope="col">Medio</th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col"><select name="medio" id="medio">
              <option value="">Ninguno</option>
              <?php
do {  
?>
              <option value="<?php echo $row_medios['codigomediocomunicacion']?>"><?php echo $row_medios['nombremediocomunicacion']?></option>
              <?php
} while ($row_medios = mysql_fetch_assoc($medios));
  $rows = mysql_num_rows($medios);
  if($rows > 0) {
      mysql_data_seek($medios, 0);
	  $row_medios = mysql_fetch_assoc($medios);
  }
?>
          </select></th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col">Informacion</th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col"><input name="info" type="text" id="info"></th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col">Confidencial</th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col"><input name="confidencial" type="checkbox" id="confidencial" value="100"></th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col">Publica Internet</th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col"><input name="publica" type="checkbox" id="publica" value="100" checked></th>
        </tr>
      </table>
    </div>
    <p align="center">
      <input type="button" name="Submit" value="Enviar" onclick="enviaragregar()">
      <span class="Estilo14"> </span>
      <input type="hidden" name="MM_insert" value="formcomn">
    </p>
  </form>
</div>
<div id="modificar" style="position:absolute; left:159px; top:283px; width:150; height:200; z-index:2; visibility: hidden; background-color: #ECE9D8; layer-background-color: #ECE9D8; border: 1px none #000000;">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="formmodificar" id="formmodificar">
    <p align="left" class="Estilo14"><span class="Estilo10">Modificar</span>      <input name="id" type="hidden" id="id" value="<?php echo $row_avanzado['iddirectorio']; ?>">
        <input name="cedula" type="hidden" id="cedula" value="<?php echo $row_avanzado['numeroidentificaciondirectorio']; ?>">
        <input name="identificacion" type="hidden" id="identificacion" value="<?php echo $row_actualesmedios['identificacioncomunicacion']?>">
    </p>
    <div align="center">
      <table width="30%" cellspacing="1" bordercolor="#003768">
        <tr>
          <th width="50%" class="Estilo5" scope="col">Anterior</th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col"><select name="medioa" id="medioa" onchange="valor()">
            <option value="">Ninguno</option>
            <?php
do {  
?>
            <option value="<?php echo $row_actualesmedios['identificacioncomunicacion']?>"><?php echo $row_actualesmedios['identificacioncomunicacion']?></option>
            <?php
} while ($row_actualesmedios = mysql_fetch_assoc($actualesmedios));
  $rows = mysql_num_rows($actualesmedios);
  if($rows > 0) {
      mysql_data_seek($actualesmedios, 0);
	  $row_actualesmedios = mysql_fetch_assoc($actualesmedios);
  }
?>
          </select></th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col">Nuevo</th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col"><input name="infoa" type="text" id="infoa"></th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col">Confidencial</th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col"><input name="confidenciala" type="checkbox" id="confidenciala" value="100"></th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col">Publica Internet </th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col"><input name="publicaa" type="checkbox" id="publicaa" value="100" checked></th>
        </tr>
      </table>
    </div>
    <p align="right">
      <input type="button" name="Submit" value="Enviar" onclick="enviarmodificar()">
      <input type="hidden" name="MM_update" value="formmodificar">
    </p>
  </form>
</div>
<div id="eliminar" style="position:absolute; left:158px; top:283px; width:100; height:200; z-index:3; visibility: hidden; background-color: #ECE9D8; layer-background-color: #ECE9D8; border: 1px none #000000;">
  <form action="" method="post" name="formeliminar" id="formeliminar">
    <p align="left"><span class="Estilo27">Eliminar</span><span class="Estilo14">
      <input name="ide" type="hidden" id="ide" value="<?php echo $row_avanzado['iddirectorio']; ?>">
      <input name="cedula" type="hidden" id="cedula" value="<?php echo $row_avanzado['numeroidentificaciondirectorio']; ?>">
    </span></p>
    <div align="center">
      <table width="50%" cellspacing="2" bordercolor="#ECE9D8">
        <tr>
          <th class="Estilo5" scope="col">Medios</th>
        </tr>
        <tr>
          <th class="Estilo5" scope="col"><select name="medioe" id="medioe">
              <option value="">Ninguno</option>
              <?php
do {  
?>
              <option value="<?php echo $row_actualesmedios['identificacioncomunicacion']?>"><?php echo $row_actualesmedios['identificacioncomunicacion']?></option>
              <?php
} while ($row_actualesmedios = mysql_fetch_assoc($actualesmedios));
  $rows = mysql_num_rows($actualesmedios);
  if($rows > 0) {
      mysql_data_seek($actualesmedios, 0);
	  $row_actualesmedios = mysql_fetch_assoc($actualesmedios);
  }
?>
          </select></th>
        </tr>
      </table>
    </div>
    <p align="center">
      <input type="submit" name="Submit" value="Enviar">
    </p>
  </form>
</div>
<table width="90%" height="550"  border="" align="center" cellspacing="0" bordercolor="#F7BC6C" id="tabla">
  <tr>
    <th height="132" valign="top" class="Estilo11 Estilo8" scope="col"><img src="BanDirector.jpg" width="648" height="107"></th>
  </tr>
  <tr>
    <th valign="top"  scope="col">
	
	<form  method="post" name="formcom" id="formcom" action="insertar.php">
	  <p class="Estilo22"><span class="Estilo24">Informacion de</span> <?php echo $row_avanzado['nombresdirectorio']; ?> <?php echo $row_avanzado['apellidosdirectorio']; ?></p>
	  <p><span class="Estilo8"></span><span class="Estilo14">Informaci&oacute;n
	      de Medios</span>
	    <?php mysql_select_db($database_directorio, $directorio);
							$query_comunicacion = "SELECT nombremediocomunicacion,identificacioncomunicacion,comunicacion.codigomediocomunicacion FROM comunicacion,mediocomunicacion  WHERE iddirectorio = '".$row_avanzado['iddirectorio']."' and mediocomunicacion.codigomediocomunicacion=comunicacion.codigomediocomunicacion order by comunicacion.codigomediocomunicacion" ;
							$comunicacion = mysql_query($query_comunicacion, $directorio) or die(mysql_error());
							$row_comunicacion = mysql_fetch_assoc($comunicacion);
							$totalRows_comunicacion = mysql_num_rows($comunicacion);
					
					 ?>
        </p>
 	   <p>
              <input type="button" name="Submit" value="Agregar" onClick="mostrar('agregar','modificar','eliminar')">
              <input type="button" name="Submit" value="Modificar" onClick="mostrar('modificar','agregar','eliminar')">
              <input type="button" name="Submit" value="Eliminar" onClick="mostrar('eliminar','modificar','agregar')">
              <span class="Estilo14"> </span></p>
            <table width="81%"  border="0" cellspacing="2">
                    <tr>
                      <th width="66%" align="left" valign="top" scope="col"><br>
                        <?php 
								 
								  do { ?>
                        
				   		
						
                        <span class="Estilo10">
                        </span>
                        <table width="91%" align="center" bordercolor="#000000">
                          <tr>
                            <th align="left" scope="col"><span class="Estilo10">
                              <?php 
								  
								  if($pos_ant!=$row_comunicacion['codigomediocomunicacion'])
								  echo $row_comunicacion['nombremediocomunicacion']," :"; ?>
                              <span class="Estilo5">                            </span>                            </span><span class="Estilo10"><span class="Estilo5">
                            </span></span></th>
                          </tr>
                          <tr>
                            <td height="26" bgcolor="#ECE9D8"><span class="Estilo5">
                              <?php 
				   					 echo $row_comunicacion['identificacioncomunicacion'],"<br>"; 
									 													
										$pos_ant=$row_comunicacion['codigomediocomunicacion'];
										
									?>
                              </span><span class="Estilo5">
                              <span class="Estilo10">                            </span>
                              </span></td>
                          </tr>
                        </table>
                        <span class="Estilo10">
                        </span> <span class="Estilo5">
                        
                        </span>
                        <?php } while ($row_comunicacion = mysql_fetch_assoc($comunicacion)); ?>
                        
</span> </th>
                      <th width="34%" align="left" valign="top" scope="col">&nbsp;</th>
                    </tr>
        </table>
                  <p>&nbsp;</p>
      </form> 
	<form name="form1" method="post" action="insertar.php">
      <input type="submit" name="Submit" value="Volver">
      <span class="Estilo14">
      <input name="cedula" type="hidden" id="cedula" value="<?php echo $_POST[cedula]  ?>">
      </span>
	</form>
	
	
</table>
<span class="Estilo15">
<?php } else echo "ACCESO DENEGADO";?>
</span>
</body>
</html>
<?php 
mysql_free_result($avanzado);

mysql_free_result($medios);

mysql_free_result($publica);

mysql_free_result($actualesmedios);

mysql_free_result($sede);

mysql_free_result($oficina);
?>
