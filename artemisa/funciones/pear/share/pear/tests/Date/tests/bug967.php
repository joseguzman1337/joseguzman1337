<?php
require_once 'Date.php';
$_DATE_TIMEZONE_DEFAULT = 'Pacific/Chatham';
$tz = Date_TimeZone::getDefault();
if ($tz->id!=$_DATE_TIMEZONE_DEFAULT && $tz->id!='Pacific/Chatham') {
    echo "setDefault Failed\n";
}
Date_TimeZone::setDefault('CST');
$default = 'EST';
$tz = Date_TimeZone::getDefault();
if ($tz->id!=$_DATE_TIMEZONE_DEFAULT && $tz->id!='EST') {
    echo "setDefault Failed\n";
}
?>
