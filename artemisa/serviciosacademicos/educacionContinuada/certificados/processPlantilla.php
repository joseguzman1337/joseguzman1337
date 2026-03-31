<?php session_start(); 

include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();
$utils = Utils::getInstance();

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

$action = $_REQUEST["action"];

if(strcmp($action,"save")==0){
	//registrar firma
	
	//VERIFICAMOS QUE SE SELECCIONO ALGUN ARCHIVO
	  if(sizeof($_FILES)==0){
		 $data = array('success'=> false,'message'=> "No se ha seleccionado ningún archivo.");
	  } else { 
			$archivo = $_FILES["file"]["tmp_name"];
			//OBTENEMOS EL TAMAÑO DEL ARCHIVO
			$tamanio = array();
			$tamanio = $_FILES["file"]["size"];
			//OBTENEMOS EL TIPO MIME DEL ARCHIVO
			$tipo = $_FILES["file"]["type"];
			
			//OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
			if($tipo=='image/gif' || $tipo=='image/png' || $tipo=='image/pjpeg' || 
					$tipo=='image/jpeg' || $tipo=='image/jpg'){
				//todo bien
				$nombre = $_REQUEST['nombre'];
				$cargo = $_REQUEST['cargo'];
				$unidad = $_REQUEST['unidad'];
				
				$nombre_archivo = $_FILES["file"]["name"];
				extract($_REQUEST);
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
						$info = pathinfo($_FILES["file"]["name"]);
				
						//subimos el archivo a la carpeta
						move_uploaded_file($_FILES["file"]["tmp_name"],"firmas/".$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']);
 
						$url="firmas/".$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']; 
						
						//registramos la firma
						$fields = array();
						$fields["nombre"] = $nombre;
						$fields["cargo"] = $cargo;
						$fields["unidad"] = $unidad;
						$fields["ubicacionFirmaEscaneada"] = $url;
						$fields["file_size"] = $tamanio[0];
						$fields["unidadTamano"] = $tamanio[1];
						$fields["tipoArchivo"] = $tipo;
						$fields["extensionArchivo"] = $info['extension'];
						$result = $utils->processData("save","firmaEscaneadaEducacionContinuada","idfirmaEscaneadaEducacionContinuada",$fields,false);
						if($result == 0){ 
							// Set up associative array
							$data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de registrar la firma.');
						} else { 
							$data = array('success'=> true,'message'=> "La firma se ha registrado de forma correcta.");
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
	  
	if($data["success"]){ ?>
		<script language="javascript" type="text/javascript">
			window.location.href="detalle.php?id=<?php echo $result; ?>";
		</script>
	<?php } else { ?>
		<script language="javascript" type="text/javascript">
			window.location.href="registro.php?mensaje=<?php echo $data["message"]; ?>";
		</script>
	<?php } 
} else if(strcmp($action,"update")==0){

	$fields = array();
	$fields["nombre"] = $_REQUEST['nombre'];
	$fields["cargo"] = $_REQUEST['cargo'];
	$fields["unidad"] = $_REQUEST['unidad'];
	$fields["idfirmaEscaneadaEducacionContinuada"] = $_REQUEST['idfirmaEscaneadaEducacionContinuada'];

	if(sizeof($_FILES)==0 || $_FILES["file"]["name"]===""){
		$result = $utils->processData("update","firmaEscaneadaEducacionContinuada","idfirmaEscaneadaEducacionContinuada",$fields,false);
		if($result==0){
			$data["success"] = false;
			$data["message"] = "Ocurrio un error al tratar de actualizar los datos de la firma.";
		} else {
			$data["success"] = true;
		}
	} else {
		$archivo = $_FILES["file"]["tmp_name"];
			//OBTENEMOS EL TAMAÑO DEL ARCHIVO
			$tamanio = array();
			$tamanio = $_FILES["file"]["size"];
			//OBTENEMOS EL TIPO MIME DEL ARCHIVO
			$tipo = $_FILES["file"]["type"];
			
			//OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
			if($tipo=='image/gif' || $tipo=='image/png' || $tipo=='image/pjpeg' || 
					$tipo=='image/jpeg' || $tipo=='image/jpg'){
				//todo bien
				$nombre_archivo = $_FILES["file"]["name"];
				extract($_REQUEST);
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
						$info = pathinfo($_FILES["file"]["name"]);
				
						//subimos el archivo a la carpeta
						move_uploaded_file($_FILES["file"]["tmp_name"],"firmas/".$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']);
 
						$url="firmas/".$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']; 
						
						//registramos la firma
						$fields["ubicacionFirmaEscaneada"] = $url;
						$fields["file_size"] = $tamanio[0];
						$fields["unidadTamano"] = $tamanio[1];
						$fields["tipoArchivo"] = $tipo;
						$fields["extensionArchivo"] = $info['extension'];
						$result = $utils->processData("update","firmaEscaneadaEducacionContinuada","idfirmaEscaneadaEducacionContinuada",$fields,false);
						if($result == 0){ 
							// Set up associative array
							$data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de registrar la firma.');
						} else { 
							$data = array('success'=> true,'message'=> "La firma se ha registrado de forma correcta.");
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
	
	if($data["success"]){ ?>
		<script language="javascript" type="text/javascript">
			window.location.href="detalle.php?id=<?php echo $result; ?>";
		</script>
	<?php } else { ?>
		<script language="javascript" type="text/javascript">
			window.location.href="editar.php?id=<?php echo $fields["idfirmaEscaneadaEducacionContinuada"]; ?>";
		</script>
	<?php } 
} else if(strcmp($action,"inactivate")==0){
	$result = $utils->processData("inactivate",$_REQUEST["entity"],"id".$_REQUEST["entity"]);
	if($result == 0){ 
		// Set up associative array
		$data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de eliminar la plantilla.');
	} else { 
		$data = array('success'=> true,'message'=> "La plantilla se ha eliminado de forma correcta.");
	}

	// JSON encode and send back to the server
	echo json_encode($data);
}
?>