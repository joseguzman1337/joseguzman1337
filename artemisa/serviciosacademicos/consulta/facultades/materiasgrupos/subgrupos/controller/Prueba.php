<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//include_once ('RotacionSubGrupos_class.php');  $C_Rotacion = new RotacionSubGrupos();
echo '<br>Fecha_1->'.$Fecha_1 = '2015-06-10';
echo '<br><br>Fecha_2->'.$Fecha_2 = '2015-06-30';
echo '<br><br>Fecha_3->'.$fecha_3 = '2015-06-24';

$Value = check_in_range($Fecha_1,$Fecha_2,$fecha_3);

if($Value){
     echo "<br>SI estas en rango";
}else{
     echo "<br>NO estas en rango";
}


$Value2 = Validafecha($Fecha_1,$Fecha_2,$fecha_3);

if($Value2){
     echo "<br>SI estas en rango ...1";
}else{
     echo "<br>NO estas en rango....1";
}


function check_in_range($start_date, $end_date, $evaluame) {
        
    $start_ts = strtotime($start_date);
    $end_ts   = strtotime($end_date);
    $user_ts  = strtotime($evaluame);
    
    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));  
    
    }
    
function Validafecha($Fecha_1,$Fecha_2,$Fecha_3){
    $tmp = explode('-',$Fecha_1);
    $Fecha_In = mktime(0,0,0,$tmp[1],$tmp[2],$tmp[0]);
    
    
    $tmp = explode('-',$Fecha_2);
    $Fecha_Fi = mktime(0,0,0,$tmp[1],$tmp[2],$tmp[0]);
    
    
    $tmp = explode('-',$Fecha_3);
    $Fecha_A = mktime(0,0,0,$tmp[1],$tmp[2],$tmp[0]);
    
    return (($Fecha_A >= $Fecha_In) && ($Fecha_A <= $Fecha_Fi));
}    
?>