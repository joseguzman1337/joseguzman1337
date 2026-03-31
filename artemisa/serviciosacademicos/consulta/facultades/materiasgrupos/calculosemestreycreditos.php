<?php
// Variables usadas: $_SESSION['dirini1'], $_SESSION['dir1']
require_once('../../../Connections/sala2.php'); 
mysql_select_db($database_sala, $sala);
session_start();
require_once('seguridadmateriasgrupos.php');
//echo "asañs";
//echo "<br>sin eliminar<br>";
/*foreach($_SESSION as $key => $value)
{
	echo "$key => $value<br>";
}*/
//echo "asañs";
	//$_SESSION['codigofacultad'] = 200;
	//$codigocarrera = $_SESSION['codigofacultad'];
	
	/*if(isset($_SESSION['objetos1']))
	{
		unset($_SESSION['objetos1']);
		session_unregister($_SESSION['objetos1']);
	}
	if(isset($_SESSION['numerodegrupo']))
	{
		unset($_SESSION['numerodegrupo']);
		session_unregister($_SESSION['numerodegrupo']);
	}
	*/
unset($_SESSION['dirini1']);
session_unregister($_SESSION['dirini1']);
	/*if(isset($_SESSION['nuevo1']))
	{
		unset($_SESSION['nuevo1']);
		session_unregister($_SESSION['nuevo1']);
	}
	*/
unset($_SESSION['dir1']);
session_unregister($_SESSION['dir1']);

echo "<br><br>despues de eliminar<br>";
foreach($_SESSION as $key => $value)
{
	echo "$key => $value<br>";
}
?>
<html>
<head>
<title>Busqueda de Materias</title>
<style type="text/css">
<!--
.Estilo6 {
	font-family: Tahoma;
	font-size: x-small;
}
-->
</style>
</head>
<style type="text/css">
<!--
.Estilo3 {
	font-family: tahoma;
	font-size: xx-small;
	font-weight: bold;
}
.Estilo5 {font-size: x-small}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
.Estilo7 {font-family: tahoma}
-->
</style>
<script language="javascript">
function cambia_tipo()
{ 
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (tipo == 1)
	{
		window.location.reload("materiasgrupos.php?busqueda=codigo"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("materiasgrupos.php?busqueda=nombre"); 
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
		window.location.reload("materiasgrupos.php?buscar="+busca); 
	} 
} 
</script>
<body>
<div align="center">
<form name="f1" action="materiasgrupos.php" method="get">
  <p class="Estilo6"><strong>CRITERIO DE B&Uacute;SQUEDA DE MATERIAS</strong></p>
  <table width="707" border="1" cellpadding="2" cellspacing="1"  bordercolor="#003333">
  <tr>
    <td width="250" bgcolor="#C5D5D6" class="Estilo6">
	<strong>Búsqueda por: 
	<select name="tipo" onChange="cambia_tipo()">
		    <option value="0">Seleccionar</option>
		    <option value="1">Código</option>
		    <option value="2">Nombre</option>
	    </select>
&nbsp;	</strong></td>
	<td class="Estilo6 Estilo1">&nbsp;
<?php
if(isset($_GET['busqueda']))
{
	if($_GET['busqueda']=="codigo")
	{
		echo "Digite un Código : <input name='busqueda_codigo' type='text'>";
	}
	if($_GET['busqueda']=="nombre")
	{
		echo "Digite un Nombre : <input name='busqueda_nombre' type='text'>";
	}
	if($_GET['busqueda']=="facultad")
	{
		echo "Digite una Faculta: <input name='busqueda_facultad' type='text'>";
	}
?>
	</td>
    <td bgcolor="#C5D5D6" class="Estilo6 Estilo1">Fecha : </td>
    <td class="Estilo6 Estilo1"><?php echo $fechahoy=date("Y-m-d");?>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="4" align="center" class="Estilo6 Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;
  	  </td>
  </tr>
  </table>
  <p class="Estilo6 Estilo1">
<?php
}
echo "</table>";
if(isset($_GET['buscar']))
{
	$vacio = false;
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		$query_solicitud = "SELECT	*
		FROM materia m,carrera c ,periodo p
		WHERE m.codigomateria LIKE '$codigo%'
		AND m.codigocarrera = c.codigocarrera  						
		AND m.codigoperiodo = p.codigoperiodo
		AND p.codigoestadoperiodo = 1
		ORDER BY m.nombremateria";
			
		//AND m.codigocarrera = '$codigocarrera'
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_codigo'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		$query_solicitud = "SELECT *
		FROM materia m,carrera c ,periodo p
		WHERE m.nombremateria LIKE '$nombre%'		
		AND m.codigocarrera = c.codigocarrera 				
		AND m.codigoperiodo = p.codigoperiodo
		AND p.codigoestadoperiodo = 1
		ORDER BY m.nombremateria";					
		//AND m.codigocarrera = '$codigocarrera'
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	$totalRows1=mysql_num_rows($res_solicitud);	
?>
</p>
  <p align="center" class="Estilo5 Estilo6 Estilo1">MATERIAS ENCONTRADAS </p>
  <p align="center" class="Estilo5 Estilo6 Estilo1">Seleccione la materia que desee  de la siguiente tabla :</p>
  <table width="606" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6">
      <td width="82" class="Estilo2 Estilo6 Estilo1"><div align="center"></div>
          <div align="center"><span class="Estilo7">C&oacute;digo</span></div></td>
      <td width="269" class="Estilo6 Estilo1"><div align="center"><span class="Estilo7">Nombre</span></div></td>
      <td width="231" class="Estilo6 Estilo1"><div align="center">Facultad</div></td>
      </tr>
  </table>
  <table width="606" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E97914">
<?php
	while ($fila=mysql_fetch_array($res_solicitud))
	{ 
?>
    <tr>
      <td width="85" class="Estilo6 Estilo1"><div align="center"><a href="detallesmateria.php?codigomateria1=<?php echo $fila['codigomateria'];?>&codigomaterianovasoft1=<?php echo $fila['codigomaterianovasoft'];?>&carrera1=<?php echo $fila['nombrecarrera'];?>"><?php echo $fila['codigomateria'];?></a></div></td>
      <td width="266" class="Estilo6 Estilo1"><div align="center"><?php echo $fila['nombremateria'];?></div></td>
      <td width="231" class="Estilo6 Estilo1"><div align="center"></div>
         <?php echo $fila['nombrecarrera'];?><div align="center"></div>
        <div align="center"></div></td>
      </tr>
    <?php
	}
}
?>
</table>
   
<p class="Estilo1">&nbsp;  </p>
</form>
		<p align="center" class="Estilo5 Estilo3">&nbsp;</p>
        <p class="Estilo1">
</p>
</form>
</div>
</body>
</html>
