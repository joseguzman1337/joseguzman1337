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
        <script type="text/javascript">
        var oTable;
        var aSelected = [];
       
       function traercontenido(){           
           $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'lookupInstitucion.php',
                dataType: "html",
                data: "id=sdsds",                
                success:function(data){                    
                    $('#searh').html(data);},
                error: function(data,error){}
            });           
       }
       
       
       
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
                    data: 'idsiq_detalle_participante='+id+'&entity=detalle_participante',
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
        
         function validar(){
            
            if($("#idsiq_participante").val()=='') {
                alert("El Participante no debe estar vacio");
                $("#nombreparticipante").focus();
               return false;
            }else{
                return true;
           } 
        }
        
        /* Formating function for row details */
            
        function showPanel(panelID,id){
            
            $panel = $('#'+panelID);
            $.ajax({
                url: "createpartdetalle.php?idsiq_detalle_convenio=<?php echo $_REQUEST['id'] ?>",
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
                        height: 230,
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
            sql='SELECT dp.idsiq_detalle_participante, dp.idsiq_detalle_convenio as `dp.idsiq_detalle_convenio`, dc.numeroconvenio as `dc.numeroconvenio`, dp.idsiq_participante as `dp.idsiq_participante`, p.apellidoparticipante as `p.apellidoparticipante`, p.nombreparticipante as `p.nombreparticipante` FROM siq_detalle_participante as dp inner join siq_detalle_convenio as dc on (dp.idsiq_detalle_convenio=dc.idsiq_detalle_convenio) inner join siq_participante as p on (p.idsiq_participante=dp.idsiq_participante) ';
            //alert("server_processing.php?table=siq_detalle_participante&sql="+sql+"&wh=dp.idsiq_detalle_convenio&vwh=<?php echo $_REQUEST['id'] ?>");
            oTable = $('#example').dataTable({                
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "server_processing.php?table=siq_detalle_participante&sql="+sql+"&wh=dp.idsiq_detalle_convenio&vwh=<?php echo $_REQUEST['id'] ?>",   
                "aoColumns": [
                { "sTitle": "Detalle  Convenio" },
                { "sTitle": "Numero  Convenio" },
                { "sTitle": "Participante" , "bVisible": false },
                { "sTitle": "Apellido" },
                { "sTitle": "Nombre" }             
                ]
            });
            /* Click event handler */
            $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                if ( index === -1 ) {                
                    aSelected.push( id );               
                } else {
                    aSelected.splice( index, 1 );                 
                }
                $(this).toggleClass('row_selected');
                
                if(aSelected.length == 1){
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');            
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                }else{
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
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
             <div class="demo_jui">
                <div class="DTTT_container">
                <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text">
                <span>Agregar</span>
                </button>
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Editar</span>
                </button>
                <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Desvincular</span>
                </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>codigoconvenio</th>  
                            <th>Numero Convenio</th>  
                            <th>Participnate</th>  
                            <th>Apellido</th>  
                            <th>Nombre</th>  
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