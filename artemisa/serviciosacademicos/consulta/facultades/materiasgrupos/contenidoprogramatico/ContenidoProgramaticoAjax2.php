<?
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');

if($_REQUEST['PeriodoContenidoProgramatico']){
    $Query = "select * from detallecontenidoprogramatico c where idcontenidoprogramatico ='".$_REQUEST['selectOption']."' and c.codigoestado like '1%'";
    $Query = $db->Execute ($Query) or die("$Query".mysql_error());
    $total_Rows_query= $Query->RecordCount();
    $xml .= '<?xml version="1.0" ?>';
            $xml .= "<RecentTutorials>";
     while ($row_registros = $Query->FetchRow()) {       
                $xml .="<Tutorial author=".$row_registros["codigotipodetallecontenidoprogramatico"].">";
                    $xml .= "<observacion>".$row_registros["observaciondetallecontenidoprogramatico"]."</observacion>";
                $xml .= "</Tutorial>";
     }
            $xml .= "</RecentTutorials>";
    echo $xml;
}
?>
