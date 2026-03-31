<?php

    session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Ver Detalle Docente",TRUE);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $user1 = array();
    $user2 = array();
   
    if(isset($_REQUEST["id"])){  
       $utils = Utils::getInstance();
       $id = str_replace('row_','',$_REQUEST["id"]);
       $data = $utils->getDataEntity("docenteEducacionContinuada", $id,"iddocenteEducacionContinuada");   
       $ciudad = $utils->getDataEntity("ciudad", $data["idciudadresidencia"],"idciudad");      
       $genero = $utils->getDataEntity("genero", $data["codigogenero"],"codigogenero");     
       $tipoDoc = $utils->getDataEntity("documento", $data["tipodocumento"],"tipodocumento");  
   }
?>
        
        <div id="contenido">
            <h2>Ver Detalle Docente</h2>
            <table class="detalle">
                <tr>
                    <th>Nombre:</th>
                    <td><?php echo $data['nombredocente']." ".$data['apellidodocente']; ?></td>
                    <th>E-mail:</th>
                    <td><?php echo $data['emaildocente']; ?></td>
                </tr>
                <tr>
                    <th>Género:</th>
                    <td><?php echo $genero['nombregenero']; ?></td>
                    <th>Documento:</th>
                    <td><?php echo $tipoDoc['nombrecortodocumento']." ".$data["numerodocumento"]; ?></td>
                </tr>
                <tr>
                    <th>Profesión:</th>
                    <td><?php echo $data['profesion']; ?></td>
                    <th>Especialidad:</th>
                    <td><?php echo $data['especialidad']; ?></td>
                </tr>
                <tr>
                    <th>Teléfono:</th>
                    <td><?php echo $ciudad['telefonoresidenciadocente']; ?></td>
                    <th>Celular:</th>
                    <td><?php echo $data['numerocelulardocente']; ?></td>
                </tr>
                <tr>
                    <th>Ciudad de residencia:</th>
                    <td><?php echo $ciudad['nombreciudad']; ?></td>
                    <th>Dirección:</th>
                    <td><?php echo $data['direcciondocente']; ?></td>
                </tr>
                <tr>
                    <th>Fecha creación:</th>
                    <td><?php echo $data['fecha_creacion']; ?></td>
                    <th>Fecha modificación:</th>
                    <td><?php echo $data['fecha_modificacion']; ?></td>
                </tr>            
            </table>
        </div>

<?php  

 writeFooter(); ?>