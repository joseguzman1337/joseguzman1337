<?php
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   /* include("./menu.php");
    writeMenu(0);*/
    ?>
        <div id="container">
            <div class="full_width big">Instrumentos</div>
            <h1>Resportes de Instrumentos</h1>
            <div class="demo_jui">
                <div class="DTTT_container">
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Ver</span>
                </button>
                <!--<button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Eliminar</span> 
                </button>-->
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Nombre</th>
                            <th>Bienvenida</th>
                            <th>Despedida</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>   
                            <th>Secciones</th> 
                            <th>Tipo</th> 
                            <th>Programa</th> 
                            <th>Periodicidad</th> 
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
		<?php if(!isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]==="MGI") { ?>
            sql="SELECT c.idsiq_Ainstrumentoconfiguracion, c.nombre, c.mostrar_bienvenida, c.mostrar_despedida, ";
            sql+="c.fecha_inicio, c.fecha_fin, c.estado, c.secciones, d.nombre as tipo, nombrecarrera, p.periodicidad ";
            sql+="FROM siq_Ainstrumentoconfiguracion AS c ";
            sql+="left join siq_discriminacionIndicador as d on (d.idsiq_discriminacionIndicador=c.idsiq_discriminacionIndicador) ";
			sql+="left join siq_periodicidad as p on (p.idsiq_periodicidad=c.idsiq_periodicidad) ";
			<?php } else { ?>
			sql="SELECT c.idsiq_Ainstrumentoconfiguracion, c.nombre, c.mostrar_bienvenida, c.mostrar_despedida, ";
            sql+="c.fecha_inicio, c.fecha_fin, c.estado, c.secciones, '' as tipo, nombrecarrera, '' as periodicidad ";
            sql+="FROM siq_Ainstrumentoconfiguracion AS c ";
			<?php } ?>
            sql+="left  join carrera as r on (r.codigocarrera=c.codigocarrera) ";
           // alert(sql);
            oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../../server_processing.php?active=true&table=siq_Ainstrumentoconfiguracion&sql="+sql+"&wh=c.codigoestado&tableNickname=c&join=true&cwh=cat_ins IN (\'<?php echo $_REQUEST["cat_ins"]; ?>\')",   
                "aoColumns": [
                { "sTitle": "Nombre" },
                { "sTitle": "Bienvenida", "bVisible":false },
                { "sTitle": "Despedida", "bVisible":false },
                { "sTitle": "Fecha Inicio"},
                { "sTitle": "Fecha Expiración"},
                { "sTitle": "Estado", "bVisible":false},
                { "sTitle": "Secciones", "bVisible":false  },
                { "sTitle": "Tipo"},
                { "sTitle": "Programa"},
                { "sTitle": "periodicidad"}
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
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                }
             } );
        
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {updateForm2('instrumento_reporte.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>'); }               
            } );
            /*$('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {deleteForm("Ainstrumentoconfiguracion");}                
            } );
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteForm("Ainstrumentoconfiguracion");}                
            } );*/
      } );
        </script>
    
<?php    writeFooter();
        ?>  