<?php
/**
 * @author Sergio Martínez 
 * @package controlSeguridad
 */


 include_once 'OficioUB.php';
 
class ControlCorreoSeguridad {
	
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
    private $IsSMTP =true;
	
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
    private $From = "oficialseguridad@unbosque.edu.co";
	
	/**
	 * @type String
	 * @access private
	 */
	private	$FromName ="Notificación Cambio Evento Seguridad";
    
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

	public function enviarCorreoEvento($eventos) {
		
		$correo1='semartinezl@unbosque.edu.co';
		$correo2='martinezsergio@unbosque.edu.co';
		
		$envioCorreo = new OficioUB();
		
		$Subject = utf8_decode( "Notificación Evento Seguridad" );
		
		$AddAddress = array( 0 => array ( "mail" => ''.strtolower($correo1).'',
											  "nombre" => utf8_decode( "Notificación Evento Seguridad" )
	                               		    )
	                        	);
								
		$AddBCc = array(  0 => ''.$correo2.''  
	                        );
		
		$AddAttachment = "";
		$html="Se ha presentado un posible fraude o modificación no autorizada en el último día en SALA. A continuación el detalle: <br><br>
			<table border='1'><th>ideventoseguridad</th><th>fechaeventoseguridad</th><th>tipoevento</th>
			<th>tablamodificada</th><th>estudiantemodificado</th><th>registrooriginal</th><th>registromodificado</th>
			<th>usuariomodificador</th>";
			
		foreach($eventos as $dataCorreo){
			$html .= "<tr><td>".$dataCorreo['IdEventoSeguridad']."</td>";
			$html .= "<td>".$dataCorreo['FechaEventoSeguridad']."</td>";
			$html .= "<td>".$dataCorreo['tipoevento']."</td>";
			$html .= "<td>".$dataCorreo['tablamodificada']."</td>";
			$html .= "<td>".$dataCorreo['estudiantemodificado']."</td>";
			$html .= "<td>".$dataCorreo['registrooriginal']."</td>";
			$html .= "<td>".$dataCorreo['registromodificado']."</td>";
			$html .= "<td>".$dataCorreo['usuariomodificador']."</td></tr>";
		}
		$html .= "</table>";
		$Body = utf8_decode($html);
		$AltBody = utf8_decode( "Se ha presentado un posible fraude o modificación no autorizada en el último día en SALA. A continuación el detalle" );
		if($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, utf8_decode($this->FromName), 
												$this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body, 
        										  $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc=null, $AddBCc)){
			
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