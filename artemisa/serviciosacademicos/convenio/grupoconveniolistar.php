<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>
<html>
    <head>
         <title>Lista de Participantes Detalle Convenio</title>
        <style type="text/css" title="currentStyle">
                @import "../css/demo_page.css";
                @import "../css/demo_table_jui.css";
                @import "../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
        </style>
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>        
        <script type="text/javascript" language="javascript" src="../js/jquery.numeric.js"></script>   
        <script type="text/javascript">
        var oTable;
        var aSelected = [];
    
        function sendForm(){
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'process.php',
                data: $('#form_test').serialize(),                
                success:function(data){$('.result').html(data);},
                error: function(data,error){}
            });            
        }
        function deleteForm(){
            if(confirm('Esta seguro de eliminar este registro?')){              
                if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);                
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process.php?delete=true',
                    data: 'idsiq_grupoconvenio='+id+'&entity=grupoconvenio',
                    success:function(data){$('.result').html(data);},
                    error: function(data,error){}
                }); 
                }else{
                    return false;
                }
                alert('Registro eliminado satisfactoriamente!');
                location.reload();
            }
        }
        function updateForm(){            
            if(aSelected.length==1){
                var id = aSelected[0];
                showPanel('dialog',id);
            }else{
                return false;
            }
        }
        function programset(){
            if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);
                window.location.href= "cortelistar.php?idsiq_grupoconvenio="+id;
            }else{
                return false;
            }
        }
        function addestudent(){            
            if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);
                window.location.href= "grupo_asignar.php?idsiq_grupoconvenio="+id;
            }else{
                return false;
            }
        }
        function califset(){            
            if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);
                window.location.href= "grupo_calificar.php?idsiq_grupoconvenio="+id;
            }else{
                return false;
            }
        }
        
        
        
          function validar(){
            if($("#codigogrupo").val()=='') {
                alert("El codigo del grupo no debe estar vacio");
                $("#codigogrupo").focus();
               return false;
            }else if($("#numeroparticipante").val()==''){
                alert("El Numero de participantes no debe estar vacia");
                $("#numeroparticipante").focus();
               return false;
            }else if($("#iddocente").val()==''){
                alert("El docente no debe estar vacia");
                $("#nombredocente").focus();
               return false;
            }else{
                return true;
           } 
        }
        /* Formating function for row details */
            
        function showPanel(panelID,id){
            
            $panel = $('#'+panelID);
            $.ajax({
                url: "creategrupo_convenio.php?idsiq_detalle_convenio=<?php echo $_REQUEST['idsiq_detalle_convenio']; ?>",
                type: "GET",
                dataType: "html",
                async: false,
                data: { "id": id},
                success: function (obj) {
                    // obj will contain the complete contents of the page requested
                    // use jquery to extract just the html inside the body tag                   
                    // then update the dialog contents with this and show it
                    $panel.html(obj);
                    $.fx.speeds._default = 1000;
                    $panel.dialog({
                        height: 350,
			width: 850,
			modal: true,
                        show: "blind",
			hide: "explode",
                        buttons:{    
                            Cancelar: function() {
                                $(this).dialog( "close" );
                            },
                            Guardar: function() {
                              if(validar()){  
                                if(confirm('Esta Seguro de Realizar esta accion')){
                                    sendForm();
                                    alert('Proceso realizado satisfactoriamente');
                                    $( this ).dialog( "close" );
                                    location.reload();
                                }else{
                                    $( this ).dialog( "close" );
                                }
                               }
                            } 
                        }
                    }                    
                );
                }
            });
        }
            
        $(document).ready(function() {  
            var sql;
            sql='SELECT g.idsiq_grupoconvenio,  g.codigogrupo as `g.codigogrupo`, g.numeroparticipante as `g.numeroparticipante` ,dc.apellidodocente as `dc.apellidodocente`,dc.nombredocente as `dc.nombredocente `, g.idsiq_detalle_convenio as `g.idsiq_detalle_convenio`, c.nombreconvenio as `c.nombreconvenio`, d.numeroconvenio as `d.numeroconvenio`,  g.descripcion as `g.descripcion` FROM siq_grupoconvenio as g  inner join siq_detalle_convenio as d on (g.idsiq_detalle_convenio=d.idsiq_detalle_convenio) inner join siq_convenio as c on (d.idsiq_convenio=c.idsiq_convenio) inner join docente as dc on (dc.iddocente=g.iddocente) ';
           // alert("server_processing.php?table=siq_grupoconvenio&sql="+sql+"&wh=g.codestado&vwh=");
            oTable = $('#example').dataTable({                
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "server_processing.php?table=siq_grupoconvenio&sql="+sql+"&wh=g.idsiq_detalle_convenio&vwh=<?php echo $_REQUEST['idsiq_detalle_convenio']; ?>",   
                "aoColumns": [
                { "sTitle": "Cod Grupo"},
                { "sTitle": "# Max Participantes" },
                { "sTitle": "Apellido Docente" },
                { "sTitle": "Nombre Docente" },
                { "sTitle": "Detalle Convenio" , "bVisible": false},
                { "sTitle": "Convenio" },
                { "sTitle": "# Convenio" },
                { "sTitle": "Descripcion", "bVisible": false }
                ]
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
                    $("#ToolTables_example_4").removeClass('DTTT_disabled');
                    $("#ToolTables_example_5").removeClass('DTTT_disabled');
                }
             } );
            
            
            $('#ToolTables_example_0').click( function () { 
                showPanel('dialog','');  
                //Popup2();
            } );
            
            $('#ToolTables_example_1').click( function () {  
                updateForm();                
            } );
            $('#ToolTables_example_2').click( function () {  
                deleteForm();                
            } );
            $('#ToolTables_example_3').click( function () {  
                addestudent();                
            } );
            $('#ToolTables_example_4').click( function () {  
                programset();                
            } );
            $('#ToolTables_example_5').click( function () {  
                califset();                
            } );
      } );
        </script>
                <style>
        .ui-state-default {
                  font: 80%/1.45em "Lucida Grande",Verdana,Arial,Helvetica,sans-serif;
        }
                .odd {
                 font: 80%/1.45em "Lucida Grande",Verdana,Arial,Helvetica,sans-serif;
        }
                .even {
                  font: 80%/1.45em "Lucida Grande",Verdana,Arial,Helvetica,sans-serif;
        }
            
        </style>
    </head>
    <body id="dt_example">
        <div id="container">
            <div class="full_width big">Grupo - Convenio</div>
            <h1>Administraci&oacute;n de Grupos Convenios</h1>
             <div class="demo_jui">
                <div class="DTTT_container">
                <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text">
                <span>Agregar</span>
                </button>
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Editar</span>
                </button>
                <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Eliminar</span>
                </button>
                <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Estudiantes</span>
                </button>
                <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text DTTT_disabled">
                    <span>Programaci&oacute;n de Corte</span>
                </button>
                <button id="ToolTables_example_5" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>calificaci&oacute;n</span>
                </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Cod Grupo</th>  
                            <th>Max</th> 
                            <th>Apellido</th> 
                            <th>Docente</th>  
                            <th>Detalle</th>  
                            <th>Convenio</th>  
                            <th>Apellido</th>  
                            <th>N</th>  
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                </table>
            </div>
        </div>            
        <div id="dialog">
        </div>
    </body>
</html>