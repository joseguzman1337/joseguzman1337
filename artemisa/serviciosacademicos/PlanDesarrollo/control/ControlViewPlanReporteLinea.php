<?php
/* @author Diego Rivera<riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
include '../entidades/ViewPlanReporteLinea.php';
include '../entidades/ViewPlanReporteAvance.php';
    class ControlViewPlanReporteLinea {
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
        public function ControlViewPlanReporteLinea( $persistencia ){
            $this->persistencia = $persistencia;
        }
        /**
         * Consulta  avance actual de los diferentes planes de desarrollo
         * @param int $idPlan
         * @param int $idLinea
         * @return array 
         */
        public function alcanceMetasReporte( $idPlan , $idLinea ){
            $ViewPlanReporteLineas = new ViewPlanReporteLinea( $this->persistencia );
            return $ViewPlanReporteLineas ->alcanceMetas( $idPlan , $idLinea );
        }
         /**
         * Consulta  avance actual de los avances anuales de los planes de desarrollo
         * @param int $idPlan
         * @param int $idLinea
         * @return array 
         */
        public function alcanceAvancesAnuales( $idPlan , $idLinea , $perido){
            $ViewPlanReporteAvances = new ViewPlanReporteAvance ( $this->persistencia );
            return $ViewPlanReporteAvances->alcanceMetasAnuales( $idPlan , $idLinea , $perido );
        }

}
?>
