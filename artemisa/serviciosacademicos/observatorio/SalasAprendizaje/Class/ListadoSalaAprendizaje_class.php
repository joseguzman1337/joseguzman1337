<?php
class ListadoSalaAprendizaje{
    public function ListadoSalas($db,$Periodo){
         $SQL='SELECT
                	s.SalaAprendizajeId,
                	s.Nombre,
                	s.CodigoCarrera,
                    c.nombrecarrera,
                    s.IdAsignaturaEstado,
                    a.nombreasignaturaestado 
               FROM
                    	SalaAprendizaje s
                    INNER JOIN carrera c ON s.CodigoCarrera = c.codigocarrera
                    INNER JOIN asignaturaestado a ON a.idasignaturaestado=s.IdAsignaturaEstado
                
                WHERE
                
                s.CodigoEstado=100
                AND
                s.CodigoPeriodo="'.$Periodo.'"';
                
         if($Data=&$db->GetAll($SQL)===false){
            echo 'Error en el SQL de Info de Salas de aprendizaje...<br>'.$SQL;
            die;
         }      
         
         for($i=0;$i<count($Data);$i++){
            $Result[$i]['Num']               = $i+1;
            if ($i%2==0) // Vemos si 54 dividido en 2 da resto 0 si lo da
            { $Result[$i]['Color'] = 'C3FFFF'; } //escribo Par
            else //Sino
            { $Result[$i]['Color'] = 'F1FFD0';} //Escribo impar
            $Result[$i]['SalaAprendizajeId'] = $Data[$i]['SalaAprendizajeId'];
            $Result[$i]['Nombre']            = $Data[$i]['Nombre'];
            $Result[$i]['CodigoCarrera']     = $Data[$i]['CodigoCarrera'];
            $Result[$i]['nombrecarrera']     = $Data[$i]['nombrecarrera'];
            $Result[$i]['NombreData']        = $Data[$i]['nombreasignaturaestado'];
         }//for
         
         return $Result; 
    }//public function ListadoSalas
    public function InfoSalaAprendizaje($db,$id){
          $SQL='SELECT
                        s.SalaAprendizajeId,
                        s.Nombre AS NombreSala,
                        s.CodigoCarrera,
                        c.nombrecarrera As Programa,
                        s.CodigoPeriodo AS Periodo,
                        s.Justificacion,
                        s.ObjetivoAprendizaje AS Objetivos,
                        s.Evaluacion,
                        s.Bibliografia
                FROM
                        SalaAprendizaje s INNER JOIN carrera c ON s.CodigoCarrera=c.codigocarrera
                WHERE
                
                s.CodigoEstado=100
                AND
                s.SalaAprendizajeId="'.$id.'"';
                
          if($Info=&$db->GetAll($SQL)===false){
            echo 'Error en el SQL de la Informacion de la Sala de Aprendizaje';
            die;
          }      
          
          return $Info;
    }//public function InfoSalaAprendizaje
    public function SesionSalaAprendizaje($db,$id,$op=''){
          $SQL='SELECT
                    SesionSalaAprendizajeId,
                	Competencia,
                	Contenido,
                	Actividad
                FROM
                	SesionSalaAprendizaje
                WHERE
                	SalaAprendizajeId ="'.$id.'"
                AND CodigoEstado = 100';
                
           if($Sesion=&$db->GetAll($SQL)===false){
             echo 'Error en el SQL de Sesion Sala de Aprendizaje.';
             die;
           }     
           
           for($i=0;$i<count($Sesion);$i++){
               $Resultado[$i]['i']            = $i;
               $Resultado[$i]['Num']          = $i+1;
               $Resultado[$i]['id_Sesion']    = $Sesion[$i]['SesionSalaAprendizajeId'];
               $Resultado[$i]['Competencia']  = $Sesion[$i]['Competencia'];
               $Resultado[$i]['Contenido']    = $Sesion[$i]['Contenido'];
               $Resultado[$i]['Actividad']    = $Sesion[$i]['Actividad'];
           }//for
           
           if($op){
              return count($Resultado)-1;
           }else{           
              return $Resultado;
           }
    }//public function SesionSalaAprendizaje
    public function ElimnarSalaAprendizaje($db,$id,$userid){
        $SQL='UPDATE SalaAprendizaje
              SET    CodigoEstado=200,
                     UsuarioUltimaModificacion="'.$userid.'",
                     FechaultimaModificacion=NOW()
              WHERE
                     SalaAprendizajeId="'.$id.'"';
                     
        if($ElimanrSala=&$db->Execute($SQL)===false){
            $a_vectt['val']			  =false;
            $a_vectt['descrip']		  ='Error en el SQL de Elimnar Sala Aprendizaje.';
            echo json_encode($a_vectt);
            exit;
        } 
        
        $SQL_Session='UPDATE SesionSalaAprendizaje
                      SET    CodigoEstado=200,
                             UsuarioUltimaModificacion="'.$userid.'",
                             FechaultimaModificacion=NOW()
                      WHERE
                             SalaAprendizajeId="'.$id.'"';
                     
        if($ElimanrSesion=&$db->Execute($SQL_Session)===false){
            $a_vectt['val']			  =false;
            $a_vectt['descrip']		  ='Error en el SQL de Elimnar Sesion Sala Aprendizaje.';
            echo json_encode($a_vectt);
            exit; 
        }   
        
        $a_vectt['val']			  =true;
        $a_vectt['descrip']		  ='Se Ha Eliminado la Sala de Aprendizaje.';
        echo json_encode($a_vectt);
        exit;         
    }//public function ElimnarSalaAprendizaje
    public function UpdateSalaAprendizaje($db,$Datos,$userid){
        
        $SQL="UPDATE SalaAprendizaje
              SET    Nombre='".$Datos["NombreSala"]."',
                     CodigoCarrera='".$Datos["Encargado_id"]."',
                     Justificacion='".$Datos["area1"]."',
                     ObjetivoAprendizaje='".$Datos["area2"]."',
                     Evaluacion='".$Datos["area3"]."',
                     Bibliografia='".$Datos["area4"]."',
                     UsuarioUltimaModificacion='".$userid."',
                     FechaultimaModificacion=NOW()
              WHERE
                     SalaAprendizajeId='".$Datos["Sala_id"]."' AND CodigoEstado=100";
        
      
                     
        if($UpdateSala=&$db->Execute($SQL)===false){
            $a_vectt['val']			  =false;
            $a_vectt['descrip']		  ='Error al Modificar la Sala Aprendizaje.';
            echo json_encode($a_vectt);
            exit;
        } 
        
        $SQL_Session='UPDATE SesionSalaAprendizaje
                      SET    CodigoEstado=200,
                             UsuarioUltimaModificacion="'.$userid.'",
                             FechaultimaModificacion=NOW()
                      WHERE
                             SalaAprendizajeId="'.$Datos["Sala_id"].'"';
                     
        if($ElimanrSesion=&$db->Execute($SQL_Session)===false){
            $a_vectt['val']			  =false;
            $a_vectt['descrip']		  ='Error en el SQL de Elimnar Sesion Sala Aprendizaje.';
            echo json_encode($a_vectt);
            exit; 
        }   
        
        for($i=0;$i<count($Datos['Competencia']);$i++){
            if($Datos['id_Sesion'][$i]){
                $SQL_Sesion='UPDATE SesionSalaAprendizaje
                              SET    CodigoEstado=100,
                                     UsuarioUltimaModificacion="'.$userid.'",
                                     FechaultimaModificacion=NOW()
                              WHERE
                                     SalaAprendizajeId="'.$Datos["Sala_id"].'" AND  SesionSalaAprendizajeId="'.$Datos['id_Sesion'][$i].'"';
            }else{
                $SQL_Sesion='INSERT INTO SesionSalaAprendizaje(SalaAprendizajeId,Competencia,Contenido,Actividad,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion)VALUES("'.$Datos["Sala_id"].'","'.$Datos['Competencia'][$i].'","'.$Datos['Contenido'][$i].'","'.$Datos['Actividad'][$i].'","'.$userid.'","'.$userid.'",NOW(),NOW())';
            }
            
            if($EjecutarSesion=&$db->Execute($SQL_Sesion)===false){
                    $a_vectt['val']			  =false;
                    $a_vectt['descrip']		  ='Error en el Modificar o Adiconar la Sesion Sala Aprendizaje.';
                    echo json_encode($a_vectt);
                    exit; 
                } 
        }//for
        
            $a_vectt['val']			  =true;
            $a_vectt['descrip']		  ='Se Ha Modificado La Sala Aprendizaje.';
            echo json_encode($a_vectt);
            exit; 
    }//public function UpdateSalaAprendizaje
     public function banerPrincipal($title){
        ?>
        <link rel="stylesheet" href="../../tablero/css/main.css"></link>
        <div id="encabezado" style=" color: #FFFFFF; line-height: 1em; font-family:'Fjalla One',sans-serif">
    			<div class="cajon">
    				<div style=" margin-left: 100px; color:#E5D912; line-height: 1.2em; font-size: 30px">
    					<div><?php echo $title ?></div>
    				</div>
    				<div style=" margin-left: 20px; line-height: 1em; font-size: 70px;   ">
                                        &Eacute;xito Estudiantil
    				</div>
    			</div>
                <div>
                    <a href="../../tablero/index.php"><img style=" margin-left: 100px;" src="../../tablero/img/inicio2.png"   width="70" height="70"/></a>
                </div>
		</div>
        <?PHP
     }//public function banerPrincipal
}//class
?>