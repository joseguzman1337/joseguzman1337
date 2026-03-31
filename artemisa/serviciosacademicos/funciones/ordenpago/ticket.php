<?php 
require_once('Cimpresionescyc.php' );
mysql_select_db($database_sala, $sala);
session_start();

$numeroordenpago = $_GET['ordenpago'];

$query_ordenespagadaspse= "select eg.numerodocumento, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, 
BankProcessDate, TransValue, Reference1, FIName, TrazabilityCode, StaCode, SoliciteDate, TicketId
from LogPagos lp, estudiantegeneral eg, ordenpago o, estudiante e
where lp.Reference1 = o.numeroordenpago
and o.codigoestudiante = e.codigoestudiante
and e.idestudiantegeneral = eg.idestudiantegeneral
and lp.Reference1 = '$numeroordenpago'
and StaCode <> 'CUADRAR TICKET'
order by TicketId desc";
//and dop.codigoconcepto = '151'
//echo "<br>$query_ordenespagadaspse<br>";
$ordenespagadaspse=mysql_db_query($database_sala,$query_ordenespagadaspse);
$totalRows_ordenespagadaspse = mysql_num_rows($ordenespagadaspse);
$row_ordenespagadaspse=mysql_fetch_array($ordenespagadaspse);
?>
<html>
<head>
<title>Comprobante de pago</title><meta http-equiv='Content-Type' content='text/html; charset=utf-8'></head>
<style type='text/css'>
<!--
.textogris {font-family: Tahoma; font-size: 12px;  }
.Estilo1 {font-family: Tahoma; font-size: 12px; ; color:#808080; font-weight: bold;}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
.style1 {color: #FF0000}
-->
</style>
<body>
<?php
$query_universidad = "SELECT direccionuniversidad,c.nombreciudad,p.nombrepais,u.paginawebuniversidad,u.imagenlogouniversidad,u.telefonouniversidad,u.faxuniversidad,u.nituniversidad,u.personeriauniversidad,u.entidadrigeuniversidad
FROM universidad u,ciudad c,pais p,departamento d 
WHERE u.iduniversidad = 1
AND d.idpais = p.idpais
AND u.idciudad = c.idciudad
AND c.iddepartamento = d.iddepartamento";
$universidad = mysql_query($query_universidad, $sala) or die(mysql_error());
$row_universidad = mysql_fetch_assoc($universidad);
$totalRows_universidad = mysql_num_rows($universidad);
?>
<table width="600" border="0" align="center">
    <tr>
     <td><div align="center"><img src="<?php echo $row_universidad['imagenlogouniversidad'];?>" width="200" height="62" onClick="print()"><br><span class="Estilo5"><?php echo $row_universidad['personeriauniversidad'];?><br><?php echo $row_universidad['entidadrigeuniversidad'];?><br><?php echo $row_universidad['nituniversidad'];?></span></div></td>
   </tr>
  </table>
 <br>
<table width='57%' height='324' border='0' align='center' cellpadding='1' cellspacing='0'>
  <tr>
  <td class='marco' bgcolor='#000000'>
    <table border=0 cellpadding=2 cellspacing=0 width='100%' bgcolor='#FFFFFF'>
    <tr>
  	  <td height='23' colspan='2' align='center' class='titulos'><strong>Comprobante de Pago </strong></td>
	</tr>
	<tr align='center'>
	  <td class='textonegro' colspan='3' height='48'><hr size='1' color='#B5B5B5' width='90%'></td>
	</tr>
	<tr>
	  <td class=textoverde width='16%'>&nbsp;</td>
	  <td class=textogris width='90%'><table width='100%'  border='0' cellspacing='2' cellpadding='0'>
	<tr>
	  <td class='textogris'>Documento de Identidad:</td>
	  <td><span class='Estilo1'><?php echo $row_ordenespagadaspse['numerodocumento'] ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>Nombres y Apellidos: </td><td class='textogris'><span class='Estilo1'><?php echo $row_ordenespagadaspse['nombre'] ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>Fecha de Transacci&oacute;n: </td><td class='textogris'><span class='Estilo1'><?php echo $row_ordenespagadaspse['BankProcessDate'] ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>Total a pagar: </td><td class='textogris'><span class='Estilo1'>$ <?php echo number_format($row_ordenespagadaspse['TransValue']); ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>N&uacute;mero Orden de Pago: </td><td class='textogris'><span class='Estilo1'><?php echo $row_ordenespagadaspse['Reference1'] ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>Banco:</td><td class='textogris'><span class='Estilo1'><?php echo $row_ordenespagadaspse['FIName'] ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>N&uacute;mero de confirmaci&oacute;n:</td><td class='textogris'><span class='Estilo1'><?php echo $row_ordenespagadaspse['TrazabilityCode'] ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>&nbsp;</td><td class='textogris'>&nbsp;</td>
	</tr>
	<tr>
	  <td class='textogris'><div align='center'></div></td><td class='textogris'><div align='center'></div></td>
	</tr>
  </table>
  <b>&nbsp;</b>
  <table width='100%'  border='0' align='center' cellpadding='1' cellspacing='1'>
  <tr>
    <td width='100%' align='center' class='textogris style1'>
	<?php 
	switch($row_ordenespagadaspse['StaCode']){
        case "OK":
            echo("La transacción fue APROBADA en la Entidad Financiera");
            break;
        case "FAILED":
            echo("La transacción fué FALLIDA por la Entidad Financiera, por favor verifique en su entidad financiera si el débito fue realizado");
            break;
        case "PENDING":
            echo("La transacción está siendo confirmada en la Entidad Financiera. Por favor verifique en 10 minutos");
            break;
        case "NOT_AUTHORIZED":
            echo("La transacción fué RECHAZADA por la Entidad Financiera");
            break;
        case "CREATED":
            echo("Usted no terminó su sesión anterior de manera normal, por favor ingrese en 10 minutos");
            break;
        case "EXPIRED":
            echo("Su sesión ha expirado, por favor cierre y vuelva a comenzar.");
            break;
        case "SUCCESS":
            echo("Ejecucion satisfactoria");
            break;
        case "FAIL_ENTITYNOTEXISTSORDISABLED":
            echo("La Entidad Financiera no existe o esta deshabilitada.");
            break;
        case "FAIL_BANKNOTEXISTSORDISABLED":
            echo("La Entidad Financiera no existe o esta deshabilitada");
            break;
        case "FAIL_SERVICENOTEXISTS":
            echo("El servicio indicado por el código no existe en la entidad o no tiene cuenta de destino");
            break;
        case "FAIL_INVALIDAMOUNT":
            echo("La cuantía solicitada es inválida");
            break;
        case "FAIL_INVALIDSOLICITDATE":
            echo("Fecha de solicitud Invalida.");
            break;
        case "FAIL_BANKUNREACHEABLE":
            echo("La Entidad Financiera no puede ser contactada para iniciar la transacción");
            break;
        case "FAIL_NOTCONFIRMEDBYBANK":
            echo("La Entidad Financiera no aceptó iniciar la transacción");
            break;
        case "FAIL_CANNOTGETCURRENTCYCLE":
            echo("El sistema no pudo obtener el ciclo en el cual la transacción tiene que participar. Contacte el administrador del sistema.");
            break;
        case "FAIL_ACCESSDENIED":
            echo("Se denegó el acceso a la Entidad Financiera.");
            break;
        case "FAIL_TIMEOUT":
            echo("La Entidad Financiera no responidió, por favor intente en 10 minutos.");
            break;
        case "FAIL_EXCEEDEDLIMIT":
            echo("El valor excede el límite establecido por su Entidad Financiera");
            break;
        case "FAIL_INVALIDAUTHORIZEDAMOUNT":
            echo("El valor devuelto por la Entidad Financiera es diferente de la cuantía solicitada");
            break;
        case "FAIL_INCONSISTENTDATA":
            echo("Los datos confirmados por la Entidad Financiera son diferentes a la información contenidas en el PSE");
            break;
        case "FAIL_INVALIDBANKPROCESSINGDATE":
            echo("La fecha de proceso de la Entidad Financiera es menor a la fecha de solicitud");
            break;
        case "DESCRIPTIONNOTFOUND":
            echo("La descripción del servicio está vacía.");
            break;
        case "FAIL_INVALIDTRAZABILITYCODE":
            echo("No existe la transacción solicitada en el sistema autorizador.");
            break;
        case "FAIL_INVALIDENTITYCODE":
            echo("Código de entidad inválido");
            break;
        case "FAIL_INVALIDSERVICECODE":
            echo("Código de servicio inválido");
            break;
        case "FAIL_INVALIDPAYMENTDESC":
            echo("Descripción de la transacción inválida");
            break;
        case "FAIL_INVALIDTRANSVALUE":
            echo("Valor total transacción inválido");
            break;
        case "FAIL_INVALIDVATVALUE":
            echo("Valor IVA transacción inválido");
            break;
        case "FAIL_INVALIDUSERTYPE":
            echo("Tipo de Usuario inválido");
            break;
        case "FAIL_INVALIDTICKETID":
            echo("Información Ticket inválido");
            break;
        case "FAIL_INVALIDREFERENCE1":
            echo("Referencia inválida");
            break;
        case "FAIL_INVALIDFICODE":
            echo("Entidad Financiera inválido");
            break;
        case "FAIL_SYSTEM":
            echo("Falla del sistema, por favor intente más tarde");
            break;
        default:
            echo("Falla del sistema, por favor intente más tarde.");
            break;
      }
	?>
  </td>
  </tr>
  </table>
  <b>&nbsp;</b>
  <table width='100%'  border='0' align='center' cellpadding='1' cellspacing='1'>
  <tr>
    <td width='50%' align='right'><img src='../../../imagenes/ico_back.jpg' width='58' height='52' style='border:2px solid blue;' onClick="history.go(-1)"></td>
	<td width='50%'><img src='../../../imagenes/ico_print.jpg' width='58' height='52' style='border:2px solid blue;' onClick="print()"></td>
  </tr>
  </table>
  </td>
  <td class=textogris align='left'>
  <b>&nbsp;</b>
  </td>
  </tr>
  </table>
  </td>
  </tr>
</table>
<br>
<div align="center" class="Estilo5">
 <?php echo $row_universidad['direccionuniversidad'];?> - P B X <?php echo $row_universidad['telefonouniversidad'];?> - FAX: <?php echo $row_universidad['faxuniversidad'];?><br> <?php echo $row_universidad['paginawebuniversidad'];?> - <?php echo $row_universidad['nombreciudad'];?> <?php echo $row_universidad['nombrepais'];?> 
 </div>
</body>
</html>
