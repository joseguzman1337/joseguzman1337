<?php
   session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
 require_once('../../../Connections/sala2.php');

@session_start();
$carrera = $_SESSION['codigofacultad'];
mysql_select_db($database_sala, $sala);


$query_sel_seguimiento_carrera= "SELECT * FROM seguimientoacademico WHERE codigocarrera = '$carrera' and codigoestado like '1%'";
//$query_sel_seguimiento_carrera= "SELECT * FROM carrera WHERE codigocarrera = '$carrera'";
$sel_seguimiento_carrera = mysql_query($query_sel_seguimiento_carrera, $sala) or die(mysql_error());
$row_sel_seguimiento_carrera = mysql_fetch_assoc($sel_seguimiento_carrera);
$totalRows_sel_seguimiento_carrera = mysql_num_rows($sel_seguimiento_carrera);

//Se oculta las siguientes lineas de codigo para que se muestre la seleccion de periodos para la consulta de boletines.

/*if (! $row_sel_seguimiento_carrera)
{
    if ($_GET['busqueda_codigo'] <> "")
    {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultarboletinesformulario.php?busqueda_codigo=".$_GET['busqueda_codigo']."&periodo=".$_GET['periodo']."&tipodetalleseguimiento=".$_GET['tipodetalleseguimiento']."&busqueda_semestre=".$_GET['busqueda_semestre']."'>";
    }
    else
    {
        if ($_GET['busqueda_semestre'] <> "")
        {
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultarboletinesmasivo.php?busqueda_codigo=".$_GET['busqueda_codigo']."&periodo=".$_GET['periodo']."&tipodetalleseguimiento=".$_GET['tipodetalleseguimiento']."&busqueda_semestre=".$_GET['busqueda_semestre']."'>";
        }
    }
    exit();
}*/


$query_sel_seguimiento= "SELECT * FROM tipodetalleseguimiento tdsa WHERE tdsa.codigoestado LIKE '1%'";
$sel_seguimiento = mysql_query($query_sel_seguimiento, $sala) or die(mysql_error());
$row_sel_seguimiento = mysql_fetch_assoc($sel_seguimiento);
$totalRows_sel_seguimiento = mysql_num_rows($sel_seguimiento);

$query_sel_periodo="SELECT distinct codigoperiodo,nombreperiodo FROM periodo ORDER BY 1 DESC";
$sel_periodo=mysql_query($query_sel_periodo, $sala) or die(mysql_error());
$row_sel_periodo=mysql_fetch_assoc($sel_periodo);
$totalRows_sel_periodo=mysql_num_rows($sel_periodo);

?>

<style type="text/css">

<!--

.Estilo1 {font-family: Tahoma; font-size: 12px}

.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }

.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }

.Estilo4 {color: #FF6600}

-->

</style>

 

<form name="form1" method="get" action="seleccion_certificado.php">

<p align="center"><span class="Estilo1"><STRONG>BOLETIN DE CALIFICACI&Oacute;NES</STRONG> </span></p>

<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">

 

  <tr class="Estilo2">

    <td bgcolor="#C5D5D6"><div align="center">Tipo de Seguimiento </div></td>

    <td><div align="center" class="Estilo1"> 

	     <select name="tipodetalleseguimiento" id="tipodetalleseguimiento"  onChange="enviar()">

			   <option value="">Seleccionar</option>

<?php

                  do {

?>

                  <option value="<?php echo $row_sel_seguimiento['codigotipodetalleseguimiento']?>"<?php if(isset($_GET['tipodetalleseguimiento'])){if($_GET['tipodetalleseguimiento'] == $row_sel_seguimiento['codigotipodetalleseguimiento']){echo "selected";}}?>><?php echo $row_sel_seguimiento['nombretipodetalleseguimiento']?></option>

<?php

                  } while ($row_sel_seguimiento = mysql_fetch_assoc($sel_seguimiento));

                  $rows = mysql_num_rows($sel_seguimiento);

                  if($rows > 0) {

                 	mysql_data_seek($sel_seguimiento, 0);

                  	$row_sel_seguimiento = mysql_fetch_assoc($sel_seguimiento);

                  }

?>

              </select>	

	</div></td>

  </tr>

<?php 

   if($_GET['tipodetalleseguimiento'] == 100)

    { 

?> 

      <tr bgcolor="#C5D5D6" class="Estilo2"> 	

       <td bgcolor="#C5D5D6"><div align="center">Periodo</div></td>

       <td><div align="center" class="Estilo1"> 

	     <select name="periodo" id="periodo">

			   <option value="">Seleccionar</option>

<?php

                  do {

?>

                  <option value="<?php echo $row_sel_periodo['codigoperiodo']?>"<?php if(isset($_GET['periodo'])){if($_GET['periodo'] == $row_sel_periodo['codigoperiodo']){echo "selected";}}?>><?php echo $row_sel_periodo['nombreperiodo']?></option>

<?php

                  } while ($row_sel_periodo = mysql_fetch_assoc($sel_periodo));

                  $rows = mysql_num_rows($sel_periodo);

                  if($rows > 0) {

                 	mysql_data_seek($sel_periodo, 0);

                  	$row_sel_periodo = mysql_fetch_assoc($sel_periodo);

                  }

?>

              </select>	

	     </div></td>

  

     </tr>

<?php 

     }

?>

</table>

<p align="center">

  <input type="hidden" name="busqueda_codigo" value="<?php echo $_GET['busqueda_codigo'];?>">

  <input type="hidden" name=" busqueda_semestre" value="<?php echo $_GET['busqueda_semestre'];?>">

 

  <input type="submit" name="Submit" value="Continuar">

 <?php 

   if ($_GET['Submit'])

    {

	   if ($_GET['tipodetalleseguimiento'] == 100 and $_GET['periodo'] == "")

	    {

		  echo '<script language="JavaScript">alert("Debe Seleccionar un Periodo");</script>';

		}

	  else

	   {

	     if ($_GET['busqueda_codigo'] <> "")

         {

		   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultarboletinesformulario.php?busqueda_codigo=".$_GET['busqueda_codigo']."&periodo=".$_GET['periodo']."&tipodetalleseguimiento=".$_GET['tipodetalleseguimiento']."&busqueda_semestre=".$_GET['busqueda_semestre']."'>";

	     }

		else

		if ($_GET['busqueda_semestre'] <> "")

		 {

		   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultarboletinesmasivo.php?busqueda_codigo=".$_GET['busqueda_codigo']."&periodo=".$_GET['periodo']."&tipodetalleseguimiento=".$_GET['tipodetalleseguimiento']."&busqueda_semestre=".$_GET['busqueda_semestre']."'>";

		 }

	   }

	}

 

 ?>

 

 </form>

<script language="javascript">

function enviar()

{

	document.form1.submit()

}

</script>

<style type="text/css">

