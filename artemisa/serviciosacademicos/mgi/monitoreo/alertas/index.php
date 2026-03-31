<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Tipo de Alertas",false,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(1);    ?>

<div id="container">
            <h2>Administración de los Tipos de Alertas</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver detalle</span>                
                    </button>
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar</span>
                    </button>
                    <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Agregar destinatario personalizado</span>                
                    </button>
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Inactivar</span>                
                    </button>                    
                    <!--<button id="ToolTables_example_5" class="DTTT_button DTTT_button_text">
                        <span>Prueba</span>                
                    </button>-->
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>        
                            <th>Id</th>    
                            <th>Tipo de Alerta</th>        
                            <th>Asunto del Correo</th>
                            <th>Tipo del responsable destinatario</th>
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
            sql="SELECT g.idsiq_tipoAlerta,g.idsiq_tipoAlerta,g.nombre,g.asunto_correo,t.nombre as responsabilidad,g.fecha_modificacion,g.usuario_modificacion FROM siq_tipoAlerta g ";
            sql+='left join siq_tipoResponsabilidad t on t.idsiq_tipoResponsabilidad = g.idTipoResponsable';
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_tipoAlerta&sql="+sql+"&wh=g.usuario_modificacion&tableNickname=g&join=true&group=g.idsiq_tipoAlerta",
                "aaSorting": [[ 4, "desc" ]],
                "aoColumnDefs": [  
						{ "bSearchable": false, "bVisible": true, "aTargets": [ 4,5 ] },
						{ "sClass": "column_fecha", "aTargets": [ 0,4,5 ] }
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
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                    $("#ToolTables_example_0").addClass('DTTT_disabled');
                    $("#ToolTables_example_4").addClass('DTTT_disabled');
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
                    $("#ToolTables_example_4").removeClass('DTTT_disabled');
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
                {assignDestinatary();}                
            } );
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteForm("tipoAlerta");}                
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
            //                    url: 'processPrueba.php',
            //                    data: 'idsiq_tipoAlerta='+id+'&entity=tipoAlerta&action=dontProcess',
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
   

