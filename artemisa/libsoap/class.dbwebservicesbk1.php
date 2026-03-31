<?php
//require_once('../serviciosacademicos/Connections/sala2.php');
//require_once('../serviciosacademicospse/Connections/sala2.php');
require_once('../serviciosacademicos/Connections/sala2.php');
/**
 *==============================================================================
 * Descripción:         Clase exclusiva para transacciones a la base de datos. |
 * Desarrollado por:    Avisortech Ltda.                                       |
 *                      (571) - 3458833 - (571) - 4937039.                     |
 *                      Carrera 26 # 63 a - 22 Piso 5. - Bogotá D.C - Colombia.|
 * Desarrollo para:     Universidad del Bosque. Bogotá D.C - Colombia          |
 * Autor:               Nicolás G. Rico                                        |
 *                      Ing. Desarrollador Avisortech Ltda.                    |
 *                      nicolas.guaneme@avisortech.com                         |
 * Fecha:               31 de Octubre de 2005.                                 |
 * Versión:             0.1 release.                                           |
 *==============================================================================
 */
define("_SERVI_",$hostname_sala);
define("_USER_",$username_sala);
define("_CLAVE_",$password_sala);
class DB_mysql {
   var $TicketId,$Reference1,$Reference2,$Reference3,$PaymentDesc,$TransValue,$TransVatValue,$SoliciteDate,$BankProcessDate,$FIName,$TrazabilityCode,$StaCode,$FlagButton,$RefAdc1,$RefAdc2,$RefAdc3,$RefAdc,$Error,$SrvCode,$nombreEstudiante,
    $strTabla = "LogPagos";
    var $Code = 0;
    var $strCampos = "";
    var $strConsulta = "";
    var $strMensaje = "";
    /* variables de conexi+¦n */
    var $BaseDatos;
    /* identificador de conexi+¦n y consulta */
    var $Conexion_ID = 0;
    var $Consulta_ID = 0;
    /* n+¦mero de error y texto error */
    var $Errno = 0;
    var $Error = "";
    /* M+®todo Constructor: Cada vez que creemos una variable
    de esta clase, se ejecutar+í esta funci+¦n */
    function DB_mysql($bd = "") {
        $this->BaseDatos = $bd;
    }
    /*Conexi+¦n a la base de datos*/
    function conectar($bd){
        if ($bd != "") $this->BaseDatos = $bd;
        // Conectamos al servidor
        $this->Conexion_ID = mysql_connect(_SERVI_, _USER_, _CLAVE_);
        if (!$this->Conexion_ID) {
            $this->Error = "Ha fallado la conexi+¦n con el servidor.";
            return 0;
        }
        //seleccionamos la base de datos
        if (!@mysql_select_db($this->BaseDatos, $this->Conexion_ID)) {
            $this->Error = "Imposible abrir ".$this->BaseDatos ;
            return 0;
        }
        /* Si hemos tenido +®xito conectando devuelve
        el identificador de la conexi+¦n, sino devuelve 0 */
        return $this->Conexion_ID;
    }
    /* Ejecuta un consulta */
    function consulta($sql = ""){
        if ($sql == "") {
            $this->Error = "No ha especificado una consulta SQL.";
            return 0;
        }else{
            //ejecutamos la consulta
            $this->Consulta_ID = @mysql_query($sql, $this->Conexion_ID);
			if (!$this->Consulta_ID) {
                $this->Errno = mysql_errno();
                $this->Error = mysql_error();
            }
            /* Si hemos tenido +®xito en la consulta devuelve
            el identificador de la conexi+¦n, sino devuelve 0 */
            return $this->Consulta_ID;
        }
    }
    /* Devuelve el n+¦mero de campos de una consulta */
    function numcampos() {
        $numerocampos = @mysql_num_fields($this->Consulta_ID);
        return $numerocampos;
    }
    /* Devuelve el n+¦mero de registros de una consulta */
    function numregistros(){
        $numreg = @mysql_num_rows($this->Consulta_ID);
        return $numreg;
    }//finnumregistros
    function getReturnCodeDesc($cadena){
      switch($cadena){
        case "OK":
            $this->setstrMensaje("La transacción fue APROBADA en la Entidad Financiera");
            break;
        case "FAILED":
            $this->setstrMensaje("La transacción fué FALLIDA por la Entidad Financiera, por favor verifique en su entidad financiera si el débito fue realizado");
            break;
        case "PENDING":
            $this->setstrMensaje("La transacción está siendo confirmada en la Entidad Financiera. Por favor verifique en 10 minutos");
            break;
        case "NOT_AUTHORIZED":
            $this->setstrMensaje("La transacción fué RECHAZADA por la Entidad Financiera");
            break;
        case "CREATED":
            $this->setstrMensaje("Usted no terminó su sesión anterior de manera normal, por favor ingrese en 10 minutos");
            break;
        case "EXPIRED":
            $this->setstrMensaje("Su sesión ha expirado, por favor cierre y vuelva a comenzar.");
            break;
        case "SUCCESS":
            $this->setstrMensaje("Ejecucion satisfactoria");
            break;
        case "FAIL_ENTITYNOTEXISTSORDISABLED":
            $this->setstrMensaje("La Entidad Financiera no existe o esta deshabilitada.");
            break;
        case "FAIL_BANKNOTEXISTSORDISABLED":
            $this->setstrMensaje("La Entidad Financiera no existe o esta deshabilitada");
            break;
        case "FAIL_SERVICENOTEXISTS":
            $this->setstrMensaje("El servicio indicado por el código no existe en la entidad o no tiene cuenta de destino");
            break;
        case "FAIL_INVALIDAMOUNT":
            $this->setstrMensaje("La cuantía solicitada es inválida");
            break;
        case "FAIL_INVALIDSOLICITDATE":
            $this->setstrMensaje("Fecha de solicitud Invalida.");
            break;
        case "FAIL_BANKUNREACHEABLE":
            $this->setstrMensaje("La Entidad Financiera no puede ser contactada para iniciar la transacción");
            break;
        case "FAIL_NOTCONFIRMEDBYBANK":
            $this->setstrMensaje("La Entidad Financiera no aceptó iniciar la transacción");
            break;
        case "FAIL_CANNOTGETCURRENTCYCLE":
            $this->setstrMensaje("El sistema no pudo obtener el ciclo en el cual la transacción tiene que participar. Contacte el administrador del sistema.");
            break;
        case "FAIL_ACCESSDENIED":
            $this->setstrMensaje("Se denegó el acceso a la Entidad Financiera.");
            break;
        case "FAIL_TIMEOUT":
            $this->setstrMensaje("La Entidad Financiera no responidió, por favor intente en 10 minutos.");
            break;
        case "FAIL_EXCEEDEDLIMIT":
            $this->setstrMensaje("El valor excede el límite establecido por su Entidad Financiera");
            break;
        case "FAIL_INVALIDAUTHORIZEDAMOUNT":
            $this->setstrMensaje("El valor devuelto por la Entidad Financiera es diferente de la cuantía solicitada");
            break;
        case "FAIL_INCONSISTENTDATA":
            $this->setstrMensaje("Los datos confirmados por la Entidad Financiera son diferentes a la información contenidas en el PSE");
            break;
        case "FAIL_INVALIDBANKPROCESSINGDATE":
            $this->setstrMensaje("La fecha de proceso de la Entidad Financiera es menor a la fecha de solicitud");
            break;
        case "DESCRIPTIONNOTFOUND":
            $this->setstrMensaje("La descripción del servicio está vacía.");
            break;
        case "FAIL_INVALIDTRAZABILITYCODE":
            $this->setstrMensaje("No existe la transacción solicitada en el sistema autorizador.");
            break;
        case "FAIL_INVALIDENTITYCODE":
            $this->setstrMensaje("Código de entidad inválido");
            break;
        case "FAIL_INVALIDSERVICECODE":
            $this->setstrMensaje("Código de servicio inválido");
            break;
        case "FAIL_INVALIDPAYMENTDESC":
            $this->setstrMensaje("Descripción de la transacción inválida");
            break;
        case "FAIL_INVALIDTRANSVALUE":
            $this->setstrMensaje("Valor total transacción inválido");
            break;
        case "FAIL_INVALIDVATVALUE":
            $this->setstrMensaje("Valor IVA transacción inválido");
            break;
        case "FAIL_INVALIDUSERTYPE":
            $this->setstrMensaje("Tipo de Usuario inválido");
            break;
        case "FAIL_INVALIDTICKETID":
            $this->setstrMensaje("Información Ticket inválido");
            break;
        case "FAIL_INVALIDREFERENCE1":
            $this->setstrMensaje("Referencia inválida");
            break;
        case "FAIL_INVALIDFICODE":
            $this->setstrMensaje("Entidad Financiera inválido");
            break;
        case "FAIL_SYSTEM":
            $this->setstrMensaje("Falla del sistema, por favor intente más tarde");
            break;
        default:
            $this->setstrMensaje("Falla del sistema, por favor intente más tarde.");
            break;
      }
      return $strMensaje;
  }
  function getNextTicketId()
  {
	if($this->numregistros() <= 0)
	{
		$code = "100";
		$this->setTicketId($code);
	} 
	else 
	{
		while ($row = @mysql_fetch_row($this->Consulta_ID))
		{
			$arrtemp = $row[0];
		}
		$temp = explode(",",$arrtemp);
		$codeTemp = $arrtemp;
		$tempc = $codeTemp++;
		$this->setTicketId($codeTemp);
	}
  }

 /* function getNextTicketId(){
    if($this->numregistros() <= 0){
      $code = date("Ymd") . "0001";
      $this->setTicketId($code);
    } else {
      while ($row = @mysql_fetch_row($this->Consulta_ID)){
        $arrtemp = $row[0];
      }
      $temp = explode(",",$arrtemp);
      $codeTemp = $arrtemp;
      //$tempc = substr($codeTemp,8,12);
	  $tempc = substr($codeTemp,8,12);
      $code = date("Ymd") . $tempc + 1;
      $this->setTicketId($code);
    }
  }*/
  function valorAPagar(){
    $fecha = date("Ymd");
    while($row = @mysql_fetch_row($this->Consulta_ID)){
      $arrTemp = split("-",$row[0],8);
      $tempFe = $arrTemp[0] . $arrTemp[1] . $arrTemp[2];
      if ($tempFe >= $fecha){
        $this->setTransValue($row[1]);
        exit;
      } else {
        $this->setTransValue("000000");
      }
    }
  }
  function updateEstadoPagoOK($val,$digito){
    $strConsulta = "UPDATE ordenpago SET codigoestadoordenpago = 4".$digito." WHERE numeroordenpago = '" . $val . "';";
    $this->setstrConsulta($strConsulta);
  }
  function updateEstadoOrden($val,$digito){
    $strConsulta = "UPDATE ordenpago SET codigoestadoordenpago = 6".$digito." WHERE numeroordenpago = '" . $val . "';";
    $this->setstrConsulta($strConsulta);
  }
  function updateEstadoOrdenPrematicula($val,$digito){
    $strConsulta = "UPDATE ordenpago SET codigoestadoordenpago = 1".$digito." WHERE numeroordenpago = '" . $val . "';";
    $this->setstrConsulta($strConsulta);
  }
  function updateTablasU($fecha,$numero,$digito){
    $strConsulta = "UPDATE ordenpago SET codigoestadoordenpago = 4".$digito.", fechaentregaordenpago = '" . $fecha . "' WHERE numeroordenpago = '" . $numero . "' AND codigoestadoordenpago = 10;";
    $this->setstrConsulta($strConsulta);
  }
  function updateTablaPrematricula($numeroordenpago, $digito){
    $strConsulta = "UPDATE prematricula p, ordenpago o
	SET p.codigoestadoprematricula = 4".$digito."
	WHERE o.numeroordenpago = '$numeroordenpago'
	and p.idprematricula = o.idprematricula
	and p.codigoperiodo = o.codigoperiodo;";
	$this->setstrConsulta($strConsulta);
  }
  function updateTablaDetallePrematricula($numeroordenpago){
    $strConsulta = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = 30 WHERE numeroordenpago = '$numeroordenpago' and codigoestadodetalleprematricula like '1%';";
	$this->setstrConsulta($strConsulta);
  }
  function updateFechaPagoU(){
    $fecha = date("Y-m-d");
    $strConsulta = "UPDATE ordenpago SET fechaentregaordenpago = '" . $fecha . "' WHERE numeroordenpago = '" . $this->getTicketId() . "';";
    $this->setstrConsulta($strConsulta);
  }
  function updatePagoOK($bp,$bn,$trc,$tk){
    $strConsulta = "UPDATE LogPagos SET BankProcessDate = '" . $bp . "',FIName = '" . $bn . "',StaCode = 'OK',TrazabilityCode = '" . $trc . "' WHERE TicketId = '" . $tk . "';";
    $this->setstrConsulta($strConsulta);
  }
  function updatePagoPENDING($bp,$bn,$trc,$tk){
    $strConsulta = "UPDATE LogPagos SET BankProcessDate = '" . $bp . "',FIName = '" . $bn . "',TrazabilityCode = '" . $trc . "' WHERE TicketId = '" . $tk . "';";
    $this->setstrConsulta($strConsulta);
  }
  function getValorPago($cod_T){
    $strCampos = "fechaordenpago,valorfechaordenpago";
    $strConsulta = "SELECT DISTINCT " . $strCampos . " FROM fechaordenpago WHERE numeroordenpago ='" . $cod_T . "' ORDER BY porcentajefechaordenpago;";
    $this->setstrConsulta($strConsulta);
  }
  function selectLogPagosxTicketIdSonda($cod_T){
      $strCampos = "RefAdc1,RefAdc2,RefAdc3,Reference1";
      $strConsulta = "SELECT " . $strCampos . " FROM " . $strTabla . " WHERE TicketId = " .$cod_T . ";";
      $this->setstrConsulta($strConsulta);
  }
  function selectLogPagosxReference2($cod_T){
      $strCampos = "Reference2";
      $strConsulta = "SELECT " . $strCampos . " FROM " . $strTabla . " WHERE TicketId = " .$cod_T . ";";
      $this->setstrConsulta($strConsulta);
  }
    function selectLogPagosxTrazabilityCode($cod_T){
      $strCampos = "TicketId,SrvCodeReference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,BankProcessDate,FIName,StaCode,RefAdc1,RefAdc2,RefAdc3,RefAdc";
      $strConsulta = "SELECT " . $strCampos . " FROM " . $strTabla . " WHERE TicketId = " .$cod_T . ";";
      $this->setstrConsulta($strConsulta);
    }
    function selectLogPagosxTicketId($cod_T){
      $strCampos = "SrvCode,Reference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,BankProcessDate,FIName,StaCode,TrazabilityCode,RefAdc1,RefAdc2,RefAdc";
      $strConsulta = "SELECT " . $strCampos . "FROM " . $strTabla . " WHERE TicketId = " . $cod_T . ";";
      $this->setstrConsulta($strConsulta);
    }
    function updateEstadoLogPagos(){
      $strConsulta = "UPDATE " .$strTabla . " SET TicketId = " . $this->getTicketId() . ",StaCode = " . $this->getStaCode() . "WHERE TicketId = " . $this->getTicketId();
      $this->setstrConsulta($strConsulta);
    }
    function updateEstado($val){
        $strCons = "UPDATE LogPagos SET TicketId='" . $this->getTicketId() . "'" . ",StaCode='PROCESANDO',SoliciteDate='" . date("Y-d-m:H:i:s") . "' WHERE Reference1='" . $val . "'";
        $this->setstrConsulta($strCons);
    }
    function insertLogPagos(){
        $pendiente = "PENDING";
        //".$this->getTicketId()."
		$strCons = "INSERT INTO LogPagos (TicketId,SrvCode,Reference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,BankProcessDate,FIName,StaCode,TrazabilityCode) 
		VALUES ('0','".$this->getSrvCode()."'".",'".$this->getReference1()."'".",'".$this->getReference2()."'".",'".$this->getReference3()."','".$this->getPaymentDesc()."','".$this->getTransValue()."','".$this->getTransVatValue()."','".date("Y-m-d H:i:s")."','".$this->getBankProcessDate()."','".$this->getFIName()."','".$pendiente."','".$this->getTrazabilityCode()."'" . ")";
       	//$strCons = "INSERT INTO LogPagos (TicketId,SrvCode,Reference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,FIName,TrazabilityCode) VALUES ('" . $this->getTicketId() . "','" . $this->getSrvCode() . "'" . ",'" . $this->getReference1() . "'" . ",'" . $this->getReference2() . "'" . ",'" . $this->getReference3() . "','" . $this->getPaymentDesc() . "','" . $this->getTransValue() . "','" . $this->getTransVatValue() . "','" . date("Y-d-m:H:i:s") . "','" . $this->getFIName() . "','" . $this->getTrazabilityCode() . "'" . ");";
        $this->setstrConsulta($strCons);
    }
    function updateRespuestaLogPagos(){
      $strConsulta = "UPDATE " .$strTabla . " SET TicketId = " . $this->getTicketId() . ",TrazabilityCode = " . $this->getTrazabilityCode() . ",StaCode = " . $this->getStaCode() . ",FIName = " . $this->getFIName() . ",BankProcessDate = " . $this->getBankProcessDate() . "WHERE TicketId = " . $this->getTicketId();
      $this->setstrConsulta($strConsulta);
    }
    function nombre(){
      $strConsulta = "SELECT nombresestudiantegeneral,apellidosestudiantegeneral FROM estudiantegeneral WHERE numerodocumento = '" . $this->getReference2() . "';";
      $this->setstrConsulta($strConsulta);
      $this->consulta($strConsulta);
      while ($row = @mysql_fetch_row($this->Consulta_ID)){
        $arrtemp = $row[0];
        $arrtemp1 = $row[1];
        $name = $arrtemp . " " . $arrtemp1;
        $this->setnombreEstudiante($name);
      }
    }
    function verRecibo(){
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
$universidad = mysql_query($query_universidad, $this->Conexion_ID) or die(mysql_error());
$row_universidad = mysql_fetch_assoc($universidad);
$totalRows_universidad = mysql_num_rows($universidad);

$query_selestadoorden = "select o.codigoestadoordenpago, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, 
eg.numerodocumento, e.codigoestudiante, o.codigoperiodo
from ordenpago o, estudiantegeneral eg, estudiante e
where o.numeroordenpago = '".$this->getReference1()."'
and eg.idestudiantegeneral = e.idestudiantegeneral
and e.codigoestudiante = o.codigoestudiante";
$selestadoorden=mysql_query($query_selestadoorden, $this->Conexion_ID) or die(mysql_error());
$totalRows_selestadoorden = mysql_num_rows($selestadoorden);	
$row_selestadoorden = mysql_fetch_array($selestadoorden);
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
	  <td><span class='Estilo1'><?php echo $row_selestadoorden['numerodocumento']; ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>Nombres y Apellidos: </td><td class='textogris'><span class='Estilo1'><?php echo $row_selestadoorden['nombre']; ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>Fecha de Transacci&oacute;n: </td><td class='textogris'><span class='Estilo1'><?php echo $this->getBankProcessDate() ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>Total a pagar: </td><td class='textogris'><span class='Estilo1'>$ <?php echo number_format($this->getTransValue()); ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>N&uacute;mero Orden de Pago: </td><td class='textogris'><span class='Estilo1'><?php echo $this->getReference1() ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>Banco:</td><td class='textogris'><span class='Estilo1'><?php echo $this->getFIName() ?></span></td>
	</tr>
	<tr>
	  <td class='textogris'>N&uacute;mero de confirmaci&oacute;n:</td><td class='textogris'><span class='Estilo1'><?php echo $this->getTrazabilityCode() ?></span></td>
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
    <td width='100%' align='center' class='textogris style1'><?php echo $this->getstrMensaje() ?></td>
  </tr>
  </table>
  <b>&nbsp;</b>
  <table width='100%'  border='0' align='center' cellpadding='1' cellspacing='1'>
  <tr>
    <td width='50%' align='right'>
<?php
		//FAIL
		//echo "<h1>$this->getstrMensaje()</h1>";
		
		//echo "<h1>EREG ".ereg("FAIL",$this->getstrMensaje())."</h1>";
		
		$query_conceptosordenpagomatricula="select d.codigoconcepto, c.codigoreferenciaconcepto
		from detalleordenpago d, concepto c
		where d.codigoconcepto = c.codigoconcepto
		and d.numeroordenpago = '".$this->getReference1()."'
		and c.codigoreferenciaconcepto = '100'";	
		$conceptosordenpagomatricula = mysql_query($query_conceptosordenpagomatricula,$this->Conexion_ID) or die("$query_conceptosordenpagomatricula<br>".mysql_error());     
		$totalRows_conceptosordenpagomatricula = mysql_num_rows($conceptosordenpagomatricula);
		if($totalRows_conceptosordenpagomatricula != "")
		{
			// La orden tiene conceptos de matricula
			$link = "tipousuario.php?codigoestudiante=".$row_selestadoorden['codigoestudiante']."&codigoperiodo=".$row_selestadoorden['codigoperiodo']."";
		}
		else
		{
			$query_conceptosordenpagoinscripcion="select d.codigoconcepto, c.codigoreferenciaconcepto
			from detalleordenpago d, concepto c
			where d.codigoconcepto = c.codigoconcepto
			and d.numeroordenpago = '".$this->getReference1()."'
			and c.codigoreferenciaconcepto = '600'";	
			$conceptosordenpagoinscripcion = mysql_query($query_conceptosordenpagoinscripcion,$this->Conexion_ID) or die("$query_conceptosordenpagoinscripcion<br>".mysql_error());     
			$totalRows_conceptosordenpagoinscripcion = mysql_num_rows($conceptosordenpagoinscripcion);
			if($totalRows_conceptosordenpagoinscripcion != "")
			{
				// La orden tiene conceptos de inscripcion
				$link = "../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=".$this->getReference2()."&logincorrecto";
			}
			else
			{
				// Cargar las variable de sesion del estudiante si no las tiene
				
				// La orden tiene otros conceptos
				$link = "../serviciosacademicos/consulta/consultanotas.htm";
			}
		}
		//$row_conceptosordenpago = mysql_fetch_array($conceptosordenpago);
		//mysql_query($query_selnumeroordenpago, $this->Conexion_ID);
?>	
	<a href="<?php echo $link;?>"><img src='../imagenes/ico_back.jpg' width='58' height='52'></a>
<?php
?>	
	</td>
	<td width='50%'><img src='../imagenes/ico_print.jpg' width='58' height='52' style='border:2px solid blue;' onClick="print()"></td>
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
<?php      
	 }
	// Metodos Getter
    function getstrConsulta(){
      return $this->strConsulta;
    }
    function getStrMensaje(){
      return $this->strMensaje;
    }
    function getTicketId(){
		return $this->TicketId;
	}
	function getReference1(){
		return $this->Reference1;
	}
	function getReference2(){
		return $this->Reference2;
	}
	function getReference3(){
		return $this->Reference3;
	}
	function getPaymentDesc(){
		return $this->PaymentDesc;
	}
	function getTransValue(){
		return $this->TransValue;
	}
	function getTransVatValue(){
      return $this->TransVatValue;
    }
    function getSoliciteDate(){
      return $this->SoliciteDate;
    }
    function getBankProcessDate(){
      return $this->BankProcessDate;
    }
    function getFIName(){
      return $this->FIName;
    }
    function getTrazabilityCode(){
      return $this->TrazabilityCode;
    }
    function getStaCode(){
      return $this->StaCode;
    }
    function getFlagButton(){
      return $this->FlagButton;
    }
    function getRefAdc1(){
      return $this->RefAdc1;
    }
    function getRefAdc2(){
      return $this->RefAdc2;
    }
    function getRefAdc3(){
      return $this->RefAdc3;
    }
    function getRefAdc(){
      return $this->RefAdc;
    }
    function getSrvCode(){
      return $this->SrvCode;
    }
    function getnombreEstudiante(){
      return $this->nombreEstudiante;
    }
	// Metodos Setter
    function setSrvCode($SrvCode = ""){
      if($SrvCode != "") $this->SrvCode = $SrvCode;
    }
    function setstrConsulta($strConsulta = ""){
      if($strConsulta != "") $this->strConsulta = $strConsulta;
    }
    function setstrMensaje($strMensaje = ""){
      if($strMensaje != "") $this->strMensaje = $strMensaje;
      return 0;
    }
    function setTicketId($TicketId = ""){
		if($TicketId != "") $this->TicketId = $TicketId;
		return 0;
	}
	function setReference1($Reference1 = ""){
        if($Reference1 != "") $this->Reference1 = $Reference1;
		return 0;
	}
	function setReference2($Reference2 = ""){
        if($Reference2 != "") $this->Reference2 = $Reference2;
    	return 0;
	}
	function setReference3($Reference3 = ""){
        if($Reference3 != "") $this->Reference3 = $Reference3;
        return 0;
	}
	function setPaymentDesc($PaymentDesc = ""){
        if($PaymentDesc != "") $this->PaymentDesc = $PaymentDesc;
		return 0;
	}
	function setTransValue($TransValue = ""){
        if($TransValue != "") $this->TransValue = $TransValue;
		return 0;
	}
	function setTransVatValue($TransVatValue = ""){
      if($TransVatValue != "") $this->TransVatValue = $TransVatValue;
      return 0;
    }
    function setSoliciteDate($SoliciteDate = ""){
      if($SoliciteDate != "") $this->SoliciteDate = $SoliciteDate;
      return 0;
    }
    function setBankProcessDate($BankProcessDate = ""){
      if($BankProcessDate != "") $this->BankProcessDate = $BankProcessDate;
      return 0;
    }
    function setFIName($FIName = ""){
      if($FIName != "") $this->FIName = $FIName;
      return 0;
    }
    function setTrazabilityCode($TrazabilityCode = ""){
      if($TrazabilityCode != "") $this->TrazabilityCode = $TrazabilityCode;
      return 0;
    }
    function setStaCode($StaCode = ""){
      if($StaCode != "") $this->StaCode = $StaCode;
      return 0;
    }
    function setFlagButton($FlagButton = ""){
      if($FlagButton != "") $this->FlagButton = $FlagButton;
      return 0;
    }
    function setRefAdc1($RefAdc1 = ""){
      if($RefAdc1 != "") $this->RefAdc1 = $RefAdc1;
      return 0;
    }
    function setRefAdc2($RefAdc2 = ""){
      if($RefAdc2 != "") $this->RefAdc2 = $RefAdc2;
      return 0;
    }
    function setRefAdc3($RefAdc3 = ""){
      if($RefAdc3 != "") $this->RefAdc3 = $RefAdc3;
      return 0;
    }
    function setRefAdc($RefAdc = ""){
      if($RefAdc != "") $this->RefAdc = $RefAdc;
      return 0;
    }
    function setnombreEstudiante($nombreEstudiante = ""){
      if($nombreEstudiante != "") $this->nombreEstudiante = $nombreEstudiante;
      return 0;
    }
} //fin de la Clse DB_mysql
?>
