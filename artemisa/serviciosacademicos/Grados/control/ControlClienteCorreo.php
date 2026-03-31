<?php

/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - DirecciÃ³n de TecnologÃ­a
 * @package entidades 
 */
require_once("../../../kint/Kint.class.php");
include '../lib/phpMail/OficioUB.php';

function pasarMayusculas($cadena) {
    $cadena = strtoupper($cadena);
    $cadena = str_replace("Ã¡", "Ã�", $cadena);
    $cadena = str_replace("Ã©", "Ã‰", $cadena);
    $cadena = str_replace("Ã­", "Ã�", $cadena);
    $cadena = str_replace("Ã³", "Ã“", $cadena);
    $cadena = str_replace("Ãº", "Ãš", $cadena);
    return ($cadena);
}

class ControlClienteCorreo {

    /**
     * @type String
     * @access private
     */
    private $path = "";

    /**
     * @type String
     * @access private
     */
    private $id_Docente;

    /**
     * @type String
     * @access private
     */
    private $rtf;

    /**
     * @type String
     * @access private
     */
    private $persistencia;

    /**
     * @type String
     * @access private
     */
    private $Mailer = "smtp";

    /**
     * @type boolean
     * @access private
     */
    private $IsSMTP = true;

    /**
     * @type String
     * @access private
     */
    private $Host = "localhost";

    /**
     * @type boolena
     * @access private
     */
    private $SMTPAuth = false;

    /**
     * @type String
     * @access private
     */
    private $From = "campusxxi@unbosque.edu.co";

    /**
     * @type String
     * @access private
     */
    private $FromName = "SISTEMA DE GRADOS";

    /**
     * @type int
     * @access private
     */
    private $Timeout = 500;

    /**
     * @type boolean
     * @access private
     */
    private $IsHTML = true;

    /**
     * @type int
     * @access private
     */
    private $SMTPDebug = 1;

    /**
     * @type String
     * @access private
     */
    private $AddReplyTo = "";

    /**
     * Constructor
     * @param Singleton $persistencia
     */
    public function ControlClienteCorreo($persistencia) {
        $this->persistencia = $persistencia;
        //$this->rtf = new OficioUB();
    }

    /**
     * Enviar NotificaciÃ³n a Estudiantes Candidatos a Grado
     * @access publi
     */
    public function enviarNotificacionEstudiante($emailEstudiante, $nombreEstudiante, $nombreFacultad, $fechaGrado, $fechaMaxima) {

        $envioCorreo = new OficioUB();

        $Subject = utf8_decode("NOTIFICACIÃ“N SISTEMA DE GRADOS");

        $AddAddress = array(0 => array("mail" => '' . $emailEstudiante . '',
                "nombre" => utf8_decode("Sistema de Grados de Estudiantes")
            )
        );

        $AddAttachment = "";

        $AddBCc = null;
        // $AddAttachment = array( 0 => $this->path . $radicacion->toNombreArchivo( ) . ".PDF" );

        $Body = ' 
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Documento sin tÃ­tulo</title>
				</head>
				<body>
				<div style="font-family: Calibri; width:720px;">
					<div>	
				        <table width="100%" border="0" style="background: #3C4729; color:white; font-weight: bold;">
				        	
				               <tr>
				                        <td><img src="https://artemisa.unbosque.edu.co/serviciosacademicos/Grados/css/images/logotipo_ueb.png" width="172" height="80" /></td>
				                    </tr>
				               <tr>
				               		<td align="center"><div align="right">SISTEMA DE GRADOS</div></td>
				               </tr>
				        </table>
					</div>
				    <br />
				    <br />
				    <p align="center" style="font-size:20px;"><b>NOTIFICACIÃ“N SISTEMA DE GRADOS</b></p>
				    <br />
				    <div style="margin-left: 20px; margin-right: 20px; font-size: 14px;">
				    <p>Apreciado Estudiante: <br />
				    <span><b>' . pasarMayusculas($nombreEstudiante) . '</b></span>
				    </p>
				    <br />
				    <br />
				    <p align="justify">Ãšsted es candidato a graduarse en <b>' . date("Y-m-d", strtotime($fechaGrado)) . '</b>, recuerde que para obtener el grado debe estar al dÃ­a con todas los requisitos acadÃ©micos y administrativos a mÃ¡s tardar el <b>' . date("Y-m-d", strtotime($fechaMaxima)) . '</b>, por favor ingrese al sistema acadÃ©mico <a href="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm"><b>SALA</b></a> y consulte el estado de sus obligaciones.</p>
				    <p align="justify">CerciÃ³rese que su nombre, apellidos, nÃºmero del documento de identidad y lugar de expediciÃ³n del mismo, registrados en el Sistema sean los correctos, con esta informaciÃ³n se elaborarÃ¡ su diploma y acta de grado. Esto le evitarÃ¡ futuros inconvenientes de orden legal y trÃ¡mites de duplicados por inconsistencias en esta informaciÃ³n, con los costos que ello le representa. Cualquier inquietud sobre el particular, con gusto le serÃ¡ atendida en la respectiva SecretarÃ­a AcadÃ©mica.</p>
				    <br />
				    <br />
				    <p>Cordialmente,</p>
				    <br />
				    <br />
				    <p><b>' . pasarMayusculas($nombreFacultad) . '</b></p>
				    <br />
				    <br />
				    <p>Este mensaje es automÃ¡tico y es generado por el Sistema de Grados de la Universidad el Bosque.</p>
				    <br />
				    </div>
				    <div>    
				        <table width="100%" height="92" border="0" style="background: #3C4729; color:white; font-weight: normal; font-size: 12px;">
				        	<tr>
				            	<td align="center">
				                	<div>Av. Cra 9 No. 131A - 02 Edificio Fundadores LÃ­nea Gratuita 01 8000 113033 PBX (571) 6489000 BogotÃ¡ - D.C. - Colombia </div>
				                </td>
				            </tr>	
				        </table>
				   </div>
				</div>
				</body>
				</html>';

        //echo $Body."<br />";

        $AltBody = utf8_decode("Este es un mensaje autom&aacute;tico,  Sistema de Grados");

        if ($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName,
                        $this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body,
                        $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc = null, $AddBCc)) {
            echo "Se ha enviado un correo electrÃ³nico";
        } else {
            echo "No se envÃ­o";
        }
    }

    /**
     * Enviar NotificaciÃ³n a Programas AcadÃ©micos de Estudiantes candidatos a grado
     * @access public
     */
    public function enviarNotificacionPrograma($codigoFacultad, $codigoCarrera) {

        $envioCorreo = new OficioUB();

        $controlUsuario = new ControlUsuario($this->persistencia);
        $controlEstudiante = new ControlEstudiante($this->persistencia);


        $usuarios = $controlUsuario->consultarUsuariosFacultad($codigoFacultad, $codigoCarrera);
        if (count($usuarios) != 0) {
            foreach ($usuarios as $usuario) {
                if ($usuario->getUser() != "") {
                    /*
                     * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                     * Se agrega validacion para ver si existe en el objeto el campo emailusuariofacultad para enviar correos a el email registrado
                     * si no se construye una cadena de correo con el texto del usuaio
                     * @since  Marzo 14, 2017
                     */
                    $email = $usuario->getEmailusuariofacultad();
                    $emailUsuario = (!empty($email) ) ? $email : ($usuario->getUser() . "@unbosque.edu.co");
                    /* FIN MODIFICACION */
                    //$emailUsuario = array("suarezcarlos@unbosque.edu.co", "martinezsergio@unbosque.edu.co");



                    $nombreCarrera = $usuario->getCarrera()->getNombreCarrera();
                    $nombreFacultad = $usuario->getCarrera()->getFacultad()->getNombreFacultad();
                    //$fechaMaxima = "2015-06-30";

                    $estudiantes = $controlEstudiante->consultarEstudianteNotificarFacultad($codigoFacultad, $codigoCarrera);
                    if (count($estudiantes) != 0) {
                        $Subject = utf8_decode("NOTIFICACIÃ“N SISTEMA DE GRADOS");
                        $AddAddress = array(0 => array("mail" => '' . $emailUsuario . '',
                                "nombre" => utf8_decode("Sistema de Grados de Estudiantes")
                            )
                        );
                        $AddAttachment = "";

                        $AddBCc = null;
                        // $AddAttachment = array( 0 => $this->path . $radicacion->toNombreArchivo( ) . ".PDF" );

                        $Body = ' 
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>NotificaciÃ³n de Estudiante</title>
						</head>
						<body>
						<div style="font-family: Calibri; width:720px;">
							<div>	
						        <table width="100%" border="0" style="background: #3C4729; color:white; font-weight: bold;">
						        	
						               <tr>
						                        <td><img src="https://artemisa.unbosque.edu.co/serviciosacademicos/Grados/css/images/logotipo_ueb.png" width="172" height="80" /></td>
						                    </tr>
						               <tr>
						               		<td align="center"><div align="right">SISTEMA DE GRADOS</div></td>
						               </tr>
						        </table>
							</div>
						    <br />
						    <br />
						    <p align="center" style="font-size:20px;"><b>NOTIFICACIÃ“N SISTEMA DE GRADOS</b></p>
						    <br />
						    <div style="margin-left: 20px; margin-right: 20px; font-size: 14px;">
						    <p>Programa AcadÃ©mico: <br />
						    <span><b>' . pasarMayusculas($nombreCarrera) . '</b></span>
						    </p>
						    <br />
						    <br />
						    <p align="justify">Los siguientes estudiantes son candidatos a graduarse en la prÃ³xima ceremonia que se llevarÃ¡ a cabo el dÃ­a <b>' . date("Y-m-d", strtotime($estudiantes[0]->getFechaGrado()->getFechaGraduacion())) . '</b>. Por favor recuerde que para optar al tÃ­tulo los estudiantes deben cumplir con la totalidad ( 100% ) de sus obligaciones acadÃ©micas y administrativas para lo cuÃ¡l tiene como plazo mÃ¡ximo hasta el <b>' . date("Y-m-d", strtotime($estudiantes[0]->getFechaGrado()->getFechaMaxima())) . '</b>.</p>
						    <br />
						    <br />
						    <p><b>' . pasarMayusculas($nombreCarrera) . '</b>:<br /><br />
						    <table border="1" width="100%">
							<thead>
								<tr>
									<th>No.</th>
									<th>Documento</th>
									<th>Expedido</th>
									<th>Nombre</th>
								</tr>
							</thead>
							<tbody>';
                        $i = 1;
                        foreach ($estudiantes as $estudiante) {
                            $Body .= '<tr>
							  			<td>' . $i++ . '</td>
							  			<td>' . $estudiante->getNumeroDocumento() . '</td>
							  			<td>' . pasarMayusculas($estudiante->getExpedicion()) . '</td>
							  			<td>' . pasarMayusculas($estudiante->getNombreEstudiante()) . '</td>
							  			</tr>';
                        }
                        $Body .= '</tbody>
							</table>
							</p>
						    <br />
						    <br />
						    <br />
						    <br />
						    <p>Este mensaje es automÃ¡tico y es generado por el Sistema de Grados de la Universidad el Bosque.</p>
						    <br />
						    </div>
						    <div>    
						        <table width="100%" height="92" border="0" style="background: #3C4729; color:white; font-weight: normal; font-size: 12px;">
						        	<tr>
						            	<td align="center">
						                	<div>Av. Cra 9 No. 131A - 02 Edificio Fundadores LÃ­nea Gratuita 01 8000 113033 PBX (571) 6489000 BogotÃ¡ - D.C. - Colombia </div>
						                </td>
						            </tr>	
						        </table>
						   </div>
						</div>
						</body>
						</html>';
                        //echo $Body."<br />";

                        $AltBody = utf8_decode("Este es un mensaje autom&aacute;tico,  Sistema de Grados");

                        if ($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName,
                                        $this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body,
                                        $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc = null, $AddBCc)) {
                            echo "Se ha enviado un correo electrÃ³nico";
                        } else {
                            echo "No se envÃ­o";
                        }
                    }
                }
            }
        }
    }

    /**
     * Enviar NotificaciÃ³n a Estudiantes que les falta InglÃ©s
     * @access public
     */
    public function enviarNotificacionEstudianteSemestre($emailEstudiante, $nombreEstudiante, $nombreFacultad) {

        $envioCorreo = new OficioUB();

        $Subject = utf8_decode("NOTIFICACIÃ“N SISTEMA DE GRADOS");

        $AddAddress = array(0 => array("mail" => '' . $emailEstudiante . '',
                "nombre" => utf8_decode("Sistema de Grados de Estudiantes")
            )
        );

        $AddAttachment = "";

        $AddBCc = null;
        // $AddAttachment = array( 0 => $this->path . $radicacion->toNombreArchivo( ) . ".PDF" );

        $Body = ' 
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Documento sin tÃ­tulo</title>
				</head>
				<body>
				<div style="font-family: Calibri; width:720px;">
					<div>	
				        <table width="100%" border="0" style="background: #3C4729; color:white; font-weight: bold;">
				        	
				               <tr>
				                        <td><img src="https://artemisa.unbosque.edu.co/serviciosacademicos/Grados/css/images/logotipo_ueb.png" width="172" height="80" /></td>
				                    </tr>
				               <tr>
				               		<td align="center"><div align="right">SISTEMA DE GRADOS</div></td>
				               </tr>
				        </table>
					</div>
				    <br />
				    <br />
				    <p align="center" style="font-size:20px;"><b>NOTIFICACIÃ“N SISTEMA DE GRADOS</b></p>
				    <br />
				    <div style="margin-left: 20px; margin-right: 20px; font-size: 14px;">
				    <p>Apreciado Estudiante: <br />
				    <span><b>' . pasarMayusculas($nombreEstudiante) . '</b></span>
				    </p>
				    <br />
				    <br />
				    <p align="justify">La Universidad el Bosque le informa que para obtener su tÃ­tulo de Grado debe haber cumplido los niveles de InglÃ©s establecidos como requisito en su facultad o programa acadÃ©mico.</p>
				    <br />
				    <br />
				    <p>Cordialmente,</p>
				    <br />
				    <br />
				    <p><b>' . pasarMayusculas($nombreFacultad) . '</b></p>
				    <br />
				    <br />
				    <p>Este mensaje es automÃ¡tico y es generado por el Sistema de Grados de la Universidad el Bosque.</p>
				    <br />
				    </div>
				    <div>    
				        <table width="100%" height="92" border="0" style="background: #3C4729; color:white; font-weight: normal; font-size: 12px;">
				        	<tr>
				            	<td align="center">
				                	<div>Av. Cra 9 No. 131A - 02 Edificio Fundadores LÃ­nea Gratuita 01 8000 113033 PBX (571) 6489000 BogotÃ¡ - D.C. - Colombia </div>
				                </td>
				            </tr>	
				        </table>
				   </div>
				</div>
				</body>
				</html>';


        //echo $Body."<br />";
        $AltBody = utf8_decode("Este es un mensaje autom&aacute;tico,  Sistema de Grados");

        if ($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName,
                        $this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body,
                        $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc = null, $AddBCc)) {
            echo "Se ha enviado un correo electrÃ³nico";
        } else {
            echo "No se envÃ­o";
        }
    }

    /**
     * Enviar Comunicado a VicerrectorÃ­a y Secretaria
     * @access public
     */
    public function enviarComunicado($txtFechaGrado, $txtTipoGrado) {

        $envioCorreo = new OficioUB();

        $controlUsuario = new ControlUsuario($this->persistencia);
        $controlFacultad = new ControlFacultad($this->persistencia);
        $controlFechaGrado = new ControlFechaGrado($this->persistencia);
        $controlActaAcuerdo = new ControlActaAcuerdo($this->persistencia);
        $controlIncentivoAcademico = new ControlIncentivoAcademico($this->persistencia);


        if ($txtTipoGrado == 1) {
            $tipoGrado = "CEREMONIA";
        } else {
            $tipoGrado = "SECRETARIA";
        }


        $fechaGrado = $controlFechaGrado->buscarFechaGrado($txtFechaGrado);

        $txtCodigoCarrera = $fechaGrado->getCarrera()->getCodigoCarrera();

        $facultad = $controlFacultad->buscarFacultad($txtCodigoCarrera);

        $txtCodigoFacultad = $facultad->getCodigoFacultad();

        $mesActual = mesActual();
        $diaActual = date("j", fechaActual());
        $anioActual = "20" . date("y", fechaActual());

        $Subject = utf8_decode("NOTIFICACIÓN SISTEMA DE GRADOS - ESTUDIANTES CANDIDATOS A GRADO");

        /*
         * Modidied Diego Rivera <riveradiego@unbosque.edu.co>
         * Se añaden variables:
          $emailUsuarioActual recibe  data : txtUsuarioActual ,
          $usuariosFacultadenvia	 recibe  datos del control	 $controlUsuario->consultarEmailusuariofacultades
          $usuarioLogin almacena el email del usuario actual respecto a la tabla usuario facultad
         * Since February 20 ,2018
         */

        $emailUsuarioActual = $_REQUEST['txtUsuarioActual'];
        $usuariosFacultadenvia = $controlUsuario->consultarEmailusuariofacultades($emailUsuarioActual, $txtCodigoCarrera);
        $usuarioLogin = $usuariosFacultadenvia->getEmailusuariofacultad();


        $emailUsuario = "martinezconsuelo@unbosque.edu.co";
        //$emailUsuario = "diego887@hotmail.com";
        /* Modidied Diego Rivera <riveradiego@unbosque.edu.co>
         * Se añade posicion 1 en array  (añade destinatario usuarioa actual)
         * Since February 20 ,2018
         */

        $AddAddress = array(0 => array("mail" => '' . $emailUsuario . '',
                "nombre" => utf8_decode("Sistema de Grados de Estudiantes")
            ),
            1 => array("mail" => '' . $usuarioLogin . '',
                "nombre" => utf8_decode("Sistema de Grados de Estudiantes")
            )
        );


        $usuarios = $controlUsuario->consultarUsuariosFacultad($txtCodigoFacultad, $txtCodigoCarrera);
        $notificacion = array();
        if (count($usuarios) != 0) {
            foreach ($usuarios as $usuario) {
                if ($usuario->getUser() != "") {
                    /*
                     * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                     * Se agrega validacion para ver si existe en el objeto el campo emailusuariofacultad para enviar correos a el email registrado
                     * si no se construye una cadena de correo con el texto del usuaio
                     * @since  Marzo 14, 2017
                     */
                    $email = $usuario->getEmailusuariofacultad();
                    $usuariosFacultad = (!empty($email) ) ? $email : ($usuario->getUser() . "@unbosque.edu.co");
                    /* FIN MODIFICACION */
                    $notificacion[count($notificacion)] = $usuariosFacultad;
                }
            }
        }

        array_push($notificacion, "auditoria@unbosque.edu.co");
        //array_push( $notificacion, "diferica@hotmail.com" );
        $AddBCc = $notificacion;
        //echo "<pre>";print_r($AddBCc);


        $this->path = "../documentos/actas/" . $txtFechaGrado . "/*.pdf";
        $archivos = glob($this->path);

        $AddAttachment = $archivos;

        $actaAcuerdos = $controlActaAcuerdo->consultarActaAcuerdos($txtFechaGrado);


        $Body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Documento sin tÃ­tulo</title>
		<style type="text/css">
		body{
			font-family: Arial Black, Gadget, sans-serif;
			font-size: 12pt;
			margin-left: 1cm;
		    margin-top: 1cm;
		    margin-right: 1cm;
		    margin-bottom: 1cm; 
		}
		@page { margin: 120px 50px; }
		#header { position: fixed; left: 0px; top: -110px; right: 0px; text-align: center; }
		#footer { position: fixed; left: 0px; bottom: -120px; right: 0px; height: 90px; }
		#footer .page:after { content: counter(page, upper-roman); }
		</style>
		</head>
		<body>';
        foreach ($actaAcuerdos as $actaAcuerdo) {


            $fecha = $actaAcuerdo->getFechaActa();
            $txtCodigoCarrera = $actaAcuerdo->getFechaGrado()->getCarrera()->getCodigoCarrera();
            $usuarioDecano = $controlUsuario->buscarUsuarioDecano($txtCodigoCarrera);

            //echo $fecha;
            $mes = mes($fecha);
            $dia = date("j", fecha($fecha));
            $anio = "20" . date("y", fecha($fecha));

            if (strlen($dia) == 1) {
                $dia = "0" . $dia;
            }

            $Body .= '
		<div align="justify">
			<div id="header">
			    <p ><img src="https://artemisa.unbosque.edu.co/serviciosacademicos/Grados/css/images/encabezadoBosque.jpg" width="700px"/></p>
			</div>
			
		  <div id="content" align="justify" style="width: 700px;">
		    <p align="right">Bogotá¡ ' . $diaActual . ' de ' . $mesActual . ' de ' . $anioActual . '</p>
		    <p align="justify">Ingeniera<br /><strong>MARÍA DEL CONSUELO MARTÍNEZ RINCÓN</strong><br />Coordinadora Registro y Control Académico<br /><strong>UNIVERSIDAD EL BOSQUE</strong><br />
			Bogotá</p>
			    <p align="justify" style="font-size: 11pt;"><strong>ASUNTO: POSTULACIÓN ESTUDIANTES - GRADO</strong></p>
			<p align="justify">El Consejo de Facultad, en su sesiónn del día ' . $dia . ' de ' . $mes . ' de ' . $anio . ', Acta No. ' . $actaAcuerdo->getNumeroActa() . ', emitió concepto favorable para trámite de otorgamiento de título a los estudiantes que se relacionan a continuación:</p>
			    <p align="center"><strong>POSTULADOS A GRADO EN ' . $tipoGrado . '</strong></p>
			    <p align="center">' . $actaAcuerdo->getFechaGrado()->getCarrera()->getNombreCarrera() . '</p>
		 <table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size: 10pt;"  >
				<thead>
					<tr >
						<th>No</th>
						<th>Estudiante</th>
						<th>Documento de IdentificaciÃ³n</th>
						<th>Expedido</th>
						</tr>
				</thead>
			<tbody>';
            $txtIdActaAcuerdo = $actaAcuerdo->getIdActaAcuerdo();
            $detalleActaAcuerdos = $controlActaAcuerdo->consultarActaPDF($txtFechaGrado, $txtIdActaAcuerdo);
            $i = 1;
            $cantidadIncentivos = 0;
            foreach ($detalleActaAcuerdos as $detalleActaAcuerdo) {

                $txtCodigoEstudiante = $detalleActaAcuerdo->getEstudiante()->getCodigoEstudiante();

                $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($txtCodigoEstudiante, $txtCodigoCarrera);

                foreach ($incentivos as $verIncentivos) {
                    $tipoIncentivo = $verIncentivos->getNombreIncentivo();

                    if ($tipoIncentivo != "") {
                        $cantidadIncentivos = $cantidadIncentivos + 1;
                    }
                }



                if ($detalleActaAcuerdo->getEstadoEnvioSecretaria() == null) {
                    $controlActaAcuerdo->actualizarEnvioSecretaria($txtIdActaAcuerdo, $txtCodigoEstudiante);
                }
                $Body .= '	 
		 <tr>
		 	<td>' . $i++ . '</td>
		 	<td>' . $detalleActaAcuerdo->getEstudiante()->getNombreEstudiante() . '</td>
		 	<td>' . $detalleActaAcuerdo->getEstudiante()->getNumeroDocumento() . '</td>
		 	<td>' . $detalleActaAcuerdo->getEstudiante()->getExpedicion() . '</td>
		 </tr>';
            }
            $Body .= '</tbody> 
		    </table>';
            if ($cantidadIncentivos > 0) {

                $Body .= '<br />
			     <p align="center">ESTUDIANTES CANDIDATOS A GRADO CON INCENTIVOS</p>
			    <table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size: 10pt;"  >
					<thead>
						<tr >
							<th>No</th>
							<th>Estudiante</th>
							<th>Documento de Identificación</th>
							<th>Tipo Incentivo</th>
							<th>Descripción</th>
							</tr>
					</thead>
				    <tbody>';
                $i = 1;

                foreach ($detalleActaAcuerdos as $detalleActaAcuerdo) {

                    $txtCodigoEstudiante = $detalleActaAcuerdo->getEstudiante()->getCodigoEstudiante();
                    $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($txtCodigoEstudiante, $txtCodigoCarrera);

                    foreach ($incentivos as $verIncentivos) {
                        $tipoIncentivo = $verIncentivos->getNombreIncentivo();
                        $observacion = $verIncentivos->getObservacionIncentivo();

                        $Body .= '	 
							 <tr>
							 	<td>' . $i++ . '</td>
							 	<td>' . $detalleActaAcuerdo->getEstudiante()->getNombreEstudiante() . '</td>
							 	<td>' . $detalleActaAcuerdo->getEstudiante()->getNumeroDocumento() . '</td>
								<td>' . $tipoIncentivo . '</td>
								<td>' . $observacion . '</td>
							 	
							 </tr>';
                    }
                }
                $Body .= '</tbody></table>';
            }


            $Body .= '<br />   
		<p align="justify">Muy respetuosamente, le solicito presentarla a Vicerrectoría Académica para grado ceremonial, habiendo cumplido con todos los requisitos académicos, administrativos y financieros del Reglamento Estudiantil.</p>
		<p align="justify">Cordial Saludo,</p>
		<br />
		<p align="justify">' . pasarMayusculas($usuarioDecano->getNombres() . " " . $usuarioDecano->getApellidos()) . '</p>
		<p align="left">&nbsp;</p>
			<div align="right" id="footer">
				<p ><img width="400" height="52" src="https://artemisa.unbosque.edu.co/serviciosacademicos/Grados/css/images/piePagina.jpg" /></p>   
		  	</div>
		</div>
		  
		</div>
		<p style="page-break-before: always;"></p>
		';
        }
        $Body .= '</body>
		</html>';

        $AltBody = utf8_decode("Este es un mensaje autom&aacute;tico,  Sistema de Grados");


        if ($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName,
                        $this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, utf8_decode($Body),
                        $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc = null, $AddBCc)) {
            echo "Se ha enviado un correo electrÃ³nico";
        } else {
            echo "No se envÃ­o";
        }
    }

    /**
     * Enviar NotificaciÃ³n a VicerrectorÃ­a AcadÃ©mica
     * @access public
     */
    public function enviarVicerrectoria($txtFechaGrado, $anioActual, $mesActual, $diaActual, $txtCodigoModalidadAcademica, $txtIdTipoGrado) {


        $envioCorreo = new OficioUB();

        $Subject = utf8_decode("NOTIFICACIÃ“N SISTEMA DE GRADOS");
        $tipoGrado = "";

        if ($txtCodigoModalidadAcademica == 200) {
            $trato = "Doctora";
            $emailUsuario = "viceacademica@unbosque.edu.co";
            $cargo = "Vicerrectora AcadÃ©mica";
            $nombre = "MARIA CLARA RANGEL GALVIS";
        } else {
            $trato = "Doctor";
            $emailUsuario = "dir.postgrados@unbosque.edu.co";
            $cargo = "DirecciÃ³n de postgrados";
            $nombre = "DIRECTOR DE POSTGRADOS";
        }

        if ($txtIdTipoGrado == 1) {
            $tipoGrado = "CEREMONIA";
        } else {
            $tipoGrado = "SECRETARIA";
        }

        $AddAddress = array(0 => array("mail" => '' . $emailUsuario . '',
                "nombre" => utf8_decode("Sistema de Grados de Estudiantes")
            )
        );

        $AddAttachment = "";
        $emailDirectivo = "cdirectivo@unbosque.edu.co";
        $AddBCc = array(0 => '' . $emailDirectivo . ''
        );
        // $AddAttachment = array( 0 => $this->path . $radicacion->toNombreArchivo( ) . ".PDF" );

        $controlActaAcuerdo = new ControlActaAcuerdo($this->persistencia);
        $controlIncentivoAcademico = new ControlIncentivoAcademico($this->persistencia);
        $actaAcuerdos = $controlActaAcuerdo->consultarActaAcuerdos($txtFechaGrado);

        $Body = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Documento sin tÃ­tulo</title>
		<style type="text/css">
		body{
			font-family: Arial Black, Gadget, sans-serif;
			font-size: 12pt;
			margin-left: 1cm;
		    margin-top: 1cm;
		    margin-right: 1cm;
		    margin-bottom: 1cm; 
		}
		@page { margin: 120px 50px; }
		#header { position: fixed; left: 0px; top: -110px; right: 0px; text-align: center; }
		#footer { position: fixed; left: 0px; bottom: -120px; right: 0px; height: 90px; }
		#footer .page:after { content: counter(page, upper-roman); }
		</style>
		</head>
		<body>';
        foreach ($actaAcuerdos as $actaAcuerdo) {

            $fecha = $actaAcuerdo->getFechaActa();
            $txtCodigoCarrera = $actaAcuerdo->getFechaGrado()->getCarrera()->getCodigoCarrera();
            //$usuarioDecano = $controlUsuario->buscarUsuarioDecano( $txtCodigoCarrera );	
            //echo $fecha;
            $mes = mes($fecha);
            $dia = date("j", fecha($fecha));
            $anio = "20" . date("y", fecha($fecha));

            if (strlen($dia) == 1) {
                $dia = "0" . $dia;
            }

            $Body .= '
			<div id="header">
			    <p ><img src="https://artemisa.unbosque.edu.co/serviciosacademicos/Grados/css/images/encabezadoBosque.jpg" width="100%"/></p>
			</div>
		  <div id="content" align="center">
		    <p align="right">BogotÃ¡ ' . $diaActual . ' de ' . $mesActual . ' de ' . $anioActual . '</p>
		    <p align="justify">' . $trato . '<br /><strong>' . $nombre . '</strong><br />' . $cargo . '<br /><strong>UNIVERSIDAD EL BOSQUE</strong><br />
			BogotÃ¡</p>
			    <p align="justify" style="font-size: 11pt;"><strong>ASUNTO: POSTULACIÃ“N CONSEJO DIRECTIVO - GRADO</strong></p>
			<p align="justify">El Departamento de SecretarÃ­a General, por medio de su Ã¡rea de Registro y Control verificÃ³ el cumplimiento de requisitos de Grado de los estudiantes que en el Consejo de Facultad, en su sesiÃ³n del dÃ­a ' . $dia . ' de ' . $mes . ' de ' . $anio . ', Acta No. ' . $actaAcuerdo->getNumeroActa() . ', emitiÃ³ concepto favorable para trÃ¡mite de otorgamiento de tÃ­tulo a los estudiantes que se relacionan a continuaciÃ³n:</p>
			    <p align="center"><strong>POSTULADOS A GRADO EN ' . $tipoGrado . ' - ' . $actaAcuerdo->getFechaGrado()->getCarrera()->getNombreCarrera() . '</strong></p>
		 <table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size: 10pt;"  >
				<thead>
					<tr >
						<th>No</th>
						<th>Estudiante</th>
						<th>Documento de IdentificaciÃ³n</th>
						<th>Expedido</th>
						</tr>
				</thead>
			<tbody>';
            $txtIdActaAcuerdo = $actaAcuerdo->getIdActaAcuerdo();
            $detalleActaAcuerdos = $controlActaAcuerdo->consultarActaPDF($txtFechaGrado, $txtIdActaAcuerdo);
            $i = 1;
            $cantidadIncentivos = 0;
            foreach ($detalleActaAcuerdos as $detalleActaAcuerdo) {

                $txtCodigoEstudiante = $detalleActaAcuerdo->getEstudiante()->getCodigoEstudiante();
                $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($txtCodigoEstudiante, $txtCodigoCarrera);

                foreach ($incentivos as $verIncentivos) {
                    $tipoIncentivo = $verIncentivos->getNombreIncentivo();

                    if ($tipoIncentivo != "") {
                        $cantidadIncentivos = $cantidadIncentivos + 1;
                    }
                }

                $Body .= '	 
		 <tr>
		 	<td>' . $i++ . '</td>
		 	<td>' . $detalleActaAcuerdo->getEstudiante()->getNombreEstudiante() . '</td>
		 	<td>' . $detalleActaAcuerdo->getEstudiante()->getNumeroDocumento() . '</td>
		 	<td>' . $detalleActaAcuerdo->getEstudiante()->getExpedicion() . '</td>
		 </tr>';
            }
            $Body .= '</tbody> 
		    </table>';

            if ($cantidadIncentivos > 0) {

                $Body .= '<br />
                        <p align="center"><strong>ESTUDIANTES CANDIDATOS A GRADO CON INCENTIVOS</strong></p>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size: 10pt;"  >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Estudiante</th>
                                    <th>Documento de Identificaci&oacute;n</th>
                                    <th>Tipo Incentivo</th>
                                    <th>Descripci&oacute;n</th>
                                </tr>
                            </thead>
                            <tbody>';
                $e = 1;
                foreach ($detalleActaAcuerdos as $detalleActaAcuerdo) {

                    $cargaIncentivos = "";
                    $txtCodigoEstudiante = $detalleActaAcuerdo->getEstudiante()->getCodigoEstudiante();
                    $incentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($txtCodigoEstudiante, $txtCodigoCarrera);

                    foreach ($incentivos as $verIncentivos) {
                        $tipoIncentivo = $verIncentivos->getNombreIncentivo();
                        $observacion = $verIncentivos->getObservacionIncentivo();

                        $Body .= '	 
                                                <tr>
                                                    <td>' . $e++ . '</td>
                                                    <td>' . $detalleActaAcuerdo->getEstudiante()->getNombreEstudiante() . '</td>
                                                    <td>' . $detalleActaAcuerdo->getEstudiante()->getNumeroDocumento() . '</td>
                                                    <td>' . $tipoIncentivo . '</td>
                                                    <td>' . $observacion . '</td>							 	
                                                </tr>';
                    }
                }
                $Body .= '</tbody>
                        </table>';
            }

            $Body .= '<br />
		<p align="justify">Muy respetuosamente, le solicito presentarla al prÃ³ximo Consejo Directivo para grado ceremonial, habiendo cumplido con todos los requisitos acadÃ©micos, administrativos y financieros del Reglamento Estudiantil.</p>
		<p align="justify">Cordial Saludo, <br />
			<br />
			MarÃ­a del Consuelo MartÃ­nez RincÃ³n <br />
			Coordinadora Registro y Control AcadÃ©mico
		</p>
		<p align="left">&nbsp;</p>
			<div align="right" id="footer">
				<p ><img width="400" height="52" src="https://artemisa.unbosque.edu.co/serviciosacademicos/Grados/css/images/piePagina.jpg" /></p>   
		  	</div>
		  </div>
		  <p style="page-break-before: always;"></p>
		';
        }
        $Body .= '</body>
		</html>';

        //echo $Body."<br />";
        $AltBody = utf8_decode("Este es un mensaje autom&aacute;tico,  Sistema de Grados");

        if ($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName,
                        $this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body,
                        $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc = null, $AddBCc)) {
            echo "Se ha enviado un correo electrÃ³nico";
        } else {
            echo "No se envÃ­o";
        }
    }

    /**
     * Enviar NotificaciÃ³n a SecretarÃ­a General
     * @access public
     */
    public function enviarSecretarioGeneral($txtFechaGrado, $anioActual, $mesActual, $diaActual) {


        $envioCorreo = new OficioUB();

        $Subject = utf8_decode("NOTIFICACIÃ“N SISTEMA DE GRADOS");

        $emailUsuario = "secgeneral@unbosque.edu.co";

        $AddAddress = array(0 => array("mail" => '' . $emailUsuario . '',
                "nombre" => utf8_decode("Sistema de Grados de Estudiantes")
            )
        );

        $AddAttachment = "";

        $AddBCc = null;
        // $AddAttachment = array( 0 => $this->path . $radicacion->toNombreArchivo( ) . ".PDF" );

        $controlActaAcuerdo = new ControlActaAcuerdo($this->persistencia);
        $controlCarrera = new ControlCarrera($this->persistencia);
        $controlFacultad = new ControlFacultad($this->persistencia);
        $actaAcuerdos = $controlActaAcuerdo->consultarActaAcuerdos($txtFechaGrado);


        $Body = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Documento sin tÃ­tulo</title>
		<style type="text/css">
		body{
			font-family: Arial Black, Gadget, sans-serif;
			font-size: 12pt;
			margin-left: 1cm;
		    margin-top: 1cm;
		    margin-right: 1cm;
		    margin-bottom: 1cm; 
		}
		@page { margin: 100px 50px; }
		#header { position: fixed; left: 0px; top: -100px; right: 0px; height: 90px; text-align: center; }
		#footer { position: fixed; left: 0px; bottom: -100px; right: 0px; height: 90px; }
		#footer .page:after { content: counter(page, upper-roman); }
		</style>
		</head>
		
		<body>';
        foreach ($actaAcuerdos as $actaAcuerdo) {

            if ($actaAcuerdo->getNumeroAcuerdo() != 0) {
                $anioAcuerdo = date("Y", strtotime($actaAcuerdo->getFechaAcuerdo()));
                $diaAcuerdo = date("d", strtotime($actaAcuerdo->getFechaAcuerdo()));

                $mesAcuerdo = mes(date("Y-m-d", strtotime($actaAcuerdo->getFechaAcuerdo())));


                $txtCodigoCarrera = $actaAcuerdo->getFechaGrado()->getCarrera()->getCodigoCarrera();

                $tituloProfesion = $controlCarrera->buscarTituloProfesion($txtCodigoCarrera);

                $facultad = $controlFacultad->buscarFacultad($txtCodigoCarrera);

                $Body .= '
		  	<div id="header">
			    <p><img src="https://artemisa.unbosque.edu.co/serviciosacademicos/Grados/css/images/encabezadoBosque.jpg"" width="100%" height="85" /></p>
			</div>
		  <div align="center">
		    <p><strong>ACUERDO NÂ° ' . $actaAcuerdo->getNumeroAcuerdo() . ' DE ' . $anioAcuerdo . '</strong></p>
		    <br />
		    <p align="justify"> Por el cual se autoriza el otorgamiento de un(os) tÃ­tulo(s) de <strong>' . pasarMayusculas($tituloProfesion->getTituloProfesion()->getNombreTitulo()) . '</strong></p>
		    <p align="justify">El Consejo Directivo, en uso de las atribuciones legales que le confiere el Estatuto de la Universidad El Bosque, en su sesiÃ³n ordinaria del dÃ­a ' . $diaAcuerdo . ' de ' . $mesAcuerdo . ' de ' . $anioAcuerdo . ', acta ' . $actaAcuerdo->getNumeroActa() . ' y</p>
		    <br />
		    <p align="center"><strong>CONSIDERANDO</strong></p>
		    <p align="justify">QuÃ© la ' . pasarMayusculas($facultad->getNombreFacultad()) . ' recomendÃ³ otorgar el tÃ­tulo de <strong>' . pasarMayusculas($tituloProfesion->getTituloProfesion()->getNombreTitulo()) . '</strong> a los siguientes estudiantes de Ãºltimo semestre de la carrera de ' . pasarMayusculas($actaAcuerdo->getFechaGrado()->getCarrera()->getNombreCortoCarrera()) . ' que han cumplido satisfactoriamente con todos los requisitos exigidos en el Plan de Estudios y el Reglamento Estudiantil de la Universidad.</p>
		    <br />
		    <p align="center"><strong>ACUERDA</strong></p>
		    <p align="justify"><strong>Art. 1</strong> Autorizar el otorgamiento del tÃ­tulo de <strong>' . pasarMayusculas($tituloProfesion->getTituloProfesion()->getNombreTitulo()) . '</strong> - ' . $actaAcuerdo->getFechaGrado()->getCarrera()->getNombreCarrera() . ' a los siguientes egresados:</p>
		   <br /> 
		 <table width="100%" border="1" cellpadding="0" cellspacing="0" >
				<thead>
					<tr >
						<th>No</th>
						<th>Estudiante</th>
						<th>Documento de IdentificaciÃ³n</th>
						<th>Expedido</th>
						</tr>
				</thead>
			<tbody>';
                $txtIdActaAcuerdo = $actaAcuerdo->getIdActaAcuerdo();
                $detalleActaAcuerdos = $controlActaAcuerdo->consultarAcuerdoPDF($txtFechaGrado, $txtIdActaAcuerdo);
                $i = 1;
                foreach ($detalleActaAcuerdos as $detalleActaAcuerdo) {
                    $Body .= '	 
		 <tr>
		 	<td>' . $i++ . '</td>
		 	<td>' . $detalleActaAcuerdo->getEstudiante()->getNombreEstudiante() . '</td>
		 	<td>' . $detalleActaAcuerdo->getEstudiante()->getNumeroDocumento() . '</td>
		 	<td>' . $detalleActaAcuerdo->getEstudiante()->getExpedicion() . '</td>
		 </tr>';
                }
                $Body .= '</tbody> 
		    </table>
		    <br />
		    <p align="left">Dado en BogotÃ¡ a los ' . $diaActual . '  dÃ­as del mes de ' . $mesActual . ' de ' . $anioActual . '</p>
		    <br />
		    <p align="left">NOTIFÃ�QUESE, COMUNÃ�QUESE Y CUMPLASE</p>
		    <br />
		    <br />
		    <br />
		    <p align="left">Consejo Directivo</p>
		    <div align="right" id="footer">
				<p><img width="400" height="52" src="https://artemisa.unbosque.edu.co/serviciosacademicos/Grados/css/images/piePagina.jpg" /></p>   
		  	</div>
		  </div>
		  <br />
		<p style="page-break-before: always;"></p>
		';
            }
        }
        $Body .= '</body>
		</html>';


        //echo $Body."<br />";
        $AltBody = utf8_decode("Este es un mensaje autom&aacute;tico,  Sistema de Grados");

        if ($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName,
                        $this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body,
                        $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc = null, $AddBCc)) {
            echo "Se ha enviado un correo electrÃ³nico";
        } else {
            echo "No se envÃ­o";
        }
    }

}

?>