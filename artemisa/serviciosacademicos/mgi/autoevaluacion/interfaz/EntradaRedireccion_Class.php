<?PHP

class EntradaRedirecion {

    public function Consulta($userid, $CodigoPeriodo, $Posponer = '', $id_instrumento = '') {        
        global $db;
        include_once('../ReportesAuditoria/templates/mainjson.php');

        if ($Posponer == 1) {
            $Fecha = date('Y-m-d');
            $Excepcion = "AND  e.id_instrumento NOT IN (SELECT "
            ." id_instrumento as id FROM "
            ." actualizacionusuario WHERE usuarioid='" . $userid . "' "
            ." AND codigoestado=100  "
            ." AND estadoactualizacion=3 "
            ." AND id_instrumento<='" . $id_instrumento . "' )";
        } else {
            $Excepcion = "";
        }
        
        if(!empty($id_instrumento)){
            $instrumento = " and e.id_instrumento = '".$id_instrumento."' ";
        }else{
            $instrumento = "";
        }
        //query que seleccione aleatoriamente mientras
        $Query_EntradaUsuario = "SELECT *  FROM( "
        ." SELECT u.*,e.identradaredireccion,e.urlentradaredireccion,e.fechainicioentradaredireccion, "
        ." e.fechafinalentradaredireccion,e.codigoestado,e.id_instrumento,e.tipoactualizacion "
        ." FROM  usuario u , entradaredireccion e "
        ." WHERE "
        ." (u.codigotipousuario =e.codigotipousuario  OR e.codigotipousuario =0) "
        ." and now() between fechainicioentradaredireccion and fechafinalentradaredireccion "
        ." and u.idusuario='" . $userid . "' ".$instrumento." AND codigoestado=100 " . $Excepcion . " ORDER BY RAND() "
        ." ) x ORDER BY tipoactualizacion";        
        if ($R_EntradaUsuario = &$db->Execute($Query_EntradaUsuario) === false) {//if
            echo 'Error en la Consulta de Entrada Redirecion ...<br><br>' . $Query_EntradaUsuario;
            die;
        }//if

        if (!$R_EntradaUsuario->EOF) {
            /********************************************************/
            while (!$R_EntradaUsuario->EOF) {                
                $id_instrumento = $R_EntradaUsuario->fields['id_instrumento'];
                /********************************************************/
                if ($R_EntradaUsuario->fields['tipoactualizacion'] == 0) {
                    if ($id_instrumento != 150 && $id_instrumento != 151 && $id_instrumento != 152 && $id_instrumento != 153 && $id_instrumento != 154 && $id_instrumento != 155 && $id_instrumento != 156 && $id_instrumento != 157 && $id_instrumento != 158) {
                        $SQL = "SELECT * FROM actualizacionusuario "
                        . "WHERE id_instrumento='".$R_EntradaUsuario->fields['id_instrumento']."'" 
                        ." AND usuarioid='".$userid."'" 
                        ." AND codigoestado=100 "
                        ." AND estadoactualizacion=2";
                    } else {
                        //POR AHORA PARA QUE SI CONTESTO 1 NO LO OBLIGUE A CONTESTAR MAS
                        $SQL = "SELECT idactualizacionusuario as id,  "
                        . " estadoactualizacion   FROM actualizacionusuario  WHERE  "
                        ." usuarioid='".$userid."' "
                        ." AND id_instrumento IN (150,151,152,153,154,155,156,157,158) "
                        ." AND codigoestado=100 "
                        ." AND estadoactualizacion=2";
                    }                    
                    if ($ValidaInstrumentos = &$db->Execute($SQL) === false) {
                        echo 'Error en el SQL que Valida los Instrumentos...<br><br>' . $SQL;
                        die;
                    }
                    if ($ValidaInstrumentos->EOF) {
                        $SQL_V = "SELECT idsiq_Arespuestainstrumento FROM siq_Arespuestainstrumento ar  "
                        ." inner join siq_Ainstrumentoconfiguracion i on i.idsiq_Ainstrumentoconfiguracion=ar.idsiq_Ainstrumentoconfiguracion "
                        ." WHERE ar.usuariocreacion ='".$userid."'" 
                        ." AND ar.idsiq_Ainstrumentoconfiguracion ='".$R_EntradaUsuario->fields['id_instrumento']."'"
                        . " AND i.cat_ins<>'EDOCENTES'";
                        if ($ValidaFinalAcceso = &$db->Execute($SQL_V) === false) {
                            echo 'Error en el SQL que Valida los Instrumentos...<br><br>del sistema';
                            die;
                        }

                        if ($ValidaFinalAcceso->EOF) {
                            /********************************************************/
                            //$query_periodo = "SELECT * FROM usuario u INNER JOIN estudiantegeneral e 
                            //ON e.numerodocumento=u.numerodocumento AND u.idusuario='".$userid."'";
                            $query_periodo = "SELECT * FROM usuario u  WHERE  u.idusuario='".$userid."' "
                            . "AND  codigoestadousuario=100";
                            if ($DataUsuer = &$db->Execute($query_periodo) === false) {
                                echo 'error en el sql de datos de Usuario....<br><br>' . $query_periodo;
                                die;
                            }

                            if (($DataUsuer->fields['codigorol'] == 2) || ($DataUsuer->fields['codigorol'] == 1 && $DataUsuer->fields['codigotipousuario'] == 600) || ($DataUsuer->fields['codigorol'] == 3)) {
                                /***************************************************************/
                                $instrumento_id = $R_EntradaUsuario->fields['id_instrumento'];
                                $Tipo_user = $DataUsuer->fields['codigorol'];
                                $Estudiante_Gene = '';                                

                                if (($DataUsuer->fields['codigorol'] == 1 || $DataUsuer->fields['codigorol'] == '1') && $DataUsuer->fields['codigotipousuario'] == 600) {
                                    $query_periodo = "SELECT * FROM usuario u "
                                    . "INNER JOIN estudiantegeneral e ON e.numerodocumento=u.numerodocumento "
                                    . "AND u.idusuario='" . $userid . "'";
                                    if ($Estudiante_id = &$db->Execute($query_periodo) === false) {
                                        echo 'Error en el SQL de los estudiante al buscar el id<br><br>' . $query_periodo;
                                        die;
                                    }
                                    $Estudiante_Gene = $Estudiante_id->fields["idestudiantegeneral"];
                                }// Estudiantes

                                $Permiso_Instrumento = $this->ValidadInfo($instrumento_id, $userid, $Tipo_user, $Estudiante_Gene);                                
                                if ($Permiso_Instrumento == 1) {
                                    /*****************************************************/
                                    $SQL = 'SELECT idsiq_Ainstrumentoconfiguracion AS id, cat_ins
                                            FROM siq_Ainstrumentoconfiguracion
                                            WHERE codigoestado=100
                                            AND idsiq_Ainstrumentoconfiguracion="' . $instrumento_id . '"';
                                    if ($CategoriaInstrumento = &$db->Execute($SQL) === false) {
                                        echo 'Error en el SQL Categoria Instrumento....<br><br>' . $SQL;
                                        die;
                                    }

                                    if ($CategoriaInstrumento->fields['cat_ins'] == 'EDOCENTES') {
                                        $URL = '/serviciosacademicos/mgi/autoevaluacion/interfaz/EvaluacionDocente.php?id_instrumento=' . $instrumento_id . '&userid=' . $userid;
                                    } else {
                                        $URL = '/serviciosacademicos/mgi/autoevaluacion/interfaz/instrumento_aplicar.php?id_instrumento=' . $instrumento_id . '&Ver=1';
                                    }

                                    $C_Data = array();
                                    $C_Data['URL'] = $URL;
                                    $C_Data['Activo'] = 1;
                                    $C_Data['id_instrumento'] = $instrumento_id;

                                    return $C_Data;
                                    break;
                                    /*****************************************************/
                                }//Permisos instrumento if 
                                /***************************************************************/
                            }//if
                            /***************************************************************/
                        } else {
                            $SQL = 'SELECT cat_ins FROM siq_Ainstrumentoconfiguracion
                            WHERE idsiq_Ainstrumentoconfiguracion="' . $id_instrumento . '"
                            AND cat_ins="EDOCENTES"';
                            if ($ValidaCat = &$db->Execute($SQL) === false) {
                                echo 'Error en el Sistema..';
                                die;
                            }

                            if ($ValidaCat->EOF) {
                                echo $SQL_Insert = 'INSERT INTO actualizacionusuario(usuarioid,id_instrumento,codigoperiodo,estadoactualizacion,userid,entrydate)'
                                . 'VALUES("' . $userid . '","' . $R_EntradaUsuario->fields['id_instrumento'] . '","' . $CodigoPeriodo . '",2,"' . $userid . '",NOW())';
                                if ($InserUltime = &$db->Execute($SQL_Insert) === false) {
                                    echo 'Error en el SQL .....<br><br>';
                                    die;
                                }
                            }
                        }//else
                    }//if
                    /************************* */
                } else if ($R_EntradaUsuario->fields['tipoactualizacion'] > 0 && $R_EntradaUsuario->fields['tipoactualizacion'] != 5) {                   
                    $SQL = 'SELECT * FROM actualizacionusuario WHERE
                    tipoactualizacion="' . $R_EntradaUsuario->fields['tipoactualizacion'] . '"
                    AND codigoperiodo="' . $CodigoPeriodo . '"
                    AND usuarioid="' . $userid . '"
                    AND codigoestado=100
                    AND estadoactualizacion=2';
                    if ($Valida_URL = &$db->Execute($SQL) === false) {
                        echo 'Error en el SQL .....<br><br>' . $SQL;
                        die;
                    }
                    if ($Valida_URL->EOF) {
                        /************************************************/
                        $C_Data = array();
                        $C_Data['URL'] = $R_EntradaUsuario->fields['urlentradaredireccion'];
                        $C_Data['Activo'] = 1;
                        return $C_Data;
                        break;
                        /************************************************/
                    }
                    /************************** */
                } else {
                    /* CREADA PARQA EL USO DE LAS ENCUESTAS DEL OBSERVATORIO */                    
                    $SQL = 'SELECT *
                            FROM
                            actualizacionusuario
                            WHERE
                            codigoperiodo="' . $CodigoPeriodo . '"
                            AND usuarioid="' . $userid . '"
                            AND id_instrumento="' . $R_EntradaUsuario->fields['id_instrumento'] . '"
                            AND codigoestado=100
                            AND estadoactualizacion=2';
                    if ($Consulta = &$db->Execute($SQL) === false) {
                        echo 'Error en el SQL ...<br><br>' . $SQL;
                        die;
                    }
                    /***************************************************************************************/
                    if ($Consulta->EOF) {
                        $P_Permiso = $this->Observatorio($userid, $CodigoPeriodo);
                        if ($P_Permiso == 1) {
                            /*****************************************************/
                            $C_Data = array();
                            $C_Data['URL'] = '/serviciosacademicos/mgi/autoevaluacion/interfaz/instrumento_aplicar.php?id_instrumento=' . $R_EntradaUsuario->fields['id_instrumento'] . '&Ver=2'; //
                            $C_Data['Activo'] = 1;
                            $C_Data['id_instrumento'] = $R_EntradaUsuario->fields['id_instrumento'];
                            return $C_Data;
                            break;
                            /*****************************************************/
                        }//Permisos instrumento
                    }
                    /************************************************************************************** */
                }
                /****************************************************/
                $R_EntradaUsuario->MoveNext();
            }
            /********************************************************/
        }//if
        $C_Data = array();
        $C_Data['URL'] = '';
        $C_Data['Activo'] = 0;
        $C_Data['id_instrumento'] = '';
        return $C_Data;
        break;
    }

//public function Consulta

    public function ValidadInfo($instrumento_id, $userid, $Tipo_user, $Estudiante_Gene = '') {
        global $db;

        /* echo '<br>Instrumento->'.$instrumento_id;
          echo '<br>user_id->'.$userid;
          echo '<br>Tipo_user->'.$Tipo_user;
          echo '<br>Estudiante_General->'.$Estudiante_Gene; */

        /*         * ***************************************************************************************** */

        $SQL = 'SELECT *
				  FROM
                    siq_Apublicoobjetivo
				  WHERE
				  	idsiq_Ainstrumentoconfiguracion="' . $instrumento_id . '"
					AND codigoestado=100';

        if ($UsusariosValidos = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de Validar Usuarios Permitidos ,....<br><br>' . $SQL;
            die;
        }

        if (!$UsusariosValidos->EOF) {
            /*             * ********************************************************************************** */
            $Estudiante = $UsusariosValidos->fields['estudiante'];
            $Docente = $UsusariosValidos->fields['docente'];
            $Admin = $UsusariosValidos->fields['admin'];
            $Publico_id = $UsusariosValidos->fields['idsiq_Apublicoobjetivo'];

            $D_Usuer = $this->DataUser($userid);

            $Permiso = 0;

            if ($Tipo_user == 1) {//tipo 1 Estudiante
                $Permiso = 0;
                if ($Estudiante == 0) {
                    $Permiso = 0;
                    /*                     * *********************************************** */
                    if ($D_Usuer['codigorol'] == 1) { //Estudiante
                        $Permiso = 0;
                        /*                         * *************************************** */
                        $SQL_P = 'SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo IN (1,3)';

                        if ($PeriodoCodigo = &$db->Execute($SQL_P) === false) {
                            echo 'Error en el SQl de PeriodoCodigo ......<br><br>' . $SQL_P;
                            die;
                        }

                        $Periodo = $PeriodoCodigo->GetArray();
                        /*                         * *************************************** */
                        $SQL_D = 'SELECT *
                                            FROM
											     siq_Adetallepublicoobjetivo
											WHERE
												idsiq_Apublicoobjetivo="' . $Publico_id . '"
												AND codigoestado=100';

                        if ($DetallePublicoEstudiante = &$db->Execute($SQL_D) === false) {
                            echo 'Error en el SQl del Detalle del Publico Estudiante...<br><br>' . $SQL_D;
                            die;
                        }

                        if (!$DetallePublicoEstudiante->EOF) {
                            $Permiso = 0;
                            /*                             * **************************************** */

                            $E_DPublico = $DetallePublicoEstudiante->GetArray();

                            $SQL_Info = 'SELECT
															e.codigoestudiante,
															e.codigocarrera,
															e.codigotipoestudiante,
															t.nombretipoestudiante,
															e.codigosituacioncarreraestudiante  AS situacion,
															s.nombresituacioncarreraestudiante,
															c.nombrecarrera,
															m.nombremodalidadacademicasic
                                                            FROM
															estudiante e INNER JOIN situacioncarreraestudiante s ON s.codigosituacioncarreraestudiante=e.codigosituacioncarreraestudiante
																		 INNER JOIN tipoestudiante t ON t.codigotipoestudiante=e.codigotipoestudiante
																		 INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
																		 INNER JOIN modalidadacademicasic m ON m.codigomodalidadacademicasic=c.codigomodalidadacademicasic
                                                                         INNER JOIN prematricula p ON p.codigoestudiante = e.codigoestudiante

															WHERE
                                                            e.idestudiantegeneral="' . $Estudiante_Gene . '"
															AND
															m.codigomodalidadacademicasic NOT IN (000,100,101,400)
															AND
															m.codigoestado=100
                                                            AND p.codigoestadoprematricula = 40
                                                            GROUP BY c.codigocarrera';
                            if ($Info_Estudiante = &$db->Execute($SQL_Info) === false) {
                                echo 'Error en el SQL de Info Adicional del Estudiante ...<br><br>' . $SQL_Info;
                                die;
                            }

                            $E_DPublico[0]['E_New']; //Estudiantes Nuevos
                            $E_DPublico[1]['E_Old']; //Estudiantes Antiguos
                            $E_DPublico[2]['E_Egr']; //Estudiantes Egresados
                            $E_DPublico[3]['E_Gra']; //Estudiantes Graduados


                            $EstudinteGeneral_id = $Estudiante_Gene; //id Estudiante Genral

                            while (!$Info_Estudiante->EOF && $Permiso === 0) {
                                $Permiso = 0;
                                /*                                 * *********************************************************************** */
                                /*
                                  tipo estudiante

                                  10-->Nuevo
                                  11-->Transferencia
                                  20-->Antiguo
                                  21-->Reintegro

                                  situacion estudfiante

                                  300-->Admitido
                                  301-->Normal
                                  200-->Prueba Academica
                                  104-->Egresado
                                  400-->Graduado
                                 */
                                /*                                 * **Filtro Para estudiantes Nuevos o en Trasferencia** */
                                if ($Info_Estudiante->fields['codigotipoestudiante'] == 10 || $Info_Estudiante->fields['codigotipoestudiante'] == 11) {//if...1
                                    //echo "<br/> entre al primer if";
                                    if ($Info_Estudiante->fields['situacion'] == 300 || $Info_Estudiante->fields['situacion'] == 301) {//if...2
                                        //echo "<br/> entre al segundo if"; 
                                        if ($E_DPublico[0]['E_New'] == 1) { //if...3
                                            $Permiso = 0;

                                            if ($E_DPublico[0]['filtro'] == 0) {//if...4                                                               
                                                /* Filtro si es Por Facultades */
                                                $Permiso = 0;

                                                if ($Periodo[1]['codigoperiodo']) {
                                                    $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                } else {
                                                    $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                }
                                                /*
                                                 * Caso 90791
                                                 * @modified Luis Dario Gualteros 
                                                 * <castroluisd@unbosque.edu.co>
                                                 * Se modifica la consulta con la condición p.codigoestadoprematricula = 40  
                                                 * para que solo pida evaluar materias a los estudiantes que se encuentren * matriculados al progarma de Psicologia y no inscritos o no admitidos.
                                                 * @since Junio 9 de 2017
                                                 */
                                                /*                                                 * *********************************************************** */
                                                $SQL_F = 'SELECT
																			e.codigoestudiante,
																			e.idestudiantegeneral,
																			e.codigocarrera,
																			c.codigofacultad,
																			f.nombrefacultad,
																			p.codigoperiodo,
																		    p.semestreprematricula
                                                                            FROM
                                                                            estudiante e INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
																									 INNER JOIN facultad f ON f.codigofacultad=c.codigofacultad
																									 INNER JOIN modalidadacademicasic m ON m.codigomodalidadacademicasic=c.codigomodalidadacademicasic
																									 INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
																			WHERE
                                                                            e.idestudiantegeneral="' . $EstudinteGeneral_id . '"
																			AND
																			m.codigomodalidadacademicasic NOT IN (000,100,101,400)
																			AND
																			m.codigoestado=100
																			
                                                                            AND p.codigoestadoprematricula = 40 
                                                                            AND 
																			e.codigoestudiante="' . $Info_Estudiante->fields['codigoestudiante'] . '"
																			AND ' . $Condicion_Periodo;
                                                // End Caso 90791
                                                if ($FacultadEstudiante = &$db->Execute($SQL_F) === false) {
                                                    echo 'Error en el SQL Facultad.........<br><br>' . $SQL_F;
                                                    die;
                                                }

                                                if (!$FacultadEstudiante->EOF) {//if...5
                                                    /*                                                     * *************************************************************** */
                                                    $Permiso = 0;
                                                    /*
                                                      Todos los Semestres ->99
                                                      si es diferente de 99 es una cadena wjwmplo 1,2,3,4,5,6
                                                     */

                                                    /*                                                     * ************************************************************** */
                                                    if ($E_DPublico[0]['semestre'] == 99) {//if...Semestres Todos
                                                        /*                                                         * ****************************************************** */
                                                        if ($E_DPublico[0]['cadena'] === 0 || $E_DPublico[0]['cadena'] === '0') {

                                                            $C_Cadena = 0;
                                                            $Permiso = 1;
                                                        } else {

                                                            $C_Cadena = explode('::', $E_DPublico[0]['cadena']);

                                                            for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                /*                                                                 * ************************************ */
                                                                if ($FacultadEstudiante->fields['codigofacultad'] == $C_Cadena[$i]) {
                                                                    $Permiso = 1;
                                                                }
                                                                /*                                                                 * ************************************ */
                                                            }//for
                                                        }
                                                        /*                                                         * ****************************************************** */
                                                    } else {
                                                        /*                                                         * ****************************************************** */
                                                        if ($E_DPublico[0]['cadena'] === 0 || $E_DPublico[0]['cadena'] === '0') {

                                                            $C_Cadena = 0;
                                                            $C_Semestre = explode(',', $E_DPublico[0]['semestre']);

                                                            for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                /*                                                                 * ************************************************** */
                                                                if ($C_Semestre[$j] == $FacultadEstudiante->fields['semestreprematricula']) {//if
                                                                    /*                                                                     * ********************************************** */
                                                                    $Permiso = 1;
                                                                    /*                                                                     * ********************************************** */
                                                                }//if
                                                            }//for	Semestre
                                                        } else {

                                                            $C_Semestre = explode(',', $E_DPublico[0]['semestre']);
                                                            $C_Cadena = explode('::', $E_DPublico[0]['cadena']);

                                                            for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                /*                                                                 * ************************************************** */
                                                                if ($C_Semestre[$j] == $FacultadEstudiante->fields['semestreprematricula']) {//if
                                                                    /*                                                                     * ********************************************** */
                                                                    for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                        /*                                                                         * ************************************ */
                                                                        if ($FacultadEstudiante->fields['codigofacultad'] == $C_Cadena[$i]) {
                                                                            $Permiso = 1;
                                                                        }
                                                                        /*                                                                         * ************************************ */
                                                                    }//for
                                                                    /*                                                                     * ********************************************** */
                                                                }//if
                                                                /*                                                                 * ************************************************** */
                                                            }//for semestre
                                                        }//if

                                                        /*                                                         * ****************************************************** */
                                                    }//if semestre
                                                    /*                                                     * ************************************************************** */
                                                    /*                                                     * *************************************************************** */
                                                }//if...5
                                                /*                                                 * *********************************************************** */
                                            }//if...4

                                            if ($E_DPublico[0]['filtro'] == 1) {//if...6

                                                /* Filtro si es Por Modalidad Acdemica */
                                                $Permiso = 0;
                                                /*                                                 * ************************************************************************************* */
                                                if ($Periodo[1]['codigoperiodo']) {
                                                    $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                } else {
                                                    $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                }
                                                /*                                                 * ********************************************************************* */
                                                /*
                                                 * Caso 90791
                                                 * @modified Luis Dario Gualteros 
                                                 * <castroluisd@unbosque.edu.co>
                                                 * Se modifica la consulta con la condición p.codigoestadoprematricula = 40  
                                                 * para que solo pida evaluar materias a los estudiantes que se encuentren * matriculados al progarma de Psicologia y no inscritos o no admitidos.
                                                 * @since Junio 9 de 2017
                                                 */
                                                $SQL_C = 'SELECT

																			e.codigoestudiante,
																			e.idestudiantegeneral,
																			e.codigocarrera,
																			c.nombrecarrera,
																			p.codigoperiodo,
																			p.semestreprematricula

																			FROM

																			estudiante e INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
																						 INNER JOIN modalidadacademica m ON m.codigomodalidadacademica=c.codigomodalidadacademica
																						 INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
																			WHERE
                                                                            
																			e.idestudiantegeneral="' . $EstudinteGeneral_id . '"
																			AND
																			m.codigomodalidadacademica NOT IN (000,100,101,400)
																			AND
                                                                            p.codigoestadoprematricula = 40
                                                                            AND
																			m.codigoestado=100
																			AND
																			' . $Condicion_Periodo . '
                                                                            AND
                                                                            c.codigomodalidadacademica="' . $E_DPublico[0]['modalidadsic'] . '"';
                                                // End Caso 90791
                                                if ($CarreraEstudiante = &$db->Execute($SQL_C) === false) {
                                                    echo 'Error en el SQl de La carrera del estudiante....<br><br>' . $SQL_C;
                                                    die;
                                                }

                                                if (!$CarreraEstudiante->EOF) {//if...7
                                                    $Permiso = 0;

                                                    //echo '<pre>';print_r($C_Cadena);die;
                                                    while (!$CarreraEstudiante->EOF) {//while
                                                        /*                                                         * ************************************************************** */
                                                        if ($E_DPublico[0]['semestre'] == 99) {//if...Semestres Todos
                                                            /*                                                             * ****************************************************** */
                                                            if ($E_DPublico[0]['cadena'] === 0 || $E_DPublico[0]['cadena'] === '0') {

                                                                $C_Cadena = 0;
                                                                $Permiso = 1;
                                                            } else {

                                                                $C_Cadena = explode('::', $E_DPublico[0]['cadena']);

                                                                for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                    if ($C_Cadena[$i] == $CarreraEstudiante->fields['codigocarrera']) {
                                                                        $Permiso = 1;
                                                                    }
                                                                }//for
                                                            }//if

                                                            /*                                                             * ****************************************************** */
                                                        } else {
                                                            /*                                                             * ****************************************************** */
                                                            if ($E_DPublico[0]['cadena'] === 0 || $E_DPublico[0]['cadena'] === '0') {

                                                                $C_Cadena = 0;
                                                                $C_Semestre = explode(',', $E_DPublico[0]['semestre']);

                                                                for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                    /*                                                                     * ************************************************** */
                                                                    if ($C_Semestre[$j] == $CarreraEstudiante->fields['semestreprematricula']) {//if
                                                                        /*                                                                         * ********************************************** */
                                                                        $Permiso = 1;
                                                                        /*                                                                         * ********************************************** */
                                                                    }//if
                                                                }//for	Semestre
                                                            } else {

                                                                $C_Semestre = explode(',', $E_DPublico[0]['semestre']);
                                                                $C_Cadena = explode('::', $E_DPublico[0]['cadena']);

                                                                for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                    //echo "primer for";
                                                                    /*                                                                     * ************************************************** */
                                                                    if ($C_Semestre[$j] == $CarreraEstudiante->fields['semestreprematricula']) {//if
                                                                        //echo "if primer for";
                                                                        /*                                                                         * ********************************************** */
                                                                        for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                            if ($C_Cadena[$i] == $CarreraEstudiante->fields['codigocarrera']) {
                                                                                $Permiso = 1;
                                                                            }
                                                                        }//for
                                                                        /*                                                                         * ********************************************** */
                                                                    }//if
                                                                    /*                                                                     * ************************************************** */
                                                                }//for semestre
                                                            }//if

                                                            /*                                                             * ****************************************************** */
                                                        }//if semestre
                                                        /*                                                         * ************************************************************** */

                                                        $CarreraEstudiante->MoveNext();
                                                    }//while
                                                }//if...7
                                            }//if...6
                                            if ($E_DPublico[0]['filtro'] == 2) {//if...8
                                                /* Filtro si es Por Materias */
                                                $Permiso = 0;
                                                /*                                                 * ************************************************************************************* */
                                                if ($Periodo[1]['codigoperiodo']) {
                                                    $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                } else {
                                                    $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                }
                                                /*                                                 * ********************************************************************* */
                                                /*
                                                 * Caso 90791
                                                 * @modified Luis Dario Gualteros 
                                                 * <castroluisd@unbosque.edu.co>
                                                 * Se modifica la consulta con la condición p.codigoestadoprematricula = 40  
                                                 * para que solo pida evaluar materias a los estudiantes que se encuentren * * matriculados al progarma de Psicologia y no inscritos o no admitidos.
                                                 * @since Junio 9 de 2017
                                                 */
                                                $SQL_C = 'SELECT

																			e.codigoestudiante,
																			e.idestudiantegeneral,
																			e.codigocarrera,
																			c.nombrecarrera,
																			p.codigoperiodo,
																			p.semestreprematricula

																			FROM

																			estudiante e INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
																						 INNER JOIN modalidadacademica m ON m.codigomodalidadacademica=c.codigomodalidadacademica
																						 INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
																			WHERE

																			e.idestudiantegeneral="' . $EstudinteGeneral_id . '"
																			AND
																			m.codigomodalidadacademica NOT IN (000,100,101,400)
																			AND
                                                                            p.codigoestadoprematricula = 40
                                                                            and
																			m.codigoestado=100
																			AND
																			' . $Condicion_Periodo;
                                                // End Caso 90791
                                                if ($CarreraEstudiante = &$db->Execute($SQL_C) === false) {
                                                    echo 'Error en el SQl de La carrera del estudiante....<br><br>' . $SQL_C;
                                                    die;
                                                }

                                                $Permiso = 0;



                                                while (!$CarreraEstudiante->EOF) {
                                                    /*                                                     * ************************************************************************************* */

                                                    /*                                                     * ************************************************************** */
                                                    if ($E_DPublico[0]['semestre'] == 99) {//if...Semestres Todos
                                                        /*                                                         * ****************************************************** */
                                                        if ($E_DPublico[0]['cadena'] === 0 || $E_DPublico[0]['cadena'] === '0') {

                                                            $C_Cadena = 0;
                                                            $Permiso = 1;
                                                        } else {

                                                            if ($Periodo[1]['codigoperiodo']) {
                                                                $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                            } else {
                                                                $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                            }
                                                            /*
                                                             * Caso 90791
                                                             * @modified Luis Dario Gualteros 
                                                             * <castroluisd@unbosque.edu.co>
                                                             * Se modifica la consulta con la condición
                                                             * p.codigoestadoprematricula = 40  
                                                             * para que solo pida evaluar materias a los estudiantes que se encuentren * matriculados al progarma de Psicologia y no inscritos o no admitidos.
                                                             * @since Junio 9 de 2017
                                                             */
                                                            $SQL_M = 'SELECT

																						p.idprematricula,
																						dp.codigomateria

																						FROM

																						prematricula p INNER JOIN detalleprematricula dp ON dp.idprematricula=p.idprematricula


																						WHERE

																						p.codigoestudiante="' . $CarreraEstudiante->fields['codigoestudiante'] . '"
																						AND
																						' . $Condicion_Periodo . '
																						AND
																						p.codigoestadoprematricula=40
																						AND
																						dp.codigoestadodetalleprematricula=30';

                                                            // End Caso 90791
                                                            if ($Materia_Estudiante = &$db->Execute($SQL_M) === false) {
                                                                echo 'Error en el SQL Materias ....<br><br>' . $SQL_M;
                                                                die;
                                                            }

                                                            while (!$Materia_Estudiante->EOF) {
                                                                /*                                                                 * ************************************************************************ */
                                                                $C_Cadena = explode('::', $E_DPublico[0]['cadena']);


                                                                for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                    if ($C_Cadena[$i] == $Materia_Estudiante->fields['codigomateria']) {
                                                                        $Permiso = 1;
                                                                    }
                                                                }//for
                                                                /*                                                                 * ************************************************************************ */
                                                                $Materia_Estudiante->MoveNext();
                                                            }//while
                                                        }//if

                                                        /*                                                         * ****************************************************** */
                                                    } else {
                                                        /*                                                         * ****************************************************** */
                                                        if ($E_DPublico[0]['cadena'] === 0 || $E_DPublico[0]['cadena'] === '0') {

                                                            $C_Cadena = 0;
                                                            $C_Semestre = explode(',', $E_DPublico[0]['semestre']);

                                                            for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                /*                                                                 * ************************************************** */
                                                                if ($C_Semestre[$j] == $CarreraEstudiante->fields['semestreprematricula']) {//if
                                                                    /*                                                                     * ********************************************** */
                                                                    $Permiso = 1;
                                                                    /*                                                                     * ********************************************** */
                                                                }//if
                                                            }//for	Semestre
                                                        } else {

                                                            $C_Semestre = explode(',', $E_DPublico[0]['semestre']);
                                                            $C_Cadena = explode('::', $E_DPublico[0]['cadena']);

                                                            for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                /*                                                                 * ************************************************** */
                                                                if ($C_Semestre[$j] == $CarreraEstudiante->fields['semestreprematricula']) {//if
                                                                    /*                                                                     * ********************************************** */
                                                                    if ($Periodo[1]['codigoperiodo']) {
                                                                        $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                                    } else {
                                                                        $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                                    }
                                                                    /*                                                                     * ********************************************** */
                                                                    /*
                                                                     * Caso 90791
                                                                     * @modified Luis Dario Gualteros 
                                                                     * <castroluisd@unbosque.edu.co>
                                                                     * Se modifica la consulta con la condición p.codigoestadoprematricula = 40  
                                                                     * para que solo pida evaluar materias a los estudiantes que se encuentren * matriculados al progarma de Psicologia y no inscritos o no admitidos.
                                                                     * @since Junio 9 de 2017
                                                                     */
                                                                    $SQL_M = 'SELECT

																								p.idprematricula,
																								dp.codigomateria

																								FROM

																								prematricula p INNER JOIN detalleprematricula dp ON dp.idprematricula=p.idprematricula


																								WHERE

																								p.codigoestudiante="' . $CarreraEstudiante->fields['codigoestudiante'] . '"
																								AND
																								' . $Condicion_Periodo . '
																								AND
																								p.codigoestadoprematricula=40
																								AND
																								dp.codigoestadodetalleprematricula=30';

                                                                    // End Caso 90791
                                                                    if ($Materia_Estudiante = &$db->Execute($SQL_M) === false) {
                                                                        echo 'Error en el SQL Materias ....<br><br>' . $SQL_M;
                                                                        die;
                                                                    }

                                                                    while (!$Materia_Estudiante->EOF) {
                                                                        /*                                                                         * ************************************************************************ */
                                                                        for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                            if ($C_Cadena[$i] == $Materia_Estudiante->fields['codigomateria']) {
                                                                                $Permiso = 1;
                                                                            }
                                                                        }//for
                                                                        /*                                                                         * ************************************************************************ */
                                                                        $Materia_Estudiante->MoveNext();
                                                                    }//while

                                                                    /*                                                                     * ********************************************** */
                                                                }//if
                                                                /*                                                                 * ************************************************** */
                                                            }//for semestre
                                                        }

                                                        /*                                                         * ****************************************************** */
                                                    }//if semestre
                                                    /*                                                     * ************************************************************** */
                                                    /*                                                     * ************************************************************************************* */
                                                    $CarreraEstudiante->MoveNext();
                                                }//while
                                            }//if...8
                                        }//if...3
                                    }//if....2
                                }//if.....1

                                /*                                 * ***Filtro para estudiantes antiguos o de reintegro********* */

                                if ($Info_Estudiante->fields['codigotipoestudiante'] == 20 || $Info_Estudiante->fields['codigotipoestudiante'] == 21) {//if...1
                                    //echo 'if 1'; die;
                                    if ($Info_Estudiante->fields['situacion'] == 301 || $Info_Estudiante->fields['situacion'] == 200) {//if...2
                                        //echo 'if 2'; die;
                                        if ($E_DPublico[1]['E_Old'] == 1) {//if...3
                                            //echo 'if 3'; die;
                                            $Permiso = 0;
                                            /*                                             * ***************************************************************************************** */

                                            if ($E_DPublico[1]['filtro'] == 0) {//if...4

                                                /* Filtro si es Por Facultades */
                                                $Permiso = 0;
                                                /*                                                 * ************************************************************************************* */
                                                /* $SQL_F='SELECT

                                                  e.codigoestudiante,
                                                  e.idestudiantegeneral,
                                                  e.codigocarrera,
                                                  c.codigofacultad,
                                                  f.nombrefacultad

                                                  FROM

                                                  estudiante e INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                                                  INNER JOIN facultad f ON f.codigofacultad=c.codigofacultad
                                                  INNER JOIN modalidadacademicasic m ON m.codigomodalidadacademicasic=c.codigomodalidadacademicasic
                                                  WHERE

                                                  e.idestudiantegeneral="'.$EstudinteGeneral_id.'"
                                                  AND
                                                  m.codigomodalidadacademicasic NOT IN (000,100,101,400)
                                                  AND
                                                  m.codigoestado=100
                                                  AND
                                                  e.codigoestudiante="'.$Info_Estudiante->fields['codigoestudiante'].'"'; */

                                                if ($Periodo[1]['codigoperiodo']) {
                                                    $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                } else {
                                                    $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                }
                                                /*
                                                 * Caso 90791
                                                 * @modified Luis Dario Gualteros 
                                                 * <castroluisd@unbosque.edu.co>
                                                 * Se modifica la consulta con la condición p.codigoestadoprematricula = 40  
                                                 * para que solo pida evaluar materias a los estudiantes que se encuentren 
                                                 * matriculados al progarma de Psicologia y no inscritos o no admitidos.
                                                 * @since Junio 9 de 2017
                                                 */

                                                $SQL_F = 'SELECT

																			e.codigoestudiante,
																			e.idestudiantegeneral,
																			e.codigocarrera,
																			c.codigofacultad,
																			f.nombrefacultad,
																			p.codigoperiodo,
																		    p.semestreprematricula

																			FROM

																			estudiante e INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
																									 INNER JOIN facultad f ON f.codigofacultad=c.codigofacultad
																									 INNER JOIN modalidadacademicasic m ON m.codigomodalidadacademicasic=c.codigomodalidadacademicasic
																									 INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
																			WHERE

																			e.idestudiantegeneral="' . $EstudinteGeneral_id . '"
																			AND
																			m.codigomodalidadacademicasic NOT IN (000,100,101,400)
																			AND
																			m.codigoestado=100
																			AND
                                                                            p.codigoestadoprematricula = 40
                                                                            AND
																			e.codigoestudiante="' . $Info_Estudiante->fields['codigoestudiante'] . '"
																			AND
																		   ' . $Condicion_Periodo;
                                                // End Caso 90791
                                                if ($FacultadEstudiante = &$db->Execute($SQL_F) === false) {
                                                    echo 'Error en el SQL Facultad.........<br><br>' . $SQL_F;
                                                    die;
                                                }

                                                while (!$FacultadEstudiante->EOF) {//While
                                                    $Permiso = 0;


                                                    /*
                                                      Todos los Semestres ->99
                                                      si es diferente de 99 es una cadena wjwmplo 1,2,3,4,5,6
                                                     */
                                                    /*                                                     * ************************************************************** */
                                                    if ($E_DPublico[1]['semestre'] == 99) {//if...Semestres Todos
                                                        /*                                                         * ****************************************************** */
                                                        if ($E_DPublico[1]['cadena'] === 0) {

                                                            $C_Cadena = 0;
                                                            $Permiso = 1;
                                                        } else {

                                                            $C_Cadena = explode('::', $E_DPublico[1]['cadena']);

                                                            for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                /*                                                                 * ************************************ */
                                                                if ($FacultadEstudiante->fields['codigofacultad'] == $C_Cadena[$i]) {
                                                                    $Permiso = 1;
                                                                }
                                                                /*                                                                 * ************************************ */
                                                            }//for
                                                        }//if

                                                        /*                                                         * ****************************************************** */
                                                    } else {
                                                        /*                                                         * ****************************************************** */
                                                        if ($E_DPublico[1]['cadena'] === 0 || $E_DPublico[1]['cadena'] === '0') {

                                                            $C_Cadena = 0;

                                                            $C_Semestre = explode(',', $E_DPublico[1]['semestre']);

                                                            for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                /*                                                                 * ************************************************** */
                                                                if ($C_Semestre[$j] == $FacultadEstudiante->fields['semestreprematricula']) {//if
                                                                    /*                                                                     * ********************************************** */
                                                                    $Permiso = 1;
                                                                    /*                                                                     * ********************************************** */
                                                                }//if
                                                            }//for	Semestre
                                                        } else {

                                                            $C_Cadena = explode('::', $E_DPublico[1]['cadena']);

                                                            $C_Semestre = explode(',', $E_DPublico[1]['semestre']);

                                                            for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                /*                                                                 * ************************************************** */
                                                                if ($C_Semestre[$j] == $FacultadEstudiante->fields['semestreprematricula']) {//if
                                                                    /*                                                                     * ********************************************** */
                                                                    for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                        /*                                                                         * ************************************ */
                                                                        if ($FacultadEstudiante->fields['codigofacultad'] == $C_Cadena[$i]) {
                                                                            $Permiso = 1;
                                                                        }
                                                                        /*                                                                         * ************************************ */
                                                                    }//for
                                                                    /*                                                                     * ********************************************** */
                                                                }//if
                                                                /*                                                                 * ************************************************** */
                                                            }//for semestre
                                                        }//if

                                                        /*                                                         * ****************************************************** */
                                                    }//if semestre
                                                    $FacultadEstudiante->MoveNext();
                                                }//while
                                                /*                                                 * ************************************************************************************* */
                                            }//if....4

                                            if ($E_DPublico[1]['filtro'] == 1) {//if....6
                                                /* Modalidad Acdemica */
                                                $Permiso = 0;
                                                /*                                                 * ************************************************************************************* */
                                                /* $SQL_C='SELECT

                                                  e.codigoestudiante,
                                                  e.idestudiantegeneral,
                                                  e.codigocarrera,
                                                  c.nombrecarrera
                                                  FROM

                                                  estudiante e INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera

                                                  INNER JOIN modalidadacademicasic m ON m.codigomodalidadacademicasic=c.codigomodalidadacademicasic
                                                  WHERE

                                                  e.idestudiantegeneral="'.$EstudinteGeneral_id.'"
                                                  AND
                                                  m.codigomodalidadacademicasic NOT IN (000,100,101,400)
                                                  AND
                                                  m.codigoestado=100'; */
                                                /*                                                 * ************************************************************************************* */
                                                if ($Periodo[1]['codigoperiodo']) {
                                                    $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                } else {
                                                    $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                }
                                                /*                                                 * ********************************************************************* */
                                                /*
                                                 * Caso 90791
                                                 * @modified Luis Dario Gualteros 
                                                 * <castroluisd@unbosque.edu.co>
                                                 * Se modifica la consulta con la condición p.codigoestadoprematricula = 40  
                                                 * para que solo pida evaluar materias a los estudiantes que se encuentren 
                                                 * matriculados al progarma de Psicologia y no inscritos o no admitidos.
                                                 * @since Junio 9 de 2017
                                                 */
                                                $SQL_C = 'SELECT

																			e.codigoestudiante,
																			e.idestudiantegeneral,
																			e.codigocarrera,
																			c.nombrecarrera,
																			p.codigoperiodo,
																			p.semestreprematricula

																			FROM

																			estudiante e INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
																						 INNER JOIN modalidadacademica m ON m.codigomodalidadacademica=c.codigomodalidadacademica
																						 INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
																			WHERE

																			e.idestudiantegeneral="' . $EstudinteGeneral_id . '"
																			AND
																			m.codigomodalidadacademica NOT IN (000,100,101,400)
																			AND
																			m.codigoestado=100
																			AND
																			' . $Condicion_Periodo . '
                                                                            AND
                                                                            p.codigoestadoprematricula = 40
                                                                            AND
                                                                            c.codigomodalidadacademica="' . $E_DPublico[1]['modalidadsic'] . '"';
                                                // End Caso 90791
                                                if ($CarreraEstudiante = &$db->Execute($SQL_C) === false) {
                                                    echo 'Error en el SQl de La carrera del estudiante....<br><br>' . $SQL_C;
                                                    die;
                                                }

                                                if (!$CarreraEstudiante->EOF) {//if...7
                                                    $Permiso = 0;

                                                    while (!$CarreraEstudiante->EOF) {//whil

                                                        /*                                                         * ************************************************************** */
                                                        if ($E_DPublico[1]['semestre'] == 99) {//if...Semestres Todos

                                                            /*                                                             * ****************************************************** */
                                                            if ($E_DPublico[1]['cadena'] === 0 || $E_DPublico[1]['cadena'] === '0') {

                                                                $C_Cadena = 0;
                                                                $Permiso = 1;
                                                            } else {

                                                                $C_Cadena = explode('::', $E_DPublico[1]['cadena']);



                                                                for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                    if ($C_Cadena[$i] == $CarreraEstudiante->fields['codigocarrera']) {
                                                                        $Permiso = 1;
                                                                    }
                                                                }//for
                                                            }//if

                                                            /*                                                             * ****************************************************** */
                                                        } else {
                                                            /*                                                             * ****************************************************** */

                                                            if ($E_DPublico[1]['cadena'] === 0 || $E_DPublico[1]['cadena'] === '0') {

                                                                $C_Cadena = 0;

                                                                $C_Semestre = explode(',', $E_DPublico[1]['semestre']);

                                                                for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                    /*                                                                     * ************************************************** */
                                                                    if ($C_Semestre[$j] == $CarreraEstudiante->fields['semestreprematricula']) {//if
                                                                        /*                                                                         * ********************************************** */
                                                                        $Permiso = 1;
                                                                        /*                                                                         * ********************************************** */
                                                                    }//if
                                                                }//for	Semestre
                                                            } else {

                                                                $C_Cadena = explode('::', $E_DPublico[1]['cadena']);

                                                                $C_Semestre = explode(',', $E_DPublico[1]['semestre']);

                                                                for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                    /*                                                                     * ************************************************** */
                                                                    if ($C_Semestre[$j] == $CarreraEstudiante->fields['semestreprematricula']) {//if
                                                                        /*                                                                         * ********************************************** */
                                                                        for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                            if ($C_Cadena[$i] == $CarreraEstudiante->fields['codigocarrera']) {
                                                                                $Permiso = 1;
                                                                            }
                                                                        }//for
                                                                        /*                                                                         * ********************************************** */
                                                                    }//if
                                                                    /*                                                                     * ************************************************** */
                                                                }//for semestre
                                                            }//if

                                                            /*                                                             * ****************************************************** */
                                                        }//if semestre
                                                        /*                                                         * ************************************************************** */
                                                        $CarreraEstudiante->MoveNext();
                                                    }//while
                                                }//if...7
                                                /*                                                 * ************************************************************************************* */
                                            }//if...6
                                            if ($E_DPublico[1]['filtro'] == 2) {//if..8																
                                                /* Filtro si es Por Materias */
                                                $Permiso = 0;
                                                /*                                                 * ************************************************************************************* */
                                                if ($Periodo[1]['codigoperiodo']) {
                                                    $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                } else {
                                                    $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                }
                                                /*                                                 * *************************************************************** */
                                                /*
                                                 * Caso 90791
                                                 * @modified Luis Dario Gualteros 
                                                 * <castroluisd@unbosque.edu.co>
                                                 * Se modifica la consulta con la condición p.codigoestadoprematricula = 40  
                                                 * para que solo pida evaluar materias a los estudiantes que se encuentren 
                                                 * matriculados al progarma de Psicologia y no inscritos o no admitidos.
                                                 * @since Junio 9 de 2017
                                                 */
                                                $SQL_C = 'SELECT

																			e.codigoestudiante,
																			e.idestudiantegeneral,
																			e.codigocarrera,
																			c.nombrecarrera,
																			p.codigoperiodo,
																			p.semestreprematricula

																			FROM

																			estudiante e INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
																						 INNER JOIN modalidadacademica m ON m.codigomodalidadacademica=c.codigomodalidadacademica
																						 INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
																			WHERE

																			e.idestudiantegeneral="' . $EstudinteGeneral_id . '"
																			AND
																			m.codigomodalidadacademica NOT IN (000,100,101,400)
																			AND
																			m.codigoestado=100
                                                                            AND 
                                                                            p.codigoestadoprematricula = 40
																			AND
																			' . $Condicion_Periodo;
                                                // End Caso 90791
                                                if ($CarreraEstudiante = &$db->Execute($SQL_C) === false) {
                                                    echo 'Error en el SQl de La carrera del estudiante....<br><br>' . $SQL_C;
                                                    die;
                                                }

                                                $Permiso = 0;




                                                while (!$CarreraEstudiante->EOF) {
                                                    /*                                                     * ************************************************************************************* */

                                                    /*                                                     * ************************************************************** */
                                                    if ($E_DPublico[1]['semestre'] == 99) {//if...Semestres Todos
                                                        /*                                                         * ****************************************************** */
                                                        if ($E_DPublico[1]['cadena'] === 0 || $E_DPublico[1]['cadena'] === '0') {

                                                            $C_Cadena = 0;
                                                            $Permiso = 1;
                                                        } else {

                                                            $C_Cadena = explode('::', $E_DPublico[1]['cadena']);


                                                            if ($Periodo[1]['codigoperiodo']) {
                                                                $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                            } else {
                                                                $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                            }
                                                            /*
                                                             * Caso 90791
                                                             * @modified Luis Dario Gualteros 
                                                             * <castroluisd@unbosque.edu.co>
                                                             * Se modifica la consulta con la condición p.codigoestadoprematricula = 40  
                                                             * para que solo pida evaluar materias a los estudiantes que se encuentren 
                                                             * matriculados al progarma de Psicologia y no inscritos o no admitidos.
                                                             * @since Junio 9 de 2017
                                                             */
                                                            $SQL_M = 'SELECT

																							p.idprematricula,
																							dp.codigomateria

																							FROM

																							prematricula p INNER JOIN detalleprematricula dp ON dp.idprematricula=p.idprematricula


																							WHERE

																							p.codigoestudiante="' . $CarreraEstudiante->fields['codigoestudiante'] . '"
																							AND
																							' . $Condicion_Periodo . '
																							AND
																							p.codigoestadoprematricula=40
																							AND
																							dp.codigoestadodetalleprematricula=30';

                                                            // End Caso 90791
                                                            if ($Materia_Estudiante = &$db->Execute($SQL_M) === false) {
                                                                echo 'Error en el SQL Materias ....<br><br>' . $SQL_M;
                                                                die;
                                                            }

                                                            while (!$Materia_Estudiante->EOF) {
                                                                /*                                                                 * ************************************************************************ */
                                                                for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                    if ($C_Cadena[$i] == $Materia_Estudiante->fields['codigomateria']) {
                                                                        $Permiso = 1;
                                                                    }
                                                                }//for
                                                                /*                                                                 * ************************************************************************ */
                                                                $Materia_Estudiante->MoveNext();
                                                            }//while
                                                        }//if

                                                        /*                                                         * ****************************************************** */
                                                    } else {
                                                        /*                                                         * ****************************************************** */
                                                        if ($E_DPublico[1]['cadena'] === 0 || $E_DPublico[1]['cadena'] === '0') {

                                                            $C_Cadena = 0;

                                                            $C_Semestre = explode(',', $E_DPublico[1]['semestre']);

                                                            for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                /*                                                                 * ************************************************** */
                                                                if ($C_Semestre[$j] == $CarreraEstudiante->fields['semestreprematricula']) {//if
                                                                    /*                                                                     * ********************************************** */
                                                                    $Permiso = 1;
                                                                    /*                                                                     * ********************************************** */
                                                                }//if
                                                            }//for	Semestre
                                                        } else {
                                                            $C_Cadena = explode('::', $E_DPublico[1]['cadena']);

                                                            $C_Semestre = explode(',', $E_DPublico[1]['semestre']);

                                                            for ($j = 0; $j < count($C_Semestre); $j++) {//for semestres
                                                                /*                                                                 * ************************************************** */
                                                                if ($C_Semestre[$j] == $CarreraEstudiante->fields['semestreprematricula']) {//if
                                                                    /*                                                                     * ********************************************** */

                                                                    if ($Periodo[1]['codigoperiodo']) {
                                                                        $Condicion_Periodo = '  (p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '"  OR  p.codigoperiodo="' . $Periodo[1]['codigoperiodo'] . '")';
                                                                    } else {
                                                                        $Condicion_Periodo = '  p.codigoperiodo="' . $Periodo[0]['codigoperiodo'] . '" ';
                                                                    }

                                                                    /*                                                                     * ********************************************** */

                                                                    $SQL_M = 'SELECT

																								p.idprematricula,
																								dp.codigomateria

																								FROM

																								prematricula p INNER JOIN detalleprematricula dp ON dp.idprematricula=p.idprematricula


																								WHERE

																								p.codigoestudiante="' . $CarreraEstudiante->fields['codigoestudiante'] . '"
																								AND
																								' . $Condicion_Periodo . '
																								AND
																								p.codigoestadoprematricula LIKE "4%"
																								AND
																								dp.codigoestadodetalleprematricula=30';


                                                                    if ($Materia_Estudiante = &$db->Execute($SQL_M) === false) {
                                                                        echo 'Error en el SQL Materias ....<br><br>' . $SQL_M;
                                                                        die;
                                                                    }
                                                                    while (!$Materia_Estudiante->EOF) {
                                                                        /*                                                                         * ************************************************************************ */
                                                                        for ($i = 1; $i < count($C_Cadena); $i++) {//for
                                                                            if ($C_Cadena[$i] == $Materia_Estudiante->fields['codigomateria']) {
                                                                                $Permiso = 1;
                                                                            }
                                                                        }//for
                                                                        /*                                                                         * ************************************************************************ */
                                                                        $Materia_Estudiante->MoveNext();
                                                                    }//while

                                                                    /*                                                                     * ********************************************** */
                                                                }//if
                                                                /*                                                                 * ************************************************** */
                                                            }//for semestre
                                                        }//if

                                                        /*                                                         * ****************************************************** */
                                                    }//if semestre
                                                    /*                                                     * ************************************************************** */
                                                    /*                                                     * ************************************************************************************* */
                                                    $CarreraEstudiante->MoveNext();
                                                }//while
                                            }//if...8
                                            /*                                             * ***************************************************************************************** */
                                        }//if...3
                                    }//if...2
                                }//if...1
                                /*                                 * ***Filtro para estudiantes Egresado********* */
                                if ($Info_Estudiante->fields['situacion'] == 104 && $E_DPublico[2]['E_Egr'] == 1) {
                                    
                                }
                                /*                                 * ***Filtro para estudiantes Graduado********* */
                                if ($Info_Estudiante->fields['situacion'] == 400 && $E_DPublico[3]['E_Gra'] == 1) {
                                    
                                }
                                /*                                 * *********************************************************************** */
                                $Info_Estudiante->MoveNext();
                            }//while
                            /*                             * ****************************************************** */
                        }//if $DetallePublicoEstudiante->EOF
                        /*                         * *************************************** */
                    }//if codigosituacion = 600
                    /*                     * *********************************************** */
                }//if estudiante = 0
            }//tipo 600
            if ($Tipo_user == 2) {
                //echo '<br>'.$Tipo_user;
                $Permiso = 0;

                if ($Docente == 1) {
                    //echo '<br>'.$Docente;
                    $Permiso = 0;
                    /*                     * ******************************************************* */
                    if ($D_Usuer['codigorol'] == 2) {
                        /*                         * *************************************************** */
                        $Permiso = 0;


                        $SQL_P = 'SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo IN (1,3)';

                        if ($PeriodoCodigo = &$db->Execute($SQL_P) === false) {
                            echo 'Error en el SQl de PeriodoCodigo ......<br><br>' . $SQL_P;
                            die;
                        }

                        $Periodo = $PeriodoCodigo->GetArray();
                        /*
                          [0] => Array
                          (
                          [0] => 20142
                          [codigoperiodo]=> 20142
                          )
                          [1] => Array
                          (
                          [0] => 20141
                          [codigoperiodo]=> 20141
                          )
                         */
                        /*                         * *************************************** */
                        $SQL_D = 'SELECT *

											FROM
													siq_Adetallepublicoobjetivo
											WHERE
													idsiq_Apublicoobjetivo="' . $Publico_id . '"
													AND
													codigoestado=100';

                        if ($DetallePublico = &$db->Execute($SQL_D) === false) {
                            echo 'Error en el SQl del Detalle del Publico Detalle...<br><br>' . $SQL_D;
                            die;
                        }

                        if (!$DetallePublico->EOF) {
                            $Permiso = 0;
                            /*                             * **************************************** */

                            $E_DPublico = $DetallePublico->GetArray();

                            /*
                              [0] => Array
                              (
                              [0] => 1
                              [idsiq_Adetallepublicoobjetivo] => 1
                              [1] => 14
                              [idsiq_Apublicoobjetivo] => 14
                              [2] => 1
                              [tipoestudiante] => 1
                              [3] => 1
                              [E_New] => 1
                              [4] => 0
                              [E_Old] => 0
                              [5] => 0
                              [E_Egr] => 0
                              [6] => 0
                              [E_Gra] => 0
                              [7] => 0
                              [filtro] => 0
                              [8] => 1,3,4,5
                              [semestre] => 1,3,4,5
                              [9] => 200
                              [modalidadsic] => 200
                              [10] => 0
                              [codigocarrera] => 0
                              [11] => ::5::354
                              [cadena] => ::5::354
                              [12] => 2
                              [tipocadena] => 2
                              [13] => 4186
                              [userid] => 4186
                              [14] => 2013-08-23 11:12:38
                              [entrydate] => 2013-08-23 11:12:38
                              [15] => 100
                              [codigoestado] => 100
                              [16] => 4186
                              [userid_estado] => 4186
                              [17] => 2013-08-23
                              [changedate] => 2013-08-23
                              [17] => 2013-08-23
                              [docente] => 1 -->Esta activo para docente
                              [17] => 2013-08-23
                              [modalidadocente] => ::2::6::5  -> es una cadena el cual endica que tipo de modalidad docente puede aceder a el instrumento.
                             */
                            //echo '-->'.$E_DPublico[4]['modalidadocente'];
                            $C_ModalidaDocente = explode('::', $E_DPublico[4]['modalidadocente']);

                            //echo '<pre>';print_r($C_ModalidaDocente);die;

                            $SQL_Docente = 'SELECT

                                                                d.iddocente,
                                                                d.modalidadocente

                                                                FROM

                                                                docente d INNER JOIN usuario u ON d.numerodocumento=u.numerodocumento
                                                                AND
                                                                u.idusuario="' . $userid . '"';

                            if ($DocenteData = &$db->Execute($SQL_Docente) === false) {
                                echo 'Error en el SQl de la Data del docente...<br><br>' . $SQL_Docente;
                                die;
                            }

                            if (!$DocenteData->EOF) {
                                $Permiso = 0;
                                /*                                 * ************************************************************** */
                                for ($i = 1; $i < count($C_ModalidaDocente); $i++) {
                                    $Permiso = 0;
                                    /*                                     * ******************************************************** */
                                    //echo '<br>'.$C_ModalidaDocente[$i].'=='.$DocenteData->fields['modalidadocente'];
                                    if ($C_ModalidaDocente[$i] == $DocenteData->fields['modalidadocente']) {
                                        $Permiso = 1;
                                        break;
                                    }
                                    /*                                     * ******************************************************** */
                                }//for
                                /*                                 * ************************************************************** */
                            }//if !$DocenteData->EOF
                        }//if !$DetallePublico->EOF
                        /*                         * *************************************************** */
                    }//if($D_Usuer['codigotipousuario']==500)
                    /*                     * ******************************************************* */
                }//Docente == 0
            }//$Tipo_user==500
            /*             * ********************************************************************************** */
            /*             * ********************************************************************************** */
        }
        return $Permiso;
        /*         * ***************************************************************************************** */
    }

//public function ValidadInfo

    public function DataUser($userid) {
        global $db;

        $SQL = 'SELECT * FROM usuario WHERE idusuario="' . $userid . '"';

        if ($DataUser = &$db->Execute($SQL) === false) {
            echo 'Erorr al Buscar Info Sobre El Usuer...<br><br>' . $SQL;
            die;
        }
        if (!$DataUser->EOF) {
            /*             * ************************************** */
            $C_User = array();
            $C_User['idusuario'] = $DataUser->fields['idusuario'];
            $C_User['usuario'] = $DataUser->fields['usuario'];
            $C_User['numerodocumento'] = $DataUser->fields['numerodocumento'];
            $C_User['tipodocumento'] = $DataUser->fields['tipodocumento'];
            $C_User['apellidos'] = $DataUser->fields['apellidos'];
            $C_User['nombres'] = $DataUser->fields['nombres'];
            $C_User['codigousuario'] = $DataUser->fields['codigousuario'];
            $C_User['semestre'] = $DataUser->fields['semestre'];
            $C_User['codigorol'] = $DataUser->fields['codigorol'];
            $C_User['fechainiciousuario'] = $DataUser->fields['fechainiciousuario'];
            $C_User['fechavencimientousuario'] = $DataUser->fields['fechavencimientousuario'];
            $C_User['fecharegistrousuario'] = $DataUser->fields['fecharegistrousuario'];
            $C_User['codigotipousuario'] = $DataUser->fields['codigotipousuario'];
            $C_User['idusuariopadre'] = $DataUser->fields['idusuariopadre'];
            $C_User['ipaccesousuario'] = $DataUser->fields['ipaccesousuario'];
            $C_User['codigoestadousuario'] = $DataUser->fields['codigoestadousuario'];

            return $C_User;
            /*             * ************************************** */
        }
    }

//public function DataUser

    public function Observatorio($userid, $Periodo) {

        global $db;

        $Permiso = 0;

        $D_User = $this->DataUser($userid);

        if ($D_User['codigorol'] == 1 && $D_User['codigotipousuario'] == 600) {
            /*             * *********************************************************** */
            $SQL = 'SELECT 

                eg.idestudiantegeneral,
                e.codigoestudiante 
                
                
                
                FROM estudiantegeneral eg INNER JOIN usuario u ON u.numerodocumento=eg.numerodocumento
			                              INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
                
                WHERE
                
                u.idusuario="' . $userid . '"';

            if ($D_CodigoEstudiante = &$db->Execute($SQL) === false) {
                echo 'Error en el SQL del Codigo Estudiante...<br><br>' . $SQL;
                die;
            }

            while (!$D_CodigoEstudiante->EOF) {
                /*                 * ***************************************************** */
                $CodigoEstudiante = $D_CodigoEstudiante->fields['codigoestudiante'];

                $SQL_2 = 'SELECT 

                        idobs_tutorias,
                        codigoestudiante
                        
                        FROM 
                        
                        obs_tutorias
                        
                        WHERE
                        
                        codigoestado=100
                        AND
                        codigoperiodo="' . $Periodo . '"
                        AND
                        codigoestudiante="' . $CodigoEstudiante . '"';

                if ($TieneTutoria = &$db->Execute($SQL_2) === false) {
                    echo 'Error en el SQL de Si El Estudiante tiene tutorias....<br><br>' . $SQL_2;
                    die;
                }

                if (!$TieneTutoria->EOF) {
                    /*                     * ****************************** */
                    $Permiso = 1;
                    break;
                    /*                     * ****************************** */
                }
                /*                 * ***************************************************** */
                $D_CodigoEstudiante->MoveNext();
            }/* while */
            /*             * *********************************************************** */
        }
        return $Permiso;
    }

/* public function Observatorio */
}

//class