<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../../Connections/sala2.php');



@@session_start();



mysql_select_db($database_sala, $sala);



$codigocarrera = $_SESSION['codigofacultad']; 



$usuario = $_SESSION['MM_Username'];







 $query_tipousuario = "SELECT * from carrera where codigocarrera = '".$codigocarrera."'";



 $tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());



 $row_tipousuario = mysql_fetch_assoc($tipousuario);



 $totalRows_tipousuario = mysql_num_rows($tipousuario);







?> 



<html>



<head>



<title></title>



<style type="text/css">



<!--



.Estilo1 {font-family: tahoma}



.Estilo2 {font-size: x-small}



.Estilo3 {font-size: xx-small}



.Estilo4 {



	font-size: 14px;



	font-weight: bold;



}



.Estilo5 {font-size: 12px}



.Estilo6 {font-size: 12}



.Estilo8 {font-size: 12px; font-weight: bold; }



.Estilo9 {



	font-family: Tahoma;



	font-weight: bold;



	font-size: 9px;



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



		window.location.reload("listadopreinscritosbusqueda.php?busqueda=salon"); 



	} 



    if (tipo == 2)



	{



		window.location.reload("listadopreinscritosbusqueda.php?busqueda=todos"); 



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



		window.location.reload("listadopreinscritosbusqueda.php?buscar="+busca); 



	} 



} 



</script>



<body>



<div align="center" class="Estilo1">



<form name="f1" action="listadopreinscritosbusqueda.php" method="get" onSubmit="return validar(this)">



  <p class="Estilo4">CRITERIO DE B&Uacute;SQUEDA</p>



  <table width="707" border="1" bordercolor="#003333">



  <tr>



    <td width="250" bgcolor="#C5D5D6"><div align="center"><span class="Estilo6"> <span class="Estilo5"><strong>Búsqueda por : </strong></span>



            <select name="tipo" onChange="cambia_tipo()">



		      <option value="0">Seleccionar</option>



		      <option value="1">Salón</option>



			  <option value="2">Todos</option>				            



	        </select>



	&nbsp;



	  </span></div></td>



	<td><span class="Estilo8">&nbsp;



<?php



 if(isset($_GET['busqueda']))  



    {	



			if($_GET['busqueda']=="salon")



			{



				echo "Digite el Salón : <input name='busqueda_salon' type='text' size ='5'>";



			}



			if($_GET['busqueda']=="todos")



			{



				echo "Listado Genérico <input name='busqueda_salon' type='hidden' size ='18'>";



			}



			



?>      



	</span></td>



  </tr> 



 <tr>



  <td colspan="2" align="center"><span class="Estilo8">



   Fecha de Examen: &nbsp; <input name="fecha" type="text" value="<?php echo date("Y-m-d");?>" size="8" maxlength="10"> 



   aaaa-mm-dd  



  	</span></td>



  </tr>



 <tr>



  <td colspan="2" align="center"><span class="Estilo8">



   Ordenado Por: &nbsp;



   <select name="ordenado">



    <option value="i.numeroinscripcion">No de Formulario</option>



	<option value="nombre">Alfabético</option>



  </select>



  	</span></td>



  </tr>  



<?php 



  if ($row_tipousuario['codigomodalidadacademica'] == 300)



    { // if 2



            $fecha = date("Y-m-d G:i:s",time());



			$query_car = "SELECT nombrecarrera,codigocarrera 



					      FROM carrera 



						  where codigomodalidadacademica = '300'



						  AND fechavencimientocarrera > '".$fecha."'



						  order by 1";		



			//echo $query_car;



			$car = mysql_query($query_car, $sala) or die(mysql_error());



			$row_car = mysql_fetch_assoc($car);



			$totalRows_car = mysql_num_rows($car);











?> 



  <tr>



  	<td colspan="2" align="center"><span class="Estilo8">



  	 Programa: <select name="especializacion" id="especializacion">



            <option value="" <?php if (!(strcmp("0", $_POST['especializacion']))) {echo "SELECTED";} ?>>Todos los Pogramas</option>



            <?php



             do {  



?>



            <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp($row_car['codigocarrera'], $_POST['especializacion']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>



            <?php



				} while ($row_car = mysql_fetch_assoc($car));



				  $rows = mysql_num_rows($car);



				  if($rows > 0) {



					  mysql_data_seek($car, 0);



					  $row_car = mysql_fetch_assoc($car);



				  }



?>



       </select> 



  	</span></td>



  </tr>  



<?php



    } // if 2



?>  



  <tr>



  	<td colspan="2" align="center"><span class="Estilo3">



  	  <input name="buscar" type="submit" value="Consultar">



  	  &nbsp;  	 



  	</span></td>



  </tr>



<?php  



  }



?>



</table>



  <span class="Estilo9">



  <?php 



if(isset($_GET['buscar']))



  {         



    if ($_GET['fecha'] == "")



	 {



	   echo '<script language="JavaScript">alert("Debe digitar la fecha de examen");



		     history.go(-1);</script>';  



	 }



	



	



	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=listadopreinscritos.php?tipo=".$_GET['busqueda_salon']."&ordenado=".$_GET['ordenado']."&fecha=".$_GET['fecha']."&programa=".$_GET['especializacion']."'>";	



  }



?>



  </span> 



<p class="Estilo2">







</p>



</form>



</div>



</body>



</html>