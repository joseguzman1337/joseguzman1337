<?php
session_start();
$_SESSION['MM_Username'] = 'equipomgi';
//var_dump(is_file('../../funciones/funcionip.php'));die;


switch($_REQUEST['actionID']){
    case 'Nickname':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        
        $Data = $C_TelevisoresDinamicos->BlokeIp($db,$Ip);
        
       $a_vectt['val']			=true;
       $a_vectt['Nickname']		=$Data[0]['Nombre'];
       echo json_encode($a_vectt);
       exit;
    }break;
    case 'CargaData':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        $View  = $_POST['view'];
        $C_TelevisoresDinamicos->TablaDianmic($db,$_POST['Num'],$Ip,$View);
        
    }break;
    case 'Total':{ 
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        $View  = $_POST['view'];
        $Num = $C_TelevisoresDinamicos->ConsultaBloque($db,'Numero',$Ip,$View);
        
       $a_vectt['val']			=true;
       $a_vectt['Num']		    =$Num;
       echo json_encode($a_vectt);
       exit;
    }break;
    default:{
        global $C_TelevisoresDinamicos,$userid,$db; 
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        $Ip = ObtenerIP();
        
        $C_TelevisoresDinamicos->Display($db,$Ip);
    }break;
}
function MainGeneral(){

		
		global $C_TelevisoresDinamicos,$userid,$db;
		
	    include_once("../templates/template.php"); 	
        
        
        if(AJAX==false){  
            $db = getBD();
        }else{
            $db = getBD();
        }
	
		include('TelevisorDinamico_class.php');  $C_TelevisoresDinamicos = new TelevisoresDinamicos();
	
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		$userid=$Usario_id->fields['id'];
	}
function MainJson(){
	global $userid,$db;
		
		
		include("../templates/template.php");
		
		$db = getBD();
        
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}
function ObtenerIP(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
           $ip = getenv("HTTP_CLIENT_IP");
   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
           $ip = getenv("HTTP_X_FORWARDED_FOR");
   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
           $ip = getenv("REMOTE_ADDR");
   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
           $ip = $_SERVER['REMOTE_ADDR'];
   else
           $ip = "IP desconocida";
   return($ip);
}    
function JsGeneral(){
    ?>
    <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
     <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
     <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
    <script type='text/javascript' src='jquery-3.6.0.min.js'></script>
    <script type="text/javascript">
       
        timer = setTimeout('temporizador()', 1000);
        
        function temporizador() {  
        $(document).ready(function() {
                $.ajax({//Ajax
                    type: 'POST',
                    url: 'TelevisorDinamico_html.php',
                    async: false,
                    dataType: 'json',
                    data:({actionID: 'Nickname'}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                    success: function(data){
                        //$('#Nickname').slideUp(1000).delay('2000').fadeIn(1500);
                        $('#Nickname').html(data.Nickname);
                        
                    } 
                }); //AJAX
                /*********************************/
                $.ajax({//Ajax
            		   type: 'POST',
            		   url: 'TelevisorDinamico_html.php',
            		   async: false,
            		   dataType: 'json',
            		   data:({actionID: 'Total',view:1}),
            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
            		   success: function(data){
            					if(data.val==false){
            					   alert('Error');
                                   return false;
            					}else{
            					   var N = Math.ceil(parseInt(data.Num)/parseInt(10));
                                   
                                   for(i=1;i<=N;i++){
                                    var Count = parseInt(8000)*parseInt(i);
                                    /*********************************************/
                                           if(i==1){
                                              CargaData(i,'1');  
                                               }else{
                                            timer = setTimeout("CargaData("+i+",'1')", Count);
                                            }  
                                         
                                    /*********************************************/
                                   }//for
                                  
            					}
            							
            		   } 
            	}); 
                /*********************************/
                $.ajax({//Ajax
            		   type: 'POST',
            		   url: 'TelevisorDinamico_html.php',
            		   async: true,
            		   dataType: 'json',
            		   data:({actionID: 'Total',view:2}),
            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
            		   success: function(data){
            					if(data.val==false){
            					   alert('Error');
                                   return false;
            					}else{
            					   var M = Math.ceil(parseInt(data.Num)/parseInt(10));
                                   
                                   for(j=1;j<=M;j++){
                                    var Con = parseInt(8000)*parseInt(j);
                                    /*********************************************/
                                           if(j==1){
                                              CargaDataView(j,'2');  
                                               }else{
                                            timer = setTimeout("CargaDataView("+j+",'2')", Con);
                                            }  
                                         
                                    /*********************************************/
                                   }//for
                                   
            					}
            							
            		   } 
            	});
                //var Count_final = parseInt(Count)+parseInt(Con);
                var Count_final = parseInt(50000);
                timer = setTimeout("temporizador()", Count_final);
                /************************************/
           });
       }   
        function CargaData(N,view){
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'CargaData',Num:N,view:view}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                success: function(data){
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                    $('#CargaDinamic').html(data);
                    
                } 
            }); //AJAX
        }//function CargaData
        function CargaDataView(N,view){
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'CargaData',Num:N,view:view}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                success: function(data){
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                    $('#CargaDinamic2').html(data);
                
                } 
            }); //AJAX
           
        }//function CargaData
       
    </script>
    <?PHP  
}
?>