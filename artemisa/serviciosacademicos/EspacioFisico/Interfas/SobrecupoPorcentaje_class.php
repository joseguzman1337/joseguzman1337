<?php
class SobrecupoPorcentaje{
    public function Display($db,$RolEspacioFisico){
        if($RolEspacioFisico!=1){
            echo 'No Tiene Permisos Para Esta Opcion';
            die;
        }
        ?>
        <script>
          $(function() {
            $( "#tabs" ).tabs();
          });
        </script>
        <div id="container">
           <h2>Configuraci&oacute;n de Parametros Espacio F&iacute;sico</h2>
           <div>
                <table>
                    <tr>
                        <td>
                            <div id="tabs">
                                <ul>
                                    <li><a href="#tabs-1" >Porcentaje de Aumento</a></li>
                                    <li><a href="#tabs-2" >Aprobar Sobrecupos</a></li>
                                    <li><a href="#tabs-3" >Administar Tiempos de No Uso</a></li>
                                </ul>
                                <div id="tabs-1"><?PHP $this->PorcentajeAumento($db);?></div>
                                <div id="tabs-2"><?PHP $this->Sobrecupos($db);?></div>
                                <div id="tabs-3"><?PHP $this->AdminHoras($db);?></div>
                            </div> 
                        </td>
                    </tr>
                   
                </table>
           </div>
        </div>   
        <?PHP
    }//public function Display
    public function PorcentajeAumento($db){
        ?>
        <form id="PorcentajeAdd">
            <table>
                <thead>
                    <tr>
                        <th>Porcentaje</th>
                        <th>
                            <input type="text" id="NumPorcentaje" name="NumPorcentaje" style="text-align: center;" maxlength="2" size="5" autocomplete="off" /><strong>%</strong>
                        </th>
                        <th>Periodo</th>
                        <th>
                            <?PHP $this->Periodo($db);?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">
                            <input type="button" id="SavePorcentaje" value="Guardar" onclick="PorcentajeSave()" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <?PHP
    }//public function PorcentajeAumento
    public function Sobrecupos($db,$op=''){
        $Data = $this->DataSobrecupo($db,'',$op);
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
            <div id="VentanaNew"></div>
            <div id="demo">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>       
                                <th>Nombre Espacio F&iacute;sico</th> 
                                <th>Observaci&oacute;n</th> 
                                <th>Periodo</th> 
                                <th>Sobrecupo</th> 
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?PHP
                            for($i=0;$i<count($Data);$i++){
                                /***********************************/
                                ?>
                                <tr style="cursor: pointer;" title="Click para Aprobar." onclick="VerSobrecupoolicitud('<?PHP echo $Data[$i]['SobreCupoClasificacionEspacioId']?>')">
                                    <td><?PHP echo $Data[$i]['Nombre']?></td>
                                    <td><?PHP echo $Data[$i]['Observaciones']?></td>
                                    <td><?PHP echo $Data[$i]['codigoperiodo']?></td>
                                    <td><?PHP echo $Data[$i]['Sobrecupo']?></td>
                                    <?PHP 
                                    if($Data[$i]['EstadoAprobacion']==0){
                                        $Texto = 'Pendiente';
                                        $Color = '#EC1F4C';
                                    }else{
                                        $Texto = 'Aprobada';
                                        $Color = '#21E634';
                                    }
                                    ?>
                                    <td><span style="color: <?PHP echo $Color?>;"><?PHP echo $Texto?></span></td>
                                </tr>
                                <?PHP
                                /***********************************/
                            }//for
                            ?>                       
                        </tbody>
                    </table>
             </div>
        </div> 
        
        <?PHP
    }//public function Sobrecupos
    public function AdminHoras($db){
        ?>
        <form id="HorasAdmin">
            <table>
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>
                            <?PHP $this->Periodo($db);?>
                        </th>
                    </tr>
                    <tr>
                        <th>Sede</th>
                        <th>
                            <?PHP $this->Sede($db);?>
                        </th>
                    </tr>
                    <tr>
                        <th>Hora Inicial</th>
                        <th>
                            <?PHP $this->Hora('Hora_ini','Hora Inicial');?>
                        </th>
                    </tr>
                    <tr>
                        <th>Hora Final</th>
                        <th>
                            <?PHP $this->Hora('Hora_fin','Hora Final');?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                            <input type="button" id="SaveHora" value="Guardar" onclick="HoraSave()" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <?PHP
    }//public function AdminHoras
    public function Periodo($db){
          $SQL='SELECT 
                
                codigoperiodo AS id,
                codigoperiodo
                
                FROM periodo
                
                WHERE
                
                codigoestadoperiodo IN(1,3)';
                
            if($Periodos=&$db->Execute($SQL)===false){
                echo 'Error en el SQl Periodos...<br><br>'.$SQL;
                die;
            }    
         ?>
         <select id="Periodo" name="Periodo">
            <?PHP 
            while(!$Periodos->EOF){
                ?>
                <option value="<?PHP echo $Periodos->fields['id']?>"><?PHP echo $Periodos->fields['codigoperiodo']?></option>
                <?PHP
                $Periodos->MoveNext();
            }
            ?>
         </select>
         <?PHP   
    }//public function Periodo
    public function Sede($db){
          $SQL='SELECT
                        ClasificacionEspaciosId AS id,
                        Nombre
                FROM
                        ClasificacionEspacios
                WHERE
                        ClasificacionEspacionPadreId = 1
                        AND EspaciosFisicosId = 3
                        AND codigoestado = 100';
                        
                if($Sede=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de las Sedes....<br><br>'.$SQL;
                    die;
                } 
         ?>
         <select id="Sede" name="Sede">
            <option value="-1"></option>
         <?PHP              
         while(!$Sede->EOF){
            ?>
            <option value="<?PHP echo $Sede->fields['id']?>"><?PHP echo $Sede->fields['Nombre']?></option>
            <?PHP
            $Sede->MoveNext();
         }
         ?>
         </select>
         <?PHP       
    }//public function Sede
    public function Hora($name,$Example){
        ?>
        <input type="text" size="10" id="<?PHP echo $name?>" name="<?PHP echo $name?>" readonly="readonly" style="text-align: center;" placeholder="<?PHP echo $Example?>" />
        <script>
        $("#<?PHP echo $name?>").clockpick({
            starthour : 6,
            endhour : 23,
            showminutes : true
        });
        $("#<?PHP echo $name?>").clockpick({
            starthour : 6,
            endhour : 23,
            showminutes : true
        });
        </script>
        <?PHP
    }// public function Hora
    public function VerSolicitudSobrecupo($db,$id){
        $Data = $this->DataSobrecupo($db,$id);
       
        ?>
        <style>
            th{
                text-align: left;
            }
        </style>
        <br />
        <br />
        <br />
        <fieldset>
            <legend>Administrador de Sobrecupos</legend>
            <table>
                <thead>
                    <tr>
                        <th>Nombre:</th>
                        <th>&nbsp;</th>
                        <th><?PHP echo $Data[0]['Nombre'];?></th>
                    </tr>
                    <tr>    
                        <th>Capacidad Actual:</th>
                        <th>&nbsp;</th>
                        <th><?PHP echo $Data[0]['CapacidadEstudiantes'];?></th>
                    </tr>
                    <tr>    
                        <th>Periodo:</th>
                        <th>&nbsp;</th>
                        <th><?PHP echo $Data[0]['codigoperiodo'];?></th>
                    </tr>
                    <tr>    
                        <th>Cantidad Solicitada:</th>
                        <th>&nbsp;</th>
                        <th><?PHP echo $Data[0]['Sobrecupo'];?></th>
                    </tr>
                    <tr>
                        <th>Observaci&oacute;n:</th>
                        <th>&nbsp;</th>
                        <th><?PHP echo $Data[0]['Observaciones'];?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">
                            <input type="button" id="AprobarSobrecupo" value="Aprobar Sobrecupo." onclick="SobreCupoAprobado('<?PHP echo $id;?>')" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <?PHP
    }//public function VerSolicitudSobrecupo
    public function DataSobrecupo($db,$id='',$op=''){
        if($id){
            if($op){
                $Condicion = ' WHERE s.SobreCupoClasificacionEspacioId="'.$id.'"';
            }else{
                $Condicion = ' AND s.SobreCupoClasificacionEspacioId="'.$id.'"';
            }
            
        }else{
            $Condicion = '';
        }
        if($op){
            $CondicionNext = '';
        }else{
            $CondicionNext = ' WHERE s.EstadoAprobacion = 0';
        }
          $SQL='SELECT
                	s.SobreCupoClasificacionEspacioId,
                	s.Sobrecupo,
                	Observaciones,
                	c.Nombre,
                	s.codigoperiodo,
                    c.CapacidadEstudiantes,
                    s.EstadoAprobacion
                FROM
                	SobreCupoClasificacionEspacios s
                INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = s.ClasificacionEspacioId
                
                	'.$CondicionNext.$Condicion;
                    
                if($SobreCupoData=&$db->Execute($SQL)===false){
                    Echo 'Error en el SQL de la Data del Sobrecupo....<br><br>'.$SQL;
                    die;
                } 
                
          $Data = $SobreCupoData->GetArray();
          
          Return $Data;         
    }//public function DataSobrecupo
}//class

?>