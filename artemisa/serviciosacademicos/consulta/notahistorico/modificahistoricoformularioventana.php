<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require('../../Connections/sala2.php');


$salatmp=$sala;
$id=$_GET['idhistorico'];
$direccion = "modificahistoricoformulario.php";
//$nuevogrupo = $row_maxgrupo['maximogrupo'] + 1;
mysql_select_db($database_sala, $sala);

include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarModuloNota.php');
include_once(realpath(dirname(__FILE__)).'/../../utilidades/Ipidentificar.php');

//identificaicon de la ip del usuario
$A_Validarip = new ipidentificar();
$ip = $A_Validarip->tomarip();
//validacion del ingreso del modulo
$C_ValidarFecha = new ValidarModulo(); 
$alerta = $C_ValidarFecha->ValidarIngresoModulo($_SESSION['usuario'], $ip, 'NotaHistorico-FormularioVentana');
//si el usuario ingresa durante fecha no autorizadas se genera la alerta.
if($alerta)
{
    echo $alerta;
    die;
}


$query_Recordset1 = "SELECT *
					FROM tmpnotahistorico n,materia m,estadonotahistorico e,tiponotahistorico t
					WHERE n.idnotahistorico = '".$_GET['idhistorico']."'
					AND e.codigoestadonotahistorico = n.codigoestadonotahistorico
					AND m.codigomateria = n.codigomateria
					and n.codigotiponotahistorico = t.codigotiponotahistorico										
";	
//echo $query_Recordset1;
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

        mysql_select_db($database_sala, $sala);
		$query_estadonota = "SELECT *
								FROM estadonotahistorico								
								order by 1";		
		$estadonota = mysql_query($query_estadonota, $sala) or die(mysql_error());
		$row_estadonota = mysql_fetch_assoc($estadonota);
		$totalRows_estadonota = mysql_num_rows($estadonota);		

mysql_select_db($database_sala, $sala);
$query_tiponota = "SELECT * FROM tiponotahistorico 
                  ";
$tiponota = mysql_query($query_tiponota, $sala) or die(mysql_error());
$row_tiponota = mysql_fetch_assoc($tiponota);
$totalRows_tiponota = mysql_num_rows($tiponota);

?>
<style type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>

<form name="form1" method="get" action="modificahistoricoformularioventana.php">
 <p align="center" class="Estilo3">Modificaci&oacute;n Historico de Notas</p>
<table width="600"  border="1" align="center" cellpadding="2" bordercolor="#E97914">
  <tr class="Estilo2">
     <td align="center">Código</td>
      <td align="center">Nombre</td>
      <td align="center">Nota</td>
      <td align="center">Tipo nota</td>
      <td align="center">Estado nota</td>
  </tr>
  <tr class="Estilo1">
    <td align="center"><?php echo $row_Recordset1['codigomateria']; ?></td>
    <td><?php echo $row_Recordset1['nombremateria']; ?></td>
    <td align="center">
	<?php echo number_format($row_Recordset1['notadefinitiva'],1);?>
      <input name='nota' type='hidden' value='<?php echo number_format($row_Recordset1['notadefinitiva'],1);?>' size='3' maxlength='3'>
    </div></td>
    <td><div align="center" class="Estilo3">
<?php 
if ($row_Recordset1['codigotiponotahistorico'] <> 100)
 { // tipo nota

?>
	<select name="tiponota" id="tiponota">
			  
	<?php
	  do {  
		   if ($row_tiponota['codigotiponotahistorico'] <> 100)
			 {
	?>
			  <option value="<?php echo $row_tiponota['codigotiponotahistorico']?>"<?php if (!(strcmp($row_tiponota['codigotiponotahistorico'], $row_Recordset1['codigotiponotahistorico']))) {echo "SELECTED";} ?>><?php echo $row_tiponota['nombretiponotahistorico']?></option>
	<?php
			 }
	} while ($row_tiponota = mysql_fetch_assoc($tiponota));
	  $rows = mysql_num_rows($tiponota);
	  if($rows > 0) {
		  mysql_data_seek($tiponota, 0);
		  $row_tiponota = mysql_fetch_assoc($tiponota);
	  }
	?>  </select>    
<?php 
  } // tipo nota
 else
  {
    echo $row_tiponota['nombretiponotahistorico'];
  }
?>	
	</div></td>
	<td><div align="center"><span class="Estilo3">
	    <select name="estadonota" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_estadonota['codigoestadonotahistorico']?>"<?php if (!(strcmp($row_estadonota['codigoestadonotahistorico'], $row_Recordset1['codigoestadonotahistorico']))) {echo "SELECTED";} ?>><?php echo $row_estadonota['nombreestadonotahistorico']?></option>
            <?php
} while ($row_estadonota = mysql_fetch_assoc($estadonota));
  $rows = mysql_num_rows($estadonota);
  if($rows > 0) {
      mysql_data_seek($estadonota, 0);
	  $row_estadonota = mysql_fetch_assoc($estadonota);
  }
?>
        </select>
	  </span></div></td>
  </tr>
   <tr>
     <td colspan="5"><span class="Estilo2">Observaci&oacute;n:<span class="Estilo1">        <input name="observacion" type="text" size="50" value="<?php echo $_GET['observacion'];?>">
        </span></td>
   </tr>
    <tr>
	 <td colspan="5"><div align="center"><span class="Estilo14"><input type="submit" name="Submit" value="Guardar Cambios">&nbsp;&nbsp;<input name="Aceptar" type="button" id="Aceptar" value="Cerrar" onClick="window.close()"></span></div></td>
    </tr>
</table>
<p>
  <input type="hidden" name="idhistorico" value="<?php echo $_GET['idhistorico'];?>">
</p>
<div align="center"></div>
<div align="center"></div>
<?php
$banderagrabar=0;

if ($_GET['Submit'])
 {
		if ((!eregi("^[0-5]{1,1}\.[0-9]{1,1}$", $_GET['nota'])) or ($_GET['nota'] > 5))
		  {
		   echo '<script language="JavaScript">alert("Las Notas se deben Digitar en Formato 0.0 a 5.0 con separador PUNTO(.)")</script>';
		    echo '<script language="JavaScript">history.go(-1)</script>';
		   $banderagrabar = 1;
		   $_GET['Submit'] == false;
		  }
		else
		 if($_GET['observacion'] == "")
		  {
		    echo '<script language="JavaScript">alert("Debe escribir una observación de la modificación realizada")</script>';		    		  
		    echo '<script language="JavaScript">history.go(-1)</script>';
		    $banderagrabar = 1;
		    $_GET['Submit'] == false;
		  }	   
	  	  
	  if ($banderagrabar == 0)
	    {
		  //echo "<h1>sdadasd</h1>";
		  require_once('modificahistoricooperacion.php');
		  //echo "<h1>sdad55555asd</h1>";
		 // exit();
		}
     echo "<script language='javascript'>
			window.opener.recargar('".$direccion."');
			window.opener.focus();
			window.close();
		  </script>";		  
  
 }

?>
</form>
