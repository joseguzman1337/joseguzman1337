<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Listado de estudiantes con orden de 1er semestre</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<div align="center">
<p align="center" class="Estilo1"><strong>Estudiantes Nuevos con Orden de Pago: </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#C5D5D6" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo1"><strong>Documento</strong>&nbsp;</td>
	<td align="center" bgcolor="#C5D5D6" class="Estilo1"><strong>Orden de Pago</strong>&nbsp;</td>	
  </tr>
<?php
	//$_SESSION['codigofacultad'] = 123;
	// Estudiantes a los que posiblemete se les va a generar orden de pago
	$query_selestudiantes = "SELECT concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre, e.codigocarrera, e.numerocohorte, e.codigotipoestudiante, 
	e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoestudiante, eg.numerodocumento, p.codigoperiodo, o.numeroordenpago 
	FROM estudiante e, estudiantegeneral eg, periodo p, ordenpago o, prematricula pre
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
	AND e.codigosituacioncarreraestudiante = '300'
	AND e.codigotipoestudiante = '10'
	AND e.codigocarrera = '".$_SESSION['codigofacultad']."'
	AND e.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
	AND e.codigoperiodo = p.codigoperiodo 
	AND p.codigoestadoperiodo = '1'
	and o.codigoestudiante = e.codigoestudiante
	and o.codigoperiodo = p.codigoperiodo
	and pre.codigoestudiante = e.codigoestudiante
	and o.idprematricula = pre.idprematricula
	and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
	order by 1";
	//echo "$query_selestudiantes<br>";
	//exit();
	$selestudiantes = mysql_db_query($database_sala,$query_selestudiantes) or die("$query_selestudiantes".mysql_error());
	$totalRows_selestudiantes = mysql_num_rows($selestudiantes);
	// Si el query es vacio quiere decir que el estudiante ingreso en un periodo diferente al activo
	if($totalRows_selestudiantes != "")
	{
		while($row_selestudiantes = mysql_fetch_array($selestudiantes))
		{
?> 
  <tr>
    <td align="center" class="Estilo1"><?php echo $row_selestudiantes['nombre']; ?>&nbsp;</td>
    <td align="center" class="Estilo1"><?php echo $row_selestudiantes['numerodocumento']; ?>&nbsp;</td>	
	<td align="center" class="Estilo1"><?php echo $row_selestudiantes['numeroordenpago']; ?>&nbsp;</td>	
  </tr>
<?php
		}
	}
	else
	{
?>
 <tr>
    <td align="center" class="Estilo1" colspan="3">No Hay Estudiantes Nuevos Con Orden Generada</td>	
  </tr>
<?php
	}
?>
 <tr>
    <td align="center" class="Estilo1" colspan="3"><input type="button" name="regresar" value="Regresar" onClick="window.location.reload('../../facultades/menuopcion.php')"><input type="button" name="imprimir" value="Imprimir" onClick="print()"></td>	
  </tr>
</table>

</div> 
</body>
</html>
