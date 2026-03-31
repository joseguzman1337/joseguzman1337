<?php
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/sala2.php");
require_once('funciones/MySQL.php');
require_once('funciones/Menu.php');
require_once('funciones/BreadCrumb.php');
require_once('funciones/FullTree.php');

$db=& new MySQL($hostname_sala,$username_sala,$password_sala,$database_sala);

$baseUrl='';

$location = str_replace ($baseUrl,'',$_SERVER['PHP_SELF']);

$menu=& new FullTree($db,$location);

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
	<script type="text/javascript" src="js/config.js"></script>
	<script type="text/javascript">DHTMLSuite.include("windowWidget");</script>
	<script type="text/javascript">DHTMLSuite.include('form');</script>
	<script type="text/javascript">DHTMLSuite.include('formValidator');</script>
	
	<link rel="stylesheet" href="css/drag-drop-folder-tree.css" type="text/css"></link>
	<link rel="stylesheet" href="css/context-menu.css" type="text/css"></link>
	<style type="text/css">
	/* CSS for the demo */
	img{
		border:0px;
	}
	</style>
	<script type="text/javascript">
	//--------------------------------
	// Save functions
	//--------------------------------
	var ajaxObjects = new Array();

	// Use something like this if you want to save data by Ajax.
	function saveMyTree()
	{
		saveString = treeObj.getNodeOrders();
		var ajaxIndex = ajaxObjects.length;
		ajaxObjects[ajaxIndex] = new sack();
		var url = 'guardarNodos.php?saveString=' + saveString;
		ajaxObjects[ajaxIndex].requestFile = url;	// Specifying which file to get
		ajaxObjects[ajaxIndex].onCompletion = function() { saveComplete(ajaxIndex); } ;	// Specify function that will be executed after file has been found
		ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function

	}

	function saveComplete(index)
	{
		//alert(ajaxObjects[index].response);
		document.getElementById('respuesta').innerHTML=ajaxObjects[index].response;
	}


	// Call this function if you want to save it by a form.
	function saveMyTree_byForm()
	{
		document.myForm.elements['saveString'].value = treeObj.getNodeOrders();
		document.myForm.submit();
	}


	var http=instanciaAjax();

	function instanciaAjax(){
		var ro;
		var browser = navigator.appName;
		if(browser == 'Microsoft Internet Explorer') {
			ro = new ActiveXObject("Microsoft.XMLHTTP");
		} else {
			ro = new XMLHttpRequest();
		}
		return ro;
	}

	function desactivaBotonEnviar(){
		document.getElementById('Enviar').disabled = true;
	}

	function activaBotonEnviar(){
		document.getElementById('Enviar').disabled = false;
	}

	function leeTopPos(inputObj)
	{
		var returnValue = inputObj.offsetTop;
		while((inputObj = inputObj.offsetParent) != null){
			if(inputObj.tagName!='HTML')returnValue += inputObj.offsetTop;
		}
		return returnValue;
	}

	function leeVertPos(inputObj)
	{
		var returnValue = inputObj.offsetLeft;
		while((inputObj = inputObj.offsetParent) != null){
			if(inputObj.tagName!='HTML')returnValue += inputObj.offsetLeft;
		}
		return returnValue;
	}

	function editarNodoMenu(id,obj){
		var posX=leeTopPos(obj);
		var posY=leeVertPos(obj);
		//alert(posX+' '+posY);
		edicionMenuModelo = new DHTMLSuite.windowModel({windowsTheme:false,id:'ventanaEdicionMenu',title:'Edición de menús',xPos:posY,yPos:posX-50,minWidth:100,minHeight:100,width:420,height:300 } );//cookieName:'ventanaRevisionCasos'
		edicionMenuModelo.addTab({ id:'edicionMenu',htmlElementId:'edicionMenu',tabTitle:'Editar' } );
		edicionModeloObj = new DHTMLSuite.windowWidget(edicionMenuModelo);
		edicionModeloObj.init();
		http.open('post','editarNodo.php?idmenuopcion='+id);
		http.onreadystatechange=manejadorEditarMenu;
		http.send(null);
	}
	function manejadorEditarMenu(){
		if(http.readyState==4){
			//document.getElementById('esperando').innerHTML=null;
			document.getElementById('edicionMenu').innerHTML=http.responseText;
			formEdicion = new DHTMLSuite.form({ formRef:'formularioEdicion',action:'guardarEdicionNodo.php',responseEl:'esperando',callbackOnComplete:'reCarga()'});
			formValidacion = new DHTMLSuite.formValidator({ formRef:'formularioEdicion',keyValidation:true,callbackOnFormValid:'activaBotonEnviar',callbackOnFormInvalid:'desactivaBotonEnviar',indicateWithBars:false });
		}
	}

	function permisosNodoMenu(id,obj){
		var posX=leeTopPos(obj);
		var posY=leeVertPos(obj);
		//alert(posX+' '+posY);
		permisosMenuModelo = new DHTMLSuite.windowModel({windowsTheme:false,id:'ventanaPermisosMenu',title:'Edición de permisos',xPos:posY,yPos:posX-50,minWidth:100,minHeight:100,width:420,height:800 } );//cookieName:'ventanaRevisionCasos'
		permisosMenuModelo.addTab({ id:'permisosMenu',htmlElementId:'permisosMenu',tabTitle:'Editar' } );
		permisosModeloObj = new DHTMLSuite.windowWidget(permisosMenuModelo);
		permisosModeloObj.init();
		http.open('post','permisosNodo.php?idmenuopcion='+id);
		http.onreadystatechange=manejadorPermisosNodoMenu;
		http.send(null);
	}

	function manejadorPermisosNodoMenu(){
		if(http.readyState == 4){
			document.getElementById('permisosMenu').innerHTML=http.responseText;
		}
	}

	function asignarPermisoNodo(obj,idmenuopcion){
		var estadoPermisoRol;
		if(obj.checked==true){
			estadoPermisoRol='noexiste';
			//alert('checked');
		}
		else{
			estadoPermisoRol='existe';
			//alert('unchecked');
		}
		http.open('post','guardarPermisosNodo.php?estado='+estadoPermisoRol+'&idmenuopcion='+idmenuopcion+'&idrol='+obj.value);
		http.onreadystatechange=function(){
			if(http.readyState==4){
				if(http.responseText != 'OK'){
					alert("Error! "+http.responseText);
				}
			}
		}
		http.send(null);
	}

	function nuevoMenu(obj){
		var posX=leeTopPos(obj);
		var posY=leeVertPos(obj);
		//alert(posX+' '+posY);
		edicionMenuModelo = new DHTMLSuite.windowModel({windowsTheme:false,id:'ventanaEdicionMenu',title:'Edición de menús',xPos:posY+200,yPos:posX-500,minWidth:100,minHeight:100,width:420,height:300 } );//cookieName:'ventanaRevisionCasos'
		edicionMenuModelo.addTab({ id:'edicionMenu',htmlElementId:'edicionMenu',tabTitle:'Editar' } );
		edicionModeloObj = new DHTMLSuite.windowWidget(edicionMenuModelo);
		edicionModeloObj.init();
		http.open('post','editarNodo.php?nuevo');
		http.onreadystatechange=manejadorEditarMenu;
		http.send(null);
	}

	function reCarga(){
		if(document.getElementById('esperando').innerHTML=='OK'){
			window.location.href='ordenamientoMenu.php';
		}
		else{
			alert('Falló actualización del menú'+document.getElementById('esperando').innerHTML);
		}
	}
	</script>
<body>
<strong>Editor de menús aplicación SALA Universidad El Bosque</strong><br><br>
<div id="esperando" style="visibility:hidden;position:absolute; width:640px; height:480px; z-index:1; left: 401px; top: 162px; overflow: auto; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;"></div><!--visibility:hidden;-->
<ul id="dhtmlgoodies_tree2" class="dhtmlgoodies_tree">
<?php
// Display the context menu
while ( $item = $menu->fetch() ) {
	if ( $item->isStart() )
	echo ( "<ul>" );
	else if ( $item->isEnd() )
	echo ( "</ul>" );
	else
	echo ( "<li id='".$item->id()."'><a href=\"".'#'."\">"
	.$item->name()."</a></li>" );
}
?>
</ul>

	
	<form>
	<input type="button" onclick="saveMyTree()" value="Guardar">
	<input type="button" onclick="nuevoMenu(this)" value="Nuevo">
	</Form>

	<script type="text/javascript">	
	treeObj = new JSDragDropTree();
	treeObj.setTreeId('dhtmlgoodies_tree2');
	treeObj.setMaximumDepth(10);
	treeObj.setMessageMaximumDepthReached('Profundidad máxima alcanzada'); // If you want to show a message when maximum depth is reached, i.e. on drop.
	treeObj.initTree();
	treeObj.expandAll();






	</script>
	<a href="#" onclick="treeObj.collapseAll()">Contraer Todo</a> | 
	<a href="#" onclick="treeObj.expandAll()">Expandir Todo</a>
	
	<!-- Form - if you want to save it by form submission and not Ajax -->
	<form name="myForm" method="post" action="guardarNodos.php">
		<input type="hidden" name="saveString">
	</form>
<div id="respuesta"></div>
</body>
</html>