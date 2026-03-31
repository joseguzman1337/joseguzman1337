<?php 
	/** USA LAS SIGUIENTES VARIABLES DE SESION
		PARA ESTE PROGRAMA:
		$_SESSION['dir']
	*/	
	require_once('../../../Connections/sala2.php'); 
	session_start();
	require_once('seguridaddescuentosvsdeudas.php');
	require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

	mysql_select_db($database_sala, $sala);

	foreach($_POST as $materia => $valor)
	{ 
	   	$asignacion = "\$" . $materia . "='" . $valor . "';"; 
		//echo $asignacion."<br>";
	}

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
.Estilo4 {font-size: x-small; font-weight: bold; }
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
		window.location.reload("descuentosvsdeudas.php?busqueda=nombre"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("descuentosvsdeudas.php?busqueda=apellido"); 
	} 
    if (tipo == 3)
	{
		window.location.reload("descuentosvsdeudas.php?busqueda=documento"); 
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
		window.location.reload("descuentosvsdeudas.php?buscar="+busca); 
	} 
} 
</script>
<script language="javascript">
function validar(formulario)
{
  var estado;
  var er_valor = /^[0-9]{1,8}$/;
  estado = document.f1.estado[document.f1.estado.selectedIndex].value 
  if (estado == 20)
  {
  	formulario.valoraprobado.value = "";
  }
  else if (estado == 21)
  {
  	formulario.valoraprobado.value = "";
  }
  else if (!er_valor.test(formulario.valoraprobado.value))
  {
    alert("Escriba solamente números y no deje el campo en blanco");
    formulario.valoraprobado.focus();
    return (false);
  }
  return (true); 
}
</script>
<body>
<div align="center" class="Estilo1">
<form name="f1" action="descuentosvsdeudas.php" method="get" onSubmit="return validar(this)">
  <p><strong>CRITERIO DE B&Uacute;SQUEDA</strong></p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="250" bgcolor="#C5D5D6"><span class="Estilo2"> <strong>Búsqueda por </strong>:
        <select name="tipo" onChange="cambia_tipo()">
		  <option value="0">Seleccionar</option>
		  <option value="1">Nombre</option>
		  <option value="2">Apellido</option>
		  <option value="3">Documento</option>		  
	      </select>
	&nbsp;
	</span></td>
	<td><span class="Estilo2">&nbsp;
	    <?php
		if(isset($_GET['busqueda']))
		{
			if($_GET['busqueda']=="nombre")
			{
				echo "Digite un Nombre: <input name='busqueda_nombre' type='text'>";
			}
			if($_GET['busqueda']=="apellido")
			{
				echo "Digite un Apellido: <input name='busqueda_apellido' type='text'>";
			}			
			if($_GET['busqueda']=="documento")
			{
				echo "Digite Nro Documento: <input name='busqueda_documento' type='text'>";
			}
			
	?>
	</span></td>
    <td bgcolor="#C5D5D6"><span class="Estilo2">Fecha :</span></td>
    <td><span class="Estilo2"><?php echo $fechahoy=date("Y-m-d");?></span>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="4" align="center"><input name="buscar" type="submit" value="Buscar"><input name="buscar" type="button" value="Cancelar" onClick="cancelar()">&nbsp;</td>
  </tr>
  <?php
  }
  if(isset($_GET['buscar']))
  {
  ?>
</table>
<p align="center"><strong>Seleccione el estudiante que desee consultar de la siguiente tabla :</strong></p>
<p align="center"><input name="buscar" type="button" value="Cancelar" onClick="cancelar()"></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6"><span class="Estilo2"><strong>Cédula</strong>&nbsp;</span></td>
    <td align="center" bgcolor="#C5D5D6"><span class="Estilo2"><strong>Código</strong>&nbsp;</span></td>
  </tr>
<?php
  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		    $nombre = $_GET['busqueda_nombre'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
				c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
				WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'				
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
					c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
					FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
					WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'					
					and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
					and eg.idestudiantegeneral = est.idestudiantegeneral
					and ed.idestudiantegeneral = eg.idestudiantegeneral
					and c.codigocarrera = est.codigocarrera
					and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
					and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
					ORDER BY 3, est.codigoperiodo";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	}
	
	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
				c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c 
				WHERE ed.numerodocumento LIKE '$documento%'				
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
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
			$cod = $solicitud["codigoestudiante"];
			$nombrecarrera = $solicitud["nombrecarrera"];
			echo "<tr>
				<td><a href='descuentosvsdeudas.php?estudiante=$cod'>$est&nbsp;</a></td>
				<td>$cc&nbsp;</td>
				<td>$nombrecarrera&nbsp;</td>
			</tr>";
		}
		echo '<tr>
				<td colspan="3" align="center"><input name="buscar" type="button" value="Cancelar" onClick="cancelar()"></td>
			</tr>';
	}
?>
</table>
<p>
<?php
}
if(isset($_GET['estudiante']))
{
	echo "</table>";
	$codigoestudiante = $_GET['estudiante'];
	if(isset($_SESSION['dir']))
	{
		$dir = $_SESSION['dir'];
	}
	else
	{
		// Pagina de donde se llamo esta pagina
		$pagina = $_SERVER['HTTP_REFERER'];
		$inicio_pagina = strpos ($pagina, "?");
		$dir = substr ($pagina, $inicio_pagina);
		$_SESSION['dir'] = $dir;
	}
	
	require("descuentosvsdeudasformulario.php");
}
if(isset($_GET['borrar']))
{
	unset($_SESSION['dir']);
}
?>
</p>
</form>
</div>
</body>
<script language="javascript">
function cancelar()
{
	window.location.reload("descuentosvsdeudas.php");
}
</script>
<?php echo '<script language="javascript">
function cancelar2()
{
	window.location.reload("descuentosvsdeudas.php'.$dir.'&borrar=yes");
}
</script>';
?>
</html>
