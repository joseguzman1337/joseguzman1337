<?php 
header('Content-Type: application/json');
$arrayReturn = array();
$selected='';

    $arrayReturn['programasPlanDesarrollo'] = '<option value="-1" selected >Seleccionar</option>';

    if( isset( $programasPlanDesarrollo )) {
      
      foreach( $programasPlanDesarrollo as $programa ) {
          $arrayReturn['programasPlanDesarrollo'] .='<option value="'.$programa->getCarrera().'">'.$programa->getNombrePlanDesarrollo().'</option>'; 
      }
    } else {
          $arrayReturn['programasPlanDesarrollo'] .='<option value="'.$programasPlanDesarrolloInstitucional[1].'">'.$programasPlanDesarrolloInstitucional[0].'</option>'; 
    }
    
    if(!empty($arrayReturn)){
        echo json_encode( array('success' => true, 'values' => $arrayReturn) );
    } else {
        echo json_encode( array('success' => false) );
}
?>
