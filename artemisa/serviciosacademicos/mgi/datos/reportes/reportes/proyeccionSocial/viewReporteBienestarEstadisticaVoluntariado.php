<br/>
<?php 
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
 $reporteEspecifico=1;
 include(dirname(__FILE__)."../../templates/template.php");
 include(dirname(__FILE__)."/../../../registroInformacion/formularios/proyeccionSocial/viewBienestarUniversitarioVoluntariadoUniversitario.php");
?>