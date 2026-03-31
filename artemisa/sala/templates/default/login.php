<?php defined('_EXEC') or die;  
include_once (PATH_SITE."/includes/cacheControl.php");
$auth = Factory::getSessionVar('auth');
if($auth===true){
    header("Location: ".HTTP_SITE."/");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> 
    <link rel="icon" href="<?php echo HTTP_SITE;?>/assets/images/favicon.ico" type="image/x-icon" />
    <title>Ingreso al Sistema de gestión académica en línea - SALA.</title>
    
    <script type="text/javascript">
    var ANALYTICS = "<?php echo ANALYTICS; ?>";
    var HTTP_SITE = "<?php echo HTTP_SITE;?>";
    var HTTP_ROOT = "<?php echo HTTP_ROOT;?>";
    </script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo ANALYTICS; ?>"></script>
    <script async >
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', ANALYTICS);
    </script>
    <!-- Google Analytics -->
    <script async >
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', ANALYTICS, 'auto');
    ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->
    <!--STYLESHEET-->
    <!--=================================================-->
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <?php echo Factory::printImportJsCss("css",HTTP_SITE."/assets/css/bootstrap.min.css"); ?>

    <!--Nifty Stylesheet [ REQUIRED ]-->
    <?php echo Factory::printImportJsCss("css",HTTP_SITE."/assets/css/nifty.min.css"); ?>
    
    <!--Font Awesome [ OPTIONAL ]-->
    <?php echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/font-awesome/css/font-awesome.css"); ?>

    <!--Demo [ DEMONSTRATION ]-->
    <?php echo Factory::printImportJsCss("css",HTTP_SITE."/assets/css/btlogin.css"); ?>
    
    <!--SCRIPT-->
    <!--=================================================-->
    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <?php echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/pace/pace.min.css"); ?>
    <?php echo Factory::printImportJsCss("css",HTTP_SITE."/assets/css/loader.css"); ?>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/pace/pace.min.js"); ?>

    <!--jQuery [ REQUIRED ]-->
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/jquery-3.6.0.min.js"); ?>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/jquery-ui.min.js"); ?>
		
    <!--JAVASCRIPT-->
    <!--=================================================-->
    <!--BootstrapJS [ RECOMMENDED ]-->
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/bootstrap.min.js"); ?>

    <!--Fast Click [ OPTIONAL ]-->
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/fast-click/fastclick.min.js"); ?>
    
    <!--Nifty Admin [ RECOMMENDED ]-->
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/nifty.min.js"); ?>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/general.js"); ?>
    <?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootbox/bootbox.min.js"); ?>
    
</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
    
    <div id="container" class="cls-container">
        <div class="loaderContent">
            <div class="contenedorInterior">
                <i class="fa fa-spinner fa-pulse fa-5x"></i>
                <span class="sr-only">Cargando...</span>
                <div id="mensajeLoader"></div>
            </div>
        </div>
        <?php echo $component; ?>
    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER -->

</body>
</html>
