<?php
class OrdenesPago{

    private $db;
    private $numeroOrdenPago;

	public function __construct( $db, $numeroOrdenPago ) {
       
        $this->db = $db;
        $this->numeroOrdenPago = $numeroOrdenPago;
    }	

    private function actualizarValor( $valoresDescuentos , $numeroOrdenPago ){
        
        $arrayfechas = array();

        $query = "SELECT fechaordenpago from fechaordenpago where numeroordenpago = $numeroOrdenPago order by fechaordenpago";
        $queryResponse = $this->db->Execute($query);
        
        while ($auxFechas = $queryResponse->FetchRow()) {
            array_push($arrayfechas,$auxFechas['fechaordenpago']);
        }       
        
        foreach ($valoresDescuentos as $llave => $valor) {

            if (isset($arrayfechas[$llave])) {
                
                $query="UPDATE fechaordenpago "
                    . "SET valorfechaordenpago = (valorfechaordenpago-$valor) "
                    . "WHERE numeroordenpago = $numeroOrdenPago"
                    ." and fechaordenpago = '$arrayfechas[$llave]' ";             
            
                $this->db->Execute($query) or die(mysql_error());    
            }
            
        }      
        
    }

    private function insertarDetalle( $descuento , $numeroOrdenPago, $codigoDescuento ){
              
        $query = "INSERT INTO detalleordenpago( numeroordenpago,codigoconcepto, ".
        " cantidaddetalleordenpago,valorconcepto, codigotipodetalleordenpago) ".
        " VALUES ( ".$numeroOrdenPago.",'".$codigoDescuento."',1,".$descuento[0].",'1')";
        $this->db->Execute($query) or die(mysql_error());
    }

    public function obtenerDetalleOrdenPago($ordenPago){
        $query = "SELECT * from detalleordenpago where numeroordenpago=$ordenPago and codigoconcepto='151'";
        $response = $this->db->GetRow($query);
        return $response;
    }

    public function obtenerValoresFechaOrdenPago($ordenPago, $valida_hay_descuento){
        $query = "SELECT * from fechaordenpago fp where fp.numeroordenpago=$ordenPago order by fechaordenpago";
        $response = $this->db->Execute($query);
        $returnResponse = array();

        while ($fechas = $response->FetchRow()){
            if ($valida_hay_descuento) {
                $detalleOrdenPago = $this->obtenerDetalleOrdenPago($ordenPago);
                array_push($returnResponse,$detalleOrdenPago['valorconcepto']);
            }else{
                array_push($returnResponse,$fechas['valorfechaordenpago']);
            }
        }
        return $returnResponse;
    }
   
    public function aplicarDescuento( $valor , $numeroOrdenPago, $codigoDescuento ){
        $this->insertarDetalle( $valor , $numeroOrdenPago, $codigoDescuento );
        $this->actualizarValor( $valor , $numeroOrdenPago );
    }

    public function ordenPagoEsMatricula(){
        $auxArray = false;
        $numeroOrdenPago = $this->numeroOrdenPago;

        $sql = "SELECT codigoconcepto FROM detalleordenpago WHERE numeroordenpago = $numeroOrdenPago";
        $execQuery = $this->db->Execute($sql);

        while ($response = $execQuery->FetchRow()) {
            if ((int)$response['codigoconcepto'] == 151) {
                $auxArray = true;
            }
        }
        return $auxArray;
    }

    public function ordenPagoEsVacacional(){
        $auxArray = false;
        $numeroOrdenPago = $this->numeroOrdenPago;

        $sql = "SELECT codigoconcepto FROM detalleordenpago WHERE numeroordenpago = $numeroOrdenPago";
        $execQuery = $this->db->Execute($sql);

        while ($response = $execQuery->FetchRow()){
            if ((int)$response['codigoconcepto'] == 110){
                $auxArray = true;
            }
        }
        return $auxArray;
    }
}