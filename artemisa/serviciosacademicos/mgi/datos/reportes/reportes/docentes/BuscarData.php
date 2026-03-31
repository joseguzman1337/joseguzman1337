<?php

require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

$SQL = 'SELECT 
        du.idCategory,
        t.nombre,
        SUM(du.numHoras) AS numHoras,
        SUM(du.numAcademicosTCE) AS numAcademicosTCE
        
        FROM 
        
        siq_formUnidadesAcademicasActividadesAcademicos  u INNER JOIN siq_detalleformUnidadesAcademicasActividadesAcademicos du ON u.idsiq_formUnidadesAcademicasActividadesAcademicos=du.idData
						                                   INNER JOIN siq_tipoActividadAcademicos t ON du.idCategory=t.idsiq_tipoActividadAcademicos
        
        
        WHERE codigoperiodo = "'.$_REQUEST['periodo'].'" AND u.codigoestado=100 AND du.codigoestado=100
        
        GROUP BY du.idCategory';
        
        
        if($DataResult=&$db->Execute($SQL)===false){
            echo 'Error en el SQl Respuesta...<br><br>'.$SQL;
            die;
        }
        
        if($DataResult->EOF){
                    
            $Data['val'] = false;
            //$Data['Data'] = $DataResult->GetArray();
        }else{
                    
            $Data['val'] = true;
            $Data['Data'] = $DataResult->GetArray();    
        }
        
    
    echo json_encode($Data);
    exit;

?>