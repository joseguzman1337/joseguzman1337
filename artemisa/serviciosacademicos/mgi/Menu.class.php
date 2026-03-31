<?php

class Menu_Global {

    public function writeMenu($URL, $nombre, $Active, $onclick = true, $option = false) {
        ?>
        <link rel="stylesheet" href="../../css/styleMonitoreo.css" type="text/css" />  
        <div id="menuPrincipal">
            <ul>
                <?php
                for ($i = 0; $i < count($URL); $i++) {
                    $target = '';
                    ?>
                    <li id="Opcion_<?php echo $i ?>" onmouseout="$(this).removeClass('active');" onmouseover="$(this).addClass('active');"<?php if ($Active[$i] == 1) { ?>class="active"<?php } ?>>
                        <?php
                        if ($option === true) {
                            $target = 'target="_blank"';
                        }
                        ?>
                        <a <?php echo $target; ?> href="<?php echo $URL[$i] ?>" <?php if ($onclick) { ?>onclick="Add_Class(<?php echo $i ?>);"<?php } ?>><?php echo $nombre[$i] ?></a>

                    </li>
                    <?php
                }
                ?>
            </ul>            
        </div>
        <script type="text/javascript">
            calculateWidthMenu();
            //Para que arregle el menu al cambiar el tamaño de la página
            $(window).resize(function () {
                calculateWidthMenu();
            });
        </script>
        <?php
    }

    public function writeMenu2($URL, $nombrePrincipal, $nombre, $Active) {
        ?>
        <div id="menuPrincipal" class="menu">
            <ul class="littleSmaller clearfix">
                <li class="active current-item"><a href="#"><?php echo $nombrePrincipal; ?> <span class="arrow">▼</span></a>
                    <ul class="sub-menu">
                        <?php
                        for ($i = 0; $i < count($URL); $i++) {  
                            ?>
                            <li <?php if ($Active[$i] == 1) { ?>class="active current-item"<?php } ?>><a href="<?php echo $URL[$i] ?>" ><?php echo $nombre[$i] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>            
        </div>
        <?php
    }
}
?>