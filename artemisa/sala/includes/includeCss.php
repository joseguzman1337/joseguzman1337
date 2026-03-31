<?php 
echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");
echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
?>

<!--Bootstrap Stylesheet [ REQUIRED ]-->
<?php
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/css/bootstrap.css");
?> 

<!--Btheme Stylesheet [ REQUIRED ]-->
<?php
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/css/btheme.css");
?>
    
<!--Font Awesome [ OPTIONAL ]-->
<?php
echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
?>
    
<!--Theme styles-->
<?php
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/css/template.css");
echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/chosen.css");
echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap-datetimepicker.css");
echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap-datetimepicker.min.css");
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/css/loader.css");
?>