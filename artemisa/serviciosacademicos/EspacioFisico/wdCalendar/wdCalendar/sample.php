<?PHP


/*
Array
(
    [Grupo] => 71212
    [FechaIni] => 2014-06-01
    [FechaFin] => 2014-06-30
    [FrecuenciaOnline] => 36
    [CadenaDia] => ,1
    [HorasIniciales] => ,11:00 AM
    [HorasFinales] => ,7:00 PM
)

*/ 

$FechaIni = $_REQUEST['FechaIni'];
$FechaFin  = $_REQUEST['FechaFin'];
$Frecuencia = $_REQUEST['Frecuencia'];
$numIndices = $_REQUEST['numIndices'];
$DiaSemana = $_REQUEST['DiaSemana'];
$sede      = $_REQUEST['Campus'];

$OP  = $_REQUEST['Op'];

$Url = '';//../wdCalendar/wdCalendar/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1">
    <title>	My Calendar </title>
    <?PHP 
    if($OP!=1){
        ?>
        <form id="Prueba">
            <input type="hidden" id="FechaIni" name="FechaIni" value="<?PHP echo $FechaIni?>" />
            <input type="hidden" id="FechaFin" name="FechaFin" value="<?PHP echo $FechaFin?>" />
            <input type="hidden" id="Frecuencia" name="Frecuencia" value="<?PHP echo $Frecuencia?>" />
            <input type="hidden" id="numIndices" name="numIndices" value="<?PHP echo $numIndices?>" />
            <input type="hidden" id="sede" name="sede" value="<?PHP echo $sede?>" />
            <?PHP 
            for($i=0;$i<count($DiaSemana);$i++){
                ?>
                <input type="hidden" id="DiaSemana" name="DiaSemana[]" value="<?PHP echo $DiaSemana[$i]?>" />
                <?PHP
            }
            for($l=0;$l<=$numIndices;$l++){
                $Hora_ini = $_REQUEST['HoraInicial_'.$l];
                $Hora_fin = $_REQUEST['HoraFin_'.$l];
                for($x=0;$x<count($Hora_ini);$x++){
                        ?>
                        <input type="hidden" id="HoraInicial" name="HoraInicial_<?PHP echo $l?>[]" value="<?PHP echo $Hora_ini[$x]?>" />
                        <input type="hidden" id="HoraFin" name="HoraFin_<?PHP echo $l?>[]" value="<?PHP echo $Hora_fin[$x]?>" />
                        <?PHP
                }
               
            }//HoraInicial_
            ?>
            
        </form>
        <?PHP
    }
    ?>
    
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link href="<?PHP echo $Url?>css/dailog.css" rel="stylesheet" type="text/css" />
    <link href="<?PHP echo $Url?>css/calendar.css" rel="stylesheet" type="text/css" /> 
    <link href="<?PHP echo $Url?>css/dp.css" rel="stylesheet" type="text/css" />   
    <link href="<?PHP echo $Url?>css/alert.css" rel="stylesheet" type="text/css" /> 
    <link href="<?PHP echo $Url?>css/main.css" rel="stylesheet" type="text/css" /> 
    

    <script src="<?PHP echo $Url?>src/jquery.js" type="text/javascript"></script>  
   
    <script src="<?PHP echo $Url?>src/Plugins/Common.js" type="text/javascript"></script>    
    <script src="<?PHP echo $Url?>src/Plugins/datepicker_lang_US.js" type="text/javascript"></script>     
    <script src="<?PHP echo $Url?>src/Plugins/jquery.datepicker.js" type="text/javascript"></script>

    <script src="<?PHP echo $Url?>src/Plugins/jquery.alert.js" type="text/javascript"></script>    
    <script src="<?PHP echo $Url?>src/Plugins/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
    <script src="<?PHP echo $Url?>src/Plugins/wdCalendar_lang_US.js" type="text/javascript"></script>    
    <script src="<?PHP echo $Url?>src/Plugins/jquery.calendar.js" type="text/javascript"></script>   
    
    <script type="text/javascript">
       function ParentWindowFunction()
        {
             $("#gridcontainer").reload();
        }
        
        $(document).ready(function() {  
            
           var view="week";          
           
            var DATA_FEED_URL = "<?PHP echo $Url?>./php/datafeed.php";
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
                <?PHP 
                if($OP!=1){
                    ?>
                    url: DATA_FEED_URL + "?method=list&"+$('#Prueba').serialize(),
                    <?PHP
                }else{
                    ?>
                    url: DATA_FEED_URL + "?method=ViewList",
                    <?PHP
                }
                ?>
                quickAddUrl: DATA_FEED_URL + "?method=add", 
                quickUpdateUrl: DATA_FEED_URL + "?method=update",
                quickDeleteUrl: DATA_FEED_URL + "?method=remove"        
            };
           
            var $dv = $("#calhead");
            var _MH = document.documentElement.clientHeight;
           
            var dvH = $dv.height() + 2;
            op.height = _MH - dvH;
           
            var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
            //console.log(p);
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
                var t="Loading data...";
                switch(type)
                {
                    case 1:
                        t="Loading data...";
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
            function Edit(data){
               //alert('Entro');
               //var eurl="edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";
               
               var eurl="EditarEvento.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";
                  
                if(data)
                {
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 800, height: 400, caption:"Adminstrador de Eventos"});
                }
            }    
            function View(data)
            { 
                //var str = "";
//               
//                $.each(data, function(i, item){
//                    str += "[" + i + "]: " + item + "\n";
//                });
//                alert(str);   

                var eurl="EditarEvento.php?id={0}&indicador={9}&limite={10}&actualizacion={11}&creacion={12}&creador={13}&modificacion={14}&modificador={15}&idindicador={16}";   
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
                
                $.alerts.okButton="Ok";  
                $.alerts.cancelButton="Cancel";  
                hiConfirm("Desea Eliniar Solicitd", 'Confirm',function(r){ r && callback(0);});           
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
            $("#faddbtn").click(function(e) {//Nuevo evento
               
                var url ="CrerarEventoNew.php?"+$('#Prueba').serialize();
                OpenModelWindow(url,{ width: 825, height: 530, caption: "Crear Nuevo Evento"});
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
   
</head>
<body>
    <div>

      <div id="calhead" style="padding-left:1px;padding-right:1px;">          
            <div class="cHead"><div class="ftitle">Solicitud </div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading data...</div>
             <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>
            </div>          
            <?PHP 
                if($Frecuencia==3){
                    $Style = '';
                }else{
                    $Style = 'style="display: none;"';
                }
            ?>
            <div id="caltoolbar" class="ctoolbar">
              <div id="faddbtn" class="fbutton" <?PHP echo $Style?> >
                <div><span title='Click to Create New Event' class="addcal">

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
                <div><span title='Day' class="showdayview">D&iacute;a</span></div>
            </div>
              <div  id="showweekbtn" class="fbutton fcurrent">
                <div><span title='Week' class="showweekview">Semana</span></div>
            </div>
              <div  id="showmonthbtn" class="fbutton">
                <div><span title='Month' class="showmonthview">Mes</span></div>

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
     
  </div>
    
</body>
</html>
