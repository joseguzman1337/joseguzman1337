<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Docentes de Educación Continuada",false);
    
    include("./menu.php");
    writeMenu(1);    ?>

<div id="container">
            <h2>Docentes por Prestación de Servicios de Educación Continuada</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver detalle</span>                
                    </button>
                    <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar Datos Docente</span>                
                    </button>
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar Docente</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>          
                            <th>Nombre</th> 
                            <th>Apellidos</th>  
                            <th>Documento</th>  
                            <th>E-mail</th>    
                            <th>Profesión</th>  
                            <th>Especialidad</th>                               
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
            
            <?php $fechahoy=date("Y-m-d H:i:s"); ?>
            
            sql="SELECT g.iddocenteEducacionContinuada,g.nombredocente,g.apellidodocente,g.numerodocumento,g.emaildocente,g.profesion,g.especialidad FROM docenteEducacionContinuada g ";
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?IndexColumn=iddocenteEducacionContinuada&table=docenteEducacionContinuada&sql="+sql+"&wh=g.iddocenteEducacionContinuada&tableNickname=g&join=true&cwh=g.codigoestado=\'100\'",
                "aaSorting": [[ 0, "asc" ]],
                "aoColumnDefs": [  
                                                //{ "bSearchable": true, "bVisible": false, "aTargets": [ 3,5 ] },
                                                //{ "bSearchable": false, "bVisible": true, "aTargets": [ 6,7 ] },
						{ "sClass": "column_fecha", "aTargets": [ 2 ] }//,
                                                //{ "fnRender": function ( oObj ) {
                                                //    if(oObj.aData[3]==1){
                                                //       return oObj.aData[4];     
                                                //    } else if(oObj.aData[3]==3) {
                                                //        return oObj.aData[5];
                                                //    } 
                                                //  },
                                                //"aTargets": [ 4 ]}
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
                   if(confirm('¿Está seguro de eliminar este docente?')){                
                        if(aSelected.length==1){
                                    var id = aSelected[0];
                                    id=id.substring(4,id.length);                
                                    $.ajax({
                                        dataType: 'json',
                                        type: 'POST',
                                        url: 'process.php',
                                        data: 'iddocenteEducacionContinuada='+id+'&entity=docenteEducacionContinuada&action=inactivate',
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