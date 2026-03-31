<?php
/**
 * @author Gonzalo Mejia Zapata <c.gmejia@sic.gov.co>
 * @copyright 2012 Oficnina de tecnologoia
 * @package servicio
 */


header ('Content-type: text/html; charset=utf-8');
ini_set('display_errors','On');

session_start( );

if($_POST){ 
    $keys_post = array_keys($_POST); 
    foreach ($keys_post as $key_post){ 
      $$key_post = $_POST[$key_post]; 
     } 
}

if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $$key_get = $_GET[$key_get]; 
     } 
} 

switch ( $mensaje ) {
	
	case 'actualizado':
			echo "Actualizado con exito";
	break;
	
	case 'ValidarCampos':
		?>
		<p align="center">
		<?php	echo "</br>&nbsp;Existen campos sin diligenciar.</br>"; ?>
		</p>	
		<?php	
		
		/* Modified Diego Rivera <riveradiego@unbosque.edu.co>
		 * se agrega validacion para que muestre texto adecuado en el mesaje de alerta
		 * Since March 22,2017
		 */
				if($_POST){ 
    				$keys_post = array_keys($_POST);
    				foreach ($keys_post as $key_post){
    					if( $_POST[$key_post] != "ValidarCampos" ){
								
							if($key_post=='txtCodigoFacultad'){
								$key_post='Facultad<br>';
							}
							
							if($key_post=='cmbLineaConsulta'){
								$key_post='Línea Estratégica<br>';
							}
							
							if($key_post=='cmbProgramaConsultar'){
								$key_post='Programa<br>';
							}
							
							if($key_post=='cmbProyectoConsultar'){
								$key_post='Proyecto<br>';
							}
							
							if($key_post=='cmbMetaConsultar'){
								$key_post='Meta Principal<br>';
							}
							
							echo $key_post ;
						}
     				}
				}
				if($_GET){
				    $keys_get = array_keys($_GET); 
				    foreach ($keys_get as $key_get){ 
    					if( $_GET[$key_post] != "ValidarCampos" )
    					echo $key_get . " , ";
				     } 
				}
	break;
	case 'errorLogin':
			echo "Error usuario o contrasenia incorrectos";	
	break;
	
		
	case 'errorClaves':
			echo "Las claves no coinciden";	
	break;

	case 'clavesActulizadas':
		echo "Las claves se han actualizado.";	
			
	case 'selecionarTipoDocumento':
			echo "Seleccion el tipo de documento";	
	break;
	
	case 'controlCampos':
			echo "<div style=\"color:#FF0000;\">"; 
			echo "Los siguientes campos se encuentran vacios o no seleccionados.</br></br>";
			echo $errores;
			echo "</div>";
	break;
	
	case 'estadoActualizado':
			echo "Estado actualizado";	
	break;
	case 'error':
			echo $error;	
	break;
			
}


?>