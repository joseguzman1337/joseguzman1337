<?php
$ADODB_COUNTRECS = false
$server="172.16.7.109";
$user="root";
$password="";
$database="salad";
$sala = &ADONewConnection('mysql');
if (!$sala) die("Connection failed");
$sala->debug = true; 
$sala->setfetchMode(ADODB_FETCH_ASSOC);
$sala->Connect($server, $user, $password, $database); 
?>
