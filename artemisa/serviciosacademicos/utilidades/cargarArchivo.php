<?php 

function filesize_format($bytes, $format = '', $force = ''){
	#echo 'Entro..';
	$bytes=(float)$bytes;
		if ($bytes< 1024){
		$numero=number_format($bytes, 0, '.', ',');
        return array($numero,"B");
        }
	if ($bytes< 1048576){
		$numero=number_format($bytes/1024, 2, '.', ',');
		return array($numero,"KBs");
		}
	if ($bytes>= 1048576){
		$numero=number_format($bytes/1048576, 2, '.', ',');
		return array($numero,"MB");
	}
}

function getTiposImagenes(){
	return array('image/gif','image/png','image/pjpeg','image/jpeg','image/jpg');
}

function cargarArchivo($db,$file,$tiposAdmitidos,$parametros){
	//VERIFICAMOS QUE SE SELECCIONO ALGUN ARCHIVO
	  if(sizeof($file)==0){
		 $data = array('success'=> false,'message'=> "No se ha seleccionado ningún archivo.");
	  } else { 
			$archivo = $file["tmp_name"];
			//OBTENEMOS EL TAMAÑO DEL ARCHIVO
			$tamanio = array();
			$tamanio = $file["size"];
			//OBTENEMOS EL TIPO MIME DEL ARCHIVO
			$tipo = $file["type"];
			
			//OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
			$todobien = false;
			foreach($tiposAdmitidos as $tipoA){
				if($tipo==$tipoA){
					$todobien = true;
				}
			}
			
			if($todobien){
				//todo bien
				
				$nombre_archivo = $file["name"];
				//extract($_REQUEST);
				if ( $archivo != "none" ){
					//ABRIMOS EL ARCHIVO EN MODO SOLO LECTURA
					// VERIFICAMOS EL TAÑANO DEL ARCHIVO
					$fp = fopen($archivo, "rb");
					//LEEMOS EL CONTENIDO DEL ARCHIVO
					$contenido = fread($fp, $tamanio);
					//CON LA FUNCION addslashes AGREGAMOS UN \ A CADA COMILLA SIMPLE ' PORQUE DE OTRA MANERA
					//NOS MARCARIA ERROR A LA HORA DE REALIZAR EL INSERT EN NUESTRA TABLA
					$contenido = addslashes($contenido);
					//CERRAMOS EL ARCHIVO
					fclose($fp);
					
					//HACEMOS LA CONVERSION PARA PODER GUARDAR SI EL TAMAÑO ESTA EN b ó MB
					$tamanio=filesize_format($tamanio);
					
					if($tamanio[1]==='MB'){
							if($tamanio[0]>10){
								$data = array('success'=> false,'message'=> "El archivo supera el tamaño permitido. No debe ser mayor a 10MB.");
							}
					} else { 
						$info = pathinfo($file["name"]);
				
						//subimos el archivo a la carpeta
						move_uploaded_file($file["tmp_name"],$parametros["carpeta"].$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']);
						if(is_file($parametros["carpeta"].$info['filename'].'_'.date("Y-m-d").'.'.$info['extension'])){
							$url=$parametros["carpeta"].$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']; 
							
							//retornamos datos del archivo
							$fields = array();
							$fields["url"] = $url;
							$fields["file_size"] = $tamanio[0];
							$fields["file_unit"] = $tamanio[1];
							$fields["file_type"] = $tipo;
							$fields["file_extension"] = $info['extension'];
								$data = array('success'=> true,'message'=> "El archivo se ha registrado de forma correcta.",'fileData'=>$fields);
						} else {
							$data = array('success'=> false,'message'=> "Error al cargar el archivo, comuniquese con tecnología.");
						}
					}					
				} else {
					$data = array('success'=> false,'message'=> "El archivo está corrupto.");
				}
			} else {
				$data = array('success'=> false,'message'=> "El archivo no tiene un formato permitido. Los tipos de archivo 
				permitidos son jpg, gif y png.");
			}
	  }
	  //var_dump($data);die;
	  return $data;
	
}

?>