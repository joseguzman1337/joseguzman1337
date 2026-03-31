<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);  
      
require('../../../Connections/sala2.php'); 

@@session_start();

 $direccion = "admision.php"; 

 mysql_select_db($database_sala, $sala);

 $query_periodo = "select codigoperiodo from periodo order by 1 desc";

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

<form name="inscripcion" method="post" action="">

<div align="center">

<p class="Estilo3">ADMISI&Oacute;N</p>

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

<table width="40%" border="0" align="center" cellpadding="3" bordercolor="#003333">

  <tr>

    <td width="201" align="center" bgcolor="#C5D5D6" class="Estilo2">Nombre Inscripci&oacute;n <span class="Estilo4">*</span></td>

    <td align="center" bgcolor='#FEF7ED' class="Estilo1"><input type="text" name="nombre" value="<?php if (isset($row_datosgrabados['nombreadmision'])) echo $row_datosgrabados['nombreadmision']; else echo $_POST['nombre'];?>" size="40"></td>

  </tr>

   <tr>

    <td width="201" align="center" bgcolor="#C5D5D6" class="Estilo2">Cantidad de seleccionados <span class="Estilo4">*</span></td>

    <td width="212" align="left" bgcolor='#FEF7ED' class="Estilo1">

	    <input type="text" name="cantidad" value="<?php if (isset($row_datosgrabados['cantidadseleccionadoadmision'])) echo $row_datosgrabados['cantidadseleccionadoadmision']; else echo $_POST['cantidad'];?>" size="1" maxlength="3">

	 </td>

  </tr>

  <tr>

    <td width="201" align="center" bgcolor="#C5D5D6" class="Estilo2">Periodo Inscripci&oacute;n <span class="Estilo4">*</span></td>

    <td width="212" align="left" bgcolor='#FEF7ED' class="Estilo1">

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

    </td>

  </tr>

</table>

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