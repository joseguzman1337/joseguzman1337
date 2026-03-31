<?php
class CrearSalaAprendizaje{
    public function Periodo($db){
          $SQL='SELECT
                	codigoperiodo AS CodigoPeriodo,
                	CodigoPeriodo AS NamePeriodo
                FROM
                	periodo
                ORDER BY
                	codigoperiodo DESC';
                    
         if($Periodo=&$db->GetAll($SQL)===false){
                echo 'Error en el SQL del Periodo...<br><br>'.$SQL;
                die;
         }          
         
         return $Periodo; 
    }//public function Periodo
    public function AddTr($db,$i){ 
        ?>
        <td style="text-align: center;"><strong><?PHP echo $i+1?></strong></td>
        <td style="text-align: center;">
            <input type="text" id="Competencia_<?PHP echo $i?>" name="Competencia[]" size="70" />
        </td>
        <td style="text-align: center;">
            <input type="text" id="Contenido_<?PHP echo $i?>" name="Contenido[]" size="70" />
        </td>
        <td style="text-align: center;">
            <input type="text" id="Actividad_<?PHP echo $i?>" name="Actividad[]" size="70" />
        </td>
        <?PHP
    }//public function AddTr
    public function DepartamentoPrograma($db,$Letra){
          $SQL='SELECT
                	codigocarrera,
                	nombrecarrera
                FROM
                	carrera
                WHERE
                	codigomodalidadacademica = 200
                AND codigocarrera <> 1
                AND (codigocarrera LIKE "'.$Letra.'%" OR nombrecarrera LIKE "'.$Letra.'%")
                 
                ORDER BY
                	nombrecarrera';
                    
         if($Programas=&$db->GetAll($SQL)===false){
            echo 'Error en el SQL de la Carrera ...<br><br>'.$SQL;
            die;
         } 
         
        $DataPrograma = array(); 
         
        for($i=0;$i<count($Programas);$i++){
            
                $Ini_Vectt['label']=$Programas[$i]['codigocarrera'].' :: '.$Programas[$i]['nombrecarrera'];
                $Ini_Vectt['value']=$Programas[$i]['codigocarrera'].' :: '.$Programas[$i]['nombrecarrera'];
                $Ini_Vectt['id']   =$Programas[$i]['codigocarrera'];
                
                array_push($DataPrograma, $Ini_Vectt);
          
        }//for
               
       echo json_encode($DataPrograma);          
    }//public function DepartamentoPrograma
    public function InsertSalaAprendizaje($db,$Datos,$userid){
        $Nombre         = $Datos['NombreSala'];
        $Periodo        = $Datos['Periodo'];
        $Encargado_id   = $Datos['Encargado_id'];
        $Justificacion  = $Datos['area1'];
        $Objetivo       = $Datos['area2'];
        $Evaluacion     = $Datos['area3'];
        $Bibliografia   = $Datos['area4'];
        $Competencia    = $Datos['Competencia'];
        $Contenido      = $Datos['Contenido'];
        $Actividad      = $Datos['Actividad'];
        $CompetenciasInicial    = $Datos['CompetenciasInicial'];
        
        
        $SQL_Sala="INSERT INTO SalaAprendizaje(Nombre,CodigoPeriodo,CodigoCarrera,Justificacion,ObjetivoAprendizaje,Evaluacion,Bibliografia,IdAsignaturaEstado,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion)VALUES('".$Nombre."','".$Periodo."','".$Encargado_id."','".$Justificacion."','".$Objetivo."','".$Evaluacion."','".$Bibliografia."','".$CompetenciasInicial."','".$userid."','".$userid."',NOW(),NOW())";
        
        if($InsertSalaAprendizaje=&$db->Execute($SQL_Sala)===false){
            $a_vectt['val']			  =false;
            $a_vectt['descrip']		  ='Error al Crear la Sala de Aprendizaje....';
            echo json_encode($a_vectt);
            exit;
        }
        
        $Last_id=$db->Insert_ID();
        
        for($i=0;$i<count($Competencia);$i++){
        
            $SQL_Sesion='INSERT INTO SesionSalaAprendizaje(SalaAprendizajeId,Competencia,Contenido,Actividad,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion)VALUES("'.$Last_id.'","'.$Competencia[$i].'","'.$Contenido[$i].'","'.$Actividad[$i].'","'.$userid.'","'.$userid.'",NOW(),NOW())';
            
            if($InsertSesionAprendizaje=&$db->Execute($SQL_Sesion)===false){
                $a_vectt['val']			  =false;
                $a_vectt['descrip']		  ='Error al Crear las Sesiones de la Sala de Aprendizaje....';
                echo json_encode($a_vectt);
                exit;
            }
        
        }//for
        
        $a_vectt['val']			  =true;
        $a_vectt['descrip']		  ='Se Ha Creado la Sala de Aprendizaje.';
        echo json_encode($a_vectt);
        exit;
    }//public function InsertSalaAprendizaje
   public function Competencias($db,$periodo){
          $SQL='SELECT
                	idasignaturaestado AS id,
                	nombreasignaturaestado AS Nombre
                FROM
                	asignaturaestado
                WHERE
                	TipoPrueba = 2
                AND codigoestado = 100
                AND CuentaCompetenciaBasica = 1
                AND  idasignaturaestado NOT IN(SELECT
                s.IdAsignaturaEstado
                FROM
                SalaAprendizaje s
                WHERE
                s.CodigoEstado=100
                AND
                s.CodigoPeriodo="'.$periodo.'")
                ORDER BY
                	nombreasignaturaestado ASC';
                    
         if($Competencia=&$db->GetAll($SQL)===false){
            echo 'Error en el SQL ...<br><br>'.$SQL;
            die;
         }  
         
       return $Competencia;           
   }//public function Competencias
}//class

?>