<?php require_once('../../Connections/egresado.php'); session_start();?>
<style type="text/css">
<!--
.style1 {	font-family: Tahoma;
	font-size: x-small;
}
.Estilo3 {font-weight: bold}
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo4 {font-family: Tahoma}
.Estilo5 {font-size: x-small}
.Estilo6 {
	font-size: x-small;
	font-weight: bold;
}
.style11 {font-family: Tahoma}
.style2 {font-size: x-small}
.style4 {font-size: small}
-->
</style>

<form name="form1" method="post" action="">
<div align="center">
<?php 
$documento=$_SESSION['numerodocumento'];
      $base= "select * from docente
	          where numerodocumento = '".$documento."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
$base1= "select * from carreraegresado c,carrera ca 
	           where c.numerodocumento = '".$_SESSION['numerodocumento']."'			  
			   and c.codigocarrera = ca.codigocarrera";
       $sol1=mysql_db_query($database_conexion,$base1);
	   $totalRows1 = mysql_num_rows($sol1);
       $row1=mysql_fetch_array($sol1);    	   
	
	   	 do{  ?>
  </div>
 <div align="center" class="Estilo1"><span class="style11"><span class="style2"><strong>VISTA PREVIA</strong></span></span> <br>
  <?php echo "<h4>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"</h4>";?></div>
	 <h3 align="center" class="style1 style1 Estilo5">Identificaci&oacute;n del Egresado </h3>
         <div align="center" class="Estilo1">
<table width="700" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
<tr>
  <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">Sexo:</span></td>
  <td class="style1 style1 Estilo5"><span class="style11"><?php echo $row['sexodocente'];?></span></td>
</tr>
               <tr>
                 <td width="238" bgcolor="#C6CFD0" class="Estilo4"><div class="Estilo5" ><strong>
                   Nacimiento:
               </strong></div></td>
                 <td width="496" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['fechanacimientodocente'];?>&nbsp;</span><div align="center"></div></td>
               </tr>
               <tr>
                 <td width="238" bgcolor="#C6CFD0" class="Estilo4"><div class="Estilo5" ><strong>Lugar: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['lugarnacimientodocente'];?>&nbsp;</span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Tel&eacute;fono Casa: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['telefonodocente'];?>&nbsp;</span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><div class="Estilo5" ><strong>Tel&eacute;fono Oficina: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['telefonodocente2'],"&nbsp;";?>&nbsp;</span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Celular: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['celulardocente'],"&nbsp;";?>&nbsp;</span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Dirección: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['direcciondocente'];?>&nbsp;</span><div align="center"></div></td>
               </tr>
               <tr>
                 <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Ciudad: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['ciudaddocente'];?>&nbsp;</span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><div class="Estilo5" ><strong>E-mail: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['emaildocente'],"&nbsp;";?></span><div align="center"></div></td>
               </tr>
               <tr>
                 <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="style2"><strong>Fax: </strong></span></td>
                 <td class="style1 style1 Estilo5"><span class="style11"><?php echo $row['faxdocente'],"&nbsp;";?></span></td>
               </tr>
               <tr>
                 <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong><span class="Estilo2 Estilo1 Estilo6"><strong><span class="Estilo6"><strong>Nombre Especializaci&oacute;n</strong></span>:</strong></span></strong></div></td>
                 <td class="style1 style1 Estilo5"> <div align="left"><?php echo $row1['nombrecarrera'];?></div></td>
               </tr>
               <?php }while ($row=mysql_fetch_array($sol));  ?>
  </table>
  </div>		   
		    
	         
       <?php  $base= "select * from historialacademico,tipogrado where ((numerodocumento = '".$documento."')and(historialacademico.codigotipogrado=tipogrado.codigotipogrado))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 	   
       if ($row <> "")
		 { ?> 
          <h3 align="center" class="style1 style1 Estilo5">Formaci&oacute;n Acad&eacute;mica</h3>
  <div align="center">
             <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
               <tr bgcolor="#C6CFD0">
                 <td width="91"  class="style1 style1 Estilo5"><div align="center"><strong>MODALIDAD</strong></div></td>
                 <td width="170"  class="style1 style1 Estilo5"><div align="center"><strong>TITULO</strong></div></td>
                 <td width="214"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div></td>
                 <td width="113" class="style1 style1 Estilo5"><div align="center"><strong>LUGAR</strong></div></td>
                 <td width="116" class="style1 style1 Estilo5"><div align="center"><strong>FECHA</strong></div></td>
               </tr>             
<?php
 do{  ?>   
               <tr>
                   <td width="90" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['nombretipogrado'];?> <div align="center"></div></td>   
                   <td width="171"class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['tituloobtenidohistorialacademico'];?> <div align="center"></div></td>
                   <td width="214" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['institucionhistorialacademico'];?><div align="center"></div></td>             
                   <td width="112" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['lugarhistorialacademico'];?> <div align="center"></div></td>
                   <td width="117" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['fechagradohistorialacademico'];?><div align="center"></div></td>
        </tr>
               
		       
   <?php }while ($row=mysql_fetch_array($sol)); 
			   }
   ?>
    </table>    
  </div>
  
 
      
      <?php $base= "select * from historiallaboral where numerodocumento = '".$documento."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   if ($row <> "")
		 { ?> 
	    <h3 align="center" class="style1 style1 Estilo5">Ubicaci&oacute;n Laboral</h3>
        <div align="center">
    <div align="center">
      <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr bgcolor="#C6CFD0">
          <td width="203"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div></td>
          <td width="136"  class="style1 style1 Estilo5"><div align="center"><strong>CARGO</strong></div></td>
          <td width="117"  class="style1 style1 Estilo5"><div align="center"><strong>DEDICACION</strong></div></td>
          <td width="83" class="style1 style1 Estilo5"><div align="center"><strong>FECHA INICIO </strong></div></td>
          <td width="80" class="style1 style1 Estilo5"><div align="center"><strong>FECHA FINAL </strong></div></td>
          <td width="102" class="style1 style1 Estilo5"><div align="center"><strong>ESCALAFON</strong></div></td>
        </tr>
 <?php	   
do{  ?>
    
      <tr>
        <td width="198" class="style1 style1 Estilo5"><div align="center"></div><?php echo $row['empresahistoriallaboral'];?></td>
        <td width="131" class="style1 style1 Estilo5"><?php echo $row['cargohistoriallaboral'];?></td>
        <td width="114" class="style1 style1 Estilo5"><?php echo $row['tiempohistoriallaboral'];?></td>
        <td width="78" class="style1 style1 Estilo5"><?php echo $row['fechainiciohistoriallaboral'];?></td>
        <td width="78" class="style1 style1 Estilo5"><?php echo $row['fechafinalhistoriallaboral'];?></td>
        <td width="95" class="style1 style1 Estilo5"><?php echo $row['escalafondocenciahistoriallaboral'],"&nbsp;";?></td>
      </tr>
      
      
      <?php }while ($row=mysql_fetch_array($sol)); 
	  }?>
    </table>             
   
    </div>  
     
   <?php $base= "select * from autoria
                 where numerodocumento = '".$documento."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
  if ($row <> "")
	 { ?>
 <h3 align="center" class="style1 style1 Estilo5">Participaci&oacute;n en Formaci&oacute;n o generaci&oacute;n de Empresa </h3>
 <div align="center">
   <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td width="358"  class="style1 style1 Estilo5"><div align="center"><strong>TITULO</strong></div></td>
        <td width="187"  class="style1 style1 Estilo5"><div align="center"></div>       
        <div align="center"><strong>OBSERVACIÓN</strong></div></td>        
      </tr>
 
<?php	   
 do{  ?>    
        <tr>
          <td width="180" class="style1 style1 Estilo5"><?php echo $row['nombreautoria'];?></td>
          <td width="187" class="style1 style1 Estilo5"><?php echo $row['referenciaautoria'];?></td>          
        </tr>
        <?php }while ($row=mysql_fetch_array($sol));
		} ?>
    </table>
  </div>  
   <?php $base= "select * from condecoracion,tipocondecoracion where ((numerodocumento = '".$documento."')and(condecoracion.codigotipocondecoracion=tipocondecoracion.tipocondecoracion))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
  if ($row <> "")
	 { ?>  
	 <h3 align="center" class="style1 style1 Estilo5">Distinciones Academicas o Profesionales </h3>
     <div align="center">
   <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td width="221"  class="style1 style1 Estilo5"><div align="center"><strong>TIPO DE PREMIO</strong></div></td>
        <td width="230"  class="style1 style1 Estilo5"><div align="center"><strong>NOMBRE PREMIO</strong></div></td>
        <td width="265"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCI&Oacute;N</strong></div></td>
      </tr>
   
<?php
  do{  ?>
         <tr>
          <td width="221"class="style1 style1 Estilo5"><?php echo $row['nombretipocondecoracion'];?></td>
          <td width="231"class="style1 style1 Estilo5"><?php echo $row['nombrecondecoracion'];?></td>
          <td width="265" class="style1 style1 Estilo5"><?php echo $row['institucioncondecoracion'];?></td>
        </tr>   
      <?php }while ($row=mysql_fetch_array($sol)); 
	  }?>
	  </table>
  </div>
 
  
   <?php  $base= "select * from membresia where numerodocumento = '".$documento."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
 if ($row <> "")
	 { ?>  
	 <h3 align="center" class="style1 style1 Estilo5"> Asociaciones Cientificas o Acad&eacute;micas </h3>
	  <div align="center">
   <table width="700" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="738" bgcolor="#C6CFD0"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div><div align="center"></div>       </td>
      </tr>
  
<?php	 
  	 do{  ?>  
        <tr>
          <td width="738" class="style1 style1 Estilo5"><div align="center"><?php echo $row['nombremembresia'];?></div></td>
        </tr>
    
      <?php }while ($row=mysql_fetch_array($sol)); 
	  }?>
    </table>
 </div>
 
 
 
 <?php  $base= "SELECT r.idrespuestaencuesta,i.nombreitemsencuesta,v.nombrevaloracionencuesta  
					FROM respuestaencuesta r,detallerespuestaencuesta dr,itemsencuesta i,valoracionencuesta v 
					WHERE r.idrespuestaencuesta = dr.idrespuestaencuesta
					AND i.iditemsencuesta = dr.iditemsencuesta
					AND v.codigovaloracionencuesta = dr.codigovaloracionencuesta  
					AND r.numerodocumento = '".$documento."'
					AND codigotipoitemsencuesta LIKE '1%'
					ORDER BY 2";                
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
 if ($row <> "")
	 { ?>  
	 <h3 align="center" class="style1 style1 Estilo5"> Respuestas Cuestionario </h3>
	  <div align="center">
   <table width="700" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="738" bgcolor="#C6CFD0"  class="style1 style1 Estilo5"><div align="center"><strong>ASPECTOS</strong></div><div align="center"></div>       </td>
        <td width="738" bgcolor="#C6CFD0"  class="style1 style1 Estilo5"><div align="center"><strong>VALORACIÓN</strong></div><div align="center"></div>       </td>
	  </tr>
  
<?php	 
  	 do{  ?>  
        <tr>
          <td width="700" class="style1 style1 Estilo5"><div align="center"><?php echo $row['nombreitemsencuesta'];?></div></td>
          <td width="700" class="style1 style1 Estilo5"><div align="center"><?php echo $row['nombrevaloracionencuesta'];?></div></td>
		</tr>
    
      <?php }while ($row=mysql_fetch_array($sol)); 
	  }	  
	  ?>
    </table>
 </div>

<?php  $base= "SELECT r.idrespuestaencuesta,i.nombreitemsencuesta,dr.respuestapreguntaabierta  
					FROM respuestaencuesta r,detallerespuestaencuesta dr,itemsencuesta i
					WHERE r.idrespuestaencuesta = dr.idrespuestaencuesta
					AND i.iditemsencuesta = dr.iditemsencuesta					
					AND r.numerodocumento = '".$documento."'
					AND codigotipoitemsencuesta LIKE '2%'
					ORDER BY 2";                
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
 if ($row <> "")
	 { ?>  
	 <h3 align="center" class="style1 style1 Estilo5"> Grado de Satisfación con el programa </h3>
	  <div align="center">
   <table width="700" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="738" bgcolor="#C6CFD0"  class="style1 style1 Estilo5"><div align="center"><strong>ASPECTOS</strong></div><div align="center"></div>       </td>
        <td width="738" bgcolor="#C6CFD0"  class="style1 style1 Estilo5"><div align="center"><strong>VALORACIÓN</strong></div><div align="center"></div>       </td>
	  </tr>
  
<?php	 
  	 do{  ?>  
        <tr>
          <td width="738" class="style1 style1 Estilo5"><div align="center"><?php echo $row['nombreitemsencuesta'];?>&nbsp;</div></td>
          <td width="738" class="style1 style1 Estilo5"><div align="center"><?php echo $row['respuestapreguntaabierta'];?>&nbsp;</div></td>
		</tr>
    
      <?php }while ($row=mysql_fetch_array($sol)); 
	  }	  
	  ?>
    </table>
 </div> 
</form>
