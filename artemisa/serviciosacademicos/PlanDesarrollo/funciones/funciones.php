<?php

/**
 * @author Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @funciones de reportes
 */
 
/* Include adodb */
/*error_reporting(E_ALL);
ini_set('display_errors', '1');
*/
include_once ('../../EspacioFisico/templates/template.php');
//require_once ('../../funciones/phpmailerv2/PHPMailerAutoload.php');
require_once '../../../sala/lib/PHPMailer/PHPMailerAutoload.php';

class funciones
{
	//Esta funcion calcula el indicador de la meta
	public function calcularIndicador()
	{

	}//function calcularIndicador


	//
	public function calcularProyecto()
	{

	}//function name


	//
	public function calcularPrograma()
	{

	}//function calcularPrograma


	//
	public function calcularLinea()
	{

	}//function calcularLinea


	//
	public function calcularPlan()
	{
		
	}//function calcularPlan

	//Funcion para realizar consultas de las alertas semanales
	public function alertaConsolidada(){
            $db = getBD();
            $date=date_create(date('Y-m-d'));
            date_modify($date,"+1 month");
            $dosSemanas = date_format($date,"Y-m-d");
		

            $sqlCorreos = "
                            SELECT
                                p.EmailResponsableProyecto,
                                mspd.EmailResponsableMetaSecundaria
                            FROM
                                MetaIndicadorPlanDesarrollo m
                            LEFT JOIN IndicadorPlanDesarrollo i ON m.IndicadorPlanDesarrolloId = i.IndicadorPlanDesarrolloId
                            LEFT JOIN ProyectoPlanDesarrollo p ON p.ProyectoPlanDesarrolloId = i.ProyectoPlanDesarrolloId
                            LEFT JOIN ProgramaProyectoPlanDesarrollo pp ON pp.ProyectoPlanDesarrolloId = p.ProyectoPlanDesarrolloId
                            LEFT JOIN ProgramaPlanDesarrollo ppd ON ppd.ProgramaPlanDesarrolloId = pp.ProgramaPlanDesarrolloId
                            LEFT JOIN PlanDesarrolloProgramaLineaEstrategica pdl ON pdl.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
                            LEFT JOIN MetaSecundariaPlanDesarrollo mspd ON mspd.MetaIndicadorPlanDesarrolloId = m.MetaIndicadorPlanDesarrolloId
                            INNER JOIN LineaEstrategica l ON pdl.LineaEstrategicaId = l.LineaEstrategicaId
                            WHERE
                                    m.VigenciaMeta <= '2021-03-01'
                            AND mspd.MetaSecundariaPlanDesarrolloId IS NOT NULL
                            AND DATEDIFF(
                                    mspd.FechaFinMetaSecundaria,
                                    now()
                            ) > 0
                            AND DATEDIFF(
                                    mspd.FechaFinMetaSecundaria,
                                    now()
                            ) < 30
                            OR DATEDIFF(m.VigenciaMeta, NOW()) > 0
                            AND DATEDIFF(m.VigenciaMeta, NOW()) < 30
                            AND mspd.ValorMetaSecundaria > mspd.AvanceResponsableMetaSecundaria
                            AND m.AlcanceMeta > m.AvanceMetaPlanDesarrollo
                            GROUP BY
                                    mspd.EmailResponsableMetaSecundaria";			

            if($Resultado=&$db->Execute($sqlCorreos)===false){
                    echo 'Error en consulta a base de datos '.$sqlCorreos;
                    die;    
            }
		
            $registros=$Resultado->RecordCount();
		
            if( $registros > 0){
								
                if(!$Resultado->EOF){
                    while( !$Resultado->EOF ) {
                        $emailProyecto = $Resultado->fields['EmailResponsableProyecto'];	
                        $emailMetaSecundaria = $Resultado->fields['EmailResponsableMetaSecundaria'];	
                        $sqlEnvios = "
                                    SELECT
                                        m.NombreMetaPlanDesarrollo,
                                        m.AlcanceMeta,
                                        m.VigenciaMeta,
                                        m.AvanceMetaPlanDesarrollo,
                                        l.NombreLineaEstrategica,
                                        ppd.NombrePrograma,
                                        p.NombreProyectoPlanDesarrollo,
                                        mspd.NombreMetaSecundaria,
                                        mspd.FechaFinMetaSecundaria,
                                        mspd.ValorMetaSecundaria,
                                        mspd.AvanceResponsableMetaSecundaria,
                                        p.EmailResponsableProyecto,
                                        mspd.EmailResponsableMetaSecundaria,
                                        DATEDIFF(m.VigenciaMeta, NOW()) AS diasMetaPrincipal,
                                        DATEDIFF(
                                                mspd.FechaFinMetaSecundaria,
                                                now()
                                        ) AS diasMetaSecundaria
                                    FROM
                                        MetaIndicadorPlanDesarrollo m
                                    LEFT JOIN IndicadorPlanDesarrollo i ON m.IndicadorPlanDesarrolloId = i.IndicadorPlanDesarrolloId
                                    LEFT JOIN ProyectoPlanDesarrollo p ON p.ProyectoPlanDesarrolloId = i.ProyectoPlanDesarrolloId
                                    LEFT JOIN ProgramaProyectoPlanDesarrollo pp ON pp.ProyectoPlanDesarrolloId = p.ProyectoPlanDesarrolloId
                                    LEFT JOIN ProgramaPlanDesarrollo ppd ON ppd.ProgramaPlanDesarrolloId = pp.ProgramaPlanDesarrolloId
                                    LEFT JOIN PlanDesarrolloProgramaLineaEstrategica pdl ON pdl.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
                                    LEFT JOIN MetaSecundariaPlanDesarrollo mspd ON mspd.MetaIndicadorPlanDesarrolloId = m.MetaIndicadorPlanDesarrolloId
                                    INNER JOIN LineaEstrategica l ON pdl.LineaEstrategicaId = l.LineaEstrategicaId
                                    WHERE
                                            m.VigenciaMeta <= '2021-03-01'
                                    AND mspd.MetaSecundariaPlanDesarrolloId IS NOT NULL
                                    AND mspd.EmailResponsableMetaSecundaria = '".$emailMetaSecundaria."'
                                    AND DATEDIFF(
                                            mspd.FechaFinMetaSecundaria,
                                            now()
                                    ) > 0
                                    AND DATEDIFF(
                                            mspd.FechaFinMetaSecundaria,
                                            now()
                                    ) < 30
                                    OR DATEDIFF(m.VigenciaMeta, NOW()) > 0
                                    AND DATEDIFF(m.VigenciaMeta, NOW()) < 30
                                    AND mspd.ValorMetaSecundaria > mspd.AvanceResponsableMetaSecundaria
                                    AND m.AlcanceMeta > m.AvanceMetaPlanDesarrollo";	

                        if($ResultadoEnvios=&$db->Execute($sqlEnvios)===false){
                            echo 'Error en consulta a base de datos '.$sqlEnvios;
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
                                            <p align="center">Usted presenta atrasos en las siguientes metas, recuerde que esto se calcula con 1 mes de anterioridad</p>
                                                <div align="justify">
                                                    <table align="center">
                                                        <tr>
                                                            <th colspan="7" align="center">
                                                                    Metas retrasadas.
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Linea estrategica</th>												
                                                            <th>Nombre programa</th>												
                                                            <th>Nombre proyecto</th>	
                                                            <th>Nombre Meta</th>
                                                            <th>Avance real</th>
                                                            <th>Avance esperado</th>												
                                                            <th>Vigencia meta</th>												
                                                        </tr>';
                                                        if(!$ResultadoEnvios->EOF){
                                                            while(!$ResultadoEnvios->EOF){
                                                                    $html .=   '<tr><td>'.utf8_decode($ResultadoEnvios->fields['NombreLineaEstrategica']).'</td>
                                                                                    <td>'.utf8_decode($ResultadoEnvios->fields['NombrePrograma']).'</td>
                                                                                    <td>'.utf8_decode($ResultadoEnvios->fields['NombreProyectoPlanDesarrollo']).'</td>
                                                                                    <td>'.utf8_decode($ResultadoEnvios->fields['NombreMetaPlanDesarrollo']).'</td>																	
                                                                                    <td>'.utf8_decode($ResultadoEnvios->fields['AvanceMetaPlanDesarrollo']).'</td>
                                                                                    <td>'.utf8_decode($ResultadoEnvios->fields['AlcanceMeta']).'</td>
                                                                                    <td>'.utf8_decode($ResultadoEnvios->fields['VigenciaMeta']).'</td>
                                                                                </tr>';
                                                                    $ResultadoEnvios->MoveNext();
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
				</html>
                                <br>';
			$Resultado->MoveNext();
                    }
		}	
            }
	return $html;
		
	}

	public function alertaQuincenal(){
		$db = getBD();
		$date=date_create(date('Y-m-d'));
		date_modify($date,"+1 month");
		$dosSemanas = date_format($date,"Y-m-d");
		
		$SQL = "
			SELECT
                            m.NombreMetaPlanDesarrollo,
                            m.AlcanceMeta,
                            m.VigenciaMeta,
                            m.AvanceMetaPlanDesarrollo,
                            l.NombreLineaEstrategica,
                            ppd.NombrePrograma,
                            p.NombreProyectoPlanDesarrollo
			FROM
                            MetaIndicadorPlanDesarrollo m
                        LEFT JOIN IndicadorPlanDesarrollo i ON m.IndicadorPlanDesarrolloId = i.IndicadorPlanDesarrolloId
                        LEFT JOIN ProyectoPlanDesarrollo p ON p.ProyectoPlanDesarrolloId = i.ProyectoPlanDesarrolloId
                        LEFT JOIN ProgramaProyectoPlanDesarrollo pp ON pp.ProyectoPlanDesarrolloId = p.ProyectoPlanDesarrolloId
                        LEFT JOIN ProgramaPlanDesarrollo ppd ON ppd.ProgramaPlanDesarrolloId = pp.ProgramaPlanDesarrolloId
                        LEFT JOIN PlanDesarrolloProgramaLineaEstrategica pdl ON pdl.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
                        INNER JOIN LineaEstrategica l ON pdl.LineaEstrategicaId = l.LineaEstrategicaId
                        WHERE
                            m.VigenciaMeta = '2021-01-01'

                        ORDER BY
                            l.LineaEstrategicaId
                            limit 10";
					
				
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
				<p align="center">Usted presenta atrasos en las siguientes metas, recuerde que esto se calcula con 1 mes de anterioridad</p>
                                    <div align="justify">
					<table align="center">
                                            <tr>
                                                <th colspan="7" align="center">
                                                    Metas retrasadas.
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Linea estrategica</th>												
                                                <th>Nombre programa</th>												
                                                <th>Nombre proyecto</th>	
                                                <th>Nombre Meta</th>
                                                <th>Avance real</th>
                                                <th>Avance esperado</th>												
                                                <th>Vigencia meta</th>												
                                            </tr>';
                                            if(!$Resultado->EOF){
                                                while(!$Resultado->EOF){
                                                    $html .=   '<tr><td>'.utf8_decode($Resultado->fields['NombreLineaEstrategica']).'</td>
                                                                    <td>'.utf8_decode($Resultado->fields['NombrePrograma']).'</td>
                                                                    <td>'.utf8_decode($Resultado->fields['NombreProyectoPlanDesarrollo']).'</td>
                                                                    <td>'.utf8_decode($Resultado->fields['NombreMetaPlanDesarrollo']).'</td>																	
                                                                    <td>'.utf8_decode($Resultado->fields['AvanceMetaPlanDesarrollo']).'</td>
                                                                    <td>'.utf8_decode($Resultado->fields['AlcanceMeta']).'</td>
                                                                    <td>'.utf8_decode($Resultado->fields['VigenciaMeta']).'</td>
                                                                </tr>';
                                                    $Resultado->MoveNext();
                                                }
                                            }
                $html .= '          </table>
                                </div>
                                <p>&nbsp;</p>
                                <hr />        
                                <p style="font-size: 11px;" align="center">Av. Cra 9 No. 131 A - 02 &middot; Edificio Fundadores &middot; L&iacute;nea Gratuita 018000 113033 &middot; PBX (571) 6489000 &middot; Bogot&aacute; D.C. - Colombia.</p>
                            </div>
			</div>
			</page>
                        </body>
		</html>';
										
		//return $html;
		$address = 'riveradiego@unbosque.edu.co';
		$mail = new PHPMailer;
		$mail->setFrom($address, 'Universidad El Bosque');
		$mail->AddReplyTo($address,"Universidad El Bosque");
		$mail->isHTML(true);
		$mail->Subject = "Alerta quincenal.";
		$mail->Body = $html;
		$mail->AddEmbeddedImage('logonegro.png', 'logo');
		$mail->AddAddress($address, 'Universidad El Bosque');
		echo 'Enviando correo... <br />';
		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
			echo 'Correo enviado';
		}
	}
	
	public function alertaNoAprobado ( $metaSecundaria ) {
		$db = getBD();
		$SQL = "SELECT
                            pd.NombrePlanDesarrollo,
                            ln.NombreLineaEstrategica,
                            propd.NombrePrograma,
                            ppd.NombreProyectoPlanDesarrollo,
                            mipd.NombreMetaPlanDesarrollo,
                            mspd.NombreMetaSecundaria,
                            ppd.EmailResponsableProyecto,
                            mspd.EmailResponsableMetaSecundaria,
                            aipd.observaciones
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
                            group by pd.NombrePlanDesarrollo";
						
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
                                                         <h2 align="center">El avance registrado para la siguiente meta anual no fue aprobado:</h2>
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
                        $plan=utf8_decode($Resultado->fields['NombrePlanDesarrollo']);
                }
														
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
                                    </tr>
                                    <tr>
                                        <td colspan="6">Observacion:<td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">'.utf8_decode($Resultado->fields['observaciones']).'<td>
                                    </tr>';
                $Resultado->MoveNext();
                    }
		}
		$html .= '           </table>
                                </div>
                            <p>&nbsp;</p>
                            <hr />        
                            <p style="font-size: 11px;" align="center">Av. Cra 9 No. 131 A - 02 &middot; Edificio Fundadores &middot; L&iacute;nea Gratuita 018000 113033 &middot; PBX (571) 6489000 &middot; Bogot&aacute; D.C. - Colombia.</p>
                            </div>
                        </div>
                        </page>
                        </body>
			</html>';
										
		//return $html;
		$address = 'riveradiego@unbosque.edu.co';
		$mail = new PHPMailer;
		$mail->setFrom($address, 'Universidad El Bosque');
		$mail->AddReplyTo($address,"Universidad El Bosque");
		$mail->isHTML(true);
		$mail->Subject = "El avance registrado no fue aprobado-".$plan."";
		$mail->Body = $html;
		$mail->AddEmbeddedImage('logonegro.png', 'logo');
		$mail->AddAddress( $email,'Universidad El Bosque');
		$mail->AddAddress( $emailProyecto,'Universidad El Bosque');
		//echo 'Enviando correo... <br />';
		if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
			
		}
	}

	public function alertaEvidencia ( $metaSecundaria ) {
		$db = getBD();
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
                            group by pd.NombrePlanDesarrollo";
						
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
                                                    <h2 align="center">Tiene nuevos avances pendientes por evaluar</h2>
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
	
		$address = 'riveradiego@unbosque.edu.co';
		$mail = new PHPMailer;
		$mail->setFrom($address, 'Universidad El Bosque');
		$mail->AddReplyTo($address,"Universidad El Bosque");
		$mail->isHTML(true);
		$mail->Subject = "Plan De Desarrollo Evidencia Registrada.";
		$mail->Body = $html;
		$mail->AddEmbeddedImage('logonegro.png', 'logo');
		$mail->AddAddress( $email,'Universidad El Bosque');
		$mail->AddAddress( $emailProyecto,'Universidad El Bosque');
		if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
			
		}
        }
    }

?>