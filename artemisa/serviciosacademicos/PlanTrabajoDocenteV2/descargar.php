<?php

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header("Content-Type: application/force-download");
header('Content-disposition: attachment; filename='. unserialize( urldecode( base64_decode( $_GET["bm9tYnJl"] ) ) ) );
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');


$file = unserialize( urldecode( base64_decode( $_GET["dWJpY2FjaW9u"] ) ) );

//echo $file;

readfile($file);
exit;
?>