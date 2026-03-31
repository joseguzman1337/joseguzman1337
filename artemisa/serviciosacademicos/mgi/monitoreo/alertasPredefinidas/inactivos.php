<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Alertas por Eventos Inactivas",false,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(3);    ?>

<div id="container">
            <h2>Alertas Inactivas</h2>
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
                            <th>Alerta</th>   
                            <th>Descripción</th>     
                            <th>Asunto del Correo</th>
                            <th>Fecha Última Modificación</th>     
                            <th>Usuario Modificador</th>                   
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
            sql="SELECT g.idsiq_tipoAlertaPredefinida,g.idsiq_tipoAlertaPredefinida,g.nombre,g.descripcion,g.asunto_correo,g.fecha_modificacion,g.usuario_modificacion FROM siq_tipoAlertaPredefinida g ";
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=false&table=siq_tipoAlertaPredefinida&sql="+sql+"&wh=g.usuario_modificacion&tableNickname=g&join=true",
                "aaSorting": [[ 4, "desc" ]],
                "aoColumnDefs": [  
						{ "bSearchable": false, "bVisible": true, "aTargets": [ 4,5 ] },
						{ "sClass": "column_fecha", "aTargets": [ 0,5,4 ] }
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
                 if ( $(this).children().hasClass('dataTables_empty') && index === -1  ) {
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
                {activateForm("tipoAlertaPredefinida");}                
            } );
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#container',oTable);
        });       
        </script>
    
<?php    writeFooter();
        ?>       
   

