<?php

session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
include_once ('../templates/template.php');
$db = getBD();
function redondear_hora($hora){
    $sep = explode(':', $hora);
    $minutos=$sep[1];
    $hora=$sep[0];
    if($minutos>30){
        $hora=$hora+1;
    }
    return $hora;  // sin minutos
}
	switch($_REQUEST['actionID']){
		case 'cargar_aula':{
			$bloque = $_REQUEST['bloque'];
			$SQL = 'SELECT ClasificacionEspaciosId, Nombre FROM ClasificacionEspacios WHERE ClasificacionEspacionPadreId = '.$bloque;
			if($Resultado=&$db->Execute($SQL)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR '.$SQL;
            }
			$id_aula = array();
			$nombre_aula = array();
			$i = 0;
			if($Resultado->_numOfRows != 0){
				if(!$Resultado->EOF){
					while(!$Resultado->EOF){
						$id_aula[$i] = $Resultado->fields['ClasificacionEspaciosId'];
						$nombre_aula[$i] = $Resultado->fields['Nombre'];
						$Resultado->MoveNext();
						$i++;
					}
				}
			}
			$a_vectt['id_aula'] = $id_aula;
			$a_vectt['nombre_aula'] = $nombre_aula;
			echo json_encode($a_vectt);
		}break;
		case 'cargar_datos':{
			$aula = $_REQUEST['aula'];
			$a_vectt['AsignacionEspaciosNoAsignadosId'] = 0;
			$SQL = 'SELECT
						a.AsignacionEspaciosId,
						a.FechaAsignacion,
						a.HoraInicio,
						a.HoraFin,
						c.Nombre,
						g.nombregrupo,
						s.codigomodalidadacademica,
						s.NombreEvento,
						s.Responsable,
						cr.nombrecarrera,
						ca.nombrecarrera AS OtherCarrera,
						c.CapacidadEstudiantes,
						g.idgrupo,
						CONCAT(
							dc.nombredocente,
							" ",
							dc.apellidodocente
						) AS FullDocente,
						m.nombremateria
					FROM
						AsignacionEspacios a
					INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId
					INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
					LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
					LEFT JOIN grupo g ON g.idgrupo = sg.idgrupo
					LEFT JOIN materia m ON m.codigomateria = g.codigomateria
					LEFT JOIN carrera cr ON cr.codigocarrera = m.codigocarrera
					LEFT JOIN docente dc ON dc.numerodocumento = g.numerodocumento
					INNER JOIN carrera ca ON ca.codigocarrera = s.codigocarrera
					WHERE
						a.FechaAsignacion = CURDATE()
					AND CURTIME() BETWEEN a.HoraInicio
					AND a.HoraFin
					AND a.codigoestado = 100
					AND a.ClasificacionEspaciosId = '.$aula.'
					AND (
						sg.codigoestado = 100
						OR sg.codigoestado IS NULL
					)
					LIMIT 1';
			if($Resultado=&$db->Execute($SQL)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR '.$SQL;
            }
			$a_vectt['AsignacionEspaciosId'] = $Resultado->fields['AsignacionEspaciosId'];
			$a_vectt['FechaAsignacion'] = $Resultado->fields['FechaAsignacion'];
			$a_vectt['HoraInicio'] = $Resultado->fields['HoraInicio'];
			$a_vectt['HoraFin'] = $Resultado->fields['HoraFin'];
			$a_vectt['Nombre'] = $Resultado->fields['Nombre'];
			$a_vectt['nombregrupo'] = $Resultado->fields['nombregrupo'];
			$a_vectt['codigomodalidadacademica'] = $Resultado->fields['codigomodalidadacademica'];
			$a_vectt['nombremateria'] = ($Resultado->fields['codigomodalidadacademica'] == 001) ? $Resultado->fields['nombremateria'] : $Resultado->fields['NombreEvento'];
			$a_vectt['Responsable'] = ($Resultado->fields['codigomodalidadacademica'] == 001) ? $Resultado->fields['FullDocente'] : $Resultado->fields['Responsable'];
			if($Resultado->_numOfRows == 0){
				$SQL = 'SELECT * FROM AsignacionEspaciosNoAsignados 
						WHERE FechaAsignacion = CURDATE() 
						AND CURTIME() BETWEEN HoraInicio AND HoraFin
						AND codigoestado = 100
						AND Aula = "'.$aula.'" LIMIT 1';
				if($Asignacion=&$db->Execute($SQL)===false){
					$a_vectt['val'] = 'FALSE';
					$a_vectt['descrip'] = 'ERROR '.$SQL;
				}
				if($Asignacion->fields['AsignacionEspaciosNoAsignadosId'] != NULL && $Asignacion->fields['AsignacionEspaciosNoAsignadosId'] != 0){
					$a_vectt['AsignacionEspaciosNoAsignadosId'] = $Asignacion->fields['AsignacionEspaciosNoAsignadosId'];
					$SQL = 'SELECT * FROM LogsMonitoreosEspaciosFisicos WHERE AsignacionEspaciosNoAsignadosId = '.$Asignacion->fields['AsignacionEspaciosNoAsignadosId'];
					if($Log=&$db->Execute($SQL)===false){
						$a_vectt['val'] = 'FALSE';
						$a_vectt['descrip'] = 'ERROR '.$SQL;
					}
					$a_vectt['nuevo'] = 0;
					if($Log->fields['LogMonitoreoEspacioFisicoId'] == NULL){
						$a_vectt['LogMonitoreoEspacioFisicoId'] = 0;
						$a_vectt['UltimaModificacion'] = 'N/A';
						$a_vectt['nuevo'] = 1;
					}else{
						$a_vectt['LogMonitoreoEspacioFisicoId'] = $Log->fields['LogMonitoreoEspacioFisicoId'];
						$a_vectt['UltimaModificacion'] = $Log->fields['FechaUltimaModificacion'];
					}
				}
			}else{
				$SQL = 'SELECT * FROM LogsMonitoreosEspaciosFisicos WHERE AsignacionEspaciosId = '.$Resultado->fields['AsignacionEspaciosId'];
				if($Log=&$db->Execute($SQL)===false){
					$a_vectt['val'] = 'FALSE';
					$a_vectt['descrip'] = 'ERROR '.$SQL;
				}
				$a_vectt['nuevo'] = 0;
				if($Log->fields['LogMonitoreoEspacioFisicoId'] == NULL){
					$a_vectt['LogMonitoreoEspacioFisicoId'] = 0;
					$a_vectt['UltimaModificacion'] = 'N/A';
					$a_vectt['nuevo'] = 1;
				}else{
					$a_vectt['LogMonitoreoEspacioFisicoId'] = $Log->fields['LogMonitoreoEspacioFisicoId'];
					$a_vectt['Observacion'] = $Log->fields['Observacion'];
					if($Log->fields['UsuarioUltimaModificacion'] == NULL){
						$a_vectt['UltimaModificacion'] = 'Ultima modificacion realizada el: '.$Log->fields['FechaCreacion'];
					}else{
						$a_vectt['UltimaModificacion'] = 'Ultima modificacion realizada el: '.$Log->fields['FechaUltimaModificacion'];
					}
				}
			}							
			echo json_encode($a_vectt);			
		}break;
		case 'guardar_datos':{
			$aula = $_REQUEST['aula'];
			$ocupado = $_REQUEST['ocupado'];
			$observacion = $_REQUEST['observacion'];
			$LogMonitoreoEspacioFisicoId = $_REQUEST['LogMonitoreoEspacioFisicoId'];
			$AsignacionEspaciosNoAsignadosId = $_REQUEST['AsignacionEspaciosNoAsignadosId'];
			$AsignacionEspaciosId = $_REQUEST['AsignacionEspaciosId'];
			$nuevo = $_REQUEST['nuevo'];
			$usuario = $_REQUEST['usuario'];
			$ocupado = $_REQUEST['ocupado'];
			$observacion = $_REQUEST['observacion'];
			$LogMonitoreoEspacioFisicoId = $_REQUEST['LogMonitoreoEspacioFisicoId'];
			if($AsignacionEspaciosId != 0 && $AsignacionEspaciosId != null){
				
				/* EL DOCENTE NO SE ENCUENTRA EN CLASE */
				
					if($ocupado == 0){
						$SQL = 'SELECT
									s.codigocarrera,
									a.ClasificacionEspaciosId,
									a.FechaAsignacion,
									a.HoraInicio,
									a.HoraFin,
									c.Nombre AS Aula,
									cc.Nombre AS Bloque,
									ccc.Nombre AS Instalacion
								FROM
									AsignacionEspacios a
								INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
								INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
								INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
								INNER JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
								WHERE
									a.AsignacionEspaciosId = "'.$AsignacionEspaciosId.'"
								AND a.codigoestado = 100
								AND s.codigoestado = 100
								LIMIT 1';
						if($Resultado=&$db->Execute($SQL)===false){
							$a_vectt['val'] = 'FALSE';
							$a_vectt['descrip'] = 'ERROR '.$SQL;
						}
						$carrera = $Resultado->fields['codigocarrera'];
						$aula = $Resultado->fields['Aula'];
						$bloque = $Resultado->fields['Bloque'];
						$instalacion = $Resultado->fields['Instalacion'];
						$HoraInicio = $Resultado->fields['HoraInicio'];
						$HoraFin = $Resultado->fields['HoraFin'];
						$FechaAsignacion = $Resultado->fields['FechaAsignacion'];
						
                        $SQL ="select u.usuario, u.idusuario, CONCAT(u.usuario, '@unbosque.edu.co' ) AS CorreoPosible, CONCAT( u.nombres, ' ', u.apellidos, ' :: ', u.numerodocumento ) AS DataUser, uf.codigofacultad, rol.idrol, c.codigocarrera, c.nombrecarrera, IF (uf.emailusuariofacultad = ' ', 	 f.emailusuariofacultad, 	uf.emailusuariofacultad ) AS EmailUser  
                        from usuariorol rol
                        inner join UsuarioTipo ut on rol.idusuariotipo = ut.UsuarioTipoid
                        inner join usuario u on u.idusuario = ut.usuarioid
                        inner join usuariofacultad uf ON uf.usuario = u.usuario
                        INNER JOIN carrera c ON c.codigocarrera = uf.codigofacultad 
                        left join usuariofacultad f on f.usuario = u.usuario AND f.emailusuariofacultad <> ' ' AND f.emailusuariofacultad IS NOT NULL
                        where rol.idrol IN (3, 93) and c.codigocarrera='".$carrera."'";
                        
						if($Resultado=&$db->Execute($SQL)===false){
							$a_vectt['val'] = 'FALSE';
							$a_vectt['descrip'] = 'ERROR '.$SQL;
						}
						/*while(!$Resultado->EOF){
							if($Resultado->fields['EmailUser'] != '' && $Resultado->fields['EmailUser'] != NULL){
								$address = $Resultado->fields['EmailUser'];
							}else{
								$address = $Resultado->fields['CorreoPosible'];
							}
							
							require_once('../../mgi/autoevaluacion/interfaz/phpcaptcha/phpmailer/class.phpmailer.php');
							$mail             = new PHPMailer();			
							$body             = '<page style="margin: 0; padding: 0; font-family: Verdana, Arial; font-size: 13px;">
												<div style="width: 100%;">
													<div style="width:100%; background-color: #364329; height: 95px;"><img style="margin-left: 50px; margin-top: 15px;" src="../imagenes/logonegro.png" alt="logo" /></div>
													<div style="width:80%; margin:auto;">
														<p>&nbsp;</p>
														<p style="font-size: 15px;">Bogot&aacute;. '.strftime("%d de %B de %Y").'</p>									
														<p>&nbsp;</p>
														
														<div align="justify">
															<p>El Docente '.$_REQUEST['docente'].' no se encuentra en su clase del dia '.$FechaAsignacion.' en horario de '.$HoraInicio.' a '.$HoraFin.' en la instalación '.$instalacion.' en el '.$bloque.', aula '.$aula.'</p>
															<p>&nbsp;</p>
														</div>
														<p>&nbsp;</p>
														<p>&nbsp;</p> 
														<hr />        
														<p style="font-size: 11px;">Av. Cra 9 No. 131 A - 02 &middot; Edificio Fundadores &middot; L&iacute;nea Gratuita 018000 113033 &middot; PBX (571) 6489000 &middot; Bogot&aacute; D.C. - Colombia.</p>
													</div>
												</div>
												</page>';
							$mail->SetFrom($address, 'Universidad El Bosque');
							$mail->AddReplyTo($address,"Universidad El Bosque");
							$mail->Subject = "Alerta de inasistencia docente";
							$mail->MsgHTML($body);
							$mail->AddAddress($address, $_POST['nombres']);
							if(!$mail->Send()) {
								echo "Mailer Error: " . $mail->ErrorInfo;
							}
							$Resultado->MoveNext();
						}*/
					}
				
				/* FIN EL DOCENTE NO SE ENCUENTRA EN CLASE */
				
				
				if($nuevo == 1){
					$SQL = 'INSERT INTO LogsMonitoreosEspaciosFisicos (AsignacionEspaciosId, AsignacionEspaciosNoAsignadosId, FechaCreacion, UsuarioCreacion, Ocupado, Observacion) VALUES ("'.$AsignacionEspaciosId.'", NULL, "'.date("Y-m-d H:i:s").'", "'.$usuario.'", "'.$ocupado.'", "'.$observacion.'");';			
				}else{
					$SQL = 'UPDATE LogsMonitoreosEspaciosFisicos SET FechaUltimaModificacion = "'.date("Y-m-d H:i:s").'", UsuarioUltimaModificacion = "'.$usuario.'", Ocupado = "'.$ocupado.'", Observacion = "'.$observacion.'" WHERE LogMonitoreoEspacioFisicoId = "'.$LogMonitoreoEspacioFisicoId.'";';
				}
				if($Log=$db->Execute($SQL)===false){
					echo 'ERROR '.$SQL;
				}else{
					$a_vectt['mensaje'] = "Modificacion realizada";
					echo json_encode($a_vectt);
				}
			}else{
				if($AsignacionEspaciosNoAsignadosId != 0 || $AsignacionEspaciosNoAsignadosId != null){
					if($nuevo == 1){
						$fin = redondear_hora(date('H:i:s'));
						$inicio = $fin - 1;
						$SQL = 'INSERT INTO AsignacionEspaciosNoAsignados SET FechaAsignacion = CURDATE(), HoraInicio = "'.$inicio.':00", HoraFin = "'.$fin.':00", Aula = "'.$aula.'", codigoestado = 100';
						if($Resultado=&$db->Execute($SQL)===false){
							$a_vectt['val'] = 'FALSE';
							$a_vectt['descrip'] = 'ERROR '.$SQL;
						}
						$AsignacionEspaciosNoAsignadosId = $db->Insert_ID();
						$SQL = 'INSERT INTO LogsMonitoreosEspaciosFisicos (AsignacionEspaciosId, AsignacionEspaciosNoAsignadosId, FechaCreacion, UsuarioCreacion, Ocupado, Observacion) VALUES (NULL, "'.$AsignacionEspaciosNoAsignadosId.'", "'.date("Y-m-d H:i:s").'", "'.$usuario.'", "'.$ocupado.'", "'.$observacion.'");';			
					}else{
						$SQL = 'UPDATE LogsMonitoreosEspaciosFisicos SET FechaUltimaModificacion = "'.date("Y-m-d H:i:s").'", UsuarioUltimaModificacion = "'.$usuario.'", Ocupado = "'.$ocupado.'", Observacion = "'.$observacion.'" WHERE LogMonitoreoEspacioFisicoId = "'.$LogMonitoreoEspacioFisicoId.'";';
					}
					if($Log=$db->Execute($SQL)===false){
						echo 'ERROR '.$SQL;
					}else{
						$a_vectt['mensaje'] = "Modificacion realizada";
						echo json_encode($a_vectt);
					}
				}
			}			
		}break;
		case 'detalleAula':{
			$aula = $_REQUEST['aula'];
			$SQL = 'SELECT
						a.AsignacionEspaciosId,
						a.FechaAsignacion,
						a.HoraInicio,
						a.HoraFin,
						c.Nombre,
						g.nombregrupo,
						s.codigomodalidadacademica,
						s.NombreEvento,
						s.Responsable,
						cr.nombrecarrera,
						ca.nombrecarrera AS OtherCarrera,
						c.CapacidadEstudiantes,
						g.idgrupo,
						CONCAT(
							dc.nombredocente,
							" ",
							dc.apellidodocente
						) AS FullDocente,
						m.nombremateria
					FROM
						AsignacionEspacios a
					INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId
					INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
					LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
					LEFT JOIN grupo g ON g.idgrupo = sg.idgrupo
					LEFT JOIN materia m ON m.codigomateria = g.codigomateria
					LEFT JOIN carrera cr ON cr.codigocarrera = m.codigocarrera
					LEFT JOIN docente dc ON dc.numerodocumento = g.numerodocumento
					INNER JOIN carrera ca ON ca.codigocarrera = s.codigocarrera
					WHERE
						a.AsignacionEspaciosId = '.$aula.'					
					AND a.codigoestado = 100					
					LIMIT 1';
			if($Resultado=&$db->Execute($SQL)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR '.$SQL;
            }
			$ocupaciones = $Resultado->getarray();

			echo '<b>Fecha de asignacion:</b> '.$ocupaciones[0]['FechaAsignacion'].'<br />';
			echo '<b>Hora Inicio:</b> '.$ocupaciones[0]['HoraInicio'].'<br />';
			echo '<b>Hora Fin:</b> '.$ocupaciones[0]['HoraFin'].'<br />';
			echo '<b>Aula:</b> '.$ocupaciones[0]['Nombre'].'<br />';
			echo '<b>Carrera:</b> '.$ocupaciones[0]['nombrecarrera'].'<br />';
			echo '<b>Capacidad estudiantes:</b> '.$ocupaciones[0]['CapacidadEstudiantes'].'<br />';
			echo '<b>Docente:</b> '.$ocupaciones[0]['FullDocente'].'<br />';
			echo '<b>Materia:</b> '.$ocupaciones[0]['nombremateria'].'<br />';
		}break;		
	}
?>
