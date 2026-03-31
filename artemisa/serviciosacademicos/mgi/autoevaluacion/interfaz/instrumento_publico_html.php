<?php
    session_start();
    switch($_REQUEST['actionID']){
        //finaliza la evalaucion docente		
        case 'FinalizoExtreno':{			
            global $db;
            MainJson();

            $id_instrumento = $_POST['Instrumento_id'];
            $NumeroDocumento = $_POST['NumeroDocumento'];
            $Userid          = $_POST['Userid'];
            
            //Actualizacion de la consulta de rol del usuario
            $SQL="SELECT u.idusuario, ur.idrol FROM usuario u  INNER JOIN UsuarioTipo ut "
            . "on u.idusuario = ut.UsuarioId INNER JOIN usuariorol ur on ut.UsuarioTipoId = ur.idusuariotipo "
            . "WHERE u.numerodocumento = '".$NumeroDocumento."'  AND (ur.idrol = 2 OR ur.idrol = 1)";   
         
            if($Usuario=&$db->Execute($SQL)===false){
                echo 'Error en el SQL del Usuario...<br><br>consulta del rol del usuario';
                die;
            }  
                 
            if(!$Usuario->EOF){
                $Userid = $Usuario->fields['idusuario'];
            }else{
                $Userid = 0; 
            }
                  
            /*********************************************************/      
            //$SQL_P = 'SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';
            $SQL_P = 'SELECT fecha_inicio as codigoperiodo FROM siq_Ainstrumentoconfiguracion '
                    . 'where idsiq_Ainstrumentoconfiguracion = '.$id_instrumento;

            if ($PeriodoCodigo = &$db->Execute($SQL_P) === false){
                echo 'Error en el SQl de PeriodoCodigo ......<br><br>' . $SQL_P;
                die;
            }

            $Periodo  = $PeriodoCodigo->fields['codigoperiodo'];
            $Periodo = explode("-", $Periodo);

            if($Periodo[1] >= 6)
            {
                $mes = 2;	
                //semestre dos
            }else
            {
                $mes = 1;
                //semestre 1
            }
	        
            $CodigoPeriodo = $Periodo[0].$mes;
            
            if($Userid==0 || $Userid=='0')
            {
                $Condicion  = 'numerodocumento="' . $NumeroDocumento . '"';
            }else{
                $Condicion  = '(numerodocumento="' . $NumeroDocumento . '" OR usuarioid="'.$Userid.'")'; 
            }

            $SQL_Actualiza = 'SELECT idactualizacionusuario as id, estadoactualizacion
                            FROM  actualizacionusuario  
                            WHERE  
                            '.$Condicion.'
                            AND id_instrumento="' . $id_instrumento . '"
                            AND codigoperiodo="' . $CodigoPeriodo . '"
                            AND codigoestado=100 ';
            if ($Existe_R = &$db->Execute($SQL_Actualiza) === false)
            {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error en el SQl de Busqueda de Requistro....<br><br>';
                echo json_encode($a_vectt);
                exit;
            }

            if (!$Existe_R->EOF)
            {
                /****************Existe un Registro***********************************/
                if ($Existe_R->fields['estadoactualizacion'] == 1 || $Existe_R->fields['estadoactualizacion'] == 3)
                {
                    //actualiza el registro en estado 2 para finalizar la evaluacion docente de todas las materias
                    $SQL_UP = 'UPDATE  actualizacionusuario
                                SET    estadoactualizacion=2,
                                        changedate=NOW()
                                WHERE
                                (numerodocumento="' . $NumeroDocumento . '"  OR  usuarioid="'.$Userid.'")
                                AND id_instrumento="' . $id_instrumento . '"
                                AND codigoperiodo="' . $CodigoPeriodo . '"
                                AND codigoestado=100
                                AND idactualizacionusuario="' .$Existe_R->fields['id'].'"';                    

                    if ($Update_Actulizacion = &$db->Execute($SQL_UP) === false)
                    {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] =
                            'Error en el SQl que Modifica el estado de Actualizacion del Instrumento a Finalizado...<br><br>' .
                            $SQL_Up;
                        echo json_encode($a_vectt);
                        exit;
                    }
                } //if
                /**********************************************************************/
            } else
            {
                /*****************Si No exite Ningun Reguistro*******************/
                //Registra en la tabla de actualizacionusuario el numero del instrumento y el estado 2
                $SQL_Insert = 'INSERT INTO actualizacionusuario(numerodocumento,id_instrumento,codigoperiodo,estadoactualizacion,entrydate,usuarioid,userid)
                VALUES("'.$NumeroDocumento.'","'.$id_instrumento.'","'.$CodigoPeriodo.'",2,NOW(),"'.$Userid.'","'.$Userid.'")';                 
                if ($Insert_Actulizacion = &$db->Execute($SQL_Insert) === false)
                {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] =
                        'Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>' .
                        $SQL_Insert;
                    echo json_encode($a_vectt);
                    exit;   
                }
                /****************************************************************/
            }
            /*************************************************************************/
            $a_vectt['val'] = 'TRUE';
            //$a_vectt['descrip']		='Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>'.$SQL_Insert;
            echo json_encode($a_vectt);
            exit;
            /*************************************************************************/
    }//FinalizoExtreno
    break;
    
    case 'SinFinalizarNumeroDocumento':{
        global $db;
        MainJson();

        $id_instrumento = $_POST['Instrumento_id'];
        $NumeroDocumento = $_POST['NumeroDocumento'];
        $Userid          = $_POST['Userid'];

        //Actualizacion de la consulta de rol del usuario
        $SQL="SELECT u.idusuario, ur.idrol FROM usuario u  "
                . "INNER JOIN UsuarioTipo ut on u.idusuario = ut.UsuarioId "
                . "INNER JOIN usuariorol ur on ut.UsuarioTipoId = ur.idusuariotipo "
                . "WHERE u.numerodocumento = '".$NumeroDocumento."'  AND (ur.idrol = 2 OR ur.idrol = 1)";   

        if($Usuario=&$db->Execute($SQL)===false){
               echo 'Error en el SQL del Usuario...<br><br>';
               die;
        }  

        if(!$Usuario->EOF){
               $Userid = $Usuario->fields['idusuario'];
         }else{
               $Userid = 0; 
         }
                  
        /*********************************************************/     
            
        //$SQL_P = 'SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';
        $SQL_P = 'SELECT fecha_inicio as codigoperiodo FROM siq_Ainstrumentoconfiguracion '
                . 'where idsiq_Ainstrumentoconfiguracion = '.$id_instrumento;

        if ($PeriodoCodigo = &$db->Execute($SQL_P) === false)
        {
            echo 'Error en el SQl de PeriodoCodigo ......<br><br>' . $SQL_P;
            die;
        }

        $Periodo  = $PeriodoCodigo->fields['codigoperiodo'];			
        $Periodo = explode("-", $Periodo);

        if($Periodo[1] >= 6)
        {
            $mes = 2;	
            //semestre dos
        }else
        {
            $mes = 1;
            //semestre 1
        }    
		
        $CodigoPeriodo = $Periodo[0].$mes;
        $SQL_Actualiza = 'SELECT 
                        idactualizacionusuario as id,
                        estadoactualizacion
                        FROM 
                        actualizacionusuario  
                        WHERE  
                        (numerodocumento="' . $NumeroDocumento . '" OR  usuarioid="'.$Userid.'")
                        AND
                        id_instrumento="' . $id_instrumento . '"
                        AND
                        codigoperiodo="' . $CodigoPeriodo . '"
                        AND
                        codigoestado=100';

        if ($Existe_R = &$db->Execute($SQL_Actualiza) === false)
        {
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error en el SQl de Busqueda de Requistro....<br><br>' . $SQL_Actualiza;
            echo json_encode($a_vectt);
            exit;
        }

        if ($Existe_R->EOF)   
        {
            //Registra en la tabla de actualizacionusuario el numero del instrumento y el estado 1
            $SQL_Insert = 'INSERT INTO actualizacionusuario(numerodocumento,id_instrumento,codigoperiodo,estadoactualizacion,entrydate,usuarioid,userid)
            VALUES("'.$NumeroDocumento.'","'.$id_instrumento.'","'.$CodigoPeriodo.'",1,NOW(),"'.$Userid.'","'.$Userid.'")';                
            if ($Insert_Actulizacion = &$db->Execute($SQL_Insert) === false)
            {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] =
                    'Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>' .
                    $SQL_Insert;
                echo json_encode($a_vectt);
                exit;
            }
        }//if
        /**************************************************************/
        $a_vectt['val'] = 'TRUE';
        //$a_vectt['descrip']		='Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>'.$SQL_Insert;
        echo json_encode($a_vectt);
        exit;
        /**************************************************************/
    }//SinFinalizarNumeroDocumento
    break;
    case 'ModDocente':{
        global $db, $C_Insturmneto;
        MainJson();
        $C_Insturmneto->Mod_Docente($_POST['Mod_Docente']);
    }//ModDocente
    break;
    case 'CargarSession':{
        include_once ('EntradaRedireccion_Class.php');
        $C_EntradaRedirecion = new EntradaRedirecion();
        $userid = $_POST['Userid'];
        $id_instrumento = $_POST['id_instrumento']; 	
        global $db, $userid, $C_EntradaRedirecion;
                
        if($userid==null){
            $userid = $_POST['Userid'];
        }

        MainJson();
        $SQL_P = 'SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';
        if ($PeriodoCodigo = &$db->Execute($SQL_P) === false){
            echo 'Error en el SQl de PeriodoCodigo ......<br><br>' . $SQL_P;
            die;
        }
 
        $CodigoPeriodo  = $PeriodoCodigo->fields['codigoperiodo'];	            
        /********************************************************/
        if($_POST['Posponer']==1){
            //$id_instrumento = $_POST['id_instrumento']; 
            /***********************************************************/
            $SQL_Actualiza = 'SELECT 
                            idactualizacionusuario as id,
                            estadoactualizacion
                            FROM 
                            actualizacionusuario  
                            WHERE  
                            usuarioid="' . $userid . '"
                            AND
                            id_instrumento="' . $id_instrumento . '"
                            AND
                            codigoperiodo="' . $id_Periodo . '"
                            AND
                            codigoestado=100
                            AND
                            estadoactualizacion IN (1,3)';
            if($R_Existe=&$db->Execute($SQL_Actualiza)===false)
            {
                echo 'Error en el SQl <br><br>'.$SQL_Actualiza;
                die;
            }               
            /***********************************************************/
            if($R_Existe->EOF)
            {
                /*********************************************************/
                //Registra en la tabla de actualizacionusuario el numero del instrumento y el estado 3
                $SQL_Insert = 'INSERT INTO actualizacionusuario(usuarioid,id_instrumento,codigoperiodo,estadoactualizacion,userid,entrydate)
                VALUES("'.$userid.'","'.$id_instrumento.'","'.$id_Periodo.'",3,"'.$userid.'",NOW())';                     
                if ($Insert_Actulizacion = &$db->Execute($SQL_Insert) === false)
                {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] =
                        'Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>' .
                        $SQL_Insert;
                    echo json_encode($a_vectt);
                    exit;
                }
                /*********************************************************/
            }else{
                /*********************************************************/
                $SQL_UP = 'UPDATE  actualizacionusuario
                        SET estadoactualizacion=3,
                        useridestado="' . $userid . '",
                        changedate=NOW()
                        WHERE
                        usuarioid="' . $userid . '"
                        AND
                        id_instrumento="' . $id_instrumento . '"
                        AND
                        codigoperiodo="' . $id_Periodo . '"
                        AND
                        codigoestado=100
                        AND
                        idactualizacionusuario="' . $R_Existe->fields['id'] . '"';                

                if ($Update_Actulizacion = &$db->Execute($SQL_UP) === false)
                {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] =
                        'Error en el SQl que Modifica el estado de Actualizacion del Instrumento a Finalizado...<br><br>' .
                        $SQL_Up;
                    echo json_encode($a_vectt);
                    exit;
                }
                /*********************************************************/
            }
            /***********************************************************/  
        }//If Posponer
            
        /********************************************************/
        $C_Data = $C_EntradaRedirecion->Consulta($userid, $id_Periodo,$_POST['Posponer'],$id_instrumento);
        
        if($id_instrumento==$C_Data['id_instrumento'])
        {
            $Activo = 0;
        }else{
            $Activo = $C_Data['Activo'];
        }
            
        $C_user = $C_EntradaRedirecion->DataUser($userid);

        if ($C_Data['Activo'] == 1)
        {
            $_SESSION['redireccionentrada'] = $C_Data['URL'];
        }
        else
        {
            $_SESSION['redireccionentrada'] = '';
        }       
        $a_vectt['val'] = 'TRUE';
        $a_vectt['Permiso'] = $Activo;//$C_Data['Activo'];
        $a_vectt['Rol'] = $C_user['codigorol'];
        $a_vectt['tipoUser'] = $C_user['codigotipousuario'];
        echo json_encode($a_vectt);
        exit;            
    }//CargarSession
    break;
    case 'SinFinalizar':{
        global $db;
        $idusuario = $_POST['id'];        
        $id_instrumento = $_POST['Instrumento_id'];
        
        MainJson();
        
        //consulta la fecha de inicio del instrumento para obtener el periodo al cual se aplicara
        $SQL_P = "SELECT fecha_inicio as codigoperiodo FROM siq_Ainstrumentoconfiguracion
                where idsiq_Ainstrumentoconfiguracion = ".$id_instrumento." ";        
        $PeriodoCodigo = $db->Execute($SQL_P);
        
        $Periodo = $PeriodoCodigo->fields['codigoperiodo'];				
        $Periodo = explode("-", $Periodo);

        if($Periodo[1] >= 6){
            //semestre dos
            $mes = 2;	
        }else{
            //semestre 1
            $mes = 1;
        }        
		
        $CodigoPeriodo = $Periodo[0].$mes;
        $SQL_Actualiza = 'SELECT 
                        idactualizacionusuario as id,
                        estadoactualizacion
                        FROM 
                        actualizacionusuario  
                        WHERE  
                        usuarioid="' . $idusuario . '"
                        AND
                        id_instrumento="' . $id_instrumento . '"
                        AND
                        codigoperiodo="' . $CodigoPeriodo . '"
                        AND
                        codigoestado=100';            
        $Existe_R = $db->Execute($SQL_Actualiza);
                
        if ($Existe_R->EOF){
            //Registra en la tabla de actualizacionusuario el numero del instrumento y el estado 1
            $SQL_Insert = 'INSERT INTO actualizacionusuario(usuarioid,id_instrumento,codigoperiodo,estadoactualizacion,userid,entrydate)
            VALUES("'.$idusuario.'","'.$id_instrumento.'","'.$CodigoPeriodo.'",1,"'.$idusuario.'",NOW())';               
            if ($Insert_Actulizacion = &$db->Execute($SQL_Insert) === false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>' .
                    $SQL_Insert;
                echo json_encode($a_vectt);
                exit;
            }
        }else if($Existe_R->fields['estadoactualizacion']==3){     
            $SQL_UP = 'UPDATE  actualizacionusuario
                        SET estadoactualizacion=1,
                            useridestado="' . $idusuario . '",
                            changedate=NOW()
                        WHERE
                            usuarioid="' . $idusuario . '"
                            AND
                            id_instrumento="' . $id_instrumento . '"
                            AND
                            codigoperiodo="' . $CodigoPeriodo . '"
                            AND
                            codigoestado=100
                            AND
                            idactualizacionusuario="' . $Existe_R->fields['id'] . '"';                        
            if ($Update_Actulizacion = &$db->Execute($SQL_UP) === false)
            {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] =
                    'Error en el SQl que Modifica el estado de Actualizacion del Instrumento a Finalizado...<br><br>' .
                    $SQL_Up;
                echo json_encode($a_vectt);
                exit;
            }
                
        }//if
        /**************************************************************/
        $a_vectt['val'] = 'TRUE';
        //$a_vectt['descrip']		='Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>'.$SQL_Insert;
        echo json_encode($a_vectt);
        exit;
        /**************************************************************/
    }//SinFinalizar
    break;
    //cuando finaliza la evalaucion de una materia
    case 'Finalizo':{			
        global $db, $userid;
			
        if($userid==null || $userid== '6492'){
            $userid  = $_POST['Userid'];
        }
		
        MainJson();

        $id_instrumento = $_POST['Instrumento_id'];
        $Grupo_id        = $_POST['Grupo_id'];
        $CodigoEstudiante  = $_POST['CodigoEstudiante'];
        $CodigoJornada     = $_POST['CodigoJornada'];

        //$SQL_P = 'SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';
        $SQL_P = 'SELECT fecha_inicio as codigoperiodo FROM siq_Ainstrumentoconfiguracion 
                where idsiq_Ainstrumentoconfiguracion = '.$id_instrumento;

        if ($PeriodoCodigo = &$db->Execute($SQL_P) === false)
        {
            echo 'Error en el SQl de PeriodoCodigo ......<br><br>' . $SQL_P;
            die;
        }

        $Periodo  = $PeriodoCodigo->fields['codigoperiodo'];					
        $Periodo = explode("-", $Periodo);

        if($Periodo[1] >= 6)
        {
            $mes = 2;	
            //semestre dos
        }else
        {
            $mes = 1;
            //semestre 1
        }		
        $CodigoPeriodo = $Periodo[0].$mes;
	
        $SQL_Actualiza = 'SELECT 
                        idactualizacionusuario as id,
                        estadoactualizacion
                        FROM 
                        actualizacionusuario  
                        WHERE  
                        usuarioid="' . $userid . '"
                        AND
                        id_instrumento="' . $id_instrumento . '"
                        AND
                        codigoperiodo="' . $CodigoPeriodo . '"
                        AND
                        codigoestado=100';        
        $Existe_R = $db->Execute($SQL_Actualiza);

        if (!$Existe_R->EOF)
        {
            /****************Existe un Reguistro***********************************/				
            if ($Existe_R->fields['estadoactualizacion'] == 1 || $Existe_R->fields['estadoactualizacion'] == 3)
            {            
                $SQL='SELECT
                            idsiq_Ainstrumentoconfiguracion AS id,
                            cat_ins
                      FROM
                            siq_Ainstrumentoconfiguracion
                      WHERE
                            codigoestado=100
                            AND
                            idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"';

                if($CategoriaInstrumento=&$db->Execute($SQL)===false){
                  echo 'Error en el SQL Categoria Instrumento....<br><br>';
                  die;
                }      

                if($CategoriaInstrumento->fields['cat_ins']=='EDOCENTES')
                {
                    $SQL_InsertGrupo='INSERT INTO siq_ADetallesRespuestaInstrumentoEvaluacionDocente(idactualizacionusuario,idgrupo,codigojornada,UsuarioCreacion,'
                            . 'FechaCreacion,codigoestado,UsuarioUltimaModificacion,FechaUltimaModificacion)'
                            . 'VALUES("'.$Existe_R->fields['id'].'","'.$Grupo_id.'","'.$CodigoJornada.'","'.$userid.'",NOW(),"100","'.$userid.'",NOW())';  

                    if($EjecutaInsertGrupo=&$db->Execute($SQL_InsertGrupo)===false){
                      echo 'Error en el SQL del Insert Grupo Docente...<br><br>'.$SQL_InsertGrupo;
                      die;
                    }  

                    $SQL='SELECT
                                  COUNT(*) AS Num
                          FROM
                                  prematricula p,
                                  detalleprematricula dp,
                                  materia m,
                                  docente d,
                                  grupo g
                          LEFT JOIN horario h ON h.idgrupo = g.idgrupo
                          LEFT JOIN dia di ON di.codigodia = h.codigodia
                          WHERE
                                  p.idprematricula = dp.idprematricula
                          AND dp.codigomateria = m.codigomateria
                          AND p.codigoestadoprematricula LIKE "4%"
                          AND dp.codigoestadodetalleprematricula LIKE "3%"
                          AND g.idgrupo = dp.idgrupo AND g.idgrupo NOT IN (76993,80085,77029,77050,76812,77056)
                          AND g.numerodocumento = d.numerodocumento
                          AND p.codigoperiodo = "'.$CodigoPeriodo.'"
                          AND p.codigoestudiante = "'.$CodigoEstudiante.'"
                          AND m.codigomateria NOT IN (
                            SELECT
                                    m.codigomateria
                            FROM
                                    siq_ADetallesRespuestaInstrumentoEvaluacionDocente e
                            INNER JOIN actualizacionusuario a ON a.idactualizacionusuario = e.idactualizacionusuario
                            INNER JOIN grupo g ON e.idgrupo = g.idgrupo
                            INNER JOIN materia m ON m.codigomateria = g.codigomateria
                            WHERE
                                    a.id_instrumento = "'.$id_instrumento.'"
                            AND a.usuarioid = "'.$userid.'"
                            AND e.codigoestado = 100
                        )
                            AND
                            m.codigomateria NOT IN(SELECT
                                    codigomateria
                            FROM
                                    MateriasExcluidasEncuesta

                            WHERE
                             idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"
                            AND
                            codigoestado=100)
                            GROUP BY p.codigoestudiante';
                                        
                    if($DataNum=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL Num Materias...<br><br>';
                        die;
                    }    
                                    
                    if($DataNum->fields['Num']!=0){
                         $SQL_UP = 'UPDATE  actualizacionusuario
                                    SET  estadoactualizacion=1,
                                        useridestado="' . $userid . '",
                                        changedate=NOW()
                                    WHERE
                                        usuarioid="' . $userid . '"
                                        AND
                                        id_instrumento="' . $id_instrumento . '"
                                        AND
                                        codigoperiodo="' . $CodigoPeriodo . '"
                                        AND
                                        codigoestado=100
                                        AND
                                        idactualizacionusuario="' . $Existe_R->fields['id'] . '"';                         
                    }else{                                        
                        $SQL_UP = 'UPDATE  actualizacionusuario
                                    SET  estadoactualizacion=2,
                                        useridestado="' . $userid . '",
                                        changedate=NOW()
                                    WHERE
                                        usuarioid="' . $userid . '"
                                        AND
                                        id_instrumento="' . $id_instrumento . '"
                                        AND
                                        codigoperiodo="' . $CodigoPeriodo . '"
                                        AND
                                        codigoestado=100
                                        AND
                                        idactualizacionusuario="' . $Existe_R->fields['id'] . '"';                        
                    }    
                }else{                                
                    $SQL_UP = 'UPDATE  actualizacionusuario
                                SET estadoactualizacion=2,
                                    useridestado="' . $userid . '",
                                    changedate=NOW()
                                WHERE
                                    usuarioid="' . $userid . '"
                                    AND
                                    id_instrumento="' . $id_instrumento . '"
                                    AND
                                    codigoperiodo="' . $CodigoPeriodo . '"
                                    AND
                                    codigoestado=100
                                    AND
                                    idactualizacionusuario="' . $Existe_R->fields['id'] . '"';                    
                }      
                if ($Update_Actulizacion = &$db->Execute($SQL_UP) === false)
                {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] =
                        'Error en el SQl que Modifica el estado de Actualizacion del Instrumento a Finalizado...<br><br>' .
                        $SQL_Up;
                    echo json_encode($a_vectt);
                    exit;
                }
            } //if

            /**********************************************************************/
        } else {
            /*****************Si No exite Ningun Reguistro*******************/
            $SQL='SELECT
                    idsiq_Ainstrumentoconfiguracion AS id,
                    cat_ins
              FROM
                    siq_Ainstrumentoconfiguracion
              WHERE
                    codigoestado=100
                    AND
                    idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"';

            if($CategoriaInstrumento=&$db->Execute($SQL)===false){
              echo 'Error en el SQL Categoria Instrumento....<br><br>'.$SQL;
              die;
            }      
                              
            if($CategoriaInstrumento->fields['cat_ins']=='EDOCENTES')
            {
                    
                $SQL='SELECT
                                COUNT(*) AS Num
                        FROM
                                prematricula p,
                                detalleprematricula dp,
                                materia m,
                                docente d,
                                grupo g
                        LEFT JOIN horario h ON h.idgrupo = g.idgrupo
                        LEFT JOIN dia di ON di.codigodia = h.codigodia
                        WHERE
                                p.idprematricula = dp.idprematricula
                        AND dp.codigomateria = m.codigomateria
                        AND p.codigoestadoprematricula LIKE "4%"
                        AND dp.codigoestadodetalleprematricula LIKE "3%"
                        AND g.idgrupo = dp.idgrupo AND g.idgrupo NOT IN (76993,80085,77029,77050,76812,77056)
                        AND g.numerodocumento = d.numerodocumento
                        AND p.codigoperiodo = "'.$CodigoPeriodo.'"
                        AND p.codigoestudiante = "'.$CodigoEstudiante.'"
                        AND m.codigomateria NOT IN (
                            SELECT
                                    m.codigomateria
                            FROM
                                    siq_ADetallesRespuestaInstrumentoEvaluacionDocente e
                            INNER JOIN actualizacionusuario a ON a.idactualizacionusuario = e.idactualizacionusuario
                            INNER JOIN grupo g ON e.idgrupo = g.idgrupo
                            INNER JOIN materia m ON m.codigomateria = g.codigomateria
                            WHERE
                                    a.id_instrumento = "'.$id_instrumento.'"
                            AND a.usuarioid = "'.$userid.'"
                            AND e.codigoestado = 100
                        )
                        AND
                        m.codigomateria NOT IN(SELECT
                                codigomateria
                        FROM
                                MateriasExcluidasEncuesta

                        WHERE
                         idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"
                        AND
                        codigoestado=100)

                        GROUP BY p.codigoestudiante';
                                        
                if($DataNum=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL Num Materias...<br><br>'.$SQL;
                    die;
                } 

                 if($DataNum->fields['Num']==0){
                    $Estado = 2;
                 }else{
                    $Estado = 1;
                 }   
                //Registra en la tabla de actualizacionusuario el numero del instrumento y el estado 
                $SQL_Insert = 'INSERT INTO actualizacionusuario(usuarioid,id_instrumento,codigoperiodo,estadoactualizacion,userid,entrydate)
                VALUES("'.$userid.'","'.$id_instrumento.'","'.$CodigoPeriodo.'","'.$Estado.'","'.$userid.'",NOW())';                
                if ($Insert_Actulizacion = &$db->Execute($SQL_Insert) === false)
                {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] =
                        'Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>' .
                        $SQL_Insert;
                    echo json_encode($a_vectt);
                    exit;
                }
                        
                $Last_id  = $db->Insert_ID();
                
                $SQL_InsertGrupo='INSERT INTO siq_ADetallesRespuestaInstrumentoEvaluacionDocente(idactualizacionusuario,idgrupo,codigojornada,UsuarioCreacion,FechaCreacion,codigoestado,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$Last_id.'","'.$Grupo_id.'","'.$CodigoJornada.'","'.$userid.'",NOW(),"100","'.$userid.'",NOW())';  
                                     
                if($EjecutaInsertGrupo=&$db->Execute($SQL_InsertGrupo)===false){
                    echo 'Error en el SQL del Insert Grupo Docente...<br><br>'.$SQL_InsertGrupo;
                    die;
                }
                  
            }else{ 
                
                //Registra en la tabla de actualizacionusuario el numero del instrumento y el estado 2
                $SQL_Insert = 'INSERT INTO actualizacionusuario(usuarioid,id_instrumento,codigoperiodo,estadoactualizacion,userid,entrydate)
                VALUES("'.$userid.'","'.$id_instrumento.'","'.$CodigoPeriodo.'",2,"'.$userid.'",NOW())';                         
                if ($Insert_Actulizacion = &$db->Execute($SQL_Insert) === false)
                {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] =
                        'Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>' .
                        $SQL_Insert;
                    echo json_encode($a_vectt);
                    exit;
                }

                $Last_id  = $db->Insert_ID();

            }  
            /****************************************************************/
        }
        $SQL_Actualiza = 'SELECT 
                            idactualizacionusuario as id,
                            estadoactualizacion
                            FROM 
                            actualizacionusuario  
                            WHERE  
                            usuarioid="' . $userid . '"
                            AND
                            id_instrumento="' . $id_instrumento . '"
                            AND
                            codigoperiodo="' . $CodigoPeriodo . '"
                            AND
                            codigoestado=100';
                                
        if ($Existe_Resulktado = &$db->Execute($SQL_Actualiza) === false)
        {
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error en el SQl de Busqueda de Requistro....<br><br>' . $SQL_Actualiza;
            echo json_encode($a_vectt);
            exit;
        } 
                    
        if($Existe_Resulktado->EOF)
        {	
            //Registra en la tabla de actualizacionusuario el numero del instrumento y el estado 2
            $SQL_Insert = 'INSERT INTO actualizacionusuario(usuarioid,id_instrumento,codigoperiodo,estadoactualizacion,userid,entrydate)
            VALUES("'.$userid.'","'.$id_instrumento.'","'.$CodigoPeriodo.'",2,"'.$userid.'",NOW())';    
            if ($Insert_Actulizacion = &$db->Execute($SQL_Insert) === false)
            {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] =
                    'Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>' .
                    $SQL_Insert;
                echo json_encode($a_vectt);
                exit;
            }
        }                     
        /*************************************************************************/
        $a_vectt['val'] = 'TRUE';
        //$a_vectt['descrip']		='Error en el SQl que Insertar el estado de Actualizacion del Instrumento ...<br><br>'.$SQL_Insert;
        echo json_encode($a_vectt);
        exit;
        /*************************************************************************/

    }//Finalizo
    break;
    case 'EntradaRedirecion':{     
        global $db, $userid;

        MainJson();

        $id_instrumento = $_POST['id_instrumento'];

        $SQL = 'SELECT 

                            conf.fecha_inicio,
                            conf.fecha_fin,
                            conf.nombre

                            FROM 

                            siq_Ainstrumentoconfiguracion conf 
                            WHERE

                            conf.idsiq_Ainstrumentoconfiguracion="' . $id_instrumento . '"
                            AND
                            conf.codigoestado=100';


        if ($Fechas = &$db->Execute($SQL) === false)
        {
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Buscar las Fechas de Publicacion.....' . $SQL;
            echo json_encode($a_vectt);
            exit;
        }

            $Fecha_inicial = $Fechas->fields['fecha_inicio'];
            $Fecha_final = $Fechas->fields['fecha_fin'];
            $nombre = $Fechas->fields['nombre'];


            $SQL_Valida = 'SELECT * 

							FROM 
							
							entradaredireccion
							
							WHERE
							
							id_instrumento="' . $id_instrumento . '"
							AND
							codigoestado=100
							AND
							fechafinalentradaredireccion="' . $Fecha_final . '"
							AND
							fechainicioentradaredireccion="' . $Fecha_inicial . '"';

            if ($Validacion = &$db->Execute($SQL_Valida) === false)
            {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error al Validar la Existencia de Una Publicacion.....' .
                    $SQL_Valida;
                echo json_encode($a_vectt);
                exit;
            }

            if ($Validacion->EOF)
            {
                /*********************************************************************/
                $SQL_Insert = 'INSERT INTO  entradaredireccion (fechainicioentradaredireccion,fechafinalentradaredireccion,id_instrumento,userid,entrydate,codigotipousuario)VALUES("' .
                    $Fecha_inicial . '","' . $Fecha_final . '","' . $id_instrumento . '","' . $userid .
                    '",NOW(),0)';

                if ($InsertEntradaRedirecion = &$db->Execute($SQL_Insert) === false)
                {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error al Insertar la Publicacion.....' . $SQL_Insert;
                    echo json_encode($a_vectt);
                    exit;
                }
                /*********************************************************************/
            }

            /**************************************/
            $a_vectt['val'] = 'TRUE';
            //$a_vectt['descrip']		='Error al Insertar la Publicacion.....'.$SQL_Insert;
            echo json_encode($a_vectt);
            exit;
            /**************************************/
        }//EntradaRedirecion
        break;
        case 'EliminarDetalle':{
            global $db, $userid;

            MainJson();

            $id_Detalle = $_POST['id_Detalle'];

            $SQL_Delete = 'UPDATE  siq_Adetallepublicoobjetivo
						 
						 SET     codigoestado=200,
						 		 userid_estado="' . $userid . '",
								 changedate=NOW()
								 
						 WHERE   idsiq_Adetallepublicoobjetivo="' . $id_Detalle .
                '" AND  codigoestado=100';

            if ($EliminaDato = &$db->Execute($SQL_Delete) === false)
            {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error al Eliminar  Publico Objetivo.....' . $SQL_Delete;
                echo json_encode($a_vectt);
                exit;
            }

            $a_vectt['val'] = 'TRUE';
            //$a_vectt['descrip']		='Error al Eliminar  Publico Objetivo.....'.$SQL_Delete;
            echo json_encode($a_vectt);
            exit;

        }//EliminarDetalle
        break;
        case 'Procesar':{
            global $db, $userid;

            MainJson();

            $E_new = $_POST['E_new'];
            $Filtro_New = $_POST['Filtro_New'];
            $C_Datos_New = $_POST['C_Datos_New'];
            $Modalidad_id_New = $_POST['Modalidad_id_New'];
            $Carrera_new = $_POST['Carrera_new'];
            $estudiantesemestreNew = $_POST['estudiantesemestreNew'];
            $TipoCadena_new = $_POST['TipoCadena_new'];
            $E_Type = $_POST['E_Type'];


            for ($i = 0; $i < count($estudiantesemestreNew); $i++)
            {
                if ($i == 0)
                {
                    $S_Cadena_New = $estudiantesemestreNew[$i];
                } else
                {
                    $S_Cadena_New = $S_Cadena_New . ',' . $estudiantesemestreNew[$i];
                }
            }
            /**********************************************************/
            $E_Old = $_POST['E_Old'];
            $Filtro_Old = $_POST['Filtro_Old'];
            $C_Datos_Old = $_POST['C_Datos_Old'];
            $Modalidad_id_Old = $_POST['Modalidad_id_Old'];
            $Carrera_Old = $_POST['Carrera_Old'];
            $TipoCadena_Old = $_POST['TipoCadena_Old'];
            $estudiantesemestreOld = $_POST['estudiantesemestreOld'];
            $E_Type_Old = $_POST['E_Type_Old'];

            for ($i = 0; $i < count($estudiantesemestreOld); $i++)
            {
                if ($i == 0)
                {
                    $S_Cadena_Old = $estudiantesemestreOld[$i];
                } else
                {
                    $S_Cadena_Old = $S_Cadena_Old . ',' . $estudiantesemestreOld[$i];
                }
            }
            /********************************************************/
            $E_Egre = $_POST['E_Egre'];
            $Filtro_Egre = $_POST['Filtro_Egre'];
            $C_Datos_Egre = $_POST['C_Datos_Egre'];
            $Modalidad_id_Egre = $_POST['Modalidad_id_Egre'];
            $Carrera_Egre = $_POST['Carrera_Egre'];
            $TipoCadena_Egre = $_POST['TipoCadena_Egre'];
            $E_Type_Egr = $_POST['E_Type_Egr'];
            /***************************************************/
            $E_Gra = $_POST['E_Gra'];
            $Modalidad_Gra = $_POST['Modalidad_Gra'];
            /*--*/
            $recien         = $_POST['recien'];
            $consolidacion  = $_POST['consolidacion'];
            $senior         = $_POST['senior'];
            /*$Filtro_Gra = $_POST['Filtro_Gra'];
            $C_Datos_Gra = $_POST['C_Datos_Gra'];
            $Modalidad_id_Gra = $_POST['Modalidad_id_Gra'];
            $Carrera_Gra = $_POST['Carrera_Gra'];
            $TipoCadena_Gra = $_POST['TipoCadena_Gra'];
            */
            $E_Type_Gra = $_POST['E_Type_Gra'];
            /****************************************************/
            $id_instrumento = $_POST['id_instrumento'];
            $id_publicoobjetivo = $_POST['id_publicoobjetivo'];
            $aprobada = $_POST['aprobada'];
            /****************************************************/
            $id_NewDetalle = $_POST['id_NewDetalle'];
            $id_OldDetalle = $_POST['id_OldDetalle'];
            $id_EgrDetalle = $_POST['id_EgrDetalle'];
            $id_GraDetalle = $_POST['id_GraDetalle'];
            /****************************************************/
            $Estudiante = '1';
            $Docente = '0';
            $Admin = '1';
            $csv = $_POST['csv'];
            $Obligar    = $_POST['Obligar'];
            /****************************************************/
            /*Docente*/
            $Docente            = $_POST['Docente'];        
            $CadenaDocente      = $_POST['CadenaDocente'];   
            $M_Docente          = $_POST['M_Docente'];
            $Docente_id         = $_POST['Docente_id']; 
            /****************************************************/            
            if (!$id_publicoobjetivo)
            {
                /******************Insert Publico Objetivo**********************/

                if ($E_Type == 1 || $E_Type_Old == 2 || $E_Type_Egr == 3 || $E_Type_Gra == 4  ||  $Docente==1 || $Docente==0)
                {
                    /************************************/
                    $Estudiante = 0;
                    /************************************/
                }

                $Insert_PObjetivo = 'INSERT INTO siq_Apublicoobjetivo(idsiq_Ainstrumentoconfiguracion,userid,entrydate,estudiante,docente,admin,cvs,obligar)VALUES("' .
                    $id_instrumento . '","' . $userid . '",NOW(),"' . $Estudiante . '","' . $Docente .
                    '","' . $Admin . '","' . $csv . '","'.$Obligar.'")';

                if ($InsertPublicoObjetivo = &$db->Execute($Insert_PObjetivo) === false)
                {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error al Insertar Publico Objetivo.....';
                    echo json_encode($a_vectt);	
                    exit;
                }
                #####################################
                $Last_id = $db->Insert_ID();
                #####################################

                if ($E_Type == 1)
                { //E_new
                    /******************Estudiantes Nuevos*************************/
                    $Inset_Detalle = 'INSERT INTO siq_Adetallepublicoobjetivo(idsiq_Apublicoobjetivo,tipoestudiante,E_New,filtro,semestre,modalidadsic,codigocarrera,cadena,tipocadena,userid,entrydate)VALUES("' .$Last_id . '","' . $E_Type . '","' . $E_new . '","' . $Filtro_New . '","' . $S_Cadena_New .'","' .$Modalidad_id_New . '","' . $Carrera_new . '","' . $C_Datos_New . '","' .$TipoCadena_new . '","' . $userid . '",NOW())';

                    if ($InsertDetalle = &$db->Execute($Inset_Detalle) === false)
                    {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] =
                            'Error al Insertar Publico Objetivo Detalle Estudiantes Nuevos.....' . $Inset_Detalle;
                        echo json_encode($a_vectt);
                        exit;
                    }

                    /*************************************************************/
                } //If E_new
                if ($E_Type_Old == 2)
                { //E_Old
                    /*****************Estudiante Antiguosd************************/
                    $Inset_Detalle = 'INSERT INTO siq_Adetallepublicoobjetivo(idsiq_Apublicoobjetivo,tipoestudiante,E_Old,filtro,semestre,modalidadsic,codigocarrera,cadena,tipocadena,userid,entrydate)VALUES("' .$Last_id . '","' . $E_Type_Old . '","' . $E_Old . '","' . $Filtro_Old . '","' .            $S_Cadena_Old . '","' . $Modalidad_id_Old . '","' . $Carrera_Old . '","' . $C_Datos_Old .'","' . $TipoCadena_Old . '","' . $userid . '",NOW())';

                    if ($InsertDetalle = &$db->Execute($Inset_Detalle) === false)
                    {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] =
                            'Error al Insertar Publico Objetivo Detalle Estudiante Antiguos.....' . $Inset_Detalle;
                        echo json_encode($a_vectt);
                        exit;
                    }
                    /*************************************************************/
                } //If E_Old
                if ($E_Type_Egr == 3)
                { //E_Egre
                    /****************Estudiantes Egresados************************/
                    $Inset_Detalle = 'INSERT INTO siq_Adetallepublicoobjetivo(idsiq_Apublicoobjetivo,tipoestudiante,E_Egr,filtro,modalidadsic,codigocarrera,cadena,tipocadena,userid,entrydate)VALUES("' .$Last_id . '","' . $E_Type_Egr . '","' . $E_Egre . '","' . $Filtro_Egre . '","' .                  $Modalidad_id_Egre . '","' . $Carrera_Egre . '","' . $C_Datos_Egre . '","' . $TipoCadena_Egre .'","' . $userid . '",NOW())';

                    if ($InsertDetalle = &$db->Execute($Inset_Detalle) === false)
                    {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] =
                            'Error al Insertar Publico Objetivo Detalle Estudiante Egresado.....' . $Inset_Detalle;
                        echo json_encode($a_vectt);
                        exit;
                    }
                    /*************************************************************/
                } //if E_Egre
                if ($E_Type_Gra == 4)
                { //E_Gra
                    /***************Estudiantes Graduados*************************/
                    $Inset_Detalle = 'INSERT INTO siq_Adetallepublicoobjetivo(idsiq_Apublicoobjetivo,tipoestudiante,E_Gra,modalidadsic,userid,entrydate,recienegresado,consolidacionprofesional,senior)VALUES("' .$Last_id . '","' . $E_Type_Gra . '","' . $E_Gra . '","' .$Modalidad_Gra . '","' . $userid . '",NOW(),"'.$recien.'","'.$consolidacion.'","'.$senior.'")';

                    if ($InsertDetalle = &$db->Execute($Inset_Detalle) === false)
                    {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] =
                            'Error al Insertar Publico Objetivo Detalle Estudiantes Graduados.....' . $Inset_Detalle;
                        echo json_encode($a_vectt);
                        exit;
                    }
                    /*************************************************************/
                } //if E_Gra
                /***************************************************************/
                if($Docente==1 || $Docente==0){//Docente
                    /***********************************************************/
                    $Inset_Detalle = 'INSERT INTO siq_Adetallepublicoobjetivo(idsiq_Apublicoobjetivo,modalidadsic,docente,modalidadocente,userid,entrydate)VALUES("' .$Last_id . '","' .$M_Docente. '","' .$Docente. '","' .$CadenaDocente. '","' . $userid . '",NOW())';

                    if ($InsertDetalle = &$db->Execute($Inset_Detalle) === false)
                    {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] =
                            'Error al Insertar Publico Objetivo Detalle Docentes.....' . $Inset_Detalle;
                        echo json_encode($a_vectt);
                        exit;
                    }
                    /***********************************************************/
                }
                /***************************************************************/
            } else
            {   
                /*******************************************************/
                if ($E_Type == 1 || $E_Type_Old == 2 || $E_Type_Egr == 3 || $E_Type_Gra == 4)
                {
                    /************************************/
                    $Estudiante = 0;
                    /************************************/
                }
                    /*************************************************/
                    $SQL_Up = 'UPDATE		siq_Apublicoobjetivo
						
								 SET		estudiante="'.$Estudiante.'",
                                            cvs="'.$csv.'",
								 			userid_estado="' . $userid . '",
											changedate=NOW(),
                                            obligar="'.$Obligar.'",
                                            docente="'.$Docente.'"
											
								 WHERE		idsiq_Apublicoobjetivo="' . $id_publicoobjetivo .   
                        '"  AND  codigoestado=100'; 

                    if ($Upd_New = &$db->Execute($SQL_Up) === false)
                    {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] =
                            'Error al Modificar Condiciones del Publñico Obejtivo.....' . $SQL_Up;
                        echo json_encode($a_vectt);
                        exit;
                    }
                    /*************************************************/
                
                /*******************************************************/
                if ($id_NewDetalle)
                {
                    if ($E_new == 1)
                    {
                        $SQL_UpNew = 'UPDATE  siq_Adetallepublicoobjetivo
						 
										 SET     
												 userid_estado="' . $userid . '",
												 changedate=NOW(),
												 tipoestudiante="' . $E_Type . '",
												 E_New="' . $E_new . '",
												 filtro="' . $Filtro_New . '",
												 semestre="' . $S_Cadena_New . '",
												 modalidadsic="' . $Modalidad_id_New . '",
												 codigocarrera="' . $Carrera_new . '",
												 cadena="' . $C_Datos_New . '",
												 tipocadena="' . $TipoCadena_new . '"
												 
										 WHERE   idsiq_Adetallepublicoobjetivo="' . $id_NewDetalle . '" 
										 		 AND  
												 codigoestado=100';

                        if ($Upd_New = &$db->Execute($SQL_UpNew) === false)
                        {
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] =
                                'Error al Modificar Publico Objetivo Detalle Estudiantes Nuevos.....' . $SQL_UpNew;
                            echo json_encode($a_vectt);
                            exit;
                        }
                    }
                } //if

                if ($id_OldDetalle)
                {
                    if ($E_Old == 1)
                    {
                        $SQL_UpOld = 'UPDATE  siq_Adetallepublicoobjetivo
						 
										 SET     
												 
												 userid_estado="' . $userid . '",
												 changedate=NOW(),
												 tipoestudiante="' . $E_Type_Old . '",
												 E_Old="' . $E_Old . '",
												 filtro="' . $Filtro_Old . '",
												 semestre="' . $S_Cadena_Old . '",
												 modalidadsic="' . $Modalidad_id_Old . '",
												 codigocarrera="' . $Carrera_Old . '",
												 cadena="' . $C_Datos_Old . '",
												 tipocadena="' . $TipoCadena_Old . '"
												 
										 WHERE   idsiq_Adetallepublicoobjetivo="' . $id_OldDetalle . '" 
										 		 AND  
												 codigoestado=100';

                        if ($Upd_Old = &$db->Execute($SQL_UpOld) === false)
                        {
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] =
                                'Error al Modificar Publico Objetivo Detalle Estudiantes Antiguos.....' . $SQL_UpOld;
                            echo json_encode($a_vectt);
                            exit;
                        }
                    }
                } //if

                if ($id_EgrDetalle)
                {
                    if ($E_Egre == 1)
                    {
                        $SQL_UpEgr = 'UPDATE  siq_Adetallepublicoobjetivo
						 
										 SET     
												 
												 userid_estado="' . $userid . '",
												 changedate=NOW(),
												 tipoestudiante="' . $E_Type_Egr . '",
												 E_Egr="' . $E_Egre . '",
												 filtro="' . $Filtro_Egre . '",
												 modalidadsic="' . $Modalidad_id_Egre . '",
												 codigocarrera="' . $Carrera_Egre . '",
												 cadena="' . $C_Datos_Egre . '",
												 tipocadena="' . $TipoCadena_Egre . '"
												 
										 WHERE   idsiq_Adetallepublicoobjetivo="' . $id_EgrDetalle . '" 
										 		 AND  
												 codigoestado=100';

                        if ($Upd_Egr = &$db->Execute($SQL_UpEgr) === false)
                        {
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] =
                                'Error al Modificar Publico Objetivo Detalle Estudiantes Egresados.....' . $SQL_UpEgr;
                            echo json_encode($a_vectt);
                            exit;
                        }
                    }
                } //if

                if ($id_GraDetalle)
                {
                    if ($E_Gra == 1)
                    {
                        $SQL_UpGra = 'UPDATE  siq_Adetallepublicoobjetivo
						 
										 SET     
												 
												 userid_estado="' . $userid . '",
												 changedate=NOW(),
												 tipoestudiante="' . $E_Type_Gra . '",
												 E_Gra="' . $E_Gra . '",
												 filtro="' . $Filtro_Gra . '",
												 modalidadsic="' . $Modalidad_Gra . '",
												 codigocarrera="' . $Carrera_Gra . '",
												 cadena="' . $C_Datos_Gra . '",
												 tipocadena="' . $TipoCadena_Gra . '",
                                                 recienegresado="'.$recien.'",
                                                 consolidacionprofesional="'.$consolidacion.'",
                                                 senior="'.$senior.'"
												 
										 WHERE   idsiq_Adetallepublicoobjetivo="' . $id_GraDetalle . '" 
										 		 AND  
												 codigoestado=100';

                        if ($Upd_Gra = &$db->Execute($SQL_UpGra) === false)
                        {
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] =
                                'Error al Modificar Publico Objetivo Detalle Estudiantes Graduados.....' . $SQL_UpGra;
                            echo json_encode($a_vectt);
                            exit;
                        }
                    }
                } //if
                /*******************************************************/
                if($Docente_id){
                    /******************************************************/
                    if($Docente==1 || $Docente==0){
                        
                        $SQL_Docente = 'UPDATE  siq_Adetallepublicoobjetivo
						 
										 SET     
												 
												 userid_estado="' . $userid . '",
												 changedate=NOW(),
                                                 modalidadsic="' .$M_Docente. '",
                                                 docente="' .$Docente. '",
                                                 modalidadocente="' .$CadenaDocente. '"
												
												 
										 WHERE   idsiq_Adetallepublicoobjetivo="' . $Docente_id . '" 
										 		 AND  
												 codigoestado=100';

                        if ($Upd_Docente = &$db->Execute($SQL_Docente) === false)
                        {
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] ='Error al Modificar Publico Objetivo Detalle Docente.....' . $SQL_Docente;
                            echo json_encode($a_vectt);
                            exit;
                        }
                        
                    }//if
                     
                    /******************************************************/
                }else{
                   
                   if($Docente==1 || $Docente==0){//Docente
                    /***********************************************************/
                    $Inset_Detalle = 'INSERT INTO siq_Adetallepublicoobjetivo(idsiq_Apublicoobjetivo,modalidadsic,docente,modalidadocente,userid,entrydate)VALUES("' .$id_publicoobjetivo . '","' .$M_Docente. '","' .$Docente. '","' .$CadenaDocente. '","' . $userid . '",NOW())';

                    if ($InsertDetalle = &$db->Execute($Inset_Detalle) === false)
                    {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] =
                            'Error al Insertar Publico Objetivo Detalle Docentes.....' . $Inset_Detalle;
                        echo json_encode($a_vectt);
                        exit;
                    }
                    /***********************************************************/
                    /***********************************************************/
                   }//if 
                    
                }//if
                
            } //if
           
            if(!$id_publicoobjetivo){ 
                $Ultimo_id=$Last_id;
            }else{ 
                $Ultimo_id=$id_publicoobjetivo;
            }
            
            $a_vectt['val'] = 'TRUE';
            $a_vectt['id'] = $Ultimo_id;
            echo json_encode($a_vectt);
            exit;

        }//Procesar
        break;
        case 'VerMaterias':{
            global $db, $C_Insturmneto;

            MainJson();

            $C_Insturmneto->Materias($_POST['Carrera'], $_POST['Ext']);
        }//VerMaterias
        break;
        case 'Materia':{
            global $db, $C_Insturmneto;

            MainJson();

            $C_Insturmneto->DisplayDos($_POST['modalidad'], $_POST['carrera'], $_POST['carga'],
                $_POST['type'], $_POST['td_Materia'], $_POST['Ext']);
        }//Materia
        break;
        case 'Carrera':{
            global $db, $C_Insturmneto;

            MainJson();

            $C_Insturmneto->Carrera($_POST['Modalidad'], $_POST['codigoCarrera'], $_POST['type'],
                $_POST['Cargamateria'], $_POST['Ext'], $_POST['C_CarreraCodigo']);
        }//Carrera
        break;
        case 'Modalidad':{
            global $db, $C_Insturmneto;

            MainJson();

            $C_Insturmneto->DisplayDos($_POST['modalidad'], $_POST['carrera'], $_POST['carga'],
                $_POST['type'], $_POST['Cargamateria'], $_POST['Ext'], $_POST['CodigoCarrera']);
        }//Modalidad
        break;
        case 'Facultades':{
            global $db, $C_Insturmneto;

            MainJson();

            $C_Insturmneto->Facultad($_POST['type'], $_POST['Ext']);
        }//Facultades
        break;
    }//siwcth
    function MainJson(){
        global $db, $C_Insturmneto, $userid;
        include ("../../templates/templateAutoevaluacion.php");
        include ('instrumento_publico_class.php');
        $C_Insturmneto = new Insturmneto();

        $db = writeHeaderBD();

        if ($_SESSION['MM_Username'] == 'estudiante' && isset($_SESSION['idusuariofinalentradaentrada'])){
            $userid = $_SESSION['idusuariofinalentradaentrada'];
        } else if(isset($_SESSION['MM_Username'])){
            $SQL_User = 'SELECT idusuario as id FROM usuario WHERE usuario="' . $_SESSION['MM_Username'] .'"';
        if ($Usuario = &$db->Execute($SQL_User) === false){
            echo 'Error en el SQL usuario....<br><br>' . $SQL_User;
            die;
        }

        $userid = $Usuario->fields['id'];
        } /*else if(isset($_POST['Userid'])&&!empty($_POST['Userid'])){
		 $userid = $_POST['Userid'];
	}*/
    }//MainJson