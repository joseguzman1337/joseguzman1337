<?php 
defined('_EXEC') or die; 
?>
<?php echo Factory::printImportJsCss("js",HTTP_SITE."/components/userMenu/assets/js/userMenu.js"); ?>
<script type="text/javascript">
    var disablePulsar = <?php echo (!empty($disablePulsar)?"true":"false"); ?>;
</script>
<ul class="nav navbar-top-links pull-right">
    
    <li class="hidden-sm hidden-md hidden-lg visible-xs">
        <a href="<?php echo HTTP_SITE;?>/index.php" id="menuId_0" class="menuItem" rel="">
             <i class="fa fa-home"></i> Inicio
        </a>
    </li>
    <!--Periodo Seleccionado -->
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <li class="dropdown">
        <a class="periodoactivo hidden-xs">
            Periodo: <i class="fa fa-calendar-check-o"></i> <strong><?php echo $codigoPeriodo;?></strong>
        </a>
    </li>
    
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <!--End periodo seleccionado-->
    
    <!--Perfil selector-->
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <?php echo $selectPerfil;?> 
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <!--End perfil selector-->
    <!--User dropdown-->
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <li id="dropdown-user" class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
            <span class="pull-right">
                <?php /*/ ?><img class="img-circle img-user media-object" src="<?php echo HTTP_ROOT; ?>/imagenes/estudiantes/1000123624.jpg" alt="Profile Picture"><?php /**/ ?>
                <img class="img-circle img-user img-rectangulo media-object" src="<?php echo $imgUsuario; ?>" alt="Profile Picture">
            </span>
            <div class="username hidden-xs"><?php echo ucwords(mb_strtolower($Usuario->getNombres(),"UTF-8"))." ".ucwords(mb_strtolower($Usuario->getApellidos(),"UTF-8"));?></div>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">
            <?php echo $curCarrera;?>
            <?php /*/?><!-- Dropdown heading  -->
            <div class="pad-all bord-btm">
                <p class="text-lg text-muted text-thin mar-btm">750Gb of 1,000Gb Used</p>
                <div class="progress progress-sm">
                    <div class="progress-bar" style="width: 70%;">
                        <span class="sr-only">70%</span>
                    </div>
                </div>
            </div><?php /**/ ?> 
            <!-- User dropdown menu -->
            <ul class="head-list">
                <?php
                foreach($menuItems as $mi){
                    echo $mi;
                }
                ?>
            </ul>

            <!-- Dropdown footer -->
            <div class="pad-all text-right">
                <a href="#" class="btn btn-warning logout" >
                    <i class="fa fa-sign-out fa-fw"></i> Cerrar sesión
                </a>
            </div>
        </div>
    </li>

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <!--End user dropdown-->
    <li class="">
        <a class="btn btn-link btn-icon icon-lg fa fa-sign-out logout add-tooltip" data-placement="bottom" data-toggle="tooltip" data-original-title="Cerrar sesión" ></a>
    </li>
</ul>