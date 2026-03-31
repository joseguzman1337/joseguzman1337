<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
       $base= "select * from historiallaboral where idhistoriallaboral = '".$_GET['modificar']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      
?>

<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset4 = "SELECT * FROM tipohistoriallaboral";
$Recordset4 = mysql_query($query_Recordset4, $conexion) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 12;
	font-family: Tahoma;
}
.Estilo2 {
	font-size: 14;
	font-family: Tahoma;
}
.Estilo3 {font-size: 12px}
.Estilo5 {font-size: 12px; color: #FF0000; }
-->
</style>

<form name="form1" method="post" action="modificarhistoriallaboral.php">
  <p align="center" class="Estilo2"><strong>MODIFICACI&Oacute;N DE DATOS</strong>

  <div align="center"><span class="Estilo1">
    <?php
$ano = substr($_POST['finicio'],0,4); 
$mes = substr($_POST['finicio'],5,2);
$dia = substr($_POST['finicio'],8,2);

	  	  
 if (($_POST['empresahistoriallaboral'] == "")or($_POST['cargohistoriallaboral'] == "") or ($_POST['tiempohistoriallaboral'] == "")or ($_POST['codigohistoriallaboral'] == 0))
   {?>
    </span>
      <span class="Estilo1">
      </span>
  </div>
  <div align="center" class="Estilo1" >
    <span class="Estilo1"><?php echo  "<h5>Recuerde que los campos con <span class='Estilo5'>*</span> son obligatorios</h5>";
   }
 
 else 

 //if ((!( checkdate($_POST['mes'],$_POST['dia'],$_POST['ano']))or ($_POST['ano'] > date("Y",strtotime($fecha)))or ($_POST['ano'] < 1930))) {
  if (! checkdate($mes, $dia,$ano) or $_POST['finicio'] > date("Y-m-d"))
   {
    echo "<h5>Fecha Incorrecta</h5>";
   }
else 
  if (($_POST['ffinal'] != "") and ($_POST['finicio'] > $_POST['ffinal']))
    {
	  echo "<h5>Fecha Mayor a la Actual</5>";
	}        
else 
     {
     require_once('modificarhistoriallaboral1.php');
	 exit();
     }

    ?>  
    </span></div>  
    <table width="410" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Instituci&oacute;n <span class="Estilo5">*</span></strong></td>
        <td width="240" class="Estilo1"><input name="empresahistoriallaboral" type="text" id="empresahistoriallaboral" value="<?php if (isset($row['empresahistoriallaboral'])) echo $row['empresahistoriallaboral']; else echo  $_POST['empresahistoriallaboral'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Cargo<strong> <span class="Estilo5">*</span></strong></strong></td>
        <td class="Estilo1"><input name="cargohistoriallaboral" type="text" id="cargohistoriallaboral" value="<?php if (isset($row['cargohistoriallaboral'])) echo $row['cargohistoriallaboral']; else echo  $_POST['cargohistoriallaboral'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Dedicaci&oacute;n<strong> <span class="Estilo5">*</span></strong></strong></td>
        <td class="Estilo1">
          <input name="tiempohistoriallaboral" type="text" id="tiempohistoriallaboral" value="<?php if (isset($row['tiempohistoriallaboral'])) echo $row['tiempohistoriallaboral']; else echo  $_POST['tiempohistoriallaboral'];?>">
         </span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Fecha Inicio<strong> <span class="Estilo5">*</span></strong></strong></td>
        <td class="Estilo1">
		<!-- DD
          <input name="dia" type="text" id="dia" value="<?php //echo $dia;?>" size="1">
MM
<input name="mes" type="text" id="mes" value="<?php //echo $mes;?>" size="1">
AAAA</span>
          <input name="ano" type="text" id="ano" value="<?php //echo $ano;?>" size="2"> --> 
	  <input name="finicio" type="text" size="10" value="<?php if(isset($row['fechainiciohistoriallaboral'])) echo $row['fechainiciohistoriallaboral']; else echo $_POST['finicio']; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10">       
	  </td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Fecha Final</strong></td>
        <td class="Estilo1">		<!-- 
          <input name="dia2" type="text" id="dia2" value="<?php //echo $dia2;?>" size="1">
MM
<input name="mes2" type="text" id="mes2" value="<?php //echo $mes2;?>" size="1">
AAAA</span>
          <input name="ano2" type="text" id="ano2" value="<?php //echo $ano2;?>" size="2"> -->
     <input name="ffinal" type="text" size="10" value="<?php if($row['fechafinalhistoriallaboral'] <> "0000-00-00") echo $row['fechafinalhistoriallaboral']; else echo $_POST['ffinal']; ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)" maxlength="10">       
	  </td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Escalaf&oacute;n</strong></td>
        <td class="Estilo1">
          <input name="escalafondocenciahistoriallaboral" type="text" id="escalafondocenciahistoriallaboral" value="<?php if(isset($row['escalafondocenciahistoriallaboral'])) echo $row['escalafondocenciahistoriallaboral']; else echo $_POST['escalafondocenciahistoriallaboral'];?>">
        Para Educador </span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Tipo de Actividad<strong> <span class="Estilo5">*</span></strong></strong></td>
        <td class="Estilo1">
          <select name="codigohistoriallaboral" id="codigohistoriallaboral">
            <option value="value" <?php if (!(strcmp("value", $row['codigohistoriallaboral']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset4['codigotipohistoriallaboral']?>"<?php if (!(strcmp($row_Recordset4['codigotipohistoriallaboral'], $row['codigohistoriallaboral']))) {echo "SELECTED";} ?>><?php echo $row_Recordset4['nombretipohistoriallaboral']?></option>
            <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
          </select>
        </span></td>
      </tr>
  </table>
  </div>
  <p align="center" class=" Estilo1">
    <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
  </p>
  <p align="center" class="Estilo3">
    <input type="submit" name="Submit" value="Modificar">
    </span>     </p>
</form>
<p>
  <span class="Estilo3">
  <?php
mysql_free_result($Recordset4);
?>
  </span>
</p>
