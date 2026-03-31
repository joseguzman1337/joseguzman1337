<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../../variables.php");
    include($rutaTemplateCalendar."template.php");
    writeHeaderCalendar("Programación de actualizaciones de indicadores");
    $db = writeHeaderBD();
    
    $action = "save";
    $action2 = "save";
    $utils = new Utils_monitoreo();
    $tipos = $utils->getPeriodicidadesMonitoreo($db);
 ?> 
<script type="text/javascript" language="javascript" src="../../../js/functions.js"></script> 
      <script type="text/javascript">
        if (!DateAdd || typeof (DateDiff) != "function") {
            var DateAdd = function(interval, number, idate) {
                number = parseInt(number);
                var date;
                if (typeof (idate) == "string") {
                    date = idate.split(/\D/);
                    eval("var date = new Date(" + date.join(",") + ")");
                }
                if (typeof (idate) == "object") {
                    date = new Date(idate.toString());
                }
                switch (interval) {
                    case "y": date.setFullYear(date.getFullYear() + number); break;
                    case "m": date.setMonth(date.getMonth() + number); break;
                    case "d": date.setDate(date.getDate() + number); break;
                    case "w": date.setDate(date.getDate() + 7 * number); break;
                    case "h": date.setHours(date.getHours() + number); break;
                    case "n": date.setMinutes(date.getMinutes() + number); break;
                    case "s": date.setSeconds(date.getSeconds() + number); break;
                    case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
                }
                return date;
            }
        }
        $(document).ready(function() {
            //debugger;
            var DATA_FEED_URL = "php/datafeed.php";
            
            $("#Savebtn").click(function() { $("#fmEdit").submit(); //CloseModelWindow();
                                    });
            
            $("#Closebtn").click(function() { CloseModelWindow(); });
            
           $("#fecha_prox_monitoreo").datepicker({ 
                        onReturn: function(){checkboxFinDeMes();return false;},
                        picker: "<button class='calpick'></button>"});    
            var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            $("#calendarcolor").colorselect({ title: "Color", index: cv, hiddenid: "colorvalue" });
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() {               
                    return true;
                },
                dataType: "json",
                success: function(data) {
                    if (data.IsSuccess) {
                        alert(data.Msg);
                        //window.parent.location.reload();
                        window.parent.ParentWindowFunction();
                        CloseModelWindow(null,true);  
                        //window.parent.document.getElementById("gridcontainer").reload();
                    }
                } 
            };
            
           $.validator.addMethod("date", function(value, element) {                             
                var arrayDate = $("#fecha_prox_monitoreo").val().split("-"); 
                var newDate=new Date();
                newDate.setFullYear(arrayDate[0],arrayDate[1]-1,arrayDate[2]);
                
                var today = new Date();
                
                //console.log(newDate);
                //console.log(today);
                //console.log(newDate.getTime() > today.getTime());
                    if( newDate.getTime() > today.getTime() || $('#action2').val()=="update" ){                   
                        return true;
                    } else {
                        //"La fecha no puede ser menor a hoy"
                        return false;
                    }
            }, "La fecha no puede ser menor a hoy");
            $("#fmEdit").validate({                
                submitHandler: function(form) { $("#fmEdit").ajaxSubmit(options); },
                errorElement: "div",
                errorClass: "cusErrorPanel",
                errorPlacement: function(error, element) {
                    showerror(error, element);
                }
            });
            function showerror(error, target) {
                var pos = target.position();
                target.addClass("msgError");
                var height = target.height();
                var newpos = { left: pos.left, top: pos.top + height + 2 }
                if(target.context.id=="idIndicador"){
                    newpos = { left: pos.left + 110, top: pos.top + height + 120 }
                } else if(target.context.id=="fecha_prox_monitoreo"){
                    newpos = { left: pos.left + 20, top: pos.top + height + 185 }
                }
                //console.log(newpos);
                //console.log(target.context.id);
                var form = $("#fmEdit");             
                error.appendTo(form).css(newpos);
            }
        });
    </script>    
    <style type="text/css" title="currentStyle">
       @import "../../../css/styleMonitoreo.css";
    </style>   
    <style type="text/css">       
    form input[type="text"]{  
        margin-top: 5px;
    }
    th, td {
        border: 0;
        padding: 0;
    }
    table{
        margin-bottom:0;
    }
    .fform label span.mandatory{
            display: inline;
     }
    .calpick     {        
        width:16px;   
        height:16px;     
        border:none;        
        cursor:pointer;        
        background:url("sample-css/cal.gif") no-repeat center 2px;        
        margin-left: 2px;
        margin-top: 5px;
    }      
    .mask{
        width:100%;
        height:100%;
        position:absolute;
        background-color:grey;
        z-index:1;
        filter:alpha(opacity=80);
        opacity:.8;
    }
    .mask div{
        width: 50%;
        text-align:center;
        position: absolute; 
        top: 50%;
        left: 25%;
        color:white;
        
    }
    body{
        background-color: #fff;
    }
    .infocontainer{
        height: 89%;
    }
    </style>
       
    <div>      
      <div class="toolBotton">           
        <a id="Savebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Save"  title="Guardar cambios">Guardar cambios(<u>S</u>)
          </span>          
        </a>                      
        <a id="Closebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Close" title="Cerrar ventana" >Cancelar
          </span></a>            
        </a>        
      </div>                  
      <div style="clear: both">         
      </div>        
      <div class="infocontainer">            
        <form action="php/datafeed.php?method=adddetails" class="fform" id="fmEdit" method="post">  
               <input type="hidden" name="entity" value="monitoreo" />
          <input type="hidden" name="entity2" value="relacionIndicadorMonitoreo" />
          <input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />   
          <input type="hidden" name="action2" id="action2" value="<?php echo $action2; ?>" /> 
          <input type="hidden" name="idsiq_monitoreo" id="idsiq_monitoreo" value="" />
          <input type="hidden" name="idsiq_relacionIndicadorMonitoreo" id="idsiq_relacionIndicadorMonitoreo" value="" />
          
          <fieldset>   
            <legend>Información del Indicador</legend>
            <label for="nombre" class="grid-2-12">Indicador: <span class="mandatory">(*)</span></label> 
            <!--<input type="text"  class="grid-9-12" name="nombreGenerico" id="nombreGenerico" title="Nombre del Indicador" tabindex="1" autocomplete="off" value="" />-->
            <textarea class="grid-9-12 smaller" name="nombreGenerico" id="nombreGenerico" title="Nombre del Indicador" tabindex="1" autocomplete="off" ></textarea>
            <input type="hidden"  class="grid-5-12 required" name="idIndicador" id="idIndicador" title="Nombre del Indicador" maxlength="250" tabindex="1" autocomplete="off" value="" />
          </fieldset>
          <fieldset>   
            <legend>Vencimiento del Indicador</legend>
            <label for="fecha_prox_monitoreo" class="grid-4-12">Fecha de vencimiento: <span class="mandatory">(*)</span></label>
            <input type="text"  class="grid-2-12 required date" name="fecha_prox_monitoreo" id="fecha_prox_monitoreo" title="Fecha de Vencimiento" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="" />

            <label for="idPeriodicidad" class="grid-4-12">Periodicidad: </label>
            <?php  echo $tipos->GetMenu2('idPeriodicidad',0,true,false,1,'id="idPeriodicidad" class="grid-2-12"'); ?>
            
            <label for="fin_de_mes" id="labelFinMes" class="grid-4-12 hidden">¿Siempre en fin de mes?: <span class="mandatory">(*)</span></label>
            <select name="fin_de_mes" size="1" id="fin_de_mes" class="grid-auto hidden">
                <option selected="" value="1">Si</option>
                <option selected="" value="0">No</option>
            </select>
                <?php //writeYesNoSelect("fin_de_mes",$data['fin_de_mes'], "hidden"); ?>
          </fieldset>                      
        </form>         
      </div>     
 
<script type="text/javascript">
$(document).ready(function() {
                    $('#nombreGenerico').autocomplete({
                        source: function( request, response ) {
                            //console.log("aja ey");
                            $.ajax({
                                url: "../../searchs/lookForIndicadorDetalleByResponsabilidad.php",
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
                                            idrelacion: item.idrelacion,
                                            idmonitoreo: item.idmonitoreo,
                                            fecha: item.fecha,
                                            periodicidad: item.periodicidad,
                                            finmes: item.mes
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#fmEdit').width()-110;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            $('#idIndicador').val(ui.item.id);
                            if(ui.item.idrelacion!=false){
                                $('#action2').val("update");
                                $('#action').val("update");
                                $('#fecha_prox_monitoreo').val(ui.item.fecha);
                                $('#idPeriodicidad').val(ui.item.periodicidad);
                                $('#idsiq_relacionIndicadorMonitoreo').val(ui.item.idrelacion);
                                $('#idsiq_monitoreo').val(ui.item.idmonitoreo);
                                checkboxFinDeMes();
                                $('#fin_de_mes').val(ui.item.finmes);
                                //remuevo los errores si hay
                                $( ".msgError" ).each(function() {
                                    $(this).removeClass( "cusErrorPanel" );
                                });
                                $('.cusErrorPanel').remove();
                            }
                        }                
                    });
                });
                
                $('#idPeriodicidad').bind("change", function(){
                    checkboxFinDeMes();
               });
               
                $('#fecha_prox_monitoreo').bind("change", function(){
                    checkboxFinDeMes();
               });
               
               $('#nombreGenerico').bind("change", function(){
                    if($('#nombreGenerico').val()==""){
                        $('#idIndicador').val("");
                    }
               });
                
                function checkboxFinDeMes(){
                   if(($('#idPeriodicidad').val()!="")&&($('#fecha_prox_monitoreo').val()!="")){
                        var choosenDate = $('#fecha_prox_monitoreo').val().split("-");
                        var lastDay = daysInMonth(choosenDate[1]-1,choosenDate[0]);
                        if(lastDay==choosenDate[2]){                      
                            $("#labelFinMes").removeClass('hidden');
                            $("#fin_de_mes").removeClass('hidden');                           
                        } else {                            
                            $("#labelFinMes").addClass('hidden');
                            $("#fin_de_mes").addClass('hidden');
                            $('#fin_de_mes').val("0");
                        }
                        //console.log(choosenDate);
                        //console.log(daysInMonth(choosenDate[1]-1,choosenDate[0]));          
                    } else {
                        $("#labelFinMes").addClass('hidden');
                        $("#fin_de_mes").addClass('hidden');
                        $('#fin_de_mes').val("0");
                    }
               }
</script>
<?php writeFooter(); ?>