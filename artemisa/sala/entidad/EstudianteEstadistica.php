<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
//defined('_EXEC') or die;
class EstudianteEstadistica implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $idestudianteestadistica;
    private $codigoestudiante;
    private $estudianteestadisticafechainicial;
    private $estudianteestadisticafechafinal;
    private $codigoperiodo;
    private $codigoprocesovidaestudiante;
    private $codigoestado;
    private $observacionestudianteestadistica;
    
    public function __construct(){
        $this->setDb();
    }

    public function setDb(){
        $this->db = Factory::createDbo();
    }

    /**
     * @return mixed
     */
    public function getIdestudianteestadistica()
    {
        return $this->idestudianteestadistica;
    }

    /**
     * @param mixed $idestudianteestadistica
     */
    public function setIdestudianteestadistica($idestudianteestadistica)
    {
        $this->idestudianteestadistica = $idestudianteestadistica;
    }

    /**
     * @return mixed
     */
    public function getCodigoestudiante()
    {
        return $this->codigoestudiante;
    }

    /**
     * @param mixed $codigoestudiante
     */
    public function setCodigoestudiante($codigoestudiante)
    {
        $this->codigoestudiante = $codigoestudiante;
    }

    /**
     * @return mixed
     */
    public function getEstudianteestadisticafechainicial()
    {
        return $this->estudianteestadisticafechainicial;
    }

    /**
     * @param mixed $estudianteestadisticafechainicial
     */
    public function setEstudianteestadisticafechainicial($estudianteestadisticafechainicial)
    {
        $this->estudianteestadisticafechainicial = $estudianteestadisticafechainicial;
    }

    /**
     * @return mixed
     */
    public function getEstudianteestadisticafechafinal()
    {
        return $this->estudianteestadisticafechafinal;
    }

    /**
     * @param mixed $estudianteestadisticafechafinal
     */
    public function setEstudianteestadisticafechafinal($estudianteestadisticafechafinal)
    {
        $this->estudianteestadisticafechafinal = $estudianteestadisticafechafinal;
    }

    /**
     * @return mixed
     */
    public function getCodigoperiodo()
    {
        return $this->codigoperiodo;
    }

    /**
     * @param mixed $codigoperiodo
     */
    public function setCodigoperiodo($codigoperiodo)
    {
        $this->codigoperiodo = $codigoperiodo;
    }

    /**
     * @return mixed
     */
    public function getCodigoprocesovidaestudiante()
    {
        return $this->codigoprocesovidaestudiante;
    }

    /**
     * @param mixed $codigoprocesovidaestudiante
     */
    public function setCodigoprocesovidaestudiante($codigoprocesovidaestudiante)
    {
        $this->codigoprocesovidaestudiante = $codigoprocesovidaestudiante;
    }

    /**
     * @return mixed
     */
    public function getCodigoestado()
    {
        return $this->codigoestado;
    }

    /**
     * @param mixed $codigoestado
     */
    public function setCodigoestado($codigoestado)
    {
        $this->codigoestado = $codigoestado;
    }

    /**
     * @return mixed
     */
    public function getObservacionestudianteestadistica()
    {
        return $this->observacionestudianteestadistica;
    }

    /**
     * @param mixed $observacionestudianteestadistica
     */
    public function setObservacionestudianteestadistica($observacionestudianteestadistica)
    {
        $this->observacionestudianteestadistica = $observacionestudianteestadistica;
    }



    
    public function getById(){
        if(!empty($this->idestudianteestadistica)){
            $query = "SELECT * FROM estudianteestadistica "
                . "WHERE idestudianteestadistica = '".$this->idestudianteestadistica."'";

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idestudianteestadistica = $d['idestudianteestadistica'];
                $this->codigoestudiante = $d['codigoestudiante'];
                $this->estudianteestadisticafechainicial = $d['estudianteestadisticafechainicial'];
                $this->estudianteestadisticafechafinal = $d['estudianteestadisticafechafinal'];
                $this->codigoperiodo = $d['codigoperiodo'];
                $this->codigoprocesovidaestudiante = $d['codigoprocesovidaestudiante'];
                $this->codigoestado = $d['codigoestado'];
                $this->observacionestudianteestadistica = $d['observacionestudianteestadistica'];

            }
        }
    }
    
    public static function getList($where = null, $orderBy = null){
        $return = array();        
        $db = Factory::createDbo();
        $query = "SELECT * FROM estudianteestadistica "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $estudianteEstadistica = new EstudianteEstadistica();
            $estudianteEstadistica->setIdestudianteestadistica(@$d['idestudianteestadistica']);
            $estudianteEstadistica->setCodigoestudiante($d['codigoestudiante']);
            $estudianteEstadistica->setEstudianteestadisticafechainicial($d['estudianteestadisticafechainicial']);
            $estudianteEstadistica->setEstudianteestadisticafechafinal($d['estudianteestadisticafechafinal']);
            $estudianteEstadistica->setCodigoperiodo($d['codigoperiodo']);
            $estudianteEstadistica->setCodigoprocesovidaestudiante($d['codigoprocesovidaestudiante']);
            $estudianteEstadistica->setCodigoestado($d['codigoestado']);
            $estudianteEstadistica->setObservacionestudianteestadistica($d['observacionestudianteestadistica']);
            
            $return[] = $estudianteEstadistica;
            unset($estudianteEstadistica);
        }        
        return $return;
    }
}