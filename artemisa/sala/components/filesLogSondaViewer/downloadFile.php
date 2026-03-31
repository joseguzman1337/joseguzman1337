<?php

//Si la variable archivo que pasamos por URL no esta
//establecida acabamos la ejecucion del script.

if (!isset($_GET['archivo']) || empty($_GET['archivo'])) {
    echo 'no existe';
}

//Utilizamos basename por seguridad, devuelve el
//nombre del archivo eliminando cualquier ruta.
$archivo = $_GET['archivo'];

$ruta = realpath(dirname(__FILE__) . "/../../../libsoap/logsSondaEcollet") .'/'. $archivo;

if (is_file($ruta)) {
    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=".$archivo."");
    header("Pragma: no-cache");
    header("Expires: 0");
    flush();
    readfile($ruta);
} else
    {
        exit();
    }
