<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <title>Grupo Materia</title>
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
                    data: 'idsiq_grupo_materia='+id+'&entity=grupo_materia',
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
            if($("#nombre").val()=='') {
                alert("El nombre no debe estar vacio");
               return false;
            }else if($("#codigo").val()==''){
                alert("El codigo no debe estar vacia");
               return false;
            }else{
                return true;
           } 
        }
        /* Formating function for row details */
            
        function showPanel(panelID,id){
            
            $panel = $('#'+panelID);
            $.ajax({
                url: "create_grupo_materia.php",
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
        var sql
        sql='SELECT m.idsiq_grupo_materia, m.nombre, m.codigo, e.nombreestado FROM sala.siq_grupo_materia as m inner join estado as e on (m.codigoestado=e.codigoestado)';
            oTable = $('#example').dataTable({                
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "server_processing.php?table=siq_grupo_materia&sql="+sql+"&wh=&vwh=",   
                "aoColumns": [
                { "sTitle": "Nombre"},
                { "sTitle": "Grupo" },
                { "sTitle": "Estado" },
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
    </head>
    <body id="dt_example">
        <div id="container">
            <div class="full_width big">Grupo - Materia</div>
            <h1>Administraci&oacute;n de Grupos Materia</h1>
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
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>cod</th>  
                            <th>nombre</th> 
                            <th>grupo</th> 
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