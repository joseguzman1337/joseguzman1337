<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Instrumentos de percepción",true,$proyectoMonitoreo);
    
    $utils = new Utils_monitoreo();

    $data = $utils->getDataEntity("indicador", $_REQUEST["id"]);   
    $indicadorG = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]);
    $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]); 
    $nombre = $indicadorG["nombre"];
       if($discriminacion["idsiq_discriminacionIndicador"]==1){
           $nombre = $nombre." - ".$discriminacion["nombre"];
       } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
           $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$data["idCarrera"]."'");
           $nombre = $nombre." - ".$carrera["nombrecarrera"];  
       }   

       $api = new API_Monitoreo();
       $rel = $api->getRelacionIndicadorMonitoreo($data["idsiq_indicador"]);
       $actividad = $api->getActividadActualizarActiva($rel["idMonitoreo"]);
       if($data["idCarrera"]==null){
           $complexQuery="(c.codigocarrera IS NULL ";
       } else {
            $complexQuery="(c.codigocarrera=".$data["idCarrera"]." ";
       }
       if(count($actividad)>0){
           $complexQuery .= " AND c.fecha_fin<='".$actividad["fecha_limite"]."' ";
           $actividad2 = $utils->getDataNonEntity($db,"fecha_actualizacion,fecha_limite","siq_actividadActualizar","idEstado='3' AND fecha_limite<'".$actividad["fecha_limite"]."' AND idMonitoreo='".$rel["idMonitoreo"]."' ORDER BY fecha_limite DESC");
           if(count($actividad2)>0){
                $complexQuery .= " AND c.fecha_inicio>'".$actividad2["fecha_limite"]."' ";               
           }
       }      
       $complexQuery .= " AND c.idsiq_Ainstrumentoconfiguracion IN (SELECT ins.idsiq_Ainstrumentoconfiguracion ";
       $complexQuery .=  " FROM sala.siq_Ainstrumento ins  WHERE idsiq_Apregunta IN (SELECT p.idsiq_Apregunta ";
       $complexQuery .=  " FROM siq_Apreguntaindicador p WHERE p.disiq_indicador=".$data["idsiq_indicador"]." AND p.codigoestado=100) ";
       $complexQuery .=  " AND ins.codigoestado=100 GROUP BY ins.idsiq_Ainstrumentoconfiguracion) )";
?>

<div id="container">            
            <h4 style="margin-bottom:0.5em;">Instrumentos relacionados con el indicador: <?php echo $nombre; ?></h4>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <!--<button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver</span>                
                    </button>
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Actualizar análisis</span>
                    </button>-->
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>       
                            <th>Identificador</th>    
                            <th>Nombre</th> 
                            <th>Fecha Inicio</th>  
                            <th>Fecha Expiración</th>  
                            <th>Tipo</th>      
                            <th>Programa</th>
                            <th>Periodicidad</th>                          
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                </table>
            </div>
        </div>  
        <script type="text/javascript">
        var oTable;
        var aSelected = [];           
                      
        $(document).ready(function() {  
            var sql;
            
            
            sql="SELECT c.idsiq_Ainstrumentoconfiguracion, c.idsiq_Ainstrumentoconfiguracion, c.nombre, ";
            sql+="c.fecha_inicio, c.fecha_fin, d.nombre as tipo, nombrecarrera, p.periodicidad ";
            sql+="FROM siq_Ainstrumentoconfiguracion c ";
            sql+="inner join siq_discriminacionIndicador as d on (d.idsiq_discriminacionIndicador=c.idsiq_discriminacionIndicador) ";
            sql+="inner join siq_periodicidad as p on (p.idsiq_periodicidad=c.idsiq_periodicidad) ";
            sql+="left  join carrera as r on (r.codigocarrera=c.codigocarrera) ";
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_Ainstrumentoconfiguracion&sql="+sql+"&wh=c.codigoestado&cwh=<?php echo $complexQuery; ?>&tableNickname=c&join=true",
                "aaSorting": [[ 3, "desc" ]],
                "aoColumnDefs": [  
						{ "sClass": "column_fecha", "aTargets": [ 0,2,3,4 ] }
                            ],
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); 
                            var maxWidth = $('#container').width();  
                            this.width(maxWidth);
                        }
            });
                        
            $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).hasClass('row_selected') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_0").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');  
                    $("#ToolTables_example_0").removeClass('DTTT_disabled');
                }
             } );
            
            $('#ToolTables_example_0').click( function () {  
                if(!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
                {gotodetalle();  }
            } );
            
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {updateForm(); }               
            } );
            
            //$('#ToolTables_example_5').click( function () {  
            //    if(!$('#ToolTables_example_5').hasClass('DTTT_disabled'))
            //   {
            //          if(aSelected.length==1){
            //                var id = aSelected[0];
            //                id=id.substring(4,id.length);                
            //                $.ajax({
            //                    dataType: 'json',
            //                    type: 'POST',
            //                    url: 'process.php',
            //                    data: 'idsiq_indicador='+id+'&entity=indicador&action=revisar',
            //                    success:function(data){ 
            //                        if (data.success == true){
            //                            location.reload();
            //                        }
            //                    },
            //                    error: function(data,error){}
            //                }); 
            //            }else{
            //                    return false;
            //        }                     
            //    }                
            //});
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#container',oTable);
        });      
        </script>
    
<?php    writeFooter();
        ?>       