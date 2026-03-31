
    <title>	Asignación de salones </title>
    
    <script type="text/javascript">
    
         function ParentWindowFunction()
        {
             $("#gridcontainer").reload();
        }
        $(document).ready(function() {     
            var view="week";          
            var DATA_FEED_URL = "../asignacionSalones/calendario3/wdCalendar/php/datafeed.php";
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
                readonly:true,
                url: DATA_FEED_URL + "?method=list&id=<?php echo $_GET['id'];?>",  
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
                var t='<img src="../imagenes/engranaje-13.gif" width="10%" />Este Proceso Puede Tardar Unos Minutos...';
                switch(type)
                {
                    case 1:
                        t='<img src="../imagenes/engranaje-13.gif" width="10%" />Este Proceso Puede Tardar Unos Minutos...';
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
               var eurl="../asignacionSalones/calendario3/wdCalendar/CalendarioSolicitud.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";   
               // var eurl="edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";   
                if(data)
                {
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 1000, height: 800, caption:"Manage  The Calendar",onclose:function(){
                       $("#gridcontainer").reload();
                    }});
                }
            }    
            
            function View(data)
            {
                <?php if($_GET['Ver']==1){?>
                 var eurl="";
                <?PHP }else{?>
                 var eurl="../asignacionSalones/calendario3/wdCalendar/CalendarioSolicitud.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";  
                  if(data){
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 1000, height: 800, caption:"Editar evento",onclose:function(){
                       $("#gridcontainer").reload();
                    }});
                } 
                <?PHP
                }
                ?>
               
               // var eurl="edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";   
               
                // var str = "";
                // $.each(data, function(i, item){
                //     str += "[" + i + "]: " + item + "\n";
                // });
                // alert(str);               
            } 
              
            function Delete(data,callback)
            {           
                
                $.alerts.okButton="Ok";  
                $.alerts.cancelButton="Cancel";  
                hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});           
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
                $("#gridcontainer").reload();
            });
            
            //Add a new event
            $("#faddbtn").click(function(e) {
                var url ="../asignacionSalones/calendario3/wdCalendar/EventoSolicitud.php";
                OpenModelWindow(url,{ width: 1300, height: 700, caption: "Crear Nuevo Evento"});
            });
            //go to today
            $("#showtodaybtn").click(function(e) {
                var p = $("#gridcontainer").gotoDate().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }


            });
            //previous date range
            $("#sfprevbtn").click(function(e) {
                var p = $("#gridcontainer").previousRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //next date range
            $("#sfnextbtn").click(function(e) {
                var p = $("#gridcontainer").nextRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            
        });
        
    </script>    

    <div style="width: 98%; ">
      <div id="calhead" style="padding-left:1px;padding-right:1px;">          
            <div class="cHead"><div class="ftitle">Asignación de Salones</div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Cargando Datos...</div>
             <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Disculpe, no se pudo cargar sus datos, porfavor intente despues</div>
            </div>          
            
            <div id="caltoolbar" class="ctoolbar">
              <div id="faddbtn" class="fbutton">
                <div style="display: none;"><span title='Click para crear un Nuevo Evento' class="addcal">
                Nuevo Evento                
                </span></div>
            </div>
            <div class="btnseparator"></div>
             <div id="showtodaybtn" class="fbutton">
                <div><span title='Click to back to today ' class="showtoday">
                Hoy</span></div>
            </div>
              <div class="btnseparator"></div>

            <div id="showdaybtn" class="fbutton">
                <div><span title='Day' class="showdayview">Día</span></div>
            </div>
              <div  id="showweekbtn" class="fbutton fcurrent">
                <div><span title='Week' class="showweekview">Semana</span></div>
            </div>
              <div  id="showmonthbtn" class="fbutton">
                <div><span title='Month' class="showmonthview">Més</span></div>
            </div>
            <div class="btnseparator"></div>
              <div  id="showreflashbtn" class="fbutton">
                <div><span title='Refresh view' class="showdayflash">Actualizar</span></div>
                </div>
             <div class="btnseparator"></div>
            <div id="sfprevbtn" title="Prev"  class="fbutton">
              <span class="fprev"></span>
            </div>
            <div id="sfnextbtn" title="Next" class="fbutton">
                <span class="fnext"></span>
            </div>
            <div class="fshowdatep fbutton">
                    <div>
                        <input type="hidden" name="txtshow" id="hdtxtshow" />
                        <span id="txtdatetimeshow">Calendario</span>
                    </div>
            </div>
            <div class="clear"></div>
            </div>
      </div>
      <div style="padding:1px;border:">
          <div class="t1 chromeColor">&nbsp;</div>
          <div class="t2 chromeColor">&nbsp;</div>
          <div id="dvCalMain" class="calmain printborder">
            <div id="gridcontainer" style="overflow-y: visible;"></div>
          </div>
          <div class="t2 chromeColor">&nbsp;</div>
          <div class="t1 chromeColor">&nbsp;</div>   
      </div>
     
  </div>
 