<?php
class InterfazDocente{
    public function Display($db,$Docente){
        $Resultado = $this->PrintSolicitudDocente($db,$Docente);
        
        ?>
        <style>
        tr.odd:hover,tr.even:hover{
            background-color: yellow;
            cursor: pointer;
        }
        .ClasOnclikColor{
             background-color: red;
        }
        .odd{
            background-color: #e2e4ff;
        }
        .even{
          background-color: #A8F7C5;  
        }
        
        </style>
        <style type="text/css" title="currentStyle">
                @import "../../observatorio/data/media/css/demo_page.css";
                @import "../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../observatorio/data/media/css/ColVis.css";
                @import "../../observatorio/data/media/css/TableTools.css";
                @import "../../observatorio/data/media/css/ColReorder.css";
                @import "../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../../observatorio/data/media/css/jquery.modal.css";
                
        </style>
        <!--<script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="../jquery/js/jquery-3.6.0.js"></script>-->
        <script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/FixedColumns.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColReorder.js"></script>
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			oTable = $('#example').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "aLengthMenu": [[100], [100,  "All"]],
                                    "iDisplayLength": 100,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                                var oTableTools = new TableTools( oTable, {
        					"buttons": [
        						"copy",
        						"csv",
        						"xls",
        						"pdf",
        						{ "type": "print", "buttonText": "Print me!" }
        					]
        		         });
                                 //$('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
           
        </script>
         <div id="container">
           <h2>M&oacute;dulo de Solicitudes Asociadas A Docente</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                     <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text  tooltip" title="Ver Estado de la Solicitud" onclick="Ver_EstadoSolicitudDocente()">
                            <span>Ver Estado de la Solicitud</span>                
                     </button>
                </div>
                    <input type="hidden" id="Id_Solicitud" name="Id_Solicitud" />
                    <?PHP 
                       
                          $SQL='SELECT
                                codigoperiodo,codigoestadoperiodo
                                FROM
                                	periodo
                                WHERE
                                	codigoestadoperiodo=1';
                                    
                               if($Dato=&$db->Execute($SQL)===false){
                                echo 'Error en el SQL ...<br><br>'.$SQL;
                                die;
                               }  
                               
                         $arrayP = str_split($Dato->fields['codigoperiodo'], strlen($Dato->fields['codigoperiodo'])-1);

                        $Year = $arrayP[0];         
                        
                        if($arrayP[1]==1){
                            $Periodo   = 1;
                            $Periodo_2 = 2;
                        }else{
                            $Periodo   = 2;
                            $Periodo_2 = 1;
                        }
                        
                        if($Periodo==2){
                            $Year_2  = $Year+1;
                        }else{
                            $Year_2  = $Year;
                        }
                        
                    ?>
                    <div>
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <label>Periodo Actual&nbsp;<?PHP echo $Year.'-'.$Periodo?></label>
                                </td>
                                <td>
                                     <label style="background: #e2e4ff; width: 10px; height: 10px;"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Proximo Periodo&nbsp;<?PHP echo $Year_2.'-'.$Periodo_2?></label>
                                </td>
                                <td>
                                     <label style="background: #A8F7C5; width: 10px; height: 10px;"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Solicitudes Externas</label>
                                </td>
                                <td>
                                     <label style="background: #FAFF6B; width: 10px; height: 10px;"></label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <!--<img src="../../mgi/images/Office-Excel-icon.png" width="40" style="cursor: pointer;"  onclick="ExportarExcel();" title="Exportar a Excel" />-->
                                </td>
                            </tr>
                        </table>
                   </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>    
                                <th>#</th>  
                                <th>ID Solicitud</th> 
                                <th>ID Solicitud Detalle</th>   
                                <th>D&iacute;a Semana</th> 
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>Instalaci&oacute;n</th> 
                                <th>Grupo &oacute; Unidad</th>
                                <th>Materia &oacute; Evento</th> 
                                <th>Fecha Creaci&oacute;n</th> 
                                <th>Fecha Inicial</th>                     
                                <th>Fecha Final</th>
                                <th>Acceso A Discapacitado</th>
                                <th>Atendiadas/Solicitadas</th>
                                <th>Tipo DE Solicitud</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?PHP 
                        $num = count($Resultado);
                        for($i=0;$i<count($Resultado);$i++){
                            /*****************************************************/
                            if($Resultado[$i]['AccesoDiscapacitados']==1){
                                $Accesso = 'Si';
                            }else{
                                $Accesso = 'No';
                            }
                            
                            $id = $Resultado[$i]['Padre_ID'];
                            
                            $valor = $this->ColorPeriodo($db,$Resultado[$i]['FechaInicio'],$Resultado[$i]['codigomodalidadacademica']);
                            
                            if($valor==1){
                                $Color = '#e2e4ff';
                                $Type = 'Interna';
                              }else if($valor==2){
                                $Color = '#FAFF6B';//Amarillo Externo
                                $Type = 'Externa';
                              }else{
                                $Color = '#A8F7C5';
                                $Type = 'Interna';
                              } 
                              
                              
                            if($Resultado[$i]['Grupo-Unidad']){  
                                if($Resultado[$i]['codigomodalidadacademica']==001 || $Resultado[$i]['codigomodalidadacademica']=='001'){
                                    $Nombre='<ul>';
                                        
                                        for($n=0;$n<count($Resultado[$i]['Grupo-Unidad']);$n++){
                                            
                                            $Nombre=$Nombre.'<li>'.$Resultado[$i]['Grupo-Unidad'][$n]['nombregrupo'].'</li>';
                                            
                                        }
                                       
                                    $Nombre=$Nombre.'</ul>';
                                    
                                    $Materia='<ul>';
                                        
                                        for($n=0;$n<count($Resultado[$i]['Grupo-Unidad']);$n++){
                                            
                                            $Materia=$Materia.'<li>'.$Resultado[$i]['Grupo-Unidad'][$n]['nombremateria'].'</li>';
                                            
                                        }
                                       
                                    $Materia=$Materia.'</ul>';
                                    
                                }else{
                                    $Nombre =  $Resultado[$i]['Grupo-Unidad'][0]['UnidadNombre'];
                                    $Materia = $Resultado[$i]['Grupo-Unidad'][0]['NombreEvento'];
                                }
                            }
                            
                            
                            $Dia ='<ul>';
                            for($d=0;$d<count($Resultado[$i]['Dia']);$d++){
                                $Dia =$Dia.'<li>'.$Resultado[$i]['Dia'][$d].'</li>';
                            }
                            $Dia =$Dia.'</ul>';
                            
                            $Hijos='<ul>';
                            for($h=0;$h<count($Resultado[$i]['Hijos']);$h++){
                                $Hijos =$Hijos.'<li>'.$Resultado[$i]['Hijos'][$h].'</li>';
                            }
                            $Hijos =$Hijos.'</ul>';
                            
                            $Horas='<ul>';
                            for($c=0;$c<count($Resultado[$i]['Hora']);$c++){
                                $Horas =$Horas.'<li>'.$Resultado[$i]['Hora'][$c].'</li>';
                            }
                            $Horas =$Horas.'</ul>';
                            
                            $Instalacion='<ul>';
                            for($s=0;$s<count($Resultado[$i]['Instalacion']);$s++){
                                $Instalacion =$Instalacion.'<li>'.$Resultado[$i]['Instalacion'][$s].'</li>';
                            }
                            $Instalacion =$Instalacion.'</ul>';
                            
                            ?>
                            <tr style="background: <?PHP echo $Color?>;" id="Tr_File_<?PHP echo $i?>" onclick="CargarNum('<?PHP echo $i?>','<?PHP echo $id?>','<?PHP echo $num?>')"  onmouseover="ColorNeutro('<?PHP echo $i?>','<?PHP echo $Resultado[$i]['FechaInicio']?>','<?PHP echo $Resultado[$i]['codigomodalidadacademica']?>');">       
                                <td><?PHP echo $i+1?></td>
                                <td><?PHP echo $id?></td>
                                <td><?PHP echo $Hijos?></td>
                                <td><?PHP echo $Dia?></td>
                                <td style="font-size: 14px;"><?PHP echo $Horas?></td>  
                                <td><?PHP echo $Instalacion?></td> 
                                <td><?PHP echo $Nombre?></td> 
                                <td><?PHP echo $Materia?></td>
                                <td><?PHP echo $Resultado[$i]['FechaCreacion']?></td> 
                                <td><?PHP echo $Resultado[$i]['FechaInicio']?></td>                     
                                <td><?PHP echo $Resultado[$i]['FechaFinal']?></td>
                                <td style="text-align: center;"><?PHP echo $Accesso?></td>
                                <td><?PHP echo $Resultado[$i]['Num_Atendida'].'/'.$Resultado[$i]['Total']?></td>
                                <td><?PHP echo $Type?></td>
                            </tr>
                            <?PHP
                            /*****************************************************/
                        }//for
                        ?>                      
                        </tbody>
                    </table>
                    <div>
                        <table>
                            <tr>
                                <td>
                                    <!--<img src="../../mgi/images/Office-Excel-icon.png" width="40" style="cursor: pointer;" onclick="ExportarExcel();" title="Exportar a Excel" />-->
                                </td>
                            </tr>
                        </table>
                    </div>
             </div>
        </div> 
        <?PHP
    }//public function Display
    public function PrintSolicitudDocente($db,$Docente){
        $Periodo = $this->Periodo($db);
        //$Periodo = 20151;
        $SQL='SELECT
                        sp.SolicitudPadreId,
                    	g.idgrupo,
                    	g.numerodocumento,
                    	g.codigomateria,
                    	s.SolicitudAsignacionEspacioId,
                    	s.FechaInicio,
                    	s.FechaFinal,
                    	s.ClasificacionEspaciosId,
                    	cc.Nombre,
                    	d.nombredia,
                    	CONCAT(
                    		a.HoraInicio,
                    		" :: ",
                    		a.HoraFin
                    	) AS Horas,
                    	s.codigomodalidadacademica
                    FROM
                    	grupo g
                    INNER JOIN SolicitudEspacioGrupos sg ON sg.idgrupo = g.idgrupo
                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                    INNER JOIN AsociacionSolicitud aa ON aa.SolicitudAsignacionEspaciosId=s.SolicitudAsignacionEspacioId
                    INNER JOIN SolicitudPadre sp ON sp.SolicitudPadreId=aa.SolicitudPadreId
                    INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = s.ClasificacionEspaciosId
                    INNER JOIN dia d ON d.codigodia = s.codigodia
                    INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                    WHERE
                    	g.codigoperiodo = "'.$Periodo.'"
                    AND g.codigoestadogrupo = 10
                    AND g.numerodocumento = "'.$Docente.'"
                    AND sg.codigoestado = 100
                    AND sp.CodigoEstado=100
                    GROUP BY
                    	sp.SolicitudPadreId';
                
                if($ConsutaPadre=&$db->Execute($SQL)===false){
                    Echo 'Error en el SQL de Las Solicitudes relacionadas al docente...<br><br>'.$SQL;
                    die;
                }
                
         if(!$ConsutaPadre->EOF){
             $Resultado = array();
             $i=0;
             while(!$ConsutaPadre->EOF){
                /*******************************************************/
                $Padre_ID = $ConsutaPadre->fields['SolicitudPadreId'];
                
                $SQL_Contenido='SELECT
                                	s.SolicitudAsignacionEspacioId,
                                	s.codigodia,
                                	s.ClasificacionEspaciosId,
                                	s.codigomodalidadacademica,
                                	s.codigocarrera,
                                	asg.HoraInicio,
                                	asg.HoraFin,
                                	d.nombredia,
                                	c.Nombre AS Instalacion,
                                    s.AccesoDiscapacitados,
                                    s.FechaCreacion,
                                    s.FechaInicio,
                                    s.FechaFinal
                                FROM
                                	AsociacionSolicitud a
                                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                                    INNER JOIN AsignacionEspacios asg ON asg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                    INNER JOIN dia d ON d.codigodia = s.codigodia
                                    INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = s.ClasificacionEspaciosId
                                WHERE
                                	a.SolicitudPadreId ="'.$Padre_ID.'"
                                AND s.codigoestado = 100
                                GROUP BY
                                	s.codigodia,
                                	s.ClasificacionEspaciosId,
                                	s.codigocarrera';
                                    
                               if($Contenido=&$db->Execute($SQL_Contenido)===false){
                                    echo 'Error en el SQL del Contenido solicitud  ....<br><br>'.$SQL_Contenido;
                                    die;
                                 } 
                if(!$Contenido->EOF){          
                       if($Contenido->fields['codigomodalidadacademica']=='001' || $Contenido->fields['codigomodalidadacademica']==001){
                        /******************Internas******************************/   
                              $SQL_ContDetalle='SELECT
                                                        g.idgrupo,
                                                        g.nombregrupo,
                                                        m.codigomateria,
                                                        m.nombremateria
                                                FROM
                                                        SolicitudEspacioGrupos sg 
                                                        INNER JOIN grupo g ON g.idgrupo=sg.idgrupo
                                                        INNER JOIN materia m ON m.codigomateria=g.codigomateria
                                                
                                                WHERE
                                                
                                                        sg.SolicitudAsignacionEspacioId="'.$Contenido->fields['SolicitudAsignacionEspacioId'].'"
                                                        AND
                                                        sg.codigoestado=100'; 
                       }else{
                        /******************Externas******************************/
                              $SQL_ContDetalle='SELECT
                                                    	s.NombreEvento,
                                                    	s.NumAsistentes,
                                                    	s.UnidadNombre,
                                                    	s.Responsable
                                                FROM
                                                	   SolicitudAsignacionEspacios s
                                                WHERE
                                                       s.SolicitudAsignacionEspacioId ="'.$Contenido->fields['SolicitudAsignacionEspacioId'].'"
                                                       AND 
                                                       s.codigoestado = 100'; 
                       }  
                       
                            if($ContDetalle=&$db->Execute($SQL_ContDetalle)===false){
                                echo 'Error en el SQL del Contenido Detalle...<br><br>'.$SQL_ContDetalle;
                                die;
                            }
                            
                            $C_Detalle = $ContDetalle->GetArray();
                                                        
                /*********************Construir Array()*****************/
                      $Resultado[$i]['Padre_ID'] = $Padre_ID;
                      $O=0;
                      $N=0; 
                      while(!$Contenido->EOF){
                        /*****************************************/
                        $Resultado[$i]['Hijos'][]        = $Contenido->fields['SolicitudAsignacionEspacioId']; 
                        $Resultado[$i]['Dia'][]          = $Contenido->fields['nombredia'];
                        $Resultado[$i]['Hora'][]         = substr($Contenido->fields['HoraInicio'], 0,5).' :: '.substr($Contenido->fields['HoraFin'], 0,5);
                        $Resultado[$i]['Instalacion'][]  = $Contenido->fields['Instalacion'];
                        $Resultado[$i]['Grupo-Unidad']   = $C_Detalle;
                        $Resultado[$i]['AccesoDiscapacitados']         = $Contenido->fields['AccesoDiscapacitados'];
                        $Resultado[$i]['FechaCreacion']  = $Contenido->fields['FechaCreacion'];
                        $Resultado[$i]['FechaInicio']    = $Contenido->fields['FechaInicio'];
                        $Resultado[$i]['FechaFinal']     = $Contenido->fields['FechaFinal'];
                        $Resultado[$i]['codigomodalidadacademica']  = $Contenido->fields['codigomodalidadacademica'];
                        
                        /******************************************/
                        
                        $SQL_X='SELECT
                                a.ClasificacionEspaciosId
                                FROM
                                AsignacionEspacios a
                                
                                WHERE  a.codigoestado=100 and a.SolicitudAsignacionEspacioId="'.$Contenido->fields['SolicitudAsignacionEspacioId'].'"';
                                
                                if($Info=&$db->Execute($SQL_X)===false){
                                    echo 'Error al Calcular Atendidas...<br><br>'.$SQL_X;
                                    die;
                                }
                               
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
                       
                        /*****************************************/
                        $Contenido->MoveNext();
                      }//while Hijos
                      
                      $Resultado[$i]['Num_Atendida'] = $O;
                      $Resultado[$i]['Total'] = $N+$O; 
                }  
                /*******************************************************/
                $ConsutaPadre->MoveNext();
                $i++;
             }//while
        }
        
        return $Resultado;
    }//public function PrintSolicitudDocente
    public function Periodo($db){
          $SQL='SELECT
                codigoperiodo,codigoestadoperiodo
                FROM
                	periodo
                WHERE
                	codigoestadoperiodo = 1';
                    
               if($Dato=&$db->Execute($SQL)===false){
                echo 'Error en el SQL ...<br><br>'.$SQL;
                die;
               }  
           
           
           $Periodos = $Dato->fields['codigoperiodo'];
                      
           return $Periodos;
    }//public function Periodo
    public function MultiGrupoView($db,$id){
          $SQL='SELECT
                	sg.idgrupo,
                    g.nombregrupo,
                	g.maximogrupo
                FROM
                	SolicitudAsignacionEspacios s
                                                    INNER JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                                    INNER JOIN grupo g ON g.idgrupo=sg.idgrupo
                WHERE
                	s.SolicitudAsignacionEspacioId = "'.$id.'"
                AND s.codigoestado = 100';
                
                if($MultiGroup=&$db->Execute($SQL)===false){
                    echo 'Error en el SQl multigrupo View...<br><br>'.$SQL;
                    die;
                }
                
                $C_Multi = $MultiGroup->GetArray();
                
                $Num = count($C_Multi);
                
                $C_Resultado = array();
                
                if($Num>1){
                    $C_Resultado['val']  = true;
                    $Name = '';
                    $codigo = '';
                    for($i=0;$i<$Num;$i++){
                        if($i==0){
                            $Name = $C_Multi[$i]['nombregrupo'];
                            $codigo = $C_Multi[$i]['idgrupo'];
                        }else{
                        $Name = $Name.' :: '.$C_Multi[$i]['nombregrupo'];
                        $codigo = $codigo.' :: '.$C_Multi[$i]['idgrupo'];
                        }
                    }
                    $C_Resultado['name']  = $Name;
                    $C_Resultado['codigo']  = $codigo;
                }else{
                    $C_Resultado['val']  = false;
                }
            return $C_Resultado;
    }//public function MultiGrupoView
    public function ColorPeriodo($db,$fecha_1,$Modalidad){
        $SQL='SELECT
                	date(fechainicioperiodo) AS fecha_ini, date(fechavencimientoperiodo) AS fecha_fin ,codigoperiodo,codigoestadoperiodo
                FROM
                	periodo
                WHERE
                	"'.$fecha_1.'" BETWEEN fechainicioperiodo AND fechavencimientoperiodo';
                    
               if($Fechas=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de las Fechas del Periodo Academico.....<br><br>'.$SQL;
                    die;
               } 
               
              if($Fechas->fields['codigoestadoperiodo']==1 && $Modalidad==001){
                $Color =1;
              }else if($Fechas->fields['codigoestadoperiodo']!=1 && $Modalidad==001){
                $Color = 0;
              }else if($Modalidad!=001 || $Modalidad!='001'){
                 $Color = 2;
              } 
              
              return $Color;
    }//public function ColorPeriodo
}//class

?>