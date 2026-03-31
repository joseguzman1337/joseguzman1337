<?php
require_once("estudiante.php");
require_once("cohorte.php");
require_once("ordenPago.php");
require_once("prematricula.php");

class Descuento {

    private $codigoEstudiante;
    private $numeroOrden;
    private $instanciaOrdenesPago;
    private $periodo;
    private $db;
    private $descuentoPorAplicar;

    public function __construct( $numeroOrden ,$periodo, $db, $valida_hay_descuento = null  ) {

        $this->numeroOrden = $numeroOrden;        
        $this->periodo = $periodo;
        $this->db = $db;
        $this->instanciaOrdenesPago = new OrdenesPago($this->db, $this->numeroOrden);
        $this->estudiante = new EstudianteDescuento($this->numeroOrden, $periodo, $this->db);
        $this->valida_hay_descuento = $this->existedescuento($this->numeroOrden);
        $this->descuentoPorAplicar = $this->descuento();
    }

    private function calculoDescuento( $valoresFechaOrdenPago , $porcentajes ){
        $aplicaDescuento = array();
        
        foreach ($porcentajes as $llave => $valorPorcentaje) {
            if ( isset($valoresFechaOrdenPago[$llave]) ) {
                $valor=(int) $valoresFechaOrdenPago[$llave] * $valorPorcentaje / 100;
                $aplicaDescuento[$llave] = round($valor);
            }else{
                $aplicaDescuento[$llave] = 0;
            }
        }
        return $aplicaDescuento;
    }
    
    public function descuento(){
        $descuentos = array();
        
            $valoresFechaOrdenPago = $this->instanciaOrdenesPago->obtenerValoresFechaOrdenPago($this->numeroOrden, $this->valida_hay_descuento);

            $porcentajePlanFomentoEducacion = $this->porcentajeDescuento("planFomentoEducacion");
            $porcentajeDescuentoVacacional = $this->porcentajeDescuento("descuentoVacacional");
            $planAnticipate = $this->porcentajeDescuento("planAnticipate");

            $descuentos["planFomentoEducacion"] = $this->calculoDescuento($valoresFechaOrdenPago, $porcentajePlanFomentoEducacion);
            $descuentos["descuentoVacacional"] = $this->calculoDescuento($valoresFechaOrdenPago, $porcentajeDescuentoVacacional);
            $descuentos["planAnticipate"] = $this->calculoDescuento($valoresFechaOrdenPago, $planAnticipate);

            //ahora se eliminan todos los descuentos vacios
            foreach ($descuentos as $key => $value) {
                if (!$this->validarDescuento($descuentos[$key])) {
                    unset($descuentos[$key]);
                }
            }
        
        return $descuentos;
    }    
    
    private function aplicarDescuento( $descuento ){
        $codigoDescuento = $this->conceptoPeople('codigoconcepto');  
        $this->instanciaOrdenesPago->aplicarDescuento( $descuento , $this->numeroOrden, $codigoDescuento );
    }

    //==============================

    public function porcentajeDescuento($param){
        $periodo = (int)$this->periodo;

        switch ($param) {
            case 'planFomentoEducacion': //para plan fomento a la educacion
                    if (($this->estudiante->estudianteEsAntiguo()) and ($this->estudiante->estudiantePregrado())
                    and ($periodo == 20202) and ( $this->instanciaOrdenesPago->ordenPagoEsMatricula() )) {
                    //si aplica para pregrado
                    return array(15,10,0);

                    }elseif (($this->estudiante->estudianteEsAntiguo()) and ($this->estudiante->estudiantePostgrado())
                            and ($periodo == 20202) and ( $this->instanciaOrdenesPago->ordenPagoEsMatricula() )) {
                        //si aplica para postgrado
                        return array(15,10,0);
                    }else{
                        return array(0);
                    }
            break;
            case 'descuentoVacacional':
                if (($this->estudiante->estudianteEsAntiguo()) and ($this->estudiante->estudiantePregrado())
                    and ($periodo == 20202) and ( $this->instanciaOrdenesPago->ordenPagoEsVacacional() )) {
                    return array(25);                
                }                    
                else {
                    return array(0);
                }
            break;
            case 'planAnticipate':{
                $prematricula = new Prematricula($this->db, $this->numeroOrden);

                if (($this->estudiante->estudianteEsAntiguo())  && ($this->estudiante->estudiantePregrado())
                    && ($periodo == 20211)  && ( $this->instanciaOrdenesPago->ordenPagoEsMatricula() )
                    && ($prematricula->creditosPrematriculados($periodo))
                    && ($this->estudiante->estudianteRecursoFinanciero())
                ) {
                    //consulta el porcentaje que le corresponde al programa
                    return $this->descuentoCarrera();
                }elseif (($this->estudiante->estudianteEsAntiguo()) && ($this->estudiante->estudiantePostgrado())
                    && ($periodo == 20211) && ( $this->instanciaOrdenesPago->ordenPagoEsMatricula())
                    && ($prematricula->creditosPrematriculados($periodo))
                    && ($this->estudiante->estudianteRecursoFinanciero()) && ($this->estudiante->estudiantePlanEstudio())
                ) {
                    //consulta el porcentaje que le corresponde al programa
                    return $this->descuentoCarrera();
                }else{
                    return array(0);
                }
            } break;
            default:
                return array(0);
            break;
        }
    }
    //==============================

    public function descuentoCarrera(){
        $porcentajeDescuento = array();
        $codigoCarrera = $this->estudiante->estudiantes();
        $codigoCarrera = $codigoCarrera['codigocarrera'];
        $sql = "SELECT porcentaje FROM descuentomatriculas ".
        " WHERE codigocarrera=$codigoCarrera and codigoestado=100 order by codigoTipoPorcentaje desc";

        $queryResponse = $this->db->execute($sql);
        $totalDescuentos = $queryResponse->recordCount();

        if($totalDescuentos >0){
            while ($auxPorcentaje = $queryResponse->FetchRow()) {
                array_push($porcentajeDescuento,$auxPorcentaje['porcentaje']);
            }
            return $porcentajeDescuento;
        }
        return array(0);
    }

    public function validarDescuento( $descuento ){
        $totalDescuentos = array_sum($descuento);
        if ($totalDescuentos > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function getItemCarreraConceptoPeople($concepto){

        $query = "select itemcarreraconceptopeople from carreraconceptopeople where codigoconcepto = '".$concepto."'";
        $queryResponse = $this->db->GetRow($query);

        return $queryResponse['itemcarreraconceptopeople'];
    }
    

    public function conceptoPeople($param){
        $auxArray = array();
        //Revisa que descuento esta disponible
        if (isset($this->descuentoPorAplicar['planFomentoEducacion'])) {
            if ($this->estudiante->estudiantePregrado()) {
                //codigo de concepto especifico para Plan Avancemos Pregrado
                $auxArray['codigoconcepto'] = 'C9110';
                $auxArray['itemcarreraconceptopeople'] = $this->getItemCarreraConceptoPeople($auxArray['codigoconcepto']);
            }elseif ($this->estudiante->estudiantePostgrado()) {
                //codigo de concepto especifico para Plan Avancemos Postgrado
                $auxArray['codigoconcepto'] = 'C9111';
                $auxArray['itemcarreraconceptopeople'] = $this->getItemCarreraConceptoPeople($auxArray['codigoconcepto']);
            }
        }

        if (isset($this->descuentoPorAplicar['descuentoVacacional'])) {
            $auxArray['codigoconcepto'] = 'C9110';
            $auxArray['itemcarreraconceptopeople'] = $this->getItemCarreraConceptoPeople($auxArray['codigoconcepto']);
        }

        if (isset($this->descuentoPorAplicar['planAnticipate'])) {
            $auxArray['codigoconcepto'] = 'C9110';
            $auxArray['itemcarreraconceptopeople'] = $this->getItemCarreraConceptoPeople($auxArray['codigoconcepto']);
        }
        
        //aca se devuelve la informacion solicitada
        if ($param) {
            if ($param == 'codigoconcepto') {
                return $auxArray['codigoconcepto'];
            }
            if ($param == 'itemcarreraconceptopeople') {
                return $auxArray['itemcarreraconceptopeople'];
            }
        }else {
            die("Por favor revisar el parametro en el modulo descuentos 196");
        }
    }//function
   
    public function xmlDescuento($fechaOrden, $param = false){
        $aplicaDescuento = $this->estudiante;
        $itemDescuento = $this->conceptoPeople('itemcarreraconceptopeople');
        $xml = "";

        //se verifica que el array de descuentos este vacio
        if (empty($this->descuentoPorAplicar)) {
            return $xml;
        }

        //se obtiene el valor del primer y unico descuento que encuentre
        
        $descuentoPorAplicar = array_values($this->descuentoPorAplicar);
        $descuentoPorAplicar = $descuentoPorAplicar[0];      
        
        $validarDescuento = $this->validarDescuento($descuentoPorAplicar);

        if (!$validarDescuento) {
            return $xml;
        }
              
        $arrayfechas = array();

        $query = "SELECT * from fechaordenpago where numeroordenpago = $this->numeroOrden order by fechaordenpago";
        $queryResponse = $this->db->execute($query);

        while ($auxFechas = $queryResponse->FetchRow()) {
            array_push($arrayfechas,$auxFechas['fechaordenpago']);
        }              

        foreach ($descuentoPorAplicar as $llave => $valorDescuento) {
            if ($valorDescuento > 0) {
                $fechaDueDT = "";

                if (!$param) {
                    $fechaDueDT = cambiaf_a_people2($arrayfechas[$llave]);
                }else {
                    $fechaDueDT = $arrayfechas[$llave];
                }

                $xml .= "<UBI_ITEM_WRK>
                <ITEM_TYPE>$itemDescuento</ITEM_TYPE>
                <ITEM_TYPE_TO></ITEM_TYPE_TO>
                <ITEM_NBR></ITEM_NBR>
                <ITEM_AMT>$valorDescuento</ITEM_AMT>
                <ACCOUNT_TYPE_SF>MAT</ACCOUNT_TYPE_SF>
                <ITEM_EFFECTIVE_DT>$fechaOrden</ITEM_EFFECTIVE_DT>
                <DUE_DT2>$fechaDueDT</DUE_DT2>
                 </UBI_ITEM_WRK>";                 
            }            
        }
        return $xml;
    }
    
    public function modificarTotalBill($totalBill){
        //se verifica que el array de descuentos este vacio o que exista un descuento
        if (empty($this->descuentoPorAplicar) or $this->valida_hay_descuento) {
            return $totalBill;
        }
        //se obtiene el valor del primer y unico descuento que encuentre
        $descuentoPorAplicar = array_values($this->descuentoPorAplicar);
        $descuentoPorAplicar = $descuentoPorAplicar[0];
        $returnTB= (int)$totalBill - $descuentoPorAplicar[0];

        return (string)$returnTB;
    }

    public function visualizarHeaderDescuento($numeral, $seccion = false){
        if ( isset($this->descuentoPorAplicar['planFomentoEducacion']) ) { //si aplica para plan de fomento a la educacion
            switch ($numeral) {
                case 1:
                    return $seccion !== 'pdf' ? "Apoyo 15%": "APOYO 15% HASTA: ";
                    break;

                case 2:
                    return $seccion !== 'pdf' ? "Apoyo 10%": "APOYO 10% HASTA: ";
                    break;

                default:
                    return $seccion !== 'pdf' ? "Matricula completa": "MATRICULA COMPLETA HASTA: ";
                    break;
            }
        }

        elseif ( isset($this->descuentoPorAplicar['descuentoVacacional']) ) { //si aplica para vacacional
            switch ($numeral) {
                case 1:
                    return $seccion !== 'pdf' ? "Apoyo vacacional": "APOYO 25% HASTA: ";
                    break;

                default:
                    return $seccion !== 'pdf' ? "Extraordinario ".(int)$numeral-1 : "EXTRAORDINARIA ".(int)$numeral - 1 ." HASTA: ";
                    break;
            }
        }
        //Si aplica para plan anticipate 20201
        elseif ( isset($this->descuentoPorAplicar['planAnticipate']) ) {
            switch ($numeral) {
                case 1:
                    return $seccion !== 'pdf' ? "Plan Anticípate": " : ";
                    break;
                case 2:
                    return $seccion !== 'pdf' ? "Ordinario" : "ORDINARIA HASTA: ";
                    break;
                case 3:
                    return $seccion !== 'pdf' ? "Extraordinario " : "EXTRAORDINARIA HASTA: ";
                    break;

                default:
                    return $seccion !== 'pdf' ? "Extraordinario ".($numeral-1) : "EXTRAORDINARIA ".($numeral - 1) ." HASTA: ";
                    break;
            }
        }
        //Los descuentos por agregar van en este espacio
        else {
            if ($this->instanciaOrdenesPago->ordenPagoEsMatricula()) {
                switch ($numeral) {
                    case 1:
                        return $seccion !== 'pdf' ? "Ordinario" : "ORDINARIA HASTA: ";
                        break;

                    default:
                        return $seccion !== 'pdf' ? "Extraordinario ".($numeral-1) : "EXTRAORDINARIA ".($numeral - 1) ." HASTA: ";
                        break;
                }
            }else{
                switch ($numeral) {
                    case 1:
                        return $seccion !== 'pdf' ? "Ordinario" : "PAGO OPORTUNO HASTA: ";
                        break;
                    default:
                        return $seccion !== 'pdf' ? "Extraordinario ".($numeral-1) : "$numeral VENCIMIENTO HASTA: ";
                        break;
                }
            }
        }
    }
    
    public function descuentoMatricula(){
        
        foreach ( $this->descuentoPorAplicar as $tipoDescuento => $descuento ) {
            $validarDescuento = $this->validarDescuento( $descuento );
            // Si el descuento es valido y no existe un descuento en la orden
            if ($validarDescuento and !$this->valida_hay_descuento) {
               //se llama al metodo que aplica el descuento 
               $this->aplicarDescuento( $descuento );  
            }
        }
    }

    public function existedescuento($orden){
        $sqldescuento = "select count(*) as 'conteo' from detalleordenpago where numeroordenpago = $orden ".
        " and codigoconcepto in ('C9110', 'C9111')";
        $queryResponse = $this->db->GetRow($sqldescuento);

        if($queryResponse['conteo'] > 0){
            return true;
        }
        return false;

    }
}
