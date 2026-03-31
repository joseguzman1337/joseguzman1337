<?php
	include('NotificacionEspaciosFisicos_class.php');
	include("../templates/template.php");
		
	$db = getBD();

	$C_NotificacionEspaciosFisicos = new NotificacionEspaciosFisicos();

    $fecha_Now = date('Y-m-d');
    
    $dia = DiasSemana($fecha_Now);
    
    if($dia==7)
	{
        $FechaFutura_1 = dameFecha($fecha_Now,1);
        $FechaFutura_2 = dameFecha($FechaFutura_1,6);
    }
	else
	{
        $Falta  = 7-$dia+1;    
        $FechaFutura_1 = dameFecha($fecha_Now,$Falta);
        $FechaFutura_2 = dameFecha($FechaFutura_1,6);
    }

	$N = 0;
    
    $DataDocente = $C_NotificacionEspaciosFisicos->Docente($db);
    
    $DataInforma = 0;
    $DataError   = 0;

	for($x=0;$x<count($DataDocente);$x++)
	{
		$CodigoDocente = $DataDocente[$x]['numerodocumento'];
        
		if($DataDocente[$x]['Correo'])
		{
            $Correo = $DataDocente[$x]['Correo'];
        }
		else
		{
            $Correo = $DataDocente[$x]['usuario'].'@unbosque.edu.co';
        }
        
		$Datos = $C_NotificacionEspaciosFisicos->HorarioDocente($db,$CodigoDocente,$FechaFutura_1,$FechaFutura_2);
        
		if($Datos)
		{        
			$SQl='SELECT codigodia,nombredia FROM dia'; 

			if($Dias=&$db->Execute($SQl)===false)
			{
    			echo 'Error al Buscar Dias....<br><br>'.$SQl;
    			die;
			}
			$DiaName = $Dias->GetArray();

			$Mensaje ='<table  border=2>
						<tr>
							<th colspan=7>'.$DataDocente[$x]['NameDocente'].'</th>
           				</tr> 
        				<tr >
            				<td>
                				<table>
                    				<tr>
                        				<th>Lunes</th>
                    				</tr>';
			for($j=0;$j<count($Datos[1]['idGrupo']);$j++)
			{            
				$Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                            	<td style="border: black 1px solid ;">
                                <div style="background-color:'.$Datos[1]['Kolor'][$j].'">
                                '.$Datos[1]['Fecha'][$j].'<br />
                                '.$Datos[1]['hora_1'][$j].' :: '.$Datos[1]['hora_2'][$j].'<br />
                                '.$Datos[1]['idGrupo'][$j].'<br />
                                '.$Datos[1]['Info'][$j].'<br />
                                Lugar :'.$Datos[1]['Nombre'][$j].'<br />
                                </div>
                            </td>    
                        </tr>';
			}//info
                
			$Mensaje=$Mensaje.'</table>
            					</td>
            					<td>
                				<table>
                    				<tr>
                        				<th>Martes</th>
                    				</tr>';
                   
			for($j=0;$j<count($Datos[2]['idGrupo']);$j++)
			{           
				$Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[2]['Kolor'][$j].';">
                                '.$Datos[2]['Fecha'][$j].'<br />
                                '.$Datos[2]['hora_1'][$j].' :: '.$Datos[2]['hora_2'][$j].'<br />
                                '.$Datos[2]['idGrupo'][$j].'<br />
                                '.$Datos[2]['Info'][$j].'<br />
                                Lugar :'.$Datos[2]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';            
			}//info
                    
			$Mensaje=$Mensaje.'</table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>Miercoles</th>
                    </tr>';
			for($j=0;$j<count($Datos[3]['idGrupo']);$j++)
			{
				$Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[3]['Kolor'][$j].';">
                                '.$Datos[3]['Fecha'][$j].'<br />
                                '.$Datos[3]['hora_1'][$j].' :: '.$Datos[3]['hora_2'][$j].'<br />
                                '.$Datos[3]['idGrupo'][$j].'<br />
                                '.$Datos[3]['Info'][$j].'<br />
                                Lugar :'.$Datos[3]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>'; 
			}//info
                    
			$Mensaje=$Mensaje.'</table>
                  </td>
                    <td>
                <table>
                    <tr>
                        <th>Jueves</th>
                    </tr>';
			for($j=0;$j<count($Datos[4]['idGrupo']);$j++)
			{           
				$Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[4]['Kolor'][$j].';">
                                '.$Datos[4]['Fecha'][$j].'<br />
                                '.$Datos[4]['hora_1'][$j].' :: '.$Datos[4]['hora_2'][$j].'<br />
                                '.$Datos[4]['idGrupo'][$j].'<br />
                                '.$Datos[4]['Info'][$j].'<br />
                                Lugar :'.$Datos[4]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';        
			}//info
                    
            $Mensaje=$Mensaje.'</table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>Viernes</th>
                    </tr>';
			for($j=0;$j<count($Datos[5]['idGrupo']);$j++)
			{
                        $Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[5]['Kolor'][$j].';">
                                '.$Datos[5]['Fecha'][$j].'<br />
                                '.$Datos[5]['hora_1'][$j].' :: '.$Datos[5]['hora_2'][$j].'<br />
                                '.$Datos[5]['idGrupo'][$j].'<br />
                                '.$Datos[5]['Info'][$j].'<br />
                                Lugar :'.$Datos[5]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';
            }//info
                 
            $Mensaje=$Mensaje.'</table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>Sabado</th>
                    </tr>';
                    
			for($j=0;$j<count($Datos[6]['idGrupo']);$j++)
			{
				$Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
					 <td style="border: black 1px solid;">
						<div style="background-color:'.$Datos[6]['Kolor'][$j].';">
						'.$Datos[6]['Fecha'][$j].'<br />
						'.$Datos[6]['hora_1'][$j].' :: '.$Datos[6]['hora_2'][$j].'<br />
						'.$Datos[6]['idGrupo'][$j].'<br />
						'.$Datos[6]['Info'][$j].'<br />
						Lugar :'.$Datos[6]['Nombre'][$j].'<br />
						</div>
					</td> 
				</tr>';
			 }//info
                  
             $Mensaje=$Mensaje.'</table>
            	</td>
            	<td>
                <table>
                    <tr>
                        <th>Domingo</th>
                    </tr>';
                    
			for($j=0;$j<count($Datos[7]['idGrupo']);$j++)
			{            
				$Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[7]['Kolor'][$j].';">
                                '.$Datos[7]['Fecha'][$j].'<br />
                                '.$Datos[7]['hora_1'][$j].' :: '.$Datos[7]['hora_2'][$j].'<br />
                                '.$Datos[7]['idGrupo'][$j].'<br />
                                '.$Datos[7]['Info'][$j].'<br />
                                Lugar :'.$Datos[7]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';        
			}//info
                    
            $Mensaje=$Mensaje.'</table>
										</td>
									</tr>
								</table>
								<br><br><br>
								Lo Invitamos A Consultar Su Horario En El Portal De La Universidad www.uelbosque.edu.co <br>
								O en el Siguiente Enlace <a href="https://artemisa.unbosque.edu.co/serviciosacademicos/EspacioFisico/Interfas/EspaciosFisicosAsigandosReporte.php" target="_blank">Click aquí</a>
								<br>Gracias por ayudarnos a construir una mejor Universidad. Por favor enviar sus sugerencias a  mesadeservicio@unbosque.edu.co';
        	$to = $Correo;
                	
        	$tittle = 'Horario Próxima Semana '.$FechaFutura_1.' - '.$FechaFutura_2;
        	$Resultado = $C_NotificacionEspaciosFisicos->EnviarCorreo($to,$tittle,$Mensaje,true);
        	$N = $N+1;
        
			if($Resultado['succes']==true)
			{
				$DataInforma++;
			}else{
				$DataError++;
				$emailerror[]= $to;
			}
        }//if        
	}//for
        
	/*
	* @author Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
	* @copyright Dirección de Tecnología Universidad el Bosque
	* @Funcion de tabla de datos de los docentes a los que no se les envia el correo.
	* since 20 de febero 2017
	*/

	//NOTIFICA A LA DIRRECION DE TECNOLOGIA EL TOTAL DE ENVIO Y TOTAL DE ERRORES
	$to = 'it@unbosque.edu.co';    
	$tittle = 'Docente Informe '.$FechaFutura_1.' - '.$FechaFutura_2;
	$Mensaje = 'Correos Correctos son # '.$DataInforma.'<br><br>Correos Error #'.$DataError;		
	$Resultado = $C_NotificacionEspaciosFisicos->EnviarCorreo($to,$tittle,$Mensaje,true);	

	//Diseño de la tabla para la lista de correos que no se enviaron
	$tabla = "<table border='2'><tr><td>#</td><td>Email<td></tr>";
	$t=0;
	foreach($emailerror as $correos)
	{
		$tabla.= "<tr><td>".$t."</td><td>".$correos."</td></tr>";
		$t++;
	}
	$tabla.= "</table>";
       
	//NOTIFICA AL COORDINADOR DE SISTEMAS DE INFORMACION EL TOTAL DE CORREOS ENVIADOS Y CUALES NO SE ENVIARON
	$to = 'coordinadorsisinfo@unbosque.edu.co';    
	$tittle = 'Docente Informe '.$FechaFutura_1.' - '.$FechaFutura_2;
	$Mensaje = 'Correos Correctos son # '.$DataInforma.'<br><br>Correos Error #'.$DataError.' <br><br>'.$tabla;		
	$Resultado = $C_NotificacionEspaciosFisicos->EnviarCorreo($to,$tittle,$Mensaje,true);
    
	/*
	*END	
	*/
        
	function DiasSemana($Fecha,$Op='')
	{
        if($Op=='Nombre')
		{
            $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');    
        }else{
            $dias = array('','1','2','3','4','5','6','7');    
        }
        
        $fecha = $dias[date('N', strtotime($Fecha))]; 
        return $fecha;
	}//  function DiasSemana

	function dameFecha($fecha,$dia)
	{   
        list($year,$mon,$day) = explode('-',$fecha);
        return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));        
	}//function dameFecha
?>