
<?php

session_start();
include("../../class/class.phpmailer.php");
ini_set('display_errors', 'On');
error_reporting(E_ALL);

/*
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Ajuste de formulario y creacion de horarios de Entrevistas para los programas de Postgrados.
 * @since Abril 13, 2018.
*/ 

date_default_timezone_set('America/Bogota');

	function email ($db , $id ){

		$sqlCorreo = "
						SELECT
							E.FechaEntrevista,
							E.HoraInicio,
							EG.emailestudiantegeneral,
							EG.nombresestudiantegeneral,
							EG.apellidosestudiantegeneral,
                            C.codigocarrera,
							C.nombrecarrera,
							SAE.NombreSalonEntrevistas
						FROM
							AsignacionEntrevistas AEN
						INNER JOIN Entrevistas E ON (
							AEN.EntrevistaId = E.EntrevistaId
						)
						INNER JOIN CarreraSalones CS ON (
							E.CarreraSalonId = CS.CarreraSalonId
						)
						INNER JOIN carrera C ON (
							CS.CodigoCarrera = C.codigocarrera
						)
						INNER JOIN SalonEntrevistas SAE ON (
							CS.SalonEntrevistasId = SAE.SalonEntrevistasId
						)
						INNER JOIN estudiantecarrerainscripcion ECI ON (
							AEN.IdEstudianteCarreraInscripcion = ECI.idestudiantecarrerainscripcion
						)
						INNER JOIN estudiantegeneral EG ON (
							ECI.idestudiantegeneral = EG.idestudiantegeneral
						)
						WHERE
							AEN.AsignacionEntrevistaId =".$id;

						return $datos = $db->GetRow( $sqlCorreo );
	}
  
    function dias ( $db , $parametro , $carrera , $jornada ){
    	
    	$parametro = substr($parametro, 0, -1);
		$consultar = 'in ('.$parametro.')';
		$where = "";


		if(isset($_SESSION['usuario'])){

		  } else {

		$where .="and e.FechaEntrevista>=ADDDATE(CURDATE(), INTERVAL 2 DAY) ";
		}
	    /*
		 * Caso 95575
		 * @modified: Luis Dario Gualteros C
		 * <castroluisd@unbosque.edu.co>
		 * Se modifica el rango de horarios de las jornadas para las Entrevistas.
		 * @since Noviembre 7, 2017
		*/     
		if( $jornada == "jm" ) {
			$where .= " and e.HoraInicio between '06:00:00' and '11:59:00'";
		} else if( $jornada == "jt" ) {
			$where .= "and e.HoraInicio between '12:00:00' and '17:59:00'";
		} else {
			$where .= "and e.HoraInicio between '18:00:00' and '23:59:00'";
		}
        //End Caso 95575.
		if($parametro == '') {
			echo "<p style='color:red'>Seleccione día de preferencia para la entrevista</p>";

		}else{
			/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
			*Se modifica  sql en la parte de  cs.CupoEstudiante >   para que tenga en cuenta  los cupos utilizados dependiento el id de la entrevista
			*
							SELECT
								count(*)
							FROM
								AsignacionEntrevistas asie
							INNER JOIN Entrevistas nt ON (
								nt.EntrevistaId = asie.EntrevistaId
							)
							WHERE 
								nt.FechaEntrevista = e.FechaEntrevista and nt.HoraInicio = e.HoraInicio  and asie.EstadoAsignacionEntrevista=400
			
			*SInce November 3 , 2017	
			*/	
            /*
                * Caso 95575
                * @modified: Luis Dario Gualteros C
                * <castroluisd@unbosque.edu.co>
                * Se modifica la consulta para que solo muestre los horarios en estado '100' activos AND e.EstadoEntrevista = '100'.
                * @since Noviembre 10, 2017
            */ 
        	$sqlDias = "SELECT
							(
								ELT(
									WEEKDAY(e.FechaEntrevista) + 1,
									'Lunes',
									'Martes',
									'Miercoles',
									'Jueves',
									'Viernes',
									'Sabado',
									'Domingo'
								)
							) AS DIA_SEMANA,e.FechaEntrevista,e.HoraInicio,cs.CupoEstudiante,e.EntrevistaId
						FROM
							Entrevistas e
						INNER JOIN CarreraSalones cs ON (
							cs.CarreraSalonId = e.CarreraSalonId
						)

						WHERE
							cs.CodigoCarrera = ".$carrera."
						AND cs.CupoEstudiante > (
								SELECT
								count(*)
							FROM
								AsignacionEntrevistas asie
							WHERE
							asie.EstadoAsignacionEntrevista=400 and asie.EntrevistaId=e.EntrevistaId
						)and WEEKDAY(e.FechaEntrevista)+1 ".$consultar." AND e.EstadoEntrevista = '100' AND cs.CodigoCarrera=".$carrera." ".$where."   order by  e.FechaEntrevista , e.HoraInicio";
            //End Caso 95575.
			$dias = $db->GetAll( $sqlDias );
			
			$contador = 0;
			$conteoDias = sizeof( $dias );
			$jornadaManana=strtotime('12:00:00');
			$horario="";
			$htmlDias="";

			if ( $conteoDias == 0 ) {
				$htmlDias.="";
			} else {

					$htmlDias=" <div class='form-group'>
		                <label class='control-label col-md-4' >Seleccione Fecha: </label><div style='text-align:left;background-color:white' class='col-md-6 col-xs-12 col-md-offset-3 col-md-push-2 validacion'><div style='width:100%;height: 80px;overflow:auto'>";
					foreach( $dias as $diasDisponibles ) {
						
						$dia = $diasDisponibles['DIA_SEMANA'];
						$fecha = $diasDisponibles['FechaEntrevista'];
						$horaIncio = $diasDisponibles['HoraInicio'];
						$entrevistaId = $diasDisponibles['EntrevistaId'];

						$tipoJornada = strtotime( $horaIncio );
						
						if( $jornadaManana >= $tipoJornada){
							$horario = ' AM';

						} else {
							$horario = ' PM';
						}	

						/*
						*Este bloque de variables  se creo con el fin de mostrar la fechas actualuas añandiendoles 20 minutos demas y no mostrar las que ya se vencieron
						*/
						$fechaActual = date( 'Y-m-d' );		
						$horaActual =  date( 'H:i:s' );
						$anadirMinutos = 20;
						$segundosHoraActual = strtotime( $horaActual );
						$segundosAnadidos =  $anadirMinutos * 60;
						$nuevaHora = strtotime(date("H:i:s",$segundosHoraActual+$segundosAnadidos));
						$horaEntrevista = strtotime( $horaIncio );
						


						if( $fechaActual == $fecha and $horaEntrevista<= $nuevaHora  ){
							$htmlDias.="";
						}else if( $fechaActual == $fecha and $horaEntrevista>= $nuevaHora  ){
							
							$htmlDias.="
								<div class='radio-inline'>
								  <label><input type='radio' name='optradio[]' class='entrevista' id='entrevistaId_$entrevistaId' value='$entrevistaId'>".$dia.' '.$fecha.' Hora Inicio '.$horaIncio.' '.$horario."</label>
								</div>";

						} else if ( $fecha > $fechaActual ){
							$htmlDias.="				
								<div class='radio-inline'>
								  <label><input type='radio' name='optradio[]' class='entrevista' id='entrevistaId_$entrevistaId' value='$entrevistaId'>".$dia.' '.$fecha.' Hora Inicio '.$horaIncio.' '.$horario."</label>
								</div>";

						} 

						//fin bloque
												
						$contador ++;

							if( $contador == 1 ){
							//	$htmlDias.="<br>";
								$contador = 0;
							}
					} 
					  $htmlDias.='</div></div>';
			     }  
			     
			 	   echo  $htmlDias; 
		 	}
    }
    /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
     *Se crea funcion contarRegistro para identificar si el registro ya exsite
     *@Since October 23,2018
     *      */
    function contarRegistro( $db , $idEstudianteCarreraInscripcion ){
        $sqlConsutlar=" SELECT
                                count( * ) AS numeroRegistro 
                        FROM
                                AsignacionEntrevistas 
                        WHERE
                                EstadoAsignacionEntrevista = 400 
                        AND IdEstudianteCarreraInscripcion = ".$idEstudianteCarreraInscripcion  ;
        $resSqlConsutlar = $db->GetRow($sqlConsutlar);
        return $resSqlConsutlar["numeroRegistro"];
        
    }
    function guardar ( $db ,  $entrevistaId , $idEstudianteCarreraInscripcion , $UsuairoCreacion ){

	$sqlGuardar= "
		INSERT INTO AsignacionEntrevistas (
					EntrevistaId,
					IdEstudianteCarreraInscripcion,
					UsuarioCreacion,
					FechaCreacion,
					EstadoAsignacionEntrevista
				)
		VALUES
			(
				".$entrevistaId." , 
				".$idEstudianteCarreraInscripcion." , 
				".$UsuairoCreacion." ,
				 now() ,
				 400

			)";

		 if( $db->Execute( $sqlGuardar ) == false ){
            echo 0;
         }else{
         	
	         	$id = mysql_insert_id();
	        	$datos = email ( $db , $id );				
				$destinatario = $datos['emailestudiantegeneral'];	
				$nombreCompleto = $datos['nombresestudiantegeneral'];
				$apellido = $datos['apellidosestudiantegeneral'];
				$fecha =  $datos['FechaEntrevista'];
             	$codCarrera = $datos['codigocarrera'];
				$carrera = $datos['nombrecarrera'];
				$salon = $datos['NombreSalonEntrevistas'];
				$hora = $datos['HoraInicio'];
				$horaAm = strtotime("12:00:00");
				$horario = strtotime( $hora );
				$jornada = "";
			
				if( $horario <= $horaAm ){
					$jornada = "AM";
				}else {
					$jornada = "PM";
				}
			     
                $SQL_Modalidad = "SELECT c.codigomodalidadacademica FROM carrera c WHERE c.codigocarrera = '$codCarrera' ";
                $ResMod = $db->GetRow($SQL_Modalidad);
                $Modal = $ResMod['codigomodalidadacademica'];    	
             
				$mensaje = "Estimado Aspirante,";
				$mensaje .= "<br>";
				$mensaje .= $nombreCompleto." ".$apellido."<br><br><br>";
				$mensaje .= "<p style='text-align:center'><strong>¡Tu entrevista ha sido agendada!</strong><br>Nos alegra que hayas decidido dar el siguiente paso en tu proceso de admisión.<br> Encuentra a continuación los datos de tu entrevista… <br><br>
					Fecha:<br>".$fecha."<br>Hora:<br>". $hora ." ".$jornada." </p>Recuerda que tu entrevista se realizará de forma virtual, pero eso no significa que no puedas conocer desde antes tu Universidad (<a href='http://360.perspectiva360.com/el-bosque/'>ingresando acá</a>). Te pedimos asistir puntualmente.";
             /*   if ($Modal == 200 || $Modal == 800){ //Mensaje para los aspirantes a los programas de 
                  $mensaje .= "Recuerde que si aún no ha hecho entrega de los documentos, podrá enviarlos al correo atencionalusuario@unbosque.edu.co escaneados en archivo PDF o enviarlos en físico a la misma dirección antes mencionada.<br><br><br>Por último, le recomendamos llegar 15 minutos antes de la hora pactada.<br><br><br><strong>Crecer es hacer realidad tus sueños</strong>";
                }else{
                $mensaje .= "Recuerde que si aún no ha hecho entrega de los documentos, podrá enviarlos en físico a la dirección Avenida carrera 9 #131-02 o entregarlos de manera presencial en la dirección antes mencionada, en el horario de lunes a viernes de 8:00 a.m. a 7:00 p.m. o el sábado de 8:30 a.m. a 12:30 p.m.<br><br><br>Por último, le recomendamos llegar 15 minutos antes de la hora pactada.<br><br><br><strong>Crecer es hacer realidad tus sueños</strong>";
                }*/
				
				$mail = new PHPMailer;
				$mail->From ="sala@unbosque.edu.co";
				$mail->FromName = "Universidad el Bosque";
				$mail->isHTML(true);
				$mail->Subject = "Entrevista Programada";
				$mail->Body = $mensaje;
				$mail->AddEmbeddedImage('logonegro.png', 'logo');
				$mail->AddAddress( $destinatario );
				$mail->CharSet = 'UTF-8';
				
				if( !$mail->Send( ) ) {
						echo "Mailer Error: " . $mail->ErrorInfo;
				}else{
					
				}
               if ($Modal == 200 || $Modal == 800){
                echo 1;       
               }else{
                echo 2;
               }
	        
	    }
   }


    function actualizar ( $db , $entrevistaAsignacionId , $entrevistaId , $UsuairoModificacion , $observacion ){
        
        
    	$sqlActualizar  = "						
				UPDATE AsignacionEntrevistas
				SET 
					 EntrevistaId =".$entrevistaId.",
					 UsuarioUltimaModificacion = ".$UsuairoModificacion.",
					 FechaUltimaModificacion = NOW(),
					 Observacion = '".$observacion."'
				WHERE
					 AsignacionEntrevistaId =".$entrevistaAsignacionId;

		if( $db->Execute( $sqlActualizar ) == false ){
            echo 0;
         } else {

         		$datos = email ( $db , $entrevistaAsignacionId );	
				$destinatario = $datos['emailestudiantegeneral'];	
				$fecha =  $datos['FechaEntrevista'];
				$nombreCompleto = $datos['nombresestudiantegeneral'];
				$apellido = $datos['apellidosestudiantegeneral'];
				$carrera = $datos['nombrecarrera'];
				$salon = $datos['NombreSalonEntrevistas'];
				$hora = $datos['HoraInicio'];
				$horaAm = strtotime("12:00:00");
				$horario = strtotime( $hora );
				$jornada = "";
			
				if( $horario <= $horaAm ){
					$jornada = "AM";
				}else {
					$jornada = "PM";
				}
                
                $SQL_Modalidad = "SELECT c.codigomodalidadacademica FROM carrera c WHERE c.codigocarrera = '$codCarrera' ";
                $ResMod = $db->GetRow($SQL_Modalidad);
                $Modal = $ResMod['codigomodalidadacademica']; 
            
				$mensaje = "Estimado Aspirante,";
				$mensaje .= "<br>";
				$mensaje .= $nombreCompleto." ".$apellido."<br><br><br>";
				$mensaje .= "<p style='text-align:center'><strong>¡Tu entrevista ha sido agendada!</strong><br>Nos alegra que hayas decidido dar el siguiente paso en tu proceso de admisión.<br> Encuentra a continuación los datos de tu entrevista… <br><br>
					Fecha:<br>".$fecha."<br>Hora:<br>". $hora ." ".$jornada." </p>Recuerda que tu entrevista se realizará de forma virtual, pero eso no significa que no puedas conocer desde antes tu Universidad (<a href='http://360.perspectiva360.com/el-bosque/'>ingresando acá</a>). Te pedimos asistir puntualmente.";

				/*"Se ha generado un cambio para su prueba de admisión. Nos permitimos recordarle que el día ".$fecha." a las ". $hora ." ".$jornada." se llevará a cabo la entrevista para el proceso de admisión al programa de ".$carrera.", en la Avenida carrera 9 # 131ª – 02, ".$salon."<br><br><br>";
                
                
				if ($Modal == 200 || $Modal == 800){
                    $mensaje .= "Recuerde que si aún no ha hecho entrega de los documentos, podrá enviarlos al correo atencionalusuario@unbosque.edu.co escaneados en archivo PDF o enviarlos en físico a la misma dirección antes mencionada.<br><br><br>Por último, le recomendamos llegar 15 minutos antes de la hora pactada.<br><br><br><strong>Crecer es hacer realidad tus sueños</strong>";
                }else{
                    $mensaje .= "Recuerde que si aún no ha hecho entrega de los documentos, podrá enviarlos en físico a la dirección Avenida carrera 9 #131-02 o entregarlos de manera presencial en la dirección antes mencionada, en el horario de lunes a viernes de 8:00 a.m. a 7:00 p.m. o el sábado de 8:30 a.m. a 12:30 p.m.<br><br><br>Por último, le recomendamos llegar 15 minutos antes de la hora pactada.<br><br><br><strong>Crecer es hacer realidad tus sueños</strong>";
                }*/

				$hora = $datos['HoraInicio'];

				$mail = new PHPMailer;
				$mail->From ="sala@unbosque.edu.co";
				$mail->FromName = "Universidad el Bosque";
				$mail->isHTML(true);
				$mail->Subject = "Entrevista ReProgramada";
				$mail->Body = $mensaje;
				$mail->AddEmbeddedImage('logonegro.png', 'logo');
				$mail->AddAddress( $destinatario );
				$mail->CharSet = 'UTF-8';
				
				if( !$mail->Send( ) ) {
						echo "Mailer Error: " . $mail->ErrorInfo;
				}else{
					
				}

             echo 1;
         }
    }

    function eliminar ( $db , $entrevistaAsignacionId ,  $UsuairoModificacion , $observacion){
    	$sqlEliminiar = "
				UPDATE AsignacionEntrevistas
				SET 
					EstadoAsignacionEntrevista = 300 ,
					UsuarioUltimaModificacion = ".$UsuairoModificacion.",
					FechaUltimaModificacion = NOW(),
					Observacion = '".$observacion."'

				WHERE
					AsignacionEntrevistaId =".$entrevistaAsignacionId;
		
		if( $db->Execute( $sqlEliminiar ) == false ){
            echo 0;
         } else {

            	$datos = email ( $db , $entrevistaAsignacionId );	
				
				$destinatario = $datos['emailestudiantegeneral'];	
				$fecha =  $datos['FechaEntrevista'];
				$nombreCompleto = $datos['nombresestudiantegeneral'];
				$apellido = $datos['apellidosestudiantegeneral'];
				$carrera = $datos['nombrecarrera'];
				$salon = $datos['NombreSalonEntrevistas'];
				$hora = $datos['HoraInicio'];
				$horaAm = strtotime("12:00:00");
				$horario = strtotime( $hora );
				$jornada = "";
			
				if( $horario <= $horaAm ){
					$jornada = "AM";
				}else {
					$jornada = "PM";
				}

				$mensaje = "Estimado Aspirante,";
				$mensaje .= "<br>";
				$mensaje .= $nombreCompleto." ".$apellido."<br><br><br>";
				$mensaje .= "Se ha generado un cambio para su prueba de admisión. Nos permitimos informarle  que la entrevista programada para el  día ".$fecha." a las ". $hora ." ".$jornada."  para el proceso de admisión al programa de ".$carrera."  fue cancelada<br><br><br><br><br>Si desea programar nuevamente su cita contactese con nosotros";

				/*"Se ha generado un cambio para su prueba de admisión. Nos permitimos informarle  que la entrevista programada para el  día ".$fecha." a las ". $hora ." ".$jornada."  para el proceso de admisión al programa de ".$carrera.", en la Avenida carrera 9 # 131ª – 02, ".$salon." fue cancelada<br><br><br><br><br>Si desea programar nuevamente su cita para entrevista ingrese con su usuario y contraseña";*/
				


				$hora = $datos['HoraInicio'];

				$mail = new PHPMailer;
				$mail->From ="sala@unbosque.edu.co";
				$mail->FromName = "Universidad el Bosque";
				$mail->isHTML(true);
				$mail->Subject = "Entrevista Cancelada";
				$mail->Body = $mensaje;
				$mail->AddEmbeddedImage('logonegro.png', 'logo');
				$mail->AddAddress( $destinatario );
				$mail->CharSet = 'UTF-8';
				
				if( !$mail->Send( ) ) {
						echo "Mailer Error: " . $mail->ErrorInfo;
				}else{
					
				}	

			echo 1;
         }
			        		

    }


    function consutarId ( $db , $idEstudianteCarreraInscripcion ){
    	$sqlContusultar = "			
				SELECT
					e.HoraInicio,e.FechaEntrevista,e.EntrevistaId,aen.AsignacionEntrevistaId
				FROM
					AsignacionEntrevistas aen
					INNER JOIN Entrevistas e on (aen.EntrevistaId = e.EntrevistaId)
				WHERE
					IdEstudianteCarreraInscripcion =".$idEstudianteCarreraInscripcion." and aen.EstadoAsignacionEntrevista = 400 ORDER BY aen.AsignacionEntrevistaId desc limit 1";
		
		return $datos = $db->GetRow( $sqlContusultar );
        		
        }


        
     function emailResponsables ( $db ){

     	$sql = "SELECT
					RC.CorreoResponsable,
					C.codigocarrera
				FROM
					AsignacionEntrevistas A
				INNER JOIN estudiantecarrerainscripcion ECI ON (
					A.IdEstudianteCarreraInscripcion = ECI.idestudiantecarrerainscripcion
				)
				INNER JOIN estudiantegeneral EG ON (
					ECI.idestudiantegeneral = EG.idestudiantegeneral
				)
				INNER JOIN Entrevistas E ON (
					A.EntrevistaId = E.EntrevistaId
				)
				INNER JOIN CarreraSalones CSA ON (
					E.CarreraSalonId = CSA.CarreraSalonId
				)
				INNER JOIN carrera C ON (
					CSA.CodigoCarrera = C.codigocarrera
				)
				INNER JOIN ResponsableEntrevistaCarrera RC ON (
					CSA.ResponsableEntrevistaCarrreraId = RC.ResponsableEntrevistaCarrreraId
				)
				WHERE
					E.FechaEntrevista = ADDDATE(CURDATE(), INTERVAL 1 DAY)
				GROUP BY
					RC.CorreoResponsable,
					C.codigocarrera";

			return $correos = $db->GetAll( $sql );



     }


     function envioCarrera( $db , $codigoCarrera ){

     	$sql="SELECT
				EG.numerodocumento,
				EG.nombresestudiantegeneral,
				EG.apellidosestudiantegeneral,
				E.FechaEntrevista,
				E.HoraInicio,
				C.nombrecarrera
			FROM
				AsignacionEntrevistas A
			INNER JOIN estudiantecarrerainscripcion ECI ON (
				A.IdEstudianteCarreraInscripcion = ECI.idestudiantecarrerainscripcion
			)
			INNER JOIN estudiantegeneral EG ON (
				ECI.idestudiantegeneral = EG.idestudiantegeneral
			)
			INNER JOIN Entrevistas E ON (
				A.EntrevistaId = E.EntrevistaId
			)
			INNER JOIN CarreraSalones CSA ON (
				E.CarreraSalonId = CSA.CarreraSalonId
			)
			INNER JOIN carrera C ON (
				CSA.CodigoCarrera = C.codigocarrera
			)
			WHERE
				E.FechaEntrevista = ADDDATE(CURDATE(), INTERVAL 1 DAY)
			AND C.codigocarrera =".$codigoCarrera;

			return $correos = $db->GetAll( $sql );

     	}
?>
