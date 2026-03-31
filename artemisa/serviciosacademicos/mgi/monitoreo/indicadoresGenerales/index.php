<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Indicadores",false,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(1);   
    ?>

<div id="container">
            <h2>Administración de Definiciones de Indicadores</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver detalle</span>                
                    </button>
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar</span>
                    </button>                
                    <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Actualizar detalle de indicadores</span>                
                    </button>                  
                    <button id="ToolTables_example_5" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Asignar alerta</span>                
                    </button>             
                    <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Inactivación masiva de indicadores</span>                
                    </button>                   
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Inactivar definición de indicador</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>         
                            <th>Id</th>   
                            <th>Código</th>    
                            <th>Indicador</th>  
                            <th>Área</th>       
                            <th>Aspecto a Evaluar</th>
                            <th>Característica</th>
                            <th>Factor</th>
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
            sql="SELECT g.idsiq_indicadorGenerico,g.idsiq_indicadorGenerico,g.codigo,g.nombre,ar.nombre as area,a.nombre as aspecto,c.nombre as caracteristica,f.nombre as factor,g.fecha_modificacion FROM siq_indicadorGenerico g ";
            sql+='inner join siq_area ar on ar.idsiq_area = g.area ';
            sql+='inner join siq_aspecto a on a.idsiq_aspecto = g.idAspecto ';
            sql+='inner join siq_caracteristica c on c.idsiq_caracteristica = a.idCaracteristica ';
            sql+='inner join siq_factor f on f.idsiq_factor = c.idFactor ';
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_indicadorGenerico&sql="+sql+"&wh=g.usuario_modificacion&tableNickname=g&join=true",
                "aaSorting": [[ 7, "desc" ]],
                "aoColumnDefs": [  
						{ "bSearchable": false, "bVisible": true, "aTargets": [ 5,6,7 ] },
						{ "sClass": "column_fecha", "aTargets": [ 0,7 ] }
                            ],
                "fnInitComplete": function() {
                           // alert($(window).width());
                           //alert($(window).outerWidth());
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
                    $("#ToolTables_example_5").addClass('DTTT_disabled');
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
                    $("#ToolTables_example_5").removeClass('DTTT_disabled');
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
                {
                    if(aSelected.length==1){
                        var id = aSelected[0];
                            window.location.href= "inactivateMass.php?id="+id;
                     }else{
                            return false;
                    }
                }                
            } );
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteForm("indicadorGenerico");}                
            } );  
            $('#ToolTables_example_4').click( function () {  
                if(!$('#ToolTables_example_4').hasClass('DTTT_disabled'))
                {
                    if(aSelected.length==1){
                        var id = aSelected[0];
                            window.location.href= "editMass.php?id="+id;
                     }else{
                            return false;
                    }
                }                
            } );   
            $('#ToolTables_example_5').click( function () {  
                if(!$('#ToolTables_example_5').hasClass('DTTT_disabled'))
                {
                    if(aSelected.length==1){
                        var id = aSelected[0];
                            window.location.href= "alertMass.php?id="+id;
                     }else{
                            return false;
                    }
                }                
            } ); 
            
      } );
            
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {  
            resizeWindow('#container',oTable);
        });      
        </script>
    
<?php    writeFooter();
        ?>       
   

