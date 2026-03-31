<?php 

require_once (realpath(dirname(__FILE__)).'/Autoloader.php');
Mustache_Autoloader::register();
$mustache = new Mustache_Engine(array(
   'loader' => new Mustache_Loader_FilesystemLoader($rutaVistas),
	/*'cache' => realpath(dirname(__FILE__)).'/../tmp/cache/mustache',  */ 
	'charset' => 'UTF-8'
));
?>