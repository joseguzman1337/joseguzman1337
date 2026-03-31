<?php

global $userid,$db;
		
		
		include("../templates/template.php");
        
        include('InterfazSolicitud_class.php');  $C_InterfazSolicitud = new InterfazSolicitud();
			$db = getBD();
        
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
		 
		 $Hora = date('Y-m-d');
		 
		 				header('Content-type: application/vnd.ms-excel');
						header("Content-Disposition: attachment; filename=Solicitudes_".$Hora.".xls");
						header("Pragma: no-cache");
						header("Expires: 0");
                        
                        
                       
	
$Resultado = $C_InterfazSolicitud->DataSolicitudesPrint($db,$userid);

//echo '<pre>';print_r($Resultado);
  
?>
<div style="text-align: center; font-size: 30pt;">SOLICITUDES INTERNAS</div>
<table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
    <tdead>
        <tr>    
            <th>ID SOLICITUD</th>   
            <th>ID SOLICITUD DETALLE</th>
            <th>PROGRAMA</th> 
            <th>MATERIA</th> 
            <th>ID GRUPO</th>
            <th>N&deg; Matriuclados + Prematriculados</th> 
            <th>SEMESTRE</th> 
            <th>DIA SEMANA</th>                     
            <th>HORA INICIO</th>
            <th>HORA FIN</th>
            <th>FECHA INICIO</th>
            <th>FECHA FIN</th>
            <th>OBSERVACIONES</th>
            <th>AULA O ESAPCIO</th>
            <th>ASIGNADO/SOLICITADO</th>
            <th>INSTALACION</th>
            <th>TIPO AULA</th>
            <th>DOCENTE</th>
            <th>Tipo Solicitud</th>
        </tr>
    </thead>
    <tbody> 
    <?PHP 
    $num = count($Resultado);
    for($i=0;$i<count($Resultado);$i++){
        /*****************************************************/
        if($Resultado[$i]["codigomodalidadacademica"]==001 || $Resultado[$i]["codigomodalidadacademica"]=='001'){
            AllSolicitudes($db,$Resultado[$i],$Resultado[$i]["codigomodalidadacademica"]);
        }else{
            $Externas[]                 = $Resultado[$i];
            
        }
        /*****************************************************/
    }//for
    ?>                      
    </tbody>
</table>
<div style="text-align: center; font-size: 30pt;">SOLICITUDES EXTERNAS</div>
<table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
    <thead>
        <tr>    
            <th>ID SOLICITUD</th>    
            <th>ID SOLICITUD DETALLE</th>
            <th>PROGRAMA</th> 
            <th>NOMBRE DEL EVENTO</th> 
            <th>UNIDAD RESPONSABLE</th><!--ID GRUPO-->
            <th>NUMERO ASISTENTES</th>
            <th>&nbsp;</th><!--SEMESTRE-->
            <th>DIA SEMANA</th>  
            <th>HORA INICIO</th>
            <th>HORA FIN</th>
            <th>FECHA INICIO</th>
            <th>FECHA FIN</th>
            <th>OBSERVACIONES</th>
            <th>AULA O ESAPCIO</th>
            <th>ASIGNADO/SOLICITADO</th>
            <th>INSTALACION</th>
            <th>TIPO AULA</th>
            <th>Persona Responsable</th><!--DOCENTE-->
            <th>Tipo Solicitud</th>
        </tr>
    </thead>
    <tbody> 
    <?PHP 
    //echo '<pre>';print_r($Externas);
    ////////////////////solicitudes externas
    for($j=0;$j<count($Externas);$j++){
       AllSolicitudes($db,$Externas[$j],$Externas[$j]["codigomodalidadacademica"]); 
    }    
    ?>                      
    </tbody>
</table>
<?PHP 
function AllSolicitudes($db,$Data,$tipoasig){
    if($tipoasig=="001" || $tipoasig==001){
          //echo '<pre>';print_r($Data);die;
          for($i=0;$i<count($Data['Hijos']);$i++){
            $Materia = '';
            $Grupo   = '';
            $Grupo_ID = '';
            $C_hora  = explode('::',$Data['Hora'][$i]); 
            //echo '<pre>';print_r($Data['Grupo-Unidad']);
            for($m=0;$m<count($Data['Grupo-Unidad']);$m++){
                
                if($m==0 || $m<1){
                    $Materia= $Data['Grupo-Unidad'][$m]['nombremateria'];
                    $Grupo  = $Data['Grupo-Unidad'][$m]['idgrupo'].'::'.$Data['Grupo-Unidad'][$m]['nombregrupo'];
                    $Grupo_ID   = $Data['Grupo-Unidad'][$m]['idgrupo'];
                    $Materia_ID = $Data['Grupo-Unidad'][$m]['codigomateria'];
                }else{
                    $Materia= $Materia.','.$Data['Grupo-Unidad'][$m]['nombremateria'];
                    $Grupo  = $Grupo.','.$Data['Grupo-Unidad'][$m]['idgrupo'].'::'.$Data['Grupo-Unidad'][$m]['nombregrupo'];
                    $Grupo_ID   = $Grupo_ID.','.$Data['Grupo-Unidad'][$m]['idgrupo'];
                    $Materia_ID = $Materia_ID.','.$Data['Grupo-Unidad'][$m]['codigomateria'];
                }
            }
            if($Grupo_ID != ''){
				$Programa = ProgramaCarrera($db,$Grupo_ID);
				$Num      = NumEstudiante($db,$Grupo_ID);
				$Semestre = SemestreMateria($db,$Materia_ID);
				$Dato     = ObservacionAula($db,$Data['Padre_ID'],$Data['Hijos'][$i]);   
				$Resultado = AsignadoSolicitado($db,$Data['Hijos'][$i]);  
				$TipoSalon = TipoAula($db,$Data['Hijos'][$i]);       
				$DocenteView = DocenteView($db,$Materia_ID,$Grupo_ID);
			}
          ?>
            <tr>   
                <td><?PHP echo $Data['Padre_ID']?></td><!--ID SOLICITUD-->   
                <td><?PHP echo $Data['Hijos'][$i]?></td><!--ID SOLICITUD DETALLE-->
                <td><?PHP echo $Programa?></td><!--PROGRAMA--> 
                <td><?PHP echo $Materia?></td><!--MATERIA--> 
                <td><?PHP echo $Grupo?></td>
                <td style="text-align: center;"><?PHP echo $Num?></td><!--N&deg; Matriculados Prematiculados--> 
                <td><?PHP echo $Semestre?></td><!--SEMESTRE--> 
                <td><?PHP echo $Data['Dia'][$i]?></td><!--DIA SEMANA-->                     
                <td style="text-align: center;"><?PHP echo $C_hora[0]?></td><!--HORA INICIO -->
                <td style="text-align: center;"><?PHP echo $C_hora[1]?></td><!--HORA FIN-->
                <td><?PHP echo $Data['FechaInicio']?></td><!--FECHA INICIO-->
                <td><?PHP echo $Data['FechaFinal']?></td><!--FECHA FIN-->
                <td><?PHP echo $Dato['Obs']?></td><!--OBSERVACIONES-->
                <td><?PHP echo $Dato['Aula']?></td><!--AULA O ESAPCIO-->
                <td style="text-align: center;">="<?PHP echo $Resultado['Num_Atendida'].'/'.$Resultado['Total']?>"</td>
                <td><?PHP echo $Data['Instalacion'][$i]?></td>
                <td><?PHP echo $TipoSalon?></td>
                <td><?PHP echo $DocenteView?></td>
                <td>Internas</td>
            </tr>
          <?PHP
          }
    }else{
        
        for($i=0;$i<count($Data['Hijos']);$i++){
            $C_hora  = explode('::',$Data['Hora'][$i]);
            $Dato     = ObservacionAula($db,$Data['Padre_ID'],$Data['Hijos'][$i]);   
            $Resultado = AsignadoSolicitado($db,$Data['Hijos'][$i]);
            $TipoSalon = TipoAula($db,$Data['Hijos'][$i]);
         ?>
         <tr>    
            <td><?PHP echo $Data['Padre_ID']?></td><!--ID SOLICITUD-->    
            <td><?PHP echo $Data['Hijos'][$i]?></td><!--ID SOLICITUD DETALLE-->
            <td><?PHP echo $Data['Grupo-Unidad'][0]['nombrecarrera']?></td><!--NOMBRE Carrera--> 
            <td><?PHP echo $Data['Grupo-Unidad'][0]['NombreEvento']?></td><!--NOMBRE DEL EVENTO-->
            <td><?PHP echo $Data['Grupo-Unidad'][0]['UnidadNombre']?></td><!--UNIDAD RESPONSABLE--> <!--ID GRUPO-->      
            <td><?PHP echo $Data['Grupo-Unidad'][0]['NumAsistentes']?></td><!--NUMERO ASISTENTES-->
            <td>&nbsp;</td><!--SEMESTRE-->
            <td><?PHP echo $Data['Dia'][$i]?></td><!--DIA SEMANA--> 
            <td style="text-align: center;"><?PHP echo $C_hora[0]?></td><!--HORA INICIO-->
            <td style="text-align: center;"><?PHP echo $C_hora[1]?></td><!--HORA FIN-->
            <td><?PHP echo $Data['FechaInicio']?></td><!--FECHA INICIO-->
            <td><?PHP echo $Data['FechaFinal']?></td><!--FECHA FIN-->
            <td><?PHP echo $Dato['Obs']?></td><!--OBSERVACIONES-->
            <td><?PHP echo $Dato['Aula']?></td><!--AULA O ESAPCIO-->
            <td style="text-align: center;">="<?PHP echo $Resultado['Num_Atendida'].'/'.$Resultado['Total']?>"</td>
            <td><?PHP echo $Data['Instalacion'][$i]?></td>
            <td><?PHP echo $TipoSalon?></td>
            <td><?PHP echo $Data['Grupo-Unidad'][0]['Responsable']?></td><!--DOCENTE  --> 
            <td>Externa</td>
        </tr>
         <?PHP   
        }
    }
    
                 
}//function AllSolicitudes
function ProgramaCarrera($db,$Grupo_ID){
      $SQL='SELECT 
            
            c.codigocarrera,
            c.nombrecarrera,
            m.nombremateria,
            m.codigomateria
            
            FROM grupo g INNER JOIN materia m  ON m.codigomateria=g.codigomateria
            			 INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
            ';
			if($Grupo_ID != ''){
				$SQL .= 'WHERE 
            g.idgrupo IN('.$Grupo_ID.')';
			}
            
            $SQL .= '
            GROUP BY c.codigocarrera';
            
        if($Dato=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de la Carrera...<br><br>'.$SQL;
            die;
        }
       $Programa = ''; 
       $i=0;    
       while(!$Dato->EOF){
            if($i==0 || $i<1){
                $Programa= $Dato->fields['nombrecarrera'];
            }else{
                $Programa= $Programa.','.$Dato->fields['nombrecarrera'];    
            }
                       
           $i++;
           $Dato->MoveNext();
        } 
       
       
       return $Programa;
        
}//function ProgramaCarrera(){}//
function NumEstudiante($db,$Grupo_ID){
        $SQL='SELECT
                	COUNT(codigoestadodetalleprematricula) AS Num
                FROM
                	detalleprematricula
                WHERE
                	idgrupo IN('.$Grupo_ID.')
                AND codigoestadodetalleprematricula IN ("10")';
                
                
          if($Prematriculados=&$db->Execute($SQL)===false){
                echo 'Error en el SQL data de prematriculados...<br>'.$SQL;
                die;
            }
            
        $SQL='SELECT
                	COUNT(codigoestadodetalleprematricula) AS Num
                FROM
                	detalleprematricula
                WHERE
                	idgrupo IN('.$Grupo_ID.')
                AND codigoestadodetalleprematricula IN (30)';
                
                
          if($Matriculados=&$db->Execute($SQL)===false){
                echo 'Error en el SQL data de prematriculados...<br>'.$SQL;
                die;
            } 
            
        $Num = $Prematriculados->fields['Num']+$Matriculados->fields['Num']; 
        
        return $Num;  
}//function NumEstudiante
function SemestreMateria($db,$Carrera){
      $SQL='SELECT
            	semestredetalleplanestudio
            FROM
            	detalleplanestudio
            
            WHERE
            
            codigomateria IN ('.$Carrera.')
            
            GROUP BY semestredetalleplanestudio';
            
         if($Semestre=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Semestre...<br><br>'.$SQL;
            die;
         }  
         
       $C_Semestre = ''; 
        $i=0;   
        while(!$Semestre->EOF){
            if($i==0 || $i<1){
                $C_Semestre= $Semestre->fields['semestredetalleplanestudio'];
            }else{
                $C_Semestre= $C_Semestre.','.$Semestre->fields['semestredetalleplanestudio'];    
            }
                       
           $i++;
           $Semestre->MoveNext();
        } 
       
       return $C_Semestre;
}//function SemestreMateria
function ObservacionAula($db,$Padre,$Hijo){
    $SQL='SELECT
                c.Nombre,
                s.observaciones
          FROM
                SolicitudPadre sp INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId=sp.SolicitudPadreId
                                  INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                                  INNER JOIN AsignacionEspacios ag ON ag.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                                  INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=ag.ClasificacionEspaciosId
            
          WHERE
            
                sp.SolicitudPadreId="'.$Padre.'"
                AND
                s.SolicitudAsignacionEspacioId="'.$Hijo.'"
                AND
                sp.CodigoEstado=100
                AND 
                s.codigoestado=100
                AND
                ag.codigoestado=100
                AND
                ag.FechaAsignacion>=CURDATE()
            
          GROUP BY s.SolicitudAsignacionEspacioId';
          
          if($ObsercionAula=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Observaciones.....<br><br>'.$SQL;
            die;
          }
          
          $Dato['Aula'] = $ObsercionAula->fields['Nombre'];
          $Dato['Obs']  = $ObsercionAula->fields['observaciones'];
          
          return $Dato;
}//function ObservacionAula
function AsignadoSolicitado($db,$Hijo){
    $SQL_X='SELECT
            a.ClasificacionEspaciosId
            FROM
            AsignacionEspacios a
            
            WHERE  a.codigoestado=100 and a.SolicitudAsignacionEspacioId="'.$Hijo.'"';
            
            if($Info=&$db->Execute($SQL_X)===false){
                echo 'Error al Calcular Atendidas...<br><br>'.$SQL_X;
                die;
            }
      $O=0;
      $N=0;     
      while(!$Info->EOF){
        /************************************/
        if($Info->fields['ClasificacionEspaciosId']!=212){
            $O= $O+1;
        }else{
            $N=$N+1;
        }
        /************************************/
        $Info->MoveNext();
      }  
      
      $Resultado['Num_Atendida'] = $O;
      $Resultado['Total'] = $N+$O;  
      
      return $Resultado;
}//function AsignadoSolicitado
function TipoAula($db,$Hijo){
      $SQL='SELECT
            	t.nombretiposalon
            FROM
            	SolicitudAsignacionEspaciostiposalon s INNER JOIN tiposalon t ON t.codigotiposalon=s.codigotiposalon
            WHERE
            	s.SolicitudAsignacionEspacioId ="'.$Hijo.'"';
                
       if($Salon=&$db->Execute($SQL)===false){
          echo 'Error en el SQL ....<br><br>'.$SQL;
       }
       
       return $Salon->fields['nombretiposalon'];         
}//function TipoAula
function DocenteView($db,$codigomateria,$idgrupo){
     $SQL='SELECT
            CONCAT(d.nombredocente," ",d.apellidodocente) as NameDocente
            FROM
            grupo g INNER JOIN docente d ON d.numerodocumento=g.numerodocumento
            WHERE
            g.idgrupo IN ('.$idgrupo.')
            AND
            g.codigomateria IN ('.$codigomateria.')';
            
       if($Docente=&$db->Execute($SQL)===false){
         echo 'Error en el Sistema ....<br>';
         die;
       }     
       
       return $Docente->fields['NameDocente'];
}//function DocenteView
?>