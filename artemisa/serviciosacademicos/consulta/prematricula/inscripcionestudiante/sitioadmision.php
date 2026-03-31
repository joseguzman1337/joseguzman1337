<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
  require('../../../Connections/sala2.php'); 

@@session_start();

$carrera = 100;

 echo "Hola"; 

 mysql_select_db($database_sala, $sala);

 $query_periodo = "select * from carreraperiodo where codigocarrera = '$carrera' order by 3 desc";

 $periodo = mysql_query($query_periodo, $sala) or die("$query_periodo");

 $totalRows_periodo = mysql_num_rows($periodo);

 $row_periodo = mysql_fetch_assoc($periodo);

?>

<style type="text/css">

<!--

.Estilo1 {font-family: Tahoma; font-size: 12px}

.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }

.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}

.Estilo4 {color: #FF0000}

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

<form name="inscripcion" method="post" action="admision.php">

<div align="center">

<p class="Estilo3">ADMISI&Oacute;N</p>

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

		       <table width="50%" border="1" align="center" bordercolor="#003333" cellpadding="0" cellspacing="0">

			   <tr>

			   <td>

		       <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">

                <tr bgcolor="#CCDADD" class="Estilo2">

					<td ><div align="center">Nombre</div></td>

					<td><div align="center">Cantidad</div></td>					

                    <td><div align="center">Periodo</div></td>

					<td><div align="center">Detalle</div></td>

					<td><div align="center">Sitio</div></td>

					<td><div align="center">Editar</div></td>										

                </tr>

		       <?php 			    

				 do{ ?>

			        <tr bgcolor='#FEF7ED' class="Estilo1">

                     <td><div align="center"><?php echo $row_datosgrabados['nombreadmision'];?>&nbsp;</div></td>

					 <td><div align="center"><?php echo $row_datosgrabados['cantidadseleccionadoadmision'];?>&nbsp;</div></td>                     

					 <td colspan=""><div align="center"><?php echo $row_datosgrabados['codigoperiodo'];?>&nbsp;</div></td>                     

					 <td><div align="center"><a href="detalleadmision.php?idadmision=<?php echo $row_datosgrabados['idadmision'];?>"><img src="../../../../imagenes/detalleadmision.gif" width="20" height="20" alt="Detalles"></a></div></td>

					 <td><div align="center"><a href="sitioadmision.php"><img src="../../../../imagenes/citacion.gif" width="20" height="20" alt="Lugar y Hora"></a></div></td>

			         <td><div align="center"><a href="admision.php" onClick="window.open('editaradmision.php?id=<?php echo $row_datosgrabados['idadmision'];?>','mensajes','width=500,height=280,left=450,top=300,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar"></a></div></td>

				 </tr>			   

			    <?php  

				  }while($row_datosgrabados = mysql_fetch_assoc($datosgrabados));

			   ?>

			

<?php

		  }

?>

  <tr>

    <td align="center" bgcolor="#C5D5D6" class="Estilo2">Nombre Admisi&oacute;n <span class="Estilo4">*</span></td>

    <td colspan="5" bgcolor='#FEF7ED'><input type="text" name="nombre" value="<?php echo $_POST['nombre'];?>" size="40"></td>

  </tr>

   <tr>

    <td align="center" bgcolor="#C5D5D6" class="Estilo2">Cantidad seleccionados <span class="Estilo4">*</span></td>

    <td align="left" colspan="5" bgcolor='#FEF7ED'>

	    <input type="text" name="cantidad" value="<?php echo $_POST['cantidad'];?>" size="1" maxlength="3">

	</td>

  </tr>

   <tr>

    <td align="center" bgcolor="#C5D5D6" class="Estilo2">Periodo Admisi&oacute;n <span class="Estilo4">*</span></td>

    <td align="left" colspan="5" bgcolor='#FEF7ED'>

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

    </td>

  </tr>

</table>

</td> 

</tr>   

</table>     

<script language="javascript">

function grabar()

 {

  document.inscripcion.submit();

 }

</script>

<br><br>

   <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>

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

	window.location.reload("admision.php"+dir);

	history.go();

}

</script>   