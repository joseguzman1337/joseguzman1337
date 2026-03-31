<?php

class VisualizarReporte{
    public function Datos($id,$carrera='',$modalidad='',$Color=''){
        global $db;
        
          $SQL_Publico='SELECT 
                        
                        estudiante,
                        docente,
                        admin,
                        cvs
                        
                        FROM  
                        siq_Apublicoobjetivo  
                        
                        WHERE
                        
                        idsiq_Ainstrumentoconfiguracion="'.$id.'"
                        AND
                        codigoestado=100';
                        
            if($Publico=&$db->Execute($SQL_Publico)===false){
                echo 'Error en el SQL del Publico Objetivo.....<br>'.$SQL_Publico;
                die;
            }      
          
          if(!$Publico->EOF){
            
            $Estudiante = $Publico->fields['estudiante'];
            $Docente    = $Publico->fields['docente'];
            $Admin      = $Publico->fields['admin'];
            $CVS        = $Publico->fields['cvs'];
            
            /*
            *Estudiante queda activo si esta en cero (0) inactivo uno (1)
            *Docente queda activo cuando es uno (1) inactivo cero (0)
            *admin  activo cero(0) inactivo (1)
            *cvs  activo cero (0) inactivo (1)
            */
            
            $SQL_Preguntas='SELECT 
                            
                            r.idsiq_Apregunta,
                            p.idsiq_Atipopregunta
                            
                            FROM 
                            
                            siq_Ainstrumento r INNER JOIN siq_Apregunta p ON p.idsiq_Apregunta=r.idsiq_Apregunta
							
                            WHERE
                            
                            r.idsiq_Ainstrumentoconfiguracion="'.$id.'"
                            AND
                            r.codigoestado=100
                            
                            GROUP BY r.idsiq_Apregunta';
                            
                      if($Preguntas=&$db->Execute($SQL_Preguntas)===false){
                        echo 'Error en el SQL de Las Preguntas...<br>'.$SQL_Preguntas;
                        die;
                      }      
            
            /*
            *1-->Escalas tipo Likert
            *2-->Escalas tipo Guttman
            *3-->Dicotomicas
            *4-->Opcion Respuesta Multiple
            *5-->Preguntas abiertas
            *6-->Opción múltiple con única respuesta correcta
            *7-->Aparejamiento o apareamiento
            *8-->Preguntas afirmación – razón
            */
            
            /********************Inicia el Ciclo de Las Preguntas *******************************/
            while(!$Preguntas->EOF){
                /*****************************************/
                $D_Pregunta = $Preguntas->fields['idsiq_Apregunta'];
                if($Preguntas->fields['idsiq_Atipopregunta']!=5){
                    
                   $Datos = $this->Consulta($id,$carrera,$modalidad,$Estudiante,$Docente,$D_Pregunta);    
                   $Data  = $this->Consulta($id,$carrera,$modalidad,$Estudiante,$Docente,$D_Pregunta,'Formulario');
                   $this->Tabla($Data);
                   $this->Grafica($Datos,$Color); 
                }else{
                    $this->PintarPreguntasAbiertas($id,$carrera,$modalidad,$Estudiante,$Docente,$D_Pregunta);
                }
                /*****************************************/
                $Preguntas->MoveNext();
            }//while
            /************************************************************************************/
            
          }else{
            echo 'No Hay Informacion .....';die;
          }  
                  
    }//public function Datos
    public function Consulta($id,$carrera,$modalidad,$Estudiante,$Docente,$Pregunta,$op=''){
        global $db;
        
        if($Estudiante==0){//Estudiante
                if($carrera!=-1 || $carrera!='-1'){
                    $Where = ' c.codigocarrera="'.$carrera.'"';
                }else if(($carrera==-1 || $carrera=='-1') && ($modalidad!=-1 || $modalidad!='-1')){
                    $Where = ' c.codigomodalidadacademica="'.$modalidad.'"';
                }
                
                 $SQL_Data='SELECT

                            x.idsiq_Apreguntarespuesta,
                            COUNT(x.respuesta) AS num,
                            x.respuesta
                            
                            FROM(SELECT 
                            
                            r.idsiq_Apreguntarespuesta,
                            rr.respuesta,
                            rr.valor,
                            rr.unica_respuesta,
                            rr.multiple_respuesta,
                            r.idsiq_Ainstrumentoconfiguracion,
                            r.usuariocreacion,
                            r.cedula,
                            c.nombrecarrera
                            
                            FROM siq_Arespuestainstrumento r  INNER JOIN siq_Apreguntarespuesta rr ON rr.idsiq_Apreguntarespuesta=r.idsiq_Apreguntarespuesta
                                                              INNER JOIN usuario u ON u.idusuario=r.usuariocreacion
                                                              INNER JOIN  estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento
                                                              INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
                                                              INNER JOIN carrera c  ON c.codigocarrera=e.codigocarrera
                            																											
                            
                            WHERE 
                            r.idsiq_Ainstrumentoconfiguracion ="'.$id.'" 
                            AND 
                            r.idsiq_Apregunta ="'.$Pregunta.'" 
                            AND
                            r.codigoestado=100
                            AND
                            rr.codigoestado=100
                            AND
                            '.$Where.'
                            
                            ORDER BY rr.respuesta  ASC) x 
                            
                            GROUP BY x.respuesta';
             /**************Estudiante********************/   
            }else if($Docente=='1' || $Docente==1){//Docentes
                if($carrera!=-1 || $carrera!='-1'){
                    $From  = '';
                    $Where = ' e.codigocarrera="'.$carrera.'"';
                }else if(($carrera==-1 || $carrera=='-1') && ($modalidad!=-1 || $modalidad!='-1')){
                    $From  = ' INNER JOIN carrera ca ON ca.codigocarrera=e.codigocarrera'; 
                    $Where = ' ca.codigomodalidadacademica="'.$modalidad.'"';
                }
                   $SQL_Data = 'SELECT

                                x.idsiq_Apreguntarespuesta,
                                COUNT(x.respuesta) AS num,
                                x.respuesta
                                
                                FROM(
                                
                                SELECT
                                
                                rr.idsiq_Apreguntarespuesta,
                                ra.respuesta,
                                ra.valor,
                                ra.unica_respuesta,
                                ra.multiple_respuesta,
                                rr.idsiq_Ainstrumentoconfiguracion,
                                rr.usuariocreacion
                                
                                
                                FROM
                                
                                siq_Arespuestainstrumento rr  INNER JOIN siq_Apreguntarespuesta ra ON ra.idsiq_Apreguntarespuesta=rr.idsiq_Apreguntarespuesta
                                
                                WHERE
                                
                                rr.idsiq_Ainstrumentoconfiguracion="'.$id.'"
                                AND
                                rr.idsiq_Apregunta="'.$Pregunta.'"
                                AND
                                rr.codigoestado=100
                                AND
                                rr.usuariocreacion IN (
                                
                                SELECT 
                                
                                r.usuariocreacion
                                
                                FROM 
                                
                                siq_AequivalenciaCarrera e INNER JOIN siq_Arespuestainstrumento r ON r.idsiq_Arespuestainstrumento=e.idRespuestaInstrumento
                                                           '.$From.'
                                WHERE
                                
                                '.$Where.' ) ) x
                                
                                GROUP BY x.idsiq_Apreguntarespuesta';
                                
             /*************Docente****************/                   
            }
            
           
          if($Resultado=&$db->Execute($SQL_Data)===false){
                Echo 'Error en SQL de Datos PAra Pintar.......<br>'.$SQL_Data;
                die;
          }    
          
          $C_Result = $Resultado->GetArray();
          
          $Suma = 0;
          for($i=0;$i<count($C_Result);$i++){
            
               $Suma = $Suma+$C_Result[$i]['num'];
               
          }//for
          
          for($i=0;$i<count($C_Result);$i++){
            
                $Porcentaje = (($C_Result[$i]['num']*100)/$Suma);
                
                $C_Result[$i]['Porcentaje']  = number_format($Porcentaje,'2','.','.');
                $C_Result[$i][3]             = number_format($Porcentaje,'2','.','.');
                $Name = $this->DataPreguntas($Pregunta);
                $C_Result[$i]['Pregunta']  = $Name; 
                $C_Result[$i][4]           = $Name;
            
          }//for
          
          //echo '<pre>';print_r($C_Result);die;
          
          for($j=0;$j<count($C_Result);$j++){
            
            if($j>0){
                $P = $P.','.$C_Result[$j]['Porcentaje'];
                $L = $L.'|'.$C_Result[$j]['respuesta'];
            }else{
                $P = $C_Result[$j]['Porcentaje'];
                $L = $C_Result[$j]['respuesta'];
            }
            
          }//for
          
          $Data['Porcentaje'] = $P;
          $Data['Label']      = $L;
          
          //echo '<pre>';print_r($Data);die;
          if($op=='Formulario'){
            return $C_Result;
          }else{
            return $Data;  
          }
          
    }//public function Consulta
   
    public function Grafica($Data,$Color=''){
        
        $t = $Data['Porcentaje'];
        $x = $Data['Label']
        
        ?>
        <div align="center" style="width: 100%;">
        <img src="http://chart.apis.google.com/chart?chs=650x150&chd=t:<?PHP echo $t?>&cht=p3&chl=<?PHP echo $x?>&chco=<?PHP echo $Color?>&chdlp=r" alt="Primer ejemplo con Google Chart API" style="text-align: center;" />
        </div>   
        <?PHP
    }
    public function Tabla($Data){
        ?>
        <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
            <tr>
                <td colspan="3"><strong><?PHP echo $Data[0]['Pregunta']?></strong></td>
            </tr>
        <?PHP
        $Suma = 0;
        for($i=0;$i<count($Data);$i++){
            
            $Respuesta  = $Data[$i]['respuesta'];
            $Num        = $Data[$i]['num'];
            $Porcentaje = $Data[$i]['Porcentaje'];
            $Suma = $Suma+$Data[$i]['num'];
         ?>
                <tr>
                    <td><?PHP echo $Respuesta?></td>
                    <td><?PHP echo $Num?></td>
                    <td><?PHP echo $Porcentaje?></td>
                </tr>
              
        <?PHP
        }//for
       ?>
         <tr>
            <td><strong>Total</strong></td>
            <td><?PHP echo $Suma?></td>
            <td>&nbsp;</td>
         </tr>   
       </table>      
       <?PHP
    }// public function Tabla
     public function DataPreguntas($id){
        global $db;
        
        $SQL='SELECT titulo FROM siq_Apregunta WHERE idsiq_Apregunta ="'.$id.'"  AND codigoestado=100';
        
        if($Pregunta=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Data Pregunta...<br><br>'.$SQL;
            die;
        }
        
        return $Pregunta->fields['titulo'];
    }//public function DataPreguntas
    public function PreguntaAbierta($id,$carrera,$modalidad,$Estudiante,$Docente,$Pregunta){
        global $db;
        
        if($Estudiante==0){
            
             if($carrera!=-1 || $carrera!='-1'){
                    $Where = ' c.codigocarrera="'.$carrera.'"';
                }else if(($carrera==-1 || $carrera=='-1') && ($modalidad!=-1 || $modalidad!='-1')){
                    $Where = ' c.codigomodalidadacademica="'.$modalidad.'"';
                }
            
              $SQL='SELECT 

                    r.preg_abierta
                    
                    FROM 
                    
                    siq_Arespuestainstrumento r INNER JOIN usuario u ON u.idusuario=r.usuariocreacion
                                                INNER JOIN estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento
                                                INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
                                                INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                    
                    WHERE
                    
                    r.codigoestado=100
                    AND
                    r.idsiq_Ainstrumentoconfiguracion="'.$id.'"
                    AND
                    r.idsiq_Apregunta="'.$Pregunta.'"
                    AND
                    '.$Where;

        }else if($Docente==1){
        
         if($carrera!=-1 || $carrera!='-1'){
                    $From  = '';
                    $Where = ' e.codigocarrera="'.$carrera.'"';
                }else if(($carrera==-1 || $carrera=='-1') && ($modalidad!=-1 || $modalidad!='-1')){
                    $From  = ' INNER JOIN carrera ca ON ca.codigocarrera=e.codigocarrera'; 
                    $Where = ' ca.codigomodalidadacademica="'.$modalidad.'"';
                }
        
          $SQL='SELECT

                preg_abierta
                
                FROM   siq_Arespuestainstrumento
                
                WHERE 
                
                idsiq_Ainstrumentoconfiguracion="'.$id.'"
                AND 
                codigoestado=100
                AND
                idsiq_Apregunta="'.$Pregunta.'"
                AND
                usuariocreacion IN(SELECT r.usuariocreacion 
                                   FROM siq_AequivalenciaCarrera e INNER JOIN siq_Arespuestainstrumento r ON r.idsiq_Arespuestainstrumento=e.idRespuestaInstrumento
                                                                   '.$From.' 
                                   WHERE  '.$Where.')';
                                   
            }   
           
            if($PreguntaAbierta=&$db->execute($SQL)===false){
                echo 'Error en el SQL de LAs Preguntas Abiertas....';
                die;
               }    
               
               $C_Abierta = $PreguntaAbierta->GetArray();
          
          return $C_Abierta;     
                                
    }//public function PreguntaAbierta
    public function PintarPreguntasAbiertas($id,$carrera,$modalidad,$Estudiante,$Docente,$D_Pregunta){
        $Datos_Abierta = $this->PreguntaAbierta($id,$carrera,$modalidad,$Estudiante,$Docente,$D_Pregunta);
        ?>
        <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
            <tr>
                <td colspan="3"><?PHP echo $this->DataPreguntas($D_Pregunta);?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div id="DivReporte" align="center" style="overflow:scroll;width:100%; height:200; overflow-x:hidden; text-align: left;" >
                    <ul>
                    <?PHP 
                    for($i=0;$i<count($Datos_Abierta);$i++){
                        ?>
                        <li><?PHP echo $Datos_Abierta[$i]['preg_abierta']?></li>
                        <?PHP
                    }//for
                    ?>
                    </ul>
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
       <?PHP
    }//public function PintarPreguntasAbiertas
    public function ViewReport($id,$carrera='',$modalidad='',$Color=''){
        ?>
        <table border="1" cellpadding="1" cellspacing="0" align="center" bordercolor="#E9E9E9" width="100%">
            <tr>
                <td>
                    <?PHP $this->Datos($id,$carrera,$modalidad,$Color);?>
                </td>
            </tr>
        </table>
        <?PHP
    }//public function ViewReport
    public function Consola($id){
        ?>
        
            <form id="NewReport">
                <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="50%" align="center">
                    <thead>
                        <tr>
                            <th colspan="2" style="color: #FF9E08;">
                                <strong>Reporte Por Filtro Acad&eacute;mico</strong><input type="hidden" id="actionID" name="actionID" value="Reporte" />
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <hr colspan="2" style="color:#FF9E08; width: 95%;" /><input type="hidden" id="id" name="id" value="<?PHP echo $id?>" />
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" style="color: #FF9E08;">
                                <strong>REPORTE</strong>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" style="color: #FF9E08;">Filtrar por:</td>
                        </tr>
                        <tr>
                            <td><strong>Modalidad Acad&eacute;mica</strong></td>
                            <td><?PHP $this->Select();?></td>
                        </tr>
                        <tr>
                            <td><strong>Carrera</strong></td>
                            <td id="Td_Carrera"><select><option></option></select></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <input type="button" id="Reporte" name="Reporte" onclick="GenerarReporte();" value="Generar Reporte" />
                            </td>
                        </tr>
                        <tr>
                            <td>Color</td>
                            <td>
                                <table border="0">
                                    <tr>
                                        <td bgcolor="9DA242">
                                            <input type="radio" id="Color" value="9DA242" name="color">
                                        </td>
                                        <td bgcolor="FF9E08">
                                            <input type="radio" id="Color" value="FF740000" name="color">
                                        </td>
                                        <td bgcolor="4D89D9">
                                            <input type="radio" id="Color" value="4D89D9" name="color">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <br />
                <table width="50%" align="center" border="0">
                    <tr  style="background-color: white;">
                        <td colspan="2">
                            <div id="Div_Carga"></div>
                        </td>
                    </tr>
                </table>
             </form>   
            
        <?PHP
    }//public function Consola
    public function Select(){
        global $db;
        
          $SQL='SELECT 

                codigomodalidadacademica AS id,
                nombremodalidadacademica AS Nombre
                
                FROM 
                
                modalidadacademica
                
                WHERE
                
                codigoestado=100';
                
         if($Consulta=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de LAs Modalidad Acdemica...<br><br>'.$SQL;
            die;
         }      
         ?>
         <select id="Modalidad" name="Modalidad" style="width:90%;" onchange="BuscarData();">
         <option value="-1"></option>
         <?PHP
         while(!$Consulta->EOF){
            ?>
            <option value="<?PHP echo $Consulta->fields['id']?>"><?PHP echo $Consulta->fields['Nombre']?></option>
            <?PHP
            $Consulta->MoveNext();
         }//while
         ?>
         </select>
         <?PHP 
    }//public function Select
    public function Carrera($id){
        global $db;
        
          $SQL='SELECT 

                codigocarrera,
                nombrecarrera
                
                FROM carrera
                
                WHERE
                
                codigomodalidadacademica="'.$id.'"
                AND
                codigocarrera NOT IN (1,2)
                                
                ORDER BY nombrecarrera ASC';
                
          if($Carrera=&$db->Execute($SQL)===false){
            echo 'Error en el SQL Carrera.....<br><br>'.$SQL;
            die;
          }      
          ?>
          <select id="Carrera" name="Carrera" style="width: 90%;">
            <option value="-1"></option>
            <?PHP 
            while(!$Carrera->EOF){
                ?>
                <option value="<?PHP echo $Carrera->fields['codigocarrera']?>"><?PHP echo $Carrera->fields['nombrecarrera']?></option>
                <?PHP
                $Carrera->MoveNext();
            }//while
            ?>
          </select>
          <?PHP
    }//public function Carrera
}//class

?>
        