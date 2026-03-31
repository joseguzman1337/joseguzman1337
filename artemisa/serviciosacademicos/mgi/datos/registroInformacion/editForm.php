<?php

    include("../templates/template.php");
    $db = writeHeader("Editar formulario",TRUE);
    
    $utils = new Utils_datos();
    $id = str_replace('row_','',$_REQUEST["id"]);
    $formulario = $utils->getDataEntity("formulario",$id);
    $categoria = $utils->getDataEntity("categoriaData",$formulario["categoria"]);  
    
    //me toca buscar todos los cambios del formulario... en un select o botones poner seleccionar datos a editar
    //y dependiendo del que elija busco en la bd los valores que puede editar, inactivar o añadir uno nuevo
?>

<?php writeFooter(); ?>