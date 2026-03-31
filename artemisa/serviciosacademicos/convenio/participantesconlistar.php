<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
?>
<html>
    <head>
          <title>Participantes</title>
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
                url: 'lookupdocente.php',
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
                    data: 'idsiq_participante='+id+"&entity=participante",              
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
            if($("#apellidoparticipante").val()=='') {
                alert("El Apellido del Participante no debe estar vacio");
                $("#apellidoparticipante").focus();
               return false;
            }else if($("#nombreparticipante").val()==''){
                alert("El Nombre del Participante no debe estar vacio");
                $("#nombreparticipante").focus();
               return false;
            }else if($("#numerodocumento").val()==''){
                alert("El Numero de documento del Participante no debe estar vacio");
                $("#numerodocumento").focus();
               return false;
            }else if($("#emailparticipante").val()!='' && ($("#emailparticipante").val().indexOf('@', 0) == -1 || $("#emailparticipante").val().indexOf('.', 0) == -1)) {  
                    alert("La direccion e-mail parece incorrecta"); 
                    $("#emailparticipante").focus();
                    return false;  
             }else{
                return true;
           } 
        }
        function showPanel(panelID,id){
            $panel = $('#'+panelID);
            $.ajax({
                url: "createparticcon.php",
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
                        height: 500,
			width: 980,
			modal: true,
                        show: "blind",
			hide: "explode",
                        buttons:{
                             Cancelar: function() {
                                $( this ).dialog( "close" );
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
                "sAjaxSource": "server_processing.php?table=siq_participante&wh=idsiq_participante&vwh=",                
                "aoColumns": [              
                  {"sTitle": "Apellido"},
                  {"sTitle": "Nombre"},
                  {"sTitle": "tipodocumento", "bVisible":false },
                  {"sTitle": "Documento"},
                  {"sTitle": "Email", "bVisible":false },
                  {"sTitle": "Fecha de Nacimiento", "bVisible":false },
                  {"sTitle": "Direccion", "bVisible":false },
                  {"sTitle": "Telefono", "bVisible":false },
                  {"sTitle": "profesión" },
                  {"sTitle": "País Nacimiento", "bVisible":false },
                  {"sTitle": "departamento Nacimiento", "bVisible":false },
                  {"sTitle": "Ciudad Nacimiento", "bVisible":false },
                  {"sTitle": "Estado Civil", "bVisible":false },
                  {"sTitle": "Ciudad Recidencia", "bVisible":false },
                  {"sTitle": "Cargo" },
                  {"sTitle": "Genero", "bVisible":false },
                  {"sTitle": "estado", "bVisible":false }
                 
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
            <div class="full_width big">Participantes</div>
            <h1>Administraci&oacute;n de Participantes</h1>
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
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Tipo Documento</th>
                            <th>Documento</th>
                            <th>Email</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Pais Nacimiento</th>
                            <th>departamento Nacimiento</th>
                            <th>Ciudad Nacimiento</th>
                            <th>Estado Civil</th>
                            <th>Direccion</th>
                            <th>Ciudad Recidencia</th>
                            <th>Telefono</th>
                            <th>Genero</th>
                            <th>estado</th>
                            <th>profesión</th>
                            <th>cargo</th>
                            
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