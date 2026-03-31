<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
   include("../templates/templateObservatorio.php");
   $db=writeHeader('Estadisticas<br> Admisiones',true,'Admisiones',1);
   /* include("./menu.php");
    writeMenu(0);*/
    ?>
        <div id="container">
            <div class="demo_jui">
                <div class="DTTT_container">
                <!--<button id="ToolTables_example_0" class="DTTT_button DTTT_button_text">
                <span>Nuevo</span>
                </button>-->
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Ver</span>
                </button>
                <!--<button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Eliminar</span> 
                </button>-->
                <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Cargar .csv</span> 
                </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Modalidad</th>
                            <th>Carrera</th>
                            <th>Periodo</th>
                            <th>Fecha</th>
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
        var sql;
            sql="SELECT ma.idobs_admisiones_estadisticas, m.nombremodalidadacademica, c.nombrecarrera, ma.codigoperiodo,  ma.fecha_crear ";
            sql+="FROM obs_admisiones_estadisticas as ma ";
            sql+="inner join modalidadacademica as m on (m.codigomodalidadacademica=ma.codigomodalidadacademica) ";
            sql+="inner join carrera as c on (c.codigocarrera=ma.codigocarrera) ";
            //alert(sql);
        $(document).ready(function() {  
            oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../server_processing.php?active=true&table=obs_admisiones_estadisticas&sql="+sql+"&wh=ma.codigoestado&tableNickname=ma&join=true&group=ma.fecha_crear",   
                "aoColumns": [
                { "sTitle": "Modalidad" },
                { "sTitle": "Carrera", "bVisible":false},
                { "sTitle": "Periodo"},
                { "sTitle": "Fecha"}
                ], 
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); 
                            var maxWidth = $('#container').width();  
                            this.width(maxWidth);
                        }
            });
            /* Click event handler */
           
             $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).hasClass('row_selected') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
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
                }
             } );
             $('#ToolTables_example_0').click( function () {  
                if(!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
                {gotonuevo('form_admisiones_estadisticas.php');  }
            } );
            
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {updateForm2('form_admisiones_estadisticas.php'); }               
            } );
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {deleteForm("admisiones_estadisticas");}                
            } );
             $('#ToolTables_example_3').click( function () { 
                    exportar("form_exportar_admisiones_estadisticas.php");          
            } );
      } );
        </script>
    
<?php    writeFooter();
        ?>  