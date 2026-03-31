<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die; 
require_once(PATH_SITE."/entidad/SiqEvidenciaOportunidades.php");
require_once(PATH_SITE."/entidad/SiqOportunidades.php");
require_once(PATH_SITE."/entidad/SiqTipoOportunidades.php");
require_once(PATH_SITE."/entidad/SiqEstructuraDocumento.php");
require_once(PATH_SITE."/entidad/SiqTipoOportunidades.php");
require_once(PATH_GESTION."/entidad/RelacionFactorEstructura.php");
class GestionOportunidades {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function GestionOportunidades($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        $array = array();
        
        $functionGet = "getVariables".ucfirst($variables->layout);
        $array = $this->$functionGet($variables);
        return $array;
    }
    
    public function ejecutarTask($variables){
        $task = $variables->task;
        $this->$task($variables);
    }
    
    private function actualizarFactores($variables){
        $array = array();
        $where = " 1 ";
        if(!empty($variables->id)){
            $where = " fed.idsiq_estructuradocumento = ".$this->db->qstr($variables->id);
        }
        $listRelacionFactorEstructura = RelacionFactorEstructura::getList($where." GROUP BY fed.factor_id");
        $listFactores = array();
        foreach($listRelacionFactorEstructura as $l){
            $Factor = new stdClass();
            $Factor->id = $l->getIdsiq_factoresestructuradocumento();
            $Factor->nombre = "(".$l->getCodigo().") ".$l->getNombre();
            $listFactores[] = $Factor;
        }
        
        $return = "<option value='0' >Seleccione...</option>";
        foreach($listFactores as $l){
            $return .= "<option value='".$l->id."' >".$l->nombre."</option>";
        }
        
        echo json_encode(array("s"=>true, "valores"=>$return));
        exit;
    }
    
    private function getVariablesDefault($variables){
        require_once(PATH_GESTION."/control/ControlCreateEdit.php");
        $array = array();
        
        $listSiqOportunidades = SiqOportunidades::getList(" codigoestado = 100 ORDER BY idsiq_oportunidad DESC ");
        
        $listOportunidades = array();
        foreach($listSiqOportunidades as $l){
            //d($l);
            $SiqTipoOportunidades = new SiqTipoOportunidades();
            $SiqTipoOportunidades->setDb();
            $SiqTipoOportunidades->setIdsiq_tipooportunidad($l->getIdsiq_tipooportunidad());
            $SiqTipoOportunidades->getById();
            
            $RelacionFactorEstructura = new RelacionFactorEstructura();
            $RelacionFactorEstructura->setDb();
            $RelacionFactorEstructura->setIdsiq_factoresestructuradocumento($l->getIdsiq_factorestructuradocumento());
            $RelacionFactorEstructura->getById();
            
            $oportunidad = new stdClass();
            $oportunidad->idsiq_oportunidad = $l->getIdsiq_oportunidad();
            $oportunidad->idsiq_tipooportunidad = $l->getIdsiq_tipooportunidad();
            $oportunidad->tipooportunidad_nombre = $SiqTipoOportunidades->getNombre();
            $oportunidad->idsiq_factorestructuradocumento = $l->getIdsiq_factorestructuradocumento();
            $oportunidad->factorNombre = $RelacionFactorEstructura->getNombre();
            $oportunidad->factorCodigo = $RelacionFactorEstructura->getCodigo();
            $oportunidad->nombre = $l->getNombre();
            $oportunidad->descripcion = substr($l->getDescripcion(), 0, 160).(strlen($l->getDescripcion())>160?"...":"");
            $oportunidad->editIcon = ControlCreateEdit::printInconEditar($l->getIdsiq_oportunidad());
            $oportunidad->deleteIcon = ControlCreateEdit::printInconEliminar($l->getIdsiq_oportunidad());
            $listOportunidades[] = $oportunidad;
        }
        $array["listOportunidades"] = $listOportunidades;
        $array["variables"] = $variables;
        return $array;
    }
    
    private function getVariablesCreateEdit($variables){
        $array = array();
                
        $listSiqEstructuraDocumento = SiqEstructuraDocumento::getList();
        $listDocumentos = array();
        foreach($listSiqEstructuraDocumento as $l){
            $EstructuraDocumento = new stdClass();
            $EstructuraDocumento->nombreDocumento = $l->getNombre_documento();
            $EstructuraDocumento->idDocumento = $l->getIdsiq_estructuradocumento();
            $listDocumentos[] = $EstructuraDocumento;
        }
        $array['listDocumentos'] = $listDocumentos;
        
        $listRelacionFactorEstructura = RelacionFactorEstructura::getList(" true GROUP BY fed.factor_id");
        $listFactores = array();
        foreach($listRelacionFactorEstructura as $l){
            $Factor = new stdClass();
            $Factor->id = $l->getIdsiq_factoresestructuradocumento();
            $Factor->nombre = "(".$l->getCodigo().") ".$l->getNombre();
            $listFactores[] = $Factor;
        }
        $array['listFactores'] = $listFactores;
        
        $listSiqTipoOportunidades = SiqTipoOportunidades::getList();
        $listTipoOportunidad = array();
        foreach($listSiqTipoOportunidades as $l){
            $TipoOportunidad = new stdClass();
            $TipoOportunidad->id = $l->getIdsiq_tipooportunidad();
            $TipoOportunidad->nombre = $l->getNombre();
            $listTipoOportunidad[] = $TipoOportunidad;
        }
        $array['listTipoOportunidad'] = $listTipoOportunidad;
        
        $oportunidadEditar = new stdClass();
        $oportunidadEditar->idsiq_oportunidad = null;
        $oportunidadEditar->idsiq_tipooportunidad = null;
        $oportunidadEditar->idsiq_factorestructuradocumento = null;
        $oportunidadEditar->nombre  = null;
        $oportunidadEditar->descripcion = null;
        $oportunidadEditar->usuariocreacion = null;
        $oportunidadEditar->fechacreacion = null;
        $oportunidadEditar->usuariomodificacion = null;
        $oportunidadEditar->fechamodificacion = null;
        $oportunidadEditar->codigoestado = null; 
        $oportunidadEditar->idsiq_estructuradocumento = null;
        $oportunidadEditar->factor_id = null;       
        
        if(!empty($variables->id)){
            
            $SiqOportunidades = new SiqOportunidades();
            $SiqOportunidades->setDb();
            $SiqOportunidades->setIdsiq_oportunidad($variables->id);
            $SiqOportunidades->getById();
            
            $oportunidadEditar->idsiq_oportunidad = $SiqOportunidades->getIdsiq_oportunidad();
            $oportunidadEditar->idsiq_tipooportunidad = $SiqOportunidades->getIdsiq_tipooportunidad();
            $oportunidadEditar->idsiq_factorestructuradocumento = $SiqOportunidades->getIdsiq_factorestructuradocumento();
            $oportunidadEditar->nombre  = $SiqOportunidades->getNombre();
            $oportunidadEditar->descripcion = $SiqOportunidades->getDescripcion();
            $oportunidadEditar->usuariocreacion = $SiqOportunidades->getUsuariocreacion();
            $oportunidadEditar->fechacreacion = $SiqOportunidades->getFechacreacion();
            $oportunidadEditar->usuariomodificacion = $SiqOportunidades->getUsuariomodificacion();
            $oportunidadEditar->fechamodificacion = $SiqOportunidades->getFechamodificacion();
            $oportunidadEditar->codigoestado = $SiqOportunidades->getCodigoestado();
            
            $RelacionFactorEstructura = new RelacionFactorEstructura();
            $RelacionFactorEstructura->setDb();
            $RelacionFactorEstructura->setIdsiq_factoresestructuradocumento($oportunidadEditar->idsiq_factorestructuradocumento);
            $RelacionFactorEstructura->getById();
            
            $oportunidadEditar->idsiq_estructuradocumento = $RelacionFactorEstructura->getIdsiq_estructuradocumento();
            $oportunidadEditar->factor_id = $RelacionFactorEstructura->getFactor_id();
            
            $listRelacionFactorEstructura = RelacionFactorEstructura::getList(" fed.idsiq_estructuradocumento = ".$this->db->qstr($oportunidadEditar->idsiq_estructuradocumento)." GROUP BY fed.factor_id");
            $listFactores = array();
            foreach($listRelacionFactorEstructura as $l){
                $Factor = new stdClass();
                $Factor->id = $l->getIdsiq_factoresestructuradocumento();
                $Factor->nombre = "(".$l->getCodigo().") ".$l->getNombre();
                $listFactores[] = $Factor;
            }
            $array['listFactores'] = $listFactores;
        }
        
        $array['oportunidadEditar'] = $oportunidadEditar;
        
        return $array;
    }
}
