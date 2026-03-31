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
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/clasemenusic.php");
$rutaJS = '../../librerias/js/';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">

<!--<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">-->
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
   <link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
    <script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>

<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/requestxml.js"></script>

<script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery-treeview/lib/jquery.cookie.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.css" />

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
	a {
	color:#000000;
	font-family:arial;
	font-size:0.6em;
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
	function saveMyTree_byForm(tipovisualiza,exporta)
	{
		var formulario=document.getElementById("formmenu");
		formulario.target='marcocentral';	
		formulario.action='central.php?tipovisualiza='+tipovisualiza+"&exportar="+exporta;	
		//formulario.elements['saveString'].value = treeObj.getNodeOrders();
		formulario.submit();		
			
	}
	// Envia un post para consultar los hijos de un item para que se seleccionen
	function enviarconsultahijos(iditem)
	{
		var formulario=document.getElementById("formmenu");
		formulario.target='';
		if(!document.getElementById("check"+iditem).checked){
			formulario.action='creararbolsic.php?padreconsulta='+iditem+'&checked=checked#'+iditem;	
		}
		else{
			formulario.action='creararbolsic.php?padreconsulta='+iditem+'&checked=#'+iditem;
		}
	
		
		//formulario.elements['saveString'].value = treeObj.getNodeOrders();
		formulario.submit();		
			
	}
	//Esta funcion es para tomar que todo el nombre del item chequee la opcion
	function validacheck(iditem){
		//alert("check"+iditem)
		if(!document.getElementById("check"+iditem).checked){
			document.getElementById("check"+iditem).checked=true;
		}
		else{
			document.getElementById("check"+iditem).checked=false;
		}

	}
	
	$(function() {
		$("#tree").treeview({
		collapsed: false,
		animated: "medium",
		control:"#sidetreecontrol",
		//persist: "location"
		persist: "cookie"
		//unique: true
		});
	})
	function cambiaEstadoImagen(estadoimagen,iditem){
		var imagen=document.getElementById("img"+iditem);
		//alert("arbol="+estadoimagen+","+iditem)
		if(estadoimagen==true)
			imagen.src="../../imagenes/aprobado.gif";
		else
			imagen.src="../../imagenes/poraprobar.gif";
					var ajaxIndex = ajaxObjects.length;
		ajaxObjects[ajaxIndex] = new sack();
		//alert("string guardado="+saveString);
		var url = 'cambiaestadoitem.php?estado=' + estadoimagen + '&iditem=' + iditem;
		//alert(url);
		ajaxObjects[ajaxIndex].requestFile = url;	// Specifying which file to get
		ajaxObjects[ajaxIndex].onCompletion = function() { //saveComplete(ajaxIndex);
		 } ;	// Specify function that will be executed after file has been found
		ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function		

	}
	</script>
</head>
 <body  bgcolor="#EFF0D7">

<?php
echo "<br><br>";
/*echo "<form>
<input type='button' onclick='saveMyTree()' value='Guardar'>
</Form>";*/
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
echo "<div id='sidetreecontrol'><a href='?#'>Contraer Todo</a> | <a href='?#'>Expandir Todo</a></div>";
$objetobase=new BaseDeDatosGeneral($sala);
$objetomenusic= new MenuSic($objetobase,$formulario);
if(isset($_GET['padreconsulta']))
$objetomenusic->consultahijos($_GET['padreconsulta']);
$objetomenusic->setUsuario($_SESSION["MM_Username"]);
$objetomenusic->setCodigoCarrera($_SESSION['sissic_codigocarrera']);
$objetomenusic->consultaprimernivelsic();
echo "<form name='formmenu' id='formmenu' action='central.php' target='marcocentral' method='post'>";
$objetomenusic->recorreprimernivelarbol();
echo "</form>";
/*echo "<form>
<input type='button' onclick='saveMyTree()' value='Guardar'>
</Form>";*/
/*
echo "";
echo "<script type='text/javascript'>	
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
</script>";*/
?>
</body>		
</html>
