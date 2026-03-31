<?php 
session_start();

function activeErrorReporting()
{
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  date_default_timezone_set('Europe/London');
}

function noCli()
{
  if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');
}

function getHeaders()
{

  // Redirect output to a client’s web browser (Excel5)
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="Estadísticas_Prueba_Academica.xls"');
  header('Cache-Control: max-age=0');
  // If you're serving to IE 9, then the following may be needed
  header('Cache-Control: max-age=1');

  // If you're serving to IE over SSL, then the following may be needed
  header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
  header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
  header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
  header ('Pragma: public'); // HTTP/1.0
}