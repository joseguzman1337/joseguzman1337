<?php 

require_once ('ordenPago.php');

class EstudianteDescuento{

	private $db;
    private $codigoEstudiante;
    private $periodo;  

	public function __construct($numeroOrden, $codigoPeriodo, $db) {
       
        $this->db = $db;
        $this->codigoEstudiante = $this->getCodigoEstudiante($numeroOrden);
        $this->periodo = $codigoPeriodo;
    }
    
    public function getCodigoEstudiante($numeroOrden){
        //consulta para obtener el codigo de estudiante por medio de la orden de pago
        $sql = "SELECT codigoestudiante FROM ordenpago WHERE numeroordenpago = $numeroOrden";
        $responseQuery = $this->db->GetRow($sql);
        return $responseQuery['codigoestudiante'];
    }

    public function estudiantes() {
        $sql = "SELECT codigocarrera FROM ".
        " estudiante WHERE codigoestudiante = " . $this->codigoEstudiante;
        
       return $datosEstudiante = $this->db->GetRow( $sql );
    }
	
	public function planEstudioEstudiante() {
    
        $sql = "SELECT idplanestudio FROM planestudioestudiante ".
        " WHERE codigoestudiante = " . $this->codigoEstudiante;
        $planEstudio = $this->db->GetRow( $sql );
        
        return $planEstudio["idplanestudio"];
    }

    public function semetreEstudiante( $idPrematricula ) {
        $sql = "SELECT semestreprematricula  FROM prematricula ".
        " WHERE idprematricula = " . $idPrematricula;

        $semestre = $this->db->GetRow( $sql );
        
        return $semestre["semestreprematricula"];
    }

    public function creditosPlanEstudio( $idPrematricula ) {
        $sql = "SELECT sum(numerocreditosdetalleplanestudio) as creditos ".
        " FROM detalleplanestudio WHERE ".
        " idplanestudio = " . $this->planEstudioEstudiante() . " ".
        " AND semestredetalleplanestudio=" . $this->semetreEstudiante( $idPrematricula ) . "";
        $creditos = $this->db->GetRow($sql);
        return $creditos["creditos"];
    }

    public function estudianteEsAntiguo(){      
        
        //verifica que existan ordenes de pago por concepto de matricula para periodos diferentes al actual, en estado pagado (40, 41, 44)
        // y con estado de prematricula en (40, 41)
       

        $sql = "select count(*) as cantidadOrdenesAntiguas
                  from ordenpago o 
                  join detalleordenpago d
                  on o.numeroordenpago = d.numeroordenpago
                  join prematricula p
                  on o.idprematricula = p.idprematricula
                  where o.codigoestudiante = $this->codigoEstudiante
                  and d.codigoconcepto = 151
                  and o.codigoperiodo <> $this->periodo
                  and o.codigoestadoordenpago in (40, 41, 44)
                  and p.codigoestadoprematricula in (40, 41)
                  ";
                
        $ordenes = $this->db->GetRow($sql);

        if ($ordenes['cantidadOrdenesAntiguas'] > 0) {
            return true;
        }else{
            $sql = "SELECT count(*) 'contador'
                    FROM estudiante
                    WHERE codigoestudiante =".$this->codigoEstudiante." 
                          AND  codigotipoestudiante in (20,21)";
            $estudiante = $this->db->GetRow($sql);
            if ($estudiante['contador']>0){
                return true;
            }
            return false;
        }
    }
    public function estudiantePregrado(){

        $codigoCarrera = $this->estudiantes();
        
        $codigoCarrera = $codigoCarrera['codigocarrera'];

        //para premedico siempre devolver un valor false

        if ((int)$codigoCarrera == 13) {
            return false;
        }

        $sql = "select codigomodalidadacademica from carrera where codigocarrera=$codigoCarrera";
                
        $infoCarrera = $this->db->GetRow($sql);

        $modalidad = (int) $infoCarrera['codigomodalidadacademica'];

        if ($modalidad == 200) {
            return true;            
        }else{
            return false;
        }
    }

    public function estudiantePostgrado(){

        $codigoCarrera = $this->estudiantes();
        
        $codigoCarrera = $codigoCarrera['codigocarrera'];
        
        $sql = "select codigomodalidadacademica from carrera where codigocarrera=$codigoCarrera";
                
        $infoCarrera = $this->db->GetRow($sql);

        $modalidad = (int) $infoCarrera['codigomodalidadacademica'];

        if ($modalidad == 300) {
            return true;            
        }else{
            return false;
        }
    }

    public function estudianteRecursoFinanciero(){
        $auxArray = false;
        $codigoEstudiante = $this->codigoEstudiante;

        //consulta si el estudiante tiene un recursos financiero de icetex
        $sqlrecurdo = "select count(*) as 'contador' from estudianterecursofinanciero er ".
        " inner join estudiantegeneral eg on er.idestudiantegeneral = eg.idestudiantegeneral ".
        " inner join estudiante e on eg.idestudiantegeneral = e.idestudiantegeneral ".
        " where e.codigoestudiante =".$codigoEstudiante." and er.codigoestado = 100 ".
        " and er.idtipoestudianterecursofinanciero in (9)";
        $recurso = $this->db->GetRow($sqlrecurdo);
        //si existe retorna false
        if ($recurso['contador'] > 0){
            return false;
        }
        return true;
    }

    public function estudiantePlanEstudio(){
        $auxArray = false;
        $codigoEstudiante = $this->codigoEstudiante;

        //consulta si el estudiante tiene un recursos financiero de icetex
        $sqlrecurdo = "select max(d.semestredetalleplanestudio) as 'max' from planestudioestudiante p ".
        " inner join detalleplanestudio d on p.idplanestudio = d.idplanestudio ".
        " where codigoestudiante= '$codigoEstudiante'";
        $recurso = $this->db->GetRow($sqlrecurdo);
        //si el numero es mayor a 2 devuelve true
        if ($recurso['max'] > 2){
            return true;
        }
        return false;
    }
}