<?php
    
    function listar_archivos($carpeta){
		$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'xlsx', 'xls', 'docx', 'doc', 'ppt', 'pptx', 'txt', 'pdf');
	    if(is_dir($carpeta)){
	        if($dir = opendir($carpeta)){ ?>
				<div style="width: 80%; margin-left: 50px;">
				<h3 style="margin-top:30px;margin-bottom:0; font-weight: normal; font-family: Lucida Grande,Lucida Sans Unicode,Lucida Sans,Geneva,Verdana,sans-serif;">Los siguientes son los anexos asociados:</h3>
				<br />
				<ol id="listaDocumentos">
	            <?php while(($archivo = readdir($dir)) !== false){
	            	$filePart = pathinfo($archivo);
	                if (in_array(strtolower($filePart['extension']), $fileTypes)) {
	                	if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
	                	
	                	$ubicacion = base64_encode("ubicacion");
						$nombre = base64_encode("nombre");
	                	$file = base64_encode( urlencode( serialize( "".$carpeta."/".$archivo."" ) ) );
					?>
					<li><a id="linkDocumentos" target="_blank" href="<?php echo '../servicio/descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;"><?php echo $archivo; ?></a></li>
	              <?php  } 
					}
	            } ?>
	            </ol>
	            </div>
	           <?php closedir($dir);
	        }
	    }else{
	    	echo "No existen Anexos";
	    }
	}
?>