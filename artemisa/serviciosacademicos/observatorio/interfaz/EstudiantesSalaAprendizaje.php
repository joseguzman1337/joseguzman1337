<?php

/*
[Estudiante] => Array
        (
            [0] => 153598
            [1] => 153703
        )

    [CheckSession] => Array
        (
            [0] => 2
            [1] => 2
        )

    [NumSessiones] => Array
        (
            [0] => 4
            [1] => 4
        )

    [Evaluacion] => Array
        (
            [0] => 
            [1] => 
        )
*/

 switch($_REQUEST['action_ID']){
    case 'SaveData':{
        include('../templates/templateObservatorio.php');
        $db = writeHeaderBD();
        
        $SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    
        if($Usario_id=&$db->Execute($SQL_User)===false){
        		echo 'Error en el SQL Userid...<br>'.$SQL_User;
        		die;
        	}
        
        $userid=$Usario_id->fields['id'];
        $Estudiante   = $_POST['Estudiante'];
        $CheckSession = $_POST['CheckSession'];
        $NumSessiones = $_POST['NumSessiones'];
        $Evaluacion   = $_POST['Evaluacion'];
        $EstudianteSala = $_POST['EstudianteSala'];
       // echo '<pre>';print_r($_POST);
        SaveDataEstudiante($db,$Estudiante,$CheckSession,$NumSessiones,$Evaluacion,$EstudianteSala,$userid);
    }break;
    default:{
        include('../templates/templateObservatorio.php');
        //include_once ('funciones_datos.php');
         //  $db=writeHeaderBD();
           $db=writeHeader('Observatorio',true,'');
        $Periodo = $_POST['periodo'];
        $Carrera = $_POST['carrera'];
        $Carrera = str_replace("\'"," ",$Carrera);
        $Competencia  = $_POST['Competencia'];
        Display($db,$Periodo,$Carrera,$Competencia);
    }break;
 }

function  Display($db,$Periodo,$Carrera,$Competencia){

 $SQL='SELECT
        	s.Nombre,
        	ss.CodigoEstudiante,
        	CONCAT(eg.nombresestudiantegeneral," ",	eg.apellidosestudiantegeneral) AS EstudianteName,
        	eg.numerodocumento,
        	c.nombrecarrera,
        	s.SalaAprendizajeId,
            ss.SalaAprendizajeEstudianteId
        FROM
        	SalaAprendizaje s
        INNER JOIN SalaAprendizajeEstudiante ss ON ss.SalaAprendizajeId = s.SalaAprendizajeId
        INNER JOIN estudiante e ON e.codigoestudiante = ss.CodigoEstudiante
        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
        INNER JOIN carrera c ON c.codigocarrera = e.codigocarrera
        WHERE
        	c.codigocarrera IN ('.$Carrera.')
        AND s.CodigoEstado = 100
        AND ss.CodigoEstado = 100
        AND s.CodigoPeriodo="'.$Periodo.'"
        AND s.IdAsignaturaEstado="'.$Competencia.'"
        
        GROUP BY e.codigoestudiante';
        
    if($Resultado=&$db->GetAll($SQL)===false){
        echo 'Error en el SQL de busueda de la informacion....<br><br>'.$SQL;
        die;
    }
    
    ?>
    <br /><br />
    <form id="EstudiantesAulas">
    <input type="hidden" id="action_ID" name="action_ID" value="SaveData" />
    <table style="width: 100%; border: 2px solid black;" >
        <thead>
            <tr>
                <th style="border: 2px solid black;">Programa Académico</th>
                <th style="border: 2px solid black;">Nombre</th>
                <th style="border: 2px solid black;">N&deg; Identificación</th>
                <th style="width: 200px;border: 2px solid black;">Sala de Aprendizaje</th>
                <th colspan="2" style="border: 2px solid black;">Asistencia de Sesiones</th>
                <th colspan="2" style="border: 2px solid black;">Evalución</th>
            </tr>
        </thead>
        <tbody>
            <?PHP 
            for($i=0;$i<count($Resultado);$i++){
                ?>
                <tr style="border: 2px solid black;">
                    <td style="border: 2px solid black;"><?PHP echo $Resultado[$i]['nombrecarrera']?></td>
                    <td style="border: 2px solid black;"><?PHP echo $Resultado[$i]['EstudianteName']?>
                        <input type="hidden" id="Estudiante" name="Estudiante[]" value="<?PHP echo $Resultado[$i]['CodigoEstudiante']?>" />
                        <input type="hidden" id="EstudianteSala" name="EstudianteSala[]" value="<?PHP echo $Resultado[$i]['SalaAprendizajeEstudianteId']?>" />
                    </td>
                    <td style="border: 2px solid black;"><?PHP echo $Resultado[$i]['numerodocumento']?></td>
                    <td colspan="5">
                    <?PHP DataAdiconalInfo($db,$Resultado[$i]['CodigoEstudiante'],$Periodo,$Competencia);?>
                    </td>
                </tr>
                <?PHP
            }//for
            ?>
        </tbody>
    </table>
    </form>
    <br /><br />
    <div>
        <button title="Guardar" style="cursor: pointer;" class="submit" onclick="SaveEvaluacion()">Guardar&nbsp;&nbsp;<img src="../../mgi/images/Save_reg.png" width="25" /></button>
    </div>
    <?PHP  
  }//function  Display 
    function DataAdiconalInfo($db,$Estudiante,$Periodo,$Competencia){
        $SQL='SELECT
                	s.Nombre,
                	COUNT(se.SalaAprendizajeId) AS Sesiones,
                	se.SalaAprendizajeId,
                    se.SesionSalaAprendizajeId
                FROM
                	SalaAprendizaje s
                INNER JOIN SalaAprendizajeEstudiante ss ON ss.SalaAprendizajeId = s.SalaAprendizajeId
                INNER JOIN SesionSalaAprendizaje se ON se.SalaAprendizajeId = s.SalaAprendizajeId
                WHERE
                	ss.CodigoEstudiante ="'.$Estudiante.'"
                AND s.CodigoPeriodo ="'.$Periodo.'"
                AND s.CodigoEstado = 100
                AND ss.CodigoEstado = 100
                AND se.CodigoEstado = 100
                AND s.IdAsignaturaEstado="'.$Competencia.'"
                GROUP BY
                	se.SalaAprendizajeId';
                    
         if($Sesiones=&$db->GetAll($SQL)===false){
            echo 'Error en el SQL de Sala Sessiones...<br><br>'.$SQL;
            die;
         }  
         ?>
         <table style="width: 100%;" border="1">
            <?PHP 
            for($i=0;$i<count($Sesiones);$i++){
                $SQL_num = 'SELECT
                            	e.SalaAprendizajeId,
                                a.SesionSalaAprendizajeId,
                                MAX(a.SesionSalaAprendizajeId)  AS Max
 
                            FROM
                            	AsistenciaSesionSalaAprendizaje a
                            INNER JOIN SalaAprendizajeEstudiante e ON a.SalaAprendizajeEstudianteId = e.SalaAprendizajeEstudianteId
                            WHERE
                            	e.SalaAprendizajeId = "'.$Sesiones[$i]['SalaAprendizajeId'].'"
                            AND a.CodigoEstado = 100
                            
                            ';//GROUP BY a.SesionSalaAprendizajeId
                            
                     if($num=&$db->GetAll($SQL_num)===false){
                        echo 'Error en el SQL del Num...<br><br>'.$SQL;
                        die;
                     }       
                     
                    
                ?>
                <tr>
                    <td style="width: 200px;"><?PHP echo $Sesiones[$i]['Nombre']?></td>
                    <td colspan="2" style="width: 400px;"><?PHP CheckSesion($Sesiones[$i]['Sesiones'],$Estudiante,$num,$Sesiones[$i]['SalaAprendizajeId'],$db);?><input type="hidden" id="NumSessiones" name="NumSessiones[]" value="<?PHP echo $Sesiones[$i]['Sesiones']?>" /></td>
                    <td colspan="2" style="text-align: center;">
                    <?PHP 
                    $X = $Sesiones[$i]['Sesiones']-1;
                    $NumDato = NumCheckSession($Sesiones[$i]['Sesiones'],$num,$Sesiones[$i]['SalaAprendizajeId'],$db);
                    if($X==$NumDato){
                    ?>
                    <input type="text" id="Evaluacion_<?PHP echo $Sesiones[$i]['SalaAprendizajeId']?>_<?PHP echo $Estudiante?>" name="Evaluacion[]" />
                    <?PHP 
                    }
                    ?>
                    </td>
                </tr>
                <?PHP
            }//for
            ?>
         </table>
         <?PHP         
    }//function DataAdiconalInfo 
    function CheckSesion($Sesiones,$Estudiante,$num,$Sala,$db){ 
        for($i=0;$i<$Sesiones;$i++){
            $disabled = '';
            $checked  = '';
            $Type     = 'type="checkbox"';
            $id_Check = 'id="CheckSession_'.$Estudiante.'_'.$i.'"';
            $N = $i+1;
            $SessionesSala = SesionesSalas($db,$Sala);
            
            if($SessionesSala[$i]['SesionSalaAprendizajeId']<=$num[0]['Max']){
                    $disabled = 'disabled="disabled"';
                    $Val = ChekEstudiante($db,$Estudiante,$Sala,$SessionesSala[$i]['SesionSalaAprendizajeId']);
                    if($Val){
                      $checked  = 'checked="checked"';  
                    }else{
                      $checked  = '';  
                    }
                    $Type     = 'type="checkbox"';
                    $id_Check = 'id="CheckSession_'.$Estudiante.'"';
            }
            ?>
            <?PHP echo $N?><input <?PHP echo $Type?> <?PHP echo $disabled;?> <?PHP echo $checked;?> style="cursor: pointer;" class="CheckEstudiante" <?PHP echo $id_Check?> name="CheckSession[]" value="<?PHP echo $SessionesSala[$i]['SesionSalaAprendizajeId']?>" onclick="CheckAuto('<?PHP echo $Estudiante?>','<?PHP echo $Sesiones;?>','<?PHP echo $i;?>')" />&nbsp;
            <?PHP
        }//for
    }//function CheckSesion
    function SaveDataEstudiante($db,$Estudiante,$CheckSession,$NumSessiones,$Evaluacion,$EstudianteSala,$userid){
        for($i=0;$i<count($Estudiante);$i++){
            /************************************************************/
            if($Estudiante[$i]){
                if($CheckSession[$i]){
                    
                    $SQL='INSERT INTO AsistenciaSesionSalaAprendizaje(SalaAprendizajeEstudianteId,SesionSalaAprendizajeId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion)VALUES("'.$EstudianteSala[$i].'","'.$CheckSession[$i].'","'.$userid.'","'.$userid.'",NOW(),NOW())';
                    
                    if($Insert=&$db->Execute($SQL)===false){
                        echo 'Error en el Insert de Asitencia....'.$SQL;
                        die;
                    }
                    
                }//if
            }//if
            /************************************************************/
        }//for
        
        $a_vectt['val']			  =true;
        $a_vectt['descrip']		  ='Se Ha Guardado Correctamente';
        echo json_encode($a_vectt);
        exit;
    }//function SaveDataEstudiante
    function ChekEstudiante($db,$Estudiante,$Sala,$Session){
         $SQL='SELECT
                	e.SalaAprendizajeEstudianteId
                FROM
                	AsistenciaSesionSalaAprendizaje a
                INNER JOIN SalaAprendizajeEstudiante e ON a.SalaAprendizajeEstudianteId = e.SalaAprendizajeEstudianteId
                WHERE
                	e.SalaAprendizajeId = "'.$Sala.'"
                AND a.CodigoEstado = 100
                AND e.CodigoEstudiante = "'.$Estudiante.'"
                AND a.SesionSalaAprendizajeId="'.$Session.'"';
               
         if($EstudianteCheck=&$db->Execute($SQL)===false){
             echo 'Error en el SQL de Sesion de Estudiante....<br><br>'.$SQL;
             die;
          }    
          if(!$EstudianteCheck->EOF){
              return true;
          }else{
             return false;
          }
    }//function ChekEstudiante
    function SesionesSalas($db,$sala){
          $SQL='SELECT
                	SesionSalaAprendizajeId
                FROM
                	SesionSalaAprendizaje
                WHERE
                	SalaAprendizajeId ="'.$sala.'"
                AND CodigoEstado=100';
                
          if($SessionesSala=&$db->GetAll($SQL)===false){
            echo 'Error en el SQL de Sala Sessiones...<br><br>'.$SQL;
            die;
          }   
          
          return $SessionesSala;   
    }//function SesionesSalas
    function NumCheckSession($Sesiones,$num,$Sala,$db){
        $J=0;
        for($i=0;$i<$Sesiones;$i++){
            $SessionesSala = SesionesSalas($db,$Sala);
            if($SessionesSala[$i]['SesionSalaAprendizajeId']<=$num[0]['Max']){
             $J++;   
            }//if
        }//for
       
        return $J;
    }//function NumCheckSession
?>