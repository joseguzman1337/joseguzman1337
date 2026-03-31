<?php
class CalculoSemestreEstudiante
{

    private $materiasSeleccionadas = array();
    private $codigoEstudiante;
    private $semestre;
    private $db;


    public function __construct(array $materiasSeleccionadas,$codigoEstudiante)
    {
        $db = Factory::createDbo();
        $this->materiasSeleccionadas = $materiasSeleccionadas;
        $this->codigoEstudiante = $codigoEstudiante;
        $this->db = $db;
    }

    /**
     * @return string
     * retorna las materias en un string separadas por ,
     */
    public function materiasString()
    {
        $materiasString = implode ( "," , array_keys ($this->materiasSeleccionadas));
        return $materiasString;
    }

    /**
     * @return array
     * valida si hay materias electivas
     */
    public function materiasSeleccionadasElectivas()
    {
        $sql = "select codigomateria,codigomateriaelectiva from detalleprematricula dp
        inner join prematricula p on dp.idprematricula = p.idprematricula
        where p.codigoestudiante = '".$this->codigoEstudiante."'
        and dp.codigoestadodetalleprematricula in (10,30)
        and dp.codigomateriaelectiva not in (0) 
        and dp.codigomateria in (".$this->materiasString().");";

        $data = $this->db->GetAll($sql);

        if ($data != false)
        {
            return $data;
        }
        return array();
    }

    public function semestrePertenecenElectivas(array $materiasElectivas)
    {
        $returnMateriasElctivas = array();
        foreach($materiasElectivas as $materias)
        {
            $sql = "select distinct dpe.semestredetalleplanestudio,dpe.numerocreditosdetalleplanestudio from detalleplanestudio dpe
            inner join planestudioestudiante p on dpe.idplanestudio = p.idplanestudio
            inner join detalleprematricula d on dpe.codigomateria = d.codigomateriaelectiva
            where p.codigoestudiante = '".$this->codigoEstudiante."'
            and d.codigomateria = '".$materias['codigomateria']."'";

            $data = $this->db->GetRow($sql);

            $returnMateriasElctivas[] = $data;
        }
        return $returnMateriasElctivas;
    }

    /**
     * @param $arrayObligatorias
     * @param $arrayElectivas
     * @return array
     * funcion para constriur un solo array de materias obligatorias y electivas
     */
    public function mergeArrayMateriasSemestres($arrayObligatorias,$arrayElectivas)
    {

        $semestres = array();
        $creditos = array();
        $contOblig = 0;
            #se recorren array de materias obligatorias
            foreach ($arrayObligatorias as $obligatoria) {
                $semestres[$contOblig] = (int)$obligatoria['semestredetalleplanestudio'];
                $creditos[$contOblig] = (int)$obligatoria['creditos'];
                $contOblig++;
            }
        #se recorren arrays de electivas
        foreach($arrayElectivas as $electivas){
            #verifica si existe el semestre en el array para sumar creditos al semestre
            if(in_array($electivas['semestredetalleplanestudio'],$semestres))
            {
                #obtiene el key del array del semestre encontrado
                $key = array_search($electivas['semestredetalleplanestudio'],$semestres);
                #se suman creditos del semestre encontrado
                $creditos[$key] = $creditos[$key]+(int)($electivas['numerocreditosdetalleplanestudio']);
            }else
                {
                    $semestres[$contOblig] =(int)$electivas['semestredetalleplanestudio'];
                    $creditos[$contOblig] = (int)$electivas['numerocreditosdetalleplanestudio'];
                    $contOblig++;
                }
        }
        array_multisort($creditos,SORT_DESC,$semestres);
        return array('s' => $semestres,'c' => $creditos);
    }
    /**
     * Calcula en que semestre esta el estudiante dependeiendo el numero de materias a prematricular
     */
    public function calculoSemestreEstudiantes()
    {
        $semestres = array();
        $materiasElectivasArray = $this-> materiasSeleccionadasElectivas();
        $materiasElectivas = $this->semestrePertenecenElectivas($materiasElectivasArray);

        $materiasString = $this->materiasString();
        $query = "select d.semestredetalleplanestudio,sum(d.numerocreditosdetalleplanestudio) as creditos from planestudioestudiante pee
                        inner join detalleplanestudio d on pee.idplanestudio = d.idplanestudio
                        where pee.codigoestudiante = '".$this->codigoEstudiante."' and
                        d.codigomateria in (".$materiasString.")
                        AND pee.codigoestadoplanestudioestudiante in (100, 101)
                        group by   d.semestredetalleplanestudio
                        order by creditos desc;
                        ";
        //almacena datos de detalleplanestudio para saber a que semestre pertenece una materia
        $dataSemestreMateria = $this->db->GetAll($query);
        $contadorSemestre = count($dataSemestreMateria);
        if ($contadorSemestre==0 && empty($materiasElectivas)) {

            $dataSemestreMateria = array();
            // si las materias no estan en el plan de estudio entonces se procede a buscar el ultimo semestre en el que estuvo matriculado el estudiante
             $query ="SELECT semestreprematricula FROM prematricula
                    WHERE codigoestudiante = '".$this->codigoEstudiante."'
                    AND codigoestadoprematricula in (40, 41)
                    and semestreprematricula not in (0) 
                    order by idprematricula desc limit 1;";
            $dataSemestrep = $this->db->GetRow($query);
            // valida si existe el semestre de la prematricula si no se define el semestre en 1
            if (!empty($dataSemestrep)){
                $semestreEstudiante= $dataSemestrep['semestreprematricula'];
            }else{
                $semestreEstudiante = 1;
            }

        }
        else {
            # cuando las materias electivas y obligatorias pertenecen al plan del estudiante
            $semestreObligElect = $this->mergeArrayMateriasSemestres($dataSemestreMateria, $materiasElectivas);
            $semestreEstudiante = $this->conteoSemestres($semestreObligElect);
        }

        return $semestreEstudiante;


    }

    /**
     * @param array $semestres
     * @return mixed
     * funcion para contar semestres en el array
     */
    public function conteoSemestres(array $semestresCreditos)
    {
       $semestreAnt = 0;
        $creditosAnt = 0;
        $creditosmayor = 0;
        $semes = 0;
        $cont = 0;
        $semestresCreditosIguales = array();
        foreach ($semestresCreditos['c'] as $key => $conteoCreditos)
        {
            if($conteoCreditos > $cont) {
                $semes = $semestresCreditos['s'][$key];
                $creditosmayor = $conteoCreditos;
            }
            else if($conteoCreditos == $cont )
                {
                    $semestresCreditosIguales[$semestresCreditos['s'][$key]] = array($semestresCreditos['s'][$key],$conteoCreditos);
                    $semestresCreditosIguales[$semestreAnt] = array($semestreAnt,$creditosAnt);
                }
            $cont = $conteoCreditos;
            $semestreAnt = $semestresCreditos['s'][$key];
            $creditosAnt = $cont;
        }

        if(count($semestresCreditosIguales)>0)
        {
            foreach($semestresCreditosIguales as $semestreRepetidoCreditos)
            {
                if($semestreRepetidoCreditos[1] > $creditosmayor)
                {
                    $semes = min($semestresCreditosIguales);
                }
            }

        }
        $this->semestre = $semes;
        return $semes;
    }

    /**
     * @return mixed
     * realiza la sumatoria del total de creditos del semestre.
     */
    public function totalCreditosSemestre($semestre = null){
        $enfasis = $this->tieneLineaEnfasis();
        if(!$enfasis){
            //si existe un valor pata el semestre de calculo
            if(!empty($semestre)){
                $semestredetalleplanestudio = $semestre;
            }else{
                //si no existe se usa la funcion del calculo
                $semestredetalleplanestudio = $this->calculoSemestreEstudiantes();
            }
            // consulta el total de creditos de matricula del plan de estudios del estudiante para un semestre especifico
            $query = "select sum(numerocreditosdetalleplanestudio) totalCreditos ".
            " from detalleplanestudio ".
            " where semestredetalleplanestudio = '".$semestredetalleplanestudio."' ".
            " and idplanestudio = (select distinct pee.idplanestudio from planestudioestudiante pee ".
            " inner join detalleplanestudio d on pee.idplanestudio = d.idplanestudio ".
            " where pee.codigoestudiante = '".$this->codigoEstudiante."' ".
            " AND pee.codigoestadoplanestudioestudiante  in (100, 101))";
            $data = $this->db->GetRow($query);
            return $data['totalCreditos'];
        }
        else{
            $creditosEnfasis = $this->getNumeroCreditosEnfasisPlan($enfasis);
            $creditosCargaInicial = $this->getMateriasPlanEstudio($enfasis);
            return (int)$creditosEnfasis + (int)$creditosCargaInicial;
        }
    }

    /**
     * @param $idPlanEstudioEnfasis
     * @return int
     * saber numero de creditos del plan estudio enfasis por le semestre actual del estudiante
     */
    public function getNumeroCreditosEnfasisPlan($idPlanEstudioEnfasis)
    {
        $sql = " 
           select sum(numerocreditosdetallelineaenfasisplanestudio) as creditosEnfasis
            from detallelineaenfasisplanestudio where idlineaenfasisplanestudio = '".$idPlanEstudioEnfasis."'
            and semestredetallelineaenfasisplanestudio = '".$this->calculoSemestreEstudiantes()."'
        ";
        $data = $this->db->GetRow($sql);
        if(!$data)
        {
            return 0;
        }
        return isset($data['creditosEnfasis'])?$data['creditosEnfasis']:0;
    }

    public function getMateriasPlanEstudio($idPlanEstudioEnfasis)
    {
        $sql="select sum(numerocreditosdetalleplanestudio) as  totalCreditos
                from detalleplanestudio
                where semestredetalleplanestudio = '".$this->calculoSemestreEstudiantes()."'
                  and idplanestudio = (select distinct pee.idplanestudio
                                       from planestudioestudiante pee
                                       inner join detalleplanestudio d on pee.idplanestudio = d.idplanestudio
                                       where pee.codigoestudiante = '".$this->codigoEstudiante."'
                                       AND pee.codigoestadoplanestudioestudiante  in (100, 101))";

        $data = $this->db->GetRow($sql);
        if(!$data) {
            $creditosPlanEstudioEstudiante = 0;
        }
        else {
            $creditosPlanEstudioEstudiante =  isset($data['totalCreditos'])?$data['totalCreditos']:0;
        }
        $creditosRestarMateriPadreEnfasis = $this->materiaPadreEnfasisPlanEstudio($idPlanEstudioEnfasis);

        $creditosTotales = $creditosPlanEstudioEstudiante - $creditosRestarMateriPadreEnfasis;
        return $creditosTotales;
    }

    public function materiaPadreEnfasisPlanEstudio($idPlanEstudiEnfasis)
    {
        $sql = "
                select distinct dp.codigomateria, m.numerocreditos from detallelineaenfasisplanestudio dp
                inner join materia m on dp.codigomateria = m.codigomateria
                where dp.idlineaenfasisplanestudio = '".$idPlanEstudiEnfasis."'
                and dp.semestredetallelineaenfasisplanestudio = '".$this->calculoSemestreEstudiantes()."'
        ";

        $data = $this->db->GetRow($sql);
        return isset($data['numerocreditos'])?$data['numerocreditos']:0;
    }

    public function tieneLineaEnfasis()
    {
        $sql = "
            select * from lineaenfasisestudiante where codigoestudiante = '".$this->codigoEstudiante."'
            and fechavencimientolineaenfasisestudiante > now() limit 1
        ";

        $data = $this->db->GetRow($sql);
        if(!$data)
        {
            return false;
        }

        return isset($data['idlineaenfasisplanestudio'])?$data['idlineaenfasisplanestudio']:false;
    }

    public function totalCreditosCalculados($ordenActualActiva = "")
    {

        $sql = "
            select sum(numerocreditos) as creditosCalculados from materia where codigomateria in (".$this->materiasString().");
        ";

        $data = $this->db->GetRow($sql);
        return isset($data['creditosCalculados'])?$data['creditosCalculados']:0;
    }

    public function validarOrdenActualActiva($numeroOrdenActual = 0)
    {
        if ($numeroOrdenActual != 0) {
            $sql = "select * from ordenpago where numeroordenpago = '" . $numeroOrdenActual . "'";
            $orden = $this->db->GetRow($sql);
            if (count($orden) > 0) {
                return $orden;
            }
        }
        return false;
    }

    public function anulaOrdenPagoActual($numeroOrdenActual)
    {

        $sql = "update ordenpago set codigoestadoordenpago = 20 
        where numeroordenpago = '".$numeroOrdenActual."';";
        $this->db->Execute($sql);

        $rutaado = dirname(__FILE__)."/../../../funciones/adodb/";
        require_once(dirname(__FILE__).'/../interfacespeople/conexionpeople.php');
        require_once(dirname(__FILE__).'/../../../nusoap/lib/nusoap.php');
        require_once(dirname(__FILE__).'/../interfacespeople/reporteCaidaPeople.php');

        $results=array();
        $envio=0;
        $servicioPS = verificarPSEnLinea();

        if($servicioPS){
            $client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 30);
            $err = $client->getError();
            if ($err){
                echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
            }
            $proxy = $client->getProxy();
        }

        $query="SELECT tipocuenta 
		  FROM detalleordenpago dop 
		  JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto 
		 WHERE numeroordenpago='".$numeroOrdenActual."' 
	  GROUP BY tipocuenta";
        $exec = $this->db->GetAll($query);

        foreach($exec as $row){
            $arrTiposCuenta[]=$row['tipocuenta'];
        }

        if(in_array("PPA",$arrTiposCuenta)){
            $parametros['UBI_OPERACION_ORD']='R';
        } else {
            $parametros['UBI_OPERACION_ORD']='A';
        }

        /**
        * Se consulta el campo eg.numerodocumento para conocer el numero de documento del estudiante de la orden
        * para la contruccion del XML, para Facturacion Electronica
        * @modified Lina Quintero<quinterolina@unbosque.edu.do>.
        * @since 10 de Septiembre de 2020.
        */ 
        $query="SELECT dp.codigodocumentopeople, eg.numerodocumento 
		  FROM estudiantegeneral eg 
		  JOIN documentopeople dp ON dp.tipodocumentosala = eg.tipodocumento 
		 WHERE eg.numerodocumento='".$this->getNumeroDocumentoEstudiante()."'";
        $queryExec = $this->db->Execute($query);
        $row = $queryExec->FetchRow();

        $codigodocumentopeople=$row['codigodocumentopeople'];
        $numerodocumento = $row['numerodocumento'];

//verifica si la orden de pago es por concepto de inscripcion
        $query="SELECT COUNT(*) as conteo 
		  FROM detalleordenpago dop 
		  JOIN concepto c ON dop.codigoconcepto=c.codigoconcepto 
		 WHERE numeroordenpago ='".$numeroOrdenActual."' 
		   AND cuentaoperacionprincipal='153' 
		   AND cuentaoperacionparcial='0001'";

        $queryExec = $this->db->Execute($query);
        $row = $queryExec->FetchRow();

        $invoiceNormal = true;
        if($row['conteo']==0) {
            $parametros['INVOICE_ID']=$numeroOrdenActual;
            $parametros['NATIONAL_ID_TYPE']=$codigodocumentopeople;

            /*
             * @modified Andres Ariza <arizaandres@unbosque.edu.co>
             * Se modifica para que el numero de documento se consulte directamente de la base de datos con el numero de la orden de pago
             * @since January 16, 2017
            */
            $queryDocumento = "SELECT eg.numerodocumento 
						 FROM ordenpago o 
				   INNER JOIN estudiante e on e.codigoestudiante=o.codigoestudiante 
				   INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral  
						WHERE o.numeroordenpago = ".mysql_real_escape_string($numeroOrdenActual);

            $queryEscDoc = $this->db->Execute($queryDocumento);
            $doc = $queryEscDoc->FetchRow();

            if(!empty($doc['numerodocumento'])){
                $parametros['NATIONAL_ID']=$doc['numerodocumento'];
            }else{
                $parametros['NATIONAL_ID']=$_GET['documentoingreso'];
            }
            /* FIN MODIFICACION */

        } else {
            //inscripcion
            /**
            * Se validar si fue creada la inscipcion como DUMMY o  NO para realizar el proceso correspondiente para la contruccion del XML 
            * @modified Lina Quintero<quinterolina@unbosque.edu.do>.
            * @since 16 de Septiembre de 2020.
            */ 
           $sqlFechaOrdenPago="SELECT fechaordenpago  FROM ordenpago  WHERE  numeroordenpago=".$_GET['numeroordenpago'];
           $execsqlFechaOrdenPago= $this->db->Execute($sqlFechaOrdenPago);
           $rowsqlFechaOrdenPago = $execsqlFechaOrdenPago->FetchRow();

            if($rowsqlFechaOrdenPago['fechaordenpago'] <= '2020-09-17'){
                $parametros['INVOICE_ID']=$numeroOrdenActual."-".$codigodocumentopeople.$_GET['documentoingreso'];
                $parametros['NATIONAL_ID_TYPE']='CC';
                $invoiceNormal=false;
                $query = "SELECT dummy 
                    FROM logdummyintregracionps 
                    WHERE ".$numeroOrdenActual." BETWEEN numeroordenpagoinicial AND numeroordenpagofinal";
                    $execDummy = $this->db->Execute($query);
                    $rowDummy = $execDummy->FetchRow();
                     $parametros['NATIONAL_ID']=$rowDummy["dummy"];

            }else{
                $parametros['INVOICE_ID']=$numeroOrdenActual;
                $parametros['NATIONAL_ID_TYPE']=$codigodocumentopeople;
                $invoiceNormal=false;
                $parametros['NATIONAL_ID']=$numerodocumento;
            }
        }

        $parametros['BUSINESS_UNIT']='UBSF0';

        $xml="
	        <m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
	        	<UBI_OPERACION_ORD>".$parametros['UBI_OPERACION_ORD']."</UBI_OPERACION_ORD>
	        	<NATIONAL_ID_TYPE>".$parametros['NATIONAL_ID_TYPE']."</NATIONAL_ID_TYPE>
	        	<NATIONAL_ID>".$parametros['NATIONAL_ID']."</NATIONAL_ID>
	        	<INVOICE_ID>".$parametros['INVOICE_ID']."</INVOICE_ID>
	        	<BUSINESS_UNIT>".$parametros['BUSINESS_UNIT']."</BUSINESS_UNIT>
	        </m:messageRequest>";
        if($servicioPS){
            $hayResultado = false;
            for($i=0; $i <= 5 && !$hayResultado; $i++){
                // Envio de parametros por xml
                $start = time();
                $result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
                $time =  time()-$start;
                $envio = 1;

                if(($time>=30 || $result===false)){
                    $envio=0;
                    if($i>=5){
                        reportarCaida(1,'Anulacion Orden Pago');
                        $result['ERRNUM']=0;
                    }
                } else {
                    $hayResultado = true;
                }

                sleep(3); // this should halt for 3 seconds for every loop
            }

            if($result['ERRNUM']==1 && strpos($result['DESCRLONG'],'La FACTURA no existe')!== false){
                //revisar si el estudiante ha cambiado de documento en este año de casualidad e intentar anularla con el antiguo

                $query = "SELECT ed.numerodocumento,d.nombrecortodocumento 
					FROM estudiantegeneral eg
			        INNER JOIN estudiantedocumento ed ON ed.idestudiantegeneral=eg.idestudiantegeneral
			        INNER JOIN documento d ON d.tipodocumento=ed.tipodocumento
				   WHERE eg.numerodocumento='".$_GET['documentoingreso']."' 
				     AND (fechavencimientoestudiantedocumento>='".date('Y')."-01-01' and fechavencimientoestudiantedocumento<='".date('Y')."-12-31')
				     AND eg.numerodocumento<>ed.numerodocumento 
				     AND eg.tipodocumento<>ed.tipodocumento
				    ORDER BY fechavencimientoestudiantedocumento DESC";

                $row = $this->db->GetRow($query);

                if(count($row)>0){
                    if($invoiceNormal) {
                        $parametros['INVOICE_ID']=$numeroOrdenActual;
                        $parametros['NATIONAL_ID_TYPE']=$row["nombrecortodocumento"];
                        $parametros['NATIONAL_ID']=$row["numerodocumento"];
                    } else {
                        $parametros['INVOICE_ID']=$numeroOrdenActual."-".$row["nombrecortodocumento"].$row["numerodocumento"];
                        $parametros['NATIONAL_ID_TYPE']='CC';
                    }

                    $xml=" <m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
				        <UBI_OPERACION_ORD>".$parametros['UBI_OPERACION_ORD']."</UBI_OPERACION_ORD>
				        <NATIONAL_ID_TYPE>".$parametros['NATIONAL_ID_TYPE']."</NATIONAL_ID_TYPE>
				        <NATIONAL_ID>".$parametros['NATIONAL_ID']."</NATIONAL_ID>
				        <INVOICE_ID>".$parametros['INVOICE_ID']."</INVOICE_ID>
				        <BUSINESS_UNIT>".$parametros['BUSINESS_UNIT']."</BUSINESS_UNIT>
				        </m:messageRequest>";

                    $start = time();
                    $result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
                    $time =  time()-$start;
                    $envio = 1;
                    if( $time>=30 || $result===false ){
                        $envio=0;
                        reportarCaida(1,'Anulacion Orden Pago');
                        $result['ERRNUM']=0;
                    } else {
                        $hayResultado = true;
                    }
                } else {
                    //anularla igual porque no existe en people
                    $result['ERRNUM']=0;
                }
            } else if($result['ERRNUM']==1 && strpos($result['DESCRLONG'],'La FACTURA esta en estado A')!== false){
                //para que si la anule en SALA de todas formas porque en people ya se anulo
                $result['ERRNUM']=0;
            }
        } else {
            //para que si la anule en SALA de todas formas
            $result['ERRNUM']=0;
        }
        $query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Anulacion Orden Pago','".$xml."','id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG']."',".$numeroOrdenActual.",".$envio.")";
        $this->db->Execute($query);
    }

    public function getNumeroDocumentoEstudiante()
    {
        $sql = "
            select e2.numerodocumento from estudiante e
            inner join estudiantegeneral e2 on e.idestudiantegeneral = e2.idestudiantegeneral
            where e.codigoestudiante = '".$this->codigoEstudiante."'
        ";
        $data = $this->db->GetRow($sql);
        return $data['numerodocumento'];
    }

    public function actualizarOrdenDetallePrematricula($numeroOrdenNuevo,$numeroOrdenAnterior)
    {
        $sql = "
            update detalleprematricula set numeroordenpago = '".$numeroOrdenNuevo."'
            where numeroordenpago = '".$numeroOrdenAnterior."'
        ";

        $this->db->Execute($sql);
    }

    /**
     * @return mixed
     * obtiene modalidad academica del estudiante por codigo estudiante
     */
    public function getModalidadAcademicaEstudiante()
    {
        $sql="select distinct c.codigomodalidadacademica from estudiante e
        inner join carrera c on e.codigocarrera = c.codigocarrera
        where codigoestudiante = '".$this->codigoEstudiante."'";
        $modalidad = $this->db->GetRow($sql);
        return $modalidad['codigomodalidadacademica'];
    }

    public function valorEducacionContinuada()
    {
        $sql ="select * from valoreducacioncontinuada
        where codigocarrera = 257
          and codigoconcepto = 151
          and fechainiciovaloreducacioncontinuada <= NOW()
          and fechafinalvaloreducacioncontinuada >= NOW()
          order by idvaloreducacioncontinuada desc";

        $valorEducacionContinuada = $this->db->GetRow($sql);
        return $valorEducacionContinuada['preciovaloreducacioncontinuada'];
    }
    /**
     * @return bool
     * valida si es educacion continuada.
     */
    public function esEducacionContinuada()
    {
        $modalidad = $this->getModalidadAcademicaEstudiante();
        #es modalidad educacion continuada
        if($modalidad == 400){
            return true;
        }
        return false;
    }
    public function estudianteConvenioInscripcion(){
        $sql = "SELECT idlog 
                FROM logconvenioinscripcion 
                WHERE codigoestudiante=$this->codigoEstudiante AND idconvenioinscripcion IN (2,3,7) AND 
                        codigoestado = 100 and codigoperiodo >= 20202 order by idlog desc";
        $estudianteConvenio = $this->db->GetRow($sql);
        if (count($estudianteConvenio)>0){
            return true;
        }
        return false;
    }
    public function getSemetresCarrera()
    {
        $sql = "select count(distinct d.semestredetalleplanestudio) as semestresCarrera 
            from estudiante e
            inner join planestudioestudiante p on e.codigoestudiante = p.codigoestudiante
            inner join planestudio p2 on p.idplanestudio = p2.idplanestudio
            inner join detalleplanestudio d on p.idplanestudio = d.idplanestudio
            where  p.codigoestudiante = '".$this->codigoEstudiante."'";
        $data = $this->db->GetRow($sql);
        #si no obtiene información
        if(!isset($data['semestresCarrera']))
        {
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
            where  p.codigoestudiante = '".$this->codigoEstudiante."'";
        $data = $this->db->GetRow($sql);
        #si no obtiene información
        if(!isset($data['creditosCarrera']))
        {
            return 0;
        }
        return $data['creditosCarrera'];
    }

    public function getValorBaseMatricula($valorDetalleCohorte)
    {
        $return = array();
        $creditosSemestre = $this->totalCreditosSemestre();
        #en el caso de caso de carga academica completa = 1 la media matricula no existe por eso se define en 0
       if($creditosSemestre == 1){
           $creditosBase = 0;
       }else if (($creditosSemestre % 2 != 0)) {
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
}