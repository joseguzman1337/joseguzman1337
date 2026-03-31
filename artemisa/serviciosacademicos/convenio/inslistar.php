<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
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
        <title>Instituciones de convenios</title>
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
                    data: 'idsiq_institucionconvenio='+id+"&entity=institucionconvenio",              
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
            //var id = this.id;
            if(aSelected.length==1){
                var id = aSelected[0];
                //console.log(aSelected);
                showPanel('dialog',id);
            }else{
                return false;
            }
            
            //$.post('process.php',$('#form_test').serialize(),function(data) {
            //    $('.result').html(data);
            //});
        }

        
   
        /* Formating function for row details */
        function validar(){
        
	    /*
            Validacion de numero con Jquery
            !(Math.floor($("#identificacion").val()) == $("#identificacion").val() && $.isNumeric($("#identificacion").val()))            
            */
        
	    var patron = /^[0-9]{1}[0-9]*\-?[0-9]+$/;        
	    var patDocumento= /^[0-9a-zA-Z]{1}[0-9a-zA-Z]*\-?[0-9a-zA-Z]+$/;
	    var patCiudadExp= /^[^0-9]+$/;
	    
            if($("#nombreinstitucion").val()=='') {
                alert("El nombre de la institucion no debe estar vacio");
                $("#nombreinstitucion").focus();
                return false;
            }else if($("#email").val()!='' && ($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1)) {  
                    alert("La direccion e-mail del contacto aparece incorrecta"); 
                    $("#email").focus();
                    return false;  
            }else if($("#emailcontactodos").val()!='' && ($("#emailcontactodos").val().indexOf('@', 0) == -1 || $("#emailcontactodos").val().indexOf('.', 0) == -1)) {  
                    alert("La segunda direccion e-mail del contacto aparece incorrecta"); 
                    $("#emailcontactodos").focus();
                    return false;  
            }else if($("#emailcontactobosque").val()!='' && ($("#emailcontactobosque").val().indexOf('@', 0) == -1 || $("#emailcontactobosque").val().indexOf('.', 0) == -1)) {  
                    alert("La direccion e-mail del contacto Universidad aparece incorrecta"); 
                    $("#emailcontactobosque").focus();
                    return false;  
            }else if($("#emailcontactobosquedos").val()!='' && ($("#emailcontactobosquedos").val().indexOf('@', 0) == -1 || $("#emailcontactobosquedos").val().indexOf('.', 0) == -1)) {  
                    alert("La segunda direccion e-mail del contacto Universidad aparece incorrecta"); 
                    $("#emailcontactobosquedos").focus();
                    return false;  
            }else if($("#emailrpresentante").val()!='' && ($("#emailrpresentante").val().indexOf('@', 0) == -1 || $("#emailrpresentante").val().indexOf('.', 0) == -1)) {  
                    alert("La direccion e-mail del representate aparece incorrecta"); 
                    $("#emailrpresentante").focus();
                    return false;  
            }
            else if($("#nit").val()!='' && !($("#nit").val().match(patron))) {  
                    alert("Por favor Revise el Numero del NIT"); 
                    $("#nit").focus();
                    return false;  
            }            
            else if($("#identificacion").val()!='' && !($("#identificacion").val().match(patDocumento))) {  
                    alert("Debe digitar una Identificacion Valida"); 
                    $("#identificacion").focus();
                    return false;  
            }
            else if($("#ciudadexpedicion").val()!='' && !($("#ciudadexpedicion").val().match(patCiudadExp))) {  
                    alert("Revise la Ciudad de Expedicion"); 
                    $("#ciudadexpedicion").focus(); 
                    return false;  
            }else{
                return true;
           } 
        }
        
        function showPanel(panelID,id){
            $panel = $('#'+panelID);
            $.ajax({
                url: "createinstitucion.php",
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
                        height: 380,
			width: 900,
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
        
        var sql;
        
        sql="SELECT s.idsiq_institucionconvenio,s.nombreinstitucion, s.nit, s.telefono, s.emailrpresentante, s.representantelegal, s.email FROM siq_institucionconvenio s";
        
            oTable = $('#example').dataTable({                
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../mgi/server_processing.php?active=true&table=siq_institucionconvenio&sql="+sql+"&tableNickname=s&wh=s.codigoestado",                
                /*"aoColumns": [              
                { "sTitle": "Nombre Instituci&oacute;n" },
                { "sTitle": "Nit"},                
                /*"DirecciÃ³n" } { "bVisible":    false },
                { "sTitle": "Telefono" },
                { "sTitle": "email" },
                /* "Nonmbre Institucion suscribe" { "bVisible":    false },
                { "sTitle": "representante legal" },
                /* "identificacion" } { "bVisible":    false },*/
                /* emailrepresentante     null                           
                ]*/
                 "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); 
                            var maxWidth = $('#container').width();  
                            this.width(maxWidth);
                        }
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
             } );
             */
             
             
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
            
            //$("#example_length").append("<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='institucionconvenio.php'><img src='../css/themes/smoothness/images/plus.gif'>&nbsp;Nuevo</a></label>");
            
        } );
        </script>
    </head>
    <body id="dt_example">
        <div id="container">
            <div class="full_width big">Convenios</div>
            <h1>Administraci&oacute;n de Instituci&oacute;n</h1>
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
                            <th>Nombre Instituci&oacute;n</th>
                            <th>Nit</th>                            
                            <th>Telefono</th>
                            <th>Email</th>                            
                            <th>Repesentante Legal</th>                            
                            <th>Email representante</th>
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