<?php require_once('../../../../Connections/conexion.php');session_start();?>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: 12px;
}
.Estilo2 {font-size: 14px}
.Estilo3 {color: #FF0000}
-->
</style>
<body class="Estilo1"><form name="form1" method="post" action="historiallaboral.php">
  <div align="center">
    <h6 class="style1 style2 style7 Estilo2"><strong>HISTORIA LABORAL </strong></h6>
    <p class="style1">
      <?php
       		
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
        if (! $row){
		 echo "La información básica es obligatoria";
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
		}  
	  else   
		 do
		{  ?>
      <?php echo "<font size='2' face='Tahoma'><strong>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"";?>
      <?php }while ($row=mysql_fetch_array($sol)); 
    
	
	   $base= "select * from historiallaboral 
	           where numerodocumento = '".$_SESSION['numerodocumento']."'
			   order by fechainiciohistoriallaboral";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  {?>
	      <br>&nbsp;</br>
    <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr class="style1">
        <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Instituci&oacute;n</strong></div></td>
		<td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Cargo</strong></div></td>
		<td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Dedicaci&oacute;n</strong></div></td>
        <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Fecha inicio</strong></div></td>
   	    <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Fecha  fin </strong></div></td>
		<td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Escalaf&oacute;n</strong></div></td>
	    <td bgcolor="#C5D5D6">&nbsp;</td>
      </tr>
<?php  
		 do{  ?>
      <td class="Estilo1"><div align="center"><?php echo $row['empresahistoriallaboral'];?></div></td>
          <td class="Estilo1"><div align="center"><?php echo $row['cargohistoriallaboral'];?></div></td>
          <td class="Estilo1"><div align="center"><?php echo $row['tiempohistoriallaboral'];?></div></td>
        <td width="70" class="Estilo1"><div align="center"><?php echo $row['fechainiciohistoriallaboral'];?></div></td>
        <td width="70" class="Estilo1"><div align="center"><?php if ($row['fechafinalhistoriallaboral'] == "0000-00-00") echo "Vigente"; else echo $row['fechafinalhistoriallaboral'];?></div></td>
          <td class="Estilo1"><div align="center"><?php echo $row['escalafondocenciahistoriallaboral'];?>&nbsp;</div></td>
          <td class="Estilo1"><div align="center"><?php echo "<a href='modificarhistoriallaboral.php?modificar=".$row['idhistoriallaboral']."'>MODIFICAR</a>" ?></div></td>
         </tr>
		  <?php }while ($row=mysql_fetch_array($sol));
	}
//
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipohistoriallaboral";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
    </table>
    <span class="Estilo1"><br>
<?php
$ano = substr($_POST['finicio'],0,4); 
$mes = substr($_POST['finicio'],5,2);
$dia = substr($_POST['finicio'],8,2);

	 	
   if (($_POST['empresahistoriallaboral'] == "")or($_POST['cargohistoriallaboral'] == "") or ($_POST['tiempohistoriallaboral'] == "")or ($_POST['codigohistoriallaboral'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo3'>*</span> son obligatorios</h5>";
   }
else 

// if ((!( checkdate($_POST['mes'],$_POST['dia'],$_POST['ano']))or ($_POST['ano2'] < date("Y",strtotime($_POST['ano'])))or ($_POST['ano'] < 1930))) 
  if (! checkdate($mes, $dia,$ano) or $_POST['finicio'] > date("Y-m-d"))
	 {     
	   echo "<h5>La fecha es incorrecta</h5>";
	 }
else
  if (($_POST['ffinal'] != "") and ($_POST['finicio'] > $_POST['ffinal']))
	 {     
	   echo "<h5>La fecha inicial es mayor a la final</h5>";
	 }
else
     {
     require_once('capturahistoriallaboral.php');
     }

    ?>
    </span>
    <table width="410" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Instituci&oacute;n <span class="Estilo3">*</span></strong></td>
        <td width="240" class="style1"><input name="empresahistoriallaboral" type="text" id="empresahistoriallaboral" value="<?php echo $_POST['empresahistoriallaboral'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Cargo<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td class="style1"><input name="cargohistoriallaboral" type="text" id="cargohistoriallaboral" value="<?php echo $_POST['cargohistoriallaboral'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Dedicaci&oacute;n<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td class="style1"><input name="tiempohistoriallaboral" type="text" id="tiempohistoriallaboral" value="<?php echo $_POST['tiempohistoriallaboral'];?>"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Fecha Inicio<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td class="Estilo1"><!-- DD
              <input name="dia" type="text" id="dia" value="<?php //echo $_POST['dia'];?>" size="1">
MM
<input name="mes" type="text" id="mes" value="<?php //echo $_POST['mes'];?>" size="1">
AAAA</span>
            <input name="ano" type="text" id="ano" value="<?php //echo $_POST['ano'];?>" size="2"> -->
 <input name="finicio" type="text" size="10" value="<?php if(isset($_POST['finicio'])) echo $_POST['finicio']; else echo "aaaa-mm-dd"; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10">       
		</span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Fecha Final</strong></td>
        <td class="Estilo1"><!-- DD
              <input name="dia2" type="text" id="dia2" value="<?php //echo $_POST['dia2'];?>" size="1">
MM
<input name="mes2" type="text" id="mes2" value="<?php //echo $_POST['mes2'];?>" size="1">
AAAA</span>
            <input name="ano2" type="text" id="ano2" value="<?php //echo $_POST['ano2'];?>" size="2"> -->
        <input name="ffinal" type="text" size="10" value="<?php if(isset($_POST['ffinal'])) echo $_POST['ffinal']; else echo "aaaa-mm-dd"; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10">       
		</span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Escalaf&oacute;n</strong></td>
        <td class="Estilo1"><input name="escalafondocenciahistoriallaboral" type="text" id="escalafondocenciahistoriallaboral" value="<?php echo $_POST['escalafondocenciahistoriallaboral'];?>"> 
        Para Educador </td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Tipo de Actividad<strong> <span class="Estilo3">*</span></strong></strong></td>
        <td class="style1"><select name="codigohistoriallaboral" id="codigohistoriallaboral">
          <option value="value" <?php if (!(strcmp("value", $_POST['codigohistoriallaboral']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['codigotipohistoriallaboral']?>"<?php if (!(strcmp($row_Recordset1['codigotipohistoriallaboral'], $_POST['codigohistoriallaboral']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipohistoriallaboral']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select></td>
      </tr>
    </table>
    <p class="style1">
      <input type="submit" name="Submit" value="Grabar">
</p>
    <p align="right" class="style1"><strong><span class="style7"><span class="Estilo8"><a href="contratolaboral.php">Continuar >></a></span></span></strong> </p>
  </div>
</form>
<?php
mysql_free_result($Recordset1);
?>

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

