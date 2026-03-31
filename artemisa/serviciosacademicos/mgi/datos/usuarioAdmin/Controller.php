<?php 
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
	session_start();
	if(empty($_SESSION['MM_Username'])){
		echo "No ha iniciado sesión en el sistema";
		exit();
	}else{
		include("classValida.php");
		require_once("../templates/template.php");		
		$db = getBD();
		$main=new Controller();
		$main->main($db);	
	}

class Controller{
	public function main($db){
		switch($_REQUEST['action']){
			case 'guardarNew':
				$this->guardarNew($db);
			break;
			case 'busacarUsuario':
				$this->busacarUsuario($db);
			break;
			case 'guardarEdit':
				$this->guardarEdit($db);
			break;
			case 'consultaRol':
				$this->consultaRol($db);
			break;
			case 'autocomplete':
				$this->autocompletar($db);
			break;
		}
		
	}
	public function busacarUsuario($db){
		$documento = $_POST['documento'];
		$valida = new Valida();
		$valida->validaVacio($documento);
		$valida->comprobar_nombre_usuario($documento);
		$valida->comprobarLargo($documento);
		$Sql = "SELECT usuario,numerodocumento,apellidos,nombres,codigoestadousuario, codigorol,
				DATE_FORMAT(fechavencimientousuario,'%Y-%m-%d') as fechavencimientousuario ,codigotipousuario
				FROM usuario 
				WHERE usuario = '".$documento."'";
		if($data=&$db->GetAll($Sql) === false){
			echo 'Ocurrio un error al consultar la data';
			die;
		}
		
		 $SqlRolAdmin = "SELECT UR.idrol, U.usuario FROM usuariorol UR INNER JOIN UsuarioTipo UT ON (UR.idusuariotipo = UT.UsuarioTipoId) INNER JOIN usuario U ON  (UT.UsuarioId = U.idusuario) WHERE U.usuario ='".$documento."'";        
		if($dataRolAdmin=&$db->GetAll($SqlRolAdmin) === false){
			echo 'Ocurrio un error al consultar la data';
			die;
		}
	    $rolAdmin=$dataRolAdmin[0][0];
		
		$SqlRol = "SELECT idrol ,nombrerol
				FROM rol 
				WHERE codigoestadorol = '100'";
		if($dataRol=&$db->GetAll($SqlRol) === false){
			echo 'Ocurrio un error al consultar la data';
			die;
		}
		$html=null;
		$select=null;
		if(!empty($data)){
			$html.="<table >";
			foreach($data as $datos){ 
				if($datos['codigoestadousuario'] === '100'){
					$select.= "<option value='100' selected>Activo</option>
							<option value='200'>Inactivo</option>";
				}else{
					$select.="<option value='100'>Activo</option>
							<option value='200' selected>Inactivo</option>";
				}
				$fechaVencimiento=$datos['fechavencimientousuario'];
				if(!empty($fechaVencimiento)){
					if($datos['codigoestadousuario'] === '200'){
						//$fechaV="<tr><td>Fecha Vencimiento<span  style='color:#F71D1D'>*</span></td><td><input type='text' name='fechavencimientousuario' id='fechavencimientousuario' size='35' value='".$fechaVencimiento."'/></td></tr>";
					}
					
				}
				/* pintar roles y seleccionar actual*/
				foreach($dataRol as $datosRol){
					$datosdocumento = "<tr><td>Documento<span  style='color:#F71D1D'>*</span></td><td><input type='text' name='numerodocumento' id='numerodocumento' size='35' value='".$datos['numerodocumento']."'/></td></tr>";
					if(empty($rolAdmin)){		
						if($datosRol['idrol'] == $datos['codigorol']){
							$selectRol.="<option value='".$datosRol['idrol']."' selected>".$datosRol['nombrerol']."</option>";
						}else{
							$selectRol.="<option value='".$datosRol['idrol']."' >".$datosRol['nombrerol']."</option>";
						}
					}else{
						if($datosRol['idrol'] == $rolAdmin){
							$selectRol.="<option value='".$datosRol['idrol']."' selected>".$datosRol['nombrerol']."</option>";
						}else{
							$selectRol.="<option value='".$datosRol['idrol']."' >".$datosRol['nombrerol']."</option>";
						}
					}	
					
				}
				$html.= $fechaV."<tr><td>Usuario<span  style='color:#F71D1D'>*</span></td><td><input type='text' name='usuarioE' id='usuarioE' size='35' value='".$datos['usuario']."'/></td></tr>
						<tr><td>Nombre<span  style='color:#F71D1D'>*</span></td><td><input type='text' name='nombres' id='nombres' size='35' value='".$datos['nombres']."'/></td></tr>
						<tr><td>Apellido<span  style='color:#F71D1D'>*</span></td><td><input type='text' name='apellidos' id='apellidos' size='35' value='".$datos['apellidos']."'/></td></tr>												
						".$datosdocumento." 
						<tr><td>Estado<span  style='color:#F71D1D'>*</span></td><td>
						<select name='codigoestadousuario' id='codigoestadousuario'>
						<option></option>"
							.$select."
						</select>
						</td>
						<tr>
						<td>Rol</td>
							<td>
								<select name='rolD' id='rolD'>
								<option></option>"
									.$selectRol."
								</select>
							</td>
						</tr>
						</tr><input type='hidden' name='tipoUsuario' id='tipoUsuario' size='35' value='".$datos['codigotipousuario']."'/>";
						
			}
			$html .= "</table>";
			echo "<input type='hidden' name='fechavencimientousuario2' id='fechavencimientousuario2' size='35' value='".$fechaVencimiento."'/>";
			
			echo ($html); exit();
			
		}
		else
		{
			echo $html= "1";
		}
	}
	public function guardarEdit($db){
		$nombre    = $_POST['nombre'];
		$apellido  = $_POST['apellido'];
		$usuario   = $_POST['usuario'];
		$codigoestadousuario       = $_POST['codigoestadousuario'];
		$documento   = $_POST['documento'];
		$fechavencimientousuario = $_POST['fechavencimientousuario'];
		$tipoUsuario = $_POST['tipoUsuario'];
		$numerodocumento = $_POST['numerodocumento'];
		$rol = $_POST['rol'];
		$valida = new Valida();
		$valida->validaVacio($nombre);
		$valida->comprobarLargo($nombre);
		$valida->validarString($nombre);
		$valida->validaVacio($apellido);
		$valida->comprobarLargo($apellido);
		$valida->validarString($apellido);		
		$valida->validaVacio($usuario);
		$valida->esNumerico($codigoestadousuario);
                
                /**
                 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Se comenta la validacion de numero de documento para que quede alfanumerico
                 * valida->esNumerico($numerodocumento); 
                 * @since Enero 23, 2019
                 */ 
		if($valida->validaFormato($fechavencimientousuario)===false){
			echo '<script>alert("El formato de fecha no es correcto");</script>';
			die;
		}
		$valida->validaFecha($fechavencimientousuario);
		$valida->comprobarLargo($fechavencimientousuario);
		/* SQL update usuario*/ 
		$updateDocumento = "";
		if($tipoUsuario == '400'){
            
            //consulta del idusuario de la tabla usuario 
            $sqlIdusuario = "select idusuario from usuario where usuario = '".$usuario."'";
            $idusuario = $db->GetRow($sqlIdusuario);
            //actualizacion de los datos de la tabla usuariorol agregando idusuario, idrol, usuario 
            $sqlUpdateRol = "UPDATE usuariorol UR SET UR.idrol = '".$rol."', UR.codigoestado = '100'
                            WHERE
                            UR.idusuariotipo = ( SELECT UT.UsuarioTipoID
                                FROM
                                    UsuarioTipo UT
                                WHERE
                                    UT.CodigoTipoUsuario = '400'
                                AND UT.UsuarioId = '".$idusuario["idusuario"]."') ";            
			$updateDocumento = "numerodocumento = '".$numerodocumento."',";
			
			if ($update = $db->Execute($sqlUpdateRol) === false) {
				echo 'Error en el SQL al editar';
				exit;
			}
		}//if

			$sqlUpdate = "UPDATE usuario 
			SET usuario = '".$usuario."',							
				apellidos = '".$apellido."',
				nombres = '".$nombre."',
				codigoestadousuario = '".$codigoestadousuario."',
				".$updateDocumento." 
				fechavencimientousuario = '".$fechavencimientousuario."'
			WHERE usuario = '".$documento."' ";
		 if ($update = $db->Execute($sqlUpdate) === false) {
			echo 'Error en el SQL al editar';
			exit;
		}else{
			echo '<script>alert("Datos Actualizados Exitosamente");</script>';
			exit();
		}
	}
	public function guardarNew($db){
		$nombre    = $_POST['nombre'];
		$apellido  = $_POST['apellido'];
		$usuario   = $_POST['usuario'];
		$rol       = $_POST['rol'];
		$documento = $_POST['documento'];
		$tipoUsuario= $_POST['tipoUsuario'];
		$valida = new Valida();
		$valida->esNumerico($documento);
		$valida->validaVacio($documento);
		$valida->comprobarLargo($documento);
		$valida->comprobar_nombre_usuario($usuario);
		$valida->comprobarLargo($usuario);
		$valida->validarString($nombre);
		$valida->comprobarLargo($nombre);
		$valida->validaVacio($nombre);
		$valida->validarString($apellido);
		$valida->comprobarLargo($apellido);
		$valida->validaVacio($apellido);
		if(($tipoUsuario !== '500')&&($tipoUsuario !== '600')){
			if($rol << 0 ){
				$valida->validaVacio($rol);
			}
			
		}
		
		if($tipoUsuario !== '600'){
			if($tipoUsuario !=='500'){
				$tipoUsuario = '400';
				$rolUsu	= 3;
			}else{
				$rolUsu	= 2;
			}
		}else{
			$rolUsu	= 1;
		}
		
		/* Consultar si existe el usuario*/
		if(empty($data)){
			$Sql = "SELECT usuario
				FROM usuario 
				WHERE usuario = '".$usuario."' ";
			if($data=&$db->GetAll($Sql) === false){
				echo 'Ocurrio un error al consultar la data';
				die;
			}
			if(!empty($data)){
				echo '<script>alert("No fue posible guardar los cambios. El usuario digitado ya existe");</script>';
				exit;
			}
		}
		/*fin consultar si existe*/
		if(empty($data)){
			$sqlInsert = "INSERT INTO usuario (usuario,numerodocumento,tipodocumento,apellidos,nombres,codigorol,fechainiciousuario,
									 fechavencimientousuario,fecharegistrousuario,codigotipousuario,idusuariopadre,codigoestadousuario)  
									 VALUES ('".$usuario."','".$documento."','01','".$apellido."','".$nombre."','".$rolUsu."','".date("Y-m-d H:i:s")."',
									 '2999-12-31 00:00:00','".date("Y-m-d H:i:s")."','".$tipoUsuario."','0','100')";
		
			 if ($insert = $db->Execute($sqlInsert) === false) {
				echo 'Error en el SQL de insert'.$sqlInsert;
				exit;
			}
			else
			{                
				if($tipoUsuario === '400')
                {    
                     //consulta del idusuario de la tabla usuario 
                    $sqlIdusuario = "select idusuario from usuario where usuario = '".$usuario."'";
                    $idusuario = $db->GetRow($sqlIdusuario);
                    
                    $sqlconsultausuariotipo = "select UsuarioTipoId from UsuarioTipo where UsuarioId = '".$idusuario["idusuario"]."'";
                    $consultausuariotipo = $db->GetRow($sqlIdusuario);
                    
                    if(!$consultausuariotipo['UsuarioTipoId'])
                    {
                        /*Insert para usuario administrativo*/
                        $sqlUsuarioTipo = "insert into UsuarioTipo (CodigoTipoUsuario, UsuarioId, CodigoEstado) value ('".$tipoUsuario."', '".$idusuario['idusuario']."', '100' );";
                        $insertar = $db->Execute($sqlUsuarioTipo);
                        
                        $ConsultaUsuarioTipo = "Select UsuarioTipoId from UsuarioTipo where UsuarioId='".$idusuario['idusuario']."' and CodigoTipoUsuario ='".$tipoUsuario."' and CodigoEstado ='100'";
                        $consultaid = $db->GetRow($ConsultaUsuarioTipo);
                        
                        $sqlInserttiporol= "INSERT INTO usuariorol (idrol,idusuariotipo, codigoestado) VALUES ('".$rol."','".$consultaid["UsuarioTipoId"]."', '100')";
                        if ($insertRol = $db->Execute($sqlInserttiporol) === false) 
                        {
						  echo 'Error en el SQL de insertRol';
						  exit;
					    }else
                        {
                            echo '<script>alert("Datos Guardados Exitosamente");</script>';
						    exit();
                        }
                    }  		
				}//if 400
                if($tipoUsuario === '500'){
					/*Insert para usuario docente*/
					/* Consultar id Usuario*/
					$Sql = "SELECT idusuario FROM usuario WHERE numerodocumento = '".$documento."'";
					if($data=&$db->GetAll($Sql) === false){
						echo 'Ocurrio un error al consultar la data';
						die;
					}
					$idUsuario=$data[0][0];
					$sqlInsertRol = "INSERT INTO permisousuariomenuopcion (idpermisomenuopcion,idusuario,codigoestado) VALUES ('251','".$idUsuario."','100')";
												
					 if ($insertRol = $db->Execute($sqlInsertRol) === false) {
						echo 'Error en el SQL de insertPermiso';
						exit;
					}else{
                         
                        $sqlIdusuario = "select idusuario from usuario where usuario = '".$usuario."'";
                        $idusuario = $db->GetRow($sqlIdusuario); 
                         
                        $sqlUsuarioTipo = "insert into UsuarioTipo (CodigoTipoUsuario, UsuarioId, CodigoEstado) value ('".$tipoUsuario."', '".$idusuario['idusuario']."', '100' );";
                        $insertar = $db->Execute($sqlUsuarioTipo);
                         
                        //se agrega esta seccion de codigo para registrar el usuariotipo en la tabla usuariorol. 
                        $ConsultaUsuarioTipo = "Select UsuarioTipoId from UsuarioTipo where UsuarioId='".$idusuario['idusuario']."' and CodigoTipoUsuario ='".$tipoUsuario."' and CodigoEstado ='100'";
                        $consultaid = $db->GetRow($ConsultaUsuarioTipo);
                        
                         //se registra el usuario rol docente
                        $sqlInsertRoles = "INSERT INTO usuariorol (idrol,idusuariotipo, codigoestado) VALUES ('2','".$consultaid["UsuarioTipoId"]."', '100')";
                        if ($insertUsuariorol = $db->Execute($sqlInsertRoles) === false) 
                        {
				            echo 'Error en el SQL de insertRol';
				            exit;
					    }else
                        {
                            echo '<script>alert("Datos Guardados Exitosamente");</script>';
						    exit();
                        }  
					}
				}//if 500				
				if($rolUsu	=== 1){
                        
                    //Si el usuario es estudiante 
                    $sqlIdusuario = "select idusuario from usuario where usuario = '".$usuario."'";
                    $idusuario = $db->GetRow($sqlIdusuario);

                    $sqlUsuarioTipo = "insert into UsuarioTipo (CodigoTipoUsuario, UsuarioId, CodigoEstado) value ('".$tipoUsuario."', '".$idusuario['idusuario']."', '100' );";
                    $insertar = $db->Execute($sqlUsuarioTipo);

                    //se agrega esta seccion de codigo para registrar el usuariotipo en la tabla usuariorol. 
                    $ConsultaUsuarioTipo = "Select UsuarioTipoId from UsuarioTipo where UsuarioId='".$idusuario['idusuario']."' and CodigoTipoUsuario ='".$tipoUsuario."' and CodigoEstado ='100'";
                    $consultaid = $db->GetRow($ConsultaUsuarioTipo);

                     //se registra el usuario rol estudiante
                    $sqlInsertRoles = "INSERT INTO usuariorol (idrol,idusuariotipo, codigoestado) VALUES ('1','".$consultaid["UsuarioTipoId"]."', '100')";
                    if ($insertUsuariorol = $db->Execute($sqlInsertRoles) === false) 
                    {
                        echo 'Error en el SQL de insertRol';
                        exit;
                    }else
                    {
                        echo '<script>alert("Datos Guardados Exitosamente");</script>';
                        exit();
                    }
				}
			}
		}//fin vacio
		else{
			echo '<script>alert("No fue posible almacenar el usuario. El documento digitado ya tiene asociado un usuario");</script>';
			exit();
		}
	}
	public function consultaRol($db){
		
		  $Sql = "SELECT idrol,nombrerol
				FROM rol 
				WHERE codigoestadorol = '100'";
		if($data=&$db->GetAll($Sql) === false){
			echo 'Ocurrio un error al consultar la data';
			die;
		}
		$html=null;
		if(!empty($data)){
			
			$html="<select name='rol' id='rol' ><option value=''></option>";
					
			foreach($data as $datos){
				$html.= "<option value='".$datos['idrol']."'>".$datos['nombrerol']."</option>";
			}
			$html .= "</select>";
			echo ($html);exit();
		}
		else
		{
			echo $html= "1";exit();
		}
	}
	public function autocompletar($db)	{
		
		$Letra   		= $_REQUEST['term'];
			
				 $SQL_Buscar="SELECT
					idusuario,
					usuario
				FROM
					usuario
				WHERE
					usuario LIKE '%".$Letra."%'";
				
				if($ResultUsuario=&$db->Execute($SQL_Buscar)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error en el SQL de Busqueda de Usuarios... '.$SQL_Buscar;
					echo json_encode($a_vectt);
					exit; 
				}
				$Result = array();
				
				while(!$ResultUsuario->EOF){
					/************************************/
					  $C_Result['label']                 = $ResultUsuario->fields['usuario'];
					  $C_Result['	']            = $ResultUsuario->fields['idusuario'];
					  array_push($Result,$C_Result);
					/************************************/
					$ResultUsuario->MoveNext();
				}//while  
				
			if(empty($Result))	{
				
				echo '<script> $("#DIV_DataActuales").empty(); </script>';exit();
			}else{
				echo json_encode($Result); exit();
			}
	}

}

?>