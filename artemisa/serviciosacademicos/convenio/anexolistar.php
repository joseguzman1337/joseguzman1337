<?php

session_start();


    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>

<html>
    <head>
        <title>Lista de Convenios</title>
        <style type="text/css" title="currentStyle">
                @import "../css/demo_page.css";
                @import "../css/demo_table_jui.css";
                @import "../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
        </style>
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>        
        <script type="text/javascript" src="../js/jquery.form.js"></script>
        <script type="text/javascript">
        var oTable;
        var aSelected = [];
       
        function sendForm(){
           // $('#form_test').ajaxForm();
            $('#form_test').submit();
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
                    data: 'idsiq_anexo='+id+'&entity=anexo',
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
            
        function showPanel(panelID,id){
            $panel = $('#'+panelID);            
            $.ajax({
                url: "createanexo.php",
                type: "POST",
                dataType: "html",
                enctype: 'multipart/form-data',
                async: false,
                data: { "id": id, "idconvenio" : <?php echo $_REQUEST['id']?>},
                success: function (obj) {
                    // obj will contain the complete contents of the page requested
                    // use jquery to extract just the html inside the body tag                   
                    // then update the dialog contents with this and show it
                    $panel.html(obj);
                    $.fx.speeds._default = 1000;
                    $panel.dialog({
                        height: 450,
			width: 880,
			modal: true,
                        show: "blind",
			hide: "explode",
                        buttons:{        
                            Cancelar: function() {
                                $(this).dialog( "close" );
                            },
                            Guardar: function() {
                                if(confirm('Esta Seguro de Realizar esta accion')){
                                    sendForm();                                               
                                    //alert('Proceso realizado satisfactoriamente');
                                    //$( this ).dialog( "close" );
                                    //location.reload();
                                }else{
                                    $( this ).dialog( "close" );
                                }
                            } 
                        }
                    }                    
                );
                }
            });
        }       
         

/* Formating function for row details */
        function fnFormatDetails ( oObj ){            
            var img = "Note.png";
            var extension = oObj.aData[4].substr( (oObj.aData[4].lastIndexOf('.') +1) );
            switch(extension) {
            case 'jpg':
            case 'png':
            case 'docx':            
                img = 'img/Word.png';
                break;
            case 'doc':            
                img = 'img/Word.png';
                break;
            case 'ppt':
                img = 'img/PowerPoint.png';
                break;
            case 'xls':            
                img = 'img/Excel.png';
            break;
            case 'xlsx':
                img = 'img/Excel.png';
            break;
            case 'pdf':            
                img = 'img/pdf.png';
            break;            
            }
            
            //alert(res);
            return '<a href=\"./' + oObj.aData[4] + '\" title="Ver archivo"><img src='+img+'  height="42" width="42" title="Ver archivo"></a>';
            //return sOut;
        }
        $(document).ready(function() {            
            //this.src = "/img/ajax-loader.gif";
            //oTable.fnOpen( nTr, fnFormatDetails(nTr), 'details' );
            
            var sql;
            
            sql="SELECT s.idsiq_anexo,s.anio,s.observacion,s.nombrearchivo,t.nombretipoanexo,s.rutadelarchivo FROM siq_anexo s ";
            sql+='inner join siq_tipoanexo t on t.idsiq_tipoanexo = s.idsiq_tipoanexo and s.idsiq_convenio=<?echo $_REQUEST['id']?> ';
            
            oTable = $('#example').dataTable({                
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../mgi/server_processing.php?active=true&table=siq_anexo&sql="+sql+"&wh=s.codigoestado&tableNickname=s&join=true",
                "aoColumns": [
                {"sTitle": "A&ntilde;o"},
                {"sTitle": "Observaci&oacute;n" },                
                {"sTitle": "Nombre Del Archivo"},
                {"sTitle": "Tipo Anexo"},
                {"sTitle": "Ver Archivo", "fnRender": function (oObj) {                                
                                return fnFormatDetails(oObj);
                            }}                                
                ]
            });
            /* Click event handler */
             /*$('#example tbody tr').live('click', function () {
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
                //propertiees();
            } );
            
            $('#ToolTables_example_1').click( function () {  
                updateForm();
                //propertiees();
            } );
            $('#ToolTables_example_2').click( function () {  
               // alert('hola');
                deleteForm();
                //propertiees();
            } );

            
           });
        </script>
    </head>
    <body id="dt_example">
        <div id="container">
            <div class="full_width big">Convenios</div>
            <h1>Documentacion Anexa del convenio</h1>
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
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Nombre del Convenio</th>
                            <th>pais</th>
                            <th>codigoconvenio</th>
                            <th>Duracion del convenio</th>
                            <th>Fecha Inicio</th>                            
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