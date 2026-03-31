<?php
    // this starts the session 
    session_start();
 
    require_once("../templates/template.php");
    $db = writeHeader("Previsualizar Reporte",TRUE);
    
    //include("./menu.php");
    //writeMenu(2);
    
    $data = array();
    $id = $_REQUEST["id"];
    $utils = new Utils_datos();
    $reporte = $utils->getDataEntity("reporte",$_REQUEST["idReporte"]);
    
?>

<div id="contenido">
      <h2 style="margin-top:0px"><?php echo $reporte["nombre"]; ?></h2>
      
      <?php if($reporte["plantilla_reporte"]!=null){ 
                include("./previewLayout".$reporte["plantilla_reporte"].".php");
      } else { ?>
      
      <?php } ?>
</div>

<?php writeFooter(); ?>
