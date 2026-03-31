<?php 
class Reporte_Bienestar{
    
    public function Display($Op,$Excel=''){
        
        global $userid,$db;
        //$D_Datos = $this->Consulta();die;
     if(!$Excel){   
        ?>
    <style type="text/css" title="currentStyle">
                @import "../../../observatorio/data/media/css/demo_page.css";
                @import "../../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../../observatorio/data/media/css/ColVis.css";
                @import "../../../observatorio/data/media/css/TableTools.css";
                @import "../../../observatorio/data/media/css/ColReorder.css";
                @import "../../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../../../observatorio/data/media/css/jquery.modal.css";
                
    </style>
    <!--<script type="text/javascript" language="javascript" src="../../../observatorio/data/media/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/jquery/js/jquery-3.6.0.js"></script>-->
    <script type="text/javascript" language="javascript" src="../../../observatorio/data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/ZeroClipboard.js"></script>
    <!--<script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/TableTools.js"></script>-->
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/FixedColumns.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/ColReorder.js"></script>
    <script type="text/javascript" language="javascript">
      
        
      
        
     $(document).ready( function () {//"sDom": '<Cfrltip>',
				var oTable = $('#example_1').dataTable( {
				    
  					"sScrollX": "100%",
					"sScrollXInner": "100,1%",
					"bScrollCollapse": true,
                    "bPaginate": true,
                    "aLengthMenu": [[50], [50,  "All"]],
                     "iDisplayLength": 50,
                    "sPaginationType": "full_numbers",
					"oColReorder": {
						"iFixedColumns": 1
					},
                    "oColVis": {
                            "buttonText": "Ver/Ocultar Columns",
                             "aiExclude": [ 0 ]
                      }
                    
                    
					
				} );
				//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 3,
                                         "iLeftWidth": 600
				} );
                                
                                	/* var oTableTools = new TableTools( oTable, {
				"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
					]
		         });*/
                        // $('#demo').before( oTableTools.dom.container );
			} ); 
    </script>
    <?PHP
    }
    ?>
    <!--<div align="center" style="width: 90%; margin-left: 5%; margin-right: 5%; margin-top: 5%;">-->
     <div id="demo" align="center" style="width: 90%; margin-left: 5%; margin-right: 5%; margin-top: 5%;">
        <?PHP 
        if(!$Excel){
            ?>
            <img src="../../images/Office-Excel-icon.png" title="Exportar a Exel" id="Imoportar" width="40" style="cursor:pointer;" align="left" onclick="ExportarExel()" />
            <?PHP
        }
        ?>
        
         <?PHP $this->Tabla($Op)?>
         <br /><br />
        <?PHP 
        if(!$Excel){
            ?>
            <img src="../../images/Office-Excel-icon.png" title="Exportar a Exel" id="Imoportar" width="40" style="cursor:pointer;" align="left" onclick="ExportarExel()" />
            <?PHP
        }
        ?> 
    </div>
  <!--</div>-->  
        <?PHP
    }/*public function Display*/
  
   public function Detalle($Estudiante_id,$Op,$Tipo='',$Dato='',$T='',$G='',$C='',$F=''){
    
    global $db,$userid;
    
    if($Op==1){/*Seleccion o Grupos*/
        
          $SQL='SELECT 

                b.idestudiantegenral,
                b.idbienestar,
                b.participaseleccionesuniversidad,
                b.tiposeleccion,
                b.periodoinicialseleccion AS S_ini,
                b.periodofinalseleccion AS S_fin
               
                FROM bienestar b 
                								 
                WHERE
                
                b.idestudiantegenral="'.$Estudiante_id.'"
                AND
                b.codigoestado=100
                AND
                (b.participaseleccionesuniversidad=0  AND   b.periodofinalseleccion="-1"  OR b.talleresformativos=0)';
        
        
    }else if($Op==2){/*Talleres*/
    
    //Tipo taller 1= taller Deportivo 2= Taller Cultural
        
          $SQL='SELECT 
                
                b.idestudiantegenral,
                b.idbienestar,
                b.talleresculturales,
                b.talleresformativos,
                b.codigoperiodo
                
                FROM bienestar b 
                								 
                WHERE
                
                b.idestudiantegenral="'.$Estudiante_id.'"
                AND
                b.codigoestado=100
                AND
                b.talleresculturales=0';
        
    }else if($Op==3){/*Salud*/
        
          $SQL='SELECT 
                
                b.idestudiantegenral,
                b.idbienestar,
                b.medicinadeporte,
                b.medicinageneral,
                b.asesoriapsicologica,
                b.asesoriapsicologicaSalud
                
                FROM bienestar b 
                								 
                WHERE
                
                b.idestudiantegenral="'.$Estudiante_id.'"
                AND
                b.codigoestado=100
                AND
                (
                b.medicinadeporte>=1
                OR
                b.medicinageneral>=1
                OR
                b.asesoriapsicologica>=1
                OR
                b.asesoriapsicologicaSalud>=1
                )';
        
    }else if($Op==4){/*Grupo*/
        
          $SQL='SELECT 

                b.idestudiantegenral,
                b.idbienestar,
                b.pertenecegrupapoyo,
                b.pertenecevoluntariado,
                b.monitorbienestar,
                b.periodoInicialApoyoBienestar AS peridodinicialapoyo,
                b.periodoFinalApoyoBienestar AS periodofinalapoyo,
                b.fechaInicialVoluntareado,
                b.fechaFinalVoluntareado,
                b.periodoInicialMonitor,
                b.periodoFinalMonitor,
                b.tipoMonitorBienestar
                
                FROM bienestar b 
                								 
                WHERE
                
                b.idestudiantegenral="'.$Estudiante_id.'"
                AND
                b.codigoestado=100
                AND
                (b.pertenecegrupapoyo=0 OR b.pertenecevoluntariado=0 OR b.monitorbienestar=0)
                ';
                
        
    }
    
    if($Respuesta=&$db->Execute($SQL)===false){
        echo 'Error en el SQL ...<br>'.$SQL;
        die;
    }
    
    if($Tipo){
        if(!$Respuesta->EOF){
            return 1;
        }else{
            return 0; 
        }
    }else{
        
        $R_Result = $Respuesta->GetArray();
        
        //$this->DataEstudiante($R_Result[0]['idestudiantegenral']);
      
        if($Op==1){
            
            
            if($Dato=='Numero'){ 
                return count($$R_Result);
            }else if($G){
                $this->Selecciones($R_Result);
            }if($T){
                $this->Talleres($R_Result);
            }else if($F){
                 
                $C_Data = $this->Talleres($R_Result,$F);
                
                if($C_Data){
                    return $C_Data;
                }
            }
            
        }else if($Op==2){
            if($T){
                $this->Talleres($R_Result);
            }else if($C){
                $this->Cultura($R_Result);
            }else if($G){
                  $SQL='SELECT

                        b.idestudiantegenral,
                        b.idbienestar,
                        b.grupoculturales,
                        b.tiposgruposculturales,
                        b.periodo_ini_Grup,
                        b.periodo_fin_Grup,
                        b.codigoperiodo
                        
                        FROM bienestar b 
                        
                        WHERE
                        
                        b.idestudiantegenral="'.$Estudiante_id.'"
                        AND
                        b.codigoestado=100
                        AND
                        b.periodo_fin_Grup="-1"
                        AND
                        b.grupoculturales=0';
                    
                    if($Respuesta=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL de Grupos...<br>'.$SQL;
                        die;
                    }
                        
                        
                 $R_Result = $Respuesta->GetArray();       
                
                //echo '<pre>';print_r($R_Result);        
                if($Dato=='Numero'){
                    if($R_Result){return count($R_Result);}
                    
                }else{
                    $this->Grupos($R_Result);    
                }       
                
            }else if($F){ 
                 
                 $C_Data = $this->Cultura($R_Result,$F);
                 
                 return $C_Data;
            }
            
            
        }else if($Op==3){
            
            return $C_Result = $this->Salud($R_Result);
            
        }else if($Op==4){
            
           return $C_Result = $this->Voluntariado($R_Result);
            
        }
        
    }
   
   }/*public function Detalle*/
   public function Selecciones($R_Result){
    
    global $db,$userid;
    
        //echo '<pre>';print_r($R_Result);
        
         
      ?>
        <table border="0" style="width: 100%;">
            <tbody>
            <?PHP 
            for($i=0;$i<count($R_Result);$i++){
            
                if($R_Result[$i]['tiposeleccion']==0){
                    $Seleccion  = '';
                }else{
                    
                      $SQL='SELECT 
                      
                            nombredeporte
                            
                            FROM 
                            
                            deportesbienestar 
                            
                            WHERE  
                            
                            id_deportesbienestar="'.$R_Result[$i]['tiposeleccion'].'" 
                            AND 
                            seleccion=1';
                       
                       if($Dato=&$db->Execute($SQL)===false){
                            echo 'Error en el SQL ...<br><br>'.$SQL;
                            die;
                       }     
                    
                    $Seleccion = $Dato->fields['nombredeporte'];
                }
                
                ?>
                <tr>
                    <td><?PHP echo $Seleccion?></td>
                </tr>
                <?PHP
            }/*for*/
            ?>    
            </tbody>
        </table>
        
        <?PHP
          
   }/*public function Selecciones*/
   public function DataEstudiante($Estudiante_id){
    
        global $db,$userid;
        
          $SQl='SELECT 

                es.idestudiantegeneral,
                CONCAT(es.nombresestudiantegeneral," ",es.apellidosestudiantegeneral) AS NombreCompleto,
                es.numerodocumento,
                e.codigoestudiante,
                c.nombrecarrera
                
                FROM estudiantegeneral es INNER JOIN estudiante e ON e.idestudiantegeneral=es.idestudiantegeneral
                												  INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                
                WHERE
                
                c.codigomodalidadacademicasic IN (200,300)
                AND
                es.idestudiantegeneral="'.$Estudiante_id.'"';
                
           if($DataEstudiante=&$db->Execute($SQl)===false){
                echo 'Error en el SQl de la Data de los Estudiantes...<br><br>'.$SQl;
                die;
           }     
           
         ?>  
         <table border=1 style="width: 50%;" align="center">
            <tr>
                <th>Nombre Estudiante</th>
                <th></th>
                <th>N&deg; Documento</th>
            </tr>
            <tr>
                <td style="text-align: center;"><?PHP echo $DataEstudiante->fields['NombreCompleto']?></td>
                <td></td>
                <td style="text-align: center;"><?PHP echo $DataEstudiante->fields['numerodocumento']?></td>
            </tr>
            <tr>
                <th>Programa Acad&eacute;mico</th>
                <th></th>
                <th>Codigo Estudiante</th>
            </tr>
            <tr>
                <td style="text-align: center;"><?PHP echo $DataEstudiante->fields['nombrecarrera']?></td>
                <td></td>
                <td style="text-align: center;"><?PHP echo $DataEstudiante->fields['codigoestudiante']?></td>
            </tr>
         </table>
         <br />
         <?PHP
   }/*public function DataEstudiante*/
   public function Talleres($R_Result,$Fechas=''){
    
     global $db,$userid;
     
     //echo '<pre>';print_r($R_Result);
     
    
    ?>
        <table border="0" style="width: 100%;">
            <tbody>
            <?PHP 
            for($i=0;$i<count($R_Result);$i++){
            
                if($R_Result[$i]['talleresformativos']==1){
                    $TallerDeportivo  = '';
                    ?>
                    <tr>
                        <td><?PHP echo $TallerDeportivo?></td>
                    </tr>
                    <?PHP
                }else{
                      $SQL='SELECT 

                            d.nombredeporte,
                            t.periodo_inicial,
                            t.periodo_fin,
                            t.id_talleresBienestarEstudiante as id,
                            t.id_bienestar
                                                        
                            FROM talleresBienestarEstudiante t INNER JOIN deportesbienestar d ON d.id_deportesbienestar=t.id_taller AND t.id_bienestar="'.$R_Result[$i]['idbienestar'].'" AND t.tipoTaller=1 AND t.codigoestado=100';
                       
                       if($Dato=&$db->Execute($SQL)===false){
                            echo 'Error en el SQL ...<br><br>'.$SQL;
                            die;
                       }    
                   
                   if($Fechas){ 
                        $C_Dato = $Dato->GetArray();
                        return $C_Dato;
                        exit();
                   }
                       
                   while(!$Dato->EOF){
                    $TallerDeportivo = $Dato->fields['nombredeporte'];
                    ?>
                    <tr>
                        <td><?PHP echo $TallerDeportivo?></td>
                    </tr>
                    <?PHP
                    $Dato->MoveNext();
                   } /*while*/    
                    
                }
           
            }/*for*/
            ?>    
            </tbody>
        </table>
        <br />
       <?PHP
    
   }/*public function Talleres*/
   public function Cultura($R_Result,$Fechas=''){
    global $db;
    ?>
        <table border="0" style="width: 100%;">
           <tbody>
            <?PHP 
              for($i=0;$i<count($R_Result);$i++){
            
               if($R_Result[$i]['talleresculturales']==1){
                    $TallerCultura  = '';
                    ?>
                    <tr>
                        <td><?PHP echo $TallerCultura?></td>
                    </tr>
                <?PHP
                    
                }else{
                    
                      $SQL='SELECT 

                            c.nombre,
                            t.periodo_inicial,
                            t.periodo_fin,
                            t.id_talleresBienestarEstudiante as id,
                            t.id_bienestar
                            
                            FROM talleresBienestarEstudiante t INNER JOIN culturabienestar c ON c.id_culturabienestar=t.id_taller AND t.tipoTaller=2 AND t.id_bienestar="'.$R_Result[$i]['idbienestar'].'" AND t.codigoestado=100';
                            
                        if($Data=&$db->Execute($SQL)===false){
                            echo 'Error en el SQl <br><br>'.$SQL;
                            die;
                        }    
                    
                    if($Fechas){ 
                        $C_Dato = $Data->GetArray();
                        //echo '<pre>';print_r($C_Dato);die;
                        return $C_Dato;
                        exit();
                     }
                    
                  while(!$Data->EOF){
                    
                    $TallerCultura  = $Data->fields['nombre'];
                    
                    ?>
                    <tr>
                        <td><?PHP echo $TallerCultura?></td>
                    </tr>
                    <?PHP
                    
                    $Data->MoveNext();
                  }/*while*/  
                    
                }
                
            }/*for*/
            ?>
            </tbody>
        </table>
    <?PHP
   }// public function Cultura
   public function Grupos($R_Result){
    global $db;
     ?>
        <table border="0" style="width: 100%;">
           <tbody>
            <?PHP 
              for($i=0;$i<count($R_Result);$i++){
            
               if($R_Result[$i]['grupoculturales']==1){
                    $TallerCultura  = '';
                    ?>
                    <tr>
                        <td><?PHP echo $TallerCultura?></td>
                    </tr>
                <?PHP
                    
                }else{
                    
                      $SQL='SELECT 

                            id_culturabienestar as id,
                            nombre  as Nombre,
                            nombrecorto
                            
                            FROM 
                            
                            culturabienestar 
                            
                            WHERE
                            
                            grupo=1
                            AND
                            codigoestado=100
                            AND
                            cancel=0
                            AND
                            id_culturabienestar="'.$R_Result[$i]['tiposgruposculturales'].'"';
                          
                        if($Data=&$db->Execute($SQL)===false){
                            echo 'Error en el SQl <br><br>'.$SQL;
                            die;
                        }    
                    
                  while(!$Data->EOF){
                    
                    $TallerCultura  = $Data->fields['Nombre'];
                    
                    ?>
                    <tr>
                        <td><?PHP echo $TallerCultura?></td>
                    </tr>
                    <?PHP
                    
                    $Data->MoveNext();
                  }/*while*/  
                    
                }
                
            }/*for*/
            ?>
            </tbody>
        </table>
    <?PHP
   }//public function Grupos
   public function Salud($R_Result){
    
    global $db,$userid;
    
        
          $SQL='SELECT 

                b.idestudiantegenral,
                b.idbienestar,
                b.medicinadeporte,
                b.medicinageneral,
                b.asesoriapsicologica,
                b.asesoriapsicologicaSalud,
                b.codigoperiodo
                
                FROM bienestar b 
                								 
                WHERE
                
                b.idestudiantegenral="'.$R_Result[0]['idestudiantegenral'].'"
                AND
                b.codigoestado=100';
                
                if($D_Salud=&$db->Execute($SQL)===false){
                    echo 'Error en el SQl <br><br>'.$SQL;
                    die;
                }
                
                $C_Result     = $D_Salud->GetArray();
                $C_Salud      = array();
                for($i=0;$i<count($C_Result);$i++){
                    if(!$C_Result[$i]['medicinageneral']){ 
                        $Medico = 0;
                        }else{ 
                            $Medico = $C_Result[$i]['medicinageneral'];
                            } 
                    if(!$C_Result[$i]['medicinadeporte']){ 
                        $Deporte = 0;
                        }else{ 
                            $Deporte = $C_Result[$i]['medicinadeporte'];
                            }        
                    if(!$C_Result[$i]['asesoriapsicologicaSalud']){ 
                        $Psicologia = 0;
                        }else{ 
                            $Psicologia = $C_Result[$i]['asesoriapsicologicaSalud'];
                            }        
                    $C_Salud[$R_Result[0]['idestudiantegenral']]['Medicina'][]    = $Medico;
                    $C_Salud[$R_Result[0]['idestudiantegenral']]['Deporte'][]     = $Deporte;
                    $C_Salud[$R_Result[0]['idestudiantegenral']]['Psicologia'][]  = $Psicologia;
                    $C_Salud[$R_Result[0]['idestudiantegenral']]['Periodo'][]     = $C_Result[$i]['codigoperiodo'];
                }
                
       return $C_Salud; 
  }/*public function Salud*/
  public function Voluntariado($R_Result){
    
    global $db,$userid;
    //echo '<pre>';print_r($R_Result);
        $C_Result = array();
        for($i=0;$i<count($R_Result);$i++){
            $C_Result[$R_Result[$i]['idestudiantegenral']]['idbienestar']              = $R_Result[$i]['idbienestar'];
            if($R_Result[$i]['pertenecevoluntariado']==0){
                $C_Result[$R_Result[$i]['idestudiantegenral']]['Voluntariado']             = 'Si';
                $C_Result[$R_Result[$i]['idestudiantegenral']]['fechaInicialVoluntareado'] = $R_Result[$i]['fechaInicialVoluntareado'];
                $C_Result[$R_Result[$i]['idestudiantegenral']]['fechaFinalVoluntareado']   = $R_Result[$i]['fechaFinalVoluntareado'];
            }
            if($R_Result[$i]['pertenecegrupapoyo']==0){
                $C_Result[$R_Result[$i]['idestudiantegenral']]['pertenecegrupapoyo']       = 'Si';
                $C_Result[$R_Result[$i]['idestudiantegenral']]['peridodinicialapoyo']      = $R_Result[$i]['peridodinicialapoyo'];
                $C_Result[$R_Result[$i]['idestudiantegenral']]['periodofinalapoyo']        = $R_Result[$i]['periodofinalapoyo'];
            }
            if($R_Result[$i]['monitorbienestar']==0){
                $C_Result[$R_Result[$i]['idestudiantegenral']]['monitorbienestar']         = 'Si';
                $C_Result[$R_Result[$i]['idestudiantegenral']]['periodoInicialMonitor']    = $R_Result[$i]['periodoInicialMonitor'];
                $C_Result[$R_Result[$i]['idestudiantegenral']]['periodoFinalMonitor']      = $R_Result[$i]['periodoFinalMonitor'];
            }
        }/*for*/
     
    // echo '<pre>';print_r($C_Result);
    
    return $C_Result; 
  }/*public function Grupos*/
  public function CargarDisplay($Op){
    global $db,$userid;
    
    ?>
    <div id="Carga" style="text-align: center; width: 90%;">
   
    <img src="../../images/engranaje-09.gif" width="50%" /></div>
    <script>
   
        $('#Carga').delay(3500);
   
     IrDisplay(<?PHP echo $Op ?>);   
     
     //$(formName + " #msg-success").delay(5500).fadeOut(800);
    </script>
    <?PHP
    
    
  }/*public function CargarDisplay*/
  public function Consulta($op){
    global $db;
    
    if($op==1){
            $SELECT = ' ,b.periodoinicialseleccion AS S_ini, b.idbienestar, b.periodofinalseleccion AS S_fin, b.talleresformativos, b.participaseleccionesuniversidad';//
            $FROM   = ' ';
            $WHERE  = ' AND  ((b.periodofinalseleccion="-1" AND participaseleccionesuniversidad=0) OR  (b.talleresformativos="0"))';//OR  b.talleresformativos="0"
            $GROUP  = 'b.idbienestar';
    }else if($op==2){
            $SELECT = '  ,b.idbienestar, b.talleresculturales , b.grupoculturales, b.periodo_ini_Grup, b.periodo_fin_Grup';
            $FROM   = '';
            $WHERE = '  AND (b.talleresculturales=0 OR ( b.grupoculturales=0  AND   b.periodo_fin_Grup="-1"))';
            $GROUP  = 'b.idbienestar';
    }else if($op==3){
            $SELECT = ' , b.idbienestar';
            $FROM   = '';
            $WHERE  ='  AND  (b.medicinadeporte>=1  OR  b.medicinageneral>=1  OR  b.asesoriapsicologica>=1   OR   b.asesoriapsicologicaSalud>=1 )';
            $GROUP  = 'e.idestudiantegeneral';
    }else if($op==4){
            $SELECT = ' ,b.periodoinicialseleccion AS S_ini, b.peridodinicialapoyo, b.fechaInicialVoluntareado,   b.periodoInicialMonitor, b.idbienestar';
            $FROM   = '';
            $WHERE = '  AND ((b.pertenecegrupapoyo=0 AND b.periodoFinalApoyoBienestar="-1") OR (b.pertenecevoluntariado=0 AND b.fechaFinalVoluntareado="0000-00-00") OR (b.monitorbienestar=0 AND b.periodoFinalMonitor="-1")) ';
            $GROUP  = 'b.idbienestar';
    }
      
          $SQL='SELECT 
            
                e.idestudiantegeneral,
                CONCAT(e.nombresestudiantegeneral," ",e.apellidosestudiantegeneral) AS NombreCopleto,
                e.numerodocumento
                '.$SELECT.'
                
                
                FROM bienestar b INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=b.idestudiantegenral
                INNER JOIN estudiante es on es.idestudiantegeneral=e.idestudiantegeneral
                INNER JOIN carrera c ON c.codigocarrera=es.codigocarrera
                '.$FROM.'
                WHERE
                
                c.codigomodalidadacademicasic=200
                '.$WHERE.'
                
                
                GROUP BY  '.$GROUP.'
                ORDER BY e.idestudiantegeneral';  
            
         if($Resultado=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Seleciones Deportes....<br><br>'.$SQL;
            die;
         }   
        
        $C_Result = $Resultado->GetArray();
        
        
       
            return $C_Result;    
     
         
         
  }//public function Consulta
  public function BoxPeriodo($num,$id,$op,$tipo='',$idBienestar,$value=''){
    global $db;
    
    ?>
    <table border="0" style="width: 100%;" >
        <?PHP
        
        for($i=0;$i<=$num;$i++){
            
            $SQl = 'SELECT
            
                    codigoperiodo,
                    codigoperiodo as dato
                    
                    FROM
                    
                    periodo
                    
                    ORDER BY codigoperiodo DESC';
                    
                if($Periodo=&$db->Execute($SQl)===false){
                    echo 'Error en el SQL de Periodo...<br><br>'.$SQl;
                    die;
                }   
            
            ?>
            <tr>
                <td>
                    <select id="Periodo_<?PHP echo $id.'_'.$i.'_'.$tipo?>" name="Periodo_<?PHP echo $id.'_'.$i?>" onchange="CambiarPerido('<?PHP echo $id.'_'.$i.'_'.$tipo?>','<?PHP echo $id?>','<?PHP echo $op?>','<?PHP echo $tipo?>','<?PHP echo $idBienestar?>')">
                        <option value="-1"></option>
                        <?PHP 
                        while(!$Periodo->EOF){
                            if($value==$Periodo->fields['codigoperiodo']){
                                $Selecte='selected="selected"';
                            }else{
                                $Selecte='';
                            }
                            ?>
                            <option value="<?PHP echo $Periodo->fields['codigoperiodo']?>" <?PHP echo $Selecte?> ><?PHP echo $Periodo->fields['dato']?></option>
                            <?PHP
                            $Periodo->MoveNext();
                        }//while
                        ?>
                    </select>        
                </td>
            </tr>
            <?PHP
        }
        ?>
    </table>
    
    <?PHP
  }//public function BoxPeriodo
  public function Tabla($op){
    global $db;
    
    ?>
        <table cellpadding="0" cellspacing="0" border="1" id="example_1">
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Nombre Estudiante</th>
                    <th>N&deg; Documento</th>
                    <?PHP 
                    if($op==1){
                        ?>
                        <th>Selecci&oacute;n</th>
                        <th>Periodo Inicial</th>
                        <th>Periodo Final</th>
                        <th>Taller</th>
                        <th>Periodo Inicial</th>
                        <th>Periodo Final</th>
                        
                        <?PHP
                    }else if($op==2){
                        ?>
                        <!--<th>Taller</th>-->
                        <th>Cultura</th>
                        <th>Periodo Inicial</th>
                        <th>Periodo Final</th>
                        <th>Grupos</th>
                        <th>Periodo Inicial</th>
                        <th>Periodo Final</th>
                        <?PHP
                    }else if($op==3){
                        ?>
                        <th>Medicina General</th>
                        <th>Medicina del Deporte</th>
                        <th>Asesoria Psicol&oacute;gica</th>
                        <th>Periodo</th>
                        <?PHP
                    }else if($op==4){
                        ?>
                        <th>Pertenece al Voluntariado</th>
                        <th>Fecha Inicial</th>
                        <th style="width: 12%;">Fecha Final</th>
                        <th>Pertenece al Grupo de Apoyo</th>
                        <th>Periodo Inicial</th>
                        <th>Periodo Final</th>
                        <th>Monitor Bienestar Universitario</th>
                        <th>Periodo Inicial</th>
                        <th>Periodo Final</th>
                        <?PHP
                    }
                    ?>
                    
                </tr>
            </thead>
            <tbody>
                <?PHP 
                $D_Datos = $this->Consulta($op);
                //echo '<pre>';print_r($D_Datos);die;
                for($i=0;$i<count($D_Datos);$i++){
                    
                    ?>
                    <tr style="width: 100%;">
                        <td style="text-align: center;"><?PHP echo $i+1?></td>
                        <td><?PHP echo $D_Datos[$i]['NombreCopleto']?></td>
                        <td style="text-align: center;"><?PHP echo $D_Datos[$i]['numerodocumento']?></td>
                        <?PHP 
                        if($op==1){
                            $Num = $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','Numero'); 
                               
                            ?>
                           
                            <td style="text-align: center;"><?PHP $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','','',1);?></td>
                            <td style="text-align: center;"><?PHP 
                            if($D_Datos[$i]['participaseleccionesuniversidad']!=1){
                                echo $D_Datos[$i]['S_ini'];
                            }
                            ?></td><!--periodo Inicial -->
                            <td style="text-align: center;"><?PHP 
                            if($D_Datos[$i]['participaseleccionesuniversidad']!=1){
                                if($D_Datos[$i]['S_fin']>0){
                                    echo $D_Datos[$i]['S_fin'];
                                }else{
                                    $this->BoxPeriodo($Num,$D_Datos[$i]['idestudiantegeneral'],$op,'2',$D_Datos[$i]['idbienestar']);    
                                }
                                
                            }?></td>
                            <td style="text-align: center;"><?PHP $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','',1);?></td><!--Talleres-->
                            <td style="text-align: center;">
                            <table border="0" style="width:100%;">
                                <tbody>
                            <?PHP 
                            if($D_Datos[$i]['talleresformativos']!=1){
                                
                                $C_Data = $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','','','','',1);
                                
                                for($x=0;$x<count($C_Data);$x++){
                                        ?>
                                        <tr>
                                            <td><?PHP echo $C_Data[$x]['periodo_inicial'];?></td>
                                        </tr>
                                        <?PHP
                                }//for
                            }
                            ?>
                               </tbody>
                            </table>
                            </td>
                            <td style="text-align: center;">
                              <table border="0" style="width:100%;">
                                <tbody>
                            <?PHP 
                            if($D_Datos[$i]['talleresformativos']!=1){
                                $Periodo = $this->Periodo();
                                $C_Data = $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','','','','',1);
                                $Num = count($C_Data);
                                    for($x=0;$x<count($C_Data);$x++){
                                       $id_mix = $C_Data[$x]['id_bienestar'].'-'.$C_Data[$x]['id'];
                                        ?>
                                        <tr>
                                            <td><?PHP 
                                            if($C_Data[$x]['periodo_fin']>=$Periodo){
                                             $this->BoxPeriodo(0,$D_Datos[$i]['idestudiantegeneral'],$op,'1',$id_mix,$C_Data[$x]['periodo_fin']);   
                                            }else{
                                                echo $C_Data[$x]['periodo_fin'];
                                            }?></td>
                                        </tr>
                                        <?PHP
                                    }//for
                            }
                            ?>
                               </tbody>
                            </table>
                            </td>
                            <?PHP
                        }else if($op==2){ 
                            $Num = $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','Numero','',1);
                            
                            ?>
                            <td style="text-align: center;"><?PHP $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','','','',1);?></td><!--Cultura-->
                            <td style="text-align: center;">
                            <table border="0" style="width:100%;">
                                <tbody>
                            <?PHP 
                            
                            if($D_Datos[$i]['talleresculturales']==1 || $D_Datos[$i]['talleresculturales']=='' || $D_Datos[$i]['talleresculturales']==Null){
                                
                            }else{
                                $C_Data = $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','','','','',1);
                            
                                //echo '<pre>';print_r($C_Data);
                                array_walk($C_Data, 'pintar_periodo');
                            }
                            ?>
                               </tbody>
                            </table>   
                            </td>
                            <td style="text-align: center;">
                            <table border="0" style="width:100%;">
                                <tbody>
                                <?PHP 
                                if($D_Datos[$i]['talleresculturales']==1 || $D_Datos[$i]['talleresculturales']=='' || $D_Datos[$i]['talleresculturales']==Null){
                                
                               }else{
                                $Periodo = $this->Periodo();
                                $C_Data = $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','','','','',1);
                                //echo 'n->'.$Num = count($C_Data);
                                for($x=0;$x<count($C_Data);$x++){
                                    $id_mix = $C_Data[$x]['id_bienestar'].'-'.$C_Data[$x]['id'];
                                    ?>
                                    <tr>
                                        <td>
                                        <?PHP  
                                        if($C_Data[$x]['periodo_fin']>=$Periodo){
                                             $this->BoxPeriodo(0,$D_Datos[$i]['idestudiantegeneral'],$op,'3',$id_mix,$C_Data[$x]['periodo_fin']);   
                                        }else{
                                            echo $C_Data[$x]['periodo_fin'];
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                    <?PHP
                                }//for   
                                }
                                ?>
                                </tbody>
                            </table>    
                            </td>
                            <td style="text-align: center;"><?PHP $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op,'','','',1);?></td><!--Grupos-->
                            <td style="text-align: center;"><?PHP  
                            if($Num>0){
                                if($D_Datos[$i]['periodo_ini_Grup']>1){
                                    echo $D_Datos[$i]['periodo_ini_Grup'];
                                }else{
                                    $this->BoxPeriodo(0,$D_Datos[$i]['idestudiantegeneral'],$op,'1',$D_Datos[$i]['idbienestar']);
                                }
                            }
                            ?></td><!--periodo Inicial  -->
                            <td style="text-align: center;"><?PHP 
                            //echo '<br>Num->'.$Num;
                            if($Num>0){
                                $this->BoxPeriodo($Num-1,$D_Datos[$i]['idestudiantegeneral'],$op,'2',$D_Datos[$i]['idbienestar']);   
                            }?></td>
                            <?PHP
                        }else if($op==3){
                            $C_Data = $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op);
                            
                            ?>
                            <td style="text-align: center;">
                            <table border="1" style="width:100%;">
                                <tbody>
                                <?PHP
                                for($j=0;$j<count($C_Data[$D_Datos[$i]['idestudiantegeneral']]['Medicina']);$j++){
                                    ?>     
                                    <tr>
                                        <td><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['Medicina'][$j]?></td>
                                    </tr>
                                    <?PHP
                                }
                                ?>
                                </tbody>
                            </table>
                            </td><!--Medicina del Deporte-->
                            <td style="text-align: center;">
                            <table border="1" style="width:100%;">
                                <tbody>
                                <?PHP
                                for($j=0;$j<count($C_Data[$D_Datos[$i]['idestudiantegeneral']]['Deporte']);$j++){
                                    ?>     
                                    <tr>
                                        <td><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['Deporte'][$j]?></td>
                                    </tr>
                                    <?PHP
                                }
                                ?>
                                </tbody>
                            </table>
                            </td><!--Medicina General-->
                            <td style="text-align: center;">
                             <table border="1" style="width:100%;">
                                <tbody>
                                <?PHP
                                for($j=0;$j<count($C_Data[$D_Datos[$i]['idestudiantegeneral']]['Psicologia']);$j++){
                                    ?>     
                                    <tr>
                                        <td><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['Psicologia'][$j]?></td>
                                    </tr>
                                    <?PHP
                                }
                                ?>
                                </tbody>
                            </table>
                            </td><!--Asesoria Psicol&oacute;gica-->
                            <td style="text-align: center;">
                            <table border="1" style="width:100%;">
                                <tbody>
                                <?PHP
                                for($j=0;$j<count($C_Data[$D_Datos[$i]['idestudiantegeneral']]['Periodo']);$j++){
                                    ?>     
                                    <tr>
                                        <td><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['Periodo'][$j]?></td>
                                    </tr>
                                    <?PHP
                                }
                                ?>
                                </tbody>
                            </table>
                            </td><!--periodo Inicial  -->
                            
                            <?PHP
                        }else if($op==4){
                            $C_Data = $this->Detalle($D_Datos[$i]['idestudiantegeneral'],$op);
                            //echo '<pre>';print_r($C_Data);
                           ?> 
                           <script>
                           
                              $(document).ready(function() {
                              $('#ui-datepicker-div').hide();
                              });
                             
                           </script>
                                <td style="text-align: center;"><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['Voluntariado']?></td><!--Pertenece al Voluntariado-->
                                <td style="text-align: center;"><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['fechaInicialVoluntareado']?></td><!--Fecha Inicial-->
                                <td style="text-align: center; width:12%;"><?PHP 
                                if($C_Data[$D_Datos[$i]['idestudiantegeneral']]['fechaInicialVoluntareado']){
                                    if($C_Data[$D_Datos[$i]['idestudiantegeneral']]['fechaFinalVoluntareado']!='0000-00-00'){
                                        echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['fechaFinalVoluntareado'];
                                    }else{
                                        ?> 
                                        <input type="text" name="F_finVoluntario_<?PHP echo $D_Datos[$i]['idestudiantegeneral']?>" size="12" id="F_finVoluntario_<?PHP echo $D_Datos[$i]['idestudiantegeneral']?>" title="Fecha de Final" maxlength="12" tabindex="7" placeholder="Fecha de Final" autocomplete="off" style="cursor: pointer;" value="" readonly onclick="Fecha('F_finVoluntario_<?PHP echo $D_Datos[$i]['idestudiantegeneral']?>');" onchange="FechaSave('F_finVoluntario_<?PHP echo $D_Datos[$i]['idestudiantegeneral']?>','<?PHP echo $D_Datos[$i]['idestudiantegeneral']?>','<?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['idbienestar']?>');" /> <?PHP 
                                        }
                                     }
                                     ?>
                                    </td><!--Fecha Final--->
                                <td style="text-align: center;"><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['pertenecegrupapoyo']?></td><!--Pertenece al Grupo de Apoyo-->
                                <td style="text-align: center;"><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['peridodinicialapoyo']?></td><!--Periodo Inicial-->
                                <td style="text-align: center;"><?PHP 
                                if($C_Data[$D_Datos[$i]['idestudiantegeneral']]['pertenecegrupapoyo']){
                                    if($C_Data[$D_Datos[$i]['idestudiantegeneral']]['periodofinalapoyo']!='-1'){
                                        echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['periodofinalapoyo'];
                                    }else{
                                    $this->BoxPeriodo(0,$D_Datos[$i]['idestudiantegeneral'],$op,'2',$C_Data[$D_Datos[$i]['idestudiantegeneral']]['idbienestar']);
                                    }
                                }?></td><!--Periodo Final-->
                                <td style="text-align: center;"><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['monitorbienestar']?></td><!--Monitor Bienestar Universitario-->
                                <td style="text-align: center;"><?PHP echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['periodoInicialMonitor']?></td><!--Periodo Inicial-->
                                <td style="text-align: center;"><?PHP 
                                if($C_Data[$D_Datos[$i]['idestudiantegeneral']]['periodoInicialMonitor']){ 
                                    if($C_Data[$D_Datos[$i]['idestudiantegeneral']]['periodoFinalMonitor']){ 
                                        echo $C_Data[$D_Datos[$i]['idestudiantegeneral']]['periodoFinalMonitor']; 
                                        }else{ 
                                            $this->BoxPeriodo(0,$D_Datos[$i]['idestudiantegeneral'],$op,'3',$C_Data[$D_Datos[$i]['idestudiantegeneral']]['idbienestar']);
                                            }
                                }?></td><!--Periodo Final-->
                           <?PHP
                        }
                        ?>
                        
                   </tr>
                    <?PHP
                }/*for*/
                ?>
            </tbody>        
         </table>
    <?PHP
    
  }/**tabla*/
  public function Periodo(){
    global $db;
    
    $SQL='SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo=1';
    
    if($Periodo=&$db->Execute($SQL)===false){
        echo 'Error en el SQL del Periodo...<br><br>'.$SQL;
        die;
    }
    return $Periodo->fields[0];
  }//public function Periodo
}//Class
function compareArrays($v1,$v2)
{
    if($v1['idestudiantegeneral'] == $v2['idestudiantegeneral']){
        return 0;
    }else if($v1['idestudiantegeneral'] > $v2['idestudiantegeneral']){
        return 1;        
    }else{
        return -1;
    }

}

function pintar_periodo($elemento2, $clave)
{
    //print_r($elemento2);
    echo $elemento2["periodo_inicial"]."<br />\n";
}
?>