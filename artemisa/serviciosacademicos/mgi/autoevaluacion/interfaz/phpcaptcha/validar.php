<?php
session_start();
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

include '../../../datos/usuarioAdmin/classValida.php';

switch($_REQUEST['actionID']){
    case 'registra_correo':{
        $valida = new Valida();
        setlocale(LC_TIME, "spanish");
        global $db;
        Main('1');
        $cap = 'notEq';
        /*
         * Agregar, modificar y quitar algunas validaciones para el registro de correo
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Dirección de Tecnología.
         * Modificado 10 de abril de 2016.
         */
        $nombres = $_REQUEST['nombres'];
        $valida->validaVacio($nombres);
        $valida->validarString($nombres);

        $apellidos = $_REQUEST['apellidos'];
        $valida->validaVacio($apellidos);
        $valida->validarString($apellidos);
        $nombrecompleto=$nombres." ".$apellidos;

        $correo = $_REQUEST['correo'];
        $valida->validaVacio($correo);
        $valida->VerificarrDireccionCorreo($correo);
        $valida->validaVacio($_REQUEST['contactar']);
        $valida->validarString($_REQUEST['contactar']);
        $valida->validaVacio($_REQUEST['contactarA']);
        $valida->validarString($_REQUEST['contactarA']);
        $area = $_REQUEST['area'];
        $valida->validaVacio($area);
        $valida->validarString($area);
        $asunto = $_REQUEST['asunto'];
        $valida->validaVacio($asunto);
        $valida->validarString($asunto);
        $dependencia = $_REQUEST['dependencia'];

        $valida->validarString($dependencia);
        $correoelec = $_REQUEST['correoelec'];
        $valida->validaVacio($correoelec);
        $valida->VerificarrDireccionCorreo($correoelec);
        $telefono = $_REQUEST['telefono'];

        $valida->alfanumerico($telefono);
        //end
        $valida->validaVacio($_REQUEST['captcha']);
        $carrera = $_REQUEST['programa'];
        $contactar= $_REQUEST['contactar']." ".$_REQUEST['contactarA'];
        $nombrecarrera = $contactar;

        if(isset($_REQUEST['programa'])&&$carrera!=null){
            $SQL = 'SELECT nombrecarrera FROM carrera WHERE codigocarrera = '.$carrera.' LIMIT 1';
            if($Nombrecarrera=&$db->Execute($SQL)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error en el SQL De Docente...<br>'.$SQL;
                echo json_encode($a_vectt);
                exit;
            } else {
                $nombrecarrera=$Nombrecarrera->fields['nombrecarrera'];
            }
        } else {
            $carrera=1;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Verificamos si el captcha es correcto
            //echo 'captcha->'.$_POST['captcha'] .'=='. $_SESSION['cap_code'].'<-cap_code';

            if ($_POST['captcha'] == $_SESSION['cap_code']) {

                $mensaje= "Captcha Correcto";
                $cap = 'Eq';
                $SQL = 'INSERT INTO LogRegistraCorreosComunicacion SET Nombre = "'.$nombrecompleto.'", Correo = "'.$correo.'", codigocarrera = '.$carrera.', Asunto = "'.$asunto.'", AContactar="'.$contactar.'" , Area="'.$area.'"';
                if($Select=&$db->Execute($SQL)===false){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error en el SQL De Docente...<br>'.$SQL;
                    echo json_encode($a_vectt);
                    exit;
                }
                $last_id = $db->Insert_ID();
                //$SQL = 'SELECT Correo FROM CorreosCarreras WHERE codigocarrera = '.$carrera;
                /*if($Select=&$db->Execute($SQL)===false){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error en el SQL De Docente...<br>'.$SQL;
                    echo json_encode($a_vectt);
                    exit;
                }*/

                //if($Select->_numOfRows != 0 || $Select->fields['Correo'] == NULL){
                $address = 'mesadeservicio@unbosque.edu.co';
//                            $address = 'vegagabriel@unbosque.edu.co';
                //}else{
                //	$address = $Select->fields['Correo'];
                //}

                require_once('phpmailer/class.phpmailer.php');
                $mail = new PHPMailer();
                /*
                * Agregar y modificar parametros para la presentacion del correo a mesa de servicio
                * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                * Universidad el Bosque - Dirección de Tecnología.
                * Modificado 7 de abril de 2016.
                */
                $body = '<page style="margin: 0; padding: 0; font-family: Verdana, Arial; font-size: 13px;">
                                <div style="width: 100%;">
                                    Buen d&iacute;a: 
                                    Si desea autorizar a la siguiente persona para que pueda comunicarse con usted, 
                                    favor reenvi&eacute; el correo a mesadeservico@unbosque.edu.co dando autorizaci&oacute;n.

                                    Bogot&aacute;. '.strftime("%d de %B de %Y").'

                                    Registro de correos

                                    Nombre completo: '.$nombrecompleto.'
                                    Correo a registrar: '.$correo.'
                                    &iquest;A quien desea contactar?: '.$contactar.'
                                    &Aacute;rea a contactar: '.$area.'
                                    Facultad y/o Dependencia: '.$dependencia.'
                                    Motivo de contacto: '.$asunto.'
                                    Correo a contactar: '.$correoelec.'
                                    Telefono o extension: '.$telefono.'

                                    Av. Cra 9 No. 131 A - 02 &middot; Edificio Fundadores &middot; 
                                    L&iacute;nea Gratuita 018000 113033 &middot; PBX (571) 6489000 &middot;  
                                    Bogot&aacute; D.C. - Colombia. 
                                </div>
                            </page>';
                //end
                $mail->SetFrom($address, 'Universidad El Bosque');
                $mail->AddReplyTo($address,"Universidad El Bosque");
                $mail->Subject = "Contacto desde la pagina web.";
                $mail->MsgHTML($body);
                $mail->AddAddress($address, $_POST['nombres']);
                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }else{
                    ?>
                    <script>
                        alert('Proceso correcto. Se notificara a la facultad en breve');
                        location.href='../../../../contacto/registrarCorreo.php';
                    </script>
                    <?php exit;
                }
            } else {
                $mensaje= "Captcha Incorrecto";
                $cap = '';
                ?>
                <script>
                    alert('<?php echo $mensaje?>');
                    location.href='Captcha_html.php?actionID=registra_correo';
                </script>
                <?php
            }
        }
    }break;
    case 'V_PlanDocente':{
        global $db;
        Main('1');


        $Num            = $_POST['Num'];
        $apellido_Pri   = $_POST['apellido_Pri'];
        $apellido_Sdo   = $_POST['apellido_Sdo'];
        $Nombre_Pri     = $_POST['Nombre_Pri'];
        $Nombre_Sdo     = $_POST['Nombre_Sdo'];

        $correo = $_POST['correo'];

        $Nom_Completo = $Nombre_Pri;
        $Ape_Completo = $apellido_Pri;

        $SQL_D='SELECT iddocente,nombredocente,apellidodocente,numerodocumento
                FROM docente
                WHERE   nombredocente LIKE "%'.$Nom_Completo.'%"
                        AND apellidodocente LIKE "%'.$Ape_Completo.'%"
                        AND numerodocumento="'.$Num.'"
                        AND codigoestado=100';

        if($Docente_E=&$db->Execute($SQL_D)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error en el SQL De Docente...<br>'.$SQL_D;
            echo json_encode($a_vectt);
            exit;

        }
        if(!empty($Docente_E)){

            $a_vectt['val'] = 'TRUE';
            $a_vectt['descrip'] = 'Bienvenido';
            $a_vectt['iddocente'] = $Docente_E->fields['iddocente'];
            echo json_encode($a_vectt);
            $sqlActualizarCorreo = 'UPDATE docente SET emaildocente = "'.$correo.'" WHERE iddocente = '.$a_vectt['iddocente'].'';
            $actualizarCorreo = &$db->Execute($sqlActualizarCorreo);
            exit;

        }else{
            $a_vectt['val'] = 'NO_Existe';
            $a_vectt['descrip'] = 'No Hay Datos en Nuestros Registros';
            echo json_encode($a_vectt);
            exit;
        }

    }break;
    case 'PlanDocente':{

        global $db;
        Main('0');

        $cap = 'notEq';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Verificamos si el captcha es correcto
            //echo 'captcha->'.$_POST['captcha'] .'=='. $_SESSION['cap_code'].'<-cap_code';

            if ($_POST['captcha'] == $_SESSION['cap_code']) {
                $mensaje= "Captcha Correcto";
                $cap = 'Eq';
                ?>
                <script>
                    $.ajax({//Ajax
                        type: 'POST',
                        url: 'validar.php',
                        async: false,
                        dataType: 'json',
                        data:({actionID: 'V_PlanDocente',
                            Num:'<?PHP echo $_POST['cedula']?>',
                            apellido_Pri:'<?PHP echo $_POST['Uno_apellido']?>',
                            apellido_Sdo:'<?PHP echo $_POST['Sdo_apellido']?>',
                            Nombre_Pri:'<?PHP echo $_POST['Uno_nombre']?>',
                            Nombre_Sdo:'<?PHP echo $_POST['Sdo_nombre']?>',
                            correo:'<?PHP echo $_POST['correo'] ?>'}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                        success: function(data){
                            if(data.val=='FALSE'){
                                alert(data.descrip);
                                return false;
                            }else if(data.val=='NO_Existe'){
                                /**********************************************/
                                alert(data.descrip);
                                location.href='Captcha_html.php?actionID=PlanDocente';
                                /**********************************************/
                            }else if(data.val=='TRUE'){
                                /*************************************/
                                alert(data.descrip);
                                location.href='../../../../PlanTrabajoDocenteV2/index.php?id_Docente='+data.iddocente;
                                /*************************************/
                            }
                        }
                    }); //AJAX

                </script>
                <?PHP
            } else {
                $mensaje= "Captcha Incorrecto";
                $cap = '';
                ?>
                <script>
                    alert('<?PHP echo $mensaje?>');
                    location.href='Captcha_html.php?actionID=PlanDocente';
                </script>
                <?PHP
            }
        }
    }break;
    case 'V_Docente':{
        global $db;
        Main('1');

        $Num            = $_POST['Num'];
        $apellido_Pri   = $_POST['apellido_Pri'];
        $apellido_Sdo   = $_POST['apellido_Sdo'];
        $Nombre_Pri     = $_POST['Nombre_Pri'];
        $Nombre_Sdo     = $_POST['Nombre_Sdo'];

        $Nom_Completo = $Nombre_Pri;
        $Ape_Completo = $apellido_Pri;


        $SQL_D='SELECT 

                        iddocente,
                        nombredocente,
                        apellidodocente,
                        numerodocumento,
                        modalidadocente
                FROM docente
                WHERE
                        nombredocente like "%'.$Nom_Completo.'%"
                        AND
                        apellidodocente like "%'.$Ape_Completo.'%" 
                        AND
                        numerodocumento="'.$Num.'"
                        AND
                        codigoestado=100';

        if($Docente_E=&$db->Execute($SQL_D)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error en el SQL De Docente...<br>'.$SQL_D;
            echo json_encode($a_vectt);
            exit;
        }



        $SQL='SELECT idusuario FROM usuario WHERE  numerodocumento ="'.$Num.'"  AND codigorol=2 ';

        if($Usuario=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Usuario...<br><br>'.$SQL;
            die;
        }

        $Userid = 0;

        if(!$Usuario->EOF){
            $Userid = $Usuario->fields['idusuario'];
        }


        $SQL_P='SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';

        if($PeriodoCodigo=&$db->Execute($SQL_P)===false){
            echo 'Error en el SQl de PeriodoCodigo ......<br><br>'.$SQL_P;
            die;
        }

        $CodigoPeriodo  = $PeriodoCodigo->fields['codigoperiodo'];




        if(!$Docente_E->EOF){
            /****************************************************************/
            $SQL_Instrumentos='SELECT 
                            
                                id_instrumento
                                
                                FROM 
                                
                                entradaredireccion
                                
                                WHERE
                                
                                now() between fechainicioentradaredireccion and fechafinalentradaredireccion  
                                AND
                                codigoestado=100
                                AND
                                id_instrumento<>""';

            if($Instrumentos=&$db->Execute($SQL_Instrumentos)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error en el SQL los Instrumentos...<br>'.$SQL_Instrumentos;
                echo json_encode($a_vectt);
                exit;
            }

            while(!$Instrumentos->EOF){
                /****************************************************************/

                $SQL_P='SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';

                if($PeriodoCodigo=&$db->Execute($SQL_P)===false){
                    echo 'Error en el SQl de PeriodoCodigo ......<br><br>'.$SQL_P;
                    die;
                }

                $CodigoPeriodo  = $PeriodoCodigo->fields['codigoperiodo'];


                if($Userid==0 || $Userid=='0'){
                    $Condicion  = 'numerodocumento="' . $Num . '"';
                }else{
                    $Condicion = '(numerodocumento="' . $Num . '" OR  usuarioid="'.$Userid.'")';
                }

                $SQL_Actualiza = 'SELECT 

            						idactualizacionusuario as id,  
            						estadoactualizacion
            
            						FROM 
            
            						actualizacionusuario  
            
            						WHERE  
            
            						'.$Condicion.' 
            						AND
            						id_instrumento="' .$Instrumentos->fields['id_instrumento']. '"
            						AND
            						codigoestado=100
                                    AND
                                    estadoactualizacion=2';

                if($Contestado=&$db->Execute($SQL_Actualiza)===false){
                    echo 'Error en el sql Actualizado...<br><br>'.$SQL_Actualiza;
                    die;
                }


                if($Contestado->EOF){

                    /****************************************************************/
                    $SQL_Publico='SELECT * 
                                
                                FROM 
                                
                                siq_Apublicoobjetivo 
                                
                                WHERE
                                
                                idsiq_Ainstrumentoconfiguracion="'.$Instrumentos->fields['id_instrumento'].'"
                                AND
                                codigoestado=100';

                    if($Publico=&$db->Execute($SQL_Publico)===false){
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'Error en el SQL del Publico...<br>'.$SQL_Publico;
                        echo json_encode($a_vectt);
                        exit;

                    }

                    if(!$Publico->EOF){
                        /***************************************************/
                        $Publico_id  = $Publico->fields['idsiq_Apublicoobjetivo'];
                        /***************************************************/
                        $SQL_D='SELECT * 
                    
                        		FROM 
                        				siq_Adetallepublicoobjetivo 
                        		WHERE 
                        				idsiq_Apublicoobjetivo="'.$Publico_id.'" 
                        				AND 
                        				codigoestado=100';

                        if($DetallePublico=&$db->Execute($SQL_D)===false){
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] = 'Error en el SQl del Detalle del Publico Detalle...<br><br>'.$SQL_D;
                            echo json_encode($a_vectt);
                            exit;

                        }

                        $E_DPublico	= $DetallePublico->GetArray();

                        // echo '<pre>';print_r($E_DPublico);
                        /*
                        [4] => Array
                             (
                                 [0] => 17
                                 [idsiq_Adetallepublicoobjetivo] => 17
                                 [1] => 17
                                 [idsiq_Apublicoobjetivo] => 17
                                 [2] =>
                                 [tipoestudiante] =>
                                 [3] =>
                                 [E_New] =>
                                 [4] =>
                                 [E_Old] =>
                                 [5] =>
                                 [E_Egr] =>
                                 [6] =>
                                 [E_Gra] =>
                                 [7] =>
                                 [filtro] =>
                                 [8] =>
                                 [semestre] =>
                                 [9] => 300
                                 [modalidadsic] => 300
                                 [10] =>
                                 [codigocarrera] =>
                                 [11] =>
                                 [cadena] =>
                                 [12] =>
                                 [tipocadena] =>
                                 [13] => 15344
                                 [userid] => 15344
                                 [14] => 2013-10-02 16:18:41
                                 [entrydate] => 2013-10-02 16:18:41
                                 [15] => 100
                                 [codigoestado] => 100
                                 [16] => 15344
                                 [userid_estado] => 15344
                                 [17] => 2013-10-02
                                 [changedate] => 2013-10-02
                                 [18] => 1
                                 [docente] => 1
                                 [19] => ::2::6::5
                                 [modalidadocente] => ::2::6::5
                             )*/

                        $C_ModalidaDocente  = explode('::',$E_DPublico[4]['modalidadocente']);

                        for($i=1;$i<count($C_ModalidaDocente);$i++){
                            if($C_ModalidaDocente[$i]==$Docente_E->fields['modalidadocente']){
                                /***************************************/
                                $a_vectt['val'] = 'Exite';
                                $a_vectt['descrip'] = 'Bienvenido.';
                                //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                $a_vectt['Instrumento'] = $Instrumentos->fields['id_instrumento'];
                                $a_vectt['Userid'] = $Userid;
                                echo json_encode($a_vectt);
                                exit;
                                /***************************************/
                            }
                        }
                        /***************************************************/
                    } //if
                    /****************************************************************/

                }//$ValidaInstrumentos->EOF
                /****************************************************************/
                $Instrumentos->MoveNext();
            }
            /****************************************************************/
        }else{
            $a_vectt['val'] = 'NO_Exite';
            $a_vectt['descrip'] = 'Los Datos Suministrados No Coinciden';
            echo json_encode($a_vectt);
            exit;
        }//if

        /**********************************************/
        $a_vectt['val'] = 'NO_Exite';
        $a_vectt['descrip'] = 'No Tiene Instrumentos o Encuestas Disponibles';
        echo json_encode($a_vectt);
        exit;
        /**********************************************/

    }break;
    case 'Doncente':{

        global $db;
        Main('0');

        $cap = 'notEq';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Verificamos si el captcha es correcto
            //echo 'captcha->'.$_POST['captcha'] .'=='. $_SESSION['cap_code'].'<-cap_code';

            if ($_POST['captcha'] == $_SESSION['cap_code']) {

                $mensaje= "Captcha Correcto";
                $cap = 'Eq';
                ?>
                <script>
                    $.ajax({//Ajax
                        type: 'POST',
                        url: 'validar.php',
                        async: false,
                        dataType: 'json',
                        data:({actionID: 'V_Docente',
                            Num:'<?PHP echo $_POST['cedula']?>',
                            apellido_Pri:'<?PHP echo $_POST['Uno_apellido']?>',
                            apellido_Sdo:'<?PHP echo $_POST['Sdo_apellido']?>',
                            Nombre_Pri:'<?PHP echo $_POST['Uno_nombre']?>',
                            Nombre_Sdo:'<?PHP echo $_POST['Sdo_nombre']?>'}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                        success: function(data){
                            if(data.val=='FALSE'){
                                alert(data.descrip);
                                return false;
                            }else if(data.val=='NO_Exite'){
                                /**********************************************/
                                alert(data.descrip);
                                location.href='Captcha_html.php?actionID=Doncente';
                                /**********************************************/
                            }else if(data.val='Exite'){
                                /*************************************/
                                alert(data.descrip);
                                //location.href='Captcha_html.php?actionID=Doncente';
                                location.href='../instrumento_aplicar.php?id_instrumento='+data.Instrumento+'&Ver=1&n=<?PHP echo $_POST['cedula']?>&Userid='+data.Userid;
                                /*************************************/
                            }
                        }
                    }); //AJAX

                </script>
                <?PHP
            } else {
                $mensaje= "Captcha Incorrecto";
                $cap = '';
                ?>
                <script>
                    alert('<?PHP echo $mensaje?>');
                    location.href='Captcha_html.php?actionID=Doncente';
                </script>
                <?PHP
            }
        }

    }break;
    case 'Carreras':{
        global $db;
        Main('1');

        $SQL_C='SELECT 
                    
                    codigocarrera,
                    nombrecarrera
                    
                    FROM 
                    
                    carrera
                    
                    WHERE
                    
                    codigomodalidadacademica="'.$_POST['modalidad'].'"
                    AND
                    codigocarrera NOT IN (1,2,3)';

        if($Carrera=&$db->Execute($SQL_C)===false){
            echo 'Error en el SQL de la Carrera..<br><br>'.$SQL_C;
            die;
        }

        ?>
        <select id="Carrera" name="Carrera">
            <option value="0"></option>
            <?PHP
            while(!$Carrera->EOF){
                /****************************************************/
                ?>
                <option id="<?PHP echo $Carrera->fields['codigocarrera']?>"><?PHP echo $Carrera->fields['nombrecarrera']?></option>
                <?PHP
                /****************************************************/
                $Carrera->MoveNext();
            }
            ?>
        </select>
        <?PHP

    }break;
    case 'V_Externo':{
        global $db;
        Main('1');

        // echo "InstrumentoDario ".$_POST['id_instrumento']; No hay info en la variable
        $Num            = $_POST['Num'];
        $apellido_Pri   = $_POST['apellido_Pri'];
        $apellido_Sdo   = $_POST['apellido_Sdo'];
        $Nombre_Pri     = $_POST['Nombre_Pri'];
        $Nombre_Sdo     = $_POST['Nombre_Sdo'];
        $Correo        = $_POST['Correo'];
        $Telefono        = $_POST['Telefono'];
        $Colegio        =$_POST['Colegio'];
        $IDColegio     =$_POST['IDColegio'];
        $IDinstru      =$_POST['id_instrumento'];


        $Nom_Completo = $Nombre_Pri.' '.$Nombre_Sdo;
        $Ape_Completo = $apellido_Pri.' '.$apellido_Sdo;


        $SQL_G='SELECT * from siq_Apublicoobjetivocsv WHERE cedula='.$Num.' ';
        //echo $SQL_G;

        if($ExisteGraduado=&$db->Execute($SQL_G)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error en el SQl de Busqueda de Requistro....<br><br>' . $SQL_G;
            echo json_encode($a_vectt);
            exit;
        }

        if(!$ExisteGraduado->EOF){
            $sql_V="SELECT * FROM sala.siq_Arespuestainstrumento where cedula='".$Num."' limit 1";
            //echo $sql_V;
            $ExisteRes=&$db->Execute($sql_V);
            // $DExisteRes=$ExisteRes->GetArray();
            //$tr=count($DExisteRes);

            if(!$ExisteRes->EOF){
                // print_r($ExisteRes);
                $Publico_id  = $ExisteRes->fields['cedula'];
                //echo '<-->>>>>'.$ExisteRes->fields['cedula'];
                if(!empty($Publico_id)){
                    $a_vectt['val'] = 'TRUE';
                    $a_vectt['descrip'] = 'Ya esta registrado, puede ver sus resultados';
                    $a_vectt['IDIn'] = $ExisteRes->fields['idsiq_Ainstrumentoconfiguracion'];
                }else{
                    $a_vectt['val'] = 'NO_Existe';
                    $a_vectt['descrip'] = 'Se registro Exitosamente';
                }
            }else{
                $a_vectt['val'] = 'NO_Existe';
                $a_vectt['descrip'] = 'Se registro Exitosamente';
            }
        }else{
            $sql_Pu="SELECT * FROM siq_Apublicoobjetivo where idsiq_Ainstrumentoconfiguracion='".$IDinstru."' ";
            //echo $sql_Pu;
            $ExistePu=&$db->Execute($sql_Pu);
            if(!$ExistePu->EOF){
                $idPublico  = $ExistePu->fields['idsiq_Apublicoobjetivo'];
            }
            $sql_in="INSERT INTO siq_Apublicoobjetivocsv  set
                        idsiq_Apublicoobjetivo='$idPublico', cedula='$Num', nombre='$Nom_Completo', apellido='$Ape_Completo', 
                        correo='$Correo', telefono='$Telefono',prueba_intereses=1, colegio='$Colegio', idinstitucioneducativa='$IDColegio', codigoestado=100, fechacreacion='".date('Y-m-d G:i:s')."' ";
            //echo $sql_in;
            //if($Insert=&$db->Execute($sql_in)===false){
            if($Insert_Doc=&$db->Execute($sql_in)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR '.$sql_in;
            }else{
                $a_vectt['val'] = 'NO_Existe';
                $a_vectt['descrip'] = 'Se registro Exitosamente';

            }

        }
        echo json_encode($a_vectt);
        exit;

    }break;


    ///////////////////////////agregado especial para encuesta bienestar laboral
    case 'Bienestar_laboral':{
        global $db;
        Main('1');


        $Num            = $_POST['Num'];

        $Correo        = "a@anonimo.com";
        $Telefono        = "0000000";
        $IDinstru      =$_POST['id_instrumento'];
        $texto        =$_POST['dependencia'];
        $texto2        =$_POST['area'];
        $texto3        =$_POST['tipoencuestado'];

        $Nom_Completo = "AAAAAAA";
        $Ape_Completo = "BBBBBBB";


        $SQL_G='SELECT * from siq_Apublicoobjetivocsv WHERE cedula='.$Num.' ';
        //echo $SQL_G;

        if($ExisteGraduado=&$db->Execute($SQL_G)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error en el SQl de Busqueda de Requistro....<br><br>' . $SQL_G;
            echo json_encode($a_vectt);
            exit;
        }

        if(!$ExisteGraduado->EOF){
            $sql_V="SELECT * FROM sala.siq_Arespuestainstrumento where cedula='".$Num."' limit 1";
            //echo $sql_V;
            $ExisteRes=&$db->Execute($sql_V);
            // $DExisteRes=$ExisteRes->GetArray();
            //$tr=count($DExisteRes);

            if(!$ExisteRes->EOF){
                // print_r($ExisteRes);
                $Publico_id  = $ExisteRes->fields['cedula'];
                //echo '<-->>>>>'.$ExisteRes->fields['cedula'];
                if(!empty($Publico_id)){
                    $a_vectt['val'] = 'TRUE';
                    $a_vectt['descrip'] = 'Ya esta registrado, puede ver sus resultados';
                    $a_vectt['IDIn'] = $ExisteRes->fields['idsiq_Ainstrumentoconfiguracion'];
                }else{
                    $a_vectt['val'] = 'NO_Existe';
                    $a_vectt['descrip'] = 'Se registro Exitosamente';
                }
            }else{
                $a_vectt['val'] = 'NO_Existe';
                $a_vectt['descrip'] = 'Se registro Exitosamente';
            }
        }else{
            $sql_Pu="SELECT * FROM siq_Apublicoobjetivo where idsiq_Ainstrumentoconfiguracion='".$IDinstru."' ";
            //echo $sql_Pu;
            $ExistePu=&$db->Execute($sql_Pu);
            if(!$ExistePu->EOF){
                $idPublico  = $ExistePu->fields['idsiq_Apublicoobjetivo'];
            }
            $sql_in="INSERT INTO siq_Apublicoobjetivocsv  set
                        idsiq_Apublicoobjetivo='$idPublico', cedula='$Num', nombre='$Nom_Completo', apellido='$Ape_Completo',colegio='$texto3',
                        correo='$Correo', codigoestado=100, fechacreacion='".date('Y-m-d G:i:s')."',usuariocreacion=0000
                        ,texto='$texto',texto2='$texto2',texto3='$texto3', estudiante=0,docente=0,padre=0,vecinos=0,practica=0,docencia_servicio=0,administrativos=1,otros=0";
            //echo $sql_in;
            //if($Insert=&$db->Execute($sql_in)===false){
            if($Insert_Doc=&$db->Execute($sql_in)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR '.$sql_in;
            }else{
                $a_vectt['val'] = 'NO_Existe';
                $a_vectt['descrip'] = 'Se registro Exitosamente';

            }

        }
        echo json_encode($a_vectt);
        exit;

    }break;
    case 'Externo':{
        global $db;
        Main('0');
        //Si es pra personal externo
        $cap = 'notEq';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Verificamos si el captcha es correcto
            //echo 'captcha->'.$_POST['captcha'] .'=='. $_SESSION['cap_code'].'<-cap_code';

            if ($_POST['captcha'] == $_SESSION['cap_code']) {

                $mensaje= "Captcha Correcto";
                $cap = 'Eq';
                ?>
                <script>
                    var instrumento = $('#id_instrumento').val();
                    alert (instrumento);
                    $.ajax({//Ajax
                        type: 'POST',
                        url: 'validar.php',
                        async: false,
                        dataType: 'json',
                        data:({actionID: 'V_Externo',
                            Num:'<?PHP echo $_POST['cedula']?>',
                            apellido_Pri:'<?PHP echo $_POST['Uno_apellido']?>',
                            apellido_Sdo:'<?PHP echo $_POST['Sdo_apellido']?>',
                            Nombre_Pri:'<?PHP echo $_POST['Uno_nombre']?>',
                            Nombre_Sdo:'<?PHP echo $_POST['Sdo_nombre']?>',
                            Correo:'<?PHP echo $_POST['correo']?>',
                            id_instrumento:'<?PHP echo $_POST['IDIn']?>',
                            Colegio:'<?PHP echo $_POST['colegio']?>',
                            Telefono:'<?PHP echo $_POST['telefono']?>',
                            IDColegio:'<?PHP echo $_POST['idinstitucioneducativa']?>'}),
                        success: function(data){
                            // alert(data.val);
                            if(data.val=='FALSE'){
                                alert(data.descrip);
                                return false;
                            }else if(data.val=='NO_Existe'){

                                alert(data.descrip);
                                location.href='../instrumento_aplicar_obs.php?id_instrumento=<?PHP echo $_POST['IDIn']?>&Ver=1&n=<?PHP echo $_POST['cedula']?>&tipoP=PIN';
                                /**********************************************/
                            }else if(data.val=='Exite'){
                                alert(data.descrip);
                                location.href='../instrumento_aplicar_obs.php?id_instrumento=<?PHP echo $_POST['IDIn']?>&Ver=1&n=<?PHP echo $_POST['cedula']?>&tipoP=PIN';
                            }else if(data.val=='TRUE'){
                                //alert(data.descrip);
                                location.href='../resultados_prueba_interes.php?id='+data.IDIn+'&cedula=<?PHP echo $_POST['cedula']?>&tipoP=PIN';
                            }
                        }
                    }); //AJAX

                </script>                <?PHP
            } else {
                $mensaje= "Captcha Incorrecto";
                $cap = '';
                ?>
                <script>
                    alert('<?PHP echo $mensaje?>');
                    location.href='Captcha_html.php?actionID=Externo';
                </script>
                <?PHP
            }
        }



    }break;
    case 'V_Graduado':{
        global $db;
        Main('1');


        $Num            = $_POST['Num'];
        $apellido_Pri   = $_POST['apellido_Pri'];
        $apellido_Sdo   = $_POST['apellido_Sdo'];
        $Nombre_Pri     = $_POST['Nombre_Pri'];
        $Nombre_Sdo     = $_POST['Nombre_Sdo'];
        $Carrera        = $_POST['Carrera'];
        $modalida       = $_POST['modalida'];

        $Nom_Completo = $Nombre_Pri;
        $Ape_Completo = $apellido_Pri;

        $SQL_GN='SELECT 

                            eg.nombresestudiantegeneral,
                            eg.apellidosestudiantegeneral,
                            eg.numerodocumento,
                            SUBSTRING(DATE_FORMAT(rg.fechagradoregistrograduado, "%Y-%m-%d"),1,4) as year,
                            SUBSTRING(DATE_FORMAT(rg.fechagradoregistrograduado, "%Y-%m-%d"),6,2) as mes
                            
                            
                            FROM 
                            
                            registrograduado  rg INNER JOIN estudiante e ON e.codigoestudiante=rg.codigoestudiante
                            					 INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                            
                            WHERE
                            
                            (eg.nombresestudiantegeneral LIKE "%'.$Nom_Completo.'%"  AND  eg.apellidosestudiantegeneral LIKE "%'.$Ape_Completo.'%")
                            AND
                            eg.numerodocumento="'.$Num.'"
                            
                            ORDER BY rg.fecharegistrograduado ASC';

        if($ExisteGraduado=&$db->Execute($SQL_GN)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error en el SQl de Busqueda de Requistro....<br><br>' . $SQL_GN;
            echo json_encode($a_vectt);
            exit;
        }
        $ExisteGraduadoAntiguo = null;
        /*********************************************************************************************/
        if($ExisteGraduado->EOF){

            $SQL_G='SELECT 

                rga.nombreregistrograduadoantiguo,
                rga.documentoegresadoregistrograduadoantiguo,
                SUBSTRING(DATE_FORMAT(rga.fechagradoregistrograduadoantiguo, "%Y-%m-%d"),1,4) as year,
                SUBSTRING(DATE_FORMAT(rga.fechagradoregistrograduadoantiguo, "%Y-%m-%d"),6,2) as mes
                
                FROM 
                
                registrograduadoantiguo rga INNER JOIN estudiante e ON e.codigoestudiante=rga.codigoestudiante 
                                            INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                
                WHERE
                
                (eg.nombresestudiantegeneral LIKE "%'.$Nom_Completo.'%" AND eg.apellidosestudiantegeneral LIKE "%'.$Ape_Completo.'%")
                AND
                rga.documentoegresadoregistrograduadoantiguo="'.$Num.'"
                
                ORDER BY fechagradoregistrograduadoantiguo ASC';

            if($ExisteGraduadoAntiguo=&$db->Execute($SQL_G)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error en el SQl de Busqueda de Requistro....<br><br>' . $SQL_G;
                echo json_encode($a_vectt);
                exit;
            }
        }

        $SQL='SELECT idusuario FROM usuario WHERE  numerodocumento ="'.$Num.'"  AND codigorol=1 ';

        if($Usuario=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Usuario...<br><br>'.$SQL;
            die;
        }

        $Userid = 0;

        if(!$Usuario->EOF){
            $Userid = $Usuario->fields['idusuario'];
        }


        $SQL_P='SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';

        if($PeriodoCodigo=&$db->Execute($SQL_P)===false){
            echo 'Error en el SQl de PeriodoCodigo ......<br><br>'.$SQL_P;
            die;
        }

        $CodigoPeriodo  = $PeriodoCodigo->fields['codigoperiodo'];

        /**********************************************************************************************************************************/

        if($ExisteGraduadoAntiguo!==null && !$ExisteGraduadoAntiguo->EOF){
            /******************************************************************/
            $TiempoGrado = '';

            $arrayP = str_split($CodigoPeriodo, strlen($CodigoPeriodo)-1);

            $year_Actual = $arrayP[0];

            $Mes = date('m');

            $TiempoGrado  =  $year_Actual-$ExisteGraduadoAntiguo->fields['year'];

            if($TiempoGrado!=0){
                if($ExisteGraduadoAntiguo->fields['year']<=$Mes){
                    $TiempoGrado       = $TiempoGrado;
                }else{
                    $TiempoGrado       = $TiempoGrado-1;
                }
            }


            if($Userid==0 || $Userid=='0'){
                $Condicion  = 'numerodocumento="' . $Num . '"';
            }else{
                $Condicion = '(numerodocumento="' . $Num . '" OR  usuarioid="'.$Userid.'")';
            }

            $SQL_Instrumentos='SELECT 
                            
                                er.id_instrumento
                                
                                FROM 
                                
                                entradaredireccion er 
                                        INNER JOIN siq_Apublicoobjetivo po ON po.idsiq_Ainstrumentoconfiguracion=er.id_instrumento
                                        INNER JOIN siq_Adetallepublicoobjetivo dpo ON dpo.idsiq_Apublicoobjetivo=po.idsiq_Apublicoobjetivo 
                                        AND dpo.E_Gra=1 
                                
                                WHERE
                                
                                now() between er.fechainicioentradaredireccion and er.fechafinalentradaredireccion  
                                AND
                                er.codigoestado=100
                                AND
                                er.id_instrumento<>""';

            if($Instrumentos=&$db->Execute($SQL_Instrumentos)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error en el SQL los Instrumentos...<br>'.$SQL_Instrumentos;
                echo json_encode($a_vectt);
                exit;
            }

            $Instrumentos_array = $Instrumentos->GetArray();

            // POR AHORA PARA QUE SALGAN A LA LOCA!
            shuffle($Instrumentos_array);
            $cont = 0;
            while(count($Instrumentos_array)>0 && $cont<count($Instrumentos_array)){
                $id_instrumento = $Instrumentos_array[$cont]['id_instrumento'];
                /****************************************************************/

                /*$SQL_P='SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';

				if($PeriodoCodigo=&$db->Execute($SQL_P)===false){
					echo 'Error en el SQl de PeriodoCodigo ......<br><br>'.$SQL_P;
					die;
				}

                $CodigoPeriodo  = $PeriodoCodigo->fields['codigoperiodo'];*/

                if($id_instrumento!=67 && $id_instrumento!=68 && $id_instrumento!=69 && $id_instrumento!=70
                    && $id_instrumento!=71 && $id_instrumento!=72) {
                    $SQL_Actualiza = 'SELECT 

            						idactualizacionusuario as id,  
            						estadoactualizacion
            
            						FROM 
            
            						actualizacionusuario  
            
            						WHERE  
            
            						'.$Condicion.' 
            						AND
            						id_instrumento="' .$id_instrumento. '"
            						
            						AND
            						codigoestado=100
                                    AND
                                    estadoactualizacion=2';
                } else {
                    //POR AHORA PARA QUE SI CONTESTO 1 NO LO OBLIGUE A CONTESTAR MAS
                    $SQL_Actualiza = 'SELECT 

            						idactualizacionusuario as id,  
            						estadoactualizacion
            
            						FROM 
            
            						actualizacionusuario  
            
            						WHERE  
            
            						'.$Condicion.' 
            						AND
            						id_instrumento IN (67,68,69,70,71,72) 
            						
            						AND
            						codigoestado=100
                                    AND
                                    estadoactualizacion=2';
                }
                if($Contestado=&$db->Execute($SQL_Actualiza)===false){
                    echo 'Error en el sql Actualizado...<br><br>'.$SQL_Actualiza;
                    die;
                }


                if($Contestado->EOF){

                    /****************************************************************/
                    $SQL_Publico='SELECT * 
                                            
                                            FROM 
                                            
                                            siq_Apublicoobjetivo 
                                            
                                            WHERE
                                            
                                            idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"
                                            AND
                                            codigoestado=100';

                    if($Publico=&$db->Execute($SQL_Publico)===false){
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'Error en el SQL del Publico...<br>'.$SQL_Publico;
                        echo json_encode($a_vectt);
                        exit;

                    }

                    if(!$Publico->EOF){
                        /***************************************************/
                        $Publico_id  = $Publico->fields['idsiq_Apublicoobjetivo'];
                        /***************************************************/
                        $SQL_D='SELECT * 
                                
                                    		FROM 
                                    				siq_Adetallepublicoobjetivo 
                                    		WHERE 
                                    				idsiq_Apublicoobjetivo="'.$Publico_id.'" 
                                    				AND 
                                    				codigoestado=100';

                        if($DetallePublico=&$db->Execute($SQL_D)===false){
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] = 'Error en el SQl del Detalle del Publico Detalle...<br><br>'.$SQL_D;
                            echo json_encode($a_vectt);
                            exit;

                        }

                        $E_DPublico	= $DetallePublico->GetArray();

                        //echo '<pre>';print_r($E_DPublico); die;
                        /*
                        [3] => Array
                             (
                                 [0] => 17
                                 [idsiq_Adetallepublicoobjetivo] => 17
                                 [1] => 17
                                 [idsiq_Apublicoobjetivo] => 17
                                 [2] =>
                                 [tipoestudiante] =>
                                 [3] =>
                                 [E_New] =>
                                 [4] =>
                                 [E_Old] =>
                                 [5] =>
                                 [E_Egr] =>
                                 [6] =>
                                 [E_Gra] => 1
                                 [7] =>
                                 [filtro] =>
                                 [8] =>
                                 [semestre] =>
                                 [9] => 300
                                 [modalidadsic] => 3 ->Pregrado Posggrado  200 pregrado 300 posgrado
                                 [10] =>
                                 [codigocarrera] =>
                                 [11] =>
                                 [cadena] =>
                                 [12] =>
                                 [tipocadena] =>
                                 [13] => 15344
                                 [userid] => 15344
                                 [14] => 2013-10-02 16:18:41
                                 [entrydate] => 2013-10-02 16:18:41
                                 [15] => 100
                                 [codigoestado] => 100
                                 [16] => 15344
                                 [userid_estado] => 15344
                                 [17] => 2013-10-02
                                 [changedate] => 2013-10-02
                                 [18] => 1
                                 [docente] => 1
                                 [19] => ::2::6::5
                                 [modalidadocente] => ::2::6::5
                                 [20] => 0
                                 [recienegresado] => 0
                                 [21] => 0
                                 [consolidacionprofesional] => 0
                                 [22] => 0
                                 [senior] => 0
                             )*/

                        if($E_DPublico[3]['E_Gra']==1){

                            if($E_DPublico[3]['modalidadsic']==3){

                                if($E_DPublico[3]['recienegresado']==1){

                                    /*0-5 a�os*/
                                    if($TiempoGrado>=0 && $TiempoGrado<=5){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }

                                if($E_DPublico[3]['consolidacionprofesional']==1){

                                    /*6-34 a�os*/

                                    if($TiempoGrado>=6 && $TiempoGrado<=34){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }

                                if($E_DPublico[3]['senior']==1){

                                    /*Mayor a 35*/

                                    if($TiempoGrado>=35){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }

                            }else if($E_DPublico[3]['modalidadsic']==$modalida){

                                if($E_DPublico[3]['recienegresado']==1){

                                    /*0-5 a�os*/

                                    if($TiempoGrado>=0 && $TiempoGrado<=5){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }

                                if($E_DPublico[3]['consolidacionprofesional']==1){

                                    /*6-34 a�os*/

                                    if($TiempoGrado>=6 && $TiempoGrado<=34){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }

                                if($E_DPublico[3]['senior']==1){

                                    /*Mayor a 35*/

                                    if($TiempoGrado>=35){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }

                            }//

                        }//if

                        /***************************************************/
                    } //if
                    /****************************************************************/

                }//$ValidaInstrumentos->EOF
                /****************************************************************/
                //$Instrumentos->MoveNext();
                $cont++;
            }
            /******************************************************************/
        }else if(!$ExisteGraduado->EOF ){
            /*********************************************************************/
            $TiempoGrado  = '';
            $arrayP = str_split($CodigoPeriodo, strlen($CodigoPeriodo)-1);

            $year_Actual = $arrayP[0];

            $Mes = date('m');

            $TiempoGrado  =  $year_Actual-$ExisteGraduado->fields['year'];

            if($TiempoGrado!=0){
                if($ExisteGraduado->fields['year']<=$Mes){
                    $TiempoGrado       = $TiempoGrado;
                }else{
                    $TiempoGrado       = $TiempoGrado-1;
                }
            }


            if($Userid==0 || $Userid=='0'){
                $Condicion  = 'numerodocumento="' . $Num . '"';
            }else{
                $Condicion = '(numerodocumento="' . $Num . '" OR  usuarioid="'.$Userid.'")';
            }

            //Verificar si hay alguno que deje por la mitad
            /*$SQL_Instrumentos='SELECT

                              er.id_instrumento

                              FROM

                              entradaredireccion er
                              INNER JOIN siq_Apublicoobjetivo po ON po.idsiq_Ainstrumentoconfiguracion=er.id_instrumento
                              INNER JOIN siq_Adetallepublicoobjetivo dpo ON dpo.idsiq_Apublicoobjetivo=po.idsiq_Apublicoobjetivo
                              AND dpo.E_Gra=1
                              WHERE
                              now() between er.fechainicioentradaredireccion and er.fechafinalentradaredireccion
                              AND
                              er.codigoestado=100
                              AND
                              er.id_instrumento<>""
          AND er.id_instrumento IN (SELECT id_instrumento FROM actualizacionusuario
                              WHERE ('.$Condicion.') and codigoperiodo="' . $CodigoPeriodo . '"
                              and estadoactualizacion=1)';
          if($Instrumentos=&$db->Execute($SQL_Instrumentos)===false){
                          $a_vectt['val'] = 'FALSE';
                          $a_vectt['descrip'] = 'Error en el SQL los Instrumentos...<br>'.$SQL_Instrumentos;
                          echo json_encode($a_vectt);
                          exit;
                     }
           $Instrumentos_array = $Instrumentos->GetArray();
           if(count($Instrumentos_array)==0){*/
            $SQL_Instrumentos='SELECT 

                                            er.id_instrumento

                                            FROM 

                                            entradaredireccion er
                                            INNER JOIN siq_Apublicoobjetivo po ON po.idsiq_Ainstrumentoconfiguracion=er.id_instrumento
                                            INNER JOIN siq_Adetallepublicoobjetivo dpo ON dpo.idsiq_Apublicoobjetivo=po.idsiq_Apublicoobjetivo 
                                            AND dpo.E_Gra=1 

                                            WHERE

                                            now() between er.fechainicioentradaredireccion and er.fechafinalentradaredireccion  
                                            AND
                                            er.codigoestado=100
                                            AND
                                            er.id_instrumento<>""';

            if($Instrumentos=&$db->Execute($SQL_Instrumentos)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error en el SQL los Instrumentos...<br>'.$SQL_Instrumentos;
                echo json_encode($a_vectt);
                exit;
            }


            $Instrumentos_array = $Instrumentos->GetArray();
            // }
            // POR AHORA PARA QUE SALGAN A LA LOCA!
            shuffle($Instrumentos_array);
            $cont = 0;
            while(count($Instrumentos_array)>0 && $cont<count($Instrumentos_array)){
                $id_instrumento = $Instrumentos_array[$cont]['id_instrumento'];
                /****************************************************************/

                /*$SQL_P='SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';

                if($PeriodoCodigo=&$db->Execute($SQL_P)===false){
                    echo 'Error en el SQl de PeriodoCodigo ......<br><br>'.$SQL_P;
                    die;
                }

                $CodigoPeriodo  = $PeriodoCodigo->fields['codigoperiodo'];*/

                //POR AHORA PARA QUE SI CONTESTO 1 NO LO OBLIGUE A CONTESTAR MAS
                if($id_instrumento!=67 && $id_instrumento!=68 && $id_instrumento!=69 && $id_instrumento!=70
                    && $id_instrumento!=71 && $id_instrumento!=72) {
                    $SQL_Actualiza = 'SELECT 
        
                    						idactualizacionusuario as id,  
                    						estadoactualizacion
                    
                    						FROM 
                    
                    						actualizacionusuario  
                    
                    						WHERE  
                    
                    						'.$Condicion.' 
                    						AND
                    						id_instrumento="' .$id_instrumento. '"
                    						AND
                    						codigoperiodo="' . $CodigoPeriodo . '"
                    						AND
                    						codigoestado=100
                                            AND
                                            estadoactualizacion=2';
                } else {

                    $SQL_Actualiza = 'SELECT 

            						idactualizacionusuario as id,  
            						estadoactualizacion
            
            						FROM 
            
            						actualizacionusuario  
            
            						WHERE  
            
            						'.$Condicion.' 
            						AND
            						id_instrumento IN (67,68,69,70,71,72) 
            						AND
            						codigoperiodo="' . $CodigoPeriodo . '"
            						AND
            						codigoestado=100
                                    AND
                                    estadoactualizacion=2';
                }
                if($Contestado=&$db->Execute($SQL_Actualiza)===false){
                    echo 'Error en el sql Actualizado...<br><br>'.$SQL_Actualiza;
                    die;
                }


                if($Contestado->EOF){

                    /****************************************************************/
                    $SQL_Publico='SELECT * 
                                                    
                                                    FROM 
                                                    
                                                    siq_Apublicoobjetivo 
                                                    
                                                    WHERE
                                                    
                                                    idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"
                                                    AND
                                                    codigoestado=100';

                    if($Publico=&$db->Execute($SQL_Publico)===false){
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'Error en el SQL del Publico...<br>'.$SQL_Publico;
                        echo json_encode($a_vectt);
                        exit;

                    }

                    if(!$Publico->EOF){
                        /***************************************************/
                        $Publico_id  = $Publico->fields['idsiq_Apublicoobjetivo'];
                        /***************************************************/
                        $SQL_D='SELECT * 
                                        
                                            		FROM 
                                            				siq_Adetallepublicoobjetivo 
                                            		WHERE 
                                            				idsiq_Apublicoobjetivo="'.$Publico_id.'" 
                                            				AND 
                                            				codigoestado=100';

                        if($DetallePublico=&$db->Execute($SQL_D)===false){
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] = 'Error en el SQl del Detalle del Publico Detalle...<br><br>'.$SQL_D;
                            echo json_encode($a_vectt);
                            exit;

                        }

                        $E_DPublico	= $DetallePublico->GetArray();

                        //echo '<pre>';print_r($E_DPublico);
                        /*
                        [3] => Array
                             (
                                 [0] => 17
                                 [idsiq_Adetallepublicoobjetivo] => 17
                                 [1] => 17
                                 [idsiq_Apublicoobjetivo] => 17
                                 [2] =>
                                 [tipoestudiante] =>
                                 [3] =>
                                 [E_New] =>
                                 [4] =>
                                 [E_Old] =>
                                 [5] =>
                                 [E_Egr] =>
                                 [6] =>
                                 [E_Gra] => 1
                                 [7] =>
                                 [filtro] =>
                                 [8] =>
                                 [semestre] =>
                                 [9] => 300
                                 [modalidadsic] => 3 ->Pregrado Posggrado  200 pregrado 300 posgrado
                                 [10] =>
                                 [codigocarrera] =>
                                 [11] =>
                                 [cadena] =>
                                 [12] =>
                                 [tipocadena] =>
                                 [13] => 15344
                                 [userid] => 15344
                                 [14] => 2013-10-02 16:18:41
                                 [entrydate] => 2013-10-02 16:18:41
                                 [15] => 100
                                 [codigoestado] => 100
                                 [16] => 15344
                                 [userid_estado] => 15344
                                 [17] => 2013-10-02
                                 [changedate] => 2013-10-02
                                 [18] => 1
                                 [docente] => 1
                                 [19] => ::2::6::5
                                 [modalidadocente] => ::2::6::5
                             )*/

                        if($E_DPublico[3]['E_Gra']==1){

                            if($E_DPublico[3]['modalidadsic']==3){


                                if($E_DPublico[3]['recienegresado']==1){

                                    /*0-5 a�os*/

                                    if($TiempoGrado>=0 && $TiempoGrado<=5){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }
                                if($E_DPublico[3]['consolidacionprofesional']==1){

                                    /*6-34 a�os*/

                                    if($TiempoGrado>=6 && $TiempoGrado<=34){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }

                                if($E_DPublico[3]['senior']==1){

                                    /*Mayor a 35*/

                                    if($TiempoGrado>=35){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }



                            }else if($E_DPublico[3]['modalidadsic']==$modalida){

                                if($E_DPublico[3]['recienegresado']==1){

                                    /*0-5 a�os*/

                                    if($TiempoGrado>=0 && $TiempoGrado<=5){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }

                                if($E_DPublico[3]['consolidacionprofesional']==1){

                                    /*6-34 a�os*/

                                    if($TiempoGrado>=6 && $TiempoGrado<=34){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }

                                if($E_DPublico[3]['senior']==1){

                                    /*Mayor a 35*/

                                    if($TiempoGrado>=35){

                                        /***************************************/
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $id_instrumento;
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                        /***************************************/

                                    }

                                }


                            }//

                        }//if

                        /***************************************************/
                    } //if
                    /****************************************************************/

                }
                /****************************************************************/
                //$Instrumentos->MoveNext();
                $cont++;
            }
            /*********************************************************************/
        }else{
            $a_vectt['val'] = 'NO_Existe';
            $a_vectt['descrip'] = 'Los Datos Suministrados No Coinciden';
            echo json_encode($a_vectt);
            exit;
        }

        $a_vectt['val'] = 'NO_Exite';
        $a_vectt['descrip'] = 'No tiene Instrumentos O Encuetas Disponibles';
        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
        //$a_vectt['Instrumento'] = $Instrumentos->fields['id_instrumento'];
        //$a_vectt['Userid'] = $Userid;
        echo json_encode($a_vectt);
        exit;

    }break;
    case 'EC':{
        global $db;
        Main('0');
        //Si es pra personal externo
        $cap = 'notEq';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Verificamos si el captcha es correcto
            //echo 'captcha->'.$_POST['captcha'] .'=='. $_SESSION['cap_code'].'<-cap_code';

            if ($_POST['captcha'] == $_SESSION['cap_code']) {

                $mensaje= "Captcha Correcto";
                $cap = 'Eq';
                //echo "aca..";
                ?>
                <script>
                    $.ajax({//Ajax
                        type: 'POST',
                        url: 'validar.php',
                        async: false,
                        dataType: 'json',
                        data:({actionID: 'V_EC',
                            Num:'<?PHP echo $_POST['cedula']?>',
                            apellido_Pri:'<?PHP echo $_POST['Uno_apellido']?>',
                            apellido_Sdo:'<?PHP echo $_POST['Sdo_apellido']?>',
                            Nombre_Pri:'<?PHP echo $_POST['Uno_nombre']?>',
                            Nombre_Sdo:'<?PHP echo $_POST['Sdo_nombre']?>',
                            id_instrumento:'<?PHP echo $_POST['IDIn']?>'}),
                        success: function(data){
                            // alert(data.val);
                            // console.log(data);
                            if(data.val=='FALSE'){
                                alert(data.descrip);
                                return false;
                            }else if(data.val=='NO_Existe'){
                                // alert('aca')

                                alert(data.descrip);
                                location.href='Captcha_html.php?actionID=EC';
                                /**********************************************/
                            }else if(data.val=='Exite'){
                                alert(data.descrip);
                                location.href='../instrumento_aplicar.php?id_instrumento='+data.Instrumento+'&Ver=1&n=<?PHP echo $_POST['cedula']?>&Userid='+data.Userid;
                            }
                        }
                    }); //AJAX

                </script>                <?PHP
            } else {
                $mensaje= "Captcha Incorrecto";
                $cap = '';
                ?>
                <script>
                    alert('<?PHP echo $mensaje?>');
                    location.href='Captcha_html.php?actionID=EC';
                </script>
                <?PHP
            }
        }



    }break;
    case 'V_EC':{
        global $db;
        Main('1');

        $Num            = $_POST['Num'];
        $apellido_Pri   = $_POST['apellido_Pri'];
        $apellido_Sdo   = $_POST['apellido_Sdo'];
        $Nombre_Pri     = $_POST['Nombre_Pri'];
        $Nombre_Sdo     = $_POST['Nombre_Sdo'];

        $Nom_Completo = $Nombre_Pri;
        $Ape_Completo = $apellido_Pri;
        $Userid=0;



        $SQL_P='SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';

        if($PeriodoCodigo=&$db->Execute($SQL_P)===false){
            echo 'Error en el SQl de PeriodoCodigo ......<br><br>'.$SQL_P;
            die;
        }

        $CodigoPeriodo  = $PeriodoCodigo->fields['codigoperiodo'];


        /****************************************************************/
        $SQL_Instrumentos='SELECT 
                            
                                id_instrumento
                                
                                FROM 
                                
                                entradaredireccion er 
								INNER JOIN siq_Ainstrumentoconfiguracion ins on
								ins.idsiq_Ainstrumentoconfiguracion=er.id_instrumento and 
								cat_ins="EC" and ins.codigoestado=100 
                                
                                WHERE
                                
                                now() between er.fechainicioentradaredireccion and er.fechafinalentradaredireccion  
                                AND
                                er.codigoestado=100
                                AND
                                er.id_instrumento<>""';
        //echo $SQL_Instrumentos;
        if($Instrumentos=&$db->Execute($SQL_Instrumentos)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error en el SQL los Instrumentos...<br>'.$SQL_Instrumentos;
            echo json_encode($a_vectt);
            exit;
        }

        while(!$Instrumentos->EOF){
            /****************************************************************/

            $SQL_P='SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';

            if($PeriodoCodigo=&$db->Execute($SQL_P)===false){
                echo 'Error en el SQl de PeriodoCodigo ......<br><br>'.$SQL_P;
                die;
            }

            $CodigoPeriodo  = $PeriodoCodigo->fields['codigoperiodo'];


            if($Userid==0 || $Userid=='0'){
                $Condicion  = 'numerodocumento="' . $Num . '"';
            }else{
                $Condicion = '(numerodocumento="' . $Num . '" OR  usuarioid="'.$Userid.'")';
            }

            $SQL_Actualiza = 'SELECT 

            						idactualizacionusuario as id,  
            						estadoactualizacion
            
            						FROM 
            
            						actualizacionusuario  
            
            						WHERE  
            
            						'.$Condicion.' 
            						AND
            						id_instrumento="' .$Instrumentos->fields['id_instrumento']. '"
            						AND
            						codigoestado=100
                                    AND
                                    estadoactualizacion=2';
            //echo    $SQL_Actualiza;
            if($Contestado=&$db->Execute($SQL_Actualiza)===false){
                echo 'Error en el sql Actualizado...<br><br>'.$SQL_Actualiza;
                die;
            }


            if($Contestado->EOF){

                /****************************************************************/
                $SQL_Publico='SELECT * 
                                
                                FROM 
                                
                                siq_Apublicoobjetivo 
                                
                                WHERE
                                
                                idsiq_Ainstrumentoconfiguracion="'.$Instrumentos->fields['id_instrumento'].'"
                                AND
                                codigoestado=100';

                if($Publico=&$db->Execute($SQL_Publico)===false){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error en el SQL del Publico...<br>'.$SQL_Publico;
                    echo json_encode($a_vectt);
                    exit;

                }

                if(!$Publico->EOF){
                    /***************************************************/
                    $Publico_id  = $Publico->fields['idsiq_Apublicoobjetivo'];
                    /***************************************************/
                    $SQL_D='SELECT * 
                    
                        		FROM 
                        				siq_Adetallepublicoobjetivo 
                        		WHERE 
                        				idsiq_Apublicoobjetivo="'.$Publico_id.'" 
                        				AND 
                        				codigoestado=100';

                    if($DetallePublico=&$db->Execute($SQL_D)===false){
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'Error en el SQl del Detalle del Publico Detalle...<br><br>'.$SQL_D;
                        echo json_encode($a_vectt);
                        exit;

                    }

                    $E_DPublico	= $DetallePublico->GetArray();
                    foreach($E_DPublico as $publico){
                        if($publico["tipoestudiante"]==1 || $publico["tipoestudiante"]==3
                            || $publico["tipoestudiante"]==4){
                            //son los nuevos, egresados o graduados, este no aplica para EC
                        } else if($publico["tipoestudiante"]==2 && $publico["E_Old"]==1){
                            //son los estudiantes antiguos

                            $C_Carreras  = explode('::',$publico['cadena']);
                            foreach($C_Carreras as $carrera){
                                if($carrera!==""){
                                    //mirar si el estudiante esta inscrito en el curso
                                    $sql = "SELECT sub.numerodocumento FROM 
                                                    (SELECT eg.numerodocumento 
                                                    FROM relacionEstudianteGrupoInscripcion g 
                                                    inner join estudiantegeneral eg ON eg.idestudiantegeneral=g.idEstudianteGeneral 
                                                    INNER JOIN materia m on m.codigocarrera='".$carrera."' 
                                                    RIGHT JOIN grupo gr on gr.codigomateria=m.codigomateria 
                                                    WHERE eg.numerodocumento='".$Num."' 
                                                        UNION 
                                                    SELECT eg.numerodocumento 
                                                    FROM detalleprematricula g 
                                                    inner join prematricula p ON p.idprematricula=g.idprematricula 
                                                    inner join estudiante e ON e.codigoestudiante = p.codigoestudiante 
                                                    inner join estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
                                                    INNER JOIN materia m on m.codigocarrera='".$carrera."' 
                                                    RIGHT JOIN grupo gr on gr.codigomateria=m.codigomateria 
                                                    WHERE eg.numerodocumento='".$Num."' and g.idgrupo=gr.idgrupo ) as sub ";
                                    $row = $db->GetRow($sql);
                                    if(count($row)>0){
                                        //echo $sql."<br/><br/>";
                                        //echo "<pre>";print_r($row);
                                        //encontro al estudiante
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $Instrumentos->fields['id_instrumento'];
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                    }

                                }
                            }

                        } else if($publico["docente"]==1){
                            //son los docentes

                            $C_CarrerasDocente  = explode('::',$publico['modalidadocente']);
                            foreach($C_CarrerasDocente as $carrera){
                                if($carrera!==""){
                                    //mirar si el estudiante esta inscrito en el curso
                                    $sql = "SELECT sub.numerodocumento FROM 
                                                    (SELECT d.numerodocumento 
                                                    FROM relacionDocenteCursoEducacionContinuada g                                                     
                                                    INNER JOIN materia m on m.codigocarrera='".$carrera."' 
                                                    RIGHT JOIN grupo gr on gr.codigomateria=m.codigomateria 
                                                    inner join docente d ON d.numerodocumento=g.iddocente AND g.codigoestado=100
                                                    WHERE d.numerodocumento ='".$Num."' 
                                                        UNION 
                                                    SELECT d.numerodocumento 
                                                    FROM relacionDocenteCursoEducacionContinuada g 
                                                    INNER JOIN materia m on m.codigocarrera='".$carrera."' 
                                                    RIGHT JOIN grupo gr on gr.codigomateria=m.codigomateria 
                                                    inner join docenteEducacionContinuada d ON d.numerodocumento=g.iddocente AND g.codigoestado=100 
                                                    WHERE d.numerodocumento='".$Num."'
                                                        UNION 
                                                        SELECT g.numerodocumento FROM docente g
                                                        INNER JOIN materia m on m.codigocarrera='".$carrera."' 
                                                    RIGHT JOIN grupo gr on gr.codigomateria=m.codigomateria AND gr.numerodocumento=g.numerodocumento 
                                                        AND gr.numerodocumento='".$Num."') as sub 
                                                        WHERE sub.numerodocumento IS NOT NULL";
                                    //echo $sql;
                                    $row = $db->GetRow($sql);
                                    if(count($row)>0){
                                        //echo $sql."<br/><br/>";
                                        //echo "<pre>";print_r($row);
                                        //encontro al docente
                                        $a_vectt['val'] = 'Exite';
                                        $a_vectt['descrip'] = 'Bienvenido.';
                                        //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                                        $a_vectt['Instrumento'] = $Instrumentos->fields['id_instrumento'];
                                        $a_vectt['Userid'] = $Userid;
                                        echo json_encode($a_vectt);
                                        exit;
                                    }

                                }
                            }
                        }
                    }
                    /*echo "<pre>";print_r($E_DPublico);
                  $C_ModalidaDocente  = explode('::',$E_DPublico[4]['modalidadocente']);

                  for($i=1;$i<count($C_ModalidaDocente);$i++){
                      if($C_ModalidaDocente[$i]==$Docente_E->fields['modalidadocente']){

                          $a_vectt['val'] = 'Exite';
                          $a_vectt['descrip'] = 'Bienvenido.';
                          //$a_vectt['descrip'] = 'Disculpe los inconvenientes esta opcion no esta disponible.';
                          $a_vectt['Instrumento'] = $Instrumentos->fields['id_instrumento'];
                          $a_vectt['Userid'] = $Userid;
                          echo json_encode($a_vectt);
                          exit;

                      }
                  }    */
                    /***************************************************/
                } //if
                /****************************************************************/

            }//$ValidaInstrumentos->EOF
            /****************************************************************/
            $Instrumentos->MoveNext();
        }
        /****************************************************************/
        /*}else{
           $a_vectt['val'] = 'NO_Exite';
           $a_vectt['descrip'] = 'Los Datos Suministrados No Coinciden';
           echo json_encode($a_vectt);
           exit;
        }//if */

        /**********************************************/
        $a_vectt['val'] = 'NO_Existe';
        $a_vectt['descrip'] = 'No Tiene Instrumentos o Encuestas Disponibles';
        echo json_encode($a_vectt);
        exit;
        /**********************************************/

    }break;
    case 'Graduado':{
        global $db;
        Main('0');

        $cap = 'notEq';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Verificamos si el captcha es correcto
            //echo 'captcha->'.$_POST['captcha'] .'=='. $_SESSION['cap_code'].'<-cap_code';

            if ($_POST['captcha'] == $_SESSION['cap_code']) {

                $mensaje= "Captcha Correcto";
                $cap = 'Eq';
                ?>
                <script>
                    $.ajax({//Ajax
                        type: 'POST',
                        url: 'validar.php',
                        async: false,
                        dataType: 'json',
                        data:({actionID: 'V_Graduado',
                            Num:'<?PHP echo $_POST['cedula']?>',
                            apellido_Pri:'<?PHP echo $_POST['Uno_apellido']?>',
                            apellido_Sdo:'<?PHP echo $_POST['Sdo_apellido']?>',
                            Nombre_Pri:'<?PHP echo $_POST['Uno_nombre']?>',
                            Nombre_Sdo:'<?PHP echo $_POST['Sdo_nombre']?>',
                            Carrera:'<?PHP echo $_POST['Carrera']?>',
                            modalida:<?PHP echo $_POST['Modalidad']?>}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                        success: function(data){
                            if(data.val=='FALSE'){
                                alert(data.descrip);
                                return false;
                            }else if(data.val=='NO_Exite'){
                                /**********************************************/
                                alert(data.descrip);
                                location.href='Captcha_html.php?actionID=Graduado';
                                /**********************************************/
                            }else if(data.val='Exite'){
                                /*************************************/
                                alert(data.descrip);
                                location.href='../instrumento_aplicar.php?id_instrumento='+data.Instrumento+'&Ver=1&n=<?PHP echo $_POST['cedula']?>&Userid='+data.Userid;;
                                /*************************************/
                            }
                        }
                    }); //AJAX

                </script>
                <?PHP
            } else {
                $mensaje= "Captcha Incorrecto";
                $cap = '';
                ?>
                <script>
                    alert('<?PHP echo $mensaje?>');
                    location.href='Captcha_html.php?actionID=Graduado';
                </script>
                <?PHP
            }
        }
    }break;
    case 'validar':{
        global $db;
        Main('1');

        $Num        = $_POST['Num'];
        $apellido   = $_POST['apellido'];
        $instrumento    = $_POST['instrumento'];

        $SQL='SELECT 

                csv.cedula,
                csv.nombre,
                csv.apellido,
                csv.docente,
                csv.padre,
                csv.vecinos,
                csv.practica,
                csv.docencia_servicio,
                csv.administrativos,
                csv.otros
                
                FROM 
                
                siq_Apublicoobjetivocsv  csv INNER JOIN siq_Apublicoobjetivo p ON csv.idsiq_Apublicoobjetivo=p.idsiq_Apublicoobjetivo 
                AND 
                p.idsiq_Ainstrumentoconfiguracion="'.$instrumento.'" 
                AND 
                csv.codigoestado=100 
                AND 
                p.codigoestado=100
                                
                WHERE
                
                csv.cedula="'.$Num.'"
                AND
                csv.apellido LIKE "%'.$apellido.'%"';
        //echo $SQL;
        if($Data=&$db->Execute($SQL)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error en el SQl de Busqueda de Requistro....<br><br>' . $SQL;
            echo json_encode($a_vectt);
            exit;
        }

        if($Data->EOF){
            /************Esta Vacio***********/
            $a_vectt['val'] = 'NO_Exite';
            $a_vectt['descrip'] = 'No Hay Datos en los Registros';
            echo json_encode($a_vectt);
            exit;
            /*********************************/
        }else{
            /***********************************/
            $a_vectt['val'] = 'Exite';
            $a_vectt['descrip'] = 'Bienvenido...';
            echo json_encode($a_vectt);
            exit;
            /***********************************/
        }


    }break;
    default:{
        /**************************************************/
        global $db;
        Main('0');

        $cap = 'notEq';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Verificamos si el captcha es correcto
            //echo 'captcha->'.$_POST['captcha'] .'=='. $_SESSION['cap_code'].'<-cap_code';

            if ($_POST['captcha'] == $_SESSION['cap_code']) {

                $mensaje= "Captcha Correcto";
                $cap = 'Eq';
                ?>
                <script>
                    $.ajax({//Ajax
                        type: 'POST',
                        url: 'validar.php',
                        async: false,
                        dataType: 'json',
                        data:({actionID: 'validar',
                            Num:'<?PHP echo $_POST['cedula']?>',
                            apellido_Pri:'<?PHP echo $_POST['Uno_apellido']?>',
                            apellido_Sdo:'<?PHP echo $_POST['Sdo_apellido']?>',
                            Nombre_Pri:'<?PHP echo $_POST['Uno_nombre']?>',
                            Nombre_Sdo:'<?PHP echo $_POST['Sdo_nombre']?>',
                            instrumento:'<?PHP echo $_POST['id_instrumento']?>'}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                        success: function(data){
                            if(data.val=='FALSE'){
                                alert(data.descrip);
                                return false;
                            }else if(data.val=='NO_Exite'){
                                /**********************************************/
                                alert(data.descrip);
                                location.href='Captcha_html.php?instrumento=<?PHP echo $_POST['id_instrumento']?>';
                                /**********************************************/
                            }else if(data.val='Exite'){
                                /*************************************/
                                alert(data.descrip);
                                location.href='../instrumento_aplicar.php?id_instrumento=<?PHP echo $_POST['id_instrumento']?>&Ver=1&n=<?PHP echo $_POST['cedula']?>';
                                /*************************************/
                            }
                        }
                    }); //AJAX

                </script>
                <?PHP
            } else {
                $mensaje= "Captcha Incorrecto";
                $cap = '';
                ?>
                <script>
                    alert('<?PHP echo $mensaje?>');
                    location.href='Captcha_html.php?instrumento=<?PHP echo $_POST['id_instrumento']?>';
                </script>
                <?PHP
            }
        }
        /**************************************************/
    }break;
}

function Main($Op){

    global $db;
    include ('../../../templates/template.php');
    if($Op==0 || $Op=='0'){
        /****************************/
        $db=writeHeader('Prueba',true,'','../../../','body','',false,false);//
        /****************************/
    }else{
        $db=writeHeaderBD();//
    }

}



?>
