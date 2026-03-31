<?php

/**
 * Piscina de datos academicos
 *
 * @author proyecto_mgi_cp
 */
$ruta = "../";
while (!is_file($ruta.'templates/template.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta."templates/template.php");
class datosClass {
    var $db = null;
    
    function __construct() {
        $this->db = getBD();
    }
    
    public function initialize($database) {
        $this->db = $database;
    }
    
    public function getAsignatura($filtros=null,$filtrosValores=null){             
        $sql = "SELECT m.codigomateria,m.nombremateria FROM materia m ";
            if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                //el codigoperiodo es de cuando se crea la materia no cuando se dicta
                $sql = $sql." inner join carrera c ON c.codigocarrera = m.codigocarrera AND c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' 
                         inner join modalidadacademicasic ma ON ma.codigomodalidadacademicasic = c.codigomodalidadacademicasic AND ma.codigoestado=100 
                        inner join modalidadacademica mac ON mac.codigomodalidadacademica = c.codigomodalidadacademica AND mac.codigoestado=100 
                        WHERE m.codigoperiodo <= '".$filtrosValores["fechas"]["periodo_final"]."' ";
            }
            $sql = $sql."ORDER BY nombremateria";
            
        if($filtros!=null){
            if(strcmp($filtros, "asignatura.programaAcademico")==0){
                //isset no retorna verdadero si $search_array['programaAcademico']=null
                if(isset($filtrosValores['programaAcademico'])){
                    if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                        $sql = "SELECT m.codigomateria, m.nombremateria,c.nombrecarrera,c.codigocarrera FROM materia m 
                            inner join carrera c ON c.codigocarrera = m.codigocarrera AND c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' 
                            AND c.codigocarrera='".$filtrosValores["programaAcademico"]."' ";
                        
                        $sql = $sql." WHERE m.codigoperiodo <= '".$filtrosValores["fechas"]["periodo_final"]."'                                     
                                  ORDER BY c.nombrecarrera,m.nombremateria";
                    } else {
                        $sql = "SELECT m.codigomateria, m.nombremateria,c.nombrecarrera,c.codigocarrera FROM materia m 
                            inner join carrera c ON c.codigocarrera = m.codigocarrera AND c.fechavencimientocarrera>CURDATE() 
                            WHERE c.codigocarrera='".$filtrosValores["programaAcademico"]."' GROUP BY m.codigomateria,c.codigocarrera ORDER BY c.nombrecarrera,m.nombremateria";
                    }                    
                } else {
                    $sql = "SELECT m.codigomateria, m.nombremateria,c.nombrecarrera,c.codigocarrera FROM materia m 
                            inner join carrera c ON c.codigocarrera = m.codigocarrera AND c.fechavencimientocarrera>CURDATE() 
                             ORDER BY c.nombrecarrera,m.nombremateria";
                }
            } else if(strcmp($filtros, "asignatura.programaAcademico.modalidadAcademica")==0){
                if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                        $sql = "SELECT m.codigomateria, m.nombremateria,c.nombrecarrera,c.codigocarrera FROM materia m 
                            inner join carrera c ON c.codigocarrera = m.codigocarrera ";
                        if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                            $sql = $sql." AND c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' ";
                        }
                     
                   if(isset($filtrosValores['programaAcademico'])){
                      $sql = $sql."AND c.codigocarrera='".$filtrosValores["programaAcademico"]."' ";
                   }
                    $sql = $sql . " inner join modalidadacademica ma ON ma.codigomodalidadacademica = c.codigomodalidadacademica AND ma.codigoestado=100 ";
                
                    if(isset($filtrosValores['modalidadAcademica'])){
                        $sql = $sql."AND ma.codigomodalidadacademica='".$filtrosValores["modalidadAcademica"]."' ";
                    }                  
                        
                        $sql = $sql." WHERE m.codigoperiodo<= '".$filtrosValores["fechas"]["periodo_final"]."'  
                                  ORDER BY ma.nombremodalidadacademica,c.nombrecarrera,m.nombremateria";
              }
            } else if(strcmp($filtros, "asignatura.programaAcademico.modalidadAcademicaSIC")==0){
                if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                        $sql = "SELECT m.codigomateria, m.nombremateria,c.nombrecarrera,c.codigocarrera FROM materia m
                            inner join detalleplanestudio dp ON dp.codigomateria=m.codigomateria ";
                        if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                            $sql = $sql."inner join carrera c ON c.codigocarrera = m.codigocarrera AND c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' ";
                        }
                     
                   if(isset($filtrosValores['programaAcademico'])){
                      $sql = $sql."AND c.codigocarrera='".$filtrosValores["programaAcademico"]."' ";
                   }
                    $sql = $sql . " inner join modalidadacademicasic ma ON ma.codigomodalidadacademicasic = c.codigomodalidadacademicasic AND ma.codigoestado=100 ";
                
                    if(isset($filtrosValores['modalidadAcademicaSIC'])){
                        $sql = $sql."AND ma.codigomodalidadacademicasic='".$filtrosValores["modalidadAcademicaSIC"]."' ";
                    }                  
                        
                        $sql = $sql." WHERE m.codigoperiodo <= '".$filtrosValores["fechas"]["periodo_final"]."' 
                                    ORDER BY ma.nombremodalidadacademicasic,c.nombrecarrera,m.nombremateria";
              }
            } else if(strcmp($filtros, "asignatura.aulaVirtual")==0){
                if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                    $sql = "SELECT m.codigomateria,m.nombremateria FROM materia m
                            inner join v_moodle_aulaVirtualAsignatura a ON a.codigomateria=m.codigomateria 
                            WHERE m.codigoperiodo <= '".$filtrosValores["fechas"]["periodo_final"]."'                             
                                AND a.fecha_inicio <= '".$filtrosValores["fechas"]["fecha_final"]."' 
                         GROUP BY a.codigomateria ORDER BY m.nombremateria";                      
                } else {                    
                    $sql = "SELECT m.codigomateria,m.nombremateria FROM materia m
                        inner join v_moodle_aulaVirtualAsignatura a ON a.codigomateria=m.codigomateria 
                    GROUP BY a.codigomateria ORDER BY m.nombremateria ";  
                }
              } else if(strcmp($filtros, "asignatura.aulaVirtual.programaAcademico")==0){
                  if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                    $sql = "SELECT m.codigomateria,m.nombremateria FROM materia m
                                inner join carrera c ON c.codigocarrera = m.codigocarrera AND c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' ";
                        if(isset($filtrosValores['programaAcademico'])){
                            $sql = $sql."AND c.codigocarrera='".$filtrosValores["programaAcademico"]."' ";
                        }
                        //$sql = $sql." inner join modalidadacademicasic ma ON ma.codigomodalidadacademicasic = c.codigomodalidadacademicasic AND ma.codigoestado!=200 ";

                        $sql = $sql." inner join v_moodle_aulaVirtualAsignatura a ON a.codigomateria=m.codigomateria ";  
                        if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                            $sql = $sql." WHERE m.codigoperiodo<= '".$filtrosValores["fechas"]["periodo_final"]."' 
                                AND a.fecha_inicio <= '".$filtrosValores["fechas"]["fecha_final"]."' ";
                        }
                                 $sql = $sql."GROUP BY a.codigomateria ORDER BY c.nombrecarrera,m.nombremateria ";
                                //GROUP BY m.codigomateria,c.codigocarrera ORDER BY ma.nombremodalidadacademicasic,c.nombrecarrera,m.nombremateria";
                  }
              } 
        }
        //var_dump($filtros);
        //var_dump("<br/><br/>");
        //var_dump($filtrosValores);
        //var_dump("<br/><br/>");
        //var_dump($sql);        
        //var_dump("<br/><br/>");
        return $this->db->GetAll($sql);
        
    }
    
    public function getModalidadAcademicaSIC($filtros=null,$filtrosValores=null){  
        $sql = "SELECT codigomodalidadacademicasic,nombremodalidadacademicasic FROM modalidadacademicasic WHERE codigoestado=100 ";
        if(isset($filtrosValores['modalidadAcademicaSIC'])){
            $sql = $sql."AND codigomodalidadacademicasic='".$filtrosValores["modalidadAcademicaSIC"]."' ";
        } 
        $sql = $sql."ORDER BY nombremodalidadacademicasic";
        return $this->db->GetAll($sql);
    }
    
    public function getModalidadAcademica($filtros=null,$filtrosValores=null){  
        $sql = "SELECT codigomodalidadacademica,nombremodalidadacademica FROM modalidadacademica WHERE codigoestado=100 ";
        if(isset($filtrosValores['modalidadAcademica'])){
            $sql = $sql."AND codigomodalidadacademica='".$filtrosValores["modalidadAcademica"]."' ";
        } 
        $sql = $sql."ORDER BY nombremodalidadacademica";
        return $this->db->GetAll($sql);
    }
    
    public function getProgramaAcademico($filtros=null,$filtrosValores=null){  
        $sql = "SELECT codigocarrera,nombrecarrera FROM carrera ";
        if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
           $sql = $sql." WHERE c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' ";
        } 
        $sql = $sql."ORDER BY nombrecarrera";
       if(strcmp($filtros, "programaAcademico.modalidadAcademicaSIC")==0){
            $sql = "SELECT c.codigocarrera,c.nombrecarrera, ma.nombremodalidadacademicasic, ma.codigomodalidadacademicasic FROM carrera c 
                inner join modalidadacademicasic ma ON ma.codigomodalidadacademicasic = c.codigomodalidadacademicasic AND ma.codigoestado=100 ";
            if(isset($filtrosValores['modalidadAcademicaSIC'])){
                    $sql = $sql."AND ma.codigomodalidadacademicasic='".$filtrosValores["modalidadAcademicaSIC"]."' ";
            } 
            /*if(isset($filtrosValores['programaAcademico'])){
                      $sql = $sql."WHERE c.codigocarrera='".$filtrosValores["programaAcademico"]."' ";
            }*/
            if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                $sql = $sql."WHERE c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' ORDER BY c.nombrecarrera";
            }
        } else if(strcmp($filtros, "programaAcademico.modalidadAcademica")==0){
            $sql = "SELECT c.codigocarrera,c.nombrecarrera, ma.nombremodalidadacademica, ma.codigomodalidadacademica FROM carrera c 
                inner join modalidadacademica ma ON ma.codigomodalidadacademica = c.codigomodalidadacademica AND ma.codigoestado=100 ";
            if(isset($filtrosValores['modalidadAcademica'])){
                    $sql = $sql."AND ma.codigomodalidadacademica='".$filtrosValores["modalidadAcademica"]."' ";
            } 
            if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                $sql = $sql."WHERE c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' ORDER BY c.nombrecarrera";
            }
            
        }
        //var_dump($filtros);
        //var_dump("<br/><br/>");
        //var_dump($filtrosValores);
        //var_dump("<br/><br/>");
        //var_dump($sql);
        //var_dump("<br/><br/>");
        return $this->db->GetAll($sql);
    }
    
    public function getContenidoProgramatico($filtros=null,$filtrosValores=null){  
        $sql = "SELECT idcontenidoprogramatico,urlaarchivofinalcontenidoprogramatico,urlasyllabuscontenidoprogramatico FROM contenidoprogramatico WHERE urlasyllabuscontenidoprogramatico!='' AND urlaarchivofinalcontenidoprogramatico!='' AND codigoestado='100' ORDER BY codigomateria";
        
        if(strcmp($filtros, "contenidoProgramatico.programaAcademico")==0){
            $sql = "SELECT cp.idcontenidoprogramatico,cp.urlaarchivofinalcontenidoprogramatico,cp.urlasyllabuscontenidoprogramatico FROM contenidoprogramatico cp
                inner join materia m ON m.codigomateria = cp.codigomateria ";
            $sql = $sql." inner join carrera c ON c.codigocarrera = m.codigocarrera ";
            
            if(isset($filtrosValores['programaAcademico'])){
                    $sql = $sql."AND c.codigocarrera='".$filtrosValores["programaAcademico"]."' ";
            } 
            
            if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                $sql = $sql." WHERE c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."'  
                           AND m.codigoperiodo<= '".$filtrosValores["fechas"]["periodo_final"]."'
                         AND cp.fechainiciocontenidoprogramatico >= '".$filtrosValores["fechas"]["fecha_inicial"]."' 
                            AND cp.fechafincontenidoprogramatico<= '".$filtrosValores["fechas"]["fecha_final"]."'  ";
            }           
                
           $sql = $sql." AND cp.urlasyllabuscontenidoprogramatico!='' AND cp.urlaarchivofinalcontenidoprogramatico!='' AND cp.codigoestado='100' 
                GROUP BY m.codigomateria,c.codigocarrera ORDER BY c.nombrecarrera, m.nombremateria";
        
        } 
        //var_dump($filtros);
        //var_dump($filtrosValores);
        //var_dump($sql);        
        //var_dump("<br/><br/>");
        return $this->db->GetAll($sql);
    }
    
    public function getModalidadAcademicaAulaVirtual($filtros=null,$filtrosValores=null){  
        $sql = "SELECT idsiq_moodle_modalidadAcademica,nombre FROM siq_moodle_modalidadAcademica WHERE codigoestado=100 ORDER BY nombre";        
        return $this->db->GetAll($sql);
    }
    
    
    // Comparison function
    /*private static function compareAulasVirtuales($a, $b) {
        var_dump($a["asignatura"]." - ".$b["asignatura"]." : ".strcasecmp($a["asignatura"], $b["asignatura"]));
        echo "<br/><br/>";
        return strcasecmp($a["asignatura"], $b["asignatura"]);
    }*/
    
    public function getAulaVirtual($filtros=null,$filtrosValores=null){  
        $sql = "SELECT idsiq_moodle_aulaVirtual,asignatura,asignatura_short FROM siq_moodle_aulaVirtual WHERE codigoestado='100' ";
        //$sql = "SELECT idsiq_moodle_aulaVirtual,asignatura,nombremateria FROM v_moodle_aulaVirtualAsignatura WHERE codigoestado='100' ";
        
            //no maneja fechas de vencimiento ni nada, si deja de estar activa se elimina y ya
            if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                $sql = $sql." AND fecha_inicio <= '".$filtrosValores["fechas"]["fecha_final"]."' ";
            }
          $sql = $sql." GROUP BY IFNULL(a.codigomateria, CONCAT(a.idsiq_moodle_aulaVirtual, '-ID')) ";
         
        if(strcmp($filtros, "aulaVirtual.modalidadAcademicaAulaVirtual")==0){
            $sql = "SELECT a.idsiq_moodle_aulaVirtual,a.asignatura,a.asignatura_short FROM siq_moodle_aulaVirtual a
                inner join siq_moodle_modalidadAcademica m ON m.idsiq_moodle_modalidadAcademica = a.codigomodalidadAcademica ";
            
            if(isset($filtrosValores['modalidadAcademicaAulaVirtual'])){
                    $sql = $sql."AND m.idsiq_moodle_modalidadAcademica='".$filtrosValores["modalidadAcademicaAulaVirtual"]."' ";
            }    
            $sql = $sql."WHERE a.codigoestado='100' AND a.fecha_inicio <= '".$filtrosValores["fechas"]["fecha_final"]."' AND a.codigomateria IS NOT NULL GROUP BY IFNULL(a.codigomateria, CONCAT(a.idsiq_moodle_aulaVirtual, '-ID')) ORDER BY a.asignatura"; 
             
        } else if(strcmp($filtros, "aulaVirtual.modalidadAcademicaSIC")==0){
                  if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                    $sql = "SELECT a.codigomateria, a.nombremateria FROM v_moodle_aulaVirtualAsignatura a
                                inner join materia m ON m.codigomateria=a.codigomateria
                                inner join carrera c ON c.codigocarrera = m.codigocarrera AND c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' ";
                        if(isset($filtrosValores['modalidadAcademicaSIC'])){
                            $sql = $sql."AND c.codigomodalidadacademicasic='".$filtrosValores["modalidadAcademicaSIC"]."' ";
                        }
                        //$sql = $sql." inner join modalidadacademicasic ma ON ma.codigomodalidadacademicasic = c.codigomodalidadacademicasic AND ma.codigoestado!=200 ";
                        
                        if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                            $sql = $sql." WHERE m.codigoperiodo<= '".$filtrosValores["fechas"]["periodo_final"]."' 
                                AND a.fecha_inicio <= '".$filtrosValores["fechas"]["fecha_final"]."' ";
                        }
                                 $sql = $sql."GROUP BY m.codigomateria ORDER BY c.nombrecarrera,m.nombremateria ";
                                //GROUP BY m.codigomateria,c.codigocarrera ORDER BY ma.nombremodalidadacademicasic,c.nombrecarrera,m.nombremateria";
                  }
              
        } else if(strcmp($filtros, "aulaVirtual.modalidadAcademica")==0){
                  if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                    $sql = "SELECT a.codigomateria, a.nombremateria FROM v_moodle_aulaVirtualAsignatura a
                                inner join materia m ON m.codigomateria=a.codigomateria
                                inner join carrera c ON c.codigocarrera = m.codigocarrera AND c.fechainiciocarrera<='".$filtrosValores["fechas"]["fecha_final"]."' AND c.fechavencimientocarrera>='".$filtrosValores["fechas"]["fecha_inicial"]."' ";
                        if(isset($filtrosValores['modalidadAcademica'])){
                            $sql = $sql."AND c.codigomodalidadacademica='".$filtrosValores["modalidadAcademica"]."' ";
                        }
                        //$sql = $sql." inner join modalidadacademicasic ma ON ma.codigomodalidadacademicasic = c.codigomodalidadacademicasic AND ma.codigoestado!=200 ";
                        
                        if(isset($filtrosValores["fechas"]) && count($filtrosValores["fechas"])>0){
                            $sql = $sql." WHERE m.codigoperiodo<= '".$filtrosValores["fechas"]["periodo_final"]."' 
                                AND a.fecha_inicio <= '".$filtrosValores["fechas"]["fecha_final"]."' ";
                        }
                                 $sql = $sql."GROUP BY m.codigomateria ORDER BY c.nombrecarrera,m.nombremateria ";
                                //GROUP BY m.codigomateria,c.codigocarrera ORDER BY ma.nombremodalidadacademicasic,c.nombrecarrera,m.nombremateria";
                  }
        }
        
        //$result = $this->db->GetAll($sql) + $this->db->GetAll($sql2);
        //$success = usort($result,array('datosClass','compareAulasVirtuales'));
        //var_dump($result);
        var_dump($sql);
        echo "<br/><br/>";
        return $this->db->GetAll($sql);
    }
    
    public function getFormacionAcademica($filtros=null,$filtrosValores=null){  
        $sql = "SELECT codigoformacionacademica,nombreformacionacademica FROM formacionacademica ORDER BY codigoformacionacademica ASC";        
        return $this->db->GetAll($sql);
    }

    public function __destruct() {
        
    }
}

?>
