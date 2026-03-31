<?php
/** SIN ADO */
require('../../../Connections/sala2.php');
$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";
require_once($rutaorden.'claseordenpago.php');
require_once('../../../funciones/funcionip.php');

include ("calendario/calendario.php");
include("../../../funciones/funcionpassword.php");
include("../../../funciones/enviamail.php");

@session_start();

$GLOBALS['sesionmodulos'];
$GLOBALS['numerodocumentosesion'];
$GLOBALS['modalidadacademicasesion'];
$GLOBALS['inscripcionsession'];
$GLOBALS['study'];
session_register("numerodocumentosesion");
session_register("modalidadacademicasesion");
session_register("sesionmodulos");
session_register("inscripcionsession");
session_register("study");

mysql_select_db($database_sala, $sala);

$codigoinscripcion = "" ;

if ($_POST['study'] == "antiguo")
 {
  $_SESSION['study'] = 'antiguo'; 
 }

if (isset($_GET['documentoingreso']))
{
	$documento = $_GET['documentoingreso'];
	$query_seldocumentos = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
	c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
	FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c
	WHERE ed.numerodocumento = '$documento'
	and eg.idestudiantegeneral = est.idestudiantegeneral
	and ed.idestudiantegeneral = eg.idestudiantegeneral
	and c.codigocarrera = est.codigocarrera
	ORDER BY 3, est.codigoperiodo";
	//echo $query_seldocumentos;
	$seldocumentos = mysql_query($query_seldocumentos, $sala) or die(mysql_error());
	$totalRows_seldocumentos = mysql_num_rows($seldocumentos);
	$respuesta = mysql_fetch_assoc($seldocumentos);

	if($respuesta <> "")
	{
		$_SESSION['numerodocumentosesion'] = $respuesta['numerodocumento'];
		$codigoinscripcion = $_SESSION['numerodocumentosesion'];
	}
	else
	{
		$_SESSION['numerodocumentosesion']= $_GET['documentoingreso'];
		$codigoinscripcion = $_SESSION['numerodocumentosesion'];
	}
	
	
	if (!isset($_GET['logincorrecto']) and !isset($_GET['eliminar']) and $_SESSION['MM_Username'] == "estudiante")
	{
		$query_usuarioclave = "select *
		from usuariopreinscripcion u,claveusuariopreinscripcion c
		where u.idusuariopreinscripcion = c.idusuariopreinscripcion
		and usuariopreinscripcion = '$codigoinscripcion'
		and codigoestadoclaveusuariopreinscripcion not like '2%'";

		$usuarioclave = mysql_query($query_usuarioclave, $sala) or die("$query_usuarioclave");
		$totalRows_usuarioclave = mysql_num_rows($usuarioclave);
		$row_usuarioclave = mysql_fetch_assoc($usuarioclave);
		if ($row_usuarioclave <> "")
		{
			
			if ($row_usuarioclave['fechavencimientousuariopresinscripcion']	<= date("Y-m-d"))
			{
				echo '
				<script language="JavaScript">
				alert("El usuario digitado ha caducado por favor escribir al correo ayuda@unbosque.edu.co para activar el usuario."); history.go(-1);
				</script>
				';
				exit();
			}
            
			else if ($row_usuarioclave['codigoestadoclaveusuariopreinscripcion'] == 100 or $row_usuarioclave['fechavencimientoclaveusuariopresinscripcion'] <= date("Y-m-d"))
			{
				
				echo "
				<META HTTP-EQUIV='Refresh' CONTENT='0;URL=solicitudclave.php?usuario=".$codigoinscripcion."&cambioclave'>";
				exit();
			}
			else
			{
				echo "
				<META HTTP-EQUIV='Refresh' CONTENT='0;URL=solicitudclave.php?usuario=".$codigoinscripcion."&digitaclave'>
				";
				exit();
			}
		}
	}
}
else if ($_SESSION['numerodocumentosesion'] <> "")
{
	$codigoinscripcion = $_SESSION['numerodocumentosesion'];
}

$query_selgenero = "select codigogenero, nombregenero
from genero";
$selgenero = mysql_query($query_selgenero, $sala) or die("$query_selgenero");
$totalRows_selgenero = mysql_num_rows($selgenero);
$row_selgenero = mysql_fetch_assoc($selgenero);

$query_trato = "select *
from trato";
$trato = mysql_query($query_trato, $sala) or die("$query_selgenero");
$totalRows_trato = mysql_num_rows($trato);
$row_trato = mysql_fetch_assoc($trato);

$query_documentos = "SELECT * FROM documento";
$documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
$row_documentos = mysql_fetch_assoc($documentos);
$totalRows_documentos = mysql_num_rows($documentos);

//********************************* tipo usuario **////////////////////////////////////////////////////////
$usuario = $_SESSION['MM_Username'];
$query_tipousuario = "SELECT *
FROM usuariofacultad
where usuario = '".$usuario."'";	
$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);   

// si el usuario es administrativo salen todas las modalidades
if ($row_tipousuario['codigotipousuariofacultad'] == 200)
{
	$query_modalidad = "SELECT * FROM modalidadacademica
	WHERE codigomodalidadacademica <> 500 order by 1";
	$modalidad = mysql_query($query_modalidad, $sala) or die(mysql_error());
	$row_modalidad = mysql_fetch_assoc($modalidad);
	$totalRows_modalidad = mysql_num_rows($modalidad);
}
else
{
	$query_modalidad = "SELECT * FROM modalidadacademica where codigoestado like '1%' order by 1";
	$modalidad = mysql_query($query_modalidad, $sala) or die(mysql_error());
	$row_modalidad = mysql_fetch_assoc($modalidad);
	$totalRows_modalidad = mysql_num_rows($modalidad); 
}
$existe = false;
$query_estudiante = "SELECT * FROM estudiantegeneral eg,departamento d,ciudad c
WHERE numerodocumento = '$codigoinscripcion'
AND c.idciudad = eg.idciudadnacimiento
AND d.iddepartamento = c.iddepartamento";

$estudiante = mysql_query($query_estudiante, $sala) or die("$query_estudiante");
$totalRows_estudiante = mysql_num_rows($estudiante);
$row_estudiante = mysql_fetch_assoc($estudiante);

if ($row_estudiante <> "")
{
	$existe = true; 
}

if(isset($_GET['idpreinscripcion']) && $row_estudiante == "")
{
	$_POST['especializacion'] = $_GET['especializacion'];
	// Inicializar los campos POST con los datos de inscripción
	$query_inscripcion = "SELECT * 
	FROM preinscripcion pe,preinscripcioncarrera pc,carrera c
	WHERE pe.idpreinscripcion = '".$_GET['idpreinscripcion']."'
	and pc.codigocarrera = c.codigocarrera
	and c.codigocarrera = '".$_POST['especializacion']."'
	AND pe.idpreinscripcion=pc.idpreinscripcion		
	and pe.codigoestado like '1%'
	and pc.codigoestado like '1%'";
	$inscripcion = mysql_query($query_inscripcion, $sala) or die(mysql_error());
	$row_inscripcion = mysql_fetch_assoc($inscripcion);
	$_POST['trato'] = $row_inscripcion['idtrato'];
	$_POST['nombres'] = $row_inscripcion['nombresestudiante'];
	$_POST['apellidos'] = $row_inscripcion['apellidosestudiante'];
	$_POST['especializacion'] = $row_inscripcion['codigocarrera'];
	$_POST['modalidad'] = $row_inscripcion['codigomodalidadacademica'];
	$_POST['tipodocumento'] = $row_inscripcion['tipodocumento'];
	$_POST['numerodocumento'] = $row_inscripcion['numerodocumento'];
	$_POST['expedidodocumento'] = $row_inscripcion['expedidodocumento'];
	$_POST['telefono'] = $row_inscripcion['telefonoestudiante'];
	$_POST['email'] = $row_inscripcion['emailestudiante'];

	if ($_POST['nombres'] == "")
	{
		echo '<script language="JavaScript">alert("El nombre es requerido");</script>';			
		$banderagrabar = 1;
	}
	else if ($_POST['apellidos'] == "")
	{
		echo '<script language="JavaScript">alert("El apellido es requerido");</script>';			
		$banderagrabar = 1;
	}
	else if ($_POST['telefono'] == "")
	{
		echo '<script language="JavaScript">alert("El número telefonico es requerido");</script>';			
		$banderagrabar = 1;
	}
	else if ($_POST['email'] == "")
	{
		echo '<script language="JavaScript">alert("El correo es requerido");</script>';			
		$banderagrabar = 1;
	}
	else if ($_POST['trato'] == 0)
	{
		echo '<script language="JavaScript">alert("El trato es requerido");</script>';			
		$banderagrabar = 1;
	}
	else if ($_POST['tipodocumento'] == 0)
	{
		echo '<script language="JavaScript">alert("El tipo de documento es requerido");</script>';			
		$banderagrabar = 1;
	
	}
	else if ($_POST['expedidodocumento'] == ""  && $_POST['estados'] == 400)
	{
		echo '<script language="JavaScript">alert("El lugar de expedición del documento es requerido");</script>';			
		$banderagrabar = 1;
	}
	else if ($_POST['numerodocumento'] == 0 && $_POST['estados'] == 400)
	{
		echo '<script language="JavaScript">alert("El documento es requerido");</script>';			
		$banderagrabar = 1;
	}
	if($banderagrabar == 1)
	{
?>
<script language="javascript">
	history.go(-1);
</script>
<?php
	}
}
if(isset($_POST['periodo']))
{ 
	$query_nopermite = "SELECT *
  	FROM inscripcion i,estudiantecarrerainscripcion e
  	WHERE i.idinscripcion = e.idinscripcion
  	AND e.codigocarrera = '".$_POST['especializacion']."'
  	AND e.codigoestado = '100'
  	AND i.codigoperiodo = '".$_POST['periodo']."'
  	AND i.idestudiantegeneral =  '".$row_estudiante['idestudiantegeneral']."'";
  	$nopermite = mysql_query($query_nopermite, $sala) or die(mysql_error());
  	$row_nopermite = mysql_fetch_assoc($nopermite);
  	$totalRows_nopermite = mysql_num_rows($nopermite);
	//echo "$query_nopermite";
  	if ($row_nopermite <> "")
	{
		echo '<script language="JavaScript">
  		alert("Ya presenta preinscripción para esa carrera en este periodo"); history.go(-2);
		</script>';
	   exit;
	}
}

$query_periodo = "select * from periodo p,carreraperiodo c
where p.codigoperiodo = c.codigoperiodo
and c.codigocarrera = '".$_POST['especializacion']."'
and p.codigoestadoperiodo like '1'
order by p.codigoperiodo";
$periodo = mysql_query($query_periodo, $sala) or die("$query_periodo");
$totalRows_periodo = mysql_num_rows($periodo);
$row_periodo = mysql_fetch_assoc($periodo);

if(isset($_GET['idpreinscripcion']) && $row_estudiante == "")
{
	if(!isset($_POST['periodo']))
	{
		$_POST['periodo'] == $row_periodo['codigoperiodo'];
	}
}
?>
<script language="javascript">
function enviar()
{
	document.inscripcion.submit();
}
</script>
<html>
<head>
<title>
Inscripciones
</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language="JavaScript" src="calendario/javascripts.js">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body>
<form name="inscripcion" method="post" action="">
<p>
FORMULARIO DEL ASPIRANTE
<br>
<?php
$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,
i.idinscripcion,s.nombresituacioncarreraestudiante,i.numeroinscripcion,i.codigosituacioncarreraestudiante,i.codigoperiodo,
c.codigoindicadorcobroinscripcioncarrera, c.codigoindicadorprocesoadmisioncarrera, ec.codigocarrera, ec.codigoestudiante
FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci,situacioncarreraestudiante s, estudiante ec, periodo p
WHERE numerodocumento = '$codigoinscripcion'
AND eg.idestudiantegeneral = i.idestudiantegeneral
AND s.codigosituacioncarreraestudiante = i.codigosituacioncarreraestudiante
AND eg.idciudadnacimiento = ci.idciudad
AND i.idinscripcion = e.idinscripcion
AND e.codigocarrera = c.codigocarrera
AND m.codigomodalidadacademica = i.codigomodalidadacademica
AND i.codigoestado like '1%'
AND e.idnumeroopcion = '1'
and ec.codigocarrera = e.codigocarrera
and ec.idestudiantegeneral = eg.idestudiantegeneral
and p.codigoestadoperiodo like '1'";
$data = mysql_query($query_data, $sala) or die("$query_data".mysql_error());
$totalRows_data = mysql_num_rows($data);
$row_data = mysql_fetch_assoc($data);
$idestudiantegeneral = $row_data['idestudiantegeneral'];
//********************************* tipo usuario **////////////////////////////////////////////////////////
    $usuario = $_SESSION['MM_Username'];
    $query_tipousuario = "SELECT *
	FROM usuariofacultad
	where usuario = '".$usuario."'";	
	$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
	$row_tipousuario = mysql_fetch_assoc($tipousuario);
	$totalRows_tipousuario = mysql_num_rows($tipousuario);   


?>
</p>
<table width="70%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="left">
<label id="labelresaltado">Si desea inscribirse a otro programa académico, diligencie el siguiente Formulario</label>
<table id="interna" border="1" cellpadding="1" cellspacing="0" width="100%" bordercolor="#E9E9E9">
<tr>
<td id="tdtitulogris">
  Modalidad Acad&eacute;mica <label id="labelresaltado">*</label>
</td>
<td>
  <select name="modalidad" id="modalidad" onChange="enviar()">
    <option value="0"<?php if (!(strcmp("0", $_POST['modalidad']))) {echo "SELECTED";} ?>>
      Seleccionar
    </option>
<?php
do 
{
?>
    <option value="<?php echo $row_modalidad['codigomodalidadacademica']?>" <?php if (!(strcmp($row_modalidad['codigomodalidadacademica'], $_POST['modalidad']))) {echo "SELECTED";} ?>>
      <?php echo $row_modalidad['nombremodalidadacademica']?>
    </option>
    <?php
}
while ($row_modalidad = mysql_fetch_assoc($modalidad));
$rows = mysql_num_rows($modalidad);
if($rows > 0)
{
	mysql_data_seek($car, 0);
    $row_modalidad = mysql_fetch_assoc($modalidad);
}
?>
  </select>
</td>
<td colspan="1" id="tdtitulogris">
<strong>Fecha&nbsp;&nbsp;</strong>
<?php echo date("j-n-Y g:i",time());?>
  &nbsp;
  <input name="hora" type="hidden" id="hora2" value="<?php echo time();?>">
  </font>
  <strong>
  </strong>
  <span class="Estilo16">
  </span>
</td>
<td><div align="left"><a onClick="window.open('../../manualpreinscripcion/preinscripcion.html','mensajes','width=700,height=700,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></div></td>
</tr>
<tr>
<td id="tdtitulogris">
  Nombre del Programa 
    <label id="labelresaltado">*</label></td>
<td colspan="3">
<?php
//if($_POST['modalidad'] <> 0)
//{  // if 1
	$fecha = date("Y-m-d G:i:s",time());
 	$query_car = "SELECT nombrecarrera,codigocarrera
  	FROM carrera
  	where codigomodalidadacademica = '".$_POST['modalidad']."'
  	AND fechavencimientocarrera > '".$fecha."'
	and codigoindicadorinscripcion like '1%'
  	order by 1";
  	$car = mysql_query($query_car, $sala) or die(mysql_error());
  	$row_car = mysql_fetch_assoc($car);
  	$totalRows_car = mysql_num_rows($car);
 //}

?>
  <select name="especializacion" id="especializacion" onChange="enviar()">
    <option value="0" <?php if (!(strcmp("0", $_POST['especializacion']))) {echo "SELECTED";} ?>>
      Seleccionar
    </option>
<?php
do
{
?>
    <option value="<?php echo $row_car['codigocarrera']?>" <?php if (!(strcmp($row_car['codigocarrera'], $_POST['especializacion']))) {echo "SELECTED";} ?>>
      <?php echo $row_car['nombrecarrera']?>
    </option>
    <?php
} 
while ($row_car = mysql_fetch_assoc($car));
$rows = mysql_num_rows($car);
if($rows > 0)
{
	mysql_data_seek($car, 0);
    $row_car = mysql_fetch_assoc($car);
}
?>
  </select>
</td>
</tr>
<tr>
<td id="tdtitulogris">
  Periodo al que se preinscribe 
    <label id="labelresaltado">*</label>
</td>
<td colspan="3"><?php

if($_POST['especializacion'] <> 0)
{  // if 1
  	$query_periodo = "select * from periodo p,carreraperiodo c
  	where p.codigoperiodo = c.codigoperiodo
  	and c.codigocarrera = '".$_POST['especializacion']."'
  	and (p.codigoestadoperiodo like '1' or p.codigoestadoperiodo like '3')
  	order by p.codigoestadoperiodo";

	$periodo = mysql_query($query_periodo, $sala) or die("$query_periodo");
  	$totalRows_periodo = mysql_num_rows($periodo);
  	$row_periodo = mysql_fetch_assoc($periodo);

	if ($row_periodo == "")
		{
			echo '<script language="JavaScript">
			alert("No hay periodo para este Programa"); histoy.go(-1);
			</script>';
		   exit;
		}
}

?><select name="periodo">
  <?php
do 
{
?>
    <option value="<?php echo $row_periodo['codigoperiodo']?>" <?php if (!(strcmp($row_periodo['codigoperiodo'], $_POST['periodo']))) {echo "SELECTED";} ?>>
      <?php echo $row_periodo['nombreperiodo']?>
    </option>
  <?php
} 
while ($row_periodo = mysql_fetch_assoc($periodo));
$rows = mysql_num_rows($periodo);
if($rows >  0) 
{
	mysql_data_seek($periodo, 0);
  	$row_periodo = mysql_fetch_assoc($periodo);
}
?>
</select>
</td>
</tr>
<?php
if ($row_tipousuario['codigotipousuariofacultad'] == 200 and $_POST['modalidad'] == 600)
{
?>
<tr>
<td id="tdtitulogris">Tipo Alumno<label id="labelresaltado">*</label></td>
<td colspan="3">
Nuevo 
          <input name="study" type="radio" value="nuevo" checked>&nbsp;&nbsp;&nbsp;
  Antiguo <input name="study" type="radio" value="antiguo">
</td>
</tr>
<?php 
 }
?>
</table>

<br>

<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr>
<td colspan="7" id="tdtitulogris">
  INFORMACI&Oacute;N PERSONAL
</td>
</tr>
<tr>
<td id="tdtitulogris">
<select name="trato" <?php if($row_estudiante){ echo ""; }?> id="habilita">
  <option value="0" <?php if (!(strcmp("0", $_POST['trato']))) {echo "SELECTED";} ?>>
    Trato
  </option>
<?php
do 
{
?>
 <option value="<?php echo $row_trato['idtrato']?>" <?php if (!(strcmp($row_trato['idtrato'], $_POST['trato']))) {echo "SELECTED";} else if($row_trato['idtrato']== $row_estudiante['idtrato']){ echo "SELECTED";}?>>
 <?php echo $row_trato['inicialestrato']?>
  </option>
  <?php
}
while($row_trato = mysql_fetch_assoc($trato));
$rows = mysql_num_rows($trato);
if($rows >  0)
{
	mysql_data_seek($trato, 0);
	$row_trato = mysql_fetch_assoc($trato);
}
?>
</select>
</td>
<td id="tdtitulogris">
<div align="left">
  Nombre
  <label id="labelresaltado">*</label>
</div>
 </td>
<td>
  <input name="nombres" type="text" id="nombres" size="20" maxlength="50" value="<?php if(!$row_estudiante){echo $_POST['nombres'];} else {echo $row_estudiante['nombresestudiantegeneral'];}?>" <?php if($row_estudiante){ echo "readonly"; }?>>
</td>
<td id="tdtitulogris">
<div align="left">
  Apellidos
  <label id="labelresaltado">*</label>
</div>
</td>
<td colspan="3">
  <input name="apellidos" type="text" id="apellidos" size="30" maxlength="50" value="<?php if(!$row_estudiante){echo $_POST['apellidos'];} else {echo $row_estudiante['apellidosestudiantegeneral'];}?>" <?php if($row_estudiante){ echo "readonly"; }?>>
</td>
</tr>
<tr>
<td colspan="2" id="tdtitulogris">
<div align="left">
  Tipo Documento
 <label id="labelresaltado">*</label>
</div>
</td>
<td>
<select name="tipodocumento" <?php if($row_estudiante){ echo ""; }?> id="habilita">
<?php
do
{
?>
 <option value="<?php echo $row_documentos['tipodocumento']?>" <?php if (!(strcmp($row_documentos['tipodocumento'], $_POST['tipodocumento']))) {echo "SELECTED";} else if($row_documentos['tipodocumento'] == $row_estudiante['tipodocumento']){ echo "SELECTED";}?>>
   <?php echo $row_documentos['nombredocumento']?>
  </option>
  <?php
}
while($row_documentos = mysql_fetch_assoc($documentos));
$rows = mysql_num_rows($documentos);
if($rows >  0)
{
	mysql_data_seek($documentos, 0);
	$row_documentos = mysql_fetch_assoc($documentos);
}
?>
</select>
</td>
<td id="tdtitulogris">
<div align="left">
  Documento
  <label id="labelresaltado">*</label>
</div>
</td>
<td>
  <input name="numerodocumento" type="text" id="numerodocumento" size="10" maxlength="12" value="<?php if(!$row_estudiante){if(!$_POST['numerodocumento']){echo $documento;} else {echo $_POST['numerodocumento'];}} else {echo $row_estudiante['numerodocumento'];}?>" <?php if($row_estudiante){ echo "readonly"; }?> readonly></td>
<td id="tdtitulogris">
<div align="left">
  Expedida en
  <label id="labelresaltado">*</label>
</div>
</td>
<td>
<?php
$query_ciudad = "select *
from ciudad c,departamento d
where c.iddepartamento = d.iddepartamento
order by 3";
$ciudad = mysql_query($query_ciudad, $sala) or die("$query_ciudad");
$totalRows_ciudad= mysql_num_rows($ciudad);
$row_ciudad = mysql_fetch_assoc($ciudad);
?>
<input name="expedidodocumento" type="text" id="expedidodocumento" size="10" maxlength="15" value="<?php if(!$row_estudiante){echo $_POST['expedidodocumento'];} else {echo $row_estudiante['expedidodocumento'];}?>" <?php if($row_estudiante){ echo "readonly"; }?>>
</td>
</tr>
<?php 
if ($_SESSION['MM_Username'] == "estudiante2") /////////////////////////////////////////////////// 
{  //   if ($_SESSION['MM_Username'] == "estudiante") 
?>
<tr>
<td colspan="2" id="tdtitulogris">
<div align="left">
  Fecha Nacimiento
  <label id="labelresaltado">*</label>
</div>
</td>
<td>

<input name="fecha1" type="text" size="10" value="<?php if(isset($row_estudiante['fechanacimientoestudiantegeneral'])) echo $row_estudiante['fechanacimientoestudiantegeneral']; else echo $_POST['fecha1']?>" maxlength="10"<?php if($row_estudiante){ echo "readonly"; }?>> 
aaaa-mm-dd 
</td>

<td colspan="1" id="tdtitulogris">
<div align="left">
  G&eacute;nero
  <label id="labelresaltado">*</label>
</div>
</td>
<td colspan="3">
<span class="style2">
<select name="genero" <?php if($row_estudiante){ echo ""; }?>>
  <option value="0" <?php if (!(strcmp(0, $_POST['genero']))) {echo "SELECTED";} ?>>
    Seleccionar
  </option>
<?php
do
{
?>
  <option value="<?php echo $row_selgenero['codigogenero']?>" <?php if (!(strcmp($row_selgenero['codigogenero'], $_POST['genero']))) {echo "SELECTED";} else if($row_selgenero['codigogenero'] == $row_estudiante['codigogenero']){ echo "SELECTED";}?>>
    <?php echo $row_selgenero['nombregenero']?>
  </option>
  <?php
}
while ($row_selgenero = mysql_fetch_assoc($selgenero));
$rows = mysql_num_rows($selgenero);
if($rows >  0)
{
	mysql_data_seek($selgenero, 0);
  	$row_selgenero = mysql_fetch_assoc($selgenero);
}
?>
</select>
</span>
</td>
</tr>
<tr>
<td colspan="2" id="tdtitulogris">
<div align="left">
  Departamento Nacimiento
  <span class="Estilo4">
  <label id="labelresaltado">*</label>
</span>
</div>
</td>
<td id="tdtitulogris">
<?php
$query_dep_nacimiento = "select *
from departamento d
where d.codigoestado like '1%'
and d.idpais = 1
order by 3";
$dep_nacimiento = mysql_query($query_dep_nacimiento, $sala) or die("$query_dep_nacimiento");
$totalRows_dep_nacimiento= mysql_num_rows($dep_nacimiento);
$row_dep_nacimiento = mysql_fetch_assoc($dep_nacimiento);
?>
<select name="dep_nacimiento" id="dep_nacimiento" onChange="enviar()">
  <option value="0"<?php if (!(strcmp("0", $_POST['dep_nacimiento']))) {echo "SELECTED";} ?>> Seleccionar </option>
  <option value="Extranjero"<?php if (!(strcmp("Extranjero", $_POST['dep_nacimiento']))) {echo "SELECTED";} ?>>Extranjero</option>
  <?php
do
{
?>
  <option value="<?php echo $row_dep_nacimiento['iddepartamento']?>" <?php if (!(strcmp($row_dep_nacimiento['iddepartamento'], $_POST['dep_nacimiento']))) {echo "SELECTED";}  else if($row_dep_nacimiento['iddepartamento'] == $row_estudiante['iddepartamento']){ echo "SELECTED";}?>><?php echo $row_dep_nacimiento['nombredepartamento'];?></option>
  <?php	
}
while($row_dep_nacimiento = mysql_fetch_assoc($dep_nacimiento));
$rows = mysql_num_rows($dep_nacimiento);
if($rows >  0)
{
	mysql_data_seek($dep_nacimiento, 0);
  	$row_dep_nacimiento = mysql_fetch_assoc($dep_nacimiento);
}
?>
</select></td>
<td id="tdtitulogris">
<div align="left">
  Lugar Nacimiento
  <span class="Estilo4">
  <label id="labelresaltado">*</label>
</span>
</div>
</td>
<td colspan="3" id="tdtitulogris">
<span class="style2" >
</span>
<strong>
<span class="style2">
<font size="2" face="Tahoma">
<?php
if ($_POST['dep_nacimiento'] == 'Extranjero')
{
	$query_ciudad = "SELECT c.idciudad,c.nombreciudad
	FROM ciudad c,departamento d,pais p
	WHERE d.iddepartamento = c.iddepartamento
	AND p.idpais = d.idpais
	AND p.idpais <> 1
	ORDER BY 2";
	$ciudad = mysql_query($query_ciudad, $sala) or die("$query_ciudad");
	$totalRows_ciudad= mysql_num_rows($ciudad);
	$row_ciudad = mysql_fetch_assoc($ciudad);	 
}
else
{
	$query_ciudad = "select *
	from ciudad c
	where iddepartamento = '".$_POST['dep_nacimiento']."'
	order by 3";
	$ciudad = mysql_query($query_ciudad, $sala) or die("$query_ciudad");
	$totalRows_ciudad= mysql_num_rows($ciudad);
	$row_ciudad = mysql_fetch_assoc($ciudad);
}
?>
 <select name="ciudadnacimiento" <?php if($row_estudiante){ echo ""; }?> id="habilita">
  <option value="0"
<?php if (!(strcmp("0", $_POST['ciudadnacimiento']))) {echo "SELECTED";} ?> >
    Seleccionar
  </option>
  <?php
do
{
  ?>
  <option value="<?php echo $row_ciudad['idciudad']?>" <?php if (!(strcmp($row_ciudad['idciudad'], $_POST['ciudadnacimiento']))) {echo "SELECTED";} else if($row_ciudad['idciudad'] == $row_estudiante['idciudadnacimiento']){ echo "SELECTED";}?> >
    <?php echo $row_ciudad['nombreciudad'];?>
  </option>
<?php
}
while($row_ciudad = mysql_fetch_assoc($ciudad)); 
$rows = mysql_num_rows($ciudad);
if($rows >  0)
{
	mysql_data_seek($ciudad, 0);
  	$row_ciudad = mysql_fetch_assoc($ciudad);
}
?>
</select>
</font></span></strong></td>
</tr>
<tr>
<td colspan="2" id="tdtitulogris">
<div align="left">
  Departamento  Residencia<span class="Estilo4">
  <label id="labelresaltado">*</label>
</span>
</div>
</td>
<td id="tdtitulogris">
<?php
$query_dep_residencia = "select *
from departamento d
where d.codigoestado like '1%'
and d.idpais = 1
order by 3";
$dep_residencia = mysql_query($query_dep_residencia, $sala) or die("$query_dep_residencia");
$totalRows_dep_residencia= mysql_num_rows($dep_residencia);
$row_dep_residencia = mysql_fetch_assoc($dep_residencia);
?>
<select name="dep_residencia" <?php if($row_estudiante){ echo ""; }?> id="dep_residencia" onChange="enviar()">
  <option value="0"<?php if (!(strcmp("0", $_POST['dep_residencia']))) {echo "SELECTED";} ?>> Seleccionar </option>
  <option value="Extranjero"<?php if (!(strcmp("Extranjero", $_POST['dep_residencia']))) {echo "SELECTED";} ?>>Extranjero</option>
  <?php
do
{
  ?>
  <option value="<?php echo $row_dep_residencia['iddepartamento']?>" <?php if (!(strcmp($row_dep_residencia['iddepartamento'], $_POST['dep_residencia']))) {echo "SELECTED";}  else if($row_dep_residencia['iddepartamento'] == $row_estudiante['iddepartamento']){ echo "SELECTED";}?>><?php echo $row_dep_residencia['nombredepartamento'];?> </option>
  <?php	
}
while($row_dep_residencia = mysql_fetch_assoc($dep_residencia));
$rows = mysql_num_rows($dep_residencia);
if($rows >  0)
{
	mysql_data_seek($dep_residencia, 0);
	$row_dep_residencia = mysql_fetch_assoc($dep_residencia);
}
?>
</select>
</td>
<td id="tdtitulogris">
<div align="left">
  Ciudad Residencia
  <span class="Estilo4">
  <label id="labelresaltado">*</label>
</span>
</div>
</td>
<td colspan="3" id="tdtitulogris">
<?php
if ($_POST['dep_residencia'] == 'Extranjero')
{
	$query_ciudad_residencia= "SELECT c.idciudad,c.nombreciudad
	FROM ciudad c,departamento d,pais p
	WHERE d.iddepartamento = c.iddepartamento
	AND p.idpais = d.idpais
	AND p.idpais <> 1
	ORDER BY 2";
	$ciudad_residencia = mysql_query($query_ciudad_residencia, $sala) or die("$query_ciudad_residencia");
	$totalRows_ciudad_residencia= mysql_num_rows($ciudad_residencia);
	$row_ciudad_residencia = mysql_fetch_assoc($ciudad_residencia);	  
}
else
{
	$query_ciudad_residencia= "select *
	from ciudad c
	where iddepartamento = '".$_POST['dep_residencia']."'
	order by 3";
	$ciudad_residencia = mysql_query($query_ciudad_residencia, $sala) or die("$query_ciudad_residencia");
	$totalRows_ciudad_residencia= mysql_num_rows($ciudad_residencia);
	$row_ciudad_residencia = mysql_fetch_assoc($ciudad_residencia); 
}
?>
<select name="ciudad" <?php if($row_estudiante){ echo ""; }?> id="habilita">
  <option value="0"
    <?php if (!(strcmp("0", $_POST['ciudad']))) {echo "SELECTED";} ?>>
    Seleccionar
  </option>
<?php
do
{
?>
  <option value="<?php echo $row_ciudad_residencia['idciudad']?>" <?php if (!(strcmp($row_ciudad_residencia['idciudad'], $_POST['ciudad']))) {echo "SELECTED";} else if($row_ciudad_residencia['idciudad'] == $row_estudiante['ciudadresidenciaestudiantegeneral']){ echo "SELECTED";}?> >
    <?php echo $row_ciudad_residencia['nombreciudad'];?>
  </option>
<?php
}
while($row_ciudad_residencia = mysql_fetch_assoc($ciudad_residencia));
$rows = mysql_num_rows($ciudad_residencia);
if($rows >  0)
{
	mysql_data_seek($ciudad_residencia, 0);
  	$row_ciudad_residencia = mysql_fetch_assoc($ciudad_residencia);
}
?>
</select>
</font>
</span>
</strong>
</td>
</tr>
<tr>
<td colspan="2" id="tdtitulogris">
<div align="left">
  Dirección Residencia
  <span class="Estilo4">
  <label id="labelresaltado">*</label>
</span>
</div>
</td>
<td colspan="5" id="tdtitulogris">
<?php
if ($_SESSION['nuevadireccionlarga'] <> "")
{
	$_POST['direccion'] = $_SESSION['nuevadireccionlarga'];

}
?>
<INPUT name="direccion" size="90" readonly onclick="window.open('direccion.php?preinscripcion=1','direccion','width=1000,height=300,left=150,top=150,scrollbars=yes')" value="<?php if(!$row_estudiante){echo $_POST['direccion'];} else {echo $row_estudiante['direccionresidenciaestudiantegeneral'];} ?>" <?php if($row_estudiante){ echo "readonly"; }?>>
<INPUT name="direccionoculta" value="<?php echo $_POST['direccionoculta'];?>" type="hidden">&nbsp;
<a onClick="window.open('../../manualdireccion/direccion.htm','mensajes','width=700,height=700,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/pregunta.gif" width="18" height="18" alt="Ayuda"></a>
</td>
</tr>
<?php 
}
?>
<tr>
<td colspan="2" id="tdtitulogris">
<div align="left">
  Tel&eacute;fono Residencia
  <label id="labelresaltado">*</label>
</div>
</td>
<td>
<input name="telefono" type="text" id="telefono" value="<?php if(!$row_estudiante){echo $_POST['telefono'];} else {echo $row_estudiante['telefonoresidenciaestudiantegeneral'];}?>" size="10" maxlength="50" <?php if($row_estudiante){ echo "readonly"; }?>>
</td>
<td id="tdtitulogris">
<div align="left">
  E-mail
    <label id="labelresaltado">*</label>
</div>
</td>
<td colspan="3">
<input name="email" type="text" id="email" size="50" maxlength="50" value="<?php if(!$row_estudiante){echo $_POST['email'];} else {echo $row_estudiante['emailestudiantegeneral'];}?>" <?php if($row_estudiante){ echo "readonly"; }?>>
<INPUT name="correooculto" value="<?php echo $_POST['correooculto'];?>" type="hidden">
</td>
</tr>
</table>
<br>
<label id="labelresaltado">Por favor asegúrese de que el E-mail digitado sea el correcto, por este medio podra continuar con su proceso de Inscripción. </label>
<br><label id="labelpequeno">Una vez generada y cancelada  la orden de pago, 24 horas después se habilitara el nombre del  programa al que aspira en forma de Link, para continuar el proceso de Inscripción.</label>
<br>
<br>

<?php
if($row_data <> "")
{ 
	$idestudiantegeneral = $row_data['idestudiantegeneral'];
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr>
  <td colspan="7" id="tdtitulogris">INSCRIPCIONES Y PAGOS</td>
 </tr>
<tr>
  <td align="left" id="tdtitulogris">
    Modalidad
  </td>
  <td align="left" id="tdtitulogris">
    Programa
  </td>
  <td align="left" id="tdtitulogris">
    Periodo
  </td>
  <td align="left" id="tdtitulogris">
    N° Orden
  </td>
  <td align="left" id="tdtitulogris">
    Valor
  </td>
  <td align="left" id="tdtitulogris">
    Estado
  </td>
  <td align="left" id="tdtitulogris">
    Pago Bancos
  </td>
</tr>
<?php
	do
	{
		$ordenesxestudiante = new Ordenesestudiante($sala, $row_data['codigoestudiante'], $row_data['codigoperiodo']);
		$cuentaordenes = $ordenesxestudiante->numerodeordenes();

?>
<tr>
  <td align="left" rowspan="<?php echo $cuentaordenes; ?>">
    <?php echo $row_data['nombremodalidadacademica'];?> </td>
  <td rowspan="<?php echo $cuentaordenes; ?>" align="left">
  <?php
		//echo $row_data['codigomodalidadacademica'],"<br>";
		if ($row_data['codigosituacioncarreraestudiante'] == 107 or $row_data['codigosituacioncarreraestudiante'] == 300)
		{
  ?>
    <a href="datosbasicos.php?modalidad=<?php echo $row_data['codigomodalidadacademica'];?>&inscripcionactiva=<?php echo $row_data['idinscripcion'];?>">
    <?php echo $row_data['nombrecarrera'];?>
    </a>
  <?php
		}
		else
		{
  ?>
    <?php echo $row_data['nombrecarrera'];?>
  <?php
		}
  ?>
  </td>
  <td rowspan="<?php echo $cuentaordenes; ?>" align="left">
    <?php echo $row_data['codigoperiodo']; ?>
  </td>
<?php
		if($ordenesxestudiante->existenordenesdepago)
		{
			$ordenesxestudiante->mostrar_ordenespago_resumido($rutaorden,"");
		}
		else
		{
?>
  <td colspan="4" align="center">
  <a href="generarordenpagoinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso']."&codigoestudiante=".$row_data['codigoestudiante']."&codigoperiodo=".$row_data['codigoperiodo']."&todos"; ?>">Generación Orden de Pago</a>
  </td>
<?php	
		}
?>
</tr>
<?php
	}
	while($row_data = mysql_fetch_assoc($data));
?>
<tr class="Estilo1" bgcolor='#FEF7ED'>
</tr>
</table>
<?php
}
?>
</td>
</tr>
</table>
<br>
<input type="submit" value="Enviar" name="Enviar">

<script language="javascript">
function correos(correooculto1)
{
	document.inscripcion.correooculto.value=correooculto1;
    document.inscripcion.submit();  
}
</script> 
<script language="javascript">

function recargar(direccioncompleta, direccioncompletalarga)
{
	document.inscripcion.direccion.value=direccioncompletalarga;
	document.inscripcion.direccionoculta.value=direccioncompleta;
}

</script>
<?php

$banderagrabar = 0;

if ($_POST['Enviar'] or $_POST['correooculto'] <> "")
{
	$ano = substr($_POST['fecha1'],0,4); 
    $mes = substr($_POST['fecha1'],5,2);
    $dia = substr($_POST['fecha1'],8,2);
	
	if($_POST['modalidad'] == 0 or $_POST['especializacion'] == 0)
	{
		echo '<script language="JavaScript">
		alert("Debe seleccionar la Modalidad Académica  y el Nombre del Programa")
		</script>';
		$banderagrabar = 1;
	}
	$query_periodoactivo = "select * from periodo p,carreraperiodo c
	where p.codigoperiodo = c.codigoperiodo
	and c.codigocarrera = '".$_POST['especializacion']."'
	and p.codigoestadoperiodo like '1'
	order by p.codigoperiodo";
	$periodoactivo = mysql_query($query_periodoactivo, $sala) or die("$query_periodoactivo");
	$totalRows_periodoactivo = mysql_num_rows($periodoactivo);
	$row_periodoactivo = mysql_fetch_assoc($periodoactivo);

	$email = "^[A-z0-9\._-]+"
	."@"
	."[A-z0-9][A-z0-9-]*"
	."(\.[A-z0-9_-]+)*"
	."\.([A-z]{2,6})$";	
	
  	if ($_SESSION['MM_Username'] == "estudiante2")
   	{ // validatodo
   
		if ($_POST['trato'] == 0 and !$existe)
		{
			echo '<script language="JavaScript">
			alert("Debe seleccionar el trato");
			</script>';
			$banderagrabar = 1;
		}
		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombres']) or $_POST['nombres'] == "") and !$existe )
		{
			echo '<script language="JavaScript">
			alert("El Nombre es Incorrecto")
			</script>';
			$banderagrabar = 1;
		}
		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['apellidos']) or $_POST['apellidos'] == "") and !$existe )
		{
			echo '<script language="JavaScript">
			alert("El Apellido es Incorrecto")
			</script>';
			$banderagrabar = 1;
		}
		else if ($_POST['tipodocumento'] == 0 and !$existe )
		{
			echo '<script language="JavaScript">
			alert("Debe seleccionar el tipo de documento")
			</script>';
			$banderagrabar = 1;
		}
		else if (!eregi("^[0-9]{1,15}$", $_POST['numerodocumento']) and !$existe )
		{
			echo '
			<script language="JavaScript">
			alert("Número de documento Incorrecto")
			</script>
			';
			$banderagrabar = 1;
		}
		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['expedidodocumento']) or $_POST['expedidodocumento'] == "") and !$existe )
		{
			echo '
			<script language="JavaScript">
			alert("Expedido documento es Incorrecto")
			</script>
			';
			$banderagrabar = 1;
		}
		else if (!(@checkdate($mes, $dia,$ano)) or ($ano > date("Y")) or ($ano < 1900)) 
	 	{
	   		echo '
			<script language="JavaScript">
			alert("La fecha digitada debe ser valida y en formato aaaa-mm-dd")
			</script>
			';
			$banderagrabar = 1;
	 	}
		else if ($_POST['ciudadnacimiento'] == 0 and !$existe)
		{
			echo '
			<script language="JavaScript">
			alert("Debe seleccionar el lugar de Nacimiento")
			</script>
			';
			$banderagrabar = 1;
		}

		else if ($_POST['genero'] == 0 and !$existe )
		{
			echo '
			<script language="JavaScript">
			alert("Debe seleccionar el genero")
			</script>';
			$banderagrabar = 1;
		}
		else if ((!eregi($email,$_POST['email']) or $_POST['email'] == "")and !$existe)
		{
			echo '
			<script language="JavaScript">
			alert("E-mail Incorrecto")
			</script>';
			$banderagrabar = 1;
		}
		else if ($_POST['direccion'] == "" and !$existe )
		{
			echo '
			<script language="JavaScript">
			alert("Debe Digitar una Dirección")
			</script>';
			$banderagrabar = 1;
		}
		else if (!eregi("^[0-9]{1,15}$", $_POST['telefono']) and !$existe )
		{
			echo '
			<script language="JavaScript">
			alert("Telefono Incorrecto")
			</script>';
	
			$banderagrabar = 1;
	
		}
		else if ($_POST['ciudad'] == 0 and !$existe )
		{
			echo '<script language="JavaScript">alert("Seleccione Ciudad de Residencia")</script>'; 
			$banderagrabar = 1;
		}
		//else bueno
 	} // validatodo	
	else
 	{ // no valide
    	if ($_POST['trato'] == 0 and !$existe)
		{
			echo '<script language="JavaScript">
			alert("Debe seleccionar el trato");
			</script>';
			$banderagrabar = 1;
		}
		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombres']) or $_POST['nombres'] == "") and !$existe )
		{
			echo '<script language="JavaScript">
			alert("El Nombre es Incorrecto")
			</script>';
			$banderagrabar = 1;
		}
		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['apellidos']) or $_POST['apellidos'] == "") and !$existe )
		{
			echo '<script language="JavaScript">
			alert("El Apellido es Incorrecto")
			</script>';
			$banderagrabar = 1;
		}
		else if ($_POST['tipodocumento'] == 0 and !$existe )
		{
			echo '<script language="JavaScript">
			alert("Debe seleccionar el tipo de documento")
			</script>';
			$banderagrabar = 1;
		}
		else if (!eregi("^[0-9]{1,15}$", $_POST['numerodocumento']) and !$existe )
		{
			echo '
			<script language="JavaScript">
			alert("Número de documento Incorrecto")
			</script>
			';
			$banderagrabar = 1;
		}
		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['expedidodocumento']) or $_POST['expedidodocumento'] == "") and !$existe )
		{
			echo '
			<script language="JavaScript">
			alert("Expedido documento es Incorrecto")
			</script>
			';
			$banderagrabar = 1;
		}
		else if (!eregi("^[0-9]{1,15}$", $_POST['telefono']) and !$existe )
		{
			echo '
			<script language="JavaScript">
			alert("Telefono Incorrecto")
			</script>';
			$banderagrabar = 1;
		}
	}// no valide	
	if ($banderagrabar == 0)
	{
		$query_usuarioclave = "select *
		from usuariopreinscripcion
		where usuariopreinscripcion = '".$_POST['numerodocumento']."'";
		$usuarioclave = mysql_query($query_usuarioclave, $sala) or die("$query_usuarioclave");
		$totalRows_usuarioclave = mysql_num_rows($usuarioclave);
		$row_usuarioclave = mysql_fetch_assoc($usuarioclave);
		
		if ($_POST['correooculto'] == "" and !$row_usuarioclave)
		{
	    	$pass = generar_pass(8);
			echo '<input name="contrasena" type="hidden" value="'.$pass.'">';
?>
			<script language="JavaScript">
				if(confirm("Para continuar su proceso de Inscripción se ha generado un usuario y una clave:\nUsuario:  <?php echo $_POST['numerodocumento'];?> \nClave: <?php echo $pass ;?>\n\nTambién se le enviara a su e-mail <?php echo $_POST['email'];?> el usuario y la clave.\n\n¿EL E-MAIL REGISTRADO ES EL CORRECTO? \n<?php echo $_POST['email'];?>"))
				{
					correos("confirmar");
				}
			</script> 
<?php
			exit();
		}
		$pass = $_POST['contrasena'];
		$idnumeroinscripcion  = 0;
		if (!$row_estudiante)
		{
			if ($_SESSION['MM_Username'] == "estudiante2")
            {
				$query_insestudiante = "INSERT INTO estudiantegeneral(idestudiantegeneral,idtrato, idestadocivil,tipodocumento, numerodocumento, expedidodocumento, nombrecortoestudiantegeneral, nombresestudiantegeneral, apellidosestudiantegeneral, fechanacimientoestudiantegeneral,idciudadnacimiento ,codigogenero, direccionresidenciaestudiantegeneral,direccioncortaresidenciaestudiantegeneral,ciudadresidenciaestudiantegeneral, telefonoresidenciaestudiantegeneral, telefono2estudiantegeneral, celularestudiantegeneral, direccioncorrespondenciaestudiantegeneral, direccioncortacorrespondenciaestudiantegeneral,ciudadcorrespondenciaestudiantegeneral, telefonocorrespondenciaestudiantegeneral, emailestudiantegeneral, fechacreacionestudiantegeneral, fechaactualizaciondatosestudiantegeneral,codigotipocliente)
				VALUES(0, '".$_POST['trato']."','1', '".$_POST['tipodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['expedidodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['nombres']."', '".$_POST['apellidos']."', '".$_POST['fecha1']."', '".$_POST['ciudadnacimiento']."', '".$_POST['genero']."', '".$_POST['direccion']."','".$_POST['direccionoculta']."' ,'".$_POST['ciudad']."', '".$_POST['telefono']."', '".$_POST['telefono']."', '".$_POST['celular']."','".$_POST['direccion']."', '".$_POST['direccionoculta']."','".$_POST['ciudad']."', '".$_POST['telefono']."', '".$_POST['email']."', '".date("Y-m-d G:i:s",time())."', '".date("Y-m-d G:i:s",time())."','0')";
				$insestudiante = mysql_db_query($database_sala,$query_insestudiante) or die("$query_insestudiante".mysql_error());
				$idestudiantegeneral = mysql_insert_id();
		    }
			else
			{
				if( $_POST['email'] <> "")
				{				   
					$maildigitado = $_POST['email'];
				}
				else
				{
					$maildigitado = "campo@faltante";
				}				
				$query_insestudiante = "INSERT INTO estudiantegeneral(idestudiantegeneral,idtrato, idestadocivil,tipodocumento, numerodocumento, expedidodocumento, nombrecortoestudiantegeneral, nombresestudiantegeneral, apellidosestudiantegeneral, fechanacimientoestudiantegeneral,idciudadnacimiento ,codigogenero, direccionresidenciaestudiantegeneral,direccioncortaresidenciaestudiantegeneral,ciudadresidenciaestudiantegeneral, telefonoresidenciaestudiantegeneral, telefono2estudiantegeneral, celularestudiantegeneral, direccioncorrespondenciaestudiantegeneral, direccioncortacorrespondenciaestudiantegeneral,ciudadcorrespondenciaestudiantegeneral, telefonocorrespondenciaestudiantegeneral, emailestudiantegeneral, fechacreacionestudiantegeneral, fechaactualizaciondatosestudiantegeneral,codigotipocliente)
				VALUES(0, '".$_POST['trato']."','1', '".$_POST['tipodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['expedidodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['nombres']."', '".$_POST['apellidos']."', '1900-01-01', '359', '200', 'Campo Faltante','".$_POST['direccionoculta']."' ,'359', '".$_POST['telefono']."', '".$_POST['telefono']."', '','Campo Faltante', '".$_POST['direccionoculta']."','359', '".$_POST['telefono']."', '$maildigitado', '".date("Y-m-d G:i:s",time())."', '".date("Y-m-d G:i:s",time())."','0')";
				$insestudiante = mysql_db_query($database_sala,$query_insestudiante) or die("$query_insestudiante".mysql_error());
				$idestudiantegeneral = mysql_insert_id();			
			}		
		}
		else
		{
			$idestudiantegeneral = $row_estudiante['idestudiantegeneral'];
		}
		
		$query_estudiantedocumento = "SELECT * from estudiantedocumento 
		where numerodocumento = '".$_POST['numerodocumento']."'";
		$estudiantedocumento = mysql_query($query_estudiantedocumento, $sala) or die("$query_estudiantedocumento".mysql_error());
		$totalRows_estudiantedocumento = mysql_num_rows($estudiantedocumento);
		$row_estudiantedocumento = mysql_fetch_assoc($estudiantedocumento);

		if(!$row_estudiantedocumento)
		{  
		   	$query_insestudiantedocumento = "INSERT INTO estudiantedocumento(idestudiantedocumento, idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento) 
		   	VALUES(0, '$idestudiantegeneral', '".$_POST['tipodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['expedidodocumento']."', '".date("Y-m-d G:i:s",time())."', '2999-12-31')"; 

		  	$insestudiantedocumento = mysql_db_query($database_sala,$query_insestudiantedocumento) or die("$query_insestudiantedocumento".mysql_error());
		}
		$query_estudiantecarrera = "select * from estudiante
		where idestudiantegeneral = '$idestudiantegeneral'
		and codigocarrera = '".$_POST['especializacion']."'";
		$estudiantecarrera = mysql_query($query_estudiantecarrera, $sala) or die("$query_estudiantecarrera ".mysql_error());
		$totalRows_estudiantecarrera = mysql_num_rows($estudiantecarrera);
		$row_estudiantecarrera = mysql_fetch_assoc($estudiantecarrera);
		if(!$row_estudiantecarrera)
		{
			$query_insestudiantecarrera = "INSERT INTO estudiante(codigoestudiante, idestudiantegeneral, codigocarrera, semestre, numerocohorte, codigotipoestudiante, codigosituacioncarreraestudiante, codigoperiodo, codigojornada) 
			VALUES(0,'$idestudiantegeneral', '".$_POST['especializacion']."','1', '1', '10', '106', '".$_POST['periodo']."','01')"; 
			//echo "$query_insestudiantecarrera <br>";
			$insestudiantecarrera = mysql_db_query($database_sala,$query_insestudiantecarrera) or die("query_insestudiantecarrera".mysql_error());
			$codigoestudiantecarrera = mysql_insert_id();
		}
		else
		{
			$codigoestudiantecarrera = $row_estudiantecarrera['codigoestudiante'];
		}

		$anoaspira = substr($_POST['periodo'],0,4);
		$periodoaspira = substr($_POST['periodo'],4,5);
		$query_mayor = "select max(idnumeroopcion) as mayor
		from estudiantecarrerainscripcion e,inscripcion i
		where e.idestudiantegeneral = '".$idestudiantegeneral."'
		and e.idinscripcion = i.idinscripcion
		and i.codigomodalidadacademica = '".$_POST['modalidad']."'";
		$mayor = mysql_query($query_mayor, $sala) or die("$query_mayor");
		$totalRows_mayor = mysql_num_rows($mayor);
		$row_mayor = mysql_fetch_assoc($mayor);

		$query_inscripcion = "INSERT INTO inscripcion(numeroinscripcion, fechainscripcion, codigomodalidadacademica, codigoperiodo, anoaspirainscripcion, periodoaspirainscripcion, idestudiantegeneral, codigosituacioncarreraestudiante,codigoestado)
		VALUES('".$_POST['formulario']."','".date("Y-m-d G:i:s",time())."', '".$_POST['modalidad']."', '".$_POST['periodo']."','$anoaspira','$periodoaspira', '$idestudiantegeneral', '106',100)";
		$inscripcion = mysql_db_query($database_sala,$query_inscripcion) or die("$query_inscripcion".mysql_error());
		$idnumeroinscripcion = mysql_insert_id();

		// Informa a el Administrador de la carrera Sabre la Inscripción.
		$query_facultad = "select emailcarreraemail,nombrecarrera, codigoindicadorcobroinscripcioncarrera 
		from carreraemail ce,carrera c
		where c.codigocarrera = '".$_POST['especializacion']."'
		and c.codigocarrera = ce.codigocarrera
		and codigoestado like '1%'";

		$facultad  = mysql_query($query_facultad , $sala) or die("$query_facultad");
		$totalRows_facultad  = mysql_num_rows($facultad );
		$row_facultad  = mysql_fetch_assoc($facultad );
        if ($row_facultad <> "")
		{
			$mailusuario = $row_facultad['emailcarreraemail'];
		   	$nombrecarrera = $row_facultad['nombrecarrera'];
		   	$nombre =  $_POST['apellidos']." ".$_POST['nombres'];
		   	$documento = $_POST['numerodocumento'];
		   	$r = enviamailfacultad($mailusuario,$nombrecarrera,$nombre,$documento);	
		}
		else
		{
			$query_facultad = "select nombrecarrera, codigoindicadorcobroinscripcioncarrera 
			from carrera c
			where c.codigocarrera = '".$_POST['especializacion']."'";

			$facultad  = mysql_query($query_facultad , $sala) or die("$query_facultad");
			$totalRows_facultad  = mysql_num_rows($facultad );
			$row_facultad  = mysql_fetch_assoc($facultad );
		}
		$query_mayor = "select max(idnumeroopcion) as mayor
		from estudiantecarrerainscripcion e,inscripcion i
		where e.idestudiantegeneral = '".$idestudiantegeneral."'
		and e.idinscripcion = i.idinscripcion
		and i.idinscripcion = '$idnumeroinscripcion'
		and i.codigoestado like '1%'";
		$mayor = mysql_query($query_mayor, $sala) or die("$query_mayor");
		$totalRows_mayor = mysql_num_rows($mayor);
		$row_mayor = mysql_fetch_assoc($mayor);
		$idnumeroinscripciones = $row_mayor['mayor'] + 1;

		$query_carrerainscripcion = "INSERT INTO estudiantecarrerainscripcion(codigocarrera, idnumeroopcion, idinscripcion, idestudiantegeneral,codigoestado)
		VALUES('".$_POST['especializacion']."', '$idnumeroinscripciones', '$idnumeroinscripcion', '$idestudiantegeneral', '100')";
		$inscripcion = mysql_db_query($database_sala,$query_carrerainscripcion) or die("$query_carrerainscripcion".mysql_error());
				
		if ($_SESSION['study'] == 'antiguo')
		{
			$query_estadoestudiante ="UPDATE estudiante e,inscripcion i,estudiantecarrerainscripcion ec
		    SET i.codigosituacioncarreraestudiante = '300',
	        e.codigosituacioncarreraestudiante = '300'
	        WHERE i.idestudiantegeneral  = e.idestudiantegeneral
	        AND ec.codigocarrera = e.codigocarrera 
	        AND i.idinscripcion = ec.idinscripcion
	        AND e.codigoestudiante = '$codigoestudiantecarrera'";
		    $estadoestudiante = mysql_db_query($database_sala,$query_estadoestudiante) or die("$query_estadoestudiante".mysql_error());
		    session_unregister('study');
		}
		
		if (!$row_usuarioclave)
		{

			$direccionemail = $_POST['email'];
			mail($direccionemail,"Usuario y Clave para proceso de Inscripción","Bienvenido a la Universidad el Bosque.\n\n Adjunto al presente usuario y clave para el proceso de inscripción.\n.\n\nusuario:".$_POST['numerodocumento']."\nclave:$pass","FROM: Universidad el Bosque <ayuda@unbosque.edu.co>\n");

            $claveencriptada = hash('sha256', $pass);
			$treintadias = date('Y-m-d', time() + (60 * 60 * 24 * 30));
			$noventadias = date('Y-m-d', time() + (60 * 60 * 24 * 90));

			$query_usuarioinscripcion = "INSERT INTO usuariopreinscripcion(idusuariopreinscripcion,idestudiantegeneral,usuariopreinscripcion,claveusuariopreinscripcion,fechavencimientoclaveusuariopresinscripcion,fechavencimientousuariopresinscripcion)
			VALUES(0,'$idestudiantegeneral','".$_POST['numerodocumento']."','$claveencriptada','$treintadias','$noventadias')";
			$user = mysql_db_query($database_sala,$query_usuarioinscripcion) or die("$query_usuarioinscripcion".mysql_error());
			$usuario = mysql_insert_id();
	
			$query_claveinscripcion = "INSERT INTO claveusuariopreinscripcion(idclaveusuariopreinscripcion,idusuariopreinscripcion,fechaclaveusuariopreinscripcion,recordarclaveusuariopreinscripcion,claveusuariopreinscripcion,codigoestadoclaveusuariopreinscripcion)
			VALUES(0,'$usuario','".date("Y-m-d H:i:s")."','temporal','$claveencriptada','100')";
			$userclave = mysql_db_query($database_sala,$query_claveinscripcion) or die("$query_claveinscripcion".mysql_error());
			echo '
			<script language="JavaScript">
			alert("En algunos segundos se enviara via E-mail su usuario y clave para el proceso de inscripción");
			</script>';
		}
		else
		{
			$noventadias = date('Y-m-d', time() + (60 * 60 * 24 * 90));
			$query_renovarusuario ="update usuariopreinscripcion
			set fechavencimientousuariopresinscripcion = '$noventadias'
			where usuariopreinscripcion = '".$_POST['numerodocumento']."'";
			$userrenovado = mysql_db_query($database_sala,$query_renovarusuario) or die("$query_renovarusuario".mysql_error());
		}
		if($idnumeroinscripcion <> 0)
		{
			$inscripcionnueva = $idnumeroinscripcion;
		}

		// Generar la orden de pago con inscripción y formulario
/*****************************************************************/
		// 1. Mirar que la carrera tenga codigoindicadorcobroinscripcio si se debe cobrar muestra el link generar orden de pago
		// si no no mostrar el link, si el estudiante no tiene orden de pago por concepto de inscripción y formulario se le debe 
		// generar la orden con los conceptos correspondientes.
		//echo "<h1>$query_facultad <br>ACA:  ".$row_facultad['codigoindicadorcobroinscripcioncarrera']."</h1>";
		//exit();
		if(ereg("^1.+$",$row_facultad['codigoindicadorcobroinscripcioncarrera']))
		{
			// Validación de las ordenes por concepto de matricula
			// Creación del objeto ordenes de pago
			//$ordenesxestudiante = new Ordenesestudiante($sala, $row_data['codigoestudiante'], $row_data['codigoperiodo']);
			//$cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos)
		    // Aqui aparece un link llamado ordenes de pago, en el cual aparece un formulario donde se generan o visualizan las ordenes de inscripción
			$query_ordenpagoinscripcion = "SELECT o.numeroordenpago, o.codigoestadoordenpago
			FROM ordenpago o, detalleordenpago do, concepto c
			where o.codigoestudiante = '$codigoestudiantecarrera'
			and o.numeroordenpago = do.numeroordenpago
			and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
			and o.codigoperiodo = '".$_POST['periodo']."'
			and do.codigoconcepto = c.codigoconcepto
			and c.codigoreferenciaconcepto like '6%'";
			//echo $query_valida,"<br>";
			$ordenpagoinscripcion = mysql_query($query_ordenpagoinscripcion, $sala) or die("$query_ordenpagoinscripcion".mysql_error());
			$row_ordenpagoinscripcion = mysql_fetch_assoc($ordenpagoinscripcion);
			$totalRows_ordenpagoinscripcion = mysql_num_rows($ordenpagoinscripcion);				  		
						
			if($totalRows_ordenpagoinscripcion == "")
			{
?>
			<script language="javascript">
				window.location.reload("generarordenpagoinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso']."&codigoestudiante=$codigoestudiantecarrera&codigoperiodo=".$_POST['periodo']."&todos";?>");
			</script>
<?php
				exit();
			}
		}
		else
		{        
			$query_estadoestudiante ="UPDATE estudiante e,inscripcion i,estudiantecarrerainscripcion ec
		   	SET i.codigosituacioncarreraestudiante = '107',
		   	e.codigosituacioncarreraestudiante = '107'
		   	WHERE i.idestudiantegeneral  = e.idestudiantegeneral
			AND ec.codigocarrera = e.codigocarrera 
			AND i.idinscripcion = ec.idinscripcion
			AND e.codigoestudiante = '".$row_data['codigoestudiante']."'";
			$estadoestudiante = mysql_db_query($database_sala,$query_estadoestudiante) or die("$query_estadoestudiante".mysql_error());
		   
		  	if(ereg("^2.+$",$row_data['codigoindicadorprocesoadmisioncarrera']))
		  	{ 	   
				$query_estado = "select * from estudiante
				where idestudiantegeneral  = '".$row_data['idestudiantegeneral']."'
				and codigocarrera = '".$row_data['codigocarrera']."'
				and (codigosituacioncarreraestudiante = 106 or codigosituacioncarreraestudiante = 107)";

				$estado = mysql_query($query_estado, $sala) or die("$query_estado");
				$totalRows_estado = mysql_num_rows($estado);
				$row_estado = mysql_fetch_assoc($estado);
			
				if ($row_estado <> "")
			 	{
					$indicadordocementacion = 0;
				    if ($row_data['codigomodalidadacademica'] == 400)
					{ // documentacion	
						$query_valida = "SELECT * 
						FROM documentacion d,documentacionfacultad df
						where d.iddocumentacion = df.iddocumentacion
						and df.codigocarrera = '".$row_data['codigocarrera']."'
						AND (df.codigogenerodocumento = '300' OR df.codigogenerodocumento = '".$row_data['codigogenero']."')";
						$valida = mysql_query($query_valida, $sala) or die(mysql_error());
						$row_valida = mysql_fetch_assoc($valida);
						$totalRows_valida = mysql_num_rows($valida);
						
						if ($row_valida <> "")
						{
							do
							{
								$query_documentosestuduante = "SELECT * 
							   	FROM documentacionestudiante d,documentacionfacultad df
							   	where d.codigoestudiante = '".$row_data['codigoestudiante']."'
							   	and d.iddocumentacion = '".$row_valida['iddocumentacion']."'									 									 
							   	AND d.codigotipodocumentovencimiento = '100'
							   	and d.iddocumentacion = df.iddocumentacion";
							   	$documentosestuduante  = mysql_query($query_documentosestuduante , $sala) or die(mysql_error());
							   	$row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante );
							   
								if (!$row_documentosestuduante)
								{
									$indicadordocementacion = 1;  
								}
							}
							while($row_valida = mysql_fetch_assoc($valida));
						}						
				  	} // documentacion	
					if ($indicadordocementacion == 0)
				  	{		
				  		$query_estadoestudiante ="UPDATE estudiante e,inscripcion i,estudiantecarrerainscripcion ec
				   		SET i.codigosituacioncarreraestudiante = '300',
				   		e.codigosituacioncarreraestudiante = '300'
						WHERE i.idestudiantegeneral  = e.idestudiantegeneral
				   		AND ec.codigocarrera = e.codigocarrera 
				   		AND i.idinscripcion = ec.idinscripcion
				   		AND e.codigoestudiante = '".$row_estado['codigoestudiante']."'";
				   		$estadoestudiante = mysql_db_query($database_sala,$query_estadoestudiante) or die("$query_estadoestudiante".mysql_error());
 			      	}
				}	
			    if ($indicadordocementacion != 0)
			   	{
?>
<script language="javascript">
	alert("Tiene Documentos Pendientes por Entregar");
</script>
<?php
				}
		   	}	
	 	}    
/*****************************************************************/

		if(ereg("estudiante",$_SESSION['MM_Username']))
		{
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=solicitudclave.php?usuario=".$codigoinscripcion."&digitaclave'>";
	    }
		else
		{		   
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formulariopreinscripcion.php?documentoingreso=$documento&logincorrecto'>";
		}
	}
}
?>
</form>
</body>
</html>

