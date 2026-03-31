<?php 
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
defined('_EXEC') or die;
$Configuration = Configuration::getInstance();
$pos = strpos($Configuration->getEntorno(), "local");
$hacerAnalisis = true;
if( $Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"||$pos!==false ){
    $hacerAnalisis = false;
    if(HTTP_ROOT==="https://artemisa365.unbosque.edu.co"){
        $hacerAnalisis = true;
    }
}

$ANALYTICS = ANALYTICS;
$idPerfil = Factory::getSessionVar("idPerfil");

if(!empty($idPerfil)){
    $ANALYTICS = ANALYTICS_ADM;
    if($idPerfil==1){
        $ANALYTICS = ANALYTICS_EST;
    }
}
//d($ANALYTICS);
if(!$hacerAnalisis){
    ?>
    <script type="text/javascript">
    var ANALYTICS = false;
    </script>
    <?php
}else{
    ?>
    <script type="text/javascript">
    var ANALYTICS = "<?php echo $ANALYTICS; ?>";
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ANALYTICS; ?>"></script>
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
    <?php
}
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/trackAnalytics.js");
