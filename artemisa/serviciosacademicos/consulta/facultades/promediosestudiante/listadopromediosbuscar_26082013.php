<?php require_once('../../../Connections/sala2.php');
session_start();
mysql_select_db($database_sala, $sala);
$query_periodos = "select p.codigoperiodo, p.nombreperiodo
from periodo p, carreraperiodo cp
where cp.codigocarrera = '".$_SESSION['codigofacultad']."'
and p.codigoperiodo = cp.codigoperiodo
ORDER BY p.codigoperiodo DESC";
$periodos = mysql_query($query_periodos, $sala) or die(mysql_error());
$row_periodos = mysql_fetch_assoc($periodos);
$totalRows_periodos = mysql_num_rows($periodos);
?> 
<html>
<head>
<title></title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo6 {font-size: 12}
.Estilo8 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo9 {font-size: 12px}
.Estilo10 {
	font-size: 14;
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
		window.location.href="listadopromediosbuscar.php?busqueda=semestre"; 
	} 
    if (tipo == 2)
	{
		window.location.href="listadopromediosbuscar.php?busqueda=todos"; 
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
		window.location.href="listadopromediosbuscar.php?buscar="+busca; 
	} 
} 
</script>
<body>
<div align="center" class="Estilo1 Estilo6">
<form name="f1" action="listadopromediosformulario.php" method="get" onSubmit="return validar(this)">
  <p class="Estilo10">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" bordercolor="#003333">
  <tr>
    <td width="255" bgcolor="#C5D5D6"> <div align="center"><span class="Estilo8">Búsqueda por : </span>      <span class="Estilo9">
        <select name="tipo" onChange="cambia_tipo()">
              <option value="0">Seleccionar</option>
              <option value="1">Por Semestre</option>
              <option value="2">Todos los Semestres</option>				 
          </select>	
      </span></div></td>
	<td width="436"><div align="left"><span class="Estilo6">&nbsp;<span class="Estilo9">	        <strong>
	  <?php
 if(isset($_GET['busqueda']))
  {			if ($_GET['busqueda']=="semestre")
			{
			   echo "Semestre: <input name='busqueda_semestre' type='text' size ='1'>";
			}		
			if($_GET['busqueda']=="todos")
			{
				echo "<input name='busqueda_todos' type='hidden' size ='18' value='1'>";
			}
///////////////////////////			
	if(isset($_GET['busqueda']))
			{ ?>
	  &nbsp;Periodo:</strong>&nbsp;	</span>    
	      <select name="periodo" id="periodo" style="font-size:9px">
              <option value="0" <?php if (!(strcmp(0, $_GET['periodo']))) {echo "SELECTED";} ?>>Periodo</option>
              <?php
				do {  
				?>
                <option value="<?php echo $row_periodos['codigoperiodo']?>"<?php if (!(strcmp($row_periodos['codigoperiodo'], $_GET['periodo']))) {echo "SELECTED";} ?>><?php echo $row_periodos['nombreperiodo']?></option>
              <?php
				} while ($row_periodos = mysql_fetch_assoc($periodos));
				  $rows = mysql_num_rows($periodos);
				  if($rows > 0) {
					  mysql_data_seek($periodos, 0);
					  $row_carreras = mysql_fetch_assoc($periodos);
				  }
				?>
            </select>          
	      <?php   	
 }			
////////////////////////////			
?>	
        </span></div></td>
  </tr>  
  <tr>
    <td colspan="2" align="center"><span class="Estilo8">Ordenado Por:
          <input name="promedio" type="radio" value="1" checked>
          Promedio Semestral &nbsp; &nbsp; &nbsp;
          <input name="promedio" type="radio" value="2">
      Promedio Acumulado </span></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><input name="buscar" type="submit" value="Consultar">&nbsp;  	</td>
  </tr>
  <?php
  }
  ?>
</table>
</form>
</div>
</body>
</html>