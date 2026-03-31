<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Periodicidades Inactivas",false,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(3); 
?>
        <div id="container">
            <h2>Administración de Periodicidades Inactivas</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver detalle</span>                
                    </button>
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Activar</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>          
                            <th>Id</th>                  
                            <th>Periodicidad</th>
                            <th>Valor</th>
                            <th>Tipo de Valor</th>
                            <th>Fecha Última Modificación</th>
                            <th>Usuario Modificación</th>                            
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
            sql="SELECT g.idsiq_periodicidad,g.idsiq_periodicidad,g.periodicidad,g.valor,t.nombre,g.fecha_modificacion,g.usuario_modificacion FROM siq_periodicidad g ";
            sql+='inner join siq_tipoValorPeriodicidad t on t.idsiq_tipoValorPeriodicidad = g.tipo_valor ';
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No hay inactivos."
                },
                "bServerSide": true, 
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=false&table=siq_periodicidad&sql="+sql+"&wh=g.usuario_modificacion&tableNickname=g&join=true",
                "aaSorting": [[ 4, "desc" ]],
                "aoColumnDefs": [ 			
						{ "bSearchable": false, "bVisible": true, "aTargets": [ 4,3 ] },			
						{ "bSearchable": false, "bVisible": false, "aTargets": [ 5 ] },
                                                { "sClass": "column_fecha", "aTargets": [ 0,2,4,3 ] }
                            ],
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); }
            });
                        
            $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).children().hasClass('dataTables_empty') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_0").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                    if (aSelected.length>1) aSelected.shift();
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
                {activateForm("periodicidad");}                
            } );
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#container',oTable);
        });  
        </script>
<?php   
    writeFooter();
?>    