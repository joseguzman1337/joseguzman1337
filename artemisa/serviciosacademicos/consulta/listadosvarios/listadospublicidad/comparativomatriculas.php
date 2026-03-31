<?php require_once('../../../Connections/sala2.php');
/*$hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); 
*/
@session_start();
$GLOBALS['periodosseleccionados'];
session_register("periodosseleccionados");

   
?>
<style type="text/css">
<!--
.Estilo11 {
	font-size: 9;
	font-family: Tahoma;
}
.Estilo15 {font-size: x-small}
-->
</style>
<script language="javascript">
function enviar()
{
 document.f1.submit();
}
</script>
<?php	
  $fecha = date("Y-m-d G:i:s",time());
  mysql_select_db($database_sala, $sala);
	
	$query_modalidad = "SELECT * FROM modalidadacademica 
	where codigomodalidadacademica not like '5%'
	order by 1 desc";
	$modalidad = mysql_query($query_modalidad, $sala) or die(mysql_error());
	$row_modalidad = mysql_fetch_assoc($modalidad);
	$totalRows_modalidad = mysql_num_rows($modalidad); 
    
	$query_car = "SELECT distinct nombrecarrera,codigocarrera,codigomodalidadacademica
    FROM carrera
    WHERE fechavencimientocarrera > '".$fecha."'
    and codigomodalidadacademica = '".$_GET['modalidad']."'	
    order by 1 ";		
    $car = mysql_query($query_car, $sala) or die(mysql_error());
    $row_car = mysql_fetch_assoc($car);
    $totalRows_car = mysql_num_rows($car);
   
   	$query_periodos = "SELECT distinct p.codigoperiodo
	FROM periodo pe,prematricula p
	where pe.codigoperiodo = p.codigoperiodo
	order by 1";
	$periodos = mysql_query($query_periodos, $sala) or die(mysql_error());
	$row_periodos = mysql_fetch_assoc($periodos);
	$totalRows_periodos = mysql_num_rows($periodos);
	$totalperiodos = $totalRows_periodos;
?> 
<html>
<head>
<title></title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo12 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo13 {font-size: 12}
.Estilo14 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<div align="center" class="Estilo1 Estilo11">
<form name="f1" action="comparativomatriculas.php" method="get" onSubmit="return validar(this)">
  <p class="Estilo14">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="650" border="1" bordercolor="#003333">
  <tr>
    <td width="353" bgcolor="#C5D5D6"> <div align="center"><span class="Estilo12">Modalidad Acad&eacute;mica  : </span>      <span class="Estilo13">
    <select name="modalidad" id="modalidad" onChange="enviar()">
  <option value="0" <?php if (!(strcmp("0", $_GET['modalidad']))) {echo "SELECTED";} ?>>Seleccionar</option>	
  <option value="0" <?php if (!(strcmp("0", $_GET['modalidad']))) {echo "SELECTED";} ?>>Todas las Modalidades</option>
<?php
	  do { 
?>			<option value="<?php echo $row_modalidad['codigomodalidadacademica']?>"<?php if (!(strcmp($row_modalidad['codigomodalidadacademica'], $_GET['modalidad']))) {echo "SELECTED";} ?>><?php echo $row_modalidad['nombremodalidadacademica']?></option>

<?php
	  } while ($row_modalidad = mysql_fetch_assoc($modalidad));
		  $rows = mysql_num_rows($modalidad);
		  if($rows > 0) 
		  {
			  mysql_data_seek($car, 0);
			  $row_modalidad = mysql_fetch_assoc($modalidad);
		  }
?>
  </select>
</span></div></td>
	<td width="281">&nbsp;	    <span class="Estilo12">
<?php
 if(isset($_GET['modalidad']))
  {			
 $query_modalidades = "SELECT *
     FROM carrera
     WHERE fechavencimientocarrera > '".$fecha."'
     and codigomodalidadacademica = '".$_GET['modalidad']."'	
     order by 1 ";		
     // echo $query_car;
     $modalidades = mysql_query($query_modalidades, $sala) or die(mysql_error());
     $row_modalidades = mysql_fetch_assoc($modalidades);
     $totalRows_modalidades = mysql_num_rows($modalidades);

?>			       
	  <select name="carrera" id="carrera">
<?php 	  
     if ($totalRows_modalidades > 1 or $_GET['modalidad'] == 0)
	  {
?>
	    <option value="0" <?php if (!(strcmp(0,$_GET['carrera']))) {echo "SELECTED";} ?>>Todos los Programas</option>
<?php 	  
      }

      while ($row_car = mysql_fetch_assoc($car))
	   {  
?>
        <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp(0, $row_car['codigocarrera']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>
 <?php
	   } 
	    $rows = mysql_num_rows($car);
		  if($rows > 0) 
		   {
		     mysql_data_seek($car, 0);
			 $row_car = mysql_fetch_assoc($car);
		   }
?>
          </select>	 
	  </span></td>
  </tr>
  <tr> 
  	<td colspan="2" align="center">
	


<table border="0" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
 <tr class="Estilo2">
   <td><div align="center">&nbsp;</div></td>
   <td><div align="center">&nbsp;</div></td>
 </tr>
 <tr class="Estilo2">
   <td bgcolor="#C5D5D6"><div align="center" class="Estilo15"><strong>Todos los Periodos</strong></div></td>
   <td><div align="center" class="Estilo1 Estilo15"><input type="checkbox" onClick="HabilitarTodos(this)"></div></td>
 </tr>
 <tr bgcolor="#C5D5D6" class="Estilo2"> 	
   <td align="center"><span class="Estilo15"><strong>Periodo&nbsp;</strong></span></td>
   <td align="center" bgcolor="#C5D5D6"><span class="Estilo15"><strong>Seleccionar&nbsp;</strong></span></td>
 </tr>
 <?php 
    $w= 1;
   do{ ?> 
      <tr class="Estilo1">	
		<td><span class="Estilo15"><?php echo $row_periodos['codigoperiodo'];?>&nbsp;</span></td>
		<td align="center"><span class="Estilo15">
		  <input type="checkbox" name="periodo<?php echo $w;?>" title="periodo" value="<?php echo $row_periodos['codigoperiodo'];?>">
		  &nbsp;</span></td>
     </tr>
<?php 
    $w++;
   }while($row_periodos = mysql_fetch_assoc($periodos));?>
</table>
	
	<input name="buscar" type="submit" value="Consultar" ></td>
  </tr>
  <?php
  }
  ?>
</table>
<p>

</p>
</form>
</div>
</body>
<script language="javascript">
function HabilitarTodos(chkbox, seleccion)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		if(elemento.type == "checkbox")
		{
			if (elemento.title == "periodo")
			{
    			elemento.checked = chkbox.checked
			}
		}
	}
}
</script>

<?php 
  session_unregister('periodosseleccionados');
   if (isset($_GET['buscar']))
	{
	 
	 
	 for($i = 1;$i <= $totalperiodos; $i++)
	  {
	    if ($_GET["periodo".$i] == true)
		 {
		    $_SESSION['periodosseleccionados'][$i] = $_GET["periodo".$i]; 
		 }
	  }
	 
	$seleccionados = count($_SESSION['periodosseleccionados']);
	
	if ($seleccionados == 0)
	 {
	   echo '<script language="JavaScript">alert("Debe seleccionar minimo un periodo"); history.go(-1);</script>';
	 }
	
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=comparativomatriculasformulario.php?carrera=".$_GET['carrera']."&modalidad=".$_GET['modalidad']."&periodossel=".$periodosseleccionados."'>"; 
	}
?>
</html>