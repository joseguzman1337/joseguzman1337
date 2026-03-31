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
<form name="form1" method="post" action="academica.php">
  <div align="center">
 
    <h6 align="center" class="Estilo3">FORMACI&Oacute;N ACAD&Eacute;MICA </h6>
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
    
	   
	  $base= "select * from historialacademico,tipogrado 
	          where numerodocumento = '".$_SESSION['numerodocumento']."'
			  and historialacademico.codigotipogrado=tipogrado.codigotipogrado
			  order by historialacademico.fechagradohistorialacademico";
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
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Instituci&oacute;n</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Lugar</div></td>
		     <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo2">Fecha</div></td>
		     <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
           </tr>
<?php  
      	 do{  
?>    
            <tr class="style1">
              <td width="75"><div align="center" class="Estilo1"><?php echo $row['nombretipogrado'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['tituloobtenidohistorialacademico'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['institucionhistorialacademico'];?></div></td>
              <td><div align="center" class="Estilo1"><?php echo $row['lugarhistorialacademico'];?></div></td>
              <td width="70"><div align="center" class="Estilo1"><?php echo $row['fechagradohistorialacademico'];?></div></td>
              <td width="70"><div align="center" class="Estilo1"><?php echo "<a href='modificaracademica.php?modificar=".$row['idhistorialacademico']."'>MODIFICAR</a>" ?></div></td>
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
	 
   if (($_POST['tituloobtenidohistorialacademico'] == "")or($_POST['institucionhistorialacademico'] == "") or ($_POST['lugarhistorialacademico'] == "")or  ($_POST['codigotipogrado'] == 0) or (trim($_POST['codigonbc']) == "") or (trim($_POST['codigopais']) == ""))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";   	  
   }  
 else
   	if (! checkdate($mes, $dia,$ano))
	  {
      echo "<h5>La fecha es incorrecta</5>";
      }
 else 
   if($_POST['fgrado'] > date("Y-m-d"))
    {
	  echo "<h5>La fecha es mayor a la actual</5>";
	}      
else 
     {	
     require_once('capturaacademica.php');
     }

    ?>
          </p>
    </div>
  <table width="480" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Titulo <span class="Estilo4">*</span></strong></td>
        <td width="240"><input name="tituloobtenidohistorialacademico" type="text" id="tituloobtenidohistorialacademico" value="<?php echo $_POST['tituloobtenidohistorialacademico'];?>" size="40">        </td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"class="Estilo1"><strong>&nbsp; Instituci&oacute;n<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td><input name="institucionhistorialacademico" type="text" id="institucionhistorialacademico" value="<?php echo $_POST['institucionhistorialacademico'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"class="Estilo1"><span class="Estilo2"><strong>&nbsp;Codigo programa (SNIES o ICFES) </strong></span> </td>
        <td><input name="codigoprograma" type="text" id="codigoprograma" value="<?php echo $_POST['codigoprograma'];?>" size="40"></td>
      </tr>

	  <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><span class="Estilo2"><strong>&nbsp; Base de conocimiento (NBC SNIES)</strong></span><strong> <strong> <span class="Estilo4">*</span></strong></strong></td>
        <td><span class="Estilo1">
          <select name="codigonbc" id="codigonbc">
            <option value="" >Seleccionar</option>
            <?php
$query_Recordset2 = "SELECT * FROM nbcsnies";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

do {  
?>
            <option value="<?php echo $row_Recordset2['codigonbcsnies']?>"<?php if (!(strcmp($row_Recordset2['codigonbcsnies'], $_POST['codigonbc']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombrenbcsnies']?></option>
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
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Lugar<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td><input name="lugarhistorialacademico" type="text" id="lugarhistorialacademico" value="<?php echo $_POST['lugarhistorialacademico'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Fecha<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td>          
          <span class="Estilo1"><!-- DD
          <input name="dia" type="text" id="dia" value="<?php //echo $_POST['dia'];?>" size="1">
          MM
          <input name="mes" type="text" id="mes" value="<?php //echo $_POST['mes'];?>" size="1">
          AAAA</span>          
        <input name="ano" type="text" id="ano" value="<?php // echo $_POST['ano'];?>" size="2"> -->
		<input name="fgrado" type="text" size="10" value="<?php if(isset($_POST['fgrado'])) echo $_POST['fgrado']; else echo "aaaa-mm-dd"; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10"></td>
		</td>
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
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; <span class="Estilo2">Fecha ECAES<strong> </strong></span></strong></td>
        <td>          
		<input name="fechaecaes" type="text" size="10" value="<?php if(isset($_POST['fechaecaes'])) echo $_POST['fechaecaes']; else echo "aaaa-mm-dd"; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10"></td>
		</td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; <span class="Estilo2">Puntaje ECAES<strong> </strong></span></strong></td>
        <td><input name="puntajeecaes" type="text" id="puntajeecaes" value="<?php echo $_POST['puntajeecaes'];?>" size="40"></td>
      </tr>
    </table>
    <p>
      <input type="submit" name="Submit" value="Grabar">
</p>
    <p align="right"><strong><span class="Estilo1"><a href="historiallaboral.php">Continuar >></a></span> </span></strong></p>
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
</script>
<?php
mysql_free_result($Recordset1);
?>
