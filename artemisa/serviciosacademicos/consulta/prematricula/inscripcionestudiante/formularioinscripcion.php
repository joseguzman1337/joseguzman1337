<?php

     
require_once('../../../Connections/sala2.php');?>
<form name="inscripcion" method="post" action="">
<div align="center" class="style1">
<p>FORMULARIO DE INSCRIPCIÓN</p>
</div><br>
<table width="70%" border="0" align="center">
  <tr>
    <td>
	<?php 
	   require('datosbasicos.php');
	   require('estudiosrealizados.php');
	   echo "<br>";
	   require('experiencia.php');
	   echo "<br>";
	   require('carreraspreferencia.php');
	   echo "<br>";
	   require('decisionuniversidad.php');
	   echo "<br>";
	   require('datosfamiliares.php');
	   echo "<br>";
	   require('idiomas.php');
	   echo "<br>";
	   require('mediocomunicacion.php');
	   echo "<br>";
	   require('recursofinanciero.php');
	   echo "<br>";
	   require('otrasuniversidades.php');
	?>
	</td>
  
  </tr>
</table>       

</form>     