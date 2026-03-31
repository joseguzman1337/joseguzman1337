<?php

    require("../templates/template.php");
    $db = writeHeader("Registrar datos",TRUE);
    
    if(!isset($_REQUEST["idIndicador"])&&(!isset($_REQUEST["menu"])||$_REQUEST["menu"]!=="0")){
        include("./menu.php");
        writeMenu(0);
    } else if(isset($_REQUEST["menu"])&&$_REQUEST["menu"]==="0"){ ?>
        <div id="menuPrincipal">
            <ul class="littleSmaller">
                <li><a href="./form.php?idIndicador=<?php echo $_REQUEST["idI"]; ?>">Volver a lista de formularios</a></li>
            </ul>            
        </div>
    <?php }
    
    $utils = new Utils_datos();
    if(isset($_REQUEST["idIndicador"])&&$_REQUEST["idIndicador"]!==""){
        $formulario = $utils->getFormularioIndicador($db,$_REQUEST["idIndicador"]); 
        
        if(count($formulario)>1){
            //es un listado de los formularios ?>
            <div id="contenido">
                <h4 style="margin-top:10px;margin-bottom:0.8em;">Formularios asociados al indicador</h4>
                <?php 
                    foreach ($formulario as $row) {
                        echo"<a href='./form.php?id=".$row["idsiq_formulario"]."&menu=0&idI=".$_REQUEST["idIndicador"]."'>".$row["nombre"]."</a><br/><br/>";
                    }
                ?>
            </div>
       <?php  writeFooter();   exit(); 
        } else {
            $formulario = $formulario[0];
        } 
    } else {
        $id = str_replace('row_','',$_REQUEST["id"]);   
        $formulario = $utils->getDataEntity("formulario",$id);  
    } 
    if(count($formulario)>0){
    $categoria = $utils->getDataEntity("categoriaData",$formulario["categoria"]);  }
    
?>
<div id="contenido">
      <h4 style="margin-top:10px;margin-bottom:0.8em;"><?php echo $formulario["nombre"]; ?></h4>
        <div id="form" style="margin: 0 5px;"> 
            <?php //$utils->viewForm($db,$formulario,$categoria,"form_test","medium"); 
            if(count($formulario)>0){
				$permisos = $utils->getDataPermisos($db);
                include("./formularios/".$categoria["alias"]."/form".$formulario["alias"].".php");            
            } else {
                echo "No se encontró un formulario asociado.";
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