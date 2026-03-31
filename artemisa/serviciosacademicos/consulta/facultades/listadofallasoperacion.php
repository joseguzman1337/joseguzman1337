<?php 
$creditos=0;
$query_Recordset1 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante
						FROM prematricula p,detalleprematricula d,materia m,grupo g
						WHERE  p.codigoestudiante = '".$codigoestudiante."'
						AND p.idprematricula = d.idprematricula
						AND d.codigomateria = m.codigomateria
						AND d.idgrupo = g.idgrupo
						AND m.codigoestadomateria = '01'
						AND g.codigoperiodo = '".$periodoactual."'
						AND p.codigoestadoprematricula LIKE '4%'
						AND d.codigoestadodetalleprematricula LIKE '3%'";
						//AND g.codigomaterianovasoft = m.codigomaterianovasoft
//echo $query_Recordset1;
$Recordset1 = mysql_query($query_Recordset1, $sala) or die("$query_Recordset1");
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_sala, $sala);
$query_Recordset2 = "SELECT * FROM estudiante e,estudiantegeneral eg 
                      WHERE codigoestudiante = '".$codigoestudiante."'
					  and e.idestudiantegeneral = eg.idestudiantegeneral";
//echo $query_Recordset2;
$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$facultad=$row_Recordset2['codigocarrera'];

mysql_select_db($database_sala, $sala);
$query_Recordset3 = sprintf("SELECT * FROM carrera WHERE codigocarrera = '%s'",$row_Recordset2['codigocarrera']);
$Recordset3 = mysql_query($query_Recordset3, $sala) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_sala, $sala);
$query_Recordset4 = sprintf("SELECT * FROM materia WHERE codigomateria = '%s'",$row_Recordset1['codigomateria']);
$Recordset4 = mysql_query($query_Recordset4, $sala) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);	

if ($totalRows_Recordset1 <> "")
 { ///////if mayor
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.Estilo3 {font-family: Tahoma; font-weight: bold; font-size: x-small; }
.style1 {
	font-family: Tahoma;
	font-size: small;
}
.Estilo14 {font-family: Tahoma; font-size: xx-small; font-weight: bold; }
.Estilo16 {font-family: Tahoma; font-size: xx-small; }
.Estilo17 {font-size: xx-small}
.Estilo18 {font-weight: bold; font-family: Tahoma;}
.Estilo1 {font-family: tahoma}
.Estilo19 {	font-family: tahoma;
	font-size: xx-small;
	font-weight: bold;
}
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
</head>
<body>
     <tr>
      <td align="center" rowspan="<?php echo ($totalRows_Recordset1+1);?>"><span class="Estilo14"><?php echo $row_Recordset2['nombresestudiantegeneral']; ?> <?php echo $row_Recordset2['apellidosestudiantegeneral']; ?> </span></td>
      <td align="center" rowspan="<?php echo ($totalRows_Recordset1+1);?>"><span class="Estilo14"><?php echo $row_Recordset2['numerodocumento']; ?></span></td>
  	  <?php 
    
	  $promedio=0;
	      $guardaidgrupo[]=0;
		  $g = 0;          
		  $numerocreditos = 0;
$query_Recordset9 = "SELECT m.nombremateria,m.codigomateria,m.numerocreditos,g.idgrupo,p.codigoestudiante
						FROM prematricula p,detalleprematricula d,materia m,grupo g
						WHERE  p.codigoestudiante = '".$codigoestudiante."'
						AND p.idprematricula = d.idprematricula
						AND d.codigomateria = m.codigomateria
						AND d.idgrupo = g.idgrupo
						AND m.codigoestadomateria = '01'
						AND g.codigoperiodo = '".$periodoactual."'
						AND p.codigoestadoprematricula LIKE '4%'
						AND d.codigoestadodetalleprematricula LIKE '3%'";						
$Recordset9 = mysql_query($query_Recordset9, $sala) or die("$query_Recordset9");
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

do{
$query_fecha ="SELECT c.numerocorte
						FROM corte c
						WHERE c.codigomateria = '".$row_Recordset9['codigomateria']."'						
						AND c.codigoperiodo = '".$periodoactual."'";
$fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
$row_fecha = mysql_fetch_assoc($fecha);
$totalRows_fecha = mysql_num_rows($fecha);
$i= 1;
$contadorcortes = 0;

if ($totalRows_fecha <> 0)
  {
   
  do {		
		//$cortes[$i]=$row_fecha;		
		//$i+=1;
		$contadorcortes +=1;
	 } while ($row_fecha = mysql_fetch_assoc($fecha));
    
  }
else
if ($totalRows_fecha==0) 
{		
	mysql_select_db($database_sala, $sala);
	$query_fecha = "SELECT * 
	                        FROM corte 
							WHERE codigocarrera = '".$facultad."'
						    AND codigoperiodo = '".$periodoactual."'
							order by numerocorte";
	//echo $query_fecha;
	$fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
	$row_fecha = mysql_fetch_assoc($fecha);
	$totalRows_fecha = mysql_num_rows($fecha);

do {
		//$cortes[$i]=$row_fecha;		
		//$i+=1;
		$contadorcortes +=1;
	} while ($row_fecha = mysql_fetch_assoc($fecha));
}	
if ($ultimocorte < $contadorcortes)
  {    
	$ultimocorte = $contadorcortes;
  }
//echo $ultimocorte;
} while ($row_Recordset9 = mysql_fetch_assoc($Recordset9));
  
do { 
	/////////////

if ($banderaimprime == 0)
  {  
   echo "<td width='10%' bgcolor='#C5D5D6' align='center'><font face='Tahoma' size='2'><strong>C&oacute;digo</strong></span></td>";
   echo "<td width='28%' bgcolor='#C5D5D6' align='center'><font face='Tahoma' size='2'><strong>Nombre Asignatura</strong> </span></td>";  
  for ($i=1;$i<=$ultimocorte;$i++) 
  {   
	  echo "<td width='3%' bgcolor='#C5D5D6' align='center'><font face='Tahoma' size='2'><strong>FT".$i."</div></td>";
      echo "<td width='3%' bgcolor='#C5D5D6' align='center'><font face='Tahoma' size='2'><strong>FP".$i."</div></td>";	 
  }    
      echo "<td width='3%' bgcolor='#C5D5D6' align='center'><font face='Tahoma' size='2'><strong>TFT</div></td>";      
	  echo "<td width='3%' bgcolor='#C5D5D6' align='center'><font face='Tahoma' size='2'><strong>TFP</div></td>";	  
      echo "</tr>";
   $banderaimprime = 1;
}
////////////////////////	
	$contador= 1;
	$query_Recordset8 ="SELECT detallenota.*,materia.nombremateria,materia.numerocreditos,
	                    grupo.codigomateria,corte.porcentajecorte 
						FROM detallenota,materia,grupo,corte 
						WHERE  materia.codigomateria=grupo.codigomateria 
						AND materia.codigoestadomateria = '01'
						AND detallenota.idgrupo=grupo.idgrupo 
						AND detallenota.idcorte=corte.idcorte 
						AND detallenota.codigoestudiante = '".$codigoestudiante."'
						AND detallenota.codigomateria = '".$row_Recordset1['codigomateria']."'  
						AND grupo.codigoperiodo = '".$periodoactual."'
						ORDER BY 2
						";
						//AND materia.codigomaterianovasoft=grupo.codigomaterianovasoft 
 // echo $query_Recordset8,"</br>";
  //exit;
  $Recordset8 = mysql_query($query_Recordset8, $sala) or die(mysql_error());
  $row_Recordset8 = mysql_fetch_assoc($Recordset8);
  $totalRows_Recordset8 = mysql_num_rows($Recordset8);	
  	
	?>
     <tr>
       <td align="center"><?php echo "<font face='Tahoma' size='2'>".$row_Recordset1['codigomateria']; ?></td>
       <td align="center" class="Estilo16"><?php echo $row_Recordset1['nombremateria']; ?></td>       
       <?php	
	       $habilitacion = 0;
		   $notafinal = 0;
		   $porcentajefinal = 0;
		   $fallasteoricasperdidas = 0;
		   $fallaspracticasperdidas = 0;
		  do{
	         
				 echo "<td align='center'><font face='Tahoma' size='2'>".$row_Recordset8['numerofallasteoria']."&nbsp;</td>";	
				 echo "<td align='center'><font face='Tahoma' size='2'>".$row_Recordset8['numerofallaspractica']."&nbsp;</td>";			 
				 $fallasteoricasperdidas = $fallasteoricasperdidas + $row_Recordset8['numerofallasteoria'];
				 $fallaspracticasperdidas = $fallaspracticasperdidas + $row_Recordset8['numerofallaspractica'];
				 $contador++;  
		  } while ($row_Recordset8 = mysql_fetch_assoc($Recordset8));		    
	      $creditosnota = $notafinal * $row_Recordset1['numerocreditos'];
		  $promedio =  $promedio + $creditosnota;		  
		  $suma = $ultimocorte - $contador; 
	  for ($i=0;$i<=$suma;$i++) 
        {   
			 echo "<td align='center'><font face='Tahoma' size='2'>&nbsp;</td>";	
			 echo "<td align='center'><font face='Tahoma' size='2'>&nbsp;</td>";			  
	    }  
	 
      echo "<td width='3%' align='center'><font face='Tahoma' size='2'>".$fallasteoricasperdidas."</td>";
	  echo "<td width='3%' align='center'><font face='Tahoma' size='2'>".$fallaspracticasperdidas."</td>";	 
	  echo "</tr>";
      
	$g++;
	} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));     
}  

?> 