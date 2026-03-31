<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
      
require('../../../Connections/sala2.php'); 



@@session_start();



$carrera = 100;



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



<script language="JavaScript" type="text/JavaScript">



<!--



function MM_jumpMenu(targ,selObj,restore){ //v3.0



  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");



  if (restore) selObj.selectedIndex=0;



}



//-->



</script>



<form name="inscripcion" method="post" action="inscripciones.php">



<div align="center">



<p><strong> ADMISI&Oacute;N </strong></p>



<br>



<?php       



		 $query_datosgrabados = "select *



		                        from admision



							    where codigocarrera = '$carrera'							    



								";			  



		///echo $query_datosgrabados; 



		$datosgrabados = mysql_query($query_datosgrabados, $sala) or die("$query_estudios".mysql_error());



		$totalRows_datosgrabados = mysql_num_rows($datosgrabados);



		$row_datosgrabados = mysql_fetch_assoc($datosgrabados);



?> 		   



<br>



<?php



         if ($row_datosgrabados <> "")



		   { ?>



		       <table width="40%" border="3" align="center" cellpadding="3" bordercolor="#003333">



                <tr bgcolor="#CCDADD">



					<td width="37%"><div align="center"><strong><font size="2" face="Tahoma">Nombre</font></strong></div></td>



					<td><div align="center"><strong><font size="2" face="Tahoma">Cantidad</font></strong></div></td>					



                    <td><div align="center"><strong><font size="2" face="Tahoma">Periodo</font></strong></div></td>



					<td><div align="center"><strong><font size="2" face="Tahoma">Editar</font></strong></div></td>										



                </tr>



		       <?php 			    



				 do{ ?>



			        <tr>



                     <td><div align="center"><font size="2" face="Tahoma"><?php echo $row_datosgrabados['nombreadmision'];?>&nbsp;</font></div></td>



					 <td><div align="center"><font size="2" face="Tahoma"><?php echo $row_datosgrabados['cantidadseleccionadoadmision'];?>&nbsp;</font></div></td>                     



					 <td><div align="center"><font size="2" face="Tahoma"><?php echo $row_datosgrabados['codigoperiodo'];?>&nbsp;</font></div></td>                     



					 <td><div align="center"><a onClick="window.open('editarinscripciones.php?id=<?php echo $row_datosgrabados['idadmision'];?>','mensajes','width=800,height=300,left=150,top=50,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar"></a></div></td>



			        </tr>			   



			    <?php  



				  }while($row_datosgrabados = mysql_fetch_assoc($datosgrabados));



			   ?>



			  </table> 



<?php



		  }



?>	



<br>



<table width="40%" border="3" align="center" cellpadding="3" bordercolor="#003333">



  <tr>



    <td width="201" align="center" bgcolor="#C5D5D6">



        <div align="center" class="Estilo6"><span class="Estilo5"> Nombre Inscripci&oacute;n *</span></div>



        </td>



    <td width="212" align="center"> <div align="center" class="Estilo6"><span class="Estilo5"> <input type="text" name="nombre" value="<?php echo $_POST['nombre'];?>" size="40"></span></div></td>



  </tr>



   <tr>



    <td width="201" align="center" bgcolor="#C5D5D6">



        <div align="center" class="Estilo6"><span class="Estilo5"> Cantidad de seleccionados *</span></div>



        </td>



    <td width="212" align="center">



	  <div align="left"><span class="Estilo6"><span class="Estilo4">



	    <input type="text" name="cantidad" value="<?php echo $_POST['cantidad'];?>" size="1" maxlength="3">



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



            <option value="<?php echo $row_periodo['codigoperiodo']?>"<?php if (!(strcmp($row_periodo['codigoperiodo'], $_POST['periodo']))) {echo "SELECTED";} ?>><?php echo $row_periodo['codigoperiodo']?></option>



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



<p>&nbsp;</p>



<script language="javascript">



function grabar()



 {



  document.inscripcion.submit();



 }



</script>



<br><br>



   <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/Registro.gif" width="50" height="50" alt="Guardar"></a>



   <input type="hidden" name="grabado" value="grabado">   



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



	     $query_admisiones = "select *



		                      from admision



							  where codigoperiodo = '".$_POST['periodo']."'



							  and codigocarrera = '$carrera'";



		 $admisiones = mysql_query($query_admisiones, $sala) or die("$query_admisiones");



		 $totalRows_admisiones = mysql_num_rows($admisiones);



		 $row_admisiones = mysql_fetch_assoc($admisiones);



		 



		 if (! $row_admisiones)



		  {



		    $query_admision = "INSERT INTO admision(nombreadmision,codigoperiodo,codigocarrera,codigoestado,cantidadseleccionadoadmision) 



		    VALUES('".$_POST['nombre']."','".$_POST['periodo']."', '$carrera', '100','".$_POST['cantidad']."')"; 



		    $admision = mysql_db_query($database_sala,$query_admision) or die("$query_admision".mysql_error());



        



		    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=inscripciones.php'>";	  



		  } 



		 else



		  {



		     echo '<script language="JavaScript">alert("Ya tiene creada una admisión para este periodo"); history.go(-1);</script>';		  



		  }		



	 }



 }	



?>



</form>



<script language="javascript">



function recargar(dir)



{



	window.location.reload("inscripciones.php"+dir);



	history.go();



}



</script>   