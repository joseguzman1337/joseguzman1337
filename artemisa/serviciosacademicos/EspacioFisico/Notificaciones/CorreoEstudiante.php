<?php

include('NotificacionEspaciosFisicos_class.php');
include("../templates/template.php");
		
		$db = getBD();

//Mensaje();die;

$C_NotificacionEspaciosFisicos = new NotificacionEspaciosFisicos();

//$Datos = Mensaje();

    $fecha_Now = date('Y-m-d');
    
    $dia = DiasSemana($fecha_Now);
    
    if($dia==7){
        $FechaFutura_1 = dameFecha($fecha_Now,1);
        $FechaFutura_2 = dameFecha($FechaFutura_1,6);
    }else{
        $Falta  = 7-$dia+1;
        
        $FechaFutura_1 = dameFecha($fecha_Now,$Falta);
        $FechaFutura_2 = dameFecha($FechaFutura_1,6);
    }


//$FechaFutura_1 ='2015-01-19';
//$FechaFutura_2 ='2015-01-25';

//$DataSolicitud = $C_NotificacionEspaciosFisicos->Solicitudes($db);

//for($i=0;$i<count($DataSolicitud);$i++){
    
    //$id = $DataSolicitud[$i];
    
    $DataEstudiante = $C_NotificacionEspaciosFisicos->Alumnos($db);
    
    //echo '<br><br>Id->'.$id;
    //echo '<pre>';print_r($DataEstudiante);die;
    /*
    [0] => Array
        (
            [0] => 4
            [id] => 4
            [1] => 80666
            [idgrupo] => 80666
            [2] => 180972
            [idprematricula] => 180972
            [3] => 131882
            [codigoestudiante] => 131882
            [4] => 97042810219
            [numerodocumento] => 97042810219
            [5] => 37816
            [idusuario] => 37816
            [6] => morjuelam
            [usuario] => morjuelam
            [7] => morjuelam@unbosque.edu.co
            [Correo] => morjuelam@unbosque.edu.co
        )
    */
    $DataInforma = 0;
    $DataError   = 0;
    $n=0;
    $L = 1;
    for($x=0;$x<count($DataEstudiante);$x++){
       
	echo '<br>'.$L;
       if($db=='NULL' || $db==NULL){ echo 'Error Base Null ';
	   $db = getBD();
		echo 'Base Recar';
	}
        $CodigoEstudiante = $DataEstudiante[$x]['codigoestudiante'];
        $Correo           = $DataEstudiante[$x]['Correo'];
        
        /*$DatosPrueba[] = 'ramirezmarcos@unbosque.edu.co';
        $DatosPrueba[] = 'bonillaleyla@unbosque.edu.co';
        $DatosPrueba[] = 'quinteroivan@unbosque.edu.co';
        $DatosPrueba[] = 'castillowilliam@unbosque.edu.co';
        $DatosPrueba[] = 'adminredes@unbosque.edu.co';
        $DatosPrueba[] = 'perezdavid@unbosque.edu.co';*/
        
       
        
        $Datos = $C_NotificacionEspaciosFisicos->HorarioEstudiante($db,$CodigoEstudiante,$FechaFutura_1,$FechaFutura_2);
        
        /*****************************************************************************************************************/
        
        $SQl='SELECT

            codigodia,nombredia
            
            FROM
            
            dia';
            
            if($Dias=&$db->Execute($SQl)===false){
                echo 'Error al Buscar Dias....<br><br>'.$SQl;
                die;
            }

$DiaName = $Dias->GetArray();

if($Datos){

$Mensaje ='<table  border=2>
           <tr>
                <th colspan=7>'.$DataEstudiante[$x]['Name'].' :: '.$DataEstudiante[$x]['usuario'].' Codigo Estudiante '.$CodigoEstudiante.'</th>
           </tr> 
        <tr >
            <td>
                <table>
                    <tr>
                        <th>Lunes</th>
                    </tr>';
                    for($j=0;$j<count($Datos[1]['idGrupo']);$j++){
                        
                      $Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                            <td style="border: black 1px solid ;">
                                <div style="background-color:'.$Datos[1]['Kolor'][$j].'">
                                '.$Datos[1]['idGrupo'][$j].'<br />
                                '.$Datos[1]['Info'][$j].'<br />
                                Lugar :'.$Datos[1]['Nombre'][$j].'<br />
                                </div>
                            </td>    
                        </tr>';
                        
                     }//info
                
$Mensaje=$Mensaje.'</table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>Martes</th>
                    </tr>';
                   
                    for($j=0;$j<count($Datos[2]['idGrupo']);$j++){
                       
                        $Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[2]['Kolor'][$j].';">
                                '.$Datos[2]['Fecha'][$j].'<br />
                                '.$Datos[2]['hora_1'][$j].' :: '.$Datos[2]['hora_2'][$j].'<br />
                                '.$Datos[2]['idGrupo'][$j].'<br />
                                '.$Datos[2]['Info'][$j].'<br />
                                Lugar :'.$Datos[2]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';
                        
                     }//info
                    
                $Mensaje=$Mensaje.'</table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>Miercoles</th>
                    </tr>';
                    for($j=0;$j<count($Datos[3]['idGrupo']);$j++){
                          $Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[3]['Kolor'][$j].';">
                                '.$Datos[3]['Fecha'][$j].'<br />
                                '.$Datos[3]['hora_1'][$j].' :: '.$Datos[3]['hora_2'][$j].'<br />
                                '.$Datos[3]['idGrupo'][$j].'<br />
                                '.$Datos[3]['Info'][$j].'<br />
                                Lugar :'.$Datos[3]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';
                       
                     }//info
                    
                 $Mensaje=$Mensaje.'</table>
                  </td>
                    <td>
                <table>
                    <tr>
                        <th>Jueves</th>
                    </tr>';
                   for($j=0;$j<count($Datos[4]['idGrupo']);$j++){
                       
                        $Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[4]['Kolor'][$j].';">
                                '.$Datos[4]['Fecha'][$j].'<br />
                                '.$Datos[4]['hora_1'][$j].' :: '.$Datos[4]['hora_2'][$j].'<br />
                                '.$Datos[4]['idGrupo'][$j].'<br />
                                '.$Datos[4]['Info'][$j].'<br />
                                Lugar :'.$Datos[4]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';
                        
                     }//info
                    
                 $Mensaje=$Mensaje.'</table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>Viernes</th>
                    </tr>';
                    for($j=0;$j<count($Datos[5]['idGrupo']);$j++){
                        $Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[5]['Kolor'][$j].';">
                                '.$Datos[5]['Fecha'][$j].'<br />
                                '.$Datos[5]['hora_1'][$j].' :: '.$Datos[5]['hora_2'][$j].'<br />
                                '.$Datos[5]['idGrupo'][$j].'<br />
                                '.$Datos[5]['Info'][$j].'<br />
                                Lugar :'.$Datos[5]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';
                     }//info
                   
                $Mensaje=$Mensaje.'</table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>Sabado</th>
                    </tr>';
                    
                    for($j=0;$j<count($Datos[6]['idGrupo']);$j++){
                        
                        $Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[6]['Kolor'][$j].';">
                                '.$Datos[6]['Fecha'][$j].'<br />
                                '.$Datos[6]['hora_1'][$j].' :: '.$Datos[6]['hora_2'][$j].'<br />
                                '.$Datos[6]['idGrupo'][$j].'<br />
                                '.$Datos[6]['Info'][$j].'<br />
                                Lugar :'.$Datos[6]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';
                       
                     }//info
                  
                $Mensaje=$Mensaje.'</table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>Domingo</th>
                    </tr>';
                    
                    for($j=0;$j<count($Datos[7]['idGrupo']);$j++){
                        
                        $Mensaje=$Mensaje.'<tr style="border: black 1px solid;">
                             <td style="border: black 1px solid;">
                                <div style="background-color:'.$Datos[7]['Kolor'][$j].';">
                                '.$Datos[7]['Fecha'][$j].'<br />
                                '.$Datos[7]['hora_1'][$j].' :: '.$Datos[7]['hora_2'][$j].'<br />
                                '.$Datos[7]['idGrupo'][$j].'<br />
                                '.$Datos[7]['Info'][$j].'<br />
                                Lugar :'.$Datos[7]['Nombre'][$j].'<br />
                                </div>
                            </td> 
                        </tr>';
                        
                     }//info
                    
                $Mensaje=$Mensaje.'</table>
            </td>
        </tr>
    </table>
    <br><br><br>
    Lo Invitamos A Consultar Su Horario En El Portal De La Universidad www.uelbosque.edu.co <br>
    O en el Siguiente Enlace <a href="http://artemisa.unbosque.edu.co/serviciosacademicos/EspacioFisico/Interfas/EspaciosFisicosAsigandosReporte.php" target="_blank">Click aqu�</a>';

        
        $to = $Correo;
        echo '<br><br>'.$Mensaje;
        $tittle = 'Horario Pr�xima Semana '.$FechaFutura_1.' - '.$FechaFutura_2;
         
        $tittle = 'Horario Pr�xima Semana '.$FechaFutura_1.' - '.$FechaFutura_2;
         
            $Resultado = $C_NotificacionEspaciosFisicos->EnviarCorreo($to,$tittle,$Mensaje,true);
        
       
        echo '<pre>';print_r($Resultado);
        
        if($Resultado['succes']==true){
            $DataInforma++;
        }else{
            $DataError++;
        }
     
     $N++;   
    }
    
    if($N==100){
        sleep(10);
        $N=0;
	$L++;
    }
        /*****************************************************************************************************************/
}//for
    
    echo'Termino';
    
        //$DatosPrueba[] = 'ramirezmarcos@unbosque.edu.co';
        $DatosPrueba[] = 'it@unbosque.edu.co';
        
    for($z=0;$z<count($DatosPrueba);$z++){
        
        $to = $DatosPrueba[$z];
        //echo '<br><br>'.$Mensaje;
        $tittle = 'Estudiante Informe '.$FechaFutura_1.' - '.$FechaFutura_2;
        $Mensaje = 'Correos Correctos son # '.$DataInforma.'<br><br>Correos Error #'.$DataError;
        $Resultado = $C_NotificacionEspaciosFisicos->EnviarCorreo($to,$tittle,$Mensaje,true);
        
    }
        
//}//for
        
function DiasSemana($Fecha,$Op=''){
    
        if($Op=='Nombre'){
            $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');    
        }else{
            $dias = array('','1','2','3','4','5','6','7');    
        }
        
        $fecha = $dias[date('N', strtotime($Fecha))]; 
        
        return $fecha;

}//  function DiasSemana
function dameFecha($fecha,$dia){   
        list($year,$mon,$day) = explode('-',$fecha);
        return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));        
}//function dameFecha

die;


//echo '<pre>';print_r($Datos);



//echo $Mensaje;die;



function Mensaje(){

?>

<link href="../asignacionSalones/calendario3/wdCalendar/css/dailog.css" rel="stylesheet" type="text/css" />
    <link href="../asignacionSalones/calendario3/wdCalendar/css/calendar.css" rel="stylesheet" type="text/css" /> 
    <link href="../asignacionSalones/calendario3/wdCalendar/css/dp.css" rel="stylesheet" type="text/css" />   
    <link href="../asignacionSalones/calendario3/wdCalendar/css/alert.css" rel="stylesheet" type="text/css" /> 
    <link href="../asignacionSalones/calendario3/wdCalendar/css/main.css" rel="stylesheet" type="text/css" />
    <?php 
    /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
     *Se cambia js externa http://code.jquery.com/jquery-3.6.0.min.js por js intertena
     *@since November 30,2018
     */
    ?>
    <script type="text/javascript" src="../../../assets/js/jquery.js"></script>
    <link rel="stylesheet" href="../css/Styleventana.css" type="text/css" /> 
    <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script> 
      
    <script src="../asignacionSalones/calendario3/wdCalendar/src/jquery.js" type="text/javascript"></script>  
    
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/Common.js" type="text/javascript"></script>    
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/datepicker_lang_US.js" type="text/javascript"></script>     
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/jquery.datepicker.js" type="text/javascript"></script>

    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/jquery.alert.js" type="text/javascript"></script>    
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/jquery.calendar.js" type="text/javascript"></script>   
    
        
	
    <title>	Asignaci�n de salones </title>
    
    <script type="text/javascript">
    
         function ParentWindowFunction()
        {
             $("#gridcontainer").reload();
        }
        $(document).ready(function() {     
            var view="week";          
            var DATA_FEED_URL = "../asignacionSalones/calendario3/wdCalendar/php/AlumnosHorario.php";
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
                var eurl="../asignacionSalones/calendario3/wdCalendar/CalendarioSolicitud.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";   
               // var eurl="edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";   
                if(data)
                {
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 1000, height: 800, caption:"Editar evento",onclose:function(){
                       $("#gridcontainer").reload();
                    }});
                }
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
            <div class="cHead"><div class="ftitle">Horario</div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Cargando Datos...</div>
             <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Disculpe, no se pudo cargar sus datos, porfavor intente despues</div>
            </div>          
            
            <div id="caltoolbar" class="ctoolbar">
              <div id="faddbtn" class="fbutton">
                <div style="display: none;"><span  class="addcal">
                Nuevo Evento                
                </span></div>
            </div>
            <div class="btnseparator"></div>
             <div id="showtodaybtn" class="fbutton">
                <div><span  class="showtoday">
                Hoy</span></div>
            </div>
              <div class="btnseparator"></div>

            <div id="showdaybtn" class="fbutton">
                <div><span class="showdayview">D�a</span></div>
            </div>
              <div  id="showweekbtn" class="fbutton fcurrent">
                <div><span  class="showweekview">Semana</span></div>
            </div>
              <div  id="showmonthbtn" class="fbutton">
                <div><span  class="showmonthview">M�s</span></div>
            </div>
            <div class="btnseparator"></div>
              <div  id="showreflashbtn" class="fbutton">
                <div><span class="showdayflash">Actualizar</span></div>
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
  <?PHP

}
?>
