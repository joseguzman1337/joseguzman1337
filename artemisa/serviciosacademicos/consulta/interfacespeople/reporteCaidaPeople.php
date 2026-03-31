<?php
/**
 * @modifed Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
 * Modificacion de funcion verificacion PSE Linea - cambio de conexion bd validacion de respuesta
 * Se añade variable $db recepcion desde archivo invocador
 * @since Mayo 8 del 2019
 */

function verificarPSEnLinea($db= null) {    
    /*if(!isset($db)){
        require(dirname(__FILE__) . '/../../Connections/sala2.php');
        $rutaado = dirname(__FILE__) . "/../../funciones/adodb/";
        require(dirname(__FILE__) . '/../../Connections/salaado.php');      
    }
    /*$sql = "SELECT LogCaidaSistemaInformacionId AS id, Tipo ".
    " FROM LogsCaidasSistemaInformacion ".
    " WHERE TipoSistemaInformacionLogId=1  ".
    " ORDER BY LogCaidaSistemaInformacionId DESC LIMIT 1";    
    $row = $db->GetRow($sql);        
    /if (isset($row["Tipo"]) &&  !empty($row["Tipo"]) && $row["Tipo"]== '0'){
        return false;
    } else {
        return true;
    }  */  
    return true;
}//function verificarPSEnLinea

function verificarInformaPSE() {

   /* require(dirname(__FILE__) . '/../../Connections/sala2.php');
    $rutaado = dirname(__FILE__) . "/../../funciones/adodb/";
    require(dirname(__FILE__) . '/../../Connections/salaado.php');

    $sql = "SELECT LogCaidaSistemaInformacionId AS id, Tipo ".
    " FROM LogsCaidasSistemaInformacion	".
    " WHERE TipoSistemaInformacionLogId=2  ".
    " ORDER BY LogCaidaSistemaInformacionId DESC LIMIT 1";    
    $row = $db->GetRow($sql);
    if ($row["Tipo"] == 0 && count($row) > 0) {
        return false;
        
    } else {
        return true;
    }*/

    return true;
}

function reportarCaida($idSistemaInformacion, $operacion) {
    /*require(dirname(__FILE__) . '/../../Connections/sala2.php');
    $rutaado = dirname(__FILE__) . "/../../funciones/adodb/";
    require(dirname(__FILE__) . '/../../Connections/salaado.php');

    //REPORTO A SALA CAIDA DEL SISTEMA
   /* $query_logps = "INSERT INTO LogsCaidasSistemaInformacion(Tipo, TipoSistemaInformacionLogId)
						VALUES( 0, '$idSistemaInformacion')";
    $db->Execute($query_logps);*/

    //REPORTO ENCARGADOS CAIDA DEL SISTEMA POR CORREO
    /* $querycontrol = $db->Execute("SELECT Correo,Descripcion from CorreosNotificacionesPs WHERE CodigoEstado='100'");


      $asunto = "Caida Sistema de Informaci�n PeopleSoft ".date('d-m-Y h:i:s A');

      $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
      $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

      $cabeceras .= 'From: Tecnologia <no-reply@unbosque.edu.co>' . "\r\n";

      $mensaje = '
      <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
      <html>
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Reporte de resultados</title>
      <script type="text/javascript" src="../../mgi/js/jquery.min.js"></script>
      <script type="text/javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
      <link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
      <style type="text/css">
      .tableDiv{
      margin-top:50px;
      }
      th{
      font-weigh:bold;
      text-align:center;
      font-size:1.3em;
      }

      .nombrePlantilla, .etiquetasPlantilla{
      text-align:center;
      font-size:1.1em;
      }

      table{
      border: 0;
      padding:0;
      margin:0;
      }

      tr td, tr th{
      border: 1px solid #000;
      }

      tr.noBorder td{
      border: 0;
      }
      </style>
      </head>
      <body>SALA encontr� problemas de conexi�n con PeopleSoft al tratar de usar la integraci�n de '.$operacion.'<body>
      </html>';

      if($querycontrol->RecordCount()>0)  {
      $correos = $querycontrol->GetArray();
      foreach($correos as $correo){
      $destinatario=$correo["Descripcion"]." <".$correo["Correo"].">";
      // Enviamos el mensaje
      if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
      $aviso = "Su mensaje fue enviado.";
      $succed = true;
      } else {
      $aviso = "Error de env�o.";
      $succed = false;
      }
      }


      }
     */
}