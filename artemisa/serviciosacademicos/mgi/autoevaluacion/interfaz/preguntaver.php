<?php
include("../../templates/templateAutoevaluacion.php");
$db =writeHeader("Instrumento",true,"Autoevaluacion");
    $id_pregunta=$_REQUEST['id_pregunta'];
    $preg=ver_preguntas($id_pregunta)
 
?>
