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



    /*if (tipo == 1)



	{



		window.location.reload("consultarboletines.php?busqueda=codigo"); 



	} 



    */if (tipo == 2)



	{



		window.location.reload("generarboletinesmasivo.php?busqueda=semestre"); 



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



		window.location.reload("generarboletinesmasivo.php?buscar="+busca); 



	} 



} 



</script>



<body>



<form name="f1" action="generarboletinesmasivo.php" method="get" >



  <p align="center" class="Estilo3">CRITERIO DE B&Uacute;SQUEDA</p>



  <table width="707" border="1" bordercolor="#003333" align="center">



  <tr class="Estilo2">



    <td width="250" bgcolor="#C5D5D6">



	  <div align="center">Búsqueda por: <select name="tipo" onChange="cambia_tipo()">



		    <option value="0">Seleccionar</option>



		    <option value="2">Semestre</option>	



	        </select>



	&nbsp;



	    </div></td>



	<td>&nbsp;



<?php



		if(isset($_GET['busqueda']))



		{



			if($_GET['busqueda']=="codigo")



			{



				echo "No. Documento: <input name='busqueda_codigo' type='text' size='10'>";



			}



			if($_GET['busqueda']=="semestre")



			{



				echo "Semestre: <input name='busqueda_semestre' type='text' size='1'>";



			}	



?>&nbsp;



	</td>



  </tr>



  <tr>



  	<td colspan="2" align="center"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>



  </tr>



<?php



  }?>



</table>

<?php 

  if ($_GET['buscar'])

   {

   	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=seleccion_certificado.php?busqueda_semestre=".$_GET['busqueda_semestre']."'>";

   }

?>







</form>



</body>