<?php
require_once('class.dbwebservices.php');
/**
 *==============================================================================
 * Descripción:         Clase modelo de web services, standar Avisortech       |
 *                      requerida para realizar las transacciones con el WS.   |
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
 //Constantes de conexion a la DB
//require_once('class.dbwebservices.php' );
class clsPagos {
   $DBM = new $DB_mysql;
   // Atributos
    var $TicketId,$SrvCode,$Reference1,$Reference2,$Reference3,$PaymentDesc,$TransValue,$TransVatValue,$SoliciteDate,$BankProcessDate,$FIName,$TrazabilityCode,$StaCode,$UserType,$FlagButton,$RefAdc1,$RefAdc2,$RefAdc3,$RefAdc,$Error,
    var $strTabla = "LogPagos";
    var $Code = 0;
    var $strCampos = "";
    var $strConsulta = "";
    var $strMensaje = "";
	// Constructor, cada vez que se instancia la clase se inicializan las variables
    function clsPagos(){
     
  }
  function getReturnCodeDesc($cadena){
      switch($cadena){
        case "OK":
            $this->strMensaje = "La transacción fue APROBADA en la Entidad Financiera";
            break;
        case "FAILED":
            $this->strMensaje = "El procesamiento de la transacción falló, por favor reintente.";
            break;
        case "PENDING":
            $this->strMensaje = "La transacción está siendo confirmada en la Entidad Financiera. Por favor verifique en 10 minutos";
            break;
        case "NOT_AUTHORIZED":
            $this->strMensaje = "La transacción fué RECHAZADA por la Entidad Financiera";
            break;
        case "CREATED":
            $this->strMensaje = "Usted no terminó su sesión anterior de manera normal, por favor ingrese en 10 minutos";
            break;
        case "EXPIRED":
            $this->strMensaje = "Su sesión ha expirado, por favor cierre y vuelva a comenzar.";
            break;
        case "SUCCESS":
            $this->strMensaje = "Ejecucion satisfactoria";
            break;
        case "FAIL_ENTITYNOTEXISTSORDISABLED":
            $this->strMensaje = "La Entidad Financiera no existe o esta deshabilitada.";
            break;
        case "FAIL_BANKNOTEXISTSORDISABLED":
            $this->strMensaje = "La Entidad Financiera no existe o esta deshabilitada";
            break;
        case "FAIL_SERVICENOTEXISTS":
            $this->strMensaje = "El servicio indicado por el código no existe en la entidad o no tiene cuenta de destino";
            break;
        case "FAIL_INVALIDAMOUNT":
            $this->strMensaje = "La cuantía solicitada es inválida";
            break;
        case "FAIL_INVALIDSOLICITDATE":
            $this->strMensaje = "Fecha de solicitud Invalida.";
            break;
        case "FAIL_BANKUNREACHEABLE":
            $this->strMensaje = "La Entidad Financiera no puede ser contactada para iniciar la transacción";
            break;
        case "FAIL_NOTCONFIRMEDBYBANK":
            $this->strMensaje = "La Entidad Financiera no aceptó iniciar la transacción";
            break;
        case "FAIL_CANNOTGETCURRENTCYCLE":
            $this->strMensaje = "El sistema no pudo obtener el ciclo en el cual la transacción tiene que participar. Contacte el administrador del sistema.";
            break;
        case "FAIL_ACCESSDENIED":
            $this->strMensaje = "Se denegó el acceso a la Entidad Financiera.";
            break;
        case "FAIL_TIMEOUT":
            $this->strMensaje = "La Entidad Financiera no responidió, por favor intente en 10 minutos.";
            break;
        case "FAIL_EXCEEDEDLIMIT":
            $this->strMensaje = "El valor excede el límite establecido por su Entidad Financiera";
            break;
        case "FAIL_INVALIDAUTHORIZEDAMOUNT":
            $this->strMensaje = "El valor devuelto por la Entidad Financiera es diferente de la cuantía solicitada";
            break;
        case "FAIL_INCONSISTENTDATA":
            $this->strMensaje = "Los datos confirmados por la Entidad Financiera son diferentes a la información contenidas en el PSE";
            break;
        case "FAIL_INVALIDBANKPROCESSINGDATE":
            $this->strMensaje = "La fecha de proceso de la Entidad Financiera es menor a la fecha de solicitud";
            break;
        case "DESCRIPTIONNOTFOUND":
            $this->strMensaje = "La descripción del servicio está vacía.";
            break;
        case "FAIL_INVALIDTRAZABILITYCODE":
            $this->strMensaje = "No existe la transacción solicitada en el sistema autorizador.";
            break;
        case "FAIL_INVALIDENTITYCODE":
            $this->strMensaje = "Código de entidad inválido";
            break;
        case "FAIL_INVALIDSERVICECODE":
            $this->strMensaje = "Código de servicio inválido";
            break;
        case "FAIL_INVALIDPAYMENTDESC":
            $this->strMensaje = "Descripción de la transacción inválida";
            break;
        case "FAIL_INVALIDTRANSVALUE":
            $this->strMensje = "Valor total transacción inválido";
            break;
        case "FAIL_INVALIDVATVALUE":
            $this->strMensaje = "Valor IVA transacción inválido";
            break;
        case "FAIL_INVALIDUSERTYPE":
            $this->strMensaje = "Tipo de Usuario inválido";
            break;
        case "FAIL_INVALIDTICKETID":
            $this->strMensaje = "Información Ticket inválido";
            break;
        case "FAIL_INVALIDREFERENCE1":
            $this->strMensaje = "Referencia inválida";
            break;
        case "FAIL_INVALIDFICODE":
            $this->strMensaje = "Entidad Financiera inválido";
            break;
        case "FAIL_SYSTEM":
            $this->strMensaje = "Falla del sistema, por favor intente más tarde";
            break;
        default:
            $this->strMensaje = "Falla del sistema, por favor intente más tarde.";
            break;
      }
      return $strMensaje;
  }
  function selectLogPagosxTicketIdSonda($cod_T){
      $strCampos = "RefAdc1,RefAdc2,RefAdc3,Reference1";
      $strConsulta = "SELECT " . $strCampos . " FROM " . $strTabla . " WHERE TicketId = " .$cod_T . ";";
      return $strConsulta;
  }
  function selectLogPagosxReference2($cod_T){
      $strCampos = "Reference2";
      $strConsulta = "SELECT " . $strCampos . " FROM " . $strTabla . " WHERE TicketId = " .$cod_T . ";";
     return $strConsulta;
  }
    function selectLogPagosxTrazabilityCode($cod_T){
      $strCampos = "TicketId,SrvCodeReference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,BankProcessDate,FIName,StaCode,RefAdc1,RefAdc2,RefAdc3,RefAdc";
      $strConsulta = "SELECT " . $strCampos . " FROM " . $strTabla . " WHERE TicketId = " .$cod_T . ";";
      return $strConsulta;
    }
    function selectLogPagosxTicketId($cod_T){
      $strCampos = "SrvCode,Reference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,BankProcessDate,FIName,StaCode,TrazabilityCode,RefAdc1,RefAdc2,RefAdc";
      $strConsulta = "SELECT " . $strCampos . "FROM " . $strTabla . " WHERE TicketId = " . $cod_T . ";";
      return $strConsulta;
    }
    function updateEstadoLogPagos(){
      $strConsulta = "UPDATE " .$strTabla . " SET TicketId = " . $this->getTicketId() . ",StaCode = " . $this->getStaCode() . "WHERE TicketId = " . $this->getTicketId();
      return $strConsulta;
    }
    function insertLogPagos(){
        $strCampos = "TicketId,SrvCode,Reference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,FIName,TrazabilityCode";
        $strConsulta = "INSERT INTO " . $strTabla . "(" . $strCampos . ")" . " VALUES ('" . $this->getTicketId(),$this->getSrvCode(),$this->getReference1(),$this->getReference2(),$this->getReference3(),$this->getPaymentDesc(),$this->getTransValue(),getTransVatValue(),$this->getSoliciteDate(),$this->getFIName(),$this->getTrazabilityCode() . "');";
        return $strConsulta;
    }
    function updateRespuestaLogPagos(){
      $strConsulta = "UPDATE " .$strTabla . " SET TicketId = " . $this->getTicketId() . ",TrazabilityCode = " . $this->getTrazabilityCode() . ",StaCode = " . $this->getStaCode() . ",FIName = " . $this->getFIName() . ",BankProcessDate = " . $this->getBankProcessDate() . "WHERE TicketId = " . $this->getTicketId();
      return $strConsulta;
    }
	// Metodos Getter
	function getTicketId(){
		return $TicketId;
	}
	function getSrvCode(){
		return $SrvCode;
	}
	function getReference1(){
		return $Reference1;
	}
	function getReference2(){
		return $Reference2;
	}
	function getReference3(){
		return $Reference3;
	}
	function getPaymentDesc(){
		return $PaymentDesc;
	}
	function getTransValue(){
		return $TransValue;
	}
	function getTransVatValue(){
      return $TransVatValue;
    }
    function getSoliciteDate(){
      return $SoliciteDate;
    }
    function getBankProcessDate(){
      return $BankProcessDate;
    }
    function getFIName(){
      return $FIName;
    }
    function getTrazabilityCode(){
      return $TrazabilityCode;
    }
    function getStaCode(){
      return $StaCode;
    }
    function getUserType(){
      return $UserType;
    }
    function getFlagButton(){
      return $FlagButton;
    }
    function getRefAdc1(){
      return $RefAdc1;
    }
    function getRefAdc2(){
      return $RefAdc2;
    }
    function getRefAdc3(){
      return $RefAdc3;
    }
    function getRefAdc(){
      return $RefAdc;
    }
	// Metodos Setter
	function setTicketId($TicketId = ""){
		if($TicketId != "") $this->TicketId = $TicketId;
		return 0;
	}
	function setSrvCode($SrvCode = ""){
        if($SrvCode != "") $this->SrvCode = $SrvCode;
        return 0;
	}
	function setReference1($Reference1 = ""){
        if($Reference1 != "") $this->Reference1 = $Reference1;
		return 0;
	}
	function setReference2($$Reference2 = ""){
        if($Reference2 != "") this->Reference2 = $Reference2;
    	return 0;
	}
	function setReference3($Reference3 = ""){
        if($Reference3 != "") this->Reference3 = $Reference3;
        return 0;
	}
	function setPaymentDesc($PaymentDesc = ""){
        if($PaymentDesc != "") this->PaymentDesc = $PaymentDesc;
		return 0;
	}
	function setTransValue($TransValue = ""){
        if($TransValue != "") this->TransValue = $TransValue;
		return 0;
	}
	function setTransVatValue($TransVatValue = ""){
      if($TransVatValue != "") this->TransVatValue = $TransVatValue;
      return 0;
    }
    function setSoliciteDate($SoliciteDate = ""){
      if($SoliciteDate != "") this->SoliciteDate = $SoliciteDate;
      return 0;
    }
    function setBankProcessDate($BankProcessDate = ""){
      if($BankProcessDate != "") this->BankProcessDate = $BankProcessDate;
      return 0;
    }
    function setFIName($FIName = ""){
      if($FIName != "") this->FIName = $FIName;
      return 0;
    }
    function setTrazabilityCode($TrazabilityCode = ""){
      if($TrazabilityCode != "") this->TrazabilityCode = $TrazabilityCode;
      return 0;
    }
    function setStaCode($StaCode = ""){
      if($StaCode != "") this->StaCode = $StaCode;
      return 0;
    }
    function setUserType($UserType = ""){
      if($UserType != "") this->UserType = $UserType;
      return 0;
    }
    function setFlagButton($FlagButton = ""){
      if($FlagButton != "") this->FlagButton = $FlagButton;
      return 0;
    }
    function setRefAdc1($RefAdc1 = ""){
      if($RefAdc1 != "") this->RefAdc1 = $RefAdc1;
      return 0;
    }
    function setRefAdc2($RefAdc2 = ""){
      if($RefAdc2 != "") this->RefAdc2 = $RefAdc2;
      return 0;
    }
    function setRefAdc3($RefAdc3 = ""){
      if($RefAdc3 != "") this->RefAdc3 = $RefAdc3;
      return 0;
    }
    function setRefAdc($RefAdc = ""){
      if($RefAdc != "") this->RefAdc = $RefAdc;
      return 0;
    }
}
?>

