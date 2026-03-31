<?php
function writeForm($edit, $id="", $db) {
    $data = array();
    $action = "save";
    $utils = new Utils_monitoreo();
    $caract = array();
    if(!$edit){
        $factores = $utils->getActives($db,"nombre,idsiq_factor", "factor");
        $tipos = $utils->getActives($db,"nombre,idsiq_tipoIndicador", "tipoIndicador");
        $areas = $utils->getAreasIndicadores($db);
        $disc = $utils->getActives($db,"nombre,idsiq_discriminacionIndicador", "discriminacionIndicador","","ASC","siq_",true);
    } else {
        //$factores = $utils->getAll($db,"nombre,idsiq_factor", "factor");
        //$tipos = $utils->getAll($db,"nombre,idsiq_tipoIndicador", "tipoIndicador");
        $factores = $utils->getActives($db,"nombre,idsiq_factor", "factor");
        $tipos = $utils->getActives($db,"nombre,idsiq_tipoIndicador", "tipoIndicador");
        $areas = $utils->getAreasIndicadores($db,false);
        $action = "update";
        if($id!=""){    
            $data = $utils->getDataEntity("indicadorGenerico", $id);  
            //$area = $utils->getDataNonEntity($db,"nombre,id","Siqarea","id='".$data["area"]."'"); 
            $aspect = $utils->getDataEntity("aspecto", $data["idAspecto"]); 
            $caract = $utils->getDataEntity("caracteristica", $aspect["idCaracteristica"]);
        }
    }

?>
<div id="form"> 
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="entity" value="indicadorGenerico" />
        <input type="hidden" name="action" value="<?php echo $action; ?>" />            
        <?php
        if($edit&&$id!=""){
            echo '<input type="hidden" name="idsiq_indicadorGenerico" value="'.$id.'">';
        } else {
            echo '<input type="hidden" name="crearIndicadores" value="crearDetalles">';
        }
        ?>
        <span class="mandatory">* Son campos obligatorios</span>
        <fieldset>   
            <legend>Definición del Indicador</legend>
            <label for="nombre" class="grid-2-12">Nombre del Indicador: <span class="mandatory">(*)</span></label>
            <?php if($edit&&$id!=""){ ?>
                <textarea class="grid-5-12 required" name="nombre" id="nombre" title="Nombre del Indicador" tabindex="1" autocomplete="off"><?php if($edit){ echo $data['nombre']; } ?></textarea>
                <!--<input type="text"  class="grid-5-12 required" name="nombre" id="nombre" title="Nombre del Indicador" tabindex="1" autocomplete="off" value="<?php //if($edit){ echo $data['nombre']; } ?>" />-->
           <?php } else { ?>
                <textarea class="grid-5-12 required smaller" name="nombreGenerico" id="nombreGenerico" title="Nombre del Indicador" tabindex="1" autocomplete="off"></textarea>
                <!--<input type="text"  class="grid-5-12" name="nombreGenerico" id="nombreGenerico" title="Nombre del Indicador" tabindex="1" autocomplete="off" value="" />-->
                <input type="hidden"  class="grid-5-12 required" name="nombre" id="nombre" tabindex="1" autocomplete="off" value="" />
            <?php } ?>
            <input type="hidden" name="idGenerico" id="idGenerico" value="<?php if($edit){ echo $id; } ?>" />

            <label for="codigo" class="grid-2-12">Código:</label>
            <input type="text"  class="grid-5-12" minlength="2" name="codigo" id="codigo" title="codigo" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['codigo']; } ?>" />

            <label for="idArea" class="grid-2-12">Área del Indicador: <span class="mandatory">(*)</span></label>
            <?php  echo $areas->GetMenu2('area',$data['area'],false,false,1,'id="area" class="grid-5-12 required"'); ?>
            <!--<input type="text"  class="grid-5-12 required" minlength="2" name="idArea" id="idArea" title="Nombre del Área" maxlength="200" tabindex="1" autocomplete="off" value="<?php //echo $area["nombre"]; ?>"  />
            <input type="hidden" name="area" id="area" value="<?php //echo $data["area"]; ?>" />-->

            <label for="descripcion" class="grid-2-12">Descripción: </label>
            <textarea class="grid-5-12" name="descripcion" id="descripcion" maxlength="700" autocomplete="off"><?php if($edit){ echo $data['descripcion']; } ?></textarea>

            <label for="idTipo" class="grid-2-12">Tipo del Indicador: <span class="mandatory">(*)</span></label>
            <?php  echo $tipos->GetMenu2('idTipo',$data['idTipo'],false,false,1,'id="idTipo" class="grid-2-12 required"'); ?>
        </fieldset>
        <fieldset id="containerAutoComplete">   
            <legend>Información del Aspecto</legend>
            <label for="factor" class="grid-2-12">Factor:</label>
            <?php
            // idFactor es el nombre del select, el data es el que esta elegido de la lista, 
            //primer true que se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
            //el 1 es si es un listbox o un select, 
            echo $factores->GetMenu2('factor',$caract['idFactor'],true,false,1,'id="factor" class="grid-5-12" disabled="true"'); ?>


            <label for="nombre" class="grid-2-12">Característica:</label>
            <input type="text"  class="grid-9-12" minlength="2" name="caracteristica" id="caracteristica" title="Nombre de la Caracteristica" maxlength="200" tabindex="1" autocomplete="off" value="<?php echo $caract["nombre"]; ?>" disabled="true" />
            <input type="hidden" name="idCaracteristica" id="idCaracteristica" value="<?php echo $aspect["idCaracteristica"]; ?>" />

            <label for="nombre" class="grid-2-12">Aspecto a Evaluar: <span class="mandatory">(*)</span></label>
            <!--<input type="text"  class="grid-9-12 required" minlength="2" name="aspecto" id="aspecto" title="Nombre del Aspecto" maxlength="250" tabindex="1" autocomplete="off" value="<?php //echo $aspect["nombre"]; ?>"  />-->
            <textarea class="grid-9-12 required smaller" minlength="2" name="aspecto" id="aspecto" title="Nombre del Aspecto" tabindex="1" autocomplete="off"><?php echo $aspect["nombre"]; ?></textarea>
            <input type="hidden" name="idAspecto" id="idAspecto" value="<?php echo $data["idAspecto"]; ?>" />
        </fieldset> 
        <?php if(!$edit){ ?>
        <fieldset id="discriminacionesIndicador">   
            <legend>Discriminación de los Indicadores</legend>
            <input type="checkbox" name="discriminacion[]" value="1" /> <?php echo $disc["0"]["nombre"]; ?><br/><br/>
            <!--<input type="checkbox" name="discriminacion[]" value="2" id="dialogFacultades" /> <?php //echo $disc["1"]["nombre"]; ?> <button type="button" id="select-facultades" class="hidden">Editar facultades</button><br/><br/>-->
            <input type="checkbox" name="discriminacion[]" value="3" id="dialogCarreras" /> <?php echo $disc["1"]["nombre"]; ?> <button type="button" id="select-carreras" class="hidden">Editar programas</button> <button type="button" id="select-all-carreras" class="loading">Seleccionar todos los programas</button> <img class="hidden loading" style="position:relative;left:150px;top:2px" src="../../images/ajax-loader2.gif" />
        </fieldset>  
        <fieldset>   
            <legend>Detalle de los Indicadores</legend>            
            <label for="inexistente" id="labelInexistente" class="grid-2-12 hidden">¿Es soportado por un documento?: <span class="mandatory">(*)</span></label>
            <?php writeYesNoSelect("inexistente",$data['inexistente'],"hidden"); ?>

            <label for="es_objeto_analisis" class="grid-2-12">¿Tiene documento de análisis?: <span class="mandatory">(*)</span></label>
            <?php writeYesNoSelect("es_objeto_analisis",$data['es_objeto_analisis']); ?>

            <label for="tiene_anexo" class="grid-2-12">¿Tiene anexo?: <span class="mandatory">(*)</span></label>
            <?php writeYesNoSelect("tiene_anexo",$data['tiene_anexo']); ?>
        </fieldset>  

        <?php   //include("./dialogFacultades.php"); 
                include("./dialogCarreras.php");
            }
        ?>

        <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first loading" />
        <?php } else { ?><input type="submit" value="Registrar indicadores" class="first loading" /> <img class="hidden loading" style="position:relative;margin-left: 16.4%;left:50px;top:2px" src="../../images/ajax-loader2.gif" /> <?php } ?>
    </form>
</div>

<?php if($edit) { ?>
<script type="text/javascript">
    $(':submit').click(function(event) {
        event.preventDefault();
        var valido= validateForm("#form_test");     

        if(valido){   
            sendForm();
        }   
    });

    function sendForm(){
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process.php',
            data: $('#form_test').serialize(),                
            success:function(data){
                if (data.success == true){
                     alert("Se ha editado la definición de indicador con éxito.");
                     window.location.href="index.php";
                }
                else{                        
                    $('#msg-error').html('<p>' + data.message + '</p>');
                    $('#msg-error').addClass('msg-error');
                }
            },
            error: function(data,error,errorThrown){alert(error + errorThrown);}
        });            
    }

    $(document).ready(function() {

        $('#caracteristica').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "../searchs/lookForCaracteristicas.php",
                    dataType: "json",
                    data: {
                        term: request.term,
                        factor: $("#factor").val()
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.label,
                                value: item.value,
                                id: item.id,
                                idFactor: item.idFactor
                            }
                        }));
                    }
                });
            },
            minLength: 3,
            selectFirst: false,
            open: function(event, ui) {
                var maxWidth = $('#containerAutoComplete').width()-400;  
                var width = $(this).autocomplete("widget").width();
                if(width>maxWidth){
                    $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                }
            },
            select: function( event, ui ) {
                //alert(ui.item.id);
                $('#idCaracteristica').val(ui.item.id);
                $('#factor').val(ui.item.idFactor);
            }                
        });

        $('#aspecto').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "../searchs/lookForAspectos.php",
                    dataType: "json",
                    data: {
                        term: request.term,
                        caracteristica: ""
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.label,
                                value: item.value,
                                id: item.id,
                                idFactor: item.idFactor,
                                idCaracteristica: item.idCaracteristica,
                                caracteristica: item.caracteristica
                            }
                        }));
                    }
                });
            },
            minLength: 3,
            selectFirst: false,
            open: function(event, ui) {
                var maxWidth = $('#containerAutoComplete').width()-400;  
                var width = $(this).autocomplete("widget").width();
                if(width>maxWidth){
                    $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                }
            },
            select: function( event, ui ) {
                //alert(ui.item.id);
                $('#caracteristica').val(ui.item.caracteristica);
                $('#idCaracteristica').val(ui.item.idCaracteristica);
                $('#factor').val(ui.item.idFactor);
                $('#idAspecto').val(ui.item.id);
            }                
        });

        $('#caracteristica').bind("change", function(){
            if($('#caracteristica').val()==""){
                $('#idCaracteristica').val("");
            }
        });

    });
  </script>

<?php } else { ?>
<script type="text/javascript">
    $(':submit').click(function(event) {
        $('#discriminacionesIndicador input').each(function() {
            $(name + ' select').removeClass('error');
        });

        event.preventDefault();
        var valido= validateForm("#form_test");

        var checked = $("#discriminacionesIndicador input:checked").length > 0;

        if(valido && checked){
            $("#form_test").append( "<div id='paraFacultades' class='hidden' >" );
            $("#form_test").append( "</div>" );
            $('#dialog-facultades input[name="facultad[]"]:checked').each(function() {
                    $("#paraFacultades").append( $(this) );
            });


            $("#form_test").append( "<div id='paraCarreras' class='hidden' >" );
            $("#form_test").append( "</div>" );
            $('#dialog-carreras input[name="carrera[]"]:checked').each(function() {
                    $("#paraCarreras").append( $(this) );
            });

            sendForm();
        } else if(!checked){                     
            //no se eligio ninguna discriminación, sin eso no se pueden crear los indicadores detalle
            var counter = 0;
            var counter2 = 0;
            $('#discriminacionesIndicador input').each(function() {
                if(!$(this).attr('disabled')){
                    $(this).addClass('error');
                    $(this).effect("pulsate", { times:3 }, 500);
                } else{
                    counter2 = counter2 + 1;
                }
                counter = counter + 1;
            });

            if(counter2==counter){
                alert("Ya se han generado todos los indicadores posibles de esta definición.");
            }
        } 
    });

    function sendForm(){
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process.php',
            data: $('#form_test').serialize(),                
            success:function(data){
                if (data.success == true){
                     alert("Se ha creado el indicador con éxito.");
                     window.location.href="index.php";
                }
                else{                        
                    $('#msg-error').html('<p>' + data.message + '</p>');
                    $('#msg-error').addClass('msg-error');
                }
            },
            error: function(data,error,errorThrown){alert(error + errorThrown);}
        });            
    }
                
    $(document).ready(function() {

        $('#nombreGenerico').autocomplete({
            source: function( request, response ) {
                $('#nombre').val(request.term);
                //alert(request.toSource());
                $.ajax({
                    url: "../searchs/lookForIndicadoresGenericos.php",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.label,
                                value: item.value,
                                id: item.id,                                            
                                descripcion: item.descripcion,                         
                                codigo: item.codigo,
                                area: item.area,
                                //idArea: item.idArea,
                                aspecto: item.aspecto,
                                idAspecto: item.idAspecto,
                                institucional: item.institucional,
                                idTipo: item.idTipo
                            }
                        }));
                    }
                });
            },
            minLength: 3,
            selectFirst: false,
            open: function(event, ui) {
                var maxWidth = $('#containerAutoComplete').width()-400;  
                var width = $(this).autocomplete("widget").width();
                if(width>maxWidth){
                    $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                }
            },
            select: function( event, ui ) {
                //alert(ui.item.id);
                $('#idGenerico').val(ui.item.id);
                $('#descripcion').val(ui.item.descripcion);
                $('#codigo').val(ui.item.codigo);
                //$('#idArea').val(ui.item.idArea);
                $('#area').val(ui.item.area);
                $('#idTipo').val(ui.item.idTipo);
                checkFieldInexistente();
                $('#aspecto').val(ui.item.aspecto);
                $('#idAspecto').val(ui.item.idAspecto);
                //Para lidiar con si ya esta creado el institucional o no
                if(ui.item.institucional){                    
                    //$('#discriminacionesIndicador input[name="discriminacion[]"][value="1"]').attr('checked','checked');
                    $('#discriminacionesIndicador input[name="discriminacion[]"][value="1"]').attr('disabled', 'disabled');
                } else{
                    //$('#discriminacionesIndicador input[name="discriminacion[]"][value="1"]').removeAttr('checked');
                    $('#discriminacionesIndicador input[name="discriminacion[]"][value="1"]').removeAttr('disabled');
                }
                //updateFacultades();
                updateCarreras();
            }                
        });


        $('#caracteristica').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "../searchs/lookForCaracteristicas.php",
                    dataType: "json",
                    data: {
                        term: request.term,
                        factor: $("#factor").val()
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.label,
                                value: item.value,
                                id: item.id,
                                idFactor: item.idFactor
                            }
                        }));
                    }
                });
            },
            minLength: 3,
            selectFirst: false,
            open: function(event, ui) {
                var maxWidth = $('#containerAutoComplete').width()-400;  
                var width = $(this).autocomplete("widget").width();
                if(width>maxWidth){
                    $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                }
            },
            select: function( event, ui ) {
                //alert(ui.item.id);
                $('#idCaracteristica').val(ui.item.id);
                $('#factor').val(ui.item.idFactor);
            }                
        });

        $('#aspecto').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "../searchs/lookForAspectos.php",
                    dataType: "json",
                    data: {
                        term: request.term,
                        caracteristica: $("#idCaracteristica").val()
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.label,
                                value: item.value,
                                id: item.id,
                                idFactor: item.idFactor,
                                idCaracteristica: item.idCaracteristica,
                                caracteristica: item.caracteristica
                            }
                        }));
                    }
                });
            },
            minLength: 3,
            selectFirst: false,
            open: function(event, ui) {
                var maxWidth = $('#containerAutoComplete').width()-400;  
                var width = $(this).autocomplete("widget").width();
                if(width>maxWidth){
                    $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                }
            },
            select: function( event, ui ) {
                //alert(ui.item.id);
                $('#caracteristica').val(ui.item.caracteristica);
                $('#idCaracteristica').val(ui.item.idCaracteristica);
                $('#factor').val(ui.item.idFactor);
                $('#idAspecto').val(ui.item.id);
            }                
        });

    });
                
    //Aparece el campo de inexistente solo si es numerico
    $('#idTipo').bind("change", function(){
        //checkFieldInexistente();
    });

    $('#nombreGenerico').bind("change keyup input", function(){
        if($('#nombreGenerico').val()==""){
            $('#nombre').val("");
            $('#idGenerico').val("");
            $('#descripcion').val("");
            $('#discriminacionesIndicador input[name="discriminacion[]"][value="1"]').removeAttr('disabled');
            //updateFacultades();
            updateCarreras();
        } 
    });

    $('#nombreGenerico').bind("keyup input", function(){
        if($('#nombreGenerico').val()==""){
            $('#nombre').val("");
            $('#idGenerico').val("");
            $('#descripcion').val("");
            $('#discriminacionesIndicador input[name="discriminacion[]"][value="1"]').removeAttr('disabled');
            //updateFacultades();
            updateCarreras();
        } else {
            $('#nombre').val($('#nombreGenerico').val());                        
            $('#idGenerico').val("");
            $('#descripcion').val("");
            $('#discriminacionesIndicador input[name="discriminacion[]"][value="1"]').removeAttr('disabled');
        }
    });

    $('#caracteristica').bind("change", function(){
        if($('#caracteristica').val()==""){
            $('#idCaracteristica').val("");
        }
    });
                
    function updateFacultades(){  
        $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: "../searchs/lookForFacultadesIndicador.php",
                    data: {
                        indicador: $('#idGenerico').val()
                    },
                    success:function(data){ 
                        $("#dialog-facultades input:checkbox").removeAttr('disabled');
                        for (var i=0;i<data.length;i++)
                        {          
                            $("#dialog-facultades input:checkbox[value='"+data[i]["value"]+"']").removeAttr('checked');
                            $("#dialog-facultades input:checkbox[value='"+data[i]["value"]+"']").attr('disabled','disabled');                                        
                        }  
                        var checked = $("#dialog-facultades input:checked").length > 0;
                        if (!checked){
                            jQuery('#dialogFacultades').removeAttr('checked');
                            $("#select-facultades").addClass('hidden');
                        }
                    },
                    error: function(data,error){}
             }); 
    }
                
    function updateCarreras(){     
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: "../searchs/lookForCarrerasIndicador.php",
            data: {
                indicador: $('#idGenerico').val()
            },
            success:function(data){ 
                $("#dialog-carreras input:checkbox").removeAttr('disabled');
                if(data!=null){
                    for (var i=0;i<data.length;i++)
                    {          
                        //console.log(data[i]["modalidad"]);
                        $("#dialog-carreras input:checkbox[value='"+data[i]["value"]+"']").removeAttr('checked');
                        $("#dialog-carreras input:checkbox[value='"+data[i]["value"]+"']").attr('disabled','disabled');                                        
                        if ($("#modalidad-"+data[i]["modalidad"]).length > 0){
                            var contenido = $("#modalidad-"+data[i]["modalidad"]).html();
                            contenido = contenido.substring(contenido.indexOf("( ")+1,contenido.indexOf("programas"));
                            contenido = $.trim( contenido );

                            var cantidad = parseInt(contenido);
                            cantidad = cantidad - 1;
                            if(cantidad>0){
                                //los espacios son por si resulta el mismo número que el id de modalidad
                                $("#modalidad-"+data[i]["modalidad"]).html($("#modalidad-"+data[i]["modalidad"]).html().replace(" "+contenido+" "," "+cantidad+" "));
                            } else {
                                //no quedan seleccionadas entonces me toca sacarla de aqui
                                updateSelect(data[i]["modalidad"]);
                            }

                        }
                    }
                    var checked = $("#dialog-carreras input:checked").length > 0;
                    if (!checked){
                        jQuery('#dialogCarreras').removeAttr('checked');
                        $("#select-carreras").addClass('hidden');
                    }
                }
            },
            error: function(data,error){}
        }); 

    }

    function checkFieldInexistente(){                   
        if($('#idTipo').val()==3){
            $("#labelInexistente").removeClass('hidden');
            $("#inexistente").removeClass('hidden');
        } else{   
            if(!$("#labelInexistente").hasClass('required')){
                $("#labelInexistente").addClass('hidden');
                $("#inexistente").addClass('hidden');
            }
        }
    }
                
            //dialogos para carreras y facultades. Me toco clavarle un doctype en el header porque si no se jodia la posicion en ie
    $(function() {
        $( "#dialog-facultades" ).dialog({
            autoOpen: false,
            height: 400,
            width: 500,
            modal: true,
            position: 'center',
            buttons: {
                "Finalizar selección": function() {                            
                        $( this ).dialog( "close" );
                },
                "Cancelar selección": function() {
                    //elimino todas las facultades seleccionadas
                    var checked = $("#dialog-facultades input:checked").length > 0;
                    if (checked){
                        $('#dialog-facultades input:checkbox').removeAttr('checked');

                        jQuery('#dialogFacultades').removeAttr('checked');
                        $("#select-facultades").addClass('hidden');
                    }
                    $( this ).dialog( "close" );
                }
            },
            close: function(event) {
                //allFields.val( "" ).removeClass( "ui-state-error" );                        
                //si esta vacio los checkbox => de-seleccionar facultades y quitar el boton de elegir facultades
                var checked = $("#dialog-facultades input:checked").length > 0;
                if (!checked){
                    jQuery('#dialogFacultades').removeAttr('checked');
                    $("#select-facultades").addClass('hidden');
                }
                //Para que no le haga submit automaticamente al form al cerrar el dialog
                event.preventDefault();
            }
        });

        $( "#dialogFacultades" ).click(function() {
            if($(this).is(":checked")){
                $("#select-facultades").removeClass('hidden');
                $( "#dialog-facultades" ).dialog( "open" );                            
            } else {
                $("#select-facultades").addClass('hidden');
            }
        });

        $( "#select-facultades" ).button().click(function() {
                $( "#dialog-facultades" ).dialog( "open" );                        
        });

        //dialogo carreras
        $( "#dialog-carreras" ).dialog({
            autoOpen: false,
            height: 400,
            width: 800,
            modal: true,
            position: 'center',
            buttons: {
                "Añadir programas de otra facultad": function() { 
                    var checked = $("#checkboxes input:checked").length > 0;
                    if (!checked){
                        //no selecciono carreras >.> que cambie el select a menos que sea una modalidad editable
                        if($('#modalidadEditable').val()!="false"){
                            returnSelect($("#modalidadEditable").val());
                        }
                        alert("No ha seleccionado ninguna facultad y/o programa");
                    } else {
                        //guardo todos los seleccionados hasta ahora
                        var modalidad = $("#idModalidades").val();
                        if($('#modalidadEditable').val()!="false" && $('#modalidadEditable').val()!=""){
                            modalidad = $("#modalidadEditable").val();
                            $("#modalidadC-"+$("#modalidadEditable").val()).remove();
                            $("#modalidad-"+$("#modalidadEditable").val()).remove();
                        } else if($('#modalidadEditable').val()==""){
                            $("#modalidadEditable").val("false");
                        }

                        $("#selected-checkboxes").append( "<div id='modalidadC-"+modalidad+"'>" );
                        $("#selected-checkboxes").append( "</div>" );
                        var i = 0;
                        $('#checkboxes input:checked').each(function() {
                            i = i + 1;
                            $("#modalidadC-"+modalidad).append( $(this) );
                        });

                        //Lo paso a la lista de elegidos                                    
                        $("#modalidadesElegidas").append( "<span id='modalidad-"+modalidad+"'><a href='javascript:selectCarreras(\""+modalidad+"\",true)'>"+$("#idModalidades option:selected").text()+" ( "+i+" programas seleccionados )</a><br/></span>" );


                        if($('#modalidadEditable').val()=="false"){
                            //remuevo la modalidad de los que falta por elegir
                            changeSelect(modalidad);  
                        }

                        $("#idModalidades").val("");    
                        $("#carreras-all").addClass('hidden');
                        $("#carreras-span").addClass('hidden');                                
                        //innerHTML no funciona en IE o.O
                        $('#checkboxes').html("");
                        //document.getElementById("checkboxes").innerHTML = "";
                        $('#carreras-all').removeAttr('checked');
                    }
                },
                "Finalizar selección": function() {  
                    var checked = $("#checkboxes input:checked").length > 0;
                    if (!checked){
                        //no selecciono carreras >.> que cambie el select a menos que sea una modalidad editable
                        if($('#modalidadEditable').val()!="false"){
                            returnSelect($("#modalidadEditable").val());
                        }
                    } else {
                        if($('#modalidadEditable').val()!="false"){
                           var modalidad = $("#modalidadEditable").val();
                            $("#modalidadC-"+$("#modalidadEditable").val()).remove();
                            $("#modalidad-"+$("#modalidadEditable").val()).remove(); 

                            $("#selected-checkboxes").append( "<div id='modalidadC-"+modalidad+"'>" );
                            $("#selected-checkboxes").append( "</div>" );
                            var i = 0;
                            $('#checkboxes input:checked').each(function() {
                                i = i + 1;
                                $("#modalidadC-"+modalidad).append( $(this) );
                            });

                            //Lo paso a la lista de elegidos
                            $("#modalidadesElegidas").append( "<span id='modalidad-"+modalidad+"'><a href='javascript:selectCarreras(\""+modalidad+"\",true)'>"+$("#idModalidades option:selected").text()+" ( "+i+" carreras seleccionadas )</a><br/></span>" );

                        }

                        $('#modalidadEditable').val(modalidad);
                    }

                    $( this ).dialog( "close" );
                },
                "Cancelar selección": function() {
                    //elimino todas las facultades seleccionadas
                    var checked = $("#dialog-carreras input:checked").length > 0;
                    if (checked){
                        $('#dialog-carreras input:checkbox').removeAttr('checked');

                        jQuery('#dialogCarreras').removeAttr('checked');
                        $("#select-carreras").addClass('hidden');


                        //innerHTML no funciona en IE o.O
                        $('#selected-checkboxes').html("");
                        $('#modalidadesElegidas').html("");
                        //document.getElementById("selected-checkboxes").innerHTML = "";
                        //document.getElementById("modalidadesElegidas").innerHTML = "";

                        resetModalidades();
                    }
                    $( this ).dialog( "close" );
                }
            },
            close: function(event) {
                //allFields.val( "" ).removeClass( "ui-state-error" );                        
                //si esta vacio los checkbox => de-seleccionar facultades y quitar el boton de elegir facultades
                var checked = $("#dialog-carreras input:checked").length > 0;
                if (!checked){
                    jQuery('#dialogCarreras').removeAttr('checked');
                    $("#select-carreras").addClass('hidden');
                }
                //Para que no le haga submit automaticamente al form al cerrar el dialog
                event.preventDefault();
            }
        });

        $( "#dialogCarreras" ).click(function() {
                if($(this).is(":checked")){
                    $("#select-carreras").removeClass('hidden');
                    $( "#dialog-carreras" ).dialog( "open" );                            
                } else {
                    $("#select-carreras").addClass('hidden');
                }
       });

       $( "#select-carreras" ).button().click(function() {
                $( "#dialog-carreras" ).dialog( "open" );                        
        });

        $( "#select-all-carreras" ).button().click(function() {                    
            $('button.loading').each(function() {
                 //$(this).addClass('hidden');
                 $(this).css("display","none");
            });        

            $('input.loading').each(function() {
                 //$(this).addClass('hidden');
                 $(this).css("display","none");
            });

            $('img.loading').each(function() {
                 $(this).removeClass('hidden');
            });

            selectAllCareers();

            var checked = $("#dialog-carreras input:checked").length > 0;
            if(checked){
                $('#dialogCarreras').attr('checked','checked');
                $("#select-carreras").removeClass('hidden'); 
            } 

            $('img.loading').each(function() {
                 $(this).addClass('hidden');
            });

            $('button.loading').each(function() {
                 //$(this).removeClass('hidden');
                 $(this).css("display","inline-block");
            });   

            $('input.loading').each(function() {
                 //$(this).removeClass('hidden');
                 $(this).css("display","inline-block");                             
            }); 

            if(!checked){
                $('#dialogCarreras').attr('disabled','disabled');
                alert("No hay programas nuevos para adicionar al indicador actualmente.");
            }
        });
    });
</script>
<?php }} ?>
