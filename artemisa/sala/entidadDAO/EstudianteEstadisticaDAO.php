<?php namespace Sala\entidadDAO;

use Sala\interfaces\EntidadDAO;
use Sala\entidad;

//defined('_EXEC') or die;

class EstudianteEstadisticaDAO
{

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type LogGrupo
     * @access private
     */
    private $estudianteEstadisticaEntity;

    private $arrayLifeProcess;
    private $lifeProccessStudent;

    private $tableName = "estudianteestadistica";

    public function __construct(\EstudianteEstadistica $estudianteEstadistica)
    {
        $this->setDb();
        $this->estudianteEstadisticaEntity = $estudianteEstadistica;
        $this->arrayLifeProcess = $this->validateSituationsStudent();
    }

    public function setDb()
    {
        $this->db = \Factory::createDbo();
    }


    public function save()
    {
        #se setea por defecto query de insercion
        $query = $this->getInsertQueryBody();
        $where = array();
        $idestudianteestadis = $this->estudianteEstadisticaEntity->getIdestudianteestadistica();

        if (!is_null($idestudianteestadis)) {
            $query = $this->getUpdateQueryBody();
        }

        $rs = $this->db->Execute($query);

        if (!$rs) {
            return false;
        }

        return true;
    }

    public function getInsertQueryBody()
    {
        $query = " INSERT INTO " . $this->tableName . " 
        (codigoestudiante,
        estudianteestadisticafechainicial,
        estudianteestadisticafechafinal,
        codigoperiodo,
        codigoprocesovidaestudiante,
        codigoestado,
        observacionestudianteestadistica
        ) values
        (        
            " . $this->estudianteEstadisticaEntity->getCodigoestudiante() . ",
            '" . $this->estudianteEstadisticaEntity->getEstudianteestadisticafechainicial() . "',
            '" . $this->estudianteEstadisticaEntity->getEstudianteestadisticafechafinal() . "',
             " . $this->estudianteEstadisticaEntity->getCodigoperiodo() . ",
             '" . $this->estudianteEstadisticaEntity->getCodigoprocesovidaestudiante() . "',
             '" . $this->estudianteEstadisticaEntity->getCodigoestado() . "',
             '" . $this->estudianteEstadisticaEntity->getObservacionestudianteestadistica() . "'
        );";

        return $query;
    }

    public function getUpdateQueryBody()
    {
        $query = "UPDATE " . $this->tableName . " SET 
        codigoestudiante = " . $this->estudianteEstadisticaEntity->getCodigoestudiante() . ",
        estudianteestadisticafechainicial = '" . $this->estudianteEstadisticaEntity->getEstudianteestadisticafechainicial() . "',
        estudianteestadisticafechafinal = '" . $this->estudianteEstadisticaEntity->getEstudianteestadisticafechafinal() . "',
        codigoperiodo =  " . $this->estudianteEstadisticaEntity->getCodigoperiodo() . ",
        codigoprocesovidaestudiante =  '" . $this->estudianteEstadisticaEntity->getCodigoprocesovidaestudiante() . "',
        codigoestado =  '" . $this->estudianteEstadisticaEntity->getCodigoestado() . "',
        observacionestudianteestadistica =  '" . $this->estudianteEstadisticaEntity->getObservacionestudianteestadistica() . "'
        where idestudianteestadistica = '" . $this->estudianteEstadisticaEntity->getIdestudianteestadistica() . "'
         ";

        return $query;
    }

    public function studentSituationInput()
    {
        $arrayProcesoVida = $this->validateSituationsStudent();
        $situacionEstudiante = $this->getStudentSituation();

        #si si obtiene una situacion del estudiante.
        if (!is_null(isset($situacionEstudiante['codigosituacioncarreraestudiante']) ?
            $situacionEstudiante['codigosituacioncarreraestudiante'] : null)) {

            #Perdida de la Calidad de Estudiante Academica
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 100) {
                /**
                 * no aplica para estadisticas
                 */
            }
            #Perdida de la Calidad de Estudiante Disciplinaria
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 101) {
                /**
                 * no aplica para estadisticas
                 */
            }
            #Perdida de la Calidad de Estudiante Administrativa
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 102) {
                /**
                 * no aplica para estadisticas
                 */

            }
            #Perdida de la Calidad de Estudiante Voluntaria
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 103) {
                /**
                 * no aplica para estadisticas
                 */
            }
            #Egresado
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 104) {
                /**
                 * 401 - Matriculado antiguo
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                $older = $this->esMatriculadoAntiguo();
                $new = $this->esMatriculadoNuevo();
                #si es estudiante nuevo registra en estadisticas
                if($new) { $this->SaveMatriculadoNuevo(); }
                #si es antiguo registra en estadisticas
                if($older) { $this->saveMatriculadoAntiguo(); }

            }
            #Admitido que no Ingreso
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 105) {
                /**
                 * 200 - inscrito
                 * 201 - inscritoo no evaluado
                 * 300 - admitido
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción de admitido que no ingreso por si no la tiene
                $this->saveAdmitidoQueNoIngreso();
                #guarda estadistica de admitido
                $this->saveAdmitido();
            }
            #Preinscrito
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 106) {
                /**
                 * 101 - aspirante
                 */
                #guardamos aspirante
                $this->saveAspirante();
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
            }
            #Inscrito
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 107) {
                /**
                 * 200 - inscrito
                 * 201 - inscrito no evaluado
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
            }
            #Reserva de cupo
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 108) {
                /**
                 * 400 - Matriculado nuevo
                 * 401 - Matriculado antiguo
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                $older = $this->esMatriculadoAntiguo();
                $new = $this->esMatriculadoNuevo();
                #si es estudiante nuevo registra en estadisticas
                if($new) { $this->SaveMatriculadoNuevo(); }
                #si es antiguo registra en estadisticas
                if($older) { $this->saveMatriculadoAntiguo(); }
            }
            #Registro Anulado
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 109) {
                /**
                 * 700 - Deserto
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                #guardamos decersion en la estadistica
                $this->saveDeserto();

            }
            #Pendiente Decision Consejo Facultad
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 110) {
                /**
                 * no aplica para estadisticas
                 */
            }
            #Inscrito sin pago
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 111) {
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
            }
            #Terminacion de curso o educacion no formal
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 112) {
                /**
                 * no aplica para estadisticas
                 */
            }
            #No Admitido
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 113) {
                /**
                 *202 - Evaluados no admitidos
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                #guardamos evaluado no admitido por si no la tiene
                $this->saveEvaluadoNoAdmitido();
            }
            #En proceso de financiación
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 114) {
                /**
                 * 300 - Admitido
                 * 203 - Lista de espera
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                #guardamos en admitidos
                $this->saveAdmitido();
            }
            #Lista en Espera
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 115) {
                /**
                 * 300 - Admitido
                 * 203 - Lista de espera
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                #guardamos en admitidos
                $this->saveAdmitido();
                #guardamos lista de espera
                $this->saveListaDeEspera();
            }
            #Prueba Academica
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 200) {
                /**
                 * no aplica para estadisticas
                 */
            }
            #Admitido
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 300) {
                /**
                 * 400 - Matriculado nuevo
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                #guardamos en admitidos
                $this->saveAdmitido();
                $new = $this->esMatriculadoNuevo();
                #si es estudiante nuevo registra en estadisticas
                if($new) { $this->SaveMatriculadoNuevo(); }
            }
            #Normal
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 301) {
                /**
                 * 300 - admitido
                 * 400 - Matriculado antiguo
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                #guardamos en admitidos
                $this->saveAdmitido();
                $older = $this->esMatriculadoAntiguo();
                #si es estudiante nuevo registra en estadisticas
                if($older) { $this->saveMatriculadoAntiguo(); }

            }
            #Solicitud reserva de cupo
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 302) {
                /**
                 * 400 - Matriculado nuevo
                 * 401 - Matriculado antiguo
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                $older = $this->esMatriculadoAntiguo();
                $new = $this->esMatriculadoNuevo();
                #si es estudiante nuevo registra en estadisticas
                if($new) { $this->SaveMatriculadoNuevo(); }
                #si es antiguo registra en estadisticas
                if($older) { $this->saveMatriculadoAntiguo(); }
            }
            #Terminacion periodo de movilidad
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 303) {
                /**
                 * 700 - Deserto
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                #guardamos decersion en la estadistica
                $this->saveDeserto();
            }
            #Graduado
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 400) {
                /**
                 *  401 - Matriculado antiguo
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                $older = $this->esMatriculadoAntiguo();
                #si es antiguo registra en estadisticas
                if($older) { $this->saveMatriculadoAntiguo(); }
            }
            #En proceso de Grado
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 500) {
                /**
                 *  401 - Matriculado antiguo
                 */
                #guardamos inscripción por si no la tiene
                $this->saveIncripcion();
                #guardamos inscripción no evaluado por si no la tiene
                $this->saveInscritoNoEvaluado();
                $older = $this->esMatriculadoAntiguo();
                #si es antiguo registra en estadisticas
                if($older) { $this->saveMatriculadoAntiguo(); }
            }
            #Reconocimiento de Saberes
            if ($situacionEstudiante['codigosituacioncarreraestudiante'] == 501) {
                /**
                 * no aplica para estadisticas
                 */
            }
        }

    }


    /**
     * @return array
     * obtener lista de proceso vida estudiante por codigoestudiante previamente seteado.
     */
    public function lifeProccessStuden()
    {
        $lista = $this->estudianteEstadisticaEntity->getList('codigoestudiante = ' . $this->estudianteEstadisticaEntity->getCodigoestudiante());
        $ActualsProccess = array();
        foreach ($lista as $row) {
            $ActualsProccess[] = $row->getCodigoprocesovidaestudiante();
        }

        return $ActualsProccess;
    }

    public function getStadisticsStudentByStudent()
    {
        $return = array();
        $db = $this->db;
        $query = "SELECT * FROM estudianteestadistica "
            . " WHERE codigoestudiante " . $this->estudianteEstadisticaEntity->getCodigoestudiante() . " order by idestudianteestadistica desc ;";

        $datos = $db->Execute($query);

        while ($d = $datos->GetRow()) {
            $estudianteEstadistic = new \EstudianteEstadistica();
            $estudianteEstadistic->setIdestudianteestadistica(@$d['idestudianteestadistica']);
            $estudianteEstadistic->setCodigoestudiante($d['codigoestudiante']);
            $estudianteEstadistic->setEstudianteestadisticafechainicial($d['estudianteestadisticafechainicial']);
            $estudianteEstadistic->setEstudianteestadisticafechafinal($d['estudianteestadisticafechafinal']);
            $estudianteEstadistic->setCodigoperiodo($d['codigoperiodo']);
            $estudianteEstadistic->setCodigoprocesovidaestudiante($d['codigoprocesovidaestudiante']);
            $estudianteEstadistic->setCodigoestado($d['codigoestado']);
            $estudianteEstadistic->setObservacionestudianteestadistica($d['observacionestudianteestadistica']);

            $return[] = $estudianteEstadistic;
            unset($estudianteEstadistic);
        }
        return $return;
    }

    public function validateSituationsStudent()
    {
        $arrayLifeProccess = $this->lifeProccessStuden();

        return $arrayLifeProccess;
    }

    public function getStudentSituation()
    {
        $query = "select codigosituacioncarreraestudiante from estudiante where codigoestudiante = " . $this->estudianteEstadisticaEntity->getCodigoestudiante();
        $data = $this->db->GetRow($query);
        return $data;
    }



    public function getDateGeneralStudent()
    {
        $query = "select distinct eg.*
        from estudiantegeneral eg
                 inner join estudiante e on eg.idestudiantegeneral = e.idestudiantegeneral
        where e.codigoestudiante = " . $this->estudianteEstadisticaEntity->getCodigoestudiante();

        $data = $this->db->GetRow($query);

        if (!$data) {
            $data = $this->setNullDataGeneralStudent();
        }

        return $data;
    }

    public function updateDatesStadisticsStudent()
    {
        $query = "select distinct ee.*
        from estudianteestadistica ee
        where ee.codigoestudiante = ".$this->estudianteEstadisticaEntity->getCodigoestudiante()." order by idestudianteestadistica desc limit 1";
        $data = $this->db->GetRow($query);
        if (is_array($data)) {
            $queryUpdate = "update estudianteestadistica 
            set estudianteestadisticafechafinal = '" . date('Y-m-d') . "'
            where idestudianteestadistica = " . $data['idestudianteestadistica'] . ";";
            $this->db->Execute($queryUpdate);
        }
    }

    public function setNullDataGeneralStudent()
    {
        $data = array();
        $data['idestudiantegeneral'] = "";
        $data['idtrato'] = "";
        $data['idestadocivil'] = "";
        $data['tipodocumento'] = "";
        $data['numerodocumento'] = "";
        $data['expedidodocumento'] = "";
        $data['numerolibretamilitar'] = "";
        $data['numerodistritolibretamilitar'] = "";
        $data['expedidalibretamilitar'] = "";
        $data['nombrecortoestudiantegeneral'] = "";
        $data['nombresestudiantegeneral'] = "";
        $data['apellidosestudiantegeneral'] = "";
        $data['fechanacimientoestudiantegeneral'] = "";
        $data['idciudadnacimiento'] = "";
        $data['codigogenero'] = "";
        $data['direccionresidenciaestudiantegeneral'] = "";
        $data['direccioncortaresidenciaestudiantegeneral'] = "";
        $data['ciudadresidenciaestudiantegeneral'] = "";
        $data['telefonoresidenciaestudiantegeneral'] = "";
        $data['telefono2estudiantegeneral'] = "";
        $data['celularestudiantegeneral'] = "";
        $data['direccioncorrespondenciaestudiantegeneral'] = "";
        $data['direccioncortacorrespondenciaestudiantegeneral'] = "";
        $data['ciudadcorrespondenciaestudiantegeneral'] = "";
        $data['telefonocorrespondenciaestudiantegeneral'] = "";
        $data['emailestudiantegeneral'] = "";
        $data['email2estudiantegeneral'] = "";
        $data['fechacreacionestudiantegeneral'] = "";
        $data['fechaactualizaciondatosestudiantegeneral'] = "";
        $data['codigotipocliente'] = "";
        $data['casoemergenciallamarestudiantegeneral'] = "";
        $data['telefono1casoemergenciallamarestudiantegeneral'] = "";
        $data['telefono2casoemergenciallamarestudiantegeneral'] = "";
        $data['idtipoestudiantefamilia'] = "";
        $data['eps_estudiante'] = "";
        $data['tipoafiliacion'] = "";
        $data['idciudadorigen'] = "";
        $data['esextranjeroestudiantegeneral'] = "";
        $data['FechaDocumento'] = "";
        $data['idpaisnacimiento'] = "";
        $data['GrupoEtnicoId'] = "";
        $data['EstadoActualizaDato'] = "";

        return $data;
    }

    /**
     * @return mixed
     * saber si es matricualdo antiguo
     */
    public function esMatriculadoAntiguo()
    {
        $queryAdition = "select codigoperiodo
                from periodo
                where fechainicioperiodo <= NOW()
                and codigoperiodo not in (
                select codigoperiodo from periodo where fechainicioperiodo <= NOW() and fechavencimientoperiodo >= NOW()";
        $data = $this->saberMatriculaPagaPorPeriodo($queryAdition);

        if($data == false)
        {
            return false;
        }

        return true;
    }

    public function esInscritoNoEvaluado()
    {
        $query="
            SELECT es.codigoestudiante	
                        FROM AsignacionEntrevistas a
                        INNER JOIN estudiantecarrerainscripcion ec ON a.IdEstudianteCarreraInscripcion = ec.idestudiantecarrerainscripcion
                        INNER JOIN estudiante es on ec.idestudiantegeneral = es.idestudiantegeneral
                        INNER JOIN Entrevistas en on a.EntrevistaId = en.EntrevistaId
                        INNER JOIN CarreraSalones cs on en.CarreraSalonId = cs.CarreraSalonId
                        inner join inscripcion i on (ec.idinscripcion = i.idinscripcion and ec.idestudiantegeneral = i.idestudiantegeneral)
                        WHERE a.EstadoAsignacionEntrevista = 400
                        and cs.CodigoCarrera = es.codigocarrera
                        and es.codigoperiodo = ".$this->estudianteEstadisticaEntity->getCodigoperiodo()."
                        and i.codigoperiodo = ".$this->estudianteEstadisticaEntity->getCodigoperiodo()."
                        and es.codigosituacioncarreraestudiante IN (107, 111)
                        and ec.codigoestado = 100
                        and es.codigoestudiante = ".$this->estudianteEstadisticaEntity->getCodigoestudiante()." limit 1 ";

        $data = $this->db->GetRow($query);
        return $data;
    }
    
    /**
     * @return mixed
     * saber si es matricualdo nuevo
     */
    public function esMatriculadoNuevo()
    {
        $queryAdition = "select codigoperiodo
                from periodo
                where fechainicioperiodo <= NOW() and fechavencimientoperiodo >= NOW() limit 1";

        $periodo = $this->db->GetRow($queryAdition);
        $data = $this->saberMatriculaPagaPorPeriodo($periodo['codigoperiodo']);

        if($data == false)
        {
            return false;
        }

        return true;
    }

    public function saberMatriculaPagaPorPeriodo($condition)
    {
        $query = "select p.*
            from prematricula p
                     inner join detalleprematricula dp on p.idprematricula = dp.idprematricula
                     inner join ordenpago o on dp.numeroordenpago = o.numeroordenpago
                     inner join detalleordenpago d on o.numeroordenpago = d.numeroordenpago
                     inner join estudiante e on o.codigoestudiante = e.codigoestudiante
            where e.codigoestudiante = ".$this->estudianteEstadisticaEntity->getCodigoestudiante()."
              and p.codigoestadoprematricula = 40
              and o.codigoestadoordenpago = 40
              and d.codigoconcepto = 151
              and o.codigoperiodo IN (
                $condition
             ));";

        $data = $this->db->GetAll($query);
        return $data;
    }

    /**
     * guarda estadistica inscripcion
     */
    public function saveIncripcion()
    {
        if (!in_array(200, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos
            $dateGeneralStudent = $this->getDateGeneralStudent();
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial($dateGeneralStudent['fechacreacionestudiantegeneral']);
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 200 (Inscritos)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(200);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();

        }
    }

    /**
     * guarda estadistica inscripcion
     */
    public function saveInscritoNoEvaluado()
    {
        if (!in_array(201, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos

            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial(date('Y-m-d'));
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 201 (InscritosNoEvaluados)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(201);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();
        }
    }

    public function saveAdmitidoQueNoIngreso()
    {
        if (!in_array(105, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos

            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial(date('Y-m-d'));
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 201 (InscritosNoEvaluados)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(410);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();
        }
    }

    /**
     * guarda estadistica inscripcion
     */
    public function saveAdmitido()
    {
        if (!in_array(300, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos

            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial(date('Y-m-d'));
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 201 (InscritosNoEvaluados)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(300);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();
        }
    }
    /**
     * guarda estadistica matriculado antiguo
     */
    public function saveMatriculadoAntiguo()
    {
        if (!in_array(401, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos
            $dateGeneralStudent = $this->getDateGeneralStudent();
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial(date('Y-m-d'));
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 401 (Matriculados_Antiguos)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(401);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();

        }
    }

    /**
     * guarda estadistica matriculadoNuevo
     */
    public function saveMatriculadoNuevo()
    {
        if (!in_array(400, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos
            $dateGeneralStudent = $this->getDateGeneralStudent();
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial(date('Y-m-d'));
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 401 (Matriculados_Antiguos)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(400);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();

        }
    }

    /**
     * guarda estadistica Aspirante
     */
    public function saveAspirante()
    {
        if (!in_array(101, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos

            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial(date('Y-m-d'));
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 201 (InscritosNoEvaluados)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(101);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();
        }
    }

    /**
     * guarda estadistica Deserto
     */
    public function saveDeserto()
    {
        if (!in_array(700, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos

            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial(date('Y-m-d'));
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 700 (Deserto)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(700);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();
        }
    }

    /**
     * guarda estadistica Evaluados no admitidos
     */
    public function saveEvaluadoNoAdmitido()
    {
        if (!in_array(202, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos

            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial(date('Y-m-d'));
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 202 (Deserto)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(202);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();
        }
    }

    /**
     * guarda estadistica Evaluados no admitidos
     */
    public function saveListaDeEspera()
    {
        if (!in_array(203, $this->validateSituationsStudent())) {
            #se toma la fecha de creacion del estudiante general para insercion de estadistica inscritos

            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechainicial(date('Y-m-d'));
            $this->estudianteEstadisticaEntity->setEstudianteestadisticafechafinal('2999-12-31');
            #se setea proceso vida estudiante en 202 (Deserto)
            $this->estudianteEstadisticaEntity->setCodigoprocesovidaestudiante(203);
            $this->estudianteEstadisticaEntity->setCodigoestado(100);
            $this->estudianteEstadisticaEntity->setObservacionestudianteestadistica('Creado por EstudianteEstadistica DAO');
            $this->updateDatesStadisticsStudent();
            $this->save();
        }
    }
}