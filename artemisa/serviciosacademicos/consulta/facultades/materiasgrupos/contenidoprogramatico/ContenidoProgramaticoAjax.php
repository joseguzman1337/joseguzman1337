<?PHP 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 session_start();
//echo '<pre>';print_r($_SESSION);
if(!isset ($_SESSION['MM_Username'])){
 
//	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi�n en el sistema</strong></blink>';
    $a_vectt['val']			  =false;
    $a_vectt['msj']		      ='Ha ocurrido un problema al Guardar. No se ha iniciado sesion en el sistema';
    echo json_encode($a_vectt);
    exit;
	
}else{
  
 
    require_once('../../../../Connections/sala2.php');
    $rutaado = "../../../../funciones/adodb/";
    require_once('../../../../Connections/salaado.php');
    header('Content-Type: text/HTML; charset=UTF-8');
    
   
    
    if($_REQUEST['PeriodoContenidoProgramatico']){
        $Query_val = "select * from detallecontenidoprogramatico c where idcontenidoprogramatico ='".$_REQUEST['idcontenidoprogramatico']."' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico = 400;";
        $Query_val = $db->Execute ($Query_val) or die("$Query_val".mysql_error());
        $total_Rows_query_val= $Query_val->RecordCount();
        if($total_Rows_query_val > 0){
            $Query_val = "select * from detallecontenidoprogramatico c where idcontenidoprogramatico ='".$_REQUEST['idcontenidoprogramatico']."' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico = 100;";
            $Query_val = $db->Execute ($Query_val) or die("$Query_val".mysql_error());        
            $row_registros = $Query_val->FetchRow();
            $formatGeneral = $row_registros["observaciondetallecontenidoprogramatico"];
        }else{
            $Query = "select * from detallecontenidoprogramatico c where idcontenidoprogramatico ='".$_REQUEST['selectOption']."' and c.codigoestado like '1%' and c.codigotipodetallecontenidoprogramatico <> 400;";
            $Query = $db->Execute ($Query) or die("$Query".mysql_error());
            $total_Rows_query= $Query->RecordCount();
            while ($row_registros = $Query->FetchRow()) {
                if($row_registros["codigotipodetallecontenidoprogramatico"] == 100){
                    $title = "1.Justificación";
                }
                if($row_registros["codigotipodetallecontenidoprogramatico"] == 200){
                    $title = "2.Contenidos Generales";
                }
                if($row_registros["codigotipodetallecontenidoprogramatico"] == 300){
                    $title = "3.Objetivos de Aprendizaje";
                }
                $formatGeneral .= '<p><strong>'.$title.'<br /><br /></strong></p>';
                $formatGeneral .= '<table style="width: 100%;" border="1" cellspacing="0">';
                $formatGeneral .= '<tbody><tr><td><p>&nbsp;</p><p>'.$row_registros["observaciondetallecontenidoprogramatico"].'</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td></tr></tbody>';
                $formatGeneral .= '</table>';
            }
        }
        echo $formatGeneral;
    }
    if($_REQUEST['guardar_data']){ 
        
        $Query = "update contenidoprogramatico set horastrabajoindependiente = '".$_REQUEST['horastrabajoindependiente']."' where idcontenidoprogramatico ='".$_REQUEST['idcontenidoprogramatico']."' ;";
        $Query = $db->Execute ($Query) or die("$Query".mysql_error());
        $Query = "select * from detallecontenidoprogramatico c where idcontenidoprogramatico ='".$_REQUEST['idcontenidoprogramatico']."' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico = 400;";
        $Query = $db->Execute ($Query) or die("$Query".mysql_error());
        $total_Rows_query= $Query->RecordCount();
        if($total_Rows_query > 0){
            
            $Query = "update detallecontenidoprogramatico c set observaciondetallecontenidoprogramatico = '".mysql_real_escape_string($_REQUEST['observacion400'])."', fechadetallecontenidoprogramatico=now() where idcontenidoprogramatico ='".$_REQUEST['idcontenidoprogramatico']."' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico = 400;";
            $Query = $db->Execute ($Query) or die("$Query".mysql_error());
            $Query = "update detallecontenidoprogramatico c set observaciondetallecontenidoprogramatico = '".mysql_real_escape_string($_REQUEST['observacion100'])."',  fechadetallecontenidoprogramatico=now() where idcontenidoprogramatico ='".$_REQUEST['idcontenidoprogramatico']."' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico = 100;";
            $Query = $db->Execute ($Query) or die("$Query".mysql_error());
           $Query = "update detallecontenidoprogramatico c set observaciondetallecontenidoprogramatico = '".mysql_real_escape_string($_REQUEST['observacion200'])."', fechadetallecontenidoprogramatico=now() where idcontenidoprogramatico ='".$_REQUEST['idcontenidoprogramatico']."' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico = 200;";
            $Query = $db->Execute ($Query) or die("$Query".mysql_error());
        }else{
            $Query = "insert into detallecontenidoprogramatico values (null , '".$_REQUEST['idcontenidoprogramatico']."', 100, '".mysql_real_escape_string($_REQUEST['observacion100'])."',now(),100)";
            $Query = $db->Execute ($Query) or die("$Query".mysql_error());
            $Query = "insert into detallecontenidoprogramatico values (null , '".$_REQUEST['idcontenidoprogramatico']."', 200, '".mysql_real_escape_string($_REQUEST['observacion200'])."',now(),100)";
            $Query = $db->Execute ($Query) or die("$Query".mysql_error());
            $Query = "insert into detallecontenidoprogramatico values (null , '".$_REQUEST['idcontenidoprogramatico']."', 400, '".mysql_real_escape_string($_REQUEST['observacion400'])."',now(),100)";
            $Query = $db->Execute ($Query) or die("$Query".mysql_error());
        }
    }
    
    $a_vectt['val']			  =true;
    $a_vectt['msj']		      ='Informacion Actualizada Satisfactoriamente!';
    echo json_encode($a_vectt);
    exit;
}
?>
