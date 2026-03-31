<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
        $perdieron = 0;
		$pasaron = 0;
		mysql_select_db($database_sala, $sala);
		$query_materia = "SELECT m.codigomateria,m.nombremateria,c.nombrecarrera,m.notaminimaaprobatoria,m.notaminimahabilitacion
		FROM materia m,carrera c
		WHERE m.codigomateria = '".$_GET['materia']."'				     
	    and m.codigocarrera = c.codigocarrera";		
		//echo $query_materia;
		$materia = mysql_query($query_materia, $sala) or die(mysql_error());
		$row_materia = mysql_fetch_assoc($materia);
		$totalRows_materia = mysql_num_rows($materia);
		
if ($_GET['grupo'] == 0)
  {  // if grupo       
		mysql_select_db($database_sala, $sala);
		$query_historico = "SELECT *
						    FROM notahistorico n,materia m,estudiante e,carrera c,estudiantegeneral eg
						    WHERE m.codigomateria = '".$_GET['materia']."'				     
					        and n.codigomateria = m.codigomateria
							and e.idestudiantegeneral = eg.idestudiantegeneral
							and n.codigoestudiante = e.codigoestudiante
							and c.codigocarrera = e.codigocarrera
							and n.codigoestadonotahistorico like '1%'
							and n.codigoperiodo = '".$periodo."'
							order by eg.apellidosestudiantegeneral";		
		//echo $query_historico;
		//exit;
		$historico = mysql_query($query_historico, $sala) or die(mysql_error());
		$row_historico = mysql_fetch_assoc($historico);
		$totalRows_historico = mysql_num_rows($historico);
        if (!$row_historico)
		 {
		    echo '<script language="JavaScript">alert("No se produjo ningún resultado1");</script>';	
		    echo '<script language="JavaScript">history.go(-1);</script>';	
		 }
     if ($_GET['estudiante'] == 0)
	   {
	     $tiporeporte = "TODOS LOS ESTUDIANTES";
		do{
		    $codigoestudiante[] = $row_historico['codigoestudiante'];	
			
	        if($row_historico['notadefinitiva'] < $row_historico['notaminimaaprobatoria'])
			 {
		      $perdieron ++;	
	         }
			else  
		     {
			  $pasaron ++;
			 }
		  } while($row_historico = mysql_fetch_assoc($historico));   
		 
	   } 
      else
	   if ($_GET['estudiante'] == 1)
	   {
	    $tiporeporte = "PERDIERON LA MATERIA";
	   do{
		   //  echo $row_historico['codigoestudiante'],"&nbsp;&nbsp;",$row_historico['notadefinitiva'],"<",$row_historico['notaminimaaprobatoria'],"<br>";
			if($row_historico['notadefinitiva'] < $row_historico['notaminimaaprobatoria'])
			 {
		      $codigoestudiante[] = $row_historico['codigoestudiante'];	
	         }
		  } while($row_historico = mysql_fetch_assoc($historico));
	   }
	  else
	   if ($_GET['estudiante'] == 2)
	   {
	     $tiporeporte = "PASARON LA MATERIA";
		do{
		    if($row_historico['notadefinitiva'] >= $row_historico['notaminimaaprobatoria'])
			 {
		      $codigoestudiante[] = $row_historico['codigoestudiante'];	
	         }
		  } while($row_historico = mysql_fetch_assoc($historico));
	   }
	  else
	   if ($_GET['estudiante'] == 3)
	   {
	     
		 $tiporeporte = "HABILITAN LA  MATERIA";
		 
		do{
		    //echo $row_historico['notadefinitiva'], ">=", $row_historico['notaminimahabilitacion'], "and" ,$row_historico['notadefinitiva'], "<" ,$row_historico['notaminimaaprobatoria'],"<br><br>";
			if($row_historico['notadefinitiva'] >= $row_historico['notaminimahabilitacion'] and $row_historico['notadefinitiva'] < $row_historico['notaminimaaprobatoria'])
			 {
		      $codigoestudiante[] = $row_historico['codigoestudiante'];	
	         }
		  } while($row_historico = mysql_fetch_assoc($historico));
	   }  
  
  }  // if grupo  
 else
  {
        mysql_select_db($database_sala, $sala);
		$query_historico = "SELECT *
						    FROM notahistorico n,materia m,estudiante e,estudiantegeneral eg
						    WHERE m.codigomateria = '".$_GET['materia']."'
							and n.idgrupo = '".$_GET['grupo']."'				     
					        and e.idestudiantegeneral = eg.idestudiantegeneral
							and n.codigomateria = m.codigomateria
							and n.codigoestudiante = e.codigoestudiante
							and n.codigoestadonotahistorico like '1%'
							and n.codigoperiodo = '".$periodo."'
							order by eg.apellidosestudiantegeneral";		
		//echo $query_historico;
		$historico = mysql_query($query_historico, $sala) or die(mysql_error());
		$row_historico = mysql_fetch_assoc($historico);
		$totalRows_historico = mysql_num_rows($historico);
       if (!$row_historico)
		 {
		    echo '<script language="JavaScript">alert("No se produjo ningún resultado2");</script>';	
		    echo '<script language="JavaScript">history.go(-1);</script>';	
		 } 
     if ($_GET['estudiante'] == 0)
	   {
	     $tiporeporte = "TODOS LOS ESTUDIANTES";
		do{
		    
		     $codigoestudiante[] = $row_historico['codigoestudiante'];	
	         if($row_historico['notadefinitiva'] < $row_historico['notaminimaaprobatoria'])
			 {
		      $perdieron ++;	
	         }
			else  
		     {
			  $pasaron ++;
			 }
		  } while($row_historico = mysql_fetch_assoc($historico));
	   } 
      else
	   if ($_GET['estudiante'] == 1)
	   {
	    $tiporeporte = "PERDIERON LA MATERIA";
	   do{
		    // echo $row_historico['codigoestudiante'],"&nbsp;&nbsp;",$row_historico['notadefinitiva'],"<",$row_historico['notaminimaaprobatoria'],"<br>";
			if($row_historico['notadefinitiva'] < $row_historico['notaminimaaprobatoria'])
			 {
		      $codigoestudiante[] = $row_historico['codigoestudiante'];	
	         }
		  } while($row_historico = mysql_fetch_assoc($historico));
	   }
	  else
	   if ($_GET['estudiante'] == 2)
	   {
	     $tiporeporte = "PASARON LA MATERIA";
		do{
		    if($row_historico['notadefinitiva'] >= $row_historico['notaminimaaprobatoria'])
			 {
		      $codigoestudiante[] = $row_historico['codigoestudiante'];	
	         }
		  } while($row_historico = mysql_fetch_assoc($historico));
	   }
	  else
	   if ($_GET['estudiante'] == 3)
	   {
	     $tiporeporte = "HABILITAN LA  MATERIA";
		 
		do{
		    if($row_historico['notadefinitiva'] >= $row_historico['notaminimahabilitacion'] and $row_historico['notadefinitiva'] < $row_historico['notaminimaaprobatoria'])
			 {
		      $codigoestudiante[] = $row_historico['codigoestudiante'];	
	         }
		  } while($row_historico = mysql_fetch_assoc($historico));
	   }  
  
  } 
if ($codigoestudiante <> "")
 { ?>

<span style="font-size: 10px">
<style type="text/css">
<!--
.Estilo16 {font-family: tahoma; font-size: xx-small; }
.Estilo18 {font-family: tahoma; font-weight: bold; font-size: xx-small; }
.Estilo20 {font-family: tahoma; font-weight: bold; font-size: x-small; }
-->
  </style>
  </span><table width="60%" border="1" align="center" cellpadding="5" bordercolor="#003333">
  <tr>
    <td bgcolor="#C6CFD0" style="font-size: 12; font-family: Tahoma"><span class="Estilo20">Facultad:</span></td>
    <td colspan="5" style="font-size: 12; font-family: Tahoma" ><span class="Estilo20"><?php echo $row_materia['nombrecarrera'];?>&nbsp;</span>&nbsp;</td>
  </tr>
  <tr>
	<td bgcolor="#C6CFD0" style="font-size: 12; font-family: Tahoma"><span class="Estilo20">Materia:&nbsp;</span></td>
	<td colspan="2" style="font-size: 12; font-family: Tahoma" ><span class="Estilo20"><?php echo $row_materia['nombremateria'];?>&nbsp;-&nbsp;<span class="Estilo20">
    <?php echo $row_materia['codigomateria'];?>&nbsp;</span></td>
	<td colspan="2" style="font-size: 12; font-family: Tahoma" ><div align="center"><span class="Estilo20" style="font-size: 12px">
	  <?php
		  if ($row_materia['notaminimaaprobatoria'] > $row_materia['notaminimahabilitacion'])
		    {
			  echo "Habilitable Min. con:&nbsp;",$row_materia['notaminimahabilitacion']; 
			}	
		   else
		    {
			 echo "No Habilitable";
			}	
		?>
	&nbsp;</span></div></td>
  </tr>
  <tr bgcolor="#C6CFD0">
    <td colspan="5" style="font-size: 12; font-family: Tahoma"><div align="center"><span class="Estilo20">
	<?php echo $tiporeporte,"<br>";
		   if($pasaron <> 0)
		     {
			   echo "Pasaron  &nbsp;&nbsp;",$pasaron,"<br>";
			 }
			if($perdieron <> 0)
		     {
			   echo "Perdieron&nbsp;&nbsp;",$perdieron;
			 }
		?></span></div></td>
  </tr>
  <tr bgcolor="#C6CFD0">
    <td style="font-size: 12; font-family: Tahoma"><div align="center"><span class="Estilo18" style="font-weight: bold; font-size: 12px">Id. Grupo</span></div></td>
	<td style="font-size: 12; font-family: Tahoma"><div align="center"><span class="Estilo18" style="font-weight: bold; font-size: 12px">Documento</span></div></td>
	<td style="font-size: 12; font-family: Tahoma"><div align="center"><span class="Estilo18" style="font-weight: bold; font-size: 12px">Nombre</span></div></td>
	<td style="font-size: 12; font-family: Tahoma"><div align="center"><span class="Estilo18" style="font-weight: bold; font-size: 12px">Tipo Nota</span></div></td>
	<td style="font-size: 12; font-family: Tahoma"><div align="center"><span class="Estilo18" style="font-weight: bold; font-size: 12px">Nota</span></div></td>
  </tr>
<?php   
   foreach($codigoestudiante as $key => $codigo)
	{	
	    mysql_select_db($database_sala, $sala);
		$query_estudiante = "SELECT *
						    FROM notahistorico n,tiponotahistorico t,estudiante e,materia m,grupo g,estudiantegeneral eg
						    WHERE n.codigoestudiante = '".$codigo."'
							and n.codigomateria = '".$row_materia['codigomateria']."'				     
					        and n.codigotiponotahistorico = t.codigotiponotahistorico
							and e.idestudiantegeneral = eg.idestudiantegeneral
							and e.codigoestudiante = n.codigoestudiante
							and n.idgrupo = g.idgrupo
							and m.codigomateria = n.codigomateria
							and n.codigoestadonotahistorico like '1%'
							and n.codigoperiodo = '".$periodo."'";		
		$estudiante = mysql_query($query_estudiante, $sala) or die(mysql_error());
		$row_estudiante = mysql_fetch_assoc($estudiante);
		$totalRows_estudiante = mysql_num_rows($estudiante);
	
	?>
  <tr>
    <td style="font-size: 12; font-family: Tahoma"><div align="center" style="font-size: 10px"><span class="Estilo16"><?php echo $row_estudiante['idgrupo'];?>&nbsp;-Grupo <?php echo $row_estudiante['nombregrupo'];?></span></div></td>
	<td style="font-size: 12; font-family: Tahoma"><div align="center" style="font-size: 10px"><span class="Estilo16"><?php echo $row_estudiante['numerodocumento'];?>&nbsp;</span></div></td>
	<td style="font-size: 12; font-family: Tahoma"><div align="center" style="font-size: 10px"><span class="Estilo16"><?php echo $row_estudiante['apellidosestudiantegeneral'];?>&nbsp;<?php echo $row_estudiante['nombresestudiantegeneral'];?></span></div></td>
	<td style="font-size: 12; font-family: Tahoma"><div align="center" style="font-size: 10px"><span class="Estilo16"><?php echo $row_estudiante['nombretiponotahistorico'];?></span></div></td>
	<td style="font-size: 12; font-family: Tahoma"><div align="center" style="font-size: 10px"><span class="Estilo16">
      <?php 
		     if ($row_estudiante['notadefinitiva'] < $row_estudiante['notaminimaaprobatoria'])
			  {
		        echo "<font color='red'>",$row_estudiante['notadefinitiva'],"</font>";
		      }
			 else
			  {
			   echo $row_estudiante['notadefinitiva'];
			  }		 
		 ?>
	</span></div></td>
  </tr>
<div align="center" style="font-size: 12; font-family: Tahoma">	  
<?php 
    }
     $key = $key + 1;
     echo "<strong><span class='Estilo20'>Se encontraron &nbsp;",$key,"&nbsp;registros</span></strong>";  
?>	
</div>
<br>  <br>  <br>  
  </table>
<p align="center" style="font-size: 12; font-family: Tahoma">
 <input type="button" name="Submit" value="Regresar" onClick="history.go(-1)">
 <input type="button" name="Submit" value="Imprimir" onClick="window.print()">
</p>	
<span style="font-size: 12; font-family: Tahoma">
<?php
 }
else
  {
    echo '<script language="JavaScript">alert("No se produjo ningún resultado");</script>';	
	echo '<script language="JavaScript">history.go(-1);</script>';	
  }
 ?>
</span>