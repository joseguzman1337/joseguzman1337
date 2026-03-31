<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('/../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('/../../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/clasemenusic.php");
$rutaJS="../../../../funciones/sala_genericas/ajax/jquery/"
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">

<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
   <link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
    <script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>

<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/requestxml.js"></script>


<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/dragdropmenu/js/ajax.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/dragdropmenu/js/context-menu.js"></script> 
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/dragdropmenu/js/drag-drop-folder-tree.js"></script> 

<link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/dragdropmenu/css/drag-drop-folder-tree.css" type="text/css"></link>
<link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/dragdropmenu/css/context-menu.css" type="text/css"></link>

	<style type="text/css">
	/* CSS for the demo */
	img{
		border:0px;
	}
	</style>

	<script type="text/javascript">
	/*$(document).ready(function () {
		$('body').layout({ applyDefaultStyles: true });
		$('body').layout().sizePane("west", 270);
		/*$('body').layout({
		west: {closable: true, size: 250}
		});*/
	//});
	</script>

	<script type="text/javascript">
	//--------------------------------
	// Save functions
	//--------------------------------
	var ajaxObjects = new Array();
	
	// Use something like this if you want to save data by Ajax.
	function saveMyTree()
	{
			//alert("entro? 1");
			saveString = treeObj.getNodeOrders();
			var ajaxIndex = ajaxObjects.length;
			ajaxObjects[ajaxIndex] = new sack();
			//alert("string guardado="+saveString);
			var url = 'guardararbol.php?saveString=' + saveString;
			//alert(url);
			ajaxObjects[ajaxIndex].requestFile = url;	// Specifying which file to get
			ajaxObjects[ajaxIndex].onCompletion = function() { saveComplete(ajaxIndex); } ;	// Specify function that will be executed after file has been found
			ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function			
		
	}
	function saveComplete(index)
	{
		alert(ajaxObjects[index].response);			
	}

	
	// Call this function if you want to save it by a form.
	function saveMyTree_byForm()
	{
		document.myForm.elements['saveString'].value = treeObj.getNodeOrders();
		document.myForm.submit();		
	}
	

	</script>
</head>
 <body  bgcolor="#F8F8F8">

<?php
echo "<br><br>";
/*echo "<form>
<input type='button' onclick='saveMyTree()' value='Guardar'>
</Form>";*/
$objetobase=new BaseDeDatosGeneral($sala);
$objetomenusic= new MenuSic($objetobase,$formulario);
$objetomenusic->consultaprimernivelsic();
$objetomenusic->recorreprimernivelarbol();
/*echo "<form>
<input type='button' onclick='saveMyTree()' value='Guardar'>
</Form>";*/
echo "";
echo "  <script type='text/javascript'>	
	treeObj = new JSDragDropTree();\n
	treeObj.setImageFolder('../../../../funciones/sala_genericas/ajax/dragdropmenu/images/');\n
	treeObj.setTreeId('dhtmlgoodies_tree2');\n
	treeObj.setMaximumDepth(7);\n
	treeObj.setFileNameDelete('borraritem.php');
	treeObj.setFileNameRename('renombraritem.php');
	treeObj.setMessageMaximumDepthReached('Maximum depth reached');\n
	// If you want to show a message when maximum depth is reached, i.e. on drop.
	treeObj.initTree();\n
	//treeObj.expandAll();\n	
	</script>";
?>
</body>		
</html>
