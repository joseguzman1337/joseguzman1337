<?php
$time = time();
$expires =  strtotime(date("Y-m-d 00:00:00", mktime(0,0,0,date("n", $time),date("j",$time)+ 5 ,date("Y", $time))));
header("Cache-Control: max-age=432000, public"); //5 days (60sec * 60min * 24hours  )
header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', $expires));