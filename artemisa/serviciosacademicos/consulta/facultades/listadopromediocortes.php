<?php 
	//require_once('Connections/sala.php'); 	
	require_once('../../Connections/sala2.php');
	session_start();	
	/* 
if (! isset ($_SESSION['nombreprograma']))
 {?>
 <script>
   window.location.reload("../login.php");
 </script>
<?php	
 }
 else 
 if ($_SESSION['nombreprograma'] <> "listadopromediocortes.php")
{?>
 <script>
   window.location.reload("../login.php");
 </script>
<?php	 	
} */
?>
<html>
<head>
<title></title>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 9;
	font-weight: bold;
	font-family: Tahoma;
}
.Estilo3 {
	font-size: 12px;
	font-weight: bold;
	font-family: Tahoma;
}
.Estilo4 {font-size: 14}
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
		window.location.href="listadopromediocortes.php?busqueda=codigo";
	} 
    if (tipo == 2)
	{
		window.location.href="listadopromediocortes.php?busqueda=semestre";
	} 
	if (tipo == 3)
	{
		window.location.href="listadopromediocortes.php?busqueda=todos";
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
		window.location.href="listadopromediocortes.php?buscar="+busca;
	} 
} 
</script>
<body>
<div align="center">
<form name="f1" action="listadopromediocortesmostrar.php" method="post" >
  <p align="center" class="Estilo1 Estilo4">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" bordercolor="#003333" >
  <tr>
    <td width="250" bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"><strong> <span class="Estilo3">Búsqueda por :</span>              
      <select name="tipo" onChange="cambia_tipo()">
              <option value="0">Seleccionar</option>
              <option value="1">Documento</option>
              <option value="2">Semestre</option>
              <option value="3">Todos los Cortes</option>			
            </select>
	  </strong></span></div></td>
	<td><span class="Estilo3">&nbsp;
        <?php  
	  $usuario = $_SESSION['MM_Username'];
	  
	  mysql_select_db($database_sala, $sala);
	  $query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
	  $tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
	  $row_tipousuario = mysql_fetch_assoc($tipousuario);
	  $totalRows_tipousuario = mysql_num_rows($tipousuario);
      
	   $fecha = date("Y-m-d G:i:s",time());
		mysql_select_db($database_sala, $sala);
		$query_car = "SELECT nombrecarrera,codigocarrera 
						FROM carrera
						WHERE codigomodalidadacademica = '200'						
					    AND fechavencimientocarrera > '".$fecha."'	
					    order by 1";		
		$car = mysql_query($query_car, $sala) or die(mysql_error());
		$row_car = mysql_fetch_assoc($car);
		$totalRows_car = mysql_num_rows($car);

		
		if(isset($_GET['busqueda']))
		{
			if($_GET['busqueda']=="codigo")
			{
				echo "Digite No. Documento : <input name='busqueda_codigo' type='text' size='10'>&nbsp;&nbsp;&nbsp;&nbsp; Corte : <input name='busqueda_corte' type='text' size='1'>";
			}
			if($_GET['busqueda']=="semestre")
			{
				echo "Digite Semestre : <input name='busqueda_semestre' type='text' size='1'> &nbsp;&nbsp;&nbsp;&nbsp; Corte : <input name='busqueda_corte' type='text' size='1'>";
			}	
			if($_GET['busqueda']=="todos")
			{
				echo "Semestre Inicial: <input name='busqueda_semestre1' type='text' size='1'>";
			}	
	        
?>
	</span></td>
  </tr>
  <?php
if ($row_tipousuario['codigotipousuariofacultad'] == 200)
    {
?>
  <tr>
    <td bgcolor="#C5D5D6"><div align="center" class="Estilo3">Seleccionar Facultad </div></td>
    <td>
      <select name="carrera" id="carrera">
        <option value="0" <?php if (!(strcmp(0,$_GET['carrera']))) {echo "SELECTED";} ?>>Seleccionar Facultad</option>
        <?php
						do {  
						?>
        <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp(0, $row_car['codigocarrera']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>
        <?php
						} while ($row_car = mysql_fetch_assoc($car));
						  $rows = mysql_num_rows($car);
						  if($rows > 0) 
							   {
								  mysql_data_seek($car, 0);
								  $row_car = mysql_fetch_assoc($car);
								}
						  ?>
      </select>
      <?php			
			}
	 ?></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
<?php
  }?>
</table>
</form>
</div>
</body>