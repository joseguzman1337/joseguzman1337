<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of proccessClass
 *
 * @author proyecto_mgi_cp
 */
class proccessFormClass {
    
    
    public function proccessFormEquiposComputo(){  
        $sql = "SELECT codigoformacionacademica,nombreformacionacademica FROM formacionacademica ORDER BY codigoformacionacademica ASC";        
        return $this->db->GetAll($sql);
    }
}

?>
