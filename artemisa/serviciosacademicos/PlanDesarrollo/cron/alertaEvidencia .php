
<html>
<head>
	<style>
		table, td, th {    
			border: 1px solid #ddd;
			text-align: left;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			padding: 10px;
		}
	</style>
</head>
<body>

<?php
	include_once ('../../EspacioFisico/templates/template.php');
	require_once ('../../funciones/phpmailerv2/PHPMailerAutoload.php');
	$metaSecundaria = $_POST['metaSecundaria']; 
	$db = getBD();
	
  	$sqlFacultad="
   				SELECT
					pd.CodigoFacultad
				FROM
					avancesIndicadorPlanDesarrollo aipd
				INNER JOIN MetaSecundariaPlanDesarrollo mspd ON aipd.IndicadorPlanDesarrolloId = mspd.MetaSecundariaPlanDesarrolloId
				INNER JOIN MetaIndicadorPlanDesarrollo mipd ON mspd.MetaIndicadorPlanDesarrolloId = mipd.MetaIndicadorPlanDesarrolloId
				INNER JOIN ProyectoPlanDesarrollo ppd ON mipd.ProyectoPlanDesarrolloId = ppd.ProyectoPlanDesarrolloId
				INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON ppd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId
				INNER JOIN ProgramaPlanDesarrollo propd ON pppd.ProgramaPlanDesarrolloId = propd.ProgramaPlanDesarrolloId
				INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON propd.ProgramaPlanDesarrolloId = pdple.ProgramaPlanDesarrolloId
				INNER JOIN LineaEstrategica ln ON pdple.LineaEstrategicaId = ln.LineaEstrategicaId
				INNER JOIN PlanDesarrollo pd ON pdple.PlanDesarrolloId = pd.PlanDesarrolloId
				WHERE
					mspd.MetaSecundariaPlanDesarrolloId = $metaSecundaria
				group by pd.CodigoFacultad";
    	
		if($ResultadoFacultad=&$db->Execute($sqlFacultad)===false){
			echo 'Error en consulta a base de datos '.$sqlCorreos;
			die;    
		}
    	if(!$ResultadoFacultad->EOF){
    		$codigoFacultad=utf8_decode($ResultadoFacultad->fields['CodigoFacultad']);
    	}
    	
    		$SQL = "SELECT
					pd.NombrePlanDesarrollo,
					ln.NombreLineaEstrategica,
					propd.NombrePrograma,
					ppd.NombreProyectoPlanDesarrollo,
					mipd.NombreMetaPlanDesarrollo,
					mspd.NombreMetaSecundaria,
					ppd.EmailResponsableProyecto,
					mspd.EmailResponsableMetaSecundaria
				FROM
					avancesIndicadorPlanDesarrollo aipd
				INNER JOIN MetaSecundariaPlanDesarrollo mspd ON aipd.IndicadorPlanDesarrolloId = mspd.MetaSecundariaPlanDesarrolloId
				INNER JOIN MetaIndicadorPlanDesarrollo mipd ON mspd.MetaIndicadorPlanDesarrolloId = mipd.MetaIndicadorPlanDesarrolloId
				INNER JOIN ProyectoPlanDesarrollo ppd ON mipd.ProyectoPlanDesarrolloId = ppd.ProyectoPlanDesarrolloId
				INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON ppd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId
				INNER JOIN ProgramaPlanDesarrollo propd ON pppd.ProgramaPlanDesarrolloId = propd.ProgramaPlanDesarrolloId
				INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON propd.ProgramaPlanDesarrolloId = pdple.ProgramaPlanDesarrolloId
				INNER JOIN LineaEstrategica ln ON pdple.LineaEstrategicaId = ln.LineaEstrategicaId
				INNER JOIN PlanDesarrollo pd ON pdple.PlanDesarrolloId = pd.PlanDesarrolloId
				WHERE
					mspd.MetaSecundariaPlanDesarrolloId = $metaSecundaria
				group by pd.NombrePlanDesarrollo
				
				";
						
			if($Resultado=&$db->Execute($SQL)===false){
			echo 'Error en consulta a base de datos '.$SQL;
			die;    
		}
			
		$html = '
		<html>
			<head>
				<style>
					table, td, th {    
						border: 1px solid #ddd;
						text-align: left;
					}
			
					table {
						border-collapse: collapse;
						width: 100%;
					}
			
					th, td {
						padding: 10px;
					}
				</style>
			</head>
			<body>
					<page style="margin: 0; padding: 0; font-family: Verdana, Arial; font-size: 13px;">
										<div style="width: 100%;">
											<div style="width:100%; background-color: #364329; height: 95px;"><img style="margin-left: 50px; margin-top: 15px;" src="cid:logo" alt="logo" /></div>
			
											<div style="width:80%; margin:auto;">
												
												
												<div align="justify">
													<table align="center">
														<tr>
															<th colspan="6" align="center">
																 <h2 align="center">Tiene nuevos avances pendientes por evaluar en el sistema SALA para el ';
																 if(!$Resultado->EOF){
																 
																 $html.=$Resultado->fields['NombrePlanDesarrollo'];
																 }
																 
														$html.='</h2>
															</th>
														</tr>
														<tr>
															<th>Plan de desarrollo</th>	
															<th>Linea estrategica</th>												
															<th>Nombre programa</th>												
															<th>Nombre proyecto</th>	
															<th>Nombre Meta</th>
															<th>Avance anual</th>
																										
																										
														</tr>';
															if(!$Resultado->EOF){
																while(!$Resultado->EOF){
																	$email = utf8_decode($Resultado->fields['EmailResponsableMetaSecundaria']);
																	$emailProyecto = utf8_decode($Resultado->fields['EmailResponsableProyecto']);				
																	$html .=  '<tr><td>'.utf8_decode($Resultado->fields['NombrePlanDesarrollo']).'</td>
																				<td>'.utf8_decode($Resultado->fields['NombreLineaEstrategica']).'</td>
																				<td>'.utf8_decode($Resultado->fields['NombrePrograma']).'</td>
																				<td>'.utf8_decode($Resultado->fields['NombreProyectoPlanDesarrollo']).'</td>																	
																				<td>'.utf8_decode($Resultado->fields['NombreMetaPlanDesarrollo']).'</td>
																				<td>'.utf8_decode($Resultado->fields['NombreMetaSecundaria']).'</td>
																				</tr>';
																	$Resultado->MoveNext();
																}
															}
														$html .= '
													</table>
												</div>
												<p>&nbsp;</p>
												<hr />        
												<p style="font-size: 11px;" align="center">Av. Cra 9 No. 131 A - 02 &middot; Edificio Fundadores &middot; L&iacute;nea Gratuita 018000 113033 &middot; PBX (571) 6489000 &middot; Bogot&aacute; D.C. - Colombia.</p>
											</div>
									</div>
							</page>
					</body>
			</html>';
	echo $html;
	
				$sqlMail = "
						SELECT
								DISTINCT U.idusuario,
								UF.emailusuariofacultad
							FROM 
								usuario U
							INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
							INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
					        INNER JOIN usuariorol UR ON (UR.idusuariotipo = UT.UsuarioTipoId)
							INNER JOIN rol R ON ( R.idrol = UR.idrol )
							INNER JOIN claveusuario CU ON ( CU.idusuario = U.idusuario )
							INNER JOIN carrera C ON ( C.codigocarrera = UF.codigofacultad )
							INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
							WHERE  
								U.codigotipousuario = 400 AND R.idrol in (93,98)
								AND CU.codigoestado = 100 AND F.codigoestado=100
								AND F.codigofacultad='".$codigoFacultad."' AND UF.emailusuariofacultad<>''";
								
						    if($ResultadoCorreos=&$db->Execute($sqlMail)===false){
								echo 'Error en consulta a base de datos '.$sqlMail;
								die;    
							}		
								
								if(!$ResultadoCorreos->EOF){
									while(!$ResultadoCorreos->EOF){
											$correos = $ResultadoCorreos->fields['emailusuariofacultad'];	
											
											$address = 'riveradiego@unbosque.edu.co';
											$mail = new PHPMailer;
											$mail->setFrom($address, 'Universidad El Bosque');
											$mail->isHTML(true);
											$mail->Subject = "Resumen de avances pendientes por evaluar - Sistema gestión del plan de desarrollo";
											$mail->Body = $html;
											$mail->AddEmbeddedImage('logonegro.png', 'logo');
											$mail->AddAddress( $correos,'Universidad El Bosque');
											echo 'Enviando correo... <br />';
											if(!$mail->Send()) {
												echo "Mailer Error: " . $mail->ErrorInfo;
											}else{
												echo 'Correo enviado';
											}
											$ResultadoCorreos->MoveNext();	
									}
								}	
			
?>
</body>
</html>