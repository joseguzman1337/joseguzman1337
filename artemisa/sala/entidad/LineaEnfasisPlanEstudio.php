<?php
/**
 * @author Diego Rivera<riveradiego@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class LineaEnfasisPlanEstudio implements Entidad {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    /**
     * @type int
     * @access private
     */
    private $idlineaenfasisplanestudio;
    /**
     * @type int
     * @access private
     */
    private $idplanestudio;
    /**
     * @type varchar
     * @access private
     */
    private $nombrelineaenfasisplanestudio;
    /**
     * @type datetime
     * @access private
     */
    private $fechacreacionlineaenfasisplanestudio;    
    /**
     * @type datetime
     * @access private
     */
    private $fechainiciolineaenfasisplanestudio;
    /**
     * @type datetime
     * @access private
     */
    private $fechavencimientolineaenfasisplanestudio;
    /**
     * @type varchar
     * @access private
     */
    private $responsablelineaenfasisplanestudio;
    /**
     * @type int
     * @access private
     */

    public function getIdlineaenfasisplanestudio() {
        return $this->idlineaenfasisplanestudio;
    }

    public function getIdplanestudio() {
        return $this->idplanestudio;
    }

    public function getNombrelineaenfasisplanestudio() {
        return $this->nombrelineaenfasisplanestudio;
    }

    public function getFechacreacionlineaenfasisplanestudio() {
        return $this->fechacreacionlineaenfasisplanestudio;
    }

    public function getFechainiciolineaenfasisplanestudio() {
        return $this->fechainiciolineaenfasisplanestudio;
    }

    public function getFechavencimientolineaenfasisplanestudio() {
        return $this->fechavencimientolineaenfasisplanestudio;
    }

    public function getResponsablelineaenfasisplanestudio() {
        return $this->responsablelineaenfasisplanestudio;
    }

    public function getCodigoestadolineaenfasisplanestudio() {
        return $this->codigoestadolineaenfasisplanestudio;
    }

    public function setIdlineaenfasisplanestudio($idlineaenfasisplanestudio) {
        $this->idlineaenfasisplanestudio = $idlineaenfasisplanestudio;
    }

    public function setIdplanestudio($idplanestudio) {
        $this->idplanestudio = $idplanestudio;
    }

    public function setNombrelineaenfasisplanestudio($nombrelineaenfasisplanestudio) {
        $this->nombrelineaenfasisplanestudio = $nombrelineaenfasisplanestudio;
    }

    public function setFechacreacionlineaenfasisplanestudio($fechacreacionlineaenfasisplanestudio) {
        $this->fechacreacionlineaenfasisplanestudio = $fechacreacionlineaenfasisplanestudio;
    }

    public function setFechainiciolineaenfasisplanestudio($fechainiciolineaenfasisplanestudio) {
        $this->fechainiciolineaenfasisplanestudio = $fechainiciolineaenfasisplanestudio;
    }

    public function setFechavencimientolineaenfasisplanestudio($fechavencimientolineaenfasisplanestudio) {
        $this->fechavencimientolineaenfasisplanestudio = $fechavencimientolineaenfasisplanestudio;
    }

    public function setResponsablelineaenfasisplanestudio($responsablelineaenfasisplanestudio) {
        $this->responsablelineaenfasisplanestudio = $responsablelineaenfasisplanestudio;
    }

    public function setCodigoestadolineaenfasisplanestudio($codigoestadolineaenfasisplanestudio) {
        $this->codigoestadolineaenfasisplanestudio = $codigoestadolineaenfasisplanestudio;
    }

        private $codigoestadolineaenfasisplanestudio;
    
     public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }

    public function getById() {
        
    }

    public static function getList($where) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM lineaenfasisplanestudio "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $LineaEnfasisPlanEstudio = new LineaEnfasisPlanEstudio();
            $LineaEnfasisPlanEstudio->idlineaenfasisplanestudio=$d["idlineaenfasisplanestudio"];
            $LineaEnfasisPlanEstudio->nombrelineaenfasisplanestudio=$d["nombrelineaenfasisplanestudio"];
            $return[] = $LineaEnfasisPlanEstudio;
            unset($LineaEnfasisPlanEstudio);
        }
        return $return;
    }

}
?>