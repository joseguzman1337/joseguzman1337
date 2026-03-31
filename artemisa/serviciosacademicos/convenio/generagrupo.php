<?php
//header( 'Content-type: text/html; charset=ISO-8859-1' );

require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');
require_once '../class/ManagerEntity.php';

$sql = "select nombregrupo,idgrupo,nombremateria  from grupo g inner join materia m on g.codigomateria = m.codigomateria
where g.codigoperiodo = '".$_REQUEST['codigoperiodo']."' and codigocarrera = ".$_REQUEST['id'].";";
//echo $sql;
$rs= $db->Execute($sql);
        
while (!$rs->EOF) {
    echo '<option value="'.$rs->fields['idgrupo'].'">'.$rs->fields['nombregrupo']."-".$rs->fields['nombremateria'].'</option>';
    $rs->MoveNext();
}


//echo $cnd.'<br>';
// for($i=0;$i<=$cnd;$i++){
//     $cod= $data2[$i]['idgrupo'];
//     $nom= $data2[$i]['nombregrupo'];
//     echo '<option value="'.$cod.'">'.$nom.'</option>';
//}

?>

