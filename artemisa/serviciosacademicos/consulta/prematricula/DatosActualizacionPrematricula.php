<?php
include('CalculoSemestreEstudiante.php');

class DatosActualizacionPrematricula
{

    private $ordenPagoActual;
    private $codigoEstudiante;
    private $codigoPeriodo;
    private $db;
    private $codigoCarrera;
    private $calculoSemestre;

    /**
     * @return CalculoSemestreEstudiante
     */
    public function getCalculoSemestre()
    {
        return $this->calculoSemestre;
    }

    /**
     * @param CalculoSemestreEstudiante $calculoSemestre
     */
    public function setCalculoSemestre($calculoSemestre)
    {
        $this->calculoSemestre = $calculoSemestre;
    }


    public function __construct(array $ordenPagoActual, $codigoEstudiante, $codigoperiodo, $codigocarrera)
    {
        $db = Factory::createDbo();
        $this->ordenPagoActual = $ordenPagoActual;
        $this->codigoEstudiante = $codigoEstudiante;
        $this->codigoPeriodo = $codigoperiodo;
        $this->codigoCarrera = $codigocarrera;
        $this->db = $db;

        /**
         * calculamos el semestre actual del estudiante
         */

        $this->calculoSemestre = new CalculoSemestreEstudiante($this->obtenerMateriasPrematricula(),$this->codigoEstudiante);
    }


    /**
     * @return mixed
     * creditos calculados del estudiante
     */
    public function obtenerCreditosCalculados()
    {
        $sql = "
         select sum(m.numerocreditos) as creditosCalculados from estudiante e
         inner join prematricula p on e.codigoestudiante = p.codigoestudiante
         inner join detalleprematricula d on p.idprematricula = d.idprematricula
         inner join materia m on d.codigomateria = m.codigomateria
         where
         p.idprematricula =  '" . $this->ordenPagoActual['idprematricula'] . "'
         and d.codigoestadodetalleprematricula = 10
   ";

        $creditos = $this->db->GetRow($sql);
        return $creditos['creditosCalculados'];
    }

    /**
     * @return array
     * obenter materias de la prematricula actualmente registrada
     */
    public function obtenerMateriasPrematricula()
    {
        $sql = "
         select m.codigomateria,m.nombremateria,m.numerocreditos from estudiante e
         inner join prematricula p on e.codigoestudiante = p.codigoestudiante
         inner join detalleprematricula d on p.idprematricula = d.idprematricula
         inner join materia m on d.codigomateria = m.codigomateria
         where
         p.idprematricula =  '" . $this->ordenPagoActual['idprematricula'] . "'
         and d.codigoestadodetalleprematricula = 10
   ";

        $materias = $this->db->GetAll($sql);
        $returnMaterias = array();

        #se recorre materias para asigar indice de array con el codigo de la materia
        foreach ($materias as $materia) {
            $returnMaterias[$materia['codigomateria']] = $materia['nombremateria'];
        }

        return $returnMaterias;
    }

    public function getPorcentageCreditos()
    {
        $creditosBase = $this->getValorBaseMatricula($this->getValorDetalleCohorte());

        $creditosCalculados = $this->calculoSemestre->totalCreditosCalculados();

        if ($creditosCalculados <= $creditosBase['creditosBase']) {
            $porcentajecreditos = 50;
        } else {
            $porcentajecreditos = ($creditosCalculados * 100) / $this->calculoSemestre->totalCreditosSemestre();
        }

        $porcentajecreditos = round($porcentajecreditos, 1);
        return $porcentajecreditos;
    }

    /**
     * @return float|int
     * función para calcular cuanto vale el credito por semestre
     */
    public function calcularValorCredito()
    {
        #creditos totales del semestre al que pertenece el estudiante
        $creditosSemestre = $this->calculoSemestre->totalCreditosSemestre();

        $valordetallecohorte = $this->getValorDetalleCohorte();

        if ($creditosSemestre == 0 || is_null($creditosSemestre)) {
            $valor = 0;
        } else {
            $valor = $valordetallecohorte / $creditosSemestre;
        }
        return $valor;

    }//calcular_valorcredito

    public function saberMediaCargaOrdenActual()
    {
        $sql = "select sum(valorconcepto) as 'valorordenActual'
        from detalleordenpago
        where numeroordenpago = '" . $this->ordenPagoActual['numeroordenpago'] . "'";
        $valorOrden = $this->db->GetRow($sql);
        //se valida si el valor de la mitad del semestre es menor al valor
        //de la orden actual creada para determinar si se debe actualizar la orden o no
        if ($valorOrden['valorordenActual'] <= ($this->getValorDetalleCohorte() / 2)) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * valida si se debe cambiar el valor de la orden de acuerdo a la carga academica nueva
     * y antigua
     */
    public function seDebeActualizarOrden($valorNuevaMatricula)
    {
        if (($this->getPorcentageCreditos() <= 50 && $this->saberMediaCargaOrdenActual())
            || $this->ordenPagoActual['codigoestadoordenpago'] == 40) {
            return false;
        }
        return true;
    }

    public function crearNuevaOrdenPago(array $ordenPagoActual, $codigoestudiante)
    {
        $sqlMaxOrdenPago = "select (max(numeroordenpago)+1) as maxOrden from ordenpago";
        $idOrdenPago = $this->db->GetRow($sqlMaxOrdenPago);

        $sqlNuevaOrdenPago = "insert into ordenpago (numeroordenpago,codigoestudiante, fechaordenpago, idprematricula, fechaentregaordenpago,
                       codigoperiodo, codigoestadoordenpago, codigoimprimeordenpago, observacionordenpago,
                       codigocopiaordenpago, documentosapordenpago, idsubperiodo, idsubperiododestino,
                       documentocuentaxcobrarsap, documentocuentacompensacionsap, fechapagosapordenpago)
                       values(
                       '" . $idOrdenPago['maxOrden'] . "',
                       '" . $codigoestudiante . "',
                       NOW(),
                       '" . $ordenPagoActual['idprematricula'] . "',
                  NOW(),
                  '" . $ordenPagoActual['codigoperiodo'] . "',
                  10,       
                  '" . $ordenPagoActual['codigoimprimeordenpago'] . "',   
                  '" . $ordenPagoActual['observacionordenpago'] . "',       
                  '" . $ordenPagoActual['codigocopiaordenpago'] . "',       
                  '" . $ordenPagoActual['documentosapordenpago'] . "',          
                  '" . $ordenPagoActual['idsubperiodo'] . "',       
                  '" . $ordenPagoActual['idsubperiododestino'] . "',        
                  '" . $ordenPagoActual['documentocuentaxcobrarsap'] . "',          
                  '" . $ordenPagoActual['documentocuentacompensacionsap'] . "',         
                  '" . $ordenPagoActual['fechapagosapordenpago'] . "'       
                       )";


        $result = $this->db->Execute($sqlNuevaOrdenPago);

        if (is_object($result)) {
            return $idOrdenPago['maxOrden'];
        }
        #devuelve false si la consulta es fallida
        return $result;
    }
    public function updatePrematricula($idPrematricula, $semestrePrematriucla)
    {
        $sql = "UPDATE prematricula
                    SET semestreprematricula='".$semestrePrematriucla."'
                    WHERE idprematricula = '".$idPrematricula."'";
        $this->db->Execute($sql);
    }
    public function updateDetalleOrdenPago($valorMatriculaNueva, $idOrdenNueva)
    {
        $sql = "update detalleordenpago set valorconcepto = '" . $valorMatriculaNueva . "', numeroordenpago = '" . $idOrdenNueva . "' 
        where codigoconcepto = '151'
        and numeroordenpago = '" . $this->ordenPagoActual['numeroordenpago'] . "'";

        $this->db->Execute($sql);
    }

    public function getConceptoAporteBecas()
    {
        $query_pecuniario = "SELECT
									idvalorpecuniario
								FROM
									valorpecuniario
								WHERE
									codigoperiodo = $this->codigoPeriodo
								AND codigoestado = 100
                                AND codigoconcepto = 'C9106' LIMIT 1";
                                
        $response = $this->db->GetRow($query_pecuniario);

        return $response['idvalorpecuniario'];

    }

    public function updateAporteBecas($idOrdenNueva)
    {

        $codigoConceptoAporteBecas = $this->getConceptoAporteBecas();

        $sql = "insert into AportesBecas (numeroordenpago, idvalorpecuniario) values(". $idOrdenNueva. ", '". $codigoConceptoAporteBecas ."')";
        $this->db->Execute($sql);

        $sql2 = "update AportesBecas set codigoestado = '200'
        where numeroordenpago = '" . $this->ordenPagoActual['numeroordenpago'] . "'";

        $this->db->Execute($sql2);
    }

    public function updateDetalleSemillasOrdenPago($idOrdenNueva)
    {
        // se inactiva la siguiente sql para que no se inserten concepto semillas en detalle ordenpago
        $sql = "
            insert into detalleordenpago (numeroordenpago, codigoconcepto, cantidaddetalleordenpago, valorconcepto, codigotipodetalleordenpago)
            VALUES ('" . $idOrdenNueva . "','C9106',1,'35000',1);";

        // $this->db->Execute($sql);
    }

    public function crearFechaOrdenPago($idNuevo, $valorMatriculaNueva)
    {

        $fechasFinancieras = $this->getfechasFinancieras();
        foreach ($fechasFinancieras as $fechas) {
            $valorporcentaje = ($valorMatriculaNueva * $fechas['porcentajedetallefechafinanciera']) / 100;
            $valorfinal = $valorMatriculaNueva + $valorporcentaje;
            $sql = "
                insert into fechaordenpago (numeroordenpago, fechaordenpago, porcentajefechaordenpago, 
                valorfechaordenpago)
                values ('" . $idNuevo . "','" . $fechas['fechadetallefechafinanciera'] . "',
                '" . $fechas['porcentajedetallefechafinanciera'] . "','" . $valorfinal . "')
            ";
            $this->db->Execute($sql);
        }
    }


    public function actualizarOrdenDetallePrematricula($numeroOrdenNuevo)
    {
        $sql = "
            update detalleprematricula set numeroordenpago = '" . $numeroOrdenNuevo . "'
            where numeroordenpago = '" . $this->ordenPagoActual['numeroordenpago'] . "' 
            and codigoestadodetalleprematricula in (10,30);
        ";
        $this->db->Execute($sql);
    }


    /**
     * @return mixed
     * fecha financiera para saber los plazoz de pago de una orden
     */
    public function getfechasFinancieras()
    {
        $sql = "select dff.fechadetallefechafinanciera,porcentajedetallefechafinanciera 
        from fechafinanciera ff
        inner join detallefechafinanciera dff on ff.idfechafinanciera = dff.idfechafinanciera
        where ff.codigocarrera = '" . $this->codigoCarrera . "'
        and ff.codigoperiodo = '" . $this->codigoPeriodo . "';";

        $fechaFinanciera = $this->db->GetAll($sql);
        return $fechaFinanciera;
    }

    /**
     *
     */
    public function getCreditosOtraJornada()
    {
        $query = "select  sum(m.numerocreditos) as creditosOtraJornada
            from detalleprematricula dp
            inner join prematricula p on dp.idprematricula = p.idprematricula
            inner join estudiante e on p.codigoestudiante = e.codigoestudiante
            inner join grupo g on dp.idgrupo = g.idgrupo
            inner join horario h on g.idgrupo = h.idgrupo and h.horainicial < '18:00:00'
            inner join materia m on dp.codigomateria = m.codigomateria
            inner join carrera c on e.codigocarrera = c.codigocarrera
            inner join jornada j on e.codigojornada = j.codigojornada
            where dp.codigoestadodetalleprematricula in (10,30)
            and e.codigojornada = '02'
            and e.codigoestudiante = '" . $this->codigoEstudiante . "'
            and p.codigoperiodo = '" . $this->codigoPeriodo . "'
            and g.codigomateria in (" . $this->calculoSemestre->materiasString() . ")";

        $data = $this->db->GetRow($query);
        if(!$data)
        {
            return 0;
        }
        return isset($data['creditosOtraJornada'])?$data['creditosOtraJornada']:0;
    }


    /**
     * funcion para determinar el nuevo valor de la prematricula
     */
    public function calculoNuevoValorPrematricula()
    {
        $valorBaseMatricula = $valorBaseMatricula = $this->calculoSemestre->getValorBaseMatricula($this->getValorDetalleCohorte());
        $valorcredito = $this->calcularValorCredito();
        $valorcredito = round($valorcredito, 0);
        if ($this->getPorcentageCreditos() <= 50) {// 1% y 50% del valor de la matricula
            #este valor corresponde a la mitad del valor de la matricula
            $valorMatricula = $valorBaseMatricula['valorBase'];

        } else if ($this->getPorcentageCreditos() > 50) {// 51 y 100% del valor de la matricula
            $creditoscalculados = $this->calculoSemestre->totalCreditosCalculados();
            $valorMatricula = $valorcredito * $creditoscalculados;
        }

        #obtiene el valor del credito para otra jornada
        $valorCreditoOtraJornada = $this->getValorCreditoOtraJornada();
        #creditos pertenecientes a otra jornada
        $creditosOtraJornada = $this->getCreditosOtraJornada();
        $valorOtraJornada =  $valorCreditoOtraJornada * $creditosOtraJornada;
        $valorAdicionalOtraJornada = $valorOtraJornada - ($valorcredito * $creditosOtraJornada);
        $valorMatricula = $valorMatricula + $valorAdicionalOtraJornada;

        return $valorMatricula;
    }

    /**
     * @return mixed
     * obtener el cohorte de la carrera y el periodo
     */
    public function getCohorte()
    {
        $sql = "
           select * from cohorte
            where codigocarrera = '" . $this->codigoCarrera . "'
            and codigoperiodo = '" . $this->codigoPeriodo . "'
        ";

        $cohorte = $this->db->GetRow($sql);
        return $cohorte['numerocohorte'];
    }

    /**
     * @param $semestre
     * @return mixed
     * obtiene el valor detalle cohorte que se asemeja
     * al valor del semestre
     */
    public function getValorDetalleCohorte()
    {
        $sql = "
            SELECT d.valordetallecohorte, d.codigoconcepto
         FROM cohorte c, detallecohorte d, estudiante e
         WHERE c.numerocohorte = '" . $this->getCohorte() . "'
         AND c.codigocarrera = e.codigocarrera
         AND c.codigoperiodo = '" . $this->codigoPeriodo . "'
         and c.codigojornada = e.codigojornada
         AND c.codigoestadocohorte = '01'
         AND c.idcohorte = d.idcohorte
         and e.codigoestudiante = '" . $this->codigoEstudiante . "'
         AND d.semestredetallecohorte = '" . $this->calculoSemestre->calculoSemestreEstudiantes() . "'
        ";
        $valorDetalleCohorte = $this->db->GetRow($sql);
        return isset($valorDetalleCohorte['valordetallecohorte']) ? $valorDetalleCohorte['valordetallecohorte'] : 0;
    }

    public function getNumeroDocumentoEstudiante()
    {
        $sql = "
            select e2.numerodocumento from estudiante e
            inner join estudiantegeneral e2 on e.idestudiantegeneral = e2.idestudiantegeneral
            where e.codigoestudiante = '" . $this->codigoEstudiante . "'
        ";
        $data = $this->db->GetRow($sql);
        return $data['numerodocumento'];
    }

    public function anulaOrdenPagoActual()
    {
        $sql = "update ordenpago set codigoestadoordenpago = 20 
        where numeroordenpago = '" . $this->ordenPagoActual['numeroordenpago'] . "';";
        $this->db->Execute($sql);

        $rutaado = dirname(__FILE__) . "/../../../funciones/adodb/";
        require_once(dirname(__FILE__) . '/../interfacespeople/conexionpeople.php');
        require_once(dirname(__FILE__) . '/../../../nusoap/lib/nusoap.php');
        require_once(dirname(__FILE__) . '/../interfacespeople/reporteCaidaPeople.php');

        $results = array();
        $envio = 0;
        $servicioPS = verificarPSEnLinea();

        if ($servicioPS) {
            $client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 30);
            $err = $client->getError();
            if ($err) {
                echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
            }
            $proxy = $client->getProxy();
        }

        $query = "SELECT tipocuenta 
        FROM detalleordenpago dop 
        JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto 
       WHERE numeroordenpago='" . $this->ordenPagoActual['numeroordenpago'] . "' 
     GROUP BY tipocuenta";
//d($query);
        $exec = $this->db->GetAll($query);

        foreach ($exec as $row) {
            $arrTiposCuenta[] = $row['tipocuenta'];
        }

        if (in_array("PPA", $arrTiposCuenta)) {
            $parametros['UBI_OPERACION_ORD'] = 'R';
        } else {
            $parametros['UBI_OPERACION_ORD'] = 'A';
        }

        /**
        * Se consulta el campo eg.numerodocumento para conocer el numero de documento del estudiante de la orden
        * para la contruccion del XML, para Facturacion Electronica
        * @modified Lina Quintero<quinterolina@unbosque.edu.do>.
        * @since 10 de Septiembre de 2020.
        */

        $query = "SELECT dp.codigodocumentopeople, eg.numerodocumento
        FROM estudiantegeneral eg 
        JOIN documentopeople dp ON dp.tipodocumentosala = eg.tipodocumento 
       WHERE eg.numerodocumento='" . $this->getNumeroDocumentoEstudiante() . "'";
        $queryExec = $this->db->Execute($query);
        $row = $queryExec->FetchRow();

        $codigodocumentopeople = $row['codigodocumentopeople'];
        $numerodocumento = $row['numerodocumento'];

//verifica si la orden de pago es por concepto de inscripcion
        $query = "SELECT COUNT(*) as conteo 
        FROM detalleordenpago dop 
        JOIN concepto c ON dop.codigoconcepto=c.codigoconcepto 
       WHERE numeroordenpago ='" . $this->ordenPagoActual['numeroordenpago'] . "' 
         AND cuentaoperacionprincipal='153' 
         AND cuentaoperacionparcial='0001'";
//d($query);
        $queryExec = $this->db->Execute($query);
        $row = $queryExec->FetchRow();

        $invoiceNormal = true;
        if ($row['conteo'] == 0) {
            $parametros['INVOICE_ID'] = $this->ordenPagoActual['numeroordenpago'];
            $parametros['NATIONAL_ID_TYPE'] = $codigodocumentopeople;

            /*
             * @modified Andres Ariza <arizaandres@unbosque.edu.co>
             * Se modifica para que el numero de documento se consulte directamente de la base de datos con el numero de la orden de pago
             * @since January 16, 2017
            */
            $queryDocumento = "SELECT eg.numerodocumento 
                   FROM ordenpago o 
               INNER JOIN estudiante e on e.codigoestudiante=o.codigoestudiante 
               INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral  
                  WHERE o.numeroordenpago = " . mysql_real_escape_string($this->ordenPagoActual['numeroordenpago']);

            $queryEscDoc = $this->db->Execute($queryDocumento);
            $doc = $queryEscDoc->FetchRow();

            if (!empty($doc['numerodocumento'])) {
                $parametros['NATIONAL_ID'] = $doc['numerodocumento'];
            } else {
                $parametros['NATIONAL_ID'] = $_GET['documentoingreso'];
            }
            /* FIN MODIFICACION */

        } else {
          //Inscripcion
          /**
          * Se validar si fue creada la inscipcion como DUMMY o  NO para realizar el proceso correspondiente para la contruccion del XML
          * @modified Lina Quintero<quinterolina@unbosque.edu.do>.
          * @since 16 de Septiembre de 2020.
          */
            $sqlFechaOrdenPago="SELECT fechaordenpago  FROM ordenpago  WHERE  numeroordenpago=".$_GET['numeroordenpago'];
            $execsqlFechaOrdenPago= $this->db->Execute($sqlFechaOrdenPago);
            $rowsqlFechaOrdenPago = $execsqlFechaOrdenPago->FetchRow();

            if($rowsqlFechaOrdenPago['fechaordenpago']  <= '2020-09-17'){
            $parametros['INVOICE_ID'] = $this->ordenPagoActual['numeroordenpago'] . "-" . $codigodocumentopeople . $_GET['documentoingreso'];
            $parametros['NATIONAL_ID_TYPE'] = 'CC';
            $invoiceNormal = false;
            $query = "SELECT dummy 
            FROM logdummyintregracionps 
            WHERE " . $this->ordenPagoActual['numeroordenpago'] . " BETWEEN numeroordenpagoinicial AND numeroordenpagofinal";

            $execDummy = $this->db->Execute($query);
            $rowDummy = $execDummy->FetchRow();
            $parametros['NATIONAL_ID'] = $rowDummy["dummy"];

            }else{
               $parametros['INVOICE_ID'] = $this->ordenPagoActual['numeroordenpago'];
              $parametros['NATIONAL_ID_TYPE'] = $codigodocumentopeople;
              $invoiceNormal = false;
              $parametros['NATIONAL_ID'] = $numerodocumento;
            }
        }

        $parametros['BUSINESS_UNIT'] = 'UBSF0';

        $xml = "
           <m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
              <UBI_OPERACION_ORD>" . $parametros['UBI_OPERACION_ORD'] . "</UBI_OPERACION_ORD>
              <NATIONAL_ID_TYPE>" . $parametros['NATIONAL_ID_TYPE'] . "</NATIONAL_ID_TYPE>
              <NATIONAL_ID>" . $parametros['NATIONAL_ID'] . "</NATIONAL_ID>
              <INVOICE_ID>" . $parametros['INVOICE_ID'] . "</INVOICE_ID>
              <BUSINESS_UNIT>" . $parametros['BUSINESS_UNIT'] . "</BUSINESS_UNIT>
           </m:messageRequest>";
        if ($servicioPS) {
            $hayResultado = false;
            for ($i = 0; $i <= 5 && !$hayResultado; $i++) {
                // Envio de parametros por xml
                $start = time();
                $result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV', $xml);
                $time = time() - $start;
                $envio = 1;

                if (($time >= 30 || $result === false)) {
                    $envio = 0;
                    if ($i >= 5) {
                        reportarCaida(1, 'Anulacion Orden Pago');
                        $result['ERRNUM'] = 0;
                    }
                } else {
                    $hayResultado = true;
                }

                sleep(3); // this should halt for 3 seconds for every loop
            }

            //$result['ERRNUM']=1;
            //$result['DESCRLONG'] = 'La FACTURA no existe NO existe';

            if ($result['ERRNUM'] == 1 && strpos($result['DESCRLONG'], 'La FACTURA no existe') !== false) {
                //revisar si el estudiante ha cambiado de documento en este año de casualidad e intentar anularla con el antiguo

                $query = "SELECT ed.numerodocumento,d.nombrecortodocumento 
               FROM estudiantegeneral eg
                 INNER JOIN estudiantedocumento ed ON ed.idestudiantegeneral=eg.idestudiantegeneral
                 INNER JOIN documento d ON d.tipodocumento=ed.tipodocumento
               WHERE eg.numerodocumento='" . $_GET['documentoingreso'] . "' 
                 AND (fechavencimientoestudiantedocumento>='" . date('Y') . "-01-01' and fechavencimientoestudiantedocumento<='" . date('Y') . "-12-31')
                 AND eg.numerodocumento<>ed.numerodocumento 
                 AND eg.tipodocumento<>ed.tipodocumento
                ORDER BY fechavencimientoestudiantedocumento DESC";

                $row = $this->db->GetRow($query);

                if (count($row) > 0) {
                    if ($invoiceNormal) {
                        $parametros['INVOICE_ID'] = $this->ordenPagoActual['numeroordenpago'];
                        $parametros['NATIONAL_ID_TYPE'] = $row["nombrecortodocumento"];
                        $parametros['NATIONAL_ID'] = $row["numerodocumento"];
                    } else {
                        $parametros['INVOICE_ID'] = $this->ordenPagoActual['numeroordenpago'] . "-" . $row["nombrecortodocumento"] . $row["numerodocumento"];
                        $parametros['NATIONAL_ID_TYPE'] = 'CC';
                    }

                    $xml = " <m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
                    <UBI_OPERACION_ORD>" . $parametros['UBI_OPERACION_ORD'] . "</UBI_OPERACION_ORD>
                    <NATIONAL_ID_TYPE>" . $parametros['NATIONAL_ID_TYPE'] . "</NATIONAL_ID_TYPE>
                    <NATIONAL_ID>" . $parametros['NATIONAL_ID'] . "</NATIONAL_ID>
                    <INVOICE_ID>" . $parametros['INVOICE_ID'] . "</INVOICE_ID>
                    <BUSINESS_UNIT>" . $parametros['BUSINESS_UNIT'] . "</BUSINESS_UNIT>
                    </m:messageRequest>";

                    $start = time();
                    $result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV', $xml);
                    $time = time() - $start;
                    $envio = 1;
                    if ($time >= 30 || $result === false) {
                        $envio = 0;
                        reportarCaida(1, 'Anulacion Orden Pago');
                        $result['ERRNUM'] = 0;
                    } else {
                        $hayResultado = true;
                    }
                } else {
                    //anularla igual porque no existe en people
                    $result['ERRNUM'] = 0;
                }
            } else if ($result['ERRNUM'] == 1 && strpos($result['DESCRLONG'], 'La FACTURA esta en estado A') !== false) {
                //para que si la anule en SALA de todas formas porque en people ya se anulo
                $result['ERRNUM'] = 0;
            }
        } else {
            //para que si la anule en SALA de todas formas
            $result['ERRNUM'] = 0;
        }
        $query = "INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Anulacion Orden Pago','" . $xml . "','id:" . $result['ERRNUM'] . " descripcion: " . $result['DESCRLONG'] . "'," . $this->ordenPagoActual['numeroordenpago'] . "," . $envio . ")";
        $this->db->Execute($query);
    }

    public function getSemetresCarrera()
    {
        $sql = "select count(distinct d.semestredetalleplanestudio) as semestresCarrera 
            from estudiante e
            inner join planestudioestudiante p on e.codigoestudiante = p.codigoestudiante
            inner join planestudio p2 on p.idplanestudio = p2.idplanestudio
            inner join detalleplanestudio d on p.idplanestudio = d.idplanestudio
            where  p.codigoestudiante = '" . $this->codigoEstudiante . "'";
        $data = $this->db->GetRow($sql);
        #si no obtiene información
        if (!isset($data['semestresCarrera'])) {
            return 0;
        }
        return $data['semestresCarrera'];

    }

    public function getCreditosCarrera()
    {
        $sql = "select sum(d.numerocreditosdetalleplanestudio) as creditosCarrera
            from estudiante e
            inner join planestudioestudiante p on e.codigoestudiante = p.codigoestudiante
            inner join planestudio p2 on p.idplanestudio = p2.idplanestudio
            inner join detalleplanestudio d on p.idplanestudio = d.idplanestudio
            where  p.codigoestudiante = '" . $this->codigoEstudiante . "'";
        $data = $this->db->GetRow($sql);
        #si no obtiene información
        if (!isset($data['creditosCarrera'])) {
            return 0;
        }
        return $data['creditosCarrera'];
    }

    public function getValorBaseMatricula($valorDetalleCohorte)
    {
        $return = array();
        $creditosSemestre = $this->calculoSemestre->totalCreditosSemestre();
        if (($creditosSemestre % 2 != 0)) {
            #redondea la mitad impar a la unidad siguiente
            $creditosBase = round(($creditosSemestre / 2), 0, PHP_ROUND_HALF_UP);
        } else {
            #si es par se divide en 2
            $creditosBase = round(($creditosSemestre / 2));
        }

        $return['creditosBase'] = (int)$creditosBase;
        $return['valorBase'] = ($valorDetalleCohorte / 2);
        return $return;

    }

    public function getJornadaEstudiante()
    {
        $sql = "
            select j.codigojornada
            from estudiante e
            inner join carrera c on e.codigocarrera = c.codigocarrera
            inner join jornada j on e.codigojornada = j.codigojornada
            where e.codigoestudiante = '" . $this->codigoEstudiante . "'
        ";

        $data = $this->db->GetRow($sql);
        if (!$data) {
            return 0;
        }
        return $data['codigojornada'];
    }

    public function getPeriodoActual()
    {
        $sql = "select p.codigoperiodo from periodo p where p.fechainicioperiodo <= now()
            and p.fechavencimientoperiodo >= now()
            order by p.codigoperiodo desc
            limit 1;";
        $data = $this->db->GetRow($sql);
        if (!$data) {
            return 0;
        }
        return $data['codigoperiodo'];
    }

    /**
     * @return float|int
     * obtenemos el valor del crtedito de
     * otra jornada segun formula de reglamento estudiantil
     */
    public function getValorCreditoOtraJornada()
    {
        $valor = 0;
        $tabla = "";
        $Condicion = "";
        if ($this->codigoEstudiante) {
            $query_selplanestudiante = "select p.idplanestudio
       from planestudioestudiante p, planestudio pe
       where p.codigoestudiante = '" . $this->codigoEstudiante . "'
       and p.idplanestudio = pe.idplanestudio
       and pe.codigoestadoplanestudio like '1%'
            and p.codigoestadoplanestudioestudiante like '1%'";
            $row_selplanestudiante = $this->db->GetRow($query_selplanestudiante);
            $idplan = $row_selplanestudiante['idplanestudio'];
            if ($idplan == '615' || $idplan == 615) {
                $Condicion = ' AND c.idplanestudio=516';
            } else {
                $tabla = '';
                $Condicion = "";
            }
        }


        // Voy a la tabla jornadacarrera y hallo el plan de estudio y la cohorte
        // de la que debe sacar el valor
        $query_selcobroexcedente = "select c.nombrecobroexcedentecambiojornada, c.idplanestudio, c.idcohorte
               from cobroexcedentecambiojornada c, subperiodo s, carreraperiodo cp " . $tabla . "
               where c.codigojornada = '" . $this->getJornadaEstudiante() . "'
               and c.codigocarrera = '" . $this->codigoCarrera . "'
               and c.codigoestado like '1%'
               and cp.codigoperiodo = '" . $this->getPeriodoActual() . "'
               and s.idcarreraperiodo = cp.idcarreraperiodo
               and s.idsubperiodo = c.idsubperiodo 
                 " . $Condicion . ";";
        $row_selcobroexcedente = $this->db->GetRow($query_selcobroexcedente);

        // Ahora con la cohorte y el semestre hallo el valor
        $query_selcohorte = "select max(dc.valordetallecohorte) as valordetallecohorte
   from detallecohorte dc
   where dc.idcohorte = '" . $row_selcobroexcedente['idcohorte'] . "'";
        $row_selcohorte = $this->db->GetRow($query_selcohorte);

        // Ahora con el plan de estudio hallo el numero de creditos del plan de estudios, y hallo el valor por credito
        // del plan de estudio
        $query_selcreditosplan = "SELECT p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio,
               p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio,
               c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre,
               p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio, dp.codigomateria,
               dp.semestredetalleplanestudio, sum(dp.numerocreditosdetalleplanestudio) as creditos
               FROM planestudio p, carrera c, tipocantidadelectivalibre t, detalleplanestudio dp
               WHERE p.codigocarrera = c.codigocarrera
               AND p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
               AND p.idplanestudio = '" . $row_selcobroexcedente['idplanestudio'] . "'
               and p.idplanestudio = dp.idplanestudio
               group by 1";

        $row_selcreditosplan = $this->db->GetRow($query_selcreditosplan);

        // Multiplico el numero de semestres del plan de estudio por la cohorte mas alta y lo divido por los creditos del plan de estudio
        if (isset($row_selcreditosplan['creditos']) && $row_selcreditosplan['creditos'] == 0) {
            $valor = 0;
        } else {
            $valor = $row_selcohorte['valordetallecohorte'] * $row_selcreditosplan['cantidadsemestresplanestudio'] /
                $row_selcreditosplan['creditos'];
        }

        return $valor;
    }
}