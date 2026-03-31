<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Indicadores Inactivos",false,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(3);    ?>

<div id="container">
            <h2>Indicadores Inactivos</h2>
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
                            <th>Código</th> 
                            <th>Indicador</th> 
                            <th>ID Discriminación</th>  
                            <th>Discriminación</th>  
                            <th>Carrera</th>    
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
            sql="SELECT g.idsiq_indicador,g.idsiq_indicador,id.codigo,id.nombre,g.discriminacion as disc,d.nombre as discriminacion,c.nombrecarrera as carrera,e.nombre as estado,g.fecha_modificacion FROM siq_indicador g ";
            sql+='inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico ';
            sql+='inner join siq_discriminacionIndicador d on d.idsiq_discriminacionIndicador = g.discriminacion ';
            sql+='left join carrera c on c.codigocarrera = g.idCarrera ';
            sql+='inner join siq_estadoIndicador e on e.idsiq_estadoIndicador = g.idEstado ';
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=false&table=siq_indicador&sql="+sql+"&wh=g.usuario_modificacion&tableNickname=g&join=true",
                "aaSorting": [[ 7, "desc" ]],
                "aoColumnDefs": [  
                                               { "bSearchable": true, "bVisible": false, "aTargets": [ 3,5 ] },
                                                { "bSearchable": false, "bVisible": true, "aTargets": [ 6,7 ] },
						{ "sClass": "column_fecha", "aTargets": [ 0,7,6 ] },
                                                { "fnRender": function ( oObj ) {
                                                    if(oObj.aData[3]==1){
                                                       return oObj.aData[4];     
                                                    } else if(oObj.aData[3]==3) {
                                                        return oObj.aData[5];
                                                    } 
                                                  },
                                                "aTargets": [ 4 ]}
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
                {activateForm("indicador");}                
            } );
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#container',oTable);
        });         
        </script>
    
<?php    writeFooter();
        ?>       
   

