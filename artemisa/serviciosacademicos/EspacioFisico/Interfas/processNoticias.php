<?php
 session_start(); 
    include("template.php");
	require("../../utilidades/cargarArchivo.php");
    $db = getBD();
	
	$action = $_REQUEST["action"];
if(strcmp($action,"save")==0){
		//cargar el archivo
		$tiposImagenes = getTiposImagenes();
		$parametros = array("carpeta"=>"noticias/");
		if(sizeof($_FILES)==0 || $_FILES["file"]["name"]=="" || $_FILES["file2"]["name"]==""){
			$sql = "INSERT INTO `NoticiaEvento` (`TituloNoticia`, `DescripcionNoticia`, `FechaInicioVigencia`, `FechaFinalVigencia`, `Tipo`) 
			VALUES ('".$_POST["titulonoticia"]."', '".$_POST["descnoticia"]."', '".$_POST["fechainicio"]."', '".$_POST["fechafin"]."', '".$_POST["tipopublicacion"]."')";
			$result=$db->Execute($sql);
			if($result){
				$result = $db->Insert_ID();				
				$data = array('success'=> true,'message'=> "Se ha registrado la noticia de forma correcta.");
			} else {
				$data = array('success'=> false,'message'=> "No se registro la noticia en el sistema.");
			}  
			
		} else {
			$datosArchivo = cargarArchivo($db,$_FILES["file"],$tiposImagenes,$parametros);
			//echo "<pre>";print_r($datosArchivo);echo "<br/>";
			$datosArchivo2 = cargarArchivo($db,$_FILES["file2"],$tiposImagenes,$parametros);
			//echo "<pre>";print_r($datosArchivo2);echo "<br/>"; die;
			if($datosArchivo["success"]==true && $datosArchivo2["success"]==true){
				$sql = "INSERT INTO `NoticiaEvento` (`TituloNoticia`, `DescripcionNoticia`, `FechaInicioVigencia`, `FechaFinalVigencia`, `Tipo`
				, `UbicacionImagen`, `FileSize`, `FileUnit`, `FileExtension`, `FileType`, `UbicacionImagen2`
				, `FileSize2`, `FileUnit2`, `FileExtension2`, `FileType2`) 
				VALUES ('".$_POST["titulonoticia"]."', '".$_POST["descnoticia"]."', '".$_POST["fechainicio"]."', '".$_POST["fechafin"]."', '".$_POST["tipopublicacion"]."'
				, '".$datosArchivo["fileData"]["url"]."', '".$datosArchivo["fileData"]["file_size"]."', '".$datosArchivo["fileData"]["file_unit"]."', '".$datosArchivo["fileData"]["file_type"]."', '".$datosArchivo["fileData"]["file_extension"]."' 
				, '".$datosArchivo2["fileData"]["url"]."', '".$datosArchivo2["fileData"]["file_size"]."', '".$datosArchivo2["fileData"]["file_unit"]."', '".$datosArchivo2["fileData"]["file_type"]."', '".$datosArchivo2["fileData"]["file_extension"]."')";
				//echo $sql; die;
				$result=$db->Execute($sql);
				$result = $db->Insert_ID();
				//var_dump($result);die;
				if($result){
						$data = array('success'=> true,'message'=> "Se ha registrado la noticia de forma correcta.");
				} else {
						$data = array('success'=> false,'message'=> "No se registro la noticia en el sistema.");
				}   
			} else {
				$data = array('success'=> false,'message'=> "Ocurrio un error al subir las imagenes.");
			}	
		}
	
} else if(strcmp($action,"update")==0){
	$sql = "UPDATE `NoticiaEvento` SET `TituloNoticia`='".$_POST["titulonoticia"]."',`DescripcionNoticia`='".$_POST["descnoticia"]."',`FechaInicioVigencia`='".$_POST["fechainicio"]."',
	`FechaFinalVigencia`='".$_POST["fechafin"]."' WHERE (`NoticiaEventoId`='".$_POST["NoticiaEventoId"]."')";
	$result=$db->Execute($sql);
        if($result){
				$result = $_POST["NoticiaEventoId"];
				$data = array('success'=> true,'message'=> "Los cambios se han guardado de forma correcta.");
        } else {
				$data = array('success'=> false,'message'=> "Ocurrio un error en el sistema.");
		} 
 } else if(strcmp($action,"inactivate")==0){
	$sql = "UPDATE `NoticiaEvento` SET `CodigoEstado`='200' WHERE (`NoticiaEventoId`='".$_POST["NoticiaEventoId"]."')";
	$result=$db->Execute($sql);
        if($result){
				$data = array('success'=> true,'message'=> "Los cambios se han guardado de forma correcta.");
        } else {
				$data = array('success'=> false,'message'=> "Ocurrio un error en el sistema.");
		} 
 } else if(strcmp($action,"aprobar")==0){
	$sql = "UPDATE `NoticiaEvento` SET `AprobadoPublicacion`='1' WHERE (`NoticiaEventoId`='".$_POST["NoticiaEventoId"]."')";
	$result=$db->Execute($sql);
        if($result){
				$data = array('success'=> true,'message'=> "La noticia fue aprobada para su publicación.");
        } else {
				$data = array('success'=> false,'message'=> "Ocurrio un error en el sistema.");
		} 
 }
/*var_dump($_REQUEST["reload"]);
var_dump($data["success"]);
var_dump($result);*/
 if(isset($_REQUEST["reload"])){
	if($data["success"]){ ?>
		<script language="javascript" type="text/javascript">
			window.location.href="detalle.php?id=<?php echo $result; ?>";
		</script>
	<?php } else { ?>
		<script language="javascript" type="text/javascript">
			alert("<?php echo $data["message"]; ?>");
			window.location.href="noticias.php";
		</script>
	<?php } 
 } else {
    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        //$data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
 }
?>