<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session 
 session_start(); 

session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$utils = Utils::getInstance();

$action = $_REQUEST["action"];

if((strcmp($action,"updateValues")==0)){
        $now = date('Y-m-d H-i-s');
        $user = $utils->getUser();
        
        $valores = $utils->getValoresParametrizacion($db,"CURSOS");
        $numValores = count($valores);
	
        for($i = 0; $i < $numValores; ++$i) {
            $sql = "UPDATE parametrizacionEducacionContinuada SET fecha_modificacion = '" .$now. "',
                valor='" .$_REQUEST["parametro_".$valores[$i]["idparametrizacionEducacionContinuada"]]. "', 
                    usuario_modificacion = '" .$user["idusuario"]. "'
                    WHERE idparametrizacionEducacionContinuada = '" .$valores[$i]["idparametrizacionEducacionContinuada"]. "'";
            $result = $db->Execute($sql);
        }
           
	$data = array('success'=> true,'message'=> "Los valores se han guardado correctamente.");
} else if ((strcmp($action,"updateValuesCertificaciones")==0)){
    $fields = array();
	$fields["valor"] = "";
	$fields["idparametrizacionEducacionContinuada"] = $_REQUEST['idparametrizacionEducacionContinuada'];
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
						move_uploaded_file($_FILES["file"]["tmp_name"],"images/".$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']);
 
						$url="../parametrizacion/images/".$info['filename'].'_'.date("Y-m-d").'.'.$info['extension']; 
						
						//registramos la firma
						$fields["valor"] = $url;
						$result = $utils->processData("update","parametrizacionEducacionContinuada","idparametrizacionEducacionContinuada",$fields,false);
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
				permitidos son jpg y png.");
			}
	}
       ?>
		<script language="javascript" type="text/javascript">
			window.location.href="certificaciones.php?mensaje=<?php echo $data["message"]; ?>";
		</script>
<?php		
	//$data = array('success'=> true,'message'=> "Los valores se han guardado correctamente.");
} else if((strcmp($action,"agregarPermisosUsuario")==0)){
        $now = date('Y-m-d H-i-s');
        $user = $utils->getUser();
		$id = $_REQUEST["usuario"];
		$rol = $_REQUEST["rol"];
        $idpermiso = null;
		$idpermisomenuopcion = null;
        $sql = "SELECT * FROM permisousuariomenuopcion WHERE idusuario='$id' AND codigoestado=100";
		$result = $db->GetRow($sql);
		if(count($result) == 0 ){
			//no se ha creado, toca agregarlo
			$sql = "INSERT INTO `permisomenuopcion` (`fecharegistropermisomenuopcion`, `fechainiciopermisomenuopcion`, `fechavencimientopermisomenuopcion`, `codigoestado`) VALUES ('$now', '$now', '2999-12-31 00:00:00', '100')";
			$result = $db->Execute($sql);
			if($result){
				$idpermisomenuopcion = $db->Insert_ID();
				$sql = "INSERT INTO `permisousuariomenuopcion` 
				(`idpermisomenuopcion`, `idusuario`, `codigoestado`) VALUES ('$idpermisomenuopcion', '$id', '100')";
				$result = $db->Execute($sql);
				if($result){
					$idpermiso = $db->Insert_ID();
				}
			}
		} else {
			$idpermisomenuopcion = $result["idpermisomenuopcion"];
			$idpermiso = $result["idpermisousuariomenuopcion"];
		}
	
        if($idpermisomenuopcion!=null && $idpermiso!=null){
			$opcionesmenu = $utils->getIDsMenuEC($db,$rol);
                        //var_dump($opcionesmenu);
			if($opcionesmenu!==false){
				$num = count($opcionesmenu);
				for($i = 0; $i < $num; ++$i) {
					$sql = "select * from detallepermisomenuopcion where idpermisomenuopcion='$idpermisomenuopcion' 
					AND idmenuopcion='".$opcionesmenu[$i]."'";
					$result = $db->GetRow($sql);
					if(count($result) == 0 ){
						//insertar
						$sql = "INSERT INTO `sala`.`detallepermisomenuopcion` 
						(`idpermisomenuopcion`, `idmenuopcion`, `codigoestado`) VALUES ('$idpermisomenuopcion', 
						'".$opcionesmenu[$i]."', '100')";
						$result = $db->Execute($sql);
					} else {
						//activarla
						$sql = "UPDATE `detallepermisomenuopcion` SET `codigoestado`='100' WHERE 
						`iddetallepermisomenuopcion`='".$result["iddetallepermisomenuopcion"]."'";
						$result = $db->Execute($sql);
					}
				}
				
				$sql = "SELECT * FROM usuarioEducacionContinuadaRol WHERE idusuario='$id' ";
				$result = $db->GetRow($sql);
				if(count($result) == 0 ){
						//insertar
						$sql = "INSERT INTO `sala`.`usuarioEducacionContinuadaRol` 
						(`idusuario`, `idrol`, `fecha_creacion`, `usuario_creacion`, `codigoestado`, `fecha_modificacion`, `usuario_modificacion`) 
						VALUES ('$id', ".$rol.", '$now', ".$user["idusuario"].", 100, '$now', ".$user["idusuario"].")";

						$result = $db->Execute($sql);
					} else {
						//activarla
						$sql = "UPDATE `usuarioEducacionContinuadaRol` SET `codigoestado`='100', `idrol`=".$rol." WHERE 
						`idusuarioEducacionContinuadaRol`='".$result["idusuarioEducacionContinuadaRol"]."'";
						$result = $db->Execute($sql);
					}
				
				$data = array('success'=> true,'message'=> "Los valores se han guardado correctamente.");
			} else {
				$data = array('success'=> false,'message'=> "No se encontraron permisos para asignar.");
			}
		} else {
			$data = array('success'=> false,'message'=> "Ha ocurrido un error al tratar de asignar los permisos.");
		}
           
	
} else if((strcmp($action,"eliminarPermisosUsuario")==0)){
        $now = date('Y-m-d H-i-s');
        $user = $utils->getUser();
	$id = $_REQUEST["usuario"];
        $idpermiso = null;
		$idpermisomenuopcion = null;
        $sql = "SELECT * FROM permisousuariomenuopcion WHERE idusuario='$id' AND codigoestado=100";
		$result = $db->GetRow($sql);
		if(count($result) == 0 ){
			//WTF!? no tiene permisos....
		} else {
			$idpermisomenuopcion = $result["idpermisomenuopcion"];
			$idpermiso = $result["idpermisousuariomenuopcion"];
		}
	
        if($idpermisomenuopcion!=null && $idpermiso!=null){
                        //todos los permisos
			$opcionesmenu = $utils->getIDsMenuEC($db,2);
			$admins=$utils->getUsuariosAdministradores($db);
			$usuarios = "";
			foreach($admins as $admin){
				if($admin["idusuario"]!=$id){
					if($usuarios!==""){
						$usuarios .= ",";
					}
					$usuarios .= $admin["idusuario"];
				}
			}
			if($opcionesmenu!==false){
				$num = count($opcionesmenu);
				for($i = 0; $i < $num; ++$i) {
					$sql = "select * from detallepermisomenuopcion dpm 
					INNER JOIN permisousuariomenuopcion pu on pu.idpermisomenuopcion=dpm.idpermisomenuopcion and pu.idpermisomenuopcion NOT IN 
					(SELECT idpermisomenuopcion FROM permisousuariomenuopcion WHERE idusuario IN ($usuarios) AND codigoestado=100) 
					where dpm.idpermisomenuopcion='$idpermisomenuopcion' 
					AND idmenuopcion='".$opcionesmenu[$i]."'";
					//echo $sql;
					$result = $db->GetRow($sql);
					if(count($result) == 0 ){
						//todo bien, no tiene el permiso
					} else {
						//desactivarla
						$sql = "UPDATE `detallepermisomenuopcion` SET `codigoestado`='200' WHERE 
						`iddetallepermisomenuopcion`='".$result["iddetallepermisomenuopcion"]."'";
						$result = $db->Execute($sql);
					}
				}
				
				$sql = "SELECT * FROM usuarioEducacionContinuadaRol WHERE idusuario='$id' ";
				$result = $db->GetRow($sql);
				if(count($result) == 0 ){
						//todo bien, no tiene el permiso
					} else {
						//desactivarla
						$sql = "UPDATE `usuarioEducacionContinuadaRol` SET `codigoestado`='200' WHERE 
						`idusuarioEducacionContinuadaRol`='".$result["idusuarioEducacionContinuadaRol"]."'";
						$result = $db->Execute($sql);
					}
				$data = array('success'=> true,'message'=> "Los valores se han guardado correctamente.");
			} else {
				$data = array('success'=> false,'message'=> "No se encontraron permisos para eliminar.");
			}
		} else {
			$data = array('success'=> false,'message'=> "Ha ocurrido un error al tratar de asignar los permisos.");
		}
           
	
} 

    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
		if($data==null)
        $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el reporte.');

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        //$data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
?>
