<?php
class ViewConsolaNotificaciones{
    public function Display($Data){
        ?>
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
           
           <h2>Consola De Notificaciones</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                        <input type="button" id="ToolTables_example_0" class="DTTT_button DTTT_button_text  tooltip" title="Enviar Notificaci&oacute;n" onclick="EnviarNotificacion()" value="Enviar Notificaci&oacute;n">    
                        <!--<button id="ToolTables_example_0" class="DTTT_button DTTT_button_text  tooltip" style="background: silver;" title="Enviar Notificaci&oacute;n" onclick="EnviarNotificacion()">
                            <span>Enviar Notificaci&oacute;n</span>
                            <img src="../imagenes/Forward.png" width="20" />              
                        </button>-->
                  </div>
                  <form id="NotificacionSolicitud">
                  <input type="hidden" id="actionID" name="actionID" value="EnviarEmail"/>
                  <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>    
                                <th>#</th>  
                                <th>ID Solicitud</th>   
                                <th>Sede &oacute; Campus</th> 
                                <th>Grupo &oacute; Unidad</th>
                                <th>Materia &oacute; Evento</th>
                                <th>Fecha Modificaci&oacute;n</th>  
                                <th>&nbsp;&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody> 
                        <?PHP 
                        for($i=0;$i<count($Data);$i++){
                            $id      = $Data[$i]['id'];
                            $Sede    = $Data[$i]['Sede'];
                            $Nombre  = $Data[$i]['InfoGrupo'];
                            $Materia = $Data[$i]['nombremateria'];
                            $Fecha   = $Data[$i]['FechaultimaModificacion'];
                            ?>
                            <tr>       
                                <td><?PHP echo $i+1?></td>
                                <td><?PHP echo $id?></td>
                                <td><?PHP echo $Sede?></td> 
                                <td><?PHP echo $Nombre?></td> 
                                <td><?PHP echo $Materia?></td>
                                <td><?PHP echo $Fecha?></td>
                                <td>
                                    <input type="checkbox" class="Enviar" id="Enviar_<?PHP echo $id?>" name="Enviar[]" value="<?PHP echo $id?>" />
                                </td>
                            </tr>
                            <?PHP
                          }  
                        ?>                      
                        </tbody>
                    </table>
                    </form>
             </div>
             
        </div> 
        <?PHP
    }//public function Display
    public function Mensaje($Info,$FulName){
        for($i=0;$i<count($Info);$i++){
            /*
            [AsignacionEspaciosId] => 280
            [FechaAsignacion] => 2015-03-23
            [FechaAsignacionAntigua] => 
            [codigoestado] => 100
            [HoraInicio] => 16:00:00
            [HoraFin] => 18:00:00
            [idgrupo] => 86430
            [nombregrupo] => A
            [nombremateria] => FISICA
            [ClasificacionEspaciosId] => 212
            [Nombre] => Falta por Asignar
            [Observaciones] => 
            [Tittle] => Clase Activa
            [Tittle2] => Clase en Aula
            [Tittle3] => Se ha Cambiado la Fecha
            
            */
            $Fecha                   = $Info[$i]['FechaAsignacion'];
            $FechaAsignacionAntigua  = $Info[$i]['FechaAsignacionAntigua'];
            $codigoestado            = $Info[$i]['codigoestado'];
            $HoraInicio              = $Info[$i]['HoraInicio'];
            $HoraFin                 = $Info[$i]['HoraFin'];
            $idgrupo                 = $Info[$i]['idgrupo'];
            $nombregrupo             = $Info[$i]['nombregrupo'];
            $nombremateria           = $Info[$i]['nombremateria'];
            $Espacio                 = $Info[$i]['Nombre'];
            $Observaciones           = $Info[$i]['Observaciones'];
            $EstadoAsignacionEspacio = $Info[$i]['EstadoAsignacionEspacio'];
            if($EstadoAsignacionEspacio==1 && $codigoestado==100){
                if($$Fecha!=$FechaAsignacionAntigua){
                    $Tittle                  = $Info[$i]['Tittle3'];
                }else{
                    $Tittle                  = $Info[$i]['Tittle2'];
                }
            }else if($EstadoAsignacionEspacio==0 && $codigoestado==100){
                $Tittle                  = $Info[$i]['Tittle2'];
            }
            
            if($codigoestado==200){
                $Tittle                  = $Info[$i]['Tittle'];
            }
            
            
            $Mensaje=$Mensaje.'<table border=2>
                                <tr>
                                    <th colspan="2">'.$FulName.'</th>
                                </tr>
                                <tr>
                                    <td>Notificaci&oacute;n</td>
                                    <td>'.$Tittle.'</td>
                                </tr>
                                <tr>
                                    <td>Materia</td>
                                    <td>'.$nombremateria.'</td>
                                </tr>';
            if($$Fecha!=$FechaAsignacionAntigua){
                 $Mensaje=$Mensaje.'<tr>
                                        <td>Fecha Anterior</td>
                                        <td>'.$FechaAsignacionAntigua.'</td>
                                    </tr>
                                    <tr>
                                        <td>Fecha Nueva</td>
                                        <td>'.$Fecha.'</td>
                                    </tr>';
            }else{
                 $Mensaje=$Mensaje.'<tr>
                                        <td>Fecha</td>
                                        <td>'.$Fecha.'</td>
                                    </tr>';
            }            
                       
             $Mensaje=$Mensaje.'<tr>
                                    <td>Hora de Inicio</td>
                                    <td>'.$HoraInicio.'</td>
                                </tr>
                                <tr>
                                    <td>Hora Final</td>
                                    <td>'.$HoraFin.'</td>
                                </tr>
                                <tr>
                                    <td>Observaci&oacute;n</td>
                                    <td>'.$Observaciones.'</td>
                                </tr>
                                <tr>
                                    <td>Lugar</td>
                                    <td>'.$Espacio.'</td>
                                </tr>
                            </table><br><br>';
           
        }//for
        
        return $Mensaje;
    }//public function Mensaje
}//class
?>