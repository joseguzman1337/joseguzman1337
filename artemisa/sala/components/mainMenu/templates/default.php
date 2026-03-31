<?php defined('_EXEC') or die; ?>
<!--================================-->
<div id="mainnav-menu-wrap">
    <div class="search">
        <div class="nano-content" tabindex="0" style="right: -17px;">
            <ul id="search-menu" class="list-group">
                <!--Category name-->
                <li class="list-header">
                    <div class="input-group  bg-white">
                        <span class="input-group-addon"><i class="fa fa-search fa-lg"></i></span>
                        <input class="form-control" id="txt_buscador" placeholder="Búsqueda" type="text" >
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="nano has-scrollbar">
        <div class="nano-content" tabindex="0" style="right: -17px;">
            <ul id="mainnav-menu" class="list-group">
                <!--Menu list item--> 
                <li class="active-link">
                    <a href="<?php echo HTTP_SITE; ?>/index.php" id="menuId_0" rel="" class="menuItem">
                        <i class="fa fa-home"></i>
                        <span class="menu-title">
                            <strong>INICIO</strong> 
                        </span>
                    </a>
                </li> 

                <?php
                foreach($menu as $m){
                        $li = ModMainMenuHelper::printMenuItem(Factory::createDbo(), $m );
                        echo $li;
                        //d($m);
                }//exit;
                ?>

                <li class="list-divider"></li>
            </ul>
            <!--Widget-->
            <!--================================-->
            <div class="mainnav-widget">
                <!-- Show the button on collapsed navigation -->
                <div class="show-small">
                    <a href="#" data-toggle="menu-widget" data-target="#demo-wg-server">
                        <i class="fa fa-desktop"></i>
                    </a>
                </div>

                <!-- Hide the content on collapsed navigation -->
                <div id="demo-wg-server" class="hide-small mainnav-widget-content">
                    <ul class="list-group">
                        <li class="mar-btm bs-dashDoard-btn">
                            <a href="http://www.uelbosque.edu.co/" target="_blank" class="btn btn-success btn-labeled fa fa-desktop">Ir al portal institucional</a>
                            <a href="http://www.uelbosque.edu.co/nuestro-bosque/infraestructura" target="_blank" class="btn btn-success btn-labeled fa fa-map">Ver mapa institucional</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--================================-->
            <!--End widget-->
        </div>
        <div class="nano-pane" style="display: none;"><div class="nano-slider" style="height: 20px;"></div></div>

    </div>
</div>
<!--================================-->
                    
                    
                    