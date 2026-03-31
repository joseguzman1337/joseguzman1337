<?php  defined('_EXEC') or die;  ?>
<!--JQuery [ REQUIRED ]-->
<?php 
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/jquery-3.1.1.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/jquery-migrate-1.2.1.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/jquery-ui.min.js");
?>

<!--Ajax Dinamic List Search Menu [ REQUIRED ]-->
<?php 
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/ajax.js");
//echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/ajax-dynamic-list-search-menu.js");
echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/chosen.jquery.min.js");
echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/triggerChosen.js");
echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/moment.min.js");
echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/moment-with-locales.js");
echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap-datetimepicker.js");
?>

<!--Bootbox Modals [ OPTIONAL ]-->
<?php 
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootbox/bootbox.min.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/validaVidaSesion.js");
?>
