    
    <div id="contenidoSecundario2">
            <h2>Alertas del Indicador</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example2_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar</span>                
                    </button>
                    <button id="ToolTables_example2_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2" style="width: 100%;">
                    <thead>
                        <tr>         
                            <th>Identificador</th> 
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
        var oTable2;
        var aSelected2 = [];           
                      
        $(document).ready(function() {  
            var sql;
            //el id no cuenta, entonces desde nombre empieza en 0
            //muestra todas las alertas especificas del indicador y las que aplican a todos
            sql="SELECT g.idsiq_alertaPeriodica,g.idsiq_alertaPeriodica,ta.nombre,p.periodicidad,g.fecha_prox_alerta,g.fecha_modificacion FROM siq_alertaPeriodica g ";
            sql+="inner join siq_periodicidad p on p.idsiq_periodicidad = g.idPeriodicidad AND p.codigoestado=100 ";
            sql+='inner join siq_tipoAlerta ta on ta.idsiq_tipoAlerta = g.idTipoAlerta AND ta.codigoestado=100 ';
            sql+='left join siq_relacionIndicadorMonitoreo r on r.idMonitoreo = g.idMonitoreo AND r.codigoestado=100 ';
            
              oTable2 = $('#example2').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_alertaPeriodica&sql="+sql+"&wh=g.tipo&vwh=1&cwh=(r.idIndicador=<?php echo $_REQUEST["id"]; ?> OR g.idMonitoreo IS NULL)&tableNickname=g&join=true",
                "aaSorting": [[ 4, "desc" ]],
                "aoColumnDefs": [  
                                                { "bSearchable": false, "bVisible": true, "aTargets": [ 3,4 ] },
						{ "sClass": "column_center", "aTargets": [ 0,3,4 ] },
                                                { "fnRender": function ( oObj ) {
                                                    if(oObj.aData[3]=="0000-00-00"){
                                                       return "Sin definir";     
                                                    } else {
                                                       return oObj.aData[3];
                                                    } 
                                                  },
                                                "aTargets": [ 3 ]}
                            ],
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); 
                            var maxWidth = $('#contenidoSecundario2').width();  
                            this.width(maxWidth);
                        }
            });
                        
            $('#example2 tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected2);
                 if ( $(this).children().hasClass('dataTables_empty') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example2_3").addClass('DTTT_disabled');
                    $("#ToolTables_example2_2").addClass('DTTT_disabled');
                }else{
                    aSelected2.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected2.length>1) aSelected2.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable2.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example2_3").removeClass('DTTT_disabled');
                    $("#ToolTables_example2_2").removeClass('DTTT_disabled');
                }
             } );
            
            $('#ToolTables_example2_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteResponsable("alertaPeriodica");}                
            } );
            
            $('#ToolTables_example2_2').click( function () {  
                if(!$('#ToolTables_example2_2').hasClass('DTTT_disabled'))
                {
                      if(aSelected2.length==1){
                        var id = aSelected2[0];
                            window.location.href= "alert.php?id="+id;
                      } else{
                            return false;
                      }                  
                }                
            });
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#contenidoSecundario2',oTable2);
        });        
</script>
