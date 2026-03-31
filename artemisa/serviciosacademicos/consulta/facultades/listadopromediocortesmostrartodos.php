<?php 
require_once('../../Connections/sala2.php');
require_once('../../funciones/notas/redondeo.php');
session_start();
$GLOBALS['semestres'];
$periodoactivo=$_SESSION['codigoperiodosesion'];

if ($_GET['carrera'] <> "")
 {
   $codigocarrera = $_GET['carrera']; 
 }
else
 {
   $codigocarrera = $_SESSION['codigofacultad'];
 }

$limitesemestre = 12;
if(isset($_POST['busqueda_semestre']))
{
$_SESSION['semestres'] =$_POST['busqueda_semestre']; 
}
else
{
$_SESSION['semestres']=$_GET['semestreinicial']; 
} 
 mysql_select_db($database_sala,$sala);
$query_materiascarrera = "select DISTINCT m.codigomateria,m.nombremateria
	FROM detalleprematricula dp,estudiante e, prematricula p,materia m,grupo g,detallenota dn
	WHERE p.idprematricula = dp.idprematricula
	AND dp.codigomateria= m.codigomateria
	AND dn.codigoestudiante = p.codigoestudiante	
	AND dp.idgrupo = g.idgrupo	
	AND e.codigoestudiante = p.codigoestudiante
	AND g.codigoperiodo = '".$periodoactivo."'
	AND m.codigoestadomateria = '01'
	AND e.codigocarrera = '$codigocarrera'
	AND p.codigoestadoprematricula LIKE '4%'
	AND dp.codigoestadodetalleprematricula  LIKE '3%'
	AND p.semestreprematricula = '".$_SESSION['semestres']."'	
	ORDER BY 1";	
//echo $query_materiascarrera;
$materiascarrera = mysql_query($query_materiascarrera, $sala) or die("$query_promedioestudiante");
$total_materiascarrera = mysql_num_rows($materiascarrera);
if($total_materiascarrera != "")
{	
	$contadormateria = 1;
	while($row_materiascarrera = mysql_fetch_assoc($materiascarrera))
	{			
		$nombresmaterias[$contadormateria] = $row_materiascarrera['nombremateria'];
		$codigomaterias[$contadormateria] = $row_materiascarrera['codigomateria'];
	    $contadormateria ++ ;
	}
}
?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo3 {
	font-family: tahoma;
	font-size: xx-small;
	font-weight: bold;
}
.Estilo4 {font-size: xx-small}
.Estilo5 {font-family: tahoma; font-size: xx-small; }
.Estilo6 {
	font-size: 14;
	font-family: Tahoma;
}
.Estilo7 {font-size: 14px}
-->
</style>
  <h3 align="center" class="Estilo6">LISTADO PROMEDIO CORTES</h3> 
  <br>
<table width="600" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr bgcolor="#C5D5D6">
    <td align="center" class="Estilo1" colspan="2"><span class="Estilo3">Estudiantes - Semestre(<?php echo $_GET['semestreinicial'];?>) </span></td>
    <td align="center" class="Estilo1" colspan="<?php echo ($contadormateria-1);?>"><span class="Estilo3">Materias <font color='#990000'>&nbsp;PPA(Puntos Promedio Acumulado) NPA(Nota promedio acumulados) NFCR(Nota Faltante Cortes Restantes) </span></td>
    <td align="center" class="Estilo1" rowspan="2"><span class="Estilo3">Promedio Aritm&eacute;tico Semestre </span></td>
    <td align="center" class="Estilo1" rowspan="2"><span class="Estilo3">Promedio Ponderado Semestre</span></td>
  <tr bgcolor="#C5D5D6">
  <td align="center" class="Estilo1"><span class="Estilo3">Documento</span></td>
	<td align="center" class="Estilo1"><span class="Estilo3">Nombre</span></td>
<?php  for ($i= 1; $i < $contadormateria; $i++)
        { ?>	
	       <td align="center" class="Estilo1"><span class="Estilo3"><?php 
		   
		   echo $codigomaterias[$i]."<br>".$nombresmaterias[$i]."<br>";
		   echo "<font color='#990000'>Cortes Secuenciales<br>";
		   mysql_select_db($database_sala,$sala);
			$query_corte = "SELECT distinct c.porcentajecorte,dn.idcorte
											FROM detallenota dn,corte c
											WHERE c.codigoperiodo = '".$periodoactivo."'
											and dn.idcorte = c.idcorte											
											and dn.codigomateria = '".$codigomaterias[$i]."'											
											ORDER BY 1									
									   ";			
			$corte = mysql_query($query_corte, $sala) or die("$query_corte");
			$total_corte = mysql_num_rows($corte);
		 $cuentacorte = 1;
		 if ($total_corte <> "")
		    {
			   while($row_corte = mysql_fetch_assoc($corte))
	            {
			      echo $row_corte['porcentajecorte']."%&nbsp;";				
				}
			}
		 /* else
		    {
			     $query_corte = "select porcentajecorte 
		                           from corte
								   where codigocarrera = '".$codigocarrera."'
								   and codigoperiodo = '".$periodoactivo."'
								   ";	
					//echo $query_materiascarrera;
				$corte = mysql_query($query_corte, $sala) or die("$query_promedioestudiante");
				$total_corte = mysql_num_rows($corte);
				   while($row_corte = mysql_fetch_assoc($corte))
					{
					 echo $row_corte['porcentajecorte']."%&nbsp;";					
					}
			
			}		*/	  
		 
		   echo "PPA&nbsp;&nbsp;NPA&nbsp;&nbsp;NFCR";
		   ?></span></td>
<?php   }?>  
  </tr>
<?php

mysql_select_db($database_sala,$sala); 
$query_materiascarrera1 = "SELECT DISTINCT e.codigoestudiante,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,eg.numerodocumento
						FROM detalleprematricula dp,estudiante e, prematricula p,materia m,grupo g,detallenota dn,estudiantegeneral eg
						WHERE p.idprematricula = dp.idprematricula
						and e.idestudiantegeneral = eg.idestudiantegeneral
						AND dp.codigomateria= m.codigomateria
						AND dn.codigoestudiante = p.codigoestudiante		
						AND dp.idgrupo = g.idgrupo	
						AND e.codigoestudiante = p.codigoestudiante
						AND g.codigoperiodo = '".$periodoactivo."'
						AND m.codigoestadomateria = '01'
						AND e.codigocarrera = '$codigocarrera'
						AND p.codigoestadoprematricula LIKE '4%'
						AND dp.codigoestadodetalleprematricula  LIKE '3%'
						AND p.semestreprematricula = '".$_SESSION['semestres']."'	
						ORDER BY 3";	
//echo $query_materiascarrera1,"jeje";
$materiascarrera1 = mysql_query($query_materiascarrera1, $sala) or die("$query_promedioestudiante");
$total_materiascarrera1 = mysql_num_rows($materiascarrera1);
 for($j = 1; $j < $contadormateria ;$j++)
	  {   
	   $notasmenor[$j] = 5;
	   $notasmayor[$j] = 0;
	   $totalmateria[$j]=0;
	   $sumamateria[$j]= 0;
	   $perdieron[$j]= 0;
	  }
$cuentaestudiante = 1;      
while($row_materiascarrera1 = mysql_fetch_assoc($materiascarrera1))
	{
	 $estudiante[$cuentaestudiante]=$row_materiascarrera1['codigoestudiante']; 
	 $cuentaestudiante++;
	?>
	 <tr>
	  <td align="center" class="Estilo1 Estilo4"><?php echo $row_materiascarrera1['numerodocumento'];?></td>
	  <td align="center" class="Estilo5"><?php echo $row_materiascarrera1['apellidosestudiantegeneral']."&nbsp;".$row_materiascarrera1['nombresestudiantegeneral'];?></td>
      
<?php 
  
  for($i = 1; $i < $contadormateria ;$i++)
	  {
		   ?>
	  <td> 
	   <table border="0" cellpadding="2">
	    <tr> 
		<?php  
		    mysql_select_db($database_sala,$sala);
		    $query_materiascarrera2 = "SELECT dn.nota,dn.idcorte,c.porcentajecorte,m.notaminimaaprobatoria
						FROM detallenota dn,corte c,materia m
						WHERE dn.codigoestudiante = '".$row_materiascarrera1['codigoestudiante']."' 
						AND c.codigoperiodo = '".$periodoactivo."'
						and dn.idcorte = c.idcorte
						and dn.codigomateria = '".$codigomaterias[$i]."'
						and dn.codigomateria = m.codigomateria  
						ORDER BY 2";	
				//echo $query_materiascarrera2,"<br>";
				$materiascarrera2 = mysql_query($query_materiascarrera2, $sala) or die("$query_promedioestudiante");
				$total_materiascarrera2 = mysql_num_rows($materiascarrera2);	
				//$row_materiascarrera2 = mysql_fetch_assoc($materiascarrera2);	   
			    $notafinal = 0;
			    $notafaltante = 0;
				$porcentaje = 0;
			  if ($total_materiascarrera2 <> 0)
			     { //if $total_materiascarrera2				
					 ?>
		
		<?php	  while($row_materiascarrera2 = mysql_fetch_assoc($materiascarrera2))
	               {				    
				      $notaminima = $row_materiascarrera2['notaminimaaprobatoria'];
					  if ($row_materiascarrera2['nota'] < $row_materiascarrera2['notaminimaaprobatoria'])
				       {				         
				   ?>     
		                 <td align="center" class="Estilo5" ><?php //echo $row_materiascarrera2['porcentajecorte'],"%<br>";?> <font color="#FF0000"><?php echo $row_materiascarrera2['nota'],"&nbsp;&nbsp;";?></td>		           
<?php                	                     
					   }
					  else 
					   {?>
					     <td align="center" class="Estilo5" ><?php echo /*$row_materiascarrera2['porcentajecorte'],"%<br>",*/$row_materiascarrera2['nota'],"&nbsp;&nbsp;";?></td>      
<?php    
			           }
				         $notafinal = $notafinal + ($row_materiascarrera2['nota']*$row_materiascarrera2['porcentajecorte']/100);	 
				    //  $notafinaltmp = round($notafinalini * 10)/10; 
					   //  $notafinal = redondeo($notafinal); 
						
						//if($notafinaltmp=="2.9")
						//echo "NOTAFINAL=".$notafinal."-".$notafinaltmp."-".$notafinalini."<BR>";
						 $notafaltante = $row_materiascarrera2['notaminimaaprobatoria'] - redondeo($notafinal);				         
						 $porcentaje = $porcentaje + $row_materiascarrera2['porcentajecorte'];
						 
						// $notafinal = number_format($notafinal,1); 
						   if ($notafaltante > 0)
						     {
							  $notafaltante = $notafaltante;
							 }
				            else
							  {
							   $notafaltante = "0.0";
							  }
				     
				  }	
					//echo $notafinal."&nbsp;".$porcentaje."<br>";				 
					 if ($notasmenor[$i] > $notafinal)
					   {						
						$notasmenor[$i] = $notafinal;				   
					   }	
					  //echo $notasmayor[$i].">&nbsp;&nbsp;je".$notafinal."<br>";
					 if ($notafinal > $notasmayor[$i])
					   {
						$notasmayor[$i] = $notafinal;				    
					   }	   			  
				  $totalmateria[$i]=$totalmateria[$i] + 1;
				  $sumamateria[$i] = $sumamateria[$i] + $notafinal;
				  $npa = number_format($notafinal/($porcentaje/100),1);
				   // if ($notafinal < $notaminima)
				   if ($npa < $notaminima)
					 {
					  $perdieron[$i]=$perdieron[$i] + 1;
					 }		 
				// $notafinal = number_format($notafinal,2);
				 echo " <td align='center' class='Estilo5'><strong>".redondeo($notafinal)."&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>";
				 echo " <td align='center' class='Estilo5'><strong>".number_format(redondeo($notafinal)/($porcentaje/100),1)."&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>";
				 echo " <td align='center' class='Estilo5'><strong>".number_format($notafaltante,1)."</strong></td>";
				 } ////if $total_materiascarrera2		  
              else 
			   {
			     ////////////////////////////////////////////////////////////////////////////////
			        mysql_select_db($database_sala,$sala);
					$query_materiascarrera3 = "SELECT *
							FROM prematricula p,detalleprematricula dp
							WHERE p.idprematricula = dp.idprematricula
							and p.codigoestudiante = '".$row_materiascarrera1['codigoestudiante']."' 
							and dp.codigomateria = '".$codigomaterias[$i]."'
							AND p.codigoestadoprematricula LIKE '4%'
							AND dp.codigoestadodetalleprematricula  LIKE '3%'
							AND p.codigoperiodo = '".$periodoactivo."'";	
				//echo $query_materiascarrera3,"<br>";
				$materiascarrera3 = mysql_query($query_materiascarrera3, $sala) or die("$query_materiascarrera3");
				$total_materiascarrera3 = mysql_num_rows($materiascarrera3);	
			     /////////////////////////////////////////////////////////////////////////////////
			       
					if ($total_materiascarrera3 == 0)
					   {
					    $nota = "&nbsp;";
					   }
				    else
					  {
					    $nota = "sin nota";
					  } 	
				 
				
				?>
			     <td align="center" class="Estilo5"><?php echo $nota;?></td>		           
	<?php      } 
	             
	           
	?>
	     </tr>
		</table> 
	   </td>
	   <?php	  
	    }	
		 ///////////////////////////////// promedio aritmetico /////////////////////////////////////
		 mysql_select_db($database_sala,$sala);
		 $query_promedioestudiante = "SELECT e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento,round(AVG(dn.nota),1) AS promedio 
											FROM detallenota dn, estudiante e, prematricula p,corte c,estudiantegeneral eg 
											WHERE e.codigoestudiante = dn.codigoestudiante 
											AND e.codigoestudiante = '".$row_materiascarrera1['codigoestudiante']."'
											and e.idestudiantegeneral = eg.idestudiantegeneral
											AND e.codigocarrera = '$codigocarrera'
											AND c.idcorte = dn.idcorte											
											AND c.codigoperiodo = '".$periodoactivo."'
											AND p.codigoestadoprematricula LIKE '4%' 
											GROUP by 1 
											ORDER BY 2 ";
		//echo $query_promedioestudiante,"<br>";
		  $promedioestudiante = mysql_query($query_promedioestudiante, $sala) or die(mysql_error());
		  $row_promedioestudiante = mysql_fetch_assoc($promedioestudiante);
		  $totalRows_promedioestudiante = mysql_num_rows($promedioestudiante);	 
		 /////////////////////////////////////////////////////////////////////////////////////////
		 $codigoestudiante = $row_materiascarrera1['codigoestudiante'];
		 $periodo = $periodoactivo;	
	     require('calculopromedioprecierre.php');        
		?>  
		 <td align="center" class="Estilo5"><?php echo number_format($row_promedioestudiante['promedio'],1);?></td>	   
	     <td align="center" class="Estilo5"><?php echo $promediosemestral;?></td>	   
  </tr> 
<?php 
   }
   //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     
?>     
</table>
<br>
<div align="center">
<p align="center"><span class="Estilo6"><strong>DATOS ESTAD&Iacute;STICOS</strong></span></p>
<table width="600" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr bgcolor="#C5D5D6">
    <td colspan="2" align="center" class="Estilo1 Estilo4"><strong>NOMBRE ASIGNATURA</strong></td>
    <?php
//if (isset($estudiante))
//{
 for ($i= 1; $i < $contadormateria; $i++)
{   
   ?>
    <td align="center" class="Estilo1 Estilo4"><strong><?php echo $key1."<br>".$nombresmaterias[$i]?></strong></td>
    <?php
}
//}?>
  </tr>
  <tr>
    <td colspan="2" align="center" class="Estilo1 Estilo4"  bgcolor="#C5D5D6"><strong>PROMEDIO</strong></td>
    <?php

 for ($i= 1; $i < $contadormateria; $i++)
   {   
     if($totalmateria[$i] <> 0 and $sumamateria[$i] <> 0)
	  {    
		 $promedio = $sumamateria[$i]/$totalmateria[$i];        
	  }
     else
	  {
	     $promedio = 0;
	  }
   ?>
    <td align="center" class="Estilo1 Estilo4"><?php echo number_format($promedio,1);?>&nbsp;</td>
    <?php
   }
//}?>
  </tr>
  <tr>
    <td colspan="2" align="center" class="Estilo1 Estilo4"  bgcolor="#C5D5D6"><strong>NOTA M&Iacute;NIMA</strong></td>
    <?php
 for ($i= 1; $i < $contadormateria; $i++)
   { 
     if($sumamateria[$i] == 0)
	  {    
        $notasmenor[$i]=0;  
      }
   ?>
    <td align="center" class="Estilo1 Estilo4"><?php echo number_format($notasmenor[$i],1);?>&nbsp;</td>
    <?php
   }
//}?>
  </tr>
  <tr>
    <td colspan="2" align="center" class="Estilo1 Estilo4"  bgcolor="#C5D5D6"><strong>NOTA M&Aacute;XIMA</strong></td>
    <?php
 for ($i= 1; $i < $contadormateria; $i++)
   { 
   ?>
    <td align="center" class="Estilo1 Estilo4"><?php echo number_format($notasmayor[$i],1);?>&nbsp;</td>
    <?php
   }
//}?>
  </tr>
  <tr>
    <td colspan="2" align="center" class="Estilo1 Estilo4"  bgcolor="#C5D5D6"><strong>DESVIACIÓN ESTANDAR</strong></td>
    <?php
 //$desviacion = 0; $estudiante[$cuentaestudiante]
for ($j= 1; $j < $contadormateria; $j++)
	{			
	 $desviacion = 0;
	 for ($i= 1; $i < $cuentaestudiante; $i++)
	   {			 
          mysql_select_db($database_sala,$sala);
		    $query_materiascarrera2 = "SELECT dn.nota,dn.idcorte,c.porcentajecorte,m.notaminimaaprobatoria
										FROM detallenota dn,corte c,materia m
										WHERE dn.codigoestudiante = '".$estudiante[$i]."' 
										AND c.codigoperiodo = '".$periodoactivo."'
										and dn.idcorte = c.idcorte
										and dn.codigomateria = '".$codigomaterias[$j]."'
										and dn.codigomateria = m.codigomateria  
										ORDER BY 2";	
				//echo $query_materiascarrera2,"<br>";$codigomaterias[$contadormateria]
				$materiascarrera2 = mysql_query($query_materiascarrera2, $sala) or die("$query_materiascarrera2");
				$total_materiascarrera2 = mysql_num_rows($materiascarrera2);	
				//$row_materiascarrera2 = mysql_fetch_assoc($materiascarrera2);	   
			    $notafinal = 0;
			    $notafaltante = 0;
			  if ($total_materiascarrera2 <> 0)
			     { //if $total_materiascarrera2				
				      while($row_materiascarrera2 = mysql_fetch_assoc($materiascarrera2))
					   {			  
						 $notafinal = $notafinal + ($row_materiascarrera2['nota']*$row_materiascarrera2['porcentajecorte']/100);	 
					    ///$notafinal = $row_materiascarrera2['nota'];
					  }      
		               //echo $totalmateria[$j];
					 if($totalmateria[$j] <> 0)
					  {						 
						  $promedio = $sumamateria[$j]/$totalmateria[$j];
						  //echo $desviacion,"&nbsp;J",$notafinal,"-&nbsp;",$promedio,"<br>";
						  $desviacion = $desviacion + (pow(($notafinal - $promedio),2));		  
						   
					   }
	            }	
      }
       if($totalmateria[$j] <> 0)
	    {
		   $desviacion3= $desviacion/$totalmateria[$j];
		   
		   $desviaciontotal[$j] = number_format(sqrt($desviacion3),1);
        }
    }

 for ($j= 1; $j < $contadormateria; $j++)
  {
    echo "<td align='center' class='Estilo1 Estilo4'>".number_format($desviaciontotal[$j],1)."&nbsp;</td>";
  }
?>
  </tr>
  <tr>
    <td colspan="2" align="center" class="Estilo1 Estilo4"  bgcolor="#C5D5D6"><strong>Nº ESTUDIANTES PERDIERON</strong></td>
    <?php
 for ($i= 1; $i < $contadormateria; $i++)
   { 
    ?>
     <td align="center" class="Estilo1 Estilo4"><?php echo $perdieron[$i];?>&nbsp;</td>
    <?php
   }
//}?>
  </tr>
  <tr>
    <td colspan="2" align="center" class="Estilo1 Estilo4"  bgcolor="#C5D5D6"><strong>Nº ESTUDIANTES / ASIGNATURA</strong></td>
    <?php
 for ($i= 1; $i < $contadormateria; $i++)
   { 
   ?>
    <td align="center" class="Estilo1 Estilo4"><?php echo $totalmateria[$i];?>&nbsp;</td>
    <?php
   }
//}?>
  </tr>
</table>
<br>
<br>
<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if($_SESSION['semestres'] > 1)
		{
			
			echo '<a href="listadopromediocortesmostrartodos.php?semestreinicial='.($_SESSION['semestres']-1).'&carrera='.$codigocarrera.'"><<- Semestre anterior</a>';
		}
		echo "&nbsp;&nbsp;";
		if($_SESSION['semestres'] < $limitesemestre)
		{			
			echo '<a href="listadopromediocortesmostrartodos.php?semestreinicial='.($_SESSION['semestres']+1).'&carrera='.$codigocarrera.'">Semestre siguiente->></a>';
		}
?>
<br>
<br>
<p align="center"><input type="button" onClick="print()" value="Imprimir">
<input type="button" onClick="volver()" value="Regresar">
</div>
<script language="JavaScript">
  function volver()
   {
    window.location.reload("listadopromediocortes.php")
   }
</script>