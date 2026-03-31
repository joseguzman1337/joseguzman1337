<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session 
 session_start(); 

include("../templates/template.php");
$db = getBD();

$utils = new Utils_Datos();

$action = $_REQUEST["action"];

if((strcmp($action,"agregarPermisosUsuario")==0)){
        $now = date('Y-m-d H-i-s');
        $user = $utils->getUser();
		$id = $_REQUEST["usuario"];
                $form=$_REQUEST["form"];
		$rol = intval($_REQUEST["rol"]);
        $sql = "SELECT usuario FROM usuario WHERE idusuario='$id'";
	$result = $db->GetRow($sql);       
        $usuario=$result["usuario"];
        //si es lider de factor hay que agregarlo
        if($rol==2){
            $sql = "SELECT * FROM siq_gestionPermisosMGI WHERE idUsuario='$id' or usuario='$usuario' AND idRol=2";
            $result = $db->GetRow($sql);     
            if(count($result) == 0 ){
                $sql = "INSERT INTO `siq_gestionPermisosMGI` 
				(`idRol`, `idUsuario`, `codigoestado`) VALUES ('$rol', '$id', '100')";

            } else {
                //activarla
		$sql = "UPDATE `siq_gestionPermisosMGI` SET `codigoestado`='100' WHERE 
			(idUsuario='$id' or usuario='$usuario') AND idRol=$rol";
            }
        } else {
            $sql = "SELECT * FROM siq_gestionPermisosMGI WHERE idUsuario='$id' or usuario='$usuario' AND idRol!=2";
            $result = $db->GetRow($sql);     
            if(count($result) == 0 ){
                if($rol===1){
                    $sql = "INSERT INTO `siq_gestionPermisosMGI` 
				(`idRol`, `idUsuario`, `codigoestado`) VALUES ('$rol', '$id', '100')";
                } else {
                    $sql = "INSERT INTO `siq_gestionPermisosMGI` 
				(`idRol`, `idUsuario`, `idFormulario`, `codigoestado`) VALUES ('$rol', '$id', '$form', '100')";

                }

            } else {
                //activarla
		$sql = "UPDATE `siq_gestionPermisosMGI` SET `idFormulario`='$form', `codigoestado`='100' WHERE 
			(idUsuario='$id' or usuario='$usuario') AND idRol=$rol";
            }
        }
        //echo $sql;
        $result = $db->Execute($sql); 
                
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
			$opcionesmenu = $utils->getIDsMenuMGI($db,$rol,true);
                        //var_dump($opcionesmenu);
			if($opcionesmenu!==false){
				$num = count($opcionesmenu);
				for($i = 0; $i < $num; ++$i) {
					$sql = "select * from detallepermisomenuopcion where idpermisomenuopcion='$idpermisomenuopcion' 
					AND idmenuopcion='".$opcionesmenu[$i][0]."'";
					$result = $db->GetRow($sql);
					if(count($result) == 0 ){
						//insertar
						$sql = "INSERT INTO `sala`.`detallepermisomenuopcion` 
						(`idpermisomenuopcion`, `idmenuopcion`, `codigoestado`) VALUES ('$idpermisomenuopcion', 
						'".$opcionesmenu[$i][0]."', '100')";
						$result = $db->Execute($sql);
					} else {
						//activarla
						$sql = "UPDATE `detallepermisomenuopcion` SET `codigoestado`='100' WHERE 
						`iddetallepermisomenuopcion`='".$result["iddetallepermisomenuopcion"]."'";
						$result = $db->Execute($sql);
					}
                                        //echo $sql;
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
        $rol = intval($_REQUEST["rol"]);
        $idpermiso = null;
	$idpermisomenuopcion = null;
        $sql = "SELECT usuario FROM usuario WHERE idusuario='$id'";
	$result = $db->GetRow($sql);       
        $usuario=$result["usuario"];
        
        $sql = "SELECT * FROM permisousuariomenuopcion WHERE idusuario='$id' AND codigoestado=100";
		$result = $db->GetRow($sql);
		if(count($result) == 0 ){
			//WTF!? no tiene permisos....
		} else {
			$idpermisomenuopcion = $result["idpermisomenuopcion"];
			$idpermiso = $result["idpermisousuariomenuopcion"];
		}
	
        $sql = "UPDATE `siq_gestionPermisosMGI` SET `codigoestado`='200' WHERE (idUsuario='$id' or usuario='$usuario') AND codigoestado=100";
        if($rol!==0){
            $sql .= " AND idRol='$rol'";
        }
        //echo $sql;
	$result = $db->Execute($sql);      
                
        if($idpermisomenuopcion!=null && $idpermiso!=null){
                        //todos los permisos
			$opcionesmenu = $utils->getIDsMenuMGI($db,$rol);
                        //var_dump($opcionesmenu);
			if($opcionesmenu!==false){
				$num = count($opcionesmenu);
				for($i = 0; $i < $num; ++$i) {
					$sql = "select * from detallepermisomenuopcion where idpermisomenuopcion='$idpermisomenuopcion' 
					AND idmenuopcion='".$opcionesmenu[$i][0]."'";
					$result = $db->GetRow($sql);
					if(count($result) == 0 ){
						//todo bien, no tiene el permiso
					} else {
						//desactivarla
						$sql = "UPDATE `detallepermisomenuopcion` SET `codigoestado`='200' WHERE 
						`iddetallepermisomenuopcion`='".$result["iddetallepermisomenuopcion"]."'";
						$result = $db->Execute($sql);
					}
                                        //echo $sql;
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
