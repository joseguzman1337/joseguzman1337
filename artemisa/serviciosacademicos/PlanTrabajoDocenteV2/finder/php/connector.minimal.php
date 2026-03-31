<?php

error_reporting(0); // Set E_ALL for debuging

require './autoload.php';
// ===============================================

elFinder::$netDrivers['ftp'] = 'FTP';


/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from '.' (dot)
 *
 * @param  string    $attr    attribute name (read|write|locked|hidden)
 * @param  string    $path    absolute file path
 * @param  string    $data    value of volume option `accessControlData`
 * @param  object    $volume  elFinder volume driver object
 * @param  bool|null $isDir   path is directory (true: directory, false: file, null: unknown)
 * @param  string    $relpath file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume, $isDir, $relpath) {
	$basename = basename($path);
	return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
			 && strlen($relpath) !== 1           // but with out volume root
		? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
		:  null;                                 // else elFinder decide it itself
}

$idDocente = $_GET["idDocente"];
$idPrograma = $_GET["idPrograma"];
$idPeriodo = $_GET["idPeriodo"];


// Documentation for connector options:
// https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options

$opts = array(
	// 'debug' => true,
	'roots' => array(
		// Items volume 
            
		array(      
			'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
			'path'          => '../../documentos/'.$idDocente.'/'.$idPeriodo.'/'.$idPrograma.'/',                 // path to files (REQUIRED)
			'startPath'     => '../../documentos/'.$idDocente.'/'.$idPeriodo.'/'.$idPrograma.'/',
                        'URL'           => dirname($_SERVER['PHP_SELF']) . '../../../documentos/'.$idDocente.'/'.$idPeriodo.'/'.$idPrograma.'/', // URL to files (REQUIRED)
		        'alias'			=> 'Plan Docente',// disable and hide dot starting files (OPTIONAL)
			'disabled' 		=> array('mkdir','mkfile', 'edit', 'rename', 'upload'),    
                        'accessControl' => 'access'                     // disable and hide dot starting files (OPTIONAL)
		)
       )
);

$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

