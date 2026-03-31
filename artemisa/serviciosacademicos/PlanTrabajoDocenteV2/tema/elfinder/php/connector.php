<?php

error_reporting(1); // Set E_ALL for debuging

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';

$idDocente = $_GET["idDocente"];

$idPrograma = $_GET["idPrograma"];

$idPeriodo = $_GET["idPeriodo"];

/*$idVocacion = $_GET["idVocacion"];

$idMateria = $_GET["idMateria"];*/

// Required for MySQL storage connector
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeMySQL.class.php';
// Required for FTP connector support
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeFTP.class.php';

/*function clear_spec_char($string){
$string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

$string = strtolower($string);
$string = strtr($string, array('&' => '-', '"' => '-', '&'.'#039;' => '-', '<' => '-', '>' => '-', '\'' => '-'));
$string = preg_replace('/^[^a-z0-9]{0,}(.*?)[^a-z0-9]{0,}$/si', '\\1', $string);
$string = preg_replace('/[^a-z0-9.\-]/', '-', $string);
$string = preg_replace('/[\-]{2,}/', '-', $string);
return $string;
}

function sanitize($cmd, $result, $args, $elfinder) {

    $files = $result['added'];
  foreach ($files as $file) {
            $name = $file['name'];
            $webalized = $file['name'];
            if (strcmp($name, $webalized) != 0) {
                $arg = array('target' => $file['hash'], 'name' => $webalized);
                $elfinder->exec('rename', $arg);
            }
        }

return true;
}*/


/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from  '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}

$opts = array(
	//'debug' => true,
	'roots' => array(
		array(
			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
			'path'          => '../../../documentos/'.$idDocente.'/'.$idPeriodo.'/'.$idPrograma.'/',
			'startPath'		=> '../../../documentos/'.$idDocente.'/'.$idPeriodo.'/'.$idPrograma.'/',         // path to files (REQUIRED)
			'URL'           => dirname($_SERVER['PHP_SELF']) . '../../../../documentos/'.$idDocente.'/'.$idPeriodo.'/'.$idPrograma.'/', // URL to files (REQUIRED)
			'alias'			=> 'Plan Docente',// disable and hide dot starting files (OPTIONAL)
			'disabled' 		=> array('mkdir','mkfile', 'edit', 'rename', 'upload'),
			'accessControl' => 'access'
		)
	)
);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

