<?php require_once('../../../../Connections/conexion.php');session_start();?>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; }
.Estilo4 {color: #FF0000}
-->
</style>
<body class="Estilo1">
<form name="form1" method="post" action="capacitacion.php">
  <div align="center">
 
    <h6 align="center" class="Estilo3">OTRAS CAPACITACIONES RECIBIDAS </h6>
    <div align="center">
    <?php
       		 
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
        if (! $row){
		 echo "La Información básica es obligatoria";
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
		}  
	  else   
	  
		 do
		{  ?>
    
         <?php echo "<font size='2' face='Tahoma'><strong>",$row['nombresdocente'],"  ",$row['apellidosdocente'],"   ",$row['numerodocumento'],"</strong>";?>
         
          <?php }while ($row=mysql_fetch_array($sol)); 
    
	   
	  $base = "select * from capacitacion c,tipogrado t,pais p 
	          where c.numerodocumento = '".$_SESSION['numerodocumento']."'
			  and c.codigotipogrado=t.codigotipogrado
			  and p.codigopais=c.codigopais
			   order by c.fechacapacitacion";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	   if (! $row)
	  {
	    echo"";
	  }
	  else
	  { ?>
	      <br>&nbsp;</br>
	      <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
           <tr class="style1">
             <td width="75" bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Modalidad</strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Titulo</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Pa&iacute;s</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Anio</div></td>
		     <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo2">Periodo</div></td>
		     <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
           </tr>
<?php  
      	 do{  
?>    
            <tr class="style1">
              <td width="75"><div align="center" class="Estilo1"><?php echo $row['nombretipogrado'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['tituloobtenidocapacitacion'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['nombrepais'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['aniocapacitacion'];?></div></td>
              <td width="70"><div align="center" class="Estilo1"><?php echo $row['periodocapacitacion'];?></div></td>
              <td width="70"><div align="center" class="Estilo1"><?php echo "<a href='modificarcapacitacion.php?idcapacitacion=".$row['idcapacitacion']."'>MODIFICAR</a>" ?></div></td>
              <?php 
				
				}while ($row=mysql_fetch_array($sol)); }
    ?>
              <?php
//
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipogrado";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
      </table>
<?php
 $ano = substr($_POST['fgrado'],0,4); 
 $mes = substr($_POST['fgrado'],5,2);
 $dia = substr($_POST['fgrado'],8,2); 	
	 
   if (($_POST['tituloobtenidocapacitacion'] == "")or($_POST['codigopais'] == "") or ($_POST['periodocapacitacion'] == "")or  ($_POST['aniocapacitacion'] == 0) or (trim($_POST['codigotipocapacitacion']) == "") or (trim($_POST['codigotipofinanciacion']) == "") or (trim($_POST['codigotipogrado']) == "") )
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";   	  
   }  
else 
     {	
     require_once('capturacapacitacion.php');
     }

    ?>
          </p>
    </div>
  <table width="480" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Titulo <span class="Estilo4">*</span></strong></td>
        <td width="240"><input name="tituloobtenidocapacitacion" type="text" id="tituloobtenidocapacitacion" value="<?php echo $_POST['tituloobtenidocapacitacion'];?>" size="40">        </td>
      </tr>
      
     
	  <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Pais <strong> <span class="Estilo4">*</span></strong></strong></td>
        <td><span class="Estilo1">
          <select name="codigopais" id="codigopais">
            <option value="" >Seleccionar</option>
            <?php
$query_Recordset2 = "SELECT * FROM pais";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

do {  
?>
            <option value="<?php echo $row_Recordset2['codigopais']?>"<?php if (!(strcmp($row_Recordset2['codigopais'], $_POST['codigopais']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombrepais']?></option>
            <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
     mysql_data_seek($Recordset2, 0);
	 $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
          </select>
        </span></td>
      </tr>
	  
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; A&ntilde;o<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td>          
          <span class="Estilo1"><!-- DD
          <input name="dia" type="text" id="dia" value="<?php //echo $_POST['dia'];?>" size="1">
          MM
          <input name="mes" type="text" id="mes" value="<?php //echo $_POST['mes'];?>" size="1">
          AAAA</span>          
        <input name="ano" type="text" id="ano" value="<?php // echo $_POST['ano'];?>" size="2"> -->
		<input name="aniocapacitacion" type="text" size="10" value="<?php if(isset($_POST['aniocapacitacion'])) echo $_POST['aniocapacitacion']; else echo "aaaa"; ?>" onBlur="iniciaranio(this)" onFocus="limpiaranio(this)" maxlength="4"></td>
		</td>
      </tr>
	   <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong><strong>&nbsp; </strong>Periodo<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td>
          <select name="periodocapacitacion" id="periodocapacitacion">
            <option value="value" ?>Seleccionar</option>
              <option value="01" <?php if($_POST['periodocapacitacion']=="01") echo "SELECTED";?>>01</option>
              <option value="02" <?php if($_POST['periodocapacitacion']=="02") echo "SELECTED";?>>02</option>
          </select>
		</td>
	</tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Tipo capacitacion <strong> <span class="Estilo4">*</span></strong></strong></td>
        <td><span class="Estilo1">
          <select name="codigotipocapacitacion" id="codigotipocapacitacion">
            <option value="value" <?php if (!(strcmp("value", $_POST['codigotipogrado']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
$query_Recordset3 = "SELECT * FROM tipocapacitacion";
$Recordset3 = mysql_query($query_Recordset3, $conexion) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
			
do {  
?>
            <option value="<?php echo $row_Recordset3['codigotipocapacitacion']?>"<?php if (!(strcmp($row_Recordset3['codigotipocapacitacion'], $_POST['codigotipocapacitacion']))) {echo "SELECTED";} ?>><?php echo $row_Recordset3['nombretipocapacitacion']?></option>
            <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
          </select>
        </span></td>
      </tr>
	       <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Modalidad<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td><span class="Estilo1">
        <select name="codigotipogrado" id="codigotipogrado">
          <option value="value" <?php if (!(strcmp("value", $_POST['codigotipogrado']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['codigotipogrado']?>"<?php if (!(strcmp($row_Recordset1['codigotipogrado'], $_POST['codigotipogrado']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipogrado']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
</span></td>
      </tr>
 
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong> <strong> <strong>&nbsp; </strong>Financiado </strong><strong> <span class="Estilo4">*</span></strong></strong></td>
        <td><select name="codigotipofinanciacion" id="codigotipofinanciacion">
          <option value="value" <?php if (!(strcmp("value", $_POST['codigotipogrado']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
$query_Recordset4 = "SELECT * FROM tipofinanciacion";
$Recordset4 = mysql_query($query_Recordset4, $conexion) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

do {  

?>
          <option value="<?php echo $row_Recordset4['codigotipofinanciacion']?>"<?php if (!(strcmp($row_Recordset4['codigotipofinanciacion'], $_POST['codigotipofinanciacion']))) {echo "SELECTED";} ?>><?php echo $row_Recordset4['nombretipofinanciacion']?></option>
          <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
        </select></td>
		</td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <p>
      <input type="submit" name="Submit" value="Grabar">
</p>
    <p align="right"><strong><span class="Estilo1"><a href="capacitacion.php">Continuar >></a></span> </strong></p>
  </div>
</form>

<script language="javascript">
function limpiarinicio(texto)
{
	if(texto.value == "aaaa-mm-dd")
		texto.value = "";
}

function iniciarinicio(texto)
{
	if(texto.value == "")
		texto.value = "aaaa-mm-dd";
}

function limpiaranio(texto)
{
	if(texto.value == "aaaa")
		texto.value = "";
}

function iniciaranio(texto)
{
	if(texto.value == "")
		texto.value = "aaaa";
}

</script>
<?php
mysql_free_result($Recordset1);
?>
