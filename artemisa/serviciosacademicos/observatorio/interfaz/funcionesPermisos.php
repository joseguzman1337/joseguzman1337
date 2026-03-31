<?php
$permisos = new ObservatorioPermisos();
switch ($_REQUEST['action']) {
    case 'dataPermisosModulos':
        $db = $permisos->loadDB();
        $permisos->dataPermisosModulos($db);
        break;
    case 'guardarPermisosModulos':
        $db = $permisos->loadDB();
        $permisos->guardarPermisosModulos($db);
        break;
    case 'consultaPermisosActuales':
        $db = $permisos->loadDB();
        $permisos->consultaPermisosActuales($db);
        break;
	case 'AutocompleteRol':
		$db = $permisos->loadDB();
        $permisos->AutocompleteRol($db);
	break;
	case 'deletePermiso':
		$db = $permisos->loadDB();
		$permisos->deletePermiso($db);
	break;	
}

class ObservatorioPermisos {

    public function loadDB() {
        include('../templates/templateObservatorio.php');
        $db = writeHeaderBD();
        return $db;
    }

    public function dataModulos($db) {
        $SQL = 'SELECT a.id_categoriamodulo, a.categoria FROM obs_categoriamodulo a WHERE a.id_categoria=0 ;';
        if ($data = &$db->GetAll($SQL) === false) {
            echo 'Error en el SQL .....<br><br>';
            die;
        }
        return $data;
    }

    public function dataPermisosModulos($db){
        $idModulo = $_POST['dataModulos'];
		$idRol= $_POST['idRol'];
		 if(!is_numeric($idRol)) {
			 $SQL_rol = "SELECT idobs_rolusuario,obs_rol
			FROM obs_rolusuarios a 
			WHERE a.obs_rol= '".$idRol ."' 
			AND a.estado = 100";
			if ($rol = &$db->GetAll($SQL_rol) === false) {
				echo 'Error en el SQL .....<br><br>';
				die;
			}
			$idRol=$rol[0]['idobs_rolusuario'];
		 }
		 $SQL = "SELECT a.id_categoriamodulo, a.modulo 
			FROM obs_categoriamodulo a 
			WHERE a.id_categoria= '" . $idModulo . "' 
			AND a.idobs_rolusuario = '1'";
		
        if ($data = &$db->GetAll($SQL) === false) {
            echo 'Error en el SQL .....<br><br>';
            die;
        }
        $html = "<table border='2'><tr>";
		$i=0;
		
        foreach ($data as $dataModulo) {
			if(!empty($idRol)){
				$SqlPermiso="SELECT a.id_categoriamodulo, a.modulo
				FROM obs_categoriamodulo a
				WHERE a.idobs_rolusuario  = ".$idRol."
				AND a.modulo = '".$dataModulo['modulo']."'
				AND a.codigoestado=100
				AND a.id_categoria = '".$idModulo."'";	
				
				if ($dataPermiso = &$db->GetAll($SqlPermiso) === false) {
					echo 'Error en el SQL .....<br><br>';
					die;
				}
				if ($dataPermiso[0]['modulo'] !== $dataModulo['modulo']){
					
					if($i > 4){
						$html.="</tr><tr>";
						$i=0;
					}
					$html.= "<td><input type='checkbox' class='permiso' rel='" . $dataModulo['id_categoriamodulo'] . "'>" . $dataModulo['modulo'] . "</td>";
				}
			}else{
				$html.= "<td><input type='checkbox' class='permiso' rel='" . $dataModulo['id_categoriamodulo'] . "'>" . $dataModulo['modulo'] . "</td>";
			}
			$i=$i+1;
        }
        echo "</tr></table>" . $html;
    }

    public function guardarPermisosModulos($db) {
        $permisos = $_POST['permiso'];
        $idModulo = $_POST['dataModulos'];
        $nombreRol = $_POST['UsuarioData'];
        $idRol = $this->consultaRol($db, $nombreRol);
        if (empty($idRol)) {
            $this->insertRol($db, $nombreRol);
            $idRol = $this->consultaRol($db, $nombreRol);
        }
        /* Insertar permisos chequeados */
        foreach ($permisos as $dataPermiso) {
			/*Traer Url para realizar insert*/
             $SQL = "SELECT a.id_categoria,a.modulo,a.url 
					FROM obs_categoriamodulo a 
					WHERE a.id_categoriamodulo= '" . $dataPermiso . "' 
					AND a.idobs_rolusuario = 1;";
            if ($data = &$db->GetAll($SQL) === false) {
                echo 'Error en el SQL .....<br><br>';
                die;
            }
			
			/*Consultar datos antes de ingresar para evitar duplicidad de datos*/
			$consultaExiste=$this->ConsultarPermisosRegistrados($db,$idRol,$dataPermiso,$idModulo);
			
			if(empty($consultaExiste)){
				$insert = "INSERT INTO obs_categoriamodulo (id_categoria, modulo, url, userid, usuarioestado, ver, editar, eliminar, 
															crear, idobs_rolusuario, codigoestado) 
															VALUES (" . $idModulo . ", '" . $data[0][1] . "', 
															'" . $data[0][2] . "', 0, 0, 1, 1, 1, 1, " . $idRol . ", 100)"; 
				if ($Insert = $db->Execute($insert) === false) {
					echo 'Error en el SQL de INSERT';
					exit;
				}
			}else{
				$Sql_Rol = "UPDATE obs_categoriamodulo SET codigoestado = 100 WHERE id_categoriamodulo = '".$consultaExiste[0][2]."'";
				if ($update = $db->Execute($Sql_Rol) === false) {
					echo 'Error en el SQL de INSERT';
					exit;
				}
			}
        }
    }

    public function insertRol($db, $nombreRol) {
        $Sql_Rol = "INSERT INTO obs_rolusuarios(obs_rol,fecha_modificacion,estado) VALUES('" . $nombreRol . "',NOW(),100);";
        if ($Insert = $db->Execute($Sql_Rol) === false) {
            echo 'Error en el SQL de INSERT';
            exit;
        }
    }

    public function consultaRol($db, $nombreRol) {
        $SQL = "SELECT a.obs_rol,a.idobs_rolusuario FROM obs_rolusuarios a WHERE a.obs_rol= '" . $nombreRol . "' AND a.estado = 100 ";
        if ($data = &$db->GetAll($SQL) === false) {
            echo 'Error en el SQL .....<br><br>';
            die;
        }
        foreach ($data as $dataM) {
            $idRol = $dataM['idobs_rolusuario'];
        }
        return $idRol;
    }

    public function consultaPermisosActuales($db) {
        $nombreRol = $_POST['UsuarioData'];
		   if(is_numeric($nombreRol)) {
				  $SQL = "SELECT DISTINCT C.categoria, A.idobs_rolusuario, B.id_categoria
						FROM obs_rolusuarios A
						INNER JOIN obs_categoriamodulo B ON (A.idobs_rolusuario=B.idobs_rolusuario)
						INNER JOIN obs_categoriamodulo C ON (B.id_categoria = C.id_categoriamodulo)
						WHERE A.idobs_rolusuario = '" . $nombreRol . "' AND B.codigoestado = 100";
					
			} else {
					 $SQL = "SELECT DISTINCT C.categoria, A.idobs_rolusuario, B.id_categoria
						FROM obs_rolusuarios A
						INNER JOIN obs_categoriamodulo B ON (A.idobs_rolusuario=B.idobs_rolusuario)
						INNER JOIN obs_categoriamodulo C ON (B.id_categoria = C.id_categoriamodulo)
						WHERE A.obs_rol = '" . $nombreRol . "' AND B.codigoestado = 100"; 
			}
		if ($data = &$db->GetAll($SQL) === false) {
            echo 'Error en el SQL .....<br><br>';
            die;
        }
		$html = "<table border='2' align='center'><tr>";
        foreach ($data as $dataM) {
			$html.="<th><font color='Red'>Modulo: " . $dataM['categoria'] . "</font>";
			/*Consultar Permisos especificos*/
			$SQLpermisos = "SELECT A.modulo, A.id_categoriamodulo 
			FROM obs_categoriamodulo A WHERE A.id_categoria ='".$dataM['id_categoria']."' 
			AND idobs_rolusuario = '".$dataM['idobs_rolusuario']."' AND codigoestado = 100";
			if ($dataPermisos = &$db->GetAll($SQLpermisos) === false) {
				echo 'Error en el SQL .....<br><br>';
				die;
			}
			foreach($dataPermisos as $dataP){
				$html.= "<tr><td>" . $dataP['modulo'] . "</td><td><a class='delete' onclick='deletePermiso(".$dataP['id_categoriamodulo'].");' id='".$dataP['id_categoriamodulo']."' >Eliminar</a></td></tr>";	
			}
        }
		echo $html.="</tr></table>";
    }
	public function AutocompleteRol($db){
		$Letra   		= $_REQUEST['term'];
        
             $SQL_Buscar='SELECT
							idobs_rolusuario,
							obs_rol
                        FROM
							obs_rolusuarios
                        WHERE
                            obs_rol LIKE "%'.$Letra.'%"';
                        if($ResultUsuario=&$db->Execute($SQL_Buscar)===false){
                            $a_vectt['val']			='FALSE';
                            $a_vectt['descrip']		='Error en el SQL de Busqueda de Usuarios... ';
                            echo json_encode($a_vectt);
                            exit; 
                        }
                        $Result = array();
                        while(!$ResultUsuario->EOF){
                            /************************************/
                              $C_Result['label']                 = $ResultUsuario->fields['obs_rol'];
							  $C_Result['id_Usuario']            = $ResultUsuario->fields['idobs_rolusuario'];
                              array_push($Result,$C_Result);
                            /************************************/
                            $ResultUsuario->MoveNext();
                        }//while  
					if(empty($Result))	{
						
						echo '<script> $("#DIV_DataActuales").empty(); </script>'; 
					}else{
						echo json_encode($Result); 
					}
                        
             	
	}
	public function ConsultarPermisosRegistrados($db,$rol,$dataPermiso,$idModulo){
		 $SQL = "SELECT a.id_categoria,a.modulo 
						FROM obs_categoriamodulo a 
						WHERE a.id_categoriamodulo= '" . $dataPermiso . "'";
						
        if ($data = &$db->GetAll($SQL) === false) {
                echo 'Error en el SQL .....<br><br>';
                die;
        }
		  $SQLpermisoActual = "SELECT a.id_categoria,a.modulo , a.id_categoriamodulo
						FROM obs_categoriamodulo a 
						WHERE a.idobs_rolusuario= '" . $rol . "'
						AND a.id_categoria = '".$idModulo."'
						AND a.modulo='".$data[0][1]."'";
						
			
        if ($dataPermiso = &$db->GetAll($SQLpermisoActual) === false) {
                echo 'Error en el SQL .....<br><br>';
                die;
        }
		
		return $dataPermiso;
		
		
	}
	public function deletePermiso($db){
		$idPermiso=$_POST['idPermiso'];
		/*Consultar que el permiso que se quiere eliminar no corresponda al principla "1"*/
		$SQL = "SELECT idobs_rolusuario
						FROM obs_categoriamodulo 
						WHERE id_categoriamodulo = '".$idPermiso."'";
        if ($data = &$db->GetAll($SQL) === false) {
                echo 'Error en el SQL .....<br><br>';
                die;
        }
		if($data[0]['idobs_rolusuario'] === '1'){
			$Sql_Rol = "UPDATE obs_categoriamodulo SET codigoestado = 200 WHERE id_categoriamodulo = '".$idPermiso."'";
			if ($delete = $db->Execute($Sql_Rol) === false) {
				echo 'Error en el SQL de Delete';
				exit;
			}
		}else{
			$Sql_Rol = "DELETE FROM obs_categoriamodulo WHERE id_categoriamodulo = '".$idPermiso."'";
			if ($delete = $db->Execute($Sql_Rol) === false) {
				echo 'Error en el SQL de Delete';
				exit;
			}
		}
	}

}
?>