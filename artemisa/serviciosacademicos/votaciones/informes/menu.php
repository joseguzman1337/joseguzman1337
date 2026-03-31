<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("../../funciones/clases/formulariov2/clase_formulario.php");
require_once("funciones.php");

$formulario = new formulario($sala,'form1','post','',true,'menu.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<script language="javascript">
		function quitarFrame()
		{
			if (self.parent.frames.length != 0)
			self.parent.location=document.location.href="escrutinio.html";

		}
		</script>
		<script type="text/javascript" src="../../mgi/js/jquery.min.js"></script>
		<script type="text/javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
	</head>
<body>
<form action="../plantillaActaMenu.php" method="POST" name="formActa">
<input type="submit" id="acta" value="Generar acta"/><br/><br/>
</form>

<?php $hay = hayVotaciones($sala); //var_dump($hay);
if(!$hay){ ?>
Seleccione el informe de su interés:
<br>
<form name='form1' action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" id="formTable">
<tr>
	<td>
	  <select name="tipolistado" id="tipolistado">
    <option value="" <?php if(!isset($_POST['tipolistado'])) { echo "selected='selected'"; } ?>>Seleccionar</option>
	<option value="1" <?php if(isset($_POST['tipolistado']) && $_POST['tipolistado']==1){echo "selected='selected'";}?>>Escrutinio en Tiempo Real</option>
    <option value="2" <?php if(isset($_POST['tipolistado']) && $_POST['tipolistado']==2){echo "selected='selected'";}?>>Resumen Escrutinios</option>
    <option value="3" <?php if(isset($_POST['tipolistado']) && $_POST['tipolistado']==4){echo "selected='selected'";}?>>Resultados Escrutinios</option>
    <option value="5" <?php if(isset($_POST['tipolistado']) && $_POST['tipolistado']==5){echo "selected='selected'";}?>>Informe Total Votaciones</option>
  </select>
	</td>
</tr>
</table>
<?php
$formulario->Boton('Enviar','Enviar');
?>
</form>

  <?php } else {
		echo "Actualmente estamos en proceso de votaciones por lo que no se pueden consultar informes de resultados.";
	}  
if(isset($_POST['Enviar']) && !empty($_POST['Enviar'])){

	if(!empty($_POST['tipolistado'])){
		if($_POST['tipolistado']==1){
			//echo "ENTRO?";
			//echo '<script language="javascript">window.open("escrutinio.html","escrutinio")</script>';
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".'escrutinio.html'."'>";
		}
		if($_POST['tipolistado']==2){
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".'resumenEscrutinioConsejoFacultad.php'."'>";
		}
		elseif ($_POST['tipolistado']==3){
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".'resultadosEscrutinio.php'."'>";
		}
		elseif ($_POST['tipolistado']==5 && isset($_POST['votacion']) && $_POST['votacion']!=""){
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".'informeFinalResultados.php?votacion='.$_POST['votacion']."'>";
		}
		elseif ($_POST['tipolistado']==5){
			echo "<script type='text/javascript'>alert('Debe seleccionar alguna votación.');</script>";
		}
	}
}
?>
<script type="text/javascript">
	var js_array =<?php echo getVotaciones($sala); ?>;
	var num = js_array.length;
	var opciones = "";
	for (var i = 0; i < num; i++) {
		opciones = opciones + "<option value='"+js_array[i].idvotacion+"'>"+js_array[i].nombrevotacion+"</option>";
	}

	$(document).on('change', '#tipolistado', function() {
		checkSelect();
	});
	
	$(function() {
		checkSelect();
	});
	
	function checkSelect(){	
		//console.log(js_array);
		//console.log("hola " + $( "#tipolistado option:selected" ).val());
		if($( "#tipolistado option:selected" ).val()==5){
			$( "#formTable" ).append( "<tr id='votaciones'><td><select name='votacion'><option value=''>Seleccionar</option>"+opciones+"</select></td></tr>" );
		} else {
			$( "#votaciones" ).remove();
		}
	}
</script>
</body>
</html>