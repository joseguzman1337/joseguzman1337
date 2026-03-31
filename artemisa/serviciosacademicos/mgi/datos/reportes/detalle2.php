<?php
    // this starts the session 
    session_start();
 
    require_once("../templates/template.php");
    $db = writeHeader("Visualizar Reporte",TRUE);
    
    if(!isset($_REQUEST["idIndicador"])){
        include("./menu.php");
        writeMenu(0);
    }
    
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

<div id="contenido">
      <h2 style="margin-top:10px;margin-bottom:0.1em;"><?php echo $reporte["nombre"]; ?></h2>
      <?php if($reporte["descripcion"]!= null && $reporte["descripcion"]!=""){ 
        echo "<p>".$reporte["descripcion"]."</p>";
      } ?>
      
      <ul class="drop" id="nav">     
            <li tabindex="1" class="level1-li"><button onclick="hacerCorte()" type="button">Hacer corte de datos</button></li>
            <li tabindex="1" class="level1-li"><button onclick="verIndicadores()" type="button">Ver indicadores asociados</button></li>        
            <?php if($reporte["tipo_grafica"]!=NULL) { ?><li tabindex="1" class="level1-li"><button onclick="verGraficas()" type="button">Ver gráfica</button></li><?php } ?>
      </ul><br/><br/>
        
      <?php   include("./dialogIndicadores.php");
      
      if($reporte["plantilla_reporte"]!=null && $reporte["plantilla_reporte"]!=0){ 
                include("./detalleLayout".$reporte["plantilla_reporte"].".php");
      } else { 
            include("./reportesPersonalizados2/reporteGraduandos.php");
      } ?>
</div>

<script type="text/javascript">
    function verIndicadores(){
        $( "#dialog-indicadores" ).dialog( "open" );  
    }
    
//$( "#select-facultades" ).button().click(function() {
//                        $( "#dialog-facultades" ).dialog( "open" );                        
//});
                
                //dialogo indicadores asociados
                $( "#dialog-indicadores" ).dialog({
                    autoOpen: false,
                    height: 350,
                    width: 800,
                    modal: true,
                    position: 'center',
                    buttons: {
                    },
                    close: function(event) {
                        
                        //Para que no le haga submit automaticamente al form al cerrar el dialog
                        event.preventDefault();
                    }
                });
</script>

<?php writeFooter(); ?>
