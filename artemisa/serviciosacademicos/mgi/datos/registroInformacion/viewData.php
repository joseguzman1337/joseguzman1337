<?php

    include("../templates/template.php");
    $db = writeHeader("Ver datos",TRUE);
    
    include("./menu.php");
    writeMenu(0);
    
    $utils = new Utils_datos();
    $id = str_replace('row_','',$_REQUEST["id"]);
    $formulario = $utils->getDataEntity("formulario",$id);  
    $categoria = $utils->getDataEntity("categoriaData",$formulario["categoria"]);  
    
?>
<script type="text/javascript" language="javascript" src="./js/funcionesTablasMaestras.js"></script>
<div id="contenido">
      <h4 style="margin-top:10px;margin-bottom:0.8em;"><?php echo $formulario["nombre"]; ?></h4>
            <?php //$utils->viewForm($db,$formulario,$categoria,"form_test","medium"); 
            include("./formularios/".$categoria["alias"]."/view".$formulario["alias"].".php"); ?>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		// Handler for .ready() called.
		calculateWidthMenuTabs(); 
		calculateWidthMenu(); 
	});

    
    //Para que arregle el menu al cambiar el tamaño de la página
    $(window).resize(function() {
	calculateWidthMenuTabs();
         calculateWidthMenu();
    }); 
</script>

<?php writeFooter(); ?>