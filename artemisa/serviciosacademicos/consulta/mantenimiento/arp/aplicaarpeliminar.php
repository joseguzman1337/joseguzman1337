<?php 
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
?>
<?php
mysql_select_db($database_sala, $sala);
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica where codigomodalidadacademica='".$_GET['modalidadacademica']."'";
//echo $query_sel_modalidadacademica;
$sel_modalidadacademica = mysql_query($query_sel_modalidadacademica, $sala) or die(mysql_error());
$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
$totalRows_sel_modalidadacademica = mysql_num_rows($sel_modalidadacademica);

mysql_select_db($database_sala, $sala);
$query_tomaideempresasalud = "SELECT idempresasalud, nombreempresasalud FROM empresasalud";
$tomaideempresasalud = mysql_query($query_tomaideempresasalud, $sala) or die(mysql_error());
$row_tomaideempresasalud = mysql_fetch_assoc($tomaideempresasalud);
$totalRows_tomaideempresasalud = mysql_num_rows($tomaideempresasalud);

mysql_select_db($database_sala, $sala);
$query_tomatipoconcepto = "SELECT codigoconcepto, nombreconcepto FROM concepto where codigoreferenciaconcepto='100' order by nombreconcepto ASC";
$tomatipoconcepto = mysql_query($query_tomatipoconcepto, $sala) or die(mysql_error());
$row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto);
$totalRows_tomatipoconcepto = mysql_num_rows($tomatipoconcepto);
?>
<script language="javascript">
function enviar()
{
	document.aplicaarp.submit()
}
</script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<form name="aplicaarp" method="post" action="">
  <p align="center" class="Estilo3">ARP - ELIMINAR REGISTROS</p>
  <table width="58%" border="1" align="center" cellpadding="3" bordercolor="#003333">
    <tr>
      <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica:</div></td>
      <td bgcolor='#FEF7ED'><div align="center"><?php echo $row_sel_modalidadacademica['nombremodalidadacademica'];?></div></td>
    </tr>
    <tr>
      <td width="51%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Aplicaci&oacute;n Masiva: </div></td>
      <td width="49%" bgcolor='#FEF7ED'><div align="center">SI
          <input name="masivo" type="radio" value="si" onClick="enviar()"<?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){echo 'checked="checked"';}?> />
NO
<input name="masivo" type="radio" value="no" onClick="enviar()" <?php if(isset($_POST['masivo']) and $_POST['masivo']=='no'){echo 'checked="checked"';}?> />
      </div></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
        <input name="Regresar" type="submit" id="Regresar" value="Regresar">
      </div></td>
    </tr>
	<?php if(isset($_POST['masivo']) and $_POST['masivo']=='no'){ mysql_select_db($database_sala, $sala);
	$query_sel_codigocarrera = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
		WHERE c.codigomodalidadacademica = '".$_GET['modalidadacademica']."' 
		AND c.codigocarrera IN (SELECT codigocarrera FROM aplicaarp WHERE codigotipoaplicaarp='100')";
	$sel_codigocarrera = mysql_query($query_sel_codigocarrera, $sala) or die(mysql_error());
	$row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera);
$totalRows_sel_codigocarrera = mysql_num_rows($sel_codigocarrera);?>
	<tr>
      <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione carreras:
        </div>        <div align="center"></div></td>
      <td bgcolor="#CCDADD" class="Estilo2">
	  <select name="selcodigocarrera" id="selcodigocarrera" onchange="enviar()">
	  <option value="">Seleccionar</option>
	    <?php
	    do {
?>
	    <option value="<?php echo $row_sel_codigocarrera['codigocarrera']?>"<?php if(isset($_POST['selcodigocarrera'])){if($_POST['selcodigocarrera'] == $row_sel_codigocarrera['codigocarrera']){echo "selected";}}?>><?php echo $row_sel_codigocarrera['nombrecarrera']?></option>
	    <?php
	    } while ($row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera));
	    $rows = mysql_num_rows($sel_codigocarrera);
	    if($rows > 0) {
	    	mysql_data_seek($sel_codigocarrera, 0);
	    	$row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera);
	    }
?>
      </select>
	  <input type="submit" name="Anular" value="Anular" />
	  <?php } ?>
      <?php if(isset($_POST['masivo']) and $_POST['masivo']=='si' or isset($_POST['Enviar'])){ 
      	mysql_select_db($database_sala, $sala);
      	$query_carrerapormodalidad = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
		WHERE c.codigomodalidadacademica = '".$_GET['modalidadacademica']."' 
		AND c.codigocarrera IN (SELECT codigocarrera FROM aplicaarp WHERE codigotipoaplicaarp='100')";
      	$carrerapormodalidad = mysql_query($query_carrerapormodalidad, $sala) or die(mysql_error());
      	$row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad);
      	$totalRows_carrerapormodalidad = mysql_num_rows($carrerapormodalidad);


   ?></td>
    </tr>
	
	<?php 
	do{
		$chequear="";
		//$query_verifica_chequeado="select idaplicaarp from aplicaarp where codigoperiodo='20061' and codigocarrera='".$row_carrerapormodalidad['codigocarrera']."' and codigotipoaplicaarp='100'";
		//echo $query_verifica_chequeado;
		//$verifica_chequeado=mysql_query($query_verifica_chequeado,$sala);
		//$verifica_chequeado_detalle=mysql_fetch_assoc($verifica_chequeado);
		//$row_verifica_chequeado=mysql_num_rows($verifica_chequeado);
		//if ($row_verifica_chequeado > 0){$chequear="checked";}
		echo "<tr><td bgcolor='#CCDADD' class='Estilo2'>".$row_carrerapormodalidad['nombrecarrera']."&nbsp;</td>
		  <td bgcolor='#FEF7ED'><input type='checkbox' name='carreras".$row_carrerapormodalidad['codigocarrera']."' $chequear value='".$row_carrerapormodalidad['codigocarrera']."'>&nbsp;</td></tr>";}
		while ($row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad));
	  ?>
	
	<tr>
      <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
        <input type="submit" name="Anular" value="Anular" />
        &nbsp;
        <input name="Regresar" type="submit" id="Regresar" value="Regresar">
      </div></td>
    </tr>
	<?php } ?>
  </table>
  <br>
<?php  
if(isset($_POST['masivo']) and $_POST['masivo']=="no"){
	@$query_consultacarrera = "SELECT * FROM aplicaarp a
WHERE a.codigocarrera = '".$_POST['selcodigocarrera']."' and codigotipoaplicaarp='100'";
	$consultacarrera = mysql_query($query_consultacarrera, $sala) or die(mysql_error());
	$row_consultacarrera= mysql_fetch_assoc($consultacarrera);
	//echo $query_consultacarrera;
	//print_r($row_consultacarrera);
	//print_r($_POST);
;}?>
<?php	
if(isset($_POST['masivo']) and $_POST['masivo']=="no"){ ?>

  <table width="58%" border="1" align="center" cellpadding="3" bordercolor="#003333">
    <tr>
      <td width="28%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Aplica ARP<span class="Estilo4">*</span></div></td>
      <td width="72%" bgcolor='#FEF7ED'><p class="style2">
          <input name="nombreaplicaarp" type="text" id="nombreaplicaarp" value="<?php if($_POST['masivo']=="no"){echo $row_consultacarrera['nombreaplicaarp'];}?>" />
      </p></td>
    </tr>
    <tr>
      <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Empresa de Salud <span class="Estilo4">*</span></div></td>
      <td bgcolor='#FEF7ED'><select name="idempresasalud" id="idempresasalud">
          <option value="">Seleccionar</option>
          <?php
          do {
?>
          <option value="<?php echo $row_tomaideempresasalud['idempresasalud']?>"<?php if($_POST['masivo']=="no"){if($row_tomaideempresasalud['idempresasalud']==$row_consultacarrera['idempresasalud']){echo "selected";};}?>><?php echo $row_tomaideempresasalud['nombreempresasalud']?></option>
          <?php
          } while ($row_tomaideempresasalud = mysql_fetch_assoc($tomaideempresasalud));
          $rows = mysql_num_rows($tomaideempresasalud);
          if($rows > 0) {
          	mysql_data_seek($tomaideempresasalud, 0);
          	$row_tomaideempresasalud = mysql_fetch_assoc($tomaideempresasalud);
          }
?>
        </select>
      </td>
    </tr>
    <tr>
      <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Porcentaje Aplica ARP <span class="Estilo4">*</span></div></td>
      <td bgcolor='#FEF7ED'><input name="porcentajeaplicaarp" type="text" id="porcentajeaplicaarp" value="<?php if($_POST['masivo']=="no"){echo $row_consultacarrera['porcentajeaplicaarp'];}?>"/></td>
    </tr>
    <tr>
      <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor fijo Aplica ARP <span class="Estilo4">*</span></div></td>
      <td bgcolor='#FEF7ED'><input name="valorfijoaplicaarp" type="text" id="valorfijoaplicaarp" value="<?php if($_POST['masivo']=="no"){echo $row_consultacarrera['valorfijoaplicaarp'];}?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor base Aplica ARP<span class="Estilo4">*</span></div></td>
      <td bgcolor='#FEF7ED'><input name="valorbaseaplicaarp" type="text" id="valorbaseaplicaarp" value="<?php if($_POST['masivo']=="no"){echo $row_consultacarrera['valorbaseaplicaarp'];}?>"></td>
    </tr>
    <tr>
      <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto<span class="Estilo4">*</span></div></td>
      <td bgcolor='#FEF7ED'>
	  <select name="codigoconcepto" id="codigoconcepto">
		  <?php
		  do {
?>
          <option value="<?php echo $row_tomatipoconcepto['codigoconcepto']?>"<?php if($_POST['masivo']=="no"){if($row_tomatipoconcepto['codigoconcepto']==$row_consultacarrera['codigoconcepto']){echo "selected";};}?>><?php echo $row_tomatipoconcepto['nombreconcepto']?></option>
          <?php
		  } while ($row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto));
		  $rows = mysql_num_rows($tomatipoconcepto);
		  if($rows > 0) {
		  	mysql_data_seek($tomatipoconcepto, 0);
		  	$row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto);
		  }
?>
        </select>
      </td>
    </tr>
    <tr>
      <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Semestre inicio de aplicaci&oacute;n ARP <span class="Estilo4">*</span></div></td>
      <td bgcolor='#FEF7ED'><input name="semestreinicioaplicaarp" type="text" id="semestreinicioaplicaarp"  value="<?php if($_POST['masivo']=="no"){echo $row_consultacarrera['semestreinicioaplicaarp'];}?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Semestre final de aplicaci&oacute;n ARP <span class="Estilo4">*</span></div></td>
      <td bgcolor='#FEF7ED'><input name="semestrefinalaplicaarp" type="text" id="semestrefinalaplicaarp"  value="<?php if($_POST['masivo']=="no"){echo $row_consultacarrera['semestrefinalaplicaarp'];}?>"/></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">      </div></td>
    </tr>
  </table>
  
  <?php } ?>
  <?php if (isset($_POST['selcodigocarrera'])){ ?>
  
  
    <?php } ?>
    
    <?php 
    if (isset($_POST['Anular']) and  $_POST['masivo']=='no')
    {
    			$query_fechas_periodo ="SELECT p.codigoperiodo,p.fechainicioperiodo,p.fechavencimientoperiodo FROM periodo p WHERE p.codigoperiodo='".$_GET['codigoperiodo']."'";
		$fechas_periodo = mysql_query($query_fechas_periodo, $sala);
		$row_fechas=mysql_fetch_assoc($fechas_periodo);
    	$query_modificar_aplicaarp="update aplicaarp set codigotipoaplicaarp='200' WHERE codigocarrera = '".$_POST['selcodigocarrera']."' and codigotipoaplicaarp='100' and codigoperiodo='".$_GET['codigoperiodo']."'";
    	//echo $query_modificar_aplicaarp;
    	$modificar_aplicaarp=mysql_query($query_modificar_aplicaarp,$sala) or die($query_modificar_aplicaarp.mysql_error());
    	if($modificar_aplicaarp)
    	{
    		echo "<script language='javascript'>Alert('Datos modificados correctamente')</script>";
    		echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?modalidadacademica=".$_GET['modalidadacademica']."');</script>";}
    		else{echo mysql_error();
    	}
    }
    ?>
     <?php 
     if (isset($_POST['Anular']) and $_POST['masivo']=='si')
     {

     	mysql_select_db($database_sala, $sala);
     	$query_carrerapormodalidad_in = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
WHERE c.codigomodalidadacademica = '".$_GET['modalidadacademica']."' ";
     	$carrerapormodalidad_in = mysql_query($query_carrerapormodalidad_in, $sala) or die(mysql_error());
     	$row_carrerapormodalidad_in = mysql_fetch_array($carrerapormodalidad_in);
     	do{

     		foreach($_POST as $vpost => $valor)
     		{
     			if (ereg("carreras".$row_carrerapormodalidad['codigocarrera']."",$vpost))
     			{
     				$query_modificar_aplicaarp="update aplicaarp set codigotipoaplicaarp='200' WHERE codigocarrera = '".$_POST[$vpost]."' and codigotipoaplicaarp='100' and codigoperiodo='".$_GET['codigoperiodo']."'";
     				//echo $query_modificar_aplicaarp;echo "<br>";
     				$modificar_aplicaarp=mysql_query($query_modificar_aplicaarp,$sala) or die($query_modificar_aplicaarp.mysql_error());
     				if($modificar_aplicaarp){}else{echo mysql_error();}
     			}
     		}
     	}
     	while ($row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad));
     	echo "<script language='javascript'>Alert('Datos modificados correctamente')</script>";
     	echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?modalidadacademica=".$_GET['modalidadacademica']."');</script>";}
    ?>
  
    
  <p>&nbsp;</p>
</form>
<?php if(isset($_POST['Regresar']))
{
	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
}
?>

<?php
@mysql_free_result($sel_modalidadacademica);

@mysql_free_result($sel_codigocarrera);
?>
