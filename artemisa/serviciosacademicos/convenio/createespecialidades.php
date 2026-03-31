<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
//error_reporting(0);
require_once('../Connections/salasiq.php');

$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

if($_REQUEST['id']){    
    require_once '../class/ManagerEntity.php';
    $entity = new ManagerEntity("especialidad");
    $entity->sql_where = "idsiq_especialidad = ".str_replace('row_','',$_REQUEST['id'])."";
    $data = $entity->getData();
    $data = $data[0];
}

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <title>Convenios</title>                   
    </head>    
    <script>
        $.ajaxSetup({ cache:false }); 
    </script>
    <body>
        <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="especialidad" />
            <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
            <?php
            if($data['idsiq_grupo_materia']!="")
                echo '<input type="hidden" name="idsiq_especialidad" value="'.$data['idsiq_especialidad'].'">';
            ?>
            <fieldset>
                <legend>Informaci&oacute;n de Especialidades</legend>                
                <table>                    
                    <tbody>
                       <tr>
                            <td><label for="nombre">Nombre:</label></td>
                            <td><input type="text" name="nombreespecialidad" id="nombreespecialidad" title="Nombre" maxlength="120" placeholder="Nombre" autocomplete="off" value="<?php echo $data['nombreespecialidad']?>" /></td>
                        </tr>               
                    </tbody>
                </table> 
            </fieldset>
        </form>
    </body>
</html>