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
    $entity = new ManagerEntity("grupo_materia");
    $entity->sql_where = "idsiq_grupo_materia = ".str_replace('row_','',$_REQUEST['id'])."";
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
    <body>
        <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="grupo_materia" />
            <?php
            if($data['idsiq_grupo_materia']!="")
                echo '<input type="hidden" name="idsiq_grupo_materia" value="'.$data['idsiq_grupo_materia'].'">';
            ?>
            <fieldset>
                <legend>Informaci&oacute;n del Grupo - Materia</legend>                
                <table>                    
                    <tbody>
                       <tr>
                            <td><label for="nombre">Nombre:</label></td>
                            <td><input type="text" name="nombre" id="nombre" title="Nombre" maxlength="120" placeholder="Nombre" autocomplete="off" value="<?php echo $data['nombre']?>" /></td>
                        </tr>               
                        <tr>
                            <td><label for="codigo">Código Grupo:</label></td>
                            <td><input type="text" name="codigo" id="codigo" title="Código" maxlength="120" placeholder="Código" autocomplete="off" value="<?php echo $data['codigo']?>" /></td>
                        </tr>

                        <tr>
                            <td><label for=codigoestado">Estado:</label></td>
                            <td>
                                 <?php
                                        $query_estado = "SELECT nombreestado, codigoestado FROM estado order by 1";
                                        $reg_estado = $db->Execute ($query_estado);
                                        echo $reg_estado->GetMenu2('codigoestado',$data['codigoestado'],false,false,1,' ');
                                    ?>
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </fieldset>
        </form>
    </body>
</html>