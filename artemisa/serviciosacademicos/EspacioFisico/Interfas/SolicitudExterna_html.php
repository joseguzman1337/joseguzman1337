<?php
session_start();

if (!isset($_SESSION['MM_Username'])) {
    echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
    exit();
}
switch ($_REQUEST['actionID']) {
    case 'UpdateSolicitudExterna': {
            global $db, $userid;
            MainJson();

            include_once('../Solicitud/festivos.php');
            $C_Festivo = new festivos();
            include_once('../Solicitud/SolicitudEspacio_class.php');
            $C_SolicitudEspacio = new SolicitudEspacio();

            $Data = $_POST;

            $SolicitudExt_ID = $_POST['SolicitudExt_ID'];
            $Evento = $_POST['Evento'];
            $NumAsistentes = $_POST['NumAsistentes'];
            $FechaIni = $_POST['FechaIni'];
            $FechaFin = $_POST['FechaFin'];
            $DiaSemana = $_POST['DiaSemana'];
            $numIndices = $_POST['numIndices'];
            $Sede = $_POST['Campus'];
            $Modalidad = $_POST['Modalidad'];
            $Unidad = $_POST['Unidad'];
            $Persona = $_POST['Persona'];
            $Telefono = $_POST['Telefono'];
            $Email = $_POST['Email'];
            $Carrera = $_POST['Programa'];
            $Grupo_id = $_POST['MultiGrupos'];
            $Acceso = $_POST['Acceso']; // => on 
            $SolicitudPadre = $_POST['SolicitudPadre'];

            if ($Acceso) {
                $Acceso = 1;
            } else {
                $Acceso = 0;
            }

            $fechadb = $FechaIni;
            $tmp = explode('-', $fechadb);
            $Fecha_Envia = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            $fecha = date('Y-m-d');
            $tmp = explode('-', $fecha);
            $Hoy = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            // Compara ahora que las fechas son enteror
            if ($Hoy > $Fecha_Envia) {

                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'La fecha Inicial Es Menor que la fecha Actual...';
                echo json_encode($a_vectt);
                exit;
            }

            $fechadb = $FechaFin;
            $tmp = explode('-', $fechadb);
            $Fecha_Envia = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            $fecha = date('Y-m-d');
            $tmp = explode('-', $fecha);
            $Hoy = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            // Compara ahora que las fechas son enteror
            if ($Hoy > $Fecha_Envia) {

                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'La fecha Final Es Menor que la fecha Actual...';
                echo json_encode($a_vectt);
                exit;
            }

            $Result = $C_SolicitudEspacio->FechasFuturas('35', $FechaIni, $FechaFin, $DiaSemana);

            $Horas = array();

            for ($l = 0; $l < count($DiaSemana); $l++) {
                for ($h = 0; $h <= $numIndices; $h++) {
                    $x = $DiaSemana[$l] - 1;
                    $Horaini = $Data['HoraInicial_' . $h][$x];
                    $Horafin = $Data['HoraFin_' . $h][$x];
                    $TipoSalon_n = $Data['TipoSalon_' . $h][$x];
                    $C_H['inicial'][$l][] = $Horaini;
                    $C_H['final'][$l][] = $Horafin;
                    $Horas['inicial'][$l][] = $Horaini;
                    $Horas['final'][$l][] = $Horafin;
                    $Horas['TipoSalon'][$l][] = $TipoSalon_n;
                }
            }

            for ($l = 0; $l < count($DiaSemana); $l++) {
                $n = 0;
                for ($j = 0; $j < count($Result[$l]); $j++) {
                    for ($x = 0; $x < count($Horas['inicial'][$l]); $x++) {
                        if ($Horas['inicial'][$l][$x]) {
                            $Info[$DiaSemana[$l]][$n][] = $Result[$l][$j] . ' ' . $Horas['inicial'][$l][$x];
                            $Info[$DiaSemana[$l]][$n][] = $Result[$l][$j] . ' ' . $Horas['final'][$l][$x];
                            $Info[$DiaSemana[$l]][$n][] = $Horas['TipoSalon'][$l][$x];
                            $n++;
                            $Feha_inicial = $Result[$l][$j];
                            $Feha_final = $Result[$l][$j];
                        }
                    }
                }
            }

            $Limit = Count($DiaSemana) - 1;

            for ($i = 0; $i <= $Limit; $i++) {

                $Fecha_inicial = $FechaIni;
                $Fecha_final = $FechaFin;

                if ($Info[$DiaSemana[$i]]) {

                    $SQL_Insert = 'INSERT INTO SolicitudAsignacionEspacios(AccesoDiscapacitados,FechaInicio,FechaFinal,idsiq_periodicidad,ClasificacionEspaciosId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,codigodia,observaciones,NombreEvento,NumAsistentes,codigomodalidadacademica,UnidadNombre,Responsable,Telefono,Email,codigocarrera)VALUES("' . $Acceso . '","' . $Fecha_inicial . '","' . $Fecha_final . '","35","' . $Sede[$i] . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"' . $DiaSemana[$i] . '","' . $Observacion . '","' . $Evento . '","' . $NumAsistentes . '","' . $Modalidad . '","' . $Unidad . '","' . $Persona . '","' . $Telefono . '","' . $Email . '","' . $Carrera . '")';

                    if ($InsertSolicituNew = &$db->Execute($SQL_Insert) === false) {
                        $a_vectt['val'] = false;
                        $a_vectt['descrip'] = 'Error al Insertar Solicitud..' . $SQL_Insert;
                        echo json_encode($a_vectt);
                        exit;
                    }

                    ##########################
                    $Last_id = $db->Insert_ID();
                    ##########################

                    $InsertAsociacion = 'INSERT INTO AsociacionSolicitud(SolicitudPadreId,SolicitudAsignacionEspaciosId)VALUES("' . $SolicitudPadre . '","' . $Last_id . '")';

                    if ($InsertAsociacionNew = &$db->Execute($InsertAsociacion) === false) {
                        $a_vectt['val'] = false;
                        $a_vectt['descrip'] = 'Error al Insertar Asociacion Solicitud..';
                        echo json_encode($a_vectt);
                        exit;
                    }

                    for ($G = 0; $G < count($Grupo_id); $G++) {

                        $InserGrupo = 'INSERT INTO SolicitudEspacioGrupos(SolicitudAsignacionEspacioId,idgrupo)VALUES("' . $Last_id . '","' . $Grupo_id[$G] . '")';

                        if ($GrupoSolicitud = &$db->Execute($InserGrupo) === false) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Error al Insertar Solicitud Grupo..' . $InserGrupo;
                            echo json_encode($a_vectt);
                            exit;
                        }
                    }

                    $SQL_TipoSalon = 'INSERT INTO SolicitudAsignacionEspaciostiposalon(SolicitudAsignacionEspacioId,codigotiposalon)VALUES("' . $Last_id . '","' . $Info[$DiaSemana[$i]][0][2] . '")';

                    if ($SolicitudTipoSalon = &$db->Execute($SQL_TipoSalon) === false) {
                        $a_vectt['val'] = false;
                        $a_vectt['descrip'] = 'Error al Insertar Solicitud Tipo Salon..' . $SQL_TipoSalon;
                        echo json_encode($a_vectt);
                        exit;
                    }

                    for ($x = 0; $x < count($Info[$DiaSemana[$i]]); $x++) {

                        $FechaFutura_1 = $Info[$DiaSemana[$i]][$x][0];
                        $FechaFutura_2 = $Info[$DiaSemana[$i]][$x][1];

                        $C_FechaData_1 = explode(' ', $FechaFutura_1);
                        $C_FechaData_2 = explode(' ', $FechaFutura_2);

                        $C_DatosDia = explode('-', $C_FechaData_1[0]);

                        $dia = $C_DatosDia[2];
                        $mes = $C_DatosDia[1];

                        $Fecha = $C_FechaData_1[0];
                        $Hora_1 = $C_FechaData_1[1];
                        $Hora_2 = $C_FechaData_2[1];

                        $Asignacion = 'INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("' . $Fecha . '","' . $Last_id . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"212","' . $Hora_1 . '","' . $Hora_2 . '")';

                        if ($InsertAsignar = &$db->Execute($Asignacion) === false) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Error al Insertar Asignacion del Espacio..';
                            echo json_encode($a_vectt);
                            exit;
                        }
                    }
                }
            }

            for ($xx = 0; $xx < $numIndices; $xx++) {

                for ($ll = 0; $ll < count($_POST['TipoSalon_' . $xx]); $ll++) {
                    if ($_POST['TipoSalon_' . $xx][$ll] != '-1') {
                        $TipoSalon[] = $_POST['TipoSalon_' . $xx][$ll];
                    }
                }
            }

            for ($i = 0; $i < count($SolicitudExt_ID); $i++) {

                for ($m = 0; $m < count($DiaSemana); $m++) {

                    $SolicitudExt_ID[$i];
                    $Fecha_inicial = $FechaIni;
                    $Fecha_final = $FechaFin;
                    $Dia = $_POST['Dia_' . $SolicitudExt_ID[$i]];

                    if ($Dia == $DiaSemana[$m]) {
                        if ($Dia) {
                            if (!$Sede[$i]) {
                                $SQL = 'SELECT
                                        ClasificacionEspaciosId
                                        FROM SolicitudAsignacionEspacios
                                        WHERE SolicitudAsignacionEspacioId="' . $SolicitudExt_ID[$i] . '"';

                                if ($SedeBuscar = &$db->Execute($SQL) === false) {
                                    echo 'Error en el SQL del Sistema.';
                                    die;
                                }

                                $C_Sede = $SedeBuscar->fields['ClasificacionEspaciosId'];
                            } else {
                                $C_Sede = $Sede[$i];
                            }

                            $UpdateSolicitud = 'UPDATE SolicitudAsignacionEspacios            
                              SET    AccesoDiscapacitados="' . $Acceso . '",
                                     FechaInicio="' . $Fecha_inicial . '",
                                     FechaFinal="' . $Fecha_final . '",
                                     ClasificacionEspaciosId="' . $C_Sede . '",
                                     UsuarioUltimaModificacion="' . $userid . '",
                                     FechaUltimaModificacion=NOW(),
                                     codigodia="' . $Dia . '",
                                     observaciones="' . $Observacion . '",
                                     NombreEvento="' . $Evento . '",
                                     NumAsistentes="' . $NumAsistentes . '",
                                     UnidadNombre="' . $Unidad . '",
                                     Responsable="' . $Persona . '",
                                     Telefono="' . $Telefono . '",
                                     Email="' . $Email . '",
                                     codigoestado=100                             
                             WHERE   SolicitudAsignacionEspacioId="' . $SolicitudExt_ID[$i] . '" ';

                            if ($UpddateSolicitud = &$db->Execute($UpdateSolicitud) === false) {
                                $a_vectt['val'] = false;
                                $a_vectt['descrip'] = 'Error al Modificar Solicitud ..' . $UpdateSolicitud;
                                echo json_encode($a_vectt);
                                exit;
                            }



                            $SQL_Grupo = 'UPDATE SolicitudEspacioGrupos SET codigoestado=200                         
                                            WHERE  SolicitudAsignacionEspacioId="' . $SolicitudExt_ID[$i] . '"';

                            if ($GrupoSolicitudDelete = &$db->Execute($SQL_Grupo) === false) {
                                $a_vectt['val'] = false;
                                $a_vectt['descrip'] = 'Error al Modificar Solicitud Grupo..';
                                echo json_encode($a_vectt);
                                exit;
                            }


                            for ($j = 0; $j < count($Grupo_id); $j++) {
                                $SQL = 'SELECT *
                                        FROM SolicitudEspacioGrupos
                                        WHERE SolicitudAsignacionEspacioId="' . $SolicitudExt_ID[$i] . '" AND idgrupo="' . $Grupo_id[$j] . '"';

                                if ($ExisteGrupo = &$db->Execute($SQL) === false) {
                                    $a_vectt['val'] = false;
                                    $a_vectt['descrip'] = 'Error al Consultar';
                                    echo json_encode($a_vectt);
                                    exit;
                                }

                                if (!$ExisteGrupo->EOF) {
                                    $SQL_Grupo = 'UPDATE SolicitudEspacioGrupos SET codigoestado=100                                                     
                                                    WHERE  SolicitudAsignacionEspacioId="' . $SolicitudExt_ID[$i] . '" AND idgrupo="' . $Grupo_id[$j] . '"';

                                    if ($GrupoSolicitud = &$db->Execute($SQL_Grupo) === false) {
                                        $a_vectt['val'] = false;
                                        $a_vectt['descrip'] = 'Error al Modificar Solicitud Grupo..';
                                        echo json_encode($a_vectt);
                                        exit;
                                    }
                                } else {
                                    $InserGrupo = 'INSERT INTO SolicitudEspacioGrupos(SolicitudAsignacionEspacioId,idgrupo)VALUES("' . $SolicitudExt_ID[$i] . '","' . $Grupo_id[$j] . '")';

                                    if ($GrupoSolicitud = &$db->Execute($InserGrupo) === false) {
                                        $a_vectt['val'] = false;
                                        $a_vectt['descrip'] = 'Error al Insertar Solicitud Grupo..';
                                        echo json_encode($a_vectt);
                                        exit;
                                    }
                                }
                            }

                            $SQL_TipoSalon = 'UPDATE SolicitudAsignacionEspaciostiposalon
                                               SET    codigotiposalon="' . $TipoSalon[$i] . '"
                                               WHERE  SolicitudAsignacionEspacioId="' . $SolicitudExt_ID[$i] . '"';

                            if ($SolicitudTipoSalon = &$db->Execute($SQL_TipoSalon) === false) {
                                $a_vectt['val'] = false;
                                $a_vectt['descrip'] = 'Debe seleccionar el Tipo Salon segun el Dia Inidcado..';
                                echo json_encode($a_vectt);
                                exit;
                            }
                        }
                    }
                }
                $SQL = ' SELECT
                            AsignacionEspaciosId,
                            FechaAsignacion,
                            codigoestado,
                            ClasificacionEspaciosId,
                            HoraInicio,
                            HoraFin
                        FROM AsignacionEspacios
                        WHERE SolicitudAsignacionEspacioId = "' . $SolicitudExt_ID[$i] . '" LIMIT 1';

                $verificacion = $db->Execute($SQL);

                if ($verificacion === false) {
                    echo 'Error del Sistema.';
                    die;
                }

                if (!$verificacion->EOF) {
                    $SQL_Anula_temp = 'UPDATE  AsignacionEspacios
                                                SET codigoestado=200,
                                                    UsuarioUltimaModificacion="' . $userid . '",
                                                    FechaultimaModificacion=NOW()
                                                WHERE SolicitudAsignacionEspacioId = "' . $SolicitudExt_ID[$i] . '" AND FechaAsignacion >=CURDATE()';

                    $Anula_temp = $db->Execute($SQL_Anula_temp);

                    if ($Anula_temp === false) {
                        echo 'Error en el Sistema.';
                        die;
                    }

                    for ($n = 0; $n < count($Result[$i]); $n++) {

                        $SQL = ' SELECT
                                    AsignacionEspaciosId,
                                    FechaAsignacion,
                                    codigoestado,
                                    ClasificacionEspaciosId,
                                    HoraInicio,
                                    HoraFin
                                FROM AsignacionEspacios
                                WHERE SolicitudAsignacionEspacioId = "' . $SolicitudExt_ID[$i] . '"
                                AND FechaAsignacion="' . $Result[$i][$n] . '"';

                        $Consulta = $db->Execute($SQL);

                        if ($Consulta === false) {
                            echo 'Error en el Sistema.';
                            die;
                        }
                        $Fecha_X = $Result[$i][$n];
                        $Dia_X = $Data['Dia_' . $SolicitudExt_ID[$i]];
                        $HoraInicial_X = $Data['HoraInicial_' . $SolicitudExt_ID[$i]][0];
                        $HoraFin_X = $Data['HoraFin_' . $SolicitudExt_ID[$i]][0];

                        if (($Dia_X) && ($HoraInicial_X) && ($HoraFin_X)) {
                            if (!$Consulta->EOF) {
                                $SQL_Activa_Actualiza = 'UPDATE  AsignacionEspacios
                                                                            SET codigoestado=100,
                                                                                UsuarioUltimaModificacion="' . $userid . '",
                                                                                FechaultimaModificacion=NOW(),
                                                                                FechaAsignacion = "' . $Fecha_X . '",
                                                                                ClasificacionEspaciosId=212,
                                                                                HoraInicio = "' . $HoraInicial_X . '",
                                                                                HoraFin = "' . $HoraFin_X . '"
                                                                            WHERE SolicitudAsignacionEspacioId = "' . $SolicitudExt_ID[$i] . '" AND AsignacionEspaciosId="' . $Consulta->fields['AsignacionEspaciosId'] . '"';
                                $Activa_Actualiza = $db->Execute($SQL_Activa_Actualiza);

                                if ($Activa_Actualiza === false) {
                                    echo 'Error en el Sistema.';
                                    die;
                                }
                            } else {
                                $Asignacion_nueva = 'INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("' . $Fecha_X . '","' . $SolicitudExt_ID[$i] . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"212","' . $HoraInicial_X . '","' . $HoraFin_X . '")';

                                $Crear_nueva = $db->Execute($Asignacion_nueva);

                                if ($Crear_nueva === false) {
                                    echo 'Error en el Sistema.';
                                    die;
                                }
                            }
                        }
                    }
                }
            }

            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se ha Editado la Solicitud Correctamente...';
            echo json_encode($a_vectt);
            exit;
        }break;
    case 'Editar': {
            global $C_InterfazSolicitud, $C_SolicitudExterna, $userid, $db;
            define(AJAX, false);
            MainGeneral();
            JsGeneral();

            $C_SolicitudExterna->Principal($db, '', $_POST['id']);
        }break;
    case 'ViewGruposMateria': {
            global $C_InterfazSolicitud, $C_SolicitudExterna, $userid, $db;
            define(AJAX, true);
            MainGeneral();
            $GruposAdd = $_POST['GruposAdd'];
            $C_SolicitudExterna->MultiGrupoMateria($db, $GruposAdd);
        }break;
    case 'AutoGrupoMateria': {

            global $db, $userid;
            MainJson();

            $Letra = $_REQUEST['term'];
            $Carrera = $_REQUEST['Programa'];
            $GruposAdd = $_REQUEST['GruposAdd'];
            $periodoSecion = $_SESSION['codigoperiodosesion'];

            if ($GruposAdd) {
                $Data = explode('::', $GruposAdd);

                for ($i = 1; $i < count($Data); $i++) {
                    if ($i == 1) {
                        $Grupos_NO = '"' . $Data[$i] . '"';
                    } else {
                        $Grupos_NO = $Grupos_NO . ',"' . $Data[$i] . '"';
                    }
                }
                $CondiCion = ' AND  g.idgrupo NOT IN (' . $Grupos_NO . ')';
            } else {
                $CondiCion = '';
            }

            $SQL = 'SELECT
                codigoperiodo,codigoestadoperiodo
                FROM
                	periodo
                WHERE
                	codigoestadoperiodo = 1';

            if ($Dato = &$db->Execute($SQL) === false) {
                echo 'Error en el SQL ...<br><br>' . $SQL;
                die;
            }

            $Periodo = $Dato->fields['codigoperiodo'];

            $SQl_2 = 'SELECT
                g.idgrupo,
                g.nombregrupo,
                g.codigomateria,
                m.nombremateria
                FROM
                grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria                
                WHERE g.codigoestadogrupo=10
                AND m.codigocarrera="' . $Carrera . '"
                AND g.codigoperiodo IN ("' . $Periodo . '","' . $periodoSecion . '")
                AND (m.nombremateria LIKE "' . $Letra . '%" OR  m.codigomateria LIKE "' . $Letra . '%" OR  g.idgrupo LIKE "' . $Letra . '%" OR  g.nombregrupo LIKE "' . $Letra . '%") ' . $CondiCion;

            if ($Consulta = &$db->Execute($SQl_2) === false) {
                echo 'Error en el SQL ...<br><br>' . $SQl_2;
                die;
            }
            $DataGrupoMateria = array();

            if (!$Consulta->EOF) {
                while (!$Consulta->EOF) {
                    $Ini_Vectt['label'] = 'ID Grupo :: ' . $Consulta->fields['idgrupo'] . ' :: Grupo ' . $Consulta->fields['nombregrupo'] . 'ID Materia :: ' . $Consulta->fields['codigomateria'] . ' :: Materia ' . $Consulta->fields['nombremateria'];
                    $Ini_Vectt['value'] = 'ID Grupo :: ' . $Consulta->fields['idgrupo'] . ' :: Grupo ' . $Consulta->fields['nombregrupo'] . 'ID Materia :: ' . $Consulta->fields['codigomateria'] . ' :: Materia ' . $Consulta->fields['nombremateria'];
                    $Ini_Vectt['id'] = $Consulta->fields['idgrupo'];

                    array_push($DataGrupoMateria, $Ini_Vectt);

                    $Consulta->MoveNext();
                }
            } else {
                $Ini_Vectt['label'] = 'No Hay Informacion';
                $Ini_Vectt['value'] = 'No Hay Informacion';
                $Ini_Vectt['id'] = '-1';

                array_push($DataGrupoMateria, $Ini_Vectt);
            }

            echo json_encode($DataGrupoMateria);
            exit;
        }break;
    case 'SaveSolicitudExterna': {
            global $db, $userid;
            MainJson();
            include_once('../Solicitud/festivos.php');
            $C_Festivo = new festivos();
            include_once('../Solicitud/SolicitudEspacio_class.php');
            $C_SolicitudEspacio = new SolicitudEspacio();

            $Data = $_POST;

            $Evento = $_POST['Evento'];
            $NumAsistentes = $_POST['NumAsistentes'];
            $FechaIni = $_POST['FechaIni'];
            $FechaFin = $_POST['FechaFin'];
            $DiaSemana = $_POST['DiaSemana'];
            $numIndices = $_POST['numIndices'];
            $Sede = $_POST['Campus'];
            $Modalidad = $_POST['Modalidad'];
            $Unidad = $_POST['Unidad'];
            $Persona = $_POST['Persona'];
            $Telefono = $_POST['Telefono'];
            $Email = $_POST['Email'];
            $Carrera = $_POST['Programa'];
            $Grupo_id = $_POST['MultiGrupos'];
            $Acceso = $_POST['Acceso']; // => on          

            if ($Acceso) {
                $Acceso = 1;
            } else {
                $Acceso = 0;
            }


            $fechadb = $FechaIni;
            $tmp = explode('-', $fechadb);
            $Fecha_Envia = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            $fecha = date('Y-m-d');
            $tmp = explode('-', $fecha);
            $Hoy = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            // Compara ahora que las fechas son enteror
            if ($Hoy > $Fecha_Envia) {

                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'La fecha Inicial Es Menor que la fecha Actual...';
                echo json_encode($a_vectt);
                exit;
            }

            $fechadb = $FechaFin;
            $tmp = explode('-', $fechadb);
            $Fecha_Envia = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            $fecha = date('Y-m-d');
            $tmp = explode('-', $fecha);
            $Hoy = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            // Compara ahora que las fechas son enteror
            if ($Hoy > $Fecha_Envia) {

                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'La fecha Final Es Menor que la fecha Actual...';
                echo json_encode($a_vectt);
                exit;
            }
            $Result = $C_SolicitudEspacio->FechasFuturas('35', $FechaIni, $FechaFin, $DiaSemana);

            $Horas = array();

            for ($l = 0; $l < count($DiaSemana); $l++) {
                for ($h = 0; $h <= $numIndices; $h++) {
                    $x = $DiaSemana[$l] - 1;
                    $Horaini = $Data['HoraInicial_' . $h][$x];
                    $Horafin = $Data['HoraFin_' . $h][$x];
                    $C_H['inicial'][$l][] = $Horaini;
                    $C_H['final'][$l][] = $Horafin;
                    $Horas['inicial'][$l][] = $Horaini;
                    $Horas['final'][$l][] = $Horafin;
                }
            }

            for ($l = 0; $l < count($DiaSemana); $l++) {
                $n = 0;
                for ($j = 0; $j < count($Result[$l]); $j++) {
                    for ($x = 0; $x < count($Horas['inicial'][$l]); $x++) {
                        if ($Horas['inicial'][$l][$x]) {
                            $Info[$DiaSemana[$l]][$n][] = $Result[$l][$j] . ' ' . $Horas['inicial'][$l][$x];
                            $Info[$DiaSemana[$l]][$n][] = $Result[$l][$j] . ' ' . $Horas['final'][$l][$x];
                            $n++;
                            $Feha_inicial = $Result[$l][$j];
                            $Feha_final = $Result[$l][$j];
                        }
                    }
                }
            }

            $Limit = Count($DiaSemana) - 1;

            $SQL_InsertPadre = 'INSERT INTO SolicitudPadre(UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion)VALUES("' . $userid . '","' . $userid . '",NOW(),NOW())';

            if ($InsertPadre = &$db->Execute($SQL_InsertPadre) === false) {
                echo 'Error en el sql del Padre id Solicud...<br><BR>' . $SQL_InsertPadre;
                die;
            }

            $SolicituPadre = $Last_id = $db->Insert_ID();

            for ($Q = 0; $Q <= $numIndices; $Q++) {
                for ($i = 0; $i <= $Limit; $i++) {

                    $T = $DiaSemana[$i] - 1;
                    $TipoSalon = $_POST['TipoSalon_' . $Q][$T];

                    $SQL_Insert = 'INSERT INTO SolicitudAsignacionEspacios(AccesoDiscapacitados,FechaInicio,FechaFinal,idsiq_periodicidad,ClasificacionEspaciosId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,codigodia,observaciones,NombreEvento,NumAsistentes,codigomodalidadacademica,UnidadNombre,Responsable,Telefono,Email,codigocarrera)VALUES("' . $Acceso . '","' . $FechaIni . '","' . $FechaFin . '","35","' . $Sede[$i] . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"' . $DiaSemana[$i] . '","' . $Observacion . '","' . $Evento . '","' . $NumAsistentes . '","' . $Modalidad . '","' . $Unidad . '","' . $Persona . '","' . $Telefono . '","' . $Email . '","' . $Carrera . '")';

                    if ($InsertSolicituNew = &$db->Execute($SQL_Insert) === false) {
                        $a_vectt['val'] = false;
                        $a_vectt['descrip'] = 'Error al Insertar Solicitud..';
                        echo json_encode($a_vectt);
                        exit;
                    }

                    ##########################
                    $Last_id = $db->Insert_ID();
                    ##########################

                    $SQL = 'SELECT * FROM AsociacionSolicitud WHERE SolicitudAsignacionEspaciosId="' . $Last_id . '"';

                    if ($Valida = &$db->Execute($SQL) === false) {
                        echo 'Error en el SQL de la Validacion ....<br><br>' . $SQL;
                        die;
                    }

                    if ($Valida->EOF) {
                        $SQL_InsertAsociacion = 'INSERT INTO AsociacionSolicitud(SolicitudPadreId,SolicitudAsignacionEspaciosId)VALUES("' . $SolicituPadre . '","' . $Last_id . '")';
                        if ($InsertAsociacion = &$db->Execute($SQL_InsertAsociacion) === false) {
                            echo 'Error en el SQL de la Asociacion....<br><br>' . $SQL_InsertAsociacion;
                            die;
                        }
                    }

                    for ($G = 0; $G < count($Grupo_id); $G++) {

                        $InserGrupo = 'INSERT INTO SolicitudEspacioGrupos(SolicitudAsignacionEspacioId,idgrupo)VALUES("' . $Last_id . '","' . $Grupo_id[$G] . '")';

                        if ($GrupoSolicitud = &$db->Execute($InserGrupo) === false) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Error al Insertar Solicitud Grupo..';
                            echo json_encode($a_vectt);
                            exit;
                        }
                    }

                    $TipoSalon = $_POST['TipoSalon_' . $Q][$T];

                    $SQL_TipoSalon = 'INSERT INTO SolicitudAsignacionEspaciostiposalon(SolicitudAsignacionEspacioId,codigotiposalon)VALUES("' . $Last_id . '","' . $TipoSalon . '")';

                    if ($SolicitudTipoSalon = &$db->Execute($SQL_TipoSalon) === false) {
                        $a_vectt['val'] = false;
                        $a_vectt['descrip'] = 'Debe seleccionar el Tipo Salon segun el Dia Inidcado..';
                        echo json_encode($a_vectt);
                        exit;
                    }

                    for ($x = 0; $x < count($Info[$DiaSemana[$i]]); $x++) {
                        $FechaFutura_1 = $Info[$DiaSemana[$i]][$x][0];
                        $FechaFutura_2 = $Info[$DiaSemana[$i]][$x][1];

                        $C_FechaData_1 = explode(' ', $FechaFutura_1);
                        $C_FechaData_2 = explode(' ', $FechaFutura_2);

                        $C_DatosDia = explode('-', $C_FechaData_1[0]);

                        $dia = $C_DatosDia[2];
                        $mes = $C_DatosDia[1];

                        $Fecha = $C_FechaData_1[0];
                        $Hora_1 = $_POST['HoraInicial_' . $Q][$T];
                        $Hora_2 = $_POST['HoraFin_' . $Q][$T];

                        $SQL_Asignacion = 'SELECT
                                        AsignacionEspaciosId
                                        FROM AsignacionEspacios
                                        WHERE FechaAsignacion="' . $Fecha . '"
                                        AND SolicitudAsignacionEspacioId="' . $Last_id . '"
                                        AND codigoestado=100
                                        AND HoraInicio="' . $Hora_1 . '"
                                        AND HoraFin="' . $Hora_2 . '"';

                        if ($ConsultaAsignacion = &$db->Execute($SQL_Asignacion) === false) {
                            echo 'Error en el SQL de la Asignacion valida....<br><br>' . $SQL_Asignacion;
                            die;
                        }

                        if ($ConsultaAsignacion->EOF) {
                            $Asignacion = 'INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("' . $Fecha . '","' . $Last_id . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"212","' . $Hora_1 . '","' . $Hora_2 . '")';
                            if ($InsertAsignar = &$db->Execute($Asignacion) === false) {
                                $a_vectt['val'] = false;
                                $a_vectt['descrip'] = 'Error al Insertar Asignacion del Espacio..';
                                echo json_encode($a_vectt);
                                exit;
                            }
                        }
                    }
                }
            }

            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se ha Creado la Solicitud Correctamente...';
            $a_vectt['Soli_id'] = $SolicituPadre;
            echo json_encode($a_vectt);
            exit;
        }break;
    default: {
            global $C_InterfazSolicitud, $C_SolicitudExterna, $userid, $db;
            define(AJAX, false);
            MainGeneral();
            JsGeneral();
            $C_SolicitudExterna->Principal($db, $C_InterfazSolicitud);
        }break;
}

function MainGeneral() {
    global $C_InterfazSolicitud, $C_SolicitudExterna, $userid, $db;
    include("../templates/template.php");
    if (AJAX == false) {
        $db = writeHeader('Interfaz Solicitud Externa', true);
    } else {
        $db = getBD();
    }
    include('InterfazSolicitud_class.php');
    $C_InterfazSolicitud = new InterfazSolicitud();
    include('SolicitudExterna_class.php');
    $C_SolicitudExterna = new InterfazSolicitudExterna();
    $SQL_User = 'SELECT idusuario as id FROM usuario WHERE usuario="' . $_SESSION['MM_Username'] . '"';
    if ($Usario_id = &$db->Execute($SQL_User) === false) {
        echo 'Error en el SQL Userid...<br>' . $SQL_User;
        die;
    }
    $userid = $Usario_id->fields['id'];
}

function MainJson() {
    global $userid, $db;
    include("../templates/template.php");
    $db = getBD();
    $SQL_User = 'SELECT idusuario as id FROM usuario WHERE usuario="' . $_SESSION['MM_Username'] . '"';
    if ($Usario_id = &$db->Execute($SQL_User) === false) {
        echo 'Error en el SQL Userid...<br>' . $SQL_User;
        die;
    }
    $userid = $Usario_id->fields['id'];
}

function JsGeneral() {
    ?>
    <link rel="stylesheet" href="../css/jquery.clockpick.1.2.9.css" type="text/css" /> 
    <link rel="stylesheet" href="../css/Styleventana.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../asignacionSalones/css/jquery.datetimepicker.css"/>
    <script type="text/javascript" src="../asignacionSalones/js/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="../../mgi/js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>

    <script type="text/javascript" language="javascript" src="InterfazSolicitud.js"></script>
    <script type="text/javascript" language="javascript" src="SolicitudExterna.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.bpopup.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.min.js"></script>
    <!--------------------Js Para Alert Diseño JAlert----------------------->
    <script type="text/javascript" language="javascript" src="../js/JalertQuery/jquery.alerts.js"></script>
    <link rel="stylesheet" href="../js/JalertQuery/jquery.alerts.css" type="text/css" />
    <script>
        $('#ui-datepicker-div').css('display', 'none');
        $('#BBIT_DP_CONTAINER').css('display', 'none');
    </script>
    <?PHP
}
?>