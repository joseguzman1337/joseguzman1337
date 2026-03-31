  function ParentWindowFunction()
        {
             $("#gridcontainer").reload();
        }
$(document).ready(function() {     
    var view="week";  
    var id = 5;
    var DATA_FEED_URL = "../Controller/CalendarioInstitucional_html.php";
    var op = {
        view: view,
        id:2,       
        theme:3,
        action_ID:'listar',
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
        method:'POST',
        url: DATA_FEED_URL ,  
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
     /***********************/
    //to show day view
    $("#showdaybtn").click(function(e) {
        //document.location.href="#day";
        $("#caltoolbar div.fcurrent").each(function() {
            $(this).removeClass("fcurrent");
        });
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
        });
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
        });
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
       var url ="../Controller/Calendario_direcion.php";
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
    
    $('#Salirbtn').click(
         function(){
            var confirmar = 'Desea Salir...?';
            
            if(confirm(confirmar)){
                location.href='../Controller/CalendarioInstitucional_html.php';                
            }//if
        }//function
    );
            
});
function cal_beforerequest(type){
    var t='<img src="../../EspacioFisico/imagenes/engranaje-13.gif" width="10%" />Este Proceso Puede Tardar Unos Minutos...';
    switch(type)
    {
        case 1:
            t='<img src="../../EspacioFisico/imagenes/engranaje-13.gif" width="10%" />Este Proceso Puede Tardar Unos Minutos...';
            break;
        case 2:                      
        case 3:  
        case 4:    
            t="The request is being processed ...";                                   
            break;
    }
    $("#errorpannel").hide();
    $("#loadingpannel").html(t).show();    
}//function cal_beforerequest

function cal_afterrequest(type){
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

}//function cal_afterrequest

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
} //function cal_onerror  
            
function View(data){
    
     var eurl="../Controller/CalendarioEdit_direcion.php?id={0}";  //&start={2}&end={3}&isallday={4}&title={1}
      if(data){
        var url = StrFormat(eurl,data);
        OpenModelWindow(url,{ width: 1000, height: 800, caption:"Editar evento",onclose:function(){
           $("#gridcontainer").reload();
        }});
    }   
} //function View
              
function Delete(data,callback){           

    $.alerts.okButton="Ok";  
    $.alerts.cancelButton="Cancel";  
    hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});           
}//function Delete
function wtd(p)
{
   if (p && p.datestrshow) {
        $("#txtdatetimeshow").text(p.datestrshow);
    }
    $("#caltoolbar div.fcurrent").each(function() {
        $(this).removeClass("fcurrent");
    });
    $("#showdaybtn").addClass("fcurrent");
}