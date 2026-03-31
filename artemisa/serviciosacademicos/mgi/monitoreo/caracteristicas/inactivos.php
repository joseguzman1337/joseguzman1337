<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    writeHeader("Gestión de Características Inactivas",false,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(3);
    ?>

<div id="container">
            <h2>Administración de Características Inactivas</h2>
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
                            <th>Nombre de la Característica</th>
                            <th>Factor</th>
                            <th>Fecha Última Modificación</th>
                            <th>Usuario Modificación</th>   
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
            sql="SELECT g.idsiq_caracteristica,g.idsiq_caracteristica,g.codigo,g.nombre,f.nombre as factor,g.fecha_modificacion,g.usuario_modificacion,c.nombres,c.apellidos FROM siq_caracteristica g ";
            sql+='inner join usuario c on c.idusuario = g.usuario_modificacion ';
            sql+='inner join siq_factor f on f.idsiq_factor = g.idFactor ';
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=false&table=siq_caracteristica&sql="+sql+"&wh=g.usuario_modificacion&tableNickname=g&join=true",
                "aaSorting": [[ 4, "desc" ]],
                "aoColumnDefs": [ 
						{ "bSearchable": false, "bVisible": false, "aTargets": [ 5,6 ] },
						{ "bSearchable": false, "bVisible": false, "aTargets": [ 7 ] },
						{ "bSearchable": false, "bVisible": true, "aTargets": [ 4 ] },
						{ "sClass": "column_fecha", "aTargets": [ 0,4 ] }
                            ],
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true);
                            var maxWidth = $('#container').width();  
                            this.width(maxWidth); }
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
                {activateForm("caracteristica");}                
            } );
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#container',oTable);
        });   
        </script>
    
<?php    writeFooter();
        ?>       
