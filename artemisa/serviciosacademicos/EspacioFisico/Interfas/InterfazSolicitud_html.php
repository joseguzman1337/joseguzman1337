<?PHP

session_start();
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
if(!isset($_REQUEST['actionID']) || empty($_REQUEST['actionID'])) {
    $_REQUEST['actionID'] = "";
}

switch ($_REQUEST['actionID']) {
    case 'TipoNumber':       
         {
            $numero = $_POST['Numero'];
            $mod = $_POST['mod'];
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();

            $Valor = $C_InterfazSolicitud->ColorPeriodo($db, $numero, $mod);
            
            $a_vectt['val'] = true;
            $a_vectt['num'] = $Valor;
            echo json_encode($a_vectt);
            exit;
        } 
        break;
    case 'ValidafechaActivaCheked':
        {
            include_once('../Solicitud/AsignacionSalon.php');
            $C_Solicitud = new AsignacionSalon();

            $fechaIni = explode('-', $_POST['fechaIni']);
            $fechaFin = explode('-', $_POST['fechaFin']);

            if ($fechaIni[2] == $fechaFin[2]) {//año
                if ($fechaIni[1] == $fechaFin[1]) {//mes
                    if ($fechaIni[0] == $fechaFin[0]) {//dia
                        $CodigoDiaNew = $C_Solicitud->DiasSemana($_POST['fechaIni'], 'Codigo');

                        $a_vectt['val'] = true;
                        $a_vectt['dia'] = $CodigoDiaNew;
                        echo json_encode($a_vectt);
                        exit;
                    }
                }
            }
            $a_vectt['val'] = false;
            echo json_encode($a_vectt);
            exit;
        }
        break;
    case 'AvilitarODesactivar':
        {
            global $db, $userid;
            MainJson();

            $id = str_replace('row_', '', $_POST['id']);

            $SQL = 'SELECT
        codigoestado
        FROM
        ClasificacionEspacios                
        WHERE
        ClasificacionEspaciosId="' . $id . '"';

            if ($EstadoNow =& $db->Execute($SQL) === false) {
                echo 'Error en el SQL del Estado Actual...<br><br>' . $SQL;
                die;
            }

            if ($EstadoNow->fields['codigoestado'] == 100) {
                $Estado = 200;
            } else {
                $Estado = 100;
            }

            $SQL = 'UPDATE ClasificacionEspacios
     SET    codigoestado="' . $Estado . '",
            UsuarioUltimaModificacion="' . $userid . '",
            FechaUltimaModificacion=NOW()             
     WHERE  ClasificacionEspaciosId="' . $id . '"';

            if ($CambioEstado =& $db->Execute($SQL) === false) {
                echo 'Error Al CAmbiar El Estado <br><br>' . $SQL;
                die;
            }

            $a_vectt['val'] = true;
            if ($Estado == 100) {
                $a_vectt['descrip'] = 'Estado Nuevo Habilitado';
            } else {
                $a_vectt['descrip'] = 'Estado Nuevo Deshabilitado';
            }
            echo json_encode($a_vectt);
            exit;

        }
        break;
    case 'UpdateObservacion':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();

            $id_Soli = $_POST['id_Soli'];
            $Observaciones = $_POST['Observaciones'];

            $Data = $C_InterfazSolicitud->DataAsignacion($db, $id_Soli);

            for ($i = 0; $i < count($Data); $i++) {

                $id = $Data[$i][0]['Solicitud_id'];

                $SQL = 'UPDATE SolicitudAsignacionEspacios
           SET    observaciones="' . $Observaciones . '",
                  UsuarioUltimaModificacion="' . $userid . '",
                  FechaUltimaModificacion=NOW()
           WHERE  SolicitudAsignacionEspacioId="' . $id . '"';

                if ($Num_UP =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Modificar Observacion';
                    echo json_encode($a_vectt);
                    exit;
                }

            }//for

            $a_vectt['val'] = true;
            //$a_vectt['descrip']		  ='Error al Modificar Numero de Asitentes';
            echo json_encode($a_vectt);
            exit;
        }
        break;
    case 'UpdateNumAsistentes':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();

            $id_Soli = $_POST['id_Soli'];
            $Num = $_POST['Num'];

            $Data = $C_InterfazSolicitud->DataAsignacion($db, $id_Soli);

            for ($i = 0; $i < count($Data); $i++) {

                $id = $Data[$i][0]['Solicitud_id'];

                $SQL = 'UPDATE SolicitudAsignacionEspacios
           SET    NumAsistentes="' . $Num . '",
                  UsuarioUltimaModificacion="' . $userid . '",
                  FechaUltimaModificacion=NOW()  
           WHERE  SolicitudAsignacionEspacioId="' . $id . '"';

                if ($Num_UP =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Modificar Numero de Asitentes';
                    echo json_encode($a_vectt);
                    exit;
                }

            }//for

            $a_vectt['val'] = true;
            //$a_vectt['descrip']		  ='Error al Modificar Numero de Asitentes';
            echo json_encode($a_vectt);
            exit;
        }
        break;
    case 'AsignarMultiple':
        {
            global $db, $userid;
            MainJson();
            include_once('../Solicitud/AsignacionSalon.php');
            $C_AsignacionSalon = new AsignacionSalon();
            $id = $_POST['id'];
            $C_Asig_id = explode('::', $_POST['Asig_id']);

            $Verificar = 0;

            for ($i = 1; $i < count($C_Asig_id); $i++) {

                $SQL = 'SELECT
            AsignacionEspaciosId as id,
            FechaAsignacion,
            HoraInicio,
            HoraFin,
            SolicitudAsignacionEspacioId
            FROM
            AsignacionEspacios
            WHERE
            AsignacionEspaciosId = "' . $C_Asig_id[$i] . '"
            AND codigoestado = 100
            AND EstadoAsignacionEspacio = 1
            AND ClasificacionEspaciosId = 212';

                if ($Dato =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Buscar Datos de La fecha a Asignar....';
                    echo json_encode($a_vectt);
                    exit;
                }

                $Solicitud_id = $Dato->fields['SolicitudAsignacionEspacioId'];

                if (!$Dato->EOF) {

                    $fecha = $Dato->fields['FechaAsignacion'];
                    $hora_1 = $Dato->fields['HoraInicio'];
                    $hora_2 = $Dato->fields['HoraFin'];
                    $Fecha_horaIni = $fecha . ' ' . $hora_1;
                    $fecha_horaFin = $fecha . ' ' . $hora_2;

                    $SQL = 'SELECT
                            x.ClasificacionEspaciosId AS id, 
                            x.ClasificacionEspacionPadreId,
                            x.CapacidadEstudiantes
                    FROM 
                            ClasificacionEspacios x INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=x.EspaciosFisicosId
                                                    INNER JOIN DetalleClasificacionEspacios D ON D.ClasificacionEspaciosId=x.ClasificacionEspaciosId
                                                   
                    WHERE x.ClasificacionEspaciosId not in (
                            SELECT 
                                eventos.ClasificacionEspaciosId 
                            FROM (
                                    SELECT
                                        a.AsignacionEspaciosId,
                                        a.FechaAsignacion AS fecha,
                                        a.HoraInicio AS horainicio,
                                        a.HoraFin AS horafinal,
                                        c.ClasificacionEspaciosId,
                                        c.Nombre AS Salon
                                    FROM
                                        AsignacionEspacios a
                                    INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                    INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
                                    WHERE
                                        a.FechaAsignacion = "' . $fecha . '"
                                    AND a.HoraInicio <>"' . $hora_2 . '"
                                    AND a.HoraFin<> "' . $hora_1 . '"
                                    AND a.codigoestado = 100
                                    AND "' . $Fecha_horaIni . '" <> CONCAT(a.FechaAsignacion," ",a.HoraFin)
                                    AND "' . $fecha_horaFin . '" <> CONCAT(a.FechaAsignacion," ",a.HoraInicio)
                                    AND (("' . $Fecha_horaIni . '" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                    OR ("' . $fecha_horaFin . '" BETWEEN CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME)
                                    AND CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME))  
                                    OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraInicio) AS DATETIME) BETWEEN "' . $Fecha_horaIni . '"  AND "' . $fecha_horaFin . '") 
                                    OR (CAST(CONCAT(a.FechaAsignacion," ",a.HoraFin) AS DATETIME) BETWEEN "' . $Fecha_horaIni . '" AND "' . $fecha_horaFin . '"))   
                                    
                                    ) eventos
                                    WHERE 
                                        "' . $Fecha_horaIni . '" <> CONCAT(fecha," ",horafinal) 
                                        AND 
                                        "' . $fecha_horaFin . '" <> CONCAT(fecha," ",horainicio) 
                                        AND (
                                    ("' . $Fecha_horaIni . '" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) AND CAST(CONCAT(fecha," ",horafinal) AS DATETIME)) 
                                    OR ("' . $fecha_horaFin . '" BETWEEN CAST(CONCAT(fecha," ",horainicio) AS DATETIME) and CAST(CONCAT(fecha," ",horafinal) AS DATETIME) )
                                    OR  (CAST(CONCAT(fecha," ",horainicio) AS DATETIME)  BETWEEN "' . $Fecha_horaIni . '"  AND "' . $fecha_horaFin . '"  ) 
                                    OR (CAST(CONCAT(fecha," ",horafinal) AS DATETIME)  BETWEEN "' . $Fecha_horaIni . '"  AND "' . $fecha_horaFin . '"  )
                             )
                    ) 
                    AND
                    e.PermitirAsignacion=1
                    AND 
                    "' . $fecha . '" BETWEEN D.FechaInicioVigencia and D.FechaFinVigencia
                    AND  x.ClasificacionEspaciosId="' . $id . '"';

                    //echo '<br><br> Otro tipo...<br><br>'.$SQL.'<br>';

                    if ($AulasMax =& $db->Execute($SQL) === false) {
                        $a_vectt['val'] = false;
                        $a_vectt['descrip'] = 'Error en el SQL Disponibilida de Espacios Multiple';
                        echo json_encode($a_vectt);
                        exit;

                    }

                    if (!$AulasMax->EOF) {

                        $C_AsignacionSalon->InsertAula($db, $C_Asig_id[$i], $id);
                        $Verificar = 1;
                    }
                }

            }//for

            $a_vectt['val'] = true;
            if ($Verificar == 1) {
                $a_vectt['descrip'] = 'Ha terminado la Asignación';
            } else {
                $a_vectt['descrip'] = 'No Se Realizo la Asignación';
            }

            $a_vectt['Solicitud'] = $Solicitud_id;
            echo json_encode($a_vectt);
            exit;

        }
        break;
    case 'BuscarDisponibilidadMultiple':
        {

            $AsigGrupo = $_POST['AsigGrupo'];
            $Cupo = $_POST['Cupo'];
            $Campus = $_POST['Campus'];
            $idSoli = $_POST['idSoli'];
            $S_Hijo = $_POST['S_Hijo'];

            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();
            //echo 's_h->'.$S_Hijo.'<br>S_p->'.$idSoli;
            $Data = $C_InterfazSolicitud->UsuarioMenu($db, $userid);

            $RolEspacioFisico = $Data['Data'][0]['RolEspacioFisicoId'];

            $C_InterfazSolicitud->VerSalones($db, $Cupo, $Campus, $AsigGrupo, $idSoli, $S_Hijo, $userid, $RolEspacioFisico);

        }
        break;
    case 'ValidaGrupoAdd':
        {
            $MultiGrupoMateria = $_POST['MultiGrupoMateria'];
            $id = $_POST['id'];

            $Data = explode('::', $MultiGrupoMateria);

            for ($i = 1; $i < count($Data); $i++) {
                if ($id == $Data[$i]) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'El Grupo Adicionar o Selecionado ya esta en la Lista...';
                    echo json_encode($a_vectt);
                    exit;
                }
            }//for

            $a_vectt['val'] = true;
            echo json_encode($a_vectt);
            exit;
        }
        break;
    case 'ViewMultiGrupoMateria':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();

            $MultiGrupoMateria = $_POST['MultiGrupoMateria'];

            $C_InterfazSolicitud->MultiGrupoMateria($db, $MultiGrupoMateria);
        }
        break;
    case 'DataResumen':
        {

            $Acceso = $_POST['Acceso'];
            $Max = $_POST['NumEstudiantes'];
            $n = $_POST['i'];
            $j = $_POST['j'];
            $TipoSalon = $_POST['TipoSalon_' . $n][0];
            $Sede = $_POST['Campus_' . $n][0];
            $Feha_inicial = $_POST['FechaAsignacion_' . $n][$j];
            $Feha_final = $_POST['FechaAsignacion_' . $n][$j];
            $Hora_ini = $_POST['HoraInicial_' . $n][$j];
            $Hora_fin = $_POST['HoraFin_' . $n][$j];
            $Asignacio_id = $_POST['idAsignacion_' . $n . '_' . $j][0];
            $id_Soli = $_POST['id_Soli'];


            $a_vectt['val'] = true;
            $a_vectt['TipoSalon'] = $TipoSalon;
            $a_vectt['Acceso'] = $Acceso;
            $a_vectt['NumEstudiantes'] = $Max;
            $a_vectt['Campus'] = $Sede;
            $a_vectt['FechaAsignacion'] = $Feha_inicial;
            $a_vectt['HoraInicial'] = $Hora_ini;
            $a_vectt['HoraFin'] = $Hora_fin;
            $a_vectt['idAsignacion'] = $Asignacio_id;
            $a_vectt['id_Soli'] = $id_Soli;
            echo json_encode($a_vectt);
            exit;
        }
        break;
    case 'ModificarUnicoLog':
        {
            include_once('../Notificaciones/NotificacionEspaciosFisicos_class.php');
            $C_Notificaciones = new NotificacionEspaciosFisicos();
            include_once('../Notificaciones/ConsolaNotificaciones_View.php');
            $V_ConsolaNotificaciones = new ViewConsolaNotificaciones();
            include_once('../Solicitud/AsignacionSalon.php');
            $C_Solicitud = new AsignacionSalon();
            global $db, $userid;
            MainJson();

            $idAsignacion = $_POST['idAsignacion'];
            $FechaAsignacion = $_POST['FechaAsignacion'];
            $HoraInicial = $_POST['HoraInicial'];
            $HoraFin = $_POST['HoraFin'];
            $FechaAsignacion_Old = $_POST['FechaAsignacion_Old'];

            //echo '<pre>';print_r($_POST);die;

            $fechadb = $FechaAsignacion;
            $tmp = explode('-', $fechadb);
            $Fecha_Envia = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            $fecha = date('Y-m-d');
            $tmp = explode('-', $fecha);
            $Hoy = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            // Compara ahora que las fechas son enteror
            if ($Hoy > $Fecha_Envia) {

                $a_vectt['val'] = 'ErrorFecha';
                echo json_encode($a_vectt);
                exit;

            }


            $Up_Asignacion = 'UPDATE  AsignacionEspacios
                
                SET     FechaAsignacion="' . $FechaAsignacion . '",
                        UsuarioUltimaModificacion="' . $userid . '",
                        FechaultimaModificacion=NOW(),
                        ClasificacionEspaciosId=212,
                        HoraInicio="' . $HoraInicial . '",
                        HoraFin="' . $HoraFin . '",
                        EstadoAsignacionEspacio=1,
                        Modificado=1,
                        UsuarioUltimaModificacion="' . $userid . '",
                        FechaUltimaModificacion=NOW(),
                        FechaAsignacionAntigua="' . $FechaAsignacion_Old . '",
                        Enviado=0
                        
               WHERE    AsignacionEspaciosId="' . $idAsignacion . '" AND codigoestado=100';

            if ($ModificaLog =& $db->Execute($Up_Asignacion) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error en el Modificar del Log...';
                echo json_encode($a_vectt);
                exit;
            }


            $SQL = 'SELECT
            SolicitudAsignacionEspacioId AS id
        FROM
            AsignacionEspacios
        WHERE
        
        AsignacionEspaciosId="' . $idAsignacion . '"';


            if ($Solicitud =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar la Solicit de la Asignacion Eliminada....';
                echo json_encode($a_vectt);
                exit;
            }

            $id = $Solicitud->fields['id'];

            $SQL = 'SELECT
            COUNT(AsignacionEspaciosId) as num
            FROM
            AsignacionEspacios
            WHERE
            SolicitudAsignacionEspacioId="' . $id . '"';

            if ($NumData =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error En El Sisitema...1';
                echo json_encode($a_vectt);
                exit;
            }

            if ($NumData->fields['num'] == '1' || $NumData->fields['num'] == 1) {

                $CodigoDiaNew = $C_Solicitud->DiasSemana($FechaAsignacion, 'Codigo');

                $SQL_Update = 'UPDATE  SolicitudAsignacionEspacios
                        SET     codigodia="' . $CodigoDiaNew . '",
                                FechaInicio="' . $FechaAsignacion . '",
                                FechaFinal="' . $FechaAsignacion . '",
                                FechaUltimaModificacion=NOW(),
                                UsuarioUltimaModificacion="' . $userid . '"
                        WHERE 
                        SolicitudAsignacionEspacioId="' . $id . '" AND codigoestado=100';

                if ($UpdateDiaData =& $db->Execute($SQL_Update) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error En El Sisitema...2';
                    echo json_encode($a_vectt);
                    exit;
                }
            }

            $SQL = 'SELECT
        codigomodalidadacademica
        FROM
        AsignacionEspacios  a INNER JOIN SolicitudAsignacionEspacios  s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
        WHERE
        a.AsignacionEspaciosId="' . $idAsignacion . '"
        and
        s.codigomodalidadacademica=001';

            if ($TipoSolicitud =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error En el sistema....';
                echo json_encode($a_vectt);
                exit;
            }

            if (!$TipoSolicitud->EOF) {

                if ($FechaAsignacion_Old == date('Y-m-d')) {

                    $C_Data = $C_Notificaciones->AlumnosSolicitudCambio($db, $id);


                    $ID_Cambio = array();
                    $EnvarCambio = 0;
                    for ($i = 0; $i < count($C_Data); $i++) {

                        $CodigoEstudiante = $C_Data[$i]['codigoestudiante'];
                        $FulName = $C_Data[$i]['FulName'];
                        $Correo = $C_Data[$i]['Correo'];

                        $C_Info = $C_Notificaciones->InformacionCambioEstudiante($db, $id, $CodigoEstudiante);


                        if ($C_Info[0]['Tittle']) {
                            $ID_Cambio[$id][] = $C_Info[0]['AsignacionEspaciosId'];
                            $Mensaje = '<table border=2>
                            <tr>
                                <th colspan="2">' . $FulName . '</th>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;&nbsp;</td>    
                            </tr>
                            <tr>
                                <td>Notificaci&oacute;n</td>
                                <td>' . $C_Info[0]['Tittle'] . '</td>
                            </tr>
                            <tr>
                                <td>Materia</td>
                                <td>' . $C_Info[0]['nombremateria'] . '</td>
                            </tr>
                            <tr>
                                <td>Grupo</td>
                                <td>' . $C_Info[0]['nombregrupo'] . '&nbsp;::&nbsp;' . $C_Info[0]['idgrupo'] . '</td>
                            </tr>';
                            if ($C_Info[0]['FechaAsignacion'] == $C_Info[0]['FechaAsignacionAntigua']) {
                                $Mensaje = $Mensaje . '<tr>
                                                <td>Fecha</td>
                                                <td>' . $C_Info[0]['FechaAsignacion'] . '</td>
                                            </tr>';
                            } else {
                                $Mensaje = $Mensaje . '<tr>
                                                <td>Fecha Anterior</td>
                                                <td>' . $C_Info[0]['FechaAsignacionAntigua'] . '</td>
                                            </tr>
                                            <tr>
                                                <td>Fecha Nueva</td>
                                                <td>' . $C_Info[0]['FechaAsignacion'] . '</td>
                                            </tr>';
                            }


                            $Mensaje = $Mensaje . '<tr>
                                <td>Hora de Inicio</td>
                                <td>' . $C_Info[0]['HoraInicio'] . '</td>
                            </tr>
                            <tr>
                                <td>Hora Final</td>
                                <td>' . $C_Info[0]['HoraFin'] . '</td>
                            </tr>
                            <tr>
                                <td>Lugar</td>
                                <td>' . $C_Info[0]['Nombre'] . '</td>
                            </tr>
                        </table>
                        <br><br>
                        Nota : <br> Si no tiene lugar asignado, se le notificar&aacute; posteriormente o comuniquese con su Facultad.';

                            // echo '<br><br>'.$Mensaje;

                            $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                            // echo '<br><br>'.$Mensaje;
                            $tittle = $C_Info[0]['Tittle'] . ' DE ' . $C_Info[0]['nombremateria'];

                            $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $Mensaje, true);

                            if ($Resultado['succes'] === true) {
                                $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 1);
                            } else {
                                $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 0);
                            }

                            $EnvarCambio = 1;

                        } else {

                            $C_Info = $C_Notificaciones->InformacionCambioEstudiante($db, $Solicitud->fields['id'], $CodigoEstudiante, 1, 1);


                            if ($C_Info[0]['Tiempo'] >= '18:00:00') {

                                $Mensaje = $V_ConsolaNotificaciones->Mensaje($C_Info, $FulName);

                                $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                                //echo '<br><br>'.$Mensaje;
                                $tittle = 'Cambios De Aula o Camcelaci&oacute;n de Clase';

                                $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $Mensaje, true);

                                if ($Resultado['succes'] === true) {
                                    $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 1);
                                } else {
                                    $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 0);
                                }

                                $EnvarCambio = 1;

                            }


                            for ($x = 0; $x < count($C_Info); $x++) {
                                $ID_Cambio[$id][] = $C_Info[$x]['AsignacionEspaciosId'];
                            }//for

                        }
                        // echo '<pre>';print_r($Resultado);

                    }//for

                } else {

                    $C_Data = $C_Notificaciones->AlumnosSolicitudCambio($db, $id);

                    $ID_Cambio = array();
                    $EnvarCambio = 0;
                    for ($i = 0; $i < count($C_Data); $i++) {

                        $CodigoEstudiante = $C_Data[$i]['codigoestudiante'];
                        $FulName = $C_Data[$i]['FulName'];
                        $Correo = $C_Data[$i]['Correo'];


                        $C_Info = $C_Notificaciones->InformacionCambioEstudiante($db, $id, $CodigoEstudiante, 1, 1);

                        // echo '<pre>';print_r($C_Info);die;

                        if ($C_Info[0]['Tiempo'] >= '18:00:00') {

                            $Mensaje = $V_ConsolaNotificaciones->Mensaje($C_Info, $FulName);

                            $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                            //echo '<br><br>'.$Mensaje;
                            $tittle = 'Cambios De Aula o Camcelaci&oacute;n de Clase';

                            $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $Mensaje, true);

                            if ($Resultado['succes'] === true) {
                                $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 1);
                            } else {
                                $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 0);
                            }

                            $EnvarCambio = 1;

                        }

                        for ($x = 0; $x < count($C_Info); $x++) {
                            $ID_Cambio[$id][] = $C_Info[$x]['AsignacionEspaciosId'];
                        }//for

                    }//for
                }

                if ($EnvarCambio == 1) {
                    $C_Notificaciones->CambiarAEnviado($db, $id, $ID_Cambio);
                }

            } else {
                $SQL = 'SELECT
           s.Email, s.Responsable, s.NombreEvento, a.FechaAsignacion, a.HoraInicio, a.HoraFin
           FROM
            AsignacionEspacios  a INNER JOIN SolicitudAsignacionEspacios  s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
        WHERE
        a.AsignacionEspaciosId="' . $idAsignacion . '"';

                if ($SolicitudExterna =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error En el sistema....';
                    echo json_encode($a_vectt);
                    exit;
                }


                $MensajeExterno = '<table border=2>
                            <tr>
                                <td colspan=2>Modificación de Evento ó Clase Programada</td>
                            </tr>
                            <tr>
                            <td colspan=2>
                               
                            </td>
                            </tr>
                            <tr>
                                <td>Responsable</td>
                                <td>' . $SolicitudExterna->fields['Responsable'] . '</td>
                            </tr>
                            <tr>
                                <td>Evento</td>
                                <td>' . $SolicitudExterna->fields['NombreEvento'] . '</td>
                            </tr>';
                $MensajeExterno = $MensajeExterno . '<tr>
                            <td>Fecha</td>
                            <td>' . $SolicitudExterna->fields['FechaAsignacion'] . '</td>
                        </tr>';


                $MensajeExterno = $MensajeExterno . '<tr>
                                <td>Hora de Inicio</td>
                                <td>' . $SolicitudExterna->fields['HoraInicio'] . '</td>
                            </tr>
                            <tr>
                                <td>Hora Final</td>
                                <td>' . $SolicitudExterna->fields['HoraFin'] . '</td>
                            </tr>
                        </table>
                        <br><br>';


                $to = $SolicitudExterna->fields['Email'];//'ramirezmarcos@unbosque.edu.co';//
                // echo '<br><br>'.$Mensaje;
                $tittle = 'Notificación de Cancelación de Clase';

                $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $MensajeExterno, true);
            }


            $SQL = 'SELECT
                SolicitudPadreId
            FROM
                AsociacionSolicitud
            
            WHERE
            SolicitudAsignacionEspaciosId="' . $id . '"';


            if ($SolicitudPadre =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar la Solicit de la Asignacion Eliminada....';
                echo json_encode($a_vectt);
                exit;
            }


            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se Modifico Correctamente...';
            $a_vectt['idSolicituid'] = $SolicitudPadre->fields['SolicitudPadreId'];
            echo json_encode($a_vectt);
            exit;

        }
        break;
    case 'ValidarFechaMenor':
        {
            $fechadb = $_POST['fecha'];
            $tmp = explode('-', $fechadb);
            $Fecha_Envia = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            $fecha = date('Y-m-d');
            $tmp = explode('-', $fecha);
            $Hoy = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            // Compara ahora que las fechas son enteror
            if ($Hoy > $Fecha_Envia) {

                $a_vectt['val'] = true;
                echo json_encode($a_vectt);
                exit;

            } else {

                $a_vectt['val'] = false;
                echo json_encode($a_vectt);
                exit;

            }
        }
        break;
    case 'VerHorario':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();

            $id_grupo = $_REQUEST['id'];

            $C_InterfazSolicitud->VerHorarioOld($db, $id_grupo);
        }
        break;
    case 'AddTr':
        { //echo 'por aca...';die;
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();

            $C_InterfazSolicitud->AddTrNew($db, $_POST['NumFiles']);
        }
        break;
    case 'ValidarEditar':
        {
            global $db, $userid;
            MainJson();

            $id = $_POST['id'];

            $SQL = 'SELECT
                    s.SolicitudAsignacionEspacioId AS id,
                    s.Estatus
            FROM
                    SolicitudPadre sp   INNER JOIN AsociacionSolicitud aso ON sp.SolicitudPadreId=aso.SolicitudPadreId
                                        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=aso.SolicitudAsignacionEspaciosId
                                        INNER JOIN siq_periodicidad p ON p.idsiq_periodicidad = s.idsiq_periodicidad
                                        INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = s.ClasificacionEspaciosId
                                        INNER JOIN dia d ON d.codigodia = s.codigodia
                                        INNER JOIN SolicitudEspacioGrupos sg ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                                        INNER JOIN grupo g ON g.idgrupo = sg.idgrupo
                                        INNER JOIN materia m ON m.codigomateria = g.codigomateria
                                        INNER JOIN carrera ca ON ca.codigocarrera = m.codigocarrera
                                        INNER JOIN modalidadacademica md ON md.codigomodalidadacademica=ca.codigomodalidadacademica
                                        INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                                        INNER JOIN tiposalon t ON t.codigotiposalon=st.codigotiposalon
            WHERE
                    s.codigoestado = 100
                    AND p.codigoestado = 100
                    AND sp.SolicitudPadreId = "' . $id . '"';
            if ($SolicitudEstado =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error en el SQL de la Validacion del estado de la Solicitud...<br>' . $SQL;
                echo json_encode($a_vectt);
                exit;
            }

            if (!$SolicitudEstado->EOF) {
                $a_vectt['val'] = true;
                $a_vectt['Estatus'] = $SolicitudEstado->fields['Estatus'];
                echo json_encode($a_vectt);
                exit;
            } else {
                $a_vectt['val'] = true;
                $a_vectt['Estatus'] = 'Externa';
                echo json_encode($a_vectt);
                exit;
            }


        }
        break;
    case 'ModificarSolicitud':
        {
            global $db, $userid;
            MainJson();
            //echo '<pre>';print_r($_POST);/**********Aca*************/
            //var_dump(is_file('../Solicitud/AsignacionSalon.php'));die;
            include_once('../Solicitud/AsignacionSalon.php');
            include_once('../Solicitud/festivos.php');
            include_once('ValidaSolicitud_Class.php');

            $C_Festivo = new festivos();
            $C_AsignacionSalon = new AsignacionSalon();
            $C_ValidaSolicitud = new ValidaSolicitud();


            $Solicitud_id = $_POST['Solicitud_id'];
            $GruposEliminar = $_POST['GruposEliminar'];

            $C_GruposEliminar = explode('::', $GruposEliminar);

            $Grupo_id = $_POST['GrupoText'];
            $Acceso = $_POST['Acceso'];
            $TipoSalon = $_POST['TipoSalon'];
            $FechaUnica = $_POST['FechaUnica'];
            $Observacion = $_POST['Observacion'];
            $Carrera = $_POST['Programa'];
            if ($Acceso) {
                $Acceso = 1;
            } else {
                $Acceso = 0;
            }


            $Fecha_1 = $_POST['FechaIni'];
            $Fecha_2 = $_POST['FechaFin'];
            $FechaIni_OLD = $_POST['FechaIni_OLD'];

            $Data = $_POST;

            $Info = $C_AsignacionSalon->DisponibilidadMultipleSolicitud($db, $Data, 'arreglo', '../');

            $InfoNew = $C_AsignacionSalon->DisponibilidadMultiple($db, $Data, 'arreglo', '../');


            $FechaIni = $_POST['FechaIni'];
            $FechaFin = $_POST['FechaFin'];
            $CodigoDia = $_POST['DiaSemana'];
            $numIndices = $_POST['numIndices'];
            $Sede = $_POST['Campus'];

            $fechadb = $FechaIni;
            $tmp = explode('-', $fechadb);
            $Fecha_Envia = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            //$fecha = date('Y-m-d');
            $tmp = explode('-', $FechaIni_OLD);
            $Hoy = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
            // Compara ahora que las fechas son enteror
            if ($Hoy > $Fecha_Envia) {

                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'La fecha Inicial Es Menor que la fecha inicial Anterior...';
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

            for ($d = 0; $d < count($CodigoDia); $d++) {
                if ($d == 0) {
                    $Condicion_Dias = '"' . $CodigoDia[$d] . '"';
                } else {
                    if(!isset($Condicion_Dias)){
                        $Condicion_Dias = "";
                    }
                    $Condicion_Dias = $Condicion_Dias . ',"' . $CodigoDia[$d] . '"';
                }

            }
            $Limit = Count($CodigoDia) - 1;


            $Fecha_inicial = $FechaIni;
            $Fecha_final = $FechaFin;

            $ValidacionHorario = $C_ValidaSolicitud->ValidaHorario($db, $Grupo_id, $Info, $CodigoDia, $Limit, $Data);

            // echo '<pre>';print_r($ValidacionHorario);die;
            if ($ValidacionHorario['id_grupo']) {
                $a_vectt['val'] = 'ErrorHorario';
                // echo '<pre>';print_r($ValidacionHorario);
                if ($ValidacionHorario['Data'] == 'Other') {
                    for ($e = 1; $e <= count($ValidacionHorario['id_grupo']); $e++) {
                        for ($w = 0; $w < count($ValidacionHorario['id_grupo'][$e]); $w++) {
                            if ($w == 0) {
                                $Grupos_id_Error = $ValidacionHorario['id_grupo'][$e][$w];
                                $Nombre_Error = $ValidacionHorario['nombregrupo'][$e][$w];
                                $dia_Error = $ValidacionHorario['dia'][$e];
                            } else {
                                $Grupos_id_Error = $Grupos_id_Error . ' :: ' . $ValidacionHorario['id_grupo'][$e][$w];
                                $Nombre_Error = $Nombre_Error . ',' . $ValidacionHorario['nombregrupo'][$e][$w];
                                $dia_Error = $dia_Error . ',' . $ValidacionHorario['dia'][$e];
                            }
                        }
                    }
                } else {
                    for ($e = 0; $e <= count($ValidacionHorario['id_grupo']); $e++) {
                        if ($e == 0) {
                            $Grupos_id_Error = $ValidacionHorario['id_grupo'][$e];
                            $Nombre_Error = $ValidacionHorario['nombregrupo'][$e];
                            $dia_Error = $ValidacionHorario['dia'][$e];
                        } else {
                            $Grupos_id_Error = $Grupos_id_Error . ' :: ' . $ValidacionHorario['id_grupo'][$e];
                            $Nombre_Error = $Nombre_Error . ',' . $ValidacionHorario['nombregrupo'][$e];
                            $dia_Error = $dia_Error . ',' . $ValidacionHorario['dia'][$e];
                        }

                    }//for
                }

                $a_vectt['Mensaje'] = 'Error En o en los horarios de los siguientes grupos y dias...';
                $a_vectt['Mensaje_1'] = $Grupos_id_Error;
                $a_vectt['Mensaje_2'] = $Nombre_Error;
                $a_vectt['Mensaje_3'] = $dia_Error;
                echo json_encode($a_vectt);
                exit;
            }

            /****************************************Si hay Grupos Eliminados***********************************************/

            for ($G = 1; $G < count($C_GruposEliminar); $G++) {

                $SQL = 'SELECT
                s.SolicitudAsignacionEspacioId
            FROM
                SolicitudPadre sp
            INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = sp.SolicitudPadreId
            INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
            WHERE
                sp.CodigoEstado = 100
            AND s.codigoestado = 100
            AND sp.SolicitudPadreId = "' . $Solicitud_id . '"';

                if ($Hijos =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Buscar los Hijos Solicitud...';
                    echo json_encode($a_vectt);
                    exit;
                }

                while (!$Hijos->EOF) {

                    $Hijo_ID = $Hijos->fields['SolicitudAsignacionEspacioId'];

                    $UpdateGrupos = 'UPDATE SolicitudEspacioGrupos
              
                             SET    codigoestado=200
                             
                             WHERE  SolicitudAsignacionEspacioId="' . $Hijo_ID . '" AND idgrupo="' . $C_GruposEliminar[$G] . '"';

                    if ($CancelaGrupos =& $db->Execute($UpdateGrupos) === false) {
                        $a_vectt['val'] = false;
                        $a_vectt['descrip'] = 'Error al Cancelar los Grupos en las Solicitudes...';
                        echo json_encode($a_vectt);
                        exit;
                    }

                    $UpdateAsignacion = 'UPDATE AsignacionEspacios
                                    
                                    SET   ClasificacionEspaciosId=212,
                                          UsuarioUltimaModificacion="' . $userid . '",
                                          FechaultimaModificacion=NOW(),
                                          Enviado=0
                                    
                                    WHERE SolicitudAsignacionEspacioId="' . $Hijo_ID . '"';

                    if ($PierdeAsignacion =& $db->Execute($UpdateAsignacion) === false) {
                        $a_vectt['val'] = false;
                        $a_vectt['descrip'] = 'Error al Modificar Las Asignacion de las Solicitudes...';
                        echo json_encode($a_vectt);
                        exit;
                    }

                    $Hijos->MoveNext();
                }
            }//for Grupos Eliminados

            /*********************Ajuste nuevo************************/
            $SQL = 'SELECT
            s.SolicitudAsignacionEspacioId
        FROM
            SolicitudPadre sp
        INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = sp.SolicitudPadreId
        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
        WHERE
            sp.CodigoEstado = 100
        AND s.codigoestado = 100
        AND sp.SolicitudPadreId = "' . $Solicitud_id . '"';

            if ($Hijos =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar los Hijos Solicitud...';
                echo json_encode($a_vectt);
                exit;
            }
            $Condicion_idSolicitud = '';
            $ii = 0;
            while (!$Hijos->EOF) {

                $Hijo_ID = $Hijos->fields['SolicitudAsignacionEspacioId'];
                if ($Condicion_idSolicitud) {
                    $Condicion_idSolicitud = $Condicion_idSolicitud . ',' . $Hijo_ID;
                } else {
                    $Condicion_idSolicitud = $Hijo_ID;
                }

                $UpdateSolicitud = 'UPDATE SolicitudAsignacionEspacios
          
                           SET    codigoestado=200,
                                  UsuarioUltimaModificacion="' . $userid . '",
                                  FechaUltimaModificacion=NOW()
                     
                          WHERE  SolicitudAsignacionEspacioId = "' . $Hijo_ID . '"';

                /*  if($CancelaSolicitud=&$db->Execute($UpdateSolicitud)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error al Cancelar las Solicitudes...';
            echo json_encode($a_vectt);
            exit;
         }*/

                $UpdateAsignacion = 'UPDATE AsignacionEspacios
                                
                                            SET   codigoestado=200,
                                                  UsuarioUltimaModificacion="' . $userid . '",
                                                  FechaultimaModificacion=NOW(),
                                                  Enviado=0

                                            WHERE SolicitudAsignacionEspacioId = "' . $Hijo_ID . '" AND FechaAsignacion >=CURDATE()';

                /*   if($PierdeAsignacion=&$db->Execute($UpdateAsignacion)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Modificar Las Asignacion de las Solicitudes...';
                echo json_encode($a_vectt);
                exit;
             } */

                for ($d = 0; $d < count($CodigoDia); $d++) {
                    $Hijo_Dia = $_POST['Dia_' . $Hijo_ID];
                    $Hijo_Hora1 = $_POST['HoraInicial_' . $Hijo_ID][0];
                    $Hijo_Hora2 = $_POST['HoraFin_' . $Hijo_ID][0];

                    if ($Hijo_Dia == $CodigoDia[$d]) {

                        /**Codigo Nuevo**/

                        $UpdateSolicitud = 'UPDATE SolicitudAsignacionEspacios
          
                                              SET    codigoestado=100,
                                                         UsuarioUltimaModificacion="' . $userid . '",
                                                         FechaUltimaModificacion=NOW(),
                                                         AccesoDiscapacitados="' . $Acceso . '",
                                                         FechaInicio="' . $Fecha_1 . '",
                                                         FechaFinal="' . $Fecha_2 . '",
                                                         ClasificacionEspaciosId="' . $Sede[$d] . '",
                                                         codigodia="' . $Hijo_Dia . '",
                                                         observaciones="' . $Observacion . '"

                                              WHERE  SolicitudAsignacionEspacioId = "' . $Hijo_ID . '"';

                        $ActivarSolicitud = $db->Execute($UpdateSolicitud);
                        if ($ActivarSolicitud === false) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Error al Activar las Solicitudes...';
                            echo json_encode($a_vectt);
                            exit;
                        }


                        for ($ll = 0; $ll < count($Info[$ii]); $ll++) {

                            $fecha_x = $Info[$ii][$ll];

                            $C_DatosDia = explode('-', $fecha_x);

                            $dia = $C_DatosDia[2];
                            $mes = $C_DatosDia[1];
                            $year = $C_DatosDia[0];

                            $Festivo = $C_Festivo->esFestivo($dia, $mes, $year);
                            $DomingoTrue = $C_AsignacionSalon->DiasSemana($fecha_x);
                            if ($Festivo == false) {//$Festivo No es Festivo
                                if (($DomingoTrue != 7) || ($DomingoTrue != '7')) {
                                    $FechaQuemada = $C_AsignacionSalon->ValidaFechaQuemada($fecha_x);
                                    if ($FechaQuemada == false) {
                                        /**********************************************/
                                        $SQL = ' SELECT
                                                    AsignacionEspaciosId,
                                                    FechaAsignacion,
                                                    codigoestado,
                                                    ClasificacionEspaciosId,
                                                    HoraInicio,
                                                    HoraFin
                                                FROM
                                                    AsignacionEspacios
                                                WHERE
                                                    SolicitudAsignacionEspacioId = "' . $Hijo_ID . '"
                                                    AND
                                                    FechaAsignacion="' . $fecha_x . '"';

                                        $Consulta = $db->Execute($SQL);

                                        if ($Consulta === false) {
                                            echo 'Error en el Sistema.';
                                            die;
                                        }

                                        if (!$Consulta->EOF) {
                                            $SQL_Activa_Actualiza = 'UPDATE  AsignacionEspacios
                                                                                    SET          codigoestado=100,
                                                                                                    UsuarioUltimaModificacion="' . $userid . '",
                                                                                                    FechaultimaModificacion=NOW(),
                                                                                                    FechaAsignacion = "' . $fecha_x . '",
                                                                                                    ClasificacionEspaciosId=212,
                                                                                                    HoraInicio = "' . $Hijo_Hora1 . '",
                                                                                                    HoraFin = "' . $Hijo_Hora2 . '"
                                                                                    WHERE   SolicitudAsignacionEspacioId = "' . $Hijo_ID . '" AND AsignacionEspaciosId="' . $Consulta->fields['AsignacionEspaciosId'] . '"';
                                            $Activa_Actualiza = $db->Execute($SQL_Activa_Actualiza);

                                            if ($Activa_Actualiza === false) {
                                                echo 'Error en el Sistema.';
                                                die;
                                            }

                                        } else {
                                            $Asignacion_nueva = 'INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("' . $fecha_x . '","' . $Hijo_ID . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"212","' . $Hijo_Hora1 . '","' . $Hijo_Hora2 . '")';

                                            $Crear_nueva = $db->Execute($Asignacion_nueva);

                                            if ($Crear_nueva === false) {
                                                echo 'Error en el Sistema.';
                                                die;
                                            }
                                        }//fi

                                        /**********************************************/
                                    }//fecha quemada
                                }//diferente de domingo
                            }//festivo
                        }//for

                        $ii++;
                    }//Dias Iguales
                }//for

                $Hijos->MoveNext();
            }//while

            /********************Cambio de Tipo Salon************************/

            $SQL = 'SELECT
            s.SolicitudAsignacionEspacioId
            FROM
                SolicitudPadre sp
            INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = sp.SolicitudPadreId
            INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
            WHERE
            
            sp.SolicitudPadreId = "' . $Solicitud_id . '"';

            if ($Hijos =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar los Hijos Solicitud...';
                echo json_encode($a_vectt);
                exit;
            }

            $SolicitudSalon = $Hijos->GetArray();

            for ($c = 0; $c < $numIndices; $c++) {
                for ($d = 0; $d < count($CodigoDia); $d++) {
                    $Dia_Salon = $CodigoDia[$d] - 1;
                    $Salon = $_POST['TipoSalon_' . $c][$Dia_Salon];
                    if ($Salon <> '-1' || $Salon != '-1' || $Salon != -1) {
                        $C_Salon[] = $Salon;
                    }
                }
            }


            for ($s = 0; $s < count($C_Salon); $s++) {

                if (isset($C_Salon[$s]) && $C_Salon[$s] != null && isset($SolicitudSalon[$s][0]) && $SolicitudSalon[$s][0] != null) {

                    $UpdateSalon = 'UPDATE SolicitudAsignacionEspaciostiposalon
                      SET    codigotiposalon="' . $C_Salon[$s] . '"
                      WHERE  SolicitudAsignacionEspacioId="' . $SolicitudSalon[$s][0] . '"';

                    if ($CambioSalon =& $db->Execute($UpdateSalon) === false) {
                        $a_vectt['val'] = 'Error';
                        $a_vectt['Data'] = 'Error al Modificar Salon de las Solicitudes Asocidas o Detalle...';
                        echo json_encode($a_vectt);
                        exit;
                    }

                }
            }
            /**************************Nuevas Solicitudes**********************************/

            $ValidaSolicitud = $C_ValidaSolicitud->ValidarSolicitudCrear($db, $Grupo_id, $Sede, $Fecha_inicial, $Fecha_final, $InfoNew, $Limit, $CodigoDia, $C_Festivo, $Condicion_idSolicitud);
            //  echo '<pre>';print_r($ValidaSolicitud);die;
            if ($ValidaSolicitud['val'] == true) {
                $a_vectt['val'] = 'Error';
                $a_vectt['Data'] = $ValidaSolicitud['FechaAsignacion'];
                $a_vectt['NameGrupo'] = $ValidaSolicitud['Grupo'];
                echo json_encode($a_vectt);
                exit;
            }

            //echo '<pre>';print_r($_POST);

            $NewSolicitud = 1;
            for ($c = 0; $c <= $numIndices; $c++) {
                for ($d = 0; $d < count($CodigoDia); $d++) {
                    $Dia_Salon = $CodigoDia[$d] - 1;
                    $Salon = $_POST['TipoSalon_' . $c][$Dia_Salon];
                    $HoraNew_1 = $_POST['HoraInicial_' . $c][$Dia_Salon];
                    $HoraNew_2 = $_POST['HoraFin_' . $c][$Dia_Salon];
                    if ($HoraNew_1 && ($Salon <> '-1' || $Salon != '-1' || $Salon != -1)) {

                        /*************** Inicia Insertar New***********************/
                        $SQL_Insert = 'INSERT INTO SolicitudAsignacionEspacios(AccesoDiscapacitados,FechaInicio,FechaFinal,idsiq_periodicidad,ClasificacionEspaciosId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,codigodia,observaciones,codigocarrera)VALUES("' . $Acceso . '","' . $Fecha_inicial . '","' . $Fecha_final . '","35","' . $Sede[$d] . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"' . $CodigoDia[$d] . '","' . $Observacion . '","' . $Carrera . '")';

                        if ($InsertSolicituNew =& $db->Execute($SQL_Insert) === false) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Error al Insertar Solicitud..';
                            echo json_encode($a_vectt);
                            exit;
                        }

                        ##########################
                        $Last_id = $db->Insert_ID();
                        ##########################

                        $InsertAsociacion = 'INSERT INTO AsociacionSolicitud(SolicitudPadreId,SolicitudAsignacionEspaciosId)VALUES("' . $Solicitud_id . '","' . $Last_id . '")';

                        if ($InsertAsociacionNew =& $db->Execute($InsertAsociacion) === false) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Error al Insertar Asociacion Solicitud..';
                            echo json_encode($a_vectt);
                            exit;
                        }

                        for ($G = 0; $G < count($Grupo_id); $G++) {

                            $InserGrupo = 'INSERT INTO SolicitudEspacioGrupos(SolicitudAsignacionEspacioId,idgrupo)VALUES("' . $Last_id . '","' . $Grupo_id[$G] . '")';

                            if ($GrupoSolicitud =& $db->Execute($InserGrupo) === false) {
                                $a_vectt['val'] = false;
                                $a_vectt['descrip'] = 'Error al Insertar Solicitud Grupo..';
                                echo json_encode($a_vectt);
                                exit;
                            }

                        }//for


                        /****************************************************/
                        $SQL_TipoSalon = 'INSERT INTO SolicitudAsignacionEspaciostiposalon(SolicitudAsignacionEspacioId,codigotiposalon)VALUES("' . $Last_id . '","' . $Salon . '")';

                        if ($SolicitudTipoSalon =& $db->Execute($SQL_TipoSalon) === false) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Error al Insertar Solicitud Tipo Salon..';
                            echo json_encode($a_vectt);
                            exit;
                        }

                        /**********************************************************/

                        for ($r = 0; $r < count($InfoNew[$CodigoDia[$d]]); $r++) {
                            $Dato_1 = $InfoNew[$CodigoDia[$d]][$r][0];
                            $Dato_2 = $InfoNew[$CodigoDia[$d]][$r][1];

                            $C_Dato1 = explode(' ', $Dato_1);
                            $C_Dato2 = explode(' ', $Dato_2);

                            $Fecha_New = $C_Dato1[0];
                            $Hora1_New = $HoraNew_1;
                            $Hora2_New = $HoraNew_2;

                            $C_DatosDia = explode('-', $Fecha_New);

                            $dia = $C_DatosDia[2];
                            $mes = $C_DatosDia[1];
                            $year = $C_DatosDia[0];

                            $Festivo = $C_Festivo->esFestivo($dia, $mes, $year);
                            $DomingoTrue = $C_AsignacionSalon->DiasSemana($Fecha_New);
                            if ($Festivo == false) {//$Festivo No es Festivo

                                if (($DomingoTrue != 7) || ($DomingoTrue != '7')) {
                                    $FechaQuemada = $C_AsignacionSalon->ValidaFechaQuemada($Fecha_New);

                                    if ($FechaQuemada == false) {
                                        $SQL_Asignacion = 'SELECT
                                        AsignacionEspaciosId
                                        FROM
                                        AsignacionEspacios
                                        WHERE
                                        FechaAsignacion="' . $Fecha_New . '"
                                        AND
                                        SolicitudAsignacionEspacioId="' . $Last_id . '"
                                        AND
                                        codigoestado=100
                                        AND
                                        HoraInicio="' . $Hora1_New . '"
                                        AND
                                        HoraFin="' . $Hora2_New . '"';

                                        if ($ConsultaAsignacion =& $db->Execute($SQL_Asignacion) === false) {
                                            echo 'Error en el SQL de la Asignacion valida....<br><br>' . $SQL_Asignacion;
                                            die;
                                        }

                                        if ($ConsultaAsignacion->EOF) {
                                            $Asignacion = 'INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("' . $Fecha_New . '","' . $Last_id . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"212","' . $Hora1_New . '","' . $Hora2_New . '")';

                                            if ($InsertAsignar =& $db->Execute($Asignacion) === false) {
                                                $a_vectt['val'] = false;
                                                $a_vectt['descrip'] = 'Error al Insertar Asignacion del Espacio..';
                                                echo json_encode($a_vectt);
                                                exit;
                                            }
                                        }
                                    }//fin fecha quemada
                                }//Diferente de domingo
                            }//fin festivo
                        }//for
                    }
                }
            }
            /*****************************************************************************/

            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se ha Modificado la Solicitud....';
            echo json_encode($a_vectt);
            exit;

        }
        break;
    case 'HorarioGrupo':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();

            $Grupo_id = $_POST['Grupo_id'];

            Horario($db, 'HoraMulti', $Grupo_id);
        }
        break;
    case 'PintarError':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, false);
            MainGeneral();

            $Fechas = $_POST['Data'];

            $C_InterfazSolicitud->PintarError($Fechas);
        }
        break;
    case 'VerSobreCupo':
        {
            global $db, $userid;
            //define(AJAX,false);
            MainJson();
            //JsGeneral();
            include_once('SobrecupoPorcentaje_class.php');
            $C_SobrecupoPorcentaje = new SobrecupoPorcentaje();

            $C_SobrecupoPorcentaje->Sobrecupos($db, 1);
        }
        break;
    case 'SaveSobrecupo':
        {
            global $userid, $db;
            MainJson();

            $id = $_POST['id'];
            $Observaciones = $_POST['Observaciones'];
            $NumSolicitud = $_POST['NumSolicitud'];
            /*
  * Ivan Quintero
  * Diciembre 26 2018
  * Adicion de consulta de periodos en escala por estados
  */
            $SQL = "SELECT codigoperiodo " .
                "FROM periodo p" .
                " WHERE p.codigoestadoperiodo IN (1,3,4)" .
                " ORDER BY p.codigoestadoperiodo ASC " .
                " limit 1 ";
            /*END*/

            if ($Periodo =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar el Periodo';
                echo json_encode($a_vectt);
                exit;
            }

            $C_Periodo = $Periodo->fields['codigoperiodo'];

            $SQL_Insert = 'INSERT INTO SobreCupoClasificacionEspacios(Sobrecupo,Observaciones,ClasificacionEspacioId,codigoperiodo,FechaCreacion,UsuarioCreacion,FechaUltimaModificacion,UsuarioUltimaModificacion)VALUES("' . $NumSolicitud . '","' . $Observaciones . '","' . $id . '","' . $C_Periodo . '",NOW(),"' . $userid . '",NOW(),"' . $userid . '")';

            if ($InsertSobreCupo =& $db->Execute($SQL_Insert) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Insertar Sobrecupo';
                echo json_encode($a_vectt);
                exit;
            }

            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se ha Realizado la solicitud del SobreCupo...';
            echo json_encode($a_vectt);
            exit;
        }
        break;
    case 'HacerSolictuSobrecupo':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, false);
            MainGeneral();
            //JsGeneral();

            $id = str_replace('row_', '', $_REQUEST['id']);

            $C_InterfazSolicitud->SobrecupoSolicitud($db, $id);
        }
        break;
    case 'Menu':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, false);
            MainGeneral();
            JsGeneral();

            include_once('../../mgi/Menu.class.php');
            $C_Menu_Global = new Menu_Global();
            include_once('SobrecupoPorcentaje_class.php');
            $C_SobrecupoPorcentaje = new SobrecupoPorcentaje();

            //consulta los modulos de acceso que tiene el usuario
            $Data = $C_InterfazSolicitud->UsuarioMenu($db, $userid);

            if ($Data['val'] == true) {
                for ($i = 0; $i < count($Data['Data']); $i++) {
                    /**********************************************/
                    $URL[] = $Data['Data'][$i]['Url'];
                    $Nombre[] = $Data['Data'][$i]['Nombre'];
                    if ($i == 0) {
                        $Active[] = '1';
                    } else {
                        $Active[] = '0';
                    }
                    /**********************************************/
                }//for
            } else {
                echo $Data['Data'];
                die;
            }//if

            //muestra los menus de acceso
            $C_Menu_Global->writeMenu($URL, $Nombre, $Active);

            $RolEspacioFisico = $Data['Data'][0]['RolEspacioFisicoId'];

            if ($Data['Data'][0]['Url'] == 'InterfazSolicitud_html.php?actionID=Creacion') {
                $C_InterfazSolicitud->Administrativo($RolEspacioFisico);
            } else if ($Data['Data'][0]['Url'] == 'InterfazSolicitud_html.php') {
                $C_InterfazSolicitud->Principal($db, $RolEspacioFisico);
            } else if ($Data['Data'][0]['Url'] == 'SobrecupoPorcentaje_html.php') {
                $C_SobrecupoPorcentaje->Display($db, $RolEspacioFisico);
            }

        }
        break;
    case 'AsignacionManual':
        {
            global $userid, $db;
            MainJson();

            include_once('../Solicitud/AsignacionSalon.php');
            $C_AsignacionSalon = new AsignacionSalon();

            //echo '<pre>';print_r($_POST);die;

            $id_Soli = $_POST['id_Soli'];
            $Asignacio_id = $_POST['Asignacio_id'];
            $EspacioCheck = $_POST['EspacioCheck'];//Array

            for ($i = 0; $i < count($EspacioCheck); $i++) {
                /********************************************/
                if ($EspacioCheck[$i]) {
                    $Aula_id = $EspacioCheck[$i];
                }
                /********************************************/
            }//for

            $C_AsignacionSalon->InsertAula($db, $Asignacio_id, $Aula_id);

            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se ha Asignado El Aula...';
            $a_vectt['id_Soli'] = $id_Soli;
            $a_vectt['Userid'] = $userid;
            echo json_encode($a_vectt);
            exit;

        }
        break;
    case 'BuscarAutomatico':
        {
            global $userid, $db;
            MainJson();
            $Data = $_POST;
            include_once('../Solicitud/AsignacionSalon.php');
            $C_AsignacionSalon = new AsignacionSalon();
            include('InterfazSolicitud_class.php');
            $C_InterfazSolicitud = new InterfazSolicitud();
            $Data_user = $C_InterfazSolicitud->UsuarioMenu($db, $userid);
            $RolEspacioFisico = $Data_user['Data'][0]['RolEspacioFisicoId'];
            //echo'<pre>';print_r($Data);die;
            $Resultado = $C_AsignacionSalon->AsignacionAutoamtica($db, $Data, $RolEspacioFisico, $userid);
            //echo '<pre>';print_r($Resultado);die;
            echo json_encode($Resultado);
            exit;
        }
        break;
    case 'DialogoDinamic':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();

            $FechaIni = $_POST['FechaIni'];
            $FechaFinal = $_POST['FechaFinal'];

            $C_InterfazSolicitud->DialogoAutomatico($FechaIni, $FechaFinal);
        }
        break;
    case 'SaveCambioEstado':
        {
            include_once('../Notificaciones/NotificacionEspaciosFisicos_class.php');
            $C_Notificaciones = new NotificacionEspaciosFisicos();
            include_once('../Notificaciones/ConsolaNotificaciones_View.php');
            $V_ConsolaNotificaciones = new ViewConsolaNotificaciones();
            global $userid, $db;
            MainJson();

            $id = $_POST['id'];

            $SQL = 'UPDATE  AsignacionEspacios

      SET     EstadoAsignacionEspacio=1,
              Observaciones="",
              UsuarioUltimaModificacion="' . $userid . '",
              FechaUltimaModificacion=NOW(),
              Enviado=0
              
      WHERE   AsignacionEspaciosId="' . $id . '" AND codigoestado=100';

            if ($Modificacion =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Modificarde la Asignacion ....';
                echo json_encode($a_vectt);
                exit;
            }


            $SQL_ID = 'SELECT
                SolicitudAsignacionEspacioId
            FROM
                AsignacionEspacios
            WHERE
                codigoestado = 100
            AND AsignacionEspaciosId = "' . $id . '"';

            if ($Solicitud =& $db->Execute($SQL_ID) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar Solicitud Asigancion ....';
                echo json_encode($a_vectt);
                exit;
            }

            $ID_Solicitud = $Solicitud->fields['SolicitudAsignacionEspacioId'];


            $C_Data = $C_Notificaciones->AlumnosSolicitudCambio($db, $ID_Solicitud);


            $ID_Cambio = array();
            $EnvarCambio = 0;
            for ($i = 0; $i < count($C_Data); $i++) {

                $CodigoEstudiante = $C_Data[$i]['codigoestudiante'];
                $FulName = $C_Data[$i]['FulName'];
                $Correo = $C_Data[$i]['Correo'];

                $C_Info = $C_Notificaciones->InformacionCambioEstudiante($db, $ID_Solicitud, $CodigoEstudiante, 2);


                if ($C_Info[0]['Tittle']) {
                    $ID_Cambio[$ID_Solicitud][] = $C_Info[0]['AsignacionEspaciosId'];
                    $Mensaje = '<table border=2>
                            <tr>
                                <th colspan="2">' . $FulName . '</th>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;&nbsp;</td>    
                            </tr>
                            <tr>
                                <td>Notificaci&oacute;n</td>
                                
                                <td style="color: blue;">' . $C_Info[0]['Tittle'] . '</td>
                            </tr>
                            <tr>
                                <td>Materia</td>
                                <td>' . $C_Info[0]['nombremateria'] . '</td>
                            </tr>
                            <tr>
                                <td>Grupo</td>
                                <td>' . $C_Info[0]['nombregrupo'] . '&nbsp;::&nbsp;' . $C_Info[0]['idgrupo'] . '</td>
                            </tr>';
                    $Mensaje = $Mensaje . '<tr>
                                                <td>Fecha</td>
                                                <td>' . $C_Info[0]['FechaAsignacion'] . '</td>
                                            </tr>';


                    $Mensaje = $Mensaje . '<tr>
                                <td>Hora de Inicio</td>
                                <td>' . $C_Info[0]['HoraInicio'] . '</td>
                            </tr>
                            <tr>
                                <td>Hora Final</td>
                                <td>' . $C_Info[0]['HoraFin'] . '</td>
                            </tr>
                            <tr>
                                <td>Observaci&oacute;n</td>
                                <td>' . $C_Info[0]['Observaciones'] . '</td>
                            </tr>
                            <tr>
                                <td>Lugar</td>
                                <td>' . $C_Info[0]['Nombre'] . '</td>
                            </tr>
                        </table>
                        <br><br>
                        Nota : <br> Si no tiene lugar asignado, se le notificar&aacute; posteriormente o comuniquese con su Facultad.';

                    //echo '<br><br>'.$Mensaje;die;

                    $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                    // echo '<br><br>'.$Mensaje;
                    $tittle = $C_Info[0]['Tittle'] . ' DE ' . $C_Info[0]['nombremateria'];

                    $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $Mensaje, true);

                    if ($Resultado['succes'] === true) {
                        $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 1);
                    } else {
                        $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 0);
                    }
                    // echo '<pre>';print_r($Resultado);
                } else {
                    $C_Info = $C_Notificaciones->InformacionCambioEstudiante($db, $Solicitud->fields['id'], $CodigoEstudiante, 1, 1);


                    if ($C_Info[0]['Tiempo'] >= '18:00:00') {

                        $Mensaje = $V_ConsolaNotificaciones->Mensaje($C_Info, $FulName);

                        $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                        //echo '<br><br>'.$Mensaje;
                        $tittle = 'Cambios De Aula o Camcelaci&oacute;n de Clase';

                        $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $Mensaje, true);

                        if ($Resultado['succes'] === true) {
                            $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 1);
                        } else {
                            $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 0);
                        }

                        $EnvarCambio = 1;

                    }


                    for ($x = 0; $x < count($C_Info); $x++) {
                        $ID_Cambio[$Solicitud->fields['id']][] = $C_Info[$x]['AsignacionEspaciosId'];
                    }//for
                }
            }//for

            if ($EnvarCambio == 1) {
                $C_Notificaciones->CambiarAEnviado($db, $ID_Solicitud, $ID_Cambio);
            }

            $SQL = 'SELECT
            SolicitudPadreId
        FROM
            AsociacionSolicitud
        
        WHERE
        SolicitudAsignacionEspaciosId="' . $ID_Solicitud . '"';

            if ($SolicitudPadre =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar Solicitud Asigancion ....';
                echo json_encode($a_vectt);
                exit;
            }


            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se ha Modificado...';
            $a_vectt['id'] = $SolicitudPadre->fields['SolicitudPadreId'];
            echo json_encode($a_vectt);
            exit;
        }
        break;
    case 'VerCambio':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, false);
            MainGeneral();
            JsGeneral();
            $id = $_REQUEST['id'];
            $id_Soli = $_REQUEST['id_Soli'];

            $C_InterfazSolicitud->VerCambio($db, $id, $id_Soli);
        }
        break;
    case 'VerDetalleContenido':
        {
            global $db, $C_InterfazSolicitud, $userid, $codigorol;
            define(AJAX, true);
            MainGeneral();
            //JsGeneral();
            $id = $_POST['id'];
            $op = $_POST['op'];
            $DataMsg = '';
            //echo 'Rol->'.$codigorol;
            if ($op == 2) {
                $DataMsg = $_POST['DataMsg'];
                $Asigancion = 1;
            } else if ($op == 1 || $op == '') {
                $DataMsg = '';
                $Asigancion = 1;
            } else if ($op == 3 || $op == 3) {
                $DataMsg = '';
                $Asigancion = '';
            }

            //echo 'Asignacion ->'.$Asigancion;

            $C_InterfazSolicitud->ContenidoDetalle($db, $id, $Asigancion, $DataMsg, $userid);
        }
        break;
    case 'SaveOmitir':
        {
            include_once('../Notificaciones/NotificacionEspaciosFisicos_class.php');
            $C_Notificaciones = new NotificacionEspaciosFisicos();
            include_once('../Notificaciones/ConsolaNotificaciones_View.php');
            $V_ConsolaNotificaciones = new ViewConsolaNotificaciones();
            global $userid, $db;
            MainJson();

            $id = $_POST['id'];
            $TexObs = $_POST['TexObs'];

            $SQL = 'UPDATE  AsignacionEspacios

      SET     EstadoAsignacionEspacio=0,
              Observaciones="' . $TexObs . '",
              ClasificacionEspaciosId=212,
              UsuarioUltimaModificacion="' . $userid . '",
              FechaUltimaModificacion=NOW(),
              Modificado=1,
              Enviado=0
              
      WHERE   AsignacionEspaciosId="' . $id . '" AND codigoestado=100';

            if ($Modificacion =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Modificarde la Asignacion ....';
                echo json_encode($a_vectt);
                exit;
            }

            $SQL_ID = 'SELECT
                SolicitudAsignacionEspacioId
            FROM
                AsignacionEspacios
            WHERE
                codigoestado = 100
            AND AsignacionEspaciosId = "' . $id . '"';

            if ($Solicitud =& $db->Execute($SQL_ID) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar Solicitud Asigancion ....';
                echo json_encode($a_vectt);
                exit;
            }

            $ID_Solicitud = $Solicitud->fields['SolicitudAsignacionEspacioId'];


            $C_Data = $C_Notificaciones->AlumnosSolicitudCambio($db, $ID_Solicitud);


            $ID_Cambio = array();
            $EnvarCambio = 0;
            for ($i = 0; $i < count($C_Data); $i++) {

                $CodigoEstudiante = $C_Data[$i]['codigoestudiante'];
                $FulName = $C_Data[$i]['FulName'];
                $Correo = $C_Data[$i]['Correo'];

                $C_Info = $C_Notificaciones->InformacionCambioEstudiante($db, $ID_Solicitud, $CodigoEstudiante, 2);


                if ($C_Info[0]['Tittle']) {
                    $ID_Cambio[$ID_Solicitud][] = $C_Info[0]['AsignacionEspaciosId'];
                    $Mensaje = '<table border=2>
                            <tr>
                                <th colspan="2">' . $FulName . '</th>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;&nbsp;</td>    
                            </tr>
                            <tr>
                                <td>Notificaci&oacute;n</td>
                                
                                <td style="color: green;">' . $C_Info[0]['Tittle'] . '</td>
                            </tr>
                            <tr>
                                <td>Materia</td>
                                <td>' . $C_Info[0]['nombremateria'] . '</td>
                            </tr>
                            <tr>
                                <td>Grupo</td>
                                <td>' . $C_Info[0]['nombregrupo'] . '&nbsp;::&nbsp;' . $C_Info[0]['idgrupo'] . '</td>
                            </tr>';
                    $Mensaje = $Mensaje . '<tr>
                                                <td>Fecha</td>
                                                <td>' . $C_Info[0]['FechaAsignacion'] . '</td>
                                            </tr>';


                    $Mensaje = $Mensaje . '<tr>
                                <td>Hora de Inicio</td>
                                <td>' . $C_Info[0]['HoraInicio'] . '</td>
                            </tr>
                            <tr>
                                <td>Hora Final</td>
                                <td>' . $C_Info[0]['HoraFin'] . '</td>
                            </tr>
                            <tr>
                                <td>Observaci&oacute;n</td>
                                <td>' . $C_Info[0]['Observaciones'] . '</td>
                            </tr>
                            <tr>
                                <td>Lugar</td>
                                <td>' . $C_Info[0]['Nombre'] . '</td>
                            </tr>
                        </table>
                        <br><br>
                        Nota : <br> Si no tiene lugar asignado, se le notificar&aacute; posteriormente o comuniquese con su Facultad.';

                    //echo '<br><br>'.$Mensaje;die;

                    $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                    // echo '<br><br>'.$Mensaje;
                    $tittle = $C_Info[0]['Tittle'] . ' DE ' . $C_Info[0]['nombremateria'];

                    $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $Mensaje, true);

                    if ($Resultado['succes'] === true) {
                        $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 1);
                    } else {
                        $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 0);
                    }

                } else {
                    $C_Info = $C_Notificaciones->InformacionCambioEstudiante($db, $Solicitud->fields['id'], $CodigoEstudiante, 1, 1);


                    if ($C_Info[0]['Tiempo'] >= '18:00:00') {

                        $Mensaje = $V_ConsolaNotificaciones->Mensaje($C_Info, $FulName);

                        $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                        //echo '<br><br>'.$Mensaje;
                        $tittle = 'Cambios De Aula o Camcelaci&oacute;n de Clase';

                        $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $Mensaje, true);

                        if ($Resultado['succes'] === true) {
                            $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 1);
                        } else {
                            $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 2, 0);
                        }

                        $EnvarCambio = 1;

                    }


                    for ($x = 0; $x < count($C_Info); $x++) {
                        $ID_Cambio[$Solicitud->fields['id']][] = $C_Info[$x]['AsignacionEspaciosId'];
                    }//for
                }
                // echo '<pre>';print_r($Resultado);

            }//for

            if ($EnvarCambio == 1) {
                $C_Notificaciones->CambiarAEnviado($db, $ID_Solicitud, $ID_Cambio);
            }

            $SQL = 'SELECT
            SolicitudPadreId
        FROM
            AsociacionSolicitud
        
        WHERE
        SolicitudAsignacionEspaciosId="' . $ID_Solicitud . '"';

            if ($SolicitudPadre =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar Solicitud Asigancion ....';
                echo json_encode($a_vectt);
                exit;
            }

            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se ha Modificado...';
            $a_vectt['id'] = $SolicitudPadre->fields['SolicitudPadreId'];
            echo json_encode($a_vectt);
            exit;

        }
        break;
    case 'OmitirFecha':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, false);
            MainGeneral();
            JsGeneral();
            $id = $_REQUEST['id'];
            $id_Soli = $_REQUEST['id_Soli'];

            $C_InterfazSolicitud->OmitirFecha($db, $id, $id_Soli, $_POST['Op']);
        }
        break;
    case 'Creacion':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, false);
            MainGeneral();
            JsGeneral();
            include_once('../../mgi/Menu.class.php');

            $C_Menu_Global = new Menu_Global();


            $Data = $C_InterfazSolicitud->UsuarioMenu($db, $userid);

            // echo '<pre>';print_r($Data);die;

            if ($Data['val'] == true) {
                for ($i = 0; $i < count($Data['Data']); $i++) {
                    /**********************************************/
                    $URL[] = $Data['Data'][$i]['Url'];

                    $Nombre[] = $Data['Data'][$i]['Nombre'];

                    if ($Data['Data'][$i]['Url'] == 'InterfazSolicitud_html.php?actionID=Creacion') {
                        $Active[] = '1';
                    } else {
                        $Active[] = '0';
                    }
                    /**********************************************/
                }//for
            } else {
                echo $Data['Data'];
                die;
            }//if

            $C_Menu_Global->writeMenu($URL, $Nombre, $Active);

            $RolEspacioFisico = $Data['Data'][0]['RolEspacioFisicoId'];

            $C_InterfazSolicitud->Administrativo($RolEspacioFisico);
        }
        break;
    case 'RestaurarEspacios':
        {
            global $userid, $db;
            MainJson();

            $id = $_POST['id'];

            $Data = explode('::', $id);

            for ($i = 1; $i < count($Data); $i++) {

                $SQL = 'UPDATE AsignacionEspacios

      SET    ClasificacionEspaciosId=212,
             UsuarioUltimaModificacion="' . $userid . '",
             FechaultimaModificacion=NOW(),
             Modificado=1,
             Enviado=0
             
      WHERE  AsignacionEspaciosId="' . $Data[$i] . '" AND codigoestado=100';

                if ($EliminaAsignacion =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Intertar Elimnar la Fecha de ASignacion....';
                    echo json_encode($a_vectt);
                    exit;
                }

                $SQL = 'SELECT 

        SolicitudPadreId
        
        FROM
        
        AsignacionEspacios a INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
        INNER JOIN AsociacionSolicitud  aso ON aso.SolicitudAsignacionEspaciosId=s.SolicitudAsignacionEspacioId AND a.AsignacionEspaciosId="' . $Data[$i] . '"';


                if ($Solicitud =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Buscar la Solicit de la Asignacion Eliminada....';
                    echo json_encode($a_vectt);
                    exit;
                }
            }//for
            $a_vectt['val'] = true;
            $a_vectt['id'] = $Solicitud->fields['SolicitudPadreId'];
            $a_vectt['descrip'] = 'Se ha Restaurado...';
            echo json_encode($a_vectt);
            exit;
        }
        break;
    case 'EliminarAsigancion':
        {
            include_once('../Notificaciones/NotificacionEspaciosFisicos_class.php');
            $C_Notificaciones = new NotificacionEspaciosFisicos();
            include_once('../Notificaciones/ConsolaNotificaciones_View.php');
            $V_ConsolaNotificaciones = new ViewConsolaNotificaciones();
            global $userid, $db;
            MainJson();

            $id = $_POST['id'];

            $Data = explode('::', $id);

            for ($i = 1; $i < count($Data); $i++) {

                $SQL = 'SELECT
        s.codigomodalidadacademica
        FROM
        AsignacionEspacios  a INNER JOIN SolicitudAsignacionEspacios  s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
        WHERE
        a.AsignacionEspaciosId="' . $Data[$i] . '"
        and
        s.codigomodalidadacademica=001';

                if ($TipoSolicitud =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error En el sistema....';
                    echo json_encode($a_vectt);
                    exit;
                }

                $SQL = 'UPDATE AsignacionEspacios

      SET    codigoestado=200,
             UsuarioUltimaModificacion="' . $userid . '",
             FechaultimaModificacion=NOW(),
             Modificado=1,
             Enviado=0
             
      WHERE  AsignacionEspaciosId="' . $Data[$i] . '" AND codigoestado=100';

                if ($EliminaAsignacion =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Intertar Elimnar la Fecha de ASignacion....';
                    echo json_encode($a_vectt);
                    exit;
                }


                /************************************************************/
                $SQL = 'SELECT
            SolicitudAsignacionEspacioId AS id
        FROM
            AsignacionEspacios
        WHERE
        
        AsignacionEspaciosId="' . $Data[$i] . '"';


                if ($Solicitud =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Buscar la Solicit de la Asignacion Eliminada....';
                    echo json_encode($a_vectt);
                    exit;
                }

                $Solicitud_id = $Solicitud->fields['id'];

                $SQL = 'SELECT COUNT(AsignacionEspaciosId) As Num FROM AsignacionEspacios WHERE SolicitudAsignacionEspacioId="' . $Solicitud->fields['id'] . '" AND codigoestado=100';

                if ($SolicitudCount =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Buscar Cantida Activa  Asignaciones....';
                    echo json_encode($a_vectt);
                    exit;
                }

                if ($SolicitudCount->fields['Num'] < 1 || $SolicitudCount->fields['Num'] == 0) {
                    $Update = 'UPDATE SolicitudAsignacionEspacios
                  SET    codigoestado=200,
                         UsuarioUltimaModificacion="' . $userid . '",
                         FechaUltimaModificacion=NOW()
                  WHERE  SolicitudAsignacionEspacioId="' . $Solicitud_id . '"';

                    if ($Elimino =& $db->Execute($Update) === false) {
                        $a_vectt['val'] = false;
                        $a_vectt['descrip'] = 'Error al Eliminar Solicitud..';
                        echo json_encode($a_vectt);
                        exit;
                    }
                }


                /************************************************************/

            }//for


            if (!$TipoSolicitud->EOF) {

                $C_Data = $C_Notificaciones->AlumnosSolicitudCambio($db, $Solicitud->fields['id']);


                $ID_Cambio = array();
                $EnvarCambio = 0;
                for ($i = 0; $i < count($C_Data); $i++) {

                    $CodigoEstudiante = $C_Data[$i]['codigoestudiante'];
                    $FulName = $C_Data[$i]['FulName'];
                    $Correo = $C_Data[$i]['Correo'];

                    $C_Info = $C_Notificaciones->InformacionCambioEstudiante($db, $Solicitud->fields['id'], $CodigoEstudiante, 1);


                    if ($C_Info[0]['Tittle']) {
                        $ID_Cambio[$Solicitud->fields['id']][] = $C_Info[0]['AsignacionEspaciosId'];
                        $Mensaje = '<table border=2>
                            <tr>
                                <th colspan="2">' . $FulName . '</th>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;&nbsp;</td>    
                            </tr>
                            <tr>
                                <td>Notificaci&oacute;n</td>
                                
                                <td style="color: red;">' . $C_Info[0]['Tittle'] . '</td>
                            </tr>
                            <tr>
                                <td>Materia</td>
                                <td>' . $C_Info[0]['nombremateria'] . '</td>
                            </tr>
                            <tr>
                                <td>Grupo</td>
                                <td>' . $C_Info[0]['nombregrupo'] . '&nbsp;::&nbsp;' . $C_Info[0]['idgrupo'] . '</td>
                            </tr>';
                        $Mensaje = $Mensaje . '<tr>
                                                <td>Fecha</td>
                                                <td>' . $C_Info[0]['FechaAsignacion'] . '</td>
                                            </tr>';


                        $Mensaje = $Mensaje . '<tr>
                                <td>Hora de Inicio</td>
                                <td>' . $C_Info[0]['HoraInicio'] . '</td>
                            </tr>
                            <tr>
                                <td>Hora Final</td>
                                <td>' . $C_Info[0]['HoraFin'] . '</td>
                            </tr>
                            <tr>
                                <td>Lugar</td>
                                <td>' . $C_Info[0]['Nombre'] . '</td>
                            </tr>
                        </table>
                        <br><br>
                        Nota : <br> Si no tiene lugar asignado, se le notificar&aacute; posteriormente o comuniquese con su Facultad.';

                        //echo '<br><br>'.$Mensaje;die;

                        $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                        // echo '<br><br>'.$Mensaje;
                        $tittle = $C_Info[0]['Tittle'] . ' DE ' . $C_Info[0]['nombremateria'];
                        //echo '$CodigoEstudiante->'.$CodigoEstudiante;
                        $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $Mensaje, true);

                        if ($Resultado['succes'] === true) {
                            $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 3, 1);
                        } else {
                            $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 3, 0);
                        }

                        $EnvarCambio = 1;
                    } else {
                        $C_Info = $C_Notificaciones->InformacionCambioEstudiante($db, $Solicitud->fields['id'], $CodigoEstudiante, 1, 1);


                        if ($C_Info[0]['Tiempo'] >= '18:00:00') {

                            $Mensaje = $V_ConsolaNotificaciones->Mensaje($C_Info, $FulName);

                            $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                            //echo '<br><br>'.$Mensaje;
                            $tittle = 'Cambios De Aula o Camcelaci&oacute;n de Clase';

                            $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $Mensaje, true);

                            if ($Resultado['succes'] === true) {
                                $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 3, 1);
                            } else {
                                $C_Notificaciones->LogNotificacion($db, $CodigoEstudiante, $userid, 3, 0);
                            }

                            $EnvarCambio = 1;

                        }


                        for ($x = 0; $x < count($C_Info); $x++) {
                            $ID_Cambio[$Solicitud->fields['id']][] = $C_Info[$x]['AsignacionEspaciosId'];
                        }//for
                    }

                }//for

                if ($EnvarCambio == 1) {
                    $C_Notificaciones->CambiarAEnviado($db, $Solicitud->fields['id'], $ID_Cambio);
                }

                $SQL = 'SELECT

                        s.SolicitudAsignacionEspacioId,
                        sg.idgrupo,
                        g.codigomateria,
                        m.codigocarrera,
                        u.usuario,
                        u.emailusuariofacultad,
                        t.codigorol,
                        t.codigotipousuario,
                        CONCAT(d.apellidodocente," ",d.nombredocente) AS NameDocente,
                        m.nombremateria
                
                FROM
                
                SolicitudAsignacionEspacios s INNER JOIN SolicitudEspacioGrupos sg ON s.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId
                                              INNER JOIN grupo g ON g.idgrupo=sg.idgrupo
                                              INNER JOIN materia m ON m.codigomateria=g.codigomateria
                                              INNER JOIN usuariofacultad u ON m.codigocarrera=u.codigofacultad
                                              INNER JOIN usuario t ON  t.usuario=u.usuario
                                              INNER JOIN UsuarioTipo ut ON ut.UsuarioId = u.idusuario
                                              INNER JOIN usuariorol r ON r.usuario=t.usuario
                                              INNER JOIN docente d ON d.numerodocumento=g.numerodocumento
                
                
                WHERE
                
                s.SolicitudAsignacionEspacioId="' . $Solicitud->fields['id'] . '"
                AND
                sg.codigoestado=100
                AND
                s.codigoestado=100
                AND
                r.idrol=93
                AND
                t.codigorol=3';

                if ($SQL_Decano =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Buscar el Decano ..';
                    echo json_encode($a_vectt);
                    exit;
                }

                $User_Decano = $SQL_Decano->fields['usuario'];
                $Email_Decano = $SQL_Decano->fields['emailusuariofacultad'];

                if ($Email_Decano) {
                    $DecanoEmail = $Email_Decano;
                } else {
                    $DecanoEmail = $User_Decano . '@unbosque.edu.co';
                }
                $SQL = 'SELECT
                a.FechaAsignacion,
                a.HoraInicio,
                a.HoraFin
                FROM
                AsignacionEspacios a
                
                WHERE
                
                a.SolicitudAsignacionEspacioId="' . $Solicitud->fields['id'] . '"
                AND
                a.codigoestado=200
                AND
                DATE(a.FechaultimaModificacion)="' . date('Y-m-d') . '"';

                if ($SQL_Info =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Buscar el Info ..';
                    echo json_encode($a_vectt);
                    exit;
                }
                /******************************************************************/

                $MensajeDecano = '<table border=2>
                            <tr>
                                <td colspan=2>Notificaci&oacute;n Cancelaci&oacute;n De Clase</td>
                            </tr>
                            <tr>
                            <td colspan=2>
                                A continuaci&oacute;n detallamos la informaci&oacute;n de la clase cancelada.
                            </td>
                            </tr>
                            <tr>
                                <td>Docente</td>
                                <td>' . $SQL_Decano->fields['NameDocente'] . '</td>
                            </tr>
                            <tr>
                                <td>Materia</td>
                                <td>' . $SQL_Decano->fields['nombremateria'] . '</td>
                            </tr>';
                $MensajeDecano = $MensajeDecano . '<tr>
                            <td>Fecha</td>
                            <td>' . $SQL_Info->fields['FechaAsignacion'] . '</td>
                        </tr>';


                $MensajeDecano = $MensajeDecano . '<tr>
                                <td>Hora de Inicio</td>
                                <td>' . $SQL_Info->fields['HoraInicio'] . '</td>
                            </tr>
                            <tr>
                                <td>Hora Final</td>
                                <td>' . $SQL_Info->fields['HoraFin'] . '</td>
                            </tr>
                        </table>
                        <br><br>';
                $to = $DecanoEmail;//'ramirezmarcos@unbosque.edu.co';//
                // echo '<br><br>'.$Mensaje;
                $tittle = 'Notificación de Cancelación de Clase';

                $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $MensajeDecano, true);

                /* if($Resultado['succes']===true){
            $C_Notificaciones->LogNotificacion($db,$CodigoEstudiante,$userid,3,1);
        }else{
            $C_Notificaciones->LogNotificacion($db,$CodigoEstudiante,$userid,3,0);
        }*/
                /******************************************************************/

            } else {
                //******************Envia correo a Externa**********************//
                $SQL = 'SELECT
           s.Email, s.Responsable, s.NombreEvento, a.FechaAsignacion, a.HoraInicio, a.HoraFin
           FROM
            AsignacionEspacios  a INNER JOIN SolicitudAsignacionEspacios  s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
        WHERE
        a.AsignacionEspaciosId="' . $Data[$i] . '"';

                if ($SolicitudExterna =& $db->Execute($SQL) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error En el sistema....';
                    echo json_encode($a_vectt);
                    exit;
                }

                $MensajeExterno = '<table border=2>
                            <tr>
                                <td colspan=2>Notificaci&oacute;n Cancelaci&oacute;n De Clase</td>
                            </tr>
                            <tr>
                            <td colspan=2>
                                A continuaci&oacute;n detallamos la informaci&oacute;n de la clase cancelada.
                            </td>
                            </tr>
                            <tr>
                                <td>Responsable</td>
                                <td>' . $SolicitudExterna->fields['Responsable'] . '</td>
                            </tr>
                            <tr>
                                <td>Evento</td>
                                <td>' . $SolicitudExterna->fields['NombreEvento'] . '</td>
                            </tr>';
                $MensajeExterno = $MensajeExterno . '<tr>
                            <td>Fecha</td>
                            <td>' . $SolicitudExterna->fields['FechaAsignacion'] . '</td>
                        </tr>';


                $MensajeExterno = $MensajeExterno . '<tr>
                                <td>Hora de Inicio</td>
                                <td>' . $SolicitudExterna->fields['HoraInicio'] . '</td>
                            </tr>
                            <tr>
                                <td>Hora Final</td>
                                <td>' . $SolicitudExterna->fields['HoraFin'] . '</td>
                            </tr>
                        </table>
                        <br><br>';


                $to = $SolicitudExterna->fields['Email'];//'ramirezmarcos@unbosque.edu.co';//
                // echo '<br><br>'.$Mensaje;
                $tittle = 'Notificación de Cancelación de Clase';

                $Resultado = $C_Notificaciones->EnviarCorreo($to, $tittle, $MensajeExterno, true);
                //****************************************//
            }

            $SQL = 'SELECT
                SolicitudPadreId
            FROM
                AsociacionSolicitud
            
            WHERE
            SolicitudAsignacionEspaciosId="' . $Solicitud_id . '"';

            if ($SolicituPadre =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Eliminar Solicitud..';
                echo json_encode($a_vectt);
                exit;
            }


            $a_vectt['val'] = true;
            $a_vectt['id'] = $SolicituPadre->fields['SolicitudPadreId'];
            $a_vectt['descrip'] = 'Se ha Eliminado la Fecha de Forma Correcta...';
            echo json_encode($a_vectt);
            exit;
        }
        break;
    case 'EditarSolicitud':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, false);
            MainGeneral();

            $id = str_replace('row_', '', $_REQUEST['id']);
            if (isset($_REQUEST['tipo'])) {
                $tipo = $_REQUEST['tipo'];
            } else {
                $tipo = 1;
            }

            $C_InterfazSolicitud->Crear($db, $id, $tipo);
        }
        break;
    case 'EliminarSolicitud':
        {
            global $userid, $db;
            MainJson();

            $id = str_replace('row_', '', $_POST['id']);

            $Update = 'UPDATE SolicitudPadre
         SET    CodigoEstado=200,
                UsuarioUltimaModificacion="' . $userid . '",
                FechaUltimaModificacion=NOW()
         WHERE  SolicitudPadreId="' . $id . '"';

            if ($Elimino =& $db->Execute($Update) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Eliminar Solicitud..';
                echo json_encode($a_vectt);
                exit;
            }

            $SQL = 'SELECT
            SolicitudAsignacionEspaciosId AS id
        FROM
            AsociacionSolicitud                
        WHERE
            SolicitudPadreId="' . $id . '"';

            if ($Consulta =& $db->Execute($SQL) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error al Buscar los Hijos Solicitud..';
                echo json_encode($a_vectt);
                exit;
            }

            while (!$Consulta->EOF) {
                /************************************************/
                $Update = 'UPDATE SolicitudAsignacionEspacios
             SET    codigoestado=200,
                    UsuarioUltimaModificacion="' . $userid . '",
                    FechaUltimaModificacion=NOW()
             WHERE  SolicitudAsignacionEspacioId="' . $Consulta->fields['id'] . '"';

                if ($Elimino =& $db->Execute($Update) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Eliminar Solicitud..';
                    echo json_encode($a_vectt);
                    exit;
                }

                $Update = 'UPDATE AsignacionEspacios
             SET    codigoestado=200,
                    ClasificacionEspaciosId=212,
                    FechaultimaModificacion=NOW(),
                    UsuarioUltimaModificacion="' . $userid . '",
                    Enviado=0
             WHERE  SolicitudAsignacionEspacioId="' . $Consulta->fields['id'] . '"';

                if ($Elimino =& $db->Execute($Update) === false) {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Error al Eliminar Solicitud..';
                    echo json_encode($a_vectt);
                    exit;
                }
                /************************************************/
                $Consulta->MoveNext();
            }

            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se Ha Eliminado Solicitud...';
            echo json_encode($a_vectt);
            exit;

        }
        break;
    case 'BuscarDisponibilidad':
        { //echo '<pre>';print_r($_REQUEST);die;
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, false);
            MainGeneral();
            JsGeneral();
            //var_dump(is_file('../Solicitud/AsignacionSalon.php'));die;

            $TipoSalon = $_REQUEST['TipoSalon'];
            //echo '<pre>';print_r($TipoSalon);die;
            $Acceso = $_REQUEST['Acceso'];
            $Max = $_REQUEST['NumEstudiantes'];
            $Sede = $_REQUEST['Campus'];
            $Feha_inicial = $_REQUEST['FechaAsignacion'];
            $Feha_final = $_REQUEST['FechaAsignacion'];
            $Hora_ini = $_REQUEST['HoraInicial'];
            $Hora_fin = $_REQUEST['HoraFin'];
            $Asignacio_id = $_REQUEST['idAsignacion'];
            $id_Soli = $_REQUEST['id_Soli'];
            $id_Soli_Hijo = $_REQUEST['S_Hijo'];

            $Data = $C_InterfazSolicitud->UsuarioMenu($db, $userid);

            $RolEspacioFisico = $Data['Data'][0]['RolEspacioFisicoId'];

            $C_InterfazSolicitud->DisponibilidadManual($db, $TipoSalon, $Acceso, $Max, $Sede, $Feha_inicial, $Feha_final, $Hora_ini, $Hora_fin, $id_Soli, $Asignacio_id, $userid, $id_Soli_Hijo, $RolEspacioFisico);

        }
        break;
    case 'Asignacion':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();

            $id = str_replace('row_', '', $_POST['id']);

            $C_InterfazSolicitud->VerEstadoSolicitud($id, $db, 1, $userid);

        }
        break;
    case 'AddNewSolicitud':
        {
            global $db, $userid;
            MainJson();
            // echo '<pre>';print_r($_POST); die;
            //var_dump(is_file('../Solicitud/AsignacionSalon.php'));die;
            include_once('../Solicitud/AsignacionSalon.php');
            include_once('../Solicitud/festivos.php');
            include_once('ValidaSolicitud_Class.php');

            $C_Festivo = new festivos();
            $C_AsignacionSalon = new AsignacionSalon();
            $C_ValidaSolicitud = new ValidaSolicitud();

            $FechaUnica = $_POST['FechaUnica'];
            $Max = $_POST['NumEstudiantes'];
            $Acceso = $_POST['Acceso'];
            $Observacion = $_POST['Observacion'];
            $Carrera = $_POST['Programa'];
            if ($Acceso == 'on') {
                $Acceso = 1;
            } else {
                $Acceso = 0;
            }

            // $TipoSalon      = $_POST['TipoSalon_'];
            $Grupo_id = $_POST['MultiGrupos'];


            //echo '<pre>';print_r($TipoSalon);die;

            /*
(
    [0] => 0
    [1] => 01
    [2] => 02
)
*/

            if ($FechaUnica) {
                $HoraInicial_unica = $_POST['HoraInicial_unica'];
                $HoraFin_unica = $_POST['HoraFin_unica'];
                $Sede = $_POST['CampusUnico'];

                $fechadb = $HoraFin_unica;
                $tmp = explode('-', $fechadb);
                $Fecha_Envia = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
                $fecha = date('Y-m-d');
                $tmp = explode('-', $fecha);
                $Hoy = mktime(0, 0, 0, $tmp[1], $tmp[2], $tmp[0]);
                // Compara ahora que las fechas son enteror
                if ($Hoy > $Fecha_Envia) {

                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'La fecha Indicada Es Menor que la fecha Actual...';
                    echo json_encode($a_vectt);
                    exit;

                }

                $CodigoDia[] = $C_AsignacionSalon->DiasSemana($FechaUnica, 'Codigo');

                $Hora = $C_AsignacionSalon->Horas($HoraInicial_unica, $HoraFin_unica);

                $Info[$CodigoDia[0]][0][0] = $FechaUnica . ' ' . $Hora['Horaini'];
                $Info[$CodigoDia[0]][0][1] = $FechaUnica . ' ' . $Hora['Horafin'];
            } else {
                $Data = $_POST;

                $Info = $C_AsignacionSalon->DisponibilidadMultiple($db, $Data, 'arreglo', '../');
                $FechaIni = $_POST['FechaIni'];
                $FechaFin = $_POST['FechaFin'];
                $CodigoDia = $_POST['DiaSemana'];
                $numIndices = $_POST['numIndices'];
                $Sede = $_POST['Campus'];

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

            }

            $Limit = Count($CodigoDia) - 1;

            /*****************************/


            for ($d = 0; $d <= $numIndices; $d++) {
                for ($b = 0; $b <= $Limit; $b++) {
                    $T = $CodigoDia[$b] - 1;
                    $TipoSalon = $_POST['TipoSalon_' . $d][$T];

                    $Hora_1 = $_POST['HoraInicial_' . $d][$T];
                    $Hora_2 = $_POST['HoraFin_' . $d][$T];

                    if ($Hora_1 && $Hora_2) {

                        if ($TipoSalon == '-1' || $TipoSalon == -1) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Por Favor Indicar el o los Tipos de Salon que Nesecita...';
                            echo json_encode($a_vectt);
                            exit;
                        }

                    }

                }
            }

            if ($FechaUnica) {
                $Fecha_inicial = $FechaUnica;
                $Fecha_final = $FechaUnica;

            } else {
                $Fecha_inicial = $FechaIni;
                $Fecha_final = $FechaFin;

            }
            /******************Validar Existencia de Solicitud**********************/
            //  echo 'por aca...estoy...';die;

            $ValidacionHorario = $C_ValidaSolicitud->ValidaHorario($db, $Grupo_id, $Info, $CodigoDia, $Limit);

            // echo '<pre>';print_r($ValidacionHorario);die;
            if ($ValidacionHorario['id_grupo']) {
                $a_vectt['val'] = 'ErrorHorario';
                // echo '<pre>';print_r($ValidacionHorario);
                if ($ValidacionHorario['Data'] == 'Other') {
                    for ($e = 1; $e <= count($ValidacionHorario['id_grupo']); $e++) {
                        for ($w = 0; $w < count($ValidacionHorario['id_grupo'][$e]); $w++) {

                            if ($w == 0) {
                                $Grupos_id_Error = $ValidacionHorario['id_grupo'][$e][$w];
                                $Nombre_Error = $ValidacionHorario['nombregrupo'][$e][$w];
                                $dia_Error = $ValidacionHorario['dia'][$e];
                            } else {
                                $Grupos_id_Error = $Grupos_id_Error . ' :: ' . $ValidacionHorario['id_grupo'][$e][$w];
                                $Nombre_Error = $Nombre_Error . ',' . $ValidacionHorario['nombregrupo'][$e][$w];
                                $dia_Error = $dia_Error . ',' . $ValidacionHorario['dia'][$e];
                            }
                        }
                    }
                } else {
                    for ($e = 0; $e <= count($ValidacionHorario['id_grupo']); $e++) {
                        if ($e == 0) {
                            $Grupos_id_Error = $ValidacionHorario['id_grupo'][$e];
                            $Nombre_Error = $ValidacionHorario['nombregrupo'][$e];
                            $dia_Error = $ValidacionHorario['dia'][$e];
                        } else {
                            $Grupos_id_Error = $Grupos_id_Error . ' :: ' . $ValidacionHorario['id_grupo'][$e];
                            $Nombre_Error = $Nombre_Error . ',' . $ValidacionHorario['nombregrupo'][$e];
                            $dia_Error = $dia_Error . ',' . $ValidacionHorario['dia'][$e];
                        }

                    }//for


                }


                $a_vectt['Mensaje'] = 'Error En o en los horarios de los siguientes grupos y dias...';
                $a_vectt['Mensaje_1'] = $Grupos_id_Error;
                $a_vectt['Mensaje_2'] = $Nombre_Error;
                $a_vectt['Mensaje_3'] = $dia_Error;
                echo json_encode($a_vectt);
                exit;
            }


            $ValidaSolicitud = $C_ValidaSolicitud->ValidarSolicitudCrear($db, $Grupo_id, $Sede, $Fecha_inicial, $Fecha_final, $Info, $Limit, $CodigoDia, $C_Festivo);

            //echo '<pre>';print_r($ValidaSolicitud);die;
            //var_dump($ValidaSolicitud);die;

            if ($ValidaSolicitud['val'] == true) {
                $a_vectt['val'] = 'Error';
                $a_vectt['Data'] = $ValidaSolicitud['FechaAsignacion'];
                $a_vectt['NameGrupo'] = $ValidaSolicitud['Grupo'];
                echo json_encode($a_vectt);
                exit;
            }


            $SQL_InsertPadre = 'INSERT INTO SolicitudPadre(UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion)VALUES("' . $userid . '","' . $userid . '",NOW(),NOW())';

            if ($InsertPadre =& $db->Execute($SQL_InsertPadre) === false) {
                echo 'Error en el sql del Padre id Solicud...<br><BR>' . $SQL_InsertPadre;
                die;
            }

            $SolicituPadre = $Last_id = $db->Insert_ID();

            for ($Q = 0; $Q <= $numIndices; $Q++) {
                for ($i = 0; $i <= $Limit; $i++) {

                    $T = $CodigoDia[$i] - 1;
                    $TipoSalon = $_POST['TipoSalon_' . $Q][$T];

                    if ($TipoSalon != '-1' || $TipoSalon != -1) {

                        /***********************************************************************/

                        $SQL_Insert = 'INSERT INTO SolicitudAsignacionEspacios(AccesoDiscapacitados,FechaInicio,FechaFinal,idsiq_periodicidad,ClasificacionEspaciosId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,codigodia,observaciones,codigocarrera)VALUES("' . $Acceso . '","' . $Fecha_inicial . '","' . $Fecha_final . '","35","' . $Sede[$i] . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"' . $CodigoDia[$i] . '","' . $Observacion . '","' . $Carrera . '")';

                        if ($InsertSolicituNew =& $db->Execute($SQL_Insert) === false) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Error al Insertar Solicitud..';
                            echo json_encode($a_vectt);
                            exit;
                        }

                        ##########################
                        $Last_id = $db->Insert_ID();
                        ##########################

                        /**********************Insert Asociacion Solicitud**********************/
                        $SQL = 'SELECT * FROM AsociacionSolicitud WHERE SolicitudAsignacionEspaciosId="' . $Last_id . '"';

                        if ($Valida =& $db->Execute($SQL) === false) {
                            echo 'Error en el SQL de la Validacion ....<br><br>' . $SQL;
                            die;
                        }

                        if ($Valida->EOF) {
                            $SQL_InsertAsociacion = 'INSERT INTO AsociacionSolicitud(SolicitudPadreId,SolicitudAsignacionEspaciosId)VALUES("' . $SolicituPadre . '","' . $Last_id . '")';

                            if ($InsertAsociacion =& $db->Execute($SQL_InsertAsociacion) === false) {
                                echo 'Error en el SQL de la Asociacion....<br><br>' . $SQL_InsertAsociacion;
                                die;
                            }
                        }//VALIDAR

                        /*************************************************************************/


                        for ($G = 0; $G < count($Grupo_id); $G++) {

                            $InserGrupo = 'INSERT INTO SolicitudEspacioGrupos(SolicitudAsignacionEspacioId,idgrupo)VALUES("' . $Last_id . '","' . $Grupo_id[$G] . '")';

                            if ($GrupoSolicitud =& $db->Execute($InserGrupo) === false) {
                                $a_vectt['val'] = false;
                                $a_vectt['descrip'] = 'Error al Insertar Solicitud Grupo..';
                                echo json_encode($a_vectt);
                                exit;
                            }

                        }//for


                        $TipoSalon = $_POST['TipoSalon_' . $Q][$T];

                        /****************************************************/
                        $SQL_TipoSalon = 'INSERT INTO SolicitudAsignacionEspaciostiposalon(SolicitudAsignacionEspacioId,codigotiposalon)VALUES("' . $Last_id . '","' . $TipoSalon . '")';

                        if ($SolicitudTipoSalon =& $db->Execute($SQL_TipoSalon) === false) {
                            $a_vectt['val'] = false;
                            $a_vectt['descrip'] = 'Error al Insertar Solicitud Tipo Salon..';
                            echo json_encode($a_vectt);
                            exit;
                        }
                        /****************************************************/


                        /****************************************************/
                        //echo '<pre>';print_r($Info);die;
                        for ($x = 0; $x < count($Info[$CodigoDia[$i]]); $x++) {
                            /******************************************************/

                            $FechaFutura_1 = $Info[$CodigoDia[$i]][$x][0];
                            $FechaFutura_2 = $Info[$CodigoDia[$i]][$x][1];

                            $C_FechaData_1 = explode(' ', $FechaFutura_1);
                            $C_FechaData_2 = explode(' ', $FechaFutura_2);

                            $C_DatosDia = explode('-', $C_FechaData_1[0]);

                            $dia = $C_DatosDia[2];
                            $mes = $C_DatosDia[1];
                            $year = $C_DatosDia[0];


                            $Festivo = $C_Festivo->esFestivo($dia, $mes, $year);
                            $DomingoTrue = $C_AsignacionSalon->DiasSemana($Fecha);
                            if ($Festivo == false) {//$Festivo No es Festivo
                                if (($DomingoTrue != 7) || ($DomingoTrue != '7')) {
                                    $Fecha = $C_FechaData_1[0];

                                    $FechaQuemada = $C_AsignacionSalon->ValidaFechaQuemada($Fecha);

                                    if ($FechaQuemada == false) {

                                        $Hora_1 = $_POST['HoraInicial_' . $Q][$T];
                                        $Hora_2 = $_POST['HoraFin_' . $Q][$T];

                                        $SQL_Asignacion = 'SELECT
                                        AsignacionEspaciosId
                                        FROM
                                        AsignacionEspacios
                                        WHERE
                                        FechaAsignacion="' . $Fecha . '"
                                        AND
                                        SolicitudAsignacionEspacioId="' . $Last_id . '"
                                        AND
                                        codigoestado=100
                                        AND
                                        HoraInicio="' . $Hora_1 . '"
                                        AND
                                        HoraFin="' . $Hora_2 . '"';

                                        if ($ConsultaAsignacion =& $db->Execute($SQL_Asignacion) === false) {
                                            echo 'Error en el SQL de la Asignacion valida....<br><br>' . $SQL_Asignacion;
                                            die;
                                        }

                                        if ($ConsultaAsignacion->EOF) {

                                            $Asignacion = 'INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("' . $Fecha . '","' . $Last_id . '","' . $userid . '","' . $userid . '",NOW(),NOW(),"212","' . $Hora_1 . '","' . $Hora_2 . '")';

                                            if ($InsertAsignar =& $db->Execute($Asignacion) === false) {
                                                $a_vectt['val'] = false;
                                                $a_vectt['descrip'] = 'Error al Insertar Asignacion del Espacio..';
                                                echo json_encode($a_vectt);
                                                exit;
                                            }
                                        }
                                    }//fecha quemada
                                }//Diferente de Domingo
                            }//if festivo
                            /******************************************************/
                        }//for

                    }//if $TipoSalon != -1
                }//for
            }//for


            $a_vectt['val'] = true;
            $a_vectt['descrip'] = 'Se ha Creado la Solicitud Correctamente...';
            $a_vectt['Solid_id'] = $SolicituPadre;
            echo json_encode($a_vectt);
            exit;

        }
        break;
    case 'Ver_EstadoSolicitud':
        {
            global $db, $C_InterfazSolicitud, $userid, $codigorol;
            define(AJAX, true);
            MainGeneral();
            //JsGeneral();

            $id = $_POST['id'];
            $Op = $_POST['Op'];

            //echo '<pre>';print_r($_POST);

            if ($_POST['Omitir'] == 1 || $codigorol == 2) {

                //$Rol = $C_InterfazSolicitud->UsuarioMenu($db,$userid);

                //echo '<pre>';print_r($Rol);die;
                //echo 'Ent4ro...';die;
                if ($Op == 1) {
                    $Asigancion = '';
                }

                $C_InterfazSolicitud->VerEstadoSolicitud($id, $db, $Asigancion, $userid);
            } else {

                $Rol = $C_InterfazSolicitud->UsuarioMenu($db, $userid);

                //echo '<pre>';print_r($Rol);die;

                $RolEspacioFisico = $Rol['Data'][0]['RolEspacioFisicoId'];


                if ($RolEspacioFisico == 2 && $Op != 1) {
                    $Asigancion = 1;
                } else if ($RolEspacioFisico == 2 && $Op == 1) {
                    $Asigancion = '';
                } else {
                    $Asigancion = '';
                }

                if ($Op == 1 && $RolEspacioFisico != 2) {
                    $Asigancion = '';
                }

                $C_InterfazSolicitud->VerEstadoSolicitud($id, $db, $Asigancion, $userid);
            }
        }
        break;
    case 'Crear':
        {
            global $db, $C_InterfazSolicitud, $userid, $codigorol;
            $id = $_GET['padre'];
            if ($id == null) {
                define(AJAX, true);
            } else {
                define(AJAX, false);
            }
            MainGeneral();
            JsGeneral();


            $C_InterfazSolicitud->Crear($db, $id);

        }
        break;
    case 'PendienteAsignar':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, false);
            MainGeneral();
            JsGeneral();
            $C_InterfazSolicitud->PendienteAsignar($db, $fechaini);
        }
        break;
    case 'DataPendienteAsignar':
        {
            global $db, $C_InterfazSolicitud, $userid;
            define(AJAX, true);
            MainGeneral();
            $fechaIni = $_POST['fechaIni'];
            $fechaFin = $_POST['fechaFin'];
            //$C_InterfazSolicitud->PendienteAsignar($db,$fechaini);
            $C_InterfazSolicitud->DataPendienteAsignar($db, $fechaIni, $fechaFin);
        }
        break;
    default:
        {
            global $db, $C_InterfazSolicitud, $userid, $codigorol;

            define(AJAX, false);
            MainGeneral();
            JsGeneral();
            include_once('../../mgi/Menu.class.php');

            $C_Menu_Global = new Menu_Global();
            $Data = $C_InterfazSolicitud->UsuarioMenu($db, $userid);

            if ($Data['val'] == true) {
                for ($i = 0; $i < count($Data['Data']); $i++) {
                    /**********************************************/

                    $URL[] = $Data['Data'][$i]['Url'];

                    $Nombre[] = $Data['Data'][$i]['Nombre'];

                    if ($Data['Data'][$i]['Url'] == 'InterfazSolicitud_html.php') {
                        $Active[] = '1';
                    } else {
                        $Active[] = '0';
                    }

                    /**********************************************/
                }//for
            } else {
                echo $Data['Data'];
                die;
            }//if


            $C_Menu_Global->writeMenu($URL, $Nombre, $Active);
            //echo '<pre>';print_r($_SESSION);

            $RolEspacioFisico = $Data['Data'][0]['RolEspacioFisicoId'];

            $C_InterfazSolicitud->Principal($db, $RolEspacioFisico);
        }
        break;
}//switch


function MainGeneral(){

		
		global $C_InterfazSolicitud,$userid,$db,$codigorol;
		
		//var_dump(is_file("../templates/template.php"));die;
        include("../templates/template.php"); 	
        
        if(AJAX==false){  
            $db = writeHeader('Interfaz Solicitud',true);
        }else{
            $db = getBD();
        }
	
		include('InterfazSolicitud_class.php');  $C_InterfazSolicitud = new InterfazSolicitud();
        
       // echo 'Nmae->'.$_SESSION['MM_Username'];
	
		$SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
        
        

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		$userid=$Usario_id->fields['id'];
        $codigorol=$Usario_id->fields['codigorol'];
	}
function MainJson(){
	global $userid,$db,$codigorol;
		
		
		include("../templates/template.php");
		
		$db = getBD();
        
		$SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
         $codigorol=$Usario_id->fields['codigorol'];
	}
function JsGeneral(){
    ?>
    <link rel="stylesheet" href="../css/jquery.clockpick.1.2.9.css" type="text/css" /> 
    <link rel="stylesheet" href="../css/Styleventana.css" type="text/css" />
   
    <link rel="stylesheet" type="text/css" href="../asignacionSalones/css/jquery.datetimepicker.css"/>
    <script type="text/javascript" src="../asignacionSalones/js/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="../asignacionSalones/calendario3/wdCalendar/EventoSolicitud.js"></script>  
    <script type="text/javascript" src="../../mgi/js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>
    <script type="text/javascript" language="javascript" src="InterfazSolicitud.js"></script>
    <script type="text/javascript" language="javascript" src="SolicitudExterna.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.bpopup.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.min.js"></script>
    <!--------------------Js Para Alert Dise�o JAlert----------------------->
    <!--<script type="text/javascript" language="javascript" src="../js/JalertQuery/jquery.ui.draggable.js"></script>-->
    <script type="text/javascript" language="javascript" src="../js/JalertQuery/jquery.alerts.js"></script>
    <link rel="stylesheet" href="../js/JalertQuery/jquery.alerts.css" type="text/css" />        
   
    <script>
     $('#ui-datepicker-div').css('display','none');
     $('#BBIT_DP_CONTAINER').css('display','none');
     </script>
     
    <?PHP
}    
?>