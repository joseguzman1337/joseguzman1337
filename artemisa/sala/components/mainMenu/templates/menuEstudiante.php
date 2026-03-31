<?php 
defined('_EXEC') or die; 
echo Factory::printImportJsCss("css",HTTP_SITE."/components/mainMenu/assets/css/menuEstudiante.css");
?>
        <div class="menu-estudiante has-scrollbar" style=""> 
            <div class="list-group  bord-no"> 
                <!--Menu list item-->
                <a href="<?php echo HTTP_SITE; ?>/index.php?option=estudiantes" id="menuId_164" class="menuBoton list-group-item" data-rel=" " >
                    <i class="fa fa-user-circle"></i>
                    <span class="menu-title">
                        &nbsp;<strong>Mi cuenta (Estudiantes)</strong>
                    </span> 
                </a> 
                <?php
                //ddd($valores);
                foreach($menuEstudiante as $m){
                    $codTipo = $m->getCodigotipomenuboton();
                    if($codTipo == 100){
                        
                        $link = HTTP_ROOT."/".MainMenu::getLinkMenuBoton($m,$valores);
                        $text = $m->getNombremenuboton();
                        $menuid = $m->getIdmenuboton();
                        $icon = $m->getIconMenu()->getIcon();
                        ?>
                            <a href="<?php echo $link; ?>" id="menuId_" class="menuBoton list-group-item" data-rel="iframe" >
                                <i class="fa <?php echo $icon; ?>"></i>
                                <span class="menu-title">
                                    &nbsp;<strong><?php echo ucwords($text); ?></strong>
                                </span> 
                            </a> 
                        <?php
                    }
                }
                ?> 
            </div>
        </div>
                    
                    
                    