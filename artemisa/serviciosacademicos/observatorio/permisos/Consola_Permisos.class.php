<?php

class Permisos{
    public function Display(){
        
        global $userid, $db;
        
        ?>
        <style>
            fieldset{
                border:1px solid #C0C0C0;
            }
            .CargarButon{
                background:-moz-linear-gradient(#fc0 0%,#F60 100%);
                background:-ms-linear-gradient(#fc0 0%,#F60 100%);
                background:-o-linear-gradient(#fc0 0%,#F60 100%);
                background:-webkit-linear-gradient(#fc0 0%,#F60 100%);
                background:linear-gradient(#fc0 0%,#F60 100%);
                border:solid 1px #DEDEDE;
                border-radius:5px;
                text-align:center;
                padding:5px;
                color:#fff;
                width:150px;
            }
            .CargarButon:hover{
                background:-moz-linear-gradient(#fff 0%,#DEDEDE 100%);
                color:#999;
            }
			.delete {
				cursor: pointer;
				}

        </style>
        <div id="container">
            <fieldset>
                <legend>Asignar Roles por Usuario</legend>
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 100%;" >
                    <thead>
                        <tr>
                            <th>
                                <strong>Buscar Usuario</strong>
                            </th>
                        </tr>
                        <tr>
                            <th><input type="text" id="UsuarioData" name="UsuarioData" size="75" autocomplete="off" style="text-align: center;" placeholder="Digite Nombre , Usuario o Numero de Documento" onkeypress="AutocompleteUsuario()" onclick="Format()" /><input type="hidden" id="id_Usuario" name="id_Usuario" /></th>
                        </tr>
                        <tr id="Tr_Titulo" style="visibility: collapse;">
                            <th>Datos del Usuario</th>    
                        </tr>
                        <tr id="Tr_Detalle" style="visibility: collapse;">
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center"  style="width: 100%;" >
                                    <tr>
                                        <td><strong>Nombre:</strong></td>
                                        <td id="Td_Nombre"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Numero de Documento:</strong></td>
                                        <td id="Td_Documento"></td>
                                    </tr>    
                                        <td><strong>Usuario:</strong></td>
                                        <td id="Td_Usuario"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <th><input type="hidden" id="PermisosCargados" name="PermisosCargados" />
							<input type="hidden" id="idUsuarioSe" name="idUsuarioSe" value="<?php echo $userid ;?>"/>
                                <fieldset style="width:90%;margin: 1em auto;">
                                    <legend>Permisos Cargados</legend>
                                    <div id="DIV_DataPermisos">
                                        <br />
                                            <span style="color: silver;text-align: center;">No hay Informaci&oacute;n...</span>
                                        <br />
                                    </div>
                                </fieldset>
                            </th>
                        </tr>
						  <tr>
								<td style="text-align: right;" colspan="3">
									<input type="button" value="Adicionar Permiso" class="CargarButon" onclick="LoadPermiso()" title="Adicionar Permiso" />
								</td>
                            </tr>
                        <tr>
                            <th>
                                <hr style="width: 90%;margin: 1em auto;" />
                            </th>
                        </tr>
                    </tbody>
                </table>
           </fieldset>
        </div>        
        <?PHP
        
    }/*public function Display*/
    public function Modulos($id,$Op=''){
        
        global $userid, $db;
		$Data = $this->ConsultaModulos($id,$Op);
        if($Op==1 || $Op=='1'){
            
            return $Data;
            
            exit();
        }/*if*/
        
        ?>
        <select id="Modulo" name="Modulo" style="width: 90%;">
            <option value="-1"></option>
            <?PHP
            for($i=0;$i<count($Data);$i++){
                /********************************///
                ?>
                <option value="<?PHP echo $Data[$i]['id']?>"><?PHP echo $Data[$i]['modulo']?></option>
                <?PHP
                /********************************/
            }//for
            ?>
        </select>
        <?PHP
    }/*public function Modulos*/
    public function CargarPermisos($Cadena,$id_Usuario){
        
        global $userid,$db;
        
        $C_Cadena = explode('::',$Cadena);
        $Categorias = array();
        $Con = 1;
        for($i=1;$i<count($C_Cadena);$i++){
            /*******************************************/
            $C_Datos = explode('-',$C_Cadena[$i]);
            
            $Name  = $this->DataName($C_Datos[0]);
            
            $Entrada  = 1;
           
            if($i>1){
                
                for($j=1;$j<=$i && $Entrada==1;$j++){
                    
                    /**********************************/
                    
                    if($Name[0]==$Categorias[$j]['id']){
                        $Entrada = 0;
                       
                    }else{ 
                       $Entrada = 1;
                        
                     }
                    /**********************************/
                }//for
                
                if($Entrada==1){ 
                    $Con++;
                    $Categorias[$Con]['id']   = $Name[0];
                    $Categorias[$Con]['Name'] = $Name[1];
                    
                }
            }else{
                $Categorias[$i]['id']   = $Name[0];
                $Categorias[$i]['Name'] = $Name[1];
                
            }//if
            /*******************************************/
        }//for
        
       // echo '<pre>';print_r($Categorias);
        
        for($l=1;$l<=count($Categorias);$l++){
            
            for($i=1;$i<count($C_Cadena);$i++){
                
                $C_Datos = explode('-',$C_Cadena[$i]);
                
                if($Categorias[$l]['id']==$C_Datos[0]){
                    
                    $Data = $this->Modulos($C_Datos[1],1);
                    
                    $Modulo = $Data[0]['modulo'];
                    
                    $Categorias[$l]['Modulo'][]    = $Modulo;
                    $Categorias[$l]['Url'][]       = $Data[0]['url'];
                    $Categorias[$l]['Editar'][]    = $C_Datos[2];
                    $Categorias[$l]['Ver'][]       = $C_Datos[3]; 
                    $Categorias[$l]['Eliminar'][]  = $C_Datos[4]; 
                    $Categorias[$l]['Consultar'][] = $C_Datos[5];
                    $Categorias[$l]['Data'][]      = $C_Datos[0].'-'.$C_Datos[1].'-'.$C_Datos[2].'-'.$C_Datos[3].'-'.$C_Datos[4].'-'.$C_Datos[5];
                    
                }
                
            }//for
            
        }//for

		
		
			
		    $Rol = $this->Categorias();//echo '<pre>';print_r($Categorias);

			if($_POST['Rol']=='1'){
					 $SQL_RolUsu='SELECT idobs_rolusuario , U.obs_rol
							FROM obs_usuariosRolPermiso R
							INNER JOIN obs_rolusuarios U ON R.idobs_rol=U.idobs_rolusuario
							WHERE R.usuarioConPermiso ="'.$id_Usuario.'"
							AND R.codigoestado = 100';
					
				if($rolUsu=&$db->Execute($SQL_RolUsu)===false){
					echo 'Error en el SQL de las Categorias...<br><br>'.$SQL_RolUsu;
					die;
				 }
				 $usRol = $rolUsu->GetAll();
				 $rolV=$rolUsuario= $usRol[0][0];
			}else{
				$rolV =	$id_Usuario;
			}
			
			?>
			<fieldset style="width:90%;margin: 1em auto;">
			<legend>Roles Asignados : </legend>
			<?PHP 
			$html = "<table border='2' align='center'><tr>";
			$html.="<th><font color='Red'>ROLES </font>";
			foreach($usRol as $dataRol){
				$html.= "<tr><td>" . $dataRol['obs_rol'] . "</td><td><a class='delete' onclick='deletePermisoRol(".$dataRol['idobs_rolusuario'].")' id='".$dataRol['idobs_rolusuario']."' >Eliminar</a></td></tr>";				
				
			} echo $html.="</tr></table>";?></span></br>
            </fieldset>                         
			<fieldset style="width:90%;margin: 1em auto;"></br>
			<legend>Asignar Rol : </legend>
			<select id="Rol" name="Rol" style="width:auto" >
				<option value="-1"></option>
				<?PHP 
			
				for($i=0;$i<count($Rol);$i++){
					if($Rol[$i]['id'] === $rolV){
						$select='selected';
					}else{
						$select='';
					}
					?>
					<option value="<?PHP echo $Rol[$i]['id']?>" <?php echo $select;?>><?PHP echo $Rol[$i]['obs_rol']?></option>
					<?PHP
				}//for
				?>
			</select>
            </fieldset> 
		<?php
       
        
    }/*public function CargarPermisos*/
   public function esPar($numero){
    
    $resto = $numero%2;
    
       if (($resto==0) && ($numero!=0)) {
            return true;
       }else{
            return false;
       } 
   }//public function esPar
   public function Categorias(){
    
    global $userid,$db;
    
     $SQL_Categoria='SELECT 
                    idobs_rolusuario as id,
                    obs_rol
                    FROM 
                    obs_rolusuarios
                    WHERE
                    estado=100';
             if($Catergorias=&$db->Execute($SQL_Categoria)===false){
                echo 'Error en el SQL de las Categorias...<br><br>';
                die;
             }      

           $C_Categorias = $Catergorias->GetArray();
           
           Return $C_Categorias;   
    
   }/* public function Categorias*/
   public function ConsultaModulos($id,$op=''){
    
    global $userid,$db;
        
        if($op){
            $Condicion = 'id_categoriamodulo="'.$id.'"';
        }else{
            $Condicion = 'id_categoria="'.$id.'" ORDER BY modulo ASC';
         }
         
    
         $SQL_Modulo = 'SELECT 
                        id_categoriamodulo as id,
                        modulo,
                        url
                        FROM obs_categoriamodulo
                        WHERE
                        codigoestado=100
                        AND
                        '.$Condicion;
                        
        if($Modulo=&$db->Execute($SQL_Modulo)===false){
            echo 'Error en el SQL ...Modulos ....<br><br>';
            die;
        }//if  
        
        $C_Modulo = $Modulo->GetArray();
        
        return $C_Modulo;              
    
   }/*public function ConsultaModulos*/
   public function SelectPermisos($Usuario,$url){
    
    global $userid,$db;
    
      $SQL='SELECT 
            
            idobs_usuarios_roles as id,
            ver,
            editar,
            eliminar,
            consultar,
            codigoestado
            
            FROM obs_usuarios_roles 
            
            WHERE
            
            usuariopermiso="'.$Usuario.'"
            AND
            url="'.$url.'"';
            
           if($SelectPermiso=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Select de los Permisos';
            die;
           } 
           
           $C_Data = array();
           
           if(!$SelectPermiso->EOF){
                
                $C_Data['Val'] = true;
                $C_Data['Data'] = $Permiso = $SelectPermiso->GetArray();
                
                return $C_Data;
           }else{
            
                $C_Data['Val'] = false;
                $C_Data['Data'] = $Permiso = $SelectPermiso->GetArray();
                
                return $C_Data;
           }
           
     
   }/*public function SelectPermisos*/
   public function InsertPermiso($Data,$url,$Usuario){
    
    global $userid,$db;
    
    $C_Data = explode('-',$Data);
    
    /*
    [0] => 1  ->Categoria
    [1] => 10 ->Modulo
    [2] => 0  ->Editar
    [3] => 0  ->Ver  
    [4] => 0  ->Eliminar
    [5] => 1  ->Consultar
    */
    
    $SQL='INSERT INTO obs_usuarios_roles(url,usuariopermiso,ver,editar,eliminar,consultar,entrydate,userid)VALUES("'.$url.'","'.$Usuario.'","'.$C_Data[3].'","'.$C_Data[2].'","'.$C_Data[4].'","'.$C_Data[5].'",NOW(),"'.$userid.'")';
    
        if($Insert=&$db->Execute($SQL)===false){
            echo 'Error en El Insert del Permiso al Usuario del Observatorio...<br><br>';
            die;
        }
    
   }/*public function InsertPermiso*/
   public function UpdatePermiso($id,$Data){
    
    global $userid,$db;
    
    $C_Data = explode('-',$Data);
    
    /*
    [0] => 1  ->Categoria
    [1] => 10 ->Modulo
    [2] => 0  ->Editar
    [3] => 0  ->Ver  
    [4] => 0  ->Eliminar
    [5] => 1  ->Consultar
    */
    
    $SQL='UPDATE obs_usuarios_roles
          
          SET    codigoestado=100,
                 ver="'.$C_Data[3].'",
                 editar="'.$C_Data[2].'",
                 eliminar="'.$C_Data[4].'",
                 consultar="'.$C_Data[5].'",
                 changedate=NOW(),
                 useridestado="'.$userid.'"
         
          WHERE
                 idobs_usuarios_roles="'.$id.'"';
                 
         if($Update=&$db->Execute($SQL)===false){
            echo 'Error en el Update de los permisos...<br><br>';
            die;
         }//if        
    
   }/*public function UpdatePermiso*/
   public function DataName($id){
    global $db;
        /**********************************************/
          $SQL='SELECT 

                categoria
                
                FROM obs_categoriamodulo
                
                WHERE
                
                id_categoriamodulo="'.$id.'"';
                
          if($NameCategoria=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Nombres de Categoria....<br><br>';
                die;
          }
          $Data = array();
          $Data[0] = $id;
          $Data[1] = $NameCategoria->fields['categoria'];
          
          return $Data;
        /**********************************************/
   }//public function DataName
}//class Permisos

?>