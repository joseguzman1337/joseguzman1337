<?php require_once('../../../Connections/sala2.php'); 
 // session_start();
     session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-size: x-small;
	font-weight: bold;
}

.Estilo3 {font-family: tahoma; font-weight: bold; }

.Estilo4 {font-family: tahoma; font-weight: bold; font-size: xx-small; }

.Estilo6 {font-family: tahoma; font-weight: bold; font-size: xx-small; color: #FF0000; }

-->

</style>



<html>

<head>

<title>.:Direccion:.</title>

<form name="Keypad" method="post" action="">

<?php

               mysql_select_db($database_sala, $sala);

			   $query_calle = "select CONCAT(nombreconvenciondireccion,'-',nombrecortoconvenciondireccion)  as nombre,nombreconvenciondireccion

			   from convenciondireccion

			   where codigotipoconvenciondireccion = 100

			   order by nombreconvenciondireccion";

	           $calle = mysql_query($query_calle, $sala) or die("$query_calle");

	           $totalRows_calle = mysql_num_rows($calle);

	           $row_calle = mysql_fetch_assoc($calle);	

			   

			   $query_interior = "select CONCAT(nombreconvenciondireccion,'-',nombrecortoconvenciondireccion)  as nombre,nombreconvenciondireccion

			   from convenciondireccion

			   where codigotipoconvenciondireccion = 200

			   order by nombreconvenciondireccion";

	           $interior = mysql_query($query_interior, $sala) or die("$query_interior");

	           $totalRows_interior = mysql_num_rows($interior);

	           $row_interior = mysql_fetch_assoc($interior);	

			   

			   $query_barrio = "select CONCAT(nombreconvenciondireccion,'-',nombrecortoconvenciondireccion)  as nombre,nombreconvenciondireccion

			   from convenciondireccion

			   where codigotipoconvenciondireccion = 300

			   order by nombreconvenciondireccion";

	           $barrio = mysql_query($query_barrio, $sala) or die("$query_barrio");

	           $totalRows_barrio = mysql_num_rows($barrio);

	           $row_barrio = mysql_fetch_assoc($barrio);

			   

			   $query_zona = "select CONCAT(nombreconvenciondireccion,'-',nombrecortoconvenciondireccion)  as nombre,nombreconvenciondireccion

			   from convenciondireccion

			   where codigotipoconvenciondireccion = 400

			   order by nombreconvenciondireccion";

	           $zona = mysql_query($query_zona, $sala) or die("$query_barrio");

	           $totalRows_zona = mysql_num_rows($zona);

	           $row_zona = mysql_fetch_assoc($zona);												

?>

    <div align="center" class="Estilo3 Estilo1">DIRECCIÓN</div>

	<br>

	<table width="100%" border="1" align="center">
  
	   <tr bgcolor="#C5D5D6">

	    <td width="23%"><div align="center" class="Estilo1">Abreviaturas iniciales <span class="Estilo6">*</span></div></td>

		<td width="29%"><div align="center" class="Estilo1">Abreviaturas finales</div></td>

	    <td width="32%"><div align="center" class="Estilo1">Nomenclatura Complementaria</div></td>

		<td width="16%"><div align="center" class="Estilo1">Abreviaturas de Zonas</div></td>

	   </tr>

	    <tr bgcolor="#C5D5D6">

	    <td colspan="4"><div align="center" class="Estilo1">

	      <p>La direcci&oacute;n debe ser digitada sin espacios ni caracteres especiales eje: TRANSVERSAL 9aBIS 132 55 <br>

	      ensegida debe seleccionar si es APARTAMENTO,INTERIOR ,CASA, ETC.</p>

	    </div></td>

	   </tr>

	  <tr bgcolor='#FEF7ED'>	

		<td>

		  <div align="center">

            <select name="calle" style="font-size:9px">

                   <option value="" <?php if (!(strcmp(0, $_POST['calle']))) {echo "SELECTED";} ?>>Seleccionar</option>

                   <?php

             do 

			  {  

				?>

                   <option value="<?php echo $row_calle['nombre']?>"<?php if (!(strcmp($row_calle['nombre'], $_POST['calle']))) {echo "SELECTED";} ?>><?php echo $row_calle['nombreconvenciondireccion']?></option>

                   <?php

				} while ($row_calle = mysql_fetch_assoc($calle));

				$rows = mysql_num_rows($calle);

					if($rows > 0) 

					{

						mysql_data_seek($calle, 0);

						$row_calle = mysql_fetch_assoc($calle);

					}

				?>

            </select>

                        

             <input name="direccion" type="text" id="direccion" value="<?php echo  $_POST['direccion'];?>" size="15" maxlength="50" style="font-size:9px">            

          </div></td> 

		<td>

		  <div align="center"><br>

              <select name="interiorr" style="font-size:9px" onChange="enviar()">

                  <option value="" <?php if (!(strcmp(0, $_POST['interiorr']))) {echo "SELECTED";} ?>>Seleccionar</option>

                  <?php

             do 

			  {  

				?>

                  <option value="<?php echo $row_interior['nombre']?>"<?php if (!(strcmp($row_interior['nombre'], $_POST['interiorr']))) {echo "SELECTED";} ?>><?php echo $row_interior['nombreconvenciondireccion']?></option>

                  <?php

				} while ($row_interior = mysql_fetch_assoc($interior));

				$rows = mysql_num_rows($interior);

					if($rows > 0) 

					{

						mysql_data_seek($interior, 0);

						$row_interior = mysql_fetch_assoc($interior);

					}

				?>

              </select>

              &nbsp;

			  <input name="numerointerior" type="text" id="numerointerior"  size="15" maxlength="50" style="font-size:9px" value="">  

			  <br><br>

<?php

  if ($_POST['interiorr'] <> "")

   {

    $int=explode("-",$_POST['interiorr']);   

?> 

     <input name="numero" type="hidden" id="numero" value="<?php echo $int[1];?>" size="15" maxlength="50" style="font-size:9px">

	 <input name="numerolargo" type="hidden" id="numerolargo" value="<?php echo $int[0];?>" size="15" maxlength="50" style="font-size:9px">   				

<?php 

   }

  if ($_POST['numero'] <> "" and $_POST['numerointerior'] <> "")

   {
	 $interiorcompleto = $_POST['direccioninterior']." ".$_POST['numero']." ".$_POST['numerointerior'];	
	 $interiorcompletolargo = $_POST['direccioninteriorlarga']." ".$_POST['numerolargo']." ".$_POST['numerointerior'];
   }
  else
   {
    $interiorcompleto = $_POST['direccioninterior'];
	$interiorcompletolargo = $_POST['direccioninteriorlarga'];
   }

if ($_POST['numero'] <> "" and $_POST['numerointerior'] <> "" and $_POST['Submit'] == true) ////////////////////////////////////////////////////

   {	 

	 

	 $interiorcompleto = $_POST['direccioninterior']." ".$_POST['numero']." ".$_POST['numerointerior'];	 

	 $interiorcompletolargo = $_POST['direccioninteriorlarga']." ".$_POST['numerolargo']." ".$_POST['numerointerior'];

    /* echo $interiorcompleto,"<br>";

	 exit();*/

   }

if ($_POST['borra'])

 {

  $interiorcompleto = "";

  $interiorcompletolargo = "";

  $_POST['interiorr'] = "";

 }

?>

            <input name="direccioninterior" type="hidden" size="40" value="<?php echo $interiorcompleto;?>" style="font-size:9px">

            <input name="direccioninteriorlarga"  readonly type="text" size="40" value="<?php echo $interiorcompletolargo;?>" style="font-size:9px">

<?php 

if ($_POST['numero'] <> "" and $_POST['numerointerior'] <> "" and $_POST['Submit'] == true) ////////////////////////////////////////////////////

   {	 

	 //echo $_POST['direccioninterior']." ".$_POST['numero']." ".$_POST['numerointerior'],"pedasos<br>";	 

	 $interiorcompleto = $_POST['direccioninterior']." ".$_POST['numero']." ".$_POST['numerointerior'];	 

	 $interiorcompletolargo = $_POST['direccioninteriorlarga']." ".$_POST['numerolargo']." ".$_POST['numerointerior'];

    /* echo $interiorcompleto,"<br>";

	 exit();*/

   }

?>			

			<br> <br>

	        <!-- <input type="submit" name="ok" value="OK">  -->

	        &nbsp; 

	        <input type="submit" name="borra" value="Cancelar">

	      </div></td>

		  <td>		 

		    <div align="center">

              <select name="barrio" style="font-size:9px">

                 <option value="" <?php if (!(strcmp(0, $_POST['barrio']))) {echo "SELECTED";} ?>>Seleccionar</option>

                 <?php

             do 

			  {  

				?>

                 <option value="<?php echo $row_barrio['nombre']?>"<?php if (!(strcmp($row_barrio['nombre'], $_POST['barrio']))) {echo "SELECTED";} ?>><?php echo $row_barrio['nombreconvenciondireccion']?></option>

                 <?php

				} while ($row_barrio = mysql_fetch_assoc($barrio));

				$rows = mysql_num_rows($barrio);

					if($rows > 0) 

					{

						mysql_data_seek($barrio, 0);

						$row_barrio = mysql_fetch_assoc($barrio);

					}

				?>

              </select>

                

		      <input name="barrio1" type="text" id="barrio1" value="<?php echo  $_POST['barrio1'];?>" size="15" maxlength="50" style="font-size:9px">

		   

		    </div></td> 

		  <td> 

			  <div align="center">

			    <select name="zona" style="font-size:9px">

                  <option value="" <?php if (!(strcmp(0, $_POST['zona']))) {echo "SELECTED";} ?>>Seleccionar</option>

                  <?php

             do 

			  {  

				?>

                  <option value="<?php echo $row_zona['nombre']?>"<?php if (!(strcmp($row_zona['nombre'], $_POST['zona']))) {echo "SELECTED";} ?>><?php echo $row_zona['nombreconvenciondireccion']?></option>

                  <?php

				} while ($row_zona = mysql_fetch_assoc($zona));

				$rows = mysql_num_rows($zona);

					if($rows > 0) 

					{

						mysql_data_seek($zona, 0);

						$row_zona = mysql_fetch_assoc($zona);

					}

				?>

                </select>		

	            </div></td> 

	  </tr>

</table>

<?php 

if ($_POST['Submit'])

 {

   $dir = "^[a-z|0-9]+"

          ." "

		  ."[a-z|0-9]+"

		  ." "

		  ."[0-9]" 		  

		  ."{1,20}$"; 

				 
      $banderaguardar = 0;
	  if (!eregi($dir,$_POST['direccion']) or $_POST['calle'] == "")

	   {

	     echo '<script language="JavaScript">alert("En la abreviatura inicial solo debe digitar los números separados por espacios no utilice (No. , # , - , ni ningun otro caracter.) ");</script>';				   
         $banderaguardar = 1;
	   }

	  else

	   { 		 

		 $cll=explode("-",$_POST['calle']); 

		 $bar=explode("-",$_POST['barrio']); 

		 $zon =explode("-",$_POST['zona']);		 

		   

		 $direccioncompleta = $cll[1]." ".$_POST['direccion']." ".$interiorcompleto." ".$bar[1]." ".$_POST['barrio1']." ".$zon[1];

	     $direccioncompleta = strtoupper($direccioncompleta);		  

		 

		 $direccioncompletalarga = $cll[0]." ".$_POST['direccion']." ".$interiorcompletolargo." ".$bar[0]." ".$_POST['barrio1']." ".$zon[0];

	     $direccioncompletalarga = strtoupper($direccioncompletalarga); 		

		 

		 //if (isset($_GET['preinscripcion']) or isset($_GET['inscripcion']) or isset($_POST['preinscripcion']) or isset($_POST['inscripcion']))

	if ($banderaguardar == 0)
	  { // if validar
   
		  if ($_GET['preinscripcion'] <> "" or $_GET['inscripcion'] <> "" or $_POST['preinscripcion'] <> "" or $_POST['inscripcion'] <> "")

		  { 

			 echo "<script language='javascript'>
		     window.opener.recargar('".$direccioncompleta."', '".$direccioncompletalarga."');
		     window.opener.focus();
		     window.close();
		     </script>"; 
		  }

		 else

		  if ($_GET['correo'] <> "" or $_POST['correo'] <> "")

		 {
             echo "<script language='javascript'>
		     window.opener.recargar1('".$direccioncompleta."', '".$direccioncompletalarga."');
		     window.opener.focus();
		     window.close();
		     </script>"; 

		 }
	  }// if validar
	}	

 }
?>	

<div align="center"><br>

    <input type="submit" name="Submit" value="Aceptar">

	<input name="preinscripcion" type="hidden" id="preinscripcion" value="<?php echo $_GET['preinscripcion'];?>" size="15" maxlength="50" style="font-size:9px">

	<input name="inscripcion" type="hidden" id="inscripcion" value="<?php echo $_GET['inscripcion'];?>" size="15" maxlength="50" style="font-size:9px">

    <input name="correo" type="hidden" id="correo" value="<?php echo $_GET['correo'];?>" size="15" maxlength="50" style="font-size:9px">

</div>

</form>

</head>

</html>

<script language="javascript">

function enviar()

	{

	 document.Keypad.submit();

	}

</script>