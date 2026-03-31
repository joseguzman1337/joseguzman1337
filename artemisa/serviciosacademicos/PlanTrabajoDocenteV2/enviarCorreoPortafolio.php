<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

include 'lib/phpMail/class.phpmailer.php';
include 'lib/phpMail/class.smtp.php';
 //include 'lib/OficioUB.php';

include 'lib/ControlClienteCorreo.php';
//var_dump($db);
if($db==null){
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD(); 
}

if(isset($_POST["tipoOperacionCorreo"])){
	
	$sqlEnviaCorreoPortafolio = "SELECT
									D.nombredocente,
									D.apellidodocente,
									D.numerodocumento,
									D.emaildocente,
									U.usuario,
										CONCAT(U.usuario,'@unbosque.edu.co') AS Correo
								FROM
									docente D
								INNER JOIN grupo G ON ( G.numerodocumento = D.numerodocumento )
								LEFT  JOIN usuario U ON ( U.numerodocumento = D.numerodocumento )
								WHERE G.codigoperiodo = 20151
								AND D.iddocente != 1
								GROUP BY D.numerodocumento, D.iddocente
								ORDER BY D.nombredocente
								";
	
	$correosDocentes = $db->Execute($sqlEnviaCorreoPortafolio);
	
	$contar = $correosDocentes->_numOfRows;
	$i = 1;
	echo "<p>Se ha enviado un correo a los siguientes destinatarios:</p>";
	
	foreach( $correosDocentes as $correoDocente ){
	
	$docenteCorreo = $correoDocente["emaildocente"];
	$nombreDocente = $correoDocente["nombredocente"]." ".$correoDocente["apellidodocente"];	
	if( ($correoDocente["numerodocumento"] == 52582902 || $correoDocente["numerodocumento"] == 79785427 || $correoDocente["numerodocumento"] == 10529308) || $correoDocente["emaildocente"] == NULL ){
			
			$docenteCorreo = $correoDocente["Correo"];
	}
	$controlClienteCorreo = new ControlClienteCorreo();
	$enviarCorreo = $controlClienteCorreo->enviarCorreoPortafolio($docenteCorreo, $nombreDocente);
	/**/
	echo "<table>
			<tr>
				<td>".$i++."</td>
				<td>".$docenteCorreo."</td>
			</tr>
		</table>"; 
	
	}
	echo "<script>
			    alert('Se ha enviado un correo electrónico');
			 </script>";
	
	
	
	
	
		
}
?>