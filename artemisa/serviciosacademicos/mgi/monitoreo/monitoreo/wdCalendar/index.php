<?php

    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
    include_once("../../variables.php");
    include($rutaTemplateCalendar."template.php");
    writeHeaderCalendar("Programación de actualizaciones de indicadores");
 ?>   
    <script type="text/javascript">
        function ParentWindowFunction()
        {
             $("#gridcontainer").reload();
        }
        
        $(document).ready(function() {     
           var view="week";          
           
            var DATA_FEED_URL = "php/datafeed.php";
            var op = {
                view: view,
                theme:3,
                showday: new Date(),
                EditCmdhandler:Edit,
                DeleteCmdhandler:Delete,
                ViewCmdhandler:View,    
                onWeekOrMonthToDay:wtd,
                onBeforeRequestData: cal_beforerequest,
                onAfterRequestData: cal_afterrequest,
                onRequestDataError: cal_onerror, 
                autoload:true,
                readonly: true,
                url: DATA_FEED_URL + "?method=list",  
                quickAddUrl: DATA_FEED_URL + "?method=add", 
                quickUpdateUrl: DATA_FEED_URL + "?method=update",
                quickDeleteUrl: DATA_FEED_URL + "?method=remove"        
            };
            var $dv = $("#calhead");
            var _MH = document.documentElement.clientHeight;
            var dvH = $dv.height() + 2;
            op.height = _MH - dvH;
            op.eventItems =[];

            var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            $("#caltoolbar").noSelect();
            
            $("#hdtxtshow").datepicker({ picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
            onReturn:function(r){                          
                            var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                            if (p && p.datestrshow) {
                                $("#txtdatetimeshow").text(p.datestrshow);
                            }
                     } 
            });
            function cal_beforerequest(type)
            {
                var t="Cargando datos...";
                switch(type)
                {
                    case 1:
                        t="Cargando datos...";
                        break;
                    case 2:                      
                    case 3:  
                    case 4:    
                        t="The request is being processed ...";                                   
                        break;
                }
                $("#errorpannel").hide();
                $("#loadingpannel").html(t).show();    
            }
            function cal_afterrequest(type)
            {
                switch(type)
                {
                    case 1:
                        $("#loadingpannel").hide();
                        break;
                    case 2:
                    case 3:
                    case 4:
                        $("#loadingpannel").html("Success!");
                        window.setTimeout(function(){ $("#loadingpannel").hide();},2000);
                    break;
                }              
               
            }
            function cal_onerror(type,data)
            {
                $("#errorpannel").show();
            }
            function Edit(data)
            {
               //var eurl="edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";   
               // if(data)
               // {
               //     var url = StrFormat(eurl,data);
               //     OpenModelWindow(url,{ width: 600, height: 400, caption:"Administrar el calendario",onclose:function(){
               //        $("#gridcontainer").reload();
               //     }});
               // }
            }    
            function View(data)
            {
                //var str = "";
                //$.each(data, function(i, item){
                //    str += "[" + i + "]: " + item + "\n";
                //});
                //alert(str);  
                
                var eurl="detalle.php?id={0}&indicador={9}&limite={10}&actualizacion={11}&creacion={12}&creador={13}&modificacion={14}&modificador={15}&idindicador={16}";   
                if(data)
                {
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 825, height: 530, caption:"Ver detalle actualización de indicador",onclose:function(){
                       $("#gridcontainer").reload();
                    }});
                } 
                
            }    
            function Delete(data,callback)
            {           
                
                //$.alerts.okButton="Ok";  
                //$.alerts.cancelButton="Cancelar";  
                //hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});           
            }
            function wtd(p)
            {
               if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $("#showdaybtn").addClass("fcurrent");
            }
            //to show day view
            $("#showdaybtn").click(function(e) {
                //document.location.href="#day";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("day").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            //to show week view
            $("#showweekbtn").click(function(e) {
                //document.location.href="#week";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("week").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //to show month view
            $("#showmonthbtn").click(function(e) {
                //document.location.href="#month";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("month").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            
            $("#showreflashbtn").click(function(e){
                //console.log($("#gridcontainer").BcalGetOp());
                $("#gridcontainer").reload();
            });
             
            //Add a new event
            $("#faddbtn").click(function(e) {
                var url ="edit.php";
                OpenModelWindow(url,{ width: 600, height: 360, caption: "Programar Fecha(s) de Vencimiento de un Indicador"});
            });
            //go to today
            $("#showtodaybtn").click(function(e) {
                var p = $("#gridcontainer").gotoDate().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                //para actualizar la pantalla
                ParentWindowFunction();


            });
            //previous date range
            $("#sfprevbtn").click(function(e) {
                var p = $("#gridcontainer").previousRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                //para actualizar la pantalla
                ParentWindowFunction();

            });
            //next date range
            $("#sfnextbtn").click(function(e) {
                var p = $("#gridcontainer").nextRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                //para actualizar la pantalla
                ParentWindowFunction();
            });
            
        });
    </script> 
    
    <div>

      <div id="calhead" style="padding-left:1px;padding-right:1px;">          
            <div class="cHead"><div class="ftitle">Programación de actualizaciones de indicadores</div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Cargando datos...</div>
             <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Lo siento, pero no se pudieron cargar tus datos, por favor intente más tarde</div>
            </div>          
            
            <div id="caltoolbar" class="ctoolbar">
              <div id="faddbtn" class="fbutton">
                <div><span title='Añadir Vencimiento' class="addcal">

                Programar Fecha de Actualización                
                </span></div>
            </div>
            <div class="btnseparator"></div>
             <div id="showtodaybtn" class="fbutton">
                <div><span title='Clic para volver a hoy ' class="showtoday">
                Hoy</span></div>
            </div>
              <div class="btnseparator"></div>

            <div id="showdaybtn" class="fbutton">
                <div><span title='Dia' class="showdayview">Día</span></div>
            </div>
              <div  id="showweekbtn" class="fbutton fcurrent">
                <div><span title='Semana' class="showweekview">Semana</span></div>
            </div>
              <div  id="showmonthbtn" class="fbutton">
                <div><span title='Mes' class="showmonthview">Mes</span></div>

            </div>
            <div class="btnseparator"></div>
              <div  id="showreflashbtn" class="fbutton">
                <div><span title='Refresh view' class="showdayflash">Actualizar</span></div>
                </div>
             <div class="btnseparator"></div>
            <div id="sfprevbtn" title="Anterior"  class="fbutton">
              <span class="fprev"></span>

            </div>
            <div id="sfnextbtn" title="Siguiente" class="fbutton">
                <span class="fnext"></span>
            </div>
            <div class="fshowdatep fbutton">
                    <div>
                        <input type="hidden" name="txtshow" id="hdtxtshow" />
                        <span id="txtdatetimeshow">Cargando</span>

                    </div>
            </div>
            
            <div class="clear"></div>
            </div>
      </div>
      <div style="padding:1px;">

        <div class="t1 chromeColor">
            &nbsp;</div>
        <div class="t2 chromeColor">
            &nbsp;</div>
        <div id="dvCalMain" class="calmain printborder">
            <div id="gridcontainer" style="overflow-y: visible;">
            </div>
        </div>
        <div class="t2 chromeColor">

            &nbsp;</div>
        <div class="t1 chromeColor">
            &nbsp;
        </div>   
        </div>
     
<?php writeFooter(); ?>
