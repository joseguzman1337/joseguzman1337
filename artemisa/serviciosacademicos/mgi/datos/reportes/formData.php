<?php
    // this starts the session 
    session_start();
 
    require_once("../templates/template.php");
    $db = writeHeader("Elegir Dato",TRUE);
    
    //include("./menu.php");
    //writeMenu(2);
    $_SESSION['columnas']=$_REQUEST["columnas"];
    
    $data = array();
    $dato = array();
    $action = "save";
    $edit = false;
    $id = $_REQUEST["id"];
    $utils = new Utils_datos();
    $reporte = $utils->getDataEntity("reporte",$_REQUEST["idReporte"]);
    $infoOnly = false;
    if(isset($_REQUEST["infoOnly"]) && $_REQUEST["infoOnly"]==1){
        $tiposData = array(0=>array("idsiq_tipoData"=>2,"nombre"=>"Información"));
        $infoOnly = true;
    } else {
        $tiposData = $utils->getTiposData($db);
    }
    $categorias = $utils->getCategoriasData($db);
    if($id!="" && $id!=null){  
        $data = $utils->getDataEntity("detalleReporte",$id);
        $dato = $utils->getDataEntity("data",$data["idDato"]);
        $filtros = $utils->getFiltrosReporteJs($db, $data["idsiq_detalleReporte"]); 
        
        //solo php 5.2 pa arriba
         $js_array = json_encode($filtros);
         
        $action = "update";        
        $edit = true;
    }
?>

<div id="contenido">
      <h2 style="margin-top:0px">¿Que dato te gustaría usar?</h2>
      <div id="form"> 
            <form action="save.php" method="post" id="form_test" >
                <input type="hidden" name="entity" value="detalleReporte" />
                <input type="hidden" name="idReporte" value="<?php echo $reporte["idsiq_reporte"]; ?>" />
                <input type="hidden" name="numero_columna" value="<?php echo $_REQUEST["columna"]; ?>" />
                <input type="hidden" name="action" value="<?php echo $action; ?>" />
                <input type="hidden" name="infoOnly" id="infoOnly" value="<?php echo $infoOnly; ?>" />
                
                <?php
                if($edit&&$id!=""){
                    echo '<input type="hidden" name="idsiq_detalleReporte" value="'.$id.'">';
                }
                ?>
                <span class="mandatory">* Son campos obligatorios</span>
                <fieldset>   
                    <legend>Elegir Dato</legend>
                    <label for="nombre" class="grid-2-12">Tipo:</label>
                    <select id="tipoDato">
                        <option value=""></option>
                        <?php for($i = 0; $i < count($tiposData); ++$i) { ?>
                            <option value="<?php echo $tiposData[$i]['idsiq_tipoData']; ?>"><?php echo $tiposData[$i]['nombre']; ?></option>
                        <?php } ?>
                    </select> 
                    
                    <label for="nombre" class="grid-2-12">Categoría:</label>
                    <select id="categoriaDato">
                        <?php for($i = 0; $i < count($categorias); ++$i) { ?>
                            <option value="<?php echo $categorias[$i]['idsiq_categoriaData']; ?>"><?php echo $categorias[$i]['nombre']; ?></option>
                        <?php } ?>
                    </select> 
                    
                    <label for="nombre" class="grid-2-12">Dato:</label>
                        <select id="datos">
                            <option></option>
                        </select> 
                    
                    <p style="clear:both;margin-left:90px;">ó</p>
                    
                    <label for="nombre" style="width:190px;">Buscar dato por nombre:</label>                      
                    <input type="text"  class="grid-7-12" minlength="2" name="datosNombre" id="datosNombre" title="Nombre del dato" maxlength="120" tabindex="1" autocomplete="off" value="" />             

                </fieldset> 
                
                <fieldset>   
                    <legend>Detalle del dato seleccionado</legend>
                    <label for="nombre" class="grid-3-12">Dato seleccionado: <span class="mandatory">(*)</span></label>
                    <span id="nombreDato"><?php if($edit){ echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$dato['nombre']; } ?></span>         
                    <input type="hidden" name="idDato" id="idDato" value="<?php if($edit){ echo $data["idDato"]; } ?>" class="required" />
                    <input type="hidden" name="filtro" id="filtro" value="<?php if($edit){ echo $data["filtro"]; } ?>" class="required" />
                    <input type="hidden" name="currentFilter" id="currentFilter" value=""  />
                    
                    <label for="etiqueta_columna" class="grid-3-12">Título en el reporte: <span class="mandatory">(*)</span></label>
                    <input type="text"  class="grid-7-12 required" minlength="2" name="etiqueta_columna" id="etiqueta_columna" title="Etiqueta del dato" maxlength="255" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['etiqueta_columna']; } ?>" />             
                    
                    <input type="hidden" name="numFiltros" id="numFiltros" value="0" />
                    <div id="filtrosDato">
                    </div>
                    
                </fieldset> 

                <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" style="margin-left:20px" />
                <?php } else { ?><input type="submit" value="Agregar dato al reporte" class="first" style="margin-left:20px" /> <?php } ?>
            </form>
    </div>
</div>


<script type="text/javascript">
    <?php if($edit) { ?>
    $(document).ready(function() {  
            var filtro = "<?php echo $data["filtro"]; ?>";
            var filtros = filtro.split(".");
            var valor = "";
             <?php echo "var valoresFiltros = ". $js_array . ";\n";  ?>
            
            if(filtros.length>0){
                $('#filtro').val("<?php echo $dato["alias"]; ?>");
                getFilters();    
                for (var i=1;i<filtros.length;i++){  
                    $('#filter'+i).val(filtros[i]);
                    $('#filtro').val($('#filtro').val() + "." + $('#filter'+i).val() );   
                    getDataValues($('#filter'+i).val());
                    
                    if(typeof valoresFiltros !== "undefined" && valoresFiltros.length>0){
                        
                        for (var j=0;j<valoresFiltros.length;j++){ 
                            valor = valoresFiltros[j][0].split(".");
                            valor = valor[valor.length-1];
                            if(valor == filtros[i]){
                               $('#valueFilter'+i).val(valoresFiltros[j][1]); 
                            }
                        }
                    }
                    getFiltersData($('#filter'+i).val());
                }
            }
        });
    <?php } ?>
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
                                    window.opener.windowClose();
                                    window.close();       
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
                $('#datosNombre').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searchs/lookForData.php",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    data: $("#datosNombre").val(),
                                    infoOnly: $("#infoOnly").val()
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id,
                                            filtro: item.filtro
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#form').width()-100;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            $('#nombreDato').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+ui.item.label);
                            $('#etiqueta_columna').val(ui.item.label);
                            $('#idDato').val(ui.item.id);
                            $('#filtro').val(ui.item.filtro);
                            getFilters();
                        }                
                    });
                    
                });
                
                $('#tipoDato').bind("change", function(){
                    //cargo los datos del segundo select por ajax
                    if($('#tipoDato').val()==""){
                        document.getElementById("datos").innerHTML = "<option></option>";
                        resetData();
                    } else{             
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: "../searchs/lookForDataByCategory.php",
                                data: {
                                    categoria: $("#categoriaDato").val(),
                                    tipo: $('#tipoDato').val()
                                },
                                success:function(data){ 
                                    var select = "<option value=''></option>";
                                    for (var i=0;i<data.length;i++)
                                    {
                                        select = select+"<option value='"+data[i]["value"]+"'>"+data[i]["label"]+"</option>";
                                    }
                                    
                                    document.getElementById("datos").innerHTML = select;                                    
                                    resetData();
                                },
                                error: function(data,error){}
                            }); 
                    }
                });
                
                $('#categoriaDato').bind("change", function(){
                    //cargo los datos del segundo select por ajax
                    if($('#categoriaDato').val()==""){
                        document.getElementById("datos").innerHTML = "<option></option>";
                    } else{             
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: "../searchs/lookForDataByCategory.php",
                                data: {
                                    categoria: $("#categoriaDato").val(),
                                    tipo: $('#tipoDato').val()
                                },
                                success:function(data){ 
                                    var select = "<option value=''></option>";
                                    for (var i=0;i<data.length;i++)
                                    {
                                        select = select+"<option value='"+data[i]["value"]+"'>"+data[i]["label"]+"</option>";
                                    }
                                    
                                    document.getElementById("datos").innerHTML = select;                                    
                                    resetData();
                                },
                                error: function(data,error){}
                            }); 
                    }
                });
                
                $('#datos').live("change", function(){
                    //cargo los datos del segundo select por ajax
                    if($('#datos').val()==""){
                        resetData();
                    } else{ 
                            $('#nombreDato').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#datos option:selected").text());
                            $('#etiqueta_columna').val($("#datos option:selected").text());
                            var str=$("#datos").val();
                            var n=str.split(";"); 
                            $('#idDato').val(n[0]);
                            $('#filtro').val(n[1]);
                            getFilters();
                    }
                });
                
                $('#datosNombre').bind("change", function(){
                    if($('#datosNombre').val()==""){
                        resetData();
                    }
               });
               
               function resetData(){
                   $('#nombreDato').html("");
                   $('#etiqueta_columna').val("");
                   $('#idDato').val("");
                   $('#filtro').val("");   
                   $('#filtrosDato').html("");
                   $('#numFiltros').val("0");              
               }
               
               function getFilters(){
                    if($('#idDato').val()==""){
                        //no tengo que hacer nada
                    } else {                        
                        $('#filtrosDato').html("");
                        $('#numFiltros').val("0");  
                        
                        //busco los filtros
                        $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: "../searchs/lookForDataFilters.php",
                                async: false,
                                data: {
                                    id: $("#idDato").val()
                                },
                                success:function(data){ 
                                    if(data!=null && data.length>0){
                                        var num = parseInt(document.getElementById("numFiltros").value);
                                        var select = "";
                                        num = num + 1;
                                        select = select+"<div class='boxFilter"+num+"'><label class='grid-3-12'>Filtro "+num+":</label>";
                                        select = select+"<select class='filter"+num+" pickFilter' id='filter"+num+"'><option value=''></option>";
                                        for (var i=0;i<data.length;i++)
                                        {
                                            select = select+"<option value='"+data[i]["value"]+"'>"+data[i]["label"]+"</option>";      
                                        }
                                        select = select+"</select></div>";
                                        $('#filtrosDato').append(select);
                                        $('#numFiltros').val(num);
                                    }
                                },
                                error: function(data,error){}
                            }); 
                    }
               }
                
                $(".pickFilter").live('focus',function(){
                    // get the previously selected option
                    var id = $(this).attr('id');        
                    $('#currentFilter').val($('#'+id).val());   
                });
               
               //live es porque como estoy creando y quitanto elementos dinamicamente, me los reconozca
                $(".pickFilter").live('change',function(){
                    // get number of column
                    var id = $(this).attr('id');
                    var num = id.replace("filter",""); 
                    var numActual = parseInt(document.getElementById("numFiltros").value);                   
                    
                    var toRemove = numActual - num;
                    
                    //borrar filtros de este en adelante
                    for (var i=0;i<toRemove;i++)
                    {
                         var index = numActual - i;
                         $('.boxFilter'+index).remove();
                         $('.boxValueFilter'+index).remove();
                    }
                    if(toRemove>0){
                        $('.boxValueFilter'+num).remove();
                    }
                    $('#numFiltros').val(num);
                    
                    if($('#'+id).val()==""){
                        if(toRemove==0){
                            $('.boxValueFilter'+num).remove();
                        }
                        var filter = $('#filtro').val().split("."+$('#currentFilter').val());
                        $('#filtro').val(filter[0]);
                    } else {       
                        if($('#currentFilter').val()=="" ){
                            $('#currentFilter').val($('#'+id).val());  
                        }
                        if($('.boxValueFilter'+num).length != 0){
                            $('.boxValueFilter'+num).remove();
                            var filter = $('#filtro').val().split("."+$('#currentFilter').val());
                            $('#filtro').val(filter[0]);
                        }
                        var filter = $('#filtro').val().split("."+$('#'+id).val());
                        $('#filtro').val(filter[0] + "." + $('#'+id).val() );   
                        getDataValues($('#'+id).val());
                        getFiltersData($('#'+id).val());
                    }
                    
                });
                
                                
                function getFiltersData(al){
                    //busco los filtros
                        $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: "../searchs/lookForDataFilters.php",
                                async: false,
                                data: {
                                    alias: al
                                },
                                success:function(data){ 
                                    if(data!=null && data.length>0 ){
                                        var num = parseInt(document.getElementById("numFiltros").value);
                                        var select = "";
                                        num = num + 1;
                                        select = select+"<div class='boxFilter"+num+"'><label class='grid-3-12'>Filtro "+num+":</label>";
                                        select = select+"<select class='filter"+num+" pickFilter' id='filter"+num+"' ><option value=''></option>";
                                        for (var i=0;i<data.length;i++)
                                        {
                                            select = select+"<option value='"+data[i]["value"]+"'>"+data[i]["label"]+"</option>";      
                                        }
                                        select = select+"</select></div>";
                                        $('#filtrosDato').append(select);
                                        $('#numFiltros').val(num);
                                    }
                                },
                                error: function(data,error){}
                            }); 
                }
                
                
                function getDataValues(al){
                    //busco los filtros
                        $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: "../searchs/lookForDataValues.php",
                                async: false,
                                data: {
                                    alias: al
                                },
                                success:function(data){ 
                                    if(data!=null && data.length>0){
                                        var maxWidth = $('#form').width()-230;  
                                        var num = parseInt(document.getElementById("numFiltros").value);
                                        var select = "";
                                        //num = num + 1;
                                        select = select+"<div class='boxValueFilter"+num+"'><label class='grid-3-12'>Valor Filtro "+num+":</label>";
                                        var name = $('#filtro').val().replace(/\./g,"_"); 
                                        select = select+"<select style='max-width:"+maxWidth+"px;' class='valueFilter"+num+" pickValueFilter' id='valueFilter"+num+"' name='"+name+"'><option value=''></option>";
                                        for (var i=0;i<data.length;i++)
                                        {
                                            select = select+"<option value='"+data[i]["value"]+"'>"+data[i]["label"]+"</option>";      
                                        }
                                        select = select+"</select></div>";
                                        $('#filtrosDato').append(select);
                                        //$('#numFiltros').val(num);
                                    }
                                },
                                error: function(data,error){}
                            }); 
                }
  </script>

<?php writeFooter(); ?>