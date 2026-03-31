<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$q = strtolower($_REQUEST["actividad"]);
$selected = strtolower($_REQUEST["selected"]);
//var_dump($_REQUEST);

if (!$q) die();

//var_dump($q);
$fechahoy=date("Y-m-d H:i:s"); 
$actividadesSelectSql="select * from actividadEducacionContinuada where codigoestado=100 AND actividadPadre=".$q;
$actividadesHijas = $db->GetAll($actividadesSelectSql);
	
if($actividadesHijas!=NULL && count($actividadesHijas)>0){
    $hayActividades = true;
    $html = '<select name="actividad" id="actividadHija" class="required">';    
    foreach ($actividadesHijas as $actividad){
        if($selected === $actividad["idactividadEducacionContinuada"]){
            $html .= '<option value="'.$actividad["idactividadEducacionContinuada"].'" selected>'.$actividad["nombre"].'</option>';
        } else {
            $html .= '<option value="'.$actividad["idactividadEducacionContinuada"].'" >'.$actividad["nombre"].'</option>';
        }
    }
    $html .= '</select>';
} else {
	$hayActividades = false;
	$html = '<input type="hidden" name="actividad" id="actividadHija" value="'.$q.'" />';
}

//var_dump($existe);
// return the array as json
echo json_encode(array("result"=>$hayActividades,"html"=>$html));
?>
