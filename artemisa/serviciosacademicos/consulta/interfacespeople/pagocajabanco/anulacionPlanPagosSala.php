<?php
function InformacionAnulacion($numeroordenpago, $fechapagoordenpago) {
	global $db;
	$querycontrol = $db->Execute("SELECT o.* from ordenpago o 
								INNER JOIN ordenpagoplandepago opp ON o.numeroordenpago=opp.numerorodencoutaplandepagosap
								WHERE o.numeroordenpago='$numeroordenpago' ");
	if($querycontrol->RecordCount()>0)  {	
		$fechapago = cambiaf_a_sala($fechapagoordenpago);
		$row_orden = $querycontrol->FetchRow();        
		if($row_orden["codigoestadoordenpago"]!=40 && $row_orden["codigoestadoordenpago"]!=41){
			//SE ANULA LA ORDEN EN SALA
			$query_ordenpago = "UPDATE ordenpago
							set codigoestadoordenpago = 24 
							WHERE numeroordenpago = '$numeroordenpago'";           
				$ordenpago = $db->Execute($query_ordenpago) or die("$query_ordenpago" . mysql_error());
				
			$query_ordenpago = "UPDATE ordenpagoplandepago
							set codigoestado = 200		
							WHERE numerorodencoutaplandepagosap = '$numeroordenpago'";           
				$ordenpago = $db->Execute($query_ordenpago) or die("$query_ordenpago" . mysql_error());

				// ************************************************************************************************
				// E REGISTRA EN EL TRACE Y SE ACTUALIZA EL ESTADO EN LA TABLA DE CONTROL
				$query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
							enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
							fecharegistrologtraceintegracionps)
						VALUES( 0, 'Anulacion Plan de Pagos','INVOICE_ID =,$numeroordenpago  TRANSFER_DT=$fechapago', 'ERRNUM=0, DESCRLONG=Ok', '$numeroordenpago',now())";
				$logps = $db->Execute($query_logps) or die(mysql_error());
		} else {
			// ORDEN DE PAGO PAGADA EN SALA. SE REGISTRA EN EL TRACE 
					$query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
								enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
								fecharegistrologtraceintegracionps)
							VALUES( 0, 'Anulacion Plan de Pagos','INVOICE_ID =,$numeroordenpago  TRANSFER_DT=$fechapago', 'ERRNUM=2, DESCRLONG=No se puede anular. La orden ya fue pagada', '$numeroordenpago',now())";
					$logps = $db->Execute($query_logps) or die(mysql_error());
		
			return array(
				'ERRNUM' => 2,
				'DESCRLONG' => 'No se puede anular. La orden ya fue pagada'
			);
		}
	
	} else {
			// ORDEN DE PAGO INEXISTENTE EN SALA. SE REGISTRA EN EL TRACE 
					$query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
								enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
								fecharegistrologtraceintegracionps)
							VALUES( 0, 'Anulacion Plan de Pagos','INVOICE_ID =,$numeroordenpago  TRANSFER_DT=$fechapago', 'ERRNUM=1, DESCRLONG=Numero Orden Pago no Existe o No es de Plan de Pagos', '$numeroordenpago',now())";
					$logps = $db->Execute($query_logps) or die(mysql_error());
		return array(
			'ERRNUM' => 1,
			'DESCRLONG' => 'Numero Orden Pago no Existe o No es de Plan de Pagos'
		);
	}	
}
?>