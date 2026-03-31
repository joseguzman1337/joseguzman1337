<?php
defined('_EXEC') or die;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo HTTP_SITE;?>/assets/images/favicon.ico" type="image/x-icon" />
    <title>
        Gestion de oportunidades
    </title>
    
    <?php include_once (PATH_SITE."/includes/includeJs.php");?>
    <?php include_once (PATH_SITE."/includes/includeCss.php");?>
    <?php include_once (PATH_GESTION."/includes/includeJs.php");?>
    <script type="text/javascript">
    var HTTP_GESTION= "<?php echo HTTP_GESTION; ?>";
    var HTTP_SITE= "<?php echo HTTP_SITE; ?>";
    var HTTP_ROOT = "<?php echo HTTP_ROOT; ?>";
    </script>
    
</head>
<body>
    <div id="content-container" style="padding-top: 0!important;">
        <div class="loaderContent">
            <div class="contenedorInterior">
                <i class="fa fa-spinner fa-pulse fa-5x"></i>
                <span class="sr-only">Cargando...</span>
                <div id="mensajeLoader"></div>
            </div>
        </div>
        <div id="page-alert"></div>
        <div id="page-content">
            <?php echo $contenido ;?>
        </div>
    </div>
    
    <?php include_once (PATH_SITE."/includes/includeJsFooter.php");?>
</body>
</html>