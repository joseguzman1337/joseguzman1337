<?php 
	require_once('../../Connections/sala2.php');	
	session_start();	
?>
<html>
<head>
<title></title>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 14px;
	font-weight: bold;
	font-family: Tahoma;
}
.Estilo4 {
	font-size: 12px;
	font-family: Tahoma;
	font-weight: bold;
}
.Estilo6 {font-weight: bold; font-family: Tahoma;}
.Estilo7 {font-size: 12px; }
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
		window.location.reload("listadofallas.php?busqueda=codigo"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("listadofallas.php?busqueda=semestre"); 
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
		window.location.reload("listadofallas.php?buscar="+busca); 
	} 
} 
</script>
<body>
<div align="center">
<form name="f1" action="listadofallasformulario.php" method="post" >
  <p align="center" class="Estilo1">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" bordercolor="#003333" >
  <tr>
    <td width="251" bgcolor="#C5D5D6"><div align="center" class="Estilo7">
      <span class="Estilo6"> Búsqueda por :
      <select name="tipo" onChange="cambia_tipo()">
            <option value="0">Seleccionar</option>
            <option value="1">Documento</option>
            <option value="2">Semestre</option>		
          </select>
	&nbsp;
      </span></div></td>
	<td width="440"><span class="Estilo4">&nbsp;
	    <?php
		if(isset($_GET['busqueda']))
		{
			if($_GET['busqueda']=="codigo")
			{
				echo "Digite El Documento : <input name='busqueda_codigo' type='text' size='10'>";
			}
			if($_GET['busqueda']=="semestre")
			{
				echo "Digite Semestre : <input name='busqueda_semestre' type='text' size='1'>";
			}	
	?>
	</span></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><div align="center" class="Estilo7">
  	    <input name="buscar" type="submit" value="Buscar">
  	  &nbsp;</div></td>
  </tr>
<?php
  }?>
</table>
</form>
</body>