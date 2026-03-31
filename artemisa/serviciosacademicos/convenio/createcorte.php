<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

if($_REQUEST['id']){
    require_once '../class/ManagerEntity.php';
    $entity = new ManagerEntity("corte");
    $entity->sql_where = "idsiq_corte = ".str_replace('row_','',$_REQUEST['id'])."";
    $data = $entity->getData();
    $data = $data[0];
}
?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Convenios</title>                   
    </head>
    <body>
        <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="corte" />
            <input type="hidden" name="codigoestado" value="100" />
            <input type="hidden" name="idsiq_grupoconvenio" value="<?php echo $_REQUEST['idsiq_grupoconvenio'];?>" />
            
            <?php
            if($data['idsiq_corte']!="")
                echo '<input type="hidden" name="idsiq_corte" value="'.$data['idsiq_corte'].'">';
            ?>
            <fieldset>
                <legend>Informaci&oacute;n del Grupo - Cortes</legend>                
                <table>                    
                    <tbody>
                       <tr>
                            <td><label for="numerocorte">Numero de Corte:</label></td>
                            <td><input type="text" name="numerocorte" id="numerocorte" title="Numero de corte" maxlength="120" placeholder="Numero de corte" autocomplete="off" value="<?php echo $data['numerocorte']?>" /></td>
                        </tr>        
                        <tr>
                            <td><label for="fechainicio">Vigentes desde:</label></td>
                            <td><input type="text" name="fechainicio" id="fechainicio" title="Vigentes desde" maxlength="16" placeholder="Vigentes desde" autocomplete="off" value="<?php echo $data['fechainicio']?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="fechafin">Vigentes Hasta:</label></td>
                            <td><input type="text" name="fechafin" id="fechafin" title="Vigentes Hasta" maxlength="12" placeholder="Vigentes Hasta" autocomplete="off" value="<?php echo $data['fechafin']?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="peso">Porcentaje de Calificacion:</label></td>
                            <td><input type="text" name="peso" id="peso" title="Porcentaje de Calificacion" maxlength="3" placeholder="Porcentaje de Calificacion" autocomplete="off" value="<?php echo $data['peso']?>" /></td>
                        </tr>
                    </tbody>
                </table> 
            </fieldset>
        </form>
    </body>
</html>