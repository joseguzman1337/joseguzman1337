<?php
/**
 * @author Carlos ALberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 */


 include_once 'OficioUB.php';
 
class ControlEduOrdenCorreo {
	
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
    private $From = "campusxxi@unbosque.edu.co";
	
	/**
	 * @type String
	 * @access private
	 */
	private	$FromName ="Edu. Continuada Orden Generada Exitosamente";
    
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
	 * Enviar Email Orden de Pago Educación Continuada
	 * @param $correo1,  $correo2
	 * @access public
	 * @return boolean
	 */

	public function enviarCorreoEducaOrdenPago( $correo1, $correo2 ,$nombreEstudiante,$numeroOrden) {
		/*echo $correo1."<br>".$correo2;
		exit();*/
		$envioCorreo = new OficioUB();
		
		$Subject = utf8_decode( "Confirmación Orden de Pago" );
		
		$AddAddress = array( 0 => array ( "mail" => ''.strtolower($correo1).'',
											  "nombre" => utf8_decode( "Confirmación Orden de Pago" )
	                               		    )
	                        	);
								
		$AddBCc = array(  0 => ''.$correo2.''  
	                        );
		
		$AddAttachment = "";
		

       // $AddAttachment = array( 0 => $this->path . $radicacion->toNombreArchivo( ) . ".PDF" );
		
		$Body = utf8_decode( ' 
				<html> 
				<head> 
				</head> 
				<body>
				<div style="font-family: Calibri;"> 
				<table width="100%" border="0" cellspacing="0" style="font-family: Calibri; font-size:14px; text-shadow:#999; font-weight: bold;" >
				<!--<tr>
					<td colspan="2"><img src="https://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/images/ENCABEZADO.png" width="100%"/></td>
				</tr>-->
				<tr>
					<td colspan="2" align="center"><h2 style="font-family: Calibri;">UNIVERSIDAD EL BOSQUE</h2></td>
	            <tr>
					<td colspan="2" align="center"><h3 style="font-family: Calibri;">Educación Continuada</h3></td>
				</tr>    
	            </tr>
	            </table>
	            <table width="100%" border="0">
				<tr>
					<td colspan="5" align="center" ><span style="font-family: Calibri; font-size:14.0pt">Confirmación Orden de Pago</span>
                    </td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<span style="font-family: Calibri; font-size:14.0pt">Apreciado Estudiante</span>
					</td>
				</tr>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">'.$nombreEstudiante.'</span></td>
				</tr>
				<br>
				<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Cordial Saludo,</span></td>
				</tr>
				<tr>
					<td>
						<p style="font-family: Calibri; font-size:14.0pt">Se informa que su orden de pago número '.$numeroOrden.'. fue creada exitosamente</p>
					</td>
				</tr>
				<br>
				<!--<tr>
					<td><span style="font-family: Calibri; font-size:14.0pt">Agradecemos su pronta colaboración.</span></td>
				</tr>-->
				<br>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
				<table width="100%" border="0">
				<!--<tr>
				    <td><img src="https://artemisa.unbosque.edu.co/serviciosacademicos/PlanTrabajoDocenteV2/images/lema.png" width="40%"/></td>
				 </tr>-->
				</table>
				</div>
				</body> 
				</html>');	
				
		$AltBody = utf8_decode( "Este es un mensaje autom&aacute;tico, Sistema de Planeaci&oacute;n de Actividades Docente" );
				
       if($envioCorreo->envioCorreoElectronico($this->Mailer, $this->IsSMTP, $this->Host, $this->SMTPAuth, $this->From, $this->FromName, 
												$this->Timeout, $this->IsHTML, $this->SMTPDebug, $Subject, $Body, 
        										  $AddAddress, $this->AddReplyTo, $AddAttachment, $AltBody, $AddCc=null, $AddBCc)){
			
 		/*echo "<script>
			    alert('Se ha enviado un correo electrónico');
			 </script>";*/
		}
		else{
 		/*echo "<script>
			    alert('No se envío');
			  </script>";*/
		}
	}
	
}


?>