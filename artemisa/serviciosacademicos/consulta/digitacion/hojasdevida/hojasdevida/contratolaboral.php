<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipocontrato";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT * FROM estadotipocontrato";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; }
.Estilo3 {font-size: 14px}
.Estilo4 {color: #FF0000}
-->
</style>
<body class="Estilo2"><form name="form1" method="post" action="contratolaboral.php">
  <p align="center" class="Estilo3"><strong>CONTRATOS LABORALES  </strong></p> 
  <div align="center">
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
    
         <?php echo "<font size='2' face='Tahoma'><strong>",$row['nombresdocente'],"  ",$row['apellidosdocente'],"   ",$row['numerodocumento'],"";?>
         
          <?php }while ($row=mysql_fetch_array($sol)); 
    
	   
	   $base= "select * from contratolaboral,tipocontrato,estadotipocontrato 
	           where estadotipocontrato.codigoestadotipocontrato=contratolaboral.codigoestadotipocontrato
			   and tipocontrato.codigotipocontrato=contratolaboral.codigotipocontrato
			   and contratolaboral.numerodocumento = '".$_SESSION['numerodocumento']."'
			   order by contratolaboral.fechainiciocontratolaboral";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	  if (! $row)
	  {
	    echo"";
	  }
	  else
	  { ?>
	      <div align="center">&nbsp;</br>
	      <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
           <tr>
             <td bgcolor="#C5D5D6"><div align="center" class="Estilo2"><strong>N&ordm; contrato</strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2"><strong>Fecha de inicio </strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2"><strong>Fecha final</strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2"><strong>Tipo contrato </strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2"><strong>Estado</strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
           </tr>
<?php 
      	 do{  ?>     
            <tr>
              <td><div align="center" class="Estilo2"><?php echo $row['numerocontratolaboral'];?></span></div></td>
              <td><div align="center" class="Estilo2"><?php echo $row['fechainiciocontratolaboral'];?></span></div></td>
              <td><div align="center" class="Estilo2"><?php if ($row['fechafinalcontratolaboral'] == "0000-00-00") echo "Vigente"; else echo $row['fechafinalcontratolaboral'];?></span></div></td>
              <td><div align="center" class="Estilo2"><?php echo $row['nombretipocontrato'];?></span></span></div></td>
              <td><div align="center" class="Estilo2"><?php echo $row['nombreestadotipocontrato'];?></span></div></td>
              <td><div align="center" class="Estilo2"><?php echo "<a href='modificarcontratolaboral.php?modificar=".$row['idcontratolaboral']."'>MODIFICAR</a>" ?></span></div></td>
            </tr>
	      <?php 
		  }while ($row=mysql_fetch_array($sol)); }?>
	 </table>
	<?php	
$ano = substr($_POST['finicio'],0,4); 
$mes = substr($_POST['finicio'],5,2);
$dia = substr($_POST['finicio'],8,2);
 
   if (($_POST['numerocontratolaboral'] == "") or ($_POST['codigotipocontrato'] == 0)or ($_POST['codigoestadotipocontrato'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
    
   }  
 else 
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
   if($_POST['ano'] > date("Y",time()))
    {
	  echo "<h5>La fecha es mayor a la actual</5>";
	}     
	
else    
    {	
     require_once('capturacontratolaboral.php');
    }

    ?>
  
  </div>

 <table width="400" border="1" align="center" cellpadding="1" cellspacing="2"  bordercolor="#003333">
    <tr>
      <td width="147" bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; N&uacute;mero Contrato <span class="Estilo4">*</span></strong></td>
      <td><input name="numerocontratolaboral" type="text" id="numerocontratolaboral" value="<?php echo $_POST['numerocontratolaboral'];?>" size="15"></td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6"class="Estilo2"><strong>&nbsp; Fecha Inicio<strong> <span class="Estilo4">*</span></strong></strong></td>
      <td><span class="Estilo2">
	  <!-- DD
              <input name="dia" type="text" id="dia" value="<?php ///echo $_POST['dia'];?>" size="1">
MM
<input name="mes" type="text" id="mes" value="<?php ///echo $_POST['mes'];?>" size="1">
AAAA</span>
      <input name="ano" type="text" id="ano" value="<?php //echo $_POST['ano'];?>" size="2">  -->
	       
 <input name="finicio" type="text" size="10" value="<?php if(isset($_POST['finicio'])) echo $_POST['finicio']; else echo "aaaa-mm-dd"; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10">

</td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Fecha Final</strong></td>
      <td><span class="Estilo2">
	  <!-- DD
              <input name="dia2" type="text" id="dia2" value="<?php //echo $_POST['dia2'];?>" size="1">
MM
<input name="mes2" type="text" id="mes2" value="<?php ///echo $_POST['mes2'];?>" size="1">
AAAA</span>
      <input name="ano2" type="text" id="ano2" value="<?php //echo $_POST['ano2'];?>" size="2"> -->
	  <input name="ffinal" type="text" size="10" value="<?php if(isset($_POST['ffinal'])) echo $_POST['ffinal']; else echo "aaaa-mm-dd"; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10">
	  </td>
    </tr>
    <tr>
    <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Tipo de Contrato<strong> <span class="Estilo4">*</span></strong></strong></td>
      <td><select name="codigotipocontrato" id="codigotipocontrato">
        <option value="" <?php if (!(strcmp("", $_POST['codigotipocontrato']))) {echo "SELECTED";} ?>>Seleccionar</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['codigotipocontrato']?>"<?php if (!(strcmp($row_Recordset1['codigotipocontrato'], $_POST['codigotipocontrato']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipocontrato']?></option>
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
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Estado de Contrato <strong> <span class="Estilo4">*</span></strong></strong></td>
      <td><select name="codigoestadotipocontrato" id="codigoestadotipocontrato">
        <option value="" <?php if (!(strcmp("", $_POST['codigoestadotipocontrato']))) {echo "SELECTED";} ?>>Seleccionar</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['codigoestadotipocontrato']?>"<?php if (!(strcmp($row_Recordset2['codigoestadotipocontrato'], $_POST['codigoestadotipocontrato']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombreestadotipocontrato']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
  </table>
  <p align="center"><input type="submit" name="Submit" value="Grabar">
  </p>
  <p align="right"><strong><span class="Estilo1"><a href="jornadalaboral.php">Continuar >></a></strong> </p>
</form>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
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