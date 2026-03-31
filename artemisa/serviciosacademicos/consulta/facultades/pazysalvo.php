<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../Connections/sala2.php');
//$GLOBALS['codigofacultad'];
session_start();
//$_SESSION['codigofacultad']="AD202";
/* if (! isset ($_SESSION['nombreprograma']))
 {?>
 <script>
   window.location.reload("../login.php");
 </script>
<?php
 }
 else
 if ($_SESSION['nombreprograma'] <> "pazysalvo.php")
{?>
 <script>
   window.location.reload("../login.php");
 </script>
<?php
 } */
?>
<html>
<head>
<title>Actualización de descuentos y deudas</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo2 {font-size: x-small}
.Estilo5 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo8 {font-size: 12px}
.Estilo9 {
	font-size: 12px;
	font-family: Tahoma;
	font-weight: bold;
}
-->
</style>
</head>
<script language="javascript">
function cambia_tipo()
{
    //tomo el valor del select del tipo elegido
    var tipo
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
    //miro a ver si el tipo está definido
    if (tipo == 1)
	{
		window.location.href="pazysalvo.php?busqueda=nombre";
	}
    if (tipo == 2)
	{
		window.location.href="pazysalvo.php?busqueda=apellido";
	}
    if (tipo == 3)
	{
		window.location.href="pazysalvo.php?busqueda=documento";
    }
}

function buscar()
{
    //tomo el valor del select del tipo elegido
    var busca
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value
    //miro a ver si el tipo está definido
    if (busca != 0)
	{
		window.location.href="pazysalvo.php?buscar="+busca;
	}
}
</script>

<body>
<div align="center" class="Estilo1">
<form name="f1" action="pazysalvo.php" method="get" onSubmit="return validar(this)">
  <p class="Estilo5">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="207" bgcolor="#C5D5D6"><div align="center" class="Estilo8"> <strong>Búsqueda por </strong>:
            <select name="tipo" onChange="cambia_tipo()">
		      <option value="0">Seleccionar</option>
		      <option value="1">Nombre</option>
		      <option value="2">Apellido</option>
		      <option value="3">Documento</option>
            </select>
	&nbsp;
	  </div></td>
	<td width="306"><div align="center" class="Estilo9">&nbsp;
<?php
		if(isset($_GET['busqueda']))
		{
			if($_GET['busqueda']=="nombre")
			{
				echo "Digite un Nombre : <input name='busqueda_nombre' type='text'>";
			}
			if($_GET['busqueda']=="apellido")
			{
				echo "Digite un Apellido : <input name='busqueda_apellido' type='text'>";
			}
			if($_GET['busqueda']=="documento")
			{
				echo "Nº de Documento : <input name='busqueda_documento' type='text'>";
			}
	}
?>
        </div></td>
    <td width="65" bgcolor="#C5D5D6"><div align="center" class="Estilo8"><strong>Fecha</strong></div></td>
    <td><div align="center" class="Estilo8"><?php echo $fechahoy=date("Y-m-d");?>&nbsp;</div></td>
  </tr>
  <tr>
  	<td colspan="4" align="center"><input name="buscar" type="submit" value="Buscar"><input name="buscar" type="button" value="Cancelar" onClick="cancelar()">&nbsp;</td>
  </tr>
  <?php
  if(isset($_GET['buscar']))
  {
  ?>
</table>
<p align="center"><strong>Seleccione el estudiante que desee consultar de la siguiente tabla :</strong></p>
<p align="center"><input name="buscar" type="button" value="Cancelar" onClick="cancelar()"></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="396" align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td width="294" align="center" bgcolor="#C5D5D6"><span class="Estilo2"><strong>Cédula</strong>&nbsp;</span></td>
  </tr>
<?php
  	$vacio = false;

	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral,concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
            eg.numerodocumento
			FROM estudiantegeneral eg, estudiantedocumento ed
			WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'
			and ed.idestudiantegeneral = eg.idestudiantegeneral";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
					eg.numerodocumento
					FROM estudiantegeneral eg, estudiantedocumento ed
					WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'
					and ed.idestudiantegeneral = eg.idestudiantegeneral
					";
		//echo $query_solicitud;
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	}

	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT  eg.idestudiantegeneral,concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
				 eg.numerodocumento
				FROM estudiantegeneral eg, estudiantedocumento ed
				WHERE ed.numerodocumento LIKE '$documento%'
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				";
		//echo $query_solicitud;
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_documento'] == "")
			$vacio = true;
	}

	if(!$vacio)
	{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{

			$est = $solicitud["nombre"];
			$cc = $solicitud["numerodocumento"];
			$cod = $solicitud["idestudiantegeneral"];

			echo "<tr>

				<td  align='center'><a href='pazysalvoformulario.php?estudiante=$cod'>$est&nbsp;</a></td>
				<td  align='center'>$cc&nbsp;</td>
			</tr>";
		}
		echo '<tr>
				<td colspan="3" align="center"><input name="buscar" type="button" value="Cancelar" onClick="cancelar()"></td>
			</tr>';
	}
}
?>
</table>
</form>
</div>
</body>
<script language="javascript">
function cancelar()
{
	window.location.href="pazysalvo.php";
}
</script>
<?php echo '<script language="javascript">
function cancelar2()
{
	window.location.href="pazysalvo.php'.$dir.'&borrar=yes";
}
</script>';
?>
</html>
