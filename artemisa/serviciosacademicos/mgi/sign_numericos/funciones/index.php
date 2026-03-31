<?php

    include_once("../variables.php");
    //include($rutaTemplate."templateNumericos.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Funciones",false,$proyectoNumericos);
    
    include("./menu.php");
    writeMenu(1); 
?>
        <div id="container">
            <h2>Administración de Funciones</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver detalle</span>                
                    </button>
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar</span>
                    </button>
                    <!--  <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                    </button> -->
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Inactivar</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                 
                            <th>Nombre de la Función</th>
                            <th>Estado</th>
                            <th>Fecha Última Modificación</th>
                            <th>Usuario</th>   
                            <th>Nombre Usuario Modificación</th>
                            <th>Apellidos Usuario Modificación</th>                           
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
            sql="SELECT g.idsiq_funcion,g.nombre,g.codigoestado,g.fecha_modificacion,g.usuario_modificacion,c.nombres,c.apellidos FROM siq_funcion g ";
            sql+='inner join usuario c on c.idusuario = g.usuario_modificacion ';
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_funcion&sql="+sql+"&wh=g.usuario_modificacion",
                "aaSorting": [[ 2, "desc" ]],
                "aoColumnDefs": [ 
						{ "bSearchable": false, "bVisible": false, "aTargets": [ 4 ] },
						{ "bSearchable": false, "bVisible": false, "aTargets": [ 5 ] },
						{ "bSearchable": false, "bVisible": true, "aTargets": [ 3 ] },
                                                { "sClass": "column_fecha", "aTargets": [ 1,2,3 ] }
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
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                    $("#ToolTables_example_0").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
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
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {assignResponsable();}                
            } );
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {
                    deleteForm("funcion");  
                
            }                
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