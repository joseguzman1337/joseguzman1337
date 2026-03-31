<?php
    // this starts the session 
    session_start();
    if(isset($_REQUEST["usuario"])){
        $_SESSION['MM_Username'] = $_REQUEST["usuario"];
    }
    
    require_once("../templates/template.php");
    $db = writeHeader("Visualizar Reporte",TRUE);
    
    $data = array();
    $utils = new Utils_datos();
    if(isset($_REQUEST["idIndicador"]) && $_REQUEST["idIndicador"]!=""){
        $id = $utils->getIDReporteByIndicador($db,$_REQUEST["idIndicador"]);        
    } else {
        $id = str_replace('row_','',$_REQUEST["id"]);
    }
    $reporte = $utils->getDataEntity("reporte",$id);
    $dates = $utils->getDatesReport($db, $reporte["idsiq_reporte"]);
    
?>
<style>
th, td {
    border: 1px solid #000000;
    padding: 0.3em;
}
</style>

<div id="contenido" >
      <h2 style="margin-top:10px;margin-bottom:0.1em;"><?php echo $reporte["nombre"]; ?></h2>
      <?php if($reporte["descripcion"]!= null && $reporte["descripcion"]!=""){ 
        echo "<p>".$reporte["descripcion"]."</p>";
      } ?>
        
      <?php          
          include("./reportes/".$categoria["alias"]."/view".$reporte["alias"].".php");
       ?>
</div>

<?php writeFooter(); ?>
