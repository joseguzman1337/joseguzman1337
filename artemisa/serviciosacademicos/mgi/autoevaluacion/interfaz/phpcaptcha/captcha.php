<?php 
ini_set('display_errors', 'On');
error_reporting(E_ALL);
session_start();
// genero el codigo 
$ranStr = md5(microtime()); 
$ranStr = substr($ranStr, 0, 6);
//le asigno a la session el valor de mi captcha
$_SESSION['cap_code'] = $ranStr;
//creo la imagen con php
$newImage = imagecreatefrompng("cap_bg.png");  //imagecreatefromjpeg

$txtColor = imagecolorallocate($newImage, 0, 0, 0);
imagestring($newImage, 5, 5, 5, $ranStr, $txtColor);
header("Content-type: image/png");//header("Content-type: image/jpeg");
imagepng($newImage);//imagejpeg

?>


