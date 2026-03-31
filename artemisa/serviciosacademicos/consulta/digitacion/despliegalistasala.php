<?php session_start();
//require_once('Connections/sala.php');
require_once('../../funciones/clases/autenticacion/redirect.php' ); 
?>
<style type="text/css">
<!--
.Estilo2 {font-family: TAHOMA}
.Estilo4 {
	font-family: TAHOMA;
	font-size: 14px;
	font-weight: bold;
}
.Estilo5 {font-size: xx-small}
.Estilo6 {font-size: 12px}
-->
</style>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<form name="form1" method="post" action="listassala.php">
<?php 

mysql_select_db($database_sala, $sala);
$query_estudiantes ="SELECT
e.codigoestudiante,eg.numerodocumento,eg.nombresestudiantegeneral,
eg.apellidosestudiantegeneral,c.numerocorte,c.porcentajecorte,
dn.nota,c.fechafinalcorte,c.fechainicialcorte,dn.numerofallasteoria,
dn.numerofallaspractica,n.actividadesacademicasteoricanota,
n.actividadesacademicaspracticanota
FROM estudiante e,corte c,detallenota dn,estudiantegeneral eg,nota n
WHERE e.idestudiantegeneral = eg.idestudiantegeneral
AND dn.codigoestudiante = e.codigoestudiante	
AND dn.idgrupo = n.idgrupo
AND dn.idcorte = n.idcorte								
AND c.idcorte = dn.idcorte
AND c.idcorte = '".$_POST['corte']."'
AND dn.idgrupo ='".$_POST['grupo']."'							
ORDER BY 4";
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
    <p align="center">LISTADO GRUPO ACAD&Eacute;MICO</p>
  </div>
  <table width="600"  border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
      <td align="center" id="tdtitulogris">Materia</td>
      <td align="center" id="tdtitulogris"><strong>Porcentaje</td>
      <td align="center" id="tdtitulogris"><strong>Corte</td>
      <td align="center" id="tdtitulogris"><strong>Fecha</td>
    </tr>
    <tr>
      <td align="center"><font size="1" face="Tahoma"><?php echo $_POST['nombremateria']; ?>--<?php echo $_POST['materia']; ?></font></td>
      <td align="center"><font size="1" face="Tahoma"><?php echo $row_estudiantes['porcentajecorte']; ?></font></td>
      <td align="center"><font size="1" face="Tahoma"><?php echo $row_estudiantes['numerocorte']; ?></font></td>
      <td align="center"><font size="1" face="Tahoma"><?php echo date("j/m/Y G:i:s",time());?></font></td>
    </tr>   
   <tr>
	  <td align="center" id="tdtitulogris"><font size="1" face="Tahoma">Actividades Teóricas Realizadas</font></td>
	  <td align="center"><font size="1" face="Tahoma"><?php echo $row_estudiantes['actividadesacademicasteoricanota']; ?></font></td>
	  <td align="center" id="tdtitulogris"><font size="1" face="Tahoma">Actividades Prácticas Realizadas</font></td>
	  <td align="center"><font size="1" face="Tahoma"><?php echo $row_estudiantes['actividadesacademicaspracticanota']; ?></font></td>
  </tr>  
    <tr>
      <td colspan="4" class="style5"><div align="right"></div>        
      
 <?php  
  	echo "<font size='1' face='Tahoma'><strong><a href='JavaScript:window.print()' id='aparencialinknaranja'>Imprimir</a></strong></font>";
 ?>
      </div></td>   
  </table>
  <br>
  
  <table width="600" border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

      <tr>
        <td align="center" id="tdtitulogris">No.</td>
        <td align="center" id="tdtitulogris">Documento</td>
        <td align="center" id="tdtitulogris">Apellidos</td>
        <td align="center" id="tdtitulogris">Nombres</td>        
        <td align="center" id="tdtitulogris">Nota</td>
        <td align="center" id="tdtitulogris">FT</td>
        <td align="center" id="tdtitulogris">FP</td>
      </tr>
	  
      <?php 
	  $j=1;
	  do { ?>
      <tr>
        <td align="center"><font size="1" face="Tahoma"><?php echo $j;?></font></td>
        <td align="left"><font size="1" face="Tahoma"><?php echo $row_estudiantes['numerodocumento']; ?></font></td>
        <td align="left"><font size="1" face="Tahoma"><?php echo $row_estudiantes['apellidosestudiantegeneral']; ?> </font></td>
        <td align="left"><font size="1" face="Tahoma"><?php echo $row_estudiantes['nombresestudiantegeneral']; ?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?php echo $row_estudiantes['nota'];?>&nbsp;</font></td>
        <td align="center"><font size="1" face="Tahoma"><?php echo $row_estudiantes['numerofallasteoria'];?></font></td>
        <td align="center"><font size="1" face="Tahoma"><?php echo $row_estudiantes['numerofallaspractica'];?></font></td>
      </tr>
      <?php
	  $j++;
	   } while ($row_estudiantes = mysql_fetch_assoc($estudiantes)); 
 
	   ?>
	  </tr>
	  <tr>
        <td colspan="7" align="right"><font size="2" face="Tahoma">Responsable&nbsp;<br>
          <br>
          <br>
          ___________________________________<br><?php echo $_POST['nombre'];?></font><span class="Estilo26"><br>        
        <?php //echo $_SESSION['codigodocente']; ?></span></td>
      </tr>     
  </table>  
  <p align="center">
    <?php
}
else
  { 
     echo '<script language="JavaScript">alert("No hay notas para el periodo de consulta")</script>';			
     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listassala.php'>";
     exit();
  }

?>
<span class="Estilo24 Estilo26 Estilo32 Estilo1 Estilo2"><input name="Regresar" type="submit" id="Regresar" value="Regresar">
</span></form>
