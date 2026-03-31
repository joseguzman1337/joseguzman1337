<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>

<html>
    <head>
        <title>Detalle - convenios</title>
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
                 $("#numeroconvenio").focus();
               return false;
            }else if($("#maximoparticipantes").val()==''){
                alert("El número maximo de particiopantes no debe estar vacio");
                 $("#maximoparticipantes").focus();
               return false;
            }else if($("#codigomodalidadacademica").val()==''){
                alert("La modalidad economica no debe estar vacio");
                 $("#codigomodalidadacademica").focus();
               return false;
            }else if($("#codigomodalidadacademica option:selected").val()=='200' && $("#codigofacultad").val()==''){
                        alert("La facultad no debe estar vacia");
                        $("#codigofacultad").focus();
                       return false;
            }else if($("#codigomodalidadacademica option:selected").val()=='200' && $("#codigocarrera").val()==''){
                        alert("La carrera no debe estar vacia");
                        $("#codigocarrerad").focus();
                         return false;
             }else if($("#codigomodalidadacademica option:selected").val()=='300' && $("#idsiq_especialidad").val()==''){
                        alert("La especialidad no debe estar vacio");
                        $("#idsiq_especialidad").focus();
                        return false;
            }else if($("#fechainicio").val()==''){
                alert("La fecha de inicio no debe estar vacio");
                 $("#fechainicio").focus();
               return false;
            }else if($("#fechafin").val()==''){
                alert("La fecha fin no debe estar vacio");
                 $("#fechafin").focus();
               return false;
            }else if($("#codigoperiodo").val()==''){
                alert("El periodo academico no debe estar vacio");
                 $("#codigoperiodo").focus();
               return false;
            }else{
                return true;
           } 
        }        
        
        function showPanel(panelID,id){
            $panel = $('#'+panelID);
            $.ajax({
                url: "createdetallecon.php?idsiq_convenio=<?php echo $_REQUEST['id'] ?>",
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
            var sql;
            sql="SELECT g.idsiq_detalle_convenio,c.nombreconvenio,g.numeroconvenio,g.fechainicio,g.fechafin,i.nombreinstitucion,g.dato_carrera, CASE WHEN DATEDIFF(g.fechafin, NOW()) BETWEEN 0 and 90 THEN 'POR VENCER' WHEN NOW() BETWEEN g.fechainicio and g.fechafin THEN 'ACTIVO' WHEN NOW() > g.fechafin THEN 'VENCIDO' end as situacion FROM siq_detalle_convenio g ";
            sql+='inner join siq_convenio c on c.idsiq_convenio = g.idsiq_convenio ';
            sql+='inner join siq_institucionconvenio i on i.idsiq_institucionconvenio = c.idsiq_institucionconvenio and g.idsiq_convenio=<?echo $_REQUEST['id']?> ';
            //sql='SELECT g.idsiq_grupoconvenio,  g.codigogrupo, g.numeroparticipante,dc.apellidodocente,dc.nombredocente, g.idsiq_detalle_convenio, c.nombreconvenio, d.numeroconvenio,  g.descripcion FROM siq_grupoconvenio as g  inner join siq_detalle_convenio as d on (g.idsiq_detalle_convenio=d.idsiq_detalle_convenio) inner join siq_convenio as c on (d.idsiq_convenio=c.idsiq_convenio) inner join docente as dc on (dc.iddocente=g.iddocente) ';
            
            oTable = $('#example').dataTable({                
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,
                "fnServerParams": function (aoData) {
		    aoData.push( { "name": "active", "value": "true" } );
			aoData.push( { "name": "table", "value": "siq_detalle_convenio" } );
			aoData.push( { "name": "sql", "value": sql } );
			aoData.push( { "name": "wh", "value":"g.codigoestado" } );
			aoData.push( { "name": "tableNickname", "value":"g" } );
			aoData.push( { "name": "join", "value":"true" } );
			//aoData.push( { "name": "IndexColumn", "value":"idsiq_detalle_convenio" } );
		},                
                "sAjaxSource": "../mgi/server_processing.php",
                "sServerMethod": 'POST',
                "aoColumns": [           
                  {"sTitle": "Convenio" },                
                  {"sTitle": "# Convenio"},
                  {"sTitle": "Fecha Inicio"},                
                  {"sTitle": "Fecha Fin"},
                  {"sTitle": "Institución"},
                  {"sTitle": "Especialidad/Carrera"},
                  {"sTitle": "Estado Registro"}
                  
                ]
            });
            
            /* Click event handler */
          /*$('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).children().hasClass('dataTables_empty') && index === -1  ) {
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
             } );*/
             
             
             $('#example tbody tr').live('click', function () {
             //console.log(this.id);
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).children().hasClass('dataTables_empty') && index === -1  ) {
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
                            <th> Renovacion Automatica</th>     
                            <th> Renovacion Automatica</th>     
                            <th> Renovacion Automatica</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr><td></td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <input type="submit" name="regresar" value="Regresar" onclick="window.location.href='conveniolistar.php'">
        </div>
        <div id="dialog">
        
        </div>
    </body>
</html>