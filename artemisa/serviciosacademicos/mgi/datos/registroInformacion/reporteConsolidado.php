<?php

    require("../templates/template.php");
    $db = writeHeader("Reporte Consolidado Tablas Maestras",TRUE);
    
    if(!isset($_REQUEST["idIndicador"])&&(!isset($_REQUEST["menu"])||$_REQUEST["menu"]!=="0")){
        include("./menu.php");
        writeMenu(0);
    } 
    
    $utils = new Utils_datos();
    $id = str_replace('row_','',$_REQUEST["id"]);   
    $formulario = $utils->getDataEntity("formulario",$id); 
    if(count($formulario)>0){
    $categoria = $utils->getDataEntity("categoriaData",$formulario["categoria"]);  }
    
?>
<script type="text/javascript" language="javascript" src="./js/funcionesTablasMaestras.js"></script>
<div id="contenido">
      <h4 style="margin-top:10px;margin-bottom:0.8em;"><?php echo $formulario["nombre"]; ?></h4>
        <div id="form" style="margin: 0 5px;"> 
            <?php //$utils->viewForm($db,$formulario,$categoria,"form_test","medium"); 
            if(count($formulario)>0){
                include("./formularios/".$categoria["alias"]."/reporte".$formulario["alias"].".php");            
            } else {
                echo "No se encontró tabla maestra asociada.";
            } ?>
        </div>
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