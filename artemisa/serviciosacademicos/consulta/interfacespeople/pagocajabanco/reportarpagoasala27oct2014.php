<?php
function InformacionCajaBancos($numeroordenpago, $fechapagoordenpago) {
	global $db;
	global $salaobjecttmp;

	$querycontrol = $db->Execute("SELECT * from controlreportepagospeoplesala WHERE numeroordenpago='$numeroordenpago'");
	if($querycontrol->RecordCount()==0)  {
	        $db->Execute("INSERT INTO controlreportepagospeoplesala (numeroordenpago,errnum,descrlong) VALUES ('$numeroordenpago',99,'En proceso')");

		$fechapago = cambiaf_a_sala($fechapagoordenpago);
		$fechahoy=date("Y-m-d");

		$nuevafecha= explode("-", $fechapago);
		$anio=$nuevafecha[0];
		$mes=$nuevafecha[1];
		$dia=$nuevafecha[2];

		if(checkdate((int) $mes, (int) $dia, (int) $anio) && $fechapago<=$fechahoy){
			$query_data = "SELECT * FROM ordenpago
					WHERE numeroordenpago = '$numeroordenpago'";
			//echo $query_data,"<br>";
			$data = $db->Execute($query_data);
			$totalRows_data = $data->RecordCount();
			$row_data = $data->FetchRow();        

			$digito = ereg_replace("^[0-9]{1,1}", "", $row_data['codigoestadoordenpago']);

			if ($row_data <> "") { 
				$query_prematricula = "UPDATE prematricula p,ordenpago o
							set codigoestadoprematricula = 4" . $digito . "
							where o.idprematricula = '" . $row_data['idprematricula'] . "'
								and o.codigoestudiante = p.codigoestudiante
								and o.numeroordenpago = '$numeroordenpago'
								and o.codigoperiodo = p.codigoperiodo";
				$prematricula = $db->Execute($query_prematricula) or die("$query_prematricula" . mysql_error());


				$query_detalleprematricula = "UPDATE detalleprematricula
								set codigoestadodetalleprematricula = '30'
								where numeroordenpago = '$numeroordenpago'
									and codigoestadodetalleprematricula like '1%'";
				$detalleprematricula = $db->Execute($query_detalleprematricula) or die("$query_detalleprematricula" . mysql_error());

				$query_conceptoorden = "SELECT do.codigoconcepto
							FROM detalleordenpago do,concepto c
							WHERE do.numeroordenpago = '$numeroordenpago'
								AND do.codigoconcepto = c.codigoconcepto
								AND c.cuentaoperacionprincipal = '153'";
				$conceptoorden= $db->Execute($query_conceptoorden)or die("$query_conceptoorden" . mysql_error());
				$totalRows_conceptoorden= $conceptoorden->RecordCount();
				$row_conceptoorden= $conceptoorden->FetchRow();

				$query = "  select * 
						from ordenpago
						join estudiante using(codigoestudiante)
						join estudiantegeneral using(idestudiantegeneral)
						join usuario using(numerodocumento)
						where numeroordenpago='$numeroordenpago'";
				$reg_exec = $db->Execute($query);
				if($reg_exec->RecordCount()==0)
					$objetoclaveusuario = new GeneraClaveUsuario($numeroordenpago, $salaobjecttmp);//CREA CUENTA CORREO

				if ($row_conceptoorden <> "") { 

					$query_inscripcionorden = "select max(i1.idinscripcion) maxidinscripcion
									from ordenpago op1,estudiante e1,inscripcion i1,estudiantecarrerainscripcion ec1
									where op1.codigoestudiante = e1.codigoestudiante
										AND e1.idestudiantegeneral = i1.idestudiantegeneral
										AND e1.codigocarrera = ec1.codigocarrera
										AND i1.idinscripcion = ec1.idinscripcion
										AND op1.numeroordenpago = '" . $numeroordenpago . "'
										and e1.codigoperiodo = '" . $row_data['codigoperiodo'] . "'";

					$inscripcionorden = $db->Execute($query_inscripcionorden)or die("$query_inscripcionorden" . mysql_error());
					$totalRows_inscripcionorden = $inscripcionorden ->RecordCount();
					$row_inscripcionorden = $inscripcionorden ->FetchRow();                

					$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
								SET i.codigosituacioncarreraestudiante = '107',
									e.codigosituacioncarreraestudiante = '107',
									e.codigoperiodo = '" . $row_data['codigoperiodo'] . "'
								WHERE o.codigoestudiante = e.codigoestudiante
									AND e.idestudiantegeneral = i.idestudiantegeneral
									AND e.codigocarrera = ec.codigocarrera
									AND i.idinscripcion = ec.idinscripcion
									AND o.numeroordenpago = '$numeroordenpago'
									and i.idinscripcion ='" . $row_inscripcionorden['maxidinscripcion'] . "'
									and o.codigoperiodo = i.codigoperiodo";                    
					$inscripcion = $db->Execute($query_inscripcion)or die("$query_inscripcion" . mysql_error());
				} 

				$query_ordenpago = "UPDATE ordenpago
							set codigoestadoordenpago = 4" . $digito . ",		
								fechapagosapordenpago = '$fechapago'
							where numeroordenpago = '$numeroordenpago'";           
				$ordenpago = $db->Execute($query_ordenpago) or die("$query_ordenpago" . mysql_error());

				// ************************************************************************************************
				// SE PAGA LA ORDEN EN SALA. SE REGISTRA EN EL TRACE Y SE ACTUALIZA EL ESTADO EN LA TABLA DE CONTROL
				$query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
							enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
							fecharegistrologtraceintegracionps,estadoenvio)
						VALUES( 0, 'Pago Caja-Bancos','INVOICE_ID =,$numeroordenpago  TRANSFER_DT=$fechapago', 'ERRNUM=0, DESCRLONG=Ok', '$numeroordenpago',now(),1)";
				$logps = $db->Execute($query_logps) or die(mysql_error());
	        		
				$db->Execute("UPDATE controlreportepagospeoplesala SET fechaactualizacionreporte=now(),errnum=0,descrlong='Ok' WHERE numeroordenpago='$numeroordenpago'");
				// ************************************************************************************************

				// Verifica si esa orden tiene descuentos

				$query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante
							FROM ordenpago o,detalleordenpago d
							WHERE o.numeroordenpago = '$numeroordenpago'
								AND o.numeroordenpago = d.numeroordenpago
								AND d.codigotipodetalleordenpago = 2";
				//echo $query_data,"<br>";
				$detalleorden = $db->Execute($query_detalleorden) or die(mysql_error());
		

				while ($row_detalleorden = $detalleorden->FetchRow()) {
					$query_consultadvd = "SELECT iddescuentovsdeuda
								FROM descuentovsdeuda
								WHERE codigoestudiante = '" . $row_detalleorden['codigoestudiante'] . "'
									and codigoestadodescuentovsdeuda = '01'
									and codigoperiodo = '" . $row_detalleorden['codigoperiodo'] . "'
									and codigoconcepto = '" . $row_detalleorden['codigoconcepto'] . "'
									and valordescuentovsdeuda = '" . $row_detalleorden['valorconcepto'] . "'";
					$consultadvd = $db->Execute($query_consultadvd) or die("$query_consultadvd" . mysql_error());
					$totalRows_consultadvd= $consultadvd->RecordCount();
					$row_consultadvd= $consultadvd->FetchRow(); 
					
					if ($row_consultadvd <> "") {
						$base3 = "update descuentovsdeuda
							set  codigoestadodescuentovsdeuda = '03'
							where iddescuentovsdeuda = '" . $row_consultadvd['iddescuentovsdeuda'] . "'";
						$sol3 = $db->Execute($base3);
						echo $base3;
					}
				}		


				/////////////////////  Si Existe plan de pagos  ////////////////////////////////////////////////////////////
				$query_plan = "SELECT * FROM ordenpagoplandepago
						WHERE numerorodencoutaplandepagosap = '$numeroordenpago'";
				//echo $query_data,"<br>";
				$plan = $db->Execute($query_plan) or die(mysql_error());
				$row_plan = $plan->FetchRow();
				$totalRows_plan = $plan->RecordCount();

				if ($row_plan <> "") { //if 2
					$numeroordenpago = $row_plan['numerorodenpagoplandepagosap'];
					$digito = ereg_replace("^[0-9]{1,1}", "", $row_data['codigoestadoordenpago']);
					//echo $query_prematricula;

					$query="select * 
						from ordenpago
						join estudiante using(codigoestudiante)
						join estudiantegeneral using(idestudiantegeneral)
						join usuario using(numerodocumento)
						where numeroordenpago='$numeroordenpago'";
					$reg_exec = $db->Execute($query);
					if($reg_exec->RecordCount()==0)
						$objetoclaveusuario = new GeneraClaveUsuario($numeroordenpago, $salaobjecttmp); //CREA CUENTA CORREO

					$query_detalleprematricula = "UPDATE detalleprematricula
									set codigoestadodetalleprematricula = '30'
									where numeroordenpago = '$numeroordenpago'
										and codigoestadodetalleprematricula like '1%'";
					$detalleprematricula = $db->Execute($query_detalleprematricula) or die("$query_detalleprematricula" . mysql_error());

					/*  $query_plan1 = "UPDATE ordenpagoplandepago
					set numerorodencoutaplandepagosap = '300'
					WHERE numerorodencoutaplandepagosap = '$numeroordenpago'";
					$plan1=mysql_db_query($database_sala,$query_plan1) or die("$query_plan1".mysql_error()); */

					$query_planes = "update ordenpagoplandepago
							set codigoindicadorprocesosap	= '300'
							WHERE numerorodencoutaplandepagosap = '" . $row_plan['numerorodencoutaplandepagosap'] . "'";
					$planes = $db->Execute($query_planes) or die("$query_planes" . mysql_error());


					$query_conceptoorden = "SELECT do.codigoconcepto
								FROM detalleordenpago do,concepto c
								WHERE do.numeroordenpago = '$numeroordenpago'
									AND do.codigoconcepto = c.codigoconcepto
									AND c.cuentaoperacionprincipal = '153'";
					$conceptoorden = $db->Execute($query_conceptoorden) or die("$query_conceptoorden" . mysql_error());
					$totalRows_conceptoorden = $conceptoorden->RecordCount();
					$row_conceptoorden = $conceptoorden->FetchRow();

					if ($row_conceptoorden <> "") { 
						$query_conceptoorden = "select max(i1.idinscripcion) maxidinscripcion
									from ordenpago op1,estudiante e1,inscripcion i1,estudiantecarrerainscripcion ec1
									where op1.codigoestudiante = e1.codigoestudiante
										AND e1.idestudiantegeneral = i1.idestudiantegeneral
										AND e1.codigocarrera = ec1.codigocarrera
										AND i1.idinscripcion = ec1.idinscripcion
										AND op1.numeroordenpago = '" . $numeroordenpago . "'
										and e1.codigoperiodo = '" . $row_data['codigoperiodo'] . "'";
						$inscripcionorden = $db->Execute($query_conceptoorden) or die("$query_conceptoorden" . mysql_error());
						$totalRows_inscripcionorden = $conceptoorden->RecordCount();
						$row_inscripcionorden = $conceptoorden->FetchRow();

						$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
									SET i.codigosituacioncarreraestudiante = '107',
										e.codigosituacioncarreraestudiante = '107',
										e.codigoperiodo = '" . $row_data['codigoperiodo'] . "'
									WHERE o.codigoestudiante = e.codigoestudiante
										AND e.idestudiantegeneral = i.idestudiantegeneral
										AND e.codigocarrera = ec.codigocarrera
										AND i.idinscripcion = ec.idinscripcion
										AND o.numeroordenpago = '$numeroordenpago'
										and i.idinscripcion ='" . $row_inscripcionorden['maxidinscripcion'] . "'
										and o.codigoperiodo = i.codigoperiodo";
						$inscripcion = $db->Execute($query_inscripcion) or die("$query_inscripcion" . mysql_error());

					} // if 2

					$query_ordenpago = "UPDATE ordenpago
								set codigoestadoordenpago = 4" . $digito . ",		
									fechapagosapordenpago = '$fechapago'
								where numeroordenpago = '$numeroordenpago'";                
					$ordenpago = $db->Execute($query_ordenpago) or die("$query_ordenpago" . mysql_error());

					// ************************************************************************************************
					// SE PAGA LA ORDEN PADRE EN SALA. SE REGISTRA EN EL TRACE Y EN LA TABLA DE CONTROL TAMBIEN SE
					// REGISTRA EL PAGO, YA QUE DESDE PS SOLO LLEGA LA ORDEN HIJA, MAS NO LA PADRE
					$query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
								enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
								fecharegistrologtraceintegracionps,estadoenvio)
							VALUES( 0, 'Pago Caja-Bancos','INVOICE_ID =,$numeroordenpago  TRANSFER_DT=$fechapago', 'ERRNUM=0, DESCRLONG=Ok, se realiza el pago de la orden padre', '$numeroordenpago',now(),1)";
					$logps = $db->Execute($query_logps) or die(mysql_error());
					
	        			$db->Execute("INSERT INTO controlreportepagospeoplesala (numeroordenpago,errnum,descrlong,fechaactualizacionreporte) VALUES ('$numeroordenpago',0,'Ok, se realiza el pago de la orden padre',now())");
					// ************************************************************************************************

					// Verifica si esa orden tiene descuentos

					$query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante
								FROM ordenpago o,detalleordenpago d
								WHERE o.numeroordenpago = '$numeroordenpago'
									AND o.numeroordenpago = d.numeroordenpago
									AND d.codigotipodetalleordenpago = 2";                
					$detalleorden = $db->Execute($query_detalleorden) or die(mysql_error());


					while ($row_detalleorden = $detalleorden->FetchRow()) {
						$query_consultadvd = "SELECT iddescuentovsdeuda
									FROM descuentovsdeuda
									WHERE codigoestudiante = '" . $row_detalleorden['codigoestudiante'] . "'
										and codigoestadodescuentovsdeuda = '01'
										and codigoperiodo = '" . $row_detalleorden['codigoperiodo'] . "'
										and codigoconcepto = '" . $row_detalleorden['codigoconcepto'] . "'
										and valordescuentovsdeuda = '" . $row_detalleorden['valorconcepto'] . "'";
						$consultadvd = $db->Execute($query_consultadvd) or die("$query_consultadvd" . mysql_error());
						$totalRows_consultadvd = $consultadvd->RecordCount();
						$row_respuestadvd = $consultadvd->FetchRow();

						if ($row_respuestadvd <> "") {
							$base3 = "update descuentovsdeuda
								set  codigoestadodescuentovsdeuda = '03'
								where iddescuentovsdeuda = '" . $row_respuestadvd['iddescuentovsdeuda'] . "'";
							$sol3 = $db->Execute($base3);
						}
					}                
				}           

				return array(
					'ERRNUM' =>0,
					'DESCRLONG' => 'Ok'
				);

				//return $param;//new soapval('ERRNUM','xsd:string',$param2);

			} else {
				if($numeroordenpago<1000000) {
					// return new soap_fault("Client", "", "Número Orden Pago Incorrecto");
					// ************************************************************************************************
					// ORDEN DE PAGO MENOR A 1000000 INEXISTENTE EN SALA. SE REGISTRA EN EL TRACE Y SE ACTUALIZA EL ESTADO
					// EN LA TABLA DE CONTROL
					$query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps, enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps, fecharegistrologtraceintegracionps,estadoenvio)
	VALUES( 0, 'Pago Caja-Bancos','INVOICE_ID =,$numeroordenpago  TRANSFER_DT=$fechapago', 'ERRNUM=0, DESCRLONG=Ok, orden de pago menor a 1000000, ser reporta como Ok para finalizarlas en PS', '$numeroordenpago',now(),1)";
					$logps = $db->Execute($query_logps) or die(mysql_error());
				
					$db->Execute("UPDATE controlreportepagospeoplesala SET fechaactualizacionreporte=now(),errnum=0,descrlong='Ok, orden de pago menor a 1000000, ser reporta como Ok para finalizarlas en PS' WHERE numeroordenpago='$numeroordenpago'");
					// ************************************************************************************************

					return array(
						'ERRNUM' =>0,
						'DESCRLONG' => 'Ok'
					);
				} else {
					// return new soap_fault("Client", "", "Número Orden Pago Incorrecto");
					// ************************************************************************************************
					// ORDEN DE PAGO INEXISTENTE EN SALA. SE REGISTRA EN EL TRACE Y SE ACTUALIZA EL ESTADO EN LA TABLA DE CONTROL
					$query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
								enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
								fecharegistrologtraceintegracionps,estadoenvio)
							VALUES( 0, 'Pago Caja-Bancos','INVOICE_ID =,$numeroordenpago  TRANSFER_DT=$fechapago', 'ERRNUM=1, DESCRLONG=Numero Orden Pago no Existe', '$numeroordenpago',now(),1)";
					$logps = $db->Execute($query_logps) or die(mysql_error());
				
					$db->Execute("UPDATE controlreportepagospeoplesala SET fechaactualizacionreporte=now(),errnum=1,descrlong='Numero Orden Pago no Existe' WHERE numeroordenpago='$numeroordenpago'");
					// ************************************************************************************************

					return array(
						'ERRNUM' => 1,
						'DESCRLONG' => 'Numero Orden Pago no Existe'
					);
				}
			}

		} else {
			// ************************************************************************************************
			// ORDEN DE PAGO CON FECHA INCORRECTA. SE REGISTRA EN EL TRACE Y SE ACTUALIZA EL ESTADO EN LA TABLA DE CONTROL
			$query_logps="INSERT INTO logtraceintegracionps(idlogtraceintegracionps, transaccionlogtraceintegracionps,
						enviologtraceintegracionps, respuestalogtraceintegracionps, documentologtraceintegracionps,
						fecharegistrologtraceintegracionps,estadoenvio)
					VALUES( 0, 'Pago Caja-Bancos','INVOICE_ID =$numeroordenpago,  TRANSFER_DT=$fechapago',
						'ERRNUM=2, DESCRLONG=Fecha incorrecta', '$numeroordenpago',now(),1)";
			$logps = $db->Execute($query_logps) or die(mysql_error());
			
			$db->Execute("UPDATE controlreportepagospeoplesala SET fechaactualizacionreporte=now(),errnum=2,descrlong='Fecha incorrecta' WHERE numeroordenpago='$numeroordenpago'");
			// ************************************************************************************************

			return array(
				'ERRNUM' => 2,
				'DESCRLONG' => 'Fecha incorrecta'
			);
		}
	}
	 else {
	        $rowcontrol = $querycontrol->FetchRow();
	        return array('ERRNUM'=>$rowcontrol['errnum'],'DESCRLONG'=>$rowcontrol['descrlong']);
	}
}

?>
