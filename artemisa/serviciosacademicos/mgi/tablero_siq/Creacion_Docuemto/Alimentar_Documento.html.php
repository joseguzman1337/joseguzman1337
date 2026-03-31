<?php
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */

switch($_REQUEST['actionID']){
    case 'CrearDocumento':
        define(AJAX,'TRUE');
        MainGeneral();
        global $C_Alimentar_Documento,$userid,$db;
        
        $a_vectt['url'] = $C_Alimentar_Documento->ConstruirDocumento($_GET['id'],$_GET['OP']);
        
        echo json_encode($a_vectt);
        exit;
        break;
    case 'VerDetalleDocumento':
        define(AJAX,'FALSE');
        MainGeneral();
        JsGenral();
        global $C_Alimentar_Documento,$userid,$db;
        
        $ind      = $_GET['ind'];
        $factor   = $_GET['factor'];
        $carat    = $_GET['carat'];
        $C_Alimentar_Documento->DetalleDocumentoIndicador($factor,$carat,$ind);
        break;
    case 'GenerarDocumento':
        define(AJAX,'FALSE');
        MainGeneral();
        JsGenral();

        global $C_Alimentar_Documento,$userid,$db;        
        $id  =  str_replace('row_','',$_GET['id']);        
        $C_Alimentar_Documento->GenerarDocumento($id);
        break;
    case 'EnviarRevision':
        MainJson();
        global $userid,$db;
        include ('../API_Monitoreo.php');
        $api = new API_Monitoreo();
        $api->initialize($db);
		
        $id = $_GET['id'];
        $data = $api->enviarIndicadorARevision($id);

        if($data['success']==false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = $data['message'];
            echo json_encode($a_vectt);
            exit;
        }else{
            $a_vectt['val'] = 'TRUE';
            echo json_encode($a_vectt);
            exit;	
        }

        break;
    case 'BuscarDocumento':
        MainJson();
        global $userid,$db;

        $id = $_GET['id'];
        $idsiq_estructuradocumento = $_GET['idDoc'];

        $SQL_idDocumento='SELECT
                doc.idsiq_documento,
                doc.siqindicador_id
            FROM siq_documento AS doc 
            INNER JOIN siq_archivo_documento AS archivo ON doc.idsiq_documento=archivo.siq_documento_id 
            WHERE doc.codigoestado=100 
                AND archivo.codigoestado=100 
                AND doc.siqindicador_id="'.$id.'"
                AND doc.idsiq_estructuradocumento="'.$idsiq_estructuradocumento.'"';
        //echo $SQL_idDocumento;

        if($Documento_id=&$db->Execute($SQL_idDocumento)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Buscar la id Documento....<br>'.$SQL_idDocumento;
            echo json_encode($a_vectt);
            exit;	
        }

        $a_vectt['val']			='TRUE';
        $a_vectt['id']		    =$Documento_id->fields['idsiq_documento'];
        echo json_encode($a_vectt);
        exit;
        break;
    case 'CargarDocumentos':
        define(AJAX,'FALSE');
        MainGeneral();
        JsGenral();
        global $C_Alimentar_Documento,$userid,$db;

        $id  = $_REQUEST['id'];
        $idDoc = $_REQUEST['idDoc'];

        $C_Alimentar_Documento->Dialogo($id,$idDoc);
        break;
    case 'BuscarPropios':
        define(AJAX,'FALSE');
        MainGeneral();
        global $C_Alimentar_Documento,$userid,$db;

        $id = $_GET['id'];
        $id_estructura = $_GET['id_estructura'];
        $id_doc = $_GET['id_doc'];
        $Caracteristica_id = $_GET['Caracteristica_id'];
        
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se agregan las siguientes variables de session para controlar cuando se debe recargar
         * el listado de indicadores dependiendo si se a agregado un nuevo archivo
         * @since octubre 9, 2018
         */
        $session_recarga = array("id"=>$id,"id_estructura"=>$id_estructura,"id_doc"=>$id_doc,"Caracteristica_id"=>$Caracteristica_id);
        
        $_SESSION["session_recarga"] = $session_recarga;
        $_SESSION["reloadIndicadores"] = 0;

        $C_Alimentar_Documento->Propios($id,$id_estructura,$Caracteristica_id,$id_doc);
        break;
    case 'BuscarTodos':
        define(AJAX,'FALSE');
        MainGeneral();
        
        //JsGenral();
        global $C_Alimentar_Documento,$userid,$db;

        $id                 =   $_GET['id'];
        $id_estructura      = $_GET['id_estructura'];
        $id_doc             = $_GET['id_doc'];
        $Caracteristica_id  = $_GET['Caracteristica_id'];

        $C_Alimentar_Documento->Todos($id,$id_estructura,$Caracteristica_id,$id_doc);
        break;
    case 'BuscarUrl':
        MainJson();
        global $userid,$db;

        $id   = $_GET['id'];
        $SQL_URL='SELECT
                doc.idsiq_documento,
                doc.siqindicador_id,
                archivo.idsiq_archivodocumento,
                archivo.Ubicaicion_url
            FROM siq_documento AS doc 
            INNER JOIN siq_archivo_documento AS archivo ON doc.idsiq_documento=archivo.siq_documento_id 
            WHERE doc.codigoestado=100 
                AND archivo.codigoestado=100 
                AND doc.siqindicador_id="'.$id.'"';

        if($Url=&$db->Execute($SQL_URL)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Buscar la URL....<br>'.$SQL_URL;
            echo json_encode($a_vectt);
            exit;	
        }

        $a_vectt['val'] = 'TRUE';
        $a_vectt['URL'] = $Url->fields['Ubicaicion_url'];
        echo json_encode($a_vectt);
        exit;
        break;
    case 'Ver':
        define(AJAX,'FLASE');
        include('../../Menu.class.php');
        MainGeneral();
        JsGenral();
        global $C_Alimentar_Documento,$userid,$db;

        $Op  = $_REQUEST['opcion'];

        if($Op==1){
            $URL = array();
            $URL[0] = 'Alimentar_Documento.html.php';

            $nombre = array();
            $nombre[0]= 'Gestionar Documento...';

            $Active = array();
            $Active[0] = 1;

            Menu_Global::writeMenu($URL,$nombre,$Active);

            $id = $_REQUEST['id'];
        }else{
            $id  =  str_replace('row_','',$_GET['id']);
        }
        
        $C_Alimentar_Documento->Nuevo_Ver($id);
        break;
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se agrega la siguiente opcion para validar las variables de session para controlar cuando se debe recargar
     * el listado de indicadores dependiendo si se a agregado un nuevo archivo
     * @since octubre 9, 2018
     */
    case "reloadIndicadores":
        if(!empty($_SESSION["reloadIndicadores"])){
            $s = true;
        }else{
            $s = false;
        }
        echo json_encode(array("s"=>$s));
        break;
    default: 
        define(AJAX,'FALSE');
        include('../../Menu.class.php'); 
        MainGeneral(); 
        JsGenral();
        global $C_Alimentar_Documento,$userid,$db;

        $URL = array();
        $URL[0] = 'Alimentar_Documento.html.php';
        $URL[1] = '../Creacion_Documento/VisualizarGeneral.html.php';
        $URL[2] = '../../SQI_Documento/Documento_upload/Documentacion/SISTEMA INTERNO DE CALIDAD Y PLANEACIÓN.pdf';

        $nombre = array();
        $nombre[0]= 'Gestionar Documento...';
        $nombre[1]= 'Previsualizar Documento En Web';
        $nombre[2]= 'Sistema Interno De Calidad Y Planeación';

        $Active = array();
        $Active[0] = 1;
        $Active[1] = 0;
        $Active[2] = 0;

        /*
         * @modified Andres Ariza <arizaandre@unbosque.edu.co>
         * se elimina el ultimo parametro para que no se redirijan a paginas en blanco
         * @since Agosto 15, 2018
         */
        Menu_Global::writeMenu($URL,$nombre,$Active,false);

        $C_Alimentar_Documento->Principal();
        break;
}

function MainGeneral(){

    global $C_Alimentar_Documento,$userid,$db;
    $proyectoMonitoreo = "Monitoreo"; 
    include_once("../../templates/template.php");
    include ('Alimentar_Documento.class.php');  $C_Alimentar_Documento = new Alimentar_Documento();

    if(AJAX=='FALSE'){
        $db=writeHeader("Alimentar Documento",true);
    }else if(AJAX=='TRUE'){ 
        $db=writeHeaderBD();
    }else{
        $db=writeHeader2("Alimentar Documento",true,false);
    }
               
    $SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

    if($Usario_id=&$db->Execute($SQL_User)===false){
        echo 'Error en el SQL Userid...<br>';
        die;
    }

    $userid=$Usario_id->fields['id'];
}

function MainJson(){
    global $userid,$db;
    include("../../templates/template.php");
    $db=writeHeaderBD();

    $SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

    if($Usario_id=&$db->Execute($SQL_User)===false){
        echo 'Error en el SQL Userid...<br>';
        die;
    }

    $userid=$Usario_id->fields['id'];
}

function JsGenral(){
    ?>
    <link rel="stylesheet" href="../../css/style.css" type="text/css" />
    <style>
        .first{
            padding: 0px 14px 0px;
            padding: 0px 14px 0px;
            font-size: 20px;
            cursor: pointer;
            text-align: center;
            display:inline-block;
            /*border:1px solid #D4D4D4; */ 
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            -khtml-border-radius: 10px;
            border-radius: 10px;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
            box-shadow: 0 1px 2px rgba(0,0,0,.2);
            background: #5D7D0E;
            text-shadow: 0 1px 1px rgba(0,0,0,.3);
            background:-moz-linear-gradient(center top , #7DB72F, #4E7D0E) repeat scroll 0 0 transparent; 
            background: -webkit-gradient(linear, left top, left bottom, from(#7DB72F), to(#4E7D0E));
            /*filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#7DB72F', endColorstr='#4E7D0E');*/
            border: 1px solid #538312;
            color: #E8F0DE;
            margin-left: 10px;
        }
        .submit {
            padding: 9px 17px;
            font-family: Helvetica, Arial, sans-serif;
            font-weight: bold;
            line-height: 1;
            color: #444;
            border: none;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.85);
            background-image: -webkit-gradient( linear, 0% 0%, 0% 100%, from(#fff), to(#bbb));
            background-image: -moz-linear-gradient(0% 100% 90deg, #BBBBBB, #FFFFFF);
            background-color: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5)
        }
	.Border{
            border:0px solid #000;
            padding:.5em;
	}
    </style>
    <script type="text/javascript" src="../../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script> 
    <script type="text/javascript">
        var oTable;
        var aSelected = [];
       
        $(document).ready(function() {
            var sql;

            sql='SELECT Estru.idsiq_estructuradocumento,Estru.nombre_documento, Estru.nombre_entidad , dis.nombre, Estru.id_carrera, Estru.tipo_documento,car.nombrecarrera, Estru.fechainicial,Estru.fechafinal, date(Estru.entrydate) AS fecha';
            sql+=' FROM siq_estructuradocumento AS Estru INNER JOIN siq_discriminacionIndicador AS dis ON Estru.tipo_documento=dis.idsiq_discriminacionIndicador  INNER JOIN carrera AS car ON (Estru.id_carrera=car.codigocarrera OR Estru.id_carrera=0)  AND Estru.codigoestado=100 AND dis.codigoestado=100 '; 
            
            oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../../server_processing.php?table=siq_estructuradocumento&sql="+sql+"&wh=Estru.codigoestado&tableNickname=Estru&group=Estru.idsiq_estructuradocumento&join=true",
                "aoColumns": [
                    { "bVisible": true, "aTargets": [ 0 ] },
                    { "bVisible": true, "aTargets": [ 1 ] },
                    { "fnRender": function ( oObj ) {
                            if(oObj.aData[4]==1){
                                return oObj.aData[2];     
                            } else if(oObj.aData[4]==3) {
                                return oObj.aData[2]+' :: '+oObj.aData[5];
                            } 
                        },
                        "aTargets": [ 2 ]
                    },
                    { "bVisible": false, "aTargets": [ 3 ] },
                    { "bVisible": false, "aTargets": [ 4 ] },
                    { "bVisible": false, "aTargets": [ 5 ] },
                    { "sClass": "column_fecha","bVisible": true, "aTargets": [ 6 ] },
                    { "sClass": "column_fecha","bVisible": true, "aTargets": [ 7 ] },
                    { "sClass": "column_fecha","bVisible": true, "aTargets": [ 8 ] }
                ]
            });

            $('#example tbody tr').live('click', function () {
                var id = this.id;
			    
                var index = jQuery.inArray(id, aSelected);
                if ( $(this).hasClass('row_selected') && index === -1  ) {
                    aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
					
                    if (aSelected.length>1) aSelected.shift();
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                }
            });
            

            $('#ToolTables_example_1').click( function () {
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled')){
                    Ver_Estructura();
                }
            } );
            
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled')){
                    GenerarDocumento();
                }               
            } );
            
        } );
	  
	function Ver_Estructura(){
            if(aSelected.length==1){
                var id = aSelected[0];
            }else{
               return false;
            }

            $.ajax({//Ajax
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                //dataType: 'json',
                data:({actionID: 'Ver',id:id,opcion:0}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#container').html(data);
                } 
           }); //AJAX
        }
		
	function Sombra(i,j,k,l){
            $('#Td_indicador_'+i+'_'+j+'_'+k+'_'+l).css('background-color','#0FF');
            $('#Td_imagen_'+i+'_'+j+'_'+k+'_'+l).css('background-color','#0FF');
        }
        
	function Sin(i,j,k,l){
            $('#Td_indicador_'+i+'_'+j+'_'+k+'_'+l).css('background-color','#FFF');
            $('#Td_imagen_'+i+'_'+j+'_'+k+'_'+l).css('background-color','#FFF');
        }
        
	function Docuemtal(i,j,k,l){
            var  id = $('#id_ind_'+i+'_'+j+'_'+k+'_'+l).val();

            $.ajax({//Ajax
                type: 'GET',
                url: '../../SQI_Documento/Carga_Documento.html.php',
                async: false,
                //dataType: 'json',
                data:({actionID: 'Documental',id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#container').html(data);
                } 
            }); //AJAX
        }
        
	function BuscarUrl(i){
            var  id = $('#id_ind_'+i).val();

            $.ajax({//Ajax
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                dataType: 'json',
                data:({actionID: 'BuscarUrl',id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }else{
                        popUp_3('../../SQI_Documento/'+data.URL,'1500','800');
                    }
                } 
            }); //AJAX
	}
        
	function Ver_indicador(i,id,id_estructura,id_doc,Caracteristica_id){
            $('#Factor_carga').val(id);
            $('#Estructura_Carga').val(id_estructura);
            $('#Caracteristica_Carga').val(Caracteristica_id);

            if($('#todos').is(':checked')){
                $.ajax({//Ajax
                    type: 'GET',
                    url: 'Alimentar_Documento.html.php',
                    async: false,
                    //dataType: 'json',
                    data:({actionID: 'BuscarTodos',id:id,id_estructura:id_estructura,Caracteristica_id:Caracteristica_id,id_doc:id_doc}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        $('#cargado').val('1');
                        $('#DivIndicadores').html(data);
                    } 
                }); //AJAX 	
            }else{
                $.ajax({//Ajax
                    type: 'GET',
                    url: 'Alimentar_Documento.html.php',
                    async: false,
                    //dataType: 'json',
                    data:({actionID: 'BuscarPropios',id:id,id_estructura:id_estructura,Caracteristica_id:Caracteristica_id,id_doc:id_doc}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        $('#cargado').val('1');
                        $('#DivIndicadores').html(data);
                    } 
                });
            }
        }
        
	function Ver_Caracteristica0(i,id,id_doc){
            var index = $('#List_Factores').val();
            $('#'+i).addClass('ui-state-highlight');

            for(j=0;j<index;j++){
                if(j!=i){
                    $('#'+j).removeClass('ui-state-highlight');
                    $('#Caracteristica_'+j).css('display','none');
                }
            }

            $('#Caracteristica_'+i).css('display','block');
            
            $.ajax({//Ajax
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                data:({actionID: 'VerCaracteristicas0',i:i,id:id,id_doc:id_doc}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#Caracteristica_'+i).html(data);
                } 
            });
        }
        
	function Ver_Caracteristica1(i,id,id_estructura,id_doc,Caracteristica_id){
            $('#Caracteristica1_'+i).css('display','block');
            
            $.ajax({
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                //dataType: 'json',
                data:({actionID: 'VerCaracteristicas1',i:i,id:id,id_estructura:id_estructura,id_doc:id_doc,Caracteristica_id:Caracteristica_id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#Caracteristica1_'+i).html(data);
                } 
            });
        }
        
	function Ver_Caracteristica2(i,id,id_doc){
            $('#Caracteristica2_'+i).css('display','block');
            
            var id_estructura = $('#id_'+i).val();	
			
            $.ajax({
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                //dataType: 'json',
                data:({actionID: 'VerCaracteristicas2',id:id,id_estructura:id_estructura,id_doc:id_doc}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#Caracteristica2_'+i).html(data);
                } 
            });				
        }
        
	function ver(id_Doc){
            if($('#cargado').val()=='1' || $('#cargado').val()==1){
                var id = $('#Factor_carga').val();
                var id_estructura = $('#Estructura_Carga').val();
                var Caracteristica_id = $('#Caracteristica_Carga').val();

                if($('#todos').is(':checked')){
                    $.ajax({
                        type: 'GET',
                        url: 'Alimentar_Documento.html.php',
                        async: false,
                        //dataType: 'json',
                        data:({actionID: 'BuscarTodos',id:id,id_estructura:id_estructura,Caracteristica_id:Caracteristica_id,id_doc:id_Doc}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                        success: function(data){
                            $('#cargado').val('1');
                            $('#DivIndicadores').html(data);
                        } 
                    });
                }else{
                    $.ajax({//Ajax
                        type: 'GET',
                        url: 'Alimentar_Documento.html.php',
                        async: false,
                        //dataType: 'json',
                        data:({actionID: 'BuscarPropios',id:id,id_estructura:id_estructura,Caracteristica_id:Caracteristica_id,id_doc:id_Doc}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                        success: function(data){
                            $('#cargado').val('1');
                            $('#DivIndicadores').html(data);
                        } 
                    });
                }

            }
        }
        
	function validar_tipo(dato,id){
            var Tipo_indicador = $('#Tipo_indicador_'+id).val();
            var Anexo          = $('#Anexo_'+id).val();
            var Analisi        = $('#Analisi_'+id).val();

            switch(dato){
                case '0':
                    if(Tipo_indicador!=1){
                        $('#Tipo_Carga_'+id).val('-1');
                        alert('Error este indicador no es Documental...!');
                        return false;
                    }
                    break;
                case '1':
                    if(Tipo_indicador!=1){
                        if(Analisi!=1){
                            $('#Tipo_Carga_'+id).val('-1');
                            alert('Error este indicador No tiene \n Asociado un Documento de Analisis...!');
                            return false;
                        }
                    }else{
                        if(Analisi!=1){
                            $('#Tipo_Carga_'+id).val('-1');
                            alert('Error este indicador No tiene \n Asociado un Documento de Analisis...!');
                            return false;
                        }
                    }
                    break;
                case '2':
                    if(Tipo_indicador!=1){
                        if(Anexo!=1){
                            $('#Tipo_Carga_'+id).val('-1');
                            alert('Error este indicador  No tiene \n Asociado un Documento Anexo...!');
                            return false;
                        }
                    }else{
                        if(Anexo!=1){
                            $('#Tipo_Carga_'+id).val('-1');
                            alert('Error este indicador  No tiene \n Asociado un Documento Anexo...!');
                            return false;
                        }
                    }
                    break;  
                case'3':
                    if(Tp!=1){
                        if(Ax!=1 && An!=1){
                            alert('El Indicador Selecionado No es de Tipo Documental y No tiene asociado \n un Documento Analisis o Anexo');
                            return false;
                        }
                    }
                    break;
            }
	}
        
	function Validar(id){
            if(!$.trim($('#file').val())){
                alert('Carge un Archivo...!');
                return false;
            }
            if($('#Tipo_Carga_'+id).val()==-1){
                alert('Elige un tipo de documento...!');
                return false;
            }
            if(!$.trim($('#Descripcion_'+id).val())){
                alert('Ingrese la descripcion del Archivo...!');
                return false;
            }
            return true;
        }
        
	function CargarDocumento(id,idDoc,tipo){
            if(tipo==3){
                var url  = '../../datos/reportes/analisisReporte.php?id=1&idI='+id;
            }else{
                var url  = 'Alimentar_Documento.html.php?actionID=CargarDocumentos&id='+id+'&idDoc='+idDoc;
            }
            
            var centerWidth = (window.screen.width - 850) / 2;
            var centerHeight = (window.screen.height - 700) / 2;

            var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
            var mypopup = window.open(url,"",opciones);

            window.focus();
            mypopup.focus();
        }
        
	function VerModificarDocumentos(id,idDoc){
            $.ajax({//Ajax
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                dataType: 'json',
                data:({
                    actionID: 'BuscarDocumento',
                    id:id,
                    idDoc:idDoc
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                    }else{
                        var url  = '../../SQI_Documento/Documento_Ver.html.php?actionID=Modificar_New&idsiq_estructuradocumento='+idDoc+'&Docuemto_id='+data.id;
                        var centerWidth = (window.screen.width - 850) / 2;
                        var centerHeight = (window.screen.height - 700) / 2;

                        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
                        var mypopup = window.open(url,"",opciones);
                        
                        window.focus();
                        mypopup.focus();
                    }									
                } 
            });
        }
	function IrSeguimiento(id_Gen,id_ind){
            var url  = '../../monitoreo/monitoreo/wdCalendar/seguimiento.php?&indicadorG='+id_Gen+'&idIndicador='+id_ind+'&close=true';
            var centerWidth = (window.screen.width - 850) / 2;
            var centerHeight = (window.screen.height - 700) / 2;

            var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
            var mypopup = window.open(url,"",opciones);
            
            window.focus();
            mypopup.focus();
        }
        
	function Visualizar(id_ind){
            var url  = 'Seguimiento_Control.php?idIndicador='+id_ind;
            var centerWidth = (window.screen.width - 850) / 2;
            var centerHeight = (window.screen.height - 700) / 2;

            var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
            var mypopup = window.open(url,"",opciones);
            
            window.focus();
            mypopup.focus();
        }
        
	function Control(id_Gen,id_ind,Doc_id){
            var url  = '../../monitoreo/monitoreo/wdCalendar/calidad.php?&indicadorG='+id_Gen+'&idIndicador='+id_ind+'&close=true&Doc_id='+Doc_id;
            var centerWidth = (window.screen.width - 850) / 2;
            var centerHeight = (window.screen.height - 700) / 2;

            var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
            var mypopup = window.open(url,"",opciones);
            
            window.focus();
            mypopup.focus();
        }
        
	function EnvairRevision(id_ind){
            if(confirm('Seguro Desea Enviar a Revisi\u00f3n...?')){
                $.ajax({
                    type: 'GET',
                    url: './Alimentar_Documento.html.php',
                    async: false,
                    dataType: 'json',
                    data:({actionID: 'EnviarRevision',id:id_ind}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                        }else{
                            /**
                             * @modified Andres Ariza <arizaandres@unbosque.edu.do>
                             * Se modifica el llamado a la funcion de recarga de indicadores de modo que
                             * invoque la misma funcion de carga original
                             * @since octubre 9, 2018
                             */
                            Ver_indicador(0, id, id_estructura, id_doc, Caracteristica_id);
                        }
                    }
                });
            }
        }	
        
	function Sombralight(i,id){
            $('#Caracteristica_li_'+id+'_'+i).addClass('ui-state-highlight');
        }	
        
	function SinSombra(i,id){
            $('#Caracteristica_li_'+id+'_'+i).removeClass('ui-state-highlight');
            $('#Caracteristica_li_'+id+'_'+i).addClass('ui-state-default');
        }
        
	function VerIndicador(indicador_id,tipo,Descri,f_inicial,f_final,idInd,id_Doc){
            if(tipo==1){
                if(indicador_id==""){
                    var Data_Url = '../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&idsiq_estructuradocumento='+id_Doc+'&indicador_id='+idInd;
                } else {
                    var Data_Url = '../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&idsiq_estructuradocumento='+id_Doc+'&Docuemto_id='+indicador_id+'&Fecha_ini='+f_inicial+'&Fecha_fin='+f_final;
                }
            }
            if(tipo==2){
                var Data_Url ='../../autoevaluacion/interfaz/prueba_resul.php?indicador_id='+indicador_id+'&idsiq_estructuradocumento='+id_Doc+'&Discriminacion='+Descri+'&Fecha_ini='+f_inicial+'&Fecha_fin='+f_final;
            }
            if(tipo==3){
                var Data_Url ='../../datos/reportes/detalle.php?idIndicador='+indicador_id+'&idsiq_estructuradocumento='+id_Doc+'&actualizar=1'+'&Fecha_ini='+f_inicial+'&Fecha_fin='+f_final;
            }	
            var url  = Data_Url;
            var centerWidth = (window.screen.width - 850) / 2;
            var centerHeight = (window.screen.height - 700) / 2;

            var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
            var mypopup = window.open(url,"",opciones);
            
            window.focus();
            mypopup.focus();
        }
        
	function ActualizaFormulario(id_ind){
            var Data_Url ='../../datos/registroInformacion/form.php?idIndicador='+id_ind;

            var url  = Data_Url;
            var centerWidth = (window.screen.width - 850) / 2;
            var centerHeight = (window.screen.height - 700) / 2;

            var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
            var mypopup = window.open(url,"",opciones);
            
            window.focus();
            mypopup.focus();

        }
        
        function GenerarDocumento(){
            if(aSelected.length==1){
                var id = aSelected[0];
            }else{
                return false;
            }

            $.ajax({//Ajax
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'GenerarDocumento',id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#container').html(data);
                } 
            });
        }
        
        function Color(i,n,f){
            var Tr_id  = '#Tr_'+i+'_'+f;

            if(n==1){
                $(Tr_id).css('background-color','#D0E5FF');
            }else{
                $(Tr_id).css('background-color','#FFFFFF');
            }
        }
        
        function VerDocumentosIndicadores(ind,factor,carat){
            $.ajax({//Ajax
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                dataType: 'html',
                data:({actionID: 'VerDetalleDocumento',ind:ind,factor:factor,carat:carat}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#Tr_Detalle_'+ind).css('visibility','visible');
                    $('#Td_Cargar_'+ind).html(data);
                } 
            });
        }
        
        function CerrarAdjunto(ind){
            $('#Tr_Detalle_'+ind).css('visibility','collapse');
        }
        
        function CrearDocumento(id){
            $('#CreateDoc').css('display','none');
            $('#CreatePDF').css('display','none');
            $('#ImagenCarga').html('<span style="color:green; font-size:18px;">Generando Documento Word....</span><img src="../../images/ajax-loader.gif" width="30" style="text-align: center;" />');													
            $.ajax({//Ajax
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                dataType: 'json',
                data:({actionID: 'CrearDocumento',id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#ImagenCarga').html('');
                    $('#CreateDoc').css('display','inline');
                    $('#CreatePDF').css('display','inline'); 
                    location.href='../../SQI_Documento/DocumentosCreados/mergedDocx.docx';			
                } 
            });
        }
        
        function CrearDocumentoPDF(id){
            $('#CreateDoc').css('display','none');
            $('#CreatePDF').css('display','none');
            $('#ImagenCarga').html('<span style="color:green; font-size:18px;">Generando Documento PDF....</span><img src="../../images/ajax-loader.gif" width="30" style="text-align: center;" />');
            
            $.ajax({
                type: 'GET',
                url: 'Alimentar_Documento.html.php',
                async: false,
                dataType: 'json',
                data:({actionID: 'CrearDocumento',id:id,OP:'PDF'}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#ImagenCarga').html('');
                    $('#CreateDoc').css('display','inline');
                    $('#CreatePDF').css('display','inline'); 
                    var Data_Url ='Anexos.pdf';

                    var URL  = Data_Url;
                    var centerWidth = (window.screen.width - 850) / 2;
                    var centerHeight = (window.screen.height - 700) / 2;

                    var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
                    var mypopup = window.open(URL,"",opciones);
                    //para poner la ventana en frente
                    window.focus();
                    mypopup.focus();	
                } 
            });
        }
        
	$(document).ready(function(){
            $('div#DivFactores ul.connectedSortable li a').on( "click",function (e) {			
                e.preventDefault();	
                var ullist = $(this).parent().children('ul:first');
                //console.log(ullist);
                ullist.toggle('slow');
                //console.log($(this).parent());
                if($(this).parent().hasClass("ui-state-highlight")){
                    $(this).parent().removeClass("ui-state-highlight");
                } else {
                    $(this).parent().addClass("ui-state-highlight");
                }			
            });
	});
    </script>
    <?php
    }	
?>
