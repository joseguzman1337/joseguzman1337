<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
      
require('../../../Connections/sala2.php'); 



mysql_select_db($database_sala, $sala);	

$query_formularios = "SELECT *

FROM inscripcionmodulo im

WHERE idinscripcionmodulo = '".$_GET['id']."'";

$formularios = mysql_query($query_formularios, $sala) or die("$query_selgenero");

$totalRows_formularios = mysql_num_rows($formularios);

$row_formularios = mysql_fetch_assoc($formularios);

?>

<style type="text/css">

<!--

.Estilo1 {font-family: Tahoma; font-size: 12px}

.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}

.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}

.Estilo4 {color: #FF0000}

-->

</style>

<title>.:AYUDA:.</title>

<table width="80%" border="0" align="center" bordercolor="#003333" cellpadding="0" cellspacing="0">

 <tr>

  <td bgcolor='#FEF7ED' class="Estilo1">	

     <div align="justify">

	   <?php echo $row_formularios['descripcioninscripcionmodulo'];?>

    </div></td>

 </tr>

</table>