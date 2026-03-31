<?php

/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se cambia la imagen por una nota al pie en los metodos enviarObservacion(...) y enviarObservacionUsuario
 * @since Diciembre 3, 2019
 */ 
include 'OficioUB.php';

class ControlClienteCorreo {

    /**
     * @type String
     * @access private
     */
    private $id_Docente;

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
    private $Host = "172.16.3.235";

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
    private $FromName = "CAMPUS XXI";

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
    private $SMTPDebug = 0;

    /**
     * @type String
     * @access private
     */
    private $AddReplyTo = "";

    /**
     * Enviar Email Docente
     * @param $emailDocente, $emailUsuario,  $nombreDocente
     * @access public
     * @return boolean
     */
    public function enviarObservacion($emailDocente, $emailUsuario, $nombreDocente, $id_Docente, $nombreDirectivo) {

        $envioCorreo = new OficioUB();

        $Subject = utf8_decode("OBSERVACIÓN AL PLAN DE TRABAJO");

        $Body = utf8_decode(' 
				<html> 
				<head> 
				</head> 
				<body>
				<div style="font-family: Calibri;"> 
				<table width="100%" border="0" cellspacing="0" style="font-family: Calibri; font-size:14px; text-shadow:#999; font-weight: bold;" >
				<tr>
					<td colspan="2"><img src="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/images/ENCABEZADO.png" width="100%"/></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><h2 style="font-family: Calibri;">UNIVERSIDAD EL BOSQUE</h2></td>
                                <tr>
					<td colspan="2" align="center"><h3 style="font-family: Calibri;">PLANEACI&Oacute;N DE LAS ACTIVIDADES ACAD&Eacute;MICAS</h3></td>
				</tr>    
                                </tr>
                                </table>
                                <table width="100%" border="0">
				<tr>
					<td colspan="5" align="center" ><span style="font-family: Calibri; font-size:14.0pt">OBSERVACIONES AL PLAN DE TRABAJO</span>
                                </td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<span style="font-family: Calibri; font-size:14.0pt">Apreciado Acad&eacute;mico</span>
					</td>
				</tr>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">' . $nombreDocente . '</span></td>
				</tr>
				<br>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Cordial Saludo,</span></td>
				</tr>
				<tr>
					<td>
						<p style="font-family: Calibri; font-size:14.0pt">El usuario ' . $nombreDirectivo . ' de su Facultad y/o Programa ha realizado una observación a su plan de trabajo, por favor ingrese a la herramienta <a href="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/index.php?id_Docente=' . $id_Docente . '">Planeación de las actividades académicas</a>, 
						allí encontrará la observación que usted debe modificar con el fin de que su plan de trabajo quede completamente ajustado a sus actividades.</p>
					</td>
				</tr>
				<br>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Agradecemos su pronta colaboración.</span></td>
				</tr>
				<br>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
				<table width="100%" border="0">
				<tr>
				    <td><p style="font-family: Calibri; font-size:14.0pt"><strong>Nota:</strong> Para ver la observación ingrese a la herramienta, seleccione el periodo actual, y la pestaña planeación de actividades.</p></td>
				 </tr>
				</table>
				</div>
				</body> 
				</html>');

        if ($envioCorreo->envioMail($this->From, $this->FromName, $Subject, $Body, $emailDocente, $nombreDocente, $emailUsuario)) {
            echo "<script>alert('Se ha enviado un correo electrónico');</script>";
        } else {
            echo "<script>alert('No se envío');</script>";
        }
    }

    /**
     * Enviar Email Usuario Docente
     * @param $emailUsuario,  $nombreDocente
     * @access public
     * @return boolean
     */
    public function enviarObservacionUsuario($emailUsuario, $nombreDocente, $id_Docente, $nombreDirectivo) {

        $envioCorreo = new OficioUB();

        $Subject = utf8_decode("OBSERVACIÓN AL PLAN DE TRABAJO");

        $Body = utf8_decode(' 
				<html> 
				<head> 
				</head> 
				<body>
				<div style="font-family: Calibri;"> 
				<table width="100%" border="0" cellspacing="0" style="font-family: Calibri; font-size:14px; text-shadow:#999; font-weight: bold;" >
				<tr>
					<td colspan="2"><img src="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/images/ENCABEZADO.png" width="100%"/></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><h2 style="font-family: Calibri;">UNIVERSIDAD EL BOSQUE</h2></td>
                                <tr>
					<td colspan="2" align="center"><h3 style="font-family: Calibri;">PLANEACI&Oacute;N DE LAS ACTIVIDADES ACAD&Eacute;MICAS</h3></td>
				</tr>    
                                </tr>
                                </table>
                                <table width="100%" border="0">
				<tr>
					<td colspan="5" align="center" ><span style="font-family: Calibri; font-size:14.0pt">OBSERVACIONES AL PLAN DE TRABAJO</span>
                                </td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<span style="font-family: Calibri; font-size:14.0pt">Apreciado Acad&eacute;mico</span>
					</td>
				</tr>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">' . $nombreDocente . '</span></td>
				</tr>
				<br>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Cordial Saludo,</span></td>
				</tr>
				<tr>
					<td>
						<p style="font-family: Calibri; font-size:14.0pt">El usuario ' . $nombreDirectivo . ' de su Facultad y/o Programa ha realizado una observación a su plan de trabajo, por favor ingrese a la herramienta <a href="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/index.php?id_Docente=' . $id_Docente . '">Planeación de las actividades académicas</a>, 
						allí encontrará la observación que usted debe modificar con el fin de que su plan de trabajo quede completamente ajustado a sus actividades.</p>
					</td>
				</tr>
				<br>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Agradecemos su pronta colaboración.</span></td>
				</tr>
				<br>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
				<table width="100%" border="0">
				<tr>
				    <td><p style="font-family: Calibri; font-size:14.0pt"><strong>Nota:</strong> Para ver la observación ingrese a la herramienta, seleccione el periodo actual, y la pestaña planeación de actividades.</p></td>
				 </tr>
				</table>
				</div>
				</body> 
				</html>');


        if ($envioCorreo->envioMail($this->From, $this->FromName, $Subject, $Body, $emailUsuario, $nombreDocente)) {
            echo "<script>alert('Se ha enviado un correo electrónico');</script>";
        } else {
            echo "<script>alert('No se envío');</script>";
        }
    }

    /**
     * Enviar Email Docente de Comentario a Autoevaluacion
     * @param $emailDocente, $emailUsuario,  $nombreDocente
     * @access public
     * @return boolean
     */
    public function enviarAutoevaluacion($emailDocente, $emailUsuario, $nombreDocente, $id_Docente, $codigoPeriodo) {

        $envioCorreo = new OficioUB();

        $Subject = utf8_decode("COMENTARIO DE AUTOEVALUACION AL PLAN DE TRABAJO");

        $AddAddress = array(0 => array("mail" => '' . $emailDocente . '', "nombre" => utf8_decode("Planeación de Actividades")));

        if ($emailUsuario != $emailDocente) {
            $AddBCc = array(0 => '' . $emailUsuario . ''
            );
        }

        $AddAttachment = "";

        $Body = utf8_decode(' 
				<html> 
				<head> 
				</head> 
				<body>
				<div style="font-family: Calibri;"> 
				<table width="100%" border="0" cellspacing="0" style="font-family: Calibri; font-size:14px; text-shadow:#999; font-weight: bold;" >
				<tr>
					<td colspan="2"><img src="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/images/ENCABEZADO.png" width="100%"/></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><h2 style="font-family: Calibri;">UNIVERSIDAD EL BOSQUE</h2></td>
                                <tr>
					<td colspan="2" align="center"><h3 style="font-family: Calibri;">PLANEACI&Oacute;N DE LAS ACTIVIDADES ACAD&Eacute;MICAS</h3></td>
				</tr>    
                                </tr>
                                </table>
                                <table width="100%" border="0">
				<tr>
					<td colspan="5" align="center" ><span style="font-family: Calibri; font-size:14.0pt">OBSERVACIONES AL PLAN DE TRABAJO</span>
                                </td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<span style="font-family: Calibri; font-size:14.0pt">Apreciado Acad&eacute;mico</span>
					</td>
				</tr>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">' . $nombreDocente . '</span></td>
				</tr>
				<br>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Cordial Saludo,</span></td>
				</tr>
				<tr>
					<td>
						<p style="font-family: Calibri; font-size:14.0pt">Las Directivas de su Facultad y/o Programa han realizado un comentario de autoevaluación a su plan de trabajo, por favor ingrese a la herramienta <a href="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/index.php?id_Docente=' . $id_Docente . '&codigoPeriodo=' . $codigoPeriodo . '">Planeación de las actividades académicas</a>, 
						allí encontrará el comentario realizado, esto con el fin de que su plan de trabajo quede completamente ajustado a sus actividades.</p>
					</td>
				</tr>
				<br>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Agradecemos su pronta colaboración.</span></td>
				</tr>
				<br>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
				<table width="100%" border="0">
				<tr>
				    <td><img src="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/images/lema.png" width="40%"/></td>
				 </tr>
				</table>
				</div>
				</body> 
				</html>');

        $AltBody = utf8_decode("Este es un mensaje autom&aacute;tico,  Sistema de Planeaci&oacute;n de Actividades Docente");

        if ($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName, $this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body, $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc = null, $AddBCc)) {
            echo "Se ha enviado un correo electrónico";
        } else {
            echo "No se envío";
        }
    }

    /**
     * Enviar Email Autoevaluacion a Usuario Docente
     * @param $emailUsuario,  $nombreDocente
     * @access public
     * @return boolean
     */
    public function enviarAutoevaluacionUsuario($emailUsuario, $nombreDocente, $id_Docente, $codigoPeriodo) {

        $envioCorreo = new OficioUB();

        $Subject = utf8_decode("COMENTARIO DE AUTOEVALUACION AL PLAN DE TRABAJO");

        $AddAddress = array(0 => array("mail" => '' . $emailUsuario . '', "nombre" => utf8_decode("Planeación de Actividades")));

        $AddAttachment = "";

        $Body = utf8_decode(' 
				<html> 
				<head> 
				</head> 
				<body>
				<div style="font-family: Calibri;"> 
				<table width="100%" border="0" cellspacing="0" style="font-family: Calibri; font-size:14px; text-shadow:#999; font-weight: bold;" >
				<tr>
					<td colspan="2"><img src="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/images/ENCABEZADO.png" width="100%"/></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><h2 style="font-family: Calibri;">UNIVERSIDAD EL BOSQUE</h2></td>
                                <tr>
					<td colspan="2" align="center"><h3 style="font-family: Calibri;">PLANEACI&Oacute;N DE LAS ACTIVIDADES ACAD&Eacute;MICAS</h3></td>
				</tr>    
                                </tr>
                                </table>
                                <table width="100%" border="0">
				<tr>
					<td colspan="5" align="center" ><span style="font-family: Calibri; font-size:14.0pt">OBSERVACIONES AL PLAN DE TRABAJO</span>
                                </td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<span style="font-family: Calibri; font-size:14.0pt">Apreciado Acad&eacute;mico</span>
					</td>
				</tr>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">' . $nombreDocente . '</span></td>
				</tr>
				<br>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Cordial Saludo,</span></td>
				</tr>
				<tr>
					<td>
						<p style="font-family: Calibri; font-size:14.0pt">Las Directivas de su Facultad y/o Programa han realizado un comentario de autoevaluación a su plan de trabajo, por favor ingrese a la herramienta <a href="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/index.php?id_Docente=' . $id_Docente . '&codigoPeriodo=' . $codigoPeriodo . '">Planeación de las actividades académicas</a>, 
						allí encontrará el comentario realizado, esto con el fin de que su plan de trabajo quede completamente ajustado a sus actividades.</p>
					</td>
				</tr>
				<br>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Agradecemos su pronta colaboración.</span></td>
				</tr>
				<br>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
				<table width="100%" border="0">
				<tr>
				    <td><img src="http://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/images/lema.png" width="40%"/></td>
				 </tr>
				</table>
				</div>
				</body> 
				</html>');

        $AltBody = utf8_decode("Este es un mensaje autom&aacute;tico, Sistema de Planeaci&oacute;n de Actividades Docente");

        if ($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName, $this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body, $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc = null, $AddBCc = null)) {
            echo "Se ha enviado un correo electrónico";
        } else {
            echo "No se envío";
        }
    }

}

?>
