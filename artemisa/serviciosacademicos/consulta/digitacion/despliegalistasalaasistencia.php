<?php session_start();

require_once('../../funciones/clases/autenticacion/redirect.php' ); 
//require_once('Connections/sala.php');?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->


@media print
{
	.noprint {display:none;}
}
</style>
 <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
        <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../../mgi/css/styleDatos.css" type="text/css" /> 
		<script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script> 
 <form name="form1" method="post" action="cusossala.php">
<?php 
mysql_select_db($database_sala, $sala);

$query_estudiantes ="SELECT e.codigoestudiante,eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,d.idgrupo
									FROM prematricula p
									INNER JOIN detalleprematricula d ON p.idprematricula = d.idprematricula
									INNER JOIN estudiante e ON p.codigoestudiante = e.codigoestudiante
									INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral 
									WHERE  d.idgrupo = '".$_POST['grupo']."'
									AND p.codigoestadoprematricula LIKE '4%'
									AND d.codigoestadodetalleprematricula LIKE '3%'
									order by 4,3";
//echo $query_estudiantes; die;
$estudiantes = mysql_query($query_estudiantes,$sala) or die(mysql_error());
$row_estudiantes = mysql_fetch_assoc($estudiantes);
$totalRows_estudiantes = mysql_num_rows($estudiantes);
if ($row_estudiantes <> "")
{ 
?>
 
  <div class="botones noprint" style="margin-left:100px;margin-top:10px;text-align:left;">
			<button class="buttons-menu" type="button" style="cursor:pointer;padding:5px 22px;height:auto;width:auto;" id="exportExcel">Exportar a Excel</button>
			<button class="buttons-menu" type="button" onclick="JavaScript:window.print();" >Imprimir Planilla</button>
	</div>
<div id="reporteGeneral">
  <div align="center">
   <p align="center">PLANILLA DE ASISTENCIA</p>
   </div>
  <table width="600"  border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
        <td colspan="14">Docente: <?php echo $_POST['nombre'];?></td>
    </tr>
    <tr align="center">
      <td id="tdtitulogris" colspan="8">Materia</td>
       <td id="tdtitulogris" colspan="6">Grupo</td>
    </tr>
    <tr class="Estilo1">
      <td align="center" class="Estilo1" colspan="8"><?php echo $_POST['nombremateria']; ?>--<?php echo $_POST['materia']; ?></td>
        <td align="center" class="Estilo1" colspan="6"><?php echo $row_estudiantes['idgrupo']; ?></td>
    </tr>
    <!--<tr>
      <td colspan="4" class="style5"><div align="right"></div>        
      
 <?php  
  	//echo "<span class='Estilo2'><a href='JavaScript:window.print()' id='aparencialinknaranja'>Imprimir</a></span>";
 ?>
      </td>
    </tr>-->
  </table>
  <br>
  
  <table width="1100" border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
      <tr align="center">
        <td id="tdtitulogris" colspan="2">&nbsp;&nbsp;</td>
        <td id="tdtitulogris" colspan="12">SESI&Oacute;N</td>
        
      </tr>
      <tr align="center">
        <td id="tdtitulogris" width="30">No</td>
        <td id="tdtitulogris" width="320" height="30">Nombres</td>
        <td id="tdtitulogris" width="70" height="30">1</td>
        <td id="tdtitulogris" width="70" height="30">2</td>
        <td id="tdtitulogris" width="70" height="30">3</td>
        <td id="tdtitulogris" width="70" height="30">4</td>
        <td id="tdtitulogris" width="70" height="30">5</td>
        <td id="tdtitulogris" width="70" height="30">6</td>
        <td id="tdtitulogris" width="70" height="30">7</td>
        <td id="tdtitulogris" width="70" height="30">8</td>
        <td id="tdtitulogris" width="70" height="30">9</td>
        <td id="tdtitulogris" width="70" height="30">10</td>
        <td id="tdtitulogris" width="70" height="30">11</td>
        <td id="tdtitulogris" width="70" height="30">12</td>
      </tr>
	  
      <?php 
	  $j=1;
	  do { ?>
      <tr>
        <td align="center" class="Estilo1"><?php echo $j;?></td>
		<td align="left" valign="middle" class="Estilo1"><?php echo $row_estudiantes['apellidosestudiantegeneral']." ".$row_estudiantes['nombresestudiantegeneral']; ?> </td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
          <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
        <td align="left" valign="middle" class="Estilo1">&nbsp;&nbsp;</td>
      </tr>
      <?php
	  $j++;
	   } while ($row_estudiantes = mysql_fetch_assoc($estudiantes)); 
 
	   ?>
	  <tr>
        <td colspan="14" align="center" valign="middle"><font size="2" face="Tahoma">Responsable&nbsp;<br>
          <br>
          <br>
          ___________________________________<br><font size="2" face="Tahoma"><?php echo $_POST['nombre'];?></span><br>        
        <?php //echo $_SESSION['codigodocente']; ?></span></td>
       
      </tr>     
  </table>
  <p>
  </div>
  <p align="center">
     
</body>
</html>
<?php
}else
  { 
     echo '<script language="JavaScript">alert("No se produjo ningun resultado")</script>';			
     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listassala.php'>";
     exit();
  }
session_unregister('materias');
session_unregister('periodos');
session_unregister('grupos');
session_unregister('facultades');
?>

 <div align="left"></div> 
 <div align="center"><span class="Estilo24 Estilo26 Estilo32 Estilo1 Estilo2">
  <input type="button" value="Regresar" name="Regresar" style="color: #333;background:transparent;
	background-color: #eee;
	text-transform: uppercase;
	letter-spacing: 2px;
	font-size: 10px;
	padding: 8px 26px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border: 1px solid rgba(0,0,0,0.3);
	border-bottom-width: 3px;
		border-color: rgba(0,0,0,0.9);" onclick="window.location.href='listassala.php'">
   </span>
 </div>
 </form>
 
		  <form id="formInforme" style="z-index: -1; width:100%" method="post" action="../../utilidades/imprimirReporteExcel.php">
			<input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
		</form>
  
<script type="text/javascript">
$(document).ready(function () { 
	
	$('#exportExcel').click(function(e){
        $("#datos_a_enviar").val( $("<div>").append( $("#reporteGeneral").eq(0).clone()).html());
        $("#formInforme").submit();
	});
});

</script>
