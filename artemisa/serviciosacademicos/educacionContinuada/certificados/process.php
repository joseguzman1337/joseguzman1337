<?php
include_once("../variables.php");
include($rutaTemplate."template.php");

$db = getBD();
$utils = Utils::getInstance();

$action = $_REQUEST["action"];

if((strcmp($action,"changeHeader")==0)){
	$fields = array();
	if(sizeof($_FILES)==0 || $_FILES["file"]["name"]===""){
		//no hay cambios
		$result = 0;
	} else {
		$result = 1;
		$archivo = $_FILES["file"]["tmp_name"];
			//OBTENEMOS EL TAMAÑO DEL ARCHIVO
			$tamanio = array();
			$tamanio = $_FILES["file"]["size"];
			//OBTENEMOS EL TIPO MIME DEL ARCHIVO
			$tipo = $_FILES["file"]["type"];
			
			//OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
			if($tipo=='image/png' || $tipo=='image/pjpeg' || 
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
					$tamanio=$utils->filesize_format($tamanio);
					
					if($tamanio[1]==='MB'){
							if($tamanio[0]>10){
								$data = array('success'=> false,'message'=> "El archivo supera el tamaño permitido. No debe ser mayor a 10MB.");
							}
					} else { 
						$info = pathinfo($_FILES["file"]["name"]);
				
						//subimos el archivo a la carpeta
						move_uploaded_file($_FILES["file"]["tmp_name"],"../parametrizacion/images/".$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']);
 
						$url="../parametrizacion/images/".$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']; 
						
						//registramos la firma
						$sql = "SELECT * FROM detallePlantillaCursoEducacionContinuada WHERE idPlantilla='".$_REQUEST["idPlantilla"]."' AND idCampoParametrizado='".$_REQUEST["idCampoParametrizado"]."'";

						$fields = $db->GetRow($sql);
						$actionF = "save";
						if(count($fields)>0){
							$actionF = "update";
						}
						$fields["idPlantilla"] = $_REQUEST["idPlantilla"];
						$fields["idCampoParametrizado"] = $_REQUEST["idCampoParametrizado"];
						$fields["valor"] = $url;
						$result = $utils->processData($actionF,"detallePlantillaCursoEducacionContinuada","iddetallePlantillaCursoEducacionContinuada",$fields,false);
						if($result == 0){ 
							// Set up associative array
							$data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de cambiar el encabezado.');
						} else { 
							$data = array('success'=> true,'message'=> "El encabezado se ha registrado de forma correcta.");
						}
					}					
				} else {
					$data = array('success'=> false,'message'=> "El archivo está corrupto.");
				}
			} else {
				$data = array('success'=> false,'message'=> "El archivo no tiene un formato permitido. Los tipos de archivo 
				permitidos son jpg y png.");
			}
	} ?>
	<script language="javascript" type="text/javascript">
		window.location.href="cambiarEncabezadoCurso.php?idplantilla=<?php echo $_REQUEST["idPlantilla"]; ?>&success=<?php echo $data["success"]; ?>&mensaje=<?php echo $data["message"]; ?>";
	</script>
<?php } else if ((strcmp($action,"inactivate")==0)){ 
	$result = $utils->processData($action,$_REQUEST["entity"],"id".$_REQUEST["entity"]);
	if($result == 0){ 
		// Set up associative array
		$respuesta = array('success'=> false,'message'=>'Ha ocurrido un problema al eliminar el encabezado.');
	} else { 
		$respuesta = array('success'=> true,'message'=> "El encabezado se ha eliminado de forma correcta.");
	}
} else if ((strcmp($action,"saveCourse")==0)){ 
	initializeCertificados();
	$utilsC = Utils_Certificados::getInstance();
	$plantilla= trim($_POST['stringPlantilla']);
        $plantilla = $utilsC->decodificarGuardarPlantillaHTML($plantilla);
	$user=$utils->getUser();
	$login=$user["idusuario"];
	$dateHoy=date('Y-m-d H:i:s');
	
	$plantillaUpdateSql="update plantillaCursoEducacionContinuada set plantilla='$plantilla', fecha_modificacion='$dateHoy', usuario_modificacion='$login' where idplantillaCursoEducacionContinuada='".$_REQUEST["idplantillaCursoEducacionContinuada"]."';";
	$result=$db->Execute($plantillaUpdateSql);
	if($result){
		$respuesta['success']=true;
	}
	else{
		$respuesta['success']=false;
	}
	
} else if ((strcmp($action,"asociarFirma")==0)){ 
	$sql = "SELECT * FROM detalleFirmasPlantillaCursoEducacionContinuada WHERE idPlantilla='".$_REQUEST["idPlantilla"]."' AND idFirma='".$_REQUEST["idFirma"]."' AND codigoestado=100";

	$fields = $db->GetRow($sql);
	$actionF = $_REQUEST["actionF"];
	if(count($fields)>0){
		$respuesta = array('success'=> false,'message'=>'No puede asociar la misma firma más de una vez en el mismo certificado.');
	} else {
		$result = $utils->processData($actionF,"detalleFirmasPlantillaCursoEducacionContinuada","iddetalleFirmasPlantillaCursoEducacionContinuada");
		if($result == 0){ 
			// Set up associative array
			$respuesta = array('success'=> false,'message'=>'Ha ocurrido un problema al asociar la firma.');
		} else { 
			$respuesta = array('success'=> true,'message'=> "La firma se registro de forma correcta.");
		}
	}

} else if ((strcmp($action,"asociarFirmas")==0)){ 
    $cols = intval($_REQUEST["columnas"]); 
    $numFilas = intval($_REQUEST["filas"]);
    $maxCols = 5;
    $activos = "";
    for($j=1;$j<=$numFilas;$j++){
        for($i=1;$i<=$cols;$i++){        
            if($activos===""){
                $activos = ($maxCols*($j)-$maxCols+$i);
            } else {
                $activos .= ",".($maxCols*($j)-$maxCols+$i);
            }
        }
    }
    
	$sql = "SELECT * FROM detalleFirmasPlantillaCursoEducacionContinuada WHERE idPlantilla='".$_REQUEST["idPlantilla"]."' AND codigoestado=100 AND orden NOT IN ($activos)";
        //var_dump($sql); die;
	$toInactivate = $db->Execute($sql);
	$actionF = "inactivate";
        while($row = $toInactivate->FetchRow()){
            $fields["iddetalleFirmasPlantillaCursoEducacionContinuada"] = $row["iddetalleFirmasPlantillaCursoEducacionContinuada"];
            $result = $utils->processData($actionF,"detalleFirmasPlantillaCursoEducacionContinuada","iddetalleFirmasPlantillaCursoEducacionContinuada",$fields,false);
        }
		
	$respuesta = array('success'=> true,'message'=> "Los cambios se han guardado de forma correcta."); ?>

        <script language="javascript" type="text/javascript">
		if (window.opener != null) {   
			window.opener.location.reload(true);   
			window.close();   
		} 
	</script>
<?php } else {
        initializeCertificados();
	$utilsC = Utils_Certificados::getInstance();
	$plantilla= trim($_POST['stringPlantilla']);
        $plantilla = $utilsC->decodificarGuardarPlantillaHTML($plantilla);
        
        
        //var_dump($plantilla);die();
	$nombre= $_POST['nombre'];
	$user=$utils->getUser();
	$login=$user["idusuario"];
	$dateHoy=date('Y-m-d H:i:s');
	$plantillaSelectRow = NULL;
	if(isset($_REQUEST["idplantillaGenericaEducacionContinuada"])){
		$plantillaSelectSql="select * from plantillaGenericaEducacionContinuada where idplantillaGenericaEducacionContinuada='".$_REQUEST["idplantillaGenericaEducacionContinuada"]."';";
		$plantillaSelectRow = $db->GetRow($plantillaSelectSql);
	} 
	$result=false;
	if($plantillaSelectRow!=NULL && count($plantillaSelectRow)>0){
		$plantillaUpdateSql="update plantillaGenericaEducacionContinuada set nombre='$nombre', plantilla='$plantilla', fecha_modificacion='$dateHoy', usuario_modificacion='$login' where idplantillaGenericaEducacionContinuada='".$_REQUEST["idplantillaGenericaEducacionContinuada"]."';";
		$result=$db->Execute($plantillaUpdateSql);
	}
	else{
		$plantillaInsertSql="INSERT into `plantillaGenericaEducacionContinuada` (`nombre`, `plantilla`, `fecha_creacion`, `usuario_creacion`, `fecha_modificacion`,`usuario_modificacion`) VALUES ('$nombre', '$plantilla', '$dateHoy', '$login', '$dateHoy', '$login');";            
		$result=$db->Execute($plantillaInsertSql);
	}
	$respuesta= array();
	if($result){
		$respuesta['success']=true;
	}
	else{
		$respuesta['success']=false;
	}
}

echo json_encode($respuesta);
exit;



?>
