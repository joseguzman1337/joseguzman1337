<?php
/*
*@david perez <perezdavid@unbosque.edu.co>
*@copyright Universidad el Bosque - Dirección de Tecnología
*@Ultima modificación: Agosto 09, 2017
*/
global $db;
//require ('/var/www/html/proyecto/kint/Kint.class.php');
include_once(realpath(dirname(__FILE__)).'/../../../mgi/autoevaluacion/interfaz/EntradaRedireccion_Class.php'); 
include_once(realpath(dirname(__FILE__)).'/../../../ReportesAuditoria/templates/mainjson.php');
include_once(realpath(dirname(__FILE__)).'/../../../utilidades/DiasHorasAmdin.php'); 
include_once('../../sala/lib/Factory.php');
                         
class autenticacion{
    var $conexion;
    var $usuario;
    var $password;
    var $fechahoy;
    var $permisoAutenticar=false;
    var $politicaCantidadDiasCaducidad;
    var $politicaCantidadIntentosAcceso;
    var $autenticacionAutorizada=false;
    var $mensajeUsuario;
    var $arrayClavesUsuario;
    var $arrayDatosUsuario;
    var $urlRedireccionamiento;
    var $frameRedireccionamiento;
    var $arrayCarrerasUsuario;
    var $claveViva;
    var $ip;
    var $modoRespuestaAutenticacion;
    var $ArrayContadorIntentosAccesoFallidos;
    var $autenticarSegundaClave;
    var $passwordPlano;
    var $usuariocreado;
    var $existesegundaclave;
    var $contenidofail=0;
    var $avanzaAPISegundaClave=false;
    var $respuestaApp;
    var $AccesoSistema;
    private  $aut = '';
    
    public function getAut() {
        return $this->aut;
    }

    public function setAut($aut) {
        $this->aut = $aut;
    }

        
    function autenticacion(&$conexion,$usuario,$password,$autenticarsegundaclave,$modoRespuestaAutenticacion='XML',$app=false,$acceso=0){
        $this->modoRespuestaAutenticacion=$modoRespuestaAutenticacion;
        $this->conexion=$conexion;
        $this->fechahoy=date("Y-m-d H:i:s");
        $this->usuario=$usuario;
        $this->passwordPlano=$password;
        $this->password=hash('sha256',$password);
        $this->passwordPlano=$password;
        $this->ip=$this->tomarip();
        $this->AccesoSistema=$acceso;
        if(!empty($usuario) and !empty($password)){
            //echo 'eso es un ifi'; die;
            $this->autenticarSegundaClave = $autenticarsegundaclave;
            $this->existesegundaclave = $autenticarsegundaclave;
            
            $usuarioBDValido = $this->validarUsuarioBD($this->usuario);//validacion del usuario
            $_SESSION['MM_Username'] = $this->usuario;
            $_SESSION['key']=$this->password;
            if($this->usuarioValido($this->ip, $this->usuario)){//Si el Usuario es Valido
                if($usuarioBDValido==true){
                    //validación temporar para obligar cambio de clave en sala a ciertos usuarios
                    $this->leerPoliticaClave();
                    $this->ArrayContadorIntentosAccesoFallidos=$this->leeContadorIntentosAccesoFallidos();
                    $requiereCambioClave=$this->revisarSiRequiereCambioClave($this->usuario);
                    $this->defineAutenticacion($requiereCambioClave);
                    
                    $this->respuestaApp=$this->autenticacionAutorizada;//cambio para cargar archivo
                    
                    if($this->autenticacionAutorizada==true){
                        $this->autenticar();
                    }
                    //validacion de multiples usuarios
                    $this->arrayDatosUsuario["rolesmuliple"]= $this->Validarusuariosmultiples($this->usuario);
                    $_SESSION["rolesmuliple"]= $this->Validarusuariosmultiples($this->usuario);
                }else{
                    $correoValido=$this->validarCorreo($this->usuario,$this->passwordPlano);
                    
                    if($correoValido==true){
                        if($this->usuariocreado){
                            $this->mensajeUsuario="Su usario se encuentra deshabilitado en SALA, por favor comuniquese con la mesa de servicio";
                            $this->respuestaApp=false;
                            $this->autenticacionAutorizada=false;
                        }elseif($app){
                            $this->mensajeUsuario="Bienvenido.....";
                            $this->arrayDatosUsuario['idusuario']=$app;
                            $this->arrayDatosUsuario['usuario']=$usuario;
                            $this->registraLogActividadUsuario();
                            $this->respuestaApp=true;
                            $this->autenticacionAutorizada=true;
                        }else{
                            $this->mensajeUsuario="Usted aún no está registrado o su usario se encuentra deshabilitado en SALA, por favor comuniquese con la mesa de servicio";
                            //$this->urlRedireccionamiento='../userAjax.php';
                            $this->autenticacionAutorizada=false;
                            $this->respuestaApp=false;
                        }
                    }else{
                        $this->autenticacionAutorizada=false;
                        $this->mensajeUsuario="Error, usuario no tiene cuenta de correo electrónico";
                        $this->respuestaApp=false;
                    }//else
                }//else
            }else{
                $this->autenticacionAutorizada=false;
                $this->mensajeUsuario="Error, usuario no tiene acceso desde la ip ".$this->ip;
                $this->respuestaApp=false;
            }
        }else{
            $this->autenticacionAutorizada=false;
            $this->mensajeUsuario="Por favor digite usuario y clave";
            $this->respuestaApp=false;
        }
        
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se agrega validacion de modo que cuando el login sea exitoso y no exista un periodo activo, se seleccione
         * el periodo en inscripción o en su defecto el ultimo periodo creado (esto solo debe pasar durante el proceso de cierre 
         * y apertura de periodos realizado por registro y control
         * @since Diciembre 19, 2018
         */
        if($this->autenticacionAutorizada === true){
            if(empty($_SESSION['codigoperiodosesion'])){
                $query = "SELECT codigoperiodo "
                        . " FROM periodo "
                        . " WHERE codigoestadoperiodo = 4 ";
                $db = Factory::createDbo();
                $row = $db->GetRow($query);
                if(!empty($row) && !empty($row['codigoperiodo'])){
                    Factory::setSessionVar("codigoperiodosesion", $row['codigoperiodo']);
                    Factory::setSessionVar("codigoestadoperiodosesion", 4);
                }else{
                    $query = "SELECT MAX(codigoperiodo) codigoperiodo, codigoestadoperiodo  "
                            . " FROM periodo "; 
                    $row = $db->GetRow($query);
                    Factory::setSessionVar("codigoperiodosesion", $row['codigoperiodo']);
                    Factory::setSessionVar("codigoestadoperiodosesion", $row['codigoestadoperiodo']);
                }
            }
        }
        
        /**
         * @modified Andres Ariza <emailautor@unbosque.edu.do>
         * Cuando la peticion se hace a travez de json se agrega una nueva funcion para generar respuesta json
         * @since enero 20, 2018
        */
        if($this->modoRespuestaAutenticacion=='XML'){
            $this->generaXML();
        }elseif($this->modoRespuestaAutenticacion=='json'){
            $array = $this->generaJson();
            echo json_encode($array);
        }else{
            $this->generaArrayAutenticacion();
        }
    }//function autenticacion
    
    function activaAutenticarSegundaClave(){
        $this->autenticarSegundaClave=true;
    }
    
    function autenticar(){
        $this->registraVariablesSesionInicio();
        /*
         * Cambiar 'Autenticado correctamente' por 'Bienvenido'
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Modificado 15 de junio de 2017.
         */
        $this->mensajeUsuario="Bienvenido";
        //end
        $this->cargaVariables();
        $this->registraLogActividadUsuario();
        $this->validaPoliticasAcceso();
    }//function autenticar
    
    function validaPoliticasAcceso(){
        $query1="select idpoliticasacceso,urlpoliticasacceso
            from politicasacceso 
            where codigoestadopoliticasacceso='100'
            order by fechafinpoliticasacceso 
            limit 1";
        
        $operacion=$this->conexion->query($query1);
        $rowOperacion=$operacion->fetchRow();
        $idpoliticas=$rowOperacion['idpoliticasacceso'];
        $urlpoliticas=$rowOperacion['urlpoliticasacceso'];
        
        $query2="select *
            from politicasaccesodetalle
            where idusuario=".$this->arrayDatosUsuario['idusuario']." and idpoliticasacceso=$idpoliticas and aceptanoaceptapoliticasaccesodetalle";
        
        $operacion2=$this->conexion->query($query2);
        $numRowsOperacion=$operacion2->numRows();
        $urldespuesaceptarpoliticas=$this->urlRedireccionamiento;
        
        if($numRowsOperacion == 0) {
            $this->urlRedireccionamiento="../facultades/politicasacceso/index.php?parametros=$urlpoliticas|$idpoliticas|".$this->arrayDatosUsuario['idusuario']."|".$this->arrayDatosUsuario['apellidos']."|".$this->arrayDatosUsuario['nombres']."|".$urldespuesaceptarpoliticas;
        }
    }//validaPoliticasAcceso
    
    function verificaPasswd(){
        if($this->password==$this->arrayClavesUsuario[0]['claveusuario']){
            return true;
        }else{
            return false;
        }
    }//function verificaPasswd
    
    function verificarSiClaveCorreoHaCambiado($password){
        if($this->arrayClavesUsuario[0]['codigoestado']==200 and $this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==200){
            if($this->password==$this->arrayClavesUsuario[0]['claveusuario']){
                return false;
                //no ha cambiado la clave
            }else{
                //ya cambio la clave
                $this->mensajeUsuario="Su cambio de clave ha sido exitoso, por favor intente de nuevo";
                return true;
            }
        }
    }
    
    function caducarUltimoRegistroClave($idusuario){
        if($this->arrayClavesUsuario[0]['codigoestado']<>200 and $this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']<>200){
            $query="UPDATE claveusuario SET codigoestado='200',codigoindicadorclaveusuario='200', fechavenceclaveusuario='$this->fechahoy'
                WHERE idusuario='$idusuario' and idclaveusuario='".$this->arrayClavesUsuario[0]['idclaveusuario']."'";
            
            $operacion=$this->conexion->query($query);
            if($operacion){
                return true;
            }
        }else{
            return false;
        }
    }
    
    function revisarSiRequiereCambioClave($usuario){
        $queryUser = "SELECT tp.nombremenuopcion, tp.idusuario, tp.usuario, tp.verificacion, tp.fecha_cambio_clave FROM tmp_usuario2 tp WHERE tp.usuario = '".$usuario."' and tp.verificacion IS NULL";
        $operacion=$this->conexion->query($queryUser);
        $numRowsOperacion=$operacion->numRows();
        if($numRowsOperacion == 1){
            $rowOperacion=$operacion->fetchRow();
            $requiereCambioClave = true;
            $this->aumentaContadorIntentosAccesoFallidos(($this->politicaCantidadIntentosAcceso+1));
            $this->ArrayContadorIntentosAccesoFallidos=$this->leeContadorIntentosAccesoFallidos();
        }else{
            $requiereCambioClave = false;
        }
        
        return $requiereCambioClave;
    }//function revisarSiRequiereCambioClave
    
    function validarCorreo($usuario,$password){
        $objetoldap=new claseldap(SERVIDORLDAP,CLAVELDAP,PUERTOLDAP,CADENAADMINLDAP,"",RAIZDIRECTORIO);
        $objetoldap->ConexionAdmin();
        if($objetoldap->Autentificar($usuario,$password)){
            $objetoldap->Cerrar();
            return true;
        }else{
            $objetoldap->Cerrar();
            return false;
        }
        $objetoldap->Cerrar();
        return true;
    }


    /**
    *	Esta función valida si el usuario tiene acceso válido por IP, si en la tabla hay un campo de Ip el usuario
    *	debe ingresar desde esta ip, si el campo ip está en blanco permite ingresar desde cualquier lado
    **/
    function usuarioValido($ip, $usuario){
        $user = (get_magic_quotes_gpc()) ? $usuario : addslashes($usuario);
        $uservalido = false;
        
        $queryUser = "SELECT u.*, d.nombrecortodocumento
            FROM usuario u
            INNER JOIN documento d ON d.tipodocumento = u.tipodocumento
            WHERE u.usuario = '".$user."'
                AND (
                    NOW() BETWEEN u.fechainiciousuario
                    AND u.fechavencimientousuario
                )
                AND u.codigoestadousuario LIKE '1%'";
        //d($queryUser);
        $operacion=$this->conexion->query($queryUser);
        $numRowsOperacion=$operacion->numRows();
        if($numRowsOperacion == 1) {
            $rowOperacion=$operacion->fetchRow();
            $this->arrayDatosUsuario=$rowOperacion;
            $uservalido = true;
        }
        
        $queryUser = sprintf("SELECT ipaccesousuario FROM usuario WHERE usuario = '%s'", $user);
        $operacion=$this->conexion->query($queryUser);
        $numRowsOperacion=$operacion->numRows();
        
        $rowOperacion=$operacion->fetchRow();
        if($rowOperacion['ipaccesousuario'] == ''){
            $uservalido = true;
        }elseif($ip == $rowOperacion['ipaccesousuario']||trim($rowOperacion['ipaccesousuario']) == '0'){
            $uservalido = true;
        }
        return $uservalido;
    }//usuarioValido
    
    function leeContadorIntentosAccesoFallidos(){
        $queryLogIntentos="SELECT * FROM logintentosaccesousuario WHERE idusuario='".$this->arrayDatosUsuario['idusuario']."'";
        $logIntentos=$this->conexion->query($queryLogIntentos);
        $rowLogIntentos=$logIntentos->fetchRow();
        
        if(is_array($rowLogIntentos)){
                return $rowLogIntentos;
        }else{
            return false;
        }
    }//leeContadorIntentosAccesoFallidos
    
    function aumentaContadorIntentosAccesoFallidos($numeroIntentos=null){
        if(is_array($this->ArrayContadorIntentosAccesoFallidos)){
            if($numeroIntentos!=null){
                $queryActualizaIntentos="UPDATE logintentosaccesousuario SET contadorlogintentosaccesousuario = '".($numeroIntentos)."' WHERE idusuario='".$this->ArrayContadorIntentosAccesoFallidos['idusuario']."'";
            }else{
                $queryActualizaIntentos="UPDATE logintentosaccesousuario SET contadorlogintentosaccesousuario = '".($this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'] + 1)."' WHERE idusuario='".$this->ArrayContadorIntentosAccesoFallidos['idusuario']."'";
            }
            
            $operacion=$this->conexion->query($queryActualizaIntentos);
        }else{
            if($numeroIntentos!=null){
                $queryInsertaIntentos="INSERT into logintentosaccesousuario VALUES('','".$this->arrayDatosUsuario['idusuario']."','".($numeroIntentos)."')";
            }else{
                $queryInsertaIntentos="INSERT into logintentosaccesousuario VALUES('','".$this->arrayDatosUsuario['idusuario']."','1')";
            }
            
            $operacion=$this->conexion->query($queryInsertaIntentos);
        }
    }//aumentaContadorIntentosAccesoFallidos
    
    function reseteaContadorIntentosAccesoFallidos(){
        if(is_array($this->ArrayContadorIntentosAccesoFallidos)){
            $queryActualizaIntentos="UPDATE logintentosaccesousuario SET contadorlogintentosaccesousuario = 0 WHERE idusuario='".$this->ArrayContadorIntentosAccesoFallidos['idusuario']."'";
            $operacion=$this->conexion->query($queryActualizaIntentos);
        }
    }
    
    function verificaPoliticaIntentosAccesoUsuario(){
        if($this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'] >= $this->politicaCantidadIntentosAcceso){
            return false;
        }else{
            return true;
        }
    }
    
    function defineAutenticacion($requiereCambioClave=false){
        $this->avanzaAPISegundaClave=false;
        /*
         * @modified Ivan Quintero <quinteroivan@unbosque.edu.co>
         * Se modifica la consulta para validar los datos por el tipo de usuario y por el rol
         * @since Febrero 10, 2017
        */
        //switch ($this->arrayDatosUsuario['codigorol']){		
        $sqlRol= "SELECT rol.idrol
            FROM usuario u 
            INNER JOIN UsuarioTipo ut ON (ut.UsuarioId = u.idusuario)
            INNER JOIN usuariorol rol ON (rol.idusuariotipo = ut.UsuarioTipoId )
            WHERE u.usuario = '".$this->arrayDatosUsuario['usuario']."'";
        
        $UsuarioRol = $this->conexion->query($sqlRol);
        $row_Rol=$UsuarioRol->fetchRow();
        $this->arrayDatosUsuario['codigorol'] = $row_Rol['idrol'];
        
        $_SESSION['codigotipousuario']= $this->arrayDatosUsuario['codigotipousuario'];
        
        switch ($this->arrayDatosUsuario['codigotipousuario']){
            //case '1':
            case '600': // ESTUDIANTE
                $_SESSION["idPerfil"]=1;
                //estudiante se autentica por correo y se obliga a cambiar clave con politica vencimiento
                $correoValido=$this->validarCorreo($this->usuario,$this->passwordPlano);
                if($correoValido){
                    $cantClaves=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],1); 
                    if($cantClaves==0){
                        $this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);
                        $this->autenticacionAutorizada=true;
                        $this->respuestaApp=true;
                    }else{
                        $this->leerClavesCorreoBD($this->arrayDatosUsuario['idusuario'],1);
                        $verificaClaveViva=$this->verificaUltimaClaveViva();
                        if($verificaClaveViva==true){
                            $verificaPasswd=$this->verificaPasswd();
                            if($verificaPasswd==true){
                                $this->autenticacionAutorizada=true;
                                $this->respuestaApp=true;
                                $this->mensajeUsuario="Clave correcta";
                            }else{
                                //actualizar registro, se supone que el usuario cambió la clave del correo antes de caducar, pero validó OK
                                $this->actualizaRegistroPasswd($this->arrayClavesUsuario[0]['idclaveusuario']);
                                $this->autenticacionAutorizada=true;
                                $this->respuestaApp=true;
                                $this->mensajeUsuario="Clave correcta";
                            }
                        }else{
                            $caducar=$this->caducarUltimoRegistroClave($this->arrayDatosUsuario['idusuario']);
                            if($caducar==true){
                                $this->mensajeUsuario="Su clave caducó";
                            }else{
                                $cambioClave=$this->verificarSiClaveCorreoHaCambiado($this->password);
                                $cambioClave=true;
                                if($cambioClave==true){
                                    $regClave=$this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);
                                    if($regClave==true){
                                        $this->autenticacionAutorizada=true;
                                        $this->respuestaApp=true;
                                    }
                                }else{
                                    $this->mensajeUsuario="Aún no ha cambiado su clave de correo electrónico. No podrá entrar al Sistema de Gestión Académica hasta que no cambie la clave del correo";
                                }
                            }//ELSE
                        }//ELSE
                    }//ELSE
                    /* $this->autenticacionAutorizada=true;
                    $this->mensajeUsuario="Clave correcta";*/
                }else{
                    $this->autenticacionAutorizada=false;
                    $this->respuestaApp=false;
                    $this->mensajeUsuario="Error de autenticación de correo electrónico ";
                }
                break;
                //case '2':
            case '900':{ //Padres
                $_SESSION["idPerfil"]=4;
                $correoValido=$this->validarCorreo($this->usuario,$this->passwordPlano);
                if($correoValido){
                    $cantClaves=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],1);

                    if($cantClaves==0){
                        $this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);
                        $this->autenticacionAutorizada=true;
                        $this->respuestaApp=true;
                    }else{
                        $this->leerClavesCorreoBD($this->arrayDatosUsuario['idusuario'],1);
                        $verificaClaveViva=$this->verificaUltimaClaveViva();
                        if($verificaClaveViva==true){
                            $verificaPasswd=$this->verificaPasswd();
                            if($verificaPasswd==true){
                                $this->autenticacionAutorizada=true;
                                $this->respuestaApp=true;
                                $this->mensajeUsuario="Clave correcta";
                            }else{
                                //actualizar registro, se supone que el usuario cambió la clave del correo antes de caducar, pero validó OK
                                $this->actualizaRegistroPasswd($this->arrayClavesUsuario[0]['idclaveusuario']);
                                $this->autenticacionAutorizada=true;
                                $this->respuestaApp=true;
                                $this->mensajeUsuario="Clave correcta";
                            }
                        }else{
                            $caducar=$this->caducarUltimoRegistroClave($this->arrayDatosUsuario['idusuario']);
                            if($caducar==true){
                                $this->mensajeUsuario="Su clave caducó";
                            }else{
                                $cambioClave=$this->verificarSiClaveCorreoHaCambiado($this->password);
                                $cambioClave=true;
                                if($cambioClave==true){
                                    $regClave=$this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);
                                    if($regClave==true){
                                        $this->autenticacionAutorizada=true;
                                        $this->respuestaApp=true;
                                    }
                                }else{
                                    $this->mensajeUsuario="Aún no ha cambiado su clave de correo electrónico. No podrá entrar al Sistema de Gestión Académica hasta que no cambie la clave del correo";
                                }
                            }//ELSE
                        }//ELSE
                    }//ELSE 
                    /* $this->autenticacionAutorizada=true;
                    $this->mensajeUsuario="Clave correcta";*/
                }else{
                    $this->autenticacionAutorizada=false;
                    $this->respuestaApp=false;
                    $this->mensajeUsuario="Error de autenticación de correo electrónico ";
                }
                }break;
                    
            case '500'://DOCENTE 
                $_SESSION["idPerfil"]=2;
                //docente se autentica por correo y se obliga a cambiar clave con politica vencimiento, igual aplica la segunda clave
                //si la bandera autenticar segunda clave es true, se supone que ya habia autenticado correo, por lo que no se requiere revisar esa validacion de nuevo
                                
                if($this->autenticarSegundaClave==true){
                    $correoValido=true;
                }else{
                    $correoValido=$this->validarCorreo($this->usuario,$this->passwordPlano);
                }
                
                if($correoValido){
                    $query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion
                        FROM votacion v
                        WHERE v.codigoestado=100 
                        AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion";

                    $op=$this->conexion->query($query_votacion);
                    $numRows=$op->numRows();
                    /*
                     * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                     * Se agrega validacion para ignorar autologin en periodos de votacion para el nuevo sala
                     * es decir, siempre se va a pedir la segunda clave cuando venga desde el nuevo sala
                     * @since febrero 14 2017
                    */ 
                    if($numRows>0 && $this->modoRespuestaAutenticacion!=="json"){
                        $this->autenticacionAutorizada=true;
                        $this->respuestaApp=true;
                    }else{
                        $cantClaves=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],1);//valida cuantas segundas claves tiene el usuario
                        /*
                        1->clave de correo 
                        2->base de datos
                        3->segunda clave
                        */

                        if($cantClaves==0){
                            $this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);
                            $this->mensajeUsuario="Primera clave(la del correo) correcta, ahora debe diligenciar una nueva segunda clave";
                            //en ningun caso habilita true, eso se hace porque los docentes tienen que pasar la segunda clave, luego de la autenticacion x correo

                            $this->autenticacionAutorizada=false;
                            $this->respuestaApp=false;
                            $cantClaves2BD=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],3);

                            if($cantClaves2BD==0){
                                $this->existesegundaclave=false;
                                $this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
                            }

                            $_SESSION['2clavereq']='SEGCLAVEREQ';
                        }else{
                            //ahora verificar segundaclave existencia
                            $cantClaves2BD=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],3);

                            if($cantClaves2BD==0){
                                $this->existesegundaclave=false;
                                $this->mensajeUsuario="Primera clave(la del correo) correcta, ahora debe diligenciar una nueva segunda clave";
                                $this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
                                $_SESSION['2clavereq']='SEGCLAVEREQ';
                            }else{
                                if($this->autenticarSegundaClave==true){
                                    $this->leerClavesCorreoBD($this->arrayDatosUsuario['idusuario'],3);// Buscar y Leer
                                    $verificaClaveViva=true;
                                }else{
                                    $this->leerClavesCorreoBD($this->arrayDatosUsuario['idusuario'],1);
                                    $verificaClaveViva=$this->verificaUltimaClaveViva();
                                }

                                if($verificaClaveViva==true){
                                    if($this->autenticarSegundaClave==true){
                                        $verificaPasswd=$this->verificaPasswd();

                                        if($verificaPasswd==true){
                                            if($this->autenticarSegundaClave==true){
                                                $this->autenticacionAutorizada=true;
                                                $this->respuestaApp=true;
                                                $this->reseteaContadorIntentosAccesoFallidos();
                                                $this->mensajeUsuario="Segunda clave correcta";
                                                /**
                                                 * @modified Andres Ariza <emailautor@unbosque.edu.do>
                                                 * Cuando la segunda clave es correcta se elimina la variable de sesion 2clavereq si existe
                                                 * @since enero 24, 2018
                                                 */
                                                unset($_SESSION['2clavereq']);
                                            }
                                        }else{
                                            $verificaPoliticaIntentosAcceso=$this->verificaPoliticaIntentosAccesoUsuario();

                                            if($verificaPoliticaIntentosAcceso==true){
                                                if($this->autenticarSegundaClave==true){
                                                    ///aca debe ir el contador
                                                    $this->aumentaContadorIntentosAccesoFallidos();
                                                    $this->autenticacionAutorizada=false;
                                                    $this->respuestaApp=false;
                                                    $contIntentos=$this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario']+1;
                                                    $this->contenidofail = $contIntentos;
                                                    $this->mensajeUsuario="Clave incorrecta. Usted tiene acumulados ".$contIntentos." intentos fallidos. Por su seguridad su clave será bloqueada después de ".$this->politicaCantidadIntentosAcceso." intentos fallidos.";
                                                }else{
                                                    //actualizar registro, se supone que el usuario cambió la clave del correo antes de caducar, pero validó OK
                                                    $this->actualizaRegistroPasswd($this->arrayClavesUsuario[0]['idclaveusuario']);
                                                }
                                            }else{
                                                $this->autenticacionAutorizada=false;
                                                $this->respuestaApp=false;
                                                $this->actualizaUltimaClaveViva(200,600);// cancelado el log y en estado bloqueo
                                                $this->contenidofail = 3;
                                                $this->mensajeUsuario="Su Segunda Clave Bloqueada por intentos de acceso fallidos";
                                            }
                                        }
                                    }else{
                                        //en ningun caso habilita true, eso se hace porque los docentes tienen que pasar la segunda clave, luego de la autenticacion x correo, activar bandera AutenticacionAutorizada
                                        $this->autenticacionAutorizada=false;
                                        $this->respuestaApp=false;
                                        $this->mensajeUsuario="Primera clave(la del correo) correcta, ahora debe digitar la segunda clave";
                                        $this->avanzaAPISegundaClave=true;
                                        $_SESSION['2clavereq']='SEGCLAVE';
                                    }
                                }else{
                                    $caducar=$this->caducarUltimoRegistroClave($this->arrayDatosUsuario['idusuario']);
                                    if($caducar==true){
                                        $this->mensajeUsuario="Su clave caducó";
                                    }else{
                                        $cambioClave=$this->verificarSiClaveCorreoHaCambiado($this->password);
                                        $cambioClave=true;

                                        if($cambioClave==true){
                                            $regClave=$this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);

                                            if($regClave==true){
                                                if($this->autenticarSegundaClave==true){
                                                    $this->autenticacionAutorizada=true;
                                                    $this->respuestaApp=true;
                                                    $this->mensajeUsuario="Segunda clave correcta";
                                                }else{
                                                    //en ningun caso habilita true, eso se hace porque los docentes tienen que pasar la segunda clave, luego de la autenticacion x correo, activar bandera AutenticacionAutorizada
                                                    $this->autenticacionAutorizada=false;
                                                    $this->respuestaApp=false;
                                                    $this->mensajeUsuario="Primera clave(la del correo) correcta";
                                                    $_SESSION['2clavereq']='SEGCLAVE';
                                                }
                                            }
                                        }else{
                                            $this->autenticacionAutorizada=false;
                                            $this->respuestaApp=false;
                                            $this->mensajeUsuario="Aún no ha cambiado su clave de correo electrónico. No podrá entrar al Sistema de Gestión Académica hasta que no cambie la clave del correo";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }else{
                    $this->autenticacionAutorizada=false;
                    $this->respuestaApp=false;
                    $this->mensajeUsuario="Error de autenticación de correo electrónico ";
                }
                break;
                //case '3':
            case '400':
                $_SESSION["idPerfil"]=3;
                //administrativo se autentica por bd y se obliga a cambiar la clave con politica de vencimiento y control de intentos de acceso a usuario
                $cantClaves=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],2);					
                if($cantClaves==0){
                    //si no hay clave, se va a guardar la del correo electronico ahora
                    $validoCorreo=$this->validarCorreo($this->usuario,$this->passwordPlano);
                    if($validoCorreo==true){
                        $this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,2);
                        $this->reseteaContadorIntentosAccesoFallidos();
                        $this->autenticacionAutorizada=true;
                        $this->respuestaApp=true;
                        $this->mensajeUsuario="Clave correcta";
                    }else{
                        $this->autenticacionAutorizada=false;
                        $this->respuestaApp=false;
                        $this->mensajeUsuario="Error de autenticación de correo electrónico ";
                    }
                }else{
                    //ya hay clave, verificar que está viva
                    $this->leerClavesCorreoBD($this->arrayDatosUsuario['idusuario'],2);
                    $verificaClaveViva=$this->verificaUltimaClaveViva();

                    if($verificaClaveViva==true){
                        $verificaPoliticaIntentosAcceso=$this->verificaPoliticaIntentosAccesoUsuario();

                        if($verificaPoliticaIntentosAcceso==true){
                            $verificaPasswd=$this->verificaPasswd();
                            if($verificaPasswd==true){
                                $this->autenticacionAutorizada=true;
                                $this->respuestaApp=true;
                                $this->reseteaContadorIntentosAccesoFallidos();
                                $this->mensajeUsuario="Clave correcta";
                            }else{
                                $this->aumentaContadorIntentosAccesoFallidos();
                                $this->autenticacionAutorizada=false;
                                $this->respuestaApp=false;
                                $contIntentos=$this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario']+1;
                                $this->contenidofail = $contIntentos;
                                $this->mensajeUsuario="Clave incorrecta. Usted tiene acumulados ".$contIntentos." intentos fallidos. Por su seguridad su clave será bloqueada después de ".$this->politicaCantidadIntentosAcceso." intentos fallidos.";
                            }
                        }else{
                            $this->autenticacionAutorizada=false;
                            $this->respuestaApp=false;
                            $this->actualizaUltimaClaveViva(200,400);

                            if($requiereCambioClave){
                                $this->mensajeUsuario='En el marco de la auditoria que se viene adelantando en el sistema academico SALA, se requiere que cambie su clave.';
                            }else{
                                $this->mensajeUsuario="Clave Bloqueada por intentos de acceso fallidos";
                            }

                            $this->urlRedireccionamiento="../formClaveBDBloqAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
                            $this->frameRedireccionamiento="contenidocentral";
                        }
                    }else{
                        //****la primera vez, antes de actualizar la bd***revisar....logica
                        $verificaExistenciaPreguntaSecret=$this->verificaExistenciaPreguntaRespuestaSecreta();

                        if($verificaExistenciaPreguntaSecret==true){
                            $this->claveViva="caduca";
                            $this->urlRedireccionamiento="../formClaveBDCaducaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
                            $this->frameRedireccionamiento="contenidocentral";
                            $this->autenticacionAutorizada=false;
                            $this->respuestaApp=false;
                            $this->mensajeUsuario="Clave caducada";
                        }else{
                            $this->claveViva="caduca";
                            $this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
                            $this->frameRedireccionamiento="contenidocentral";
                            $this->autenticacionAutorizada=false;
                            $this->respuestaApp=false;
                            $this->mensajeUsuario="Clave caducada";
                        }

                        /********************************************/
                        if($this->arrayClavesUsuario[0]['codigoestado']<>200){
                            $this->actualizaUltimaClaveViva(200,200);
                        }

                        $verificaDesbloqueo=$this->verificaDesbloqueoUltimaClave();
                        if($verificaDesbloqueo==false){
                            //verificar existencia de pregunta secreta
                            $verificaExistenciaPreguntaSecreta=$this->verificaExistenciaPreguntaRespuestaSecreta();
                            if($verificaExistenciaPreguntaSecreta==true){
                                //$this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']=400;
                                if($this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==200){
                                    $this->claveViva="caduca";
                                    $this->urlRedireccionamiento="../formClaveBDCaducaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
                                    $this->frameRedireccionamiento="contenidocentral";
                                    $this->autenticacionAutorizada=false;
                                    $this->respuestaApp=false;
                                    $this->mensajeUsuario="Clave caducada..3";
                                }elseif ($this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==400){
                                    $this->autenticacionAutorizada=false;
                                    $this->respuestaApp=false;
                                    if($requiereCambioClave){
                                        $this->mensajeUsuario='En el marco de la auditoria que se viene adelantando en el sistema academico SALA, se requiere que cambie su clave.';
                                    }else{
                                        $this->mensajeUsuario="Clave Bloqueada por intentos de acceso fallidos";
                                    }

                                    $this->urlRedireccionamiento="../formClaveBDBloqAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
                                    $this->frameRedireccionamiento="contenidocentral";
                                }
                            }else{
                                if($this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==200){
                                    $this->claveViva="caduca";
                                    $this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
                                    $this->frameRedireccionamiento="contenidocentral";
                                    $this->autenticacionAutorizada=false;
                                    $this->respuestaApp=false;
                                    $this->mensajeUsuario="Clave caducada";
                                }
                            }
                        }else{
                            $this->claveViva="desbloqueada";
                            $this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
                            $this->frameRedireccionamiento="contenidocentral";
                            $this->autenticacionAutorizada=false;
                            $this->respuestaApp=false;
                            $this->mensajeUsuario="Su clave ha sido desbloqueada, Por favor actualice su contraseña.";
                        }
                    }
                }
                break;
        }
        /*fin de la modificacion*/
    }//defineAutenticacion
    
    function verificaExistenciaPreguntaRespuestaSecreta(){
        $query="SELECT idreferenciaclaveusuario FROM referenciaclaveusuario WHERE idusuario='".$this->arrayDatosUsuario['idusuario']."
            AND $this->fechahoy BETWEEN fechainicioreferenciaclaveusuario AND fechafinalreferenciaclaveusuario'";
        
        $op=$this->conexion->query($query);
        $numRows=$op->numRows();
        if($numRows>0){
            return true;
        }else{
            return false;
        }
    }//verificaExistenciaPreguntaRespuestaSecreta
    
    function actualizaRegistroPasswd($idclaveusuario){
        $query="UPDATE claveusuario SET claveusuario='$this->password' WHERE idclaveusuario='$idclaveusuario'";
        $op=$this->conexion->query($query);
    }
    
    function registraVariablesSesionInicio(){
        if($this->autenticacionAutorizada==true){
            $_SESSION['auth']=true;
        }else{
            $_SESSION['auth']=false;
        }
    }//function registraVariablesSesionInicio
    
    function validarUsuarioBD($usuario){
        $queryUser = "SELECT * FROM usuario WHERE usuario = '".$usuario."'"; 
        $operacion=$this->conexion->query($queryUser);
        $numRowsOperacion=$operacion->numRows();
        $this->usuariocreado=0;
        
        if($numRowsOperacion == 1){
            $this->usuariocreado=1;
        }
        
        $queryUser ="SELECT u.*, d.nombrecortodocumento
            FROM usuario u 
            INNER JOIN documento d ON d.tipodocumento=u.tipodocumento
            WHERE u.usuario = '".$usuario."'
                and (NOW() between u.fechainiciousuario and u.fechavencimientousuario)
                and u.codigoestadousuario like '1%'";
        
        $operacion=$this->conexion->query($queryUser);
        $numRowsOperacion=$operacion->numRows();
        
        if($numRowsOperacion == 1){
            $rowOperacion=$operacion->fetchRow();
            $this->arrayDatosUsuario=$rowOperacion;
            return true;
        }else{
            return false;
        }
    }//validarUsuarioBD
    
    function registraClaveBD($idusuario,$password,$codigotipoclaveusuario){
        $queryInsertaReg="INSERT INTO claveusuario VALUES('','$idusuario','$this->fechahoy','$this->fechahoy','2999-12-31','".$password."','100','100','".$codigotipoclaveusuario."')";
        $operacion=$this->conexion->query($queryInsertaReg);
        
        if($operacion){
            return true;
        }else{
            return false;
        }
    }//registraClaveBD
    
    function validarExistenciaClave($idusuario,$codigotipoclaveusuario){
        /*
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se agrega switch para que de acuerdo al $codigotipoclaveusuario no 
         * hayan tantas condiciones cuando sea 3 es decir segunda clave de docentes
         * @since Diciembre 12, 2018
         */
        $query="SELECT count(cu.idclaveusuario) as cantClaves FROM claveusuario cu
            WHERE cu.idusuario='$idusuario' AND cu.codigotipoclaveusuario='$codigotipoclaveusuario' ";
        switch ($codigotipoclaveusuario) {
            case 3:
                $query .= "AND codigoestado = '100' ";
                break;
            default:
                $query .= "AND (codigoestado = '100' OR codigoindicadorclaveusuario IN ('200','300','400','500')) ";
                break;
        }
        $query .= "AND fechavenceclaveusuario>=NOW() ";
        //d($query);
        $operacion=$this->conexion->query($query);
        $rowOperacion=$operacion->fetchRow();
        
        return $rowOperacion['cantClaves'];
    }//validarExistenciaClave
    
    function leerClavesCorreoBD($idusuario,$codigotipoclaveusuario){
        $query="SELECT cu.* FROM claveusuario cu WHERE cu.idusuario='$idusuario' AND cu.codigotipoclaveusuario = '$codigotipoclaveusuario' ORDER BY cu.idclaveusuario DESC";
        $operacion=$this->conexion->query($query);
        $rowOperacion=$operacion->fetchRow();
        
        do{
            $this->arrayClavesUsuario[]=$rowOperacion;
        }while ($rowOperacion=$operacion->fetchRow()); 
    }//function leerClavesCorreoBD
    
    function actualizaUltimaClaveViva($codigoestado,$codigoindicadorclaveusuario){
        $query="UPDATE claveusuario SET fechavenceclaveusuario='$this->fechahoy',codigoindicadorclaveusuario='$codigoindicadorclaveusuario',codigoestado='$codigoestado' WHERE idclaveusuario='".$this->arrayClavesUsuario[0]['idclaveusuario']."'";
        $operacion=$this->conexion->query($query);
    }//actualizaUltimaClaveViva
    
    function verificaUltimaClaveViva(){
        $fechasinformato=strtotime("+$this->politicaCantidadDiasCaducidad day",strtotime($this->arrayClavesUsuario[0]['fechainicioclaveusuario']));
        $fechanueva=date("Y-m-d H:i:s",$fechasinformato);
        
        if($this->arrayClavesUsuario[0]['codigoestado']==100 and $this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==100){
            if($fechanueva >= $this->fechahoy){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }//verificaUltimaClaveViva
    
    function verificaDesbloqueoUltimaClave(){
        if($this->arrayClavesUsuario[0]['codigoestado']==200 and $this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==500){
            return true;
        }else{
            return false;
        }
    }//verificaDesbloqueoUltimaClave
    
    function leerPoliticaClave(){
        $queryPoliticaClave="SELECT pc.* 
            FROM politicaclave pc
            WHERE '$this->fechahoy' between pc.fechadesdepoliticaclave and pc.fechahastapoliticaclave";
        $politicaClave=$this->conexion->query($queryPoliticaClave);
        $rowPoliticaClave=$politicaClave->fetchRow();
        $numRowsPoliticaClave=$politicaClave->numRows();
        $this->politicaCantidadDiasCaducidad=$rowPoliticaClave['diascaducidadpoliticaclave'];
        $this->politicaCantidadIntentosAcceso=$rowPoliticaClave['numerointentospoliticaclave'];
        
        if(empty($cantDias)){
            $cantDias = 30;
        }
        
        if(empty($numerointentospoliticaclave)) {
            $numerointentospoliticaclave=5;
        }
    }//leerPoliticaClave
    
    function registraLogActividadUsuario(){
        $queryLogActividadUsuario="INSERT INTO logactividadusuario VALUES ('','".$this->arrayDatosUsuario['idusuario']."', '".$this->fechahoy."', '$this->ip','".$this->arrayDatosUsuario['usuario']."','".$this->AccesoSistema."')";
        $operacion=$this->conexion->query($queryLogActividadUsuario);
    }//registraLogActividadUsuario
    
    function tomarip(){
        if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_X_FORWARDED_FOR"])){
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }else{
            if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_CLIENT_IP"])){
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            }else{
                if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["REMOTE_HOST"])){
                    $ip = $_SERVER["REMOTE_HOST"];
                }else{
                    $ip = $_SERVER["REMOTE_ADDR"];
                }
            }
        }
        return $ip;
    }//tomarip
    
    function generaXML(){
        if(!empty($_SESSION['2clavereq'])){
            $aut=$_SESSION['2clavereq'];
        }elseif($this->autenticacionAutorizada==true){
            $aut="OK";
        }else{
            $aut="ERROR";
        }
        
        if(empty($this->mensajeUsuario)){
            $this->mensajeUsuario="Su clave de correo ha sido cambiada satisfactoriamente,\n por favor intentelo de nuevo";
        }
        
        if(empty($this->urlRedireccionamiento)){
            $this->urlRedireccionamiento="0";
        }
        
        if(empty($this->frameRedireccionamiento)){
            $this->frameRedireccionamiento="0";
        }
        
        if(empty($this->arrayDatosUsuario['idusuario'])){
            $this->arrayDatosUsuario['idusuario']="0";
        }
        
        if(empty($this->arrayDatosUsuario['codigorol'])){
            $this->arrayDatosUsuario['codigorol']="0";
        }
        
        /*
         * @modified Ivan Quintero <quinteroivan@unbosque.edu.co>
         * Se modifica agrega la variable tipousuario para la validacion de datos del tipo de usuario en el login
         * @since Febrero 10, 2017
        */
        if(empty($this->arrayDatosUsuario['codigotipousuario'])){
            $this->arrayDatosUsuario['codigotipousuario']="0";
        }
        /**END*/
        
        if(empty($this->claveViva)){
            $this->claveViva="0";
        }
        
        if(empty($this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'])){
            $contador="-";
        }else{
            $contador=$this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'];
        }
        
        if(empty($this->politicaCantidadIntentosAcceso)){
            $politicaIntentosAcceso=0;
        }else{
            $politicaIntentosAcceso=$this->politicaCantidadIntentosAcceso;
        }
        
        header("Content-Type: text/xml");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Keep-Alive: timeout=120, max=993");
        header("KeepAliveTimeout: timeout=120, max=993");
        /*header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        // generate the output in XML format
        header('Content-type: text/xml');*/
        
        //encoding="UTF-8" o encoding="LATIN1"
        echo '<?xml version="1.0"  encoding="LATIN1"?>';
        echo "<resultado>";
        echo "<autenticacion>";
        echo $aut;
        echo "</autenticacion>";
        echo "<rol>";
        echo $this->arrayDatosUsuario['codigorol'];
        echo "</rol>";
        /*
         * @modified Ivan Quintero <quinteroivan@unbosque.edu.co>
         * Se modifica agrega la variable tipousuario para la validacion de datos del tipo de usuario en el login
         * @since Febrero 10, 2017
        */
        echo "<codigotipousuario>";
        echo $this->arrayDatosUsuario['codigotipousuario'];
        echo "</codigotipousuario>";
        /*
        *END
        */
        echo "<url>";
        echo $this->urlRedireccionamiento;
        echo "</url>";
        echo "<frame>";
        echo $this->frameRedireccionamiento;
        echo "</frame>";
        echo "<idusuario>";
        echo $this->arrayDatosUsuario['idusuario'];
        echo "</idusuario>";
        echo "<mensaje>";
        echo $this->mensajeUsuario;
        echo "</mensaje>";
        echo "<claveviva>";
        echo $this->claveViva;
        echo "</claveviva>";
        echo "<contadorintentosfallidos>";
        echo $contador;
        echo "</contadorintentosfallidos>";
        echo "<cantidadintentosaccesopermitidos>";
        echo $politicaIntentosAcceso;
        echo "</cantidadintentosaccesopermitidos>";
        echo "</resultado>";
    }//generaXML
    
    function generaArrayAutenticacion(){
        if(!empty($_SESSION['2clavereq'])){
            $aut=$_SESSION['2clavereq'];
        }elseif($this->autenticacionAutorizada==true){
            $aut="OK";
        }else{
            $aut="ERROR";
        }
        
        if(empty($this->mensajeUsuario)){
            $this->mensajeUsuario="Clave de correo Cambiada";
        }
        
        if(empty($this->urlRedireccionamiento)){
            $this->urlRedireccionamiento="0";
        }
        
        if(empty($this->frameRedireccionamiento)){
            $this->frameRedireccionamiento="0";
        }
        
        if(empty($this->arrayDatosUsuario['idusuario'])){
            $this->arrayDatosUsuario['idusuario']="0";
        }
        
        if(empty($this->arrayDatosUsuario['codigorol'])){
            $this->arrayDatosUsuario['codigorol']="0";
        }
        /*
         * @modified Ivan Quintero <quinteroivan@unbosque.edu.co>
         * Se modifica agrega la variable tipousuario para la validacion de datos del tipo de usuario en el login
         * @since Febrero 10, 2017
        */
        if(empty($this->arrayDatosUsuario['codigotipousuario'])){
            $this->arrayDatosUsuario['codigotipousuario']="0";
        }
        /*
        *END
        */
        if(empty($this->claveViva)){
            $this->claveViva="0";
        }
        
        if(empty($this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'])){
            $contador="-";
        }else{
            $contador=$this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'];
        }
        
        if(empty($this->politicaCantidadIntentosAcceso)){
            $politicaIntentosAcceso=0;
        }else{
            $politicaIntentosAcceso=$this->politicaCantidadIntentosAcceso;
        }
        
        $arrayAutenticacion[0]['autenticacion']=$aut;
        $arrayAutenticacion[0]['rol']=$this->arrayDatosUsuario['codigorol'];
        /*
         * @modified Ivan Quintero <quinteroivan@unbosque.edu.co>
         * Se modifica agrega la variable tipousuario para la validacion de datos del tipo de usuario en el login
         * @since Febrero 10, 2017
        */
        $arrayAutenticacion[0]['codigotipousuario']=$this->arrayDatosUsuario['codigotipousuario'];
        /*
        *END
        */
        $arrayAutenticacion[0]['url']=$this->urlRedireccionamiento;
        $arrayAutenticacion[0]['frame']=$this->frameRedireccionamiento;
        $arrayAutenticacion[0]['idusuario']=$this->arrayDatosUsuario['idusuario'];
        $arrayAutenticacion[0]['mensaje']=$this->mensajeUsuario;
        $arrayAutenticacion[0]['claveviva']=$this->claveViva;
        $arrayAutenticacion[0]['contadorintentosfallidos']=$contador;
        $arrayAutenticacion[0]['cantidadintentosaccesopermitidos']=$politicaIntentosAcceso;
        
        return $arrayAutenticacion;
    }//generaArrayAutenticacion
    
    function cargaVariables(){
        //si hay clave viva y valida (no caduca) continua proceso login
        $query_selperiodo = "SELECT p.codigoperiodo, e.codigoestadoperiodo FROM periodo p, estadoperiodo e WHERE p.codigoestadoperiodo = e.codigoestadoperiodo and e.codigoestadoperiodo = '1'";
        $selperiodo = $this->conexion->query($query_selperiodo);
        $totalRows_selperiodo=$selperiodo->numRows();
        $row_selperiodo=$selperiodo->fetchRow();        
        /**********
        Esta variable define la ruta donde se encuentra la aplicacion, se utiliza en algunos archivos especialmente en los de integracion con People Soft
        para evitar el problema de la	redireccion de los archivos en los REQUIRE y en los INCLUDE.
        Nota :	Esta URL hay que cambiarla tambien en el archivo "funciones/zfica_sala_crea_aspirante.php" y "funciones/ordenpago/claseordenpago.php" puesto que
                las ordenes de inscripcion se generan desde la pagina Web y desde el sistema SALA. La variable $_SESSION['path_live'] solo existe cuando se trabaja
                en el Sistema SALA.
        ************/
        $_SESSION['path_live']="/usr/local/apache2/htdocs/html/serviciosacademicos/";
		
    	$diligenciardatosgenerales=0;
        $C_EntradaRedirecion	= new EntradaRedirecion();
        
        $Userid = $this->arrayDatosUsuario['idusuario'];        
        $id_Periodo = $row_selperiodo['codigoperiodo'];
        $usuario = $this->arrayDatosUsuario['usuario'];       
        /*
         * @modified Andres Ariza <arizaandres@unbosque.edu.co>
         * Solo se organizo un poco el codigo de la consulta
         * @since enero 26 2017
        */       
        $sqlUsuarioRol= "SELECT rol.idrol 
            FROM usuario u 
            INNER JOIN UsuarioTipo ut ON (ut.UsuarioId = u.idusuario)
            INNER JOIN usuariorol rol ON (rol.idusuariotipo = ut.UsuarioTipoId )
            WHERE u.usuario = '".$this->arrayDatosUsuario['usuario']."' ";
        /* Fin Modificacion */
        $UsuarioRol = $this->conexion->query($sqlUsuarioRol);
        $row_UsuarioRol=$UsuarioRol->fetchRow();
        $C_Data	= $C_EntradaRedirecion->Consulta($Userid,$id_Periodo);
        
        $codigotipousuario=$this->arrayDatosUsuario['codigotipousuario'];
        $rol= $row_UsuarioRol['idrol'];
        
        if($rol == '13'){
            //$C_ValidarFecha = new AdminDiasHorasssss(); 
            //$C_ValidarFecha->ingresoFecha($this->arrayDatosUsuario['usuario'], $this->ip);
        }
        
        $diligenciardatosgenerales=0;
        
        if($C_Data['Activo']==1){
            $diligenciardatosgenerales=$C_Data['Activo'];
            $_SESSION["redireccionentrada"]=$C_Data['URL'];
            $_SESSION["idusuariofinalentradaentrada"]=$this->arrayDatosUsuario['idusuario'];
        }
        //Si el usuario es tipo estudiante o padre
        if($codigotipousuario==600 || $codigotipousuario==900){
            $_SESSION['nuevoMenu']=true;
            if($codigotipousuario!=900){
                $_SESSION['MM_Username'] = 'estudiante';
            }else{
                $_SESSION['MM_Username'] = 'padre';
            }
            $_SESSION['codigoperiodosesion'] = $row_selperiodo['codigoperiodo'];
            $_SESSION['codigoestadoperiodosesion'] = $row_selperiodo['codigoestadoperiodo'];
            $_SESSION['rol'] = $rol;
            $_SESSION['codigotipousuario'] = $codigotipousuario;
            $_SESSION['codigo']=$this->arrayDatosUsuario['numerodocumento'];
            
            $query_periodo = "SELECT * FROM estudiantegeneral WHERE numerodocumento = '".$_SESSION['codigo']."'";
            $periodo = $this->conexion->query($query_periodo);
            $row_periodo = $periodo->fetchRow();
            $totalRows_periodo = $periodo->numRows();
            $_SESSION['sesion_idestudiantegeneral'] = $row_periodo["idestudiantegeneral"];
            $this->arrayDatosUsuario['idestudiantegeneral'] =$row_periodo["idestudiantegeneral"];
            
            $ano1 = substr($row_periodo['fechaactualizaciondatosestudiantegeneral'],0,4);
            $ano2 = substr(date("Y-m-d"),0,4);
            $mes1= substr($row_periodo['fechaactualizaciondatosestudiantegeneral'],5,2);
            $mes2= substr(date("Y-m-d"),5,2);
            $dia1 = substr($row_periodo['fechaactualizaciondatosestudiantegeneral'],8,2);
            $dia2 = substr(date("Y-m-d"),8,2);
            $totalano = $ano2 - $ano1;
            if ($totalano > 0){
                $totalano = $totalano * 360;
            }
            $totalmes = $mes2 - $mes1;
            if ($totalmes > 0){
                $totalmes = $totalmes * 30;
            }
            
            $totaldia = $dia2 - $dia1;
            if (totaldia > 0){
                $totaldia = $totaldia * 1;
            }
            $fechatotal = $totaldia + $totalmes + $totalano;
            
            $diligenciarencuesta = false;
            
            if ($fechatotal >= 180 or $row_periodo['direccioncortaresidenciaestudiantegeneral'] == ""){
                //$this->frameRedireccionamiento='contenidocentral';
                //$this->urlRedireccionamiento="../prematricula/inscripcionestudiante/datosbasicos.php?documento=".$_SESSION['codigo']."";
                //*Se realizo el cambio por fallas en el formulario de actualizacion de datos//
                $this->frameRedireccionamiento='contenidocentral';
                $this->urlRedireccionamiento="../facultades/creacionestudiante/estudiante.php";
            }else{
                $this->frameRedireccionamiento='contenidocentral';
                $this->urlRedireccionamiento="../facultades/creacionestudiante/estudiante.php";
            }
        }else if($codigotipousuario==500){
            $_SESSION['nuevoMenu']=true;
            $_SESSION['rol'] = $rol;
            $_SESSION['codigotipousuario'] = $codigotipousuario;
            $query_selperiododocente = "select p.codigoperiodo, e.codigoestadoperiodo
                from periodo p, estadoperiodo e
                where p.codigoestadoperiodo = e.codigoestadoperiodo
                and e.codigoestadoperiodo = '3'";
            
            $selperiododocente = $this->conexion->query($query_selperiododocente);
            $row_selperiododocente=$selperiododocente->fetchRow();
            if ($row_selperiododocente <> ""){
                $_SESSION['codigoperiodosesion'] = $row_selperiododocente['codigoperiodo'];
                $_SESSION['codigoestadoperiodosesion'] = $row_selperiododocente['codigoestadoperiodo'];
            }else{
                $_SESSION['codigoperiodosesion'] = $row_selperiodo['codigoperiodo'];
                $_SESSION['codigoestadoperiodosesion'] = $row_selperiodo['codigoestadoperiodo'];
            }
            
            $_SESSION['codigodocente']=$this->arrayDatosUsuario['numerodocumento'];
            $_SESSION['numerodocumento']=$this->arrayDatosUsuario['numerodocumento'];
            
            $this->frameRedireccionamiento='contenidocentral';
            $this->urlRedireccionamiento="central.php";
        }elseif($codigotipousuario==400){
            // Pone el periodo y su estado en las variables de sesion
            $_SESSION['nuevoMenu']=true;
            $_SESSION['rol'] = $rol ;
            $_SESSION['codigotipousuario'] = $codigotipousuario;
            $_SESSION['codigoperiodosesion'] = $row_selperiodo['codigoperiodo'];
            $_SESSION['codigoestadoperiodosesion'] = $row_selperiodo['codigoestadoperiodo'];
            $_SESSION['usuario']=$_SESSION['MM_Username'];
            
            $colname_usuario = (get_magic_quotes_gpc()) ? $this->usuario : addslashes($this->usuario);
            $query_usuario = sprintf("SELECT codigofacultad FROM usuariofacultad WHERE usuario = '%s'", $colname_usuario);
            $usuario = $this->conexion->query($query_usuario);
            $row_usuario = $usuario->fetchRow();
            $totalRows_usuario = $usuario->numRows();
            
            $_SESSION['codigofacultad']= $row_usuario['codigofacultad'];
            $codigofacultad=$_SESSION['codigofacultad'];
            // SELECCIONA EL PERIODO PARA LA CARRERA QUE ENTRA
            $query_selperiodo = "SELECT
                MAX(p.codigoperiodo) AS codigoperiodo,
                p.codigoestadoperiodo
                FROM periodo p,
                carreraperiodo cp,
                usuariofacultad uf
                WHERE
                p.codigoestadoperiodo = '1'
                AND cp.codigocarrera = uf.codigofacultad
                AND p.codigoperiodo = cp.codigoperiodo 
                AND uf.usuario='$colname_usuario'";
            
            $selperiodo = $this->conexion->query($query_selperiodo);
            $totalRows_selperiodo=$selperiodo->numRows();
            if($totalRows_selperiodo == ""){
                $query_selperiodo = "select p.codigoperiodo, p.codigoestadoperiodo
                    from periodo p, carreraperiodo cp
                    where p.codigoestadoperiodo = '1'
                    and cp.codigocarrera = '$codigofacultad'
                        and p.codigoperiodo = cp.codigoperiodo";
                
                $selperiodo = $this->conexion->query($query_selperiodo);
                $totalRows_selperiodo=$selperiodo->numRows();
            }
            
            $row_selperiodo=$selperiodo->fetchRow();
            
            $_SESSION['codigoperiodosesion'] = $row_selperiodo['codigoperiodo'];
            $_SESSION['codigoestadoperiodosesion'] = $row_selperiodo['codigoestadoperiodo'];
            $colname_facultad = "0";
            
            if (isset($codigofacultad)){
                $colname_facultad = (get_magic_quotes_gpc()) ? $codigofacultad : addslashes($codigofacultad);
            }
            
            $query_facultad ="SELECT nombrecarrera FROM carrera WHERE codigocarrera = '$colname_facultad'";
            $facultad = $this->conexion->query($query_facultad);
            $row_facultad = $facultad->fetchRow();
            $totalRows_facultad = $facultad->numRows();
            
            $_SESSION['nombrefacultad']=$row_facultad['nombrecarrera'];
            
            if ($totalRows_usuario > 1){
                $query_difusuarios = "SELECT u.codigofacultad,c.nombrecarrera,c.codigocarrera
                    FROM usuariofacultad u,carrera c
                    WHERE u.usuario = '$colname_usuario'
                        and u.codigofacultad = c.codigocarrera";
                $difusuarios = $this->conexion->query($query_difusuarios);
                $row_difusuarios = $difusuarios->fetchRow();
                $totalRows_difusuarios = $difusuarios->numRows();
                
                $this->frameRedireccionamiento='contenidocentral';
                $idusuario=$this->arrayDatosUsuario['idusuario'];
                $this->urlRedireccionamiento='seleccionaCarreraAjax.php?idusuario='.$idusuario;
                
                do{
                    $this->arrayCarrerasUsuario[]=$row_difusuarios;
                }while ($row_difusuarios = $difusuarios->fetchRow());
            }else{
                $this->frameRedireccionamiento='contenidocentral';
                $this->urlRedireccionamiento="central.php";
            }
        }// else if 400
        
        if($diligenciardatosgenerales){
            $_SESSION["direccionposteriorentrada"]=$this->urlRedireccionamiento;
            $_SESSION["frameposteriorentrada"]=$this->frameRedireccionamiento;
            $this->frameRedireccionamiento='contenidocentral';
            //$this->urlRedireccionamiento="../sic/aplicaciones/estudiante/index.php?idusuario=".$this->arrayDatosUsuario["idestudiantegeneral"]."";
            $this->urlRedireccionamiento="../entrada/index.php";
        }
    }//cargaVariables
    
    //validacion de los diferentes roles de un mismo usuario     
    function Validarusuariosmultiples($usuario){
        $listaUsuarios = "select distinct case t.CodigoTipoUsuario when '400' then '3'  when '500' then '2' when '600' then '1' when '900' then '4' end as CodigoTipoUsuario 
            from usuario u inner join UsuarioTipo t on t.UsuarioId = u.idusuario 
            where u.numerodocumento = (select numerodocumento from usuario where usuario ='".$usuario."') and u.tipodocumento = (select tipodocumento from usuario where usuario ='".$usuario."') and t.CodigoEstado='100' AND u.codigoestadousuario=t.CodigoEstado order by CodigoTipoUsuario desc";
        
        $datosUsuarios = $this->conexion->query($listaUsuarios);
        $i=0;
        while($row_Usuarios = $datosUsuarios->fetchRow()){
            if($row_Usuarios['CodigoTipoUsuario']){
                $roles[$i] = $row_Usuarios['CodigoTipoUsuario'];
                $i++;
            }
        }
        //$Rows_Usuarios = $datosUsuarios->numRows();
        return $roles;
    }//function Validarusuariosmultiples
    
    /**
     * @modified Andres Ariza <emailautor@unbosque.edu.do>
     * Cuando la peticion se hace a travez de json se agrega una nueva funcion para generar respuesta json
     * @since enero 20, 2018
    */
    function generaJson(){
        //require ('/var/www/html/proyecto/kint/Kint.class.php');
        $arrayReturn = array();
        if(!empty($_SESSION['2clavereq'])){
            $arrayReturn['aut'] = $_SESSION['2clavereq'];
        }elseif($this->autenticacionAutorizada==true){
            $arrayReturn['aut'] ="OK";
            $this->aut = 'OK';
        }else{
            $arrayReturn['aut'] ="ERROR";
        }
        
        if(empty($this->mensajeUsuario)){
            $this->mensajeUsuario="Su clave de correo ha sido cambiada satisfactoriamente,\n por favor intentelo de nuevo";
        }
        
        if(empty($this->urlRedireccionamiento)){
            $this->urlRedireccionamiento="0";
        }
        
        if(empty($this->frameRedireccionamiento)){
            $this->frameRedireccionamiento="0";
        }
        
        if(empty($this->arrayDatosUsuario['idusuario'])){
            $this->arrayDatosUsuario['idusuario']="0";
        }
        
        if(empty($this->arrayDatosUsuario['codigorol'])){
            $this->arrayDatosUsuario['codigorol']="0";
        }
        
        /*
         * @modified Ivan Quintero <quinteroivan@unbosque.edu.co>
         * Se modifica agrega la variable tipousuario para la validacion de datos del tipo de usuario en el login
         * @since Febrero 10, 2017
        */
        if(empty($this->arrayDatosUsuario['codigotipousuario'])){
            $this->arrayDatosUsuario['codigotipousuario']="0";
        }
        /**END*/
        
        if(empty($this->claveViva)){
            $this->claveViva="0";
        }
        
        if(empty($this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'])){
            $contador="-";
        }else{
            $contador=$this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'];
        }
        
        if(empty($this->politicaCantidadIntentosAcceso)){
            $politicaIntentosAcceso=0;
        }else{
            $politicaIntentosAcceso=$this->politicaCantidadIntentosAcceso;
        }
        
        $_SESSION['idusuario'] = $this->arrayDatosUsuario['idusuario'];
        
        $arrayReturn['rol'] = $this->arrayDatosUsuario['codigorol'];
        
        $arrayReturn['codigotipousuario'] = $this->arrayDatosUsuario['codigotipousuario'];
        
        $arrayReturn['url'] = $this->urlRedireccionamiento;
        $arrayReturn['frame'] = $this->frameRedireccionamiento;
        $arrayReturn['idusuario'] = $this->arrayDatosUsuario['idusuario'];
        $arrayReturn['mensaje'] = $this->mensajeUsuario;
        $arrayReturn['claveviva'] = $this->claveViva;
        $arrayReturn['contadorintentosfallidos'] = $contador;
        $arrayReturn['cantidadintentosaccesopermitidos'] = $politicaIntentosAcceso;
        
        return $arrayReturn;
    }//generaXML
} 
?>
