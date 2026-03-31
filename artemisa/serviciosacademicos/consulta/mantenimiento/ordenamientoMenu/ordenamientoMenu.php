<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
//error_reporting(0);
$rutaado = "../../../funciones/adodb/";
require_once("../../../Connections/sala2.php");
require_once('funciones/MySQL.php');
require_once('funciones/Menu.php');
require_once('funciones/BreadCrumb.php');
require_once('funciones/FullTree.php');
//require_once('../../../funciones/clases/autenticacion/redirect.php');
mysql_select_db($database_sala, $sala);
//print_r($_SESSION);
if (!empty($_SESSION['MM_Username'])) {
    $query_usuario = "SELECT u.* FROM usuario u WHERE u.usuario = '" . $_SESSION['MM_Username'] . "'";
    $op_usuario = mysql_query($query_usuario, $sala) or die(mysql_error());
    $row_op_usuario = mysql_fetch_assoc($op_usuario);
    $_SESSION['idusuario'] = $row_op_usuario['idusuario'];
    if ($row_op_usuario['codigotipousuario'] == 300 or $_SESSION['MM_Username'] == 'admintecnologia') {
        $administrador = true;
    } else {
        $administrador = false;
    }
} else {
    //echo "<h1>No hay variable de sesion de usuario, no se puede continuar</h1>";
    exit();
}


$db = & new MySQL($hostname_sala, $username_sala, $password_sala, $database_sala);

$baseUrl = '';

$location = str_replace($baseUrl, '', $_SERVER['PHP_SELF']);

$menu = & new FullTree($db, $location, $_SESSION['MM_Username'], $administrador);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Organizador de Menús SALA</title>
        <script type="text/javascript" src="js/ajax.js"></script>
        <script type="text/javascript" src="js/context-menu.js"></script><!-- IMPORTANT! INCLUDE THE context-menu.js FILE BEFORE drag-drop-folder-tree.js -->
        <script type="text/javascript" src="js/drag-drop-folder-tree.js">


            /************************************************************************************************************
             (C) www.dhtmlgoodies.com, July 2006
             
             Update log:
             
             
             This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.
             
             Terms of use:
             You are free to use this script as long as the copyright message is kept intact.
             
             For more detailed license information, see http://www.dhtmlgoodies.com/index.html?page=termsOfUse
             
             Thank you!
             
             www.dhtmlgoodies.com
             Alf Magne Kalleland
             
             ************************************************************************************************************/
        </script>

        <script type="text/javascript" src="js/separateFiles/dhtmlSuite-common.js"></script>
        <script type="text/javascript" src="js/separateFiles/dhtmlSuite-menuItem.js"></script>
        <script type="text/javascript" src="js/separateFiles/dhtmlSuite-menuModel.js"></script>
        <script type="text/javascript" src="js/separateFiles/dhtmlSuite-menuBar.js"></script>	
        <script type="text/javascript" src="js/config.js"></script>
        <script type="text/javascript">DHTMLSuite.include("windowWidget");</script>
        <script type="text/javascript">DHTMLSuite.include('form');</script>
        <script type="text/javascript">DHTMLSuite.include('formValidator');</script>
        <script type="text/javascript">DHTMLSuite.include('calendar');</script>
        <link rel="stylesheet" href="css/drag-drop-folder-tree.css" type="text/css"></link>
        <link rel="stylesheet" href="css/context-menu.css" type="text/css"></link>        
        <style type="text/css">
            /* CSS for the demo */
            img{
                border:0px;
            }
            #btnExpandAll {
                    font-weight: bold;
                    cursor: pointer;
                    padding: 5px;
                    margin: 0 20px 20px 0;
                    border: 1px solid #538312;
                    background: #538312;
                    border-radius: 8px 8px 8px 8px;
            }

            #btnExpandAll:hover {
                    background: #ddd;
            }
        </style>

        <script type="text/javascript">
            // First menu
            var menuModel = new DHTMLSuite.menuModel();
            //menuModel.addSeparator();
            //menuModel.addItem(11,'Gestión usuarios','../images/open.gif','',false,'Open document','');
            //menuModel.setSubMenuWidth(11,200);
            //menuModel.addItem(111,'Agregar Usuarios','','',11,'Agregar usuarios a SALA','ventanaAgregaEditaUsuario()');
            //menuModel.addItem(112,'Copiar permisos usuarios','','',11,'Copiar permisos de un usuario a otro','');
            //menuModel.addItem(id,itemText,itemIcon,url,parentId,helpText,jsFunction,type,submenuWidth)
            //menuModel.init();

            var menuBar = new DHTMLSuite.menuBar();
            menuBar.addMenuItems(menuModel);
            menuBar.setTarget('contenedorMenu');

        </script>
        <script src="js/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="css/style.min.css" />        
        <script src="js/jstree.min.js"></script>
    </head>
    <body>
        <div id="contenedorMenu"></div>
        <script language="javascript">
            menuBar.init();
        </script>
    <br>
    <strong>Editor de menús aplicación SALA Universidad El Bosque</strong><br><br>
    <div id="esperando" style="visibility:hidden;position:absolute; width:640px; height:480px; z-index:1; left: 401px; top: 162px; overflow: auto; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;"></div><!--visibility:hidden;-->
    <ul id="dhtmlgoodies_tree2" >
        <ul>
            <?php
            // Display the context menu
                $posActualArray = array();
                $i = 0;
                $temp='';
            while ($item = $menu->fetch()) {             
                    $icono = "data-jstree='{\"icon\":\"images/sheet.png\"}'";
                    $padre = null;
                    foreach ($item as $values) {
                        if ($padre == null) {
                            $padre = $values['codigotipomenuopcion'];
                        }
                    }
                  
                   if ($padre == 1) {
                        $icono = "";
                    }
                    if ($item->isStart()) {
                        echo ( "<ul>" );
                    } else if ($item->isEnd()) {
                        echo ( "</li></ul>" );
                    } else
                    if (!$administrador) {
                       echo $posActual=$item->id();
                        echo ( "<li " . $icono . " noDrag='true' id='" . $item->id() . "'><a href=\"" . '#' . "\">" . $item->description() . '-' . $item->name() . "</a>" );
                    } else {
                       $posActual=$item->id();                        
                        echo ( "<li " . $icono . " id='" . $item->id() . "'><a href=\"" . '#' . "\">" . $item->description() . '-' . $item->name() . "</a>" );
                    }
                      if ($posActual != null){               
                          /* Acutalizar las posiciones para no repetir */
                          $query_actualiza = "UPDATE 
                                    menuopcion set posicionmenuopcion='" .$i. "' 
                                WHERE idmenuopcion='" .$item->id(). "';
                                ";
                             $updatePos = mysql_query($query_actualiza, $sala) or die(mysql_error());
                             /*Fin Actualiza*/
                             //Armar Query Con las  posiciones que llega el menú
                                    $posActualArray[$i] = $posActual+",";
                    }
                $i = $i + 1;
            }
            ?>
        </ul>
    </ul>
    <div align="center">
        <form>
            <input type="button" onclick="saveMyTree()" id="btnExpandAll" value="Guardar">
        </Form>
    </div>
    <script type="text/javascript">


        //--------------------------------
        // Save functions
        //--------------------------------
        var ajaxObjects = new Array();

        // Use something like this if you want to save data by Ajax.
        function saveMyTree()
        {
            var arrayJS =<?php echo json_encode($posActualArray);?>;
            var url = "guardarNodos.php";
            $(".jstree").jstree('open_all');
            saveString = treeObj.getNodeOrders();
            var ajaxIndex = ajaxObjects.length;
            ajaxObjects[ajaxIndex] = new sack();
            var url = 'guardarNodos.php?saveString=' + saveString +'&posActualArray='+ arrayJS ;
            ajaxObjects[ajaxIndex].requestFile = url;	// Specifying which file to get                
            ajaxObjects[ajaxIndex].onCompletion = function () {
                saveComplete(ajaxIndex);
            };	// Specify function that will be executed after file has been found
            ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function 
            $(".jstree").jstree('close_all');

        }

        function saveComplete(index)
        {
            //alert(ajaxObjects[index].response);
            document.getElementById('respuesta').innerHTML = ajaxObjects[index].response;                       
            location.reload();           
        }

        // Call this function if you want to save it by a form.
        function saveMyTree_byForm()
        {
            document.myForm.elements['saveString'].value = treeObj.getNodeOrders();
            document.myForm.submit();
        }

        var http = instanciaAjax();
        var edicionModeloObj;

        function instanciaAjax() {

            var ro;
            var browser = navigator.appName;
            if (browser == 'Microsoft Internet Explorer') {
                ro = new ActiveXObject("Microsoft.XMLHTTP");
            } else {
                ro = new XMLHttpRequest();
            }
            return ro;
        }

        function desactivaBotonEnviar() {
            document.getElementById('Enviar').disabled = true;
        }

        function activaBotonEnviar() {
            document.getElementById('Enviar').disabled = false;
        }

        function leeTopPos(inputObj)
        {
            var returnValue = inputObj.offsetTop;
            while ((inputObj = inputObj.offsetParent) != null) {
                if (inputObj.tagName != 'HTML')
                    returnValue += inputObj.offsetTop;
            }
            return returnValue;
        }

        function leeVertPos(inputObj)
        {
            var returnValue = inputObj.offsetLeft;
            while ((inputObj = inputObj.offsetParent) != null) {
                if (inputObj.tagName != 'HTML')
                    returnValue += inputObj.offsetLeft;
            }
            return returnValue;
        }

        function activaBotonEnviarAgregaUsuario() {
            document.getElementById('EnviarAgregarUsuario').disabled = false;
        }

        function desactivaBotonEnviarAgregaUsuario() {
            document.getElementById('EnviarAgregarUsuario').disabled = true;
        }

        function confirmaAgregaUsuario() {
            var respuesta = document.getElementById('datosUsuarioSoporteTecnico').innerHTML;
            if (respuesta == 'OK') {
                alert('Usuario agregado correctamente');
                edicionModeloObj.close();

            }
            else {
                alert('Error en insercción de usuario');
            }
        }
        function ventanaAgregaEditaUsuario() {
            agregarUsuariosModelo = new DHTMLSuite.windowModel({windowsTheme: false, id: 'agregarUsuarios', title: 'Agregar Usuarios', xPos: 50, yPos: 50, minWidth: 100, minHeight: 100, width: 500, height: 400});//cookieName:'ventanaRevisionCasos'
            agregarUsuariosModelo.addTab({id: 'agregarUsuario', htmlElementId: 'agregarUsuario', tabTitle: 'Datos Usuario SALA'});
            edicionModeloObj = new DHTMLSuite.windowWidget(agregarUsuariosModelo);
            edicionModeloObj.init();
            http.open('post', 'agregarUsuario.php');
            http.onreadystatechange = function handlerAgregarUsuario() {
                if (http.readyState == 4) {
                    document.getElementById('agregarUsuario').innerHTML = http.responseText;
                    formValidadorAgregaEditaUsuario = new DHTMLSuite.formValidator({formRef: 'formAgregarUsuario', keyValidation: true, callbackOnFormValid: 'activaBotonEnviarAgregaUsuario', callbackOnFormInvalid: 'desactivaBotonEnviarAgregaUsuario', indicateWithBars: false});
                    formAgregaEditaUsuario = new DHTMLSuite.form({formRef: 'formAgregarUsuario', action: 'formAgregarUsuarioInserta.php', callbackOnComplete: 'confirmaAgregaUsuario', responseEl: 'datosUsuarioSoporteTecnico'});
                }
            }
            http.send(null);
        }

        function editarNodoMenu(id, obj) {
            var posX = leeTopPos(obj);
            var posY = leeVertPos(obj);
            //alert(posX+' '+posY);
            edicionMenuModelo = new DHTMLSuite.windowModel({windowsTheme: false, id: 'ventanaEdicionMenu', title: 'Edición de menús', xPos: posY, yPos: posX - 50, minWidth: 100, minHeight: 100, width: 420, height: 300});//cookieName:'ventanaRevisionCasos'
            edicionMenuModelo.addTab({id: 'edicionMenu', htmlElementId: 'edicionMenu', tabTitle: 'Editar'});
            edicionModeloObj = new DHTMLSuite.windowWidget(edicionMenuModelo);
            edicionModeloObj.init();
            http.open('post', 'editarNodo.php?idmenuopcion=' + id);
            http.onreadystatechange = manejadorEditarMenu;
            http.send(null);
        }
        function manejadorEditarMenu() {
            if (http.readyState == 4) {
                //document.getElementById('esperando').innerHTML=null;
                document.getElementById('edicionMenu').innerHTML = http.responseText;
                formEdicion = new DHTMLSuite.form({formRef: 'formularioEdicion', action: 'guardarEdicionNodo.php', responseEl: 'esperando', callbackOnComplete: 'reCarga()'});
                formValidacion = new DHTMLSuite.formValidator({formRef: 'formularioEdicion', keyValidation: true, callbackOnFormValid: 'activaBotonEnviar', callbackOnFormInvalid: 'desactivaBotonEnviar', indicateWithBars: false});
            }
        }

        function permisosNodoMenu(id, obj) {
            var posX = leeTopPos(obj);
            var posY = leeVertPos(obj);
            //alert(posX+' '+posY);
            permisosMenuModelo = new DHTMLSuite.windowModel({windowsTheme: false, id: 'ventanaPermisosMenu', title: 'Edición de permisos', xPos: posY, yPos: posX - 50, minWidth: 100, minHeight: 100, width: 800, height: 600});//cookieName:'ventanaRevisionCasos'
            permisosMenuModelo.addTab({id: 'permisosMenu', htmlElementId: 'permisosMenu', tabTitle: 'Editar'});
            permisosModeloObj = new DHTMLSuite.windowWidget(permisosMenuModelo);
            permisosModeloObj.init();
            http.open('post', 'permisosNodo.php?idmenuopcion=' + id);
            http.onreadystatechange = manejadorPermisosNodoMenu;
            http.send(null);
        }

        function manejadorPermisosNodoMenu() {
            if (http.readyState == 4) {
                document.getElementById('permisosMenu').innerHTML = http.responseText;
            }
        }

        function asignarPermisoNodo(obj, idmenuopcion) {
            var estadoPermisoRol;
            if (obj.checked == true) {
                estadoPermisoRol = 'noexiste';
                //alert('checked');
            }
            else {
                estadoPermisoRol = 'existe';
                //alert('unchecked');
            }
            http.open('post', 'guardarPermisosNodo.php?estado=' + estadoPermisoRol + '&idmenuopcion=' + idmenuopcion + '&idusuario=' + obj.value);
            http.onreadystatechange = function () {
                if (http.readyState == 4) {
                    if (http.responseText != 'OK') {
                        alert("Error! " + http.responseText);
                        document.getElementById('esperando').innerHTML = http.responseText;
                        document.getElementById('esperando').style.visibility = 'visible';
                    }
                }
            }
            http.send(null);
        }

        function nuevoMenu(obj) {
            var posX = leeTopPos(obj);
            var posY = leeVertPos(obj);
            //alert(posX+' '+posY);
            edicionMenuModelo = new DHTMLSuite.windowModel({windowsTheme: false, id: 'ventanaEdicionMenu', title: 'Edición de menús', xPos: posY + 200, yPos: posX - 500, minWidth: 100, minHeight: 100, width: 420, height: 300});//cookieName:'ventanaRevisionCasos'
            edicionMenuModelo.addTab({id: 'edicionMenu', htmlElementId: 'edicionMenu', tabTitle: 'Editar'});
            edicionModeloObj = new DHTMLSuite.windowWidget(edicionMenuModelo);
            edicionModeloObj.init();
            http.open('post', 'editarNodo.php?nuevo');
            http.onreadystatechange = manejadorEditarMenu;
            http.send(null);
        }

        function reCarga() {
            if (document.getElementById('esperando').innerHTML == 'OK') {
                window.location.href = 'ordenamientoMenu.php';
            }
            else {
                alert('Falló actualización del menú' + document.getElementById('esperando').innerHTML);
            }
        }

        var calendarObjForForm = new DHTMLSuite.calendar({minuteDropDownInterval: 10, numberOfRowsInHourDropDown: 5, callbackFunctionOnDayClick: 'getDateFromCalendar', isDragable: true, displayTimeBar: true});

        function pickDate(buttonObj, inputObject)
        {
            /*if(divCalendario!=null){
             ventanaEdicionMenu=edicionModeloObj.getDivElement();
             //document.getElementById('burbujita').innerHTML="zindex ventana "+ventanaPrincipal.style.zIndex;
             //document.getElementById('burbujita2').innerHTML="zindex calendario "+divCalendario.style.zIndex;
             calendarObjForForm.cambiaZindex(ventanaEdicionMenu.style.zIndex);
             }
             */
            calendarObjForForm.setCalendarPositionByHTMLElement(inputObject, 0, inputObject.offsetHeight + 2);	// Position the calendar right below the form input
            calendarObjForForm.setInitialDateFromInput(inputObject, 'yyyy-mm-dd hh:ii');	// Specify that the calendar should set it's initial date from the value of the input field.
            calendarObjForForm.addHtmlElementReference('myDate', inputObject);	// Adding a reference to this element so that I can pick it up in the getDateFromCalendar below(myInput is a unique key)
            if (calendarObjForForm.isVisible()) {
                calendarObjForForm.hide();
            } else {
                calendarObjForForm.resetViewDisplayedMonth();	// This line resets the view back to the inital display, i.e. it displays the inital month and not the month it displayed the last time it was open.
                divCalendario = calendarObjForForm.display();
            }
        }
        function getDateFromCalendar(inputArray)
        {
            var references = calendarObjForForm.getHtmlElementReferences(); // Get back reference to form field.
            references.myDate.value = inputArray.year + '-' + inputArray.month + '-' + inputArray.day + ' ' + inputArray.hour + ':' + inputArray.minute;
            calendarObjForForm.hide();

        }

    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            /* $("#btnPruebaCargar").on("click",function(){
             alert("Prueba"); 
             var prueba = <?php echo json_encode($posActualArray); ?>;
             var url = "guardarNodos.php";
             alert(prueba);
             $.ajax({
             url: url,
             type:"GET",
             data: { prueba : prueba },
             success: function(data){
             alert(data);
             alert("Prueba2");
             ///procesar la respuesta.
             }
             });
             });*/
        });



        $(function () {

            $('#dhtmlgoodies_tree2')
                    .jstree({
                        "core": {
                            "animation": 0,
                            "expand": true,
                            "check_callback": true,
                            "themes": {"stripes": true},
                        },
                        "types": {
                            "root": {
                                "icon": {
                                    "image": "jstree-file"
                                },
                                "valid_children": ["default", "file"],
                                "max_depth": 2,
                                "hover_node": false,
                                "select_node": function () {
                                    return false;
                                }
                            },
                            "default": {
                                "valid_children": ["default", "file"]
                            }
                        },
                        "plugins": ["contextmenu", "dnd", "search", "state", "types", "wholerow"]
                    });
        });

        treeObj = new JSDragDropTree('<?php
            if ($administrador) {
                echo 'administrador';
            }
            ?>');
        treeObj.setTreeId('dhtmlgoodies_tree2');
        treeObj.setMaximumDepth(10);
        treeObj.setMessageMaximumDepthReached('Profundidad máxima alcanzada'); // If you want to show a message when maximum depth is reached, i.e. on drop.
        treeObj.initTree();
        if (navigator.appName == 'Microsoft Internet Explorer') {

            treeObj.collapseAll();
        }
        else {
            treeObj.expandAll();
        }
    </script>

    <!--<a href="#" onclick="treeObj.collapseAll()">Contraer Todo</a> | 
    <a href="#" onclick="treeObj.expandAll()">Expandir Todo</a>-->

    <!-- Form - if you want to save it by form submission and not Ajax -->
    <form name="myForm" method="post" action="guardarNodos.php">
        <input type="hidden" name="saveString">
    </form>
    <div id="respuesta"></div>
</body>
</html>
