<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Firmas Escaneadas de Educación Continuada",false);
    
    include("./menu.php");
    writeMenu(1);    ?>

<div id="container">
            <h2>Gestión de Firmas Escaneadas</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver detalle</span>                
                    </button>
                    <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar firma</span>                
                    </button>
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar firma</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>          
                            <th>Nombre</th> 
                            <th>Cargo</th>  
                            <th>Organización</th>                                
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
            
            sql="SELECT g.idfirmaEscaneadaEducacionContinuada,g.nombre,g.cargo,g.unidad FROM firmaEscaneadaEducacionContinuada g ";
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?IndexColumn=idfirmaEscaneadaEducacionContinuada&table=firmaEscaneadaEducacionContinuada&sql="+sql+"&wh=g.idfirmaEscaneadaEducacionContinuada&tableNickname=g&join=true&cwh=g.codigoestado=\'100\'",
                "aaSorting": [[ 0, "asc" ]],
                "aoColumnDefs": [ ],
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
                    $("#ToolTables_example_0").addClass('DTTT_disabled');
                    $("#ToolTables_example_4").addClass('DTTT_disabled');
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_0").removeClass('DTTT_disabled');
                    $("#ToolTables_example_4").removeClass('DTTT_disabled');
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
                }
             } );
            
            $('#ToolTables_example_0').click( function () {  
                if(!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
                {gotodetalle();  }
            } );
            
            $('#ToolTables_example_4').click( function () {  
                if(!$('#ToolTables_example_4').hasClass('DTTT_disabled'))
                {updateForm(); }               
            } );
          
            
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
               {
                   if(confirm('¿Está seguro de eliminar esta firma?')){                
                        if(aSelected.length==1){
                                    var id = aSelected[0];
                                    id=id.substring(4,id.length);                
                                    $.ajax({
                                        dataType: 'json',
                                        type: 'POST',
                                        url: 'processFirma.php',
                                        data: 'idfirmaEscaneadaEducacionContinuada='+id+'&entity=firmaEscaneadaEducacionContinuada&action=inactivate',
                                        success:function(data){ 
                                            if (data.success == true){
                                                location.reload();
                                            }
                                        },
                                        error: function(data,error){}
                                    }); 
                                }else{
                                        return false;
                            }             
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