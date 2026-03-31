<?php 


class UtilsContinuada{
	public function ReporteOrden($db){
		
		 $SQL= "SELECT E.codigoestudiante, E.idestudiantegeneral, E.codigoperiodo, EC.EstudianteConvenioEducacionContinuadaId,C.codigocarrera, C.nombrecarrera,
				concat(EG.nombresestudiantegeneral, ' ' , EG.apellidosestudiantegeneral) as nombreEstudiante, EG.numerodocumento, EG.emailestudiantegeneral,
				EG.celularestudiantegeneral
				FROM EstudianteConvenioEducacionContinuada EC 
				INNER JOIN estudiantegeneral EG ON EC.Idestudiantegeneral= EG.idestudiantegeneral
				INNER JOIN estudiante E ON E.codigocarrera = EC.CodigoCarrera AND E.idestudiantegeneral=EC.Idestudiantegeneral 
				INNER JOIN carrera C ON C.codigocarrera = E.codigocarrera
				INNER JOIN periodo P ON P.codigoperiodo = E.codigoperiodo AND P.codigoestadoperiodo IN (1,3) 
				WHERE EC.CodigoEstado = '100'
				AND EC.Estatus IS NULL";
		if($data=&$db->GetAll($SQL)===false){
			echo "error en Consulta";
			die;
		}
		return $data;
			
		
	}//public function ReporteOrden
    public function DataEstudiante($db,$codigoestudiante,$codigoperiodo){
          $SQL='SELECT
                	CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) AS fulname,
                	eg.numerodocumento,
                	eg.emailestudiantegeneral,
                	eg.celularestudiantegeneral,
                	c.nombrecarrera
                FROM
                	estudiante e
                INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
                INNER JOIN carrera c ON c.codigocarrera = e.codigocarrera
                WHERE
                	e.codigoestudiante ="'.$codigoestudiante.'"
                AND e.codigoperiodo = "'.$codigoperiodo.'"';
                
          if($Data=&$db->GetArray($SQL)===false){
             echo 'Error en la Consulta...2';
             die;
          }  
          
          return $Data;    
    }//public function DataEstudiante
    public function AutoCarreraNueva($db,$Letra){
        
          $SQL='SELECT
                    codigocarrera,
                    nombrecarrera
                FROM
                    carrera 
                WHERE
                
                    codigocarrera LIKE "'.$Letra.'%" OR nombrecarrera LIKE "'.$Letra.'%"';
                    
           if($Carreras=&$db->Execute($SQL)===false){
                echo 'Error en la Consultas ...3';
                die;
           }         
        
        $DataMateria = array();
        
        if(!$Carreras->EOF){
            while(!$Carreras->EOF){
                
                    $Ini_Vectt['label']=$Carreras->fields['codigocarrera'].' :: '.$Carreras->fields['nombrecarrera'];
                    $Ini_Vectt['value']=$Carreras->fields['codigocarrera'].' :: '.$Carreras->fields['nombrecarrera'];
                    $Ini_Vectt['id']   =$Carreras->fields['codigocarrera'];
                    
                    array_push($DataMateria, $Ini_Vectt);
                
                $Carreras->MoveNext();
            }//while
        }else{
            $Ini_Vectt['label']='No Hay Informacion';
            $Ini_Vectt['value']='No Hay Informacion';
            $Ini_Vectt['id']   ='-1';
            
            array_push($DataMateria, $Ini_Vectt);
        } 
        
       echo json_encode($DataMateria);
    }//public function AutoCarreraNueva
}

?>