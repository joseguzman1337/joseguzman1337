<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../Connections/conexion.php'); ?>
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
$documento=$_GET['documentos'];
if ($_POST['atras'])
{
       echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=consultadocente.php'>";
	   exit ();
}
      $base= "select * from docente,escalafondocente where ((numerodocumento = '".$documento."')and(escalafondocente.codigoescalafondocente=docente.codigoescalafondocente))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	
	   	 do{  ?>
  </div>
 <div align="center" class="Estilo1"><span class="style11"><span class="style2"><strong>VISTA PREVIA</strong></span></span> <br>
  <?php echo "<h4>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"</h4>";?></div>
	 <h3 align="center" class="style1 style1 Estilo5">Informaci&oacute;n Personal</h3>
         <div align="center" class="Estilo1">
<table width="858" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
<tr>
  <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">Sexo:</span></td>
  <td class="style1 style1 Estilo5"><span class="style11"><?php echo $row['sexodocente'];?></span></td>
</tr>
               <tr>
                 <td width="238" bgcolor="#C6CFD0" class="Estilo4"><div class="Estilo5" ><strong>
                   Nacimiento:
               </strong></div></td>
                 <td width="496" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['fechanacimientodocente'];?></span><div align="center"></div></td>
               </tr>
               <tr>
                 <td width="238" bgcolor="#C6CFD0" class="Estilo4"><div class="Estilo5" ><strong>Lugar: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['lugarnacimientodocente'];?></span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Tel&eacute;fono Casa: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['telefonodocente'];?></span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><div class="Estilo5" ><strong>Tel&eacute;fono Oficina: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['telefonodocente2'],"&nbsp;";?></span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Celular: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['celulardocente'],"&nbsp;";?></span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Dirección: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['direcciondocente'];?></span><div align="center"></div></td>
               </tr>
               <tr>
                 <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Ciudad: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['ciudaddocente'];?></span><div align="center"></div></td>
               </tr>
               <tr>
                <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><div class="Estilo5" ><strong>E-mail: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['emaildocente'],"&nbsp;";?></span><div align="center"></div></td>
               </tr>
               <tr>
                 <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Fax: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['faxdocente'],"&nbsp;";?></span><div align="center"></div></td>
               </tr>
               <tr>
                 <td bgcolor="#C6CFD0" class="style1 style1 Estilo5"><span class="Estilo6">
                 <div class="Estilo5" ><strong>Escalaf&oacute;n: </strong></div></td>
                 <td class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['nombreescalafondocente'];?></span><div align="center"></div></td>
               </tr>
               <?php }while ($row=mysql_fetch_array($sol));  ?>
  </table>
  </div>		   
		     <span class="Estilo1">
	         <?php
		   $base= "select * from contratolaboral,tipocontrato,estadotipocontrato where ((estadotipocontrato.codigoestadotipocontrato=contratolaboral.codigoestadotipocontrato)and(tipocontrato.codigotipocontrato=contratolaboral.codigotipocontrato)and(contratolaboral.numerodocumento = '".$documento."'))";
		   $sol=mysql_db_query($database_conexion,$base);
		   $totalRows = mysql_num_rows($sol);
		   $row=mysql_fetch_array($sol); 
	    if ($row <> "")
		 { ?>
		 <h3 align="center" class="style1 style1 Estilo5">Contratos Laborales </h3>		   
		   <div align="center">
		     <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
               <tr bgcolor="#C6CFD0">
                 <td width="109"  class="style1 style1 Estilo5"><div align="center"><strong>NRO CONTRATO </strong></div></td>
                 <td width="113"  class="style1 style1 Estilo5"><div align="center"><strong>FECHA INICIO </strong></div></td>
                 <td width="142"  class="style1 style1 Estilo5"><div align="center"><strong>FECHA FINAL </strong></div></td>
                 <td width="181" class="style1 style1 Estilo5"><div align="center"><strong>TIPO CONTRATO </strong></div></td>
                 <td width="159" class="style1 style1 Estilo5"><div align="center"><strong>ESTADO CONTRATO </strong></div></td>
               </tr>
             </table>
 
 <?php 
 
 do{  ?>		     
	         <table width="858" border="1" cellpadding="1" bordercolor="#003333">
               <tr>
			   <div align="center" class="Estilo1"></div> 
                 <td width="110" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['numerocontratolaboral'];?></span> </td>                           
                 <td width="113" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['fechainiciocontratolaboral'];?></span>                   <div align="center"></div></td>
                 <td width="141" class="style1 style1 Estilo5"><span class="Estilo4"><?php echo $row['fechafinalcontratolaboral'];?></span>                 <div align="center"></div></td>
                 <td width="180" class="style1 style1 Estilo5"><span class="Estilo4"><?php echo $row['nombretipocontrato'];?></span>
                 <td width="160" class="style1 style1 Estilo5"><span class="Estilo4"><?php echo $row['nombreestadotipocontrato'];?></span>                 <div align="center"></div></td>
               </tr>
             </table>
	         <span class="Estilo1">
	         <?php }while ($row=mysql_fetch_array($sol)); 
			 }?>
  
		     </span>
  </div>
		   
       <?php  $base= "select * from historialacademico,tipogrado where ((numerodocumento = '".$documento."')and(historialacademico.codigotipogrado=tipogrado.codigotipogrado))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 	   
       if ($row <> "")
		 { ?> 
          <h3 align="center" class="style1 style1 Estilo5">Formaci&oacute;n Acad&eacute;mica</h3>
		   <div align="center">
             <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
               <tr bgcolor="#C6CFD0">
                 <td width="91"  class="style1 style1 Estilo5"><div align="center"><strong>MODALIDAD</strong></div></td>
                 <td width="170"  class="style1 style1 Estilo5"><div align="center"><strong>TITULO</strong></div></td>
                 <td width="214"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div></td>
                 <td width="113" class="style1 style1 Estilo5"><div align="center"><strong>LUGAR</strong></div></td>
                 <td width="116" class="style1 style1 Estilo5"><div align="center"><strong>FECHA</strong></div></td>
               </tr>
             </table> 
<?php
 do{  ?>           
           
  <div align="center" class="Estilo1">
		     <div align="center">
		       <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
                 <tr>
                   <td width="90" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['nombretipogrado'];?> <div align="center"></div></td>   
                   <td width="171"class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['tituloobtenidohistorialacademico'];?> <div align="center"></div></td>
                   <td width="214" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['institucionhistorialacademico'];?><div align="center"></div></td>             
                   <td width="112" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['lugarhistorialacademico'];?> <div align="center"></div></td>
                   <td width="117" class="style1 style1 Estilo5"> <span class="Estilo4"><?php echo $row['fechagradohistorialacademico'];?><div align="center"></div></td>
                 </tr>
               </table>
		       <span class="Estilo4">
   <?php }while ($row=mysql_fetch_array($sol)); 
			   }
   ?>
             </span> </div>
  </div>
 
      <span class="style1 style1 Estilo5">
      <?php $base= "select * from historiallaboral where numerodocumento = '".$documento."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   if ($row <> "")
		 { ?> 
	    <h3 align="center" class="style1 style1 Estilo5">Informaci&oacute;n Laboral</h3>
  <div align="center">
    <div align="center">
      <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr bgcolor="#C6CFD0">
          <td width="203"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div></td>
          <td width="136"  class="style1 style1 Estilo5"><div align="center"><strong>CARGO</strong></div></td>
          <td width="117"  class="style1 style1 Estilo5"><div align="center"><strong>DEDICACION</strong></div></td>
          <td width="83" class="style1 style1 Estilo5"><div align="center"><strong>FECHA INICIO </strong></div></td>
          <td width="80" class="style1 style1 Estilo5"><div align="center"><strong>FECHA FINAL </strong></div></td>
          <td width="102" class="style1 style1 Estilo5"><div align="center"><strong>ESCALAFON</strong></div></td>
        </tr>
      </table>  
	   
<?php	   
do{  ?>
      </span>
    <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="198" class="style1 style1 Estilo5"><div align="center"></div><?php echo $row['empresahistoriallaboral'];?></td>
        <td width="131" class="style1 style1 Estilo5"><?php echo $row['cargohistoriallaboral'];?></td>
        <td width="114" class="style1 style1 Estilo5"><?php echo $row['tiempohistoriallaboral'];?></td>
        <td width="78" class="style1 style1 Estilo5"><?php echo $row['fechainiciohistoriallaboral'];?></td>
        <td width="78" class="style1 style1 Estilo5"><?php echo $row['fechafinalhistoriallaboral'];?></td>
        <td width="95" class="style1 style1 Estilo5"><?php echo $row['escalafondocenciahistoriallaboral'],"&nbsp;";?></td>
      </tr>
      </table>
      <span class="Estilo1">
      <?php }while ($row=mysql_fetch_array($sol)); 
	  }?>
                 
    </span>
    </div>
 
  </div>
  <div align="center" class="Estilo1">
    <div align="center"><span class="Estilo4">
      <?php
       $base= "select * from facultad,jornadalaboral,tipolabor,detallejornadalaboral,dia where ((dia.codigodia = detallejornadalaboral.codigodia) and (facultad.codigofacultad = jornadalaboral.codigofacultad)and(tipolabor.codigotipolabor=jornadalaboral.codigotipolabor)and (jornadalaboral.idjornadalaboral = detallejornadalaboral.idjornadalaboral)and (jornadalaboral.numerodocumento ='".$documento."')) ";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);  
	  if ($row <> "")
		 { ?>  
	    <h3 align="center" class="style1 style1 Estilo5">Actividades UnBosque</h3>
  <div align="center">
    <table width="858" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td width="84"  class="style1 Estilo3 style1 Estilo5"><div align="center">TIPO LABOR </div></td>
        <td width="101"  class="style1 Estilo3 style1 Estilo5"><div align="center">FACULTAD</div></td>
        <td width="113"  class="style1 Estilo3 style1 Estilo5"><div align="center">ASIGNATURA</div></td>
        <td width="73"  class="style1 Estilo3 style1 Estilo5"><div align="center">UBICACI&Oacute;N</div></td>
        <td width="74"  class="style1 Estilo3 style1 Estilo5"><div align="center">DIA</div></td>
        <td width="91"  class="style1 Estilo3 style1 Estilo5"><div align="center">HORA INICIO </div></td>
        <td width="90"  class="style1 Estilo3 style1 Estilo5"><div align="center">FECHA FINAL</div></td>
        <td width="146"  class="style1 Estilo3 style1 Estilo5"><div align="center">OBSERVACIONES</div></td>
      </tr>
    </table>   
	   
<?php

  do{  ?>
      </span>
    </div>
  </div>
 <div align="center" class="style1 style1 Estilo5"></div>
 <div align="center" class="style1 style1 Estilo5"></div>
 <div align="center" class="Estilo1">
   <div align="center">
     <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr>
          <td width="85" class="style1 style1 Estilo5"><?php echo $row['nombretipolabor'];?></td>
          <td width="102" class="style1 style1 Estilo5"><?php echo $row['nombrefacultad'];?></td>
          <td width="112" class="style1 style1 Estilo5"><?php echo $row['codigoasignatura'];?></td>
          <td width="72" class="style1 style1 Estilo5"><?php echo $row['ubicaciondetallejornadalaboral'];?></td>
          <td width="77" class="style1 style1 Estilo5"><?php echo $row['nombredia'];?></td>
          <td width="89" class="style1 style1 Estilo5"><?php echo $row['horainicialdetallejornadalaboral'];?> &nbsp; <?php echo $row['meridianohorainicialdetallejornadalaboral'];?></td>
          <td width="91" class="style1 style1 Estilo5"><?php echo $row['horafinaldetallejornadalaboral'];?>&nbsp;<?php echo $row['meridianohorafinaldetallejornadalaboral'];?></td>
          <td width="144" class="style1 style1 Estilo5"><?php echo $row['observaciondetallejornadalaboral'];?></td>
        </tr>
     </table>
     <?php }while ($row=mysql_fetch_array($sol)); 
	 }?>
   </div>
 </div>

   <span class="style1 style1 Estilo5">
   <?php  $base= "select * from asignaturahistoriallaboral where numerodocumento = '".$documento."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
 
   if ($row <> "")
	 { ?>  
  
  <h3 align="center" class="style1 style1 Estilo5">Materias Dictadas Otras Universidades</h3>
 
 <div align="center">
   <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td width="259"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div></td>
        <td width="254"  class="style1 style1 Estilo5"><div align="center"><strong>FACULTAD </strong></div></td>
        <td width="212"  class="style1 style1 Estilo5"><div align="center"><strong>ASIGNATURA</strong></div></td>
      </tr>
   </table>  
<?php  
  do{  ?>
   </span>
 </div>
 <div align="center" class="Estilo1">
    <div align="center">
      <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr>
          <td width="260" class="style1 style1 Estilo5"><?php echo $row['institucionasignaturahistoriallaboral'];?></td>
          <td width="253" class="style1 style1 Estilo5"><?php echo $row['nombrefacultadasignaturahistoriallaboral'];?></td>
          <td width="211"class="style1 style1 Estilo5"><?php echo $row['nombreasignaturahistoriallaboral'];?></td>
        </tr>
        <?php }while ($row=mysql_fetch_array($sol)); 
		}?>
      </table>
    </div>
 </div>
 
   <span class="style1 style1 Estilo5">
   <?php $base= "select * from cursoinformaldictado,tipocursodictado where ((numerodocumento = '".$documento."')and(cursoinformaldictado.codigotipocursodictado=tipocursodictado.codigotipocursodictado))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);
	if ($row <> "")
	 { ?>
	 <h3 align="center" class="style1 style1 Estilo5">Cursos Dictados</h3>
 <div align="center">
   <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td width="123"  class="style1 style1 Estilo5"><div align="center"><strong>TIPO CURSO </strong></div></td>
        <td width="122"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div></td>
        <td width="133"  class="style1 style1 Estilo5"><div align="center"><strong>DISCIPLINA</strong></div></td>
        <td width="140" class="style1 style1 Estilo5"><div align="center"><strong>NOMBRE</strong></div></td>
        <td width="98" class="style1 style1 Estilo5"><div align="center"><strong>DURACION</strong></div></td>
        <td width="97" class="style1 style1 Estilo5"><div align="center"><strong>LUGAR</strong></div></td>
        <td width="75" class="style1 style1 Estilo5"><div align="center"><strong>EVENTO</strong></div></td>
      </tr>
   </table>    
<?php	   
	   do{  ?>
   </span>
 </div>
 <div align="center" class="Estilo1">
   <div align="center">
     <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr>
          <td width="122" class="style1 style1 Estilo5"><?php echo $row['nombretipocursodictado'];?> </td>
          
       <td width="123" class="style1 style1 Estilo5"><?php echo $row['institucioncursoinformaldictado'];?> </td>
          <td width="134" class="style1 style1 Estilo5"> <?php echo $row['areacursoinformaldictado'];?></td>
          <td width="142" class="style1 style1 Estilo5"><?php echo $row['nombrecursoinformaldictado'];?></td>
          <td width="97"class="style1 style1 Estilo5"><?php echo $row['unidadtiempocursoinformaldictado'];?>&nbsp;<?php echo $row['tiempocursoinformaldictado'];?></td>
          <td width="95"class="style1 style1 Estilo5"><?php echo $row['lugarcursoinformaldictado'];?></td>
          <td width="73"class="style1 style1 Estilo5"><?php echo $row['tipoeventocursoinformaldictado'];?></td>
          <?php }while ($row=mysql_fetch_array($sol)); 
		  }?>
           
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
 
   <span class="style1 style1 Estilo5">
   <?php $base= "select * from investigacion,tipoinvestigacion where ((numerodocumento = '".$documento."')and(investigacion.codigotipoinvestigacion=tipoinvestigacion.codigotipoinvestigacion)) ";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   if ($row <> "")
	 { ?>
	<h3 align="center" class="style1 style1 Estilo5">Investigaciones o Inventos </h3>
 
 <div align="center">
   <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td width="70"  class="style1 style1 Estilo5"><div align="center"><strong>TIPO</strong></div></td>
        <td width="110"  class="style1 style1 Estilo5"><div align="center"><strong>TITULO</strong></div></td>
        <td width="106"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div></td>
        <td width="107" class="style1 style1 Estilo5"><div align="center"><strong>FINANCIAMIENTO</strong></div></td>
        <td width="71" class="style1 style1 Estilo5"><div align="center"><strong>DURACION</strong></div></td>
        <td width="137" class="style1 style1 Estilo5"><div align="center"><strong>LIDER</strong></div></td>
        <td width="81" class="style1 style1 Estilo5"><div align="center"><strong>CANT. INV. </strong></div></td>
      </tr>
   </table>	   
<?php	   
    do{  ?>
   </span>
 </div>
 <div align="center" class="Estilo1">
    <div align="center">
      <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <td width="72" class="style1 style1 Estilo5"><?php echo $row['nombretipoinvestigacion'];?></td>
          <td width="107" class="style1 style1 Estilo5"><?php echo $row['tituloinvestigacion'];?></td>
          <td width="108" class="style1 style1 Estilo5"><?php echo $row['institucioninvestigacion'];?></td>
          <td width="105" class="style1 style1 Estilo5"><?php echo $row['entidadfinanciamientoinvestigacion'];?></td>
          <td width="72" class="style1 style1 Estilo5"><?php echo $row['unidadtiempoinvestigacion'];?>&nbsp;<?php echo $row['tiempoinvestigacion'];?></td>
          <td width="138" class="style1 style1 Estilo5"><?php echo $row['liderinvestigacion'];?></td>
          <td width="82" class="style1 style1 Estilo5"><?php echo $row['cantidadinvestigadores'];?></td>
          <?php }while ($row=mysql_fetch_array($sol));
		  }?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipoinvestigacion";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
          <div align="center" class="Estilo4">         
          </div>
      </table>
    </div>
 </div>
 
   <span class="style1 style1 Estilo5">
   <?php $base= "select * from autoria,tipoautoria where ((numerodocumento = '".$documento."')and(autoria.codigotipoautoria=tipoautoria.codigotipoautoria))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
  if ($row <> "")
	 { ?>
 <h3 align="center" class="style1 style1 Estilo5">Publicaciones</h3>
 <div align="center">
   <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td width="358"  class="style1 style1 Estilo5"><div align="center"><strong>TITULO</strong></div></td>
        <td width="187"  class="style1 style1 Estilo5"><div align="center"></div>       
        <div align="center"><strong>REFERENCIA</strong></div></td>
        <td width="182"  class="style1 style1 Estilo5"><div align="center"><strong>TIPO DE OBRA </strong></div></td>
      </tr>
   </table>	 
<?php	   
 do{  ?>
   </span>
 </div>
 <div align="center" class="Estilo1">
    <div align="center">
      <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr>
          <td width="359"class="style1 style1 Estilo5"><?php echo $row['nombretipoautoria'];?></td>
          <td width="187" class="style1 style1 Estilo5"><?php echo $row['referenciaautoria'];?></td>
          <td width="180" class="style1 style1 Estilo5"><?php echo $row['nombreautoria'];?></td>
        </tr>
        <?php }while ($row=mysql_fetch_array($sol));
		} ?>
      </table>
    </div>
 </div>
 
   <span class="style1 style1 Estilo5">
   <?php $base= "select * from condecoracion,tipocondecoracion where ((numerodocumento = '".$documento."')and(condecoracion.codigotipocondecoracion=tipocondecoracion.tipocondecoracion))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
  if ($row <> "")
	 { ?>  
	 <h3 align="center" class="style1 style1 Estilo5">Premios Recibidos</h3>
 <div align="center">
   <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td width="221"  class="style1 style1 Estilo5"><div align="center"><strong>NOMBRE PREMIO </strong></div></td>
        <td width="230"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div></td>
        <td width="265"  class="style1 style1 Estilo5"><div align="center"><strong>TIPO DE PREMIO </strong></div></td>
      </tr>
   </table> 
<?php
  do{  ?>
   </span>
 </div>
 <div align="center" class="Estilo1">
    <div align="center">
      <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr>
          <td width="221"class="style1 style1 Estilo5"><?php echo $row['nombretipocondecoracion'];?></td>
          <td width="231"class="style1 style1 Estilo5"><?php echo $row['nombrecondecoracion'];?></td>
          <td width="265" class="style1 style1 Estilo5"><?php echo $row['institucioncondecoracion'];?></td>
        </tr>
      </table>
      <span class="Estilo4">
      <?php }while ($row=mysql_fetch_array($sol)); 
	  }?>
    </span> </div>
 </div> 
   <span class="style1 style1 Estilo5">
   <?php  $base= "select * from membresia where numerodocumento = '".$documento."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
 if ($row <> "")
	 { ?>  
	 <h3 align="center" class="style1 style1 Estilo5">Sociedades y Asociaciones </h3>
	  <div align="center">
   <table width="858" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="738" bgcolor="#C6CFD0"  class="style1 style1 Estilo5"><div align="center"><strong>INSTITUCION</strong></div>       <div align="center"></div>       </td>
      </tr>
  </table>
	 
<?php	 
  	 do{  ?>
   </span>
   <div align="center" class="Estilo1">
      <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr>
          <td width="738" class="style1 style1 Estilo5"><div align="center"><?php echo $row['nombremembresia'];?></div></td>
        </tr>
     </table>
      <?php }while ($row=mysql_fetch_array($sol)); 
	  }?>
   
 </div>
    <span class="style1 style1 Estilo5">
   <?php $base= "select * from lengua,idioma where ((numerodocumento = '".$documento."')and(lengua.codigoidioma=idioma.codigoidioma))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
 if ($row <> "")
	 { ?>
	<h3 align="center" class="style1 style1 Estilo5">Idiomas </h3>
 <div align="center">
   <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td width="165"  class="style1 style1 Estilo5"><div align="center"><strong>IDIOMA</strong></div></td>
        <td width="189"  class="style1 style1 Estilo5"><div align="center"><strong>HABLA</strong></div></td>
        <td width="180"  class="style1 style1 Estilo5"><div align="center"><strong>LEE</strong></div></td>
        <td width="176"  class="style1 style1 Estilo5"><div align="center"><strong>ESCRIBE</strong></div></td>
      </tr>
   </table>	 
<?php	    
  do{  ?>
   </span>
 </div>
 <div align="center" class="Estilo1">
    <div align="center">
      <table width="858" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr>
          <td width="164"  class="style1 style1 Estilo5"><?php echo $row['nombreidioma'];?></td>
          <td width="190"  class="style1 style1 Estilo5"><?php echo $row['hablalengua'];?></td>
          <td width="180"  class="style1 style1 Estilo5"><?php echo $row['leelengua'];?></td>
          <td width="174"  class="style1 style1 Estilo5"><?php echo $row['escribelengua'];?></td>
        </tr>
      </table>
      <?php }while ($row=mysql_fetch_array($sol)); 
	  }?> 
    </div>
 </div>
 <div align="center" class="style1 style1 Estilo5">
   <p>
     <input name="atras" type="submit" id="atras" value="Regresar">
   </p>
 </div>
</form>
