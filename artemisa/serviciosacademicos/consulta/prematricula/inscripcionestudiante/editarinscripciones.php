<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require('../../../Connections/sala2.php'); 
@@session_start();
 $direccion = "inscripciones.php"; 
 mysql_select_db($database_sala, $sala);
 $query_periodo = "select codigoperiodo from periodo order by 1 desc";
 $periodo = mysql_query($query_periodo, $sala) or die("$query_periodo");
 $totalRows_periodo = mysql_num_rows($periodo);
 $row_periodo = mysql_fetch_assoc($periodo);

?>



<style type="text/css">



<!--



.style1 {	font-family: Tahoma;



	font-weight: bold;



	font-size: small;



}



.style2 {	font-family: Tahoma;



	font-size: small;



}



.Estilo4 {



	font-size: xx-small;



	font-weight: bold;



}



.Estilo5 {



	font-size: x-small;



	font-weight: bold;



}



.Estilo6 {font-family: Tahoma}



-->



</style>



<form name="inscripcion" method="post" action="">



<div align="center">



<p><strong> ADMISI&Oacute;N </strong></p>



<br>



<?php       



		$query_datosgrabados = "select *



		                        from admision



							    where idadmision = '".$_GET['id']."'							    



								";			  



		//echo $query_datosgrabados; 



		$datosgrabados = mysql_query($query_datosgrabados, $sala) or die("$query_estudios".mysql_error());



		$totalRows_datosgrabados = mysql_num_rows($datosgrabados);



		$row_datosgrabados = mysql_fetch_assoc($datosgrabados);



?> 	



<table width="40%" border="3" align="center" cellpadding="3" bordercolor="#003333">



  <tr>



    <td width="201" align="center" bgcolor="#C5D5D6">



        <div align="center" class="Estilo6"><span class="Estilo5"> Nombre Inscripci&oacute;n *</span></div>



        </td>



    <td width="212" align="center"> <div align="center" class="Estilo6"><span class="Estilo5"> <input type="text" name="nombre" value="<?php if (isset($row_datosgrabados['nombreadmision'])) echo $row_datosgrabados['nombreadmision']; else echo $_POST['nombre'];?>" size="40"></span></div></td>



  </tr>



   <tr>



    <td width="201" align="center" bgcolor="#C5D5D6">



        <div align="center" class="Estilo6"><span class="Estilo5"> Cantidad de seleccionados *</span></div>



        </td>



    <td width="212" align="center">



	  <div align="left"><span class="Estilo6"><span class="Estilo4">



	    <input type="text" name="cantidad" value="<?php if (isset($row_datosgrabados['cantidadseleccionadoadmision'])) echo $row_datosgrabados['cantidadseleccionadoadmision']; else echo $_POST['cantidad'];?>" size="1" maxlength="3">



	    </span></span>	    



	  </div></td>



  </tr>



  <tr>



    <td width="201" align="center" bgcolor="#C5D5D6">



        <div align="center" class="Estilo6"><span class="Estilo5"> Periodo Inscripci&oacute;n * </span></div>



        </td>



    <td width="212" align="center"><div align="left"><span class="Estilo6">



        <select name="periodo" onChange="MM_jumpMenu('consultanotassala.php',this,0)">



            <?php



      do {



?>



            <option value="<?php echo $row_periodo['codigoperiodo']?>"<?php if (!(strcmp($row_periodo['codigoperiodo'], $row_datosgrabados['codigoperiodo']))) {echo "SELECTED";} ?>><?php echo $row_periodo['codigoperiodo']?></option>



<?php



        } while ($row_periodo = mysql_fetch_assoc($periodo));



  $rows = mysql_num_rows($periodo);



  if($rows > 0) {



      mysql_data_seek($periodo, 0);



  $row_periodo = mysql_fetch_assoc($periodo);



  }



?>



        </select>



    </span></div></td>



  </tr>



</table>



<script language="javascript">



function grabar()



 {



  document.inscripcion.submit();



 }



</script>



<br>



   <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>



   <input type="hidden" name="grabado" value="grabado"> 



    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">   



</div>



<?php



if (isset($_POST['grabado']))



 {	



	$banderagrabar = 0;    



	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombre']) or $_POST['nombre'] == ""))



	  {



	    echo '<script language="JavaScript">alert("Nombre Incorrecto")</script>';	



		$banderagrabar = 1;



	  }	



	 else



	  if (!eregi("^[0-9]{1,15}$", $_POST['cantidad']))



	  {



	    echo '<script language="JavaScript">alert("Debe escribir la cantidad")</script>';		    		  



		



		$banderagrabar = 1;



	  }



	        



	else



	 if ($banderagrabar == 0)



	 {



	     $base="update admision



	     set nombreadmision = '".$_POST['nombre']."',



		 codigoperiodo = '".$_POST['periodo']."',



		 cantidadseleccionadoadmision = '".$_POST['cantidad']."'



	     WHERE idadmision = '".$_POST['id']."'";	 



	    



		 $sol=mysql_db_query($database_sala,$base);		



       



	     echo "<script language='javascript'>



			window.opener.recargar('".$direccion."');



			window.opener.focus();



			window.close();



		    </script>"; 	 



	 }



 }	



?>



</form>	   