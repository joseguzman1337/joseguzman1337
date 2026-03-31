<?php
/* @author Diego Rivera<riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
include '../entidades/ViewPlanDiferencia.php';
class ControlViewPlanDiferencia{
    /**
    * @type Singleton
    * @access private
    */
    private $persistencia;
    /**
    * Constructor
    * @param Singleton $persistencia
    * @access public
    */
    public function ControlViewPlanDiferencia( $persistencia ){
        $this->persistencia = $persistencia;
    }

    /**
    * Consulta lineas del plan con metas sin avances
    * @param int $CodigoCarrera
    * @return array 
    */
    public function lineaSinAvances( $codigoCarrera ){
        $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
        return $viewPlanDiferencia->lineaSinAvances( $codigoCarrera );
    }
    /**
    * Consulta programas del plan con metas sin avances
    * @param int $codigoCarrera , $linea
    * @return array 
    */
    public function programaSinAvances ( $codigoCarrera , $linea ){
        $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
        return $viewPlanDiferencia->programaSinAvances( $codigoCarrera , $linea );
    }
    /**
    * Consulta proyectos  del plan con metas sin avances
    * @param int $codigoCarrera , $linea , $idPrograma
    * @return array 
    */
    public function proyectoSinAvances ( $codigoCarrera , $linea , $idPrograma ){
        $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
        return $viewPlanDiferencia->proyectoSinAvances( $codigoCarrera , $linea , $idPrograma );
    }
    /**
    * Consulta indicadores del plan con metas sin avances
    * @param int $codigoCarrera , $linea , $programa ,$proyecto 
    * @return array 
    */
    public function indicadorSinAvances( $codigoCarrera , $linea , $programa ,$proyecto ){
        $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
        return $viewPlanDiferencia->indicadorSinAvances($codigoCarrera, $linea, $programa, $proyecto );
    }
    /**
    * Consulta plan con metas sin avances
    * @param int $codigoCarrera , $linea , $programa ,$proyecto , $indicador
    * @return array 
    */
    public function metaSinAvances ( $codigoCarrera , $linea , $programa ,$proyecto , $indicador ){ 
        $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
        return $viewPlanDiferencia->metaSinAvances($codigoCarrera, $linea, $programa, $proyecto, $indicador);
    }
    
    /**
    * Consulta lineas del plan con diferencia  en las  entre el alcance de las metas y la suma del alcance de los avances creados
    * @param int $CodigoCarrera
    * @return array 
    */
    public function lineaDiferencia( $codigoCarrera ){
    $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
    return $viewPlanDiferencia->lineaDiferencia( $codigoCarrera );
    }
    /**
    * Consulta programas  del plan con diferencia  en las  entre el alcance de las metas y la suma del alcance de los avances creados
    * @param int $codigoCarrera , $linea 
    * @return array 
    */
    public function programaDiferencia ( $codigoCarrera , $linea ){
        $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
        return $viewPlanDiferencia->programaDiferencia( $codigoCarrera , $linea );
    }
    /**
    * Consulta proyecto  del plan con diferencia  en las  entre el alcance de las metas y la suma del alcance de los avances creados
    * @param int $codigoCarrera , $linea , $idPrograma 
    * @return array 
    */
    public function proyectoDiferencia( $codigoCarrera , $linea , $idPrograma ){
        $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
        return $viewPlanDiferencia->proyectoDiferencia( $codigoCarrera , $linea , $idPrograma );
    }
    /**
    * Consulta indicador  del plan con diferencia  en las  entre el alcance de las metas y la suma del alcance de los avances creados
    * @param int $codigoCarrera , $linea , $programa ,$proyecto 
    * @return array 
    */
    public function indicadorDiferencia( $codigoCarrera , $linea , $programa ,$proyecto ){
        $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
        return $viewPlanDiferencia->indicadorDiferencia($codigoCarrera, $linea, $programa, $proyecto );
    }
    /**
    * Consulta del plan con diferencia  en las  entre el alcance de las metas y la suma del alcance de los avances creados
    * @param $codigoCarrera , $linea , $programa ,$proyecto , $indicador 
    * @return array 
    */
    public function metaDiferencia( $codigoCarrera , $linea , $programa ,$proyecto , $indicador ){ 
        $viewPlanDiferencia = new ViewPlanDiferencia( $this->persistencia );
        return $viewPlanDiferencia->metaDiferencia($codigoCarrera, $linea, $programa, $proyecto, $indicador);
    }      
         
            
}
?>