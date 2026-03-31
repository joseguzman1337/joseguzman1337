<?php 
defined('_EXEC') or die;
include_once (PATH_SITE."/includes/cacheControl.php");
$Configuration = Configuration::getInstance();
$entorno = $Configuration->getEntorno();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo HTTP_SITE;?>/assets/images/favicon.ico" type="image/x-icon" />
    <title>
        <?php 
        echo $tituloSeccion." "; 
        if($entorno!=="produccion"){
            echo $entorno;
        }
        ?>
    </title>
    <script type="text/javascript">
    var HTTP_SITE = "<?php echo HTTP_SITE; ?>";
    var HTTP_ROOT = "<?php echo HTTP_ROOT; ?>";
    var alowNavigate = true; //esta variable permite o no navegar las opciones del menu dependiendo de las condiciones para estudiantes u otros usuarios
    </script>
<!--  Space loading indicator  -->
    <script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>
    <?php include_once (PATH_SITE."/includes/includeJs.php");?>
    <?php include_once (PATH_SITE."/includes/includeCss.php");?>
    <?php include_once (PATH_SITE."/includes/googleAnalytics.php");?>

    <script>
        Pace.options.elements.selectors=['#content-container'];
        Pace.restart();
    </script>

<!--  loading cornerIndicator  -->
    <link href="<?php echo HTTP_SITE; ?>/assets/css/cornerIndicator/cornerIndicator.css" rel="stylesheet">

</head>
<style type="text/css">
    #navbar.produccionHeader,
    #navbar.produccionHeader #navbar-container.boxed,
    #navbar.produccionHeader #navbar-container.boxed .navbar-content,
    #navbar.produccionHeader #navbar-container.boxed .navbar-header,
    #navbar.produccionHeader #navbar-container.boxed .navbar-header a
    {
        background-color: #7CC240  !important;
    }
</style>
<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
    <div id="container" class="effect mainnav-lg <?php if(!empty($asideContainer)){?>aside-in aside-left aside-bright<?php } ?>">
        <!--NAVBAR-->
        <!--===================================================-->
        <header id="navbar" class="<?php echo ($entorno!=="produccion")?"entornoPruebas":"produccionHeader"?>">
            <div id="navbar-container" class="boxed">
                <!--Brand logo & name-->
                <!--================================-->
                <div class="navbar-header">
                    <a href="<?php echo HTTP_SITE; ?>" class="navbar-brand">
                        <?php
                        if($entorno!=="produccion")
                        {?>
                            <img src="<?php echo HTTP_SITE; ?>/assets/images/logo.png" alt="Logo" class="brand-icon">
                            <?php
                        }
                        ?>
                        <div class="brand-title">
                            <span class="brand-text">
                                <?php
                                if($entorno==="produccion"){
                                    ?>
                                    <img src="<?php echo HTTP_SITE; ?>/assets/images/logoSALA/Logo-UEB-Sala.svg" width="100%" alt="btheme Logo" class="brand-icon">
                                    <?php
                                }else{
                                    ?>
                                    Entorno <?php echo $entorno; ?>
                                    <?php
                                }
                                ?>
                            </span>
                        </div>
                    </a>
                </div>
                <!--================================-->
                <!--End brand logo & name-->
                
                <!--Navbar Dropdown-->
                <!--================================-->
                <div class="navbar-content clearfix">
                    <ul class="nav navbar-top-links pull-left">
                        <!--Navigation toogle button-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <li class="tgl-menu-btn">
                            <a class="mainnav-toggle" href="#">
                                <i class="fa fa-navicon fa-lg"></i>
                            </a>
                        </li>
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <!--End Navigation toogle button-->
                        <?php 
                        if(mktime() < mktime(0, 0, 0, 3, 31, 2018)){
                            ?>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--Notification dropdown-->
                            <li class="dropdown hidden-xs">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-xs" aria-expanded="false">
                                    <i class="fa fa-bell fa-lg"></i>
                                    <span class="badge badge-header badge-danger">1</span>
                                </a>
                                <!--Notification dropdown menu-->
                                <div class="dropdown-menu dropdown-menu-md with-arrow">
                                    <div class="pad-all bord-btm">
                                        <p class="text-lg text-muted text-thin mar-no">Usted tiene 1 mensaje.</p>
                                    </div>
                                    <div class="nano scrollable has-scrollbar" style="height: 0px;">
                                        <div class="nano-content" tabindex="0" style="right: -13px;">
                                            <ul class="head-list">
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="<?php echo HTTP_ROOT;?>/serviciosacademicos/consulta/facultades/consultafacultadesv2.php" class="media">
                                                        <?php /*/ ?><span class="badge badge-danger pull-right"><i class="fa fa-refresh fa-spin  fa-xs"></i></span>
                                                        <span class="label label-danger pull-right">New</span><?php /**/ ?>
                                                        <div class="media-left">
                                                            <span class="icon-wrap icon-circle bg-warning">
                                                                <i class="fa fa-refresh fa-lg"></i>
                                                            </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">Clic aca para <strong>VOLVER</strong> a la versión anterior</div>
                                                            <small class="text-muted">Disponible hasta el 30 de marzo</small>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="nano-pane" style="display: none;"><div class="nano-slider" style="height: 20px; transform: translate(0px, 0px);"></div></div>
                                    </div>
                                </div>
                            </li>
                            <!--End Notification dropdown-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <?php
                        }
                        ?>
                    </ul>
                    <?php echo $userMenu;?>
                </div>
                
                <!--================================-->
                <!--End Navbar Dropdown-->
            </div>
        </header>
        <!--===================================================-->
        <!--END NAVBAR-->
        
        <div class="boxed">
            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <div class="loaderContent">
                    <div class="contenedorInterior">
                        <i class="fa fa-spinner fa-pulse fa-5x"></i>
                        <span class="sr-only">Cargando...</span>
                        <div id="mensajeLoader"></div>
                    </div>
                </div>
                <div id="page-alert"></div>
                <!--Page Title-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div id="page-title">
                    <h1 class="page-header text-overflow"><?php echo $tituloSeccion; ?></h1>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End page title-->
                
                <!--Breadcrumb-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div id="page-breadCrumb">
                    <?php echo $breadCrumb; ?>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End breadcrumb-->
                
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    <?php echo $component;?>
                </div>
                <!--===================================================-->
                <!--End page content-->
            
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->
            
            <!--MAIN NAVIGATION-->
            <!--===================================================-->
            <nav id="mainnav-container">
                <div id="mainnav">
                    <!--Shortcut buttons-->
                    <!--  -->
                    <div id="mainnav-shortcut">
                        <ul class="list-unstyled">
                            <li class="col-xs-4" data-content="Preguntas Frecuentes" data-original-title="" title="">
                                <a id="demo-toggle-aside" rel="iframe" class="menuItem shortcut-grid" href="<?php echo HTTP_ROOT; ?>/serviciosacademicos/consulta/facultades/centralPreguntasFrecuentes.htm">
                                    <i class="fa fa-question-circle"></i>
                                </a>
                            </li>
                            <li class="col-xs-4" data-content="Correo Institucional" data-original-title="" title="">
                                <a id="demo-alert" rel="" class="shortcut-grid" href="https://mail.google.com/a/unbosque.edu.co" target="_blank">
                                    <i class="fa fa-envelope"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--End shortcut buttons-->
                    
                    <!--Menu-->
                    <?php echo $mainMenu; ?>
                    <!--End menu-->
                
                </div>
            </nav>
            <!--===================================================-->
            <!--END MAIN NAVIGATION-->
			
            <!--ASIDE-->
            <!--===================================================-->
            <!--ASIDE-->
            <!--===================================================-->
            <aside id="aside-container">
                <?php echo $asideContainer;?>
            </aside>
            <!--===================================================-->
            <!--END ASIDE-->
            <!--===================================================-->
            <!--END ASIDE-->
        </div>
        
        <!-- FOOTER -->
        <footer id="footer">
            <div class="hide-fixed pull-right pad-rgt"><i class="fa fa-html5"></i> <i class="fa fa-linux fa-php"></i> SALA V1.0</div>
            <p class="pad-lft">&copy; <?php echo date('Y'); ?> Universidad El Bosque</p>
        </footer>
        <!-- END FOOTER -->


        <!-- SCROLL TOP BUTTON -->
        <!--===================================================-->
        <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
        <!--===================================================-->



        <div id="floating-top-right" class="floating-container"></div>
    
    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER --> 
    
    <?php include_once (PATH_SITE."/includes/includeJsFooter.php");?>
</body>
</html>

