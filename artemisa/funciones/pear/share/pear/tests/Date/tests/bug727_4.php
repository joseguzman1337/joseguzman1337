<?php
/*
 * Tests for weeksInMonth, "random"
 * Monday as 1st day of week
 */
define('DATE_CALC_BEGIN_WEEKDAY', 1);
require_once "Date/Calc.php";

/**
 * Test dates from 1970 to 2029
 * Data from: http://www.merlyn.demon.co.uk/wknotest.txt
 * Others usefull datas available from:
 * http://www.merlyn.demon.co.uk/#dat
 */
$datapath = dirname( __FILE__);

$failed_test_data   = false;
$dates   = file($datapath . '/weeksinmonth_rdm_monday.txt');
$cnt     = sizeof($dates);
$valids = array();
for( $i=0;$i<$cnt;$i++ ){
    $parts      = explode('/',$dates[$i]);
    $valids[$parts[0]] = array($parts[1]=>(int)str_replace("\n",'',$parts[2]));
}
unset($dates);
foreach($valids as $year => $months){
    foreach ($months as $month=>$valid_weeks) {
        $calc_weeks = Date_Calc::weeksInMonth($month,$year);
        if($calc_weeks!=$valid_weeks){
            $failed_test_data   = true;
            echo "Bug 727, pass 4: $year/$month failed. Expect:$valid_weeks Got:$calc_weeks\n";
        }
    }
}
if (!$failed_test_data) {
    echo "Bug #727, pass 4: OK\n";
}
?>
