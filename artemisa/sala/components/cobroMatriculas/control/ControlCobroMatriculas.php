<?php

defined('_EXEC') or die;

class ControlCobroMatriculas {

    private $db;

    /**
     * @type stdObject
     * @access private
     */
    public function __construct($variables) {
        $this->db = Factory::createDbo();
        $this->variables = $variables;

        if (empty($this->variables->dataType)) {
            $this->variables->dataType = null;
        }

        if (empty($this->variables->dataAction)) {
            $this->variables->dataAction = null;
        }
    }

    public function administrarCobroMatriculas() {
        $validar=$this->validarCobro();
        
        if($validar > 0){
            $return = array("n" => true, "msj" => "Existe un registro con la informacion digitada");
        }else{
           $cobro = $this->cobroMatricula();
           if($cobro==false){
               $return = array("n" => true, "msj" => "Ha ocurrido un error");
           }else{
               $return = array("s" => true, "msj" => "Cobro matricula guardado / actualizado correctamente");
           }
            
        }
         echo json_encode($return);
         
    }

    private function cobroMatricula() {

        $periodoNuevo = $this->variables->periodoNuevo;
        $periodoActual = $this->variables->periodoActual;
        $desdeActual = $this->variables->desdeActual;
        $desdeNuevo = $this->variables->desdeNuevo;
        $hastaActual = $this->variables->hastaActual;
        $hastaNuevo = $this->variables->hastaNuevo;
        $cobroActual = $this->variables->cobroActual;
        $cobroNuevo = $this->variables->cobroNuevo;
        
        $cobroMatricula = new \CobroMatricula();
        
        if(empty($periodoActual)){
            $cobroMatricula->setIdentificador("Nuevo");
        }
        $cobroMatricula->setCodigoPeriodo( $this->variables->periodoActual );
        $cobroMatricula->setPorcentajeCreditosDesde( $this->variables->desdeActual );
        $cobroMatricula->setPorcentajeCreditosHasta( $this->variables->hastaActual );
        $cobroMatricula->setPorcentajeCobroMatricula( $this->variables->cobroActual );
        
        $cobroMatricula->setCodigoPeriodoN( $this->variables->periodoNuevo  );
        $cobroMatricula->setPorcentajeCreditosDesdeN( $this->variables->desdeNuevo );
        $cobroMatricula->setPorcentajeCreditosHastaN( $this->variables->hastaNuevo );
        $cobroMatricula->setPorcentajeCobroMatriculaN( $this->variables->cobroNuevo );
        
        $cobroMatriculaDAO = new Sala\entidadDAO\CobroMatriculaDAO($cobroMatricula);
        $cobroMatriculaDAO->setDb();
        return  $cobroMatriculaDAO->save();
    }
    
    
   private function validarCobro(){
        $this->variables->periodoNuevo;
        $this->variables->desdeNuevo;
        $this->variables->hastaNuevo;
        $this->variables->cobroNuevo;
        
        $cobroMatricula = new \CobroMatricula();
        
        $verificarExistencia=$cobroMatricula->getList(" codigoperiodo=".$this->variables->periodoNuevo." AND porcentajecreditosdesde=".$this->variables->desdeNuevo." AND porcentajecreditoshasta=".$this->variables->hastaNuevo." AND porcentajecobromatricula=".$this->variables->cobroNuevo);
        return count($verificarExistencia);
   }

}
