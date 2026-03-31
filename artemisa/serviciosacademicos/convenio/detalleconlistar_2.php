<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?
header( 'Content-type: text/html; charset=ISO-8859-1' );
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <title>Detalle - convenios</title>
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
                    data: 'idsiq_detalle_convenio='+id+"&entity=detalle_convenio",              
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

         
   
        /* Formating function for row details */
        function validar(){
            
            if($("#numeroconvenio").val()=='') {
                alert("El numero del convenio no debe estar vacio");
               return false;
            }else if($("#idsiq_estadoconvenio").val()==''){
                alert("El estado del convenio no debe estar vacio");
               return false;
            }else{
                return true;
           } 
        }
        function showPanel(panelID,id){
            $panel = $('#'+panelID);
            $.ajax({
                url: "createdetallecon_2.php?idsiq_convenio=<?php echo $_REQUEST['id'] ?>",
                type: "GET",
                dataType: "html",
                async: false,
                data: { "id": id
                },
                success: function (obj) {
                    // obj will contain the complete contents of the page requested
                    // use jquery to extract just the html inside the body tag                   
                    // then update the dialog contents with this and show it
                    $panel.html(obj);
                    $.fx.speeds._default = 1000;
                    $panel.dialog({
                        height: 590,
			width: 980,
			modal: true,
                        show: "blind",
			hide: "explode",
                        buttons:{
                             Cancelar: function() {
                                $(this).dialog( "close" );
                            },
                            Guardar: function() {
                                  // x=val();
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
            oTable = $('#example').dataTable({                
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "server_processing.php?table=siq_detalle_convenio&wh=idsiq_convenio&vwh=<?php echo $_REQUEST['id'] ?>",                
                "aoColumns": [              
                  {"sTitle": "# Convenio" },
                /*{"sTitle": "Clausula terminacion"}*/ { "bVisible":    false },                
                /*{"sTitle": "Objeto General Convenio"}*/ { "bVisible":    false },                
                  {"sTitle": "Fecha Renovacion"},
                  {"sTitle": "Fecha Fin Convenio"},
                /*{"sTitle": "Renovacion Automatica"}*/ { "bVisible":    false },
                  {"sTitle": "Fecha Terminacion"},
                /*{"sTitle": "Tiene Poliza"}*/ { "bVisible":    false },
                /*{"sTitle": "Afilacion ARP"}*/ { "bVisible":    false },
                /*{"sTitle": "Afiliacion"}*/ { "bVisible":    false },
                /*{"sTitle": "Codigo Nies"}*/ { "bVisible":    false },
                  {"sTitle": "Nombre Programa"},
                /*{"sTitle": "Numero Reg Calificado"}*/ { "bVisible":    false },
                  {"sTitle": "Nivel"},
                  {"sTitle": "Año Programa"},
               /* {"sTitle": "Ciudad"}*/ { "bVisible":    false },
                  { "sTitle": "Codigo Periodo"},
                /*{"sTitle": "Convenio"}*/ { "bVisible":    false },
                /*{"sTitle": "Estado Convenio"}*/ { "bVisible":    false }
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
            <div class="full_width big">Convenios</div>
            <h1>Administraci&oacute;n Detalle de Convenio</h1>
            <div class="demo_jui">
                <div class="DTTT_container">
                <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text">
                <span>Nuevo</span>
                </button>
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Editar</span>
                </button>
                <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Eliminar</span>
                </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
                    <thead>
                        <tr>                            
                            <th> Numero Convenio </th>
                            <th> Clausula terminacion </th>
                            <th> Objeto General Convenio </th>
                            <th> Fecha Renovacion</th>
                            <th> Fecha Fin Convenio</th>
                            <th> Renovacion Automatica</th>
                            <th> Fecha Terminacion</th>
                            <th> Tiene Poliza</th>
                            <th> Afilacion ARP</th>
                            <th> Afiliacion</th>
                            <th> Codigo Nies</th>
                            <th> Nombre Programa</th>
                            <th> Numero Reg Calificado</th>
                            <th> Nivel</th>
                            <th> Año Programa</th>
                            <th> Ciudad</th>
                            <th> Codigo Periodo</th>
                            <th> Convenio</th>
                            <th> Estado Convenio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!tr class="gradeX" esta clase es rosado-->
                        <!tr class="gradeC" esta clase es Asul-->
                        <!tr class="gradeU"-->
                    </tbody>
                </table>
            </div>
        </div>
        <div id="dialog">
        </div>
    </body>
</html>
