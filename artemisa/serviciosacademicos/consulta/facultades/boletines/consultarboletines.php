<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../../Connections/sala2.php'); 	
session_start();	
?>



<html>



<head>



<title></title>



</head>



<style type="text/css">



<!--



.Estilo1 {font-family: Tahoma; font-size: 12px}



.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }



.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}



.Estilo4 {color: #FF0000}



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



		window.location.reload("consultarboletines.php?busqueda=codigo"); 



	} 



    if (tipo == 2)



	{



		window.location.reload("consultarboletines.php?busqueda=semestre"); 



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



		window.location.reload("consultarboletines.php?buscar="+busca); 



	} 



} 



</script>



<body>



<div align="center">



<form name="f1" action="consultarboletinesformulario.php" method="post" >



  <p align="center" class="Estilo3"><strong>CRITERIO DE BUSQUEDA</strong></p>



  <table width="707" border="1" bordercolor="#003333" align="center">



  <tr class="Estilo2">



    <td width="250" bgcolor="#C5D5D6">



	Búsqueda por : 



	<select name="tipo" onChange="cambia_tipo()">



		<option value="0">Seleccionar</option>



		<option value="1">Código</option>			



		<option value="2">Semestre</option>	



	</select>



	&nbsp;



	</td>



	<td>&nbsp;



<?php



		if(isset($_GET['busqueda']))



		{



			if($_GET['busqueda']=="codigo")



			{



				echo "Digite Nro Documento : <input name='busqueda_codigo' type='text' size='10'>";



			}



			if($_GET['busqueda']=="semestre")



			{



				echo "Digite Semestre : <input name='busqueda_semestre' type='text' size='1'>";



			}	



?>



	</td>



  </tr>



  <tr>



  	<td colspan="2" align="center"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>



  </tr>



<?php



  }?>



</table>







</form>



</body>