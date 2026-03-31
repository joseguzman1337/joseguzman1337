<?php
require_once('../serviciosacademicos/Connections/sala2.php');

$rutaado = "../serviciosacademicos/funciones/adodb/";
require_once('../serviciosacademicos/Connections/salaado.php'); 

$documento = $_REQUEST['documentoingreso'];
?>

<script language="JavaScript" type="text/JavaScript">
<!--/*
if (document.location.protocol == "http:"){
	var direccion=document.location.href;
	var ssl=(direccion.replace(/http/, "https"));
	document.location.href=ssl;
}*/
//-->
</script>

<html>
<head>
<title>Universidad El Bosque</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<frameset rows="152,*" cols="*" framespacing="0" frameborder="NO" border="0">
  <frame src="enlineasup.htm" name="topFrame" scrolling="NO" noresize >
<?php
if(isset($_GET['depurar']) and $_GET['depurar']=='si'){?>
<frame src="../serviciosacademicos/consulta/prematricula/interesados/preinscripcion.php?link_origen=<?php echo $_GET['link_origen']?>&idpreinscripcion=<?php echo $_GET['idpreinscripcion']?>&depurar=si" name="contenido">
<?php }
elseif(isset($_GET['interesado']) and isset($_GET['idpreinscripcion'])){?><frame src="../serviciosacademicos/consulta/prematricula/interesados/preinscripcion.php?link_origen=<?php echo $_GET['link_origen']?>&idpreinscripcion=<?php echo $_GET['idpreinscripcion']?>" name="contenido"><?php }
elseif(isset($_GET['interesado']) and !isset($_GET['idpreinscripcion'])){?><frame src="../serviciosacademicos/consulta/prematricula/interesados/preinscripcion.php?link_origen=<?php echo $_GET['link_origen']?>" name="contenido"><?php }
else if(!isset($_REQUEST['logincorrecto']))
{
?>
  <frame src="../serviciosacademicos/consulta/prematricula/inscripcionestudiante/ingresopreinscripcion.php" name="contenido">
<?php
}
else
{
	/************* 
	Toca mirar:
	1. Si tiene solamente una
	2. Si no tiene
	*************/
		$query_selinscripciones = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,
	i.idinscripcion,s.nombresituacioncarreraestudiante,i.numeroinscripcion,i.codigosituacioncarreraestudiante,i.codigoperiodo,
	c.codigoindicadorcobroinscripcioncarrera, c.codigoindicadorprocesoadmisioncarrera, ec.codigocarrera, ec.codigoestudiante
	FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci,situacioncarreraestudiante s, estudiante ec, periodo p
	WHERE numerodocumento = '$documento'
	AND eg.idestudiantegeneral = i.idestudiantegeneral
	AND s.codigosituacioncarreraestudiante = i.codigosituacioncarreraestudiante
	AND eg.idciudadnacimiento = ci.idciudad
	AND i.idinscripcion = e.idinscripcion
	AND e.codigocarrera = c.codigocarrera
	AND m.codigomodalidadacademica = i.codigomodalidadacademica
	AND i.codigoestado like '1%'
	AND e.idnumeroopcion = '1'
	and e.codigoestado like '1%'
	and ec.codigocarrera = e.codigocarrera
	and ec.idestudiantegeneral = eg.idestudiantegeneral
	and i.codigoperiodo = p.codigoperiodo
	and (p.codigoestadoperiodo like '1' or p.codigoestadoperiodo like '4')";
	$selinscripciones = $db->Execute($query_selinscripciones);
	$totalRows_selinscripciones = $selinscripciones->RecordCount();
	$row_selinscripciones = $selinscripciones->FetchRow(); 
	if($totalRows_selinscripciones == 0)
	{
?>
  <frame src="../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?logincorrecto&documentoingreso=<?php echo $documento; ?>" name="contenido">
<?php
	}
	else
	{
?>
  <frame src="enlineacentral.php?documentoingreso=<?php echo $documento; ?>" name="contenido">
<?php
	}
}
?>
</frameset>
<noframes><body>
</body></noframes>
</html>
