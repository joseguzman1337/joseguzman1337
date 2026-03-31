<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Alertas",false,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(5);    ?>

<div id="container">
            <h2>Administración de Alertas</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <!--<button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver detalle</span>                
                    </button>-->
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar</span>
                    </button>
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>         
                            <th>Identificador</th> 
                            <th>Indicador</th> 
                            <th>Alerta</th>  
                            <th>Periodicidad</th>  
                            <th>Fecha de la Próxima Alerta</th>  
                            <th>Fecha Última Modificación</th>                          
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
            
            //sql="SELECT g.idsiq_indicador,id.nombre,g.discriminacion as disc,d.nombre as discriminacion,c.nombrecarrera as carrera,f.nombrefacultad as facultad,e.nombre as estado,g.fecha_modificacion FROM siq_indicador g ";
            //sql+='inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico ';
            //sql+='inner join siq_discriminacionIndicador d on d.idsiq_discriminacionIndicador = g.discriminacion ';
            //sql+='left join carrera c on c.codigocarrera = g.idCarrera ';
            //sql+='left join facultad f on f.codigofacultad = g.idFacultad ';
            //sql+='inner join siq_estadoIndicador e on e.idsiq_estadoIndicador = g.idEstado ';
            
            sql="SELECT g.idsiq_alertaPeriodica,g.idsiq_alertaPeriodica,id.nombre,ta.nombre,p.periodicidad,g.fecha_prox_alerta,g.fecha_modificacion,c.nombrecarrera FROM siq_alertaPeriodica g ";
            sql+="inner join siq_periodicidad p on p.idsiq_periodicidad = g.idPeriodicidad AND p.codigoestado=100 ";
            sql+='inner join siq_tipoAlerta ta on ta.idsiq_tipoAlerta = g.idTipoAlerta AND ta.codigoestado=100 ';
            sql+='left join siq_relacionIndicadorMonitoreo r on r.idMonitoreo = g.idMonitoreo AND r.codigoestado=100 ';
            sql+='left join siq_indicador i on i.idsiq_indicador = r.idIndicador ';
            sql+='left join carrera c on c.codigocarrera = i.idCarrera ';
            sql+='left join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = i.idIndicadorGenerico ';
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_alertaPeriodica&sql="+sql+"&wh=g.tipo&vwh=1&tableNickname=g&join=true",
                "aaSorting": [[ 5, "desc" ]],
                "aoColumnDefs": [  
                                                { "bSearchable": true, "bVisible": false, "aTargets": [ 6 ] },
                                                { "bSearchable": false, "bVisible": true, "aTargets": [ 4,5 ] },
						{ "sClass": "column_fecha", "aTargets": [ 0,4,5 ] },
                                                { "fnRender": function ( oObj ) {
                                                    if(oObj.aData[4]=="0000-00-00"){
                                                       return "Sin definir";     
                                                    } else {
                                                       return oObj.aData[4];
                                                    } 
                                                  },
                                                "aTargets": [ 4 ]},
                                                { "fnRender": function ( oObj ) {
                                                    if(oObj.aData[1]=="" || oObj.aData[1]==null){
                                                       return "Todos";     
                                                    } else {
                                                        if(oObj.aData[6]==null){
                                                            return oObj.aData[1] + " (Institucional)"
                                                        } else {
                                                            return oObj.aData[1] + " (" + oObj.aData[6] + ")";                                                            
                                                        }
                                                    } 
                                                  },
                                                "aTargets": [ 1 ]}
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
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                   // $("#ToolTables_example_0").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');  
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
                    //$("#ToolTables_example_0").removeClass('DTTT_disabled');
                }
             } );
            
            //$('#ToolTables_example_0').click( function () {  
            //    if(!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
            //    {gotodetalle();  }
            //} );
            
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteForm("alertaPeriodica");}                
            } );          
            
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {
                      if(aSelected.length==1){
                        var id = aSelected[0];
                            window.location.href= "alert.php?id="+id;
                      } else{
                            return false;
                      }                  
                }                
            });
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#container',oTable);
        });      
        </script>
    
<?php    writeFooter();
        ?>       
   

