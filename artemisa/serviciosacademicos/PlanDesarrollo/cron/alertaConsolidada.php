
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
//require_once ('../../funciones/phpmailerv2/PHPMailerAutoload.php');
require_once '../../../sala/lib/PHPMailer/PHPMailerAutoload.php';
    $db = getBD();
    $date=date_create(date('Y-m-d'));
    date_modify($date,"+1 month");
    $dosSemanas = date_format($date,"Y-m-d");

    //$sqlFacultad consulta el codigo de facultad a la cual se le van a vencer las metas
    $sqlFacultad = "
                    SELECT

                            pd.CodigoFacultad
                     FROM
                            MetaIndicadorPlanDesarrollo m
                     INNER JOIN IndicadorPlanDesarrollo i ON m.IndicadorPlanDesarrolloId = i.IndicadorPlanDesarrolloId
                     INNER JOIN ProyectoPlanDesarrollo p ON p.ProyectoPlanDesarrolloId = i.ProyectoPlanDesarrolloId
                     INNER JOIN ProgramaProyectoPlanDesarrollo pp ON pp.ProyectoPlanDesarrolloId = p.ProyectoPlanDesarrolloId
                     INNER JOIN ProgramaPlanDesarrollo ppd ON ppd.ProgramaPlanDesarrolloId = pp.ProgramaPlanDesarrolloId
                     INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdl ON pdl.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
                     INNER JOIN MetaSecundariaPlanDesarrollo mspd ON mspd.MetaIndicadorPlanDesarrolloId = m.MetaIndicadorPlanDesarrolloId
                     INNER JOIN LineaEstrategica l ON pdl.LineaEstrategicaId = l.LineaEstrategicaId
                     INNER JOIN PlanDesarrollo pd on pdl.PlanDesarrolloId = pd.PlanDesarrolloId

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
                    GROUP BY pd.CodigoFacultad";			
		
        if($Resultado=&$db->Execute($sqlFacultad)===false){
                echo 'Error en consulta a base de datos '.$sqlCorreos;
                die;    
        }
		
	$registros=$Resultado->RecordCount();
		
	if( $registros > 0){
								
            if(!$Resultado->EOF){
		while( !$Resultado->EOF ) {
                    $codigoFacultad = $Resultado->fields['CodigoFacultad'];	
							
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
                                        ) AS diasMetaSecundaria,
                                        mspd.FechaFinMetaSecundaria
                                FROM
                                        MetaIndicadorPlanDesarrollo m
                                INNER JOIN IndicadorPlanDesarrollo i ON m.IndicadorPlanDesarrolloId = i.IndicadorPlanDesarrolloId
                                INNER JOIN ProyectoPlanDesarrollo p ON p.ProyectoPlanDesarrolloId = i.ProyectoPlanDesarrolloId
                                INNER JOIN ProgramaProyectoPlanDesarrollo pp ON pp.ProyectoPlanDesarrolloId = p.ProyectoPlanDesarrolloId
                                INNER JOIN ProgramaPlanDesarrollo ppd ON ppd.ProgramaPlanDesarrolloId = pp.ProgramaPlanDesarrolloId
                                INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdl ON pdl.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
                                INNER JOIN MetaSecundariaPlanDesarrollo mspd ON mspd.MetaIndicadorPlanDesarrolloId = m.MetaIndicadorPlanDesarrolloId
                                INNER JOIN LineaEstrategica l ON pdl.LineaEstrategicaId = l.LineaEstrategicaId
                                INNER JOIN PlanDesarrollo pd on pdl.PlanDesarrolloId = pd.PlanDesarrolloId
                                WHERE
                                        m.VigenciaMeta <= '2021-03-01'
                                AND mspd.MetaSecundariaPlanDesarrolloId IS NOT NULL
                                AND pd.CodigoFacultad='".$codigoFacultad."'
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

                                        <h2 align="center">Usted presenta las siguientes metas anuales a vencer sin registro de avances. Recuerde que esto se calcula con 1 mes de anterioridad</h2>

                                            <div align="justify">
                                                <table align="center">

                                                    <tr>
                                                            <th>Linea estrategica</th>												
                                                            <th>Nombre programa</th>												
                                                            <th>Nombre proyecto</th>	
                                                            <th>Nombre Meta</th>
                                                            <th>Avance esperado</th>												
                                                            <th>Vigencia meta</th>
                                                            <th>Avance anual</th>		
                                                            <th>Fecha vencimiento</th>										

                                                    </tr>';
                                                    if(!$ResultadoEnvios->EOF){
                                                            while(!$ResultadoEnvios->EOF){
                                                                $correoMetasecundaria =$ResultadoEnvios->fields['EmailResponsableMetaSecundaria'];
                                                                $correoProyecto = $ResultadoEnvios->fields['EmailResponsableProyecto'];

                                                                $html.='<tr><td>'.utf8_decode($ResultadoEnvios->fields['NombreLineaEstrategica']).'</td>
                                                                            <td>'.utf8_decode($ResultadoEnvios->fields['NombrePrograma']).'</td>
                                                                            <td>'.utf8_decode($ResultadoEnvios->fields['NombreProyectoPlanDesarrollo']).'</td>
                                                                            <td>'.utf8_decode($ResultadoEnvios->fields['NombreMetaPlanDesarrollo']).'</td>																	
                                                                            <td>'.utf8_decode($ResultadoEnvios->fields['AlcanceMeta']).'</td>
                                                                            <td>'.utf8_decode($ResultadoEnvios->fields['VigenciaMeta']).'</td>
                                                                            <td>'.utf8_decode($ResultadoEnvios->fields['NombreMetaSecundaria']).'</td>
                                                                            <td>'.substr(utf8_decode($ResultadoEnvios->fields['FechaFinMetaSecundaria']),0,10).'</td>
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
                            </html><br>';
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
                            $mail->Subject = "Avances pendientes - Sistema de gestión de planes de desarrollo";
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

                $Resultado->MoveNext();

		}
            }	
	}	
		
?>
</body>
</html>