<?php
class CambioPlanEstudio{
    public function Modalidad($db){
          $SQL='SELECT
                	codigomodalidadacademica AS id,
                	nombremodalidadacademica 
                FROM
                	modalidadacademica
                WHERE
                	codigoestado = 100';
                    
          if($Modalidad=&$db->GetAll($SQL)===false){
             echo 'Error del Sistema....';
             die;
          }      
         
          return $Modalidad;     
    }//public function Modalidad

    public function Programa($db,$id){
          $SQL='SELECT
                	codigocarrera AS id,
                	nombrecarrera AS Nombre
                FROM
                	carrera
                WHERE
                	codigomodalidadacademica = "'.$id.'"
                AND (	fechavencimientocarrera >= curdate() 	OR EsAdministrativa = 1)
                AND codigocarrera NOT IN (1)';
                
          if($Programa=&$db->GetAll($SQL)===false){
            echo 'Error en el Sistema...';
            die;
          }     
        
        return $Programa;           
    }//public function Programa
    public function ViewSelect($dato,$Name,$Funcion=''){
        ?>
        <select id="<?PHP echo $Name?>" name="<?PHP echo $Name?>" onchange="<?PHP echo $Funcion?>(this.value)">
            <option value="-1"></option>
            <?PHP 
            for($i=0;$i<count($dato);$i++){
                ?>
                <option value="<?PHP echo $dato[$i]['id']?>"><?PHP echo $dato[$i]['Nombre']?></option>
                <?PHP
            }//for
            ?>
        </select>
        <?PHP
    }//public function ViewPrograma
    public function PlanEstudio($db,$id){
         $SQL='SELECT
                	idplanestudio AS id,
                	nombreplanestudio AS Nombre
                FROM
                	planestudio
                WHERE
                	codigocarrera = "'.$id.'"
                AND codigoestadoplanestudio = 100 ORDER BY nombreplanestudio';
                
         if($PlanEstudio=&$db->GetAll($SQL)===false){
            echo 'error en el sistema...';
            die;
         } 
         
       return $PlanEstudio;        
    }// public function PlanEstudio
    public function Validacion($db,$carrera,$PlanEstudioOld,$PlanEstudioNew){
        $Periodos = $this->Periodo($db);
          $SQL='SELECT
                	e.codigoestudiante
                FROM
                	estudiante e
                INNER JOIN planestudioestudiante p ON e.codigoestudiante = p.codigoestudiante
                INNER JOIN prematricula pp ON pp.codigoestudiante = e.codigoestudiante
                WHERE
                	e.codigocarrera = "'.$carrera.'"
                AND p.idplanestudio = "'.$PlanEstudioOld.'"
                AND pp.codigoperiodo IN ('.$Periodos.')
                AND pp.codigoestadoprematricula IN (40, 41)
                AND e.codigosituacioncarreraestudiante NOT IN (104, 400, 500)';
                
         if($Estudiante=&$db->GetAll($SQL)===false){
            echo 'Error en el Sistema...';
            die;
         }      
         
         for($i=0;$i<count($Estudiante);$i++){
            $this->CambiarPlanEstudio($db,$Estudiante[$i]['codigoestudiante'],$PlanEstudioOld,$PlanEstudioNew);
         }//for 
    }//public function Validacion
    public function Periodo($db){
          $SQL='SELECT
                        codigoperiodo,
                        codigoestadoperiodo
                FROM
                        periodo                
                WHERE
                
                        codigoestadoperiodo IN (1,3)
                        
                ORDER BY codigoestadoperiodo DESC';
                        
          if($Periodo=&$db->GetAll($SQL)===false){
             echo 'error en el sistema...';
             die;
          }  
          
         
            if($Periodo[0]['codigoestadoperiodo']==3){
                $arrayP = str_split($Periodo[0]['codigoperiodo'], strlen($Periodo[0]['codigoperiodo'])-1);
            }else{
                $arrayP = str_split($Periodo[0]['codigoperiodo'], strlen($Periodo[0]['codigoperiodo'])-1);
            } 
            
            if($arrayP[1]==2){
                $Year1 = $arrayP[0].'1';
                $Year2 = $arrayP[0].'2';
            }else{
                $Year1 = $arrayP[0].'1';
                $Year2 = ($arrayP[0]-1).'2';
            }
            
           return  $Periodos = $Year1.','.$Year2;         
    }//public function Periodo
    public function CambiarPlanEstudio($db,$CodigoEstudiante,$PlanEstudioNew){
        
        $SQL='UPDATE planestudioestudiante
              SET    codigoestadoplanestudioestudiante = 200,
                     fechavencimientoplanestudioestudiante = NOW()
              WHERE
            	     codigoestudiante ="'.$CodigoEstudiante.'"';
                     
        if($Desactiva=&$db->Execute($SQL)===false){
            echo 'Error en el Sistema..';
            die;
        } 
        
        $FechaFin = '2999-12-31 00:00:00';
         
        $Insert='INSERT INTO planestudioestudiante (idplanestudio,codigoestudiante,fechaasignacionplanestudioestudiante,fechainicioplanestudioestudiante,fechavencimientoplanestudioestudiante,codigoestadoplanestudioestudiante)VALUES("'.$PlanEstudioNew.'","'.$CodigoEstudiante.'",NOW(),NOW(),"'.$FechaFin.'",100   )';   
        
        if($NuevoRegistro=&$db->Execute($Insert)===false){
            echo 'Error en el Sistema..';
            die;
        }          
        
    }//public function CambiarPlanEstudio
    public function LecturaArchivo($db,$carrera,$PlanEstudioNew,$_FILES){
         $filename = $_FILES['Archivo']['tmp_name'];
         
         $Delimit = $this->getFileDelimiter($filename);
         
         $handle = fopen($filename, "r");
         
          while (($data = fgetcsv($handle, 1000, $Delimit)) !== FALSE){
               //Insertamos los datos con los valores...
               if($data[0]){
                  $SQL='SELECT
                        	e.codigoestudiante
                        FROM
                        	estudiantegeneral g
                        INNER JOIN estudiante e ON e.idestudiantegeneral = g.idestudiantegeneral
                        WHERE
                        	e.codigocarrera = "'.$carrera.'"
                        AND g.numerodocumento = "'.$data[0].'"';
                        
                  if($Estudiante=&$db->Execute($SQL)===false){
                     echo 'Error en el sistema...';
                     die;
                  }      
                
                  if(!$Estudiante->EOF){
                      $this->CambiarPlanEstudio($db,$Estudiante->fields['codigoestudiante'],$PlanEstudioNew);
                  }  
                }
             }//while
             //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
             fclose($handle);
    }//public function LecturaArchivo
    function getFileDelimiter($file, $checkLines = 2){
        $file = new SplFileObject($file);
        $delimiters = array(
          ',',
          '\t',
          ';',
          '|',
          ':'
        );
        $results = array();
        for($i = 0; $i <= $checkLines; $i++){
            $line = $file->fgets();
            foreach ($delimiters as $delimiter){
                $regExp = '/['.$delimiter.']/';
                $fields = preg_split($regExp, $line);
                if(count($fields) > 1){
                    if(!empty($results[$delimiter])){
                        $results[$delimiter]++;
                    } else {
                        $results[$delimiter] = 1;
                    }   
                }
            }
        }
        $results = array_keys($results, max($results));
        return $results[0];
    }
}//calss

?>