<?php require_once('../../../Connections/sala2.php');
  //@session_start();
  mysql_select_db($database_sala, $sala);
  $query_periodo = "SELECT * FROM periodo
  where codigoestadoperiodo = 1";
  $periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
  $row_periodo= mysql_fetch_assoc($periodo);
  $totalRows_periodo = mysql_num_rows($periodo); 
  
  $periodo =  $row_periodo['codigoperiodo'];
 
  $query_matriculados = "SELECT DISTINCT  e.codigocarrera,nombrecarrera,concat(apellidosestudiantegeneral,' ',nombresestudiantegeneral) AS nombre,
  telefonoresidenciaestudiantegeneral,emailestudiantegeneral,semestreprematricula,eg.idestudiantegeneral
  FROM estudiante e, ordenpago o, detalleordenpago do,carrera c,estudiantegeneral eg,prematricula p
  WHERE e.codigoestudiante = o.codigoestudiante
  AND eg.idestudiantegeneral = e.idestudiantegeneral		
  AND p.codigoestudiante = o.codigoestudiante
  AND p.idprematricula = o.idprematricula
  AND c.codigocarrera = e.codigocarrera
  AND c.codigomodalidadacademica = 200
  AND o.codigoestadoordenpago LIKE '4%'	
  AND p.codigoestadoprematricula LIKE '4%'	
  AND o.codigoperiodo = '$periodo'
  AND do.codigoconcepto = '151'
  AND do.numeroordenpago = o.numeroordenpago
  ORDER BY 1,3";
  $matriculados = mysql_query($query_matriculados, $sala) or die(mysql_error());
  $row_matriculados= mysql_fetch_assoc($matriculados);
  $totalRows_matriculados = mysql_num_rows($matriculados); 
 ?>
<style type="text/css">
<!--
.Estilo3 {font-family: tahoma; font-size: xx-small; }
-->
</style>

 <table border="1" >
  <tr>
  <td><span class="Estilo3">Nombre </span></td>
  <td><span class="Estilo3">Colegio dónde termino el bachillerato </span></td>
  <td><span class="Estilo3">Ciudad dónde termino el colegio </span></td>
  <td><span class="Estilo3">Carrera</span></td>
  <td><span class="Estilo3">Semestre</span></td>
  <td><span class="Estilo3">Telefóno</span></td>
  <td><span class="Estilo3">Correo electrónico</span></td>   
 </tr>
 <?php
  do{
  
	  $query_institucion = "SELECT e.idinstitucioneducativa,nombreinstitucioneducativa,ciudadinstitucioneducativa,otrainstitucioneducativaestudianteestudio
	  FROM estudianteestudio e,institucioneducativa i
	  where idestudiantegeneral = '".$row_matriculados['idestudiantegeneral']."'
	  and e.idinstitucioneducativa = i.idinstitucioneducativa
	  and idniveleducacion = '2'
	  and codigoestado like '1%'";
	  $institucion = mysql_query($query_institucion, $sala) or die(mysql_error());
	  $row_institucion= mysql_fetch_assoc($institucion);
	  $totalRows_institucion = mysql_num_rows($institucion); 

      if ($row_institucion['idinstitucioneducativa'] == 1)
	   {	     
		 $row_institucion['nombreinstitucioneducativa'] = $row_institucion['otrainstitucioneducativaestudianteestudio'];
	   }
?> 
<tr>
  <td><span class="Estilo3"><?php echo $row_matriculados['nombre']; ?> </span>&nbsp;</td>
  <td><span class="Estilo3"><?php echo $row_institucion['nombreinstitucioneducativa']; ?> </span>&nbsp;</td>
  <td><span class="Estilo3"><?php echo $row_institucion['ciudadinstitucioneducativa']; ?> </span>&nbsp;</td>
  <td><span class="Estilo3"><?php echo $row_matriculados['nombrecarrera']; ?></span>&nbsp;</td>
  <td><span class="Estilo3"><?php echo $row_matriculados['semestreprematricula']; ?></span>&nbsp;</td>
  <td><span class="Estilo3"><?php echo $row_matriculados['telefonoresidenciaestudiantegeneral']; ?></span>&nbsp;</td>
  <td><span class="Estilo3"><?php echo $row_matriculados['emailestudiantegeneral']; ?></span>&nbsp;</td>   
 </tr>



<?php  
  }while ($row_matriculados= mysql_fetch_assoc($matriculados));
?>
</table>
