<?PHP 
 require(realpath(dirname(__FILE__)).'/obtener_materias_class.php');
class RegistroFallasEstudiante extends obtener_materias{
    var $db;
    var $usuarioid;
    var $idgrupo;
    function __construct($db,$usuarioid,$idgrupo){ 
		$this->db  = $db;
        $this->usuarioid = $usuarioid;
        $this->idgrupo = $idgrupo;
        $this->periodo();
	}//__construct
    function validacionEstudianteGrupo($codigoestudiante){
          $SQL='SELECT
                    p.idprematricula
                FROM
                    prematricula p
                INNER JOIN detalleprematricula dp ON dp.idprematricula = p.idprematricula
                AND p.codigoperiodo = ?
                AND p.codigoestudiante = ?
                AND dp.idgrupo = ?';
        
        if($this->PeriodoPrecierre){
            $variable[] = "$this->PeriodoPrecierre";
        }else{
            $variable[] = "$this->PeriodoActivo";
        }
        
        $variable[] = "$codigoestudiante";
        $variable[] = "$this->idgrupo";
        
        // $this->db->debug = true;
        
        $DatosEstudiante = $this->db->Execute($SQL,$variable);
        
        if($DatosEstudiante===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        if(!$DatosEstudiante->EOF){
            return true;
        }else{
            return false;
        }
            
    }//function validacionEstudianteGrupo
   function IngresoFallas($C_codigoestudiante,$tipomateria){
       $num = count($C_codigoestudiante[0]['Array']);
       
        for($i=0;$i<$num;$i++){
            $codigoestudiante = $C_codigoestudiante[0]['Array'][$i];
            if($codigoestudiante){  
                if($this->validacionEstudianteGrupo($codigoestudiante)){ 
                    if($this->ValidaRegistroFalla($codigoestudiante,$tipomateria)){
                    $this->InsertFallasEstudiante($codigoestudiante,$tipomateria); 
                    }
                }    
            }else{
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
            }
        }//for
        
        return true;
    }//function IngresoFallas
    function ValidaRegistroFalla($codigoestudiante,$tipomateria){
        $SQL='SELECT
                    FallasEstudianteId
              FROM
                    FallasEstudiante
              WHERE
                    CodigoEstudiante = ?
                AND IdGrupo = ?
                AND CodigoEstado = 100
                AND codigomodalidadmateria =? 
                AND DATE(FechaCreacion) = ?';
        
        $variable   = array();
        $variable[] = "$codigoestudiante";
        $variable[] = "$this->idgrupo";
        $variable[] = "$tipomateria";
        $fecha      = date('Y-m-d');
        $variable[] = "$fecha";
        
        //$this->db->debug = true; 
        
        $DatosEstudiante = $this->db->Execute($SQL,$variable);
        
        if($DatosEstudiante===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        if(!$DatosEstudiante->EOF){
            return false;
        }else{
            return true;
        }
    }//function ValidaRegistroFalla
    function InsertFallasEstudiante($codigoestudiante,$tipomateria){
        $SQL_Insert='INSERT INTO FallasEstudiante(CodigoEstudiante,IdGrupo,codigomodalidadmateria,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES(?,?,?,?,NOW(),?,NOW())';
        
        $variable   = array();
        $variable[] ="$codigoestudiante";
        $variable[] ="$this->idgrupo";
        $variable[] ="$tipomateria"; 
        $variable[] ="$this->usuarioid";
        //$variable[] ="NOW()";
        $variable[] ="$this->usuarioid";
        //$variable[] ="NOW()";
       
        //$this->db->debug = true; 
        
        $DatosEstudiante = $this->db->Execute($SQL_Insert,$variable);
        //die;
        if($DatosEstudiante===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        return true;
    }//function InsertFallasEstudiante
}//class
?>