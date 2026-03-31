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
$id = $_REQUEST['id'] ;
if($_REQUEST['id'] > 0){
    $query_label = "select * from label where idlabel = '".$_REQUEST['id']."';";
    $query_label = mysql_query($query_label, $sala) or die(mysql_error());
    $label   = mysql_fetch_array($query_label, MYSQL_ASSOC);
}else{
    $campo_no_existe = true;
};

if($_REQUEST['esInstrumento'] == true && $label['idlabel_type']==13){
    $query_label = "select titulo from siq_Apregunta where idsiq_Apregunta = '".$label['idPregunta']."';";
    $query_label = mysql_query($query_label, $sala) or die(mysql_error());
    $pregunta   = mysql_fetch_array($query_label, MYSQL_ASSOC);
}
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
    function guardar(id){

            $.post("ajax/ajax.php", $("#popup_form_id").serialize(),function(data) {
//                var datso = eval(data);
//                if(datso > 0){
//                    element = document.getElementById('namefield');
//                    element.id = 'id';
                    alert('Campo Actualizado satisfactoriamente!');
                    document.location = 'campo_evaluacion_egresado.php';
               //}
            });       
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
             }
     };
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

<?php if ($campo_no_existe){
    echo '<input type="hidden" value="namefield" name="namefield" id=namefield>';
}else{
    echo "<input type=hidden value='$id' id='$id' name='id'>";
}?>
<input type="hidden" value="editar" name="editar">

<input type="hidden" value="true" name="is_update">
<input class="button" type="button" onclick="javascript:if(confirm('Esta seguro de Guadar esta Informacion')){guardar(<?php echo $id; ?>);}" value="Guardar" name="fsavebtn">
<input class="button" type="button" onclick="javascript:history.go(-1);" value="Cancelar" name="cancelbtn">
<hr>

    <table width="400px">
    <tbody>
    <tr>
    <td class="mbLBL" >Tipo de Campo:</td>
    <td>
    <select id="type" onchange="" name="type" <?php if($label['idlabel_type']==13) { echo "disabled"; } ?>>
    <?php
    $query_type_label = "select * from label_type;";
    $query_type_label = mysql_query($query_type_label, $sala) or die(mysql_error());
    while (($row = mysql_fetch_array($query_type_label, MYSQL_ASSOC)) != NULL) {
                echo "<option value=".$row['idlabel_type']." id='type".$row['idlabel_type']."'";
                echo ($row['idlabel_type'] == $label['idlabel_type'])? " selected='' ":"";
                echo ">".$row['name']."</option>";
        }
    ?>
            </select>
    </td>
    </td>
    </tr>
    </tbody>
    </table>


<table width="100%">
<tbody>
<tr>
<td class="mbLBL" width="30%">Nombre Del Campo:</td>
<td>
	<?php if($label['idlabel_type']!=13) { ?>
    <input id="field" type="text" value="<?php echo ($label['field']) ? $label['field'] : $_REQUEST['name'];?>" name="field" maxlength="28" disabled>
    <input id="field" type="hidden" value="<?php echo ($label['field']) ? $label['field'] : $_REQUEST['name'];?>" name="field">
	<?php } else { echo strip_tags($pregunta["titulo"]); } ?>
</td>
</tr>
<?php if($label['idlabel_type']!=13) { ?>
<tr>
<td class="mbLBL">Etiqueta a mostrar:</td>
<td>
<input id="label_field" type="text" value="<?php $label['label_field']; ?>" name="label_field">
</td>
</tr>
<?php } ?>
<tr>
<td class="mbLBL">Visible:</td>
<td>
<select name="status">
    <option value="1" <?php echo ($label['status'] == 1)? " SELECTED ":"";?>>Si</option>
    <option value="0" <?php echo ($label['status'] == 0)? " SELECTED ":"";?> >No</option>
</select>
</td>
</tr>
<?php if($label['idlabel_type']!=13) { ?>
<tr>
<td class="mbLBL">Texto de Ayuda:</td>
<td>
<input type="text" name="help"  value="<?php echo $label['help']; ?>">
</td>
</tr>
<tr>
<td class="mbLBL">Texto de Etiqueta:</td>
<td>
<input type="text" name="comments" value="<?php echo $label['comments']; ?>">
</td>
</tr>
<tr>
<td class="mbLBL">Valor por defecto:</td>
<td>
<input id="default" type="text" name="default" value="<?php echo $label['default_value']; ?>">
</td>
</tr>
<tr>
<td class="mbLBL">Tamaño Maximo:</td>
<td>
<input id="field_len" type="text" onchange="" name="len" value="<?php echo $label['len']; ?>">
<input id="orig_len" type="hidden" value="255" name="orig_len">
</td>
</tr>
<tr>
<td class="mbLBL">Campo Obligatorio:</td>
<td>
    <input type="checkbox" value="1" name="required" <?php echo ($label['required']==1)?" checked":""; ?> />
</td>
</tr>
</tbody>
</table>
<?php } ?>
</form>
                </td></tr>
    </table>
        </body>
</html>