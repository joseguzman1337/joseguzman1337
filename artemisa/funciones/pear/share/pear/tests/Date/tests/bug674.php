<?php
require_once 'Date.php';
$error = false;
$dates = array (
    array( array(2003,3,17),'20030323','20030317','20030324','20030310'),
    array( array(2003,3,20),'20030323','20030317','20030324','20030310'),
    array( array(2003,3,23),'20030323','20030317','20030324','20030310')
);
foreach ($dates as $d) {
    $date = $d[0];
    $res = Date_Calc::endOfWeek($date[2],$date[1],$date[0]);
    if ($res!=$d[1]) {
        echo "Bug 674 eow: " . $date[0].$date[1].$date[2]." failed\n";
        $error = true;
    }
}

foreach ($dates as $d) {
    $date = $d[0];
    $res = Date_Calc::beginOfWeek($date[2],$date[1],$date[0]);
    if ($res!=$d[2]) {
        echo "Bug 674 bow: " . $date[0].$date[1].$date[2]." failed\n";
        $error = true;
    }
}


foreach ($dates as $d) {
    $date = $d[0];
    $res = Date_Calc::beginOfNextWeek($date[2],$date[1],$date[0]);
    if ($res!=$d[3]) {
        echo "Bug 674 bonw: " . $date[0].$date[1].$date[2]." failed\n";
        $error = true;
    }
}


foreach ($dates as $d) {
    $date = $d[0];
    $res = Date_Calc::beginOfPrevWeek($date[2],$date[1],$date[0]);
    if ($res!=$d[4]) {
        echo "Bug 674 bopw: " . $date[0].$date[1].$date[2]." failed\n";
        $error = true;
    }
}

if (!$error) {
    echo "Bug 674: OK\n";
}

?>