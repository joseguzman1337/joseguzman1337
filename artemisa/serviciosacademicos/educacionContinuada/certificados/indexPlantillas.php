<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Plantillas de Documentos de Educación Continuada",false);
    
    include("./menuPlantillas.php");
    writeMenu(1);    ?>

<div id="container">
            <h2>Gestión de Plantillas de Documentos</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Previsualizar</span>                
                    </button>
                    <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar plantilla</span>                
                    </button>
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar plantilla</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>          
                            <th>Nombre</th> 
                            <th>Fecha Creación</th>  
                            <th>Fecha Modificación</th>                                
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
            
            sql="SELECT g.idplantillaGenericaEducacionContinuada,g.nombre,g.fecha_creacion,g.fecha_modificacion FROM plantillaGenericaEducacionContinuada g ";
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?IndexColumn=idplantillaGenericaEducacionContinuada&table=plantillaGenericaEducacionContinuada&sql="+sql+"&wh=g.idplantillaGenericaEducacionContinuada&tableNickname=g&join=true&cwh=g.codigoestado=\'100\' AND g.visible=1",
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
                {     if(aSelected.length==1){
						 var id = aSelected[0];
						 id=id.substring(4,id.length);
						 //window.location.href= "detallePlantilla.php?id="+id;
                                                 popup_carga("previsualizarPlantilla.php?id="+id);
					 }else{
						 return false;
                        } }
            } );
            
            $('#ToolTables_example_4').click( function () {  
                if(!$('#ToolTables_example_4').hasClass('DTTT_disabled'))
                {if(aSelected.length==1){
				  var id = aSelected[0];
					 window.location.href= "editarPlantilla.php?id="+id;
				  }else{
					 return false;
				  } }               
            } );
          
            
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
               {
                   if(confirm('¿Está seguro que desea eliminar esta plantilla?')){                
                        if(aSelected.length==1){
                                    var id = aSelected[0];
                                    id=id.substring(4,id.length);                
                                    $.ajax({
                                        dataType: 'json',
                                        type: 'POST',
                                        url: 'processPlantilla.php',
                                        data: 'idplantillaGenericaEducacionContinuada='+id+'&entity=plantillaGenericaEducacionContinuada&action=inactivate',
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