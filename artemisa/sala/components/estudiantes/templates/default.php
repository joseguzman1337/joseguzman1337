<?php defined('_EXEC') or die;
echo Factory::printImportJsCss("js",HTTP_SITE."/components/estudiantes/assets/js/estudiantes.js"); 
echo Factory::printImportJsCss("css",HTTP_SITE."/components/estudiantes/assets/css/estudiantes.css");
?>
<div class="row"> 
    <div class="left-col">
        <div class="col-lg-12 " id="contenido-estudiante">
            <?php echo $graficoNotas; ?>
        </div>
    </div>
    <div class="right-col hidden-xs hidden-sm" >
    </div>
</div> 
<aside class="aside-right hidden-xs hidden-sm" >
    <div class="nano has-scrollbar">
        <div class="nano-content" style="right: -20px;" >
            <?php echo $mainMenu; ?>
        </div>
    </div>
</aside>
<span class="fa-stack fa-lg hidden-md hidden-lg show-menu" id="show-hide-student-menu">
    <i class="fa fa-square-o fa-stack-2x"></i>
    <i class="fa fa-chevron-left fa-stack-1x " id="arrowIcon"></i>
</span>