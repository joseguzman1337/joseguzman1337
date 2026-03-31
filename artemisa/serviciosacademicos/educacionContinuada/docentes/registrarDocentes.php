<?php
	session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Importar Excel",TRUE);

    include("./menu.php");
    writeMenu(3);
    
    $data = array();
    $mensaje="";
    
    if(isset($_REQUEST["mensaje"])){
        $mensaje=$_REQUEST["mensaje"];        
    }
    $mensajeTodo=explode(':',$mensaje);
    $mensajeTipo=$mensajeTodo[0];
    $mensaje=$mensajeTodo[1];
    

?>
<script type="text/javascript" src="../js/jquery.powertip.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.powertip.css" />
<div id="contenido" style="margin-top: 10px;">
<h4>Registrar Docentes Externos</h4>
    <div id="form"> 
        <form action="registrarDocentesBackEnd.php" method="post" id="form_test" enctype="multipart/form-data">
            <div id="msg-success" class="msg-success" <?php if(strcmp('exito', $mensajeTipo)==0){ echo 'style="display:block"'; $mostrar=true; } else {echo 'style="display:none"'; $mostrar=false;} ?> ><p><?php echo $mensaje;?></p></div>
            <div id="msg-error" class="msg-error" <?php if(!$mostrar&&$mensajeTipo!=""){ echo 'style="display:block"'; } else {echo 'style="display:none"';} ?> ><p><?php echo $mensaje;?></p></div>

            <div class="vacio"></div>
            <label for="file">Archivo con los docentes:</label>
            <input accept="application/vnd.ms-excel" type="file" name="file" id="file" style="position:relative;top:-5px;">
            <a href="../templates/plantillaRegistroDocentes.xls" style="font-size:11px;margin-left:15px;position: relative;top: -15px;"> (descargar plantilla en excel) </a>
 		<img width="32" height="32" alt="ayuda" id="ayuda" name="image" src="../images/help.png" style="cursor:pointer;position: relative; top: -5px;">

            <br/>
            <br/>
            <br/>
            
            <input type="submit" value="Registrar docentes" />
            
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
        alert('Por favor ingresar un archivo.');
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
    '<p><b>Campos opcionales:</b></p>',
    '<ul><li>Especialidad</li><li>Dirección</li><li>Teléfono</li></ul>'
    ].join('\n')));
$('#ayuda').powerTip({
    placement: 'sw',
    smartPlacement: true
});

  </script>
<?php  writeFooter(); ?>