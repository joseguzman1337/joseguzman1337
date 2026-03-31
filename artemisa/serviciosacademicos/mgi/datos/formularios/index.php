<?php

    include("../templates/template.php");
    writeHeader("Formularios para el Registro de la Información",false);
    
?>

<div id="container">
            <h2>Administración de Reportes</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver reporte</span>                
                    </button>
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar</span>
                    </button>
                    <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Relacionar indicadores</span>                
                    </button>
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar</span>                
                    </button>
                    <!--<button id="ToolTables_example_5" class="DTTT_button DTTT_button_text">
                        <span>Prueba</span>                
                    </button>-->
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>       
                            <th>Id</th>    
                            <th>Nombre</th> 
                            <th>Descripcion</th> 
                            <th>Estado</th>  
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
            
            sql="SELECT g.idsiq_reporte,g.idsiq_reporte,g.nombre,g.descripcion,e.nombre as estado,g.fecha_modificacion FROM siq_reporte g ";
            sql+='inner join siq_estadoReporte e on e.idsiq_estadoReporte = g.estado_definicion_reporte ';
                  
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "../../server_processing.php?active=true&table=siq_reporte&sql="+sql+"&wh=g.fecha_modificacion&tableNickname=g&join=true",
                "aaSorting": [[ 4, "desc" ]],
                "aoColumnDefs": [  
                                                //{ "bSearchable": true, "bVisible": false, "aTargets": [ 3,5 ] },
                                                { "bSearchable": false, "bVisible": true, "aTargets": [ 2 ] },
						{ "sClass": "column_fecha", "aTargets": [ 0,3,4 ] }//,
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
                {assignResponsable();}                
            } );
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteForm("indicador");}                
            } );          
            
            $('#ToolTables_example_4').click( function () {  
                if(!$('#ToolTables_example_4').hasClass('DTTT_disabled'))
                {
                      if(aSelected.length==1){
                        var id = aSelected[0];
                            window.location.href= "monitoreoIndicador.php?id="+id;
                      } else{
                            return false;
                      }                  
                }                
            });
            
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
   

