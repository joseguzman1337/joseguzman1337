<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);  
    
 require('../../../Connections/sala2.php'); 

@@session_start();



 mysql_select_db($database_sala, $sala);

 $query_tipoadmision= "select * from tipodetalleadmision";

 $tipoadmision = mysql_query($query_tipoadmision, $sala) or die("$query_tipoadmision");

 $totalRows_tipoadmision = mysql_num_rows($tipoadmision);

 $row_tipoadmision = mysql_fetch_assoc($tipoadmision);

 

 $query_preseleccion = "select * from requierepreselecciondetalleadmision";

 $preseleccion = mysql_query($query_preseleccion, $sala) or die("$query_preseleccion");

 $totalRows_preseleccion = mysql_num_rows($preseleccion);

 $row_preseleccion = mysql_fetch_assoc($preseleccion);

?>

<style type="text/css">

<!--

.Estilo1 {font-family: Tahoma; font-size: 12px}

.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }

.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}

.Estilo4 {color: #FF0000}

-->

</style>

<form name="inscripcion" method="post" action="detalleadmision.php">

<div align="center">

<p class="Estilo3">ADMISI&Oacute;N</p>

<br>

<table width="60%" border="1" align="center" bordercolor="#003333"  cellspacing="0">

<tr>

<td>

 <table width="100%" border="0">  

 <?php

	 $detalleadmision = "";

	 if (isset($_GET['idadmision']))

	  {

		 $detalleadmision = $_GET['idadmision'];

	?>   

	  <input type="hidden" name="idadmision" value="<?php echo $_GET['idadmision'];?>">   

	<?php 

	  }

	?>

	<?php 

	 if (isset($_POST['idadmision']))

	  {

		 $detalleadmision = $_POST['idadmision'];

	?>   

	  <input type="hidden" name="idadmision" value="<?php echo $_POST['idadmision'];?>">   

	<?php 

	  } 

$query_datosgrabados = "select *

     					from detalleadmision d,tipodetalleadmision t,requierepreselecciondetalleadmision r

						where d.idadmision = '$detalleadmision'

						and d.codigotipodetalleadmision	= t.codigotipodetalleadmision		

						and d.codigorequierepreselecciondetalleadmision = r.codigorequierepreselecciondetalleadmision			    

						order by d.numeroprioridaddetalleadmision";			  

			///echo $query_datosgrabados; 

$datosgrabados = mysql_query($query_datosgrabados, $sala) or die("$query_datosgrabados".mysql_error());

$totalRows_datosgrabados = mysql_num_rows($datosgrabados);

$row_datosgrabados = mysql_fetch_assoc($datosgrabados);  

            

if ($row_datosgrabados <> "")

 {

?>

  <tr class="Estilo2">

	<td colspan="1" align="center" bgcolor="#C5D5D6">No.</td>

	<td colspan="1" align="center" bgcolor="#C5D5D6">Nombre</td>

	<td colspan="1" align="center" bgcolor="#C5D5D6">Porcentaje</td>

	<td colspan="1" align="center" bgcolor="#C5D5D6">Preguntas</td>

	<td colspan="1" align="center" bgcolor="#C5D5D6">Tipo</td>

	<td colspan="1" align="center" bgcolor="#C5D5D6">Preselección</td>

	<td colspan="1" align="center" bgcolor="#C5D5D6">Editar</td>

</tr>



<?php 

do

 {

?> 

    <tr class="Estilo1">

	<td colspan="1" align="center" bgcolor="#FEF7ED"><?php echo $row_datosgrabados['numeroprioridaddetalleadmision'];?></td>

	<td colspan="1" align="center" bgcolor="#FEF7ED"><?php echo $row_datosgrabados['nombredetalleadmision'];?></td>

	<td colspan="1" align="center" bgcolor="#FEF7ED"><?php echo $row_datosgrabados['porcentajedetalleadmision'];?></td>

	<td colspan="1" align="center" bgcolor="#FEF7ED"><?php echo $row_datosgrabados['totalpreguntasdetalleadmision'];?></td>

	<td colspan="1" align="center" bgcolor="#FEF7ED"><?php echo $row_datosgrabados['nombretipodetalleadmision'];?></td>

	<td colspan="1" align="center" bgcolor="#FEF7ED"><?php echo $row_datosgrabados['nombrerequierepreselecciondetalleadmision'];?></td>

    <td bgcolor="#FEF7ED"><div align="center"><a onClick="window.open('editardetalleadmision.php?id=<?php echo $row_datosgrabados['idadmision'];?>','mensajes','width=900,height=350,left=200,top=300,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar"></a></div></td>

</tr>

<?php

 }while($row_datosgrabados = mysql_fetch_assoc($datosgrabados));

 }

else

 { // else         

?>

  <tr>

    <td colspan="3" align="center" bgcolor="#C5D5D6"><div align="center" class="Estilo2">Cantidad de Pruebas</div></td>

    <td colspan= "3" align="center"  bgcolor='#FEF7ED'> <div align="center" class="Estilo1">

      <input type="text" name="cantidad"  value="<?php echo $_POST['cantidad'];?>" size="1" maxlength="2"></div></td>

  </tr>

<?php 

if ($_POST['cantidad'] <> "")

 { ?>

   <tr bgcolor="#C5D5D6" class="Estilo2">

		<td colspan="1" align="center" bgcolor="#C5D5D6">No.</td>

	    <td align="center" bgcolor="#C5D5D6">Nombre de Prueba</td>

	    <td colspan="1" align="center" bgcolor="#C5D5D6">Porcentaje</td>

		<td colspan="1" align="center" bgcolor="#C5D5D6">No. Preguntas</td>	 

		<td colspan="1" align="center" bgcolor="#C5D5D6">Tipo Admisión</td>	   

        <td colspan="1" align="center" bgcolor="#C5D5D6">Preselección</td>

   </tr>	

<?php	

	for ($i= 1; $i <= $_POST['cantidad'] ; $i++)

	 {

?>  

	  <tr class="Estilo1">

		<td colspan="1" align="center"  bgcolor='#FEF7ED'><?php echo $i;?></td>

	    <td align="center"  bgcolor='#FEF7ED'><input type="text" name="nombre<?php echo $i;?>" value="<?php echo $_POST['nombre'.$i];?>"></td>

	    <td align="center"  bgcolor='#FEF7ED'><input type="text" name="porcentaje<?php echo $i;?>" value="<?php echo $_POST['porcentaje'.$i];?>" size="1" maxlength="3">%</td>

	    <td align="center"  bgcolor='#FEF7ED'><input type="text" name="preguntas<?php echo $i;?>" value="<?php echo $_POST['preguntas'.$i];?>" size="1" maxlength="3"></td>

	    <td align="center"  bgcolor='#FEF7ED'>

		 <select name="tipoadmision<?php echo $i;?>">

            <option value="0"<?php if (!(strcmp($row_tipoadmision['codigotipodetalleadmision'], $_POST['tipoadmision'.$i]))) {echo "SELECTED";} ?>>Seleccionar</option>

<?php

          do {  

?>

            <option value="<?php echo $row_tipoadmision['codigotipodetalleadmision']?>"<?php if (!(strcmp($row_tipoadmision['codigotipodetalleadmision'], $_POST['tipoadmision'.$i]))) {echo "SELECTED";} ?>><?php echo $row_tipoadmision['nombretipodetalleadmision']?></option>

<?php

           } while ($row_tipoadmision = mysql_fetch_assoc($tipoadmision));

           $rows = mysql_num_rows($tipoadmision);

           if($rows > 0)

            {

              mysql_data_seek($tipoadmision, 0);

              $row_tipoadmision = mysql_fetch_assoc($tipoadmision);

            }

?>

        </select>

		</td>

	    <td align="center"  bgcolor='#FEF7ED'>

		<select name="preseleccion<?php echo $i;?>">

  <option value="0"<?php if (!(strcmp($row_preseleccion['codigorequierepreselecciondetalleadmision'], $_POST['preseleccion'.$i]))) {echo "SELECTED";} ?>>Sel.</option>

  <?php

          do {  

?>

  <option value="<?php echo $row_preseleccion['codigorequierepreselecciondetalleadmision']?>"<?php if (!(strcmp($row_preseleccion['codigorequierepreselecciondetalleadmision'], $_POST['preseleccion'.$i]))) {echo "SELECTED";} ?>><?php echo $row_preseleccion['nombrerequierepreselecciondetalleadmision']?></option>

  <?php

           } while ($row_preseleccion = mysql_fetch_assoc($preseleccion));

           $rows = mysql_num_rows($preseleccion);

           if($rows > 0)

            {

              mysql_data_seek($preseleccion, 0);

              $row_preseleccion = mysql_fetch_assoc($preseleccion);

            }

?>

</select>

		</td>

	  </tr>

<?php 

      }

  }

} // else     

?>    

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

$i = 1;

if (isset($_POST['grabado']) and $_POST['nombre'.$i] <> "")

 { // if 1		

	

	for ($i= 1; $i <= $_POST['cantidad'] ; $i++)

	 { // for	

		

		if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombre'.$i]) or $_POST['nombre'.$i] == ""))

		  {			

			$banderagrabar = 1;

		  }	

	  } // for

		

	  if ($banderagrabar == 1)

	   {

	     echo '<script language="JavaScript">alert("Nombre de Prueba Incorrecto");

		       history.go(-1);</script>';

	   }	

	

	  $cuentaporcentaje = 0;

	  for ($i= 1; $i <= $_POST['cantidad'] ; $i++)

		{ // for	

			

		  if ((!eregi("^[0-9]{1,15}$", $_POST['porcentaje'.$i]) or $_POST['porcentaje'.$i] == ""))

			{			

			  $banderagrabar = 1;

			}	

		   

		   $cuentaporcentaje = $cuentaporcentaje + $_POST['porcentaje'.$i];

		   //echo $cuentaporcentaje,"<br>";

		 } // for

			

		if ($banderagrabar == 1 or $cuentaporcentaje > 100 or $cuentaporcentaje < 100)

		 {

		   echo '<script language="JavaScript">alert("El porcentaje se debe digitar en formato númerico y debe sumar el 100%");

		          history.go(-1);</script>';

		 }

		 

	 

	  for ($i= 1; $i <= $_POST['cantidad'] ; $i++)

		{ // for	

			

		  if ((!eregi("^[0-9]{1,15}$", $_POST['preguntas'.$i]) or $_POST['preguntas'.$i] == ""))

			{			

			  $banderagrabar = 1;

			}	

		 } // for

			

		if ($banderagrabar == 1)

		 {

		   echo '<script language="JavaScript">alert("Cantidad de Preguntas Incorrectas");

		         history.go(-1);</script>';

		 }	

	

	  

	  for ($i= 1; $i <= $_POST['cantidad'] ; $i++)

		{ // for	

			

		  if ($_POST['tipoadmision'.$i] == 0)

			{			

			  $banderagrabar = 1;

			}	

		 } // for

			

		if ($banderagrabar == 1)

		 {

		   echo '<script language="JavaScript">alert("Debe Seleccionar el tipo de admisión");

		         history.go(-1);</script>';

		 }	

	  

	 

	  for ($i= 1; $i <= $_POST['cantidad'] ; $i++)

		{ // for	

			

		  if ($_POST['preseleccion'.$i] == 0)

			{			

			  $banderagrabar = 1;

			}	

		 } // for

			

		if ($banderagrabar == 1)

		 {

		   echo '<script language="JavaScript">alert("Debe Seleccionar si requiere Preselección");

		         history.go(-1);</script>';

		 }	

	

	  if ($banderagrabar == 0)

		 {

			for ($i= 1; $i <= $_POST['cantidad'] ; $i++)

		      { // for	

				$query_detalleadmision = "INSERT INTO detalleadmision(idadmision,numeroprioridaddetalleadmision,nombredetalleadmision,porcentajedetalleadmision,totalpreguntasdetalleadmision,codigoestado,codigotipodetalleadmision,codigorequierepreselecciondetalleadmision) 

				VALUES('".$_POST['idadmision']."','$i', '".$_POST['nombre'.$i]."', '".$_POST['porcentaje'.$i]."','".$_POST['preguntas'.$i]."','100','".$_POST['tipoadmision'.$i]."','".$_POST['preseleccion'.$i]."')"; 

				$detalleadmision = mysql_db_query($database_sala,$query_detalleadmision) or die("$query_detalleadmision".mysql_error());

			  } // for	

				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=detalleadmision.php'>";			 

	      }

     

 }// if 1	

?>

</form>

<script language="javascript">

function recargar(dir)

{

	window.location.reload("detalleadmision.php"+dir);

	history.go();

}

</script>