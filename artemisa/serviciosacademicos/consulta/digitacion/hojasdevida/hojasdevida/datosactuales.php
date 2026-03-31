<?php require_once('../../../../Connections/conexion.php');session_start();?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; }
-->
</style>
<form name="form1" method="post" action="">
<div align="center">
<?php 

      $base= "select * from docente,escalafondocente where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(escalafondocente.codigoescalafondocente=docente.codigoescalafondocente))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	
	   	 do{  ?>
  </div><br> 
 <div align="center">
   <p><span class="Estilo3"><strong>VISTA PREVIA</strong> </span></p> 
   <?php echo "<font size='3' face='Tahoma'><strong>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"";?></div>
 <h3 align="center" class="Estilo2">Informaci&oacute;n Personal</h3>
         <div align="center" class="Estilo1">
<table width="500" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
<tr>
	<td width="185" bgcolor="#C5D5D6" class="Estilo2">&nbsp; G&eacute;nero </td>
    <td class="Estilo1" align="center"><?php echo $row['sexodocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Fecha de Nacimiento</strong></td>
    <td class="Estilo1" align="center"><?php echo $row['fechanacimientodocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Lugar</td>
    <td class="Estilo1" align="center"><?php echo $row['lugarnacimientodocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tel&eacute;fono Casa</strong></td>
    <td class="Estilo1" align="center"><?php echo $row['telefonodocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tel&eacute;fono Oficina</strong></td>
	<td class="Estilo1" align="center"><?php echo $row['telefonodocente2'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Celular</strong></td>
	<td class="Estilo1" align="center"><?php echo $row['celulardocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Dirección</strong></td>
	<td class="Estilo1" align="center"><?php echo $row['direcciondocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Ciudad</strong></td>
	<td class="Estilo1" align="center"><?php echo $row['ciudaddocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; E-mail</strong></td>
	<td class="Estilo1" align="center"><?php echo $row['emaildocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Fax</strong></td>
	<td class="Estilo1" align="center"><?php echo $row['faxdocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Escalaf&oacute;n</strong></td>
	<td class="Estilo1" align="center"><?php echo $row['nombreescalafondocente'];?>&nbsp;</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Estado</strong></td>
	<td class="Estilo1" align="center"><?php echo $row['nombreestadodocente'];?>&nbsp;</td>
</tr>
<?php }while ($row=mysql_fetch_array($sol));  ?>
  </table>
  </div>	  
<?php
		   $base= "select * from contratolaboral,tipocontrato,estadotipocontrato 
		           where estadotipocontrato.codigoestadotipocontrato=contratolaboral.codigoestadotipocontrato
				   and tipocontrato.codigotipocontrato=contratolaboral.codigotipocontrato
				   and contratolaboral.numerodocumento = '".$_SESSION['numerodocumento']."'
				   order by contratolaboral.fechainiciocontratolaboral";
		   $sol=mysql_db_query($database_conexion,$base);
		   $totalRows = mysql_num_rows($sol);
		   $row=mysql_fetch_array($sol);
		  if ($row <> "")
		   {// if 1
?>	
          <h3 align="center" class="Estilo2">Contratos Laborales </h3>		   
		   <div align="center">
		     <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
               <tr bgcolor="#C6CFD0" class="Estilo2">
                 <td bgcolor="#C5D5D6"><div align="center"><strong>N&uacute;mero</strong></div></td>
                 <td bgcolor="#C5D5D6"><div align="center"><strong>Fecha inicio</strong></div></td>
                 <td bgcolor="#C5D5D6"><div align="center"><strong>Fecha  fin</strong></div></td>
                 <td bgcolor="#C5D5D6"><div align="center"><strong>Tipo de contrato</strong></div></td>
                 <td bgcolor="#C5D5D6"><div align="center"><strong>Estado</strong></div></td>
               </tr>           
<?php         
 do{  ?>     
               <tr class="Estilo1"> 
                 <td align="center"><?php echo $row['numerocontratolaboral'];?>&nbsp;</td>                           
                 <td align="center"><?php echo $row['fechainiciocontratolaboral'];?>&nbsp;</td>
                 <td align="center"><?php echo $row['fechafinalcontratolaboral'];?>&nbsp;</td>
                 <td align="center"><?php echo $row['nombretipocontrato'];?>&nbsp;</td>
				 <td align="center"><?php echo $row['nombreestadotipocontrato'];?>&nbsp;</td>               
	           </tr>
	         <?php }while ($row=mysql_fetch_array($sol)); 
	
	    } // if 1
	?>
  
</table>	    
  </div>
		   
<?php  $base= "select * from historialacademico,tipogrado 
               where numerodocumento = '".$_SESSION['numerodocumento']."'
			   and historialacademico.codigotipogrado=tipogrado.codigotipogrado
			   order by historialacademico.fechagradohistorialacademico";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	  
	  if ($row <> "")
	   {?>
	     
		 <h3 align="center" class="Estilo2">Formaci&oacute;n Acad&eacute;mica</h3>
		   <div align="center">
             <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
               <tr bgcolor="#C6CFD0" class="Estilo2">
                 <td bgcolor="#C5D5D6"><div align="center"><strong>Modalidad</strong></div></td>
                 <td bgcolor="#C5D5D6"><div align="center"><strong>T&iacute;tulo</strong></div></td>
                 <td bgcolor="#C5D5D6"><div align="center"><strong>Instituci&oacute;n</strong></div></td>
                 <td bgcolor="#C5D5D6"><div align="center"><strong>Lugar</strong></div></td>
                 <td width="70" bgcolor="#C5D5D6"><div align="center"><strong>Fecha</strong></div></td>
               </tr>   
<?php 
             do{  ?>              
                 <tr class="Estilo1">
                   <td align="center"><?php echo $row['nombretipogrado'];?>&nbsp;</td>   
                   <td align="center"><?php echo $row['tituloobtenidohistorialacademico'];?>&nbsp;</td>
                   <td align="center"><?php echo $row['institucionhistorialacademico'];?>&nbsp;</td>             
                   <td align="center"><?php echo $row['lugarhistorialacademico'];?>&nbsp;</td>
                   <td width="70" align="center"><?php echo $row['fechagradohistorialacademico'];?>&nbsp;</td>
                 </tr>
               <?php }while ($row=mysql_fetch_array($sol)); 
			   
	   }    
?>
     </table>
  </div>
 
      <span class="Estilo1">
      <?php $base= "select * from historiallaboral where numerodocumento = '".$_SESSION['numerodocumento']."' order by fechainiciohistoriallaboral";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
     if ($row <> "" )
	  { ?>
	        <h3 align="center" class="Estilo2">Informaci&oacute;n Laboral</h3>		  
		   <div align="center">
		  <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
			<tr bgcolor="#C6CFD0" class="Estilo2">
			  <td bgcolor="#C5D5D6"><div align="center"><strong>Instituci&oacute;n</strong></div></td>
			  <td bgcolor="#C5D5D6"><div align="center"><strong>Cargo</strong></div></td>
			  <td bgcolor="#C5D5D6"><div align="center"><strong>Dedicaci&oacute;n</strong></div></td>
			  <td width="70" bgcolor="#C5D5D6"><div align="center"><strong>Fecha  inicio</strong></div></td>
			  <td width="70" bgcolor="#C5D5D6"><div align="center"><strong>Fecha  fin</strong></div></td>
			  <td bgcolor="#C5D5D6"><div align="center"><strong>Escalaf&oacute;n</strong></div></td>
			</tr>  
	   
<?php   
         do{  ?>       
      <tr class="Estilo1">
        <td align="center"><?php echo $row['empresahistoriallaboral'];?>&nbsp;</td>
        <td align="center"><?php echo $row['cargohistoriallaboral'];?>&nbsp;</td>
        <td align="center"><?php echo $row['tiempohistoriallaboral'];?>&nbsp;</td>
        <td width="70" align="center"><?php echo $row['fechainiciohistoriallaboral'];?>&nbsp;</td>
        <td width="70" align="center"><?php echo $row['fechafinalhistoriallaboral'];?>&nbsp;</td>
        <td align="center"><?php echo $row['escalafondocenciahistoriallaboral'];?>&nbsp;</td>
      </tr>
      <?php }while ($row=mysql_fetch_array($sol)); 
	  
      }
?>
	  </table>                 
    </div>  
<?php
       $base= "select * from facultad,jornadalaboral,tipolabor,detallejornadalaboral,dia 
	           where dia.codigodia = detallejornadalaboral.codigodia
			   and facultad.codigofacultad = jornadalaboral.codigofacultad
			   and tipolabor.codigotipolabor=jornadalaboral.codigotipolabor
			   and jornadalaboral.idjornadalaboral = detallejornadalaboral.idjornadalaboral
			   and jornadalaboral.numerodocumento ='".$_SESSION['numerodocumento']."'
			   order by dia.codigodia,detallejornadalaboral.horainicialdetallejornadalaboral";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);  
        if ($row <> "")
		 {?>
		   <h3 align="center" class="Estilo2">Actividades UnBosque</h3>
           <div align="center">
           <table width="700" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
           <tr bgcolor="#C5D5D6" class="Estilo2">
			<td><div align="center">Actividad</div></td>
			<td><div align="center">Facultad</div></td>
			<td><div align="center">Asignatura</div></td>
			<td><div align="center">Ubicaci&oacute;n</div></td>
			<td><div align="center">D&iacute;a</div></td>
			<td><div align="center">Hora inicio</div></td>
			<td><div align="center">Hora fin</div></td>
			<td><div align="center">Observaciones</div></td>
           </tr>		 
<?php	 
	    do{ ?>
			  <tr class="Estilo1">
			  <td align="center"><?php echo $row['nombretipolabor'];?>&nbsp; </td>
			  <td align="center"><?php echo $row['nombrefacultad'];?>&nbsp; </td>
			  <td align="center"><?php echo $row['codigoasignatura'];?>&nbsp; </td>
			  <td align="center"><?php echo $row['ubicaciondetallejornadalaboral'];?>&nbsp; </td>
			  <td align="center"><?php echo $row['nombredia'];?>&nbsp; </td>
			  <td align="center"><?php echo $row['horainicialdetallejornadalaboral'];?>&nbsp;<?php echo $row['meridianohorainicialdetallejornadalaboral'];?>&nbsp; </td>
			  <td align="center"><?php echo $row['horafinaldetallejornadalaboral'];?>&nbsp;<?php echo $row['meridianohorafinaldetallejornadalaboral'];?>&nbsp; </td>
			  <td align="center"><?php echo $row['observaciondetallejornadalaboral'];?>&nbsp; </td>
			</tr>     
<?php }while ($row=mysql_fetch_array($sol));
	 
	    }
?>
	 </table>
   </div>
 </div>
<?php  $base= "select * from asignaturahistoriallaboral where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
  
      if ($row <> "")
	    {
?>  
           <h3 align="center" class="Estilo2">Materias Dictadas Otras Universidades</h3> 
		   <div align="center">
		   <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
			  <tr bgcolor="#C5D5D6" class="Estilo2">
				<td><div align="center"><strong>Instituci&oacute;n</strong></div></td>
				<td><div align="center"><strong>Facultad</strong></div></td>
				<td><div align="center"><strong>Asignatura</strong></div></td>
			</tr>  
<?php 
         do{  ?>
			<tr class="Estilo1">
			  <td align="center"><?php echo $row['institucionasignaturahistoriallaboral'];?>&nbsp;</td>
			  <td align="center"><?php echo $row['nombrefacultadasignaturahistoriallaboral'];?>&nbsp;</td>
			  <td align="center"><?php echo $row['nombreasignaturahistoriallaboral'];?>&nbsp;</td>
			</tr>
<?php     }while ($row=mysql_fetch_array($sol)); 
		} 
?>
    </table>
  </div>

   <?php $base= "select * from cursoinformaldictado,tipocursodictado where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(cursoinformaldictado.codigotipocursodictado=tipocursodictado.codigotipocursodictado))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	    if ($row <> "")
		 {
	?>	        
           <h3 align="center" class="Estilo2">Cursos Dictados</h3>
           <div align="center">
           <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
          <tr bgcolor="#C5D5D6" class="Estilo2">
			<td><div align="center"><strong>Tipo</strong></div></td>
			<td><div align="center"><strong>Instituci&oacute;n</strong></div></td>
			<td><div align="center"><strong>Disciplina</strong></div></td>
			<td><div align="center"><strong>Nombre</strong></div></td>
			<td><div align="center"><strong>Duraci&oacute;n</strong></div></td>
			<td><div align="center"><strong>Lugar</strong></div></td>
			<td><div align="center"><strong>Evento</strong></div></td>
		  </tr>
	<?php
	   do{  ?>
         <tr class="Estilo1">
          <td align="center"><?php echo $row['nombretipocursodictado'];?>&nbsp;</td>
          <td align="center"><?php echo $row['institucioncursoinformaldictado'];?>&nbsp;</td>
          <td align="center"> <?php echo $row['areacursoinformaldictado'];?>&nbsp;</td>
          <td align="center"><?php echo $row['nombrecursoinformaldictado'];?>&nbsp;</td>
          <td align="center"><?php echo $row['unidadtiempocursoinformaldictado'];?>&nbsp;<?php echo $row['tiempocursoinformaldictado'];?>&nbsp;</td>
          <td align="center"><?php echo $row['lugarcursoinformaldictado'];?>&nbsp;</td>
          <td align="center"><?php echo $row['tipoeventocursoinformaldictado'];?>&nbsp;</td>
          <?php }while ($row=mysql_fetch_array($sol)); 
		  }
		 ?>
           
 <?php      
	mysql_select_db($database_conexion, $conexion);
	$query_Recordset1 = "SELECT * FROM tipocursodictado ORDER BY tipocursodictado.codigotipocursodictado";
	$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
    </table>
  </div>
 </div>
   <?php $base= "select * from investigacion,tipoinvestigacion where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(investigacion.codigotipoinvestigacion=tipoinvestigacion.codigotipoinvestigacion)) ";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
       if ($row <> "")
	    { ?>
		   <h3 align="center" class="Estilo2">Investigaciones o Inventos</h3> 
           <div align="center">
           <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
		  <tr bgcolor="#C5D5D6" class="Estilo2">
			<td><div align="center"><strong>Tipo</strong></div></td>
			<td><div align="center"><strong>T&iacute;tulo</strong></div></td>
			<td><div align="center"><strong>Instituci&oacute;n</strong></div></td>
			<td><div align="center"><strong>Financiamiento</strong></div></td>
			<td><div align="center"><strong>Duraci&oacute;n</strong></div></td>
			<td><div align="center"><strong>Lider</strong></div></td>
			<td><div align="center"><strong>Investigadores</strong></div></td>
		  </tr>
		
   
<?php   
		do{  ?>
			<tr class="Estilo1"><td align="center"><?php echo $row['nombretipoinvestigacion'];?>&nbsp;</td>
			  <td align="center"><?php echo $row['tituloinvestigacion'];?>&nbsp;</td>
			  <td align="center"><?php echo $row['institucioninvestigacion'];?>&nbsp;</td>
			  <td align="center"><?php echo $row['entidadfinanciamientoinvestigacion'];?>&nbsp;</td>
			  <td align="center"><?php echo $row['unidadtiempoinvestigacion'];?>&nbsp;<?php echo $row['tiempoinvestigacion'];?>&nbsp;</td>
			  <td align="center"><?php echo $row['liderinvestigacion'];?>&nbsp;</td>
			  <td align="center"><?php echo $row['cantidadinvestigadores'];?>&nbsp;</td>
<?php   }while ($row=mysql_fetch_array($sol));
      }
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipoinvestigacion";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>          
    </table>
  </div>
 </div> 
   <?php $base= "select * from autoria,tipoautoria where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(autoria.codigotipoautoria=tipoautoria.codigotipoautoria))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	  if ($row <> "")
	   { ?>      
          <h3 align="center" class="Estilo2">Publicaciones</h3>
		 <div align="center">
		   <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
			  <tr bgcolor="#C5D5D6" class="Estilo2">
				<td><div align="center">Modalidad</div></td>
				<td><div align="center"><strong>Referencia</strong></div></td>
				<td><div align="center"><strong>T&iacute;tulo</strong></div></td>
			  </tr>
 
<?php 
		 do{  ?>
			   <tr class="Estilo1">
				  <td align="center"><?php echo $row['nombretipoautoria'];?>&nbsp;</td>
				  <td align="center"><?php echo $row['referenciaautoria'];?>&nbsp;</td>
				  <td align="center"><?php echo $row['nombreautoria'];?>&nbsp;</td>
			  </tr>
<?php    }while ($row=mysql_fetch_array($sol));
       }
?>
    </table>
 </div>

   <?php $base= "select * from condecoracion,tipocondecoracion where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(condecoracion.codigotipocondecoracion=tipocondecoracion.tipocondecoracion))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);   
     
	   if ($row <> "")
	    {  ?>
		    <h3 align="center" class="Estilo2">Premios Recibidos</h3>
            <div align="center">
           <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
             <tr bgcolor="#C5D5D6" class="Estilo2">
             <td><div align="center"><strong>Tipo</strong></div></td>
             <td><div align="center">Nombre</div></td>
             <td><div align="center"><strong>Instituci&oacute;n</strong></div></td>
            </tr> 
<?php  
		  do{  ?>
			  <tr class="Estilo1">
				  <td align="center"><?php echo $row['nombretipocondecoracion'];?>&nbsp;</td>
				  <td align="center"><?php echo $row['nombrecondecoracion'];?>&nbsp;</td>
				  <td align="center"><?php echo $row['institucioncondecoracion'];?>&nbsp;</td>
			  </tr>
		
			  <?php }while ($row=mysql_fetch_array($sol)); 
	    }
	?>
    </table>
 </div>
 
   <?php  $base= "select * from membresia where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
  	    if ($row <> "")
		  {?>
		     <h3 align="center" class="Estilo2">Sociedades y Asociaciones Cient&iacute;ficas </h3>
             <div align="center">
             <table width="700" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
             <tr>
             <td bgcolor="#C5D5D6" align="center" class="Estilo2">Instituci&oacute;n</td>
             </tr>
<?php	 
		 do{  ?>
			<tr>
			  <td class="Estilo1"><div align="center"><?php echo $row['nombremembresia'];?>&nbsp;</div></td>
			</tr>
<?php       }while ($row=mysql_fetch_array($sol)); 
        }	
?>
   </table>
 </div>

   <?php $base= "select * from lengua,idioma where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(lengua.codigoidioma=idioma.codigoidioma))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);  
       if ($row <> "")
	    {?>
            <h3 align="center" class="Estilo2">Idiomas </h3>
            <div align="center">
            <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
		  <tr bgcolor="#C5D5D6" class="Estilo2">
			<td><div align="center"><strong>Idioma</strong></div></td>
			<td><div align="center"><strong>Nivel de conversaci&oacute;n</strong></div></td>
			<td><div align="center"><strong>Nivel de lectura </strong></div></td>
			<td><div align="center"><strong>Nivel de redacci&oacute;n </strong></div></td>
		  </tr>
 <?php 
  do{  ?>
        <tr class="Estilo1">
          <td align="center"><?php echo $row['nombreidioma'];?>&nbsp;</td>
          <td align="center"><?php echo $row['hablalengua'];?>&nbsp;</td>
          <td align="center"><?php echo $row['leelengua'];?>&nbsp;</td>
          <td  align="center"><?php echo $row['escribelengua'];?>&nbsp;</td>
        </tr>
      <?php }while ($row=mysql_fetch_array($sol)); 
       }
?> 
    </table>
  </div>
 </div>
 <br>
 <div align="center" class="style1 style1 Estilo5">
   <input type="button"  onClick="window.print()" value="Imprimir">
 </div>
</form>
