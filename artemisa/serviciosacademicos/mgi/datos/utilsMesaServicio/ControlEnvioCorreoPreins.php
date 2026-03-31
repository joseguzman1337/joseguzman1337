<?php
/**
 * @author Sergio Martínez 
 * @package ControlEnvioCorreoPreins
 */

/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/



class ControlEnvioCorreoPreins {
	
	/**
	 * @type String
	 * @access private
	 */
	private $Mailer = "smtp";
	
	/**
	 * @type boolean
	 * @access private
	 */
    private $IsSMTP =true;
	
	/**
	 * @type boolena
	 * @access private
	 */
	 
    private $SMTPAuth = false;
	/**
	 * @type String
	 * @access private
	 */
    private $Host = "172.16.3.235";
	/**
	 * @type String
	 * @access private
	 */
    private $From = "atencionalusuario@unbosque.edu.co";
	
	/**
	 * @type String
	 * @access private
	 */
	private	$FromName ="UNIVERSIDAD EL BOSQUE ACTIVACION USUARIO ASPIRANTE";
    
	/**
	 * @type int
	 * @access private
	 */
    private $Timeout = 500;
    
	/**
	 * @type boolean
	 * @access private
	 */
    private $IsHTML =true;
	
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
	 * 
	 */
	/**
	 * Enviar Email Evento Seguridad
	 * @param $array datos
	 * @access public
	 * @return boolean
	 */

	public function enviarCorreoEvento($correo) {
		
		$correo1=$correo;
		$envioCorreo = new OficioUB();
		
		$Subject = utf8_decode( "UNIVERSIDAD EL BOSQUE ACTIVACION USUARIO ASPIRANTE" );
		$AddAddress = array( 0 => array ( "mail" => ''.strtolower($correo1).'',
											"nombre" => utf8_decode( "UNIVERSIDAD EL BOSQUE ACTIVACION USUARIO ASPIRANTE" )
	                               		)
	                        );
		$AddAttachment = "";
		$urlactivacion="https://artemisa.unbosque.edu.co/aspirantes/usuarioaspirante/registrarpasouno.php?";
		$html="<br><br>".
            "Gracias por preferir la UNIVERSIDAD EL BOSQUE, La siguiente url le permite continuar su proceso de inscripción presione".
            "<br><br>".
            "<a href='" . $urlactivacion . "' target='new'>"."aqui"."</a>" .
            " "."o copie el siguiente enlace en su navegador"." <br><br><br>" . $urlactivacion;;
			
		$Body = utf8_decode($html);
		$AltBody = utf8_decode( "UNIVERSIDAD EL BOSQUE ACTIVACION USUARIO ASPIRANTE" );
		
		
		
		if($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName,
												$this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body, 
        										  $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc=null, $AddBCc=null)){
			
 		echo "<script>
			    alert('Se ha enviado un correo electrónico');
			 </script>";
		}
		else{
 		echo "<script>
			    alert('No se envío');
			  </script>";
		}
	}
	
}


?>
