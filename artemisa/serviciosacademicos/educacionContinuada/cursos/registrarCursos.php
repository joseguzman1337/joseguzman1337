<?php
	session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Importar Programa",TRUE);

    include("./menu.php");
    writeMenu(4);
    
    $data = array();
    $mensaje="";
	$mensajeTipo = "";
    
    if(isset($_REQUEST["mensaje"])){
        $mensaje=$_REQUEST["mensaje"];   
		$mensajeTodo=explode(':',$mensaje);
		$mensajeTipo=$mensajeTodo[0];
		$mensaje=$mensajeTodo[1];     
    }
    
	//echo date("Y-m-d", strtotime($datetime));

?>
<script type="text/javascript" src="../js/jquery.powertip.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.powertip.css" />
<div id="contenido" style="margin-top: 10px;">
<h4>Registrar Programas</h4>
    <div id="form"> 
        <form action="registrarCursosBackEnd.php" method="post" id="form_test" enctype="multipart/form-data">
            <p style="margin:0; font-weight: bold; <?php if(strcmp('exito', $mensajeTipo)==0){ echo 'color:green;'; } else {echo 'color:red;';} ?>" ><?php echo $mensaje;?></p>
			<br/>
            <div class="vacio"></div>
            <label for="file">Archivo con los cursos:</label>
            <input accept="application/vnd.ms-excel" type="file" name="file" id="file">
            <a href="../templates/plantillaRegistroCurso.xls" style="font-size:11px;margin-left:15px;position: relative;top: -10px;">(descargar plantilla en excel)</a>
            <img width="32" height="32" alt="ayuda" id="ayuda" name="image" src="../images/help.png" style="cursor:pointer;">
            <br/>
            <br/>
            <br/>
            
            <input type="submit" value="Registrar cursos" class="first" />
            
        </form>
    </div>
 </div>

<script type="text/javascript">
$(':submit').click(function(event){
    event.preventDefault();
    if(validar()){
        $("#form_test").submit();
    }
});

function validar(){
    if(document.getElementById('file').value==''){
        alert('Por favor ingresar un archivo');
        return false;
    }
    else{
        var validExts = new Array(".xlsx", ".xls", ".csv");
        var fileExt=document.getElementById('file').value;
        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
        if(validExts.indexOf(fileExt) < 0){
            alert("Tipo de archivo invalido, favor seleccionar uno de los siguientes tipos de archivo: " + validExts.toString());
            return false;
        }
        else{
            return true;
        } 
    }
}
$('#ayuda').data('powertipjq', $([
    '<p><b>Descripción de campos:</b></p>',
    '<ul><li>Código del Programa: es el código del curso (para cursos ya existentes).</li><li>Nombre del Programa: nombre del curso.</li><li>Facultad: facultad a la que pertenece el curso.</li><li>Ciudad: solo para cursos presenciales y semi-presenciales.</li><li>Empresas: nombre de empresas (para cursos cerrados).</li></ul>',
    '<p><b>Para nuevos cursos, los siguientes campos son obligatorios:</b></p>',
    '<p>Nombre del Programa, Facultad, Tipo de Actividad, Categoría, Núcleo Estratégico,<br/>Valor matrícula, Tipo de Programa, Fecha de Inicio, Fecha de Finalización y Autorizado por.</p>',
    '<p><b>Para nuevas fechas de cursos ya existentes, los siguientes campos son obligatorios:</b></p>',
    '<p>Código del Programa ó Nombre del Programa, Tipo de Actividad, Categoría, Núcleo Estratégico,<br/>Fecha de Inicio, Fecha de Finalización y Tipo de Programa.</p>'
    ].join('\n')));
$('#ayuda').powerTip({
    placement: 'sw',
    smartPlacement: true
});
  </script>
<?php  writeFooter(); ?>
