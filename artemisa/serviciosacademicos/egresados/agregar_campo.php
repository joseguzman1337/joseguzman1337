<?php
/*
* Caso 90158
* @modified Luis Dario Gualteros 
* <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso  90158
include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../Connections/sala2.php');

mysql_select_db($database_sala, $sala);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tabulación de Encuesta</title>
<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
<script type="text/javascript" src="js/jquery.js"></script>
<style>
    button, input[type="submit"], input[type="reset"], input[type="button"], .button {
    background-color: #ECF1F4;
    background-image: url("../../../../index.php?entryPoint=getImage&themeName=Sugar5&imageName=bgBtn.gif");
    border-color: #ABC3D7;
    color: #000000;
}
</style>
<script>
    function guardar(){
		if($("#type").val()==13 && $("#preguntasEncuestas").val()==""){
			alert("Debe seleccionar una pregunta a agregar.");
		} else {
            $.post("ajax/ajax.php", $("#popup_form_id").serialize(),function(data) {
                var datso = eval(data);
                if(datso > 0){                    
                    alert('Campo Creado satisfactoriamente!');
                    document.location = 'campo_evaluacion_egresado.php';
                }
            });
		}
     }
     function select_option(obj){
           var chosenoption=obj.options[obj.selectedIndex]; //this refers to "selectmenu"           
             if (chosenoption.value != "nothing"){
                 if(chosenoption.value ==8 || chosenoption.value ==12){
                    document.getElementById("dropdown_selectoption").style.display = 'block';
                    document.getElementById("dropdown_select").style.display = 'block';
                 }else{
                     document.getElementById("dropdown_selectoption").style.display = 'none';
                    document.getElementById("dropdown_select").style.display = 'none';
                 }
				 
				 if(chosenoption.value == 13){
					document.getElementById("form1").style.display = 'none';
					document.getElementById("form2").style.display = 'block';
				 } else {
					document.getElementById("form2").style.display = 'none';
					document.getElementById("form1").style.display = 'block';
				 }
             }
     }
	 
	 function buscarPreguntas(obj){
		var chosenoption=obj.options[obj.selectedIndex].value;
		//console.log(chosenoption);
        $.post("ajax/preguntasPercepcion.php", {"cat_ins": chosenoption},function(data) {
				//console.log(data);
				 //html = $.parseHTML( data );
                $("#preguntasEncuestas").html(data);
            });
    }
	 
</script>
</link>
</head>

<body>
  <table align="center" width="50%" style="" >
        <tr><td>
<form id="popup_form_id" onsubmit="return false;" name="popup_form">
<input type="hidden" value="ModuleBuilder" name="module">
<input type="hidden" value="saveField" name="action">
<input type="hidden" value="" name="new_dropdown">
<input type="hidden" value="true" name="to_pdf">
<input type="hidden" value="crear" name="crear">
<input type="hidden" value="true" name="is_create">
<input class="button" type="button" onclick="javascript:if(confirm('Esta seguro de Guadar esta Informacion')){guardar();}" value="Crear" name="fsavebtn">
<input class="button" type="button" onclick="javascript:history.go(-1);" value="Cancelar" name="cancelbtn">
<hr> 
    <table>
    <tbody>
    <tr>
    <td class="mbLBL" >Tipo de Campo:</td>
    <td>
    <select id="type" onchange="javascript:select_option(this);" name="type">
    <?php 
    $query_type_label = "select * from label_type;";
    $query_type_label = mysql_query($query_type_label, $sala) or die(mysql_error());
    while (($row = mysql_fetch_array($query_type_label, MYSQL_ASSOC)) != NULL) {
                echo "<option value=".$row['idlabel_type']." id='type".$row['idlabel_type']."'";
                echo ($row['idlabel_type'] == $label['idlabel_type'])? " SELECTED ":"";
                echo ">".$row['name']."</option>";
        }
    ?>
            </select>
    </td>
    <tr style="display:none" id="dropdown_select">
        <td colspan="2">
            <div>Ingrese los valores de la lista de la siguiente forma:<br>
                 Ejemplo lista de modelos de carro.<br>
                 carrotipo1:audi 5<br>
                 carrotipo2:Fiat Palio<br>
                 carrotipo3:Mazda 323<br>
                 segun la seleccion se alamacenara el valor carrotipox en la base de datos.<br>
                 Los valores estan separados por el simbolo pipe "|"<br>
                 El ejemplo completo es :<br>     carrotipo1:audi 5|carrotipo2:Fiat Palio|carrotipo3:Mazda 323
            </div>            
        </td>
        </tr>
    <tr style="display:none" id="dropdown_selectoption">
        <td>Valores de la lista
        </td>
        <td><input type="text" name="option_dropdown">
        </td>
        </tr>
    </tr>
    </tbody>
    </table>

<table width="100%" id="form1">
<tbody>
<tr>
<td class="mbLBL" width="30%">Nombre Del Campo:</td>
<td>
    <input id="field" type="text" value="" name="field" maxlength="28" >
    <input id="field" type="hidden" value="egresado_ext" name="table">
</td>
</tr>
<tr>
<td class="mbLBL">Etiqueta a mostrar:</td>
<td>
<input id="label_field" type="text" value="" name="label_field">
</td>
</tr>
<tr>
<td class="mbLBL">Visible:</td>
<td>
<select name="status">
    <option value="1" >Si</option>
    <option value="0" >No</option>
</select>
</td>
</tr>
<tr>
<td class="mbLBL">Texto de Ayuda:</td>
<td>
<input type="text" name="help"  value="">
</td>
</tr>
<tr>
<td class="mbLBL">Texto de Etiqueta:</td>
<td>
<input type="text" name="comments" value="">
</td>
</tr>
<tr>
<td class="mbLBL">Valor por defecto:</td>
<td>
<input id="default" type="text" maxlength="255" name="default" value="">
</td>
</tr>
<tr>
<td class="mbLBL">Tamaño Maximo:</td>
<td>
<input id="field_len" type="text" onchange="" name="len" value="">
<input id="orig_len" type="hidden" value="255" name="orig_len">
</td>
</tr>
<tr>
<td class="mbLBL">Campo Obligatorio:</td>
<td>
    <input type="checkbox" value="1" name="required" >
</td>
</tr>
</tbody>
</table>

<div id="form2" style="display:none;">
	<label>Tipo de Encuesta:</label>
	<select id="categoriasEncuestas" name="categoriaEncuesta" onchange="javascript:buscarPreguntas(this);">
		<option value="" selected></option>
		<?php
		$query_type_label = "select * from siq_AcategoriaInstrumento;";
		$query_type_label = mysql_query($query_type_label, $sala) or die(mysql_error());
		while (($row = mysql_fetch_array($query_type_label, MYSQL_ASSOC)) != NULL) {
					echo "<option value=".$row['alias']." id='type".$row['idCategoriaInstrumento']."'";
					echo ">".$row['nombre']."</option>";
			}
		?>
	</select>
	
	<br/><br/>
	
	<label>Pregunta:</label>
	<select id="preguntasEncuestas" name="preguntasEncuestas">
		<option value="" selected></option>
		
	</select>
	
	<br/><br/>
	
	<label>Visible:</label>
	<select name="status2">
		<option value="1" selected>Si</option>
		<option value="0" >No</option>
	</select>
</div>
</form>
   </td></tr>
    </table>
        </body>
</html>