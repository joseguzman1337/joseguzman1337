<?php
/*
 * Caso 90158
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso 90158 
include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
$fechahoy=date("Y-m-d");
require_once(realpath(dirname(__FILE__)).'/../Connections/sala2.php');
$rutaado = "../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../Connections/salaado.php');
require_once(realpath(dirname(__FILE__))."/../funciones/clases/phpmailer/class.phpmailer.php");
$varguardar=0;

$aniomenos = strtotime( '-1 year' ,strtotime($fechahoy));
$aniomenos = date ( 'd/m/Y' , $aniomenos );
//echo "<br>".$aniomenos;

$query_egresados = "select * from egresado_ext where fechaactualizacion ='$aniomenos' and recibeinfo like '1%'";
                $egresados= $db->Execute($query_egresados);
                $totalRows_egresados = $egresados->RecordCount();
                //$row_egresados = $egresados->FetchRow();
if($totalRows_egresados !=0){

   while($row_egresados = $egresados->FetchRow()){
   //echo "<br>".$row_egresados['codigoestudiante'];

	$query_correoe = "select * from estudiante e 
			join estudiantegeneral eg using(idestudiantegeneral)
			where e.idestudiantegeneral='".$row_egresados['codigoestudiante']."'
			group by e.idestudiantegeneral";
                $correoe= $db->Execute($query_correoe);
                $totalRows_correoe = $correoe->RecordCount();
		$row_correoe = $correoe->FetchRow();

$correoest=$row_correoe['emailestudiantegeneral'];
$nombre=strtoupper($row_correoe['nombresestudiantegeneral'])." ".strtoupper($row_correoe['apellidosestudiantegeneral']);
	
	$mail = new PHPMailer();
        $mail->From = "EGRESADOS UNIVERSIDAD EL BOSQUE";
        $mail->FromName = "EGRESADOS UNIVERSIDAD EL BOSQUE";
        $mail->ContentType = "text/html";
        $mail->Subject = "ACTUALIZACION DE DATOS";
        $mail->AddAddress($correoest,$nombre);

                       $mensaje="<h2><i>¡Tú eres muy importante para nosotros!</i></h2><br><br>"
			."Te invitamos a mantener tu información al día. Así podremos mantenerte actualizado sobre los temas que sean de tu interés, como los diferentes planes, programas y beneficios que el Área de Egresados ha desarrollado especialmente para ti. Esta es la mejor forma de entregarte oportunamente información relevante en tu dirección de correo. ¿Qué estás esperando?<BR>"
			."<h2 style='COLOR: #6f90b8;'><i><a href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/info_egresados.php?opc=actualizar'>¡ACTUALIZALOS YA!</a></i></h2><BR>".
                        "<h5><i>Has recibido este correo porque estás  en nuestros registros de Egresado. Para nosotros es muy importante mantenernos en contacto y ofrecerte información de interés. Si no deseas recibir más mensajes por favor háznoslo saber haciendo <a href='dardebaja.php?idserialize=".$row_correoe['codigoestudiante']."' target='_blank'>Click aquí</i></h5>";

                      $mail->Body = $mensaje;
                      //print_r($mensaje);
                      //$mail->Send();

                     if($mail->Send())
                        {
			    echo "se ha enviado el mensaje a ".$nombre."  ".$correoest."<br>";
                        }

		     else{
			    echo "El mensaje no pudo ser enviado<br>";
                            echo "Mailer Error: " . $mail->ErrorInfo;
			    echo "<br>";
                        //exit();
		     }

   }

}
else{

echo "<h1>No hay Estudiantes en la fecha</h1>";

}
?>
