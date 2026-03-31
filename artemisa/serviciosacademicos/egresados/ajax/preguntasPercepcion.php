<?php

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
require_once('../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);

$selectOptions = "<option value=''></option>";

$query_type_label = "select idsiq_Apregunta,titulo from siq_Apregunta where codigoestado=100 and cat_ins='".$_REQUEST["cat_ins"]."' 
			and idsiq_Atipopregunta NOT IN (5,7,8) and idsiq_Apregunta NOT IN (select idPregunta from label WHERE idPregunta IS NOT NULL);";


    $query_type_label = mysql_query($query_type_label, $sala) or die(mysql_error());
    while (($row = mysql_fetch_array($query_type_label, MYSQL_ASSOC)) != NULL) {
                $selectOptions .="<option value='".$row['idsiq_Apregunta']."' id='type".$row['idsiq_Apregunta']."'";
                //$selectOptions .= ($row['idlabel_type'] == $label['idlabel_type'])? " SELECTED ":"";
                $selectOptions .= ">".strip_tags($row['titulo'])."</option>";
	}
	
echo $selectOptions;