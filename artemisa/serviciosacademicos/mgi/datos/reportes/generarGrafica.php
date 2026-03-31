<?php
    // this starts the session 
    session_start();
    if(isset($_REQUEST["usuario"])){
        $_SESSION['MM_Username'] = $_REQUEST["usuario"];
    }
    
    require_once("../templates/template.php");
    include("../../pChart/class/pData.class.php");
    include("../../pChart/class/pDraw.class.php");
    include("../../pChart/class/pImage.class.php");
    $db = writeHeader("Visualizar Gráficas Reporte",TRUE);
    $fontPath = "../../pChart/fonts/";
    
    $data = array();
    $utils = new Utils_datos();
    if(isset($_REQUEST["idIndicador"]) && $_REQUEST["idIndicador"]!=""){
        $id = $utils->getIDReporteByIndicador($db,$_REQUEST["idIndicador"]);        
    } else {
        $id = str_replace('row_','',$_REQUEST["id"]);
    }
    $reporte = $utils->getDataEntity("reporte",$id);
    $categoria = $utils->getDataEntity("categoriaData",$reporte["categoria"]);  
    $dates = $utils->getDatesReport($db, $reporte["idsiq_reporte"]);
    
    function getPeriodos($db,$dates){
        $query="select codigoperiodo from periodo where fechainicioperiodo>='".$dates["fecha_inicial"]."' AND fechavencimientoperiodo<='".$dates["fecha_final"]."' ORDER BY codigoperiodo ASC";
        return $db->Execute($query);
    }

    function getPeriodosArray($db,$dates){
        $query="select codigoperiodo from periodo where fechainicioperiodo>='".$dates["fecha_inicial"]."' AND fechavencimientoperiodo<='".$dates["fecha_final"]."' ORDER BY codigoperiodo ASC";
        return $db->GetAll($query);
    }

    function getModalidades($db){
        $query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400) ";
        return $db->Execute($query_modalidad);
    }

    function getCarrerasModalidadSIC($db,$modalidad){
        $query_nomcarrera = "select nombrecarrera, codigocarrera from carrera 
            where now() between fechainiciocarrera and fechavencimientocarrera
            and codigomodalidadacademicasic ='".$modalidad."' ORDER BY nombrecarrera ASC"; 
        return $db->Execute($query_nomcarrera);     
    }
    
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
            /*if(isset($_REQUEST["codigoperiodo"])){
                include("./graficasReportes/".$reporte["archivoReporte"].".php?codigoperiodo=".$_REQUEST["codigoperiodo"]);
            } else {*/
      
                include("./graficasReportes/".$categoria["alias"]."/graficas".$reporte["alias"].".php");
            //}
       ?>
</div>

<?php writeFooter(); ?>
