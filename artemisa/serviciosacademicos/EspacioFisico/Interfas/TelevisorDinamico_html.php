<?php
session_start();
$_SESSION['MM_Username'] = 'coordinadorsisinfo';
//var_dump(is_file('../../funciones/funcionip.php'));die;


switch($_REQUEST['actionID']){
    case 'EsPar':{
          global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        
        $N  = $_POST['Num'];
        
        if ($N%2==0){
           $a_vectt['val']			=true;//par
        }else{
            $a_vectt['val']			=false;//impar
        }
        
        echo json_encode($a_vectt);
        exit;
    }break;    
    case 'DataTransporte':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        
        $N  = $_POST['N'];
        
        $C_TelevisoresDinamicos->Transporte($db,$N);
    }break;
    case 'DataMensaje':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        
        $C_TelevisoresDinamicos->MensajeDinamico($db,$_POST['Num']);
    }break;
    case 'TotalMensaje':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        
        
        $Num = $C_TelevisoresDinamicos->ConsolaRecuerda($db,'Numero');
        
       $a_vectt['val']			=true;
       $a_vectt['Num']		    =$Num;
       echo json_encode($a_vectt);
       exit;
    }break;    
    case 'CargaUpdate':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        $View  = $_POST['view'];
        $Estado  = $_POST['Estado'];
        
        $C_TelevisoresDinamicos->TablaDianmic($db,$_POST['Num'],'',$View,$Estado);
        
    }break;
    case 'CargaCancel':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        $View  = $_POST['view'];
        $Estado  = $_POST['Estado'];
        
        $C_TelevisoresDinamicos->DataCancel($db,$_POST['Num'],$View,$Estado);
    }break;
    case 'TotalEventos':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        
        $Num = $C_TelevisoresDinamicos->ConsultaEvento($db,'Numero');
        
        $a_vectt['val']			=true;
       $a_vectt['Num']		    =$Num;
       echo json_encode($a_vectt);
       exit;
    }break;
    case 'DataEvento':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        
        $C_TelevisoresDinamicos->EventoDinamico($db,$_POST['Num']);
    }break;
    case 'Cancel':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        define(BIPANTALLA,false);
        define(CANCEL,true);
        define(MULTI,false);
        MainGeneral();
        JsGeneral();
        $Ip = ObtenerIP();
        
        $C_TelevisoresDinamicos->ViewCancelUpdate($db,$Ip);
    }break;
    case 'MultiPantallas':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        define(BIPANTALLA,false);
        define(CANCEL,false);
        define(MULTI,true);
        MainGeneral();
        JsGeneral();
        $Ip = ObtenerIP();
        
        $C_TelevisoresDinamicos->MultiPantallas($db,$Ip);
    }break;
    case 'Nickname':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        
        $id = $_POST['id'];
        
        //echo '<pre>';print_r($db);die;
        
        $Data = $C_TelevisoresDinamicos->BlokeIp($db,$Ip,$id);
        //echo '<pre>';print_r($Data);
       $a_vectt['val']			=true;
       $a_vectt['Nickname']		=$Data;
       echo json_encode($a_vectt);
       exit;
    }break;
    case 'CargaData':{
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        $View  = $_POST['view'];
        $id    = $_POST['id'];
        $Estado  = $_POST['Estado'];
        
        $Data_ip = $C_TelevisoresDinamicos->BlokeIp($db,$Ip,'','Cadena',0,12);
        
        //echo '<pre>';print_r($Data_ip);die;
        
        $C_TelevisoresDinamicos->TablaDianmic($db,$_POST['Num'],$Data_ip,$View,$Estado);
        
    }break;
    case 'Total':{ 
        global $C_TelevisoresDinamicos,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Ip = ObtenerIP();
        $View  = $_POST['view'];
        $id    = $_POST['id'];
        $Estado = $_POST['Estado'];
        $ini    = $_POST['ini'];
        $fin    = $_POST['fin'];
        
        if($View==3){
            $Num = $C_TelevisoresDinamicos->BlokeIp($db,$Ip,'','Numero');    
        }else{ 
            if($fin){
               $Cadena= $C_TelevisoresDinamicos->BlokeIp($db,$Ip,'','Cadena',$ini,$fin);
            }else{
                $Cadena= $C_TelevisoresDinamicos->BlokeIp($db,$Ip,'','Cadena',0,12);
            }
            
            $Num = $C_TelevisoresDinamicos->ConsultaBloque($db,'Numero',$Cadena,$View,$Estado,$Cadena);
        }
        
        //echo 'Num-->'.$Num;
        
       $a_vectt['val']			=true;
       $a_vectt['Num']		    =$Num;
       echo json_encode($a_vectt);
       exit;
    }break;
    default:{
        global $C_TelevisoresDinamicos,$userid,$db;  
        define(AJAX,false);
        define(BIPANTALLA,true);
        define(CANCEL,false);
        define(MULTI,false);
        MainGeneral();//echo 'llego..';die;
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

        //echo '<pre>';print_r($db);die;
        
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
	<!doctype html> <!-- html5 -->
<html lang="es"> <!-- lang="xx" is allowed, but NO xmlns="http://www.w3.org/1999/xhtml", lang:xml="", and so on -->
<head>
<meta http-equiv="x-ua-compatible" content="IE=Edge"/> 

    <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
     <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
     <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
    <script type='text/javascript' src='jquery-3.6.0.min.js'></script>
    <script type="text/javascript">
       
        timer = setTimeout('temporizador()', 1000);
        var Q = 0;
        var T = 0;
        var Z = 0;
        var y = 0;
        var K = 0;
        <?PHP 
        if(BIPANTALLA==true){
        ?>
        function temporizador() {  
        $(document).ready(function() {
                
              /* $.ajax({//Ajax
                    type: 'POST',
                    url: 'TelevisorDinamico_html.php',
                    async: false,
                    dataType: 'json',
                    data:({actionID: 'Nickname'}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        //$('#Nickname').slideUp(1000).delay('2000').fadeIn(1500);
                        //console.log(data);
                        var Espacios = data.Nickname;
                        var NumEspacio = Espacios.length;
                        for(x=0;x<NumEspacio;x++){*/
                            
                            /***************************************************************************/
                             //var Nombre = Espacios[x]['Nombre'];
                             //var id = Espacios[x]['ClasificacionEspaciosId'];
                             
                           // $('#container').html('<img src="../imagenes/prueba_black.jpg" width="100%" />');
            
                              $.ajax({//Ajax
                            		   type: 'POST',
                            		   url: 'TelevisorDinamico_html.php',
                            		   async: false,
                            		   dataType: 'json',
                            		   data:({actionID: 'Total',view:1}),
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                            		   success: function(data){
                            					if(data.val==false){
                            					   alert('Error');
                                                   return false;
                            					}else{
                            					   // console.log(data.Num.Num);
                                                   
                            					   var N = Math.ceil(parseInt(data.Num.Num)/parseInt(18));
                                                  
                                                  for(i=1;i<=N;i++){
                                                   
                                                    var Count = parseInt(8000)*parseInt(i);
                                                   
                                                    /*********************************************/
                                                           if(i==1){
                                                             //CargaData(i,'1',id);
                                                             //console.log(N);
                                                                var Count = parseInt(Q)+parseInt(1500)*parseInt(N);
                                                                Q = Count;
                                                              setTimeout("CargaData("+i+",'1')",Count);
                                                              // console.log('count->'+Count);
                                                              //timer = setTimeout("CargaData("+i+",'1',"+id+")",'30000');
                                                               }else{
                                                                 //console.log('-->'+Count);
                                                                setTimeout("CargaData("+i+",'1')", Count);
                                                            }  
                                                         
                                                    /*********************************************/
                                                   }//for
                                                  
                            					}
                            							
                            		   } 
                            	}); 
                                EventosView();
                                Transporte();
                               /* $.ajax({//Ajax
                            		   type: 'POST',
                            		   url: 'TelevisorDinamico_html.php',
                            		   async: false,
                            		   dataType: 'json',
                            		   data:({actionID: 'Total',view:2,id:id}),
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                            		   success: function(data){
                            					
                            					if(data.val==false){
                            					   alert('Error');
                                                   return false;
                            					}else{
                            					   
                                                   var M = Math.ceil(parseInt(data.Num)/parseInt(10));
                                                   
                                                   for(j=1;j<=M;j++){
                                                    var Con = parseInt(8000)*parseInt(j);
                                                    /*********************************************/
                                                           /*if(j==1){
                                                              //CargaDataView(j,'2',id);
                                                               var Con = parseInt(T)+parseInt(1500)*parseInt(M);
                                                                T = Con;
                                                              setTimeout("CargaDataView("+j+",'2',"+id+")", Con);  
                                                               }else{
                                                            timer = setTimeout("CargaDataView("+j+",'2',"+id+")", Con);
                                                            }  
                                                         
                                                    /*********************************************/
                                                   /*}//for
                                                   
                            					}		
                            		   } 
                           	      });//Ajax
                                /*********************************/
                                
                                 //Eventos
                                
                            
                            /***************************************************************************/
                        //}//for borrar
                     //} 
                //}); //AJAX
                /*********************************/
                 var Count_final = parseInt(30000);
                 timer = setTimeout("temporizador()", Count_final);
                /************************************/
           });
       } 
         
        function CargaData(N,view){
           
            var name = 'Nickname';
              //Nickname(id,name);

                $.ajax({//Ajax
                    type: 'POST',
                    url: 'TelevisorDinamico_html.php',
                    async: false,
                    dataType: 'html',
                    data:({actionID: 'CargaData',Num:N,view:view}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                        $('#CargaDinamic').html(data);

                    } 
                }); //AJAX
            
        }//function CargaData
        function CargaDataView(N,view,id){
             var name = 'Nickname_2';
          Nickname(id,name);
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'CargaData',Num:N,view:view,id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                    $('#CargaDinamic2').html(data);
                
                } 
            }); //AJAX
           
        }//function CargaData
        function Nickname(id,name){
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'json',
                data:({actionID: 'Nickname',id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                  //  console.log(data);
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                     $('#'+name).html(data.Nickname[0]['Nombre']); 
                
                } 
            }); //AJAX
        }//function Nickname
       <?PHP 
       }else if(CANCEL==true){
        ?>
        function temporizador() {  
        $(document).ready(function() {
                
                               $.ajax({//Ajax
                            		   type: 'POST',
                            		   url: 'TelevisorDinamico_html.php',
                            		   async: false,
                            		   dataType: 'json',
                            		   data:({actionID: 'Total',view:1,Estado:1}),
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                                                             //CargaData(i,'1',id);
                                                             //console.log(N);
                                                                var Count = parseInt(Q)+parseInt(1500)*parseInt(N);
                                                                Q = Count;
                                                              setTimeout("CargaDataCancel("+i+",'1')",Count);
                                                              // console.log('count->'+Count);
                                                              //timer = setTimeout("CargaData("+i+",'1',"+id+")",'30000');
                                                               }else{
                                                                 //console.log('-->'+Count);
                                                                setTimeout("CargaDataCancel("+i+",'1')", Count);
                                                            }  
                                                         
                                                    /*********************************************/
                                                   }//for
                                                  
                            					}
                            							
                            		   } 
                            	}); 
                                
                                $.ajax({//Ajax
                            		   type: 'POST',
                            		   url: 'TelevisorDinamico_html.php',
                            		   async: false,
                            		   dataType: 'json',
                            		   data:({actionID: 'Total',view:2,Estado:1}),
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                                                              //CargaDataView(j,'2',id);
                                                               var Con = parseInt(T)+parseInt(1500)*parseInt(M);
                                                                T = Con;
                                                              setTimeout("CargaDataUpdate("+j+",'2')", Con);  
                                                               }else{
                                                            timer = setTimeout("CargaDataUpdate("+j+",'2')", Con);
                                                            }  
                                                         
                                                    /*********************************************/
                                                   }//for
                                                   
                            					}		
                            		   } 
                           	      });//Ajax
                                /*********************************/
                                
                                 //Eventos
                                EventosView();
                           
                /*********************************/
                 var Count_final = parseInt(30000);
                 timer = setTimeout("temporizador()", Count_final);
                /************************************/
           });
       } 
         
        function CargaDataCancel(N,view){ 
             $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'CargaCancel',Num:N,view:view,Estado:1}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                    $('#CargaDinamic_1').html(data);
                    
                } 
            }); //AJAX
        }//function CargaData
        function CargaDataUpdate(N,view){
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'CargaUpdate',Num:N,view:view,Estado:1}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                    $('#CargaDinamic_2').html(data);
                
                } 
            }); //AJAX
           
        }//function CargaData
       
        <?PHP
       }else if(MULTI==true){
        ?>
        function temporizador() {  
            $(document).ready(function() {
                
                $.ajax({//Ajax
        		   type: 'POST',
        		   url: 'TelevisorDinamico_html.php',
        		   async: false,
        		   dataType: 'json',
        		   data:({actionID: 'Total',view:3}),
        		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        		   success: function(data){
        		      
                            if(data.val==false){
        					   alert('Error');
                               return false;
        					}else{
        					   
                               var M = Math.ceil(parseInt(data.Num)/parseInt(4));
                               //console.log(M)
                               for(l=0;l<4;l++){
                                    $.ajax({//Ajax
                                		   type: 'POST',
                                		   url: 'TelevisorDinamico_html.php',
                                		   async: false,
                                		   dataType: 'json',
                                		   data:({actionID: 'Total',view:1,ini:l,fin:M}),
                                		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                                		   success: function(data){
                                		          if(data.val==false){
                                					   alert('Error');
                                                       return false;
                                					}else{
                                					   var Cantidad = data.Num.Num;
                                                       var Cadena = data.Num.Cadena;
                                                       var P = Math.ceil(parseInt(Cantidad)/parseInt(10));
                                                       
                                					   switch(l){
                                                            case 0:{
                                                               
                                                                var Data_id = Cadena.split(',');
                                                                
                                                                /***********************************************************************************/
                                                                var Con = Data_id.length;
                                                                
                                                                for(x=0;x<Con;x++){
                                                                    
                                                                    $.ajax({//Ajax
                                                                		   type: 'POST',
                                                                		   url: 'TelevisorDinamico_html.php',
                                                                		   async: false,
                                                                		   dataType: 'json',
                                                                		   data:({actionID: 'Total',view:1,id:Data_id[x]}),
                                                                		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                                                                                                   var Count = parseInt(Q)+parseInt(1500)*parseInt(N);
                                                                                                    Q = Count;
                                                                                                  setTimeout("CargaDataMulti("+i+",'1',"+Data_id[x]+",'1')",Count);
                                                                                                  }else{
                                                                                                    setTimeout("CargaDataMulti("+i+",'1',"+Data_id[x]+",'1')", Count);
                                                                                                }  
                                                                                             
                                                                                        /*********************************************/
                                                                                       }//for
                                                                                      
                                                                					}
                                                                							
                                                                		   } 
                                                                	});//ajax 
                                                                }//for
                                                                /***********************************************************************************/       
                                                            }break;
                                                            case 1:{
                                                             
                                                                var Data_id = Cadena.split(',');
                                                                
                                                                /***********************************************************************************/
                                                                var Con = Data_id.length;
                                                                
                                                                for(x=0;x<Con;x++){
                                                                    
                                                                    $.ajax({//Ajax
                                                                		   type: 'POST',
                                                                		   url: 'TelevisorDinamico_html.php',
                                                                		   async: false,
                                                                		   dataType: 'json',
                                                                		   data:({actionID: 'Total',view:1,id:Data_id[x]}),
                                                                		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                                                                                                   var Count = parseInt(Q)+parseInt(1500)*parseInt(N);
                                                                                                    Q = Count;
                                                                                                  setTimeout("CargaDataMulti("+i+",'1',"+Data_id[x]+",'2')",Count);
                                                                                                  }else{
                                                                                                    setTimeout("CargaDataMulti("+i+",'1',"+Data_id[x]+",'2')", Count);
                                                                                                }  
                                                                                             
                                                                                        /*********************************************/
                                                                                       }//for
                                                                                      
                                                                					}
                                                                							
                                                                		   } 
                                                                	});//ajax 
                                                                }//for    
                                                            }break;
                                                            case 2:{
                                                                var Data_id = Cadena.split(',');
                                                                
                                                                /***********************************************************************************/
                                                                var Con = Data_id.length;
                                                                
                                                                for(x=0;x<Con;x++){
                                                                    
                                                                    $.ajax({//Ajax
                                                                		   type: 'POST',
                                                                		   url: 'TelevisorDinamico_html.php',
                                                                		   async: false,
                                                                		   dataType: 'json',
                                                                		   data:({actionID: 'Total',view:1,id:Data_id[x]}),
                                                                		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                                                                                                   var Count = parseInt(Q)+parseInt(1500)*parseInt(N);
                                                                                                    Q = Count;
                                                                                                  setTimeout("CargaDataMulti("+i+",'1',"+Data_id[x]+",'3')",Count);
                                                                                                  }else{
                                                                                                    setTimeout("CargaDataMulti("+i+",'1',"+Data_id[x]+",'3')", Count);
                                                                                                }  
                                                                                             
                                                                                        /*********************************************/
                                                                                       }//for
                                                                                      
                                                                					}
                                                                							
                                                                		   } 
                                                                	});//ajax 
                                                                }//for
                                                                      
                                                            }break;
                                                            case 3:{
                                                                var Data_id = Cadena.split(',');
                                                                
                                                                /***********************************************************************************/
                                                                var Con = Data_id.length;
                                                                
                                                                for(x=0;x<Con;x++){
                                                                    
                                                                    $.ajax({//Ajax
                                                                		   type: 'POST',
                                                                		   url: 'TelevisorDinamico_html.php',
                                                                		   async: false,
                                                                		   dataType: 'json',
                                                                		   data:({actionID: 'Total',view:1,id:Data_id[x]}),
                                                                		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                                                                                                   var Count = parseInt(Q)+parseInt(1500)*parseInt(N);
                                                                                                    Q = Count;
                                                                                                  setTimeout("CargaDataMulti("+i+",'1',"+Data_id[x]+",'4')",Count);
                                                                                                  }else{
                                                                                                    setTimeout("CargaDataMulti("+i+",'1',"+Data_id[x]+",'4')", Count);
                                                                                                }  
                                                                                             
                                                                                        /*********************************************/
                                                                                       }//for
                                                                                      
                                                                					}
                                                                							
                                                                		   } 
                                                                	});//ajax 
                                                                }//for
                                                                      
                                                            }break;
                                                       }
                                					   
                                                       
                                                    }   
                                		      }//data
                                        });//AJAX
                               }//fin for 
                            }//fin if
        		      }//data
                      
                   });//AJAX
                   
                   EventosView();
                   
                 var Count_final = parseInt(30000);
                 timer = setTimeout("temporizador()", Count_final);
                
            });
        }
        
        
        
         function CargaDataMulti(N,view,id,l){
            
                    var name = 'Nickname_'+l;
                    Nickname(id,name);
                    
                    $.ajax({//Ajax
                        type: 'POST',
                        url: 'TelevisorDinamico_html.php',
                        async: false,
                        dataType: 'html',
                        data:({actionID: 'CargaData',Num:N,view:view,id:id}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                        success: function(data){
                            //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                          
                            $('#CargaDinamic_'+l).html(data);
                        } 
                    }); //AJAX
                
            
           
        }//function CargaData
        function CargaDataView(N,view,id){
             var name = 'Nickname_2';
          Nickname(id,name);
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'CargaData',Num:N,view:view,id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                    $('#CargaDinamic2').html(data);
                
                } 
            }); //AJAX
           
        }//function CargaData
        function Nickname(id,name){
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'json',
                data:({actionID: 'Nickname',id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                  //  console.log(data);
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                     $('#'+name).html(data.Nickname[0]['Nombre']); 
                
                } 
            }); //AJAX
        }//function Nickname
        <?PHP
       }
       ?> 
       function CargaEvento(N){ 
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'DataEvento',Num:N}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                    //console.log(data);
                    $('#EventoDinamico').html(data);                    
                } 
            }); //AJAX
       }//function CargaEvento
       function EventosView(){  
        
         $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'TelevisorDinamico_html.php',
    		   async: false,
    		   dataType: 'json',
    		   data:({actionID: 'TotalEventos'}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		   success: function(data){
    					
    					if(data.val==false){
    					   alert('Error');
                           return false;
    					}else{
    					   
                           var E = Math.ceil(parseInt(data.Num)/parseInt(1));
                           
                           for(r=1;r<=E;r++){
                            var Even = parseInt(5000)*parseInt(r);
                            /*********************************************/
                                   if(r==1){
                                      //CargaDataView(j,'2',id);
                                       var Even = parseInt(Z)+parseInt(1000)*parseInt(E);
                                        Z = Even;
                                      setTimeout("CargaEvento("+r+")", Even);  
                                       }else{
                                    timer = setTimeout("CargaEvento("+r+")", Even);
                                    }  
                                 
                            /*********************************************/
                           }//for
                           
    					}		
    		   } 
   	      });//Ajax   
        
       }//function EventosView
       function RecuerdView(){
            $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'TelevisorDinamico_html.php',
    		   async: false,
    		   dataType: 'json',
    		   data:({actionID: 'TotalMensaje'}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		   success: function(data){
    					
    					if(data.val==false){
    					   alert('Error');
                           return false;
    					}else{
    					   
                           var E = Math.ceil(parseInt(data.Num)/parseInt(3));
                           
                           for(r=1;r<=E;r++){
                            var Even = parseInt(8000)*parseInt(r);
                            /*********************************************/
                                   if(r==1){
                                      //CargaDataView(j,'2',id);
                                       var Even = parseInt(K)+parseInt(1500)*parseInt(E);
                                        K = Even;
                                      setTimeout("CargaMensaje("+r+")", Even);  
                                       }else{
                                    timer = setTimeout("CargaMensaje("+r+")", Even);
                                    }  
                                 
                            /*********************************************/
                           }//for
                           
    					}		
    		   } 
   	      });//Ajax   
       }//function RecuerdView
       function CargaMensaje(N){
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'DataMensaje',Num:N}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                    //console.log(data);
                    $('#EventoMenasje').html(data);                    
                } 
            }); //AJAX
       }//function CargaMensaje
       function Transporte(){
        var k = 0;
            for(r=1;r<=2;r++){
                var Even = parseInt(8000)*parseInt(r);
                /*********************************************/
                       if(r==1){
                          //CargaDataView(j,'2',id);
                           var Even = parseInt(K)+parseInt(1500)*parseInt(2);
                            K = Even;
                            setTimeout("CargaTrans("+r+")", Even);  
                           }else{
                            timer = setTimeout("CargaTrans("+r+")", Even);
                        }  
                     
                /*********************************************/
               }//for
       }//function Transporte
       function CargaTrans(N){
            $.ajax({//Ajax
                type: 'POST',
                url: 'TelevisorDinamico_html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'DataTransporte',N:N}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    //$('#CargaDinamic').slideUp(1000).delay('2000').fadeIn(1500);
                    //console.log(data);
                    $('#Trasnporte').html(data);                    
                } 
            }); //AJAX
       }//function CargaTrans
    </script>
	<!--[if lt IE 9]>
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
		<script src="../js/html5shiv.js"></script>
		<script src="../js/DOMAssistantComplete-2.8.1.js"></script>
		<script src="../js/PIE_IE9_uncompressed.js"></script>
		<script src="../js/PIE_IE678_uncompressed.js"></script>
	<![endif]-->
	</head>
	<body>
    <?PHP  
}
?>
