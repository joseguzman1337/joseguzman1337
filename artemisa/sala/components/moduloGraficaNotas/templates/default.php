<?php
defined('_EXEC') or die;
//d($vinculos['menuEstudiante']);
foreach($menuEstudiante as $m){
    $codTipo = $m->getCodigotipomenuboton();
    if($codTipo == 100){

        $link = HTTP_ROOT."/".MainMenu::getLinkMenuBoton($m,$valores);
        $text = $m->getNombremenuboton();
        $menuid = $m->getIdmenuboton();
        $icon = $m->getIconMenu()->getIcon();
        ?>
        <div class="col-sm-6 col-md-4 col-lg-4">
            <!--Sales-->
            <a href="<?php echo $link; ?>" id="menuId_" class="menuBoton" style="color: #ffffff !important;" data-rel="iframe" >
                <div class="panel panel-success panel-colorful">
                    <div class="panel-body text-center"> 
                        <i class="fa <?php echo $icon; ?> fa-5x"></i>
                        <hr>
                        <p class="text-lg text-thin"><?php echo ucwords($text); ?></p> 
                    </div>
                </div>
                
            </a>
        </div>  
        <?php
    }
}
?>