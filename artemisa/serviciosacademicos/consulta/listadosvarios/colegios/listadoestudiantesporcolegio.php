<?php require_once('../../../Connections/sala2.php');


mysql_select_db($database_sala, $sala);
$query_periodo = "SELECT *
					 from periodo
					 where codigoestadoperiodo = '1'";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

mysql_select_db($database_sala, $sala);
$query_Recordset1 = "SELECT DISTINCT departamentoinstitucioneducativa
					 from institucioneducativa
					 order by 1";
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-family: tahoma; font-size: xx-small; }
.Estilo4 {font-size: x-small}
-->
</style>

<form name="form1" method="post" action="">
  <p align="center" class="Estilo1"><strong>LISTADO DE ESTUDIANTES MATRICULADOS POR DEPARTAMENTO<br>
    <span class="Estilo4"><?php echo $row_periodo['codigoperiodo'];?></span></strong></p>
  <p align="center" class="Estilo1">&nbsp;</p>
  <p align="center" class="Estilo1">
<script language="javascript">
function enviar()
 {
	document.form1.submit();
 }
</script>
<select name="departamento" id="departamento" onChange="enviar()">
<option value="" selected>Seleccionar Departamento</option>
<?php
do {  
?>
          <option value="<?php echo $row_Recordset1['departamentoinstitucioneducativa']?>"<?php if (!(strcmp($row_Recordset1['departamentoinstitucioneducativa'], $_POST['departamento']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['departamentoinstitucioneducativa']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
  </p>
  <p align="center" class="Estilo1">&nbsp; </p>
  <span class="Estilo1">
  <?php   
if ($_POST['departamento'] <> "")
 {
    mysql_select_db($database_sala, $sala);
	$query_colegio = "SELECT * from institucioneducativa
					  where municipioinstitucioneducativa = '".$_POST['departamento']."'";
	$colegio = mysql_query($query_colegio, $sala) or die(mysql_error());
	$row_colegio = mysql_fetch_assoc($colegio);
	$totalRows_colegio = mysql_num_rows($colegio);
?>
  </span>    
<?php 
      mysql_select_db($database_sala, $sala);
	$query_estudiante = "SELECT DISTINCT eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,eg.numerodocumento,c.nombrecarrera,p.semestreprematricula,
	                     i.nombreinstitucioneducativa,municipioinstitucioneducativa
	                     FROM institucioneducativa i,institucioneducativaestudiante ie,estudiante e,prematricula p,carrera c,ordenpago o,estudiantegeneral eg
					     WHERE i.idinstitucioneducativa = ie.idinstitucioneducativa
						 AND e.codigocarrera = c.codigocarrera
						 AND ie.codigoestudiante = e.codigoestudiante 
						 AND p.codigoestudiante = e.codigoestudiante
						 AND e.idestudiantegeneral = eg.idestudiantegeneral
						 AND o.idprematricula = p.idprematricula
						 AND o.codigoestadoordenpago LIKE '4%'
						 AND p.codigoestadoprematricula LIKE '4%'
						 AND o.codigoperiodo = '".$row_periodo['codigoperiodo']."'
						 AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'
						 ORDER BY c.nombrecarrera,eg.apellidosestudiantegeneral,p.semestreprematricula  
						 ";	
	$estudiante = mysql_query($query_estudiante, $sala) or die(mysql_error());
	$row_estudiante = mysql_fetch_assoc($estudiante);
	$totalRows_estudiante = mysql_num_rows($estudiante);
 if ($row_estudiante <> "")
  {
      echo "<div align='center'><strong>Se encontraron&nbsp;",$totalRows_estudiante,"&nbsp;Registros</strong></div>"; 

?> <br>  <br>
    <table width="70%"  border="1" align="center" cellpadding="1" bordercolor="#003333">
    <tr bgcolor="#C6CFD0">
      <td class="Estilo2"><div align="center"><strong>Documento</strong></div></td>
      <td class="Estilo2"><div align="center"><strong>Nombres</strong></div></td>
      <td class="Estilo2"><div align="center"><strong>Carrera</strong></div></td>
      <td class="Estilo2"><div align="center"><strong>Semestre</strong></div></td>
      <td class="Estilo2"><div align="center"><strong>Nombre Colegio </strong></div></td>
      <td class="Estilo2"><div align="center"><strong>Ciudad / Municipio</strong></div></td>      
    </tr>  
   
<?php   
   do{
?> <tr>
	  <td class="Estilo2"><div align="center"><?php echo $row_estudiante['numerodocumento'];?>&nbsp;</div></td>
      <td class="Estilo2"><div align="center"><?php echo $row_estudiante['apellidosestudiantegeneral'];?>&nbsp;<?php echo $row_estudiante['nombresestudiantegeneral'];?></div></td>
      <td class="Estilo2"><div align="center"><?php echo $row_estudiante['nombrecarrera'];?>&nbsp;</div></td>
      <td class="Estilo2"><div align="center"><?php echo $row_estudiante['semestreprematricula'];?>&nbsp;</div></td>
      <td class="Estilo2"><div align="center"><?php echo $row_estudiante['nombreinstitucioneducativa'];?>&nbsp;</div></td>
      <td class="Estilo2"><?php echo $row_estudiante['municipioinstitucioneducativa'];?>&nbsp;</td>
     </tr>
<?php 
   }while($row_estudiante = mysql_fetch_assoc($estudiante));
}
?>   
   
  </table>
<div align="center">
  <p>
    <input type="button" value="Imprimir" onClick="window.print()">
  </p>
</div>
<?php 
}
?> 

</form>

