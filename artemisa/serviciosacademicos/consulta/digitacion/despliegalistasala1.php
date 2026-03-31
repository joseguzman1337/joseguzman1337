<?php session_start();
require_once('../../funciones/clases/autenticacion/redirect.php' ); 
//require_once('Connections/sala.php');?>
<style type="text/css">
<!--
.Estilo2 {font-family: TAHOMA}
.Estilo4 {
	font-family: TAHOMA;
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
 <form name="form1" method="post" action="listassala.php">
<?php 
mysql_select_db($database_sala, $sala);
$query_estudiantes ="SELECT e.codigoestudiante,eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral
									FROM prematricula p,detalleprematricula d,estudiante e,estudiantegeneral eg
									WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
									and p.codigoestudiante = e.codigoestudiante
									AND p.idprematricula = d.idprematricula
									AND d.idgrupo = '".$_POST['grupo']."'
									AND p.codigoestadoprematricula LIKE '4%'
									AND d.codigoestadodetalleprematricula LIKE '3%'
									order by 4";
//echo $query_estudiantes;
$estudiantes = mysql_query($query_estudiantes,$sala) or die(mysql_error());
$row_estudiantes = mysql_fetch_assoc($estudiantes);
$totalRows_estudiantes = mysql_num_rows($estudiantes);
if ($row_estudiantes <> "")
{ 
?>
  </p>
  <div align="center">
   
    <style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: xx-small}
-->
  </style>
    <p align="center">LISTADO GRUPO ACAD&Eacute;MICO </p>
   </div>
  <table width="650"  border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
      <td  align="center" id="tdtitulogris">Materia</td>
      <td div align="center"><font size="2" face="Tahoma"><?php echo $_POST['nombremateria']; ?>--<?php echo $_POST['materia']; ?></font></td>
      <td  align="center" id="tdtitulogris">Fecha</td>
      <td align="center"><font size="2" face="Tahoma"><?php echo date("j/m/Y G:i:s",time());?></font></td>
    </tr>
    <tr>
      <td colspan="4" class="style5"><div align="right"></div>        
      
 <?php  
  	echo "<font size='1' face='Tahoma'><strong><a href='JavaScript:window.print()' id='aparencialinknaranja'>Imprimir</a></strong></span>";
 ?>
      </div></td>
    </tr>
  </table>
  <br>
  
  <table width="650" border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

      <tr>
        <td align="center" id="tdtitulogris">No.</td>
        <td align="center" id="tdtitulogris">Documento</td>
        <td align="center" id="tdtitulogris">Apellidos</td>
        <td align="center" id="tdtitulogris">Nombres</td>        
        <td colspan="10" align="center" id="tdtitulogris">Casillas de control</td>
      </tr>
	  
      <?php 
	  $j=1;
	  do { ?>
      <tr>
        <td align="center"><font size="1" face="Tahoma"><?php echo $j;?></font></td>
        <td align="left"><font size="1" face="Tahoma"><?php echo $row_estudiantes['numerodocumento']; ?></font></td>
        <td align="left"><font size="1" face="Tahoma"><?php echo $row_estudiantes['apellidosestudiantegeneral']; ?> </font></td>
        <td align="left"><font size="1" face="Tahoma"><?php echo $row_estudiantes['nombresestudiantegeneral']; ?></font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
        <td align="left"><font size="1" face="Tahoma">____</font></td>
      </tr>
      <?php
	  $j++;
	   } while ($row_estudiantes = mysql_fetch_assoc($estudiantes)); 
 
	   ?>
	  <tr>
        <td colspan="14" align="right"><font size="2" face="Tahoma">Responsable</font>&nbsp;<br>
          <br>
          <br>
          ___________________________________<br><font size="2" face="Tahoma"><?php echo $_POST['nombre'];?></span><br>        
        <?php //echo $_SESSION['codigodocente']; ?></span></td>
      </tr>     
  </table>
  <p><span class="style5"><br>
      <br>
      <br>
  
  </span><span class="style4"></span><span class="style1"><br>
  </span>
  <p>  
 
  <p align="center">
     
</body>
</html>
<?php
}
else
  { 
     echo '<script language="JavaScript">alert("No se produjo ningun resultado")</script>';			
     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listassala.php'>";
     exit();
  }

?>

 <div align="left"></div> 
 <div align="center"><span class="Estilo24 Estilo26 Estilo32 Estilo1 Estilo2">
   <input name="Regresar" type="submit" id="Regresar" value="Regresar">
   </span>
 </div>
 </form>
