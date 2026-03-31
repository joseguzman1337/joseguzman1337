<?php

session_start();


include_once ('../EspacioFisico/templates/template.php');
$db = getBD();

switch ($_REQUEST['actionID']) {
    case 'guarda_ensenanzayapredizaje_varios': {
            $actividades = $_REQUEST['actividades'];
            $ocultos_actividades = $_REQUEST['ocultos_actividades'];
            $horas = $_REQUEST['cadena'];
            if ($actividades[0] == '') {
                echo '<script>alert("Favor ingresar al menos una actividad antes de guardar");</script>';
                die;
            }
            $horas = explode(',', $_REQUEST['cadena']);
            if ($horas[14] != 'asignatura') {
                /*
                 * Caso 87930
                 * @modified Luis Dario Gualteros 
                 * <castroluisd@unbosque.edu.co>
                 * Se modifica la consulta para que muestre el campo de innovación para nueva funcionalidad de Innovación según
                 * solicitud de Liliana Ahumada.
                 * @since Marzo 6 de 2017
                 */
                $SQL = 'SELECT PlanTrabajoDocenteEnsenanzaId,
                                    HorasTIC,HorasInnovar,HorasTaller, HorasPAE 
                                    FROM PlanesTrabajoDocenteEnsenanza
                                    WHERE codigocarrera = "' . $horas[0] . '" 
                                    AND iddocente = "' . $horas[2] . '" 
                                    AND codigoperiodo = "' . $horas[3] . '" 
                                    AND codigomateria = 1 
                                    AND codigoestado = 100
                                    AND ( HorasPAE != 0 OR HorasTaller != 0 OR HorasTIC != 0 OR HorasInnovar != 0 )';
                if ($horas[15] != "undefined") {
                    $SQL .= " AND TipoHoras = '" . $horas[15] . "'";
                } else {
                    $SQL .= " AND TipoHoras = 'CONTRATO'";
                }

                if ($Resultado = &$db->Execute($SQL) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQL;
                }


                if ($Resultado->_numOfRows == 0) {
                    $sql_insert = "INSERT INTO PlanesTrabajoDocenteEnsenanza set codigocarrera = '" . $horas[0] . "', codigomateria = '1', 
                    iddocente = '" . $horas[2] . "', codigoperiodo = '" . $horas[3] . "', HorasPresencialesPorSemana = '0', HorasPreparacion = '0', 
                    HorasEvaluacion = '0', HorasAsesoria = '0', HorasTIC = '" . $horas[8] . "',HorasInnovar = '" . $horas[16] . "', 
                    HorasTaller = '" . $horas[9] . "', HorasPAE = '" . $horas[10] . "', FechaCreacion = '" . date("Y-m-d H:i:s") . "'";
                    /* End Caso 87930 */
                    if ($horas[15] != "undefined") {
                        $sql_insert .= ", TipoHoras = '" . $horas[15] . "'";
                    } else {
                        $sql_insert .= ", TipoHoras = 'CONTRATO'";
                    }


                    if ($insertar_plandocente = &$db->Execute($sql_insert) === false) {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'ERROR ' . $sql_insert;
                    }
                    $plan_ensenanza = $db->Insert_ID();
                    $arr_id_actividades = array();
                    $i = 0;
                    foreach ($actividades as $act) {
                        if ($ocultos_actividades[$i] == 0) {
                            $sql_insert_actividades = "INSERT INTO ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', PlanTrabajoDocenteEnsenanzaId = '" . $plan_ensenanza . "', FechaCreacion = '" . date("Y-m-d H:i:s") . "', 
                        TipoPlanTrabajoDocenteEnsenanzaId = '" . $horas[13] . "'";
                            if ($consulta = $db->Execute($sql_insert_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_select;
                            }
                            $max_actividad = $db->Insert_ID();
                            $arr_id_actividades[$i] = $max_actividad;
                        } else {
                            $sql_update_actividades = "UPDATE ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', codigoestado = 100, FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "' 
                        WHERE ActividadPlanTrabajoDocenteEnsenanzaId = '" . $ocultos_actividades[$i] . "'";
                            if ($consulta = $db->Execute($sql_update_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_update_actividades;
                            } else {
                                $arr_id_actividades[$i] = $ocultos_actividades[$i];
                            }
                        }
                        $i++;
                    }
                    $a_vectt['val'] = 'NO_Existe';
                    $a_vectt['descrip'] = 'Se registro Exitosamente';
                    $a_vectt['plan_ensenanza'] = $plan_ensenanza;
                    $a_vectt['arr_id_actividades'] = $arr_id_actividades;
                    echo json_encode($a_vectt);
                } else {
                    $plan_ensenanza = $Resultado->fields['PlanTrabajoDocenteEnsenanzaId'];

                    $horaTIC = $Resultado->fields['HorasTIC'];
                    $horaInnovar = $Resultado->fields['HorasInnovar'];
                    $horaTaller = $Resultado->fields['HorasTaller'];
                    $horaPAE = $Resultado->fields['HorasPAE'];

                    /*
                     * Caso 87930
                     * @modified Luis Dario Gualteros 
                     * <castroluisd@unbosque.edu.co>
                     * Se modifica la consulta para que modifique el campo de innovación para nueva funcionalidad de Innovación según
                     * solicitud de Liliana Ahumada.
                     * @since Marzo 6 de 2017
                     */
                    $sql_update = "UPDATE PlanesTrabajoDocenteEnsenanza SET HorasPresencialesPorSemana = '0', HorasPreparacion = '0', 
                            HorasEvaluacion = '0', HorasAsesoria = '0', HorasTIC = '" . $horas[8] . "',HorasInnovar = '" . $horas[16] . "' ,
                            HorasTaller = '" . $horas[9] . "', HorasPAE = '" . $horas[10] . "', FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "'";
                    /* END Caso 87930 */
                    if ($horas[15] != "undefined") {
                        $sql_update .= ", TipoHoras = '" . $horas[15] . "'";
                    } else {
                        $sql_update .= ", TipoHoras = 'CONTRATO'";
                    }
                    $sql_update .= " WHERE PlanTrabajoDocenteEnsenanzaId= '" . $plan_ensenanza . "'";


                    if ($modificar_plandocente = &$db->Execute($sql_update) === false) {
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'ERROR ' . $sql_update;
                    }
                    $arr_id_actividades = array();
                    $i = 0;
                    foreach ($actividades as $act) {
                        if ($ocultos_actividades[$i] == 0) {
                            $sql_insert_actividades = "INSERT INTO ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', PlanTrabajoDocenteEnsenanzaId = '" . $plan_ensenanza . "', FechaCreacion = '" . date("Y-m-d H:i:s") . "', 
                        TipoPlanTrabajoDocenteEnsenanzaId = '" . $horas[13] . "'";
                            if ($consulta = $db->Execute($sql_insert_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_select;
                            }
                            $arr_id_actividades[$i] = $db->Insert_ID();
                        } else {
                            $sql_update_actividades = "UPDATE ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', codigoestado = 100, FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "' 
                        WHERE ActividadPlanTrabajoDocenteEnsenanzaId = '" . $ocultos_actividades[$i] . "'";
                            if ($consulta = $db->Execute($sql_update_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_update_actividades;
                            } else {
                                $arr_id_actividades[$i] = $ocultos_actividades[$i];
                            }
                        }
                        $i++;
                    }

                    $a_vectt['val'] = 'NO_Existe';
                    $a_vectt['descrip'] = 'Se registro Exitosamente';
                    $a_vectt['plan_ensenanza'] = $horas[12];
                    $a_vectt['arr_id_actividades'] = $arr_id_actividades;
                    echo json_encode($a_vectt);
                }
            }
        }break;
    case 'guarda_ensenanzayapredizaje': {
            $actividades = $_REQUEST['actividades'];
            $ocultos_actividades = $_REQUEST['ocultos_actividades'];
            $horas = $_REQUEST['cadena'];
            if ($actividades[0] == '') {
                echo '<script>alert("Favor ingresar al menos una actividad antes de guardar");</script>';
                die;
            }
            $horas = explode(',', $_REQUEST['cadena']);
            /*
             * Caso 91989
             * comentar estas 2 lineas para que en el formulario no salga error de conexion
             * cuando se guarde la informacion
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Modificado Julio 24 de 2017
             */
            /* echo '<pre>'; 
              print_r($horas); */
            //end

            if ($horas[12] == 0 && $horas[14] == 'asignatura') {

                $sql_insert = "INSERT INTO PlanesTrabajoDocenteEnsenanza set codigocarrera = '" . $horas[0] . "', codigomateria = '" . $horas[1] . "', 
                    iddocente = '" . $horas[2] . "', codigoperiodo = '" . $horas[3] . "', HorasPresencialesPorSemana = '" . $horas[4] . "', HorasPreparacion = '" . $horas[5] . "', 
                    HorasEvaluacion = '" . $horas[6] . "', HorasAsesoria = '" . $horas[7] . "', HorasTIC = '" . $horas[8] . "', HorasTaller = '" . $horas[9] . "',
                    HorasPAE = '" . $horas[10] . "', FechaCreacion = '" . date("Y-m-d H:i:s") . "'";

                if ($horas[15] != "undefined") {
                    $sql_insert .= ", TipoHoras = '" . $horas[15] . "'";
                } else {
                    $sql_insert .= ", TipoHoras = 'CONTRATO'";
                }

                if ($insertar_plandocente = &$db->Execute($sql_insert) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $sql_insert;
                } else {
                    $plan_ensenanza = $db->Insert_ID();
                    $arr_id_actividades = array();
                    $i = 0;
                    foreach ($actividades as $act) {
                        if ($ocultos_actividades[$i] == 0) {
                            $sql_insert_actividades = "INSERT INTO ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', PlanTrabajoDocenteEnsenanzaId = '" . $plan_ensenanza . "', FechaCreacion = CURDATE(), 
                        TipoPlanTrabajoDocenteEnsenanzaId = '" . $horas[13] . "'";

                            if ($consulta = $db->Execute($sql_insert_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_select;
                            }
                            $arr_id_actividades[$i] = $db->Insert_ID();
                        } else {
                            $sql_update_actividades = "UPDATE ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', codigoestado = 100, FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "' 
                        WHERE ActividadPlanTrabajoDocenteEnsenanzaId = '" . $ocultos_actividades[$i] . "'";
                            if ($consulta = $db->Execute($sql_update_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_update_actividades;
                            } else {
                                $arr_id_actividades[$i] = $ocultos_actividades[$i];
                            }
                        }
                        $i++;
                    }

                    $a_vectt['val'] = 'NO_Existe';
                    $a_vectt['descrip'] = 'Se registro Exitosamente';
                    $a_vectt['plan_ensenanza'] = $plan_ensenanza;
                    $a_vectt['arr_id_actividades'] = $arr_id_actividades;
                    $a_vectt['update'] = 'no';
                    echo json_encode($a_vectt);
                }
            } else {
                if ($db->Execute($sql_inicial) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $sql_inicial;
                }

                /*
                 * Caso 87930
                 * @modified Luis Dario Gualteros 
                 * <castroluisd@unbosque.edu.co>
                 * Se modifica la consulta para que modifique el campo de innovación para nueva funcionalidad de Innovación según
                 * solicitud de Liliana Ahumada.
                 * @since Marzo 6 de 2017
                 */
                $sql_update = "UPDATE PlanesTrabajoDocenteEnsenanza SET HorasPresencialesPorSemana = '" . $horas[4] . "', HorasPreparacion = '" . $horas[5] . "', 
                            HorasEvaluacion = '" . $horas[6] . "', HorasAsesoria = '" . $horas[7] . "', HorasTIC = '" . $horas[8] . "', HorasInnovar = '" . $horas[16] . "',
                            HorasTaller = '" . $horas[9] . "', HorasPAE = '" . $horas[10] . "', FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "'";
                /* END Caso 87930 */
                if ($horas[15] != "undefined") {
                    $sql_update .= ", TipoHoras = '" . $horas[15] . "'";
                } else {
                    $sql_update .= ", TipoHoras = 'CONTRATO'";
                }
                $sql_update .= " WHERE PlanTrabajoDocenteEnsenanzaId= '" . $horas[12] . "'";

                if ($modificar_plandocente = &$db->Execute($sql_update) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $sql_update;
                } else {
                    $arr_id_actividades = array();
                    $i = 0;
                    foreach ($actividades as $act) {
                        if ($ocultos_actividades[$i] == 0) {
                            $sql_insert_actividades = "INSERT INTO ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', PlanTrabajoDocenteEnsenanzaId = '" . $horas[12] . "', FechaCreacion = '" . date("Y-m-d H:i:s") . "', 
                        TipoPlanTrabajoDocenteEnsenanzaId = '" . $horas[13] . "'";

                            if ($consulta = $db->Execute($sql_insert_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_select;
                            }
                            $arr_id_actividades[$i] = $db->Insert_ID();
                        } else {
                            $sql_update_actividades = "UPDATE ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', codigoestado = 100, FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "' 
                        WHERE ActividadPlanTrabajoDocenteEnsenanzaId = '" . $ocultos_actividades[$i] . "'";
                            if ($consulta = $db->Execute($sql_update_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_update_actividades;
                            } else {
                                $arr_id_actividades[$i] = $ocultos_actividades[$i];
                            }
                        }
                        $i++;
                    }

                    $a_vectt['val'] = 'NO_Existe';
                    $a_vectt['descrip'] = 'Se registro Exitosamente';
                    $a_vectt['plan_ensenanza'] = $horas[12];
                    $a_vectt['arr_id_actividades'] = $arr_id_actividades;
                    $a_vectt['update'] = 'si';
                    echo json_encode($a_vectt);
                }
            }
        }break;
    case 'guarda_otros': {
            $actividades = $_REQUEST['actividades'];
            $ocultos_actividades = $_REQUEST['ocultos_actividades'];
            $horas = $_REQUEST['cadena'];
        
            if ($actividades[0] == '') {
                echo '<script>alert("Favor ingresar al menos una actividad antes de guardar");</script>';
                die;
            }
            $horas = explode(',', $_REQUEST['cadena']);
            if ($horas[7] == 0) {
                $sql_insert = "INSERT INTO PlanesTrabajoDocenteOtros set codigocarrera = '" . $horas[0] . "', iddocente = '" . $horas[1] . "', codigoperiodo = '" . $horas[2] . "', 
			HorasDedicadas = '" . $horas[3] . "', TipoPlanTrabajoDocenteOtrosId = '" . $horas[4] . "', Nombres = '" . $horas[5] . "', VocacionesPlanesTrabajoDocenteId = '" . $horas[6] . "', FechaCreacion = '" . date("Y-m-d H:i:s") . "'";
                 
            /*
             * Caso 107107 
             * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>.
             * Se adiciona la validación del tipo de horas cuando viene vacio o indefinido para que por 
             * Defecto tome el tipo de horas como Contrato. 
             * @copyright Dirección de Tecnología Universidad el Bosque
             * @since 15 de Noviembre de 2018.
            */       
                if($horas[8] == 'undefined'){
                    $sql_insert .= ", TipoHoras = 'CONTRATO'"; 
                }else
                    if( empty($horas[8]) ){
                        $sql_insert .= ", TipoHoras = 'CONTRATO'"; 
                    }else{
                        $sql_insert .= ", TipoHoras ='".$horas[8]."'"; 
                }
            //End Caso 107107.
            
                if ($insertar_plandocente = &$db->Execute($sql_insert) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $sql_insert;
                } else {
                    $plan_ensenanza = $db->Insert_ID();
                    $arr_id_actividades = array();
                    $i = 0;
                    foreach ($actividades as $act) {
                        if ($ocultos_actividades[$i] == 0) {
                            $sql_insert_actividades = "INSERT INTO ActividadesPlanesTrabajoDocenteOtros SET Nombre = '" . $act . "', PlanTrabajoDocenteOtrosId = '" . $plan_ensenanza . "', FechaCreacion = '" . date("Y-m-d H:i:s") . "'";
                            if ($consulta = $db->Execute($sql_insert_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_select;
                            }
                            $arr_id_actividades[$i] = $db->Insert_ID();
                        } else {
                            $sql_update_actividades = "UPDATE ActividadesPlanesTrabajoDocenteOtros SET Nombres = '" . $act . "', codigoestado = 100, FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "' 
                        WHERE ActividadPlanTrabajoDocenteOtrosId = '" . $ocultos_actividades[$i] . "'";
                            if ($consulta = $db->Execute($sql_update_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_update_actividades;
                            } else {
                                $arr_id_actividades[$i] = $ocultos_actividades[$i];
                            }
                        }
                        $i++;
                    }

                    $a_vectt['val'] = 'NO_Existe';
                    $a_vectt['descrip'] = 'Se registro Exitosamente';
                    $a_vectt['nombre'] = $horas[5];
                    $a_vectt['plan_ensenanza'] = $plan_ensenanza;
                    $a_vectt['tipo_vocacion'] = $horas[6];
                    $a_vectt['arr_id_actividades'] = $arr_id_actividades;
                    $a_vectt['update'] = 'no';
                    echo json_encode($a_vectt);
                }
            } else {
                if ($db->Execute($sql_inicial) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $sql_inicial;
                }
                $sql_update = "UPDATE PlanesTrabajoDocenteOtros SET Nombres= '" . $horas[5] . "', HorasDedicadas = '" . $horas[3] . "', TipoPlanTrabajoDocenteOtrosId = '" . $horas[4] . "', FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "'";
                if ($horas[8] != "undefined") {
                    $sql_update .= ", TipoHoras ='" . $horas[8] . "'";
                }
                /*
                 * Caso
                 * comentar este if para que permita guardar la informacion
                 * cuando es docente sobre sueldos
                 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Universidad el Bosque - Direccion de Tecnologia.
                 * Modificado Julio 25 de 2017
                 */
//            if( $horas[16] != "undefined"){
//                $sql_update .= ", TipoHoras ='".$horas[16]."'";
//            }else{
//                $sql_update .= ", TipoHoras = 'CONTRATO'";
//            } 
//            end
                $sql_update .= " WHERE PlanTrabajoDocenteOtrosId= '" . $horas[7] . "'";
                if ($modificar_plandocente = &$db->Execute($sql_update) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $sql_update;
                } else {
                    $arr_id_actividades = array();
                    $i = 0;
                    foreach ($actividades as $act) {
                        if ($ocultos_actividades[$i] == 0) {
                            $sql_insert_actividades = "INSERT INTO ActividadesPlanesTrabajoDocenteOtros SET Nombre = '" . $act . "', PlanTrabajoDocenteOtrosId = '" . $horas[7] . "', FechaCreacion = '" . date("Y-m-d H:i:s") . "'";
                            if ($consulta = $db->Execute($sql_insert_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_insert_actividades;
                            }
                            $arr_id_actividades[$i] = $db->Insert_ID();
                        } else {
                            $sql_update_actividades = "UPDATE ActividadesPlanesTrabajoDocenteOtros SET Nombre = '" . $act . "', codigoestado = 100, FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "' 
                        WHERE ActividadPlanTrabajoDocenteOtrosId = '" . $ocultos_actividades[$i] . "'";
                            if ($consulta = $db->Execute($sql_update_actividades) === false) {
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR ' . $sql_update_actividades;
                            } else {
                                $arr_id_actividades[$i] = $ocultos_actividades[$i];
                            }
                        }
                        $i++;
                    }

                    $a_vectt['val'] = 'NO_Existe';
                    $a_vectt['descrip'] = 'Se registro Exitosamente';
                    $a_vectt['nombre'] = $horas[5];
                    $a_vectt['tipo_vocacion'] = $horas[6];
                    $a_vectt['plan_ensenanza'] = $horas[7];
                    $a_vectt['arr_id_actividades'] = $arr_id_actividades;
                    $a_vectt['update'] = 'si';
                    echo json_encode($a_vectt);
                }
            }
        }break;
    case 'cargar_programa_academico': {
            $documento_docente = $_REQUEST['documento_docente'];
            $Facultad_id = $_REQUEST['facultad_id'];
            $Periodo_id = $_REQUEST['periodo_id'];
            $modalidad = $_REQUEST['modalidad'];
            $SQL = 'SELECT
                	DISTINCT car.codigocarrera,
                	car.nombrecarrera
                FROM
                	carrera car                
                WHERE
                	(car.fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1)
                AND car.codigofacultad = ' . $Facultad_id . '
                AND car.codigomodalidadacademica <> 400
				AND car.codigomodalidadacademica = ' . $modalidad . '
                ORDER BY car.nombrecarrera';
            if ($Resultado = &$db->Execute($SQL) === false) {
                echo 'Error en consulta a base de datos';
                die;
            }
            $imp = '<option value="0" selected="selected">Seleccione</option>';
            if (!$Resultado->EOF) {
                while (!$Resultado->EOF) {
                    $imp .= '<option value="' . $Resultado->fields['codigocarrera'] . '">' . $Resultado->fields['nombrecarrera'] . '</option>';
                    $Resultado->MoveNext();
                }
            }
            echo $imp;
        }break;
    case 'cargar_materia': {
            $documento_docente = $_REQUEST['documento_docente'];
            $periodo = $_REQUEST['periodo'];
            $programa = $_REQUEST['programa'];
            $id_docente = $_REQUEST['id_docente'];

            $SQL = 'SELECT
								codigoperiodo
							FROM
								periodo
							WHERE
								codigoperiodo < "' . $periodo . '"
							ORDER BY
								codigoperiodo DESC
							LIMIT 1';

            if ($Resultado = &$db->Execute($SQL) === false) {
                echo 'Error en consulta a base de datos';
                die;
            }
            $codigo_periodo_ant = $Resultado->fields['codigoperiodo'];
            if ($programa == 124 || $programa == 119 || $programa == 134) { // ING SISTEMAS, ELECTRONICA  Y FACULTAD DE PSICOLOGIA
                switch ($programa) {
                    case 124: {
                            $SQL = 'SELECT DISTINCT
					mat.codigomateria,
					mat.nombremateria
					FROM
					materia mat
					inner join grupo g on g.codigomateria=mat.codigomateria
					WHERE
					(
						g.codigoperiodo = "' . $periodo . '"
						OR g.codigoperiodo = "' . $codigo_periodo_ant . '"
					)
					and g.maximogrupo>0 and
					mat.codigocarrera in (' . $programa . ', 123)
					ORDER BY mat.nombremateria';
                        }break;
                    case 119: {
                            $SQL = 'SELECT DISTINCT
					mat.codigomateria,
					mat.nombremateria
					FROM
					materia mat
					inner join grupo g on g.codigomateria=mat.codigomateria
					WHERE
					(
						g.codigoperiodo = "' . $periodo . '"
						OR g.codigoperiodo = "' . $codigo_periodo_ant . '"
					)
					and g.maximogrupo>0 and
					mat.codigocarrera in (' . $programa . ', 118)
					ORDER BY mat.nombremateria';
                        }break;
                    case 134: {
                            $SQL = 'SELECT DISTINCT
					mat.codigomateria,
					mat.nombremateria
					FROM
					materia mat
					inner join grupo g on g.codigomateria=mat.codigomateria
					WHERE
					(
						g.codigoperiodo = "' . $periodo . '"
						OR g.codigoperiodo = "' . $codigo_periodo_ant . '"
					)
					and g.maximogrupo>0 and
					mat.codigocarrera in (' . $programa . ', 133)
					ORDER BY mat.nombremateria';
                        }break;
                }
            } else {
                $SQL = 'SELECT DISTINCT
					mat.codigomateria,
					mat.nombremateria
					FROM
					materia mat
					inner join grupo g on g.codigomateria=mat.codigomateria
					WHERE
					(
						g.codigoperiodo = "' . $periodo . '"
						OR g.codigoperiodo = "' . $codigo_periodo_ant . '"
					)
					and g.maximogrupo>0 and
					mat.codigocarrera in (' . $programa . ')
					ORDER BY mat.nombremateria';
            }
            if ($Resultado = &$db->Execute($SQL) === false) {
                echo 'Error en consulta a base de datos';
                die;
            }
            $imp = '<option value="0" selected="selected">Seleccione</option>';
            if (!$Resultado->EOF) {
                while (!$Resultado->EOF) {
                    $imp .= '<option value="' . $Resultado->fields['codigomateria'] . '">' . $Resultado->fields['nombremateria'] . '</option>';
                    $Resultado->MoveNext();
                }
            }
            $a_vectt['option'] = $imp;
            $SQL = 'SELECT DISTINCT
					PlanTrabajoDocenteOtrosId,
					Nombres,
					VocacionesPlanesTrabajoDocenteId, TipoHoras
				FROM
					PlanesTrabajoDocenteOtros
				WHERE
					codigocarrera = ' . $programa . '
				AND iddocente = ' . $id_docente . '
				AND codigoperiodo = ' . $periodo . '
				AND codigoestado = 100
				ORDER BY
					VocacionesPlanesTrabajoDocenteId ASC';
            if ($Resultado = &$db->Execute($SQL) === false) {
                echo 'Error en consulta a base de datos';
                die;
            }
            $plan_otros = array();
            $plan_nombres = array();
            $plan_vocaciones = array();
            $plan_tipoHorasOtros = array();
            $i = 0;
            if ($Resultado->_numOfRows != 0) {
                if (!$Resultado->EOF) {
                    while (!$Resultado->EOF) {
                        $plan_otros[$i] = $Resultado->fields['PlanTrabajoDocenteOtrosId'];
                        $plan_nombres[$i] = $Resultado->fields['Nombres'];
                        $plan_vocaciones[$i] = $Resultado->fields['VocacionesPlanesTrabajoDocenteId'];
                        $plan_tipoHorasOtros[$i] = $Resultado->fields['TipoHoras'];
                        $Resultado->MoveNext();
                        $i++;
                    }
                }
            }

            /* Anteriores Enseñanza nombrecarrera = nombremateria */
            $SQL = 'SELECT
					ptd.PlanTrabajoDocenteEnsenanzaId AS id_plan_ensenanza,
					m.nombremateria AS nombrecarrera,
					m.codigomateria AS codigomateria,
					ptd.TipoHoras AS tipoHorasE
				FROM
					PlanesTrabajoDocenteEnsenanza ptd
				JOIN materia m ON ptd.codigomateria = m.codigomateria
				WHERE
					ptd.codigocarrera = ' . $programa . '
				AND ptd.iddocente = ' . $id_docente . '
				AND ptd.codigoperiodo = ' . $periodo . '
				AND ptd.codigomateria <> 1
				AND ptd.codigoestado = 100';
            if ($Resultado = &$db->Execute($SQL) === false) {
                echo 'Error en consulta a base de datos dario';
                die;
            }

            $i = 0;
            $id_plan_ensenanza = array();
            $nombre_plan_ensenanza = array();
            $id_codigomateria = array();
            $plan_tipoHoras = array();
            if ($Resultado->_numOfRows != 0) {
                if (!$Resultado->EOF) {
                    while (!$Resultado->EOF) {
                        $id_plan_ensenanza[$i] = $Resultado->fields['id_plan_ensenanza'];
                        $nombre_plan_ensenanza[$i] = $Resultado->fields['nombrecarrera'];
                        $id_codigomateria[$i] = $Resultado->fields['codigomateria'];
                        $plan_tipoHoras[$i] = $Resultado->fields['tipoHorasE'];
                        $Resultado->MoveNext();
                        $i++;
                    }
                }
            }
            /*
             * Caso 87930
             * @modified Luis Dario Gualteros 
             * <castroluisd@unbosque.edu.co>
             * Se modifica la consulta para que modifique el campo de innovación para nueva funcionalidad de Innovación según
             * solicitud de Liliana Ahumada.
             * @since Marzo 6 de 2017
             */
            $SQL = 'SELECT
					PlanTrabajoDocenteEnsenanzaId,
					HorasPAE,
					HorasTaller,
					HorasTIC,
                    HorasInnovar,
                    TipoHoras
				FROM
					PlanesTrabajoDocenteEnsenanza
				WHERE
					codigocarrera = ' . $programa . '
				AND iddocente = ' . $id_docente . '
				AND codigoperiodo = ' . $periodo . '
				AND codigomateria = 1
				AND codigoestado = 100
				AND ( HorasPAE != 0 OR HorasTaller != 0 OR HorasTIC != 0 OR HorasInnovar != 0 ) ';


            if ($Resultado = &$db->Execute($SQL) === false) {
                echo 'Error en consulta a base de datos';
                die;
            }

            $i = 0;
            $ensenanza_otros_id = array();
            $ensenanza_otros_pae = array();
            $ensenanza_otros_taller = array();
            $ensenanza_otros_tic = array();
            $ensenanza_otros_Innovar = array();
            $ensenanza_otros_TipoHora = array();
            if ($Resultado->_numOfRows != 0) {
                if (!$Resultado->EOF) {
                    while (!$Resultado->EOF) {
                        $ensenanza_otros_id[$i] = $Resultado->fields['PlanTrabajoDocenteEnsenanzaId'];
                        $ensenanza_otros_pae[$i] = $Resultado->fields['HorasPAE'];
                        $ensenanza_otros_taller[$i] = $Resultado->fields['HorasTaller'];
                        $ensenanza_otros_tic[$i] = $Resultado->fields['HorasTIC'];
                        $ensenanza_otros_Innovar[$i] = $Resultado->fields['HorasInnovar'];
                        $ensenanza_otros_TipoHora[$i] = $Resultado->fields['TipoHoras'];
                        $Resultado->MoveNext();
                        $i++;
                    }
                }
            }

            $a_vectt['id_codigomateria'] = $id_codigomateria;
            $a_vectt['id_plan_ensenanza'] = $id_plan_ensenanza;
            $a_vectt['nombre_plan_ensenanza'] = $nombre_plan_ensenanza;

            $a_vectt['plan_otros'] = $plan_otros;
            $a_vectt['plan_nombres'] = $plan_nombres;
            $a_vectt['plan_vocaciones'] = $plan_vocaciones;

            $a_vectt['plan_tipoHoras'] = $plan_tipoHoras;

            $a_vectt['plan_tipoHorasOtros'] = $plan_tipoHorasOtros;

            /*             * Horas Taller Horas Pae Horas TIC** */
            $a_vectt['ensenanza_otros_id'] = $ensenanza_otros_id;
            $a_vectt['ensenanza_otros_pae'] = $ensenanza_otros_pae;
            $a_vectt['ensenanza_otros_taller'] = $ensenanza_otros_taller;
            $a_vectt['ensenanza_otros_tic'] = $ensenanza_otros_tic;
            $a_vectt['ensenanza_otros_Innovar'] = $ensenanza_otros_Innovar;
            $a_vectt['ensenanza_otros_TipoHora'] = $ensenanza_otros_TipoHora;
            /* END Caso 87930 */
            echo json_encode($a_vectt);
        }break;

    //End cargar materia

    case 'cargarTipoEnsenanaza': {
            $success = false;
            $tipoensenanza = "";
            $SQL = 'SELECT * FROM TiposPlanesTrabajoDocenteEnsenanza';
            if ($_POST['opcion'] == 2) {
                $SQL .= ' WHERE  TipoPlanTrabajoDocenteEnsenanzaId <>1 ';
            }
            if ($Tipo_ensenanza = &$db->Execute($SQL) === false) {
                $success = false;
            } else {
                if (!$Tipo_ensenanza->EOF) {
                    $success = true;
                    $tipoensenanza .= '<option selected="selected" value="0">Seleccione</option>';
                    while (!$Tipo_ensenanza->EOF) {
                        $tipoensenanza .= '<option value="' . $Tipo_ensenanza->fields['TipoPlanTrabajoDocenteEnsenanzaId'] . '">' . $Tipo_ensenanza->fields['Nombre'] . '</option>';
                        $Tipo_ensenanza->MoveNext();
                    }
                }
            }
            echo json_encode(array('success' => $success, 'tipoensenanza' => $tipoensenanza));
        }break;

    case 'consulta_antiguos': {
            $facultad = $_REQUEST['facultad'];

            $programa = $_REQUEST['programa'];
            $asignatura = $_REQUEST['asignatura'];
            $documento_docente = $_REQUEST['documento_docente'];
            $periodo = $_REQUEST['periodo'];
            $tipoHoras = $_REQUEST['TipoHorasEnsenanza'];

            $SQL = 'SELECT * FROM PlanesTrabajoDocenteEnsenanza
                WHERE codigocarrera = ' . $programa . ' AND
                codigomateria = ' . $asignatura . ' AND
                iddocente = ' . $documento_docente . ' AND
				codigoestado = 100 AND
                codigoperiodo = ' . $periodo . '';

            if ($tipoHoras != "") {
                $SQL .= ' AND TipoHoras = "' . $tipoHoras . '" LIMIT 1';
            }
            //echo "<pre>";print_r($SQL);
            if ($Resultado = &$db->Execute($SQL) === false) {
                echo 'Error en consulta a base de datos' . $SQL;
                die;
            } else {
                if ($Resultado->_numOfRows != 0) {


                    $a_vectt['val'] = 'NO_Existe';
                    $a_vectt['horas_presenciales'] = $Resultado->fields['HorasPresencialesPorSemana'];
                    $a_vectt['horas_preparacion'] = $Resultado->fields['HorasPreparacion'];
                    $a_vectt['horas_evaluacion'] = $Resultado->fields['HorasEvaluacion'];
                    $a_vectt['horas_asesoria'] = $Resultado->fields['HorasAsesoria'];
                    $a_vectt['PlanTrabajoDocenteEnsenanzaId'] = $Resultado->fields['PlanTrabajoDocenteEnsenanzaId'];
                    /* ACTIVIDADES */
                    $SQL = 'SELECT * FROM ActividadesPlanesTrabajoDocenteEnsenanza WHERE PlanTrabajoDocenteEnsenanzaId = ' . $Resultado->fields['PlanTrabajoDocenteEnsenanzaId'] . ' AND codigoestado = 100 AND TipoPlanTrabajoDocenteEnsenanzaId = 1';

                    if ($Resultado = &$db->Execute($SQL) === false) {
                        echo 'Error en consulta a base de datos';
                        die;
                    }

                    if ($Resultado->_numOfRows != 0) {
                        $plan_ensenanza = array();
                        $plan_ensenanza_nombre = array();
                        $plan_ensenanza_tipo = array();
                        $i = 0;
                        if (!$Resultado->EOF) {
                            while (!$Resultado->EOF) {
                                $plan_ensenanza[$i] = $Resultado->fields['ActividadPlanTrabajoDocenteEnsenanzaId'];
                                $plan_ensenanza_nombre[$i] = $Resultado->fields['Nombre'];
                                $plan_ensenanza_tipo[$i] = $Resultado->fields['TipoPlanTrabajoDocenteEnsenanzaId'];
                                $Resultado->MoveNext();
                                $i++;
                            }
                        }
                        $a_vectt['plan_ensenanza'] = $plan_ensenanza;

                        $a_vectt['plan_ensenanza_nombre'] = $plan_ensenanza_nombre;
                        $a_vectt['plan_ensenanza_tipo'] = $plan_ensenanza_tipo;
                    } else {
                        $a_vectt['plan_ensenanza'] = 0;
                    }
                } else {
                    $a_vectt['val'] = 'NO_Existe';
                }
            }
            echo json_encode($a_vectt);
        }break;
    case 'carga_facultad': {
            $modalidad = $_REQUEST['modalidad'];
            if ($modalidad == 200) {
                $SQL = 'SELECT
						DISTINCT fac.codigofacultad,
						fac.nombrefacultad
					FROM
						facultad fac        
					WHERE
						fac.codigoestado = 100
					ORDER BY fac.nombrefacultad';
            } else if ($modalidad == 400) {
                $SQL = 'SELECT
						DISTINCT car.codigocarrera,
						car.nombrecarrera
					FROM
						carrera car                
					WHERE
						(car.EsAdministrativa = 1)
					AND car.codigomodalidadacademica = ' . $modalidad . ' 
					ORDER BY car.nombrecarrera';
            } else {
                $SQL = 'SELECT
						DISTINCT car.codigocarrera,
						car.nombrecarrera
					FROM
						carrera car                
					WHERE
						(fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1)
					AND car.codigomodalidadacademica = ' . $modalidad . ' 
					ORDER BY car.nombrecarrera';
            }

            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $sql_update_actividades;
            } else {
                if ($modalidad == 200) {
                    $imp = '<option value="0" selected="selected">Seleccione</option>';
                    if (!$Resultado->EOF) {
                        while (!$Resultado->EOF) {
                            $imp .= '<option value="' . $Resultado->fields['codigofacultad'] . '">' . $Resultado->fields['nombrefacultad'] . '</option>';
                            $Resultado->MoveNext();
                        }
                    }
                } else {
                    $imp = '<option value="0" selected="selected">Seleccione</option>';
                    if (!$Resultado->EOF) {
                        while (!$Resultado->EOF) {
                            $imp .= '<option value="' . $Resultado->fields['codigocarrera'] . '">' . $Resultado->fields['nombrecarrera'] . '</option>';
                            $Resultado->MoveNext();
                        }
                    }
                }
            }
            $a_vectt['option'] = $imp;
            $a_vectt['val'] = 'TRUE';
            $a_vectt['modalidad'] = $modalidad;
            echo json_encode($a_vectt);
        }break;

    case 'cargar_plan': {
            $id = $_REQUEST['id'];
            $vocacion = $_REQUEST['vocacion'];
            $tipoHorasO = $_REQUEST['tipoHorasO'];

            $SQL = 'SELECT * FROM PlanesTrabajoDocenteOtros WHERE PlanTrabajoDocenteOtrosId = ' . $id . '';
            if ($tipoHoras != "") {
                $SQL .= ' AND TipoHoras = "' . $tipoHorasO . '" LIMIT 1';
            }

            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            } else {
                $a_vectt['n_proyecto'] = $Resultado->fields['Nombres'];
                $a_vectt['t_proyecto'] = $Resultado->fields['TipoPlanTrabajoDocenteOtrosId'];
                $a_vectt['h_proyecto'] = $Resultado->fields['HorasDedicadas'];
                $imp = '';
                $i = 0;
                $SQL = 'SELECT * FROM ActividadesPlanesTrabajoDocenteOtros WHERE PlanTrabajoDocenteOtrosId = ' . $id . ' AND codigoestado = 100';
                if ($Resultado = &$db->Execute($SQL) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQL;
                }
                if (!$Resultado->EOF) {
                    if ($vocacion == 2) {
                        $tabla = 'descubrimiento';
                        $indicador = 'd';
                    }
                    if ($vocacion == 3) {
                        $tabla = 'compromiso';
                        $indicador = 'o';
                    }
                    if ($vocacion == 4) {
                        $tabla = 'gestion';
                        $indicador = 'g';
                    }
                    $imp .= '<thead>
                                        					<tr>
                                        						<th style="width:95%">Planeación de actividades a desarrollar</th>
                                        						<th>&nbsp;</th>
                                        					</tr>
                                        				</thead><tbody>';
                    while (!$Resultado->EOF) {
                        $imp .= '<tr>
                                        						<td><input class="actividad" type="text" name="' . $tabla . '[]" maxlength="800" id="' . $indicador . $i . '" value="' . $Resultado->fields['Nombre'] . '" />
																<input type="hidden" id="oculto_' . $indicador . $i . '" value="' . $Resultado->fields['ActividadPlanTrabajoDocenteOtrosId'] . '" /></td>
																<td><input type="button" value="Delete" class="del_ExpenseRow_' . $tabla . '" onclick="deleteActividadOtros(' . $Resultado->fields['ActividadPlanTrabajoDocenteOtrosId'] . ')" /></td>                                        						
                                        					</tr>';
                        $Resultado->MoveNext();
                        $i++;
                    }
                    $imp .= '</tbody>';
                }
            }
            $a_vectt['imp'] = $imp;
            echo json_encode($a_vectt);
        }break;
    case 'cargar_resumen': {
            $total = 0;
            $iddocente = $_REQUEST['iddocente'];
            $periodo = $_REQUEST['codigoperiodo'];
            /*
             * Caso 87930
             * @modified Luis Dario Gualteros 
             * <castroluisd@unbosque.edu.co>
             * Se modifica la consulta para que consulte el campo de innovación para nueva funcionalidad de Innovación según
             * solicitud de Liliana Ahumada.
             * @since Marzo 6 de 2017
             */
            $SQL = 'SELECT
					SUM(HorasPresencialesPorSemana) as HorasPresencialesPorSemana,
					SUM(HorasPreparacion) as HorasPreparacion,
					SUM(HorasEvaluacion) as HorasEvaluacion,
					SUM(HorasAsesoria) as HorasAsesoria,
					SUM(HorasTIC) as HorasTIC,
                    SUM(HorasInnovar) as HorasInnovacion,
					SUM(HorasTaller) as HorasTaller,
					SUM(HorasPAE) as HorasPAE
				FROM
					PlanesTrabajoDocenteEnsenanza
				WHERE
					iddocente = "' . $iddocente . '"
				AND codigoestado = 100
				AND codigoperiodo = "' . $periodo . '"
				AND TipoHoras = "CONTRATO" LIMIT 1';
            
            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            } else {
                $total = $total + $Resultado->fields['HorasPresencialesPorSemana'] + $Resultado->fields['HorasPreparacion'] + $Resultado->fields['HorasEvaluacion'] + $Resultado->fields['HorasAsesoria'] + $Resultado->fields['HorasTaller'] + $Resultado->fields['HorasTIC'] + $Resultado->fields['HorasInnovacion'] + $Resultado->fields['HorasPAE'];
                $a_vectt['tabla'] = '<table align="center" class="formData last" width="92%" border="2" bordercolor="#fff" >
                                        <thead>            
                                            <tr class="dataColumns">
                                            </tr>
                                            <tr class="dataColumns category">
                                                <th class="column borderR" colspan="2" style="background-color:#FFFC0B;"><span>Clase De Actividades</span></th> 
                                                <th class="column " style="background-color:#FFFC0B;"><span>Horas Semanales</span></th> 
                                            </tr>
                                        </thead>
                                        <tbody style="background-color:#fff;">
                                                    <tr class="dataColumns">
                                                        <td class="column borderR" rowspan="8" >Vocaci&oacute;n Ense&ntilde;anza-Aprendizaje         (Docencia)
                                                        </td>
                                                        <td class="column borderR">horas presenciales por semana</td>
                                                        <td class="column center">' . $Resultado->fields['HorasPresencialesPorSemana'] . '</td>
                                                    </tr>  
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas de preparaci&oacute;n</td>
                                                        <td class="column center">' . $Resultado->fields['HorasPreparacion'] . '</td>
                                                    </tr> 
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas de evaluaci&oacute;n</td>
                                                        <td class="column center">' . $Resultado->fields['HorasEvaluacion'] . '</td>
                                                    </tr>  
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas de asesor&iacute;a acad&eacute;mica</td>
                                                        <td class="column center">' . $Resultado->fields['HorasAsesoria'] . '</td>
                                                    </tr> 
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas laboratorios, talleres o preclinicas</td>
                                                        <td class="column center">' . $Resultado->fields['HorasTaller'] . '</td>
                                                    </tr>                                          
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas tutorias PAE</td>
                                                        <td class="column center">' . $Resultado->fields['HorasPAE'] . '</td>
                                                    </tr>
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas dedicadas a TIC</td>
                                                        <td class="column center">' . $Resultado->fields['HorasTIC'] . '</td>
                                                    </tr>
													<tr class="dataColumns">
                                                        <td class="column borderR">horas dedicadas a Innovacion</td>
                                                        <td class="column center">' . $Resultado->fields['HorasInnovacion'] . '</td>
                                                    </tr>
                                                    ';
                /* END Caso 87930 */
                /* Caso  103595
                 * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                 * Se adiciona el criterio TipoHoras = "CONTRATO" para que muestre las horas de sobresueldo. 
                * @since Junio 21 de 2017
                 */
                $SQL = 'SELECT
                            SUM(HorasDedicadas) as HorasDedicadas
                    FROM
                            PlanesTrabajoDocenteOtros tra
                    JOIN TiposPlanesTrabajoDocenteOtros tip ON tra.TipoPlanTrabajoDocenteOtrosId = tip.TipoPlanTrabajoDocenteOtrosId
                    WHERE
                            tip.VocacionesPlanesTrabajoDocenteId = 2
                    AND tra.iddocente = ' . $iddocente . '
                    AND tra.codigoestado = 100
                    AND codigoperiodo = ' . $periodo . '
                    AND TipoHoras = "CONTRATO"    
                    LIMIT 1';
                
                if ($Resultado = &$db->Execute($SQL) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQL;
                }
                if ($Resultado->fields['HorasDedicadas'] == '') {
                    $Resultado->fields['HorasDedicadas'] = 0;
                }
                $total = $total + $Resultado->fields['HorasDedicadas'];
                $a_vectt['tabla'] .= '<tr class="dataColumns">
                                                        <td class="column borderR">Vocaci&oacute;n de Descubrimiento (Investigaci&oacute;n)</td>
                                                        <td class="column borderR">Horas dedicadas</td>
                                                        <td class="column center">' . $Resultado->fields['HorasDedicadas'] . '</td>
                                                    </tr>';

                $SQL = 'SELECT
					SUM(HorasDedicadas) as HorasDedicadas
				FROM
					PlanesTrabajoDocenteOtros tra
				JOIN TiposPlanesTrabajoDocenteOtros tip ON tra.TipoPlanTrabajoDocenteOtrosId = tip.TipoPlanTrabajoDocenteOtrosId
				WHERE
					tip.VocacionesPlanesTrabajoDocenteId = 3
				AND tra.iddocente = ' . $iddocente . '
				AND tra.codigoestado = 100
				AND codigoperiodo = ' . $periodo . '
                                AND TipoHoras = "CONTRATO"    
				LIMIT 1';
                                
                if ($Resultado = &$db->Execute($SQL) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQL;
                }
                if ($Resultado->fields['HorasDedicadas'] == '') {
                    $Resultado->fields['HorasDedicadas'] = 0;
                }
                $total = $total + $Resultado->fields['HorasDedicadas'];
                $a_vectt['tabla'] .= '<tr class="dataColumns">
                                                        <td class="column borderR">Vocaci&oacute;n de Compromiso (Extensi&oacute;n)</td>
                                                        <td class="column borderR">Horas dedicadas</td>
                                                        <td class="column center">' . $Resultado->fields['HorasDedicadas'] . '</td>
                                                    </tr>';

                $SQL = 'SELECT
                            SUM(HorasDedicadas) as HorasDedicadas
                    FROM
                            PlanesTrabajoDocenteOtros tra
                    JOIN TiposPlanesTrabajoDocenteOtros tip ON tra.TipoPlanTrabajoDocenteOtrosId = tip.TipoPlanTrabajoDocenteOtrosId
                    WHERE
                            tip.VocacionesPlanesTrabajoDocenteId = 4
                    AND tra.iddocente = ' . $iddocente . '
                    AND tra.codigoestado = 100
                    AND codigoperiodo = ' . $periodo . '
                    
                    LIMIT 1';
                //End Caso 103595.
                if ($Resultado = &$db->Execute($SQL) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQL;
                }
                if ($Resultado->fields['HorasDedicadas'] == '') {
                    $Resultado->fields['HorasDedicadas'] = 0;
                }
                $total = $total + $Resultado->fields['HorasDedicadas'];
                $a_vectt['tabla'] .= '                                                   <tr class="dataColumns">
                                                        <td class="column borderR" colspan="2">Gesti&oacute;n Academica</td>
                                                        <td class="column center">' . $Resultado->fields['HorasDedicadas'] . '</td>
                                                    </tr>   
                                        </tbody>
                                        <tfoot style="background-color:#fff;">
                                            <tr>
                                                <td class="column borderR" colspan="2" style="text-align:right;">Total</td>
                                                <td class="center">' . $total . '</td>
                                            </tr>
                                        </tfoot>
                                    </table>';
                echo json_encode($a_vectt);
            }
        }break;

    case 'cargar_resumenSS': {
            $totalSobresueldo = 0;
            $iddocente = $_REQUEST['iddocente'];
            $periodo = $_REQUEST['codigoperiodo'];
            /*
             * Caso 87930
             * @modified Luis Dario Gualteros 
             * <castroluisd@unbosque.edu.co>
             * Se modifica la consulta para que consulte el campo de innovación para nueva funcionalidad de Innovación según
             * solicitud de Liliana Ahumada.
             * @since Marzo 6 de 2017
             */
            $SQLSobresueldo = 'SELECT
					SUM(HorasPresencialesPorSemana) as HorasPresencialesPorSemana,
					SUM(HorasPreparacion) as HorasPreparacion,
					SUM(HorasEvaluacion) as HorasEvaluacion,
					SUM(HorasAsesoria) as HorasAsesoria,
					SUM(HorasTIC) as HorasTIC,
                    SUM(HorasInnovar) as HorasInnovacion,
					SUM(HorasTaller) as HorasTaller,
					SUM(HorasPAE) as HorasPAE
				FROM
					PlanesTrabajoDocenteEnsenanza
				WHERE
					iddocente = "' . $iddocente . '"
				AND codigoestado = 100
				AND codigoperiodo = "' . $periodo . '"
				AND TipoHoras = "SOBRESUELDO" LIMIT 1';

            if ($ResultadoSobresueldo = &$db->Execute($SQLSobresueldo) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQLSobresueldo;
            } else {
                $totalSobresueldo = $totalSobresueldo + $ResultadoSobresueldo->fields['HorasPresencialesPorSemana'] + $ResultadoSobresueldo->fields['HorasPreparacion'] + $ResultadoSobresueldo->fields['HorasEvaluacion'] + $ResultadoSobresueldo->fields['HorasAsesoria'] + $ResultadoSobresueldo->fields['HorasTaller'] + $ResultadoSobresueldo->fields['HorasTIC'] + $ResultadoSobresueldo->fields['HorasInnovacion'] + $ResultadoSobresueldo->fields['HorasPAE'];


                $a_vectt['tablaSobresueldo'] = '<table align="center" class="formData last" width="92%" border="2" bordercolor="#fff" >
                                        <thead>            
                                            <tr class="dataColumns">
                                            </tr>
                                            <tr class="dataColumns category">
                                                <th class="column borderR" colspan="2" style="background-color:#FFFC0B;"><span>Clase De Actividades</span></th> 
                                                <th class="column " style="background-color:#FFFC0B;"><span>Horas Semanales</span></th> 
                                            </tr>
                                        </thead>
                                        <tbody style="background-color:#fff;">
                                                    <tr class="dataColumns">
                                                        <td class="column borderR" rowspan="8" >Vocaci&oacute;n Ense&ntilde;anza-Aprendizaje (Docencia)</td>
                                                        <td class="column borderR">horas presenciales por semana</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasPresencialesPorSemana'] . '</td>
                                                    </tr>  
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas de preparaci&oacute;n</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasPreparacion'] . '</td>
                                                    </tr> 
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas de evaluaci&oacute;n</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasEvaluacion'] . '</td>
                                                    </tr>  
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas de asesor&iacute;a acad&eacute;mica</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasAsesoria'] . '</td>
                                                    </tr> 
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas laboratorios, talleres o preclinicas</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasTaller'] . '</td>
                                                    </tr>                                          
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas tutorias PAE</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasPAE'] . '</td>
                                                    </tr>
													<tr class="dataColumns">
                                                        <td class="column borderR">horas dedicadas a TICs</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasTIC'] . '</td>
                                                    </tr>
                                                    <tr class="dataColumns">
                                                        <td class="column borderR">horas dedicadas a la Innovación</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasInnovacion'] . '</td>
                                                    </tr>';
                /* End Caso 87930 */
                $SQLSobresueldo = 'SELECT
					SUM(HorasDedicadas) as HorasDedicadas
				FROM
					PlanesTrabajoDocenteOtros tra
				JOIN TiposPlanesTrabajoDocenteOtros tip ON tra.TipoPlanTrabajoDocenteOtrosId = tip.TipoPlanTrabajoDocenteOtrosId
				WHERE
					tip.VocacionesPlanesTrabajoDocenteId = 2
				AND tra.iddocente = ' . $iddocente . '
				AND tra.codigoestado = 100
				AND codigoperiodo = ' . $periodo . '
				AND TipoHoras = "SOBRESUELDO" LIMIT 1';

                if ($ResultadoSobresueldo = &$db->Execute($SQLSobresueldo) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQLSobresueldo;
                }
                if ($ResultadoSobresueldo->fields['HorasDedicadas'] == '') {
                    $ResultadoSobresueldo->fields['HorasDedicadas'] = 0;
                }
                $totalSobresueldo = $totalSobresueldo + $ResultadoSobresueldo->fields['HorasDedicadas'];
                $a_vectt['tablaSobresueldo'] .= '<tr class="dataColumns">
                                                        <td class="column borderR">Vocaci&oacute;n de Descubrimiento (Investigaci&oacute;n)</td>
                                                        <td class="column borderR">Horas dedicadas</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasDedicadas'] . '</td>
                                                    </tr>';

                $SQLSobresueldo = 'SELECT
					SUM(HorasDedicadas) as HorasDedicadas
				FROM
					PlanesTrabajoDocenteOtros tra
				JOIN TiposPlanesTrabajoDocenteOtros tip ON tra.TipoPlanTrabajoDocenteOtrosId = tip.TipoPlanTrabajoDocenteOtrosId
				WHERE
					tip.VocacionesPlanesTrabajoDocenteId = 3
				AND tra.iddocente = ' . $iddocente . '
				AND tra.codigoestado = 100
				AND codigoperiodo = ' . $periodo . '
				AND TipoHoras = "SOBRESUELDO" LIMIT 1';
                if ($ResultadoSobresueldo = &$db->Execute($SQLSobresueldo) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQLSobresueldo;
                }
                if ($ResultadoSobresueldo->fields['HorasDedicadas'] == '') {
                    $ResultadoSobresueldo->fields['HorasDedicadas'] = 0;
                }
                $totalSobresueldo = $totalSobresueldo + $ResultadoSobresueldo->fields['HorasDedicadas'];
                $a_vectt['tablaSobresueldo'] .= '<tr class="dataColumns">
                                                        <td class="column borderR">Vocaci&oacute;n de Compromiso (Extensi&oacute;n)</td>
                                                        <td class="column borderR">Horas dedicadas</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasDedicadas'] . '</td>
                                                    </tr>';

                $SQLSobresueldo = 'SELECT
					SUM(HorasDedicadas) as HorasDedicadas
				FROM
					PlanesTrabajoDocenteOtros tra
				JOIN TiposPlanesTrabajoDocenteOtros tip ON tra.TipoPlanTrabajoDocenteOtrosId = tip.TipoPlanTrabajoDocenteOtrosId
				WHERE
					tip.VocacionesPlanesTrabajoDocenteId = 4
				AND tra.iddocente = ' . $iddocente . '
				AND tra.codigoestado = 100
				AND codigoperiodo = ' . $periodo . '
				AND TipoHoras = "SOBRESUELDO" LIMIT 1';
                if ($ResultadoSobresueldo = &$db->Execute($SQLSobresueldo) === false) {
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR ' . $SQLSobresueldo;
                }
                if ($ResultadoSobresueldo->fields['HorasDedicadas'] == '') {
                    $ResultadoSobresueldo->fields['HorasDedicadas'] = 0;
                }
                $totalSobresueldo = $totalSobresueldo + $ResultadoSobresueldo->fields['HorasDedicadas'];
                $a_vectt['tablaSobresueldo'] .= '                                                   <tr class="dataColumns">
                                                        <td class="column borderR" colspan="2">Gesti&oacute;n Academica</td>
                                                        <td class="column center">' . $ResultadoSobresueldo->fields['HorasDedicadas'] . '</td>
                                                    </tr>   
                                        </tbody>
                                        <tfoot style="background-color:#fff;">
                                            <tr>
                                                <td class="column borderR" colspan="2" style="text-align:right;">Total</td>
                                                <td class="center">' . $totalSobresueldo . '</td>
                                            </tr>
                                        </tfoot>
                                    </table>';

                if ($totalSobresueldo == 0) {
                    $a_vectt['tablaSobresueldo'] = "";
                }

                echo json_encode($a_vectt);
            }
        }break;

    case 'delete_otros': {
            $id_proyecto = $_REQUEST['id_proyecto'];
            $a_vectt['val'] = 'TRUE';
            $SQL = 'UPDATE PlanesTrabajoDocenteOtros SET codigoestado = 200 WHERE PlanTrabajoDocenteOtrosId = ' . $id_proyecto;
            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            }
            $SQL = 'UPDATE ActividadesPlanesTrabajoDocenteOtros SET codigoestado = 200 WHERE PlanTrabajoDocenteOtrosId = ' . $id_proyecto;
            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            }
            echo json_encode($a_vectt);
        }break;
    case 'delete_ensenanza': {
            $id_ensenanza = $_REQUEST['id'];
            $tipoHorasE = $_REQUEST['tipoHorasE'];
            $a_vectt['val'] = 'TRUE';
            $SQL = 'UPDATE PlanesTrabajoDocenteEnsenanza SET codigoestado = 200 WHERE PlanTrabajoDocenteEnsenanzaId = ' . $id_ensenanza . '';
            if ($tipoHorasE != 'undefined' && $tipoHorasE != '') {
                $SQL .= ' AND TipoHoras = "' . $tipoHorasE . '"';
            } else {
                $SQL .= ' AND TipoHoras = "CONTRATO"';
            }

            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            }
            $SQL = 'UPDATE ActividadesPlanesTrabajoDocenteEnsenanza SET codigoestado = 200 WHERE PlanTrabajoDocenteEnsenanzaId = ' . $id_ensenanza;
            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            }
            echo json_encode($a_vectt);
        }break;
    case 'delete_ensenanza_otros': {
            $id_ensenanza = $_REQUEST['id'];
            $identificador = $_REQUEST['identificador'];
            $tipoHorasE = $_REQUEST['tipoHorasE'];
            switch ($identificador) {
                case 'T': {
                        $horas = 'HorasTaller';
                        $tipo = 2;
                    }break;
                case 'P': {
                        $horas = 'HorasPAE';
                        $tipo = 3;
                    }break;
                case 'I': {
                        $horas = 'HorasTIC';
                        $tipo = 4;
                    }break;

                case 'N': {
                        $horas = 'HorasInnovar';
                        $tipo = 5;
                    }break;
            }
            $a_vectt['val'] = 'TRUE';
            $SQL = 'UPDATE PlanesTrabajoDocenteEnsenanza SET ' . $horas . ' = 0 WHERE PlanTrabajoDocenteEnsenanzaId = ' . $id_ensenanza . '';
            if ($tipoHorasE != 'undefined' && $tipoHorasE != '') {
                $SQL .= ' AND TipoHoras = "' . $tipoHorasE . '"';
            } else {
                $SQL .= ' AND TipoHoras = "CONTRATO"';
            }

            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            }
            $SQL = 'UPDATE ActividadesPlanesTrabajoDocenteEnsenanza SET codigoestado = 200 WHERE PlanTrabajoDocenteEnsenanzaId = ' . $id_ensenanza . ' AND TipoPlanTrabajoDocenteEnsenanzaId = ' . $tipo;
            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            }
            echo json_encode($a_vectt);
        }break;

    case 'consultar_antiguos_EO': {
            $programa = $_REQUEST['programa'];
            $id_docente = $_REQUEST['id_docente'];
            $periodo = $_REQUEST['periodo'];
            $tipoHorasEO = $_REQUEST['TipoHorasEnsenanza'];
            $tipo_Actividad = $_REQUEST['tipo_Actividad'];


            /*
             * Caso 87930
             * @modified Luis Dario Gualteros 
             * <castroluisd@unbosque.edu.co>
             * Se modifica la consulta para que consulte el campo de innovación para nueva funcionalidad de Innovación según
             * solicitud de Liliana Ahumada.
             * @since Marzo 6 de 2017
             */
            $SQL = 'SELECT
					PlanTrabajoDocenteEnsenanzaId,
					HorasPAE,
					HorasTaller,
					HorasTIC, 
                    HorasInnovar, 
                    TipoHoras
				FROM
					PlanesTrabajoDocenteEnsenanza
				WHERE
					codigocarrera = ' . $programa . '
				AND iddocente = ' . $id_docente . '
				AND codigoperiodo = ' . $periodo . '
				AND codigomateria = 1
				AND codigoestado = 100
				AND ( HorasPAE != 0 OR HorasTaller != 0 OR HorasTIC != 0 OR HorasInnovar != 0 )';
            if ($tipoHorasEO != 'undefined' && $tipoHorasEO != '') {
                $SQL .= ' AND TipoHoras = "' . $tipoHorasEO . '"';
            } else {
                $SQL .= ' AND TipoHoras = "CONTRATO"';
            }



            if ($Resultado = &$db->Execute($SQL) === false) {
                echo 'Error en consulta a base de datos';
                die;
            } else {

                if ($Resultado->_numOfRows != 0) {

                    $a_vectt['ensenanza_id'] = $Resultado->fields['PlanTrabajoDocenteEnsenanzaId'];
                    $a_vectt['ensenanza_horas_tic'] = $Resultado->fields['HorasTIC'];
                    $a_vectt['ensenanza_horas_Innovar'] = $Resultado->fields['HorasInnovar'];
                    $a_vectt['ensenanza_horas_tal'] = $Resultado->fields['HorasTaller'];
                    $a_vectt['ensenanza_horas_pae'] = $Resultado->fields['HorasPAE'];


                    /* ACTIVIDADES */
                    $SQL = 'SELECT * FROM ActividadesPlanesTrabajoDocenteEnsenanza WHERE PlanTrabajoDocenteEnsenanzaId = ' . $Resultado->fields['PlanTrabajoDocenteEnsenanzaId'] . ' AND codigoestado = 100 AND TipoPlanTrabajoDocenteEnsenanzaId = ' . $tipo_Actividad . ' ORDER BY TipoPlanTrabajoDocenteEnsenanzaId ASC';


                    if ($Resultado = &$db->Execute($SQL) === false) {
                        echo 'Error en consulta a base de datos';
                        die;
                    }

                    if ($Resultado->_numOfRows != 0) {
                        $plan_ensenanza = array();
                        $plan_ensenanza_nombre = array();
                        $plan_ensenanza_tipo = array();
                        if (!$Resultado->EOF) {
                            while (!$Resultado->EOF) {
                                $plan_ensenanza[$i] = $Resultado->fields['ActividadPlanTrabajoDocenteEnsenanzaId'];
                                $plan_ensenanza_nombre[$i] = $Resultado->fields['Nombre'];
                                $plan_ensenanza_tipo[$i] = $Resultado->fields['TipoPlanTrabajoDocenteEnsenanzaId'];
                                $Resultado->MoveNext();
                                $i++;
                            }
                        }
                        $a_vectt['plan_ensenanza'] = $plan_ensenanza;
                        $a_vectt['plan_ensenanza_nombre'] = $plan_ensenanza_nombre;
                        $a_vectt['plan_ensenanza_tipo'] = $plan_ensenanza_tipo;
                    } else {
                        $a_vectt['plan_ensenanza'] = 0;
                    }
                } else {
                    $a_vectt['val'] = 'NO_Existe';
                }
            }echo json_encode($a_vectt);
        }break;

    case 'actualizar_ensenanzayapredizaje_varios': {

            $actividades = $_REQUEST['actividades'];
            $ocultos_actividades = $_REQUEST['ocultos_actividades'];
            $programaAcademicoId = $_REQUEST['programaAcademicoId'];
            $asignatura_id = $_REQUEST['asignatura_id'];
            $docente_id = $_REQUEST['docente_id'];
            $periodo = $_REQUEST['periodo'];
            $horasTic = $_REQUEST['horasTic'];
            $horasInnovar = $_REQUEST['horasInnovar'];
            $horasTaller = $_REQUEST['horasTaller'];
            $horasPae = $_REQUEST['horasPae'];
            $tipo_ensenanza = $_REQUEST['tipo_ensenanza'];
            $oculto_ensenanza = $_REQUEST['oculto_ensenanza'];
            $modalidad = $_REQUEST['modalidad'];
            $TipoHorasEO = $_REQUEST['TipoHorasEnsenanza'];
            $ensenanza_id = $_REQUEST['txtPlanEnsenanza'];


            $sql_update = "UPDATE PlanesTrabajoDocenteEnsenanza SET HorasPresencialesPorSemana = '0', HorasPreparacion = '0', 
                            HorasEvaluacion = '0', HorasAsesoria = '0', HorasTIC = '" . $horasTic . "',HorasInnovar = '" . $horasInnovar . "', 
                            HorasTaller = '" . $horasTaller . "', HorasPAE = '" . $horasPae . "', FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "'";
            /* END caso 87930 */
            if ($TipoHorasEO != "undefined" && $TipoHorasEO != "") {
                $sql_update .= ", TipoHoras = '" . $TipoHorasEO . "'";
            } else {
                $sql_update .= ", TipoHoras = 'CONTRATO'";
            }
            $sql_update .= " WHERE PlanTrabajoDocenteEnsenanzaId= '" . $ensenanza_id . "'";



            if ($modificar_plandocente = &$db->Execute($sql_update) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $sql_update;
            } else {


                $arr_id_actividades = array();
                $i = 0;
                foreach ($actividades as $act) {

                    if ($ocultos_actividades[$i] == 0) {

                        $sql_insert_actividades = "INSERT INTO ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', PlanTrabajoDocenteEnsenanzaId = '" . $ensenanza_id . "', FechaCreacion = '" . date("Y-m-d H:i:s") . "', 
                            TipoPlanTrabajoDocenteEnsenanzaId = '" . $tipo_ensenanza . "'";


                        if ($consulta = $db->Execute($sql_insert_actividades) === false) {
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] = 'ERROR ' . $sql_select;
                        }
                        $arr_id_actividades[$i] = $db->Insert_ID();
                    } else {
                        $sql_update_actividades = "UPDATE ActividadesPlanesTrabajoDocenteEnsenanza SET Nombre = '" . $act . "', codigoestado = 100, FechaUltimaModificacion = '" . date("Y-m-d H:i:s") . "' 
                            WHERE ActividadPlanTrabajoDocenteEnsenanzaId = '" . $ocultos_actividades[$i] . "'
                            AND TipoPlanTrabajoDocenteEnsenanzaId = '" . $tipo_ensenanza . "'";


                        if ($consulta = $db->Execute($sql_update_actividades) === false) {
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] = 'ERROR ' . $sql_update_actividades;
                        } else {
                            $arr_id_actividades[$i] = $ocultos_actividades[$i];
                        }
                    }
                    $i++;
                }

                $a_vectt['val'] = 'NO_Existe';
                $a_vectt['descrip'] = 'Se registro Exitosamente';

                $a_vectt['arr_id_actividades'] = $arr_id_actividades;
                echo json_encode($a_vectt);
            }
        }break;


    case 'deleteActividad': {
            $id_proyecto = $_REQUEST['id_Proyecto'];
            $a_vectt['val'] = 'TRUE';
            $SQL = 'UPDATE ActividadesPlanesTrabajoDocenteEnsenanza SET codigoestado = 200 WHERE ActividadPlanTrabajoDocenteEnsenanzaId = ' . $id_proyecto;
            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            }
            echo json_encode($a_vectt);
        }break;

    case 'deleteActividadOtros': {
            $id_proyectoOtros = $_REQUEST['id_ProyectoOtros'];
            $a_vectt['val'] = 'TRUE';
            $SQL = 'UPDATE ActividadesPlanesTrabajoDocenteOtros SET codigoestado = 200 WHERE ActividadPlanTrabajoDocenteOtrosId = ' . $id_proyectoOtros;
            if ($Resultado = &$db->Execute($SQL) === false) {
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR ' . $SQL;
            }
            echo json_encode($a_vectt);
        }break;
}
?>