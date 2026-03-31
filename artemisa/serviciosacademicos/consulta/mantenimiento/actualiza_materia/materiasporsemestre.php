<?php
require_once('../../../Connections/sala2.php'); 
mysql_select_db($database_sala, $sala);
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
//require_once('seguridadmateriasgrupos.php');
if(isset($_SESSION['codigofacultad']))
{
	$codigocarrera = $_SESSION['codigofacultad'];
}
$codigocarrera = 5;

$query_planestudios = "select *
from  planestudio p 
where p.codigocarrera = '$codigocarrera'	
and p.codigoestadoplanestudio like '1%'";
//echo $query_planestudios,"<br>"; 
$planestudios = mysql_query($query_planestudios, $sala) or die("$query_planestudios".mysql_error());
$row_planestudios = mysql_fetch_assoc($planestudios);
$totalRows_planestudios = mysql_num_rows($planestudios);
?>
<html>
<head>
<title>Busqueda de Materias y Grupos</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; }
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
		window.location.href="busca_materia.php?busqueda=codigo"; 
	} 
    if (tipo == 2)
	{
		window.location.href="busca_materia.php?busqueda=nombre"; 
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
		window.location.href="busca_materia.php?buscar="+busca; 
	} 
} 
</script>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<body>

<div align="center">
<form name="f1" action="busca_materia.php" method="get">
  <p align="center">CRITERIO DE B&Uacute;SQUEDA DE MATERIAS</p>
  <table width="700" border="1" bordercolor="#E9E9E9" cellpadding="1" cellspacing="0">
    <tr>
      <td width="200" id="tdtitulogris">Búsqueda por:
                <select name="tipo" onChange="cambia_tipo()">
                  <option value="0">Seleccionar</option>
                  <option value="1">Código</option>
                  <option value="2">Nombre</option>
                </select>
      </td>
      <td width="351" align="center" class="Estilo2"><?php
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
		echo "Digite una Facultad: <input name='busqueda_facultad' type='text'>";
	}
}
   

?>
  &nbsp; </td>
      <td width="55" id="tdtitulogris">Fecha</td>
      <td width="70" align="center" class="Estilo1" ><?php echo $fechahoy=date("Y-m-d");?></td>
    </tr>
    <tr>
      <td colspan="4" align="center" class="Estilo1">Plan de Estudios
	  <select name="planestudio">
<?
		do 
		{			
?>
            <option value="<?php echo $row_planestudios['idplanestudio'];?>"<?php if(!(strcmp($row_planestudios['idplanestudio'],$row_dataestudianteplan['idplanestudio']))) {echo "SELECTED";} ?>><?php echo $row_planestudios['nombreplanestudio']?></option>
 <?php				
    	} 
			while ($row_planestudios = mysql_fetch_assoc($planestudios));
			$totalRows_planestudios = mysql_num_rows($planestudios);
			if($totalRows_planestudios > 0)
			{
    			mysql_data_seek($planestudios, 0);
				$row_planestudios = mysql_fetch_assoc($planestudios);

			}
?>
          </select>
	  </td>
    </tr>
	<tr>
      <td colspan="4" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp; </td>
    </tr>
  </table>
  <p class="Estilo6 Estilo1">
<?php
//echo "<h1>".$_SESSION['MM_Username']."</h1>";
if(isset($_GET['buscar']))
{
	$vacio = false;
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		
		$query_solicitud = "SELECT	m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
		FROM materia m, carrera c, tipomateria t,detalleplanestudio d
		WHERE m.codigomateria LIKE '$codigo'
		and d.codigomateria = m.codigomateria	 
		AND m.codigocarrera = c.codigocarrera  						
		AND m.codigocarrera like '$codigocarrera'
		AND m.codigoestadomateria = '01'
		and d.idplanestudio = '".$_GET['planestudio']."'
		and m.codigotipomateria = t.codigotipomateria
		ORDER BY 2";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
	 
		if($_GET['busqueda_codigo'] == "")
		 {	
			//$vacio = true;
		   $query_solicitud = "SELECT	m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
		   FROM materia m, carrera c, tipomateria t,detalleplanestudio d
		   WHERE m.codigocarrera = c.codigocarrera 
		   and d.codigomateria = m.codigomateria	 						
		   AND m.codigocarrera like '$codigocarrera'
		   AND m.codigoestadomateria = '01'
		   and d.idplanestudio = '".$_GET['planestudio']."'
		   and m.codigotipomateria = t.codigotipomateria
		   ORDER BY 2";
		   $res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		 }
			
	}
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		
		$query_solicitud = "SELECT m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
		FROM materia m, carrera c, tipomateria t,detalleplanestudio d
		WHERE m.nombremateria LIKE '$nombre%'	
		and d.codigomateria = m.codigomateria	
		AND m.codigocarrera = c.codigocarrera 				
		AND m.codigocarrera like '$codigocarrera'
		AND m.codigoestadomateria = '01'
		and d.idplanestudio = '".$_GET['planestudio']."'
		and m.codigotipomateria = t.codigotipomateria
		ORDER BY 2";					
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		
		if($_GET['busqueda_nombre'] == "")
		 {
		    $query_solicitud = "SELECT	m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
		    FROM materia m, carrera c, tipomateria t,detalleplanestudio d
		    WHERE m.codigocarrera = c.codigocarrera  						
		    and d.codigomateria = m.codigomateria
			AND m.codigocarrera like '$codigocarrera'
		    AND m.codigoestadomateria = '01'
			and d.idplanestudio = '".$_GET['planestudio']."'
		    and m.codigotipomateria = t.codigotipomateria
		    ORDER BY 2";
		   $res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		 }
	}
	//echo $query_solicitud;
	$totalRows1=mysql_num_rows($res_solicitud);	
?>
</p>
  <p >MATERIAS ENCONTRADAS</p>
  <p >Seleccione la materia que desee  de la siguiente tabla :</p>
  <table width="700" height="5" border="1" align="center" bordercolor="#E9E9E9" cellpadding="1" cellspacing="0">
    <tr bgcolor="#C5D5D6">
      <td width="10%" id="tdtitulogris"><div align="center">Editar</div></td>
	  <td width="10%" id="tdtitulogris"><div align="center">Agregar Contenido</div></td>      
      <td width="20%" id="tdtitulogris"><div align="center">Facultad</div></td>
      <td width="10%" id="tdtitulogris"><div align="center">Tipo Materia</div></td>      
      </tr>
  </table>
  <table width="700" height="5" border="1" align="center" bordercolor="#E9E9E9" cellpadding="1" cellspacing="0">
<?php
	while ($fila=mysql_fetch_array($res_solicitud))
	{ 		
?>
    <tr class="Estilo1">
      <td width="10%" align="center"><a onClick="window.open('editar_materia.php?materia=<?php echo $fila['codigomateria'];?>','materias','width=600,height=400,left=200,top=100,scrollbars=yes')" style="cursor: pointer; font-size: 10px;"><?php echo $fila['codigomateria'];?></a></td>
      <td width="10%" align="center"><a onClick="window.open('contenidos.php?materia=<?php echo $fila['codigomateria'];?>&plan=<?php echo $_GET['planestudio']; ?>','materias','width=600,height=400,left=200,top=100,scrollbars=yes')" style="cursor: pointer; font-size: 10px;"><?php echo $fila['nombremateria'];?></a></td>
	  <td width="20%" align="center"><?php echo $fila['nombrecarrera'];?></td>
	  <td width="10%" align="center"><?php echo $fila['nombretipomateria'];?></td>
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