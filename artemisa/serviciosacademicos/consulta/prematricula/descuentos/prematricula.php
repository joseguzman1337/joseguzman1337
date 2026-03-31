<?php

require_once("estudiante.php");
class Prematricula{

	private $db;
    private $numeroOrdenPago;
    private $codigoEstudiante;

	public function __construct( $db , $numeroOrdenPago , $codigoEstudiante =null ) {
       
        $this->db = $db;
        $this->numeroOrdenPago = $numeroOrdenPago;
        $this->codigoEstudiante = $codigoEstudiante;
    }		

    public function prematriculaOrdenPago( ) {
	    $sql = "SELECT idprematricula FROM ordenpago WHERE ".
        " numeroordenpago = " . $this->numeroOrdenPago . " AND codigoestudiante = " . $this->codigoEstudiante;
	    $prematricula = $this->db->GetRow( $sql );
	    return $prematricula["idprematricula"];
    }

    public function semestrePrematriculaOrdenPago( ) {
	    $sql = "SELECT p.semestreprematricula FROM ordenpago o ".
        " inner join prematricula p on o.idprematricula = p.idprematricula ".
        " WHERE o.codigoestudiante = ".$this->codigoEstudiante." and o.numeroordenpago = " . $this->numeroOrdenPago . " ";
	    $prematricula = $this->db->GetRow( $sql );
	    return $prematricula["semestreprematricula"];
    }

    private function detallePrematricula( ) {
        $codigoMaterias = "";
        $sql = "SELECT codigomateria FROM detalleprematricula ".
        " WHERE codigoestadodetalleprematricula = 10 ".
        " AND numeroordenpago = " . $this->numeroOrdenPago . " ";
        $materias = $this->db->GetAll( $sql );

        foreach ( $materias as $mt ) {
            if ($codigoMaterias == "") {
                $codigoMaterias = $mt["codigomateria"];
            } else {
                $codigoMaterias = $codigoMaterias . "," . $mt["codigomateria"];
            }
        }
        return $codigoMaterias;
    }

    public function creditoPrematricula( ) {
		$estudiante = new Estudiante( $this->db , $this->codigoEstudiante );
        $idPrematricula = $this->prematriculaOrdenPago();

        $sql = "SELECT sum(numerocreditosdetalleplanestudio) as creditos ".
        " FROM detalleplanestudio ".
        " WHERE idplanestudio = " . $estudiante->planEstudioEstudiante( ) . " ".
        " AND codigomateria IN (" . $this->detallePrematricula( $this->numeroOrdenPago ) . ") ".
        " AND semestredetalleplanestudio=" . $estudiante->semetreEstudiante( $idPrematricula ) . "";
        $creditos = $this->db->GetRow($sql);
        return $creditos["creditos"];
    }

    public function planestudioEstudiante(){
	    $sql= "select p.idplanestudio from planestudioestudiante p where p.codigoestudiante = ".$this->codigoEstudiante." ".
        " and p.codigoestadoplanestudioestudiante in (100,101)";
	    $planestudio = $this->db->GetRow($sql);
	    return $planestudio['idplanestudio'];
    }

    public function creditosPlanEstudio($semestre, $idplan){
        $sqlplanestuidio = "select sum(pe.numerocreditosdetalleplanestudio) as 'sumcreditos' from detalleplanestudio pe ".
        " where pe.idplanestudio = ".$idplan ." and pe.semestredetalleplanestudio =". $semestre." ";
        $planestudio = $this->db->GetRow($sqlplanestuidio);
        return $planestudio['sumcreditos'];
    }

    public function creditosPrematriculados($codigoperiodo, $cantidad = null){
        $auxArray = false;
        $numeroOrdenPago = $this->numeroOrdenPago;
        $numerocreditos = 0;
        //consulta para obtener el codigo de estudiante por medio de la orden de pago
        $sql = "SELECT codigoestudiante FROM ordenpago WHERE numeroordenpago = $numeroOrdenPago";
        $responseQuery = $this->db->GetRow($sql);
        $this->codigoEstudiante =  $responseQuery['codigoestudiante'];
        $codigoestudiante =  $this->codigoEstudiante;

        $semestreprematricula= $this->semestrePrematriculaOrdenPago();
        $idplanestudio= $this->planestudioEstudiante();

        //consulta las materias prematriculas o matriculadas del estudiante
        $sqlmaterias= "SELECT d.codigomateria, d.codigomateriaelectiva, edp.nombreestadodetalleprematricula, ".
        " d.idgrupo, d.numeroordenpago ".
        " FROM detalleprematricula d ".
        " inner join prematricula p on d.idprematricula = p.idprematricula ".
        " inner join materia m on d.codigomateria = m.codigomateria ".
        " inner join estudiante e on p.codigoestudiante = e.codigoestudiante ".
        " inner join estadodetalleprematricula edp on d.codigoestadodetalleprematricula = edp.codigoestadodetalleprematricula ".
        " where e.codigoestudiante = $codigoestudiante ".
        " and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') ".
        " and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or ".
        " d.codigoestadodetalleprematricula = '23') and p.codigoperiodo = $codigoperiodo";
        $listamaterias = $this->db->GetAll($sqlmaterias);

        //si usa la funcion de consulta de total creditos generica para el semestre especifico
        if (!empty($listamaterias)) {
            require_once(realpath(dirname(__FILE__) . "/../CalculoSemestreEstudiante.php"));
            $calculocreditos = new CalculoSemestreEstudiante($listamaterias, $this->codigoEstudiante);
            $sumcreditos = $calculocreditos->totalCreditosSemestre($semestreprematricula);
        }else{
            $sumcreditos = 0;
        }

        foreach($listamaterias as $rowmateria){
            // Selecciona los datos de las materias para aquellas que no son electivas, de acuerdo al plan de estudio
            $query_datosmateria = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, ".
            " dpe.numerocreditosdetalleplanestudio as numerocreditos ".
            " from materia m ".
            " inner join detalleplanestudio dpe on m.codigomateria = dpe.codigomateria ".
            " inner join planestudioestudiante pee on pee.idplanestudio = dpe.idplanestudio ".
            " where m.codigomateria = ".$rowmateria['codigomateria']." ".
            " and pee.codigoestudiante = $codigoestudiante and pee.codigoestadoplanestudioestudiante like '1%'";
            $datosmateria = $this->db->GetRow($query_datosmateria);
            $contadordatosmateria = count($datosmateria);

            if($contadordatosmateria == 0) {
                // Toma los datos de la materia si es enfasis
                $query_datosmateriaenfasis = "select m.nombremateria, m.codigomateria, " .
                    " dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio, " .
                    " dle.numerocreditosdetallelineaenfasisplanestudio as numerocreditos " .
                    " from materia m " .
                    " inner join detallelineaenfasisplanestudio dle on m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio " .
                    " inner join lineaenfasisestudiante lee on lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio " .
                    " and lee.idplanestudio = dle.idplanestudio " .
                    " where m.codigomateria = " . $rowmateria['codigomateria'] . " " .
                    " and lee.codigoestudiante = $codigoestudiante " .
                    " and dle.codigoestadodetallelineaenfasisplanestudio like '1%' " .
                    " and (NOW() between lee.fechainiciolineaenfasisestudiante and lee.fechavencimientolineaenfasisestudiante)";
                $datosmateriaenfasis = $this->db->GetRow($query_datosmateriaenfasis);
                $contadordatosmateriaelectiva = count($datosmateriaenfasis);

                if ($contadordatosmateriaelectiva == 0) {
                    // Mira si tiene papa, si el papa es electiva libre toma los creditos directamente del hijo
                    // Si no tiene papa toma los datos como si fuera una materia externa
                    $query_datosmateriapapa = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio," .
                        " dpe.numerocreditosdetalleplanestudio as numerocreditos,
                            dpe.codigotipomateria, gm.codigotipogrupomateria
                            from grupomaterialinea gml, materia m, grupomateria gm, detalleplanestudio dpe, planestudioestudiante pee
                            where gm.codigoperiodo = $codigoperiodo
                            and gml.codigomateria = " . $rowmateria['codigomateriaelectiva'] . "
                            and gml.codigoperiodo = gm.codigoperiodo
                            and gm.codigoperiodo = gml.codigoperiodo
                            and pee.codigoestudiante = '$codigoestudiante'
                            and pee.idplanestudio = dpe.idplanestudio
                            and dpe.codigomateria = m.codigomateria
                            and gml.codigomateria = m.codigomateria
                            and gml.idgrupomateria = gm.idgrupomateria
                            and pee.codigoestadoplanestudioestudiante like '1%'
                            order by m.nombremateria";
                    $datosmateriapapa = $this->db->GetRow($query_datosmateriapapa);
                    $contadordatosmateriapapa = count($datosmateriapapa);

                    if ($contadordatosmateriapapa == 0) {
                        // En el caso de haber hecho la prematricula y de tratarse de una materia externa en carga academica se
                        // Actualmente todos los planes de estudio tiene el ismo numero de creditos para una materia
                        $query_datosmateriaexterna = "select m.nombremateria, m.codigomateria, m.numerocreditos " .
                            " from materia m " .
                            " where m.codigomateria = " . $rowmateria['codigomateria'] . " and m.codigoestadomateria = '01'";
                        $datosmateriaexterna = $this->db->GetRow($query_datosmateriaexterna);
                        $numerocreditos += $datosmateriaexterna['numerocreditos'];
                    }
                    else {
                        $eselectivatecnica = false;
                        // Si entra aca quiere decir que la materia tiene hijos.
                        if ($datosmateriapapa['codigotipogrupomateria'] == "100") {
                            // Materia electiva libre
                            // Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella
                            $query_datosmateriaelectivalibre = "select m.nombremateria, m.codigomateria, m.numerocreditos " .
                                " from materia m where m.codigomateria = " . $rowmateria['codigomateria'] . " " .
                                " and m.codigoestadomateria = '01'";
                            $datosmateriaelectivalibre = $this->db->GetRow($query_datosmateriaelectivalibre);
                            $numerocreditos += $datosmateriaelectivalibre['numerocreditos'];

                        } else if ($datosmateriapapa['codigotipogrupomateria'] == "200") {
                            // Materia electiva tecnica
                            $query_datosmateriaelectivatecnica = "select m.nombremateria, m.codigomateria, m.numerocreditos " .
                                " from materia m where m.codigomateria = " . $rowmateria['codigomateria'] . " " .
                                " and m.codigoestadomateria = '01'";
                            $datosmateriaelectivatecnica = $this->db->GetRow($query_datosmateriaelectivatecnica);
                            $eselectivatecnica = true;
                        }

                        if ($eselectivatecnica == true) {
                            $numerocreditos += $datosmateriapapa['numerocreditos'];
                        }
                    }
                }
                else {
                    $numerocreditos += $datosmateriaenfasis['numerocreditos'];
                }
            }
            else{
                $numerocreditos += $datosmateria['numerocreditos'];
            }
        }//foreach

        if($cantidad){
            $resultadocreditos = array('creditosprematriculados'=>$numerocreditos, 'creditossemestre'=> $sumcreditos);
            return $resultadocreditos;
        }

        if($numerocreditos >= $sumcreditos){
            $auxArray = true;
        }
        return $auxArray;
    }

    public function calcular_valormatriculaotrajornada($codigocarrera, $codigoperiodo, $codigojornada,$codigoestudiante=false){ //,
        $valor = 0;
        $tabla ="";
        $Condicion = "";
        if(isset($codigocarrera) && !empty($codigocarrera)){
            $sqlmodalidad = "select codigomodalidadacademica from carrera where codigocarrera = $codigocarrera";
            $row_modalidad=$this->db->GetRow($sqlmodalidad);
            // debido a que los programas de pregrado manejan jornada nocturna para los demas devuelve 0
            if(!empty($row_modalidad['codigomodalidadacademica']) && $row_modalidad['codigomodalidadacademica'] != "200"){
                $valor =0;
            }else{
                $valor = 0;
                if($codigoestudiante){
                    $query_selplanestudiante= "select p.idplanestudio from planestudioestudiante p, planestudio pe ".
                    " where p.codigoestudiante = '$codigoestudiante' and p.idplanestudio = pe.idplanestudio ".
                    " and pe.codigoestadoplanestudio like '1%' and p.codigoestadoplanestudioestudiante like '1%'";
                    $row_selplanestudiante =$this->db->GetRow($query_selplanestudiante);
                    $idplan = $row_selplanestudiante['idplanestudio'];
                    if($idplan=='615' || $idplan==615){
                        $Condicion = ' AND c.idplanestudio=516';
                    }else{
                        $tabla = '';
                        $Condicion = "";
                    }
                }

                // Voy a la tabla jornadacarrera y hallo el plan de estudio y la cohorte
                // de la que debe sacar el valor
                $query_selcobroexcedente = "select c.nombrecobroexcedentecambiojornada, c.idplanestudio, c.idcohorte ".
                " from cobroexcedentecambiojornada c, subperiodo s, carreraperiodo cp ".$tabla." ".
                " where c.codigojornada = '$codigojornada' and c.codigocarrera = '$codigocarrera' ".
                " and c.codigoestado like '1%' and cp.codigoperiodo = '$codigoperiodo' ".
                " and s.idcarreraperiodo = cp.idcarreraperiodo and s.idsubperiodo = c.idsubperiodo $Condicion ";
                $row_selcobroexcedente = $this->db->GetRow($query_selcobroexcedente);

                if(isset($row_selcobroexcedente['idcohorte'])) {
                    // Ahora con la cohorte y el semestre hallo el valor
                    $query_selcohorte = "select max(dc.valordetallecohorte) as valordetallecohorte " .
                        " from detallecohorte dc where dc.idcohorte = '" . $row_selcobroexcedente['idcohorte'] . "'";
                    $row_selcohorte = $this->db->GetRow($query_selcohorte);

                    if (!isset($row_selcobroexcedente['idplanestudio']) || empty($row_selcobroexcedente['idplanestudio'])) {
                        $idplan = $row_selplanestudiante['idplanestudio'];
                    } else {
                        $idplan = $row_selcobroexcedente['idplanestudio'];
                    }
                    // Ahora con el plan de estudio hallo el numero de creditos del plan de estudios, y hallo el valor por credito
                    // del plan de estudio
                    $query_selcreditosplan = "SELECT p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio, " .
                        " p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio, " .
                        " c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre, " .
                        " p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio, dp.codigomateria, " .
                        " dp.semestredetalleplanestudio, sum(dp.numerocreditosdetalleplanestudio) as creditos " .
                        " FROM planestudio p, carrera c, tipocantidadelectivalibre t, detalleplanestudio dp " .
                        " WHERE p.codigocarrera = c.codigocarrera " .
                        " AND p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre " .
                        " AND p.idplanestudio = '" . $idplan . "' and p.idplanestudio = dp.idplanestudio group by 1";
                    $row_selcreditosplan = $this->db->GetRow($query_selcreditosplan);

                    // Multiplico el numero de semestres del plan de estudio por la cohorte mas alta y lo divido por los creditos del plan de estudio
                    if (isset($row_selcreditosplan['creditos']) && $row_selcreditosplan['creditos'] == 0) {
                        $valor = 0;
                    } else {
                        $valor = $row_selcohorte['valordetallecohorte'] * $row_selcreditosplan['cantidadsemestresplanestudio'] /
                            $row_selcreditosplan['creditos'];
                    }
                }
            }
        }
        return $valor;
    }

    public function getCreditosOtraJornada($codigoEstudiante, $codigoperiodo){
	    $sqlmaterias = "select d.codigomateria from detalleprematricula d ".
        " inner join prematricula p on d.idprematricula = p.idprematricula ".
        " where p.codigoperiodo = $codigoperiodo and p.codigoestudiante= $codigoEstudiante ".
        " and d.codigoestadodetalleprematricula in (10, 30) and p.codigoestadoprematricula in (10, 40)";
	    $materias = $this->db->GetAll($sqlmaterias);
        $materiaslista="";
	    foreach($materias as $lista){
	        $materiaslista.=  $lista['codigomateria'].", ";
        }
        $materiaslista = substr($materiaslista, 0, -2);

        $query = "select  sum(m.numerocreditos) as creditosOtraJornada ".
            " from detalleprematricula dp ".
            " inner join prematricula p on dp.idprematricula = p.idprematricula ".
            " inner join estudiante e on p.codigoestudiante = e.codigoestudiante ".
            " inner join grupo g on dp.idgrupo = g.idgrupo ".
            " inner join horario h on g.idgrupo = h.idgrupo and h.horainicial < '18:00:00' ".
            " inner join dia d on d.codigodia = h.codigodia and h.codigodia not in (6) ".
            " inner join materia m on dp.codigomateria = m.codigomateria ".
            " inner join carrera c on e.codigocarrera = c.codigocarrera ".
            " inner join jornada j on e.codigojornada = j.codigojornada ".
            " where dp.codigoestadodetalleprematricula in (10,30) and e.codigojornada = '02' ".
            " and e.codigoestudiante = '" . $codigoEstudiante . "' and p.codigoperiodo = '" . $codigoperiodo . "' ".
            " and g.codigomateria in (" . $materiaslista . ")";
            $data = $this->db->GetRow($query);
            if(!$data){
                return 0;
            }
            return isset($data['creditosOtraJornada'])?$data['creditosOtraJornada']:0;
        }
    }