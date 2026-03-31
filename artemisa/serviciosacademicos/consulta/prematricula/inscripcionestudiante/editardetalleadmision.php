<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
      
require('../../../Connections/sala2.php'); 

@@session_start();

 $direccion = "detalleadmision.php"; 

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

<form name="inscripcion" method="post" action="">

<div align="center">

<p class="Estilo3">ADMISI&Oacute;N</p>

<?php       

		$query_datosgrabados = "select *

     					from detalleadmision d,tipodetalleadmision t,requierepreselecciondetalleadmision r

						where d.idadmision = '".$_GET['id']."'

						and d.codigotipodetalleadmision	= t.codigotipodetalleadmision		

						and d.codigorequierepreselecciondetalleadmision = r.codigorequierepreselecciondetalleadmision			    

						order by d.numeroprioridaddetalleadmision						    

								";			  

		//echo $query_datosgrabados; 

		$datosgrabados = mysql_query($query_datosgrabados, $sala) or die("$query_estudios".mysql_error());

		$totalRows_datosgrabados = mysql_num_rows($datosgrabados);

		$row_datosgrabados = mysql_fetch_assoc($datosgrabados);

?> 	

<table width="40%" border="0" align="center" cellpadding="3" bordercolor="#003333">

   <tr bgcolor="#C5D5D6" class="Estilo2">

		<td colspan="1" align="center" bgcolor="#C5D5D6">No.</td>

	    <td align="center" bgcolor="#C5D5D6">Nombre de Prueba </td>

	    <td colspan="1" align="center" bgcolor="#C5D5D6">Porcentaje</td>

		<td colspan="1" align="center" bgcolor="#C5D5D6">No. Preguntas</td>	 

		<td colspan="1" align="center" bgcolor="#C5D5D6">Tipo Admisión</td>	   

        <td colspan="1" align="center" bgcolor="#C5D5D6">Preselección</td>

   </tr>	

   <?php 

      $contador = 1;

	  unset($iddetalle);

	  do{

	      $iddetalle[$contador] = $row_datosgrabados['iddetalleadmision'];

    ?>

	  <tr class="Estilo1">

		<td colspan="1" align="center"  bgcolor='#FEF7ED'><?php echo $contador;?></td>

	    <td align="center"  bgcolor='#FEF7ED'><input type="text" name="nombre<?php echo $contador;?>" value="<?php echo $row_datosgrabados['nombredetalleadmision'];?>"></td>

	    <td align="center"  bgcolor='#FEF7ED'><input type="text" name="porcentaje<?php echo $contador;?>" value="<?php echo $row_datosgrabados['porcentajedetalleadmision'];?>" size="1" maxlength="3">%</td>

	    <td align="center"  bgcolor='#FEF7ED'><input type="text" name="preguntas<?php echo $contador;?>" value="<?php echo $row_datosgrabados['totalpreguntasdetalleadmision'];?>" size="1" maxlength="3"></td>

	    <td align="center"  bgcolor='#FEF7ED'>

		 <select name="tipoadmision<?php echo $contador;?>">

            <option value="0"<?php if (!(strcmp($row_tipoadmision['codigotipodetalleadmision'], $row_datosgrabados['codigotipodetalleadmision']))) {echo "SELECTED";} ?>>Seleccionar</option>

<?php

          do {  

?>

            <option value="<?php echo $row_tipoadmision['codigotipodetalleadmision']?>"<?php if (!(strcmp($row_tipoadmision['codigotipodetalleadmision'],$row_datosgrabados['codigotipodetalleadmision']))) {echo "SELECTED";} ?>><?php echo $row_tipoadmision['nombretipodetalleadmision']?></option>

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

		<select name="preseleccion<?php echo $contador;?>">

  <option value="0"<?php if (!(strcmp($row_preseleccion['codigorequierepreselecciondetalleadmision'],$row_datosgrabados['codigorequierepreselecciondetalleadmision']))) {echo "SELECTED";} ?>>Sel.</option>

  <?php

          do {  

?>

  <option value="<?php echo $row_preseleccion['codigorequierepreselecciondetalleadmision']?>"<?php if (!(strcmp($row_preseleccion['codigorequierepreselecciondetalleadmision'],$row_datosgrabados['codigorequierepreselecciondetalleadmision']))) {echo "SELECTED";} ?>><?php echo $row_preseleccion['nombrerequierepreselecciondetalleadmision']?></option>

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

          $contador++;

		 }while($row_datosgrabados = mysql_fetch_assoc($datosgrabados));

?>  

</table>

<br>

<script language="javascript">

function grabar()

 {

  document.inscripcion.submit();

 }

</script>



   <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>

   <input type="hidden" name="grabado" value="grabado"> 

    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">   

</div>

<?php

$i = 1;

if (isset($_POST['grabado']) and $_POST['nombre'.$i] <> "")

 { // if 1		

	

	for ($i= 1; $i < $contador ; $i++)

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

	  for ($i= 1; $i < $contador ; $i++)

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

		 

	 

	  for ($i= 1; $i < $contador ; $i++)

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

	

	  

	  for ($i= 1; $i < $contador ; $i++)

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

	  

	 

	  for ($i= 1; $i < $contador ; $i++)

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

			for ($i= 1; $i < 3 ; $i++)

		      { // for	

				$query_detalleadmision = "update detalleadmision

				set nombredetalleadmision = '".$_POST['nombre'.$i]."',

				porcentajedetalleadmision = '".$_POST['porcentaje'.$i]."' ,

				totalpreguntasdetalleadmision = '".$_POST['preguntas'.$i]."',				

				codigotipodetalleadmision = '".$_POST['tipoadmision'.$i]."',

				codigorequierepreselecciondetalleadmision = '".$_POST['preseleccion'.$i]."'

				WHERE iddetalleadmision = ' $iddetalle[$i]'";

				echo $query_detalleadmision,"<br>";

				$detalleadmision = mysql_db_query($database_sala,$query_detalleadmision) or die("$query_detalleadmision".mysql_error());

			  } // for				

			echo "<script language='javascript'>

			window.opener.recargar('".$direccion."');

			window.opener.focus();

			window.close();

		    </script>"; 	 	 

	      }

     

 }// if 1	

?>

</form>	   