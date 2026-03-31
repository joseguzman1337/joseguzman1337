<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//@session_start();

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

/** SIN ADO */
require('../../../Connections/sala2.php');
$sala2 = $sala;
$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";
require_once($rutaorden.'claseordenpago.php');
require_once('../../../funciones/funcionip.php');


$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

include ("calendario/calendario.php");
include("../../../funciones/funcionpassword.php");
include("../../../funciones/enviamail.php");

mysql_select_db($database_sala, $sala2);

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


	$seldocumentos = $db->Execute($query_seldocumentos);

	$totalRows_seldocumentos = $seldocumentos->RecordCount();

	if($totalRows_seldocumentos == "")

	{

		$query_seldocumentos = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,

		c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo

		FROM estudiante est, estudiantegeneral eg, carrera c

		WHERE eg.numerodocumento = '$documento'

		and eg.idestudiantegeneral = est.idestudiantegeneral

		and c.codigocarrera = est.codigocarrera

		ORDER BY 3, est.codigoperiodo";


		$seldocumentos = $db->Execute($query_seldocumentos);

		$totalRows_seldocumentos = $seldocumentos->RecordCount();

		if($totalRows_seldocumentos == "")

		{

			$query_seldocumentos = "SELECT distinct eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,

			eg.numerodocumento

			FROM estudiantegeneral eg

			WHERE eg.numerodocumento = '$documento'

			ORDER BY 3";



			$seldocumentos = $db->Execute($query_seldocumentos);

			$totalRows_seldocumentos = $seldocumentos->RecordCount();

		}

	}

	$respuesta = $seldocumentos->FetchRow();



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



	if (!isset($_GET['logincorrecto']) and !isset($_GET['eliminar']) and $_SESSION['MM_Username'] == "estudiante" and $totalRows_seldocumentos != "")

	{
		$query_usuarioclave = "select *
		from usuariopreinscripcion u,claveusuariopreinscripcion c
		where u.idusuariopreinscripcion = c.idusuariopreinscripcion
		and usuariopreinscripcion = '$codigoinscripcion'
		and codigoestadoclaveusuariopreinscripcion not like '2%'";

		$usuarioclave = $db->Execute($query_usuarioclave);

		$totalRows_usuarioclave = $usuarioclave->RecordCount();

		$row_usuarioclave = $usuarioclave->FetchRow();

?>

			<script language="javascript">

				alert("Usted ya se encuentra registrado en el sistema, ingrese desde el portal de aspirantes digitando su documento y su contrasena");

				history.go(-2);

			</script>

<?php

		//}

	}

}

else if ($_SESSION['numerodocumentosesion'] <> "")

{

	$codigoinscripcion = $_SESSION['numerodocumentosesion'];

}



$query_selgenero = "select codigogenero, nombregenero

from genero";

$selgenero = $db->Execute($query_selgenero);

$totalRows_selgenero = $selgenero->RecordCount();

$row_selgenero = $selgenero->FetchRow();



$query_trato = "select *

from trato";

$trato = $db->Execute($query_trato);

$totalRows_trato = $trato->RecordCount();

$row_trato = $trato->FetchRow();



$query_documentos = "SELECT * FROM documento";

$documentos = $db->Execute($query_documentos);

$totalRows_documentos = $documentos->RecordCount();

$row_documentos = $documentos->FetchRow();



//********************************* tipo usuario **////////////////////////////////////////////////////////

$usuario = $_SESSION['MM_Username'];

$query_tipousuario = "SELECT *

FROM usuariofacultad

where usuario = '".$usuario."'";

$tipousuario = $db->Execute($query_tipousuario);

$totalRows_tipousuario = $tipousuario->RecordCount();

$row_tipousuario = $tipousuario->FetchRow();



// si el usuario es administrativo salen todas las modalidades

if ($row_tipousuario['codigotipousuariofacultad'] == 200)

{

	$query_modalidad = "SELECT * FROM modalidadacademica

	WHERE codigomodalidadacademica <> 500 order by 1";

	$modalidad = $db->Execute($query_modalidad);

	$totalRows_modalidad = $modalidad->RecordCount();

	$row_modalidad = $modalidad->FetchRow();

}

else

{

	$query_modalidad = "SELECT * FROM modalidadacademica where codigoestado like '1%' order by 1";

	$modalidad = $db->Execute($query_modalidad);

	$totalRows_modalidad = $modalidad->RecordCount();

	$row_modalidad = $modalidad->FetchRow();

}

$existe = false;

$query_estudiante = "SELECT * FROM estudiantegeneral eg,departamento d,ciudad c

WHERE numerodocumento = '$codigoinscripcion'

AND c.idciudad = eg.idciudadnacimiento

AND d.iddepartamento = c.iddepartamento";



$estudiante = $db->Execute($query_estudiante);

$totalRows_estudiante = $estudiante->RecordCount();

$row_estudiante = $estudiante->FetchRow();



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

	$inscripcion = $db->Execute($query_inscripcion);

	$totalRows_inscripcion = $inscripcion->RecordCount();

	$row_inscripcion = $inscripcion->FetchRow();

	if($totalRows_inscripcion == "")

	{

		$query_inscripcion = "SELECT *

		FROM preinscripcion pe,preinscripcioncarrera pc,carrera c

		WHERE pe.idpreinscripcion = '".$_GET['idpreinscripcion']."'

		and pc.codigocarrera = c.codigocarrera

		AND pe.idpreinscripcion=pc.idpreinscripcion

		and pe.codigoestado like '1%'

		and pc.codigoestado like '1%'";

		$inscripcion = $db->Execute($query_inscripcion);

		$totalRows_inscripcion = $inscripcion->RecordCount();

		$rowinscripcion = $inscripcion->FetchRow();

	}

	$_POST['trato'] = $row_inscripcion['idtrato'];
	$_POST['nombres'] = $row_inscripcion['nombresestudiante'];
	$_POST['apellidos'] = $row_inscripcion['apellidosestudiante'];
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

if(isset($_POST['especializacion']))
{

	$_POST['periodo'] = ereg_replace("^.+ - ","",$_POST['especializacion']);
	$query_nopermite = "SELECT *
  	FROM inscripcion i,estudiantecarrerainscripcion e
  	WHERE i.idinscripcion = e.idinscripcion
  	AND e.codigocarrera = '".$_POST['especializacion']."'
  	AND e.codigoestado = '100'
  	AND i.codigoperiodo = '".$_POST['periodo']."'
    AND e.idnumeroopcion = '1'
  	AND i.idestudiantegeneral =  '".$row_estudiante['idestudiantegeneral']."'";
  	$nopermite = $db->Execute($query_nopermite);
	$totalRows_nopermite = $nopermite->RecordCount();
	$row_nopermite = $nopermite->FetchRow();

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

$periodo = $db->Execute($query_periodo);
$totalRows_periodo = $periodo->RecordCount();
$row_periodo = $periodo->FetchRow();

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

<script type="text/javascript" src="../../../funciones/overlib/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>

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

<!--<div class=fieldset_box valign=top style="width: 780px;"><fieldset>  Crea marco exterior -->

<form name="inscripcion" method="post" action="">



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
and (p.codigoestadoperiodo like '1' or p.codigoestadoperiodo like '4')";

$data = $db->Execute($query_data);

$totalRows_data = $data->RecordCount();

$row_data = $data->FetchRow();

$idestudiantegeneral = $row_data['idestudiantegeneral'];



//********************************* tipo usuario **////////////////////////////////////////////////////////

$usuario = $_SESSION['MM_Username'];

$query_tipousuario = "SELECT *
FROM usuariofacultad
where usuario = '".$usuario."'";

$tipousuario = $db->Execute($query_tipousuario);

$totalRows_tipousuario = $tipousuario->RecordCount();

$row_stipousuario = $tipousuario->FetchRow();

?>

<?php

if($totalRows_data != "")
{
?>

<a href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $row_estudiante['numerodocumento']."&codigocarrera=".$_SESSION['codigocarrerasesion']."";?>" id="aparencialinknaranja">Inicio</a>

<?php
}
else
{
	if(ereg("estudiante",$_SESSION['MM_Username']))
	{
?>
<a href="../../../../aspirantes/aspirantes.php" id="aparencialinknaranja" target="_top">Inicio</a><br><br>
<?php
	}
}

?>

<p>

FORMULARIO DEL ASPIRANTE

<br>

</p>

<table width="750" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

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

while($row_trato = $trato->FetchRow());

?>

</select>&nbsp;<label id="labelresaltado">*</label>

</td>

<td id="tdtitulogris">



  Nombre

  <label id="labelresaltado">*</label>



 </td>

 <td><input name="nombres" type="text" id="nombres" size="20" maxlength="50" value="<?php if($_POST['nombres']){echo $_POST['nombres'];} else {echo $row_estudiante['nombresestudiantegeneral'];}?>" <?php if($row_estudiante){ echo "readonli"; }?>></td>

 <td id="tdtitulogris">Apellidos <label id="labelresaltado">*</label></td>

<td colspan="3"><input name="apellidos" type="text" id="apellidos" size="30" maxlength="50" value="<?php if($_POST['apellidos']){echo $_POST['apellidos'];} else {echo $row_estudiante['apellidosestudiantegeneral'];}?>" <?php if($row_estudiante){ echo "readonli"; }?>></td>

</tr>

<tr>

<td colspan="2" id="tdtitulogris">Tipo Documento<label id="labelresaltado">*</label>



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

while($row_documentos = $documentos->FetchRow());

?>

</select>

</td>

<td id="tdtitulogris">

 Documento

  <label id="labelresaltado">*</label>

</td>

<td>

  <input name="numerodocumento" type="text" id="numerodocumento" size="10" maxlength="12" value="<?php if($_POST['numerodocumento']){if(!$_POST['numerodocumento']){echo $documento;} else {echo $_POST['numerodocumento'];}} else {echo $row_estudiante['numerodocumento'];}?>" <?php if($row_estudiante){ echo "readonli"; }?> readonli>

</td>

<!-- <td id="tdtitulogris">

  Expedida en

  <label id="labelresaltado">*</label>

</td>

<td>

<input name="expedidodocumento" type="text" id="expedidodocumento" size="10" maxlength="15" value="<?php if(!$row_estudiante){echo $_POST['expedidodocumento'];} else {echo $row_estudiante['expedidodocumento'];}?>" <?php if($row_estudiante){ echo "readonli"; }?>>

</td>-->

</tr>

<?php

if ($_SESSION['MM_Username'] == "estudiante2") ///////////////////////////////////////////////////

{  //   if ($_SESSION['MM_Username'] == "estudiante")

?>

<tr>

<td colspan="2" id="tdtitulogris">



  Fecha Nacimiento

  <label id="labelresaltado">*</label>



</td>

<td>

<input name="fecha1" type="text" size="10" value="<?php if(!$_POST['fecha1']) echo $row_estudiante['fechanacimientoestudiantegeneral']; else echo $_POST['fecha1']?>" maxlength="10"<?php if($row_estudiante){ echo "readonli"; }?>>

aaaa-mm-dd

</td>



<td colspan="1" id="tdtitulogris">



  G&eacute;nero

  <label id="labelresaltado">*</label>



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



  Departamento Nacimiento

  <span class="Estilo4">

  <label id="labelresaltado">*</label>

</span>



</td>

<td id="tdtitulogris">

<?php

	$query_dep_nacimiento = "select *
	from departamento d
	where d.codigoestado like '1%'
	and d.idpais = 1
	order by 3";

	$dep_nacimiento = mysql_query($query_dep_nacimiento, $sala2) or die("$query_dep_nacimiento");

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



  Lugar Nacimiento

  <span class="Estilo4">

  <label id="labelresaltado">*</label>

</span>



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



		$ciudad = mysql_query($query_ciudad, $sala2) or die("$query_ciudad");

		$totalRows_ciudad= mysql_num_rows($ciudad);

		$row_ciudad = mysql_fetch_assoc($ciudad);

	}

	else

	{

		$query_ciudad = "select *

		from ciudad c

		where iddepartamento = '".$_POST['dep_nacimiento']."'

		order by 3";

		$ciudad = mysql_query($query_ciudad, $sala2) or die("$query_ciudad");

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



  Departamento  Residencia<span class="Estilo4">

  <label id="labelresaltado">*</label>

</span>



</td>

<td id="tdtitulogris">

<?php

	$query_dep_residencia = "select *

	from departamento d

	where d.codigoestado like '1%'

	and d.idpais = 1

	order by 3";

	$dep_residencia = mysql_query($query_dep_residencia, $sala2) or die("$query_dep_residencia");

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



  Ciudad Residencia

  <span class="Estilo4">

  <label id="labelresaltado">*</label>

</span>



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

		$ciudad_residencia = mysql_query($query_ciudad_residencia, $sala2) or die("$query_ciudad_residencia");

		$totalRows_ciudad_residencia= mysql_num_rows($ciudad_residencia);

		$row_ciudad_residencia = mysql_fetch_assoc($ciudad_residencia);

	}

	else

	{

		$query_ciudad_residencia= "select *

		from ciudad c

		where iddepartamento = '".$_POST['dep_residencia']."'

		order by 3";

		$ciudad_residencia = mysql_query($query_ciudad_residencia, $sala2) or die("$query_ciudad_residencia");

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



  Dirección Residencia

  <span class="Estilo4">

  <label id="labelresaltado">*</label>

</span>



</td>

<td colspan="5" id="tdtitulogris">

<?php

	if ($_SESSION['nuevadireccionlarga'] <> "")
	{
		$_POST['direccion'] = $_SESSION['nuevadireccionlarga'];
	}

?>

<INPUT name="direccion" size="90" readonli onclick="window.open('direccion.php?preinscripcion=1','direccion','width=1000,height=300,left=150,top=150,scrollbars=yes')" value="<?php if($_POST['direccion']){echo $_POST['direccion'];} else {echo $row_estudiante['direccionresidenciaestudiantegeneral'];} ?>" <?php if($row_estudiante){ echo "readonli"; }?>>

<INPUT name="direccionoculta" value="<?php echo $_POST['direccionoculta'];?>" type="hidden">&nbsp;

<a onClick="window.open('../../manualdireccion/direccion.htm','mensajes','width=700,height=700,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/pregunta.gif" width="18" height="18" alt="Ayuda"></a>

</td>

</tr>

<?php

}

?>

<tr>

<td colspan="2" id="tdtitulogris">



  Tel&eacute;fono Residencia

  <label id="labelresaltado">*</label>



</td>

<td>

<input name="telefono" type="text" id="telefono" value="<?php if($_POST['telefono']){echo $_POST['telefono'];} else {echo $row_estudiante['telefonoresidenciaestudiantegeneral'];}?>" size="10" maxlength="50" <?php if($row_estudiante){ echo "readonli"; }?>>

</td>

<td id="tdtitulogris">



  E-mail

    <label id="labelresaltado">*</label>



</td>

<td colspan="3">

<input name="email" type="text" id="email" size="50" maxlength="50" value="<?php if($_POST['email']){echo $_POST['email'];} else {echo $row_estudiante['emailestudiantegeneral'];}?>" <?php if($row_estudiante){ echo "readonli"; }?>>

<INPUT name="correooculto" type="hidden">

</td>

</tr>

<tr>

<td colspan="2" id="tdtitulogris">

Tel&eacute;fono Oficina

</td>

<td>

<input name="telefonooficina" type="text" value="<?php if($_POST['telefonooficina']){echo $_POST['telefonooficina'];} else {echo $row_estudiante['telefono2estudiantegeneral'];}?>" size="10" maxlength="50" <?php if($row_estudiante){ echo "readonli"; }?>>

</td>

<td id="tdtitulogris">

Célular

</td>

<td colspan="3">

<input name="celular" type="text" size="10" maxlength="50" value="<?php if($_POST['celular']){echo $_POST['celular'];} else {echo $row_estudiante['celularestudiantegeneral'];}?>" <?php if($row_estudiante){ echo "readonli"; }?>>

</td>

</tr>

</table>

<br>

<label id="labelresaltado">Por favor asegúrese de que el E-mail digitado sea el correcto, por este medio podra continuar con su proceso de Inscripción. </label>

<br>

<br>

<?php

$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,

i.idinscripcion,s.nombresituacioncarreraestudiante,i.numeroinscripcion,i.codigosituacioncarreraestudiante,i.codigoperiodo,

c.codigoindicadorcobroinscripcioncarrera, c.codigoindicadorprocesoadmisioncarrera, ec.codigocarrera, ec.codigoestudiante

FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci,situacioncarreraestudiante s, estudiante ec, periodo p

WHERE numerodocumento = '".$_REQUEST['documentoingreso']."'

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

and i.codigoperiodo = p.codigoperiodo

and (p.codigoestadoperiodo like '1' or p.codigoestadoperiodo like '4')";

$data = $db->Execute($query_data);

$totalRows_data = $data->RecordCount();

$row_data = $data->FetchRow();

$idestudiantegeneral = $row_data['idestudiantegeneral'];


if($row_data <> "")

{

	$idestudiantegeneral = $row_data['idestudiantegeneral'];

	if(!ereg("estudiante",$_SESSION['MM_Username']) && !isset($_SESSION['codigocarrerasesion']))

	{

?>

<script language="javascript">

	window.location.href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $_REQUEST['documentoingreso']."&codigocarrera=".$row_data['codigocarrera']."";?>";

</script>

<?php


	}

?>

<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">

<tr>

  <td id="tdtitulogris" colspan="3">INSCRIPCIONES REALIZADAS</td>

 </tr>

<tr>

  <td align="left" id="tdtitulogris">

    Modalidad

  </td>

  <td align="left" id="tdtitulogris">

    Programa

  </td>

  <td align="left" id="tdtitulogris">

    Estado

  </td>

</tr>

<?php

	do

	{

?>

<tr>

  <td align="left">

    <?php echo $row_data['nombremodalidadacademica'];?> </td>

  <td align="left">

    <?php echo $row_data['nombrecarrera'];?>

  </td>

  <td align="left">

    <?php echo $row_data['nombresituacioncarreraestudiante'];?>

  </td>

 </tr>

<?php

		$documento = $row_data['numerodocumento'];

	}

	while($row_data = $data->FetchRow());

?>

</table>

<br>

<?php

}

?>

</td>

</tr>

</table>

<br>

<table width="750" border="0" cellpadding="0" cellspacing="0">

<tr>

<td align="left">

<label id="labelresaltado">Seleccione la modalidada académica y el programa  que aspira.</label>

<br><br>

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

    <option value="<?php echo $row_modalidad['codigomodalidadacademica']?>" <?php if (!(strcmp($row_modalidad['codigomodalidadacademica'], $_POST['modalidad']))) {echo "SELECTED";} ?>><?php echo $row_modalidad['nombremodalidadacademica']?></option>

<?php

}

while($row_modalidad = $modalidad->FetchRow());

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

  <td><a onClick="window.open('../../manualpreinscripcion/preinscripcion.html','mensajes','width=700,height=700,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a>

  </td>

  </tr>

  <tr>

  <td id="tdtitulogris">Nombre del Programa<label id="labelresaltado">*</label></td>

  <td colspan="3">

<?php

$fecha = date("Y-m-d G:i:s",time());



 if (ereg("estudiante",$_SESSION['MM_Username']))

  {

	$query_car = "SELECT c.nombrecarrera, c.codigocarrera, cp.codigoperiodo

	FROM carrera c, carreragrupofechainscripcion cf, carreraperiodo cp, subperiodo sp

	where c.codigomodalidadacademica = '".$_POST['modalidad']."'

	AND c.fechavencimientocarrera > now()

	and c.codigocarrera = cf.codigocarrera

	and cf.fechahastacarreragrupofechainscripcion > now()

	and cf.idsubperiodo = sp.idsubperiodo

	and sp.idcarreraperiodo = cp.idcarreraperiodo

	order by 1, 3";


	$car = $db->Execute($query_car);

	$totalRows_car = $car->RecordCount();

  }

 else

  {

    $query_periodopre = "SELECT *

	FROM periodo where codigoestadoperiodo = '4'";

	$periodopre = $db->Execute($query_periodopre);

	$totalRows_periodopre = $periodopre->RecordCount();

	$row_periodopre = $periodopre->FetchRow();

	 if ($row_periodopre <> "")

	 {

		$query_car = "SELECT DISTINCT c.nombrecarrera, c.codigocarrera, cp.codigoperiodo

		FROM carrera c, carreragrupofechainscripcion cf, carreraperiodo cp, subperiodo sp

		WHERE c.codigomodalidadacademica = '".$_POST['modalidad']."'


		AND c.fechavencimientocarrera > now()

		AND c.codigocarrera = cf.codigocarrera

		AND cf.fechahastacarreragrupofechainscripcion > now()

		AND cf.idsubperiodo = sp.idsubperiodo

		AND sp.idcarreraperiodo = cp.idcarreraperiodo";


		$car = $db->Execute($query_car);

		$totalRows_car = $car->RecordCount();

      }

	 else

	  {
		$query_car = "SELECT DISTINCT c.nombrecarrera, c.codigocarrera, cp.codigoperiodo

		FROM carrera c, carreragrupofechainscripcion cf, carreraperiodo cp, subperiodo sp

		WHERE c.codigomodalidadacademica = '".$_POST['modalidad']."'

		AND c.fechavencimientocarrera > now()

		AND c.codigocarrera = cf.codigocarrera

		AND cf.fechahastacarreragrupofechainscripcion > now()

		AND cf.idsubperiodo = sp.idsubperiodo

		AND sp.idcarreraperiodo = cp.idcarreraperiodo";

		$car = $db->Execute($query_car);

		$totalRows_car = $car->RecordCount();
	  }

  }
?>

  <select name="especializacion" id="especializacion">

    <option value="0" <?php if (!(strcmp("0", $_POST['especializacion']))) {echo "SELECTED";} ?>>

      Seleccionar

    </option>

<?php

while($row_car = $car->FetchRow())

{
?>

    <option value="<?php echo $row_car['codigocarrera']." - ".$row_car['codigoperiodo'];?>" <?php if (!(strcmp($row_car['codigocarrera']." - ".$row_car['codigoperiodo'], $_POST['especializacion']))) {echo "SELECTED";} ?>>

      <?php echo $row_car['nombrecarrera']." - ".$row_car['codigoperiodo']; ?>

    </option>

	<?php

}

?>

  </select>

  </td>

  </tr>

<?php
if($_POST['especializacion'] <> 0)

{  // if 1

  	$query_periodo = "select * from periodo p,carreraperiodo c

  	where p.codigoperiodo = c.codigoperiodo

  	and c.codigocarrera = '".$_POST['especializacion']."'

  	and p.codigoestadoperiodo not like '2'

  	order by p.codigoestadoperiodo";



	$periodo = mysql_query($query_periodo, $sala2) or die("$query_periodo");

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

?>

</select>

</td>

</tr>

 --><?php

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

</td>

</tr>

</table>



<input type="submit" value="Enviar" name="Enviar">

<?php

if(isset($_REQUEST['menuprincipal']))

{

?>

<input type="button" value="Regresar" onClick="window.location.reload('../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $row_estudiante['numerodocumento']."&codigocarrera=".$_SESSION['codigocarrerasesion']."";?>')">

<?php

}

?>

<!-- <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="grabado" width="25" height="25" alt="Guardar">

 --><!-- <a onClick="grabar()" style="cursor: pointer" name="grabado">



<img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar">



</a> -->

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

//} // if 1

//

$banderagrabar = 0;

//print_r ($_POST);

//$guardar = false;

/*foreach ($_POST as $key => $value)

 {

  echo "$key => $value<br>";

  // $guardar = true;

 }*/

 //exit();

if ($_POST['Enviar'] or $_POST['correooculto'] <> "")
{
	//echo "va a grabar: ".$row_data['codigoindicadorcobroinscripcioncarrera']."<br>$query_data";
	//exit();
	/******************************************************************/
	$ano = substr($_POST['fecha1'],0,4);
    $mes = substr($_POST['fecha1'],5,2);
    $dia = substr($_POST['fecha1'],8,2);

   $_POST['nombres']   =  strtr(strtoupper($_POST['nombres']), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
   $_POST['apellidos'] =  strtr(strtoupper($_POST['apellidos']), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");

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
	$periodoactivo = $db->Execute($query_periodoactivo);
	$totalRows_periodoactivo = $periodoactivo->RecordCount();
	$row_periodoactivo = $periodoactivo->FetchRow();
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
		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*)) *$",$_POST['nombres']) or $_POST['nombres'] == "") and !$existe )
		{
			echo '<script language="JavaScript">
			alert("El Nombre es Incorrecto")
			</script>';
			$banderagrabar = 1;

		}

		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*)) *$",$_POST['apellidos']) or $_POST['apellidos'] == "") and !$existe )

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

		/*else if ((!ereg("^([a-zA-ZáéíóúünÁÉÍÓÚNÜ]+([A-Za-záéíóúünÁÉÍÓÚNÜ]*|( [A-Za-záéíóúünÁÉÍÓÚNÜ]+)*))*$",$_POST['expedidodocumento']) or $_POST['expedidodocumento'] == "") and !$existe )

		{

			echo '

			<script language="JavaScript">

			alert("Expedido documento es Incorrecto")

			</script>

			';

			$banderagrabar = 1;

		}*/

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

		/* else if ($_POST['fecha1'] == "" and !$existe )

		{

			echo '

			<script language="JavaScript">

			alert("Debe seleccionar fecha de nacimiento")

			</script>

			';

			$banderagrabar = 1;

		} */

		else if ($_POST['genero'] == 0 and !$existe )

		{

			echo '

			<script language="JavaScript">

			alert("Debe seleccionar el genero")

			</script>';

			$banderagrabar = 1;

		}

		else if($_POST['email'] == "" and $_POST['telefono'] == "" and !$existe)

		{

			echo '

			<script language="JavaScript">

			alert("Debe digitar el e-mail o la dirrección")

			</script>';

			$banderagrabar = 1;

		}

		else if($_POST['email'] != "" or $_POST['telefono'] != "")

		{

			if ((!eregi($email,$_POST['email']) and $_POST['email'] != "")and !$existe)

			{

				echo '

				<script language="JavaScript">

				alert("E-mail Incorrecto")

				</script>';

				$banderagrabar = 1;

			}

			if(!eregi("^[0-9]{1,15}$", $_POST['telefono'])  and $_POST['telefono'] != "" and !$existe)

			{

				echo '

				<script language="JavaScript">

				alert("Telefono Incorrecto")

				</script>';

				$banderagrabar = 1;

			}

		}

		else if ($_POST['direccion'] == "" and !$existe )

		{

			echo '

			<script language="JavaScript">

			alert("Debe Digitar una Dirección")

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

		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*)) *$",$_POST['nombres']) or $_POST['nombres'] == "") and !$existe )

		{

			echo '<script language="JavaScript">

			alert("El Nombre es Incorrecto")

			</script>';

			$banderagrabar = 1;

		}

		else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*)) *$",$_POST['apellidos']) or $_POST['apellidos'] == "") and !$existe )

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

		/*else if ((!ereg("^([a-zA-ZáéíóúünÁÉÍÓÚNÜ]+([A-Za-záéíóúünÁÉÍÓÚNÜ]*|( [A-Za-záéíóúünÁÉÍÓÚNÜ]+)*))*$",$_POST['expedidodocumento']) or $_POST['expedidodocumento'] == "") and !$existe )

		{

			echo '

			<script language="JavaScript">

			alert("Expedido documento es Incorrecto")

			</script>

			';

			$banderagrabar = 1;

		}*/

		else if($_POST['email'] == "" and $_POST['telefono'] == "" and !$existe)

		{

			echo '

			<script language="JavaScript">

			alert("Debe digitar el e-mail o la dirrección")

			</script>';

			$banderagrabar = 1;

		}

		else if($_POST['email'] != "" or $_POST['telefono'] != "")

		{

			if ((!eregi($email,$_POST['email']) and $_POST['email'] != "")and !$existe)

			{

				echo '

				<script language="JavaScript">

				alert("E-mail Incorrecto")

				</script>';

				$banderagrabar = 1;

			}

			if(!eregi("^[0-9]{1,15}$", $_POST['telefono'])  and $_POST['telefono'] != "" and !$existe )

			{

				echo '

				<script language="JavaScript">

				alert("Telefono Incorrecto")

				</script>';

				$banderagrabar = 1;

			}

		}

	}// no valide

	if ($banderagrabar == 0)

	{

		$query_usuarioclave = "select *

		from usuariopreinscripcion

		where usuariopreinscripcion = '".$_POST['numerodocumento']."'";

		$usuarioclave = $db->Execute($query_usuarioclave);

		$totalRows_usuarioclave = $usuarioclave->RecordCount();

		$row_usuarioclave = $usuarioclave->FetchRow();



		if ($_POST['correooculto'] == "" and !$row_usuarioclave)

		{

	    	$pass = generar_pass(8);

			echo '<input name="contrasena" type="hidden" value="'.$pass.'">';

?>

			<script language="JavaScript">

				if(confirm("Para continuar su proceso de Inscripción se ha generado un usuario y una clave:\nUsuario:  <?php echo $_POST['numerodocumento'];?> \nClave: <?php echo $pass ;?>\n\nTambién se le enviara a su e-mail <?php echo $_POST['email'];?> el usuario y la clave.\n\n?EL E-MAIL REGISTRADO ES EL CORRECTO? \n Si no es el correcto de clic en cancelar y corríja su e-mail <?php echo $_POST['email'];?>"))

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
				$insestudiante = $db->Execute($query_insestudiante);
				$idestudiantegeneral = $db->Insert_ID();

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

				VALUES(0, '".$_POST['trato']."','1', '".$_POST['tipodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['expedidodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['nombres']."', '".$_POST['apellidos']."', '1900-01-01', '359', '200', 'Campo Faltante','".$_POST['direccionoculta']."' ,'359', '".$_POST['telefono']."', '".$_POST['telefono']."', '".$_POST['celular']."','Campo Faltante', '".$_POST['direccionoculta']."','359', '".$_POST['telefono']."', '$maildigitado', '".date("Y-m-d G:i:s",time())."', '".date("Y-m-d G:i:s",time())."','0')";

				//echo $query_insestudiante;
				$insestudiante = mysql_db_query($database_sala,$query_insestudiante) or die("$query_insestudiante".mysql_error());

				$idestudiantegeneral = $db->Insert_ID();

			}

		}

		else

		{

			$idestudiantegeneral = $row_estudiante['idestudiantegeneral'];

			$query_insestudiante = "update estudiantegeneral
			set idtrato='".$_POST['trato']."',tipodocumento='".$_POST['tipodocumento']."',
			numerodocumento='".$_POST['numerodocumento']."',expedidodocumento='".$_POST['expedidodocumento']."',
			nombrecortoestudiantegeneral='".$_POST['numerodocumento']."',nombresestudiantegeneral='".$_POST['nombres']."',
			apellidosestudiantegeneral='".$_POST['apellidos']."',telefonoresidenciaestudiantegeneral='".$_POST['telefono']."',
			telefono2estudiantegeneral='".$_POST['telefonooficina']."',celularestudiantegeneral='".$_POST['celular']."',
			emailestudiantegeneral='".$_POST['email']."',
			fechaactualizaciondatosestudiantegeneral = '" . date("Y-m-d G:i:s", time()) . "'
			where idestudiantegeneral = '$idestudiantegeneral'";

			$updestudiante = mysql_db_query($database_sala,$query_insestudiante) or die("$query_insestudiante".mysql_error());

			// Actualiza los datos



		}



		$query_estudiantedocumento = "SELECT * from estudiantedocumento

		where numerodocumento = '".$_POST['numerodocumento']."'";

		$estudiantedocumento = $db->Execute($query_estudiantedocumento);

		$totalRows_estudiantedocumento = $estudiantedocumento->RecordCount();

		$row_estudiantedocumento = $estudiantedocumento->FetchRow();



		if(!$row_estudiantedocumento)

		{

		   	$query_insestudiantedocumento = "INSERT INTO estudiantedocumento(idestudiantedocumento, idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento)

		   	VALUES(0, '$idestudiantegeneral', '".$_POST['tipodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['expedidodocumento']."', '".date("Y-m-d G:i:s",time())."', '2999-12-31')";

		  	// echo "$query_insestudiantedocumento <br>";

			$insestudiantedocumento = $db->Execute($query_insestudiantedocumento);

		}

		$query_estudiantecarrera = "select * from estudiante

		where idestudiantegeneral = '$idestudiantegeneral'

		and codigocarrera = '".$_POST['especializacion']."'";

		$estudiantecarrera = $db->Execute($query_estudiantecarrera);

		$totalRows_estudiantecarrera = $estudiantecarrera->RecordCount();

		$row_estudiantecarrera = $estudiantecarrera->FetchRow();

		if(!$row_estudiantecarrera)

		{

			$query_insestudiantecarrera = "INSERT INTO estudiante(codigoestudiante, idestudiantegeneral, codigocarrera, semestre, numerocohorte, codigotipoestudiante, codigosituacioncarreraestudiante, codigoperiodo, codigojornada)

			VALUES(0,'$idestudiantegeneral', '".$_POST['especializacion']."','1', '1', '10', '106', '".$_POST['periodo']."','01')";

			//echo "$query_insestudiantecarrera <br>";

			$insestudiantecarrera = $db->Execute($query_insestudiantecarrera);

			$codigoestudiantecarrera = $db->Insert_ID();

		}

		else

		{

			$codigoestudiantecarrera = $row_estudiantecarrera['codigoestudiante'];

		}

		//echo  $idestudiantegeneral;

		$anoaspira = substr($_POST['periodo'],0,4);

		$periodoaspira = substr($_POST['periodo'],4,5);

		$query_mayor = "select max(idnumeroopcion) as mayor

		from estudiantecarrerainscripcion e,inscripcion i

		where e.idestudiantegeneral = '".$idestudiantegeneral."'

		and e.idinscripcion = i.idinscripcion

		and i.codigomodalidadacademica = '".$_POST['modalidad']."'";

		$mayor = $db->Execute($query_mayor);

		$totalRows_mayor = $mayor->RecordCount();

		$row_mayor = $mayor->FetchRow();



		$query_inscripcion = "INSERT INTO inscripcion(numeroinscripcion, fechainscripcion, codigomodalidadacademica, codigoperiodo, anoaspirainscripcion, periodoaspirainscripcion, idestudiantegeneral, codigosituacioncarreraestudiante,codigoestado)

		VALUES('".$_POST['formulario']."','".date("Y-m-d G:i:s",time())."', '".$_POST['modalidad']."', '".$_POST['periodo']."','$anoaspira','$periodoaspira', '$idestudiantegeneral', '106',100)";

		$inscripcion = $db->Execute($query_inscripcion);

		$idnumeroinscripcion = $db->Insert_ID();



		// Informa a el Administrador de la carrera Sabre la Inscripción.

		$query_facultad = "select emailcarreraemail,nombrecarrera, codigoindicadorcobroinscripcioncarrera

		from carreraemail ce,carrera c

		where c.codigocarrera = '".$_POST['especializacion']."'

		and c.codigocarrera = ce.codigocarrera

		and codigoestado like '1%'";

		//echo $query_facultad;

		$facultad = $db->Execute($query_facultad);

		$totalRows_facultad = $facultad->RecordCount();

		$row_facultad = $facultad->FetchRow();



		if($row_facultad <> "")

		{

		  do{

			$mailusuario = $row_facultad['emailcarreraemail'];

		   	$nombrecarrera = $row_facultad['nombrecarrera'];

		   	$nombre =  $_POST['apellidos']." ".$_POST['nombres'];

		   	$documento = $_POST['numerodocumento'];

			$r = enviamailfacultad($mailusuario,$nombrecarrera,$nombre,$documento);

		    }while($row_facultad = $facultad->FetchRow());

		}

		//else

		//{

			$query_facultad = "select nombrecarrera, codigoindicadorcobroinscripcioncarrera

			from carrera c

			where c.codigocarrera = '".$_POST['especializacion']."'";

			$facultad = $db->Execute($query_facultad);

			$totalRows_facultad = $facultad->RecordCount();

			$row_facultad = $facultad->FetchRow();

		//}

		$query_mayor = "select max(idnumeroopcion) as mayor

		from estudiantecarrerainscripcion e,inscripcion i

		where e.idestudiantegeneral = '".$idestudiantegeneral."'

		and e.idinscripcion = i.idinscripcion

		and i.idinscripcion = '$idnumeroinscripcion'

		and i.codigoestado like '1%'";

		$mayor = $db->Execute($query_mayor);

		$totalRows_mayor = $mayor->RecordCount();

		$row_mayor = $mayor->FetchRow();



		$idnumeroinscripciones = $row_mayor['mayor'] + 1;



		$query_carrerainscripcion = "INSERT INTO estudiantecarrerainscripcion(codigocarrera, idnumeroopcion, idinscripcion, idestudiantegeneral,codigoestado)

		VALUES('".$_POST['especializacion']."', '$idnumeroinscripciones', '$idnumeroinscripcion', '$idestudiantegeneral', '100')";

		$carrerainscripcion = $db->Execute($query_carrerainscripcion);



		if ($_SESSION['study'] == 'antiguo')

		{

			$query_estadoestudiante ="UPDATE estudiante e,inscripcion i,estudiantecarrerainscripcion ec

		    SET i.codigosituacioncarreraestudiante = '300',

	        e.codigosituacioncarreraestudiante = '300'

	        WHERE i.idestudiantegeneral  = e.idestudiantegeneral

	        AND ec.codigocarrera = e.codigocarrera

	        AND i.idinscripcion = ec.idinscripcion

	        AND e.codigoestudiante = '$codigoestudiantecarrera'";

			$estadoestudiante = $db->Execute($query_cestadoestudiante);

		    session_unregister('study');

		}



		if (!$row_usuarioclave)

		{

			//$pass = generar_pass(8);

			$direccionemail = $_POST['email'];

			mail($direccionemail,"Usuario y Clave para proceso de Inscripción","Bienvenido a la Universidad el Bosque.\n\n Adjunto al presente usuario y clave para el proceso de inscripción el cual debe realizarlo en www.unbosque.edu.co en el link de Aspirantes y diligenciar los formularios en su totalidad para iniciar el proceso de Selección\n\n\nusuario:".$_POST['numerodocumento']."\nclave:$pass","FROM: Universidad el Bosque <ayuda@unbosque.edu.co>\n");

			$claveencriptada = md5($pass);

			$treintadias = date('Y-m-d', time() + (60 * 60 * 24 * 30));

			$noventadias = date('Y-m-d', time() + (60 * 60 * 24 * 90));



			$query_usuarioinscripcion = "INSERT INTO usuariopreinscripcion(idusuariopreinscripcion,idestudiantegeneral,usuariopreinscripcion,claveusuariopreinscripcion,fechavencimientoclaveusuariopresinscripcion,fechavencimientousuariopresinscripcion)

			VALUES(0,'$idestudiantegeneral','".$_POST['numerodocumento']."','$claveencriptada','$treintadias','$noventadias')";

			$user = $db->Execute($query_usuarioinscripcion);

			$usuario = $db->Insert_ID();



			$query_claveinscripcion = "INSERT INTO claveusuariopreinscripcion(idclaveusuariopreinscripcion,idusuariopreinscripcion,fechaclaveusuariopreinscripcion,recordarclaveusuariopreinscripcion,claveusuariopreinscripcion,codigoestadoclaveusuariopreinscripcion)

			VALUES(0,'$usuario','".date("Y-m-d H:i:s")."','temporal','$claveencriptada','100')";

			$userclave = $db->Execute($query_claveinscripcion);



			echo '

			<script language="JavaScript">

			alert("IMPORTANTE! \n\nEn algunos segundos se enviara via E-mail su usuario y clave para el proceso de inscripción \n\nRECUERDE que el diligenciamiento total del formulario le permite generar la orden de pago de la inscripción");

			</script>';

		}

		else

		{

			$noventadias = date('Y-m-d', time() + (60 * 60 * 24 * 90));

			$query_renovarusuario ="update usuariopreinscripcion

			set fechavencimientousuariopresinscripcion = '$noventadias'

			where usuariopreinscripcion = '".$_POST['numerodocumento']."'";

			$userrenovado = $db->Execute($query_renovarusuario);

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

			$ordenpagoinscripcion = $db->Execute($query_ordenpagoinscripcion);

			$totalRows_ordenpagoinscripcion = $ordenpagoinscripcion->RecordCount();

			$row_ordenpagoinscripcion = $ordenpagoinscripcion->FetchRow();



			if($totalRows_ordenpagoinscripcion == "")

			{

?>

			<script language="javascript">

				//alert("Se le va a generar orden de pago");

				//window.location.reload("generarordenpagoinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso']."&codigoestudiante=$codigoestudiantecarrera&codigoperiodo=".$_POST['periodo']."&todos";?>");

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

			$estadoestudiante = $db->Execute($query_estadoestudiante);



		  	if(ereg("^2.+$",$row_data['codigoindicadorprocesoadmisioncarrera']))

		  	{

				$query_estado = "select * from estudiante

				where idestudiantegeneral  = '".$row_data['idestudiantegeneral']."'

				and codigocarrera = '".$row_data['codigocarrera']."'

				and (codigosituacioncarreraestudiante = 106 or codigosituacioncarreraestudiante = 107)";

				$estado = $db->Execute($query_estado);

				$totalRows_estado = $estado->RecordCount();

				$row_estado = $estado->FetchRow();



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

						//echo $query_valida,"<br>";

						$valida = $db->Execute($query_valida);

						$totalRows_valida = $valida->RecordCount();

						$row_valida = $valida->FetchRow();



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

							   	//echo $query_documentosestuduante,"<br><br>";	//and fechainiciodocumentacionestudiante <= '".date("Y-m-d")."'

							   	// and fechavencimientodocumentacionestudiante >= '".date("Y-m-d")."'

							   	$documentosestuduante = $db->Execute($query_documentosestuduante);

								$row_documentosestuduante = $documentosestuduante->FetchRow();



								if (!$row_documentosestuduante)

								{

									$indicadordocementacion = 1;

								}

							}

							while($row_valida = $valida->FetchRow());

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

				   		$estadoestudiante = $db->Execute($query_estadoestudiante);

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

			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../../../aspirantes/enlineacentral.php?documentoingreso=$documento&logincorrecto'>";

		}

	}

}

?>

</form>

</body>

<script language="javascript">

function toggleBox(szDivID) {

  if (document.layers) { // NN4+

    if (document.layers[szDivID].visibility == 'visible') {

      document.layers[szDivID].visibility = "hide";

      document.layers[szDivID].display = "none";

      document.layers[szDivID+"SD"].fontWeight = "normal";

    } else {

      document.layers[szDivID].visibility = "show";

      document.layers[szDivID].display = "inline";

      document.layers[szDivID+"SD"].fontWeight = "bold";

    }

  } else if (document.getElementById) { // gecko(NN6) + IE 5+

    var obj = document.getElementById(szDivID);

    var objSD = document.getElementById(szDivID+"SD");



    if (obj.style.visibility == 'visible') {

      obj.style.visibility = "hidden";

      obj.style.display = "none";

      objSD.style.fontWeight = "normal";

    } else {

      obj.style.visibility = "visible";

      obj.style.display = "inline";

      objSD.style.fontWeight = "bold";

    }

  } else if (document.all) { // IE 4

    if (document.all[szDivID].style.visibility == 'visible') {

      document.all[szDivID].style.visibility = "hidden";

      document.all[szDivID].style.display = "none";

      document.all[szDivID+"SD"].style.fontWeight = "normal";

    } else {

      document.all[szDivID].style.visibility = "visible";

      document.all[szDivID].style.display = "inline";

      document.all[szDivID+"SD"].style.fontWeight = "bold";

    }

  }

}

</script>

  <script type="text/javascript">

_uacct = "UA-840736-1";

urchinTracker();

  </script>

</html>



