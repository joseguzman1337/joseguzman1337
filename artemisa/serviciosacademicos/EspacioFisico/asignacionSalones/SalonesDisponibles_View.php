<?php
class ViewSalonesDisponibles{
    public function Display($Dias,$Sedes){
        ?>
        <style>
            th{
              text-align: left;  
            }
        </style>
        <div id="containerThree">
           <h2>Salones Disponibles</h2>
           <div>
           <fieldset>
           <form name="salonesDisponibles" id="salonesDisponibles" action="">
           <input type="hidden" id="actionID" name="actionID" value="" />
                <table>
                    <thead>
                        <tr>
                            <th>Fecha Inicial</th>
                            <th>
                                <input type="text" name="fechaInicio" id="fechaInicio" size="10"/>
                            </th>
                            <th>Fecha Final</th>
                            <th>
                                <input type="text" name="fechaFinal" id="fechaFinal" value="" size="10"/>
                            </th>
                        </tr>
                        <tr>
                            <th>Hora Inicla</th>
                            <th>
                                <input type="text" name="datetimepicker1" id="datetimepicker1" value="06:00" size="5"/>
                            </th>
                            <th>Fecha Final</th>
                            <th>
                                <input type="text" name="datetimepicker2" id="datetimepicker2" value="22:00" size="5"/>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <fieldset>
                                    <legend>Dia Semana</legend>
                                    <table style="width: 100%;">
                                        <?PHP 
                                        for($i=0;$i<count($Dias);$i++){
                                            /*************************************/
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="Dia_<?PHP echo $i?>" name="dia[]" value="<?PHP echo $Dias[$i]['codigodia']?>" />&nbsp;&nbsp;<?PHP echo $Dias[$i]['nombredia']?>
                                                </td>
                                            </tr>
                                            <?PHP
                                            /*************************************/
                                        }//for
                                        ?>
                                    </table>
                                </fieldset>
                            </th>
                        </tr>
                        <tr>
                            <th>Instalaci&oacute;n</th>
                            <th id="Th_Sede">
                                <select name="Sede" id="Sede">
                                    <option value="-1"></option>
                                    <?PHP 
                                    for($i=0;$i<count($Sedes);$i++){
                                        ?>
                                        <option value="<?PHP echo $Sedes[$i]['id'];?>"><?PHP echo $Sedes[$i]['Nombre'];?></option>
                                        <?PHP
                                    }//for
                                    ?>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th>Acceso a Discapacitados</th>
                            <th>
                                <input type="checkbox" id="accDiscapacitados" name="accDiscapacitados" />
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <input type="button" id="Buscar" value="Buscar Espacios Libres" onclick="validar('#salonesDisponibles')" />
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="text-align: center;">
                                <div id="mostrarResultados" style="text-align: center; margin-left: 2%"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
           </form>     
           </fieldset>
           </div>
        </div>   
        <script>
            $('#fechaInicio').datetimepicker({
                lang:'es',
                timepicker:false,
                format:'Y-m-d',
                formatDate:'Y-m-d',
            })
            .datetimepicker({value:'',step:10});
            
            $('#fechaFinal').datetimepicker({
                lang:'es',
                timepicker:false,
                format:'Y-m-d',
                formatDate:'Y-m-d',
            })
            .datetimepicker({value:'',step:10});
            
            $('#datetimepicker1').datetimepicker({
                datepicker:false,
                format:'H:i',
                step:30
            });
            
            $('#datetimepicker2').datetimepicker({
                datepicker:false,
                format:'H:i',
                step:30
            });
        </script>
        <?PHP
    }//public function Display
    public function EspaciosLibres($db,$Data,$C_Fecha,$dia,$Discapacitados,$Hora_1,$Hora_2){
        //echo '<pre>';print_r($dia);die;
        if($Discapacitados=='on'){
            $Discapacitados=1;
        }else{
            $Discapacitados='';
        }
        include_once('../Solicitud/SolicitudEspacio_class.php'); $C_Solicitud  = new SolicitudEspacio();
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
         <table cellpadding="0" cellspacing="0" border="0" class="display" style="width: 100%;" id="example">
            <thead>
                <tr>    
                    <th>Espacio F&iacute;sioo</th>
                    <th>Bloque</th> 
                    <th>Tipo Aula</th>
                    <th>Capacidad Estudiantes</th> 
                    <th>Acceso Discapacitados</th> 
                    <th>Hora Inicial</th>                     
                    <th>Hora Final</th>                    
                    <th>Fecha</th>
                    <th>D&iacute;a Semana</th>
                </tr>
            </thead>
            <tbody>
            <?PHP 
            for($j=0;$j<count($Data);$j++){
                /***********************************************************************************/
                
                for($i=0;$i<count($C_Fecha);$i++){
                /**********************************************/
                $Dia_Ok=0;
                $fecha = $C_Fecha[$i][0];
                $DiaAcceso = $C_Solicitud->DiasSemana($fecha);
                for($d=0;$d<count($dia);$d++){
                    if($DiaAcceso==$dia[$d]){
                        $Dia_Ok=1;
                    }
                }
                if($Dia_Ok==1){
                /**********************************************/
                    foreach ($Data[$j][$fecha] as $key => $value) {
                        /*******************************************/
                        for($Q=0;$Q<count($value);$Q++){
                            if($Discapacitados==1){
                                if($Discapacitados==$value[$Q]['accesoDiscapacitados']){
                                /**************************************/
                                $Dia = $C_Solicitud->DiasSemana($fecha,'Nombre');
                                if($value[$Q]['accesoDiscapacitados']==1){
                                    $Acceso = 'Si';
                                }else{
                                    $Acceso = 'No';
                                }
                              
                                if($value[$Q]['HoraInicio']>=$Hora_1.':00' && $value[$Q]['HoraInicio']<=$Hora_2.':00'){
                                  
                                ?>
                                <tr>
                                    <td><?PHP echo $value[$Q]['Ubicacion']?></td>
                                    <td><?PHP echo $value[$Q]['Nombre']?></td>
                                    <td><?PHP echo $value[$Q]['tipoSalon']?></td>
                                    <td><?PHP echo $value[$Q]['capacidadEstudiantes']?></td>
                                    <td><?PHP echo $Acceso?></td>
                                    <td><?PHP echo $value[$Q]['HoraInicio']?></td>
                                    <td><?PHP echo $value[$Q]['HoraFin']?></td>
                                    <td><?PHP echo $fecha?></td>
                                    <td><?PHP echo $Dia?></td>
                                </tr>
                                <?PHP
                                }
                                /**************************************/
                                }
                            }else{
                                $Dia = $C_Solicitud->DiasSemana($fecha,'Nombre');
                                if($value[$Q]['accesoDiscapacitados']==1){
                                    $Acceso = 'Si';
                                }else{
                                    $Acceso = 'No';
                                }
                               
                                if($value[$Q]['HoraInicio']>=$Hora_1.':00' && $value[$Q]['HoraInicio']<=$Hora_2.':00'){
                                
                                ?>
                                <tr>
                                    <td><?PHP echo $value[$Q]['Ubicacion']?></td>
                                    <td><?PHP echo $value[$Q]['Nombre']?></td>
                                    <td><?PHP echo $value[$Q]['tipoSalon']?></td>
                                    <td><?PHP echo $value[$Q]['capacidadEstudiantes']?></td>
                                    <td><?PHP echo $Acceso?></td>
                                    <td><?PHP echo $value[$Q]['HoraInicio']?></td>
                                    <td><?PHP echo $value[$Q]['HoraFin']?></td>
                                    <td><?PHP echo $fecha?></td>
                                    <td><?PHP echo $Dia?></td>
                                </tr>
                                <?PHP
                              }  
                            }
                        }//for
                        /*******************************************/
                    }//foreach
                    }
                    /**********************************************/
                }//for
                
                /***********************************************************************************/
            }//for
            
            ?>  
            </tbody>
       </table>
        <?PHP
    }//public function EspaciosLibres
}//class ViewSalonesDisponibles

?>